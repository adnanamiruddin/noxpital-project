<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return view('dashboard.dokter.home');
            } elseif (Auth::user()->role == 'apoteker') {
                return view('dashboard.apoteker.home');
            }
        } else {
            return view('welcome');
        }
    }
}
