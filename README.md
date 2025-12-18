# Trench City V2 - Master Skeleton

Professional browser-based text RPG built with PHP, MySQL, and Redis.

## Quick Start

### For Production Deployment
Upload the `trench_city/` directory to your production server via FileZilla. This directory contains only application files, ready to deploy.

See: `docs/deployment/FILEZILLA_QUICK_UPLOAD_GUIDE.md`

### For Development
1. Copy `.env.example` to `.env` and configure your settings
2. Import the database schema from `database/`
3. Point your web server to the `public/` directory inside `trench_city/`

## Directory Structure

### Application Code
- **trench_city/** - Production-ready application package (upload this to server)
  - All application files without documentation
  - Configured with production `.env` settings
  - 6.6 MB, 196 PHP files, ready for FileZilla upload

### Documentation
- **docs/deployment/** - Server deployment guides and checklists
  - FILEZILLA_QUICK_UPLOAD_GUIDE.md
  - QUICK_DEPLOY_CHECKLIST.md
  - DEPLOYMENT_CONFIG_QUESTIONS.md
  - ALPHA_RELEASE_README.md
  - UPLOAD_SUMMARY.md
  - FINAL_SUMMARY.md

- **docs/guides/** - Feature documentation and user guides
  - CRIMES_SYSTEM_COMPLETE.md
  - CRIMES_QUICK_REFERENCE.md
  - GYM_SYSTEM_COMPLETE.md
  - QUICK_START_GUIDE.md
  - VISUAL_CHANGES_SUMMARY.md

- **docs/technical/** - Technical architecture and setup
  - CORE_SYSTEM_FIXES_AND_STANDARDS.md
  - EMAIL_RECAPTCHA_SETUP.md
  - LOGIN_FIX_SUMMARY.md
  - HOW_ERROR_DISPLAY_SAVED_THE_DAY.md

- **docs/development/** - Development resources and knowledge base
  - LANDING_PAGE_REFACTOR_GUIDE.md
  - TrenchCity Knowledge 1.md
  - TrenchCity Knowledge 2.md
  - TrenchCity Knowledge 3.md
  - TrenchCity Knowledge 4.md

## Key Features

### Core Systems
- **Authentication** - Secure login/register with email verification, reCAPTCHA v2
- **Session Management** - Redis-backed sessions with CSRF protection
- **Enhanced Error Display** - Detailed error pages showing type, message, file, line, stack trace
- **Centralized Database** - TCDB wrapper for consistent database access patterns

### Game Modules (47 total)
- Crimes, Gym, Combat, Bank, Mail, Garage, Casino, Travel
- Gang Wars, Rankings, Crew System, Admin Panel
- All using centralized core system (bootstrap.php, db.php, helpers.php)

### Infrastructure
- Multi-server architecture: 2 game nodes + load balancer
- Database server: 10.7.222.14
- Redis cache: 10.7.222.13
- Email: IONOS SMTP (no-reply@trenchmade.co.uk)

## Production Configuration

**Domain:** www.trenchmade.co.uk
**Load Balancer:** 82.165.200.104
**Game Nodes:** 10.7.222.11, 10.7.222.12

All credentials configured in `trench_city/.env`

## What's Been Fixed

### Critical Fixes (Production-Ready)
1. Added missing `getDB()` function - Fixed 8 broken files
2. Fixed PDO named placeholder reuse in login.php and login_new.php
3. Enhanced error handler to display full debugging information
4. Standardized database access patterns across all files
5. Complete production configuration with all server credentials

### Optional Improvements (Non-Blocking)
- 4 files still use PDO methods instead of TCDB (register_new.php, verify-email.php, leaderboards.php, profile.php)
- Session management could be centralized in bootstrap.php
- See `docs/technical/CORE_SYSTEM_FIXES_AND_STANDARDS.md` for full details

## Next Steps

1. **Deploy to Production**
   - Upload `trench_city/` directory to servers via FileZilla
   - Set file permissions (755 directories, 644 files)
   - Verify .env configuration
   - Test login flow

2. **Optional Consistency Updates**
   - Convert remaining 4 files from PDO to TCDB methods
   - Centralize session_start() in bootstrap.php

## Support

For deployment questions, see:
- `docs/deployment/FILEZILLA_QUICK_UPLOAD_GUIDE.md` - Step-by-step upload instructions
- `docs/deployment/QUICK_DEPLOY_CHECKLIST.md` - Pre-launch verification
- `docs/technical/CORE_SYSTEM_FIXES_AND_STANDARDS.md` - Coding standards and patterns

## License

Proprietary - Trench City V2 © 2025
