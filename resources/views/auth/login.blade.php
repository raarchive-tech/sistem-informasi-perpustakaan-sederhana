<x-guest-layout>

    <style>
        .readora-login-heading {
            color: #504c70;
            font-size: 25px;
            font-weight: 800;
            text-align: center;
            margin: 0 0 22px;
        }

        .readora-login-logo {
            display: block;
            width: 280px;
            max-width: 100%;
            height: auto;
            margin: 0 auto 35px;
            object-fit: contain;
        }

        .readora-password-wrapper {
            position: relative;
            margin-top: 5px;
        }

        .readora-password-wrapper input {
            padding-right: 50px !important;
        }

        .readora-password-toggle {
            all: unset !important;
            box-sizing: border-box !important;
            position: absolute !important;
            top: 50% !important;
            right: 14px !important;
            transform: translateY(-50%) !important;
            width: 30px !important;
            height: 30px !important;
            min-width: 30px !important;
            min-height: 30px !important;
            max-width: 30px !important;
            max-height: 30px !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            color: #9995b5 !important;
            box-shadow: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
        }

        .readora-password-toggle:hover {
            background: transparent !important;
            color: #7654b8 !important;
        }

        .readora-password-toggle svg {
            width: 22px;
            height: 22px;
            display: block;
        }
    </style>

    {{-- Judul dan Logo --}}
    <div>
        <h2 class="readora-login-heading">
            Selamat Datang Kembali
        </h2>

        <img
            src="{{ asset('images/readora-logo.png') }}"
            alt="Readora"
            class="readora-login-logo"
        >
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
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

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="readora-password-wrapper">

                <x-text-input
                    id="password"
                    class="block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                />

                <button
                    type="button"
                    class="readora-password-toggle"
                    id="togglePassword"
                    onclick="togglePasswordVisibility()"
                    aria-label="Tampilkan password"
                >
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>

                    <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round"
                         style="display: none;">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"></path>
                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a13.8 13.8 0 0 1-3.1 3.8"></path>
                        <path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"></path>
                    </svg>
                </button>

            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Ingat Saya --}}
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember"
                >

                <span class="ms-2 text-sm text-gray-600">
                    Ingat saya
                </span>
            </label>
        </div>

        {{-- Tombol Login --}}
        <div class="flex items-center justify-between mt-5"
             style="gap: 10px; flex-wrap: wrap;">

            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    style="font-size: 12px; color: #8982c5; font-weight: 600; text-decoration: none;"
                >
                    Lupa Password?
                </a>
            @endif

            <x-primary-button style="margin-left: auto;">
                {{ __('Masuk') }}
            </x-primary-button>

        </div>
    </form>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            const toggleButton = document.getElementById('togglePassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
                toggleButton.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
                toggleButton.setAttribute('aria-label', 'Tampilkan password');
            }
        }
    </script>

</x-guest-layout>
