<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Noxpital</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Ion Icons --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased bg-white font-sans text-gray-900" style="scroll-behavior: smooth">
    @include('components.homepage-header')

    @include('components.homepage-hero')

    @include('components.homepage-about')

    @include('components.homepage-vision')

    @include('components.homepage-blog')

    @include('components.homepage-contact')

    @include('components.homepage-footer')

    <button id="back-to-top" class="fixed bottom-4 right-4 bg-blue-700 text-white px-4 py-2 rounded-full hidden">
        <ion-icon name="arrow-up-sharp" class="text-lg mt-1"></ion-icon>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('back-to-top');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    backToTopButton.style.display = 'block';
                } else {
                    backToTopButton.style.display = 'none';
                }
            });

            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>


</body>

</html>
