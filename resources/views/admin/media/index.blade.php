<x-layouts.admin title="Media Library">

    <div class="space-y-6" x-data="{
        copiedId: null,
        copyUrl(id, url) {
            navigator.clipboard.writeText(url);
            this.copiedId = id;
            setTimeout(() => this.copiedId = null, 2000);
        }
    }">

        <!-- Top Header & Multiple Upload -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Media Library</h1>
                <p class="text-xs text-stone-400 mt-1">Upload and manage high-resolution food and ambience photography</p>
            </div>

            <!-- Upload Multiple Form -->
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
                @csrf
                <label class="cursor-pointer inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Upload Images</span>
                    <input type="file" name="files[]" multiple accept="image/*" class="hidden" onchange="this.form.submit()">
                </label>
            </form>
        </div>

        <!-- Search Bar -->
        <div class="bg-stone-900 border border-stone-800 p-4 rounded-2xl flex items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.media.index') }}" class="w-full sm:w-80">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search media files by name..."
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>
            </form>
            <span class="text-xs text-stone-400 hidden sm:inline">
                Showing {{ $media->total() }} assets
            </span>
        </div>

        <!-- Media Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @forelse($media as $item)
                <div class="group bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden shadow-lg hover:border-amber-500/50 transition-all flex flex-col justify-between">
                    <div class="aspect-square bg-stone-950 overflow-hidden relative">
                        <img src="{{ $item->url }}" alt="{{ $item->alt_text }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>

                    <div class="p-3 bg-stone-900 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <p class="text-[11px] font-semibold text-white truncate" title="{{ $item->original_name }}">
                                {{ $item->original_name }}
                            </p>
                            <p class="text-[10px] text-stone-500">
                                {{ $item->formatted_size }} • {{ $item->width }}x{{ $item->height }}
                            </p>
                        </div>

                        <div class="pt-2 border-t border-stone-800 flex items-center justify-between">
                            <button @click="copyUrl({{ $item->id }}, '{{ $item->url }}')"
                                    class="text-[10px] font-semibold flex items-center gap-1 text-stone-400 hover:text-amber-400 transition-colors">
                                <i data-lucide="copy" class="w-3 h-3"></i>
                                <span x-text="copiedId === {{ $item->id }} ? 'Copied!' : 'Copy URL'"></span>
                            </button>

                            <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this media file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-stone-500 hover:text-rose-400 transition-colors p-1" title="Delete File">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-stone-500 bg-stone-900 border border-stone-800 rounded-3xl">
                    <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-3 text-stone-600"></i>
                    <h3 class="font-serif-heading text-lg font-bold text-white mb-1">No Media Files</h3>
                    <p class="text-xs text-stone-400 max-w-sm mx-auto mb-6">Upload high-resolution photography above to use across dishes and sections.</p>
                </div>
            @endforelse
        </div>

        @if($media->hasPages())
            <div class="pt-4">
                {{ $media->links() }}
            </div>
        @endif

    </div>

</x-layouts.admin>
