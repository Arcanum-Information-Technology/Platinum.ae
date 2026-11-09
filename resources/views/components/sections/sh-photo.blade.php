@props(['data'])

@php
    $image = \App\Support\AssetUrl::make($data['image'] ?? '');
@endphp

@if($image)
    <section class="sh-feature-photo">
        <img src="{{ $image }}" alt="{{ $data['alt'] ?? '' }}">
    </section>
@endif
