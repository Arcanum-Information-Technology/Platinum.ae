@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Guest & Partner Trust');
    $title = data_get($data, 'title', 'Our Clients Say');
    $subtitle = data_get($data, 'subtitle', 'Testimonials from discerning diners, investors, and long-term hospitality partners.');
    $testimonials = data_get($data, 'testimonials', collect());

    $defaultTestimonials = [
        [
            'name' => 'Sophie Laurent',
            'role' => 'Customer & Hospitality Partner',
            'tag' => 'Brand Operations',
            'location' => 'Dubai, UAE',
            'content' => 'Working with Platinum Hospitality Management has streamlined our operations and elevated brand standards. Their strategic approach makes them a trusted hospitality partner.',
            'avatar' => 'images/platinum/testimonials/sophie-laurent.jpg',
            'rating' => 5,
        ],
        [
            'name' => 'Eveline Gagneux',
            'role' => 'Customer & Regular Patron',
            'tag' => 'Dining Experience',
            'location' => 'Abu Dhabi, UAE',
            'content' => 'Platinum Hospitality Management brings structure, consistency, and strategic clarity. Their operational expertise has significantly strengthened our brand performance and long-term growth.',
            'avatar' => 'images/platinum/testimonials/eveline-gagneux.jpg',
            'rating' => 5,
        ],
        [
            'name' => 'Ahmed Al Mansoori',
            'role' => 'Customer & Investment Partner',
            'tag' => 'Strategic Growth',
            'location' => 'UAE Flagship',
            'content' => 'A highly professional team with deep industry knowledge. Platinum Hospitality Management delivers efficient systems, reliable execution, and sustainable growth across hospitality operations.',
            'avatar' => 'images/platinum/testimonials/ahmed-al-mansoori.jpg',
            'rating' => 5,
        ],
    ];

    $items = $testimonials->isNotEmpty() ? $testimonials->map(function($t) {
        return [
            'name' => $t->customer_name,
            'role' => $t->customer_role ?? 'Customer',
            'tag' => 'Verified Partner',
            'location' => 'United Arab Emirates',
            'content' => $t->content,
            'avatar' => !empty($t->avatar) ? $t->avatar : 'images/platinum/testimonials/sophie-laurent.jpg',
            'rating' => $t->rating ?? 5,
        ];
    })->toArray() : $defaultTestimonials;

    foreach ($items as &$item) {
        $item['avatar_url'] = \App\Support\AssetUrl::make($item['avatar']);
    }
    unset($item);
@endphp

