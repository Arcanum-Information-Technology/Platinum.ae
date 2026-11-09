@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Leadership & Culinary Masters');
    $title = data_get($data, 'title', 'Meet Our Founders');
    $subtitle = data_get($data, 'subtitle', 'PLATINUM HOSPITALITY');

    $members = [
        [
            'name' => 'Aroldo De Marco',
            'role' => 'Founder & Chef',
            'bio' => 'Visionary restaurateur and culinary master behind the foundation of Platinum Hospitality, orchestrating world-class dining standards across the UAE.',
            'image' => asset('images/platinum/team/aroldo-de-marco.jpg'),
        ],
        [
            'name' => 'Quetzalli Antonio',
            'role' => 'Co - Founder & Chef',
            'bio' => 'Renowned culinary innovator and master patisserie artisan, steering concept innovation, recipe precision, and guest experience.',
            'image' => asset('images/platinum/team/quetzalli-antonio.jpg'),
        ],
        [
            'name' => 'Jovanni Scutari',
            'role' => 'Head Chef',
            'bio' => 'Leading executive kitchen operations, menu architecture, and culinary execution across all three portfolio brand kitchens.',
            'image' => asset('images/platinum/team/jovanni-scutari.jpg'),
        ],
        [
            'name' => 'Edda Rivera',
            'role' => 'HR Manager',
            'bio' => 'Directing hospitality talent acquisition, cultural alignment, customer service excellence, and corporate human resources.',
            'image' => asset('images/platinum/team/edda-rivera.jpg'),
        ],
    ];
@endphp

<section class="py-24 sm:py-32 bg-[#070708] relative overflow-hidden border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-2">
                {{ $title }}
            </h2>
            <p class="text-xs uppercase tracking-widest text-[#DFCA9B] font-bold mb-4">
                {{ $subtitle }}
            </p>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto"></div>
        </div>

        <!-- 4 Team Members Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($members as $m)
                <div class="plat-glass rounded-3xl overflow-hidden border border-white/10 plat-card-hover flex flex-col text-center group">
                    <div class="relative aspect-square w-full img-zoom-container overflow-hidden">
                        <img src="{{ $m['image'] }}"
                             alt="{{ $m['name'] }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors mb-1">
                                {{ $m['name'] }}
                            </h3>
                            <span class="text-xs uppercase tracking-wider text-[#C5A265] font-semibold block mb-3">
                                {{ $m['role'] }}
                            </span>
                            <p class="text-xs text-stone-400 font-light leading-relaxed">
                                {{ $m['bio'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

