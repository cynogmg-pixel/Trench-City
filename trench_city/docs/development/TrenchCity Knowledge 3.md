# GLOBAL PACK 02 — DB SCHEMA (TRENCH CITY V0 CORE)

> Canonical starting schema for the `trench_city` MariaDB database.  
> **DB is currently empty** → this Pack defines what DB/Schema GPT should create first.

---

## 0. PURPOSE & RULES

This Pack:

- Defines the **initial database schema** for Trench City.
- Covers **Build Order Phases 1–3**:
  1. Core Player
  2. Items (skeleton only)
  3. Gym
- Uses known core tables:
  - `users`
  - `player_stats`
  - `gyms`
  - `gym_unlocks`
  - `training_logs`
- Is the **starting point** for DB / Schema GPT:
  - Future phases (Crimes, Combat, Factions, etc.) will extend this Pack.
  - All changes must be explicit migrations, not silent changes in code.

**Global rules (from Packs 03, 05, 06):**

- `$db` wrapper only (no raw PDO/mysqli).
- XP and Level must **never drift** (Level ← `calculateLevel(xp)`).
- Bars (Energy, Nerve, Happy, Life) must be consistent across modules.
- Build Order respected:
  - Stabilize early-phase tables before piling later systems on top.

---

## 1. GLOBAL CONVENTIONS

### 1.1 Engine & Charset

- DB name: `trench_city`
- Engine: `InnoDB`
- Charset: `utf8mb4`
- Collation: `utf8mb4_unicode_ci`

