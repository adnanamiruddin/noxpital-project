<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $onDutyDoctors = User::where('role', 'dokter')->where('is_on_duty', true)->get();
                return view('dashboard.admin.home', compact('onDutyDoctors'));
            } elseif (Auth::user()->role == 'pasien') {
                $medicalRecord = DB::table('medical_records')
                    ->join('users', 'medical_records.doctor_id', '=', 'users.id')
                    ->where('medical_records.patient_id', '=', Auth::user()->id)
                    ->select('medical_records.*', 'users.name as doctor_name')
                    ->orderBy('medical_records.updated_at', 'desc')
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
                        ->where('medical_records.id', '=', $medicalRecord->id)
                        ->select(
                            'medicines.*',
                            'medical_records_medicines.amount as amount'
                        )
                        ->get();
                    return view('dashboard.pasien.home', compact('medicalRecord', 'medicines'));
                }
                return view('dashboard.pasien.new-home');
            } elseif (Auth::user()->role == 'dokter') {
                $myData = User::find(Auth::user()->id);

                $patients = DB::table('users')
                    ->join('medical_records', 'users.id', '=', 'medical_records.patient_id')
                    ->where('users.role', '=', 'pasien')
                    ->where('medical_records.doctor_id', '=', Auth::user()->id)
                    ->select(
                        'users.*',
                        'medical_records.id as medical_record_id',
                        'medical_records.action as action',
                        'medical_records.created_at as medical_record_created_at'
                    )
                    ->orderBy('medical_records.updated_at', 'desc')
                    ->limit(5)
                    ->get();
                return view('dashboard.dokter.home', compact('myData', 'patients'));
            } elseif (Auth::user()->role == 'apoteker') {
                $medicines = DB::table('medical_records')
                    ->join('medical_records_medicines', 'medical_records.id', '=', 'medical_records_medicines.medical_record_id')
                    ->join('medicines', 'medical_records_medicines.medicine_id', '=', 'medicines.id')
                    ->join('users', 'medicines.pharmacist_id', '=', 'users.id')
                    ->select(
                        'medicines.*',
                        'users.name as apoteker_name',
                        DB::raw('COUNT(medical_records_medicines.medicine_id) as total')
                    )
                    ->groupBy(
                        'medicines.id',
                        'medicines.name',
                        'medicines.description',
                        'medicines.image',
                        'medicines.price',
                        'medicines.stock',
                        'medicines.type',
                        'medicines.pharmacist_id',
                        'medicines.created_at',
                        'medicines.updated_at',
                        'users.name'
                    )
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get();

                return view('dashboard.apoteker.home', compact('medicines'));
            }
        } else {
            return view('welcome');
        }
    }
}
