@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Our Core Philosophy');
    $title = data_get($data, 'title', 'Where Hospitality Goes Beyond Food');
    $subtitle = data_get($data, 'subtitle', 'We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.');
    $quote = data_get($data, 'quote', 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.');
    $author = data_get($data, 'author', 'Platinum Hospitality Management Leadership');
@endphp

<section class="py-24 sm:py-32 relative overflow-hidden bg-[#070708] border-y border-white/5">
    <!-- Ambient Gold Radial Backdrop -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-[#C5A265]/15 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center">

        <span class="gold-badge mb-4">{{ $badge }}</span>

        <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-6">
            {{ $title }}
        </h2>

        <p class="text-base sm:text-lg text-stone-300 font-light max-w-3xl mx-auto leading-relaxed mb-12">
            {{ $subtitle }}
        </p>

        <!-- Signature Quote Card -->
        <div class="plat-glass-gold p-8 sm:p-14 rounded-3xl shadow-2xl relative max-w-4xl mx-auto border border-[#C5A265]/35">
            <!-- Decorative Gold Quote Icon -->
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#DFCA9B] to-[#C5A265] text-stone-950 flex items-center justify-center mx-auto mb-8 shadow-xl">
                <i data-lucide="quote" class="w-8 h-8 fill-current"></i>
            </div>

            <blockquote class="font-serif-heading text-xl sm:text-3xl font-medium text-white italic leading-relaxed mb-6">
                “{{ $quote }}”
            </blockquote>

            <div class="w-16 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>

            <p class="text-xs uppercase tracking-widest font-bold text-[#DFCA9B]">
                {{ $author }}
            </p>
        </div>

    </div>
</section>

