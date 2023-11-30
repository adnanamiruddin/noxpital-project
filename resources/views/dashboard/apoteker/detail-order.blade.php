@extends('dashboard.template')

@section('header')
    Detail Rekam Medis Saya
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center gap-3">
        <div class="w-6/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Nama Pasien
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $orders->patient_name }}">
        </div>

        <div class="w-6/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Email Pasien
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $orders->patient_email }}">
        </div>
    </div>

    <div class="mb-6 flex justify-between items-center gap-3">
        <div class="w-6/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Dilayani Oleh Dokter
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $orders->doctor_name }}">
        </div>

        <div class="w-3/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Nomor Antrian
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $orders->queue_number }}">
        </div>

        <div class="w-3/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Tanggal Memesan
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $orders->order_created_at }}">
        </div>
    </div>

    <div class="mb-6 flex justify-between items-center gap-3">
        <div class="w-6/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Status Pesanan
            </label>
            @if ($orders->is_done == false)
                <input
                    class="brightness-95 shadow-sm bg-yellow-200 border border-yellow-300 text-yellow-900 text-sm rounded-lg block w-full p-2.5 dark:bg-yellow-400 dark:border-yellow-500 dark:placeholder-yellow-400 dark:text-yellow-900 dark:shadow-sm-light"
                    disabled value="Belum Selesai">
            @endif
            @if ($orders->is_done == true)
                <input
                    class="brightness-95 shadow-sm bg-green-200 border border-green-300 text-green-900 text-sm rounded-lg block w-full p-2.5 dark:bg-green-400 dark:border-green-500 dark:placeholder-green-400 dark:text-green-900 dark:shadow-sm-light"
                    disabled value="Selesai">
            @endif
        </div>

        <div class="w-6/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Total Harga
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="Rp. {{ number_format($orders->total_price, 0, ',', '.') }}">
        </div>
    </div>

    <h3 class="text-center text-4xl font-black mt-9 mb-6">Daftar Obat yang Dipesan</h3>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Id Obat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Obat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipe Obat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah Obat
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($medicines as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:brightness-95">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucwords($item->type) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->amount }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ url("orders/$orders->id") }}" class="flex justify-center">
        @csrf
        @method('PUT')
        <button type="submit"
            class="mt-6 mb-4 text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
            Konfirmasi Pembayaran
        </button>
    </form>
@endsection
