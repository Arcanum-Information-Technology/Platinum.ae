@props(['data'])

@php
    $html = $data['html'] ?? '';
@endphp

<section class="py-12 bg-stone-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {!! $html !!}
    </div>
</section>
