<?php

namespace App\Http\Controllers;

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
                ->join('medical_records', 'users.id', '=', 'medical_records.id_patient')
                ->join('users as doctors', 'medical_records.id_doctor', '=', 'doctors.id')
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
                // 'id_patient' => 'required',
                'email_patient' => 'required|email|exists:users,email',
                'action' => 'required',
            ], [
                // 'id_patient.required' => 'Nama pasien harus diisi',
                'email_patient.required' => 'Email pasien harus diisi',
                'email_patient.email' => 'Email pasien harus berupa email',
                'email_patient.exists' => 'Email pasien tidak ditemukan',
                'action.required' => 'Tindakan harus diisi',
            ]);

            $idPatient = User::where('email', $request->email_patient)->where('role', 'pasien')->firstOrFail();

            $data = [
                'id_patient' => $idPatient->id,
                'id_doctor' => Auth::user()->id,
                'action' => $request->action,
            ];

            $data['created_at'] = $request->filled('created_at') ? $request->created_at : now();

            $insertData = MedicalRecord::create($data);

            if ($request->medicines) {
                foreach ($request->medicines as $item) {
                    // $item->validate([
                    //     'name' => 'required',
                    //     'amount' => 'required|numeric',
                    // ], [
                    //     'name.required' => 'Nama obat harus diisi',
                    //     'amount.required' => 'Jumlah obat harus diisi',
                    //     'amount.numeric' => 'Jumlah obat harus berupa angka',
                    // ]);
                    // $data['name'] = $item->name;
                    // $data['amount'] = $item->amount;

                    try {
                        $medicine = Medicine::where('name', $item['name'])->firstOrFail();

                        if ($medicine->stock < $item['amount']) {
                            MedicalRecord::where('id', $insertData->id)->delete();
                            return redirect()->to('medical-records/create')->with('error', 'Stok obat tidak mencukupi');
                        }

                        $dataMedicine = [
                            'id_medical_record' => $insertData->id,
                            'id_medicine' => $medicine->id,
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
}
