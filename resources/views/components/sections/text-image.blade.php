@props(['data'])

@php
    $title = $data['title'] ?? null;
    $content = $data['content'] ?? null;
    $image = $data['image'] ?? null;
    $btnText = $data['btn_text'] ?? null;
    $btnUrl = $data['btn_url'] ?? null;
@endphp

<section class="py-24 bg-stone-950 border-t border-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="space-y-6">
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($content ?? '')))
                    <div class="prose-content text-stone-300 text-sm sm:text-base leading-relaxed">
                        {!! $content !!}
                    </div>
                @endif
                @if($btnText && $btnUrl)
                    <div class="pt-4">
                        <a href="{{ url($btnUrl) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors">
                            <span>{{ $btnText }}</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                @endif
            </div>

            @if($image)
                <div class="relative rounded-3xl overflow-hidden aspect-[4/3] border border-stone-800 shadow-2xl">
                    <img src="{{ $image }}" alt="{{ $title ?? '' }}" loading="lazy" class="w-full h-full object-cover">
                </div>
            @endif
        </div>
    </div>
</section>