```sql
CREATE DATABASE IF NOT EXISTS trench_city
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE trench_city;
1.2 Common Patterns
Primary keys

Every main table uses:

id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY

Timestamps

created_at (DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)

updated_at (DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP)

User foreign keys

Column: user_id BIGINT UNSIGNED NOT NULL

FK to users(id) (FK can be omitted if you prefer soft-FKs, but relation is always implied).

Money

Use DECIMAL(15,2) for all cash balances and amounts.

2. CORE PLAYER (PHASE 1)
“Player existence, identity, bars, stats, progression.”

2.1 users
Purpose: master player account / identity and top-level values.

sql
Copy code
CREATE TABLE users (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(32)  NOT NULL,
    email           VARCHAR(255) NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,

    -- Core progression
    xp              BIGINT UNSIGNED NOT NULL DEFAULT 0,
    level           INT UNSIGNED    NOT NULL DEFAULT 1,

    -- Economy
    cash            DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    bank_balance    DECIMAL(15,2) NOT NULL DEFAULT 0.00,

    -- Status / meta
    status          ENUM('active','banned','inactive') NOT NULL DEFAULT 'active',
    last_login_at   DATETIME NULL DEFAULT NULL,
    last_ip         VARCHAR(45) NULL DEFAULT NULL,

    -- Timestamps
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_users_username (username),
    UNIQUE KEY uq_users_email (email),
    KEY idx_users_status (status),
    KEY idx_users_last_login (last_login_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
Notes for CodeGPT

Use xp and level via helpers:

Always update xp then recompute level with calculateLevel(xp).

cash and bank_balance are the global cash stores for now:

Later systems (stocks, properties, faction vaults) will add more.

2.2 player_stats
Purpose: main combat and performance stats per user.

sql
Copy code
CREATE TABLE player_stats (
    user_id         BIGINT UNSIGNED NOT NULL PRIMARY KEY,

    strength        BIGINT UNSIGNED NOT NULL DEFAULT 0,
    speed           BIGINT UNSIGNED NOT NULL DEFAULT 0,
    defense         BIGINT UNSIGNED NOT NULL DEFAULT 0,
    dexterity       BIGINT UNSIGNED NOT NULL DEFAULT 0,

    -- Optional derivatives / cached values can be added later

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_player_stats_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
Notes

One row per player.

Gym, Combat, and some Crimes formulas will read/write these fields.

2.3 player_bars
Purpose: the 4 core bars per player (Energy, Nerve, Happy, Life) + their caps.

sql
Copy code
CREATE TABLE player_bars (
    user_id         BIGINT UNSIGNED NOT NULL PRIMARY KEY,

    energy_current  INT UNSIGNED NOT NULL DEFAULT 0,
    energy_max      INT UNSIGNED NOT NULL DEFAULT 100,

    nerve_current   INT UNSIGNED NOT NULL DEFAULT 0,
    nerve_max       INT UNSIGNED NOT NULL DEFAULT 15,

    happy_current   INT UNSIGNED NOT NULL DEFAULT 0,
    happy_max       INT UNSIGNED NOT NULL DEFAULT 100,

    life_current    INT UNSIGNED NOT NULL DEFAULT 100,
    life_max        INT UNSIGNED NOT NULL DEFAULT 100,

    last_regen_at   DATETIME NULL DEFAULT NULL,

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_player_bars_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
Notes

updateUserBars() should always operate on this table.

Regeneration logic (cron or on-demand) can use last_regen_at.

2.4 player_settings (optional but recommended early)
Purpose: per-player preferences (UI, notifications, privacy).

sql
Copy code
CREATE TABLE player_settings (
    user_id         BIGINT UNSIGNED NOT NULL PRIMARY KEY,

    -- Example flags (extend later)
    show_online_status  TINYINT(1) NOT NULL DEFAULT 1,
    dark_mode           TINYINT(1) NOT NULL DEFAULT 1,

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_player_settings_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
3. ITEMS (PHASE 2 — SKELETON)
“Item system core — full details can be expanded later by DB/Schema GPT.”

We define the minimal structure so Coder/Item Maker have somewhere to plug into.

3.1 item_categories
Purpose: high-level grouping of items (weapon, armor, consumable, etc.).

sql
Copy code
CREATE TABLE item_categories (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(64) NOT NULL,
    code            VARCHAR(32) NOT NULL, -- e.g. 'weapon','armor','consumable'

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_item_categories_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
3.2 items
Purpose: master item definitions.

sql
Copy code
CREATE TABLE items (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id     INT UNSIGNED NOT NULL,

    name            VARCHAR(128) NOT NULL,
    description     TEXT         NULL,

    -- Basic stats / properties (extend later)
    rarity          TINYINT UNSIGNED NOT NULL DEFAULT 1,   -- 1=common, etc.
    base_value      DECIMAL(15,2) NOT NULL DEFAULT 0.00,   -- shop price baseline

    -- Hooks for UI/art
    icon_key        VARCHAR(64) NULL DEFAULT NULL,         -- maps to asset name
    is_tradable     TINYINT(1) NOT NULL DEFAULT 1,

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_items_category
        FOREIGN KEY (category_id) REFERENCES item_categories(id)
        ON DELETE RESTRICT,

    KEY idx_items_category (category_id),
    KEY idx_items_rarity (rarity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
3.3 user_items
Purpose: which items each player owns.

sql
Copy code
CREATE TABLE user_items (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    item_id         BIGINT UNSIGNED NOT NULL,

    quantity        INT UNSIGNED NOT NULL DEFAULT 1,

    -- Optional: fields for bound items, ownership flags later

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_user_items_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_user_items_item
        FOREIGN KEY (item_id) REFERENCES items(id)
        ON DELETE RESTRICT,

    UNIQUE KEY uq_user_items_unique (user_id, item_id),
    KEY idx_user_items_user (user_id),
    KEY idx_user_items_item (item_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
4. GYM (PHASE 3)
“Energy-based stat training with gyms and logs.”

We lock in your known gym-related tables:

gyms

gym_unlocks

training_logs

4.1 gyms
Purpose: list of all gyms and their properties.

sql
Copy code
CREATE TABLE gyms (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name            VARCHAR(128) NOT NULL,
    description     TEXT         NULL,

    -- Requirements
    min_level       INT UNSIGNED NOT NULL DEFAULT 1,
    min_total_stats BIGINT UNSIGNED NOT NULL DEFAULT 0, -- optional

    -- Costs & modifiers
    energy_cost     INT UNSIGNED NOT NULL DEFAULT 5,
    gain_multiplier DECIMAL(6,3) NOT NULL DEFAULT 1.000, -- e.g. 1.250 = +25%

    is_premium      TINYINT(1) NOT NULL DEFAULT 0,

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    KEY idx_gyms_min_level (min_level),
    KEY idx_gyms_premium (is_premium)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
4.2 gym_unlocks
Purpose: which gyms a player has unlocked (if you use explicit unlocks instead of just min_level).

sql
Copy code
CREATE TABLE gym_unlocks (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    gym_id          INT UNSIGNED NOT NULL,

    unlocked_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_gym_unlocks_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_gym_unlocks_gym
        FOREIGN KEY (gym_id) REFERENCES gyms(id)
        ON DELETE CASCADE,

    UNIQUE KEY uq_gym_unlocks_user_gym (user_id, gym_id),
    KEY idx_gym_unlocks_user (user_id),
    KEY idx_gym_unlocks_gym (gym_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
4.3 training_logs
Purpose: log of each training action for Admin/Ops, Balance and player history.

sql
Copy code
CREATE TABLE training_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    gym_id          INT UNSIGNED NOT NULL,

    stat_type       ENUM('strength','speed','defense','dexterity') NOT NULL,
    energy_spent    INT UNSIGNED NOT NULL,
    stat_before     BIGINT UNSIGNED NOT NULL,
    stat_after      BIGINT UNSIGNED NOT NULL,
    xp_gained       INT UNSIGNED NOT NULL DEFAULT 0,

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_training_logs_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_training_logs_gym
        FOREIGN KEY (gym_id) REFERENCES gyms(id)
        ON DELETE CASCADE,

    KEY idx_training_logs_user (user_id),
    KEY idx_training_logs_gym (gym_id),
    KEY idx_training_logs_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
5. NEXT STEPS FOR DB / SCHEMA GPT
From this point:

Treat this Pack as v0 canonical schema for Phases 1–3.

When you design Crimes, Combat, Factions, etc., you will:

Extend this doc with new tables and ALTERs.

Keep users, player_stats, player_bars, items, user_items, gyms, gym_unlocks, training_logs stable unless you explicitly document migrations.

Produce separate sub-sections for each later phase:

5. CRIMES (PHASE 4)

6. COMBAT (PHASE 5)

7. FACTIONS (PHASE 6)

…and so on through Phase 15 (Admin/Logs/Anti-Exploit).

6. APPLYING THIS (SQL INIT)
To initialize the empty DB to this v0 schema:

Create DB and switch to it:

sql
Copy code
CREATE DATABASE IF NOT EXISTS trench_city
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE trench_city;
Run the CREATE TABLE statements above in order:

users

player_stats

player_bars

player_settings (optional)

item_categories

items

user_items

gyms

gym_unlocks

training_logs

After that, Core Player + Items skeleton + Gym have a clean base to build on.
GLOBAL PACK 03 — DEV RULES & CODING STANDARDS (TRENCH CITY)

Canonical rules for any GPT / dev touching Trench City code or game logic.
Applies to backend, frontend, and tooling (including migrations, scripts, cron, etc.).

0. SCOPE & PRIORITY

This document is law for:

Architect GPT

CodeGPT

PageSpec/UI GPT

Balance GPT

QA/Test GPT

Docs/Lore GPT (for any technical references)

It is global:

Overrides ad-hoc instructions inside single prompts unless the user explicitly says “ignore Global Pack 03 for this task”.

Must be used alongside:

Trench City Bible (AAA_FINAL_PLUS_152)

Global Pack 04 — Dark Luxury UI & Brand Guide

Global Pack 05 — Build Order & Module Map

Non-negotiable rule:
If any instruction from a worker prompt conflicts with this Pack, this Pack wins, unless the user explicitly overrides in that session.

1. TECH STACK & ENVIRONMENT

Server OS: Ubuntu 22.04

Web server: Nginx

PHP: 8.1 (FPM)

Database: MariaDB (main schema: trench_city)

Root path: /var/www/trench_city/

1.1 Core Directories

All paths are relative to /var/www/trench_city/:

/core
Core bootstrap, config, session/bootstrap logic, autoloaders, central helpers.

/includes
Shared logic, service classes, helpers, feature-level utility functions.

/assets/css
All CSS stylesheets (global + module-specific).

/assets/js
JS for behaviours, timers, minor interactivity.

/modules
Generic modules folder (if present).

/gym — Gym system (training, gyms list, UI).

/crimes — Crimes system (actions, logs, UI).

/factions — Faction system (management, wars, chains, etc.).

/city — City navigation / activities hub.

/jobs — Jobs & companies system.

/properties — Properties / real estate.

/vehicles — Vehicles / transport.

/casino — Casino games.

/missions — Missions / story / guided content.

/mail — In-game messages/mailbox.

/documents — Design docs (Bible slices, specs, global docs). Treated as system-level truth if present.

Any other existing module folders in the repo (e.g. /admin, /api) must be respected exactly as they are.

Directory rules:

Do not invent new top-level directories without explicit Architect / human approval.

If a new feature is needed:

Prefer to place it inside an existing module or /modules.

If a new top-level folder is truly required, document it in Global Pack 05 and update this section.

2. DATABASE ACCESS RULES
2.1 DB Wrapper Only (Never Raw PDO)

All DB interactions must use the project’s $db wrapper, not raw PDO/mysqli.

Allowed patterns (examples):

// Single row
$user = $db->fetchOne(
    "SELECT * FROM users WHERE id = :id",
    ['id' => $userId]
);

// Multiple rows
$gyms = $db->fetchAll(
    "SELECT * FROM gyms WHERE min_level <= :level",
    ['level' => $level]
);

// Write
$db->execute(
    "UPDATE users SET cash = cash + :amount WHERE id = :id",
    ['amount' => $amount, 'id' => $userId]
);


Hard rules:

❌ No new PDO(...), mysqli_*, $pdo->query(), mysql_* anywhere.

✅ Always use named parameters; never string-concatenate user input into SQL.

✅ Always handle:

“No rows found” (e.g. null from fetchOne)

Empty lists from fetchAll gracefully (show “no data” UI instead of fatal errors).

2.2 Schema & Columns (DB Accuracy Rule)

The schema is absolute truth.

Never invent:

Tables

Columns

Enum values

Foreign keys

Index names

If a feature appears to require new columns or tables:

Do not slip them into code “as if they already exist”.

Instead:

Comment clearly in code:
// TODO: requires new column 'foo' in table 'bar'

Architect or human updates DB design and migration files separately.

Only once schema is updated can follow-up code assume those structures.

2.3 Query Style & Performance

Prefer simple, readable queries over over-optimized, obfuscated ones.

Use indexes that already exist; do not assume new ones.

For potentially heavy operations:

If iterating over large sets, paginate via LIMIT/OFFSET or cursor-like logic.

Avoid unbounded SELECT * on huge tables without constraints.

2.4 Transactions

Where multi-step updates must be atomic (e.g., cash transfer, faction join + respect change):

Use DB transactions (via existing $db transaction helpers if present).

If transaction helpers are not defined, flag this as:

// TODO: add transaction support to db wrapper for atomic operations

Rules:

Either all related updates succeed or none do.

On error:

Roll back.

Log error via logging system.

Return clean error message to user (no raw SQL).

3. CORE GAME HELPERS (MUST USE)

These helpers are canonical. Any new code should prefer these over bespoke logic.

Mandatory helpers (names may live in /includes or equivalent):

getUser($userId)
Main user row.

getUserStats($userId)
Strength, Speed, Defense, Dexterity, etc.

getUserBars($userId)
Energy, Nerve, Happy, Life.

updateUserBars($userId, array $bars)
Atomic bar modification (consumption or regen).

calculateLevel(int $xp): int
Mapping from XP to Level.

getXPForLevel(int $level): int
XP threshold lookup.

logPlayerAction($userId, string $actionType, array $details)
Logs important actions (rewards, crimes, trades, etc.).

3.1 Helper Usage Rules

Always check for null / missing users before using them.

Do not duplicate logic:

If calculateLevel exists, do not reimplement XP→level mapping inside a crime/gym page.

Where existing helpers are insufficient:

Propose a new helper in code comments.

Implement once in /includes/... and reuse.

3.2 XP & Level Helper Enforcement

For every XP change:

Fetch current XP (and optionally current level).

Apply XP delta.

Call calculateLevel($newXp).

If level changed, persist it.

Optionally log via logPlayerAction.

Never:

Write level independently of XP.

Store “temporary” XP/level pairs that drift apart.

4. GLOBAL GAME RULES (BARS, XP, LEVEL)
4.1 Bars (Energy, Nerve, Happy, Life)

Core bars:

Energy — used for Gym, some actions.

Nerve — used for Crimes and risky actions.

Happy — influences gains in other systems.

Life — HP; affects combat, hospital, etc.

Bar rules:

Bar regeneration rates are defined in docs/DB, not hardcoded randomly.

Regeneration must:

Respect maximum caps.

Be consistent across modules.

When consuming bars:

Check bar >= cost.

If not enough, do not perform the action.

Deduct cost and save.

Only then run downstream logic (gym/crime/combat effects).

When restoring bars (items, properties, events):

Clamp to max.

For big jumps (e.g. full heal or +50% Energy), log via logPlayerAction.

4.2 XP & Level

Level is always derived from XP using calculateLevel.

Module code must not define independent XP/level systems.

Every XP change must:

Pull existing XP.

Apply XP delta.

Recompute level via calculateLevel.

Persist XP and level in a consistent transaction/operation.

Optionally log.

Never:

Store XP/level mappings inside JSON blobs or module-specific tables unless explicitly part of a system (e.g. local skill XP). If you do, it must be clearly distinct from global player XP/Level.

5. PHP CODING STANDARDS
5.1 File Structure

Output full PHP files, never partial fragments.

For new files, preferred header (if compatible with repo):

<?php
declare(strict_types=1);

// standard bootstrap, e.g.:
require_once __DIR__ . '/../core/init.php';


Do not close PHP tag ?> at end of pure PHP files (standard best practice).

Respect existing bootstrap pattern:

Use the same require_once path structure as other files in that folder.

5.2 Naming Conventions

Follow existing repo style; by default:

Functions/methods:

snake_case or camelCase matching the file you are editing.

Do not mix styles within the same file.

Variables:

Descriptive, not single letters (except trivial for ($i = 0; ...) loops).

Avoid reusing variable names for different purposes in the same scope.

Files:

Lowercase, snake_case:
gym.php, crime_actions.php, faction_wars.php.

Classes (if used):

PascalCase: UserService, CrimeEngine.

Constants:

Uppercase with underscores: MAX_ENERGY, FACTION_RANK_LEADER.

5.3 Error Handling & Validation

Never trust $_GET, $_POST, $_REQUEST, $_COOKIE directly.

Always:

Trim values.

Cast types ((int), (float)).

Validate ranges (>= 0, < some upper bound).

On invalid input:

Fail gracefully:

Either redirect with an error message.

Or show an inline error in the UI card.

Do not show raw stack traces or SQL strings.

Examples:

$targetId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($targetId <= 0) {
    // handle invalid target
}

5.4 Coding Style & Structure

Keep functions short and single-responsibility where practical.

Extract repeated patterns into helpers inside /includes.

Prefer early returns over deep nested if chains.

Avoid copy-pasting large blocks of code; abstract instead.

5.5 Comments & Documentation

Use comments to explain why something is done, not obvious “what” lines.

For non-trivial functions, use a short docblock:

/**
 * Attempt a crime and return the outcome payload.
 *
 * @param int $userId
 * @param int $crimeId
 * @return array{success: bool, xp_gain: int, cash_gain: int, jail: bool, hospital: bool}
 */
function perform_crime(int $userId, int $crimeId): array
{
    // ...
}

6. SECURITY RULES
6.1 Authentication & Authorization

Any page that requires login must:

Check for authentication via a central helper (e.g. requireLogin()).

Redirect unauthenticated users to login/register (or show an appropriate message).

Critical actions must validate:

The acting player is allowed to perform the action.

The target resource (user, faction, property) belongs to them when appropriate.

Example:

Before allowing a property upgrade, ensure property owner’s user_id matches the current user.

Before faction actions, ensure player is in that faction and has sufficient rank.

6.2 CSRF Protection

All state-changing forms (POST) must include a CSRF token.

All state-changing GET actions (e.g. ?action=sell_all) should preferably be converted to POST or protected with CSRF + confirmation.

Rules:

GPTs must:

Not remove existing CSRF validation.

Add missing CSRF to new forms where appropriate.

If the CSRF system implementation is not visible, do not reinvent it:

Assume central helpers exist (generate_csrf_token, etc.).

If missing, clearly mark // TODO: hook up to central CSRF system.

6.3 SQL Injection & XSS

All SQL must use bound parameters via $db wrapper.

When rendering user-inputted values in HTML:

Use htmlspecialchars($value, ENT_QUOTES, 'UTF-8').

When outputting logs, avoid dumping raw JSON or serialized payloads without escaping.

6.4 Sessions & Cookies

Never store:

Passwords.

Sensitive tokens unencrypted in cookies.

Use server-side sessions for authentication; cookies should store only random session IDs if necessary.

6.5 Rate Limiting / Anti-Abuse (High-Level)

For highly spammy endpoints (crimes, casino spins, etc.) consider:

Soft rate limits (client-side cooldowns, timers).

Server-side checks (e.g. ensure action’s cooldown has expired).

7. LOGGING & AUDIT

Use logPlayerAction for core game events, especially when values change significantly.

7.1 What to Log

Log categories (examples):

Economy:

Large cash gains/losses.

Item awards/removals of high value.

Bank interest, stock dividends (later).

Progression:

Level-ups.

Major stat gains (e.g., hitting certain thresholds).

Criminal / Risk systems:

Crime attempts & outcomes.

Casino spins/bets.

Social/Factions:

Faction joins/leaves.

Faction rank changes.

War start/end events.

7.2 Log Payloads

Store minimal but sufficient data:

user_id

action_type (string key)

details (JSON or structured array)

created_at timestamp

Do not log:

Passwords

Raw session tokens

Full payment instrument details

7.3 Debug Logs

For debugging:

Use dev-only logs where possible that can be disabled in production.

Never expose stack traces or raw SQL to users in the UI.

8. FRONTEND RULES (PHP + HTML MIX)

All game pages must follow Dark Luxury layout from Global Pack 04:

London background.

Sidebar navigation.

Card-based content area.

Frontend rules (high level):

Avoid inline CSS for main styling:

Put styles in /assets/css/....

Avoid heavy inline JS:

Put logic in /assets/js/... per module.

Use consistent structure:

Page wrapper container

Sidebar (left)

Main content area with cards

8.1 HTML Structure

Use semantic elements where convenient (<section>, <header>, <nav>, <main>).

Keep forms grouped inside cards.

Use tables for dense data (logs, inventories, rankings).

8.2 Reuse of Components

When you create a new UI pattern (e.g., a specific card structure for logs), consider abstracting it into a small partial or documented fragment in /includes or a template system (if present).

9. AI / GPT USAGE RULES (FOR CODE & PAGES)

These rules bind all GPT workers editing or generating code/UI.

9.1 Localized Changes by Default

Default behaviour:

Modify only what is necessary in a file.

Do not rewrite entire file unless:

The file is very small or

The user explicitly says “rewrite this file” / “full refactor”.

9.2 Respect Existing Style

Match:

Indentation (spaces vs tabs).

Naming style.

Existing patterns in that file/module.

Never “PSR-12 reform” an entire file unless explicitly instructed.

9.3 Shell-Before-Backend Rule

For new features:

First ensure a shell page exists (UI skeleton).

Then implement backend logic that the shell uses.

Do not build backend “blind” with no page shell defined.

9.4 No Unapproved Modules

No auto-creation of:

New modules.

New top-level paths.

Only create new modules/folders if:

Architect GPT or human explicitly instructs it.

This Pack and Global Pack 05 are updated accordingly.

9.5 Commenting Refactors

For major refactors:

Add clear comments summarizing what changed and why.

Keep behaviour identical unless user asks to change behaviour.

10. NON-NEGOTIABLES (RED LINES SUMMARY)

From earlier sections, consolidated:

❌ No raw PDO/mysqli. Only $db wrapper.

❌ No invented DB schema (tables/columns/enums).

❌ No partial PHP file outputs. Always full files.

❌ No deviation from Dark Luxury theme without explicit override.

❌ No XP/level desync.

❌ No bar manipulation outside standard helpers.

✅ Always use:

Helper functions (getUser, getUserBars, calculateLevel, etc.).

Dark Luxury layout + sidebar.

Proper validation, CSRF, and logging.

11. QUICK DEV CHECKLIST (BEFORE YOU SAY “DONE”)

Any GPT / dev finishing a change should mentally tick:

Folder & file ok?

Correct directory.

File name matches conventions.

Includes ok?

Uses init.php or central bootstrap.

No missing require_once.

DB usage ok?

$db wrapper only.

Bound parameters.

No invented columns/tables.

Helpers used?

Bars and XP/level use canonical helpers.

Logging via logPlayerAction for important events.

Security ok?

Auth and permission checks.

CSRF on state-changing forms.

Escaped output.

UI ok?

Dark background, gold accents.

Sidebar present and aligned to Global Pack 04.

Content in cards with decent spacing.

Behaviour ok?

No obvious infinite loops / exploits.

No hidden debug output.

Comments & clarity ok?

Non-obvious parts briefly documented.

No leftover debug var_dump/echo.

If any answer is “no”, that GPT must fix it or explicitly flag it for follow-up instead of silently ignoring.
# GLOBAL PACK 04 — DARK LUXURY UI & BRAND GUIDE (TRENCH CITY)

> Canonical visual + UX law for **all** Trench City UI.  
> Any GPT that touches HTML/CSS, layout, UI copy, or image prompts must obey this guide. :contentReference[oaicite:0]{index=0}  

---

## 0. PURPOSE & SCOPE

This guide exists so that:

- Every page, panel and popup in Trench City:
  - Feels like the **same game**.
  - Feels **premium**, **London**, and **Dark Luxury**.
- Any worker GPT (PageSpec, Code, Image, Docs) can:
  - Read this once.
  - Produce **on-brand** output without guessing.

Hierarchy:

1. **Trench City Bible** = game systems, lore, mechanics.
2. **Global Pack 03** = dev rules, coding standards.
3. **Global Pack 04** = how everything *looks and feels*.
4. **Global Pack 05** = what modules exist and when to build them.

If a random prompt conflicts with this Pack, **this Pack wins** unless the user explicitly overrides it.

---

## 1. CORE THEME & VIBE

- **Theme Name:** Dark Luxury  
- **Core fantasy:** You’re running your grind and empire in a **cold, wet, neon London**, but the UI feels like a high-end underground command suite.
- **Primary inspirations:**
  - Late-night City of London / Canary Wharf.
  - Rain on glass, neon reflections, black cars, quiet brutality.
  - Torn-style dense browser MMO — but more cinematic, more polished.

**Mood words (every screen should embody at least 3–4):**

- Dark
- Premium
- Cinematic
- Urban
- Sleek
- Gritty but controlled
- Technical, not cartoon
- Expensive, not arcade

**Hard rules:**

- No “generic browser game blue/white” vibes.
- No saturated rainbow colors.
- No childish iconography; everything is grounded in modern UK crime/city aesthetic.

---

## 2. COLOR & PALETTE

### 2.1 Primary Palette (Core Brand Colors)

**Backgrounds:**

- Deep navy / near-black base tones:
  - Example hexes:
    - `#05070B` — almost black, acts as global page background.
    - `#0B1220` — navy-black mix for inner regions.
