@props(['category'])

@php
    $imageUrl = $category->image ? (str_starts_with($category->image, 'http') ? $category->image : asset($category->image)) : 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80';
@endphp

<a href="{{ route('menu.category', $category->slug) }}"
   class="group relative rounded-2xl overflow-hidden aspect-[4/5] sm:aspect-square flex flex-col justify-end p-6 border border-stone-800 hover:border-amber-500/50 transition-all duration-300 shadow-xl hover:shadow-amber-950/20">

    <!-- Background Image -->
    <img src="{{ $imageUrl }}"
         alt="{{ $category->name }}"
         loading="lazy"
         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-950/60 to-transparent"></div>

    <!-- Content -->
    <div class="relative z-10 space-y-1">
        <span class="text-[10px] font-semibold tracking-widest uppercase text-amber-400">
            Course Selection
        </span>
        <h3 class="font-serif-heading text-xl font-bold text-white group-hover:text-amber-300 transition-colors">
            {{ $category->name }}
        </h3>
        @if($category->description)
            <p class="text-xs text-stone-300 line-clamp-2 leading-relaxed opacity-90">
                {{ $category->description }}
            </p>
        @endif
        <div class="pt-3 flex items-center gap-1.5 text-xs font-semibold text-amber-400 group-hover:translate-x-1 transition-transform">
            <span>Explore Course</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </div>
    </div>
</a>
