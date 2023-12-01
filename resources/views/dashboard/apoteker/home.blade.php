@extends('dashboard.template')

@section('header')
    Beranda
@endsection

@section('content')
    <h1 class="mb-8 font-bold text-2xl">Daftar 5 Obat yang Paling Sering Dibeli</h1>

    <div class="flex flex-row flex-wrap justify-center gap-10">
        @foreach ($medicines as $item)
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @if ($item->image == null)
                    <img src="{{ asset('storage/medicine_images/default_medicine_image.png') }}" alt="{{ $item->name }}"
                        class="rounded-t-lg">
                @else
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="rounded-t-lg">
                @endif
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-wide text-gray-900 dark:text-white leading-normal">
                        {{ $item->name }}
                        <span
                            class="bg-blue-100 text-blue-800 text-base font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{ ucwords($item->type) }}
                        </span>
                    </h5>
                    <p class="mb-4 font-normal text-gray-700 dark:text-gray-400 text-justify">
                        {{ $item->description }}
                    </p>

                    <div class="flex flex-row justify-between pt-4 border-t-2">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                Total Pembelian
                            </span>
                            <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                                {{ $item->total }}
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                Harga
                            </span>
                            <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                Stok
                            </span>
                            <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                                {{ $item->stock }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
