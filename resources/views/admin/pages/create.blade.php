<x-layouts.admin title="Create Page">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Pages</span>
                </a>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Create New Page</h1>
            </div>
        </div>

        <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Basic Settings -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">Page Details</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Page Title <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               required
                               placeholder="e.g. Private Dining & Banquets"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            URL Slug (Optional - Auto-generated)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="private-dining"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Page Template
                        </label>
                        <select name="template" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="default">Default Page Layout</option>
                            <option value="home">Home Page Template</option>
                            <option value="menu">Menu Template</option>
                            <option value="gallery">Gallery Template</option>
                            <option value="offers">Offers Template</option>
                            <option value="contact">Contact Template</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Publish Status
                        </label>
                        <select name="status" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Excerpt / Summary
                    </label>
                    <textarea name="excerpt" rows="2" placeholder="Brief summary of this page for search engines and social cards..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('excerpt') }}</textarea>
                </div>

                <!-- Featured Image with Media Picker -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Featured Banner Image
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="text"
                               id="featured_image"
                               name="featured_image"
                               value="{{ old('featured_image') }}"
                               placeholder="Image URL or select from media library..."
                               class="flex-1 bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <button type="button"
                                @click="$dispatch('open-media-picker', { targetInput: 'featured_image', targetPreview: 'featured_image_preview' })"
                                class="px-4 py-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-medium border border-stone-700 transition-colors shrink-0 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4"></i>
                            <span>Browse</span>
                        </button>
                    </div>
                    <img id="featured_image_preview" src="" alt="Preview" class="hidden mt-3 h-28 w-auto rounded-xl border border-stone-800 object-cover">
                </div>
            </div>

            <!-- SEO Metadata Accordion -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl" x-data="{ seoOpen: true }">
                <div class="flex items-center justify-between border-b border-stone-800 pb-3 cursor-pointer" @click="seoOpen = !seoOpen">
                    <div class="flex items-center gap-2">
                        <i data-lucide="search" class="w-5 h-5 text-amber-400"></i>
                        <h3 class="font-serif-heading text-lg font-bold text-white">SEO & Social Metadata</h3>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-stone-400 transition-transform" :class="seoOpen ? 'rotate-180' : ''"></i>
                </div>

                <div x-show="seoOpen" class="space-y-6 pt-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Custom browser title..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" placeholder="Search result snippet..." class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Robots Tag</label>
                            <input type="text" name="robots" value="index, follow" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Canonical URL</label>
                            <input type="url" name="canonical_url" value="{{ old('canonical_url') }}" placeholder="https://example.com/page" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.pages.index') }}" class="px-6 py-3 rounded-xl bg-stone-900 border border-stone-800 hover:bg-stone-800 text-stone-300 text-xs font-semibold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Create Page & Build Sections
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
