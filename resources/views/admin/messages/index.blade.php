<x-layouts.admin title="Contact Inquiries">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Guest Inquiries & Messages</h1>
                <p class="text-xs text-stone-400 mt-1">Review contact inquiries, private event bookings, and general messages</p>
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.messages.index') }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ !request('status') ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    All
                </a>
                <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ request('status') === 'unread' ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    Unread
                </a>
                <a href="{{ route('admin.messages.index', ['status' => 'read']) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ request('status') === 'read' ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    Read
                </a>
            </div>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Sender</th>
                            <th class="py-4 px-6">Subject / Preview</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($messages as $msg)
                            <tr class="hover:bg-stone-800/30 transition-colors {{ !$msg->is_read ? 'bg-amber-500/5' : '' }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        @if(!$msg->is_read)
                                            <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0" title="Unread"></span>
                                        @endif
                                        <div>
                                            <span class="font-serif-heading text-sm font-bold text-white block">{{ $msg->name }}</span>
                                            <span class="text-[11px] text-stone-400">{{ $msg->email }} {{ $msg->phone ? '• ' . $msg->phone : '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-md">
                                    <span class="text-xs font-semibold text-stone-200 block">{{ $msg->subject ?? 'Website Inquiry' }}</span>
                                    <p class="text-[11px] text-stone-400 line-clamp-1 mt-0.5">{{ $msg->message }}</p>
                                </td>
                                <td class="py-4 px-6 text-stone-400 text-[11px] whitespace-nowrap">
                                    {{ $msg->created_at->format('M d, Y g:i A') }}
                                </td>
                                <td class="py-4 px-6">
                                    @if(!$msg->is_read)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/40">New / Unread</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-950 text-stone-500 border border-stone-800">Read</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.messages.show', $msg) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-stone-950 border border-stone-800 text-stone-300 hover:text-white hover:border-amber-400 transition-colors">
                                            View
                                        </a>

                                        <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete message?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 transition-colors" title="Delete Message">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-stone-500">
                                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    <p class="text-xs">No contact inquiries found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
