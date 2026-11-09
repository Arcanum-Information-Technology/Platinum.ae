@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Signature Portfolio');
    $title = data_get($data, 'title', 'OUR BRANDS');
    $subtitle = data_get($data, 'subtitle', 'Discover our restaurant locations across the region, each offering the same signature experience.');
    $categories = data_get($data, 'categories', collect());

    // If categories is empty or null, provide rich defaults matching the 3 brands
    $brandsData = [
        [
            'id' => 'shakespeare',
            'num' => '1.',
            'name' => 'Shakespeare Middle East',
            'tagline' => 'Victorian Charm, Cafe, Restaurant & Patisserie',
            'desc' => 'A timeless sanctuary of European elegance and whimsical nostalgia. Known for exquisite handcrafted French pastries, all-day artisanal breakfast, gourmet mains, and warm convivial hospitality in opulent Victorian settings.',
            'image' => asset('images/platinum/brands/shakespeare.jpg'),
            'cuisine' => 'European & French Patisserie',
            'features' => ['Bespoke Afternoon Tea', 'Artisan Viennoiserie', 'Victorian Ambience', 'Signature Catering'],
            'url' => url('/brands/shakespeare-middle-east'),
            'cta' => 'Discover Shakespeare',
        ],
        [
            'id' => 'otantik',
            'num' => '2.',
            'name' => 'Otantik Café & Restaurant',
            'tagline' => 'Middle Eastern & Mediterranean Dining, Shisha Lounge',
            'desc' => 'A vibrant celebration of authentic Levant and Arabian culinary artistry. Featuring premium lumpwood charcoal grills, succulent kebabs, slow-simmered regional stews, handcrafted mezze, and a luxury twilight shisha terrace.',
            'image' => asset('images/platinum/brands/otantik.jpg'),
            'cuisine' => 'Middle Eastern & Charcoal Grills',
            'features' => ['Live Charcoal Grills', 'Velvety Handcrafted Mezze', 'Luxury Shisha Lounge', 'Panoramic Terrace'],
            'url' => url('/brands/otantik-cafe-restaurant'),
            'cta' => 'Explore Otantik',
        ],
        [
            'id' => 'chinese-connection',
            'num' => '3.',
            'name' => 'Chinese Connection',
            'tagline' => 'Contemporary Asian & Gourmet Wok Cuisines',
            'desc' => 'A sleek, sensory journey into modern pan-Asian and authentic Chinese gastronomy. Experience steaming handmade dim sum baskets, roaring wok-hei stir fries, crispy duck, and bold Szechuan and Cantonese flavor profiles.',
            'image' => asset('images/platinum/brands/chinese-connection.jpg'),
            'cuisine' => 'Contemporary Pan-Asian & Dim Sum',
            'features' => ['Steamed Crystal Dim Sum', 'Authentic Wok-Hei Cooking', 'Private Dining Rooms', 'Handcrafted Mocktails'],
            'url' => url('/brands/chinese-connection'),
            'cta' => 'Experience Chinese Connection',
        ],
    ];
@endphp

<section id="our-brands" class="py-24 sm:py-32 bg-[#0A0A0A] relative overflow-hidden">
    <!-- Ambient Lighting -->
    <div class="absolute top-1/2 left-0 w-80 h-80 bg-[#C5A265]/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#C5A265]/10 rounded-full blur-[160px] pointer-events-none"></div>

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

        <!-- Brands Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($brandsData as $brand)
                <div id="{{ $brand['id'] }}" class="plat-glass rounded-3xl overflow-hidden plat-card-hover flex flex-col border border-white/10 group">

                    <!-- Brand Image Box -->
                    <div class="relative h-64 sm:h-72 w-full img-zoom-container overflow-hidden">
                        <img src="{{ $brand['image'] }}"
                             alt="{{ $brand['name'] }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#141416] via-[#141416]/30 to-transparent"></div>

                        <!-- Brand Order Number Pill -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-serif-heading font-bold text-[#0A0A0A] bg-gradient-to-r from-[#DFCA9B] to-[#C5A265] shadow-lg">
                                {{ $brand['num'] }}
                            </span>
                        </div>

                        <!-- Cuisine Tag -->
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-white bg-black/70 backdrop-blur-md border border-white/20">
                                {{ $brand['cuisine'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Details -->
                    <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between space-y-6">
                        <div>
                            <h3 class="font-serif-heading text-2xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors mb-2">
                                {{ $brand['name'] }}
                            </h3>
                            <p class="text-xs uppercase tracking-wider text-[#C5A265] font-semibold mb-4">
                                {{ $brand['tagline'] }}
                            </p>
                            <p class="text-sm text-stone-300 leading-relaxed font-light mb-6">
                                {{ $brand['desc'] }}
                            </p>

                            <!-- Feature Tags -->
                            <div class="grid grid-cols-2 gap-2.5 pt-3 border-t border-white/10">
                                @foreach($brand['features'] as $feat)
                                    <div class="flex items-center gap-2.5 text-xs text-stone-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gradient-to-tr from-[#C5A265] to-[#DFCA9B] shadow-[0_0_8px_rgba(197,162,101,0.6)] shrink-0"></span>
                                        <span class="truncate">{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                            <a href="{{ $brand['url'] }}"
                               class="text-xs font-bold uppercase tracking-wider text-[#DFCA9B] hover:text-white inline-flex items-center gap-2 group-hover:translate-x-1 transition-all">
                                <span>{{ $brand['cta'] }}</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 text-[#C5A265]"></i>
                            </a>

                            <a href="{{ url('/contact#book-table') }}"
                               class="btn-outline-gold text-[11px] px-3.5 py-1.5 rounded-lg">
                                Reserve
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

