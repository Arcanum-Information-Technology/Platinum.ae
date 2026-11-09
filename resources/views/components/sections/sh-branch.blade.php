@props(['data'])

@php
    $ornament = \App\Support\AssetUrl::make($data['ornament'] ?? '');
    $branches = $data['branches'] ?? [];
@endphp

<section class="sh-band">
    <div class="sh-wrap">
        @if($ornament)
            <img class="sh-ornament" src="{{ $ornament }}" alt="Our Branches">
        @endif

        @foreach($branches as $branch)
            @php
                $query = $branch['map_query'] ?? ($branch['address'] ?? '');
                $phone = $branch['phone'] ?? '';
                $whatsapp = preg_replace('/\D+/', '', $branch['whatsapp'] ?? '');
                $menuUrl = $branch['menu_url'] ?? '/menu';
            @endphp
            <article class="sh-branch">
                @if($query)
                    <div class="sh-map">
                        <iframe
                            title="Map for {{ $branch['name'] ?? 'our branch' }}"
                            src="https://maps.google.com/maps?q={{ urlencode($query) }}&z=13&output=embed"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                @endif

                <div class="sh-branch-copy">
                    @if(!empty($branch['name']))
                        <h2>{{ $branch['name'] }}</h2>
                    @endif
                    @if(!empty($branch['address']))
                        <p><strong>Address:</strong> {{ $branch['address'] }}</p>
                    @endif
                    @if($phone)
                        <p><strong>Phone:</strong> <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a></p>
                    @endif
                    @if(!empty($branch['whatsapp']))
                        <p><strong>Whatsapp:</strong> <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">{{ $branch['whatsapp'] }}</a></p>
                    @endif
                    @if(!empty($branch['hours']))
                        <p><strong>Working Hours:</strong> {{ $branch['hours'] }}</p>
                    @endif

                    <div class="sh-branch-actions">
                        @if(!empty($branch['menu_label']))
                            <a href="{{ url($menuUrl) }}">{{ $branch['menu_label'] }}</a>
                        @endif
                        @if(!empty($branch['chat_label']) && $whatsapp)
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">{{ $branch['chat_label'] }}</a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
