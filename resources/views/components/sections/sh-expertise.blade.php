@props(['data'])

@php
    $ornament = \App\Support\AssetUrl::make($data['ornament'] ?? '');
    $items = $data['items'] ?? [];
    $fallbackIcons = [
        'home-page/icon/output-onlinepngtools-2.png',
        'home-page/icon/output-onlinepngtools-3.png',
        'home-page/icon/output-onlinepngtools-4.png',
        'home-page/icon/output-onlinepngtools-5.png',
    ];
@endphp

<section class="sh-band sh-band-tight">
    <div class="sh-wrap">
        @if($ornament)
            <img class="sh-ornament" src="{{ $ornament }}" alt="Our Expertise">
        @endif

        <div class="sh-card-grid">
            @foreach($items as $index => $item)
                @php
                    $icon = \App\Support\AssetUrl::make($item['icon'] ?? ($fallbackIcons[$index] ?? ''));
                @endphp
                <article class="sh-card">
                    @if($icon)
                        <img class="sh-card-icon" src="{{ $icon }}" alt="">
                    @endif
                    <h3>{{ $item['title'] ?? '' }}</h3>
                    <p>{{ $item['body'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
