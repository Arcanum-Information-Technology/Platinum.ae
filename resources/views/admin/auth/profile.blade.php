<x-layouts.admin title="Account Profile">

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-bold text-white">Staff Profile</h1>
                <p class="text-xs text-stone-400 mt-1">Manage your administrator details and password</p>
            </div>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 shadow-xl">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Full Name
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           required
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Email Address
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           required
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="pt-6 border-t border-stone-800 space-y-4">
                    <h3 class="font-serif-heading text-base font-bold text-white">Change Password</h3>
                    <p class="text-xs text-stone-400">Leave blank if you do not wish to change your current password.</p>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                            Current Password
                        </label>
                        <input type="password"
                               name="current_password"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                New Password
                            </label>
                            <input type="password"
                                   name="new_password"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                                Confirm New Password
                            </label>
                            <input type="password"
                                   name="new_password_confirmation"
                                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-800 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-layouts.admin>
