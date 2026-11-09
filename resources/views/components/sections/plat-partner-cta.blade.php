@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Strategic Collaboration');
    $title = data_get($data, 'title', 'Partner With Platinum Hospitality Management');
    $subtitle = data_get($data, 'subtitle', 'Building Strong Hospitality Brands Together');
    $description = data_get($data, 'description', 'Platinum Hospitality Management collaborates with investors, property owners, and hospitality entrepreneurs to develop, manage, and scale successful food and beverage concepts with long-term value.');
    $footerQuote = data_get($data, 'footer_quote', 'Driving Growth Through Strategic Hospitality Management. Built on experience. Driven by performance.');
    $ctaText = data_get($data, 'cta_text', 'Start A Conversation');
    $ctaLink = data_get($data, 'cta_link', '/contact');
    $rawBg = data_get($data, 'bg_image', 'images/platinum/hero/platinum-hero.jpg');
    $bgImage = \App\Support\AssetUrl::make($rawBg);
@endphp

<section class="py-24 sm:py-32 bg-[#070708] relative overflow-hidden border-t border-white/5">
    <!-- Ambient Gold Glow Backing -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] bg-[#C5A265]/10 rounded-full blur-[180px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Luxury Glass Card Container with Cinematic Backdrop -->
        <div class="relative rounded-3xl overflow-hidden p-10 sm:p-16 lg:p-20 text-center border border-[#C5A265]/40 shadow-[0_25px_70px_-15px_rgba(0,0,0,0.9)]">

            <!-- Background Image with Gradient Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $bgImage }}"
                     alt="Partner With Platinum Hospitality"
                     class="w-full h-full object-cover scale-105 animate-[floatSlow_14s_ease-in-out_infinite_alternate]">
                <!-- Multi-layer gradient for readability and luxury tone -->
                <div class="absolute inset-0 bg-gradient-to-b from-[#0A0A0A]/90 via-[#0A0A0A]/80 to-[#0A0A0A]/95"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-[#C5A265]/10 via-black/40 to-[#0A0A0A]/90"></div>
            </div>

            <!-- Content Area (Elevated Z-Index) -->
            <div class="relative z-10 max-w-3xl mx-auto">
                <span class="gold-badge mb-5 inline-flex items-center gap-2">
                    <i data-lucide="handshake" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                    <span>{{ $badge }}</span>
                </span>

                <h2 class="font-serif-heading text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight mb-4 drop-shadow-md">
                    {{ $title }}
                </h2>

                <p class="text-xs sm:text-sm uppercase tracking-widest text-[#DFCA9B] font-bold mb-6 font-serif-heading">
                    {{ $subtitle }}
                </p>

                <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-6"></div>

                <p class="max-w-2xl mx-auto text-stone-200 text-base sm:text-lg font-light leading-relaxed mb-10 drop-shadow">
                    {{ $description }}
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
                    <a href="{{ $ctaLink }}" class="btn-gold px-8 py-4 rounded-xl text-sm font-bold inline-flex items-center gap-2 shadow-xl hover:scale-105 transition-transform">
                        <span>{{ $ctaText }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>

                    <a href="{{ url('/franchise') }}" class="btn-outline-gold px-8 py-4 rounded-xl text-sm font-semibold inline-flex items-center gap-2 backdrop-blur-md hover:scale-105 transition-transform">
                        <i data-lucide="briefcase" class="w-4 h-4"></i>
                        <span>Franchise Opportunities</span>
                    </a>
                </div>

                <!-- Footer Quote Tag -->
                <div class="pt-8 border-t border-white/15 max-w-xl mx-auto">
                    <p class="text-xs sm:text-sm italic text-[#DFCA9B] font-serif-heading">
                        “{{ $footerQuote }}”
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>
