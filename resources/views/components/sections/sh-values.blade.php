@props(['data'])

@php
    $ornament = \App\Support\AssetUrl::make($data['ornament'] ?? '');
    $rawItems = $data['items'] ?? [];
    $items = is_array($rawItems) ? array_values($rawItems) : [];
    $total = count($items);
@endphp

<section class="sh-band">
    <div class="sh-wrap max-w-6xl mx-auto px-4 sm:px-6">
        @if($ornament)
            <img class="sh-ornament" src="{{ $ornament }}" alt="Our Core Values">
        @endif

        @if($total > 0)
            <div
                class="sh-values-carousel-wrapper"
                x-data="{
                    active: 0,
                    total: {{ $total }},
                    perPage: 3,
                    touchStartX: 0,
                    touchEndX: 0,
                    init() {
                        this.updatePerPage();
                        window.addEventListener('resize', () => this.updatePerPage());
                    },
                    updatePerPage() {
                        if (window.innerWidth < 640) {
                            this.perPage = 1;
                        } else if (window.innerWidth < 1024) {
                            this.perPage = 2;
                        } else {
                            this.perPage = 3;
                        }
                    },
                    next() {
                        this.active = (this.active + 1) % this.total;
                    },
                    prev() {
                        this.active = (this.active - 1 + this.total) % this.total;
                    },
                    goTo(index) {
                        this.active = index;
                    },
                    handleTouchStart(e) {
                        this.touchStartX = e.touches[0].clientX;
                    },
                    handleTouchEnd(e) {
                        this.touchEndX = e.changedTouches[0].clientX;
                        if (this.touchStartX - this.touchEndX > 45) {
                            this.next();
                        } else if (this.touchEndX - this.touchStartX > 45) {
                            this.prev();
                        }
                    }
                }"
                @touchstart.passive="handleTouchStart($event)"
                @touchend.passive="handleTouchEnd($event)"
            >
                <!-- Carousel Viewport -->
                <div class="sh-values-viewport">
                    <!-- Carousel Sliding Track -->
                    <div
                        class="sh-values-track"
                        :style="'transform: translateX(calc(-1 * ' + active + ' * (100% + 28px) / ' + perPage + '));'"
                    >
                        @php
                            $renderedItems = array_merge($items, $items);
                        @endphp

                        @foreach($renderedItems as $idx => $item)
                            <article class="sh-value-item">
                                <h3>{{ $item['title'] ?? '' }}</h3>
                                <p>{{ $item['body'] ?? '' }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination Dots at Bottom Only -->
                @if($total > 1)
                    <div class="sh-values-dots" role="tablist" aria-label="Core values navigation">
                        @for($i = 0; $i < $total; $i++)
                            <button
                                type="button"
                                class="sh-values-dot"
                                :class="{ 'is-active': active === {{ $i }} }"
                                @click="goTo({{ $i }})"
                                aria-label="Go to slide {{ $i + 1 }}"
                                :aria-selected="(active === {{ $i }}).toString()"
                            ></button>
                        @endfor
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
