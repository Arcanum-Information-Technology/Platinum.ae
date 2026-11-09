@props(['data' => []])

@php
    $brandName = data_get($data, 'brand_name', 'Shakespeare Middle East');
    $tagline = data_get($data, 'tagline', 'A Timeless Dining Experience, Reimagined for Modern Hospitality');
    $rawBg = data_get($data, 'bg_image', 'images/platinum/brands/shakespeare.jpg');
    $bgImage = \App\Support\AssetUrl::make($rawBg);
    $badge = data_get($data, 'badge', 'Portfolio Brand');
@endphp

<section class="relative min-h-[55vh] lg:min-h-[65vh] flex items-center justify-center bg-[#070708] overflow-hidden pt-28 pb-20">
    <!-- Background Image with Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $bgImage }}"
             alt="{{ $brandName }}"
             class="w-full h-full object-cover scale-105 animate-[floatSlow_12s_ease-in-out_infinite_alternate]">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-[#0A0A0A]/75 to-[#0A0A0A]/50"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-transparent via-[#0A0A0A]/60 to-[#0A0A0A]"></div>
    </div>

    <!-- Ambient Gold Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-[#C5A265]/15 rounded-full blur-[160px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center">

        <!-- Breadcrumb -->
        <nav class="flex items-center justify-center gap-2 text-xs uppercase tracking-widest text-stone-400 mb-6 font-medium">
            <a href="{{ url('/') }}" class="hover:text-[#DFCA9B] transition-colors">Home</a>
            <span class="text-stone-600">/</span>
            <a href="{{ url('/brands') }}" class="hover:text-[#DFCA9B] transition-colors">Brands</a>
            <span class="text-stone-600">/</span>
            <span class="text-[#C5A265] font-semibold">{{ $brandName }}</span>
        </nav>

        <!-- Gold Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#C5A265]/15 border border-[#C5A265]/35 text-[#DFCA9B] text-xs font-semibold tracking-wider uppercase mb-5">
            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-[#C5A265]"></i>
            <span>{{ $badge }}</span>
        </div>

        <!-- Main Title -->
        <h1 class="font-serif-heading text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6 drop-shadow-lg">
            {{ $brandName }}
        </h1>

        <!-- Elegant Divider -->
        <div class="w-24 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-6"></div>

        <!-- Tagline -->
        <p class="text-base sm:text-xl lg:text-2xl text-stone-200 font-serif-heading italic max-w-3xl mx-auto leading-relaxed drop-shadow mb-8">
            "{{ $tagline }}"
        </p>

        <!-- Actions -->
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="#book-table" class="btn-gold px-8 py-3.5 rounded-xl text-xs sm:text-sm font-bold shadow-xl inline-flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>Reserve A Table</span>
            </a>
            <a href="#brand-story" class="btn-outline-gold px-8 py-3.5 rounded-xl text-xs sm:text-sm font-semibold inline-flex items-center gap-2">
                <i data-lucide="compass" class="w-4 h-4"></i>
                <span>Discover Experience</span>
            </a>
        </div>

    </div>
</section>

