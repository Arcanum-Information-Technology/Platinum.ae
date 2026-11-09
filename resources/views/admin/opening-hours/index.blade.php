<x-layouts.admin title="Opening Hours">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif-heading text-2xl sm:text-3xl font-extrabold text-white">
                    Opening Hours Schedule
                </h1>
                <p class="text-xs text-stone-400 mt-1">
                    Manage service hours for website display, contact pages, and Google Schema.org
                </p>
            </div>
        </div>

        <form action="{{ route('admin.opening-hours.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-stone-900 border border-stone-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
                <div class="divide-y divide-stone-800">
                    @foreach($hours as $hour)
                        <div class="py-4 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $hour->is_closed ? 'bg-stone-600' : 'bg-amber-400' }}"></span>
                                    <span class="font-serif-heading text-base font-bold text-white w-28">
                                        {{ $hour->day_name }}
                                    </span>

                                    <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-300">
                                        <input type="checkbox" name="hours[{{ $hour->id }}][is_closed]" value="1" {{ $hour->is_closed ? 'checked' : '' }} class="rounded bg-stone-950 border-stone-800 text-rose-500 focus:ring-rose-500">
                                        <span class="{{ $hour->is_closed ? 'text-rose-400 font-semibold' : 'text-stone-400' }}">Closed This Day</span>
                                    </label>
                                </div>

                                <!-- Dual Slots -->
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    <!-- Slot 1 (Lunch) -->
                                    <div class="flex items-center gap-1.5 bg-stone-950 px-3 py-1.5 rounded-xl border border-stone-800">
                                        <span class="text-[10px] uppercase font-bold text-stone-500">Slot 1:</span>
                                        <input type="time" name="hours[{{ $hour->id }}][open_time_1]" value="{{ $hour->open_time_1 }}" class="bg-transparent text-white focus:outline-none text-xs">
                                        <span class="text-stone-600">–</span>
                                        <input type="time" name="hours[{{ $hour->id }}][close_time_1]" value="{{ $hour->close_time_1 }}" class="bg-transparent text-white focus:outline-none text-xs">
                                    </div>

                                    <!-- Slot 2 (Dinner) -->
                                    <div class="flex items-center gap-1.5 bg-stone-950 px-3 py-1.5 rounded-xl border border-stone-800">
                                        <span class="text-[10px] uppercase font-bold text-stone-500">Slot 2:</span>
                                        <input type="time" name="hours[{{ $hour->id }}][open_time_2]" value="{{ $hour->open_time_2 }}" class="bg-transparent text-white focus:outline-none text-xs">
                                        <span class="text-stone-600">–</span>
                                        <input type="time" name="hours[{{ $hour->id }}][close_time_2]" value="{{ $hour->close_time_2 }}" class="bg-transparent text-white focus:outline-none text-xs">
                                    </div>
                                </div>
                            </div>

                            <!-- Note field -->
                            <div class="pl-0 sm:pl-32">
                                <input type="text"
                                       name="hours[{{ $hour->id }}][note]"
                                       value="{{ $hour->note }}"
                                       placeholder="Special note, e.g. 'Late evening wine lounge' or 'Chef special seating'"
                                       class="w-full bg-stone-950/80 border border-stone-800/80 rounded-xl px-3 py-1.5 text-xs text-stone-300 placeholder-stone-600 focus:border-amber-400 focus:outline-none">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="px-8 py-3 rounded-xl font-semibold uppercase tracking-wider text-xs text-stone-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg">
                    Save Schedule Changes
                </button>
            </div>
        </form>

    </div>

</x-layouts.admin>
