@props(['item'])

@php
    $currency = \App\Models\Setting::get('currency_symbol', 'AED ');
    $imageUrl = $item->primary_image
        ? (str_starts_with($item->primary_image, 'http') ? $item->primary_image : \App\Support\AssetUrl::make($item->primary_image))
        : \App\Support\AssetUrl::make('home-page/home1.jpg');
@endphp

<article class="sh-dish">
    <a href="{{ $item->url }}" class="sh-dish-media">
        <img src="{{ $imageUrl }}" alt="{{ $item->name }}" loading="lazy">
    </a>
    <div class="sh-dish-body">
        @if($item->category)
            <p>{{ $item->category->name }}</p>
        @endif
        <h3><a href="{{ $item->url }}">{{ $item->name }}</a></h3>
        @if($item->short_description)
            <span>{{ $item->short_description }}</span>
        @endif
        <div class="sh-dish-foot">
            <strong>{{ $currency }}{{ number_format($item->effective_price, 2) }}</strong>
            <a href="{{ $item->url }}">View</a>
        </div>
    </div>
</article>
