@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Partnership Ecosystem');
    $title = data_get($data, 'title', 'Your Franchise Journey Starts Here');
    $subtitle = data_get($data, 'subtitle', 'Comprehensive Support. Proven Systems.');
    $description = data_get($data, 'description', 'Platinum Hospitality Management provides end-to-end franchise support — from concept setup and operational training to marketing strategy and long-term business growth.');

    $pillars = [
        [
            'title' => 'Turnkey Architecture & Design',
            'desc' => 'Complete layout engineering, luxury interior design schematics, and equipment procurement tailored to your venue footprint.',
            'icon' => 'layout',
        ],
        [
            'title' => 'Centralized Supply Chain',
            'desc' => 'Direct access to verified international food suppliers, standardized ingredient bulk-pricing, and specialized packaging.',
            'icon' => 'truck',
        ],
        [
            'title' => 'Master Chef & Service Training',
            'desc' => 'Comprehensive front-of-house hospitality training, back-of-house culinary SOPs, and ongoing head chef certifications.',
            'icon' => 'award',
        ],
        [
            'title' => 'Omnichannel Marketing & CRM',
            'desc' => 'Regional brand campaigns, localized digital advertising, social media playbooks, and loyalty program integration.',
            'icon' => 'trending-up',
        ],
    ];
@endphp

<section class="py-24 sm:py-32 bg-[#0D0D0E] border-t border-white/5 relative overflow-hidden">
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
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-stone-300 text-base sm:text-lg font-light leading-relaxed">
                {{ $description }}
            </p>
        </div>

        <!-- 4 Support Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($pillars as $p)
                <div class="plat-glass rounded-3xl p-8 border border-white/10 plat-card-hover flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#C5A265]/15 border border-[#C5A265]/30 flex items-center justify-center text-[#DFCA9B] group-hover:scale-110 group-hover:bg-[#C5A265] group-hover:text-stone-950 transition-all duration-300">
                            <i data-lucide="{{ $p['icon'] }}" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors">
                            {{ $p['title'] }}
                        </h3>
                        <p class="text-xs sm:text-sm text-stone-300 leading-relaxed font-light">
                            {{ $p['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

