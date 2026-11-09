<x-layouts.website :entity="$item">

    @php
        $currency = \App\Models\Setting::get('currency_symbol', '$');
        $primaryImg = $item->primary_image ? \App\Support\AssetUrl::make($item->primary_image) : \App\Support\AssetUrl::make('home-page/home1.jpg');
        $gallery = $item->gallery_images ?? [];
    @endphp

    <div class="sh-band min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-stone-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-amber-400 transition-colors">Home</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-600"></i>
                <a href="{{ route('menu.index') }}" class="hover:text-amber-400 transition-colors">Menu</a>
                @if($item->category)
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-600"></i>
                    <a href="{{ route('menu.category', $item->category->slug) }}" class="hover:text-amber-400 transition-colors">
                        {{ $item->category->name }}
                    </a>
                @endif
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-600"></i>
                <span class="text-amber-400 font-medium truncate">{{ $item->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start" x-data="{ currentImage: '{{ $primaryImg }}' }">

                <!-- Left Column: Gallery / Images -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="relative rounded-3xl overflow-hidden aspect-[4/3] bg-[#FAF7F2] border border-[#eadfce] shadow-xl shadow-[#4a3428]/5 max-h-[520px]">
                        <img :src="currentImage"
                             alt="{{ $item->name }}"
                             class="w-full h-full object-cover object-center transition-all duration-300">

                        <!-- Dietary Badges Overlay -->
                        <div class="absolute top-4 left-4 flex flex-wrap gap-2 z-10">
                            @if($item->is_vegetarian)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-950/90 text-emerald-300 border border-emerald-500/40 backdrop-blur-md">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    Vegetarian
                                </span>
                            @endif

                            @if($item->is_vegan)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-green-950/90 text-green-300 border border-green-500/40 backdrop-blur-md">
                                    Vegan
                                </span>
                            @endif

                            @if($item->is_spicy)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-950/90 text-rose-300 border border-rose-500/40 backdrop-blur-md">
                                    @for($i = 0; $i < max(1, $item->spice_level); $i++)
                                        <i data-lucide="flame" class="w-3.5 h-3.5 text-rose-400 fill-rose-400"></i>
                                    @endfor
                                    <span>Spice {{ $item->spice_level }}/3</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnails if extra images exist -->
                    @if(!empty($gallery))
                        <div class="flex items-center gap-3 overflow-x-auto pb-2">
                            <button @click="currentImage = '{{ $primaryImg }}'"
                                    :class="currentImage === '{{ $primaryImg }}' ? 'border-[#630B0D] ring-2 ring-[#630B0D]/30' : 'border-[#e0d6c7] opacity-70 hover:opacity-100'"
                                    class="w-20 h-16 rounded-xl overflow-hidden border shrink-0 transition-all bg-[#FAF7F2]">
                                <img src="{{ $primaryImg }}" alt="Thumb" class="w-full h-full object-cover object-center">
                            </button>
                            @foreach($gallery as $gImg)
                                @php
                                    $gUrl = str_starts_with($gImg, 'http') ? $gImg : asset($gImg);
                                @endphp
                                <button @click="currentImage = '{{ $gUrl }}'"
                                        :class="currentImage === '{{ $gUrl }}' ? 'border-[#630B0D] ring-2 ring-[#630B0D]/30' : 'border-[#e0d6c7] opacity-70 hover:opacity-100'"
                                        class="w-20 h-16 rounded-xl overflow-hidden border shrink-0 transition-all bg-[#FAF7F2]">
                                    <img src="{{ $gUrl }}" alt="Thumb" class="w-full h-full object-cover object-center">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column: Details & Information -->
                <div class="lg:col-span-6 space-y-6">

                    <!-- Category & Status -->
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-widest text-amber-500">
                            {{ $item->category?->name ?? 'Course' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium {{ $item->is_available ? 'text-emerald-400' : 'text-stone-500' }}">
                            <span class="w-2 h-2 rounded-full {{ $item->is_available ? 'bg-emerald-400' : 'bg-stone-600' }}"></span>
                            {{ $item->is_available ? 'Available Today' : 'Sold Out' }}
                        </span>
                    </div>

                    <h1 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-[#4a3428] tracking-tight leading-tight">
                        {{ $item->name }}
                    </h1>

                    <!-- Pricing -->
                    <div class="flex items-baseline gap-3 pt-2">
                        @if($item->has_discount)
                            <span class="text-lg text-stone-500 line-through">
                                {{ $currency }}{{ number_format($item->price, 2) }}
                            </span>
                            <span class="font-serif-heading text-3xl sm:text-4xl font-extrabold text-[#7a2a38]">
                                {{ $currency }}{{ number_format($item->effective_price, 2) }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-amber-500/20 text-amber-400 border border-amber-500/40">
                                Save {{ $item->discount_percentage }}%
                            </span>
                        @else
                            <span class="font-serif-heading text-3xl sm:text-4xl font-extrabold text-[#7a2a38]">
                                {{ $currency }}{{ number_format($item->price, 2) }}
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="text-[#5c564e] text-sm sm:text-base leading-relaxed space-y-3 font-light">
                        <p>{{ $item->short_description }}</p>
                        @if($item->full_description)
                            <p class="text-stone-400 text-sm">{{ $item->full_description }}</p>
                        @endif
                    </div>

                    <!-- Meta specs (prep time, serving, calories) -->
                    <div class="grid grid-cols-3 gap-4 p-4 rounded-2xl bg-white border border-[#eadfce] text-center">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-stone-400 block mb-0.5">Prep Time</span>
                            <span class="text-xs sm:text-sm font-semibold text-[#4a3428]">{{ $item->preparation_time ?? '15-20 min' }}</span>
                        </div>
                        <div class="border-x border-stone-800">
                            <span class="text-[10px] uppercase tracking-wider text-stone-400 block mb-0.5">Portion</span>
                            <span class="text-xs sm:text-sm font-semibold text-[#4a3428]">{{ $item->serving_size ?? '1-2 persons' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-stone-400 block mb-0.5">Energy</span>
                            <span class="text-xs sm:text-sm font-semibold text-[#4a3428]">{{ $item->calories ? $item->calories . ' kcal' : 'Artisanal' }}</span>
                        </div>
                    </div>

                    <!-- Ingredients -->
                    @if(!empty($item->ingredients))
                        <div class="space-y-2 pt-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-stone-300 flex items-center gap-1.5">
                                <i data-lucide="leaf" class="w-3.5 h-3.5 text-amber-400"></i>
                                Key Ingredients
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($item->ingredients as $ingredient)
                                    <span class="px-3 py-1 rounded-lg text-xs bg-stone-900 border border-stone-800 text-stone-300">
                                        {{ $ingredient }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Allergens -->
                    @if(!empty($item->allergens))
                        <div class="space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-stone-300 flex items-center gap-1.5">
                                <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-rose-400"></i>
                                Allergen Advisory
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($item->allergens as $allergen)
                                    <span class="px-3 py-1 rounded-lg text-xs bg-rose-950/40 border border-rose-500/30 text-rose-300">
                                        {{ $allergen }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- CTA Buttons -->
                    <div class="pt-6 border-t border-stone-800/80 flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ url('/contact') }}"
                           class="w-full sm:w-auto flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 shadow-xl shadow-amber-500/20 transition-all">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>Reserve Table For This Dish</span>
                        </a>

                        <a href="{{ route('menu.index') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-300 bg-stone-900 hover:bg-stone-800 border border-stone-800 hover:text-white transition-colors">
                            <span>Back To Menu</span>
                        </a>
                    </div>

                </div>

            </div>

            <!-- Related Dishes -->
            @if(isset($relatedItems) && $relatedItems->isNotEmpty())
                <div class="mt-24 pt-16 border-t border-stone-900">
                    <div class="text-center mb-12">
                        <span class="text-xs font-bold uppercase tracking-widest text-amber-500">Pairings & Alternatives</span>
                        <h3 class="font-serif-heading text-3xl font-bold text-[#4a3428] mt-1">You May Also Enjoy</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($relatedItems as $rel)
                            <x-website.food-card :item="$rel" />
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-layouts.website>
