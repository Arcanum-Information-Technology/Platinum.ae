<x-layouts.admin title="Subcategories">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Food Subcategories</h1>
                <p class="text-xs text-stone-400 mt-1">Organize courses into focused culinary groups</p>
            </div>

            <a href="{{ route('admin.subcategories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add Subcategory</span>
            </a>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Subcategory Name</th>
                            <th class="py-4 px-6">Parent Category</th>
                            <th class="py-4 px-6">Slug</th>
                            <th class="py-4 px-6">Dishes</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($subcategories as $sub)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6 font-serif-heading text-sm font-bold text-white">
                                    {{ $sub->name }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($sub->category)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $sub->category->trashed() ? 'bg-rose-950/80 border border-rose-500/40 text-rose-300' : 'bg-stone-950 border border-stone-800 text-amber-400' }}">
                                            {{ $sub->category->name }}
                                            @if($sub->category->trashed())
                                                <span class="text-[10px] text-rose-400 font-normal ml-1">(Deleted)</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-stone-900 border border-stone-800 text-stone-500 italic">
                                            Unassigned
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono text-stone-400">
                                    {{ $sub->slug }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-white">
                                    {{ $sub->menu_items_count }} Dishes
                                </td>
                                <td class="py-4 px-6">
                                    @if($sub->status === 'published')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">
                                            Published
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-stone-400">Draft</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.subcategories.edit', $sub->id) }}" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="Edit Subcategory">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.subcategories.destroy', $sub->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this subcategory?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 hover:bg-stone-800 rounded-lg transition-colors" title="Delete Subcategory">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-stone-500">
                                    No subcategories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subcategories->hasPages())
                <div class="p-4 border-t border-stone-800">
                    {{ $subcategories->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
