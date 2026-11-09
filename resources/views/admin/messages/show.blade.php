<x-layouts.admin title="View Message">

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.messages.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to All Inquiries</span>
            </a>

            <div class="flex items-center gap-3">
                <form action="{{ route('admin.messages.toggle-read', $message) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl border border-stone-800 bg-stone-900 text-xs font-semibold text-stone-300 hover:text-white transition-colors">
                        Mark as {{ $message->is_read ? 'Unread' : 'Read' }}
                    </button>
                </form>

                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-xl border border-stone-800 bg-stone-900 text-stone-400 hover:text-rose-400 transition-colors" title="Delete">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            <!-- Header Info -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-stone-800 pb-6">
                <div>
                    <h2 class="font-serif-heading text-xl font-bold text-white">{{ $message->subject ?? 'Website Inquiry' }}</h2>
                    <p class="text-xs text-stone-400 mt-1">Received {{ $message->created_at->format('l, F j, Y \a\t g:i A') }}</p>
                </div>

                <div class="text-left sm:text-right">
                    <span class="font-serif-heading text-sm font-bold text-white block">{{ $message->name }}</span>
                    <a href="mailto:{{ $message->email }}" class="text-xs text-amber-400 hover:underline block">{{ $message->email }}</a>
                    @if($message->phone)
                        <a href="tel:{{ $message->phone }}" class="text-xs text-stone-400 hover:text-stone-300 block mt-0.5">{{ $message->phone }}</a>
                    @endif
                </div>
            </div>

            <!-- Message Body -->
            <div class="bg-stone-950 border border-stone-800 rounded-2xl p-6 text-sm text-stone-200 leading-relaxed whitespace-pre-line">
                {{ $message->message }}
            </div>

            <!-- Reply CTA -->
            <div class="flex items-center gap-4 pt-2">
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . ($message->subject ?? 'Your inquiry at Saffron & Thyme')) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    <i data-lucide="mail-check" class="w-4 h-4"></i>
                    <span>Reply via Email Client</span>
                </a>

                @if($message->phone)
                    <a href="tel:{{ $message->phone }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-stone-300 bg-stone-950 border border-stone-800 hover:text-white transition-colors">
                        <i data-lucide="phone-call" class="w-4 h-4"></i>
                        <span>Call Guest</span>
                    </a>
                @endif
            </div>

            <!-- Staff Notes -->
            <div class="pt-6 border-t border-stone-800 space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-stone-300">Staff Notes / Reservation Details</h4>
                <form action="{{ route('admin.messages.notes', $message) }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="notes"
                              rows="3"
                              placeholder="Record internal notes, e.g. 'Confirmed reservation for 8 guests on Friday', 'Table 4 reserved'..."
                              class="w-full bg-stone-950 border border-stone-800 rounded-xl p-3 text-xs text-white focus:border-amber-400 focus:outline-none">{{ old('notes', $message->notes) }}</textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-1.5 rounded-xl text-xs font-semibold bg-stone-800 hover:bg-stone-700 text-stone-200 transition-colors">
                            Update Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.admin>
