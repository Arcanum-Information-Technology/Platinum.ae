<x-layouts.admin title="Add Dish">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.menu-items.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Menu List</span>
                </a>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Add New Dish</h1>
            </div>
        </div>

        <form action="{{ route('admin.menu-items.store') }}" method="POST" class="space-y-8">
            @csrf

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
                               value="{{ old('name') }}"
                               required
                               placeholder="e.g. Butter Chicken Royale"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            URL Slug (Optional - Auto-generated)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="butter-chicken-royale"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Category <span class="text-amber-500">*</span>
                        </label>
                        <select name="category_id" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                            @foreach($categories as $cat)
                                <optgroup label="{{ $cat->name }}">
                                    @foreach($cat->subcategories as $sub)
                                        <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>
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
                    <textarea name="short_description" rows="2" placeholder="One or two compelling sentences about preparation, textures and key notes..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('short_description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Full Detailed Story & Culinary Technique
                    </label>
                    <textarea name="full_description" rows="4" placeholder="Detailed culinary heritage, aging, sourcing, and cooking process..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('full_description') }}</textarea>
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
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="28.00" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Discounted / Happy Hour Price ($)
                        </label>
                        <input type="number" step="0.01" name="discounted_price" value="{{ old('discounted_price') }}" placeholder="24.00" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
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
                               value="{{ old('primary_image') }}"
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
                    <img id="dish_primary_preview" src="" alt="Preview" class="hidden mt-3 h-28 w-auto rounded-xl border border-stone-800 object-cover">
                </div>
            </div>

            <!-- Section 3: Dietary, Allergens & Gastronomy Specs -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">3. Gastronomy Specs & Dietary Flags</h3>

                <!-- Toggles -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-stone-950 border border-stone-800">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_vegetarian" value="1" {{ old('is_vegetarian') ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-emerald-500 focus:ring-emerald-500">
                        <span class="text-xs text-stone-300 font-semibold">Vegetarian</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_vegan" value="1" {{ old('is_vegan') ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-green-500 focus:ring-green-500">
                        <span class="text-xs text-stone-300 font-semibold">Vegan</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_spicy" value="1" {{ old('is_spicy') ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-rose-500 focus:ring-rose-500">
                        <span class="text-xs text-stone-300 font-semibold">Spicy</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded bg-stone-900 border-stone-700 text-amber-500 focus:ring-amber-500">
                        <span class="text-xs text-amber-400 font-semibold">Chef Special</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Spice Level (0-3)</label>
                        <select name="spice_level" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="0">0 - None / Mild</option>
                            <option value="1">1 - Gentle Heat</option>
                            <option value="2">2 - Medium Spicy</option>
                            <option value="3">3 - Fiery / Hot</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Prep Time</label>
                        <input type="text" name="preparation_time" value="{{ old('preparation_time', '15-20 min') }}" placeholder="e.g. 20 mins" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Serving Size</label>
                        <input type="text" name="serving_size" value="{{ old('serving_size', 'Serves 1-2') }}" placeholder="e.g. Serves 1-2" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Calories (kcal)</label>
                        <input type="number" name="calories" value="{{ old('calories') }}" placeholder="620" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Key Ingredients (comma separated)
                        </label>
                        <input type="text" name="ingredients" value="{{ old('ingredients') }}" placeholder="Chicken, Butter, Tomatoes, Cashews" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Allergen Advice (comma separated)
                        </label>
                        <input type="text" name="allergens" value="{{ old('allergens') }}" placeholder="Dairy, Tree Nuts" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Dish Tags (comma separated)
                        </label>
                        <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Signature, Bestseller, Gluten-Free" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Status</label>
                        <select name="status" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_available" value="1" checked class="rounded bg-stone-950 border-stone-800 text-amber-500 focus:ring-amber-500">
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
                    Add Dish To Menu
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
