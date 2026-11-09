<x-layouts.website title="Unprocessable Entity | 422">

    <section class="min-h-[70vh] flex items-center justify-center py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-stone-900 border border-stone-800 text-amber-400 mb-2 shadow-2xl">
                <i data-lucide="alert-triangle" class="w-10 h-10"></i>
            </div>

            <p class="font-mono text-xs uppercase tracking-widest text-amber-500 font-bold">422 Error • Submission Validation Error</p>

            <h1 class="font-serif-heading text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Incomplete Order or Form Data
            </h1>

            <p class="text-sm sm:text-base text-stone-400 leading-relaxed max-w-md mx-auto">
                The information submitted could not be processed due to missing or invalid fields. Please review your entries and try again.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <button onclick="window.history.back();" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Go Back & Correct
                </button>
                <a href="{{ url('/') }}" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-300 bg-stone-900 border border-stone-800 hover:text-white transition-colors">
                    Return to Home
                </a>
            </div>
        </div>
    </section>

</x-layouts.website>
