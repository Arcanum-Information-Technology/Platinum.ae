<header class="h-16 bg-stone-900/80 border-b border-stone-800 flex items-center justify-between px-4 sm:px-6 lg:px-8 backdrop-blur-md">
    <!-- Left: Hamburger toggle for mobile -->
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="lg:hidden p-2 text-stone-400 hover:text-white rounded-lg hover:bg-stone-800 focus:outline-none">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <div class="hidden sm:flex items-center gap-2 text-xs text-stone-400">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Restaurant Status: <strong class="text-emerald-400">Live & Accepting Bookings</strong></span>
        </div>
    </div>

    <!-- Right: Quick actions -->
    <div class="flex items-center gap-4">
        <!-- View Public Website -->
        <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold text-stone-300 bg-stone-800 hover:bg-stone-700 hover:text-white border border-stone-700 transition-colors">
            <i data-lucide="external-link" class="w-3.5 h-3.5 text-amber-400"></i>
            <span>View Website</span>
        </a>

        <!-- Media Shortcut -->
        <button @click="$dispatch('open-media-picker', { targetInput: null })"
                class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs text-stone-400 hover:text-amber-400 hover:bg-stone-800 transition-colors">
            <i data-lucide="image" class="w-4 h-4"></i>
            <span>Media Library</span>
        </button>

        <!-- Profile Link -->
        <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 text-xs text-stone-300 hover:text-white transition-colors">
            <div class="w-7 h-7 rounded-full bg-amber-500/20 text-amber-400 font-bold flex items-center justify-center text-xs border border-amber-500/40">
                {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
            </div>
            <span class="hidden md:inline">{{ Auth::user()?->name }}</span>
        </a>
    </div>
</header>
