<x-layouts.admin title="Restaurant Information">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Restaurant Profile & Location
                </h1>
                <p class="text-xs text-stone-400 mt-1">
                    Manage core restaurant identity, address, phone, and geo coordinates
                </p>
            </div>
        </div>

        <form action="{{ route('admin.restaurant.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Contact & Address -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">1. Contact & Location</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Telephone</label>
                        <input type="text" name="restaurant_phone" value="{{ old('restaurant_phone', $info['restaurant_phone'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Concierge Email</label>
                        <input type="email" name="restaurant_email" value="{{ old('restaurant_email', $info['restaurant_email'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Street Address</label>
                    <input type="text" name="restaurant_address" value="{{ old('restaurant_address', $info['restaurant_address'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">City</label>
                        <input type="text" name="restaurant_city" value="{{ old('restaurant_city', $info['restaurant_city'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">State / Region</label>
                        <input type="text" name="restaurant_state" value="{{ old('restaurant_state', $info['restaurant_state'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Postal Code</label>
                        <input type="text" name="restaurant_postal_code" value="{{ old('restaurant_postal_code', $info['restaurant_postal_code'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Country</label>
                        <input type="text" name="restaurant_country" value="{{ old('restaurant_country', $info['restaurant_country'] ?? '') }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Latitude (for Schema.org & Maps)</label>
                        <input type="text" name="restaurant_latitude" value="{{ old('restaurant_latitude', $info['restaurant_latitude'] ?? '') }}" placeholder="37.7749" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Longitude (for Schema.org & Maps)</label>
                        <input type="text" name="restaurant_longitude" value="{{ old('restaurant_longitude', $info['restaurant_longitude'] ?? '') }}" placeholder="-122.4194" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Profile & Gastronomy Identity -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">2. Identity & Cuisine</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Price Range Indicator</label>
                        <input type="text" name="restaurant_price_range" value="{{ old('restaurant_price_range', $info['restaurant_price_range'] ?? '$$$') }}" placeholder="$$$" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Cuisine Type</label>
                        <input type="text" name="restaurant_cuisine" value="{{ old('restaurant_cuisine', $info['restaurant_cuisine'] ?? '') }}" placeholder="Modern European & Artisanal Fusion" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Short Tagline Description</label>
                    <textarea name="restaurant_short_desc" rows="2" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('restaurant_short_desc', $info['restaurant_short_desc'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Full Story / Philosophy</label>
                    <textarea name="restaurant_full_desc" rows="4" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('restaurant_full_desc', $info['restaurant_full_desc'] ?? '') }}</textarea>
                </div>

                <!-- Exterior Hero Image -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Restaurant Exterior / Ambiance Hero Image</label>
                    <div class="flex items-center gap-3">
                        <input type="text"
                               id="restaurant_hero_image"
                               name="restaurant_hero_image"
                               value="{{ old('restaurant_hero_image', $info['restaurant_hero_image'] ?? '') }}"
                               placeholder="Image URL or browse media..."
                               class="flex-1 bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <button type="button"
                                @click="$dispatch('open-media-picker', { targetInput: 'restaurant_hero_image', targetPreview: 'restaurant_hero_preview' })"
                                class="px-4 py-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-medium border border-stone-700 transition-colors shrink-0 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4"></i>
                            <span>Browse</span>
                        </button>
                    </div>
                    <img id="restaurant_hero_preview"
                         src="{{ $info['restaurant_hero_image'] ?? '' }}"
                         alt="Preview"
                         class="{{ !empty($info['restaurant_hero_image']) ? '' : 'hidden' }} mt-3 h-28 w-auto rounded-xl border border-stone-800 object-cover">
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="px-8 py-3 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Save Restaurant Profile
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
