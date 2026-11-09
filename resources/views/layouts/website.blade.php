<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seo = $seoMetadata ?? app(\App\Services\SeoService::class)->getMetadata($entity ?? null, Route::currentRouteName());
        $siteName = \App\Models\Setting::get('site_name', 'Platinum Hospitality Management');
        $favicon = \App\Models\Setting::get('site_favicon', 'images/platinum-logo.png');
        $headScripts = \App\Models\Setting::get('custom_head_scripts');
        $googleVerify = \App\Models\Setting::get('google_site_verification');
    @endphp

    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['meta_description'] }}">
    <link rel="canonical" href="{{ $seo['canonical_url'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}">

    @if($googleVerify)
        <meta name="google-site-verification" content="{{ $googleVerify }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seo['og_type'] }}">
    <meta property="og:url" content="{{ $seo['og_url'] }}">
    <meta property="og:title" content="{{ $seo['og_title'] }}">
    <meta property="og:description" content="{{ $seo['og_description'] }}">
    <meta property="og:image" content="{{ $seo['og_image'] }}">
    <meta property="og:site_name" content="{{ $siteName }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="{{ $seo['twitter_card'] }}">
    <meta name="twitter:title" content="{{ $seo['twitter_title'] }}">
    <meta name="twitter:description" content="{{ $seo['twitter_description'] }}">
    <meta name="twitter:image" content="{{ $seo['twitter_image'] }}">

    <!-- Favicon -->
    @if($favicon)
        <link rel="icon" type="image/png" href="{{ asset($favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/platinum-logo.png') }}">
    @endif

    <!-- Luxury Typography Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Schema.org JSON-LD -->
    @if(!empty($seo['schema_json_ld']))
        <script type="application/ld+json">
            {!! json_encode($seo['schema_json_ld'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif

    @stack('schema')

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if($headScripts)
        {!! $headScripts !!}
    @endif

    @stack('styles')
</head>
<body class="bg-[#0A0A0A] text-stone-200 antialiased flex flex-col min-h-screen selection:bg-[#C5A265] selection:text-stone-950">

    <!-- Header Navigation -->
    @include('components.website.header')

    <!-- Flash Notifications / Toasts -->
    <div x-data="{ show: true }" class="fixed top-24 right-4 z-50 max-w-md w-full space-y-3 pointer-events-none">
        @if(session('success'))
            <div x-show="show" x-transition.duration.300ms class="pointer-events-auto plat-glass-gold text-stone-100 p-4 rounded-2xl shadow-2xl flex items-start gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-[#C5A265] shrink-0 mt-0.5"></i>
                <div class="flex-1">
                    <h4 class="font-semibold text-[#DFCA9B] text-sm">Thank You</h4>
                    <p class="text-xs text-stone-300 mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-stone-400 hover:text-white">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-show="show" x-transition.duration.300ms class="pointer-events-auto bg-rose-950/90 border border-rose-500/40 text-stone-100 p-4 rounded-2xl shadow-2xl flex items-start gap-3 backdrop-blur-md">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400 shrink-0 mt-0.5"></i>
                <div class="flex-1">
                    <h4 class="font-semibold text-rose-400 text-sm">Attention</h4>
                    <p class="text-xs text-stone-300 mt-0.5">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-stone-400 hover:text-white">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer Component -->
    @include('components.website.footer')

    @stack('scripts')
</body>
</html>
