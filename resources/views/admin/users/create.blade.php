<x-layouts.admin title="Add Staff User">

    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-amber-500 hover:text-amber-400 inline-flex items-center gap-1 mb-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to Users</span>
            </a>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Create Staff Account</h1>
            <p class="text-xs text-stone-400 mt-1">Add a new administrator, manager, or content editor</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Full Name <span class="text-amber-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="e.g. Chef Sanjay Kapoor"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Email Address <span class="text-amber-500">*</span>
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="staff@restaurant.com"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Password <span class="text-amber-500">*</span>
                        </label>
                        <input type="password"
                               name="password"
                               required
                               placeholder="Min 8 characters"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Confirm Password <span class="text-amber-500">*</span>
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               required
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        System Role <span class="text-amber-500">*</span>
                    </label>
                    <select name="role" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-stone-800">
                    <div class="flex items-center gap-3">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-amber-500 bg-stone-950 border-stone-800 focus:ring-0">
                        <label for="is_active" class="text-xs font-semibold text-stone-200">
                            Active Account (Can login to Admin Panel)
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-stone-800">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Create Account
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
