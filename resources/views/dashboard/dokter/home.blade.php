@extends('dashboard.template')

@section('header')
    Beranda
@endsection

@section('content')
    <h1 class="mb-8 font-bold text-2xl">Daftar 5 Pasien Terbaru yang Telah Diperiksa</h1>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Id Rekam Medis
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tindakan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dilayani Pada Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($patients as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:brightness-95">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $item->medical_record_id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ substr($item->action, 0, 100) }}...
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->medical_record_created_at }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            <a href="/medical-records/{{ $item->medical_record_id }}"
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
