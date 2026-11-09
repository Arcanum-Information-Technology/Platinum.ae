<x-layouts.admin title="Staff & Roles">

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Staff & User Management</h1>
                <p class="text-xs text-stone-400 mt-1">Manage team members, roles, and administrative access permissions</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Add Staff User</span>
            </a>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-950/80 border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400 font-semibold">
                        <tr>
                            <th class="py-4 px-6">User</th>
                            <th class="py-4 px-6">Assigned Role</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Created</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800/80 text-stone-300">
                        @forelse($users as $user)
                            <tr class="hover:bg-stone-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-stone-950 border border-stone-800 flex items-center justify-center font-bold text-amber-400 font-serif-heading text-xs">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-serif-heading text-sm font-bold text-white block">{{ $user->name }}</span>
                                            <span class="text-[11px] text-stone-400 font-mono">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @foreach($user->roles as $role)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/40">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="py-4 px-6">
                                    @if($user->is_active)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-950 text-emerald-400 border border-emerald-500/40">Active</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-950 text-rose-400 border border-rose-500/40">Suspended</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-stone-400 text-[11px]">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-stone-400 hover:text-amber-400 transition-colors" title="Edit Staff User">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-stone-400 hover:text-rose-400 transition-colors" title="Delete User">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-stone-500">
                                    <p class="text-xs">No users found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-6 border-t border-stone-800">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>
