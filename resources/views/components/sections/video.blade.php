@props(['data'])

@php
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $videoUrl = $data['video_url'] ?? '';
    $poster = $data['poster'] ?? null;
@endphp

<section class="py-24 bg-stone-950 border-t border-stone-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center mb-12">
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-white tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-stone-400 text-sm sm:text-base mt-2">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <div class="relative rounded-3xl overflow-hidden aspect-video border border-stone-800 shadow-2xl bg-stone-900">
            @if($videoUrl && str_contains($videoUrl, 'youtube'))
                <iframe src="{{ $videoUrl }}"
                        title="{{ $title }}"
                        class="w-full h-full border-0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            @else
                <img src="{{ $poster }}" alt="{{ $title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-amber-500 text-stone-950 flex items-center justify-center shadow-xl">
                        <i data-lucide="play" class="w-7 h-7 fill-stone-950 ml-1"></i>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
