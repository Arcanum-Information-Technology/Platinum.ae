@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $hours = \App\Models\OpeningHour::orderBy('sort_order')->get();
@endphp

<section id="hours" class="py-24 bg-stone-900/40 relative border-t border-stone-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        <span>{{ $badge }}</span>
                    </div>
                @endif
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-stone-400 text-sm sm:text-base mt-2 leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <!-- Schedule Table -->
        <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-10 shadow-2xl">
            <div class="divide-y divide-stone-800/80">
                @foreach($hours as $h)
                    <div class="py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full {{ $h->is_closed ? 'bg-stone-600' : 'bg-amber-400' }}"></span>
                            <span class="font-serif-heading text-lg font-bold text-white">{{ $h->day_name }}</span>
                            @if($h->note)
                                <span class="hidden md:inline-block text-[11px] text-stone-400 bg-stone-950 px-2.5 py-0.5 rounded-full border border-stone-800">
                                    {{ $h->note }}
                                </span>
                            @endif
                        </div>
                        <div class="text-sm font-medium pl-5 sm:pl-0 {{ $h->is_closed ? 'text-rose-400' : 'text-stone-300' }}">
                            {{ $h->formatted_hours }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
