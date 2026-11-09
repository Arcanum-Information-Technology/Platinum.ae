<x-layouts.admin title="Page Builder: {{ $page->title }}">

    <div class="space-y-6" x-data="{
        addModalOpen: false,
        activeTab: 'all',
        editingSection: null,
        editModalOpen: false,
        structuredId: null,
        openEdit(sec) {
            this.editingSection = sec;
            this.editModalOpen = true;
        }
    }">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Pages List</span>
                </a>
                <div class="flex items-center gap-3">
                    <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                        Page Builder: {{ $page->title }}
                    </h1>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $page->status === 'published' ? 'bg-emerald-950 text-emerald-400 border border-emerald-500/40' : 'bg-stone-800 text-stone-400' }}">
                        {{ ucfirst($page->status) }}
                    </span>
                </div>
                <p class="text-xs text-stone-400 mt-1">
                    Manage ordered section blocks for <span class="font-mono text-amber-400">/{{ $page->slug === 'home' ? '' : $page->slug }}</span>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('pages.preview', $page->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold text-stone-300 bg-stone-900 border border-stone-800 hover:bg-stone-800 transition-colors">
                    <i data-lucide="eye" class="w-4 h-4 text-amber-400"></i>
                    <span>Live Preview</span>
                </a>

                <button @click="addModalOpen = true"
                        type="button"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Add New Section</span>
                </button>
            </div>
        </div>

        <!-- Section Builder List -->
        <div class="space-y-4">
            @forelse($page->sections as $index => $section)
                @php
                    $typeInfo = $availableSections[$section->section_type] ?? [
                        'name' => ucwords(str_replace('_', ' ', $section->section_type)),
                        'description' => 'Custom layout section',
                        'icon' => 'box',
                    ];
                @endphp
                <div class="bg-stone-900 border {{ $section->is_active ? 'border-stone-800' : 'border-stone-800/40 opacity-60' }} rounded-3xl p-5 sm:p-6 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all">

                    <!-- Left: Section Icon & Metadata -->
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $typeInfo['icon'] ?? 'box' }}" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono text-stone-500 font-bold">#{{ $index + 1 }}</span>
                                <h3 class="font-serif-heading text-lg font-bold text-white">
                                    {{ $typeInfo['name'] }}
                                </h3>
                                @if(!$section->is_active)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-stone-800 text-stone-400">Disabled</span>
                                @endif
                            </div>
                            <p class="text-xs text-stone-400 mt-0.5">
                                {{ $typeInfo['description'] }}
                                @if(!empty($section->data['title']))
                                    • <span class="text-amber-400 italic">"{{ $section->data['title'] }}"</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Right: Section Actions -->
                    <div class="flex items-center gap-2 self-end md:self-auto">

                        <!-- Toggle Active -->
                        <form action="{{ route('admin.pages.sections.toggle', ['page' => $page->id, 'section' => $section->id]) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="p-2 rounded-xl border {{ $section->is_active ? 'bg-emerald-950/60 border-emerald-500/40 text-emerald-400' : 'bg-stone-800 border-stone-700 text-stone-400' }} hover:scale-105 transition-all"
                                    title="{{ $section->is_active ? 'Disable Section' : 'Enable Section' }}">
                                <i data-lucide="{{ $section->is_active ? 'check-circle' : 'circle-slash' }}" class="w-4 h-4"></i>
                            </button>
                        </form>

                        @if(!empty($typeInfo['fields']))
                            <button type="button"
                                    @click="structuredId = {{ $section->id }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-white text-xs font-semibold transition-colors">
                                <i data-lucide="settings" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Configure</span>
                            </button>
                        @else
                            <button type="button"
                                    @click="openEdit({{ json_encode($section) }})"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-white text-xs font-semibold transition-colors">
                                <i data-lucide="settings" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Configure</span>
                            </button>
                        @endif

                        <!-- Delete -->
                        <form action="{{ route('admin.pages.sections.destroy', ['page' => $page->id, 'section' => $section->id]) }}" method="POST" class="inline" onsubmit="return confirm('Remove this section from the page?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl bg-stone-800/80 hover:bg-rose-950 hover:text-rose-400 text-stone-400 border border-stone-700/80 transition-colors" title="Delete Section">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>

                    </div>

                </div>
            @empty
                <div class="text-center py-16 bg-stone-900 border border-stone-800 rounded-3xl p-8">
                    <i data-lucide="layers" class="w-12 h-12 text-stone-600 mx-auto mb-3"></i>
                    <h3 class="font-serif-heading text-lg font-bold text-white mb-1">No Sections Added Yet</h3>
                    <p class="text-xs text-stone-400 max-w-sm mx-auto mb-6">Start building your page by adding hero banners, menu grids, story introductions, or galleries.</p>
                    <button @click="addModalOpen = true" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs font-semibold uppercase bg-amber-400 text-stone-950 hover:bg-amber-300 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Add First Section</span>
                    </button>
                </div>
            @endforelse
        </div>

        <!-- ADD SECTION MODAL (Displays all 23 available section types!) -->
        <div x-show="addModalOpen"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
             style="display: none;">
            <div @click.away="addModalOpen = false" class="bg-stone-900 border border-stone-800 rounded-3xl w-full max-w-4xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-stone-800 flex items-center justify-between">
                    <div>
                        <h3 class="font-serif-heading text-xl font-bold text-white">Add Page Section</h3>
                        <p class="text-xs text-stone-400 mt-0.5">Select a pre-designed component to insert into this page</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-stone-400 hover:text-white p-1">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($availableSections as $typeKey => $typeInfo)
                            <form action="{{ route('admin.pages.sections.add', $page->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="section_type" value="{{ $typeKey }}">
                                <button type="submit" class="w-full text-left p-5 rounded-2xl bg-stone-950 border border-stone-800 hover:border-amber-400 transition-all duration-200 group flex flex-col justify-between h-full hover:-translate-y-0.5 hover:shadow-xl">
                                    <div>
                                        <div class="w-10 h-10 rounded-xl bg-stone-900 group-hover:bg-amber-400 group-hover:text-stone-950 border border-stone-800 text-amber-400 flex items-center justify-center mb-3 transition-colors">
                                            <i data-lucide="{{ $typeInfo['icon'] ?? 'box' }}" class="w-5 h-5"></i>
                                        </div>
                                        <h4 class="font-serif-heading text-sm font-bold text-white group-hover:text-amber-400 transition-colors">
                                            {{ $typeInfo['name'] }}
                                        </h4>
                                        <p class="text-[11px] text-stone-400 mt-1 leading-relaxed">
                                            {{ $typeInfo['description'] }}
                                        </p>
                                    </div>
                                    <div class="pt-3 text-[10px] uppercase font-semibold tracking-wider text-amber-500/80 group-hover:text-amber-400 flex items-center gap-1 mt-2">
                                        <span>Select & Add</span>
                                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="px-6 py-3 border-t border-stone-800 bg-stone-950/60 flex justify-end">
                    <button @click="addModalOpen = false" class="px-5 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-white text-xs font-semibold">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        @foreach($page->sections as $section)
            @php
                $typeInfo = $availableSections[$section->section_type] ?? null;
            @endphp
            @if(!empty($typeInfo['fields']))
                <div x-show="structuredId === {{ $section->id }}" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-start justify-center p-4 sm:p-6" @click.self="structuredId = null">
                    <div class="bg-stone-900 border border-stone-800 rounded-3xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden my-6">
                        <div class="px-6 py-4 border-b border-stone-800 flex items-center justify-between">
                            <div>
                                <h3 class="font-serif-heading text-lg font-bold text-white">{{ $typeInfo['name'] }}</h3>
                                <p class="text-xs text-stone-400">Saved content and images update the live page.</p>
                            </div>
                            <button type="button" @click="structuredId = null" class="text-stone-400 hover:text-white p-1">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.pages.sections.update', ['page' => $page->id, 'section' => $section->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto flex-1 space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="structured" value="1">
                            @include('admin.pages.partials.section-fields', [
                                'fields' => $typeInfo['fields'],
                                'values' => $section->data ?? [],
                                'prefix' => 'data',
                            ])
                            <div class="pt-4 border-t border-stone-800 flex justify-end gap-3">
                                <button type="button" @click="structuredId = null" class="px-5 py-2.5 rounded-xl bg-stone-800 text-stone-300 text-xs font-semibold">Cancel</button>
                                <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- EDIT SECTION CONFIGURATION MODAL -->
        <div x-show="editModalOpen"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
             style="display: none;">
            <div @click.away="editModalOpen = false" class="bg-stone-900 border border-stone-800 rounded-3xl w-full max-w-2xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-stone-800 flex items-center justify-between">
                    <div>
                        <h3 class="font-serif-heading text-lg font-bold text-white">Configure Section</h3>
                        <p class="text-xs text-stone-400" x-text="'Type: ' + (editingSection?.section_type || '')"></p>
                    </div>
                    <button @click="editModalOpen = false" class="text-stone-400 hover:text-white p-1">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form :action="'/admin/pages/{{ $page->id }}/sections/' + editingSection?.id" method="POST" class="p-6 overflow-y-auto flex-1 space-y-4">
                    @csrf
                    @method('PUT')

                    <template x-for="(value, key) in (editingSection?.data || {})" :key="key">
                        <div x-show="typeof value !== 'object'">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-1.5" x-text="key.replace(/_/g, ' ')"></label>
                            <input type="text"
                                   :name="'data[' + key + ']'"
                                   :value="value"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </template>

                    <div class="pt-4 border-t border-stone-800 flex justify-end gap-3">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl bg-stone-800 text-stone-300 text-xs font-semibold">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 shadow-md">
                            Save Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.admin>
