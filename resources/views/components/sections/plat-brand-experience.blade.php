@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Signature Journey');
    $title = data_get($data, 'title', 'Experience the World of Shakespeare Middle East');
    $subtitle = data_get($data, 'subtitle', 'A Celebration of Heritage, Flavor, and Ambiance');
    $cards = data_get($data, 'cards', []);
@endphp

<section class="py-24 sm:py-32 bg-[#0D0D0E] relative overflow-hidden border-t border-white/5">
    <!-- Ambient Light -->
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#C5A265]/10 rounded-full blur-[160px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $title }}
            </h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-stone-300 text-base sm:text-lg font-light leading-relaxed font-serif-heading italic">
                {{ $subtitle }}
            </p>
        </div>

        <!-- 3 Highlights Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($cards as $card)
                @php
                    $cardImg = !empty($card['image']) ? \App\Support\AssetUrl::make($card['image']) : '';
                @endphp
                <div class="plat-glass rounded-3xl overflow-hidden border border-white/10 plat-card-hover flex flex-col group">
                    @if(!empty($cardImg))
                        <div class="relative h-60 w-full img-zoom-container overflow-hidden">
                            <img src="{{ $cardImg }}"
                                 alt="{{ $card['title'] }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#141416] via-transparent to-transparent"></div>
                            @if(!empty($card['tag']))
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-white bg-black/70 backdrop-blur-md border border-white/20">
                                        {{ $card['tag'] }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <i data-lucide="{{ $card['icon'] ?? 'sparkles' }}" class="w-4 h-4 text-[#C5A265]"></i>
                                <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-[#DFCA9B] transition-colors">
                                    {{ $card['title'] }}
                                </h3>
                            </div>
                            <p class="text-xs sm:text-sm text-stone-300 leading-relaxed font-light">
                                {{ $card['desc'] }}
                            </p>
                        </div>

                        @if(!empty($card['features']))
                            <div class="pt-3 border-t border-white/5 space-y-2">
                                @foreach($card['features'] as $f)
                                    <div class="flex items-center gap-2.5 text-xs text-stone-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gradient-to-tr from-[#C5A265] to-[#DFCA9B] shadow-[0_0_8px_rgba(197,162,101,0.6)] shrink-0"></span>
                                        <span>{{ $f }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

