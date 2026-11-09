@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Multi-Concept Footprint');
    $title = data_get($data, 'title', 'OUR BRANCHES');
    $subtitle = data_get($data, 'subtitle', 'Discover our restaurant locations across the region, each offering the same signature experience.');

    $branches = [
        [
            'id' => 'shakespeare',
            'num' => '1.',
            'name' => 'Shakespeare Middle East',
            'tag' => 'Café, Restaurant & Patisserie',
            'desc' => 'Victorian elegance, artisan French pastries, gourmet European menu, and handcrafted tea rituals.',
            'locations' => 'Bawabat Al Sharq Mall • Radiant Square Tower • UAE Flagship',
            'image' => asset('images/platinum/brands/shakespeare.jpg'),
            'link' => url('/brands/shakespeare-middle-east'),
        ],
        [
            'id' => 'otantik',
            'num' => '2.',
            'name' => 'Otantik Cafe & Restaurant',
            'tag' => 'Middle Eastern Grills & Shisha Lounge',
            'desc' => 'Authentic charcoal grilled kebabs, rich mezze platters, freshly baked flatbreads, and ambient shisha terrace.',
            'locations' => 'Prime Waterfront Promenade • Abu Dhabi & Dubai',
            'image' => asset('images/platinum/brands/otantik.jpg'),
            'link' => url('/brands/otantik-cafe-restaurant'),
        ],
        [
            'id' => 'chinese-connection',
            'num' => '3.',
            'name' => 'Chinese Connection',
            'tag' => 'Contemporary Pan-Asian & Dim Sum',
            'desc' => 'Sensory Asian gastronomy, steaming bamboo dim sum baskets, sizzling wok beef, and dramatic dining halls.',
            'locations' => 'Metropolitan Mall • Downtown Dining District',
            'image' => asset('images/platinum/brands/chinese-connection.jpg'),
            'link' => url('/brands/chinese-connection'),
        ],
    ];
@endphp

<section class="py-24 sm:py-32 bg-[#0D0D0E] relative overflow-hidden border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $title }}
            </h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-stone-300 text-base sm:text-lg font-light leading-relaxed">
                {{ $subtitle }}
            </p>
        </div>

        <!-- 3 Brand Branches Showcase -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($branches as $b)
                <div id="{{ $b['id'] }}" class="plat-glass rounded-3xl overflow-hidden border border-white/10 plat-card-hover flex flex-col group scroll-mt-28">
                    <div class="relative h-64 w-full img-zoom-container overflow-hidden">
                        <img src="{{ $b['image'] }}"
                             alt="{{ $b['name'] }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold text-stone-950 bg-[#C5A265] shadow-lg">
                                {{ $b['num'] }}
                            </span>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="text-[11px] font-semibold text-[#DFCA9B] uppercase tracking-wider block">
                                {{ $b['tag'] }}
                            </span>
                            <h3 class="font-serif-heading text-xl font-bold text-white">
                                {{ $b['name'] }}
                            </h3>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <p class="text-xs sm:text-sm text-stone-300 leading-relaxed font-light">
                            {{ $b['desc'] }}
                        </p>

                        <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                            <span class="flex items-center gap-1.5 text-stone-400 truncate max-w-[200px]">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C5A265] shrink-0"></i>
                                <span class="truncate">{{ $b['locations'] }}</span>
                            </span>

                            <a href="{{ $b['link'] }}" class="text-[#DFCA9B] font-bold hover:text-white uppercase tracking-wider text-[11px] inline-flex items-center gap-1">
                                <span>Details</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
