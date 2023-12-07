<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Ion Icons --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        #menu-toggle:checked+#menu {
            display: block;
        }

        #dropdown-toggle:checked+#dropdown {
            display: block;
        }
    </style>
</head>

<body class="antialiased bg-white font-sans text-gray-900">
    @include('components.auth-header')

    <section
        class="px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 overflow-hidden flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-400 to-teal-400">
        <div class="h-full absolute left-0 right-0 z-0">
            <img src="{{ asset('storage/assets/bg-hero.jpeg') }}" alt="Rumah Sakit Unhas"
                class="w-full h-full object-cover opacity-25" />
        </div>

        <div
            class="z-10 w-full sm:max-w-md mt-12 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center">
                <img src="{{ asset('storage/assets/icon-noxpital.jpeg') }}" alt="Icon NoxPital"
                    class="w-20 h-20 object-cover" />
            </div>
            <h2 class="text-center text-3xl font-black my-4">@yield('title')</h2>

            @yield('form')
        </div>
    </section>
</body>

</html>
