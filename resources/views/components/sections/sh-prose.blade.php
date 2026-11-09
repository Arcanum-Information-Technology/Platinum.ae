@props(['data'])

@php
    $ornament = \App\Support\AssetUrl::make($data['ornament'] ?? '');
    $paragraphs = preg_split("/\n\s*\n/", trim($data['body'] ?? '')) ?: [];
    $isFranchise = request()->is('franchise*') || str_contains(strtolower($data['body'] ?? ''), 'franchise');
@endphp

<section class="sh-band">
    <div class="sh-wrap">
        @if($ornament)
            <img class="sh-ornament" src="{{ $ornament }}" alt="Shakespeare">
        @endif

        <div class="sh-prose-card">
            <div class="sh-prose">
                @foreach($paragraphs as $paragraph)
                    @if(trim($paragraph) !== '')
                        <p>{{ $paragraph }}</p>
                    @endif
                @endforeach
            </div>

            @if($isFranchise)
                <div class="sh-franchise-pillars">
                    <div class="sh-pillar">
                        <div class="sh-pillar-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        </div>
                        <h4>Established Heritage</h4>
                        <p>Founded in Dubai in 2001 with high brand loyalty across the UAE and GCC.</p>
                    </div>
                    <div class="sh-pillar">
                        <div class="sh-pillar-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <h4>Turnkey Systems</h4>
                        <p>Complete operational blueprints, standardized recipes, and central supply chain support.</p>
                    </div>
                    <div class="sh-pillar">
                        <div class="sh-pillar-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><path d="M6 3h12l4 6-10 12L2 9l4-6z"/></svg>
                        </div>
                        <h4>Bespoke Design</h4>
                        <p>Distinctive Victorian-French décor delivering timeless customer magnetism.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
