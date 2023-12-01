<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordMedicine;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicalRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'dokter') {
                $patients = DB::table('users')
                    ->join('medical_records', 'users.id', '=', 'medical_records.patient_id')
                    ->join('users as doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                    ->where('users.role', '=', 'pasien')
                    ->select(
                        'users.*',
                        'medical_records.*',
                        'doctors.name as doctor_name',
                        'medical_records.created_at as medical_record_created_at'
                    )
                    ->orderBy('medical_records.updated_at', 'desc')
                    ->get();
                return view('dashboard.dokter.medical-records', compact('patients'));
            } else if (Auth::user()->role == 'pasien') {
                $medicalRecords = DB::table('medical_records')
                    ->join('users', 'medical_records.doctor_id', '=', 'users.id')
                    ->where('medical_records.patient_id', '=', Auth::user()->id)
                    ->select('medical_records.*', 'users.name as doctor_name')
                    ->orderBy('medical_records.updated_at', 'desc')
                    ->get();
                return view('dashboard.pasien.medical-records', compact('medicalRecords'));
            }
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->role == 'dokter') {
            $medicines = Medicine::pluck('name');
            return view('dashboard.dokter.create-medical-record', compact('medicines'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'dokter') {
            $request->validate([
                'email_patient' => 'required|email|exists:users,email',
                'action' => 'required',
            ], [
                'email_patient.required' => 'Email pasien harus diisi',
                'email_patient.email' => 'Email pasien harus berupa email',
                'email_patient.exists' => 'Email pasien tidak ditemukan',
                'action.required' => 'Tindakan harus diisi',
            ]);

            try {
                $dataPatient = User::where('email', $request->email_patient)->where('role', 'pasien')->firstOrFail();
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Email pasien tidak ditemukan!');
            }

            $data = [
                'patient_id' => $dataPatient->id,
                'doctor_id' => Auth::user()->id,
                'action' => $request->action,
            ];
            $data['created_at'] = $request->filled('created_at') ? $request->created_at : now();
            $insertData = MedicalRecord::create($data);

            $totalPrice = 0;
            if ($request->medicines) {
                foreach ($request->medicines as $item) {
                    try {
                        $medicine = Medicine::where('name', $item['name'])->firstOrFail();

                        if ($medicine->stock < $item['amount']) {
                            MedicalRecord::where('id', $insertData->id)->delete();
                            return redirect()->to('medical-records/create')->with('error', 'Stok obat tidak mencukupi');
                        }

                        $dataMedicine = [
                            'medical_record_id' => $insertData->id,
                            'medicine_id' => $medicine->id,
                            'amount' => $item['amount'],
                        ];
                        $totalPrice += $medicine->price * $item['amount'];
                        MedicalRecordMedicine::create($dataMedicine);
                    } catch (\Throwable $th) {
                        MedicalRecord::where('id', $insertData->id)->delete();
                        return redirect()->to('medical-records/create')->with('error', 'Obat tidak ditemukan');
                    }
                }
            }

            try {
                $newestAppointmentData = DB::table('appointments')
                    ->join('users', 'appointments.patient_id', '=', 'users.id')
                    ->where('users.role', 'pasien')
                    ->where('doctor_id', Auth::user()->id)
                    ->where('status', 'sedang konsultasi')
                    ->select('appointments.id as appointment_id', 'users.email as patient_email')
                    ->orderBy('appointments.updated_at', 'desc')
                    ->limit(1)
                    ->first();

                if ($newestAppointmentData->patient_email == $request->email_patient) {
                    $appointment = Appointment::find($newestAppointmentData->appointment_id);
                    $appointment->update([
                        'status' => 'selesai',
                        'queue_number' => $this->generate_queue_number(),
                        'medical_record_id' => $insertData->id,
                    ]);
                    Order::create([
                        'medical_record_id' => $insertData->id,
                        'queue_number' => $appointment->queue_number,
                        'total_price' => $totalPrice,
                    ]);
                } else {
                    throw new Error();
                }
            } catch (\Throwable $th) {
                MedicalRecord::where('id', $insertData->id)->delete();
                return redirect()->back()->with(
                    'error',
                    'Terjadi kesalahan pada sistem. Mohon input email pasien sesuai dengan email pasien pada janji temu yang terakhir disetujui oleh dokter'
                );
            }

            return redirect()->to('medical-records')->with('success', 'Berhasil menambahkan data rekam medis');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'pasien') {
            $medicalRecord = DB::table('medical_records')
                ->join('users', 'medical_records.doctor_id', '=', 'users.id')
                ->where('medical_records.patient_id', '=', Auth::user()->id)
                ->where('medical_records.id', '=', $id)
                ->select('medical_records.*', 'users.name as doctor_name')
                ->first();

            if ($medicalRecord) {
                $medicines = DB::table('medical_records')
                    ->join(
                        'medical_records_medicines',
                        'medical_records.id',
                        '=',
                        'medical_records_medicines.medical_record_id'
                    )
                    ->join('medicines', 'medical_records_medicines.medicine_id', '=', 'medicines.id')
                    ->where('medical_records.id', '=', $id)
                    ->select(
                        'medicines.*',
                        'medical_records_medicines.amount as amount'
                    )
                    ->get();

                return view('dashboard.pasien.detail-medical-record', compact('medicalRecord', 'medicines'));
            }
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'dokter') {
            $medicalRecord = DB::table('medical_records')
                ->join('users', 'medical_records.patient_id', '=', 'users.id')
                ->where('medical_records.doctor_id', '=', Auth::user()->id)
                ->where('medical_records.id', '=', $id)
                ->select('medical_records.*', 'users.email as patient_email')
                ->first();

            if ($medicalRecord) {
                $medicines = DB::table('medical_records')
                    ->join(
                        'medical_records_medicines',
                        'medical_records.id',
                        '=',
                        'medical_records_medicines.medical_record_id'
                    )
                    ->join('medicines', 'medical_records_medicines.medicine_id', '=', 'medicines.id')
                    ->where('medical_records.id', '=', $id)
                    ->select(
                        'medicines.*',
                        'medical_records_medicines.amount as amount'
                    )
                    ->get();
                return view('dashboard.dokter.edit-medical-record', compact('medicalRecord', 'medicines'));
            }
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::check() && Auth::user()->role == 'dokter') {
            $request->validate([
                'action' => 'required',
            ], [
                'action.required' => 'Tindakan harus diisi',
            ]);

            MedicalRecord::find($id)->update([
                'action' => $request->action,
            ]);
            return redirect()->to('medical-records')->with('success', 'Berhasil mengubah data rekam medis');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generate_queue_number()
    {
        $date = now()->format('Ymd');

        $lastQueueNumber = DB::table('appointments')
            ->where('queue_number', 'like', $date . '%')
            ->orderBy('queue_number', 'desc')
            ->value('queue_number');

        $counter = 1;
        if ($lastQueueNumber) {
            $lastCounter = (int)substr($lastQueueNumber, -4);
            $counter = $lastCounter + 1;
        }

        $newQueueNumber = $date . sprintf('%04d', $counter);
        return $newQueueNumber;
    }
}
