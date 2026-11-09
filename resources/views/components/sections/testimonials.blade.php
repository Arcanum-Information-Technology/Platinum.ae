@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $testimonials = \App\Models\Testimonial::published()->orderBy('sort_order')->take(4)->get();
@endphp

<section class="py-24 bg-stone-900/60 relative border-t border-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center max-w-2xl mx-auto mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
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

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $t)
                <div class="bg-stone-900 border border-stone-800 p-8 rounded-2xl flex flex-col justify-between hover:border-amber-500/40 transition-all duration-300 shadow-xl shadow-black/40">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 mb-6">
                            @for($i = 0; $i < $t->rating; $i++)
                                <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            @endfor
                        </div>

                        <p class="text-stone-300 text-sm sm:text-base leading-relaxed italic mb-8">
                            “{{ $t->content }}”
                        </p>
                    </div>

                    <!-- Author Info -->
                    <div class="flex items-center gap-4 pt-4 border-t border-stone-800/80">
                        @if($t->avatar)
                            <img src="{{ $t->avatar }}" alt="{{ $t->customer_name }}" class="w-11 h-11 rounded-full object-cover border border-amber-500/40">
                        @else
                            <div class="w-11 h-11 rounded-full bg-amber-500/20 text-amber-400 font-bold flex items-center justify-center text-sm border border-amber-500/30">
                                {{ substr($t->customer_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-serif-heading text-base font-bold text-white leading-tight">
                                {{ $t->customer_name }}
                            </h4>
                            @if($t->customer_role)
                                <p class="text-xs text-amber-500/90 font-medium">
                                    {{ $t->customer_role }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
