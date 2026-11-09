@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $items = $data['items'] ?? \App\Models\MenuItem::with(['category', 'subcategory'])->published()->available()->featured()->take(6)->get();
@endphp

<section class="py-24 bg-stone-900/60 relative border-t border-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        <span>{{ $badge }}</span>
                    </div>
                @endif
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-stone-400 text-sm sm:text-base mt-3 leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <!-- Food Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($items as $item)
                <x-website.food-card :item="$item" />
            @endforeach
        </div>

        <!-- Section Footer CTA -->
        <div class="text-center mt-14">
            <a href="{{ url('/menu') }}"
               class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-semibold uppercase tracking-wider text-xs text-white bg-stone-900 border border-amber-500/40 hover:bg-amber-500 hover:text-stone-950 transition-all duration-300 shadow-xl shadow-black/40">
                <span>View Complete Menu</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

    </div>
</section>
