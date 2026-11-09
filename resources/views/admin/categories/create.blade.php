<x-layouts.admin title="Create Category">

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.categories.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Categories</span>
                </a>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Add New Category</h1>
            </div>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Category Name <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               placeholder="e.g. Starters & Small Plates"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            URL Slug (Optional - Auto-generated)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="starters-small-plates"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" rows="3" placeholder="Course culinary overview..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('description') }}</textarea>
                </div>

                <!-- Image with Media Picker -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Category Cover Image
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="text"
                               id="category_image"
                               name="image"
                               value="{{ old('image') }}"
                               placeholder="Image URL or pick from media..."
                               class="flex-1 bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <button type="button"
                                @click="$dispatch('open-media-picker', { targetInput: 'category_image', targetPreview: 'category_image_preview' })"
                                class="px-4 py-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-medium border border-stone-700 transition-colors shrink-0 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4"></i>
                            <span>Browse</span>
                        </button>
                    </div>
                    <img id="category_image_preview" src="" alt="Preview" class="hidden mt-3 h-24 w-auto rounded-xl border border-stone-800 object-cover">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Publish Status
                        </label>
                        <select name="status" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Display Sort Order
                        </label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded bg-stone-950 border-stone-800 text-amber-500 focus:ring-amber-500">
                            <span class="text-xs text-stone-300 font-semibold">Featured on Home</span>
                        </label>
                    </div>
                </div>

                <!-- SEO Snippet -->
                <div class="pt-4 border-t border-stone-800 space-y-4">
                    <h4 class="font-serif-heading text-sm font-bold text-white">SEO Customization</h4>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Custom SEO title..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2" placeholder="Course SEO description..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 rounded-xl bg-stone-900 border border-stone-800 text-stone-300 text-xs font-semibold uppercase tracking-wider">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 shadow-lg">
                    Create Category
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
