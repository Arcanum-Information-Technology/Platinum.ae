@props(['data'])

@php
    $ornament = \App\Support\AssetUrl::make($data['ornament'] ?? '');
    $imageOne = \App\Support\AssetUrl::make($data['image_one'] ?? '');
    $imageTwo = \App\Support\AssetUrl::make($data['image_two'] ?? '');
    $sideImage = \App\Support\AssetUrl::make($data['side_image'] ?? '');
    $paragraphs = preg_split("/\n\s*\n/", trim($data['body'] ?? '')) ?: [];
    $sideParagraphs = preg_split("/\n\s*\n/", trim($data['side_text'] ?? '')) ?: [];
@endphp

<section class="sh-band sh-story">
    <div class="sh-wrap">
        @if($ornament)
            <img class="sh-ornament" src="{{ $ornament }}" alt="Our Story">
        @endif

        <div class="sh-prose">
            @foreach($paragraphs as $paragraph)
                @if(trim($paragraph) !== '')
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
        </div>

        @if($imageOne || $imageTwo)
            <div class="sh-photo-pair">
                @if($imageOne)
                    <img src="{{ $imageOne }}" alt="Signature dish">
                @endif
                @if($imageTwo)
                    <img src="{{ $imageTwo }}" alt="Afternoon tea">
                @endif
            </div>
        @endif

        @if($sideImage || trim($data['side_text'] ?? '') !== '')
            <div class="sh-split">
                @if($sideImage)
                    <img src="{{ $sideImage }}" alt="Shakespeare dining room">
                @endif
                <div class="sh-prose sh-prose-left">
                    @foreach($sideParagraphs as $paragraph)
                        @if(trim($paragraph) !== '')
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
