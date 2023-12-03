<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $users = User::where('role', '!=', 'admin')->get();
                return view('dashboard.admin.user-list', compact('users'));
            } else if (Auth::user()->role == 'dokter') {
                $users = DB::table('users')
                    ->join('medical_records', 'users.id', '=', 'medical_records.patient_id')
                    ->join('users as doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                    ->where('users.role', '=', 'pasien')
                    ->select(
                        'users.*',
                        'doctors.name as doctor_name',
                        'medical_records.id as medical_record_id',
                        'medical_records.action as action',
                        'medical_records.created_at as medical_record_created_at'
                    )
                    ->orderBy('medical_records.updated_at', 'desc')
                    ->get();

                if ($request->search_keywords) {
                    $searchKeywords = $request->search_keywords;
                    $users = DB::table('users')
                        ->join('medical_records', 'users.id', '=', 'medical_records.patient_id')
                        ->join('users as doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                        ->where('users.role', '=', 'pasien')
                        ->where('users.name', 'like', "%$searchKeywords%")
                        ->orWhere('users.email', 'like', "%$searchKeywords%")
                        ->orWhere('users.specialist', 'like', "%$searchKeywords%")
                        ->orWhere('users.room_number', 'like', "%$searchKeywords%")
                        ->orWhere('doctors.name', 'like', "%$searchKeywords%")
                        ->orWhere('medical_records.action', 'like', "%$searchKeywords%")
                        ->select(
                            'users.*',
                            'doctors.name as doctor_name',
                            'medical_records.id as medical_record_id',
                            'medical_records.action as action',
                            'medical_records.created_at as medical_record_created_at'
                        )
                        ->orderBy('medical_records.updated_at', 'desc')
                        ->get();
                }

                return view('dashboard.dokter.patient-list', compact('users'));
            }
        }
        abort(401);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return view('dashboard.admin.create-user');
        }
        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|min:8|same:password',
            ], [
                'name.required' => 'Nama harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'role.required' => 'Role harus diisi',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password_confirmation.required' => 'Konfirmasi password harus diisi',
                'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter',
                'password_confirmation.same' => 'Konfirmasi password tidak sama',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->to('user-list')->with('success', 'User berhasil ditambahkan');
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
        $selectedUser = User::where('id', $id)->get();
        return view('dashboard.admin.edit-user', compact('selectedUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $request->validate([
                    'name' => 'required',
                    'email' => "required|email|unique:users,email,$id",
                    'role' => 'required',
                ], [
                    'name.required' => 'Nama harus diisi',
                    'email.required' => 'Email harus diisi',
                    'email.email' => 'Email tidak valid',
                    'email.unique' => 'Email sudah terdaftar',
                    'role.required' => 'Role harus diisi',
                ]);

                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $request->role,
                ];

                if ($request->password) {
                    $data['password'] = bcrypt($request->password);
                }

                User::find($id)->update($data);
                return redirect()->to('user-list')->with('success', 'Data berhasil diubah');
            } else if (Auth::user()->role == 'dokter') {
                if ($request->is_on_duty == true && $request->room_number == null) {
                    return redirect()->back()->with('error', 'Nomor ruangan harus diisi jika sedang bekerja');
                }

                if ($request->is_on_duty == false && $request->room_number != null) {
                    return redirect()->back()->with(
                        'error',
                        'Gagal memperbarui data. Jangan mengisi nomor ruangan jika sedang tidak bekerja'
                    );
                }

                $roomNumber = $request->is_on_duty == true ? $request->room_number : null;
                User::find($id)->update([
                    'is_on_duty' => $request->is_on_duty,
                    'room_number' => $roomNumber,
                ]);
                return redirect()->back()->with('success', 'Status sedang bekerja dan nomor ruangan berhasil diperbarui');
            }
        }
        abort(401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            User::where('id', $id)->delete();
            return redirect()->to('user-list')->with('success', "Data User dengan Id $id berhasil dihapus");
        }
    }
}
