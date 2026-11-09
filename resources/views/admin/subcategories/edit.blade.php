<x-layouts.admin title="Edit Subcategory: {{ $subcategory->name }}">

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.subcategories.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Subcategories</span>
                </a>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Edit Subcategory: {{ $subcategory->name }}
                </h1>
            </div>
        </div>

        <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Parent Category <span class="text-amber-500">*</span>
                    </label>
                    <select name="category_id" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $subcategory->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Subcategory Name <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $subcategory->name) }}"
                               required
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            URL Slug <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug', $subcategory->slug) }}"
                               required
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" rows="2" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('description', $subcategory->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Status
                        </label>
                        <select name="status" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published" {{ $subcategory->status === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ $subcategory->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $subcategory->sort_order) }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.subcategories.index') }}" class="px-6 py-2.5 rounded-xl bg-stone-900 border border-stone-800 text-stone-300 text-xs font-semibold uppercase tracking-wider">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 shadow-lg">
                    Update Subcategory
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
