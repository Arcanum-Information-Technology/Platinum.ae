@props(['data'])

@if(!empty(trim($data['title'] ?? '')))
    <section class="sh-page-banner">
        <h1>{{ $data['title'] }}</h1>
    </section>
@endif
