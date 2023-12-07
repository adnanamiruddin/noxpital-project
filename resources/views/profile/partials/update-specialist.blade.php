<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Spesialis Dokter') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Perbarui informasi spesialis akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('specialist.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="specialist" :value="__('Spesialis')" />
            <x-text-input id="specialist" name="specialist" type="text" class="mt-1 block w-full" :value="old('specialist', $user->specialist)"
                required autofocus autocomplete="specialist" />
            <x-input-error class="mt-2" :messages="$errors->get('specialist')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
