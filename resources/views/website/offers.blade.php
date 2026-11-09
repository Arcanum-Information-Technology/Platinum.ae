<x-layouts.website>

    <div class="pt-28 pb-20 bg-stone-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Exclusive Privileges</span>
                </span>
                <h1 class="font-serif-heading text-4xl sm:text-6xl font-extrabold text-white tracking-tight mb-4">
                    Seasonal Offers & Tastings
                </h1>
                <p class="text-sm sm:text-base text-stone-300 font-light leading-relaxed">
                    Exclusive dining privileges, weekday tasting menus, and sommelier flight pairings.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($offers as $offer)
                    <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden hover:border-amber-500/40 transition-all duration-300 shadow-2xl flex flex-col justify-between group">
                        @if($offer->image)
                            <div class="relative aspect-video overflow-hidden bg-stone-950">
                                <img src="{{ $offer->image }}" alt="{{ $offer->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-transparent to-transparent"></div>
                                @if($offer->badge)
                                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500 text-stone-950 shadow-lg">
                                        {{ $offer->badge }}
                                    </span>
                                @endif
                                @if($offer->discount_amount)
                                    <span class="absolute bottom-4 right-4 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-stone-950/90 text-amber-400 border border-amber-500/30 backdrop-blur-md">
                                        {{ $offer->discount_amount }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="p-8 flex-1 flex flex-col justify-between space-y-6">
                            <div>
                                @if($offer->subtitle)
                                    <p class="text-xs font-semibold uppercase tracking-wider text-amber-500/90 mb-1">
                                        {{ $offer->subtitle }}
                                    </p>
                                @endif
                                <h3 class="font-serif-heading text-2xl font-bold text-white mb-3">
                                    {{ $offer->title }}
                                </h3>
                                <p class="text-stone-300 text-sm leading-relaxed font-light">
                                    {{ $offer->description }}
                                </p>
                            </div>

                            <div class="pt-6 border-t border-stone-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                @if($offer->promo_code)
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] uppercase tracking-wider text-stone-400 font-medium">Use Code:</span>
                                        <span class="px-3 py-1 rounded-lg bg-stone-950 border border-dashed border-amber-500/60 font-mono text-xs font-bold text-amber-400">
                                            {{ $offer->promo_code }}
                                        </span>
                                    </div>
                                @endif

                                <a href="{{ url('/contact') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-amber-400 text-stone-950 hover:bg-amber-300 transition-colors">
                                    <span>Reserve With Offer</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</x-layouts.website>
