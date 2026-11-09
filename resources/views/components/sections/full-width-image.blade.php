@props(['data'])

@php
    $image = $data['image'] ?? null;
    $caption = $data['caption'] ?? null;
@endphp

<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden bg-stone-950 border-y border-stone-800">
    @if($image)
        <div class="absolute inset-0">
            <img src="{{ $image }}" alt="Panoramic View" loading="lazy" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-stone-950/60 backdrop-blur-[2px]"></div>
        </div>
    @endif
    @if(!empty(trim($caption ?? '')))
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <blockquote class="font-serif italic text-xl sm:text-3xl text-amber-200/90 font-light drop-shadow-md leading-relaxed">
                {{ $caption }}
            </blockquote>
        </div>
    @endif
</section>
