@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Company Overview');
    $title = data_get($data, 'title', 'Platinum Hospitality Management');
    $description = data_get($data, 'description', 'Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts. As a trusted partner in the hospitality industry, we specialize in delivering refined culinary experiences supported by strong operational expertise and sustainable growth strategies.');
    $ceoTitle = data_get($data, 'ceo_title', 'CEO & Founder PLATINUM HOSPITALITY');
    $imagePath = data_get($data, 'image', 'images/platinum/dishes/vegetarian-sandwich-panini-with-spinach-leaves-tomatoes-and-cheese.jpg');
    $imageUrl = asset($imagePath);
    $ctaText = data_get($data, 'cta_text', 'Connect With Us Anytime');
    $ctaLink = data_get($data, 'cta_link', '/contact');
    $inquiryHeading = data_get($data, 'inquiry_heading', 'Business & Partnership Inquiries');
    $inquiryText = data_get($data, 'inquiry_text', 'Reach out to Platinum Hospitality Management for brand partnerships, restaurant management solutions, and hospitality collaborations.');
@endphp

<section class="py-24 sm:py-32 bg-[#0D0D0E] relative overflow-hidden border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            <!-- Left: Visual Column with the Panini & Floating Luxury Cards -->
            <div class="lg:col-span-6 relative">
                <!-- Main Image Frame with Gold Accents -->
                <div class="relative rounded-3xl overflow-hidden plat-glass-gold p-3 shadow-2xl">
                    <div class="relative rounded-2xl overflow-hidden img-zoom-container aspect-[4/3]">
                        <img src="{{ $imageUrl }}"
                             alt="Artisanal Panini & Fine Dining Gastronomy"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                        <!-- Image Caption Tag -->
                        <div class="absolute bottom-4 left-4 right-4 p-4 rounded-xl plat-glass backdrop-blur-md">
                            <span class="text-xs font-serif-heading font-bold text-white block">
                                Artisanal Gastronomy & Culinary Precision
                            </span>
                            <span class="text-[11px] text-[#DFCA9B]">
                                Sourced from premier growers, crafted by master artisans
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Floating Experience Card -->
                <div class="hidden sm:block absolute -bottom-6 -right-6 p-6 rounded-2xl plat-glass shadow-2xl border border-[#C5A265]/40 animate-float max-w-xs">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#DFCA9B] to-[#C5A265] text-stone-950 flex items-center justify-center font-bold font-serif-heading text-xl shadow-lg shrink-0">
                            20+
                        </div>
                        <div>
                            <span class="text-xs uppercase font-bold tracking-wider text-white block">Years Experience</span>
                            <span class="text-[11px] text-stone-400 block">Leading F&B concepts across the UAE</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content & Partnership Inquiries -->
            <div class="lg:col-span-6 space-y-8">
                <div>
                    <span class="gold-badge mb-3">{{ $badge }}</span>
                    <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        {{ $title }}
                    </h2>
                    <p class="text-stone-300 text-base sm:text-lg leading-relaxed font-light mb-6">
                        {{ $description }}
                    </p>
                </div>

                <!-- CEO Quote Callout -->
                <div class="plat-glass p-6 rounded-2xl border-l-4 border-l-[#C5A265] space-y-3">
                    <p class="text-sm italic text-[#DFCA9B] leading-relaxed">
                        “Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.”
                    </p>
                    <div class="flex items-center justify-between pt-2 border-t border-white/5">
                        <span class="text-xs uppercase tracking-widest font-bold text-white">
                            {{ $ceoTitle }}
                        </span>
                        <span class="text-xs text-stone-400">Executive Leadership</span>
                    </div>
                </div>

                <!-- Business & Partnership Box -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#C5A265]/20 text-[#DFCA9B] flex items-center justify-center shrink-0">
                            <i data-lucide="handshake" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-serif-heading text-lg font-bold text-white">
                            {{ $inquiryHeading }}
                        </h4>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-300 leading-relaxed">
                        {{ $inquiryText }}
                    </p>
                    <div class="pt-2">
                        <a href="{{ $ctaLink }}" class="btn-gold text-xs px-6 py-3 rounded-xl inline-flex items-center gap-2">
                            <span>{{ $ctaText }}</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

