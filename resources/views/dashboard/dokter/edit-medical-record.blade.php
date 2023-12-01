@extends('dashboard.template')

@section('header')
    Kelola Rekam Medis
@endsection

@section('content')
    <form method="POST" action="{{ url("medical-records/$medicalRecord->id") }}">
        @csrf
        @method('PUT')
        <div class="mb-6 flex justify-between items-center gap-3">
            <div class="w-9/12">
                <label for="email_patient" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Email Pasien
                </label>
                <input type="email"
                    class="shadow-sm bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="pasien@gmail.com ..." value="{{ $medicalRecord->patient_email }}" disabled>
            </div>

            <div class="w-3/12">
                <label for="created_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                <input type="date"
                    class="shadow-sm bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    value="{{ \Carbon\Carbon::parse($medicalRecord->updated_at)->format('Y-m-d') }}" disabled>
            </div>
        </div>

        <div class="mb-6">
            <label for="action" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Tindakan / Aksi
            </label>
            <textarea id="action" name="action" rows="5"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Parasetamol merupakan obat...">{{ $medicalRecord->action }}</textarea>
        </div>

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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                {{ $no++ }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->name }}
                            </td>
                            <td class="px-6 py-4 text-justify">
                                {{ $item->description }}
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

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Perbarui
        </button>
    </form>
@endsection
