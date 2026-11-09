@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'The Platinum Standard');
    $title = data_get($data, 'title', 'Why Platinum Hospitality Management');
    $subtitle = data_get($data, 'subtitle', 'A trusted partner delivering excellence across every aspect of hospitality management.');
    $pillars = data_get($data, 'pillars', [
        [
            'title' => 'Operational Excellence',
            'desc' => 'Streamlined systems that ensure consistency, efficiency, and quality.',
            'icon' => 'gauge',
            'stat' => '99.4%',
            'stat_label' => 'System Efficiency',
        ],
        [
            'title' => 'Brand-Centric Approach',
            'desc' => 'Every concept retains its unique identity while benefiting from strong management.',
            'icon' => 'shield-check',
            'stat' => '3 Unique',
            'stat_label' => 'Brand Identities',
        ],
        [
            'title' => 'Proven Industry Expertise',
            'desc' => 'Decades of experience managing successful F&B brands.',
            'icon' => 'award',
            'stat' => '20+',
            'stat_label' => 'Years in F&B',
        ],
        [
            'title' => 'Scalable Growth Models',
            'desc' => 'Built for long-term expansion and sustainable profitability.',
            'icon' => 'trending-up',
            'stat' => '100%',
            'stat_label' => 'Sustainable Focus',
        ],
    ]);
@endphp

<section class="py-24 sm:py-32 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Section Header -->
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

        <!-- 4 Pillars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach($pillars as $index => $pillar)
                <div class="plat-glass rounded-3xl p-8 border border-white/10 plat-card-hover flex flex-col justify-between group">
                    <div class="space-y-6">
                        <!-- Icon Box with Gold Ring -->
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#DFCA9B]/20 to-[#C5A265]/10 border border-[#C5A265]/30 flex items-center justify-center text-[#DFCA9B] group-hover:scale-110 group-hover:bg-[#C5A265] group-hover:text-stone-950 transition-all duration-300 shadow-lg">
                            <i data-lucide="{{ $pillar['icon'] ?? 'check' }}" class="w-6 h-6"></i>
                        </div>

                        <div>
                            <span class="text-[10px] font-mono font-bold tracking-widest text-[#C5A265] uppercase block mb-1">
                                Pillar 0{{ $index + 1 }}
                            </span>
                            <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors mb-3">
                                {{ $pillar['title'] }}
                            </h3>
                            <p class="text-sm text-stone-300 leading-relaxed font-light">
                                {{ $pillar['desc'] }}
                            </p>
                        </div>
                    </div>

                    @if(!empty($pillar['stat']))
                        <div class="pt-6 mt-6 border-t border-white/5 flex items-baseline justify-between">
                            <span class="font-serif-heading text-2xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors">
                                {{ $pillar['stat'] }}
                            </span>
                            <span class="text-[11px] text-stone-400 uppercase tracking-wider">
                                {{ $pillar['stat_label'] ?? '' }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</section>

