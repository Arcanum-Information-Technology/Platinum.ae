@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $faqs = \App\Models\Faq::published()->orderBy('sort_order')->get();

    // Generate FAQ Schema
    $faqSchema = app(\App\Services\SchemaService::class)->getFaqSchema($faqs->toArray());
@endphp

@push('schema')
    <script type="application/ld+json">
        {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

<section class="py-24 bg-stone-950 relative border-t border-stone-900" x-data="{ activeAccordion: null }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center mb-16">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
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

        <!-- Accordions -->
        <div class="space-y-4">
            @foreach($faqs as $index => $faq)
                <div class="bg-stone-900/80 border border-stone-800 rounded-2xl overflow-hidden transition-colors"
                     :class="activeAccordion === {{ $index }} ? 'border-amber-500/40 bg-stone-900' : 'hover:border-stone-700'">
                    <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                            class="w-full text-left px-6 py-5 flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-serif-heading text-base sm:text-lg font-semibold text-white">
                            {{ $faq->question }}
                        </span>
                        <span class="p-1 rounded-full bg-stone-800 text-amber-400 transition-transform duration-200"
                              :class="activeAccordion === {{ $index }} ? 'rotate-180 bg-amber-500/20 text-amber-400' : ''">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </span>
                    </button>
                    <div x-show="activeAccordion === {{ $index }}"
                         x-collapse
                         x-cloak
                         class="px-6 pb-6 text-sm text-stone-300 leading-relaxed border-t border-stone-800/60 pt-4">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
