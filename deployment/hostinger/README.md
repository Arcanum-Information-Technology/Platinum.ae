# Hostinger Automated Deployment Guide

This guide explains how automated deployment works on Hostinger shared hosting for **Platinum Hospitality Management**.

---

## Server Directory Layout

On Hostinger, your domain root is:
```text
/home/u674166921/domains/yellow-cod-219708.hostingersite.com/
├── Platinum.ae/              <-- Laravel application repository (OUTSIDE web root for security)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── deployment/
│   │   └── hostinger/
│   │       ├── deploy.sh
│   │       ├── sync-to-public-html.sh
│   │       └── public_html/
│   │           ├── index.php
│   │           └── .htaccess
│   ├── deploy.sh             <-- One-command deployment shortcut
│   ├── public/               <-- Source assets & compiled Vite bundles
│   ├── routes/
│   ├── storage/
│   └── vendor/
└── public_html/              <-- Hostinger web root (public-facing entry point)
    ├── assets/               <-- Compiled CSS / JS
    ├── images/               <-- Dish, brand & hero photography
    ├── storage -> ../Platinum.ae/storage/app/public
    ├── index.php             <-- Auto-detecting production bridge
    └── .htaccess             <-- URL routing rules
```

---

## Future Updates Workflow (One Single Command)

Whenever you make changes locally and push to your git repository, deploy to the Hostinger server with:

```bash
cd ~/domains/yellow-cod-219708.hostingersite.com/Platinum.ae
git pull
bash deploy.sh
```

---

## What `bash deploy.sh` Automates

The script runs the following sequence in seconds:

1. **Auto-Detects Paths**: Discovers `Platinum.ae` dynamically without hardcoded folder names.
2. **Production Dependencies**: Runs `composer install --no-dev --optimize-autoloader --no-interaction`.
3. **Database Migrations**: Runs `php artisan migrate --force` to apply any new database schema changes.
4. **Permissions**: Sets `chmod -R 775 storage bootstrap/cache`.
5. **Caches**: Runs `php artisan optimize:clear`, followed by `config:cache`, `route:cache`, and `view:cache`.
6. **Removes Hostinger Default Page**: Automatically clears any default `default.php` placeholder that Hostinger adds.
7. **Asset Synchronization**: Copies all static files, compiled Vite assets (`public/build`), images (`public/images`), and creates the `public_html/storage` symlink.
8. **Installs Bridge**: Deploys `public_html/index.php` and `public_html/.htaccess`.

---

## Important Hostinger Note on Frontend Assets

Hostinger shared hosting does not have `node` / `npm` installed in the terminal.
* Always run `npm run build` locally before pushing to git so that compiled files in `public/build/` are committed.
* The deployment script automatically syncs these pre-compiled assets into `public_html/`.

