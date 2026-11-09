<x-layouts.website :entity="$page">

    @if($page->activeSections->isNotEmpty())
        @foreach($page->activeSections as $section)
            <x-sections.render-section :section="$section" />
        @endforeach
    @elseif($page->content)
        <div class="sh-band">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="font-serif-heading text-4xl sm:text-5xl font-bold text-[#4a3428] tracking-tight">
                        {{ $page->title }}
                    </h1>
                </div>
                <div class="bg-stone-900/80 border border-stone-800 p-8 sm:p-12 rounded-3xl shadow-xl prose-content text-stone-300">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    @endif

</x-layouts.website>
