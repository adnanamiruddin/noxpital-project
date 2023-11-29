@extends('dashboard.template')

@section('header')
    Daftar Janjian Saya
@endsection

@section('content')
    <div class="mb-8">
        <a href="{{ route('medical-records.create') }}"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
            Tambah Rekam Medis
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Id Janjian
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Pasien
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email Pasien
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nomor Antrian
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($appointments as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:brightness-95">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $item->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->patient_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->patient_email }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->status == 'selesai')
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-800 bg-green-300 rounded dark:bg-green-700 dark:text-green-100">
                                    {{ ucwords($item->status) }}
                                </span>
                            @endif

                            @if ($item->status == 'sedang konsultasi')
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-blue-800 bg-blue-300 rounded dark:bg-blue-700 dark:text-blue-100">
                                    {{ ucwords($item->status) }}
                                </span>
                            @endif

                            @if ($item->status == 'menunggu')
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-yellow-800 bg-yellow-300 rounded dark:bg-yellow-700 dark:text-yellow-100">
                                    {{ ucwords($item->status) }}
                                </span>
                            @endif

                            @if ($item->status == 'ditolak')
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-red-800 bg-red-300 rounded dark:bg-red-700 dark:text-red-100">
                                    {{ ucwords($item->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->queue_number }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            <form method="POST" action="{{ route('doctor-appointments') }}">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="focus:outline-none text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                    name="form_name" value="accept-appointment">
                                    Terima
                                </button>
                            </form>
                            <form method="POST" action="{{ route('doctor-appointments') }}">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                    name="form_name" value="reject-appointment">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
