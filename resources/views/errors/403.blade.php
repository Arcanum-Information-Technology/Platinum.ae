<x-layouts.website title="Access Forbidden | 403">

    <section class="min-h-[70vh] flex items-center justify-center py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-stone-900 border border-stone-800 text-rose-400 mb-2 shadow-2xl">
                <i data-lucide="shield-alert" class="w-10 h-10"></i>
            </div>

            <p class="font-mono text-xs uppercase tracking-widest text-rose-500 font-bold">403 Forbidden • Private Dining Salon</p>

            <h1 class="font-serif-heading text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Staff Credentials Required
            </h1>

            <p class="text-sm sm:text-base text-stone-400 leading-relaxed max-w-md mx-auto">
                You do not possess the required role permissions to access this dining control room or administrative salon.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Return to Public Dining
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 rounded-full font-semibold uppercase tracking-wider text-xs text-stone-300 bg-stone-900 border border-stone-800 hover:text-white transition-colors">
                    Admin Dashboard
                </a>
            </div>
        </div>
    </section>

</x-layouts.website>
