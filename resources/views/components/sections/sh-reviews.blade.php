@props(['data'])

@php
    $ornament = \App\Support\AssetUrl::make($data['ornament'] ?? '');
    $googleIcon = \App\Support\AssetUrl::make('home-page/icon/icon.svg');
    $reviews = collect($data['testimonials'] ?? []);
    $avatarColors = ['#4a238f', '#1a73e8', '#c5221f', '#0f9d58', '#e37400', '#673ab7', '#8e24aa', '#00796b'];
@endphp

<section class="sh-reviews">
    <div class="sh-wrap">
        @if($ornament)
            <img class="sh-ornament" src="{{ $ornament }}" alt="Hear from our customers">
        @endif

        @if($reviews->isNotEmpty())
            <div
                class="sh-review-slider"
                x-data="{
                    start: 0,
                    per: window.innerWidth < 800 ? 1 : 3,
                    total: {{ $reviews->count() }},
                    next() { if (this.start < this.total - this.per) this.start++; },
                    prev() { if (this.start > 0) this.start--; },
                    visible(index) { return index >= this.start && index < this.start + this.per; }
                }"
                @resize.window="per = window.innerWidth < 800 ? 1 : 3; if (start > total - per) start = Math.max(0, total - per)"
            >
                <button type="button" class="sh-review-arrow is-prev" @click="prev()" x-show="start > 0" x-cloak aria-label="Previous reviews">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5l-7 7 7 7"></path></svg>
                </button>

                <div class="sh-review-grid">
                    @foreach($reviews as $index => $review)
                        @php
                            $name = $review->customer_name ?? '';
                            $initial = mb_strtoupper(mb_substr(trim($name), 0, 1));
                            $color = $avatarColors[$index % count($avatarColors)];
                            $when = $review->created_at ? $review->created_at->diffForHumans() : '8 months ago';
                            $stars = max(1, min(5, (int) ($review->rating ?? 5)));

                            // Match real Google avatars as shown in Image 2
                            $photoAvatar = null;
                            if (!empty($review->avatar)) {
                                $photoAvatar = str_starts_with($review->avatar, 'http') ? $review->avatar : \App\Support\AssetUrl::make($review->avatar);
                            } elseif (stripos($name, 'Yasmine') !== false && file_exists(public_path('home-page/icon/output-onlinepngtools-2.png'))) {
                                $photoAvatar = \App\Support\AssetUrl::make('home-page/icon/output-onlinepngtools-2.png');
                            } elseif (stripos($name, 'Dndn') !== false && file_exists(public_path('home-page/icon/output-onlinepngtools-3.png'))) {
                                $photoAvatar = \App\Support\AssetUrl::make('home-page/icon/output-onlinepngtools-3.png');
                            }
                        @endphp
                        <article class="sh-review-card" x-show="visible({{ $index }})" x-cloak>
                            <div class="sh-review-top">
                                @if($photoAvatar)
                                    <img class="sh-review-avatar-img" src="{{ $photoAvatar }}" alt="{{ $name }}">
                                @else
                                    <span class="sh-review-avatar" style="background: {{ $color }}">{{ $initial }}</span>
                                @endif
                                <div class="sh-review-who">
                                    <strong>{{ $name }}</strong>
                                    <span>{{ $when }}</span>
                                </div>
                                <img class="sh-review-google" src="{{ $googleIcon }}" alt="Google">
                            </div>

                            <!-- Rating Row: Bold Golden SVG Stars + Blue Verified Badge (Image 2) -->
                            <div class="sh-review-rating-row">
                                <div class="sh-review-stars" aria-label="{{ $stars }} out of 5 stars">
                                    @for($star = 1; $star <= 5; $star++)
                                        <svg class="sh-star-svg {{ $star <= $stars ? 'is-on' : 'is-off' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <!-- Blue Verified Customer Checkmark Badge -->
                                <span class="sh-review-badge" title="Verified Customer">
                                    <svg viewBox="0 0 16 16" fill="none" class="sh-verified-svg">
                                        <circle cx="8" cy="8" r="7.5" fill="#1a73e8"/>
                                        <path d="M4.8 8.2l2.2 2.2 4.2-4.4" stroke="#ffffff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>

                            <!-- Uniform Review Body -->
                            <div class="sh-review-body" x-data="{ more: false }">
                                <p dir="auto" :class="more ? '' : 'is-clamped'">{{ $review->content }}</p>
                                @if(mb_strlen($review->content ?? '') > 110)
                                    <button type="button" class="sh-review-more" @click="more = !more" x-text="more ? 'Show less' : 'Read more'"></button>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <button type="button" class="sh-review-arrow is-next" @click="next()" x-show="start < total - per" x-cloak aria-label="Next reviews">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        @endif
    </div>
</section>
