<x-layouts.admin title="Categories">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Food Categories</h1>
                <p class="text-xs text-stone-400 mt-1">Manage dining courses and menu categories</p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add Category</span>
            </a>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Image</th>
                            <th class="py-4 px-6">Category Name</th>
                            <th class="py-4 px-6">Slug</th>
                            <th class="py-4 px-6">Subcategories</th>
                            <th class="py-4 px-6">Dishes</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($categories as $category)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    @if($category->image)
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-12 h-12 rounded-xl object-cover border border-stone-800">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-stone-950 border border-stone-800 flex items-center justify-center text-stone-600">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-serif-heading text-sm font-bold text-white block">{{ $category->name }}</span>
                                    @if($category->is_featured)
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[9px] font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30">Featured Course</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono text-stone-400">
                                    {{ $category->slug }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('admin.subcategories.index', ['category_id' => $category->id]) }}" class="text-amber-400 hover:underline">
                                        {{ $category->subcategories_count }} Subcategories
                                    </a>
                                </td>
                                <td class="py-4 px-6 font-semibold text-white">
                                    {{ $category->menu_items_count }} Dishes
                                </td>
                                <td class="py-4 px-6">
                                    @if($category->status === 'published')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Published
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-stone-400">Draft</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('menu.category', $category->slug) }}" target="_blank" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="View Course Page">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="Edit Category">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category and related menu items?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 hover:bg-stone-800 rounded-lg transition-colors" title="Delete Category">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-stone-500">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="p-4 border-t border-stone-800">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
