<x-layouts.admin title="Menu Items">

    <div class="space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Restaurant Menu Items
                </h1>
                <p class="text-xs text-stone-400 mt-1">
                    Manage dishes, pricing, dietary flags, ingredients, and availability
                </p>
            </div>

            <a href="{{ route('admin.menu-items.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add New Dish</span>
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-stone-900 border border-stone-800 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.menu-items.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-72">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search dishes by name or description..."
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>

                <select name="category_id" onchange="this.form.submit()" class="w-full sm:w-auto bg-stone-950 border border-stone-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-stone-950 border border-stone-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                @if(request()->hasAny(['search', 'category_id', 'status']))
                    <a href="{{ route('admin.menu-items.index') }}" class="text-xs text-stone-400 hover:text-white underline">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Dish Photo</th>
                            <th class="py-4 px-6">Dish Name & Details</th>
                            <th class="py-4 px-6">Category</th>
                            <th class="py-4 px-6">Price</th>
                            <th class="py-4 px-6">Availability</th>
                            <th class="py-4 px-6">Featured</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($items as $item)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    @if($item->primary_image)
                                        <img src="{{ $item->primary_image }}" alt="{{ $item->name }}" class="w-14 h-14 rounded-2xl object-cover border border-stone-800 shadow-md">
                                    @else
                                        <div class="w-14 h-14 rounded-2xl bg-stone-950 border border-stone-800 flex items-center justify-center text-stone-600">
                                            <i data-lucide="utensils" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-serif-heading text-sm font-bold text-white block">{{ $item->name }}</span>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        @if($item->is_vegetarian)
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/30">Veg</span>
                                        @endif
                                        @if($item->is_vegan)
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-green-950 text-green-400 border border-green-500/30">Vegan</span>
                                        @endif
                                        @if($item->is_spicy)
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-rose-950 text-rose-400 border border-rose-500/30 flex items-center gap-0.5">
                                                <i data-lucide="flame" class="w-2.5 h-2.5"></i>
                                                <span>{{ $item->spice_level }}/3</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($item->category)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->category->trashed() ? 'bg-rose-950/80 border border-rose-500/40 text-rose-300' : 'bg-stone-950 border border-stone-800 text-stone-300' }}">
                                            {{ $item->category->name }}
                                            @if($item->category->trashed())
                                                <span class="text-[10px] text-rose-400 font-normal ml-1">(Deleted)</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-stone-900 border border-stone-800 text-stone-500 italic">
                                            Uncategorized
                                        </span>
                                    @endif

                                    @if($item->subcategory)
                                        <span class="block text-[10px] text-stone-500 mt-1 font-mono">
                                            / {{ $item->subcategory->name }}
                                            @if($item->subcategory->trashed())
                                                <span class="text-rose-400 font-normal">(Deleted)</span>
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($item->has_discount)
                                        <span class="line-through text-stone-500 block text-[11px]">${{ number_format($item->price, 2) }}</span>
                                        <span class="font-serif-heading font-extrabold text-amber-400 text-sm">${{ number_format($item->effective_price, 2) }}</span>
                                    @else
                                        <span class="font-serif-heading font-extrabold text-white text-sm">${{ number_format($item->price, 2) }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <form action="{{ route('admin.menu-items.toggle-available', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold transition-colors {{ $item->is_available ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-500/40 hover:bg-emerald-900' : 'bg-stone-800 text-stone-400 hover:bg-stone-700' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->is_available ? 'bg-emerald-400' : 'bg-stone-500' }}"></span>
                                            {{ $item->is_available ? 'Available' : 'Sold Out' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-6">
                                    <form action="{{ route('admin.menu-items.toggle-featured', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-lg border {{ $item->is_featured ? 'bg-amber-500/20 border-amber-500/40 text-amber-400' : 'bg-stone-950 border-stone-800 text-stone-600' }} hover:scale-105 transition-all" title="Toggle Chef Special">
                                            <i data-lucide="star" class="w-4 h-4 {{ $item->is_featured ? 'fill-amber-400' : '' }}"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ $item->url }}" target="_blank" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="View Public Dish Page">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="Edit Dish">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this dish from the menu?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 hover:bg-stone-800 rounded-lg transition-colors" title="Delete Dish">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-stone-500">
                                    No menu items found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
                <div class="p-4 border-t border-stone-800">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
