<x-layouts.admin title="Manage Pages">

    <div class="space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Pages & Page Builder
                </h1>
                <p class="text-xs text-stone-400 mt-1">
                    Manage CMS pages, custom landing pages, and section layouts
                </p>
            </div>

            <a href="{{ route('admin.pages.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Create New Page</span>
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-stone-900 border border-stone-800 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.pages.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-72">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search pages by title or slug..."
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>

                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-stone-950 border border-stone-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.pages.index') }}" class="text-xs text-stone-400 hover:text-white underline">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Page Title</th>
                            <th class="py-4 px-6">URL Slug</th>
                            <th class="py-4 px-6">Template</th>
                            <th class="py-4 px-6">Sections</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($pages as $page)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-serif-heading text-sm font-bold text-white flex items-center gap-2">
                                        <span>{{ $page->title }}</span>
                                        @if($page->is_system)
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-stone-800 text-stone-400 border border-stone-700">System</span>
                                        @endif
                                    </div>
                                    @if($page->excerpt)
                                        <p class="text-[11px] text-stone-500 line-clamp-1 mt-0.5">{{ $page->excerpt }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono text-stone-400">
                                    /{{ $page->slug === 'home' ? '' : $page->slug }}
                                </td>
                                <td class="py-4 px-6 capitalize">
                                    {{ $page->template }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('admin.pages.sections', $page->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-400 hover:text-stone-950 transition-colors">
                                        <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                                        <span>{{ $page->sections->count() }} Sections</span>
                                    </a>
                                </td>
                                <td class="py-4 px-6">
                                    @if($page->status === 'published')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-stone-400 border border-stone-700">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Preview -->
                                        <a href="{{ route('pages.preview', $page->id) }}" target="_blank" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="Live Preview">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        <!-- Builder Shortcut -->
                                        <a href="{{ route('admin.pages.sections', $page->id) }}" class="p-1.5 text-amber-400 hover:text-amber-300 hover:bg-stone-800 rounded-lg transition-colors" title="Section Builder">
                                            <i data-lucide="layout" class="w-4 h-4"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="Edit Metadata">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>

                                        <!-- Duplicate -->
                                        <form action="{{ route('admin.pages.duplicate', $page->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-1.5 text-stone-400 hover:text-white hover:bg-stone-800 rounded-lg transition-colors" title="Duplicate Page">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        @if(!$page->is_system)
                                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 hover:bg-stone-800 rounded-lg transition-colors" title="Delete Page">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-stone-500">
                                    No pages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pages->hasPages())
                <div class="p-4 border-t border-stone-800">
                    {{ $pages->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
