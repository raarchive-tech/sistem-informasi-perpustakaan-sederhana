<x-guest-layout>
    <div style="text-align: center; margin-bottom: 25px;">

        {{-- Logo Readora --}}
        <img
            src="{{ asset('images/readora-logo.png') }}"
            alt="Readora"
            style="
                display: block;
                width: 250px;
                max-width: 100%;
                height: auto;
                object-fit: contain;
                margin: 0 auto 14px;
            "
        >

        <h2 style="margin: 0; color: #504c70; font-size: 23px; font-weight: 800;">
            Lupa Password?
        </h2>

        <p style="margin-top: 8px; color: #9996ad; font-size: 12px; line-height: 1.7;">
            Jangan khawatir. Masukkan alamat email akunmu untuk menerima tautan pengaturan ulang password.
        </p>
    </div>

    {{-- Status Pengiriman --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Form Lupa Password --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan alamat email"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <x-primary-button style="width: 100%; justify-content: center;">
                Kirim Link Reset Password
            </x-primary-button>
        </div>
    </form>

    {{-- Kembali ke Login --}}
    <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid #f0eef7; text-align: center;">
        <a
            href="{{ route('login') }}"
            style="display: inline-flex; align-items: center; gap: 7px; color: #8982c5; font-size: 12px; font-weight: 700; text-decoration: none;"
        >
            <span style="font-size: 17px;">←</span>
            Kembali ke Halaman Login
        </a>
    </div>
</x-guest-layout>
