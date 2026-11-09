@props(['data'])

@php
    $primaryText = $data['primary_text'] ?? null;
    $primaryUrl = $data['primary_url'] ?? '/contact';
    $secondaryText = $data['secondary_text'] ?? null;
    $secondaryUrl = $data['secondary_url'] ?? '/our-branches';
    $image = \App\Support\AssetUrl::make($data['image'] ?? 'home-page/SAC_Dubai_Marina_Mall_New_898x608_crop_center.webp');
@endphp

<section class="sh-cta-banner">
    <div class="sh-cta-photos" aria-hidden="true">
        <img src="{{ $image }}" alt="">
        <img src="{{ $image }}" alt="">
    </div>
    <div class="sh-cta-actions">
        @if(!empty(trim($primaryText ?? '')))
            <a href="{{ url($primaryUrl) }}">{{ $primaryText }}</a>
        @endif
        @if(!empty(trim($secondaryText ?? '')))
            <a href="{{ url($secondaryUrl) }}">{{ $secondaryText }}</a>
        @endif
    </div>
</section>
