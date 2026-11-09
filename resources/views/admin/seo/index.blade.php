<x-layouts.admin title="SEO & Structured Data">

    <div class="max-w-4xl mx-auto space-y-8">

        <div>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Search Engine Optimization (SEO)</h1>
            <p class="text-xs text-stone-400 mt-1">Configure global search metadata, Open Graph social share cards, and crawler indexing rules</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Dynamic Sitemap -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl space-y-3">
                <div class="flex items-center gap-2 text-amber-400">
                    <i data-lucide="map" class="w-5 h-5"></i>
                    <h3 class="font-serif-heading text-base font-bold text-white">XML Sitemap</h3>
                </div>
                <p class="text-xs text-stone-400 leading-relaxed">
                    Auto-generated live XML sitemap containing all published pages, culinary categories, dishes, and specials.
                </p>
                <div class="pt-2">
                    <a href="{{ url('/sitemap.xml') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-400 hover:text-amber-300">
                        <span>View sitemap.xml</span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: Robots.txt -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl space-y-3">
                <div class="flex items-center gap-2 text-amber-400">
                    <i data-lucide="bot" class="w-5 h-5"></i>
                    <h3 class="font-serif-heading text-base font-bold text-white">Robots.txt</h3>
                </div>
                <p class="text-xs text-stone-400 leading-relaxed">
                    Crawler instructions protecting admin panel routes and pointing search engines directly to your sitemap.
                </p>
                <div class="pt-2">
                    <a href="{{ url('/robots.txt') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-400 hover:text-amber-300">
                        <span>View robots.txt</span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Schema.org JSON-LD -->
            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl space-y-3">
                <div class="flex items-center gap-2 text-amber-400">
                    <i data-lucide="code" class="w-5 h-5"></i>
                    <h3 class="font-serif-heading text-base font-bold text-white">Schema.org JSON-LD</h3>
                </div>
                <p class="text-xs text-stone-400 leading-relaxed">
                    Automated rich snippets: Restaurant schema, Menu, MenuSection, MenuItem, FAQPage, and BreadcrumbList.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">
                        Active & Structured
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.seo.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">Global SEO Defaults</h3>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Default Meta Title <span class="text-amber-500">*</span>
                    </label>
                    <input type="text"
                           name="default_meta_title"
                           value="{{ old('default_meta_title', $settings['default_meta_title'] ?? 'Saffron & Thyme | Artisanal Heritage Dining') }}"
                           required
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    <p class="text-[11px] text-stone-500 mt-1">Used when a page does not specify a custom meta title</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Default Meta Description <span class="text-amber-500">*</span>
                    </label>
                    <textarea name="default_meta_description"
                              rows="3"
                              required
                              class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('default_meta_description', $settings['default_meta_description'] ?? 'Award-winning artisanal dining celebrating heritage spices, wood-fired hearths, and seasonal organic ingredients.') }}</textarea>
                    <p class="text-[11px] text-stone-500 mt-1">Recommended length: 150-160 characters</p>
                </div>

                <x-admin.media-picker name="default_og_image" label="Default Social Share Image (Open Graph / Twitter)" :value="old('default_og_image', $settings['default_og_image'] ?? null)" />

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Google Search Console Verification Code (Optional)
                    </label>
                    <input type="text"
                           name="google_site_verification"
                           value="{{ old('google_site_verification', $settings['google_site_verification'] ?? '') }}"
                           placeholder="e.g. g_abcdefghijklmnopqrstuvwxyz123456"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    <p class="text-[11px] text-stone-500 mt-1">Meta tag content for Google Search Console ownership verification</p>
                </div>

                <div class="flex justify-end pt-4 border-t border-stone-800">
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Save Global SEO Settings
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
