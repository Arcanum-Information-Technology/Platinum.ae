@props(['data' => []])

@php
    $badge = data_get($data, 'badge', 'Hospitality Hours & Reservations');
    $title = data_get($data, 'title', 'Booking Table In Online');
    $subtitle = data_get($data, 'subtitle', 'Reserve your table across any of our signature venues in Dubai and Abu Dhabi.');
    $phone = data_get($data, 'phone', '+971 4 360 8888');
    $email = data_get($data, 'email', 'info@platinumhospitality.ae');
    $location = data_get($data, 'location', 'United Arab Emirates');
    $hours = data_get($data, 'hours', collect());

    // Fallback schedule if hours collection is empty
    $schedule = [
        ['day' => 'Monday', 'time' => '09:00 AM - 19:00 PM'],
        ['day' => 'Tuesday', 'time' => '10:00 AM - 20:00 PM'],
        ['day' => 'Wednesday', 'time' => '11:00 AM - 20:00 PM'],
        ['day' => 'Thursday', 'time' => '11:00 AM - 21:00 PM'],
        ['day' => 'Friday', 'time' => '13:00 PM - 21:00 PM'],
        ['day' => 'Saturday', 'time' => '09:00 AM - 23:00 PM'],
        ['day' => 'Sunday', 'time' => '13:00 PM - 19:00 PM'],
    ];
@endphp

<section id="book-table" class="py-24 sm:py-32 bg-[#0A0A0A] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <span class="gold-badge mb-3">{{ $badge }}</span>
            <h2 class="font-serif-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $title }}
            </h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C5A265] to-transparent mx-auto mb-4"></div>
            <p class="text-stone-300 text-base sm:text-lg font-light leading-relaxed">
                {{ $subtitle }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            <!-- Left: Weekly Opening Hours & Quick Contact (5 cols on lg) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Hours Card -->
                <div class="plat-glass rounded-3xl p-6 sm:p-8 border border-white/10 space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-white/10">
                        <div class="w-10 h-10 rounded-xl bg-[#C5A265]/15 text-[#DFCA9B] flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-serif-heading text-xl font-bold text-white">Opening Hours</h3>
                            <span class="text-xs text-stone-400">Weekly Hospitality Schedule</span>
                        </div>
                    </div>

                    <div class="divide-y divide-white/5 space-y-1 text-sm">
                        @if($hours->isNotEmpty())
                            @foreach($hours as $h)
                                <div class="py-3 flex items-center justify-between">
                                    <span class="font-medium text-stone-200">{{ $h->day_name }}</span>
                                    @if($h->is_closed)
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-rose-950/80 text-rose-300 border border-rose-500/30 font-semibold">Closed</span>
                                    @else
                                        <span class="font-mono text-xs text-[#DFCA9B] font-semibold">
                                            {{ \Carbon\Carbon::parse($h->open_time_1)->format('h:i A') }} - {{ \Carbon\Carbon::parse($h->close_time_1)->format('h:i A') }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            @foreach($schedule as $item)
                                <div class="py-3 flex items-center justify-between">
                                    <span class="font-medium text-stone-200">{{ $item['day'] }}</span>
                                    <span class="font-mono text-xs text-[#DFCA9B] font-semibold">{{ $item['time'] }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Contact & Support Snippet -->
                <div class="plat-glass-gold rounded-3xl p-6 sm:p-8 border border-[#C5A265]/30 space-y-4">
                    <h4 class="font-serif-heading text-lg font-bold text-white">Direct Concierge Service</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 text-stone-300">
                            <i data-lucide="phone" class="w-4 h-4 text-[#C5A265]"></i>
                            <div>
                                <span class="text-[11px] text-stone-400 block uppercase tracking-wider">Phone</span>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="font-semibold text-white hover:text-[#DFCA9B]">{{ $phone }}</a>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-stone-300">
                            <i data-lucide="mail" class="w-4 h-4 text-[#C5A265]"></i>
                            <div>
                                <span class="text-[11px] text-stone-400 block uppercase tracking-wider">Email</span>
                                <a href="mailto:{{ $email }}" class="font-semibold text-white hover:text-[#DFCA9B]">{{ $email }}</a>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-stone-300">
                            <i data-lucide="map-pin" class="w-4 h-4 text-[#C5A265]"></i>
                            <div>
                                <span class="text-[11px] text-stone-400 block uppercase tracking-wider">Region</span>
                                <span class="text-white">{{ $location }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Online Table Booking Form (7 cols on lg) -->
            <div class="lg:col-span-7">
                <div class="plat-glass rounded-3xl p-8 sm:p-10 border border-white/10 shadow-2xl space-y-6">
                    <div>
                        <h3 class="font-serif-heading text-2xl sm:text-3xl font-bold text-white mb-1">
                            Book Your Table
                        </h3>
                        <p class="text-xs sm:text-sm text-stone-400">
                            Instant reservation inquiry. Our host team will confirm your seating within 30 minutes.
                        </p>
                    </div>

                    <form action="{{ url('/contact') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="subject" value="Online Table Reservation">

                        <!-- Honeypot -->
                        <div class="hidden" aria-hidden="true">
                            <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-1.5">
                                    Full Name *
                                </label>
                                <input type="text"
                                       name="name"
                                       required
                                       placeholder="Your Full Name"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>

                            <!-- Mobile Number -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-1.5">
                                    Mobile Number *
                                </label>
                                <input type="tel"
                                       name="phone"
                                       required
                                       placeholder="+971 50 XXX XXXX"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Email Address -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-1.5">
                                    Email Address *
                                </label>
                                <input type="email"
                                       name="email"
                                       required
                                       placeholder="name@company.com"
                                       class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]">
                            </div>

                            <!-- Select Brand Venue -->
                            <div>
                                <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-1.5">
                                    Select Brand Venue *
                                </label>
                                <select name="territory"
                                        class="w-full bg-[#141416] border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#C5A265]">
                                    <option value="Shakespeare Middle East">Shakespeare Middle East</option>
                                    <option value="Otantik Café & Restaurant">Otantik Café & Restaurant</option>
                                    <option value="Chinese Connection">Chinese Connection</option>
                                </select>
                            </div>
                        </div>

                        <!-- More Information / Message -->
                        <div>
                            <label class="block text-xs font-semibold text-stone-300 uppercase tracking-wider mb-1.5">
                                More Information / Seating Preferences
                            </label>
                            <textarea name="message"
                                      rows="4"
                                      required
                                      placeholder="Number of guests, preferred seating time, private dining requests, or dietary accommodations..."
                                      class="w-full bg-black/60 border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-stone-500 focus:outline-none focus:border-[#C5A265]"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-gold w-full py-4 rounded-xl text-sm font-bold flex items-center justify-center gap-2">
                                <i data-lucide="calendar-check" class="w-4 h-4"></i>
                                <span>Confirm Table Reservation</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

