<section
    class="px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 overflow-hidden flex items-center min-h-screen bg-gradient-to-br from-blue-400 to-teal-400">
    <div class="h-full absolute left-0 right-0 z-0">
        <img src="{{ asset('storage/assets/bg-hero.jpeg') }}" alt="Rumah Sakit Unhas"
            class="w-full h-full object-cover opacity-25" />
    </div>

    <div class="lg:w-3/4 xl:w-2/4 relative z-10 h-100 lg:mt-16">
        <div>
            <h1 class="text-white text-4xl md:text-5xl xl:text-6xl font-bold leading-tight">
                RSPTN Universitas Hasanuddin
            </h1>
            <p class="text-blue-100 text-xl md:text-2xl leading-snug mt-4">
                Rumah Sakit Universitas Hasanuddin (RS Unhas) sebagai rumah sakit pendidikan untuk Fakultas Kedokteran
                Universitas Hasanuddin, yang beroperasi sejak tahun 2011.
            </p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-8 py-4 bg-teal-500 text-white rounded inline-block mt-8 font-semibold text-xl">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-8 py-4 bg-teal-500 text-white rounded inline-block mt-8 font-semibold text-xl">
                        Masuk
                    </a>
                @endauth
            @endif
        </div>
    </div>
</section>
