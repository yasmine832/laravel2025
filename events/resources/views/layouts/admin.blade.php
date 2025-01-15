<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-800">
            <!-- Side Navigation -->
            <div class="fixed top-0 left-0 h-screen w-64 bg-slate-900 text-white p-4">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-indigo-400">Admin Panel</h1>
                </div>
                
                <!-- Admin User Info -->
                <div class="mb-8 p-4 bg-slate-800 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <img src="{{ Auth::user()->profile_photo_url }}" class="h-10 w-10 rounded-full">
                        <div>
                            <div class="font-medium text-indigo-300">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-slate-400">Administrator</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="{{ route('admin.index') }}" 
                       class="{{ request()->routeIs('admin.index') ? 'bg-indigo-600' : 'hover:bg-slate-700' }} flex items-center px-4 py-3 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Manage Users
                    </a>
                    <a href="{{ route('admin.create-user') }}" 
                       class="{{ request()->routeIs('admin.create-user') ? 'bg-indigo-600' : 'hover:bg-slate-700' }} flex items-center px-4 py-3 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Create User
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="hover:bg-slate-700 flex items-center px-4 py-3 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Back to Site
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="ml-64">
                <!-- Top Bar -->
                <div class="bg-slate-900 text-white px-8 py-4 flex justify-between items-center">
                    <div>
                        @if (isset($header))
                            {{ $header }}
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-300 hover:text-white transition-colors">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Content Area -->
                <div class="p-8 bg-slate-800 text-slate-200">
                    @if (session('success'))
                        <div class="mb-4 bg-green-900 border border-green-600 text-green-100 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>