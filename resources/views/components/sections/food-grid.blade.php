@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $categories = \App\Models\Category::published()->with(['activeMenuItems.category', 'activeMenuItems.subcategory'])->orderBy('sort_order')->get();
    $allItems = \App\Models\MenuItem::with(['category', 'subcategory'])->published()->available()->orderBy('sort_order')->get();
@endphp

<section id="menu-grid" x-data="{ currentCategory: 'all', dietFilter: 'all', search: '' }" class="py-20 bg-stone-950 border-t border-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Heading -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto mb-12">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="utensils" class="w-3.5 h-3.5"></i>
                        <span>{{ $badge }}</span>
                    </div>
                @endif
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-stone-400 text-sm sm:text-base mt-3 leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <!-- Filter Controls -->
        <div class="space-y-4 mb-12">

            <!-- Category Pills -->
            <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <button @click="currentCategory = 'all'"
                        :class="currentCategory === 'all' ? 'bg-amber-400 text-stone-950 font-bold shadow-lg shadow-amber-500/20' : 'bg-stone-900 text-stone-300 hover:text-white hover:bg-stone-800'"
                        class="px-5 py-2.5 rounded-full text-xs font-semibold tracking-wider uppercase whitespace-nowrap transition-all duration-200">
                    All Courses
                </button>
                @foreach($categories as $cat)
                    <button @click="currentCategory = '{{ $cat->id }}'"
                            :class="currentCategory === '{{ $cat->id }}' ? 'bg-amber-400 text-stone-950 font-bold shadow-lg shadow-amber-500/20' : 'bg-stone-900 text-stone-300 hover:text-white hover:bg-stone-800'"
                            class="px-5 py-2.5 rounded-full text-xs font-semibold tracking-wider uppercase whitespace-nowrap transition-all duration-200">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <!-- Search Bar & Dietary Quick Filters -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 max-w-4xl mx-auto pt-2">
                <!-- Search input -->
                <div class="relative w-full sm:w-72">
                    <input type="text"
                           x-model="search"
                           placeholder="Search ingredients, dishes..."
                           class="w-full bg-stone-900/90 border border-stone-800 rounded-full pl-10 pr-4 py-2 text-xs text-stone-100 placeholder-stone-500 focus:border-amber-400 focus:outline-none transition-colors">
                    <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                </div>

                <!-- Dietary toggles -->
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <button @click="dietFilter = dietFilter === 'veg' ? 'all' : 'veg'"
                            :class="dietFilter === 'veg' ? 'bg-emerald-950 border-emerald-500 text-emerald-300' : 'bg-stone-900 border-stone-800 text-stone-400 hover:text-stone-200'"
                            class="px-3.5 py-1.5 rounded-full border text-xs font-medium transition-colors flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        Vegetarian
                    </button>

                    <button @click="dietFilter = dietFilter === 'vegan' ? 'all' : 'vegan'"
                            :class="dietFilter === 'vegan' ? 'bg-green-950 border-green-500 text-green-300' : 'bg-stone-900 border-stone-800 text-stone-400 hover:text-stone-200'"
                            class="px-3.5 py-1.5 rounded-full border text-xs font-medium transition-colors flex items-center gap-1.5">
                        Vegan
                    </button>

                    <button @click="dietFilter = dietFilter === 'spicy' ? 'all' : 'spicy'"
                            :class="dietFilter === 'spicy' ? 'bg-rose-950 border-rose-500 text-rose-300' : 'bg-stone-900 border-stone-800 text-stone-400 hover:text-stone-200'"
                            class="px-3.5 py-1.5 rounded-full border text-xs font-medium transition-colors flex items-center gap-1.5">
                        <i data-lucide="flame" class="w-3 h-3 text-rose-400"></i>
                        Spicy
                    </button>
                </div>
            </div>

        </div>

        <!-- Food Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($allItems as $item)
                @php
                    $searchData = strtolower($item->name . ' ' . $item->short_description . ' ' . implode(' ', $item->ingredients ?? []));
                @endphp
                <div x-show="(currentCategory === 'all' || currentCategory === '{{ $item->category_id }}')
                             && (dietFilter === 'all' || (dietFilter === 'veg' && {{ $item->is_vegetarian ? 'true' : 'false' }}) || (dietFilter === 'vegan' && {{ $item->is_vegan ? 'true' : 'false' }}) || (dietFilter === 'spicy' && {{ $item->is_spicy ? 'true' : 'false' }}))
                             && (search === '' || '{{ addslashes($searchData) }}'.includes(search.toLowerCase()))"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    <x-website.food-card :item="$item" />
                </div>
            @endforeach
        </div>

    </div>
</section>
