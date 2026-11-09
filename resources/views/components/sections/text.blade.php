@props(['data' => []])

@php
    $badge = data_get($data, 'badge');
    $title = data_get($data, 'title');
    $subtitle = data_get($data, 'subtitle');
    $body = data_get($data, 'content', '');
    $alignment = data_get($data, 'align', 'center');
    $alignClass = match($alignment) {
        'left' => 'text-left max-w-4xl mx-auto',
        'right' => 'text-right max-w-4xl mx-auto',
        default => 'text-center max-w-3xl mx-auto',
    };
@endphp

<section class="py-16 sm:py-20 lg:py-24 bg-stone-950 text-stone-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="{{ $alignClass }} space-y-4">
            @if($badge)
                <span class="inline-block px-3 py-1 rounded-full text-xs font-mono uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20">
                    {{ $badge }}
                </span>
            @endif

            @if($title)
                <h2 class="font-serif-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                    {{ $title }}
                </h2>
            @endif

            @if($subtitle)
                <p class="text-sm sm:text-base text-stone-300 leading-relaxed font-light">
                    {{ $subtitle }}
                </p>
            @endif

            @if($body)
                <div class="prose prose-invert prose-stone max-w-none pt-4 text-stone-300 text-sm sm:text-base leading-relaxed">
                    {!! nl2br(e($body)) !!}
                </div>
            @endif
        </div>
    </div>
</section>
