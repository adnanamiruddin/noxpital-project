<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $orders = DB::table('orders')
                ->join('medical_records', 'orders.medical_record_id', '=', 'medical_records.id')
                ->join('users', 'medical_records.patient_id', '=', 'users.id')
                ->join('users as doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                ->orderBy('orders.updated_at', 'desc')
                ->select(
                    'orders.*',
                    'users.name as patient_name',
                    'users.email as patient_email',
                    'doctors.name as doctor_name',
                    'orders.created_at as order_created_at'
                )
                ->get();
            return view('dashboard.apoteker.orders', compact('orders'));
        }
        abort(401);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $orders = DB::table('orders')
                ->join('medical_records', 'orders.medical_record_id', '=', 'medical_records.id')
                ->join('users', 'medical_records.patient_id', '=', 'users.id')
                ->join('users as doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                ->where('orders.queue_number', '=', $id)
                ->orderBy('orders.updated_at', 'desc')
                ->select(
                    'orders.*',
                    'users.name as patient_name',
                    'users.email as patient_email',
                    'doctors.name as doctor_name',
                    'orders.created_at as order_created_at'
                )
                ->first();

            if ($orders) {
                $medicines = DB::table('orders')
                    ->join('medical_records', 'orders.medical_record_id', '=', 'medical_records.id')
                    ->join(
                        'medical_records_medicines',
                        'medical_records.id',
                        '=',
                        'medical_records_medicines.medical_record_id'
                    )
                    ->join('medicines', 'medical_records_medicines.medicine_id', '=', 'medicines.id')
                    ->where('orders.queue_number', '=', $id)
                    ->select(
                        'medicines.*',
                        'medical_records_medicines.amount as amount'
                    )
                    ->get();

                return view('dashboard.apoteker.detail-order', compact('orders', 'medicines'));
            } else {
                abort(404);
            }
        }
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
        if (Auth::check() && Auth::user()->role == 'apoteker') {
            $order = Order::find($id);
            if ($order->is_done == 1) {
                return redirect()->back()->with('error', "Order telah selesai dikonfirmasi");
            }

            for ($i = 0; $i < count($request->medicines_id); $i++) {
                $medicine = Medicine::where('id', $request->medicines_id[$i])->first();

                if ($medicine->stock < $request->medicines_amount[$i]) {
                    return redirect()->back()->with('error', "Stok obat $medicine->name tidak mencukupi");
                }

                $medicine->update([
                    'stock' => $medicine->stock - $request->medicines_amount[$i]
                ]);
            }

            $order->update([
                'is_done' => true
            ]);
            return redirect()->to('orders')->with('success', 'Status order berhasil diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
