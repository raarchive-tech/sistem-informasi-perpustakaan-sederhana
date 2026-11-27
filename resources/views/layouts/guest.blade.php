<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Readora') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8"
         style="background: linear-gradient(135deg, #eee9ff 0%, #f8f6ff 50%, #e9f2ff 100%);">

        <div class="w-full sm:max-w-xl px-8 py-10 bg-white shadow-xl rounded-3xl"
             style="box-shadow: 0 15px 50px rgba(113, 91, 170, 0.10);">

            {{ $slot }}

        </div>

    </div>

</body>
</html>
