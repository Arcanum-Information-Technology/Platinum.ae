<x-layouts.admin title="FAQs">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Frequently Asked Questions</h1>
                <p class="text-xs text-stone-400 mt-1">Manage dining FAQs, dietary policies, parking info, and dress codes</p>
            </div>

            <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add FAQ</span>
            </a>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Question</th>
                            <th class="py-4 px-6">Category</th>
                            <th class="py-4 px-6">Order</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($faqs as $faq)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6 max-w-md">
                                    <span class="font-serif-heading text-sm font-bold text-white block mb-1">{{ $faq->question }}</span>
                                    <p class="text-[11px] text-stone-400 line-clamp-2">{{ $faq->answer }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-stone-950 text-stone-300 border border-stone-800 uppercase tracking-wider">
                                        {{ $faq->category ?? 'General' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-mono text-stone-400 text-xs">
                                    {{ $faq->sort_order }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($faq->status === 'published')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">Published</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-950 text-stone-400 border border-stone-800">Draft</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="p-2 text-stone-400 hover:text-amber-400 transition-colors" title="Edit FAQ">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-stone-400 hover:text-rose-400 transition-colors" title="Delete FAQ">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-stone-500">
                                    <i data-lucide="help-circle" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    <p class="text-xs">No questions found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($faqs->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $faqs->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
