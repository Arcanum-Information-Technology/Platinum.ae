@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Strategic Pillars');
    $title = data_get($data, 'title', 'Building Exceptional Hospitality Brands');
    $subtitle = data_get($data, 'subtitle', 'Where Hospitality Meets Strategic Excellence');
    $pillars = data_get($data, 'pillars', [
        [
            'title' => 'Operational Excellence',
            'desc' => 'Structured systems and proven processes that ensure consistency, efficiency, and service quality across every hospitality operation we manage.',
            'icon' => 'settings',
        ],
        [
            'title' => 'Brand Development',
            'desc' => 'We build strong hospitality identities through concept creation, positioning, and long-term brand growth strategies.',
            'icon' => 'sparkles',
        ],
        [
            'title' => 'Strategic Partnerships',
            'desc' => 'Collaborating with investors and property owners to create scalable, profitable hospitality ventures.',
            'icon' => 'users',
        ],
        [
            'title' => 'Sustainable Growth',
            'desc' => 'Focused on resource optimization, operational longevity, and environmentally responsible hospitality practices.',
            'icon' => 'leaf',
        ],
    ]);
@endphp

<section class="py-24 sm:py-32 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $title }}
            </h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-[#DFCA9B] text-base sm:text-lg font-semibold uppercase tracking-wider">
                {{ $subtitle }}
            </p>
        </div>

        <!-- 4 Strategic Pillars Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach($pillars as $p)
                <div class="plat-glass rounded-3xl p-8 border border-white/10 plat-card-hover flex flex-col justify-between group">
                    <div class="space-y-5">
                        <div class="w-12 h-12 rounded-2xl bg-[#C5A265]/15 border border-[#C5A265]/30 flex items-center justify-center text-[#DFCA9B] group-hover:bg-[#C5A265] group-hover:text-stone-950 transition-all duration-300">
                            <i data-lucide="{{ $p['icon'] ?? 'check' }}" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors">
                            {{ $p['title'] }}
                        </h3>
                        <p class="text-sm text-stone-300 leading-relaxed font-light">
                            {{ $p['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

