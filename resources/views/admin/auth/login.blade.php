<x-layouts.guest title="Admin Login">

    <div class="mb-6 text-center">
        <h3 class="font-serif-heading text-xl font-bold text-white">Sign In to Dashboard</h3>
        <p class="text-xs text-stone-400 mt-1">Enter your staff credentials to access CMS</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 p-3 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-xs">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-1.5">
                Staff Email
            </label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-stone-100 placeholder-stone-600 focus:border-amber-400 focus:outline-none transition-colors">
        </div>

        <div x-data="{ showPassword: false }">
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-1.5">
                Password
            </label>
            <div class="relative">
                <input :type="showPassword ? 'text' : 'password'"
                       id="password"
                       name="password"
                       required
                       class="w-full bg-stone-950 border border-stone-800 rounded-xl pl-4 pr-11 py-2.5 text-sm text-stone-100 placeholder-stone-600 focus:border-amber-400 focus:outline-none transition-colors">
                <button type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-amber-400 focus:outline-none p-1 transition-colors"
                        aria-label="Toggle password visibility">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
            <label class="flex items-center gap-2 cursor-pointer text-stone-400 hover:text-stone-200">
                <input type="checkbox" name="remember" class="rounded bg-stone-950 border-stone-800 text-amber-500 focus:ring-amber-500">
                <span>Remember session</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/20 transition-all">
                <span>Sign In</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </form>

</x-layouts.guest>
