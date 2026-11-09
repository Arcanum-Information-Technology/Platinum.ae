# Saffron & Thyme — Restaurant Website + CMS + Management System

A monolithic, production-grade Restaurant Website, Content Management System (CMS), and Restaurant Management System (RMS) built in a single Laravel application. Deployable on standard PHP hosting (including Hostinger) with zero external Node runtime required in production.

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [Key Features](#key-features)
3. [Technology Stack](#technology-stack)
4. [Architecture Overview](#architecture-overview)
5. [System Requirements](#system-requirements)
6. [Installation & Setup](#installation--setup)
7. [Database Migrations & Seeders](#database-migrations--seeders)
8. [Admin Authentication & Default Credentials](#admin-authentication--default-credentials)
9. [Development Workflow](#development-workflow)
10. [Production Build & Optimization](#production-build--optimization)
11. [Hostinger & Shared Hosting Deployment](#hostinger--shared-hosting-deployment)
12. [Storage & Media Handling](#storage--media-handling)
13. [Permissions & Role-Based Access Control](#permissions--role-based-access-control)
14. [Cron Jobs & Task Scheduling](#cron-jobs--task-scheduling)
15. [Automated Testing](#automated-testing)
16. [Troubleshooting & FAQ](#troubleshooting--faq)
17. [Detailed Documentation Links](#detailed-documentation-links)

---

## Project Overview

**Saffron & Thyme** is a complete, monolithic Laravel platform tailored for high-end dining and restaurant brands. It combines an ultra-fast, elegant public storefront with a comprehensive back-office admin panel for managing menus, sections, pages, reservations, SEO, redirects, and media assets.

The application follows clean architectural boundaries:
- **No separate Node/React backend**: Everything is managed by Laravel.
- **Dynamic CMS Section Builder**: Construct and reorder pages with 23 modular section types without touching Blade code.
- **Enterprise SEO & JSON-LD**: Automatic Schema.org metadata for Restaurant, Menu, Breadcrumbs, and FAQs.
- **Hierarchical Culinary Engine**: Multi-tier Category → Subcategory → Dish architecture with allergens, dietary badges, and price modifiers.

---

## Key Features

- **Public Restaurant Website**:
  - Dark, warm luxury aesthetic with Playfair Display & Plus Jakarta Sans typography.
  - Interactive culinary menu with search, category pills, and multi-tier routing (`/menu/{category}/{subcategory}/{item}`).
  - Dish detail view with allergens, ingredients list, spice scale, calorie count, preparation time, and chef recommendations.
  - Interactive table booking & concierge contact form with anti-spam honeypot and IP rate limiting.
  - Dynamic photo galleries with lightbox-ready layouts.
  - Curated promotions, seasonal offers, guest reviews, and opening hours schedule.

- **Admin Management Panel**:
  - Operational Dashboard with metrics: total pages, dishes, categories, media, and unread inquiries.
  - Visual Page Builder with 23 modular section blocks, toggle states, and drag-and-drop sort order.
  - Culinary Menu Manager: dishes, prices, discounts, availability toggles, allergens, and spice scales.
  - Centralized Media Library with modal picker and drag-and-drop image uploads.
  - 301/302 URL Redirect Manager with circular loop detection.
  - Dynamic XML Sitemap (`/sitemap.xml`) and configurable `robots.txt`.
  - Granular Role-Based Access Control (RBAC) via Spatie Laravel Permission.
  - Comprehensive Audit & Activity Logging for all write operations.

---

## Technology Stack

- **Backend**: PHP 8.2+, Laravel 12.x, Eloquent ORM.
- **Frontend**: Laravel Blade, Tailwind CSS v4, Alpine.js, Lucide Icons.
- **Database**: MySQL 8.0+ / MariaDB 10.4+ (SQLite memory supported for rapid unit tests).
- **Authentication & Authorization**: Laravel Session Auth + Spatie Laravel Permission.
- **Build Tool**: Vite 7.x + Tailwind CSS Vite Plugin.

---

## Architecture Overview

```
Browser Request
    ↓
HTTP Kernel / Routing (routes/web.php)
    ↓
Middleware Stack (HandleRedirects, CheckAdminAccess, Spatie Roles)
    ↓
Controllers (Admin/ & Website/)
    ↓
Form Requests (StoreMenuItemRequest, StorePageRequest, etc.)
    ↓
Domain Services (PageBuilderService, SchemaService, SeoService, MediaService, RedirectService, SlugService)
    ↓
Eloquent Models & Database (MySQL / MariaDB)
    ↓
Blade View Components (resources/views/components/)
```

---

## System Requirements

- **PHP**: `^8.2` or `^8.3`
- **Required PHP Extensions**:
  - `BCMath`
  - `Ctype`
  - `cURL`
  - `DOM` / `XML`
  - `Fileinfo`
  - `Filter`
  - `JSON`
  - `Mbstring`
  - `OpenSSL`
  - `PCRE`
  - `PDO` & `pdo_mysql`
  - `Tokenizer`
  - `GD` or `Imagick`
- **Composer**: `^2.2`
- **Node.js**: `^18.0` or `^20.0` (for building assets via Vite during development)
- **Database**: MySQL 8.0+ or MariaDB 10.4+

---

## Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone <repo-url>
   cd saffron-restaurant-cms
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies**:
   ```bash
   npm install
   ```

4. **Configure Environment File**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database Connection in `.env`**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=restaurant_cms
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Create Public Storage Symlink**:
   ```bash
   php artisan storage:link
   ```

---

## Database Migrations & Seeders

Run database migrations and seed the complete demo restaurant data:

```bash
php artisan migrate:fresh --seed
```

The seeders populate:
- RBAC permissions & default roles.
- 3 staff accounts (Super Admin, Content Editor, Menu Manager).
- 8 CMS pages (Home, About, Menu, Gallery, Offers, Contact, Privacy, Terms).
- 5 culinary categories, subcategories, and 10 detailed artisanal dishes.
- Weekly opening hours schedule.
- Global site identity, contact info, and SEO defaults.

---

## Admin Authentication & Default Credentials

Access the administrator portal at:
```
http://localhost:8000/admin/login
```

| Role | Email | Default Password | Access Level |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@restaurant.com` | `Admin@123456` | Full administrative control |
| **Content Editor** | `content@restaurant.com` | `Content@123456` | Pages, Sections, Media, Inquiries |
| **Menu Manager** | `chef@restaurant.com` | `Chef@123456` | Categories, Dishes, Specials, Media |

> **IMPORTANT**: Change all default passwords immediately upon production deployment via `/admin/profile`.

---

## Development Workflow

Start the local development server:
```bash
php artisan serve
```

In a separate terminal, start Vite for hot module replacement (HMR):
```bash
npm run dev
```

---

## Production Build & Optimization

To prepare the application for production deployment:

1. **Compile & Minify Assets**:
   ```bash
   npm run build
   ```

2. **Cache Configurations and Routes**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## Hostinger & Shared Hosting Deployment

The project is engineered specifically to deploy smoothly on standard Hostinger PHP hosting:

1. **Upload Files**:
   Upload files to your server (e.g. `public_html/` or a parent folder `restaurant_cms/`).
2. **Point Document Root**:
   Point your domain's Document Root to the `public/` directory (e.g. `public_html/public` or `/domains/example.com/public_html`).
3. **Environment**:
   Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
4. **Storage Symlink**:
   Run `php artisan storage:link` or create a symlink from `public/storage` to `storage/app/public`.
5. **Permissions**:
   Ensure write permissions for web server on:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

---

## Storage & Media Handling

- Uploaded media is processed through `App\Services\MediaService` and saved to `storage/app/public/media/`.
- File validation restricts dangerous types and enforces a 10MB limit.
- Files are accessible publicly via `/storage/media/{filename}`.
- To use AWS S3, Cloudflare R2, or DigitalOcean Spaces, simply update `FILESYSTEM_DISK=s3` in `.env`.

---

## Permissions & Role-Based Access Control

The platform uses Spatie Laravel Permission with dedicated gates and policies:
- `PagePolicy`: controls `pages.view`, `pages.create`, `pages.update`, `pages.delete`, `pages.publish`.
- `MenuItemPolicy`: controls `menu.view`, `menu.create`, `menu.update`, `menu.delete`.
- `CategoryPolicy`: controls category administration.
- `UserPolicy`: restricts staff account creation and prevents self-deletion.

---

## Cron Jobs & Task Scheduling

If using scheduled tasks or automated backups on Hostinger:
Add a single cron job via cPanel or hPanel:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Automated Testing

Run the automated test suite with:

```bash
php artisan test
```

All 24 feature and unit tests cover:
- Admin authentication & session security
- CMS page creation, slugs, and section ordering
- Page duplicate functionality & live preview authorization
- Culinary menu, categories, subcategories, and detail views
- Contact form submission, anti-spam honeypot, and rate limiting
- 301/302 Redirect management and loop detection
- SEO metadata and JSON-LD Schema.org structured data
- Dynamic XML sitemap and robots.txt endpoints

---

## Troubleshooting & FAQ

- **Images not showing up**: Run `php artisan storage:link`.
- **403 Forbidden on Admin**: Ensure you are logged in with an authorized role.
- **Styles or Scripts not updating**: Run `npm run build` followed by `php artisan view:clear`.
- **Redirects not triggering**: Verify that the redirect is set to `is_active = 1` in `/admin/redirects`.

---

## Detailed Documentation Links

- [Architecture Guide](docs/architecture.md)
- [Database Schema & ERD](docs/database.md)
- [Deployment & Hostinger Guide](docs/deployment.md)
- [CMS & Page Builder System](docs/cms.md)
- [SEO & Schema.org Specification](docs/seo.md)
- [Admin Panel & Operations Guide](docs/admin.md)
