@extends('dashboard.template')

@section('header')
    Detail Rekam Medis Saya
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center gap-3">
        <div class="w-6/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Dilayani Oleh Dokter
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $medicalRecord->doctor_name }}">
        </div>

        <div class="w-3/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                ID Rekam Medis
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $medicalRecord->id }}">
        </div>

        <div class="w-3/12">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Tanggal Rekam Medis
            </label>
            <input
                class="brightness-95 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:shadow-sm-light"
                disabled value="{{ $medicalRecord->created_at }}">
        </div>
    </div>

    <div class="mb-6">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Tindakan / Aksi
        </label>
        <textarea rows="5"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            disabled>{{ $medicalRecord->action }}</textarea>
    </div>

    <h3 class="text-center text-4xl font-black mt-8 mb-6">Daftar Obat yang Digunakan</h3>

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
                        Deskripsi Obat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipe Obat
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($medicines as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:brightness-95">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $item->id }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4 text-justify">
                            {{-- {{ substr($item->description, 0, 100) }}... --}}
                            {{ $item->description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucwords($item->type) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
