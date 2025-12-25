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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Breeze assets (DON'T TOUCH) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{
            font-family: 'Inter','Figtree',sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">

<div class="min-h-screen flex flex-col justify-center items-center px-4">

    <!-- Logo -->
    <div class="mb-6">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-200" />
        </a>
    </div>

    <!-- Auth Card -->
    <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl px-6 py-6">
        @yield('content')
    </div>

</div>

</body>
</html>
