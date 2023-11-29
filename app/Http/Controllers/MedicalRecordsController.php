<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordMedicine;
use App\Models\Medicine;
use App\Models\User;
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
        if (Auth::check() && Auth::user()->role == 'dokter') {
            $patients = DB::table('users')
                ->join('medical_records', 'users.id', '=', 'medical_records.patient_id')
                ->join('users as doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                ->select('users.*', 'medical_records.*', 'doctors.name as doctor_name')
                ->where('users.role', '=', 'pasien')
                ->get();
            return view('dashboard.dokter.medical-records', compact('patients'));
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

            try {
                $appointmentId = DB::table('appointments')
                    ->join('users', 'appointments.patient_id', '=', 'users.id')
                    ->where('users.role', 'pasien')
                    ->where('doctor_id', Auth::user()->id)
                    ->where('patient_id', $dataPatient->id)
                    ->where('users.email', $request->email_patient)
                    ->where('status', 'sedang konsultasi')
                    ->select('appointments.id')
                    ->orderBy('appointments.updated_at', 'desc')
                    ->limit(1)
                    ->first();
                Appointment::find($appointmentId->id)->update([
                    'status' => 'selesai',
                    'queue_number' => $this->generate_queue_number(),
                    'medical_record_id' => $insertData->id,
                ]);
            } catch (\Throwable $th) {
                MedicalRecord::where('id', $insertData->id)->delete();
                return redirect()->back()->with(
                    'error',
                    'Terjadi kesalahan pada sistem. Mohon input email pasien sesuai dengan email pasien pada janji temu yang terakhir disetujui oleh dokter'
                );
            }

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
                        MedicalRecordMedicine::create($dataMedicine);
                    } catch (\Throwable $th) {
                        MedicalRecord::where('id', $insertData->id)->delete();
                        return redirect()->to('medical-records/create')->with('error', 'Obat tidak ditemukan');
                    }
                }
            }

            return redirect()->to('medical-records')->with('success', 'Berhasil menambahkan data rekam medis');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        // Get the current date
        $date = now()->format('Ymd');

        // Get the last queue number for the current date
        $lastQueueNumber = DB::table('appointments')
            ->where('queue_number', 'like', $date . '%')
            ->orderBy('queue_number', 'desc')
            ->value('queue_number');

        // Extract the counter part from the last queue number
        $counter = 1;
        if ($lastQueueNumber) {
            $lastCounter = (int)substr($lastQueueNumber, -4);
            $counter = $lastCounter + 1;
        }

        // Generate the new queue number
        $newQueueNumber = $date . sprintf('%04d', $counter);

        return $newQueueNumber;
    }
}
