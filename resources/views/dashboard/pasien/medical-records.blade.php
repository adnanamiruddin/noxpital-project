@extends('dashboard.template')

@section('header')
    Rekam Medis Saya
@endsection

@section('search_form')
    @include('components.search-form', ['action' => route('patient-medical-records.search')])
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
                        Id Rekam Medis
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tindakan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Rekam Medis
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dilayani Oleh
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($medicalRecords as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:brightness-95">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            {{ $no++ }}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $item->id }}
                        </td>
                        <td class="px-6 py-4 text-justify">
                            {{ substr($item->action, 0, 100) }}...
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->doctor_name }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            <a href="/patient-medical-records/{{ $item->id }}"
                                class="focus:outline-none text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:focus:ring-blue-900">
                                Selengkapnya
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $medicalRecords->withQueryString()->links() }}
        </div>
    </div>
@endsection
