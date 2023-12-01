@extends('dashboard.template')

@section('header')
    Daftar Obat
@endsection

@section('content')
    <div class="mb-8">
        <a href="{{ route('medicines.create') }}"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
            Tambah Obat
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
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Stok
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Harga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipe
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Diinput Oleh
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Terakhir Diubah
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Gambar Obat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
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
                        <td class="px-6 py-4">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->stock }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->price }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucwords($item->type) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->apoteker_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->medicines_updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->image == null)
                                <img src="{{ asset('storage/medicine_images/default_medicine_image.png') }}"
                                    alt="{{ $item->name }}" class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="w-20 h-20 object-cover rounded-lg">
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            @if (Auth::user()->id == $item->pharmacist_id)
                                <a href="/medicines/{{ $item->id }}/edit"
                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:focus:ring-yellow-900">
                                    Kelola
                                </a>
                            @else
                                <button
                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:focus:ring-yellow-900 brightness-75"
                                    disabled>
                                    Kelola
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
