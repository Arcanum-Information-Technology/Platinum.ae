@props(['data'])

@php
    $content = $data['content'] ?? '';
@endphp

<section class="sh-band">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-[#eadfce] p-8 sm:p-12 shadow-sm prose-content text-[#5c564e]">
            {!! $content !!}
        </div>
    </div>
</section>
