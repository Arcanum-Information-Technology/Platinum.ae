<x-layouts.admin title="Edit FAQ">

    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <a href="{{ route('admin.faqs.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to FAQs</span>
            </a>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Edit Question & Answer</h1>
            <p class="text-xs text-stone-400 mt-1">Update dining FAQ entry</p>
        </div>

        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Question <span class="text-amber-500">*</span>
                    </label>
                    <input type="text"
                           name="question"
                           value="{{ old('question', $faq->question) }}"
                           required
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Category / Topic
                        </label>
                        <input type="text"
                               name="category"
                               value="{{ old('category', $faq->category) }}"
                               placeholder="e.g. Reservations, Dietary, Parking"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Status <span class="text-amber-500">*</span>
                        </label>
                        <select name="status" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published" {{ old('status', $faq->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $faq->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Answer <span class="text-amber-500">*</span>
                    </label>
                    <textarea name="answer"
                              rows="5"
                              required
                              class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('answer', $faq->answer) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Sort Order
                    </label>
                    <input type="number"
                           name="sort_order"
                           value="{{ old('sort_order', $faq->sort_order) }}"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-stone-800">
                    <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Update FAQ
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
