@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $btnText = $data['btn_text'] ?? null;
    $btnUrl = $data['btn_url'] ?? '/contact';
@endphp

<section class="py-24 bg-stone-950 relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="relative rounded-3xl bg-gradient-to-tr from-stone-900 via-stone-900 to-amber-950/40 border border-amber-500/30 p-10 sm:p-16 text-center shadow-2xl overflow-hidden">

            <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 rounded-full bg-amber-600/10 blur-3xl pointer-events-none"></div>

            @if(!empty(trim($badge ?? '')))
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-4">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>{{ $badge }}</span>
                </div>
            @endif

            @if(!empty(trim($title ?? '')))
                <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight mb-6">
                    {{ $title }}
                </h2>
            @endif

            @if(!empty(trim($subtitle ?? '')))
                <p class="max-w-2xl mx-auto text-stone-300 text-sm sm:text-base leading-relaxed mb-10 font-light">
                    {{ $subtitle }}
                </p>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if(!empty(trim($btnText ?? '')))
                    <a href="{{ url($btnUrl) }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-full font-semibold uppercase tracking-wider text-sm text-stone-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/25 transition-all duration-300 hover:scale-105 active:scale-95">
                        <span>{{ $btnText }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endif

                <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('restaurant_phone', '+15552345678')) }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-300 bg-stone-950/80 border border-stone-800 hover:border-amber-500/40 hover:text-white transition-colors">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>Direct Concierge</span>
                </a>
            </div>

        </div>
    </div>
</section>
