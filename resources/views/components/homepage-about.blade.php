<section class="relative px-4 py-16 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 lg:py-32">
    {{-- About Section START --}}
    <div class="flex flex-col lg:flex-row lg:-mx-8">
        <div class="w-full lg:w-1/2 lg:px-8">
            <h2 class="text-3xl leading-tight font-bold mt-4">
                Selamat Datang di Website Rumah Sakit Universitas Hasanuddin (RS Unhas)
            </h2>
            <p class="text-lg mt-4 font-semibold">
                "Long Life Learning, Innovation, Togetherness, Trustfullness, Compassionate"
            </p>
            <p class="mt-2 leading-relaxed text-justify">
                Rumah Sakit Universitas Hasanuddin (UNHAS) adalah sebuah rumah sakit yang terletak di Kota Makassar
                Provinsi Sulawesi Selatan. Rumah Sakit UNHAS rumah sakit dibawah Kementerian Riset, Teknologi dan
                Pendidikan Tinggi. Misi Rumah Sakit UNHAS adalah menjadi pelopor terpercaya dalam memadukan pendidikan,
                penelitian dan pemeliharaan kesehatan yang bertaraf internasional.
            </p>
        </div>

        <div class="w-full lg:w-1/2 lg:px-8 mt-12 lg:mt-0">
            <div class="md:flex">
                <div>
                    <ion-icon name="people-outline" class="w-16 h-16"></ion-icon>
                </div>
                <div class="md:ml-8 mt-4 md:mt-0">
                    <h4 class="text-xl font-bold leading-tight">
                        Tenaga Medis dan Tenaga Nonmedis
                    </h4>
                    <p class="mt-2 leading-relaxed text-justify">
                        RS Unhas ini didukung 487 tenaga medis dan 366 tenaga non medis yang tersebar di seluruh
                        unit-unit pelayanan. Tidak hanya itu, rumah sakit pendidikan ini memiliki 204 tempat tidur untuk
                        rawat inap pasien. Ruang kelas yang tersedia dari kelas VVIP, kelas VIP, kelas I, kelas II,
                        sampai kelas III. Kemudian, terdapat ruang rawat inap khusus kemoterapi bagi pasien kemoterapi.
                    </p>
                </div>
            </div>

            <div class="md:flex mt-8">
                <div>
                    <ion-icon name="medkit-outline" class="w-16 h-16"></ion-icon>
                </div>
                <div class="md:ml-8 mt-4 md:mt-0">
                    <h4 class="text-xl font-bold leading-tight">
                        Dokter Spesialis dan Dokter Subspesialis
                    </h4>
                    <p class="mt-2 leading-relaxed text-justify">
                        Terdapat 16 dokter spesialis dan 10 dokter subspesialis yang tersedia di Rumah Sakit Universitas
                        Hasanuddin. Tidak hanya itu, RS Unhas ini memiliki layanan unggulan yang terdiri dari Assesment
                        Alternative Medicine Center, Cancer Center, Cerebral and Vascular Intervention Center, Eye
                        Center, Fertility Endocrine Reproductive Center, Physiotheraphy and Rehabilition Center,
                        Telemedicine and Education Center, dan Trauma Center.
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- About Section END --}}

    {{-- Service Section START --}}
    <h1 class="mt-28 text-center text-4xl font-black">Layanan Unggulan</h1>

    <div class="md:flex md:flex-wrap md:justify-center mt-16 text-center md:gap-6">
        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-eye-center.png') }}" alt="Eye Center Service"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Mata</h4>
            <p class="mt-2">Let us show you how our experience.</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-trauma-center.png') }}" alt="Trauma Center Service"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Trauma</h4>
            <p class="mt-1">Let us show you how our experience.</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-cancer-center.png') }}" alt="Cancer Center Service"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Kanker</h4>
            <p class="mt-1">Let us show you how our experience.</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-telemedicine.png') }}" alt="Telemedicine Service"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Telemedis</h4>
            <p class="mt-1">Let us show you how our experience.</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-research-center.png') }}" alt="Research Center"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Penelitian</h4>
            <p class="mt-1">Let us show you how our experience.</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-neurology.png') }}" alt="Neurology Center"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Intervensi Saraf</h4>
            <p class="mt-1">Let us show you how our experience.</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="{{ asset('storage/assets/service-endocrionology.png') }}" alt="Endocrionology Center"
                class="h-20 mx-auto" />
            <h4 class="text-xl font-bold mt-4">Pusat Endokrin dan Reproduksi</h4>
            <p class="mt-1">Let us show you how our experience.</p>
        </a>
    </div>
    {{-- Service Section END --}}
</section>
