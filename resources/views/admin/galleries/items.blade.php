<x-layouts.admin title="Manage Gallery Photos">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('admin.galleries.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Galleries</span>
                </a>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Photos in "{{ $gallery->title }}"</h1>
                <p class="text-xs text-stone-400 mt-1">Upload and arrange photographs for this gallery</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Add New Photo Form -->
            <div class="lg:col-span-1">
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl sticky top-8 space-y-6">
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4 text-amber-400"></i>
                        <span>Add Photo</span>
                    </h3>

                    <form action="{{ route('admin.galleries.items.add', $gallery) }}" method="POST" class="space-y-4">
                        @csrf

                        <x-admin.media-picker name="image_path" label="Select Photo" :value="old('image_path')" />

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Photo Title (Optional)
                            </label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="e.g. Candlelit Corner Booth"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Alt Text (SEO & Accessibility)
                            </label>
                            <input type="text"
                                   name="alt_text"
                                   value="{{ old('alt_text') }}"
                                   placeholder="e.g. Cozy velvet booth with copper lighting"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Caption (Optional)
                            </label>
                            <textarea name="caption"
                                      rows="2"
                                      placeholder="Brief caption shown in lightbox..."
                                      class="w-full bg-stone-950 border border-stone-800 rounded-xl p-3 text-xs text-white focus:border-amber-400 focus:outline-none">{{ old('caption') }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                            Add Photo to Gallery
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Photo Grid -->
            <div class="lg:col-span-2">
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
                    <div class="flex items-center justify-between border-b border-stone-800 pb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-stone-400">
                            {{ $gallery->items->count() }} {{ Str::plural('Photo', $gallery->items->count()) }} in collection
                        </span>
                    </div>

                    @if($gallery->items->isEmpty())
                        <div class="py-16 text-center text-stone-500">
                            <i data-lucide="image" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                            <p class="text-sm font-medium text-stone-400">This gallery has no photos yet.</p>
                            <p class="text-xs text-stone-500 mt-1">Use the form on the left to add your first photo.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($gallery->items as $item)
                                <div class="group relative bg-stone-950 border border-stone-800 rounded-2xl overflow-hidden shadow-md flex flex-col">
                                    <div class="aspect-square bg-stone-900 overflow-hidden relative">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->alt_text ?? $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                        <div class="absolute inset-0 bg-stone-950/70 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-2">
                                            <form action="{{ route('admin.galleries.items.delete', [$gallery, $item]) }}" method="POST" onsubmit="return confirm('Remove photo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg bg-rose-600 hover:bg-rose-500 text-white transition-colors" title="Delete Photo">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @if($item->title || $item->caption)
                                        <div class="p-2.5">
                                            @if($item->title)
                                                <p class="text-xs font-semibold text-white truncate">{{ $item->title }}</p>
                                            @endif
                                            @if($item->caption)
                                                <p class="text-[11px] text-stone-400 truncate">{{ $item->caption }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</x-layouts.admin>
