@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Decades of Hospitality Management Excellence');
    $title = data_get($data, 'title', 'Strategic Expertise. Operational Precision.');
    $description = data_get($data, 'description', 'With decades of combined industry experience, Platinum Hospitality Management specializes in building, managing, and scaling high-performing food and beverage brands. From concept development to daily operations, our team ensures consistency, efficiency, and long-term profitability across every hospitality venture we lead.');
    $metrics = data_get($data, 'metrics', [
        ['label' => 'Quality Food', 'value' => '89%', 'pct' => 89],
        ['label' => 'Professional Chef', 'value' => '93%', 'pct' => 93],
        ['label' => 'Trusted Consument', 'value' => '98%', 'pct' => 98],
    ]);
@endphp

<section class="py-20 sm:py-28 bg-[#0D0D0E] border-y border-white/5 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Left: Description -->
            <div class="lg:col-span-6 space-y-6">
                <span class="gold-badge">{{ $badge }}</span>
                <h2 class="font-serif-heading text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    {{ $title }}
                </h2>
                <p class="text-stone-300 text-base leading-relaxed font-light">
                    {{ $description }}
                </p>
                <div class="pt-2">
                    <a href="{{ url('/contact') }}" class="btn-gold text-xs px-6 py-3.5 rounded-xl inline-flex items-center gap-2">
                        <span>Partner With Us</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Right: Performance Progress Bars -->
            <div class="lg:col-span-6 plat-glass rounded-3xl p-8 sm:p-10 border border-white/10 space-y-6">
                <h3 class="font-serif-heading text-xl font-bold text-white mb-6">
                    Operational Standards Index
                </h3>

                @foreach($metrics as $m)
                    @php
                        $percentage = is_numeric(rtrim($m['value'], '%')) ? (int) rtrim($m['value'], '%') : 90;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm font-semibold">
                            <span class="text-white">{{ $m['label'] }}</span>
                            <span class="font-mono text-[#DFCA9B]">{{ $m['value'] }}</span>
                        </div>
                        <div class="w-full h-3 bg-black/60 rounded-full overflow-hidden border border-white/10">
                            <div class="h-full bg-gradient-to-r from-[#C5A265] to-[#DFCA9B] rounded-full transition-all duration-1000 ease-out"
                                 style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

