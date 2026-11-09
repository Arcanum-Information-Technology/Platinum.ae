@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Connect With Platinum');
    $title = data_get($data, 'title', 'Get In Touch');
    $subtitle = data_get($data, 'subtitle', 'Business & Partnership Enquiries');
@endphp

<section class="relative py-20 sm:py-28 bg-[#0D0D0E] border-b border-white/10 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-[#C5A265]/10 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center">
        <nav class="flex items-center justify-center gap-2 text-xs uppercase tracking-wider text-stone-400 mb-6">
            <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
            <span class="text-[#C5A265]">•</span>
            <span class="text-[#DFCA9B] font-semibold">Contact Us</span>
        </nav>

        <span class="gold-badge mb-4">{{ $badge }}</span>

        <h1 class="font-serif-heading text-3xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight mb-4">
            {{ $title }}
        </h1>

        <p class="text-sm uppercase tracking-widest text-[#DFCA9B] font-semibold">
            {{ $subtitle }}
        </p>
    </div>
</section>

