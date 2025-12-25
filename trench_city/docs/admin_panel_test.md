# Admin Panel Test Checklist

- Login as admin@trenchmade.co.uk and confirm /admin/ loads with admin nav.
- Login as a non-admin user and confirm /admin/ redirects to /dashboard.php.
- Confirm Owner Panel and Owner Logs links are hidden for non-admin users.
- Update a user XP value and verify level is re-synced.
- Toggle email_verified if the column exists and confirm the change persists.
- Update bars and confirm values change in player_bars.
- Validate CSRF enforcement by submitting forms without a token (should fail).
- Open /admin/logs.php and confirm recent [PLAYER_ACTION] entries display safely.
- Enable maintenance mode and confirm non-owner users are redirected to /maintenance.php after login.

## Header Merge Smoke Checks

- Prelogin pages (/, /login.php, /register.php) render the same header layout and buttons as before.
- Postlogin pages still show stats bars, actions, and theme toggle with no layout shifts.
- Maintenance page header matches prelogin styling and preserves Back/Logout/Contact actions.
- Theme toggle works on prelogin, postlogin, and maintenance pages; logo swap still updates.
- Header stays intact on mobile widths (no overlap or clipping).