- Cards and panels:
  - Slightly lighter darks:
    - `#101827`, `#111827`, `#121826`.

**Primary Accent (Gold):**

- Used sparingly for:
  - Headings.
  - Key icons.
  - Borders, separators.
  - Important buttons and data highlights.
- Example gold tones:
  - Rich mid gold: `#D4AF37`
  - Slightly brighter UI highlight gold: `#F5C451`

**Secondary Accents:**

- **Steel greys** for chrome / frames:
  - `#1F2933`, `#4B5563`, `#6B7280`
- **Electric blue** for emphasis:
  - Controlled accent only (notifications, active selection):
    - `#1D4ED8` (muted if needed via opacity).

### 2.2 Status Colors & Semantics

**Success (good, positive):**

- Desaturated, darker green:
  - Example: `#059669` or slightly dimmed.
- Used for:
  - Successful actions.
  - Positive outcomes.
  - Minor gains.

**Warning (caution):**

- Amber aligned with gold:
  - Example: `#FBBF24` but darkened slightly.
- Used for:
  - Cooldowns nearly finished.
  - Actions with risk.
  - Soft warnings.

**Danger (negative, high risk):**

- Deep red/crimson:
  - Example: `#B91C1C` / `#DC2626` but used carefully.
- Used for:
  - Health danger.
  - Jail, hospital, death screens.
  - Critical failures.

