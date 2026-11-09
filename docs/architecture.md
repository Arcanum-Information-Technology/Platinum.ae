# Architecture & Design Patterns

## Overview

The application follows a clean monolithic MVC pattern augmented with dedicated Form Requests, Domain Services, and View Components in Laravel 12.

```
Browser Request
    ↓
Routes (routes/web.php)
    ↓
Middleware (HandleRedirects, CheckAdminAccess, Spatie Role/Permission)
    ↓
Controllers (app/Http/Controllers/Admin/ & Website/)
    ↓
Form Requests (app/Http/Requests/)
    ↓
Domain Services (app/Services/)
    ↓
Eloquent Models (app/Models/)
    ↓
Database (MySQL / MariaDB)
    ↓
Blade View Components (resources/views/components/)
```

## Architectural Guidelines

1. **Controllers**: Responsible exclusively for HTTP input handling, dispatching to services, and returning view/redirect/json responses. Keep controllers slim (< 150 lines).
2. **Form Requests**: All incoming admin inputs and public contact form submissions are validated in dedicated Form Request classes. No inline validation in controllers.
3. **Domain Services**:
   - `PageBuilderService`: Handles available section schemas, defaults, and data aggregation for dynamic sections.
   - `SeoService`: Computes meta titles, Open Graph tags, canonical URLs, and Twitter cards for any Eloquent model or route.
   - `SchemaService`: Generates validated Schema.org JSON-LD objects (Restaurant, MenuItem, MenuSection, FAQPage, BreadcrumbList).
   - `MediaService`: Secure file uploads, MIME inspection, unique filename generation, and disk storage.
   - `RedirectService`: Manages 301/302 URL redirects and detects circular redirect chains.
   - `SlugService`: Generates URL-safe unique slugs with numerical incrementing upon collision.
4. **View Components**: Reusable UI elements (`food-card`, `category-card`, `sidebar`, `media-picker`, `render-section`) are isolated Blade components.
5. **No Business Logic in Views**: Blade files only render data passed from controllers or services.
