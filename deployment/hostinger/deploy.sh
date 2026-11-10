#!/usr/bin/env bash
# ==============================================================================
# Platinum Hospitality Management - Hostinger Production Deployment Script
# Automatically deploys the project on Hostinger shared hosting.
#
# Usage:
#   bash deployment/hostinger/deploy.sh
#   (or: bash deploy.sh from project root)
# ==============================================================================

set -e

# ANSI Color Codes
GREEN='\033[0;32m'
GOLD='\033[1;33m'
CYAN='\033[0;36m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GOLD}===================================================================${NC}"
echo -e "${GOLD}   PLATINUM HOSPITALITY MANAGEMENT - HOSTINGER DEPLOYMENT SCRIPT   ${NC}"
echo -e "${GOLD}===================================================================${NC}"

# 1. Resolve Application Directory and Target public_html
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
APP_DIR="$(cd "${SCRIPT_DIR}/../.." && pwd)"
APP_NAME="$(basename "${APP_DIR}")"
TARGET_DIR="$(cd "${APP_DIR}/.." && pwd)/public_html"

if [ -n "$1" ]; then
    TARGET_DIR="$1"
fi

echo -e "${CYAN}--> Application Directory : ${APP_DIR} (${APP_NAME})${NC}"
echo -e "${CYAN}--> Public Web Root       : ${TARGET_DIR}${NC}"

cd "${APP_DIR}"

# 2. Verify .env file exists
if [ ! -f .env ]; then
    if [ -f .env.production ]; then
        echo -e "${CYAN}--> Creating .env from .env.production...${NC}"
        cp .env.production .env
    elif [ -f .env.example ]; then
        echo -e "${CYAN}--> Creating .env from .env.example...${NC}"
        cp .env.example .env
    else
        echo -e "${RED}ERROR: .env file not found! Please create a .env file first.${NC}"
        exit 1
    fi
fi

# 3. Install production Composer dependencies
echo -e "${CYAN}--> Installing Composer production dependencies...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Generate Application Key if missing
if ! grep -q "^APP_KEY=base64:" .env; then
    echo -e "${CYAN}--> Generating application key...${NC}"
    php artisan key:generate --force
fi

# 5. Run Database Migrations
echo -e "${CYAN}--> Running database migrations...${NC}"
php artisan migrate --force

# 6. Ensure Storage & Cache Directory Permissions
echo -e "${CYAN}--> Setting permissions on storage and bootstrap/cache...${NC}"
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 7. Optimize Laravel Caches for Production
echo -e "${CYAN}--> Refreshing production caches (config, routes, views, events)...${NC}"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Check Compiled Frontend Assets
if [ ! -f "public/build/manifest.json" ]; then
    echo -e "${GOLD}NOTICE: public/build/manifest.json was not found.${NC}"
    echo -e "${GOLD}Ensure 'npm run build' was executed locally before deploying.${NC}"
fi

# 9. Synchronize Assets into public_html
echo -e "${CYAN}--> Synchronizing public assets to ${TARGET_DIR}...${NC}"
bash "${SCRIPT_DIR}/sync-to-public-html.sh" "${TARGET_DIR}"

echo -e "${GREEN}===================================================================${NC}"
echo -e "${GREEN}   DEPLOYMENT COMPLETE!                                           ${NC}"
echo -e "${GREEN}   Your website is live, fully synchronized, and cached!          ${NC}"
echo -e "${GREEN}===================================================================${NC}"

