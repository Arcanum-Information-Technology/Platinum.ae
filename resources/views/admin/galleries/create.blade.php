<x-layouts.admin title="Create Gallery">

    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <a href="{{ route('admin.galleries.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to Galleries</span>
            </a>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">New Photo Gallery</h1>
            <p class="text-xs text-stone-400 mt-1">Create a gallery collection and then upload photography to it</p>
        </div>

        <form action="{{ route('admin.galleries.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Gallery Title <span class="text-amber-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           placeholder="e.g. Interior Ambiance & Architecture"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Description / Introduction
                    </label>
                    <textarea name="description"
                              rows="3"
                              placeholder="Brief description of this visual collection..."
                              class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('description') }}</textarea>
                </div>

                <x-admin.media-picker name="cover_image" label="Cover Photo" :value="old('cover_image')" />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-stone-800">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Sort Order
                        </label>
                        <input type="number"
                               name="sort_order"
                               value="{{ old('sort_order', 0) }}"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-amber-500 bg-stone-950 border-stone-800 focus:ring-0">
                        <label for="is_active" class="text-xs font-semibold text-stone-200">
                            Active (Visible on Website)
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-stone-800">
                    <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Create & Add Photos
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
