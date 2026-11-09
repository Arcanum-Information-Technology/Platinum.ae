@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Culinary Excellence Across The UAE');
    $title = data_get($data, 'title', 'Platinum Hospitality Management');
    $subtitle = data_get($data, 'subtitle', 'Your strategic partner in culinary excellence, delivering world-class hospitality solutions through quality, efficiency, and sustainable growth.');
    $ctaText = data_get($data, 'cta_text', 'Discover Our Brands');
    $ctaLink = data_get($data, 'cta_link', '#our-brands');
    $cta2Text = data_get($data, 'cta2_text', 'Book Table Online');
    $cta2Link = data_get($data, 'cta2_link', '#book-table');
    $heroImage = data_get($data, 'hero_image', 'images/platinum/hero/platinum-hero.jpg');
    $heroUrl = asset($heroImage);
@endphp

<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden py-24 sm:py-32">
    <!-- Background Image with Parallax & Dark Film -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $heroUrl }}"
             alt="{{ $title }}"
             class="w-full h-full object-cover object-center scale-105 filter brightness-[0.4] contrast-[1.1] transition-transform duration-1000 ease-out">
        <!-- Dual Vignette & Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-[#0A0A0A]/40 to-[#0A0A0A]/80"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-transparent via-[#0A0A0A]/50 to-[#0A0A0A]"></div>
    </div>

    <!-- Ambient Gold Glow Accent -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-[#C5A265]/15 rounded-full blur-[160px] pointer-events-none z-0"></div>

    <!-- Hero Content Container -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 text-center animate-fade-in">

        <!-- Gold Pill Badge -->
        <div class="inline-block mb-6">
            <span class="gold-badge shadow-lg">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                <span>{{ $badge }}</span>
            </span>
        </div>

        <!-- Main Headline -->
        <h1 class="font-serif-heading text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
            Platinum Hospitality <br class="hidden sm:inline">
            <span class="text-gold-gradient">Management</span>
        </h1>

        <!-- Subtitle / Positioning -->
        <p class="max-w-3xl mx-auto text-base sm:text-lg md:text-xl text-stone-300 font-light leading-relaxed mb-10">
            {{ $subtitle }}
        </p>

        <!-- Call to Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 mb-16">
            <a href="{{ $ctaLink }}"
               class="btn-gold w-full sm:w-auto px-8 py-4 rounded-xl text-xs sm:text-sm font-bold inline-flex items-center justify-center gap-2.5">
                <span>{{ $ctaText }}</span>
                <i data-lucide="arrow-down" class="w-4 h-4"></i>
            </a>

            <a href="{{ $cta2Link }}"
               class="btn-outline-gold w-full sm:w-auto px-8 py-4 rounded-xl text-xs sm:text-sm font-semibold inline-flex items-center justify-center gap-2.5">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>{{ $cta2Text }}</span>
            </a>
        </div>

        <!-- Key Operational Numbers Strip -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 max-w-4xl mx-auto pt-8 border-t border-white/10 plat-glass rounded-2xl p-6">
            <div class="text-center p-2">
                <span class="font-serif-heading text-2xl sm:text-3xl font-bold text-white block">3 Signature</span>
                <span class="text-[11px] uppercase tracking-wider text-[#DFCA9B] font-semibold">Dining Brands</span>
            </div>
            <div class="text-center p-2 border-l border-white/10">
                <span class="font-serif-heading text-2xl sm:text-3xl font-bold text-white block">20+</span>
                <span class="text-[11px] uppercase tracking-wider text-[#DFCA9B] font-semibold">Years Experience</span>
            </div>
            <div class="text-center p-2 border-l border-white/10">
                <span class="font-serif-heading text-2xl sm:text-3xl font-bold text-white block">UAE & GCC</span>
                <span class="text-[11px] uppercase tracking-wider text-[#DFCA9B] font-semibold">Prime Locations</span>
            </div>
            <div class="text-center p-2 border-l border-white/10">
                <span class="font-serif-heading text-2xl sm:text-3xl font-bold text-white block">98%</span>
                <span class="text-[11px] uppercase tracking-wider text-[#DFCA9B] font-semibold">Guest Satisfaction</span>
            </div>
        </div>

    </div>
</section>

