<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $medicines = DB::table('medicines')
                ->join('users', 'medicines.pharmacist_id', '=', 'users.id')
                ->select('medicines.*', 'users.name as apoteker_name', 'medicines.updated_at as medicines_updated_at')
                ->get();
            return view('dashboard.apoteker.medicines', compact('medicines'));
        }
        abort(401);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            return view('dashboard.apoteker.create-medicine');
        }
        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $request->validate([
                'name' => 'required',
                'type' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'description' => 'required',
                // 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'name.required' => 'Nama obat harus diisi',
                'type.required' => 'Tipe obat harus diisi',
                'price.required' => 'Harga harus diisi',
                'price.numeric' => 'Harga harus berupa angka',
                'stock.required' => 'Stok harus diisi',
                'stock.numeric' => 'Stok harus berupa angka',
                'description.required' => 'Deskripsi harus diisi',
                // 'image.required' => 'Gambar harus diisi',
                // 'image.image' => 'Gambar harus berupa gambar',
                // 'image.mimes' => 'Gambar harus berupa file jpeg, png, jpg',
                // 'image.max' => 'Gambar maksimal 2MB',
            ]);

            Medicine::create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
                'pharmacist_id' => Auth::user()->id,
                // 'image' => $request->image,
            ]);
            return redirect()->to('medicines')->with('success', 'Obat berhasil ditambahkan');
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
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $selectedMedicine = Medicine::where('id', $id)->get();
            foreach ($selectedMedicine as $item) {
                if (Auth::user()->id == $item->pharmacist_id) {
                    return view('dashboard.apoteker.edit-medicine', compact('selectedMedicine'));
                }
                // return redirect()->to('medicines')->with('error', 'Anda tidak memiliki akses ke halaman ini');
                abort(401);
            }
        }
        abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $request->validate([
                'name' => 'required',
                'type' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'description' => 'required',
            ], [
                'name.required' => 'Nama obat harus diisi',
                'type.required' => 'Tipe obat harus diisi',
                'price.required' => 'Harga harus diisi',
                'price.numeric' => 'Harga harus berupa angka',
                'stock.required' => 'Stok harus diisi',
                'stock.numeric' => 'Stok harus berupa angka',
                'description.required' => 'Deskripsi harus diisi',
            ]);

            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
            ];

            Medicine::where('id', $id)->update($data);
            return redirect()->to('medicines')->with('success', 'Data berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            Medicine::where('id', $id)->delete();
            return redirect()->to('medicines')->with('success', "Data obat dengan Id $id berhasil dihapus");
        }
    }
}
