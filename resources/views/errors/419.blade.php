<x-layouts.website title="Session Expired | 419">

    <section class="min-h-[70vh] flex items-center justify-center py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-stone-900 border border-stone-800 text-amber-400 mb-2 shadow-2xl">
                <i data-lucide="clock-alert" class="w-10 h-10"></i>
            </div>

            <p class="font-mono text-xs uppercase tracking-widest text-amber-500 font-bold">419 Error • Security Token Expired</p>

            <h1 class="font-serif-heading text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Your Table Session Has Expired
            </h1>

            <p class="text-sm sm:text-base text-stone-400 leading-relaxed max-w-md mx-auto">
                For your security, your session or CSRF form token has timed out due to inactivity. Please refresh your page and try again.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <button onclick="window.location.reload();" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Refresh Page
                </button>
                <a href="{{ url('/') }}" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-300 bg-stone-900 border border-stone-800 hover:text-white transition-colors">
                    Return to Home
                </a>
            </div>
        </div>
    </section>

</x-layouts.website>
