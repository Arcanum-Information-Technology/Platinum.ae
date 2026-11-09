@props(['data' => []])

@php
    $heading = data_get($data, 'heading', 'Our Special Menu');
    $subheading = data_get($data, 'subheading', 'A Timeless Dining Experience, Reimagined for Modern Hospitality');
    $description = data_get($data, 'description', '');
    $managementStatement = data_get($data, 'management_statement', '');
    $rawImage = data_get($data, 'image', 'images/platinum/brands/shakespeare.jpg');
    $image = \App\Support\AssetUrl::make($rawImage);
    $location = data_get($data, 'location', 'United Arab Emirates');
    $features = data_get($data, 'features', [
        'Artisanal Recipes & Handcrafted Techniques',
        'Immersive Cultural Interior Aesthetics',
        'Standardized Operational Consistency',
        'Managed by Platinum Hospitality Management',
    ]);
@endphp

<section id="brand-story" class="py-24 sm:py-32 bg-[#0A0A0A] relative overflow-hidden">
    <!-- Ambient Light -->
    <div class="absolute top-1/3 left-0 w-80 h-80 bg-[#C5A265]/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            <!-- Left Column: Content Narrative (7 cols on lg) -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="gold-badge mb-3">Concept Profile</span>
                    <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                        {{ $heading }}
                    </h2>
                    <p class="text-base sm:text-lg text-[#DFCA9B] font-serif-heading italic">
                        {{ $subheading }}
                    </p>
                </div>

                <!-- Main Narrative Text -->
                <div class="text-stone-300 text-sm sm:text-base leading-relaxed font-light space-y-4">
                    <p>{{ $description }}</p>
                </div>

                <!-- Platinum Management Statement Box -->
                @if(!empty($managementStatement))
                    <div class="plat-glass-gold p-6 sm:p-7 rounded-2xl border border-[#C5A265]/40 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#C5A265]">
                            <i data-lucide="shield-check" class="w-4 h-4 text-[#C5A265]"></i>
                            <span>Hospitality Management Governance</span>
                        </div>
                        <p class="text-xs sm:text-sm text-stone-200 leading-relaxed font-light">
                            {{ $managementStatement }}
                        </p>
                    </div>
                @endif

                <!-- Features Bullets -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
                    @foreach($features as $feat)
                        <div class="flex items-center gap-3 text-xs sm:text-sm text-stone-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-gradient-to-tr from-[#C5A265] to-[#DFCA9B] shadow-[0_0_8px_rgba(197,162,101,0.7)] shrink-0"></span>
                            <span>{{ $feat }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a href="#book-table" class="btn-gold px-7 py-3 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                        <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i>
                        <span>Book A Table</span>
                    </a>
                    <a href="{{ url('/franchise') }}" class="btn-outline-gold px-7 py-3 rounded-xl text-xs font-semibold inline-flex items-center gap-2">
                        <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                        <span>Franchise Inquiry</span>
                    </a>
                </div>
            </div>

            <!-- Right Column: Visual Showcase (5 cols on lg) -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-3xl overflow-hidden border border-[#C5A265]/30 shadow-2xl group">
                    <div class="img-zoom-container aspect-[4/5] w-full">
                        <img src="{{ $image }}"
                             alt="{{ $heading }}"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    <!-- Floating Badge -->
                    <div class="absolute top-5 right-5">
                        <span class="px-3.5 py-1.5 rounded-full text-[11px] font-bold text-stone-950 bg-gradient-to-r from-[#DFCA9B] to-[#C5A265] shadow-xl uppercase tracking-wider">
                            Platinum Concept
                        </span>
                    </div>

                    <!-- Bottom Caption -->
                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <div class="flex items-center gap-2 text-xs text-stone-300 mb-1">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                            <span>{{ $location }}</span>
                        </div>
                        <h4 class="font-serif-heading text-lg font-bold">Signature Hospitality Experience</h4>
                    </div>
                </div>

                <!-- Secondary floating card -->
                <div class="absolute -bottom-6 -left-6 plat-glass-gold p-4 rounded-2xl border border-[#C5A265]/40 shadow-2xl hidden sm:flex items-center gap-3 max-w-xs">
                    <div class="w-10 h-10 rounded-xl bg-[#C5A265] text-stone-950 flex items-center justify-center font-bold text-sm shrink-0">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    <div class="text-xs">
                        <span class="font-bold text-white block">Curated Excellence</span>
                        <span class="text-stone-300 text-[11px]">Uncompromising quality standards</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

