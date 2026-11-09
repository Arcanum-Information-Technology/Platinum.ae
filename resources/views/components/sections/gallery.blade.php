@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $gallery = \App\Models\Gallery::active()->with('items')->first();
    $items = $gallery ? $gallery->items : collect([]);
@endphp

<section x-data="{ lightboxOpen: false, activeImage: '', activeTitle: '' }" class="py-24 bg-stone-950 relative border-t border-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="camera" class="w-3.5 h-3.5"></i>
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

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($items as $index => $item)
                @php
                    $isLarge = in_array($index, [0, 3]);
                @endphp
                <div @click="activeImage = '{{ $item->image_path }}'; activeTitle = '{{ addslashes($item->title) }}'; lightboxOpen = true"
                     class="group relative rounded-2xl overflow-hidden cursor-pointer border border-stone-800/80 hover:border-amber-500/50 transition-all duration-300 shadow-lg aspect-square {{ $isLarge ? 'md:col-span-2 md:row-span-2 aspect-auto md:min-h-[300px]' : '' }}">
                    <img src="{{ $item->image_path }}"
                         alt="{{ $item->alt_text ?? $item->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-stone-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center p-4">
                        <div class="text-center transform translate-y-2 group-hover:translate-y-0 transition-transform">
                            <span class="w-10 h-10 rounded-full bg-amber-500 text-stone-950 flex items-center justify-center mx-auto mb-2 shadow-lg">
                                <i data-lucide="maximize-2" class="w-5 h-5"></i>
                            </span>
                            @if($item->title)
                                <p class="text-xs font-semibold text-white drop-shadow">
                                    {{ $item->title }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Lightbox Modal -->
        <div x-show="lightboxOpen"
             x-transition.opacity
             @keydown.escape.window="lightboxOpen = false"
             class="fixed inset-0 z-50 bg-black/95 backdrop-blur-md flex items-center justify-center p-4 sm:p-8"
             style="display: none;">
            <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-stone-400 hover:text-white p-2 rounded-full bg-stone-900 border border-stone-800 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center">
                <img :src="activeImage" :alt="activeTitle" class="max-h-[75vh] w-auto rounded-xl shadow-2xl object-contain">
                <p x-text="activeTitle" class="text-stone-300 text-sm font-medium mt-4"></p>
            </div>
        </div>

    </div>
</section>
