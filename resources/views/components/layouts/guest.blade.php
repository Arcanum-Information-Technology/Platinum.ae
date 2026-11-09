<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-stone-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Sign In' }} | Shakespeare Middle East</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans antialiased text-stone-100 bg-stone-950 flex flex-col justify-center py-8 sm:px-6 lg:px-8 selection:bg-amber-600 selection:text-white relative overflow-auto">

    <!-- Background Ambience -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-amber-600/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-amber-500/10 blur-3xl"></div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
        <img src="{{ \App\Support\AssetUrl::make(\App\Models\Setting::get('site_logo') ?: 'Logo.png') }}" alt="Shakespeare Middle East" class="h-20 w-auto mx-auto mb-2 brightness-0 invert">
        <h2 class="font-serif-heading text-2xl font-extrabold tracking-tight text-white">
            Shakespeare Middle East
        </h2>
        <p class="mt-2 text-xs text-stone-400 uppercase tracking-widest">
            Restaurant Management & CMS Portal
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10 px-4">
        <div class="bg-stone-900/90 border border-stone-800 p-8 sm:p-10 rounded-3xl shadow-2xl backdrop-blur-xl">
            {{ $slot }}
        </div>
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-xs text-stone-400 hover:text-amber-400 inline-flex items-center gap-1.5 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Return to Public Website</span>
            </a>
        </div>
    </div>

</body>
</html>
