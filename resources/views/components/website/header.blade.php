@php
    $siteName = \App\Models\Setting::get('site_name', 'Platinum Hospitality Management');
    $siteLogo = \App\Support\AssetUrl::make(\App\Models\Setting::get('site_logo') ?: 'images/platinum-logo.png');
    $phone = \App\Models\Setting::get('restaurant_phone', '+971 4 360 8888');
    $email = \App\Models\Setting::get('restaurant_email', 'info@platinumhospitality.ae');
@endphp

<header class="sticky top-0 z-50 w-full transition-transform duration-300 ease-in-out will-change-transform"
        :class="{
            '-translate-y-full': isHidden && !mobileOpen,
            'translate-y-0': !isHidden || mobileOpen
        }"
        x-data="{
            scrolled: false,
            isHidden: false,
            lastScrollY: 0,
            mobileOpen: false,
            brandsOpen: false,
            scrollThreshold: 8,
            init() {
                this.lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
                window.addEventListener('scroll', () => {
                    const currentY = window.pageYOffset || document.documentElement.scrollTop;
                    this.scrolled = currentY > 20;

                    if (Math.abs(currentY - this.lastScrollY) < this.scrollThreshold) {
                        return;
                    }

                    if (currentY > 100 && currentY > this.lastScrollY) {
                        // Scrolling DOWN: Hide navbar to give full immersive UI
                        this.isHidden = true;
                    } else if (currentY < this.lastScrollY) {
                        // Scrolling UP: Reveal navbar smoothly with premium feel
                        this.isHidden = false;
                    }

                    if (currentY <= 50) {
                        this.isHidden = false;
                    }

                    this.lastScrollY = currentY;
                }, { passive: true });
            }
        }">

    <!-- Top Utility Bar -->
    <div class="hidden lg:block bg-[#070708] border-b border-white/5 py-2 text-xs text-stone-400">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                    <span>United Arab Emirates • Dubai & Abu Dhabi</span>
                </span>
                <span class="flex items-center gap-2">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                    <a href="mailto:{{ $email }}" class="hover:text-[#DFCA9B] transition-colors">{{ $email }}</a>
                </span>
            </div>
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-[#C5A265]"></i>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="font-semibold text-stone-300 hover:text-[#DFCA9B] transition-colors">{{ $phone }}</a>
                </span>
                <div class="flex items-center gap-3 pl-4 border-l border-white/10 text-stone-400">
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="hover:text-[#C5A265] transition-colors" aria-label="Instagram">
                        <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                    </a>
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="hover:text-[#C5A265] transition-colors" aria-label="Facebook">
                        <i data-lucide="facebook" class="w-3.5 h-3.5"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" class="hover:text-[#C5A265] transition-colors" aria-label="LinkedIn">
                        <i data-lucide="linkedin" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div :class="scrolled ? 'plat-glass py-3 shadow-2xl border-b border-[#C5A265]/20' : 'bg-[#0A0A0A]/95 py-4 border-b border-white/10'"
         class="transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-12 sm:h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-medium tracking-wide">

                <!-- 1. Home -->
                <a href="{{ url('/') }}"
                   class="relative py-2 transition-colors {{ request()->is('/') ? 'text-[#DFCA9B] font-semibold' : 'text-stone-300 hover:text-white' }}">
                    <span>Home</span>
                    @if(request()->is('/'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent"></span>
                    @endif
                </a>

                <!-- 2. About us -->
                <a href="{{ url('/about') }}"
                   class="relative py-2 transition-colors {{ request()->is('about*') ? 'text-[#DFCA9B] font-semibold' : 'text-stone-300 hover:text-white' }}">
                    <span>About Us</span>
                    @if(request()->is('about*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent"></span>
                    @endif
                </a>

                <!-- 3. Brands (Dropdown with 3 options) -->
                <div class="relative"
                     x-data="{ open: false }"
                     @mouseenter="open = true"
                     @mouseleave="open = false">
                    <button type="button"
                            @click="open = !open"
                            class="flex items-center gap-1.5 py-2 transition-colors {{ request()->is('brands*') ? 'text-[#DFCA9B] font-semibold' : 'text-stone-300 hover:text-white' }}">
                        <span>Brands</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-[#C5A265]' : ''"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute left-0 mt-1 w-80 rounded-2xl plat-glass-gold shadow-2xl p-3 space-y-1.5 border border-[#C5A265]/30">

                        <div class="px-3 py-2 border-b border-white/5">
                            <span class="text-[10px] font-bold tracking-widest uppercase text-[#DFCA9B]">Our Restaurant Portfolio</span>
                        </div>

                        <!-- Brand 1: Shakespeare Middle East -->
                        <a href="{{ url('/brands/shakespeare-middle-east') }}"
                           class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                            <div class="w-9 h-9 rounded-lg bg-[#C5A265]/15 border border-[#C5A265]/30 flex items-center justify-center shrink-0 text-[#DFCA9B] group-hover/item:scale-110 transition-transform">
                                <i data-lucide="coffee" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-serif-heading font-bold text-white group-hover/item:text-[#DFCA9B] transition-colors block text-sm">
                                    Shakespeare Middle East
                                </span>
                                <span class="text-[11px] text-stone-400 block leading-tight">
                                    Victorian Café, Restaurant & Artisanal Patisserie
                                </span>
                            </div>
                        </a>

                        <!-- Brand 2: Otantik Café & Restaurant -->
                        <a href="{{ url('/brands/otantik-cafe-restaurant') }}"
                           class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                            <div class="w-9 h-9 rounded-lg bg-[#C5A265]/15 border border-[#C5A265]/30 flex items-center justify-center shrink-0 text-[#DFCA9B] group-hover/item:scale-110 transition-transform">
                                <i data-lucide="flame" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-serif-heading font-bold text-white group-hover/item:text-[#DFCA9B] transition-colors block text-sm">
                                    Otantik Café & Restaurant
                                </span>
                                <span class="text-[11px] text-stone-400 block leading-tight">
                                    Middle Eastern Charcoal Grills, Mezze & Shisha Lounge
                                </span>
                            </div>
                        </a>

                        <!-- Brand 3: Chinese Connection -->
                        <a href="{{ url('/brands/chinese-connection') }}"
                           class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                            <div class="w-9 h-9 rounded-lg bg-[#C5A265]/15 border border-[#C5A265]/30 flex items-center justify-center shrink-0 text-[#DFCA9B] group-hover/item:scale-110 transition-transform">
                                <i data-lucide="utensils" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-serif-heading font-bold text-white group-hover/item:text-[#DFCA9B] transition-colors block text-sm">
                                    Chinese Connection
                                </span>
                                <span class="text-[11px] text-stone-400 block leading-tight">
                                    Contemporary Pan-Asian, Dim Sum & Sizzling Wok
                                </span>
                            </div>
                        </a>

                        <div class="pt-2 border-t border-white/5">
                            <a href="{{ url('/brands') }}" class="text-xs text-[#DFCA9B] hover:text-white font-semibold flex items-center justify-between px-3 py-1">
                                <span>View Full Brand Directory</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. Franchise -->
                <a href="{{ url('/franchise') }}"
                   class="relative py-2 transition-colors {{ request()->is('franchise*') ? 'text-[#DFCA9B] font-semibold' : 'text-stone-300 hover:text-white' }}">
                    <span>Franchise</span>
                    @if(request()->is('franchise*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent"></span>
                    @endif
                </a>

                <!-- 5. Contact us -->
                <a href="{{ url('/contact') }}"
                   class="relative py-2 transition-colors {{ request()->is('contact*') ? 'text-[#DFCA9B] font-semibold' : 'text-stone-300 hover:text-white' }}">
                    <span>Contact Us</span>
                    @if(request()->is('contact*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent"></span>
                    @endif
                </a>
            </nav>

            <!-- CTA Actions (Desktop) -->
            <div class="hidden lg:flex items-center gap-4">
                <a href="{{ url('/contact#book-table') }}"
                   class="btn-outline-gold text-xs px-4 py-2.5 rounded-xl inline-flex items-center gap-2">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    <span>Book Table</span>
                </a>

                <a href="{{ url('/franchise') }}"
                   class="btn-gold text-xs px-5 py-2.5 rounded-xl inline-flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                    <span>Partner With Us</span>
                </a>
            </div>

            <!-- Mobile Hamburger Toggle -->
            <button type="button"
                    @click="mobileOpen = !mobileOpen"
                    class="lg:hidden p-2 rounded-xl text-stone-300 hover:text-[#C5A265] hover:bg-white/5 transition-colors focus:outline-none"
                    aria-label="Toggle navigation menu">
                <i data-lucide="menu" x-show="!mobileOpen" class="w-6 h-6"></i>
                <i data-lucide="x" x-show="mobileOpen" x-cloak class="w-6 h-6"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-[#0D0D0E]/98 border-b border-[#C5A265]/30 shadow-2xl px-6 py-6 space-y-4">

        <nav class="space-y-2 text-base">
            <a href="{{ url('/') }}"
               @click="mobileOpen = false"
               class="block px-3 py-2 rounded-xl font-medium {{ request()->is('/') ? 'text-[#DFCA9B] bg-white/5 font-bold' : 'text-stone-300 hover:text-white' }}">
                Home
            </a>

            <a href="{{ url('/about') }}"
               @click="mobileOpen = false"
               class="block px-3 py-2 rounded-xl font-medium {{ request()->is('about*') ? 'text-[#DFCA9B] bg-white/5 font-bold' : 'text-stone-300 hover:text-white' }}">
                About Us
            </a>

            <!-- Mobile Brands Accordion -->
            <div x-data="{ expanded: false }" class="rounded-xl overflow-hidden bg-white/5">
                <button type="button"
                        @click="expanded = !expanded"
                        class="w-full flex items-center justify-between px-3 py-2.5 font-medium text-stone-200 hover:text-[#DFCA9B]">
                    <span>Brands</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180 text-[#C5A265]' : ''"></i>
                </button>
                <div x-show="expanded" x-cloak class="px-4 pb-3 space-y-2 pt-1 border-t border-white/5 text-sm">
                    <a href="{{ url('/brands/shakespeare-middle-east') }}" @click="mobileOpen = false" class="block text-stone-300 hover:text-[#DFCA9B] py-1">
                        1. Shakespeare Middle East
                    </a>
                    <a href="{{ url('/brands/otantik-cafe-restaurant') }}" @click="mobileOpen = false" class="block text-stone-300 hover:text-[#DFCA9B] py-1">
                        2. Otantik Café & Restaurant
                    </a>
                    <a href="{{ url('/brands/chinese-connection') }}" @click="mobileOpen = false" class="block text-stone-300 hover:text-[#DFCA9B] py-1">
                        3. Chinese Connection
                    </a>
                    <a href="{{ url('/brands') }}" @click="mobileOpen = false" class="block text-[#DFCA9B] font-semibold pt-1">
                        View All Brands →
                    </a>
                </div>
            </div>

            <a href="{{ url('/franchise') }}"
               @click="mobileOpen = false"
               class="block px-3 py-2 rounded-xl font-medium {{ request()->is('franchise*') ? 'text-[#DFCA9B] bg-white/5 font-bold' : 'text-stone-300 hover:text-white' }}">
                Franchise
            </a>

            <a href="{{ url('/contact') }}"
               @click="mobileOpen = false"
               class="block px-3 py-2 rounded-xl font-medium {{ request()->is('contact*') ? 'text-[#DFCA9B] bg-white/5 font-bold' : 'text-stone-300 hover:text-white' }}">
                Contact Us
            </a>
        </nav>

        <div class="pt-4 border-t border-white/10 flex flex-col gap-3">
            <a href="{{ url('/contact#book-table') }}"
               @click="mobileOpen = false"
               class="btn-outline-gold text-center py-2.5 rounded-xl text-xs">
                Book Table Online
            </a>
            <a href="{{ url('/franchise') }}"
               @click="mobileOpen = false"
               class="btn-gold text-center py-2.5 rounded-xl text-xs">
                Partner With Us
            </a>
        </div>
    </div>
</header>
