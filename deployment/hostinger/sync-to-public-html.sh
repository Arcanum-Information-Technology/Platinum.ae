#!/usr/bin/env bash
# ==============================================================================
# Hostinger Public Directory Synchronization Script
# Synchronizes Laravel public/ assets -> public_html/
# ==============================================================================

set -e

# Resolve paths
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
APP_DIR="$(cd "${SCRIPT_DIR}/../.." && pwd)"
TARGET_DIR="$(cd "${APP_DIR}/.." && pwd)/public_html"

# Allow custom target override via argument
if [ -n "$1" ]; then
    TARGET_DIR="$1"
fi

echo "=========================================================="
echo " Synchronizing Laravel public assets to Hostinger web root"
echo " Source: ${APP_DIR}/public"
echo " Target: ${TARGET_DIR}"
echo "=========================================================="

# Create target directory if it doesn't exist
mkdir -p "${TARGET_DIR}"

# 1. Remove Hostinger default placeholder page (default.php)
if [ -f "${TARGET_DIR}/default.php" ]; then
    echo "--> Removing Hostinger default placeholder (default.php)..."
    mv "${TARGET_DIR}/default.php" "${TARGET_DIR}/../default.php.hostinger-backup" 2>/dev/null || rm -f "${TARGET_DIR}/default.php"
fi

# 2. Copy all static files & compiled assets from public/ to public_html/
echo "--> Copying public files and compiled assets..."
cp -r "${APP_DIR}/public/"* "${TARGET_DIR}/"

# 3. Remove any lingering Vite dev hot file
if [ -f "${TARGET_DIR}/hot" ]; then
    echo "--> Removing dev hot file from production web root..."
    rm -f "${TARGET_DIR}/hot"
fi

# 4. Install production Hostinger bridge index.php
echo "--> Installing Hostinger production index.php..."
cp "${SCRIPT_DIR}/public_html/index.php" "${TARGET_DIR}/index.php"

# 5. Install production .htaccess
echo "--> Installing Hostinger production .htaccess..."
cp "${SCRIPT_DIR}/public_html/.htaccess" "${TARGET_DIR}/.htaccess"

# 6. Link storage directory if not already linked
if [ ! -L "${TARGET_DIR}/storage" ] && [ ! -d "${TARGET_DIR}/storage" ]; then
    echo "--> Creating storage symlink in public_html..."
    ln -s "${APP_DIR}/storage/app/public" "${TARGET_DIR}/storage" || cp -r "${APP_DIR}/storage/app/public" "${TARGET_DIR}/storage"
fi

# 7. Set recommended file permissions
echo "--> Setting permissions..."
chmod 644 "${TARGET_DIR}/index.php" "${TARGET_DIR}/.htaccess" 2>/dev/null || true

echo "=========================================================="
echo " Synchronization complete! Web root is ready for traffic."
echo "=========================================================="
