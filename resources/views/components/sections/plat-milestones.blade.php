@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Our Historical Trajectory');
    $title = data_get($data, 'title', 'Milestones That Define Us');
    $subtitle = data_get($data, 'subtitle', 'From artisanal beginnings to regional multi-brand hospitality leadership.');
    $timeline = data_get($data, 'timeline', [
        [
            'year' => '1989',
            'title' => 'Foundation of Hospitality Vision',
            'desc' => 'The roots of our hospitality journey began with a passion for culinary excellence and guest experience, laying the groundwork for future brand development.',
        ],
        [
            'year' => '1998',
            'title' => 'Expansion into Multi-Concept Dining',
            'desc' => 'We expanded operations by introducing diverse restaurant concepts, strengthening operational systems and brand positioning.',
        ],
        [
            'year' => '2007',
            'title' => 'Operational Excellence & Brand Recognition',
            'desc' => 'Our management frameworks matured, earning recognition for quality standards, operational consistency, and hospitality innovation.',
        ],
        [
            'year' => '2017',
            'title' => 'Portfolio Growth & Regional Expansion',
            'desc' => 'We scaled our brand portfolio, managing multiple hospitality ventures and expanding our presence across key markets.',
        ],
    ]);
@endphp

<section class="py-24 sm:py-32 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $title }}
            </h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-stone-300 text-base sm:text-lg font-light leading-relaxed">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Timeline Vertical Tree -->
        <div class="relative border-l-2 border-[#C5A265]/40 ml-4 sm:ml-32 space-y-12">
            @foreach($timeline as $item)
                <div class="relative pl-8 sm:pl-12 group">

                    <!-- Year Marker on Left -->
                    <div class="hidden sm:block absolute -left-32 top-0 text-right w-24">
                        <span class="font-serif-heading text-2xl font-bold text-[#DFCA9B] block">
                            {{ $item['year'] }}
                        </span>
                        <span class="text-[10px] uppercase tracking-wider text-stone-500 font-bold">Chapter</span>
                    </div>

                    <!-- Glowing Node on Timeline Line -->
                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-[#C5A265] border-4 border-[#0A0A0A] shadow-md group-hover:scale-125 transition-transform duration-300"></div>

                    <!-- Card Body -->
                    <div class="plat-glass rounded-2xl p-6 sm:p-8 border border-white/10 plat-card-hover">
                        <span class="sm:hidden font-serif-heading text-xl font-bold text-[#DFCA9B] block mb-1">
                            {{ $item['year'] }}
                        </span>
                        <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors mb-2">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-sm text-stone-300 leading-relaxed font-light">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

