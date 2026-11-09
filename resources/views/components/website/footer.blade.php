@php
    $siteName = \App\Models\Setting::get('site_name', 'Platinum Hospitality Management');
    $siteLogo = \App\Support\AssetUrl::make(\App\Models\Setting::get('site_logo') ?: 'images/platinum-logo.png');
    $phone = \App\Models\Setting::get('restaurant_phone', '+971 4 360 8888');
    $email = \App\Models\Setting::get('restaurant_email', 'info@platinumhospitality.ae');
    $address = \App\Models\Setting::get('restaurant_address', 'United Arab Emirates');
@endphp

<footer class="bg-[#070708] border-t border-white/10 text-stone-300 relative overflow-hidden">
    <!-- Ambient Gold Glow Backing -->
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-96 h-96 bg-[#C5A265]/10 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Newsletter Bar Section -->
    <div class="border-b border-white/5 py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="plat-glass-gold p-8 sm:p-10 rounded-3xl flex flex-col lg:flex-row items-center justify-between gap-8 border border-[#C5A265]/30">
                <div class="max-w-xl text-center lg:text-left">
                    <span class="gold-badge mb-3">Newsletter</span>
                    <h3 class="font-serif-heading text-2xl sm:text-3xl font-bold text-white mb-2">
                        Subscribe Our Newsletter
                    </h3>
                    <p class="text-sm text-stone-400">
                        Stay informed with insights, updates, and hospitality industry news.
                    </p>
                </div>

                <form action="{{ url('/contact') }}" method="POST" class="w-full lg:w-auto flex-1 max-w-md">
                    @csrf
                    <input type="hidden" name="subject" value="Newsletter Subscription">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email"
                               name="email"
                               required
                               placeholder="Your Email Address"
                               class="flex-1 bg-black/60 border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                        <button type="submit" class="btn-gold px-6 py-3 rounded-xl text-xs whitespace-nowrap">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Footer Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">

            <!-- Column 1: Brand & Statement (2 cols on lg) -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="inline-block group">
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-14 w-auto object-contain">
                </a>
                <p class="text-sm text-stone-400 leading-relaxed max-w-sm">
                    Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts.
                </p>

                <div class="pt-2">
                    <blockquote class="text-xs italic text-[#DFCA9B] border-l-2 border-[#C5A265] pl-3 py-1">
                        "Driving Growth Through Strategic Hospitality Management. Built on experience. Driven by performance."
                    </blockquote>
                </div>

                <!-- Social Links -->
                <div class="flex items-center gap-3 pt-3">
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:border-[#C5A265] hover:bg-[#C5A265]/20 text-[#DFCA9B] hover:text-white flex items-center justify-center transition-all shadow-md group" aria-label="Facebook">
                        <svg class="w-5 h-5 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:border-[#C5A265] hover:bg-[#C5A265]/20 text-[#DFCA9B] hover:text-white flex items-center justify-center transition-all shadow-md group" aria-label="Instagram">
                        <svg class="w-5 h-5 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:border-[#C5A265] hover:bg-[#C5A265]/20 text-[#DFCA9B] hover:text-white flex items-center justify-center transition-all shadow-md group" aria-label="LinkedIn">
                        <svg class="w-5 h-5 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:border-[#C5A265] hover:bg-[#C5A265]/20 text-[#DFCA9B] hover:text-white flex items-center justify-center transition-all shadow-md group" aria-label="X (Twitter)">
                        <svg class="w-5 h-5 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Column 2: Navigation Links -->
            <div class="space-y-4">
                <h4 class="font-serif-heading text-lg font-bold text-white border-b border-white/10 pb-2">
                    Navigation
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ url('/') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors">About Us</a></li>
                    <li><a href="{{ url('/brands') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors">Our Brands</a></li>
                    <li><a href="{{ url('/franchise') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors">Franchise Opportunities</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Portfolio Brands -->
            <div class="space-y-4">
                <h4 class="font-serif-heading text-lg font-bold text-white border-b border-white/10 pb-2">
                    Our Brands
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ url('/brands/shakespeare-middle-east') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors block">
                            Shakespeare Middle East
                        </a>
                        <span class="text-[11px] text-stone-500 block">Café & Patisserie</span>
                    </li>
                    <li>
                        <a href="{{ url('/brands/otantik-cafe-restaurant') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors block">
                            Otantik Café & Restaurant
                        </a>
                        <span class="text-[11px] text-stone-500 block">Middle Eastern & Shisha</span>
                    </li>
                    <li>
                        <a href="{{ url('/brands/chinese-connection') }}" class="text-stone-400 hover:text-[#DFCA9B] transition-colors block">
                            Chinese Connection
                        </a>
                        <span class="text-[11px] text-stone-500 block">Contemporary Pan-Asian</span>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Contact & Locations -->
            <div class="space-y-4">
                <h4 class="font-serif-heading text-lg font-bold text-white border-b border-white/10 pb-2">
                    Corporate Office
                </h4>
                <div class="space-y-3 text-sm text-stone-400">
                    <p class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-[#C5A265] shrink-0 mt-0.5"></i>
                        <span>United Arab Emirates</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="w-4 h-4 text-[#C5A265] shrink-0"></i>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="hover:text-white transition-colors">{{ $phone }}</a>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-[#C5A265] shrink-0"></i>
                        <a href="mailto:{{ $email }}" class="hover:text-white transition-colors">{{ $email }}</a>
                    </p>
                    <div class="pt-2">
                        <a href="{{ url('/contact#book-table') }}" class="btn-outline-gold text-[11px] px-3 py-1.5 rounded-lg inline-flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            <span>View Operating Hours</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Copyright Bar -->
    <div class="border-t border-white/5 py-6 bg-black text-xs text-stone-500 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>© {{ date('Y') }} Platinum Hospitality Management. All Rights Reserved.</p>
            <div class="flex items-center gap-6">
                <a href="{{ url('/privacy-policy') }}" class="hover:text-stone-300 transition-colors">Privacy Policy</a>
                <a href="{{ url('/terms-conditions') }}" class="hover:text-stone-300 transition-colors">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>
