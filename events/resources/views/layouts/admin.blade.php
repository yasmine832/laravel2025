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
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-slate-900">
            <!-- Sidebar -->
            <div class="w-64 bg-slate-950 shadow-lg">
                <div class="flex flex-col h-full">
                    <!-- Logo Area -->
                    <div class="p-4 border-b border-slate-800">
                        <div class="flex items-center space-x-4">
                            <span class="text-lg font-semibold text-black">___Admin___</span>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 p-4 space-y-2">
                        <a href="{{ route('admin.index') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>   Manage Users</span>
                        </a>
                        
                        <a href="{{ route('admin.create-user') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.create-user') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>Create User</span>
                        </a>
                    </nav>

                    <!-- Bottom Actions -->
                    <div class="p-4 border-t border-slate-800">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg text-slate-300 hover:bg-slate-800 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Back to Site</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-slate-300 hover:bg-slate-800 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Top Bar -->
                <header class="bg-slate-800 shadow-lg">
                    <div class="p-4">
                        @if (isset($header))
                            {{ $header }}
                        @endif
                    </div>
                </header>

                <!-- Content Area -->
                <main class="p-6">
                    @if (session('success'))
                        <div class="mb-4 bg-green-600/10 border border-green-600/20 text-green-500 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
 <!--  Adapted from code generated by ChatGPT:https://chatgpt.com/share/67890672-16d4-8007-a30f-19d18c37df6b -->
