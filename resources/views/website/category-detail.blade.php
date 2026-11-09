<x-layouts.website :entity="$category">

    @php
        $bgImage = $category->image 
            ? (str_starts_with($category->image, 'http') ? $category->image : \App\Support\AssetUrl::make($category->image)) 
            : \App\Support\AssetUrl::make('home-page/Untitled-1-2048x1017.jpg');
        $currentSubSlug = request()->route('subcategorySlug') ?? request()->route('subcategory') ?? ($subcategory->slug ?? null);
    @endphp

    <!-- Category Banner with Ambient Photo Background -->
    <div class="sh-menu-hero" style="background-image: url('{{ $bgImage }}');">
        <div class="sh-menu-hero-overlay"></div>
        <div class="sh-menu-hero-content">
            <nav class="sh-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sh-breadcrumb-sep">•••</span>
                <a href="{{ route('menu.index') }}">Menu</a>
                <span class="sh-breadcrumb-sep">•••</span>
                <span class="is-current">{{ $category->name }}</span>
            </nav>
            <h1>{{ $category->name }}</h1>
            @if($category->description)
                <p class="sh-menu-hero-desc">
                    {{ $category->description }}
                </p>
            @endif
        </div>
    </div>

    <!-- Category Dishes Section -->
    <div class="sh-band">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Subcategories Filter if present -->
            @if($category->subcategories->isNotEmpty())
                <div class="flex items-center justify-center gap-2.5 flex-wrap mb-12">
                    <a href="{{ route('menu.category', $category->slug) }}"
                       class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all duration-200 {{ empty($currentSubSlug) ? 'bg-[#630B0D] text-white shadow-md' : 'bg-white text-[#5c4032] border border-[#d9d0c1] hover:border-[#630B0D] hover:text-[#630B0D]' }}">
                        All {{ $category->name }}
                    </a>
                    @foreach($category->subcategories as $sub)
                        <a href="{{ route('menu.subcategory', ['categorySlug' => $category->slug, 'subcategorySlug' => $sub->slug]) }}"
                           class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all duration-200 {{ $currentSubSlug === $sub->slug ? 'bg-[#630B0D] text-white shadow-md' : 'bg-white text-[#5c4032] border border-[#d9d0c1] hover:border-[#630B0D] hover:text-[#630B0D]' }}">
                            {{ $sub->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Dishes Grid -->
            @if($items->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                    @foreach($items as $item)
                        <x-website.food-card :item="$item" />
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $items->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl border border-[#eadfce] max-w-xl mx-auto p-8 shadow-sm">
                    <i data-lucide="utensils" class="w-12 h-12 text-[#9c8f85] mx-auto mb-4"></i>
                    <h3 class="font-serif-heading text-2xl font-bold text-[#4a3428] mb-2">Seasonal Preparations Underway</h3>
                    <p class="text-sm text-[#7a6f65] max-w-md mx-auto mb-6">Our chefs are finalizing exquisite selections for this course.</p>
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-[#630B0D] text-white hover:bg-[#4d080a] transition-colors shadow-md">
                        <span>Browse Full Menu</span>
                    </a>
                </div>
            @endif

        </div>
    </div>

</x-layouts.website>
