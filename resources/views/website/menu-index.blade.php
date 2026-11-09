<x-layouts.website :entity="$page ?? null">

    @php
        $bannerBg = \App\Support\AssetUrl::make('home-page/Untitled-1-2048x1017.jpg');
    @endphp

    <!-- Menu Hero Banner with Photo Background (Image 2 style) -->
    <header class="sh-menu-hero" style="background-image: url('{{ $bannerBg }}');">
        <div class="sh-menu-hero-overlay"></div>
        <div class="sh-menu-hero-content">
            <h1 class="sh-menu-hero-title">{{ $page->title ?? 'Our Menu' }}</h1>
            <nav class="sh-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sh-breadcrumb-sep">•••</span>
                <span class="is-current">Menu</span>
            </nav>
        </div>
    </header>

    <section class="sh-band">
        <div class="sh-wrap max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(request('search'))
                <!-- Search Results Mode -->
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#ded7cc]">
                    <div>
                        <h2 class="font-serif-heading text-2xl font-bold text-[#4a3428]">Search Results</h2>
                        <p class="text-xs text-[#8a7f74]">Showing dishes matching “{{ request('search') }}”</p>
                    </div>
                    <a href="{{ route('menu.index') }}" class="text-xs font-semibold uppercase tracking-wider text-[#630B0D] hover:underline">
                        ← Back to Categories
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                    @forelse($items as $item)
                        <x-website.food-card :item="$item" />
                    @empty
                        <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-[#eadfce] p-8">
                            <i data-lucide="search-x" class="w-12 h-12 text-[#9c8f85] mx-auto mb-3"></i>
                            <h3 class="font-serif-heading text-xl font-bold text-[#4a3428]">No dishes found matching “{{ request('search') }}”</h3>
                            <p class="text-xs text-[#7a6f65] mt-1 mb-6">Try searching with a different ingredient or dish name.</p>
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs font-semibold uppercase bg-[#630B0D] text-white hover:bg-[#4d080a] transition-colors">
                                View All Categories
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($items->hasPages())
                    <div class="pt-10 flex justify-center">{{ $items->links() }}</div>
                @endif
            @else
                <!-- Category Grid (Matches Image 2) -->
                <div class="sh-category-grid">
                    @foreach($categories as $category)
                        @php
                            $catImg = $category->image 
                                ? (str_starts_with($category->image, 'http') ? $category->image : \App\Support\AssetUrl::make($category->image))
                                : ($category->activeMenuItems->first()?->primary_image 
                                    ? (str_starts_with($category->activeMenuItems->first()->primary_image, 'http') ? $category->activeMenuItems->first()->primary_image : \App\Support\AssetUrl::make($category->activeMenuItems->first()->primary_image))
                                    : \App\Support\AssetUrl::make('home-page/home1.jpg'));
                            $count = $category->active_menu_items_count ?? $category->activeMenuItems->count();
                        @endphp
                        <a href="{{ route('menu.category', $category->slug) }}" class="sh-cat-card group">
                            <!-- Damask / Floral Pattern Card Surface -->
                            <div class="sh-cat-card-frame">
                                <div class="sh-cat-media-wrap">
                                    <img src="{{ $catImg }}" 
                                         alt="{{ $category->name }}" 
                                         loading="lazy" 
                                         class="sh-cat-img group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="sh-cat-badge">
                                    <h3 class="sh-cat-title">{{ strtoupper($category->name) }}</h3>
                                    <span class="sh-cat-count">{{ $count }} {{ Str::plural('PRODUCT', $count) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

</x-layouts.website>
