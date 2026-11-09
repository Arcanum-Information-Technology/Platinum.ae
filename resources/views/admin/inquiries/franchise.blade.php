<x-layouts.admin title="Franchise Inquiries">

    <div class="space-y-6" x-data="{ viewModal: false, selectedInquiry: null }">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Franchise & Partner Inquiries</h1>
                    @if($unreadCount > 0)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500 text-stone-950">
                            {{ $unreadCount }} New
                        </span>
                    @endif
                </div>
                <p class="text-xs text-stone-400 mt-1">Review applicant qualifications, territory requests, and franchise expansion proposals</p>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.inquiries.franchise') }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ !request('status') ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    All ({{ \App\Models\ContactMessage::franchise()->count() }})
                </a>
                <a href="{{ route('admin.inquiries.franchise', ['status' => 'unread']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'unread' ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    New / Unread ({{ $unreadCount }})
                </a>
                <a href="{{ route('admin.inquiries.franchise', ['status' => 'under_review']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ request('status') === 'under_review' ? 'bg-amber-400 text-stone-950' : 'bg-stone-900 text-stone-400 border border-stone-800 hover:text-white' }}">
                    Under Review
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-stone-900 border border-stone-800 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.inquiries.franchise') }}" class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-80">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search applicant, brand, email, territory..."
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.inquiries.franchise') }}" class="text-xs text-stone-400 hover:text-white underline">Clear</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Applicant</th>
                            <th class="py-4 px-6">Target Brand</th>
                            <th class="py-4 px-6">Proposal Summary</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6">Stage</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($franchiseInquiries as $item)
                            <tr class="hover:bg-stone-800/30 transition-colors {{ !$item->is_read ? 'bg-amber-500/5' : '' }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if(!$item->is_read)
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shrink-0" title="New Application"></span>
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
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-950 text-emerald-300 border border-emerald-500/30 whitespace-nowrap">
                                        {{ $item->brand ?: 'Multi-Brand' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 max-w-sm">
                                    <p class="text-xs text-stone-300 line-clamp-2 leading-relaxed">{{ $item->message }}</p>
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
                                            <option value="under_review" {{ $item->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                            <option value="discovery_call" {{ $item->status === 'discovery_call' ? 'selected' : '' }}>Discovery Call</option>
                                            <option value="approved" {{ $item->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="declined" {{ $item->status === 'declined' ? 'selected' : '' }}>Declined</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                @click="selectedInquiry = {{ json_encode($item) }}; viewModal = true"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-stone-950 border border-stone-800 text-stone-300 hover:text-white hover:border-amber-400 transition-colors">
                                            View
                                        </button>

                                        <form action="{{ route('admin.messages.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this franchise application?');" class="inline">
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
                                <td colspan="6" class="py-12 text-center text-stone-500">
                                    <i data-lucide="briefcase" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    <p class="text-xs">No franchise inquiries received yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($franchiseInquiries->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $franchiseInquiries->links() }}
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
                    <h3 class="font-serif-heading text-lg font-bold text-white">Franchise Application Details</h3>
                    <button @click="viewModal = false" class="text-stone-400 hover:text-white p-1">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-4 pb-4 border-b border-stone-800">
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Applicant Name</span>
                            <span class="text-white font-bold text-sm block mt-0.5" x-text="selectedInquiry?.name"></span>
                        </div>
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Brand Selected</span>
                            <span class="text-emerald-400 font-semibold block mt-0.5" x-text="selectedInquiry?.brand || 'Multi-Brand'"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pb-4 border-b border-stone-800">
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Email Address</span>
                            <a :href="'mailto:' + selectedInquiry?.email" class="text-amber-400 underline block mt-0.5" x-text="selectedInquiry?.email"></a>
                        </div>
                        <div>
                            <span class="text-stone-500 block uppercase tracking-wider text-[10px]">Phone Number</span>
                            <a :href="'tel:' + selectedInquiry?.phone" class="text-white font-mono block mt-0.5" x-text="selectedInquiry?.phone || 'Not provided'"></a>
                        </div>
                    </div>

                    <div>
                        <span class="text-stone-500 block uppercase tracking-wider text-[10px] mb-1.5">Application Proposal & Background</span>
                        <div class="bg-stone-950 p-4 rounded-xl border border-stone-800 text-stone-200 leading-relaxed whitespace-pre-wrap" x-text="selectedInquiry?.message"></div>
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

