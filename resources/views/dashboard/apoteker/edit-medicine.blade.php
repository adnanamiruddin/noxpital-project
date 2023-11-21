@extends('dashboard.template')

@section('header')
    Kelola Data Obat
@endsection

@section('content')
    @foreach ($selectedMedicine as $item)
        <form method="POST" action="{{ url("/medicines/$item->id") }}" class="mb-6 flex justify-between items-center">
            @csrf
            @method('DELETE')
            <a href="/medicines"
                class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
                << </a>
                    <h3 class="mb-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Data {{ $item->name }}
                    </h3>
                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                        type="button">
                        Hapus
                    </button>

                    <div id="popup-modal" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen max-h-full backdrop-blur-sm backdrop-brightness-75">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button"
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="popup-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        Apakah kamu yakin ingin menghapus data obat ini?
                                    </h3>
                                    <button data-modal-hide="popup-modal" type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Ya, hapus
                                    </button>
                                    <button data-modal-hide="popup-modal" type="button"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                                </div>
                            </div>
                        </div>
                    </div>
        </form>

        <form method="POST" action="{{ url("/medicines/$item->id") }}">
            @csrf
            @method('PUT')
            <div class="mb-6 flex justify-between items-center gap-3">
                <div class="w-9/12">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Obat</label>
                    <input type="text" id="name" name="name"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="Paracetamol..." required value="{{ $item->name }}">
                </div>

                <div class="w-3/12">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tipe Obat
                    </label>
                    <select id="type" name="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="{{ $item->type }}" selected>{{ ucwords($item->type) }}</option>

                        <?php $types = ['keras', 'biasa']; ?>
                        @foreach ($types as $value)
                            @if ($value != $item->type)
                                <option value="{{ $value }}">{{ ucwords($value) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6 flex justify-between items-center gap-3">
                <div class="w-9/12">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Harga Obat
                    </label>
                    <input type="number" id="price" name="price"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="10000..." required value="{{ $item->price }}">
                </div>

                <div class="w-3/12">
                    <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok
                        Obat</label>
                    <input type="number" id="stock" name="stock"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="20..." required value="{{ $item->stock }}">
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Deskripsi Obat
                </label>
                <textarea id="description" name="description" rows="5"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Parasetamol merupakan obat...">{{ $item->description }}</textarea>
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Ubah Data
            </button>
        </form>
    @endforeach
@endsection
