# Hostinger & Shared PHP Hosting Deployment Guide

This guide describes how to deploy the single monolithic Laravel application on standard PHP shared hosting (such as Hostinger hPanel, cPanel, or VPS) with zero downtime and full asset performance.

---

## 1. Hosting Requirements

- **PHP Version**: `^8.2` or `^8.3`
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **PHP Extensions**:
  - `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `Filter`, `GD` or `Imagick`, `JSON`, `Mbstring`, `OpenSSL`, `PCRE`, `PDO`, `PDO_MySQL`, `Session`, `Tokenizer`, `XML`
- **Memory Limit**: `256M` or higher recommended

---

## 2. Directory Structure on Hostinger

Hostinger shared hosting defaults to `public_html/` as the document root, while the cloned Laravel project lives in a sibling directory named `restorant-php/`.

```text
/home/u123456789/ (or domain root)
├── restorant-php/           # Complete Laravel application files (git clone)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/              # Laravel's original public directory with build/
│   │   ├── build/           # Pre-compiled Vite production assets
│   │   └── ...
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
└── public_html/             # Hostinger's actual web root
    ├── build/               # Synced from restorant-php/public/build
    ├── .htaccess            # Apache rewrite rules (prevents 404s on route refresh)
    ├── index.php            # Loads bootstrap/app.php from ../restorant-php/
    └── storage              # Symlinked to ../restorant-php/storage/app/public
```

> **Hostinger Entry Point (`public_html/index.php`)**:
> ```php
> require __DIR__.'/../restorant-php/vendor/autoload.php';
> $app = require_once __DIR__.'/../restorant-php/bootstrap/app.php';
> ```
> This connects Hostinger's `domain/public_html/index.php` directly to `domain/restorant-php/`.

### Automatic Database Initialization via Migrations
Running `php artisan migrate` automatically creates all tables AND runs initial data seeding (`2026_09_29_150000_seed_initial_production_data.php`).
This guarantees that:
- Default Super Admin (`admin@restaurant.com` / `Admin@123456`), Content Editor, and Menu Manager accounts are created.
- All default CMS pages (Home, About, Franchise, Branches, Contact) and Shakespeare sections are populated.
- Culinary categories, dishes, opening hours, and site settings are active immediately.

### Synchronizing `restorant-php/public` to `public_html`
Because Node.js and npm are not installed on Hostinger shared servers, production frontend assets in `public/build/` are compiled on the developer machine and committed to Git.

After pulling on Hostinger, run the synchronization script:
```bash
bash restorant-php/deployment/hostinger/sync-to-public-html.sh
```
This automatically:
1. Copies all files and pre-compiled assets from `restorant-php/public/` to `public_html/`.
2. Installs the production `index.php` that points to `../restorant-php/`.
3. Installs the production `.htaccess` with proper rewrite rules.
4. Removes any local development `hot` file so Laravel serves production assets.
5. Sets up the `storage/` symlink.

---

## 3. Step-by-Step Deployment Instructions

### Step 1: Prepare and Build Assets Locally
Run the Vite asset pipeline locally before uploading:
```bash
# 1. Install dependencies
npm install

# 2. Build production assets into public/build/
npm run build
```

### Step 2: Upload Files to the Server
Upload all project files to your server (via SSH, Git, or File Manager), **excluding**:
- `node_modules/`
- `.git/`
- `.env` (create fresh on server)

### Step 3: Configure Environment (`.env`)
Copy `.env.example` to `.env` on your hosting server and configure:
```env
APP_NAME="The Grand Reserve"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_restaurant
DB_USERNAME=u123456789_admin
DB_PASSWORD=YourStrongDatabasePassword123#

FILESYSTEM_DISK=public
SESSION_DRIVER=database
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=reservations@yourdomain.com
MAIL_PASSWORD=YourEmailPassword
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="reservations@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 4: Run Composer & Application Setup via SSH
Connect via SSH to your Hostinger terminal and run:
```bash
cd /home/u123456789/laravel_app

# Install production dependencies without dev tools
composer install --no-dev --optimize-autoloader

# Generate application key if not set
php artisan key:generate

# Run database migrations with force flag
php artisan migrate --force

# Seed essential roles, permissions, settings, and administrator account
php artisan db:seed --force

# Create public storage symlink
php artisan storage:link
```

*(If SSH is not available, you can run migrations via a temporary deployment web route or import the SQL dump generated locally).*

### Step 5: Directory Permissions
Ensure web server has write permissions for `storage` and `bootstrap/cache`:
```bash
chmod -R 775 storage bootstrap/cache
```

### Step 6: Cache Configuration for Maximum Performance
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 4. Hostinger Cron Job Setup

To execute scheduled tasks (e.g. sitemap updates, offer expiration, activity logging cleanup), add a Cron Job in Hostinger hPanel:

1. Navigate to **hPanel** -> **Advanced** -> **Cron Jobs**.
2. Select **Custom** type.
3. Interval: `* * * * *` (Every minute).
4. Command:
```bash
/usr/bin/php /home/u123456789/laravel_app/artisan schedule:run >> /dev/null 2>&1
```

---

## 5. Storage Symlink Troubleshooting on Shared Hosting

If `php artisan storage:link` fails due to symlink permissions on shared hosting:
1. Create a PHP script named `symlink.php` inside `public/`:
```php
<?php
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';
symlink($target, $shortcut);
echo "Symlink created successfully!";
```
2. Visit `https://yourdomain.com/symlink.php` once in your browser.
3. Delete `symlink.php` immediately afterward for security.

---

## 6. Post-Deployment Checklist

- [ ] Visit `https://yourdomain.com` - verify styling and images load properly.
- [ ] Log in to Admin at `https://yourdomain.com/admin/login`.
- [ ] Immediately change default administrator credentials in **Profile**.
- [ ] Test Contact Form submission; verify record appears in **Messages**.
- [ ] Check `https://yourdomain.com/sitemap.xml` and `https://yourdomain.com/robots.txt`.
