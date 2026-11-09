# CMS & Section-Based Page Builder Architecture

This document describes the modular CMS, page management, and 23-section page builder system powering the restaurant platform.

---

## 1. Overview

Rather than locking content editors into a rigid, monolithic HTML field, pages are composed of an ordered list of dynamic, configurable **sections**. Each section stores its structured parameters in a JSON column (`data`) and renders through an isolated, performant Blade component.

---

## 2. Rendering Pipeline

```text
HTTP GET /{slug}
   ↓
PageController::show($slug)
   ↓
Page::where('slug', $slug)->where('status', 'published')->with('activeSections')->firstOrFail()
   ↓
resources/views/website/pages/show.blade.php
   ↓
@foreach($page->activeSections as $section)
    <x-dynamic-component :component="'sections.' . $section->section_type" :data="$section->data" />
@endforeach
```

---

## 3. Supported Section Types (23 Core Blocks)

Every section component is located in `resources/views/components/sections/<type>.blade.php`:

| # | Section Name | Blade Component | Key Configurable JSON Fields |
|---|--------------|-----------------|------------------------------|
| 1 | **Hero** | `hero.blade.php` | `title`, `subtitle`, `badge`, `bg_image`, `cta_text`, `cta_link`, `cta2_text`, `cta2_link` |
| 2 | **Text** | `text.blade.php` | `title`, `subtitle`, `content`, `alignment` ('left', 'center', 'right') |
| 3 | **Text + Image** | `text-image.blade.php` | `title`, `subtitle`, `content`, `image`, `badge`, `cta_text`, `cta_link` |
| 4 | **Image + Text** | `image-text.blade.php` | Same as Text + Image with inverted column layout |
| 5 | **Full Width Image** | `full-width-image.blade.php` | `image`, `overlay_title`, `overlay_subtitle`, `height` |
| 6 | **Featured Food** | `featured-food.blade.php` | `title`, `subtitle`, `count`, `category_id` (fetches active `MenuItem::where('is_featured', true)`) |
| 7 | **Food Grid** | `food-grid.blade.php` | `title`, `subtitle`, `categories`, `limit`, `show_filters` |
| 8 | **Food Categories** | `food-categories.blade.php` | `title`, `subtitle`, `layout` ('cards' or 'carousel'), `show_count` |
| 9 | **Restaurant Intro** | `restaurant-intro.blade.php` | `badge`, `title`, `description`, `signature_image`, `years_experience`, `images` |
| 10 | **Gallery** | `gallery.blade.php` | `title`, `subtitle`, `gallery_id`, `layout` ('masonry', 'grid'), `limit` |
| 11 | **Testimonials** | `testimonials.blade.php` | `title`, `subtitle`, `limit`, `display_stars` |
| 12 | **FAQ** | `faq.blade.php` | `title`, `subtitle`, `category`, `items` `[{q, a}]` (outputs Schema.org FAQPage) |
| 13 | **Statistics** | `statistics.blade.php` | `items` `[{number: '15+', label: 'Years Experience'}, {number: '50k+', label: 'Guests'}]` |
| 14 | **CTA (Call to Action)** | `cta.blade.php` | `title`, `subtitle`, `button_text`, `button_link`, `bg_color`, `bg_image` |
| 15 | **Contact** | `contact.blade.php` | `title`, `subtitle`, `show_phone`, `show_email`, `show_address`, `show_hours` |
| 16 | **Contact Form** | `contact-form.blade.php` | `title`, `subtitle`, `form_action`, `success_message` |
| 17 | **Google Map** | `google-map.blade.php` | `embed_url`, `latitude`, `longitude`, `zoom`, `show_card` |
| 18 | **Opening Hours** | `opening-hours.blade.php` | `title`, `subtitle`, `note`, `show_current_status` |
| 19 | **Chef / Team** | `chef-team.blade.php` | `title`, `subtitle`, `members` `[{name, role, image, bio, social}]` |
| 20 | **Video** | `video.blade.php` | `title`, `video_url` (YouTube/Vimeo embed or HTML5 MP4), `poster_image` |
| 21 | **Logo / Brands** | `logo-brands.blade.php` | `title`, `logos` `[{image, name, url}]` |
| 22 | **Custom HTML** | `custom-html.blade.php` | `html_content` (sanitized or raw for authorized admins) |
| 23 | **Rich Text** | `rich-text.blade.php` | `content` (HTML formatted via rich-text editor) |

---

## 4. Section Ordering and JSON Storage Example

In `page_sections` table:
```json
{
  "id": 101,
  "page_id": 1,
  "section_type": "hero",
  "sort_order": 1,
  "is_active": true,
  "data": {
    "badge": "Authentic Dining Experience",
    "title": "A Symphony of Flavors & Heritage",
    "subtitle": "Immerse yourself in artisanal cuisine prepared with locally sourced ingredients.",
    "bg_image": "/storage/media/hero-bg.webp",
    "cta_text": "Explore Our Menu",
    "cta_link": "/menu",
    "cta2_text": "Book a Table",
    "cta2_link": "/contact"
  }
}
```

---

## 5. Page Lifecycle & Draft Preview

- **Drafting**: When editing a page in `/admin/pages/{id}/edit`, changes are saved in `draft` mode without affecting public visitors.
- **Preview Route**: Admins can securely preview draft pages at `/admin/pages/{id}/preview` which renders the full layout bypassing the `status = 'published'` check.
- **Publishing**: Marking a page as `published` makes it live and immediately includes it in the dynamic `sitemap.xml`.
- **Duplication**: The **Duplicate** button copies the entire page structure and its linked sections with a `"-copy"` slug suffix for rapid landing page creation.
