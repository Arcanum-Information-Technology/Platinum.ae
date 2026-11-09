@props(['data' => []])

@php
    $title = data_get($data, 'title', 'Submit Franchise Application');
    $subtitle = data_get($data, 'subtitle', 'Our franchise development team will review your application and schedule a private discovery call.');
@endphp

<section class="py-20 sm:py-28 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10">

        <div class="plat-glass-gold p-8 sm:p-12 rounded-3xl shadow-2xl border border-[#C5A265]/40 space-y-8">
            <div class="text-center max-w-xl mx-auto">
                <span class="gold-badge mb-2">Franchise Onboarding</span>
                <h3 class="font-serif-heading text-2xl sm:text-4xl font-bold text-white mb-2">
                    {{ $title }}
                </h3>
                <p class="text-sm text-stone-300">
                    {{ $subtitle }}
                </p>
            </div>

            <form action="{{ url('/contact') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="subject" value="Franchise & Partnership Enquiry">

                <!-- Honeypot -->
                <div class="hidden" aria-hidden="true">
                    <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                            Full Name *
                        </label>
                        <input type="text"
                               name="name"
                               required
                               placeholder="Enter your full name"
                               class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                            Mobile Number *
                        </label>
                        <input type="tel"
                               name="phone"
                               required
                               placeholder="+971 50 XXX XXXX"
                               class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Email Address -->
                    <div>
                        <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                            Email Address *
                        </label>
                        <input type="email"
                               name="email"
                               required
                               placeholder="name@company.com"
                               class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                    </div>

                    <!-- Select Brand Dropdown -->
                    <div>
                        <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                            Select Brand *
                        </label>
                        <select name="territory"
                                required
                                class="w-full bg-[#141416] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-[#C5A265]">
                            <option value="">- Select Brand -</option>
                            <option value="Shakespeare Middle East">1. Shakespeare Middle East</option>
                            <option value="Otantik Cafe & Restaurant">2. Otantik Cafe & Restaurant</option>
                            <option value="Chinese Connection">3. Chinese Connection</option>
                            <option value="Multi-Brand Portfolio Expansion">4. Multi-Brand Portfolio Expansion</option>
                        </select>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                        Message / Project Details *
                    </label>
                    <textarea name="message"
                              rows="5"
                              required
                              placeholder="Describe your territory interest, investment budget, experience in F&B, and proposed expansion timeline..."
                              class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]"></textarea>
                </div>

                <div class="pt-2 text-center">
                    <button type="submit" class="btn-gold w-full sm:w-auto px-10 py-4 rounded-xl text-sm font-bold inline-flex items-center justify-center gap-2 shadow-xl">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Submit Franchise Application</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

