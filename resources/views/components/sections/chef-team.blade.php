@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $chefs = $data['chefs'] ?? [
        ['name' => 'Alexandre Laurent', 'role' => 'Executive Chef', 'image' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=600&q=80', 'bio' => '20 years mastering French-Mediterranean fusion and seasonal forage cuisine.'],
        ['name' => 'Priya Sharma', 'role' => 'Master Spice Alchemist & Sous Chef', 'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80', 'bio' => 'Trained in Old Delhi and Lyon, weaving aromatic herbs and delicate reductions.'],
        ['name' => 'Marcus Vance', 'role' => 'Head Sommelier', 'image' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=600&q=80', 'bio' => 'Curating natural wines and vintage pairings from boutique vineyards worldwide.'],
    ];
@endphp

<section id="chefs" class="py-24 bg-stone-950 relative border-t border-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="chef-hat" class="w-3.5 h-3.5"></i>
                        <span>{{ $badge }}</span>
                    </div>
                @endif
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-stone-400 text-sm sm:text-base mt-2 leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <!-- Chefs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($chefs as $chef)
                <div class="group bg-stone-900/60 rounded-3xl overflow-hidden border border-stone-800 hover:border-amber-500/40 transition-all duration-300">
                    <div class="aspect-[4/5] overflow-hidden bg-stone-950 relative">
                        <img src="{{ $chef['image'] }}"
                             alt="{{ $chef['name'] }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-950/20 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif-heading text-xl font-bold text-white mb-1 group-hover:text-amber-400 transition-colors">
                            {{ $chef['name'] }}
                        </h3>
                        <p class="text-xs font-semibold uppercase tracking-wider text-amber-500 mb-3">
                            {{ $chef['role'] }}
                        </p>
                        <p class="text-xs text-stone-400 leading-relaxed">
                            {{ $chef['bio'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
