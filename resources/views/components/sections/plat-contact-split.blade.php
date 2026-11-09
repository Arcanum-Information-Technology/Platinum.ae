@props(['data' => []])

@php
    $description = data_get($data, 'description', 'Connect with Platinum Hospitality Management for franchise opportunities, brand partnerships, and hospitality management solutions. Our team is ready to assist you with strategic guidance and collaboration discussions.');
    $location = data_get($data, 'location', 'United Arab Emirates');
    $phone = data_get($data, 'phone', '+971 4 360 8888');
    $email = data_get($data, 'email', 'info@platinumhospitality.ae');
@endphp

<section class="py-20 sm:py-28 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <!-- Left Column: Details & Socials (5 cols on lg) -->
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <h2 class="font-serif-heading text-3xl font-extrabold text-white tracking-tight mb-4">
                        Connect Directly With Our Corporate Team
                    </h2>
                    <p class="text-sm text-stone-300 leading-relaxed font-light">
                        {{ $description }}
                    </p>
                </div>

                <div class="plat-glass rounded-3xl p-8 border border-white/10 space-y-6">
                    <!-- Location -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#C5A265]/15 text-[#DFCA9B] flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-stone-400 block font-semibold">Location</span>
                            <span class="text-sm font-medium text-white">{{ $location }}</span>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#C5A265]/15 text-[#DFCA9B] flex items-center justify-center shrink-0">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-stone-400 block font-semibold">Phone</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-sm font-medium text-white hover:text-[#DFCA9B]">
                                {{ $phone }}
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#C5A265]/15 text-[#DFCA9B] flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-stone-400 block font-semibold">Email</span>
                            <a href="mailto:{{ $email }}" class="text-sm font-medium text-white hover:text-[#DFCA9B]">
                                {{ $email }}
                            </a>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="pt-4 border-t border-white/10">
                        <span class="text-xs uppercase tracking-wider text-stone-400 block font-semibold mb-3">Our Social Media</span>
                        <div class="flex items-center gap-3">
                            <a href="https://facebook.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 hover:border-[#C5A265] hover:text-[#C5A265] flex items-center justify-center text-stone-300 transition-all" aria-label="Facebook">
                                <i data-lucide="facebook" class="w-4 h-4"></i>
                            </a>
                            <a href="https://twitter.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 hover:border-[#C5A265] hover:text-[#C5A265] flex items-center justify-center text-stone-300 transition-all" aria-label="Twitter">
                                <i data-lucide="twitter" class="w-4 h-4"></i>
                            </a>
                            <a href="https://youtube.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 hover:border-[#C5A265] hover:text-[#C5A265] flex items-center justify-center text-stone-300 transition-all" aria-label="YouTube">
                                <i data-lucide="youtube" class="w-4 h-4"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 hover:border-[#C5A265] hover:text-[#C5A265] flex items-center justify-center text-stone-300 transition-all" aria-label="Instagram">
                                <i data-lucide="instagram" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Form (7 cols on lg) -->
            <div class="lg:col-span-7">
                <div class="plat-glass-gold p-8 sm:p-12 rounded-3xl shadow-2xl border border-[#C5A265]/40 space-y-6">
                    <div>
                        <h3 class="font-serif-heading text-2xl sm:text-3xl font-bold text-white mb-2">
                            Send Us A Message
                        </h3>
                        <p class="text-xs sm:text-sm text-stone-300">
                            Fill out the inquiry form below and our partnerships desk will respond promptly.
                        </p>
                    </div>

                    <form action="{{ url('/contact') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Honeypot -->
                        <div class="hidden" aria-hidden="true">
                            <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Full Name * -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                                    Full Name *
                                </label>
                                <input type="text"
                                       name="name"
                                       required
                                       placeholder="Your Full Name"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>

                            <!-- Email * -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                                    Email *
                                </label>
                                <input type="email"
                                       name="email"
                                       required
                                       placeholder="Your Email Address"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Subject * -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                                    Subject *
                                </label>
                                <input type="text"
                                       name="subject"
                                       required
                                       placeholder="General Enquiry / Franchise / Partnership"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>

                            <!-- Phone (Optional) -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                                    Phone Number
                                </label>
                                <input type="tel"
                                       name="phone"
                                       placeholder="+971 50 XXX XXXX"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-2">
                                Message (Optional)
                            </label>
                            <textarea name="message"
                                      rows="5"
                                      required
                                      placeholder="Share your questions, proposal, or dining inquiry with us..."
                                      class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-gold w-full py-4 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-xl">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>Send Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>

