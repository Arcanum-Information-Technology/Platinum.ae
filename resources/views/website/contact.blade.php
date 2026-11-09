<x-layouts.website title="Contact & Reservations | Saffron & Thyme" meta-description="Reserve your table or contact our concierge for private events, tastings, and inquiries at Saffron & Thyme.">

    <div class="py-20 lg:py-28 bg-stone-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            <div class="text-center max-w-3xl mx-auto space-y-4">
                <span class="inline-block font-mono text-xs uppercase tracking-widest text-amber-400 font-bold px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20">
                    Concierge & Inquiries
                </span>
                <h1 class="font-serif-heading text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Reserve a Table or Reach Out
                </h1>
                <p class="text-sm sm:text-base text-stone-300 leading-relaxed">
                    We welcome table reservations, private culinary salon bookings, and inquiries. Our hospitality concierge will promptly attend to your request.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div>
                    <x-sections.contact-info :data="[]" />
                </div>
                <div>
                    <x-sections.contact-form :data="[]" />
                </div>
            </div>
        </div>
    </div>

</x-layouts.website>
