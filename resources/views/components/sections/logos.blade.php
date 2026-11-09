@props(['data'])

@php
    $title = $data['title'] ?? null;
    $logos = $data['logos'] ?? [
        ['name' => 'Michelin Guide Selection', 'text' => 'MICHELIN GUIDE 2025'],
        ['name' => 'James Beard Foundation', 'text' => 'JAMES BEARD NOMINEE'],
        ['name' => 'The New York Times', 'text' => 'NYT CRITICS PICK'],
        ['name' => 'Food & Wine Magazine', 'text' => 'BEST NEW CHEFS'],
    ];
@endphp

<section id="awards" class="py-16 bg-stone-900/60 border-y border-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @if(!empty(trim($title ?? '')))
            <p class="text-xs uppercase tracking-widest text-amber-500/90 font-semibold mb-8">
                {{ $title }}
            </p>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
            @foreach($logos as $logo)
                <div class="p-4 rounded-xl bg-stone-900/80 border border-stone-800 text-stone-300 font-serif tracking-widest text-xs sm:text-sm font-semibold uppercase hover:border-amber-500/30 transition-colors">
                    {{ $logo['text'] ?? $logo['name'] }}
                </div>
            @endforeach
        </div>
    </div>
</section>
