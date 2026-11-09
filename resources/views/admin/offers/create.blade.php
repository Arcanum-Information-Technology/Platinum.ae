<x-layouts.admin title="Create Offer">

    <div class="max-w-3xl mx-auto space-y-6">

        <div>
            <a href="{{ route('admin.offers.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to Offers</span>
            </a>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Create New Offer</h1>
            <p class="text-xs text-stone-400 mt-1">Add a promotion, tasting event, or seasonal menu discount</p>
        </div>

        <form action="{{ route('admin.offers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Offer Title <span class="text-amber-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               required
                               placeholder="e.g. Royal Weekend Tasting Experience"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            URL Slug (Optional)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="royal-weekend-tasting"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Subtitle / Subtitle Tagline
                        </label>
                        <input type="text"
                               name="subtitle"
                               value="{{ old('subtitle') }}"
                               placeholder="e.g. 5-course curated journey"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Badge
                        </label>
                        <input type="text"
                               name="badge"
                               value="{{ old('badge') }}"
                               placeholder="e.g. Limited Edition, 20% Off"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Discount / Deal
                        </label>
                        <input type="text"
                               name="discount_amount"
                               value="{{ old('discount_amount') }}"
                               placeholder="e.g. 20% Off / $45 Prix Fixe"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Promo Code (Optional)
                        </label>
                        <input type="text"
                               name="promo_code"
                               value="{{ old('promo_code') }}"
                               placeholder="e.g. CHEFROYAL"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Start Date (Optional)
                        </label>
                        <input type="date"
                               name="start_date"
                               value="{{ old('start_date') }}"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            End Date (Optional)
                        </label>
                        <input type="date"
                               name="end_date"
                               value="{{ old('end_date') }}"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Description / Details
                    </label>
                    <textarea name="description"
                              rows="4"
                              placeholder="Explain what is included in this offer, reservation conditions, etc."
                              class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('description') }}</textarea>
                </div>

                <x-admin.media-picker name="image" label="Offer Cover Image" :value="old('image')" />

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-stone-800">
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
                            Active (Visible)
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox"
                               name="is_featured"
                               id="is_featured"
                               value="1"
                               {{ old('is_featured') ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-amber-500 bg-stone-950 border-stone-800 focus:ring-0">
                        <label for="is_featured" class="text-xs font-semibold text-stone-200">
                            Feature on Home
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-stone-800">
                    <a href="{{ route('admin.offers.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Save Offer
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
