@props(['data'])

@php
    $title = $data['title'] ?? null;
    $video = \App\Support\AssetUrl::make($data['video'] ?? '');
    $poster = \App\Support\AssetUrl::make($data['poster'] ?? '');
@endphp

<section class="sh-hero">
    @if($video)
        <video class="sh-hero-media" autoplay muted loop playsinline poster="{{ $poster }}">
            <source src="{{ $video }}" type="video/mp4">
        </video>
    @elseif($poster)
        <img class="sh-hero-media" src="{{ $poster }}" alt="{{ $title }}">
    @endif
    <div class="sh-hero-shade"></div>
    @if(!empty(trim($title ?? '')))
        <h1>{{ $title }}</h1>
    @endif
</section>
