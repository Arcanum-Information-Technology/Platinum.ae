<x-layouts.admin title="Navigation Menus">

    <div class="space-y-8" x-data="{ addLocation: 'header' }">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Navigation Menus</h1>
                <p class="text-xs text-stone-400 mt-1">Configure header links, mobile menu, and footer link columns</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Add New Navigation Link Form -->
            <div class="lg:col-span-1">
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl sticky top-8 space-y-6">
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4 text-amber-400"></i>
                        <span>Add Link</span>
                    </h3>

                    <form action="{{ route('admin.navigation.store') }}" method="POST" class="space-y-4" x-data="{ linkType: 'page' }">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Menu Location <span class="text-amber-500">*</span>
                            </label>
                            <select name="location" x-model="addLocation" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                                <option value="header">Header & Mobile Navigation</option>
                                <option value="footer_links">Footer Quick Links</option>
                                <option value="footer_legal">Footer Legal & Policy Links</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Link Label <span class="text-amber-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   required
                                   placeholder="e.g. Tasting Menu"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Link Type
                            </label>
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <button type="button" @click="linkType = 'page'" :class="linkType === 'page' ? 'bg-amber-400 text-stone-950 font-semibold' : 'bg-stone-950 text-stone-400 border border-stone-800'" class="py-1.5 px-3 rounded-lg text-xs transition-colors">
                                    CMS Page
                                </button>
                                <button type="button" @click="linkType = 'custom'" :class="linkType === 'custom' ? 'bg-amber-400 text-stone-950 font-semibold' : 'bg-stone-950 text-stone-400 border border-stone-800'" class="py-1.5 px-3 rounded-lg text-xs transition-colors">
                                    Custom URL
                                </button>
                            </div>
                            <input type="hidden" name="url_type" :value="linkType">
                        </div>

                        <div x-show="linkType === 'page'">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Select Published Page
                            </label>
                            <select @change="$refs.urlInput.value = $event.target.value" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                                <option value="">Select a page...</option>
                                <option value="/menu">/menu (Full Culinary Menu)</option>
                                <option value="/offers">/offers (Dining Specials)</option>
                                <option value="/contact">/contact (Contact & Reservations)</option>
                                @foreach($publishedPages as $pg)
                                    <option value="/{{ $pg->slug }}">/{{ $pg->slug }} ({{ $pg->title }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Destination URL <span class="text-amber-500">*</span>
                            </label>
                            <input type="text"
                                   x-ref="urlInput"
                                   name="url"
                                   required
                                   placeholder="/menu or https://..."
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                    Target Window
                                </label>
                                <select name="target" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                                    <option value="_self">Same Tab (_self)</option>
                                    <option value="_blank">New Tab (_blank)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                    Sort Order
                                </label>
                                <input type="number"
                                       name="sort_order"
                                       value="0"
                                       class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg mt-2">
                            Add Link
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Menu Groups Lists -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Header Menu -->
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-stone-800 pb-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="compass" class="w-5 h-5 text-amber-400"></i>
                            <h3 class="font-serif-heading text-lg font-bold text-white">Header & Mobile Navigation</h3>
                        </div>
                        <span class="text-xs text-stone-400 font-mono">{{ $headerItems->count() }} links</span>
                    </div>

                    <div class="space-y-2">
                        @forelse($headerItems as $item)
                            <div class="flex items-center justify-between bg-stone-950 border border-stone-800/80 rounded-2xl p-4">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="grip-vertical" class="w-4 h-4 text-stone-600"></i>
                                    <div>
                                        <span class="text-sm font-semibold text-white block">{{ $item->title }}</span>
                                        <span class="text-xs text-amber-500/80 font-mono">{{ $item->url }}</span>
                                        @if($item->target === '_blank')
                                            <span class="text-[10px] text-stone-500 ml-1">(new window)</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-stone-500 font-mono">Order: {{ $item->sort_order }}</span>

                                    <form action="{{ route('admin.navigation.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove link?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-stone-500 py-4 text-center">No header links created.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Footer Quick Links -->
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-stone-800 pb-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="link" class="w-5 h-5 text-amber-400"></i>
                            <h3 class="font-serif-heading text-lg font-bold text-white">Footer Quick Links</h3>
                        </div>
                        <span class="text-xs text-stone-400 font-mono">{{ $footerLinks->count() }} links</span>
                    </div>

                    <div class="space-y-2">
                        @forelse($footerLinks as $item)
                            <div class="flex items-center justify-between bg-stone-950 border border-stone-800/80 rounded-2xl p-4">
                                <div>
                                    <span class="text-sm font-semibold text-white block">{{ $item->title }}</span>
                                    <span class="text-xs text-amber-500/80 font-mono">{{ $item->url }}</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-stone-500 font-mono">Order: {{ $item->sort_order }}</span>

                                    <form action="{{ route('admin.navigation.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove link?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-stone-500 py-4 text-center">No footer quick links created.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Footer Legal Links -->
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-stone-800 pb-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-5 h-5 text-amber-400"></i>
                            <h3 class="font-serif-heading text-lg font-bold text-white">Footer Legal & Policy Links</h3>
                        </div>
                        <span class="text-xs text-stone-400 font-mono">{{ $footerLegal->count() }} links</span>
                    </div>

                    <div class="space-y-2">
                        @forelse($footerLegal as $item)
                            <div class="flex items-center justify-between bg-stone-950 border border-stone-800/80 rounded-2xl p-4">
                                <div>
                                    <span class="text-sm font-semibold text-white block">{{ $item->title }}</span>
                                    <span class="text-xs text-amber-500/80 font-mono">{{ $item->url }}</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-stone-500 font-mono">Order: {{ $item->sort_order }}</span>

                                    <form action="{{ route('admin.navigation.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove link?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-stone-500 py-4 text-center">No footer legal links created.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>
