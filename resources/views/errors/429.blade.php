<x-layouts.website title="Too Many Requests | 429">

    <section class="min-h-[70vh] flex items-center justify-center py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-stone-900 border border-stone-800 text-amber-400 mb-2 shadow-2xl">
                <i data-lucide="shield-alert" class="w-10 h-10"></i>
            </div>

            <p class="font-mono text-xs uppercase tracking-widest text-amber-500 font-bold">429 Error • Rate Limit Exceeded</p>

            <h1 class="font-serif-heading text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Our Kitchen is Experiencing a Rush
            </h1>

            <p class="text-sm sm:text-base text-stone-400 leading-relaxed max-w-md mx-auto">
                Too many requests have been made from your connection within a short period. Please pause for a moment before trying again.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Return to Home
                </a>
                <a href="{{ url('/contact') }}" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-300 bg-stone-900 border border-stone-800 hover:text-white transition-colors">
                    Contact Concierge
                </a>
            </div>
        </div>
    </section>

</x-layouts.website>
