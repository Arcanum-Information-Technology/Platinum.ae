<x-layouts.admin title="Contact Messages">

    <div class="space-y-6" x-data="{ viewModal: false, selectedMessage: null }">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Contact Us Messages</h1>
                    @if($unreadCount > 0)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500 text-stone-950">
                            {{ $unreadCount }} New
                        </span>
                    @endif
                </div>
                <p class="text-xs text-stone-400 mt-1">Direct inquiries received from the website contact page and concierge desk</p>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.inquiries.contact') }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ !request('status') ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    All ({{ \App\Models\ContactMessage::contact()->count() }})
                </a>
                <a href="{{ route('admin.inquiries.contact', ['status' => 'unread']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'unread' ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    New / Unread ({{ $unreadCount }})
                </a>
                <a href="{{ route('admin.inquiries.contact', ['status' => 'resolved']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'resolved' ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    Resolved
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-stone-900 border border-stone-800 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.inquiries.contact') }}" class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-80">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by sender, email, subject, message..."
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.inquiries.contact') }}" class="text-xs text-stone-400 hover:text-white underline">Clear</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Sender</th>
                            <th class="py-4 px-6">Subject / Message</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($contactInquiries as $item)
                            <tr class="hover:bg-stone-800/30 transition-colors {{ !$item->is_read ? 'bg-amber-500/5' : '' }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if(!$item->is_read)
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shrink-0" title="New Message"></span>
                                        @endif
                                        <div>
                                            <span class="font-serif-heading text-sm font-bold text-white block">{{ $item->name }}</span>
                                            <div class="flex items-center gap-2 mt-0.5 text-[11px] text-stone-400">
                                                <a href="mailto:{{ $item->email }}" class="hover:text-amber-400">{{ $item->email }}</a>
                                                @if($item->phone)
                                                    <span>•</span>
                                                    <a href="tel:{{ $item->phone }}" class="hover:text-amber-400">{{ $item->phone }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-md">
                                    <span class="text-xs font-semibold text-stone-200 block">{{ $item->subject ?: 'General Inquiry' }}</span>
                                    <p class="text-[11px] text-stone-400 line-clamp-1 mt-0.5 leading-relaxed">{{ $item->message }}</p>
                                </td>
                                <td class="py-4 px-6 text-stone-400 text-[11px] whitespace-nowrap">
                                    {{ $item->created_at->format('M d, Y') }}<br>
                                    <span class="text-stone-500 text-[10px]">{{ $item->created_at->format('g:i A') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <form action="{{ route('admin.messages.status', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="bg-stone-950 border border-stone-800 text-[11px] font-semibold rounded-lg px-2.5 py-1 text-white focus:outline-none focus:border-amber-400">
                                            <option value="new" {{ $item->status === 'new' ? 'selected' : '' }}>New</option>
                                            <option value="contacted" {{ $item->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="resolved" {{ $item->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="archived" {{ $item->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                @click="selectedMessage = {{ json_encode($item) }}; viewModal = true"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-stone-950 border border-stone-800 text-stone-300 hover:text-white hover:border-amber-400 transition-colors">
                                            View
                                        </button>

                                        <form action="{{ route('admin.messages.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this contact message?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 transition-colors" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-stone-500">
                                    <i data-lucide="mail" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    <p class="text-xs">No contact inquiries received yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($contactInquiries->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $contactInquiries->links() }}
                </div>
            @endif
        </div>

        <!-- Detail Modal -->
        <div x-show="viewModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
             style="display: none;">
            <div @click.away="viewModal = false" class="bg-stone-900 border border-stone-800 rounded-3xl w-full max-w-xl flex flex-col shadow-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-stone-800 flex items-center justify-between">
                    <h3 class="font-serif-heading text-lg font-bold text-white">Contact Message Details</h3>
                    <button @click="viewModal = false" class="text-stone-400 hover:text-white p-1">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-4 pb-4 border-b border-stone-800">
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Sender Name</span>
                            <span class="text-white font-bold text-sm block mt-0.5" x-text="selectedMessage?.name"></span>
                        </div>
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Subject</span>
                            <span class="text-amber-400 font-semibold block mt-0.5" x-text="selectedMessage?.subject || 'General Inquiry'"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pb-4 border-b border-stone-800">
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Email Address</span>
                            <a :href="'mailto:' + selectedMessage?.email" class="text-amber-400 underline block mt-0.5" x-text="selectedMessage?.email"></a>
                        </div>
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Phone Number</span>
                            <a :href="'tel:' + selectedMessage?.phone" class="text-white font-mono block mt-0.5" x-text="selectedMessage?.phone || 'Not provided'"></a>
                        </div>
                    </div>

                    <div>
                        <span class="text-stone-500 block uppercase tracking-wider text-[10px] mb-1.5">Message Content</span>
                        <div class="bg-stone-950 p-4 rounded-xl border border-stone-800 text-stone-200 leading-relaxed whitespace-pre-wrap" x-text="selectedMessage?.message"></div>
                    </div>
                </div>

                <div class="px-6 py-3 border-t border-stone-800 bg-stone-950/60 flex justify-end">
                    <button @click="viewModal = false" class="px-5 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-white text-xs font-semibold">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>

</x-layouts.admin>

