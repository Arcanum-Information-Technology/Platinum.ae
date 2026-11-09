<x-layouts.admin title="Edit Dish: {{ $menuItem->name }}">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.menu-items.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Menu List</span>
                </a>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Edit Dish: {{ $menuItem->name }}
                </h1>
            </div>

            <a href="{{ $menuItem->url }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-medium text-stone-300 bg-stone-900 border border-stone-800 hover:bg-stone-800 transition-colors">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>View On Website</span>
            </a>
        </div>

        <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Basic Info -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">1. General Information</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Dish Name <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $menuItem->name) }}"
                               required
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            URL Slug <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug', $menuItem->slug) }}"
                               required
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <!-- 301 Redirect Checkbox -->
                <div class="p-4 rounded-xl bg-stone-950/80 border border-stone-800 flex items-center gap-3">
                    <input type="checkbox" name="create_redirect" id="create_redirect" value="1" checked class="rounded bg-stone-900 border-stone-700 text-amber-500 focus:ring-amber-500">
                    <label for="create_redirect" class="text-xs text-stone-300 cursor-pointer">
                        Create automatic <strong>301 Permanent Redirect</strong> if dish slug is modified
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Category <span class="text-amber-500">*</span>
                        </label>
                        <select name="category_id" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            @if(!$categories->contains('id', $menuItem->category_id))
                                <option value="" disabled selected>
                                    -- Previously: {{ $menuItem->category?->name ?? 'Deleted Category' }} (Select New Category) --
                                </option>
                            @endif
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $menuItem->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Subcategory (Optional)
                        </label>
                        <select name="subcategory_id" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="">None / Direct Under Category</option>
                            @if($menuItem->subcategory_id && !$categories->flatMap->subcategories->contains('id', $menuItem->subcategory_id))
                                <option value="" disabled selected>
                                    -- Previously: {{ $menuItem->subcategory?->name ?? 'Deleted Subcategory' }} (Unassigned) --
                                </option>
                            @endif
                            @foreach($categories as $cat)
                                <optgroup label="{{ $cat->name }}">
                                    @foreach($cat->subcategories as $sub)
                                        <option value="{{ $sub->id }}" {{ old('subcategory_id', $menuItem->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Short Menu Description
                    </label>
                    <textarea name="short_description" rows="2" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('short_description', $menuItem->short_description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Full Detailed Story & Culinary Technique
                    </label>
                    <textarea name="full_description" rows="4" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('full_description', $menuItem->full_description) }}</textarea>
                </div>
            </div>

            <!-- Section 2: Pricing & Photos -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">2. Pricing & Photography</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Regular Price ($) <span class="text-amber-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $menuItem->price) }}" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Discounted / Happy Hour Price ($)
                        </label>
                        <input type="number" step="0.01" name="discounted_price" value="{{ old('discounted_price', $menuItem->discounted_price) }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <!-- Primary Image with Media Picker -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Primary Food Photograph
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="text"
                               id="dish_primary_image"
                               name="primary_image"
                               value="{{ old('primary_image', $menuItem->primary_image) }}"
                               placeholder="Image URL or pick from media..."
                               class="flex-1 bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <button type="button"
                                @click="$dispatch('open-media-picker', { targetInput: 'dish_primary_image', targetPreview: 'dish_primary_preview' })"
                                class="px-4 py-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-medium border border-stone-700 transition-colors shrink-0 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4"></i>
                            <span>Browse Library</span>
                        </button>
                    </div>
                    <!-- Required Image Size & Ratio Guidance -->
                    <div class="mt-3 p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200/90 text-xs flex items-start gap-3">
                        <i data-lucide="info" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                        <div class="space-y-1">
                            <p class="font-semibold text-amber-300">Required Image Specifications for Website Display:</p>
                            <ul class="list-disc list-inside space-y-0.5 text-stone-300 text-[11px] leading-relaxed">
                                <li><strong>Aspect Ratio:</strong> <span class="text-amber-300 font-medium">4:3 Landscape</span> (Uniform ratio for all menu cards & dish pages).</li>
                                <li><strong>Recommended Size:</strong> <strong>800 × 600 px</strong> (Standard) or <strong>1200 × 900 px</strong> (High-Resolution / Retina).</li>
                                <li><strong>Accepted Formats:</strong> JPG, WebP, or PNG (Max 5MB).</li>
                                <li><strong>Composition Tip:</strong> Upload full-bleed dish photography where the food fills the frame edge-to-edge. Avoid adding artificial white margins, borders, or low-res thumbnails so dishes render uniformly.</li>
                            </ul>
                        </div>
                    </div>
                    <img id="dish_primary_preview"
                         src="{{ \App\Support\AssetUrl::make($menuItem->primary_image) }}"
                         alt="Preview"
                         class="{{ $menuItem->primary_image ? '' : 'hidden' }} mt-3 h-28 w-auto rounded-xl border border-stone-800 object-cover">
                </div>
            </div>

            <!-- Section 3: Dietary, Allergens & Gastronomy Specs -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">3. Gastronomy Specs & Dietary Flags</h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-stone-950 border border-stone-800">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_vegetarian" value="1" {{ old('is_vegetarian', $menuItem->is_vegetarian) ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-emerald-500 focus:ring-emerald-500">
                        <span class="text-xs text-stone-300 font-semibold">Vegetarian</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_vegan" value="1" {{ old('is_vegan', $menuItem->is_vegan) ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-green-500 focus:ring-green-500">
                        <span class="text-xs text-stone-300 font-semibold">Vegan</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_spicy" value="1" {{ old('is_spicy', $menuItem->is_spicy) ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-rose-500 focus:ring-rose-500">
                        <span class="text-xs text-stone-300 font-semibold">Spicy</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $menuItem->is_featured) ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-amber-500 focus:ring-amber-500">
                        <span class="text-xs text-amber-400 font-semibold">Chef Special</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Spice Level (0-3)</label>
                        <select name="spice_level" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="0" {{ $menuItem->spice_level == 0 ? 'selected' : '' }}>0 - None / Mild</option>
                            <option value="1" {{ $menuItem->spice_level == 1 ? 'selected' : '' }}>1 - Gentle Heat</option>
                            <option value="2" {{ $menuItem->spice_level == 2 ? 'selected' : '' }}>2 - Medium Spicy</option>
                            <option value="3" {{ $menuItem->spice_level == 3 ? 'selected' : '' }}>3 - Fiery / Hot</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Prep Time</label>
                        <input type="text" name="preparation_time" value="{{ old('preparation_time', $menuItem->preparation_time) }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Serving Size</label>
                        <input type="text" name="serving_size" value="{{ old('serving_size', $menuItem->serving_size) }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Calories (kcal)</label>
                        <input type="number" name="calories" value="{{ old('calories', $menuItem->calories) }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Key Ingredients (comma separated)</label>
                        <input type="text" name="ingredients" value="{{ old('ingredients', is_array($menuItem->ingredients) ? implode(', ', $menuItem->ingredients) : '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Allergens (comma separated)</label>
                        <input type="text" name="allergens" value="{{ old('allergens', is_array($menuItem->allergens) ? implode(', ', $menuItem->allergens) : '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Tags (comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', is_array($menuItem->tags) ? implode(', ', $menuItem->tags) : '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Status</label>
                        <select name="status" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published" {{ $menuItem->status === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ $menuItem->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_available" value="1" {{ $menuItem->is_available ? 'checked' : '' }} class="rounded bg-stone-950 border-stone-800 text-amber-500 focus:ring-amber-500">
                            <span class="text-xs text-stone-300 font-semibold">Available For Ordering Today</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.menu-items.index') }}" class="px-6 py-3 rounded-xl bg-stone-900 border border-stone-800 text-stone-300 text-xs font-semibold uppercase tracking-wider">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 shadow-lg">
                    Update Dish
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
