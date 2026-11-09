<x-layouts.admin title="Offers & Specials">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Offers & Promotions</h1>
                <p class="text-xs text-stone-400 mt-1">Manage seasonal dining specials, promo codes, and tastings</p>
            </div>

            <a href="{{ route('admin.offers.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Create Offer</span>
            </a>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Offer Title</th>
                            <th class="py-4 px-6">Badge / Promo</th>
                            <th class="py-4 px-6">Discount</th>
                            <th class="py-4 px-6">Validity Dates</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($offers as $offer)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-serif-heading text-sm font-bold text-white block">{{ $offer->title }}</span>
                                    @if($offer->subtitle)
                                        <p class="text-[11px] text-amber-500/90">{{ $offer->subtitle }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($offer->badge)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/40">{{ $offer->badge }}</span>
                                    @endif
                                    @if($offer->promo_code)
                                        <span class="font-mono text-stone-400 text-xs ml-1">({{ $offer->promo_code }})</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-semibold text-white">
                                    {{ $offer->discount_amount ?? 'Special Menu' }}
                                </td>
                                <td class="py-4 px-6 text-stone-400 text-[11px]">
                                    @if($offer->start_date && $offer->end_date)
                                        {{ $offer->start_date->format('M d, Y') }} – {{ $offer->end_date->format('M d, Y') }}
                                    @else
                                        Ongoing
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($offer->is_active)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-stone-400">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.offers.edit', $offer->id) }}" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this offer?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 hover:bg-stone-800 rounded-lg transition-colors">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-stone-500">
                                    No offers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($offers->hasPages())
                <div class="p-4 border-t border-stone-800">
                    {{ $offers->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
