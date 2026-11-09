<x-layouts.admin title="Application Settings">

    <div class="max-w-4xl mx-auto space-y-6">

        <div>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">Application & Site Settings</h1>
            <p class="text-xs text-stone-400 mt-1">Configure global restaurant branding, header/footer text, social links, and integrations</p>
        </div>

        <!-- Settings Tabs -->
        <div class="flex items-center gap-2 border-b border-stone-800 pb-3 overflow-x-auto text-xs font-semibold">
            <a href="{{ route('admin.settings.index', ['tab' => 'general']) }}"
               class="px-4 py-2 rounded-xl transition-colors {{ $group === 'general' ? 'bg-amber-400 text-stone-950 shadow-md' : 'text-stone-400 hover:text-white bg-stone-900 border border-stone-800' }}">
                General & Contact
            </a>
            <a href="{{ route('admin.settings.index', ['tab' => 'branding']) }}"
               class="px-4 py-2 rounded-xl transition-colors {{ $group === 'branding' ? 'bg-amber-400 text-stone-950 shadow-md' : 'text-stone-400 hover:text-white bg-stone-900 border border-stone-800' }}">
                Branding & Logos
            </a>
            <a href="{{ route('admin.settings.index', ['tab' => 'social']) }}"
               class="px-4 py-2 rounded-xl transition-colors {{ $group === 'social' ? 'bg-amber-400 text-stone-950 shadow-md' : 'text-stone-400 hover:text-white bg-stone-900 border border-stone-800' }}">
                Social Media
            </a>
            <a href="{{ route('admin.settings.index', ['tab' => 'header_footer']) }}"
               class="px-4 py-2 rounded-xl transition-colors {{ $group === 'header_footer' ? 'bg-amber-400 text-stone-950 shadow-md' : 'text-stone-400 hover:text-white bg-stone-900 border border-stone-800' }}">
                Header & Footer
            </a>
            <a href="{{ route('admin.settings.index', ['tab' => 'integrations']) }}"
               class="px-4 py-2 rounded-xl transition-colors {{ $group === 'integrations' ? 'bg-amber-400 text-stone-950 shadow-md' : 'text-stone-400 hover:text-white bg-stone-900 border border-stone-800' }}">
                Analytics & Scripts
            </a>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="group" value="{{ $group }}">

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">

                @if($group === 'general')
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">General Information</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Restaurant / Site Name</label>
                            <input type="text" name="settings[site_name]" value="{{ $allSettings['site_name'] ?? 'Saffron & Thyme' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Tagline</label>
                            <input type="text" name="settings[site_tagline]" value="{{ $allSettings['site_tagline'] ?? 'Artisanal Heritage Dining & Hearth Cuisine' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Primary Phone</label>
                            <input type="text" name="settings[restaurant_phone]" value="{{ $allSettings['restaurant_phone'] ?? '' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Primary Email</label>
                            <input type="email" name="settings[restaurant_email]" value="{{ $allSettings['restaurant_email'] ?? '' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                    <!-- Inquiries Email Notification Receiver -->
                    <div class="p-5 rounded-2xl bg-amber-500/10 border border-amber-500/30 space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-400">
                            Inquiry & Booking Notification Receiver Email *
                        </label>
                        <p class="text-[11px] text-stone-300 leading-relaxed">
                            When a customer submits a <strong>Table Booking</strong>, <strong>Franchise Application</strong>, or <strong>Contact Message</strong>, an instant formatted email alert with all details will be delivered to this address.
                        </p>
                        <input type="email"
                               name="settings[inquiry_notification_email]"
                               value="{{ $allSettings['inquiry_notification_email'] ?? ($allSettings['restaurant_email'] ?? 'info@platinumhospitality.ae') }}"
                               placeholder="your-email@company.com"
                               class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Physical Address</label>
                        <input type="text" name="settings[restaurant_address]" value="{{ $allSettings['restaurant_address'] ?? '' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Complaints & Feedback Email</label>
                        <input type="email" name="settings[complaints_email]" value="{{ $allSettings['complaints_email'] ?? '' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                @elseif($group === 'branding')
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">Logos & Brand Identity</h3>

                    <x-admin.media-picker name="settings[site_logo]" label="Main Website Logo" :value="$allSettings['site_logo'] ?? null" />
                    <x-admin.media-picker name="settings[site_favicon]" label="Favicon Icon (.ico, .png)" :value="$allSettings['site_favicon'] ?? null" />

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Primary Brand Color</label>
                        <input type="text" name="settings[brand_primary_color]" value="{{ $allSettings['brand_primary_color'] ?? '#f59e0b' }}" placeholder="#f59e0b" class="w-full max-w-xs bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none font-mono">
                    </div>

                @elseif($group === 'social')
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">Social Media Profiles</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Instagram URL</label>
                            <input type="url" name="settings[social_instagram]" value="{{ $allSettings['social_instagram'] ?? 'https://instagram.com' }}" placeholder="https://instagram.com/saffronandthyme" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Facebook URL</label>
                            <input type="url" name="settings[social_facebook]" value="{{ $allSettings['social_facebook'] ?? 'https://facebook.com' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">TikTok URL</label>
                            <input type="url" name="settings[social_tiktok]" value="{{ $allSettings['social_tiktok'] ?? '' }}" placeholder="https://www.tiktok.com" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">TripAdvisor URL</label>
                            <input type="url" name="settings[social_tripadvisor]" value="{{ $allSettings['social_tripadvisor'] ?? 'https://tripadvisor.com' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">OpenTable / Resy URL</label>
                            <input type="url" name="settings[social_opentable]" value="{{ $allSettings['social_opentable'] ?? 'https://opentable.com' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                @elseif($group === 'header_footer')
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">Header & Footer Content</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Header Button Label</label>
                            <input type="text" name="settings[header_cta_text]" value="{{ $allSettings['header_cta_text'] ?? 'Reserve Table' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Header Button URL</label>
                            <input type="text" name="settings[header_cta_url]" value="{{ $allSettings['header_cta_url'] ?? '/contact' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Footer Short Description</label>
                        <textarea name="settings[footer_about]" rows="3" class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ $allSettings['footer_about'] ?? 'Artisanal dining celebrating ancient trade-route spices, wood-fired hearths, and locally sourced organic ingredients.' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Footer Copyright Text</label>
                        <input type="text" name="settings[footer_copyright]" value="{{ $allSettings['footer_copyright'] ?? '© 2026 Saffron & Thyme Culinary Group. All rights reserved.' }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                @elseif($group === 'integrations')
                    <h3 class="font-serif-heading text-lg font-bold text-white border-b border-stone-800 pb-3">Analytics & Script Integrations</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Google Analytics 4 ID</label>
                            <input type="text" name="settings[google_analytics_id]" value="{{ $allSettings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none font-mono">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Google Tag Manager ID</label>
                            <input type="text" name="settings[google_tag_manager_id]" value="{{ $allSettings['google_tag_manager_id'] ?? '' }}" placeholder="GTM-XXXXXXX" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none font-mono">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300 mb-2">Custom Header Code / Meta Tags (Advanced)</label>
                        <textarea name="settings[custom_head_scripts]" rows="3" placeholder="<!-- Any custom meta tags or verification snippets -->" class="w-full bg-stone-950 border border-stone-800 rounded-xl p-4 text-xs font-mono text-white focus:border-amber-400 focus:outline-none">{{ $allSettings['custom_head_scripts'] ?? '' }}</textarea>
                    </div>
                @endif

                <div class="flex justify-end pt-4 border-t border-stone-800">
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                        Save {{ ucfirst($group) }} Settings
                    </button>
                </div>
            </div>
        </form>

    </div>

</x-layouts.admin>
