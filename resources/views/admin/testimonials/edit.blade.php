<x-layouts.admin title="Edit Review">

    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <a href="{{ route('admin.testimonials.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to Reviews</span>
            </a>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Edit Review: {{ $testimonial->customer_name }}</h1>
            <p class="text-xs text-stone-400 mt-1">Update guest critique and details</p>
        </div>

        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Guest / Reviewer Name <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="customer_name"
                               value="{{ old('customer_name', $testimonial->customer_name) }}"
                               required
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Role / Affiliation (Optional)
                        </label>
                        <input type="text"
                               name="customer_role"
                               value="{{ old('customer_role', $testimonial->customer_role) }}"
                               placeholder="e.g. Michelin Food Critic / Regular Patron"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Rating <span class="text-amber-500">*</span>
                        </label>
                        <select name="rating" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 Stars - Exceptional</option>
                            <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 Stars - Very Good</option>
                            <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 Stars - Average</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Status <span class="text-amber-500">*</span>
                        </label>
                        <select name="status" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="published" {{ old('status', $testimonial->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $testimonial->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Review / Quote Content <span class="text-amber-500">*</span>
                    </label>
                    <textarea name="content"
                              rows="4"
                              required
                              class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('content', $testimonial->content) }}</textarea>
                </div>

                <x-admin.media-picker name="avatar" label="Guest Photo / Avatar (Optional)" :value="old('avatar', $testimonial->avatar)" />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-stone-800">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Sort Order
                        </label>
                        <input type="number"
                               name="sort_order"
                               value="{{ old('sort_order', $testimonial->sort_order) }}"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox"
                               name="is_featured"
                               id="is_featured"
                               value="1"
                               {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-amber-500 bg-stone-950 border-stone-800 focus:ring-0">
                        <label for="is_featured" class="text-xs font-semibold text-stone-200">
                            Featured Testimonial
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-stone-800">
                    <a href="{{ route('admin.testimonials.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Update Review
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
