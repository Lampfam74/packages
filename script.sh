#!/bin/bash

# ==========================================
# Lampedev Security Suite Package Generator
# Creates professional Laravel package tree
# ==========================================

PACKAGE_NAME="security-suite"

echo "🚀 Creating package: $PACKAGE_NAME"

# Root
mkdir -p $PACKAGE_NAME

# Config
mkdir -p $PACKAGE_NAME/config

# Database
mkdir -p $PACKAGE_NAME/database/migrations

# Routes
mkdir -p $PACKAGE_NAME/routes

# Source folders
mkdir -p $PACKAGE_NAME/src/Models
mkdir -p $PACKAGE_NAME/src/Traits
mkdir -p $PACKAGE_NAME/src/Services
mkdir -p $PACKAGE_NAME/src/Http/Middleware
mkdir -p $PACKAGE_NAME/src/Providers

# ==========================================
# Files Creation
# ==========================================

touch $PACKAGE_NAME/config/security.php

touch $PACKAGE_NAME/database/migrations/create_security_logs_table.php

touch $PACKAGE_NAME/routes/security.php

touch $PACKAGE_NAME/src/Models/SecurityLog.php
touch $PACKAGE_NAME/src/Models/BlockedIp.php

touch $PACKAGE_NAME/src/Traits/SecureAudit.php

touch $PACKAGE_NAME/src/Services/WafService.php
touch $PACKAGE_NAME/src/Services/LogService.php
touch $PACKAGE_NAME/src/Services/AlertService.php
touch $PACKAGE_NAME/src/Services/ThreatDetector.php

touch $PACKAGE_NAME/src/Http/Middleware/WafMiddleware.php
touch $PACKAGE_NAME/src/Http/Middleware/AuditMiddleware.php

touch $PACKAGE_NAME/src/Providers/SecurityServiceProvider.php

# Extra professional files
touch $PACKAGE_NAME/composer.json
touch $PACKAGE_NAME/README.md
touch $PACKAGE_NAME/LICENSE

# ==========================================
# Output
# ==========================================

echo ""
echo "✅ Package structure created successfully!"
echo ""

tree $PACKAGE_NAME 2>/dev/null || find $PACKAGE_NAME

echo ""
echo "📦 Ready for development."