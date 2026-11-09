<x-layouts.admin title="URL Redirects">

    <div class="space-y-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">URL Redirect Manager</h1>
                <p class="text-xs text-stone-400 mt-1">Manage permanent 301 and temporary 302 redirects to preserve SEO rankings</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Add New Redirect Form -->
            <div class="lg:col-span-1">
                <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 shadow-xl sticky top-8 space-y-6">
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3 flex items-center gap-2">
                        <i data-lucide="corner-down-right" class="w-4 h-4 text-amber-400"></i>
                        <span>New Redirect</span>
                    </h3>

                    <form action="{{ route('admin.redirects.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Old URL / Source Path <span class="text-amber-500">*</span>
                            </label>
                            <input type="text"
                                   name="source_url"
                                   required
                                   placeholder="/old-dinner-menu or /menu-2023"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                            <p class="text-[11px] text-stone-500 mt-1">Relative path starting with /</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                New URL / Destination <span class="text-amber-500">*</span>
                            </label>
                            <input type="text"
                                   name="destination_url"
                                   required
                                   placeholder="/menu or /contact"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                            <p class="text-[11px] text-stone-500 mt-1">Relative or full target URL</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                HTTP Status Code <span class="text-amber-500">*</span>
                            </label>
                            <select name="status_code" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none">
                                <option value="301">301 - Permanent Redirect (Recommended for SEO)</option>
                                <option value="302">302 - Temporary Redirect</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg mt-2">
                            Create Redirect
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Redirects List -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-stone-800 flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Configured Redirects</span>
                        <span class="text-xs text-stone-500 font-mono">{{ $redirects->total() }} total</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                                <tr>
                                    <th class="py-4 px-6">Source (Old)</th>
                                    <th class="py-4 px-6">Destination (New)</th>
                                    <th class="py-4 px-6">Type</th>
                                    <th class="py-4 px-6">Hits</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-800/80 text-stone-300 font-mono">
                                @forelse($redirects as $redirect)
                                    <tr class="hover:bg-stone-800/30 transition-colors">
                                        <td class="py-4 px-6 text-rose-400 font-medium">
                                            {{ $redirect->source_url }}
                                        </td>
                                        <td class="py-4 px-6 text-emerald-400 font-medium">
                                            {{ $redirect->destination_url }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $redirect->status_code == 301 ? 'bg-blue-950 text-blue-400 border border-blue-500/40' : 'bg-amber-950 text-amber-400 border border-amber-500/40' }}">
                                                {{ $redirect->status_code }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-stone-400">
                                            {{ number_format($redirect->hits) }}
                                        </td>
                                        <td class="py-4 px-6 font-sans">
                                            @if($redirect->is_active)
                                                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400" title="Active"></span>
                                            @else
                                                <span class="inline-block w-2 h-2 rounded-full bg-stone-600" title="Disabled"></span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right font-sans">
                                            <form action="{{ route('admin.redirects.destroy', $redirect) }}" method="POST" onsubmit="return confirm('Remove redirect rule?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-400 transition-colors" title="Delete Redirect">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-stone-500 font-sans">
                                            <i data-lucide="compass" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                            <p class="text-xs">No custom redirect rules found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($redirects->hasPages())
                        <div class="p-6 border-t border-stone-800">
                            {{ $redirects->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</x-layouts.admin>
