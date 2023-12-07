<header class="absolute top-0 left-0 w-full z-50 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 pt-2">
    <div class="hidden md:flex justify-between items-center border-b text-sm py-3"
        style="border-color: rgba(255, 255, 255, 0.25)">

        <ul class="flex text-white">
            <li>
                <div class="flex items-center">
                    <ion-icon name="location-outline" class="w-6 h-6 fill-current text-white"></ion-icon>
                    <span class="ml-2">RSPTN Universitas Hasanuddin, Makassar, Indonesia</span>
                </div>
            </li>
            <li class="ml-6">
                <div class="flex items-center">
                    <ion-icon name="mail-outline" class="w-6 h-6 fill-current text-white"></ion-icon>
                    <span class="ml-2">amiruddinmap22h@student.unhas.ac.id</span>
                </div>
            </li>
        </ul>

        <ul class="flex justify-end text-white">
            <li>
                <a href="#" target="_blank" rel="noopener">
                    <ion-icon name="logo-instagram" class="w-6 h-6 fill-current text-white"></ion-icon>
                </a>
            </li>

            <li class="ml-6">
                <a href="#" target="_blank" rel="noopener">
                    <ion-icon name="logo-whatsapp" class="w-6 h-6 fill-current text-white"></ion-icon>
                </a>
            </li>

            <li class="ml-6">
                <a href="#" target="_blank" rel="noopener">
                    <ion-icon name="logo-linkedin" class="w-6 h-6 fill-current text-white"></ion-icon>
                </a>
            </li>

            <li class="ml-6">
                <a href="#" target="_blank" rel="noopener">
                    <ion-icon name="logo-web-component" class="w-6 h-6 fill-current text-white"></ion-icon>
                </a>
            </li>
        </ul>
    </div>

    <div class="flex flex-wrap items-center justify-between py-6">
        <a href="{{ url('/') }}" class="w-1/2 flex md:w-auto md:me-24">
            <img src="{{ asset('storage/assets/icon-noxpital.jpeg') }}" alt="Icon Noxpital" class="h-10 me-3">
            <span class="text-white font-bold self-center text-2xl whitespace-nowrap dark:text-black">NoxPital</span>
        </a>

        <label for="menu-toggle" class="pointer-cursor md:hidden block"><svg class="fill-current text-white"
                xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg></label>

        <input class="hidden" type="checkbox" id="menu-toggle" />

        <div class="hidden md:block w-full md:w-auto" id="menu">
            <nav
                class="w-full bg-white md:bg-transparent rounded shadow-lg px-6 py-4 mt-4 text-center md:p-0 md:mt-0 md:shadow-none">
                <ul class="md:flex items-center">
                    @if (Route::is('login'))
                        <li class="md:ml-6 mt-3 md:mt-0">
                            <a href="{{ route('register') }}"
                                class="inline-block font-semibold px-4 py-2 text-white bg-blue-600 md:bg-transparent md:text-white border border-white rounded">
                                Daftar
                            </a>
                        </li>
                    @else
                        <li class="md:ml-6 mt-3 md:mt-0">
                            <a href="{{ route('login') }}"
                                class="inline-block font-semibold px-4 py-2 text-white bg-blue-600 md:bg-transparent md:text-white border border-white rounded">
                                Masuk
                            </a>
                        </li>
                    @endif
                    <li class="md:ml-4 mt-3 md:mt-0">
                        <a href="{{ url('/') }}"
                            class="inline-block font-semibold px-4 py-2 text-white bg-blue-600 md:bg-transparent md:text-white border border-white rounded">
                            Kembali
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
