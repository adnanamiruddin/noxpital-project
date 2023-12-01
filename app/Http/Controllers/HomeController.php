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
                return view('dashboard.pasien.home');
            } elseif (Auth::user()->role == 'dokter') {
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
                return view('dashboard.dokter.home', compact('patients'));
            } elseif (Auth::user()->role == 'apoteker') {
                return view('dashboard.apoteker.home');
            }
        } else {
            return view('welcome');
        }
    }
}