**Never:**

- Use neon, bright cartoon greens/reds.
- Mix multiple vibrant colors on the same small component.

### 2.3 Greyscale Ladder

Define a rough ladder (can be adjusted to match existing CSS):

- `#020617` — base page background.
- `#050B16` — navigation sidebars.
- `#0B1220` — main content background.
- `#111827` — card backgrounds.
- `#1F2937` — borders, strong contrasts.
- `#4B5563` — muted text, secondary labels.
- `#9CA3AF` — placeholder text.
- `#D1D5DB` — low-intensity lines, dividers.

---

## 3. TYPOGRAPHY & TEXT

### 3.1 Font Families & Hierarchy

- **Base assumption:** clean sans-serif family (e.g., system font stack or a neutral webfont).
- Hierarchy:
  - **H1/H2 Titles:** bold, slightly larger, gold.
  - **H3/H4 Subtitles:** medium weight, light grey/white.
  - **Body Text:** regular, high legibility grey/white.
  - **Microcopy:** small, muted grey.

### 3.2 Heading Styles

- **H1 (Page title):**
  - Gold text, larger font size.
  - Slight letter-spacing.
  - Optional subtle bottom border or glow.

- **H2 (Section title):**
  - Slightly smaller than H1.
  - Gold or light grey, depending on context.
  - Should visually anchor each card/section.

- **H3/H4 (Card titles, sub-panels):**
  - Uppercase allowed for short titles.
  - Avoid heavy decoration; keep it clean.

### 3.3 Body & Label Text

- **Body text:**
  - Primary color: near white or light grey on dark background.
  - Line-height generous to avoid “cramped” feel.

- **Labels and microtext:**
  - Smaller size.
  - Muted grey (`#6B7280` etc.).
  - Used for hints, tooltips, small notes.

### 3.4 Text Tone & Voice (Microcopy)

- Voice:
  - Short, direct, not cringe.
  - Casual UK tone allowed, but not over-slanged.
- Error messages:
  - Concise: “Not enough Energy.” / “You can’t attack this player right now.”
- Notifications:
  - Clear and descriptive: “You gained 12 Strength and 40 XP from training.”

**Avoid:**

- Overly quirky or meme language in core systems.
- Long multi-line buttons/labels.

---

## 4. LAYOUT SKELETON

Any main game page should be recognizable as Trench City from layout alone.

### 4.1 Global Background

- London at night vibe:
  - Could be:
    - Dimmed cityscape image.
    - Soft, blurred high-rise lights with rain streak textures.
- Content background remains dark with a slight vignette to keep focus in the center.

**Rule:**

- The background is always there but never distracts:
  - Low contrast.
  - Slight blur or dim filter.

### 4.2 Header / Top Bar

**Contents:**

- Left:
  - Game logo or “TRENCH CITY” wordmark.
- Right or centered cluster:
  - Player name & title.
  - Level, rank.
  - Quick summary of bars (Energy/Nerve/Happy/Life).
  - Key currencies (Cash, Points, any premium).

**Visual:**

- Slightly darker bar than page background.
- Thin gold line along bottom edge.
- Bars can be shown as compact micro-bars in the header.

### 4.3 Sidebar Navigation (Left, Fixed)

Core characteristics:

- Background: slightly lighter than page background.
- Structured into groups separated by thin lines.

**Standard order:**

1. **Core & HUD**
   - Dashboard
   - Progression (if separate from Dashboard)
2. **Core Loops**
   - Gym
   - Crimes
   - Risk & Reward (if separate module)
3. **World & Systems**
   - City
   - Jobs
   - Properties
   - Vehicles
   - Casino
4. **Meta & Advanced**
   - Factions
   - Missions
   - Companies
   - Stock/Points (if separate)
5. **Account & Social**
   - Inventory
   - Mail
   - Account
   - Logout

**Interaction:**

- Active link:
  - Gold highlight (text or left border).
- Hover:
  - Slight increase in brightness.
- Icons:
  - Neutral, minimal icons may be used, but:
    - No cartoon style.
    - No overly complicated icons.

### 4.4 Main Content Area

- All main content lives in **cards** arranged in 1–2 columns.
- Primary layout pattern:

