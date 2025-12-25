# Trench City V2 – Full Forensic Audit (Read-Only)

## 1) Executive Summary (Top 15 Issues)
- High: 56 public entry files lack requireLogin() and are not prelogin pages (see routes_and_actions.json).
- High: 12 missing include/require targets detected (php_dependency_graph.json).
- High: Many modules in build order have 0-byte shells (factions, companies, properties, travel, casino, missions, social, blackmarket, admin).
- High: Code references ~40 tables/identifiers not present in SQL manifest (query_usage vs sql_manifest mismatch; many are noise but needs verification).
- High: Navigation links point to modules whose implementation files are empty (functional gaps).
- Medium: 349 empty files across repo (placeholders) including session files and module shells.
- Medium: Dangerous functions present in maintenance/helpers (exec/shell_exec in core/trenchcity-maintain.php, core/helpers_extended.php; see dangerous_patterns.txt).
- Medium: CSRF presence not universal; only pages containing csrf_token/csrf_check detected as yes.
- Medium: Missing include resolution could cause runtime warnings (see php_dependency_graph.json missing entries).
- Medium: Prelogin/postlogin overlay inconsistency; multiple duplicate module copies under public/modules/*.
- Medium: Query usage extraction includes non-table tokens, indicating SQL string quality issues.
- Low: Many test/utility scripts in public (dbtest.php, envtest.php, routetest.php, etc.) exposed without guards.
- Low: exec-based maintenance scripts should be restricted to CLI.
- Low: Large number of documentation/placeholder files inflate footprint but not functionality.
- Low: Background assets duplicated in assets/ and public/assets/; ensure deployment uses correct copies.
- Low: No php -l failures; overall syntax clean.

## 2) Repo Inventory Stats
- Total files: 1,188
- Empty files: 349
- By type: php 309; binary 759; md 40; txt 44; sql 11; css 15; js 2; json 5; conf 1; script 2
- Manifest: audit_out/file_manifest.csv & file_manifest.json

## 3) Full Entrypoints Table (public/*.php)
See audit_out/routes_and_actions.json. Summary:
- Total entry files scanned: 106
- Auth guarded (requireLogin detected): 50
- Unguarded (and not clearly prelogin): 56 (e.g., bank.php relies on module guard; combat.php, gym.php, mail.php rely on module guards; utility/test pages unguarded).
- CSRF detected (regex for csrf_token/csrf_check): subset only; many pages lack detectable CSRF markers.
- POST actions: captured keys per file in routes_and_actions.json.

## 4) Navigation + Module Completion (Build Order)
- Core Player: dashboard.php (guarded, non-empty) – UI 3, Backend 3
- Items: items.php (guarded shell), inventory.php (guarded) – UI 1, Backend 1 (market/inventory logic elsewhere)
- Gym: gym.php includes modules/gym/gym_shell.php (non-empty) – UI 3, Backend 3
- Crimes: crimes.php includes modules/crimes/crimes_shell.php (non-empty) – UI 3, Backend 3
- Combat: combat.php includes modules/combat/combat_shell.php (non-empty) – UI 2, Backend 2
- Factions: modules/factions/factions_shell.php (0 bytes) – UI 0, Backend 0
- Jobs/Companies: jobs.php has logic (guarded) – UI 2, Backend 2; companies_shell.php (0 bytes) – UI 0, Backend 0
- Properties: properties_shell.php (0 bytes) – UI 0, Backend 0
- Travel: travel_shell.php (0 bytes) – UI 0, Backend 0
- Casino: casino_shell.php (0 bytes) – UI 0, Backend 0
- Stock/Points: stock.php (guarded shell) – UI 1, Backend 1
- NPC/Missions: missions_shell.php (0 bytes) – UI 0, Backend 0
- Social: social_feed_shell.php (0 bytes) – UI 0, Backend 0
- Black Market: blackmarket_shell.php (0 bytes) – UI 0, Backend 0
- Admin/Logs: admin_shell.php (0 bytes); admin.php/admin_logs.php guarded shells – UI 1, Backend 0

## 5) DB Manifest Summary + Code-vs-Schema Mismatches
- SQL manifest tables parsed: 26 (see audit_out/sql_manifest.json). Includes users, player_stats, player_bars, player_settings, item_categories, items, user_items, gyms, gym_unlocks, training_logs, bank_transactions, bank_config, combat_logs, combat_config, crimes, crime_logs, email_verification_logs, email_config, jobs, user_job_history, user_current_job, market_items, user_inventory, market_transactions, mail_messages, mail_config.
- Code-referenced tables detected: 53 (see audit_out/query_usage.json). Heuristic mismatch set (~40) contains many non-table tokens (e.g., COLUMN_NAME, energy_last_regen) but also potential real gaps (hospital/leaderboards/admin_logs/etc.). Needs manual verification per query.

## 6) Security Findings
- Unguarded public files: 56 (see routes_and_actions.json); notable: combat.php, gym.php, mail.php depend on module guards; many test/utility pages exposed (dbtest.php, envtest.php, routetest.php, redistest.php, securitytest.php, health.php, helptest.php, home_shell.php).
- Missing includes: 12 unresolved include/require targets (php_dependency_graph.json) – runtime risk.
- Dangerous functions: exec/shell_exec in core/trenchcity-maintain.php and core/helpers_extended.php; shell_exec in core/audit.php for lint; restrict to CLI/admin.
- CSRF: only pages containing csrf_token/csrf_check flagged; others likely need tokens.
- Secrets: .env present (not read; contents not reported). Config keys must be redacted if inspected.

## 7) Assets/UI Findings
- Navigation links exist for modules whose shells are empty, leading to blank pages.
- Duplicate asset trees (assets/ vs public/assets/); ensure deployment uses public assets.
- Icons referenced in sidebar exist under public/assets/imgs/icons_32/.

## 8) Quality Findings
- php -l across all PHP files: no syntax errors reported.
- 349 empty files (placeholders, sessions, module shells) – clean up.
- Missing include targets (12) indicate path issues/legacy remnants.
- Query usage extraction shows noisy tokens; SQL string hygiene should be reviewed.

## 9) Perfect Finish Plan (Prioritized)
1) Lock down unguarded public pages: add requireLogin or remove test/utility scripts from production scope.
2) Resolve missing includes; fix paths or remove dead requires.
3) Implement modules with 0-byte shells (factions, companies, properties, travel, casino, missions, social, blackmarket, admin) and add schemas.
4) Verify CSRF on all POST handlers; standardize hidden csrf_token + csrf_check.
5) Reconcile code vs SQL manifest: confirm actual needed tables (hospital, leaderboards, admin logs, etc.) and add migrations.
6) Restrict exec/shell_exec usage to CLI/admin; guard maintenance scripts.
7) Clean empty placeholder/session files; ensure sessions stored outside repo in production.
8) Align navigation with implemented modules; hide links until functional.
9) Consolidate assets; ensure public assets used consistently.

Artifacts written:
- audit_out/file_manifest.csv, file_manifest.json
- audit_out/php_dependency_graph.json
- audit_out/routes_and_actions.json
- audit_out/sql_manifest.json
- audit_out/query_usage.json
- audit_out/findings.json
- audit_out/dangerous_patterns.txt
