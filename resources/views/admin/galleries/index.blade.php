<x-layouts.admin title="Photo Galleries">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Photo Galleries</h1>
                <p class="text-xs text-stone-400 mt-1">Manage photo collections for dining spaces, events, and dishes</p>
            </div>

            <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Create Gallery</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galleries as $gallery)
                <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl flex flex-col justify-between group hover:border-stone-700 transition-colors">
                    <div>
                        <div class="relative h-48 bg-stone-950 overflow-hidden">
                            @if($gallery->cover_image)
                                <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-stone-600">
                                    <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                                    <span class="text-xs">No Cover Image</span>
                                </div>
                            @endif

                            <div class="absolute top-4 right-4 flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-950/80 backdrop-blur-md text-amber-400 border border-stone-800">
                                    {{ $gallery->items_count }} {{ Str::plural('photo', $gallery->items_count) }}
                                </span>
                                @if($gallery->is_active)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-950/90 text-emerald-400 border border-emerald-500/40">Active</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-stone-950 text-stone-500 border border-stone-800">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="font-serif-heading text-lg font-bold text-white mb-1">{{ $gallery->title }}</h3>
                            <p class="text-xs text-stone-400 line-clamp-2 leading-relaxed">
                                {{ $gallery->description ?? 'No description provided for this collection.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 pt-0 border-t border-stone-800/80 mt-4 flex items-center justify-between">
                        <a href="{{ route('admin.galleries.items', $gallery) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-400 hover:text-amber-300">
                            <i data-lucide="images" class="w-4 h-4"></i>
                            <span>Manage Photos</span>
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="p-2 text-stone-400 hover:text-amber-400 transition-colors" title="Edit Gallery Details">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>

                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-stone-400 hover:text-rose-400 transition-colors" title="Delete Gallery">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-stone-900 border border-stone-800 rounded-3xl p-12 text-center text-stone-500">
                    <i data-lucide="image" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                    <p class="text-sm font-medium text-stone-400">No photo galleries created yet.</p>
                    <a href="{{ route('admin.galleries.create') }}" class="inline-block mt-4 text-xs font-semibold uppercase tracking-wider text-amber-400 hover:underline">
                        Create your first gallery
                    </a>
                </div>
            @endforelse
        </div>

        @if($galleries->hasPages())
            <div class="mt-6">
                {{ $galleries->links() }}
            </div>
        @endif

    </div>

</x-layouts.admin>
