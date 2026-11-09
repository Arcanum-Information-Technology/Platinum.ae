@php
    $unreadCount = \App\Models\ContactMessage::unread()->count();
    $unreadBookings = \App\Models\ContactMessage::bookings()->unread()->count();
    $unreadFranchise = \App\Models\ContactMessage::franchise()->unread()->count();
    $unreadContact = \App\Models\ContactMessage::contact()->unread()->count();
    $currentRoute = Route::currentRouteName() ?? '';
    $siteName = 'Platinum Hospitality';
    $siteLogo = \App\Support\AssetUrl::make(\App\Models\Setting::get('site_logo') ?: 'images/platinum-logo.png');
@endphp

<div class="flex flex-col h-full">

    <!-- Brand Header -->
    <div class="min-h-20 px-5 py-3 flex items-center justify-between border-b border-stone-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
            <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-10 w-auto object-contain">
            <div class="min-w-0">
                <span class="font-serif-heading text-xs font-bold text-white block leading-snug truncate">
                    Platinum Hospitality
                </span>
                <span class="text-[10px] uppercase tracking-wider text-[#C5A265] font-semibold">
                    Corporate CMS
                </span>
            </div>
        </a>

        <button @click="sidebarOpen = false" class="lg:hidden text-stone-400 hover:text-white p-1">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Scrollable Nav Groups -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-7 text-xs">

        <!-- Main -->
        <div>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-stone-950 font-bold shadow-md shadow-amber-500/20' : 'text-stone-300 hover:bg-stone-800 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Website CMS -->
        <div class="space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                Website CMS
            </p>
            @can('pages.view')
                <a href="{{ route('admin.pages.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>Pages & Sections</span>
                </a>
            @endcan

            <a href="{{ route('admin.navigation.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.navigation.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <i data-lucide="compass" class="w-4 h-4"></i>
                <span>Navigation Menus</span>
            </a>
        </div>

        <!-- Inquiries, Bookings & Leads -->
        <div class="space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-[#C5A265]">
                Inquiries & Bookings
            </p>

            <!-- Table Bookings -->
            <a href="{{ route('admin.inquiries.bookings') }}"
               class="flex items-center justify-between px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries.bookings*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#C5A265]"></i>
                    <span>Table Bookings</span>
                </div>
                @if($unreadBookings > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-stone-950">
                        {{ $unreadBookings }}
                    </span>
                @endif
            </a>

            <!-- Franchise Inquiries -->
            <a href="{{ route('admin.inquiries.franchise') }}"
               class="flex items-center justify-between px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries.franchise*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="briefcase" class="w-4 h-4 text-emerald-400"></i>
                    <span>Franchise Inquiries</span>
                </div>
                @if($unreadFranchise > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-400 text-stone-950">
                        {{ $unreadFranchise }}
                    </span>
                @endif
            </a>

            <!-- Contact Messages -->
            <a href="{{ route('admin.inquiries.contact') }}"
               class="flex items-center justify-between px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries.contact*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="mail" class="w-4 h-4 text-sky-400"></i>
                    <span>Contact Messages</span>
                </div>
                @if($unreadContact > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-stone-950">
                        {{ $unreadContact }}
                    </span>
                @endif
            </a>
        </div>

        <!-- Brands & Culinary Portfolio -->
        <div class="space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                Brands & Portfolio
            </p>
            <a href="{{ route('admin.restaurant.info') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.restaurant.info') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                <span>Corporate Overview</span>
            </a>

            @can('menu.view')
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    <span>Portfolio Brands</span>
                </a>

                <a href="{{ route('admin.menu-items.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.menu-items.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="utensils" class="w-4 h-4"></i>
                    <span>Signature Dishes</span>
                </a>

                <a href="{{ route('admin.opening-hours.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.opening-hours.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span>Opening Hours</span>
                </a>
            @endcan
        </div>

        <!-- Media & Testimonials -->
        <div class="space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                Content & Media
            </p>
            @can('media.view')
                <a href="{{ route('admin.media.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.media.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="image" class="w-4 h-4"></i>
                    <span>Media Library</span>
                </a>
            @endcan

            <a href="{{ route('admin.testimonials.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.testimonials.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <i data-lucide="message-square" class="w-4 h-4"></i>
                <span>Testimonials</span>
            </a>

            <a href="{{ route('admin.faqs.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.faqs.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
                <span>FAQs</span>
            </a>
        </div>

        <!-- SEO & Marketing -->
        <div class="space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                SEO & Marketing
            </p>
            @can('seo.view')
                <a href="{{ route('admin.seo.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.seo.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span>SEO Settings</span>
                </a>
            @endcan
        </div>

        <!-- Users & Permissions -->
        @can('users.view')
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                    Access Control
                </p>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Users & Staff</span>
                </a>
            </div>
        @endcan

        <!-- Settings & System -->
        <div class="space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                System
            </p>
            @can('settings.view')
                <a href="{{ route('admin.settings.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Global Settings</span>
                </a>
            @endcan

            <a href="{{ route('admin.activity-logs.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.activity-logs.*') ? 'bg-stone-800 text-amber-400 font-semibold' : 'text-stone-400 hover:bg-stone-800/60 hover:text-stone-200' }}">
                <i data-lucide="activity" class="w-4 h-4"></i>
                <span>Activity Log</span>
            </a>
        </div>

    </div>

    <!-- Bottom User Profile Snippet -->
    <div class="p-4 border-t border-stone-800 bg-stone-900/60">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 truncate">
                <div class="w-9 h-9 rounded-full bg-amber-500/20 text-amber-400 font-bold flex items-center justify-center shrink-0 border border-amber-500/30">
                    {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()?->name }}</p>
                    <p class="text-[10px] text-stone-400 truncate">{{ Auth::user()?->email }}</p>
                </div>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="p-2 text-stone-400 hover:text-rose-400 transition-colors" title="Sign Out">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>

</div>
