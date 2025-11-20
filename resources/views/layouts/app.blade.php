<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
            dark: localStorage.getItem('dark') === 'true',
            sidebarOpen: false,
            toggleDarkMode() {
                this.dark = !this.dark;
                localStorage.setItem('dark', this.dark);
            }
      }"
      :class="{ 'dark': dark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Department Expenses Monitoring App') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-serif antialiased bg-gray-200 dark:bg-blue-900">

    {{-- 👇 FIX ADDED — Prevents white page when variables are missing --}}
    @php
        $unreadCount = $unreadCount ?? 0;
        $dropdownNotifications = $dropdownNotifications ?? collect();
    @endphp
    {{-- 👍 Now layout will NEVER break --}}

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
            @click="sidebarOpen = false"></div>

        <!-- Mobile Sidebar -->
        <aside x-show="sidebarOpen" x-cloak x-transition
            class="fixed z-50 inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 md:hidden overflow-y-auto">
            @include('partials.sidebar')
        </aside>

        <!-- Desktop Sidebar -->
        <aside
            class="hidden md:flex md:w-16 bg-white dark:bg-gray-800 flex-col border-r border-gray-200 dark:border-gray-700">
            @include('partials.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 px-4 py-4 shadow flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="md:hidden text-gray-700 dark:text-gray-200 focus:outline-none">
                    <x-heroicon-o-bars-3 class="w-6 h-6" />
                </button>

                @isset($header)
                    <h2 class="ml-4 text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $header }}
                    </h2>
                @endisset

                <div class="ml-auto flex items-center gap-4">

                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode()"
                        class="text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition">
                        <template x-if="!dark">
                            <x-heroicon-o-sun class="w-6 h-6" />
                        </template>
                        <template x-if="dark">
                            <x-heroicon-o-moon class="w-6 h-6" />
                        </template>
                    </button>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="relative text-gray-700 dark:text-white hover:text-indigo-600 focus:outline-none">
                            <x-heroicon-o-bell class="w-6 h-6" />
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg z-50">
                            <div class="p-3 font-semibold text-sm text-gray-700 dark:text-white">Notifications</div>
                            <ul class="max-h-56 overflow-y-auto divide-y divide-gray-200 dark:divide-gray-600 text-sm">
                                @forelse ($dropdownNotifications->where('read', false) as $note)
                                    <li class="px-4 py-2 text-gray-600 dark:text-gray-300">
                                        {{ $note->message }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-center text-gray-400 dark:text-gray-400">
                                        No notifications
                                    </li>
                                @endforelse
                            </ul>
                            <div class="text-center border-t dark:border-gray-600">
                                <a href="{{ route('notifications.index') }}"
                                    class="block px-4 py-2 text-sm text-indigo-600 dark:text-indigo-300 hover:underline">View
                                    All</a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-sm font-medium text-gray-700 dark:text-white hover:text-gray-900 dark:hover:text-gray-300 focus:outline-none">
                            <div class="text-left mr-2 leading-tight">
                                <div class="font-medium">{{ Auth::user()->first_name }} {{ Auth::user()->middle_name }}
                                    {{ Auth::user()->last_name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                                    {{ Auth::user()->role==='admin'?'Over-All Treasurer':'Treasurer' }}</div>
                            </div>
                            <x-heroicon-o-chevron-down class="w-5 h-5" />
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg z-50">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="pt-6 px-4 sm:px-6 md:px-8 pb-6 overflow-y-auto flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('toast'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '{{ session('toast.type') }}',
                title: '{{ session('toast.message') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

</body>

</html>
