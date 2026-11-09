<x-layouts.admin title="Audit & Activity Logs">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">System Activity & Audit Log</h1>
                <p class="text-xs text-stone-400 mt-1">Immutable trail of administrative updates, menu changes, and publishing events</p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search actions or entities..."
                       class="bg-stone-900 border border-stone-800 rounded-xl px-4 py-2 text-xs text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none">
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-amber-400 text-stone-950 font-semibold text-xs hover:bg-amber-300 transition-colors">
                    Filter
                </button>
                @if(request('search') || request('action'))
                    <a href="{{ route('admin.activity-logs.index') }}" class="p-2 text-stone-400 hover:text-white transition-colors" title="Clear Filters">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Timestamp</th>
                            <th class="py-4 px-6">User / Actor</th>
                            <th class="py-4 px-6">Action</th>
                            <th class="py-4 px-6">Description</th>
                            <th class="py-4 px-6">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($logs as $log)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6 text-stone-400 whitespace-nowrap text-[11px] font-mono">
                                    {{ $log->created_at->format('M d, Y H:i:s') }}
                                    <span class="block text-[10px] text-stone-500 font-sans">({{ $log->created_at->diffForHumans() }})</span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($log->user)
                                        <span class="font-serif-heading font-bold text-white text-xs block">{{ $log->user->name }}</span>
                                        <span class="text-[10px] text-stone-500 font-mono">{{ $log->user->email }}</span>
                                    @else
                                        <span class="text-xs text-stone-500 italic">System / Visitor</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-stone-200 text-xs">
                                    {{ $log->description }}
                                </td>
                                <td class="py-4 px-6 font-mono text-[11px] text-stone-500 whitespace-nowrap">
                                    {{ $log->ip_address ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-stone-500">
                                    <i data-lucide="history" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    <p class="text-xs">No activity entries found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
