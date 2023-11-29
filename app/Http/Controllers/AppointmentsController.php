<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $appointments = DB::table('appointments')
                    ->join('users', 'appointments.patient_id', '=', 'users.id')
                    ->join('users as doctors', 'appointments.doctor_id', '=', 'doctors.id')
                    ->orderBy('appointments.updated_at', 'desc')
                    ->select('appointments.*', 'users.name as patient_name', 'users.email as patient_email', 'doctors.name as doctor_name')
                    ->get();
                return view('dashboard.admin.appointments', compact('appointments'));
            } else if (Auth::user()->role == 'dokter') {
                $appointments = DB::table('appointments')
                    ->join('users', 'appointments.patient_id', '=', 'users.id')
                    ->where('appointments.doctor_id', Auth::user()->id)
                    ->orderBy('appointments.updated_at', 'desc')
                    ->select('appointments.*', 'users.name as patient_name', 'users.email as patient_email')
                    ->get();
                return view('dashboard.dokter.appointments', compact('appointments'));
            }
            abort(401);
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return view('dashboard.admin.create-appointment');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                if ($request->form_name == 'create-appointment') {
                    $patient = User::where('role', 'pasien')->where('email', $request->patient_email)->first();
                    if (!$patient) {
                        return redirect()->back()->with('error', 'Email pasien tidak ditemukan!');
                    }

                    $doctor = User::where('role', 'dokter')->where('email', $request->doctor_email)->first();
                    if (!$doctor) {
                        return redirect()->back()->with('error', 'Email dokter tidak ditemukan!');
                    }
                    if ($doctor->is_on_duty == false) {
                        return redirect()->back()->with('error', 'Dokter tidak sedang bertugas!');
                    }

                    Appointment::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'status' => 'menunggu',
                    ]);
                    return redirect()->back()->with('success', 'Janji temu berhasil dibuat!');
                }
            } else if (Auth::user()->role == 'dokter') {
                if ($request->form_name == 'accept-appointment') {
                    $appointment = Appointment::find($request->appointment_id);
                    if ($appointment->status != 'menunggu') {
                        return redirect()->back()->with('error', "Janji temu tidak sedang dalam status 'Menunggu'!");
                    }
                    $appointment->update([
                        'status' => 'sedang konsultasi',
                    ]);
                    return redirect()->back()->with('success', 'Berhasil menyetujui janji temu!');
                } else if ($request->form_name == 'reject-appointment') {
                    $appointment = Appointment::find($request->appointment_id);
                    if ($appointment->status != 'menunggu') {
                        return redirect()->back()->with('error', "Janji temu tidak sedang dalam status 'Menunggu'!");
                    }
                    $appointment->update([
                        'status' => 'ditolak',
                    ]);
                    return redirect()->back()->with('success', 'Berhasil menolak janji temu!');
                } else {
                    abort(400);
                }
            } else {
                abort(401);
            }
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