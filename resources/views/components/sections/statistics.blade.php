@props(['data'])

@php
    $stats = $data['stats'] ?? [
        ['number' => '120k+', 'label' => 'Happy Diners Served', 'icon' => 'smile'],
        ['number' => '45+', 'label' => 'Artisanal Recipes', 'icon' => 'utensils'],
        ['number' => '18', 'label' => 'Gastronomy Awards', 'icon' => 'trophy'],
        ['number' => '4.9', 'label' => 'Average Rating on Google', 'icon' => 'star'],
    ];
@endphp

<section class="py-16 bg-stone-900 border-y border-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            @foreach($stats as $s)
                <div class="space-y-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-500/10 text-amber-400 mb-2">
                        <i data-lucide="{{ $s['icon'] ?? 'award' }}" class="w-5 h-5"></i>
                    </div>
                    <div class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white">
                        {{ $s['number'] }}
                    </div>
                    <p class="text-xs sm:text-sm text-stone-400 font-medium">
                        {{ $s['label'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
