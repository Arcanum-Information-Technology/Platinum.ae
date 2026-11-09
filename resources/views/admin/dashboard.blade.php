<x-layouts.admin title="Dashboard">

    <div class="space-y-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Dashboard Overview
                </h1>
                <p class="text-xs text-stone-400 mt-1">
                    Welcome back, {{ Auth::user()->name }}. Here is a summary of your restaurant system.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.menu-items.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-md">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>New Menu Item</span>
                </a>
                <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider text-white bg-stone-900 border border-stone-800 hover:bg-stone-800 transition-colors">
                    <i data-lucide="file-plus" class="w-4 h-4"></i>
                    <span>New Page</span>
                </a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">

            <!-- Card 1: Table Bookings -->
            <a href="{{ route('admin.inquiries.bookings') }}" class="bg-stone-900 border border-stone-800 p-6 rounded-3xl shadow-xl hover:border-amber-400/50 transition-all group block">
                <div class="flex items-center justify-between text-stone-400 mb-3">
                    <span class="text-xs uppercase font-semibold tracking-wider group-hover:text-amber-400">Table Bookings</span>
                    <div class="p-2 rounded-xl bg-amber-500/10 text-amber-400">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="font-serif-heading text-3xl font-extrabold text-white">
                    {{ $stats['total_bookings'] }}
                </div>
                <p class="text-[11px] text-stone-400 mt-1">
                    @if($stats['unread_bookings'] > 0)
                        <span class="text-amber-400 font-semibold">{{ $stats['unread_bookings'] }} new</span> pending
                    @else
                        All table requests handled
                    @endif
                </p>
            </a>

            <!-- Card 2: Franchise Inquiries -->
            <a href="{{ route('admin.inquiries.franchise') }}" class="bg-stone-900 border border-stone-800 p-6 rounded-3xl shadow-xl hover:border-emerald-400/50 transition-all group block">
                <div class="flex items-center justify-between text-stone-400 mb-3">
                    <span class="text-xs uppercase font-semibold tracking-wider group-hover:text-emerald-400">Franchise Leads</span>
                    <div class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">
                        <i data-lucide="briefcase" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="font-serif-heading text-3xl font-extrabold text-white">
                    {{ $stats['total_franchise'] }}
                </div>
                <p class="text-[11px] text-stone-400 mt-1">
                    @if($stats['unread_franchise'] > 0)
                        <span class="text-emerald-400 font-semibold">{{ $stats['unread_franchise'] }} new</span> applications
                    @else
                        Expansion applications
                    @endif
                </p>
            </a>

            <!-- Card 3: Contact Messages -->
            <a href="{{ route('admin.inquiries.contact') }}" class="bg-stone-900 border border-stone-800 p-6 rounded-3xl shadow-xl hover:border-sky-400/50 transition-all group block">
                <div class="flex items-center justify-between text-stone-400 mb-3">
                    <span class="text-xs uppercase font-semibold tracking-wider group-hover:text-sky-400">Contact Messages</span>
                    <div class="p-2 rounded-xl bg-sky-500/10 text-sky-400">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="font-serif-heading text-3xl font-extrabold text-white">
                    {{ $stats['total_contact'] }}
                </div>
                <p class="text-[11px] text-stone-400 mt-1">
                    @if($stats['unread_contact'] > 0)
                        <span class="text-sky-400 font-semibold">{{ $stats['unread_contact'] }} unread</span> messages
                    @else
                        Concierge inquiries
                    @endif
                </p>
            </a>

            <!-- Card 4: CMS Pages -->
            <a href="{{ route('admin.pages.index') }}" class="bg-stone-900 border border-stone-800 p-6 rounded-3xl shadow-xl hover:border-amber-400/50 transition-all group block">
                <div class="flex items-center justify-between text-stone-400 mb-3">
                    <span class="text-xs uppercase font-semibold tracking-wider group-hover:text-amber-400">CMS Pages</span>
                    <div class="p-2 rounded-xl bg-amber-500/10 text-amber-400">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="font-serif-heading text-3xl font-extrabold text-white">
                    {{ $stats['total_pages'] }}
                </div>
                <p class="text-[11px] text-stone-400 mt-1">
                    <span class="text-emerald-400 font-semibold">{{ $stats['published_pages'] }}</span> published live
                </p>
            </a>

        </div>

        <!-- 2 Column Section: Recent Inquiries & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left: Recent Inquiries -->
            <div class="lg:col-span-7 bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <i data-lucide="inbox" class="w-5 h-5 text-amber-400"></i>
                        <h3 class="font-serif-heading text-lg font-bold text-white">Recent Guest Inquiries</h3>
                    </div>
                    <a href="{{ route('admin.messages.index') }}" class="text-xs text-amber-400 hover:text-amber-300 font-semibold">
                        View All
                    </a>
                </div>

                @if($recentMessages->isEmpty())
                    <div class="text-center py-10 text-stone-500 text-xs">
                        <i data-lucide="mail-check" class="w-8 h-8 mx-auto mb-2 text-stone-600"></i>
                        <span>No inquiries received yet.</span>
                    </div>
                @else
                    <div class="divide-y divide-stone-800/80">
                        @foreach($recentMessages as $msg)
                            <div class="py-3.5 flex items-start justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-serif-heading text-sm font-bold text-white">{{ $msg->name }}</span>
                                        @if(!$msg->is_read)
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/40">New</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-stone-400 line-clamp-1">{{ $msg->subject }}: {{ $msg->message }}</p>
                                    <span class="text-[10px] text-stone-500">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="text-xs text-stone-400 hover:text-white px-3 py-1.5 rounded-lg bg-stone-950 border border-stone-800 hover:border-stone-700 shrink-0">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Activity Log -->
            <div class="lg:col-span-5 bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <i data-lucide="activity" class="w-5 h-5 text-amber-400"></i>
                        <h3 class="font-serif-heading text-lg font-bold text-white">System Audit Log</h3>
                    </div>
                    <a href="{{ route('admin.activity-logs.index') }}" class="text-xs text-amber-400 hover:text-amber-300 font-semibold">
                        View All
                    </a>
                </div>

                @if($recentActivities->isEmpty())
                    <div class="text-center py-10 text-stone-500 text-xs">
                        <span>No activity recorded yet.</span>
                    </div>
                @else
                    <div class="space-y-3.5">
                        @foreach($recentActivities as $act)
                            <div class="flex items-start gap-3 text-xs">
                                <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0 mt-1.5"></span>
                                <div class="flex-1">
                                    <p class="text-stone-300 font-medium leading-snug">{{ $act->description }}</p>
                                    <span class="text-[10px] text-stone-500">
                                        {{ $act->user?->name ?? 'System' }} • {{ $act->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>

</x-layouts.admin>
