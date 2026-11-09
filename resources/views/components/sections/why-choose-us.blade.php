@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $features = $data['features'] ?? [
        ['title' => 'Farm to Table Fresh', 'desc' => '100% locally harvested seasonal produce direct from organic growers daily.', 'icon' => 'leaf'],
        ['title' => 'Masterful Culinary Team', 'desc' => 'Led by Michelin-trained artisans committed to perfection in every garnish.', 'icon' => 'chef-hat'],
        ['title' => 'Intimate Ambiance', 'desc' => 'Thoughtfully curated acoustics, warm lighting, and luxury private dining alcoves.', 'icon' => 'wine'],
        ['title' => 'Impeccable Hospitality', 'desc' => 'Gracious concierge service attending to dietary subtleties and bespoke pairings.', 'icon' => 'heart-handshake'],
    ];
@endphp

<section class="py-24 bg-stone-900/40 relative border-t border-stone-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
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

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($features as $f)
                <div class="bg-stone-900/80 border border-stone-800 p-8 rounded-2xl hover:border-amber-500/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-black/50 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 mb-6 group-hover:scale-110 group-hover:bg-amber-400 group-hover:text-stone-950 transition-all">
                        <i data-lucide="{{ $f['icon'] ?? 'sparkles' }}" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-serif-heading text-lg font-bold text-white mb-2 group-hover:text-amber-400 transition-colors">
                        {{ $f['title'] }}
                    </h3>
                    <p class="text-xs sm:text-sm text-stone-400 leading-relaxed">
                        {{ $f['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>
