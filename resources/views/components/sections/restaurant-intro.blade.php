@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $desc = $data['description'] ?? null;
    $image = $data['image'] ?? null;
    $expYears = $data['experience_years'] ?? null;
    $expText = $data['experience_text'] ?? null;
    $signature = $data['signature'] ?? null;
@endphp

<section class="py-24 bg-stone-950 relative overflow-hidden border-t border-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            <!-- Left Image Collage -->
            <div class="lg:col-span-6 relative">
                @if($image)
                    <div class="relative rounded-3xl overflow-hidden border border-stone-800 shadow-2xl shadow-black/80 aspect-[4/5] sm:aspect-[4/3] lg:aspect-[4/5]">
                        <img src="{{ $image }}"
                             alt="{{ $title ?? '' }}"
                             loading="lazy"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/80 via-transparent to-transparent"></div>
                    </div>
                @endif

                <!-- Floating Experience Card -->
                @if(!empty(trim($expYears ?? '')) || !empty(trim($expText ?? '')))
                    <div class="absolute -bottom-6 -right-4 sm:bottom-8 sm:-right-6 bg-stone-900/95 border border-amber-500/30 p-6 rounded-2xl shadow-2xl backdrop-blur-md max-w-xs">
                        @if(!empty(trim($expYears ?? '')))
                            <div class="font-serif-heading text-4xl sm:text-5xl font-extrabold text-amber-400">
                                {{ $expYears }}
                            </div>
                        @endif
                        @if(!empty(trim($expText ?? '')))
                            <p class="text-xs sm:text-sm text-stone-300 font-medium mt-1 leading-snug">
                                {{ $expText }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Right Story Content -->
            <div class="lg:col-span-6 space-y-6">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        <span>{{ $badge }}</span>
                    </div>
                @endif

                @if(!empty(trim($title ?? '')) || !empty(trim($desc ?? '')))
                    @if(!empty(trim($title ?? '')))
                        <h2 class="font-serif-heading text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                            {{ $title }}
                        </h2>
                    @endif

                    @if(!empty(trim($desc ?? '')))
                        <p class="text-stone-300 text-base sm:text-lg leading-relaxed font-light">
                            {{ $desc }}
                        </p>
                    @endif
                @endif

                <div class="grid grid-cols-2 gap-6 pt-4 border-t border-stone-800">
                    <div>
                        <h4 class="font-serif-heading text-lg font-semibold text-white mb-1">Organic Sourcing</h4>
                        <p class="text-xs text-stone-400 leading-relaxed">Direct daily partnerships with biodynamic California growers.</p>
                    </div>
                    <div>
                        <h4 class="font-serif-heading text-lg font-semibold text-white mb-1">Time-Honored Alchemy</h4>
                        <p class="text-xs text-stone-400 leading-relaxed">Stone-ground aromatic spices and 48-hour slow fermentations.</p>
                    </div>
                </div>

                @if(!empty(trim($signature ?? '')))
                    <div class="pt-4 flex items-center justify-between">
                        <div>
                            <span class="block font-serif text-2xl text-amber-400 italic">
                                {{ $signature }}
                            </span>
                            <span class="text-xs text-stone-400 uppercase tracking-widest">Executive Chef & Founder</span>
                        </div>
                        <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-stone-300 hover:text-amber-400 transition-colors">
                            <span>Read Full Story</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-amber-500"></i>
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
</section>
