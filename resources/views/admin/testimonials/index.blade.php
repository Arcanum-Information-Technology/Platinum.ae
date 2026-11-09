<x-layouts.admin title="Testimonials">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Guest Reviews & Testimonials</h1>
                <p class="text-xs text-stone-400 mt-1">Manage guest critiques, quotes, and star ratings</p>
            </div>

            <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add Review</span>
            </a>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">Customer</th>
                            <th class="py-4 px-6">Rating</th>
                            <th class="py-4 px-6">Review Content</th>
                            <th class="py-4 px-6">Featured</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($testimonials as $testimonial)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-stone-950 border border-stone-800 overflow-hidden flex items-center justify-center text-amber-400 shrink-0 font-serif-heading font-bold text-xs">
                                            @if($testimonial->avatar)
                                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->customer_name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($testimonial->customer_name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-serif-heading text-sm font-bold text-white block">{{ $testimonial->customer_name }}</span>
                                            <span class="text-[11px] text-stone-400">{{ $testimonial->customer_role ?? 'Guest' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-0.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $testimonial->rating ? 'fill-current' : 'text-stone-700' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-md">
                                    <p class="text-xs text-stone-300 italic line-clamp-2">"{{ $testimonial->content }}"</p>
                                </td>
                                <td class="py-4 px-6">
                                    @if($testimonial->is_featured)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/40">Featured</span>
                                    @else
                                        <span class="text-stone-600 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($testimonial->status === 'published')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">Published</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-950 text-stone-400 border border-stone-800">Draft</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="p-2 text-stone-400 hover:text-amber-400 transition-colors" title="Edit Review">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-stone-400 hover:text-rose-400 transition-colors" title="Delete Review">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-stone-500">
                                    <i data-lucide="message-square" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    <p class="text-xs">No guest testimonials found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($testimonials->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
