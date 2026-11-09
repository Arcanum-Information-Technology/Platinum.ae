@props(['data'])

@php
    $phone = \App\Models\Setting::get('restaurant_phone', '+1 (555) 234-5678');
    $email = \App\Models\Setting::get('restaurant_email', 'concierge@saffronandthyme.com');
    $address = \App\Models\Setting::get('restaurant_address', '124 Gourmet Boulevard');
    $city = \App\Models\Setting::get('restaurant_city', 'San Francisco');
    $state = \App\Models\Setting::get('restaurant_state', 'CA');
    $postalCode = \App\Models\Setting::get('restaurant_postal_code', '94102');
@endphp

<section class="py-16 bg-stone-900/40 border-t border-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-stone-900 border border-stone-800 p-8 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-serif-heading text-lg font-bold text-white mb-1">Our Location</h4>
                    <p class="text-xs sm:text-sm text-stone-400 leading-relaxed">
                        {{ $address }}<br>
                        {{ $city }}, {{ $state }} {{ $postalCode }}
                    </p>
                </div>
            </div>

            <div class="bg-stone-900 border border-stone-800 p-8 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="phone" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-serif-heading text-lg font-bold text-white mb-1">Phone & Concierge</h4>
                    <p class="text-xs sm:text-sm text-stone-400 leading-relaxed">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="hover:text-amber-400 transition-colors">
                            {{ $phone }}
                        </a><br>
                        Assistance daily 10am – 11pm
                    </p>
                </div>
            </div>

            <div class="bg-stone-900 border border-stone-800 p-8 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="mail" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-serif-heading text-lg font-bold text-white mb-1">Email Inquiries</h4>
                    <p class="text-xs sm:text-sm text-stone-400 leading-relaxed">
                        <a href="mailto:{{ $email }}" class="hover:text-amber-400 transition-colors">
                            {{ $email }}
                        </a><br>
                        Private event & sommelier requests
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
