<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-stone-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} | {{ \App\Models\Setting::get('site_name', 'Saffron & Thyme') }} CMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-stone-200 bg-stone-950 selection:bg-amber-600 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/80 backdrop-blur-sm lg:hidden"
             style="display: none;"></div>

        <!-- Sidebar Component -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             class="fixed inset-y-0 left-0 z-50 w-72 bg-stone-900 border-r border-stone-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col justify-between">
            @include('components.admin.sidebar')
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-stone-950">

            <!-- Topbar -->
            @include('components.admin.topbar')

            <!-- Main Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 flex items-center justify-between shadow-lg">
                        <div class="flex items-center gap-3">
                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-200">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 flex items-center justify-between shadow-lg">
                        <div class="flex items-center gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400 shrink-0"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-400 hover:text-rose-200">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/50 text-rose-200 text-xs space-y-1">
                        <div class="font-bold flex items-center gap-2 text-sm text-rose-300">
                            <i data-lucide="alert-octagon" class="w-4 h-4"></i>
                            Please correct the errors below:
                        </div>
                        <ul class="list-disc pl-5 space-y-0.5 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

    </div>

    <!-- Global Media Picker Modal / Drawer -->
    @include('components.admin.media-picker')

    @stack('scripts')
</body>
</html>
