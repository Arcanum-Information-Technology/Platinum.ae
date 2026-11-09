@props(['data' => []])

@php
    $title = data_get($data, 'title', 'Platinum Hospitality Management');
    $description = data_get($data, 'description', 'Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts. As a trusted partner in the hospitality industry, we specialize in delivering refined culinary experiences supported by strong operational expertise and sustainable growth strategies.');
    $ceoBadge = data_get($data, 'ceo_badge', 'CEO & Founder PLATINUM HOSPITALITY');
    $image = data_get($data, 'image', 'images/platinum/dishes/vegetarian-sandwich-panini-with-spinach-leaves-tomatoes-and-cheese.jpg');
    $imageUrl = asset($image);
@endphp

<section class="py-20 sm:py-28 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Content Left -->
            <div class="lg:col-span-7 space-y-6">
                <span class="gold-badge">Leadership Heritage</span>
                <h2 class="font-serif-heading text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    {{ $title }}
                </h2>

                <p class="text-stone-300 text-base sm:text-lg leading-relaxed font-light">
                    {{ $description }}
                </p>

                <div class="plat-glass-gold p-6 sm:p-8 rounded-2xl border border-[#C5A265]/35 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#C5A265]/20 text-[#DFCA9B] flex items-center justify-center font-serif-heading font-bold">
                            PH
                        </div>
                        <div>
                            <span class="font-serif-heading font-bold text-white text-base block">Executive Vision</span>
                            <span class="text-xs uppercase tracking-wider text-[#C5A265] font-semibold">{{ $ceoBadge }}</span>
                        </div>
                    </div>
                    <blockquote class="text-sm italic text-stone-200 leading-relaxed border-l-2 border-[#C5A265] pl-4">
                        “We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.”
                    </blockquote>
                </div>
            </div>

            <!-- Image Right -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-3xl overflow-hidden plat-glass p-3 shadow-2xl border border-white/10 img-zoom-container aspect-[4/3]">
                    <img src="{{ $imageUrl }}"
                         alt="Platinum Hospitality Signature Dish"
                         class="w-full h-full object-cover rounded-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 p-3 rounded-xl plat-glass backdrop-blur-md text-xs text-[#DFCA9B]">
                        Artisanal Panini with spinach leaves, tomatoes & melted cheese
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

