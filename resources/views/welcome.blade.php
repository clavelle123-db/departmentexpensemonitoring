<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
asdas
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Department Expenses Monitoring App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gradient-to-r from-teal-500 to-indigo-500 text-white">
    <!-- Main container -->
    <div class="flex min-h-screen items-center justify-center px-6 sm:px-12">
        <div class="text-center bg-white bg-opacity-80 p-10 rounded-xl shadow-2xl w-full max-w-lg">

            <!-- Logo -->
            <div class="mb-6">
                <img src="{{ asset('images/melogo.png') }}" alt="Logo" class="mx-auto w-30 h-20 mb-4">
            </div>

            <!-- Heading -->
            <h1 class="text-4xl font-bold mb-4 text-gray-800">Welcome to the Department Expenses Monitoring App</h1>

            @auth
                <p class="text-xl text-gray-600 mb-4">Wasdadsadasdadahfdsadgasdahasdasdelcome back, <strong>{{ auth()->user()->first_name }}</strong>!</p>
                <a href="{{ route('dashboard') }}" class="inline-block text-white bg-teal-600 hover:bg-teal-700 py-3 px-8 rounded-lg text-xl transition-all ease-in-out duration-300 transform hover:scale-105">Go to Dashboard</a>
            @else
                <p class="text-xl text-gray-600 mb-4">New here? Sign up or log in to start managing your department's expenses.</p>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="inline-block text-teal-600 hover:text-teal-800 text-xl font-semibold transition duration-300">Login</a>
                    <span class="text-gray-600">|</span>
                    <a href="{{ route('register') }}" class="inline-block text-teal-600 hover:text-teal-800 text-xl font-semibold transition duration-300">Register</a>
                </div>
            @endauth
        </div>
    </div>
</body>

</html>