```text
[ Header / Bars ]
[ Sidebar ] [ Content Cards ]
On wide screens:

2 columns inside content where helpful:

Left: primary actions.

Right: stats, logs, contextual info.

On narrower screens (or mobile):

Cards stack vertically.

5. COMPONENT STANDARDS
5.1 Cards
Core building block.

Visual:

Background: dark (#111827 style).

Rounded corners: 12–16px radius.

Shadow: soft, subtle drop shadow.

Border: thin gold or dark grey border, depending on importance.

Structure:

Top:

Card title (H3) with gold or bright text.

Body:

Sectioned content with enough padding.

Footer (optional):

Buttons for actions.

Microtext for hints.

Usage examples:

Player snapshot.

Gym action block.

Crime category listing.

Mission details.

Faction info panels.

Logs and recent actions.

5.2 Buttons
Primary button:

Gold background, dark text or dark background with gold border and text.

Rounded corners.

Hover:

Slight glow / brightness.

Maybe subtle shadow lift.

Secondary button:

Dark grey background.

Light border.

Less visual weight.

Destructive button (danger):

Deep red background.

White text.

Only used where necessary (e.g. “Disband Faction”).

Rules:

Same button style site-wide.

Avoid default browser buttons.

5.3 Tables & Lists
Tables:

Used for:

Inventory.

Logs.

Rankings.

Faction member lists.

Header row:

Darker background.

Gold or white text.

Rows:

Alternating dark shades for readability.

Borders:

Thin lines; no heavy white boxes.

List-style blocks:

Used in Crimes, Missions, City locations.

Each item a row or mini-card with:

Title, description, icon(s), action button.

5.4 Timers & Progress Bars
Progress bars (core bars):

Rounded shape.

Fill color mapped:

Energy → Gold.

Nerve → Electric or muted blue.

Happy → Green.

Life → Red.

Text overlay:

“Current / Max” inside bar or next to it.

Timers:

Pill or tag style, e.g.:

“Travel: 03:21 remaining”

Colors:

Neutral or gentle accent; danger if < certain threshold (e.g. last 10s).

5.5 Forms & Inputs
Inputs:

Dark backgrounds.

Light text.

Thin border, highlighted in gold/blue on focus.

Labels:

Above field, small, muted grey.

Error states:

Red border.

Short error message under field.

6. UX PRINCIPLES
6.1 Density & Structure
Trench City is information-dense, but never chaotic.

Use:

Clear card division.

Headers and subheaders.

Tabs inside cards when necessary.

6.2 Feedback & State Changes
After every important action (train, crime, spin, attack):

Show:

A result card or highlight area.

What changed:

Bars

Cash

XP

Items

Optionally:

Append an entry to a log section within the page.

6.3 Navigation Clarity
Player should always know:

Where they are (highlighted sidebar + page title).

What they can do next.

Use breadcrumb-style hints where needed (e.g., inside Missions, Factions).

6.4 Consistency
One consistent interaction pattern per system:

Crimes: select crime → confirm → see result.

Gym: choose stat → confirm → see gain.

Factions: choose action → confirm → see success/fail.

6.5 Avoiding Clutter
If a card has too many options:

Group into tabs or accordions.

Don’t show every advanced feature to a level 1 player:

Use progressive disclosure based on Bible’s progression rules.

7. PAGE TYPES & THEIR FEEL
7.1 Dashboard
Purpose: player’s mission control.

Must show:

Bars (Energy, Nerve, Happy, Life).

Level, XP progress bar.

Current missions / tasks.

Income sources summary.

Faction snapshot (if in a faction).

Top 3–5 timers (travel, jail, hospital, cooldowns).

Layout:

Multi-card grid:

Top card: Player snapshot.

Left: current tasks/missions.

Right: news, last actions, events.

Vibe:

Clean, organized, slightly cinematic — like a private control room.

7.2 Gym
Content:

Stats:

Strength, Speed, Defense, Dexterity displayed clearly.

Training options:

Buttons or controls to spend Energy per stat.

Limits and bonuses:

Show any gym multipliers, unlock levels.

Layout:

Left:

Stats and main training actions.

Right:

Training log, tips, maybe flavor art.

Vibe:

Underground gym with expensive feel — not a cheap boxing gym, more a private fight club.

7.3 Crimes
Content:

Crime categories:

Basic → advanced.

Each crime row:

Title.

Short description.

Nerve cost.

Risk/reward summary.

Requirements.

Button to attempt.

Layout:

List or table.

Result panel that shows:

Outcome, XP, cash, other effects.

Vibe:

Slight tension in UI; use colors and microcopy to convey risk.

7.4 Factions
Content:

Faction overview:

Name, tag, leader, respect, rank.

Members:

Table with ranks, stats, online state.

Warfare:

Chains, wars, raids, territory.

Upgrades:

Perks, bonuses.

Layout:

Multiple cards:

Overview, Members, Actions, Warfare, Logs.

Vibe:

Organized command war-room.

Faction color may blend with Dark Luxury but not override it.

7.5 Other Modules (Short)
Jobs/Companies:

Clean, “business-like” feel inside Dark Luxury shell.

Properties:

Luxury estate cards; images with subdued high-end look.

Travel:

Map-style or list-style interface of destinations, travel times, and unique perks.

Casino:

Dark, glowing neon highlight; strongly visual but still minimal, not cartoon.

8. IMAGES & ILLUSTRATIONS
8.1 Global Style
Hyper-detailed, realistic, modern.

Photoreal or high-end 3D render aesthetic.

No comic/anime visuals in core UI.

8.2 Weapon & Item Art
Format:

1:1 square.

Transparent or very dark background.

Composition:

Single weapon/item centered.

Possibly gold rim-light.

No hands, no characters, no busy backgrounds.

Used in:

Inventory lists.

Shop panels.

Loot popups.

8.3 Environment / City Art
Night-time cityscapes:

Wet streets, reflections.

Neon, headlights, London landmarks (subtle).

Used for:

Backgrounds.

Splash images.

Mission cards.

8.4 Faction & Logo Imagery
Faction emblems:

Simple but impactful.

Limited color palette (gold, grey, one accent color).

Rule:

All image prompts generated by GPTs must reference:

“Dark Luxury”

“London at night”

“Gritty premium crime MMO”
where relevant, to keep style locked.

9. RESPONSIVE BEHAVIOUR (BASIC)
9.1 Desktop-First
Game is primarily desktop browser MMO.

Design all pages for ~1280–1600px width.

9.2 Medium Screens (Tablets / Laptops)
Sidebar shrinks width.

Cards may switch from 2 columns to 1 column where needed.

9.3 Small Screens (Mobiles)
Sidebar:

Can collapse to icon-only or slide-out menu.

Content:

Cards stacked vertically.

Larger touch targets:

Buttons and controls spaced further apart.

9.4 Avoid Horizontal Scroll
Only allow horizontal scroll in:

Data-heavy logs with many columns (as a last resort).

10. DO / DON’T (CHECKLIST)
DO:

Use dark backgrounds and gold highlights on every page.

Keep spacing generous inside cards.

Reuse component patterns mathematically:

Same card style for logs in Crimes and Gym.

Show feedback clearly after actions.

DON’T:

Use plain white backgrounds anywhere in-game UI.

Pull in random bright color sets.

Change fonts wildly between modules.

Build “bare HTML” screens that don’t match the Dark Luxury shell.

11. AI WORKER QUICK REFERENCE
For GPT workers (PageSpec, Code, Image, Docs), think in terms of:

Shell first:

Header + Sidebar + Cards scaffold.

Theme lock:

Dark background, gold accents, card layout.

Component reuse:

Progress bars, tables, forms same style everywhere.

Page match:

Dashboard / Gym / Crimes / Factions each have their own feel but share skeleton.

Whenever a GPT is about to emit HTML/CSS or image prompts:

It should mentally check:

“Does this look like Dark Luxury?”

“Would this sit cleanly next to index.php/register.php in this game?”

If answer is not immediate “yes”, it should adjust colors/layout to match this guide.
# GLOBAL PACK 05 — BUILD ORDER & MODULE MAP (TRENCH CITY)

> Canonical build-order + module map for all Trench City development.  
> Every GPT and every human dev must respect this order and never skip ahead without Architect / human approval. :contentReference[oaicite:0]{index=0}  

---

## 0. PURPOSE, SCOPE & HIERARCHY

This Pack defines:

- **What** systems exist in Trench City.
- **When** each system should be built (order + dependencies).
- **Where** their code lives (module map).
- **How** all GPT workers should prioritize work across phases.

It is used together with:

1. **Trench City Bible (AAA_FINAL_PLUS_152)**
   - Full design truth for each system.
2. **Global Pack 03 — Dev Rules & Coding Standards**
   - How code must be written.
3. **Global Pack 04 — Dark Luxury UI & Brand Guide**
   - How everything must look and feel.
4. **Global Pack 05 — Build Order & Module Map** (this doc)
   - In which order systems are built and which modules belong where.

**Priority rule:**

- For **system order & which module to work on next**, this Pack is the authority.
- If a worker prompt conflicts with this Pack regarding build order, **this Pack wins** unless user explicitly overrides.

---

## 1. OFFICIAL BUILD ORDER (PHASE OVERVIEW)

Trench City build order is **linear in priority**, but not strictly single-threaded: you may polish multiple systems in the same phase once prerequisites are met. :contentReference[oaicite:1]{index=1}  

**PHASES:**

1. **Core Player**
2. **Items**
3. **Gym**
4. **Crimes**
5. **Combat**
6. **Factions**
7. **Jobs / Companies**
8. **Properties**
9. **Travel**
10. **Casino**
11. **Stock / Points Market**
12. **NPC / Missions**
13. **Social Systems (Mail, Chat, Friends, Blacklists)**
14. **Black Market & High-Risk Systems**
15. **Admin / Logs / Anti-Exploit**

**Golden rule:**

> When in doubt, stabilize and complete **earlier phases** before investing in later ones.

---

## 2. STATUS MODEL (PER SYSTEM / MODULE)

Every major system/module must be tracked along four axes: :contentReference[oaicite:2]{index=2}  

- **Design:**  
  - `TODO` — not designed or only rough ideas.
  - `ALPHA` — initial Bible spec + early decisions exist.
  - `BETA` — design mostly complete; tweaks only.
  - `POLISHED` — fully pinned, consistent with live gameplay.

- **Backend:**
  - `TODO` — no code or stub only.
  - `ALPHA` — minimal functionality, unstable.
  - `BETA` — feature-complete, may have bugs.
  - `POLISHED` — stable, optimized, logged, and tested.

- **UI:**
  - `TODO` — shell or nothing.
  - `ALPHA` — functional but rough UI.
  - `BETA` — visually consistent, minor issues.
  - `POLISHED` — matches Dark Luxury fully + UX is final.

- **Tests:**
  - `TODO` — no tests, no checklist.
  - `PARTIAL` — some manual or smoke tests.
  - `COMPLETE` — full manual checklist + automated paths where possible.

**GPT rule:**

- GPTs should **never silently assume** a module is `POLISHED`.
- When asked, they can estimate status but must label it:
  - “AI-estimated, needs human confirmation.”

---

## 3. PHASE 1 — CORE PLAYER

> “Player existence, identity, bars, progression, account lifecycle.” :contentReference[oaicite:3]{index=3}  

### 3.1 Responsibilities

- Account lifecycle:
  - Registration, login, logout.
  - Session handling & security.
- Player profile:
  - Identity (name, gender/identity fields as per Bible).
  - Display avatar / identity decisions.
- Core stats:
  - XP & Level.
  - Primary stats: Strength, Speed, Defense, Dexterity.
- Bars:
  - Energy, Nerve, Happy, Life.
- Base economy hooks:
  - Cash, initial starting state.
- Global helpers:
  - `getUser`, `getUserStats`, `getUserBars`, `updateUserBars`.
  - `calculateLevel`, `getXPForLevel`.
  - `logPlayerAction`.

### 3.2 Example Files & Paths

- `/index.php` — landing/dashboard (already polished).
- `/register.php` — registration (already polished).
- `/logout.php` — logout (already polished).
- `/core/init.php` — bootstrap, config.
- `/includes/user_functions.php` — player helpers (illustrative).
- `/includes/stats_functions.php` — stats helpers (if present).

### 3.3 Dependencies

- Depends on:
  - None (this is absolute base).
- Required by:
  - **Everything** else: Items, Gym, Crimes, etc.

### 3.4 “Ready for Next Phase” Criteria

Before moving heavy effort into Items (Phase 2) and beyond:

- Design: `BETA` or `POLISHED` for:
  - XP/Level scaling model.
  - Bars regen model.
- Backend:
  - Authentication stable and secure.
  - Core helper functions present and used.
  - XP <-> Level sync enforced.
- UI:
  - Dashboard layout at least `ALPHA`, ideally `BETA`.
  - Bars and stats visible in at least one central place.
- Tests:
  - Manual test script exists for:
    - Registration/login/logout.
    - Basic stat/bar modifications.
    - Session timeout / logout behaviour.

---

## 4. PHASE 2 — ITEMS

> “All items and inventory that feed gym, crimes, combat, properties, etc.” :contentReference[oaicite:4]{index=4}  

### 4.1 Responsibilities

- Item definitions:
  - Weapon, armor, clothing, consumables, boosters, special, unique items.
- Inventory:
  - Player item storage.
  - Sorting, filtering, basic management.
- Item usage:
  - Consume/use effects (heals, buffs, etc.).
- Equipment:
  - Equipping weapons/armor (where relevant).
  - Hooks into combat and stats.
- Economic roles:
  - Buy/sell operations for shops/markets (initial).

### 4.2 Example Paths

- `/inventory/` or `/modules/inventory/` (depending on repo).
- `/includes/item_functions.php` — item helpers.

### 4.3 Dependencies

- Depends on:
  - Core Player (user identity and stats).
  - DB schema for `items`, `user_items`, etc.
- Required by:
  - Combat (weapons/armor).
  - Crimes (loot, consumables rewards).
  - Properties, Factions, Casino (rewards & sinks).

### 4.4 “Ready for Next Phase” Criteria

Before going deep into Gym/Crimes:

- Design:
  - Items classification clear.
  - Item rarity tiers (if any).
- Backend:
  - `get_player_inventory`, `add_item_to_player`, `remove_item_from_player` style helpers defined.
  - Inventory operations safe (no dupe/exploit).
- UI:
  - Inventory page at least `ALPHA`: list, quantities, simple use/sell.
- Tests:
  - Manual test cases for:
    - Adding/removing items.
    - Using consumables.
    - Equipping/unequipping.

---

## 5. PHASE 3 — GYM

> “Stat training system using Energy and Gyms.” :contentReference[oaicite:5]{index=5}  

### 5.1 Responsibilities

- Gym catalogue:
  - List of gyms, unlock thresholds, costs.
- Training actions:
  - Strength, Speed, Defense, Dexterity training.
  - Energy cost per action.
- Gains:
  - Stat gains calculations based on:
    - Gym quality.
    - Player Happy, properties, faction perks, etc. (as defined in Bible).
- UI:
  - Clear display of stats and expected gains.
  - Logs of training actions.

### 5.2 Example Paths

- `/gym/gym.php` — main gym page.
- `/includes/gym_functions.php` — training/gain logic.

### 5.3 Dependencies

- Depends on:
  - Core Player (stats + bars).
  - Items (for any gym-related boosters).
- Required by:
  - Combat (stats as power).
  - Crimes (some crime success formulas).
  - Factions (requirements, chain damage).

### 5.4 “Ready for Next Phase” Criteria

Before heavy Crimes & Combat:

- Design:
  - Stat gain formulas stable.
  - Gym unlock structure clear (basic → advanced).
- Backend:
  - All training actions use Energy via `updateUserBars`.
  - Gains logged appropriately.
- UI:
  - Gym UI is `BETA` at least — clear, responsive.
- Tests:
  - Manual flows:
    - Training from zero.
    - Hitting higher gyms.
    - Edge cases (no Energy, max stats, etc.).

---

## 6. PHASE 4 — CRIMES

> “Nerve-based actions with risk/reward, progression and logs.” :contentReference[oaicite:6]{index=6}  

### 6.1 Responsibilities

- Crime catalogue:
  - From petty crime to high-end operations.
- Attributes:
  - Nerve cost, base success chance, rewards, jail/hospital risk.
- Progression:
  - Unlock path: new crimes as stats/experience increase.
- Outcomes:
  - Success: cash, XP, items, respect, other rewards.
  - Failures: jail, hospital, reputation hits.
- UI:
  - Display of crime categories, difficulty, requirements.

### 6.2 Example Paths

- `/crimes/crimes.php`
- `/includes/crime_functions.php`

### 6.3 Dependencies

- Depends on:
  - Core Player (Nerve, XP/Level).
  - Items (loot table hooks).
  - Gym (stats can affect crime rates, as per Bible).
- Required by:
  - Factions (respect generation).
  - Black Market (advanced crime outputs).
  - Missions (many mission objectives rely on crimes).

### 6.4 “Ready for Next Phase” Criteria

Before large Combat/Factions push:

- Design:
  - Crime tree, difficulty curve and unlock path stable.
- Backend:
  - All crimes consume Nerve via `updateUserBars`.
  - All rewards go through central economy functions.
  - Jail/hospital integration in place.
- UI:
  - Crime page `BETA`: categories clear, outcomes surfaced.
- Tests:
  - Manual criminals flow including:
    - Early crimes.
    - Higher-tier crimes.
    - Jail/hospital edge cases.

---

## 7. PHASE 5 — COMBAT

> “Player vs Player and possibly PvE combat resolution.” :contentReference[oaicite:7]{index=7}  

### 7.1 Responsibilities

- Attack system:
  - Target selection.
  - Validation (attackable, online state, cooldowns).
- Combat mechanics:
  - Round/turn-based or simplified formulas.
  - Use of stats, weapons, armor, modifiers.
- Outcomes:
  - Life damage, hospital & defeat states.
  - Cash/loot/XP outcomes where applicable.
- UI:
  - Attack screen, outcomes, combat logs.

### 7.2 Example Paths

- `/combat/attack.php`
- `/includes/combat_functions.php`

### 7.3 Dependencies

- Depends on:
  - Core Player (Life bar, XP).
  - Gym (stats).
  - Items (weapons/armor).
- Required by:
  - Factions (wars, chains).
  - Missions/NPC fights.
  - Black Market (PvP-centric items and systems).

### 7.4 “Ready for Next Phase” Criteria

Before rolling big Faction features:

- Design:
  - Attack formulas and damage models stable.
  - Hospital/jail interplay fully specified.
- Backend:
  - Core combat path works end-to-end.
  - No obvious infinite loops or exploit attack paths.
- UI:
  - Attack flow is `BETA` minimum — intuitive, responsive.
- Tests:
  - Manual tests:
    - Balanced fights.
    - One-sided fights.
    - Edge cases (no Life, no weapon, invalid target).

---

## 8. PHASE 6 — FACTIONS

> “Player-organized groups with wars, chains, territory and upgrades.” :contentReference[oaicite:8]{index=8}  

### 8.1 Responsibilities

- Faction lifecycle:
  - Create, join, leave, disband.
- Membership:
  - Ranks, permissions, roles.
- Respect & progression:
  - Respect gain from crimes/combat.
  - Upgrades unlocked via respect & cash.
- Warfare modes:
  - Ranked wars.
  - Territory wars.
  - Chains.
  - Raids.
  - Black Ops.
- Internal tools:
  - Faction chat, notices (later).
  - Faction logs.

### 8.2 Example Paths

- `/factions/` (multiple pages).
- `/includes/faction_functions.php`

### 8.3 Dependencies

- Depends on:
  - Combat (attacks).
  - Crimes (respect generation).
  - Properties & Items (faction perks & rewards).
- Required by:
  - Missions (faction missions).
  - Black Market (faction-based content).

### 8.4 “Ready for Next Phase” Criteria

Before Jobs/Companies & Properties heavy push:

- Design:
  - Faction progression path and upgrade tree stable.
  - War/chain rules clear.
- Backend:
  - Joining/leaving, leadership control & respect storage stable.
  - War and chain awarding respect & logs.
- UI:
  - Faction overview + members + actions at least `BETA`.
- Tests:
  - Manual flows:
    - Create faction.
    - Invite/join/leave.
    - Start/resolve a simple war.

---

## 9. PHASE 7 — JOBS / COMPANIES

> “Employment system and player-owned businesses.” :contentReference[oaicite:9]{index=9}  

### 9.1 Responsibilities

- NPC jobs:
  - Entry-level employment for new players.
  - Wages, promotions, job stats.
- Player companies:
  - Company creation, hiring, management.
  - Company-specific perks and roles.
- Wages and bonuses:
  - Daily/weekly payouts.
  - Performance metrics.

### 9.2 Example Paths

- `/jobs/`
- `/companies/` (or unified module)

### 9.3 Dependencies

- Depends on:
  - Core Player.
  - Economy (cash, items).
- Required by:
  - Missions (job-based tasks).
  - Properties & long-term progression loops.

### 9.4 “Ready for Next Phase” Criteria

Before major Properties/Travel:

- Design:
  - Job ladders, wages and promotion paths defined.
- Backend:
  - Salary payout routines safe and logged.
- UI:
  - Job list/assignment at least `ALPHA`, aiming `BETA`.
- Tests:
  - Manual:
    - Join/leave job.
    - Daily/periodic payout simulation.
    - Company creation/hiring basics.

---

## 10. PHASE 8 — PROPERTIES

> “Properties as long-term assets altering regen, capacity, prestige and options.” :contentReference[oaicite:10]{index=10}  

### 10.1 Responsibilities

- Property catalogue:
  - From starter flats to premium estates to **final-level mega-properties / country ownership** as per Bible.
- Ownership:
  - Buy/sell.
  - Multi-property rules (if allowed).
- Upgrades & furnishing:
  - Interior upgrades.
  - Facilities that affect bars, regen, guest capacity, etc.
- Bonuses:
  - Regen modifiers.
  - Capacity for guests.
  - Special features (vaults, training rooms, etc.).

### 10.2 Example Paths

- `/properties/` (multiple pages: list, view, manage, market).

### 10.3 Dependencies

- Depends on:
  - Core Player.
  - Economy (property pricing).
- Required by:
  - Travel (home bases).
  - High-end economy loops (renting, property services).
  - Missions (property-based unlocks).

### 10.4 “Ready for Next Phase” Criteria

Before Travel and Casino:

- Design:
  - Full property progression tree, including **final-level property** and country ownership features.
- Backend:
  - Buy/sell logic correct.
  - Upgrade/bonus calculation integrated into bar regen and stats.
- UI:
  - Property listing and management `BETA`.
- Tests:
  - Manual flows:
    - Purchase/upgrade.
    - Effect on regen and stats.
    - Edge cases (insufficient funds, ownership limits).

---

## 11. PHASE 9 — TRAVEL

> “Travel between locations / countries for items, crimes, missions and trade.” :contentReference[oaicite:11]{index=11}  

### 11.1 Responsibilities

- Travel system:
  - Origin/destination.
  - Tickets, travel time, cooldowns.
- Location content:
  - Location-specific shops.
  - Location-specific items, crimes and missions.
- Timers:
  - Travel timer integration with bars/other systems.

### 11.2 Example Paths

- `/travel/` (map/list UI, travel logic).

### 11.3 Dependencies

- Depends on:
  - Properties/economy (affordability, travel perk from properties).
  - Items/Crimes for location-specific variations.
- Required by:
  - Missions (global routes).
  - Black Market (foreign content).
  - Casino (foreign casinos if any).

### 11.4 “Ready for Next Phase” Criteria

Before Casino:

- Design:
  - Location list and travel times defined.
  - Location-based differences fully specified.
- Backend:
  - Travel state stored & respected (can’t do certain actions while travelling).
- UI:
  - Travel UI `BETA`: selecting destinations, seeing timers, etc.
- Tests:
  - Manual:
    - Travel flows to/from several locations.
    - Timer expiry and arrival side-effects.

---

## 12. PHASE 10 — CASINO

> “High-risk cash sinks and gambling loops.” :contentReference[oaicite:12]{index=12}  

### 12.1 Responsibilities

- Games:
  - Slots, roulette, blackjack, lotto etc. per Bible.
- House edge:
  - Enforced mathematically.
  - No negative house EV features without strong reason.
- Limits:
  - Bet caps, daily limits, anti-whale safeguards.
- Logging:
  - Every bet, every win, every jackpot.

### 12.2 Example Paths

- `/casino/` (subpages for each game).

### 12.3 Dependencies

- Depends on:
  - Stable economy (otherwise casino can break game).
  - Logging systems working (for exploit detection).
- Required by:
  - Missions (casino-based content).
  - High-end Black Market / prestige systems.

### 12.4 “Ready for Next Phase” Criteria

Before Stocks/Points:

- Design:
  - Game list and rules locked.
  - House edge designed per game.
- Backend:
  - Secure randomization.
  - Bet/win flows safe and logged.
- UI:
  - Casino pages `BETA`.
- Tests:
  - Manual:
    - Multiple runs per game.
    - Edge conditions (max bet, low funds).
    - Statistical sanity checks (approx EV in tests).

---

## 13. PHASE 11 — STOCK / POINTS MARKET

> “Long-term investments and premium currency exchange.” :contentReference[oaicite:13]{index=13}  

### 13.1 Responsibilities

- Stock system:
  - Shares, prices, returns.
  - Long-term benefits for holdings.
- Points market:
  - Player-to-player trading of premium currency.
  - Buy/sell orders, price, volume.
- Safeguards:
  - Anti-manipulation measures.
  - Logging for suspicious behaviours.

### 13.2 Example Paths

- `/stocks/`
- `/points/`

### 13.3 Dependencies

- Depends on:
  - Very stable economy.
  - Logging and admin tools.
- Required by:
  - Missions (investment goals).
  - Endgame wealth loops.

### 13.4 “Ready for Next Phase” Criteria

Before Missions & Social:

- Design:
  - Stock models and Points rules pinned down.
- Backend:
  - Correct accounting of points and stock positions.
- UI:
  - Lists, order placement, portfolio view `BETA`.
- Tests:
  - Manual:
    - Buy/sell loops.
    - Simulated profit/loss.
    - Edge-case double spending checks.

---

## 14. PHASE 12 — NPC / MISSIONS

> “Story content, progression rails, guided experiences.” :contentReference[oaicite:14]{index=14}  

### 14.1 Responsibilities

- NPCs:
  - Named characters with roles and voice.
- Missions:
  - Chains, trees, multi-step objectives.
  - Rewards and unlocks.
- Hooks:
  - Crimes, Gym, Factions, Travel, Casino, etc.

### 14.2 Example Paths

- `/missions/` (list, details, progress).

### 14.3 Dependencies

- Depends on:
  - Most core loops functioning:
    - Core Player, Items, Gym, Crimes, Combat, Factions, Jobs, Properties, Travel, basic Casino.
- Required by:
  - Long-term retention, narrative structure.

### 14.4 “Ready for Next Phase” Criteria

Before Social & Black Market:

- Design:
  - Core mission arcs defined; onboarding flow locked.
- Backend:
  - Mission state tracking correct.
  - Objective checking referencing other systems stable.
- UI:
  - Mission list + detail view `BETA`.
- Tests:
  - Manual:
    - End-to-end on-boarding mission.
    - Midgame mission chain.
    - Faction-related mission.

---

## 15. PHASE 13 — SOCIAL SYSTEMS

> “Player-to-player communication and relationships.” :contentReference[oaicite:15]{index=15}  

### 15.1 Responsibilities

- Mail (in-game messaging).
- Friends / enemies lists.
- Possibly basic global/local chat (later).
- Notes, comments on profiles.

### 15.2 Example Paths

- `/mail/` (inbox, outbox, compose).

### 15.3 Dependencies

- Depends on:
  - Core Player.
  - Basic economy (for potential mailing attachments later).
- Required by:
  - Factions and Missions that rely on communication.
  - Social retention.

### 15.4 “Ready for Next Phase” Criteria

Before Black Market:

- Design:
  - Messaging rules (limits, anti-spam).
- Backend:
  - Message storage and retrieval.
- UI:
  - Inbox/outbox and indicators (`BETA`).
- Tests:
  - Manual:
    - Send/receive flows.
    - Block/ignore flows.
    - Limits and spam safety.

---

## 16. PHASE 14 — BLACK MARKET & HIGH-RISK SYSTEMS

> “Endgame rare items and high-stakes mechanics.” :contentReference[oaicite:16]{index=16}  

### 16.1 Responsibilities

- Black market shop(s):
  - Ultra-rare items.
  - Illicit services.
- High-risk mechanics:
  - Super high-stake bets.
  - Special operations that tie many systems together.
- Gating:
  - Requirements (faction rep, missions, properties).

### 16.2 Dependencies

- Depends on:
  - Almost all previous systems:
    - Items, Factions, Casino, Stocks, Missions, etc.
- Required by:
  - True endgame & prestige playstyles.

### 16.3 “Ready for Next Phase” Criteria

Before final Admin & Anti-Exploit polish:

- Design:
  - Clear risk/reward and uniqueness of black market content.
- Backend:
  - Fully uses existing economic/logging protections.
- UI:
  - Black market pages `ALPHA` → `BETA`.
- Tests:
  - Manual:
    - Acquire rare item flows.
    - Exploit checks on pricing, loops.

---

## 17. PHASE 15 — ADMIN / LOGS / ANTI-EXPLOIT

> “Operator tools and exploit detection.” :contentReference[oaicite:17]{index=17}  

### 17.1 Responsibilities

- Admin dashboards:
  - Player search, ban tools, economy snapshots.
- Global logs:
  - Cash logs.
  - XP/stat logs.
  - Item logs.
  - Faction and war logs.
- Anti-exploit:
  - Pattern detection (suspicious transactions, repeated behaviours).
  - Tools to correct/rollback.

### 17.2 Dependencies

- Depends on:
  - Logs from all earlier phases.
- Required by:
  - Live operations and long-term game health.

### 17.3 “Ready for Live” Criteria

Before any public or large-scale launch:

- Design:
  - Clear admin personas (moderator vs dev vs full admin).
- Backend:
  - All core logs integrated.
  - Basic exploit flags in place.
- UI:
  - Admin pages functional and reasonably clean.
- Tests:
  - Manual:
    - Search & view logs.
    - Simulated exploit scenarios.

---

## 18. MODULE MAP USAGE BY GPTs (HOW TO DECIDE WHAT TO WORK ON)

When any GPT gets a task, it must: :contentReference[oaicite:18]{index=18}  

1. **Identify phase:**
   - Map requested feature to a phase (1–15).
2. **Check prerequisites:**
   - Look at all earlier phases and:
     - If they’re not at least `ALPHA/BETA` stable, flag this to Architect/user.
3. **Scope work:**
   - Limit changes to:
     - The current phase’s modules.
     - Earlier phases for bugfix/polish only.
4. **Report dependency risks:**
   - If balancing or behaviour in earlier systems is unstable, warn that:
     - Later systems may need rebalancing once earlier ones are fixed.

**Example:**

- User says: “Add a new faction war mode.”
  - GPT maps this to **Phase 6 (Factions)**.
  - It must check:
    - Core Player, Items, Gym, Crimes, Combat states.
  - If Combat formulas are still in flux, it should write:
    - “Factions war mode implemented but may need rebalance when Combat stabilizes.”

---

## 19. ARCHITECT & QA CHECKLIST PER PHASE

For each phase/system before calling it “Phase Complete”:

1. **Design**
   - Bible sections updated and consistent.
   - Edge cases described.
2. **Backend**
   - Core features present and stable.
   - Uses Global Pack 03 helpers and DB rules.
3. **UI**
   - Pages follow Dark Luxury skeleton.
   - Key flows are clear and usable.
4. **Tests**
   - Manual checklist for:
     - Normal flows.
     - Edge cases.
     - Exploit-hunting scenarios.
5. **Inter-system hooks**
   - System interacts correctly with its dependencies and consumers.

If any of these are weak, the phase is not fully complete — later phases should be treated as **tentative** and ready for adjustment.

---

## 20. TL;DR FOR WORKER GPTs

- **Never** jump to late-phase systems if earlier ones are broken.
- Always ask:
  1. “What phase is this feature?”
  2. “Are earlier phases stable?”
  3. “Which modules/files does this phase own?”
- Use:
  - **Global Pack 03** for how to code.
  - **Global Pack 04** for how to style.
  - **Global Pack 05** for when and where to implement.

If in doubt, **recommend fixing/stabilizing earlier phases first**, then plan a follow-up pass on the requested later system.

---
# TRENCH CITY — MODULE PHASE MATRIX

File: `TRENCH_CITY__MODULE_PHASE_MATRIX.md`  
Purpose: Single source of truth for **which modules are at Shell / Backend / Polish**.

Architect, Systems Analyst, and all workers MUST read this before doing work on a module.

- **Shell**   = Alpha page shells + basic routing exist.
- **Backend** = Core logic implemented and stable enough for QA.
- **Polish**  = Visual/UI polish, UX tweaks, copy, and minor QoL only.

Status values to use:
- `NOT_STARTED`
- `PLANNED`
- `SHELL_IN_PROGRESS`
- `SHELL_DONE`
- `BACKEND_IN_PROGRESS`
- `BACKEND_DONE`
- `POLISH_IN_PROGRESS`
- `POLISH_DONE`

_Last updated: YYYY-MM-DD — by: [name or GPT]_

---

## 1. MATRIX OVERVIEW

| Order | Module           | Shell Status         | Backend Status         | Polish Status          | Primary Owner GPT(s)              | Notes / Blockers                          |
|------:|------------------|----------------------|------------------------|------------------------|-----------------------------------|-------------------------------------------|
| 01    | Core Player      | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Architect / Code / DB             |                                           |
| 02    | Items            | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Item Maker / Code / DB / Balance  |                                           |
| 03    | Gym              | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Page Spec / Code        |                                           |
| 04    | Crimes           | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Page Spec / Code        |                                           |
| 05    | Combat           | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / Balance          |                                           |
| 06    | Factions         | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / DB / Balance     |                                           |
| 07    | Jobs/Companies   | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / DB               |                                           |
| 08    | Properties       | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / DB               |                                           |
| 09    | Travel           | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / DB               |                                           |
| 10    | Casino           | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / Balance          |                                           |
| 11    | Stock/Points     | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / DB / Balance     |                                           |
| 12    | NPC/Missions     | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Lore / Systems / Code / Balance   |                                           |
| 13    | Social           | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / UI               |                                           |
| 14    | Black Market     | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Systems / Code / Balance / Admin  |                                           |
| 15    | Admin/Logs       | NOT_STARTED          | NOT_STARTED            | NOT_STARTED            | Admin/Ops / Code / DB             |                                           |

> Architect: update these statuses whenever a module moves phase, and mirror major changes into  
> `TRENCH_CITY__BUILD_STATUS_AND_PHASE_TRACKER.md`.

---

## 2. PHASE DEFINITIONS (SHORT)

### 2.1 Shell Phase

A module is **Shell** when:

- Routes, nav links, and base pages exist.
- Dark Luxury layout skeleton is in place (no full styling required).
- Placeholder content / stub components exist for main actions.
- No or minimal real logic; can be static or mocked.

**Who works here:**

- File Manager GPT → paths & routing
- Page Spec GPT → layout spec
- CodeGPT → minimal shell implementation (no heavy logic yet)

---

### 2.2 Backend Phase

A module is **Backend** when:

- All core actions and flows work end-to-end.
- All DB access uses `$db` wrapper and approved helpers.
- No invented schema — DB / Schema GPT has defined everything.
- Basic validation, permissions, and error handling exist.
- Logs/hooks for Admin/Ops are planned or partially implemented.

**Who works here:**

- DB / Schema GPT → schema tables/columns
- CodeGPT → full backend logic
- QA GPT → test plans, exploit checks
- Balance GPT → numbers for payouts, XP, etc. (where relevant)

---

### 2.3 Polish Phase

A module is **Polish** when:

- Logic is stable and passes QA for major flows.
- No major refactors expected.
- UI/UX can be improved without breaking behaviour.

**Who works here:**

- UI Polisher GPT → visuals, spacing, copy, UX
- Docs/Wiki GPT → documentation
- Admin/Ops GPT → final staff tools and dashboards
- QA GPT → regression checks

---

## 3. CHANGE LOG

Track major updates to this matrix.

```text
YYYY-MM-DD — [name] — Initial file created, all modules NOT_STARTED.
YYYY-MM-DD — [name] — Updated Gym to SHELL_DONE / BACKEND_IN_PROGRESS.
YYYY-MM-DD — [name] — Crimes shell created, set to SHELL_IN_PROGRESS.
4. USAGE RULES (FOR ARCHITECT + WORKERS)
Architect MUST:

Read this file at the start of any new planning step.

Update this file after any module moves Shell → Backend → Polish.

Workers MUST:

Refuse to work on a module in a later phase if earlier phases are not at the required status, unless Architect explicitly overrides.

Use the status here as the truth, not assumptions from chat.

This matrix is the global phase map for Trench City modules.
