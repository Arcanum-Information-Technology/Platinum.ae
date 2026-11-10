#!/usr/bin/env bash
# ==============================================================================
# Platinum Hospitality Management - Quick Deploy Shortcut
# Runs the full Hostinger deployment script
# ==============================================================================

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
bash "${SCRIPT_DIR}/deployment/hostinger/deploy.sh" "$@"

