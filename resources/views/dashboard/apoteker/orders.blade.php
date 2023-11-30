@extends('dashboard.template')

@section('header')
    Daftar Pesanan
@endsection

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nomor Antrian
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Pasien
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email Pasien
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dilayani Oleh
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Harga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Memesan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($orders as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:brightness-95">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $item->queue_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->patient_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->patient_email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->doctor_name }}
                        </td>
                        <td class="px-6 py-4">
                            Rp. {{ number_format($item->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->order_created_at }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->is_done == false)
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-orange-500 bg-orange-200 rounded dark:bg-orange-700 dark:text-orange-100">
                                    Belum Dibayar
                                </span>
                            @endif
                            @if ($item->is_done == true)
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-800 bg-green-300 rounded dark:bg-green-700 dark:text-green-100">
                                    Sudah Dibayar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            <a href="/orders/{{ $item->queue_number }}"
                                class="focus:outline-none text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:focus:ring-blue-900">
                                Selengkapnya
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
