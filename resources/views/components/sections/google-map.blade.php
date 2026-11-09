@props(['data' => []])

@php
    $title = data_get($data, 'title');
    $subtitle = data_get($data, 'subtitle');
    $latitude = data_get($data, 'latitude', \App\Models\Setting::get('restaurant_latitude', '37.7749'));
    $longitude = data_get($data, 'longitude', \App\Models\Setting::get('restaurant_longitude', '-122.4194'));
    $zoom = data_get($data, 'zoom', '15');
    $address = data_get($data, 'address', \App\Models\Setting::get('restaurant_address', '124 Gourmet Boulevard, San Francisco, CA'));
    $embedUrl = data_get($data, 'embed_url', "https://maps.google.com/maps?q={$latitude},{$longitude}&z={$zoom}&output=embed");
    $directionsUrl = "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($address);
@endphp

<section class="py-16 sm:py-20 lg:py-24 bg-stone-900 border-t border-b border-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        @if(!empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-mono uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20">
                    Location & Directions
                </span>
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl font-extrabold text-white">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-sm text-stone-300">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <div class="relative rounded-3xl overflow-hidden border border-stone-800 shadow-2xl bg-stone-950 aspect-[16/9] md:aspect-[21/9]">
            <iframe
                src="{{ $embedUrl }}"
                width="100%"
                height="100%"
                style="border:0; filter: grayscale(85%) invert(90%) contrast(90%);"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="w-full h-full">
            </iframe>

            <!-- Overlay card with address and directions button -->
            <div class="absolute bottom-4 left-4 right-4 sm:right-auto sm:left-6 sm:bottom-6 bg-stone-950/90 backdrop-blur-md border border-stone-800/90 rounded-2xl p-4 sm:p-5 max-w-md shadow-2xl flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wider font-semibold text-amber-400">Our Address</p>
                    <p class="text-xs sm:text-sm text-stone-200 font-medium line-clamp-2">{{ $address }}</p>
                </div>
                <a href="{{ $directionsUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl text-xs font-semibold bg-amber-400 text-stone-950 hover:bg-amber-300 transition-colors shrink-0 flex items-center gap-1.5 shadow-md">
                    <i data-lucide="navigation" class="w-3.5 h-3.5"></i>
                    <span>Directions</span>
                </a>
            </div>
        </div>
    </div>
</section>
