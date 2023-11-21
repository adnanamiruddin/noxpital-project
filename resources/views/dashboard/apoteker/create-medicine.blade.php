@extends('dashboard.template')

@section('header')
    Tambah Obat
@endsection

@section('content')
    <form method="POST" action="{{ route('medicines') }}">
        @csrf
        <div class="mb-6 flex justify-between items-center gap-3">
            <div class="w-9/12">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Obat</label>
                <input type="text" id="name" name="name"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Paracetamol..." required>
            </div>

            <div class="w-3/12">
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Tipe Obat
                </label>
                <select id="type" name="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="biasa" selected>Biasa</option>
                    <option value="keras">Keras</option>
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
                    placeholder="10000..." required>
            </div>

            <div class="w-3/12">
                <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok Obat</label>
                <input type="number" id="stock" name="stock"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="20..." required>
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Deskripsi Obat
            </label>
            <textarea id="description" name="description" rows="5"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Parasetamol merupakan obat..."></textarea>
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Tambah Obat
        </button>
    </form>
@endsection
