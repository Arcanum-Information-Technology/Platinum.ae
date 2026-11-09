@props(['data'])

@php
    $badge = $data['badge'] ?? null;
    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
@endphp

<section id="contact-form-section" class="py-24 bg-stone-950 border-t border-stone-900">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!empty(trim($badge ?? '')) || !empty(trim($title ?? '')) || !empty(trim($subtitle ?? '')))
            <div class="text-center mb-12">
                @if(!empty(trim($badge ?? '')))
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">
                        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                        <span>{{ $badge }}</span>
                    </div>
                @endif
                @if(!empty(trim($title ?? '')))
                    <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-white tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
                @if(!empty(trim($subtitle ?? '')))
                    <p class="text-stone-400 text-sm sm:text-base mt-2 leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 p-4 rounded-xl bg-rose-950/80 border border-rose-500/50 text-rose-200 text-xs space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-sm">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    Please correct the following errors:
                </div>
                <ul class="list-disc pl-5 space-y-0.5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6 bg-stone-900/90 border border-stone-800 p-8 sm:p-10 rounded-3xl shadow-2xl">
            @csrf

            <!-- Honeypot anti-spam field -->
            <input type="text" name="website_hp" value="" class="hidden" tabindex="-1" autocomplete="off">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Full Name <span class="text-amber-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="e.g. Eleanor Vance"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-100 placeholder-stone-600 focus:border-amber-400 focus:outline-none transition-colors">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Email Address <span class="text-amber-500">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="eleanor@example.com"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-100 placeholder-stone-600 focus:border-amber-400 focus:outline-none transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Phone Number
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone') }}"
                           placeholder="+1 (555) 000-0000"
                           class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-100 placeholder-stone-600 focus:border-amber-400 focus:outline-none transition-colors">
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                        Subject / Request Type
                    </label>
                    <select id="subject"
                            name="subject"
                            class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-100 focus:border-amber-400 focus:outline-none transition-colors">
                        <option value="Table Reservation">Table Reservation</option>
                        <option value="Private Event & Buyout">Private Event & Buyout</option>
                        <option value="Sommelier & Wine Inquiries">Sommelier & Wine Inquiries</option>
                        <option value="Dietary & Allergen Accommodations">Dietary & Allergen Accommodations</option>
                        <option value="General Question">General Question</option>
                    </select>
                </div>
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">
                    Your Message / Desired Date & Party Size <span class="text-amber-500">*</span>
                </label>
                <textarea id="message"
                          name="message"
                          rows="5"
                          required
                          placeholder="Please specify preferred date, seating time, number of guests, or dietary notes..."
                          class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-100 placeholder-stone-600 focus:border-amber-400 focus:outline-none transition-colors">{{ old('message') }}</textarea>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-xl font-semibold uppercase tracking-wider text-sm text-stone-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/20 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99]">
                <span>Submit Reservation Inquiry</span>
                <i data-lucide="send" class="w-4 h-4"></i>
            </button>
        </form>

    </div>
</section>