<section class="py-24 sm:py-32 bg-[#080809] relative overflow-hidden border-t border-white/5"
         x-data="{
             active: 0,
             total: {{ count($items) }},
             autoplayTimer: null,
             startAutoplay() {
                 this.autoplayTimer = setInterval(() => {
                     this.next();
                 }, 7000);
             },
             stopAutoplay() {
                 if (this.autoplayTimer) clearInterval(this.autoplayTimer);
             },
             next() { this.active = (this.active + 1) % this.total; },
             prev() { this.active = (this.active - 1 + this.total) % this.total; }
         }"
         x-init="startAutoplay()"
         @mouseenter="stopAutoplay()"
         @mouseleave="startAutoplay()">

    <!-- Ambient Luxury Gold Lights -->
    <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[650px] h-[350px] bg-[#C5A265]/10 rounded-full blur-[160px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-10 w-80 h-80 bg-[#C5A265]/5 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $title }}
            </h2>
            <div class="w-24 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-stone-300 text-base sm:text-lg font-light leading-relaxed font-serif-heading italic">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Main Testimonial Showcase Box -->
        <div class="relative max-w-4xl mx-auto">

            <!-- Decorative Watermark Quotation Mark Behind -->
            <div class="absolute -top-12 left-6 text-[#C5A265]/10 font-serif-heading text-[140px] leading-none select-none pointer-events-none font-bold">
                “
            </div>

            <!-- Card Slides -->
            <div class="relative min-h-[380px] sm:min-h-[340px]">
                @foreach($items as $idx => $item)
                    <div x-show="active === {{ $idx }}"
                         x-transition:enter="transition ease-out duration-400"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200 absolute inset-0"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="bg-gradient-to-b from-[#141416]/95 to-[#0D0D0E]/95 p-8 sm:p-12 lg:p-14 rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.8)] border border-[#C5A265]/35 backdrop-blur-xl relative">

                        <!-- Top Row: Verified Badge & Star Rating -->
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-white/10">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider text-[#DFCA9B] bg-[#C5A265]/15 border border-[#C5A265]/30 inline-flex items-center gap-1.5">
                                    <i data-lucide="award" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                                    <span>{{ $item['tag'] }}</span>
                                </span>
                                <span class="text-xs text-stone-400 hidden sm:inline">• {{ $item['location'] }}</span>
                            </div>

                            <!-- 5 Stars with Gold Glow -->
                            <div class="flex items-center gap-1.5 text-[#C5A265]" aria-label="5 out of 5 stars">
                                @for($i = 0; $i < $item['rating']; $i++)
                                    <svg class="w-4 h-4 fill-current drop-shadow-[0_0_6px_rgba(197,162,101,0.6)]" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <!-- Quote Text -->
                        <blockquote class="font-serif-heading text-lg sm:text-2xl text-stone-100 font-medium italic leading-relaxed mb-8">
                            “{{ $item['content'] }}”
                        </blockquote>

                        <!-- Author Profile Info -->
                        <div class="flex items-center justify-between gap-4 pt-6 border-t border-white/10">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $item['avatar_url'] }}"
                                         alt="{{ $item['name'] }}"
                                         class="w-14 h-14 rounded-full object-cover border-2 border-[#C5A265] shadow-[0_0_15px_rgba(197,162,101,0.3)] shrink-0">
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-[#C5A265] text-stone-950 flex items-center justify-center text-[10px] shadow">
                                        <i data-lucide="check" class="w-3 h-3 stroke-[3]"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="font-serif-heading text-xl font-bold text-white leading-tight">
                                        {{ $item['name'] }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-[#DFCA9B] font-medium tracking-wide">
                                        {{ $item['role'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Slide Number Indicator -->
                            <div class="text-right text-xs font-mono text-stone-400">
                                <span class="text-[#C5A265] font-bold text-sm">0{{ $idx + 1 }}</span> / 0{{ count($items) }}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Client Selector Navigation Thumbnails -->
            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-6">

                <!-- Interactive Client Avatar Tabs -->
                <div class="flex items-center gap-3">
                    @foreach($items as $idx => $item)
                        <button type="button"
                                @click="active = {{ $idx }}"
                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-2xl border transition-all text-left"
                                :class="active === {{ $idx }} ? 'bg-[#C5A265]/20 border-[#C5A265] text-white shadow-lg' : 'bg-white/5 border-white/10 text-stone-400 hover:border-white/25 hover:text-stone-200'">
                            <img src="{{ $item['avatar_url'] }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-7 h-7 rounded-full object-cover transition-transform"
                                 :class="active === {{ $idx }} ? 'scale-110 ring-2 ring-[#C5A265]' : 'opacity-70'">
                            <span class="text-xs font-semibold whitespace-nowrap">{{ $item['name'] }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Next / Previous Arrow Controls -->
                <div class="flex items-center gap-3">
                    <button type="button"
                            @click="prev()"
                            class="w-10 h-10 rounded-full bg-white/5 border border-white/15 text-stone-300 hover:text-white hover:border-[#C5A265] hover:bg-[#C5A265]/20 flex items-center justify-center transition-all shadow-md active:scale-95"
                            aria-label="Previous Testimonial">
                        <i data-lucide="chevron-left" class="w-5 h-5 text-[#C5A265]"></i>
                    </button>

                    <button type="button"
                            @click="next()"
                            class="w-10 h-10 rounded-full bg-white/5 border border-white/15 text-stone-300 hover:text-white hover:border-[#C5A265] hover:bg-[#C5A265]/20 flex items-center justify-center transition-all shadow-md active:scale-95"
                            aria-label="Next Testimonial">
                        <i data-lucide="chevron-right" class="w-5 h-5 text-[#C5A265]"></i>
                    </button>
                </div>

            </div>

        </div>

    </div>
</section>
