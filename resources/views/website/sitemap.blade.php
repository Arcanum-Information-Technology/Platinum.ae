{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Home -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Pages -->
    @foreach($pages as $page)
        <url>
            <loc>{{ url('/' . $page->slug) }}</loc>
            <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Categories -->
    @foreach($categories as $category)
        <url>
            <loc>{{ route('menu.category', $category->slug) }}</loc>
            <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Subcategories -->
    @foreach($subcategories as $sub)
        @if($sub->category && !$sub->category->trashed())
            <url>
                <loc>{{ route('menu.subcategory', ['categorySlug' => $sub->category->slug, 'subcategorySlug' => $sub->slug]) }}</loc>
                <lastmod>{{ $sub->updated_at->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.7</priority>
            </url>
        @endif
    @endforeach

    <!-- Menu Items -->
    @foreach($menuItems as $item)
        <url>
            <loc>{{ $item->url }}</loc>
            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>
