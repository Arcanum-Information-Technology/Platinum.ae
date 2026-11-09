@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $primaryBtnText = $data['primary_btn_text'] ?? null;
    $primaryBtnUrl = $data['primary_btn_url'] ?? null;
    $secondaryBtnText = $data['secondary_btn_text'] ?? null;
    $secondaryBtnUrl = $data['secondary_btn_url'] ?? null;
    $bgImage = $data['bg_image'] ?? 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1920&q=80';
@endphp

<section class="relative min-h-[85vh] lg:min-h-[92vh] flex items-center justify-center overflow-hidden bg-stone-950 pt-24 pb-16">
    <!-- Background Image with Parallax-feel Dark Wash -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $bgImage }}"
             alt="Restaurant Ambiance"
             class="w-full h-full object-cover object-center filter brightness-[0.38] contrast-105 scale-105 transition-transform duration-1000">
        <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-950/60 to-black/80"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(217,119,6,0.12),transparent_70%)]"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @if(!empty(trim($badge ?? '')))
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs sm:text-sm font-medium tracking-widest uppercase mb-6 backdrop-blur-md animate-fade-in">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400"></i>
                <span>{{ $badge }}</span>
            </div>
        @endif

        @if(!empty(trim($title ?? '')))
            <h1 class="font-serif-heading text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6 drop-shadow-lg">
                {{ $title }}
            </h1>
        @endif

        @if(!empty(trim($subtitle ?? '')))
            <p class="max-w-2xl mx-auto text-base sm:text-xl text-stone-300 font-light leading-relaxed mb-10 drop-shadow">
                {{ $subtitle }}
            </p>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-5">
            @if($primaryBtnText && $primaryBtnUrl)
                <a href="{{ url($primaryBtnUrl) }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-full font-semibold uppercase tracking-wider text-sm text-stone-950 bg-gradient-to-r from-amber-400 via-amber-500 to-amber-400 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/25 transition-all duration-300 hover:scale-105 active:scale-95">
                    <span>{{ $primaryBtnText }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            @endif

            @if($secondaryBtnText && $secondaryBtnUrl)
                <a href="{{ url($secondaryBtnUrl) }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-full font-semibold uppercase tracking-wider text-sm text-white bg-stone-900/80 hover:bg-stone-800 border border-stone-700/80 backdrop-blur-md transition-all duration-300 hover:border-amber-400/50 hover:scale-105 active:scale-95">
                    <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
                    <span>{{ $secondaryBtnText }}</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 text-stone-500 text-[10px] uppercase tracking-widest pointer-events-none">
        <span>Scroll</span>
        <i data-lucide="chevron-down" class="w-4 h-4 animate-bounce text-amber-500"></i>
    </div>
</section>
