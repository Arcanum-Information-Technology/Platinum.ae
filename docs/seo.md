# SEO, Schema.org Structured Data & URL Architecture

This document describes the search engine optimization (SEO) subsystem, dynamic JSON-LD structured data engine, sitemap generator, and URL redirect management.

---

## 1. Architecture Overview

SEO is built as a core system component rather than an afterthought. The platform includes two dedicated service providers:
- **`App\Services\SeoService`**: Extracts, formats, and renders meta tags, Open Graph tags, Twitter Card tags, and canonical links.
- **`App\Services\SchemaService`**: Assembles Google-compliant Schema.org JSON-LD objects.

---

## 2. Polymorphic SEO Metadata (`seo_metadata`)

Any public entity (Page, Category, Subcategory, MenuItem) attaches SEO fields via Laravel's polymorphic `morphOne` relationship:

```php
public function seo(): MorphOne
{
    return $this->morphOne(SeoMetadata::class, 'seoable');
}
```

### Configurable Parameters
- `meta_title` (defaults to entity title + Site Name if omitted)
- `meta_description` (defaults to entity excerpt/description)
- `canonical_url` (guarantees canonical consistency across devices and parameters)
- `robots` (default: `'index, follow'`; allows `'noindex, nofollow'`)
- `og_title`, `og_description`, `og_image` (Facebook / LinkedIn / WhatsApp sharing)
- `twitter_title`, `twitter_description`, `twitter_image` (Twitter summary card)
- `schema_override` (optional raw JSON-LD injection)

---

## 3. Schema.org JSON-LD Structured Data

Generated directly into the `<head>` of `resources/views/layouts/website.blade.php`:

### 3.1 Restaurant Schema (`schema.org/Restaurant`)
Automatically compiled from Global Settings and Opening Hours:
```json
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "The Grand Reserve",
  "image": "https://yourdomain.com/storage/branding/hero.jpg",
  "telephone": "+1-555-0199",
  "email": "info@grandreserve.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "123 Culinary Boulevard",
    "addressLocality": "San Francisco",
    "addressRegion": "CA",
    "postalCode": "94102",
    "addressCountry": "US"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 37.774929,
    "longitude": -122.419418
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "11:00",
      "closes": "22:00"
    }
  ],
  "servesCuisine": ["Italian", "French", "Artisanal"],
  "priceRange": "$$$",
  "menu": "https://yourdomain.com/menu"
}
```

### 3.2 MenuItem Schema (`schema.org/MenuItem`)
Generated dynamically on the food detail page (`/menu/{category}/{subcategory}/{item}`):
```json
{
  "@context": "https://schema.org",
  "@type": "MenuItem",
  "name": "Butter Chicken Deluxe",
  "description": "Slow-simmered tandoori chicken in an aromatic velvety tomato and butter gravy.",
  "image": "https://yourdomain.com/storage/dishes/butter-chicken.webp",
  "offers": {
    "@type": "Offer",
    "price": "22.50",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock"
  },
  "nutrition": {
    "@type": "NutritionInformation",
    "calories": "680 calories"
  }
}
```

### 3.3 BreadcrumbList Schema (`schema.org/BreadcrumbList`)
Outlines the hierarchical trail: Home > Menu > Category > Subcategory > Dish.

### 3.4 FAQPage Schema (`schema.org/FAQPage`)
Automatically injected when a page contains active FAQ sections, matching Google rich-snippet requirements without spamming fake questions.

---

## 4. Dynamic Sitemap (`/sitemap.xml`)

Accessible at `GET /sitemap.xml` with `Content-Type: text/xml`:
- Automatically enumerates:
  - All **published** Pages
  - All **active** Categories & Subcategories
  - All **active & available** Menu Items
- Features `lastmod` timestamps derived from `updated_at`.
- Strict priority hierarchy: Homepage (1.0) > Menu & Main Pages (0.8) > Dishes (0.7).
- Automatically omits drafts, private pages, and disabled menu items.

---

## 5. Dynamic Robots.txt (`/robots.txt`)

Accessible at `GET /robots.txt` with `Content-Type: text/plain`:
```text
User-agent: *
Disallow: /admin/
Disallow: /api/
Allow: /

Sitemap: https://yourdomain.com/sitemap.xml
```

---

## 6. Redirect Manager (301 & 302)

The system includes a redirect manager with loop prevention:
- **Admin Management**: Path: `/admin/redirects`. Add source URL, target URL, and HTTP code (301 Permanent or 302 Temporary).
- **Execution**: Intercepted by `RedirectMiddleware` or matched before fallback 404 handler.
- **Analytics**: Tracks hit count and `last_accessed_at` timestamp.
- **Loop Prevention**: Disallows source URL matching target URL, or target chaining back to source.
