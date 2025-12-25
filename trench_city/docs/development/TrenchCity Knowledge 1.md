# API_Admin_FINAL.md — Unified Ultra Specification
## This merges:
- V1 (full baseline admin API spec)
- V2 (ultra expansion: threat models, workflows, audit taxonomy, monitoring, blueprint formats)

---

## === SECTION A: BASELINE ADMIN API SPEC (V1) ===

# API_Admin.md  
**Trench City — Admin API Specification (V1)**

---

## 1. Purpose & Scope

The **Admin API** is the internal HTTP API surface used by:

- Trench City **web admin panel** (staff tools)
- Future **admin mobile tools** (ops, moderation)
- **Automated services** & back-office scripts (backups, economy checks, audits)

It is **never exposed to regular players** and must always sit behind:

- Strong authentication & authorization
- Network controls (VPN / IP allowlists / private subnets)
- Centralized logging & audit trails

This document defines:

- **Namespaces & URL design**
- **Auth model** (sessions + tokens)
- **Role & permission mapping**
- **Core endpoint families**
- **Error model, rate limits, and logging rules**
- **Security requirements** aligned with `Security_Spec.md`
- **Extension rules** and how this connects to `OpenAPI_Spec.md` and `Global_Pack_V3.md`

---

## 2. Design Principles

1. **Admin-first safety**  
   Any bug should **fail closed**, not fail open. If something is unclear, the API should deny the action and log it.

2. **Read-heavy, write-limited**  
   Most endpoints are **read-only**. Mutating endpoints are strongly permissioned, require stricter logging, and in some cases **dual confirmation**.

3. **Consistency across all APIs**  
   The Admin API follows the same conventions as the global API spec (`OpenAPI_Spec.md`):

   - JSON everywhere
   - `snake_case` fields
   - Consistent error envelope
   - Versioned base path (`/admin/api/v1/...`)

4. **Auditability over convenience**  
   Every sensitive action (bans, currency edits, item grants, stat changes, etc.) must be fully auditable:

   - Who did it
   - When
   - From where (IP / user agent)
   - What changed (before + after snapshot where reasonable)
   - Why (optional free-text reason field)

5. **Idempotency & safety for bulk ops**  
   Bulk actions must be:

   - Idempotent when possible (re-running doesn’t double-apply)
   - Paginated & streamed for long-running tasks
   - Logged with a single **bulk operation id** plus per-item sub-entries

6. **Least privilege**  
   Roles should grant **only** the permissions required for that staff member’s job. Superadmin capability is tightly controlled and rare.

---

## 3. Base URL, Versioning & Format

### 3.1 Base URL

Admin API base path (internal only):

```text
/admin/api/v1/
```

Examples:

- `GET /admin/api/v1/users`
- `POST /admin/api/v1/users/{user_id}/ban`
- `PATCH /admin/api/v1/items/{item_id}`

### 3.2 Versioning

- URI-based versioning: `/v1/` as part of the path.
- Breaking changes require a new version (`/v2/`)—never silently break `/v1/`.
- Deprecation rules and timelines must be reflected in `OpenAPI_Spec.md`.

### 3.3 Request & Response Format

- **Content-Type**: `application/json; charset=utf-8`
- **Accept**: `application/json`

Standard response envelope:

```json
{
  "success": true,
  "data": { ... },
  "meta": {
    "request_id": "uuid",
    "timestamp": "2025-01-01T00:00:00Z"
  }
}
```

Error envelope:

```json
{
  "success": false,
  "error": {
    "code": "USER_NOT_FOUND",
    "http_status": 404,
    "message": "User not found",
    "details": {
      "user_id": 12345
    }
  },
  "meta": {
    "request_id": "uuid",
    "timestamp": "2025-01-01T00:00:00Z"
  }
}
```

---

## 4. Authentication, Sessions & Roles

### 4.1 Auth Mechanisms

Admin API supports two core auth flows (defined deeply in `Security_Spec.md`):

1. **Admin Web Session (Cookie-based)**  
   - Admin logs into the **Admin Panel** (server-rendered or SPA).  
   - Backend issues a **hardened admin session cookie** scoped to admin domain/path only.  
   - Admin API requests are authenticated by that session + CSRF protection.

2. **Admin API Tokens (Bearer)**  
   - For secure automation and tooling (e.g., scheduled jobs, DevOps tools).  
   - Tokens are **scoped** (read-only, limited modules) and short-lived where possible.  
   - Always sent via `Authorization: Bearer <token>`.

No player session cookie is ever valid for `/admin/api/...`.

### 4.2 Headers

Minimum required headers:

- `Authorization: Bearer <token>` **or** valid admin session cookie
- `X-Request-Id` (optional; generated server-side if missing)
- `X-Admin-Client: web_panel | mobile_tool | cli | unknown`
- `X-CSRF-Token` for state-changing calls when using cookie auth

### 4.3 Role & Permission Model

Roles live in the DB and/or config as defined in Master Bible & security docs.

Suggested base roles (names may adjust to schema):

- `superadmin`
- `admin` (general staff)
- `moderator`
- `support`
- `economy_admin`
- `content_admin`
- `devops_admin` (infra-only endpoints, not game logic)

Permissions are fine-grained:

- `user.view`, `user.edit`, `user.ban`, `user.unban`
- `economy.wallet.view`, `economy.wallet.adjust`
- `item.view`, `item.create`, `item.update`, `item.delete`, `item.grant`
- `faction.view`, `faction.admin`
- `company.view`, `company.admin`
- `mission.view`, `mission.edit`, etc.

Admin API endpoints must each declare:

- **Required roles** (minimum)
- **Required permissions** (precise)
- Whether **superadmin only**

---

## 5. Rate Limiting & Throttling

Even internally, limits are required to prevent abuse and mistakes.

### 5.1 Per-Admin Limits

- Default: `X` requests/minute per admin account (configurable).
- Mutating endpoints (bans, grants, wipes, etc.) have additional, stricter limits:

  - e.g., `10` ban requests/minute/account
  - `50` item grants/minute/account (depending on bulk design)

### 5.2 Per-IP Limits

- Soft IP rate limits for public admin panel.
- Relaxed but monitored for VPN/internal IP ranges.

### 5.3 Bulk Operations Safeguards

- Require **confirm phrases** or multi-step flows in UI; API-level enforcement by:

  - `bulk_operation_id`
  - Max items per bulk request
  - Optional “dry run” mode returning what would be changed

---

## 6. Logging, Auditing & Monitoring

### 6.1 Request Logging

For each admin API request, log at least:

- `request_id`
- Admin user ID (or API token id)
- Timestamp
- Path + method
- IP + user-agent
- Response status
- Time to process (ms)

### 6.2 Audit Log for Sensitive Actions

For sensitive operation types:

- Bans, mutes, warnings
- Currency or stat changes
- Item grants / removals
- Faction/Company ownership changes
- Property/vehicle transfers
- Mission/state overrides
- Account deletions / anonymizations

Store structured audit rows:

- `admin_id`
- `actor_role`
- `target_type` (user, faction, company, system)
- `target_id`
- `action_type` (BAN_USER, ADJUST_WALLET, GRANT_ITEM, etc.)
- `payload_before` (JSON snapshot where feasible)
- `payload_after`
- `reason` (optional text)
- `created_at`, `ip_address`, `user_agent`

These audit log tables are defined in DB schema docs. Admin UI must surface them for investigations.

### 6.3 Security Monitoring

- Failed auth attempts -> security alerts after threshold.
- Unexpected patterns (e.g., mass bans, large stat changes) -> flagged in monitoring.
- Integrated with Security Spec alerting rules (Slack/Discord/Email).

---

## 7. Error Handling & Codes

Error codes are centralized (see `OpenAPI_Spec.md`).

Sample categories:

- `AUTH_*` — `AUTH_REQUIRED`, `AUTH_INVALID_TOKEN`
- `PERMISSION_*` — `PERMISSION_DENIED`, `ROLE_TOO_LOW`
- `USER_*` — `USER_NOT_FOUND`, `USER_ALREADY_BANNED`
- `ECONOMY_*` — `WALLET_NOT_FOUND`, `AMOUNT_OUT_OF_RANGE`
- `ITEM_*` — `ITEM_NOT_FOUND`, `ITEM_CANNOT_BE_GRANTED`
- `SYSTEM_*` — `INTERNAL_ERROR`, `ENDPOINT_DISABLED`

HTTP status mapping:

- `200/201/204` – success
- `400` – validation / bad input
- `401` – auth required
- `403` – permission denied
- `404` – not found
- `409` – conflict
- `429` – too many requests
- `500` – unexpected server error

---

## 8. Endpoint Families

This section defines **families** of admin endpoints. Exact parameter definitions and full schema will live in `OpenAPI_Spec.md`, but this document is the **source of truth for design and intent**.

### 8.1 Admin Auth & Sessions

- `POST /admin/api/v1/auth/login`  
  - Credentials or SSO.
  - Issues admin session (cookie) and returns profile + roles + permissions.

- `POST /admin/api/v1/auth/logout`  
  - Invalidates current session.

- `GET /admin/api/v1/auth/me`  
  - Returns admin profile, roles, permissions.

- `POST /admin/api/v1/auth/token` (superadmin/devops-only)  
  - Creates scoped access tokens for CLI / automation.

Security:

- Strong password policies (if local auth).
- 2FA/MFA rules from `Security_Spec.md`.
- Login throttling & lockout after repeated failures.

---

### 8.2 User Search & Profile Management

**Namespace**: `/admin/api/v1/users`

Examples:

- `GET /admin/api/v1/users`  
  - Search by username, id, email, IP, last login, etc.
  - Pagination and filtering.

- `GET /admin/api/v1/users/{user_id}`  
  - Full enriched profile with:
    - Basic info
    - Stats (strength, speed, defense, dexterity)
    - Bars (energy, nerve, happy, life)
    - Inventory summary
    - Faction, company, properties, vehicles
    - Account flags (banned, muted, staff notes)

- `PATCH /admin/api/v1/users/{user_id}`  
  - Edit limited fields (e.g. email, flags, notes).
  - Certain fields (username changes, major stats) may be restricted to higher roles.

- `POST /admin/api/v1/users/{user_id}/ban`  
  - Fields: `reason`, `duration`, `type` (temporary/permanent), `evidence_links`.
  - Audited.

- `POST /admin/api/v1/users/{user_id}/unban`

- `POST /admin/api/v1/users/{user_id}/mute` / `/unmute`  
  - For chat/communication restrictions.

- `GET /admin/api/v1/users/{user_id}/history`  
  - Ban/mute history, economy changes, property transfers, etc.

---

### 8.3 Economy & Currency Controls

**Namespace**: `/admin/api/v1/economy`

- `GET /admin/api/v1/economy/summary`  
  - High-level overview:
    - Total money in circulation
    - Total bank deposits
    - Point balances, bonds, key sinks/sources

- `GET /admin/api/v1/users/{user_id}/wallet`  
  - Detailed breakdown for a single user.

- `POST /admin/api/v1/users/{user_id}/wallet/adjust`  
  - Adjust funds with fields:
    - `amount` (signed)
    - `reason`
    - `source` (compensation, bug fix, punishment, etc.)
  - Strict logging + permission.

- `GET /admin/api/v1/economy/logs`  
  - Search economy adjustments, filters by admin, user, date, etc.

- `POST /admin/api/v1/economy/point_market/toggle`  
  - Enable/disable specific markets (superadmin).

All **economy-changing endpoints** must be wired into central audit logs.

---

### 8.4 Items & Inventory Admin

**Namespace**: `/admin/api/v1/items`

- `GET /admin/api/v1/items`  
  - List items with filters: type, rarity, enabled, etc.

- `POST /admin/api/v1/items`  
  - Create a new item definition.
  - Fields: `name`, `type`, `rarity`, `base_value`, `effects`, `flags`, etc.
  - Validation must match item schema (`MasterBible`, items spec).

- `GET /admin/api/v1/items/{item_id}`

- `PATCH /admin/api/v1/items/{item_id}`  
  - Update item metadata. Certain flags (e.g. “admin-only”) may require superadmin.

- `DELETE /admin/api/v1/items/{item_id}`  
  - Soft delete only; never fully erase used items from history.

- `POST /admin/api/v1/users/{user_id}/items/grant`  
  - Grant item(s) to a player:
    - `item_id`
    - `quantity`
    - `source` (compensation, event reward, etc.)
    - `reason` text

- `POST /admin/api/v1/users/{user_id}/items/remove`  
  - Remove item(s) with full logging.

Inventory admin APIs must respect `InventoryService` and **never bypass core safety logic**.

---

### 8.5 Stats, Bars & Progression Overrides

**Namespace**: `/admin/api/v1/progression`

- `GET /admin/api/v1/users/{user_id}/stats`  
  - View battle stats, XP, level.

- `POST /admin/api/v1/users/{user_id}/stats/adjust`  
  - Dangerous; restricted to superadmin/economy_admin.  
  - Should ideally go through a “compensation / event fix” flow rather than arbitrary editing.

- `POST /admin/api/v1/users/{user_id}/xp/grant`  
  - Uses the same XP → level logic as game (no direct level set; respects `calculateLevel(xp)`).

- `POST /admin/api/v1/users/{user_id}/bars/set`  
  - For life/energy/nerve/happy during investigations/tests.

All such overrides are logged heavily and usually require reason + ticket reference.

---

### 8.6 Factions & Companies Admin

**Namespace**: `/admin/api/v1/factions`, `/admin/api/v1/companies`

Core operations:

- Search factions/companies.
- View full profile: members, stats, resources, wars, income.
- Change ownership (with confirmation flows).
- Disband / freeze (superadmin).
- Inject or remove resources (respecting economy rules).
- Fix broken states (e.g., stuck wars, bugged properties).

Each operation must:

- Validate consistency (e.g., cannot assign multiple leaders).
- Emit audit logs for all significant changes.

---

### 8.7 Properties, Vehicles & Assets

**Namespace**: `/admin/api/v1/properties`, `/admin/api/v1/vehicles`

- View templates & instances.
- Force-transfer assets between players or to system.
- Correct bugged states.
- Adjust property upgrades where necessary.

These have high economy impact and must follow same audit model as economy and items.

---

### 8.8 Missions, Events & Content

**Namespace**: `/admin/api/v1/missions`, `/admin/api/v1/events`

- CRUD for mission templates and storylines (content_admin).
- Trigger one-off events, seasonal campaigns.
- View player progress in specific missions/events.
- Rerun rewards for select cohorts if a bug occurred.

Content APIs must integrate with the core mission/event engine while never bypassing mission integrity checks.

---

### 8.9 Moderation & Reports

**Namespace**: `/admin/api/v1/moderation`, `/admin/api/v1/reports`

- View player reports (chat, mail, profiles, factions, etc.).
- Process a report: mark as resolved, action taken, notes.
- Apply punishments (mute, temp ban, warnings).
- Link report actions to the audit trail.

---

### 8.10 System Tools, Health & Maintenance

**Namespace**: `/admin/api/v1/system`

- `GET /admin/api/v1/system/health`  
  - Internal health summary (DB, cache, queues, disk, etc.)
  - Exposes only safe, non-secret metrics.

- `POST /admin/api/v1/system/cache/flush`  
  - Scoped flushes: e.g., items cache, config cache.
  - Superadmin only, with huge warnings.

- `GET /admin/api/v1/system/config`  
  - Read-only view of feature flags and tunables (with secrets redacted).

- `POST /admin/api/v1/system/config/feature_flags`  
  - Modify feature flags for canarying new features, always with logging.

DevOps-specific functions are further detailed in `DevOps_Guide.md`.

---

## 9. Security Requirements (Summary)

Full details live in `Security_Spec.md`. Admin API must comply with:

1. **Strict Transport Security**  
   - HTTPS only.
   - HSTS for admin domains.

2. **CSRF & session hardening**  
   - CSRF tokens for cookie-based admin flows.
   - `SameSite`, `HttpOnly`, `Secure` cookie flags.
   - Short session lifetime with idle timeout.

3. **Input validation & output encoding**  
   - All request bodies validated server-side.
   - No user-supplied HTML passed through without sanitization.

4. **Permission checks everywhere**  
   - Every endpoint checks roles and permissions.
   - UI **must not** be the only layer.

5. **No debug endpoints in production**  
   - No `/admin/api/v1/debug/...` without strict, separate controls.
   - Any debug-like tool is superadmin-only and behind extra confirmation.

6. **Secrets never exposed**  
   - No API returns credentials, access tokens, or internal secrets.

7. **Soft delete over hard delete**  
   - Admin API should prefer soft delete / archival for evidentiary purposes.

---

## 10. Testing, QA & Change Management

Admin API changes are **high-risk** and must follow strict process:

1. **Spec first**  
   - Update `API_Admin.md` + `OpenAPI_Spec.md` before implementation.
   - Get approval from Architect / Security.

2. **Implementation**  
   - Use shared API layer in codebase.
   - Reuse services (`UserService`, `EconomyService`, `InventoryService`, etc.)—no direct SQL hacks.

3. **Automated tests**  
   - Unit tests for services.
   - Integration tests for endpoints (positive, negative, permission boundaries).

4. **Manual QA**  
   - Dedicated workflow tests:
     - Ban/unban round trip
     - Currency adjustment with logs
     - Item grant + verify in player inventory
     - Feature flag toggling
   - Confirm audit logs and rate limits work as expected.

5. **Rollout**  
   - Deployed to staging first.
   - Usage monitored on production via logs/metrics.
   - Documented in change log.

---

## 11. Extensibility & Future Versions

Future admin-specific API documents:

- `API_Events.md` — details for runtime event orchestration and analytics.
- `API_Director.md` — high-level orchestration for game-wide changes (e.g., global events).
- `API_Mobile.md` — subset for ops mobile tools (lite admin features).
- `API_AdvancedSystems.md` — specialized systems (Black Ops, raids, territory control).

Rules for adding new Admin API endpoints:

1. Check if they belong in Admin API vs. regular game APIs.
2. Define them here (or in a specialized admin doc) first.
3. Update OpenAPI spec.
4. Implement, test, log, and monitor.

---

## 12. Quick Reference Checklist (for Workers)

When a worker (Architect or CodeGPT) needs to **add or modify Admin API endpoints**, they MUST:

1. Verify the endpoint path is under `/admin/api/v1/`.
2. Attach it to the correct **namespace** (users, economy, items, factions, etc.).
3. Declare required **roles** and **permissions** explicitly.
4. Use the standard **request/response envelopes**.
5. Integrate with existing **services** (no raw DB access if a service exists).
6. Add or update **audit logging** where needed.
7. Align with `Security_Spec.md` (auth, rate limits, CSRF, etc.).
8. Update `OpenAPI_Spec.md` with full schema.
9. Ensure there are **automated tests** for both success and failure paths.
10. Confirm no sensitive data is exposed unintentionally.

This checklist is binding as part of `Global_Pack_V3.md` and overrides any older documents.

---


---

## === SECTION B: ADVANCED EXPANSION (V2) ===

# API_Admin.md — Ultra Expanded Edition (V2)

## NOTE
This version adds:
- Full endpoint blueprint structures
- Threat models per API family
- Audit event taxonomy
- Admin workflow maps (text‑based)
- Monitoring + alerting spec
- Full permission matrix template

## 1. Admin API Purpose & Architecture
The Admin API is the authoritative internal control surface. It exposes privileged operations with strict guarantees around:
- correctness,
- traceability,
- access control,
- forensic recoverability.

Its architecture mandates three enforcement layers:
1. Network boundary controls (VPN, IP allowlists)
2. Authentication + MFA + hardened sessions/tokens
3. Application‑level authorization + audit logging

## 2. Permission Matrix Template
A central matrix defines which role may invoke which action category.

| Category | moderator | support | admin | economy_admin | content_admin | superadmin |
|---------|-----------|---------|-------|---------------|----------------|------------|
| View users | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Edit user flags | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Ban users | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Adjust wallets | ✗ | ✗ | ✗ | ✓ | ✗ | ✓ |
| Create/update items | ✗ | ✗ | ✓ | ✓ | ✓ | ✓ |
| Delete items | ✗ | ✗ | ✗ | ✓ | ✓ | ✓ |
| System maintenance | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |

This table is expanded fully in the Security_Spec and ties into OpenAPI via the permission tag.

## 3. Threat Model Overview
For each API namespace, the threat vectors include:
- **Privilege escalation**: attempting to perform actions above role.
- **Mass‑impact actions**: bans, currency edits, bulk item grants.
- **Tampering**: manipulating audit trails or before/after snapshots.
- **Replay attacks**: reuse of stale tokens or requests.
- **Forged admin identity**: attacking headers, cookies, or bypass paths.
- **Misconfigured rate limits** allowing brute force.

Each endpoint family below now includes its dedicated threat model.

## 4. Endpoint Specification Blueprint Format
All endpoints must follow this pattern in OpenAPI_Spec.md:

```
Endpoint:
  path: /admin/api/v1/... 
  method: GET|POST|PATCH|DELETE
  summary: "Short description"
  description: "Long, technical explanation"
  permissions_required:
    - role: admin
    - permission: user.view
  rate_limit_class: admin_read|admin_write|admin_sensitive
  audit_event:
    type: USER_VIEW
    includes_before_after: false
  request_schema: {...}
  response_schema: {...}
  error_conditions:
    - USER_NOT_FOUND
    - PERMISSION_DENIED
    - VALIDATION_ERROR
  cache_invalidation:
    - none|user_profile|global_items
```

## 5. Audit Event Taxonomy
Admin actions fall under structured categories:

- **USER_ADMIN**: bans, mutes, notes, flag edits
- **ECONOMY_ADMIN**: wallet edits, market toggles
- **INVENTORY_ADMIN**: item grants/removals
- **CONTENT_ADMIN**: mission edits, event triggers
- **ASSET_ADMIN**: property transfers, vehicle overrides
- **SECURITY_ADMIN**: role changes, token creation, system unlocks
- **SYSTEM_ADMIN**: cache flush, feature flag toggling

Every audit record must guarantee:
- immutability
- timestamp with microsecond precision
- correlation ID
- actor identity + actor role
- before/after representations when applicable

## 6. Monitoring & Alerting Spec
The Admin API exposes Prometheus‑style metrics (namespaced `admin_api_`). Examples:

- `admin_api_requests_total{endpoint=", method=", status="}`
- `admin_api_latency_ms_bucket{endpoint=""}`
- `admin_api_auth_failures_total`
- `admin_api_permission_denied_total`
- `admin_api_sensitive_actions_total`

**High‑risk alerts:**
- >5 failed admin logins in 1 minute from same IP
- More than N high‑impact actions/hour (custom threshold)
- Unexpected sequence anomalies detected via event correlation

## 7. Workflow Specifications
### 7.1 User Ban Workflow (Text Blueprint)
1. Moderator initiates ban request.
2. System validates permissions.
3. System loads user profile, verifies current state.
4. Writes audit event with BEFORE snapshot.
5. Applies ban record.
6. Writes audit event with AFTER snapshot.
7. Invalidates sessions.
8. Streams event to monitoring system.
9. Returns success payload.

### 7.2 Item Grant Workflow
1. Admin selects user + item.
2. System validates grantability rules.
3. BEFORE inventory snapshot collected.
4. Item granted through InventoryService.
5. AFTER inventory snapshot recorded.
6. Audit event logged.
7. Notification hooks triggered.

## 8. Namespace Threat Models (Short Form)
### /users
- Risk: targeted harassment via repeated bans
- Risk: privilege escalation attempts
- Protection: per‑admin throttles, evidence linking

### /economy
- Risk: currency injection attacks
- Risk: laundering via admin tools
- Protection: double‑confirm workflow, reason codes

### /items
- Risk: mass item inflation
- Protection: max thresholds, mandatory audit snapshots

### /system
- Risk: shutdowns, cache wipes
- Protection: superadmin‑only, MFA required, multi‑step

## END OF V2 EXPANSION


---

## END OF FINAL MERGED SPEC
# API_AdvancedSystems.md — Trench City Advanced Systems API Specification (V1-EXPANDED)

**Status:** Authoritative design document for *all* high-complexity, multi-entity, multi-phase systems.
**Audience:** Architect, CodeGPT, Balance/Systems, Security, DevOps, Admin tooling.

This file defines how the **Advanced Systems Layer** of Trench City exposes and governs API access for:

- Ranked Wars
- Chains (Chain Engine v2)
- Territory Control & Turf Warfare
- Raids
- Black Ops
- Background Simulation Layer (BSL) & Global Progression Drivers
- Cross-system orchestration and director-level controls

It is tightly coupled to:

- `API_Admin_FINAL.md`
- `OpenAPI_Spec.md`
- `Security_Spec.md`
- `Global_Pack_V3.md`
- Factions & Combat design docs in the Master Bible

---

## 1. Purpose & Core Design Rules

Advanced systems differ from “simple” CRUD-style modules because they:

- Span **multiple users / factions / locations** at once
- Have **time-based state machines** (timers, grace windows, decay curves)
- Have **global side effects** (economy impact, leaderboards, prestige)
- Are **high-value exploit targets** (rewards, rankings, rare items, territory bonuses)
- Need strong **forensic visibility** for disputes and anti-cheat

Therefore, the Advanced Systems API must:

1. Be **deterministic and replayable** (battle logs, war logs, raid event logs).
2. Be **heavily permissioned** (only correct roles/systems can trigger advanced operations).
3. Use **explicit state transitions**, not ad-hoc flags.
4. Provide **rich telemetry** and **balancing metrics** to the Balance/Analytics teams.
5. Integrate with the **Background Simulation Layer (BSL)** without race conditions.

---

## 2. Systems Overview

### 2.1 Ranked Wars Engine

Ranked wars are structured faction-vs-faction conflicts that:

- Have a **start time, end time, and optional pre-war prep window**
- Track **objectives** (total respect, territory captures, raid successes, chain milestones)
- Award **rank points, rewards, titles, cosmetics** at completion
- Feed global leaderboards and seasonal systems

API Responsibilities:

- War creation, scheduling, and matching (admin / director level)
- Joining / withdrawing (system-run; factions cannot opt out mid-war except with penalties)
- State transitions: scheduled → active → grace → resolved → archived
- Result computation and persistence
- Exposure of safe read-only stats for clients

### 2.2 Chain Engine v2

Chains model **consecutive attacks** by a faction within a decay window.

- Track **combo counts**, **combo tiers**, **decay timers**, **chain-breaking events**
- Impacts faction bonuses, rewards, long-term stats
- Tightly coupled with combat logs and anti-cheat

API Responsibilities:

- Start/stop chain sessions (system-driven)
- Register valid attacks to chain state
- Apply decay and break logic
- Expose chain status to API clients

### 2.3 Territory Control

Trench City features **territories / tiles / regions** that:

- Are owned by factions
- Provide bonuses (income, item drop bonuses, training modifiers, etc.)
- Can be **contested** via wars, raids, or scheduled events
- May have **heat** / **stability** scores that affect difficulty and reward

API Responsibilities:

- Territory ownership CRUD (system/admin-only)
- Contest and conflict flows (challenges, wars, raids)
- Bonus calculation and propagation to other modules
- Exposure of safe map and bonus information to players

### 2.4 Raids

Raids are **multi-phase, high-stakes operations** by factions on targets (other factions, system entities, bosses).

- Have **preparation**, **assault**, **resolution**, and **cooldown** phases
- May involve **multiple participants** and **multi-wave combats**
- Provide **rare rewards** and **major faction prestige**

API Responsibilities:

- Raid creation, validation, and scheduling
- State machine handling and timers
- Participant management (joins/leaves, minimum requirements)
- Reward distribution and rollback-safe logging

### 2.5 Black Ops

Black Ops are **covert, limited-visibility missions**:

- Often **hidden from general logs**, only surfaced in special admin/ops UIs
- Have **enhanced secrecy** and **strict access rules**
- Can alter territory, economy, or faction states indirectly

API Responsibilities:

- Mission configuration and templates
- Sealed logs with limited readers
- Clearance-based access control
- Secure event streaming to the BSL and analytics

### 2.6 Background Simulation Layer (BSL)

The BSL is the **global “director”**:

- Adjusts spawn rates, event frequencies, mission offers
- Responds to world conditions (e.g., too much cash in economy → tighter rewards)
- Schedules and scales advanced events (wars, raids, global events)

API Responsibilities:

- Expose world state snapshots to internal tools
- Provide control switches (difficulty tuning, event injection)
- Handle safe read APIs for analytics

---

## 3. Shared Concepts & Data Models

All advanced systems share certain primitives:

- **IDs**: `advanced_system_id`, `war_id`, `raid_id`, `chain_id`, `territory_id`, etc.
- **Time**: start/end timestamps, grace windows, tick intervals, soft and hard deadlines.
- **States**: enumerated lifecycles per system with allowed transitions only.
- **Locks**: concurrency control for multi-actor actions (especially for war/raid resolution).
- **Scores & Rewards**: computed values that may be used by leaderboards, missions, or economy.

### 3.1 Common Fields

Most advanced entities share these attributes (names may vary per schema):

- `id` — primary identifier
- `type` — system type enum
- `owner_faction_id` / `attacker_faction_id` / `defender_faction_id`
- `status` — lifecycle state enum
- `created_at`, `updated_at`
- `starts_at`, `ends_at`
- `config` — structured JSON for system parameters
- `metrics` — structured JSON for results and counters
- `flags` — bitfield or JSON for special conditions (experimental, seasonal, test, etc.)

### 3.2 State Machines (High-Level)

Each system has a **finite state machine** (FSM). Example:

- Ranked War: `SCHEDULED → ACTIVE → GRACE → RESOLVED → ARCHIVED`
- Raid: `PLANNING → LIVE → RESOLUTION → COOLDOWN → ARCHIVED`
- Chain: `IDLE → ACTIVE → BROKEN → COOLDOWN`
- Territory: `OWNED → CONTESTED → OWNERSHIP_PENDING → OWNED` (new owner)

Transition rules must be:

- Explicitly defined
- Enforced in a single **state transition layer**
- Logged for forensic reconstruction

---

## 4. Namespaces & URL Map

Advanced Systems APIs are grouped under:

- Player/game-facing: `/api/v1/advanced/...`
- Admin/staff-facing: `/admin/api/v1/advanced/...`
- System/BG tools: `/internal/api/v1/advanced/...` (not player-accessible)

### 4.1 Core Namespaces

- `/advanced/ranked-wars`
- `/advanced/chains`
- `/advanced/territories`
- `/advanced/raids`
- `/advanced/black-ops`
- `/advanced/director` (BSL control & snapshots)

Each namespace has:

- **Read endpoints** — safe for clients (properly filtered)
- **Action endpoints** — invoked by game actions or staff tools
- **System endpoints** — invoked by scheduled jobs, background workers, or director

---

## 5. Endpoint Families (Blueprint Level, Full Detail Lives in OpenAPI_Spec)

> NOTE: This section describes what **must exist** and how it behaves. Exact request/response schemas, error codes, and pagination rules live in `OpenAPI_Spec.md`.

### 5.1 Ranked Wars

**Player/Game-Facing (Read-only):**

- `GET /api/v1/advanced/ranked-wars`  
  - List active + recent wars visible to player.
- `GET /api/v1/advanced/ranked-wars/{war_id}`  
  - Detailed war snapshot, scoped to player’s faction and visibility rules.
- `GET /api/v1/advanced/ranked-wars/{war_id}/timeline`  
  - Public-safe event log: captures, major swings, milestones.

**Admin / Director:**

- `POST /admin/api/v1/advanced/ranked-wars`  
  - Create/schedule a ranked war.
- `PATCH /admin/api/v1/advanced/ranked-wars/{war_id}`  
  - Edit parameters (before activation only).
- `POST /admin/api/v1/advanced/ranked-wars/{war_id}/force-resolve`  
  - Force resolution in case of stuck state with strict logging.
- `GET /admin/api/v1/advanced/ranked-wars/{war_id}/full-log`  
  - For investigations, returns full internal log (attacks, events, calculations).

**System/Internal:**

- `POST /internal/api/v1/advanced/ranked-wars/tick`  
  - Tick handler for war progression.
- `POST /internal/api/v1/advanced/ranked-wars/{war_id}/compute-outcome`  
  - Run outcome computation job (idempotent).

#### Ranked Wars Threat Model (Summary)

- Exploit attempts:
  - Forging extra attacks / respect.
  - Forcing incorrect outcomes via API misuse.
  - Leaking hidden war data.
- Controls:
  - Only combat engine can register war-related attacks.
  - All outcome computations are deterministic and logged.
  - Admin “force-resolve” is superadmin-only with enhanced audit trail.

---

### 5.2 Chain Engine v2

**Player/Game-Facing (Read-only):**

- `GET /api/v1/advanced/chains/current`  
  - Current chain status for player’s faction.
- `GET /api/v1/advanced/chains/history`  
  - Recent chain sessions.

**System/Internal (Write):**

- `POST /internal/api/v1/advanced/chains/{faction_id}/register-attack`  
  - Called by combat engine when a **valid** attack occurs.
- `POST /internal/api/v1/advanced/chains/{faction_id}/tick`  
  - Applies decay, breaks chain when timer expires.

#### Chain Engine Threat Model (Summary)

- Exploit attempts:
  - Simulating fake attacks.
  - Manipulating timestamps to avoid decay.
- Controls:
  - Only validated combat engine may call `register-attack`.
  - Timestamps are server-side; client cannot supply them.
  - Decay logic centralized and pure, no per-client overrides.

---

### 5.3 Territory Control

**Player/Game-Facing:**

- `GET /api/v1/advanced/territories/map`  
  - Aggregated representation: who owns what, heat, bonuses.
- `GET /api/v1/advanced/territories/{territory_id}`  
  - Detailed info for a specific territory.

**Admin / Director:**

- `POST /admin/api/v1/advanced/territories/{territory_id}/assign-owner`  
  - Hard assignment, used only in emergencies.
- `POST /admin/api/v1/advanced/territories/{territory_id}/freeze`  
  - Prevent changes while investigating exploits.

**System/Internal:**

- `POST /internal/api/v1/advanced/territories/tick`  
  - Adjust heat/stability, apply passive changes.
- `POST /internal/api/v1/advanced/territories/{territory_id}/apply-conflict-result`  
  - Called by war/raid modules once results are final.

---

### 5.4 Raids

**Player/Game-Facing:**

- `GET /api/v1/advanced/raids`  
  - Upcoming and active raids relevant to player/faction.
- `GET /api/v1/advanced/raids/{raid_id}`  
  - Detailed raid view, scoped to participant role.

**Faction Actions (Game-Facing, Authenticated):**

- `POST /api/v1/advanced/raids/{raid_template_id}/initiate`  
  - Request to start a raid based on a template.
- `POST /api/v1/advanced/raids/{raid_id}/join`  
  - Join raid, checks min-stat requirements, cooldowns.
- `POST /api/v1/advanced/raids/{raid_id}/withdraw`  
  - Controlled leave, with penalties if too late in the flow.

**System/Internal:**

- `POST /internal/api/v1/advanced/raids/{raid_id}/start`  
  - Transition PLANNING → LIVE when conditions are met.
- `POST /internal/api/v1/advanced/raids/{raid_id}/tick`  
  - Wave progression, timers, event spawning.
- `POST /internal/api/v1/advanced/raids/{raid_id}/resolve`  
  - Compute final rewards, record outcomes, trigger director hooks.

---

### 5.5 Black Ops

**Visibility Rules:**

- Black Ops data is **never** exposed via normal player endpoints.
- Certain summary effects may leak (bonus shifts, mysterious events) without attribution.

**Admin / High-Clearance:**

- `GET /admin/api/v1/advanced/black-ops`  
  - List of operations with clearance filtering.
- `GET /admin/api/v1/advanced/black-ops/{op_id}`  
  - Full detail, including hidden parameters.
- `POST /admin/api/v1/advanced/black-ops`  
  - Create new op from template.
- `POST /admin/api/v1/advanced/black-ops/{op_id}/execute`  
  - Trigger execution; may also be fully automated by director.

**System/Internal:**

- `POST /internal/api/v1/advanced/black-ops/{op_id}/tick`  
  - Progression and resolution.

Threat and secrecy rules are stricter:

- Logs are partitioned and access-controlled.
- Some details only available through dedicated forensic tools.

---

### 5.6 Director & BSL

**Internal:**

- `GET /internal/api/v1/advanced/director/world-state`  
  - Returns world health metrics (economy heat, active conflicts, raid volume, etc.).
- `POST /internal/api/v1/advanced/director/decision`  
  - Records high-level decisions (e.g., spawn a new war season, start global raid week).
- `POST /internal/api/v1/advanced/director/apply-tuning`  
  - Adjusts tuning knobs (drop rates, reward multipliers) under strict policies.

**Admin / Analytics:**

- `GET /admin/api/v1/advanced/director/dashboard`  
  - Aggregated metrics for advanced systems at a glance.

---

## 6. Security & Anti-Exploit Considerations (Advanced Systems)

High-level rules (details in `Security_Spec.md`):

- **No direct client write access** to advanced state — all actions flow through validated subsystems.
- **All high-impact events** (war outcomes, raid resolution, territory transfers) are:
  - Idempotent
  - Logged with before/after snapshots
  - Protected by locks (no double resolution)
- **Advanced Systems** are prime exploit targets; changes must go through:
  - Code review
  - Staging validation
  - Telemetry checks post-deploy

---

## 7. Monitoring, Telemetry & Balancing

Each advanced system emits metrics, for example:

- `advanced_wars_active_total`
- `advanced_raids_active_total`
- `advanced_chain_length_current{faction_id=...}`
- `advanced_territories_owned{faction_id=...}`
- `advanced_blackops_executed_total`
- `advanced_director_decisions_total{type=...}`

Balancing & integrity metrics:

- Distribution of rewards vs. baseline expectations
- Average raid success rate per difficulty tier
- Territory churn rates
- War outcome fairness (no faction dominating purely from system bias)

Alerting rules (examples):

- No active advanced events over a long period (system dead)
- Too many outcomes in favor of a single faction beyond statistical expectation
- Excessive territory transfers in a short window

---

## 8. Worker Rules (Architect, CodeGPT, Balance, Security)

When any worker touches Advanced Systems APIs, they MUST:

1. Respect **state machines** — never manually flip flags.
2. Integrate through central **services and transition layers**.
3. Update **OpenAPI_Spec.md** alongside code changes.
4. Add or adjust **metrics** and **logs** when behavior changes.
5. Consult **Security_Spec.md** for role/permission and clearance rules.
6. Ensure **staging war-games** (simulated wars/raids) are possible for QA.
7. Keep Advanced Systems aligned with `Global_Pack_V3.md` meta-rules.

This document is binding for all advanced combat, faction, and director-related features.

---
# API_Chains.md — COMPLETE ULTRA EXPANDED EDITION


# API_Chains.md — Ultra Expansion BATCH 1
## Core Architecture, Chain Object Model, Lifecycle & XP Formula Framework

---

# 1. Chain Philosophy & System Goals

Chains are one of the most important competitive progression systems in Trench City.  
They create:
- **constant faction activity**
- **PvP engagement**
- **XP progression incentives**
- **war synergy**
- **territory conflict pressure**
- **momentum-based social gameplay**

Design principles:
- rewarding active factions
- preventing boosting/abuse
- making chain pacing feel exciting
- transparent, deterministic formulas
- fully Director-controlled progression levers

Chains must balance:
- daily activity loops
- long-term competitive pacing
- anti-exploit safety
- cross-system dependencies (Wars, Territories, Raids)

---

# 2. Canonical Chain Object (Deep Spec)

```
chain:
  chain_id: string
  faction_id: int

  state: idle | active | peak | decay | ended | archived

  current_hits: int
  max_hits: int

  xp_total: float
  xp_multiplier: float

  streak:
    count: int
    last_hit_at: timestamp
    decay_timer: timestamp

  timers:
    start_at: timestamp
    peak_at: timestamp
    decay_at: timestamp
    end_at: timestamp

  modifiers:
    event_modifiers: {...}
    director_modifiers: {...}
    war_modifiers: {...}
    territory_modifiers: {...}

  metadata:
    created_by: system/admin
    version: string
```

Chain is a *state machine* heavily influenced by:
- Director tuning  
- war effects  
- player hits  
- event bonuses  
- territory stability  

---

# 3. Chain Lifecycle (Deterministic)

```
idle → active → peak → decay → ended → archived
```

## 3.1 idle
Faction is not chaining.  
Starting conditions:
- faction not in cooldown  
- minimum members online  
- optional Director permission  

## 3.2 active
Chain has begun; kill hits count.

Characteristic behavior:
- exponential XP gains  
- early combo potential  
- Director may boost early pacing  

## 3.3 peak
Chain hit threshold reached:
```
if current_hits >= max_hits:
    state = peak
```

Peak XP multipliers active:
- combo_uncapped  
- domination multipliers  
- territory region bonus  
- event seasonal effects  

## 3.4 decay
Triggered when:
```
time_since_last_hit > decay_threshold
```

Decay effects:
- streak decreases  
- xp multiplier reduces  
- time window tightens  

## 3.5 ended
Conditions:
- decay reaches 0  
- chain time expired  
- Director ends season  
- faction disbands  

## 3.6 archived
Immutable chain record stored for:
- leaderboards  
- analytics  
- Director seasonal summaries  

---

# 4. Hit Rules (Master Logic)

A **valid chain hit** requires:
1. PvP kill (player vs player)
2. unique timestamp (no duplicate spam)
3. valid enemy (no same-faction hits)
4. xp > 0
5. no repeat-kill penalty breach
6. no boosting flags triggered
7. kill must be logged in combat ledger

Chain hit endpoint:
```
POST /internal/api/v1/chains/hit
```

Payload:
```
attacker_id
target_id
damage
kill_type
timestamp
signature
```

Validation:
- combat_id must exist  
- attacker not jailed/hospitalized  
- target not self/alt  
- hit cooldown enforced  

Cooldown example:
```
chain_hit_cooldown = 3 seconds
```

---

# 5. Chain XP Formula Framework

XP system is modular so Director can adjust global pacing.

XP components:
```
xp_gain =
  base_xp
  + streak_bonus
  + domination_bonus
  + war_bonus
  + event_bonus
  + territory_bonus
  + director_global_mod
```

---

## 5.1 Base XP
```
base_xp = sqrt(attacker_level + target_level) * 1.5
```

## 5.2 Streak Bonus
```
streak_bonus = streak_count * 0.25
```

## 5.3 Domination Bonus
Active during peak wars or chain momentum.

```
domination_bonus = 0.1 * (chain_hits / 50)
```

## 5.4 Event Bonus
Events modify XP globally:
```
event_bonus = base_xp * event_modifiers.chain_xp
```

## 5.5 Territory Bonus
```
territory_bonus = region_stability * 0.02
```

## 5.6 Director Global Mod
The Director may scale all chain XP:
```
xp_gain *= director_modifiers.global_chain_xp
```

---

# 6. Chain State Transitions (Deterministic)

```
if time_since_last_hit <= decay_threshold:
    stay in active/peak
else:
    transition → decay
```

```
if decay reaches 0:
    transition → ended
```

```
if chain archived:
    write to immutable ledger
```

---

# END OF BATCH 1



# API_Chains.md — Ultra Expansion BATCH 2
## Scoring Model, Multipliers, Combo Engine, Hit Types & Chain Events

---

# 1. Chain Scoring Model (Full Competitive Spec)

Chain scoring determines how much XP a faction earns per valid hit.  
The system must be:
- transparent  
- deterministic  
- anti-boost  
- scalable into late-game  

XP components:

```
xp =
  base_xp
  + hit_type_bonus
  + streak_multiplier
  + combo_multiplier
  + domination_multiplier
  + faction_multiplier
  + director_modifier
  + event_modifier
  + territory_modifier
```

---

# 2. Base XP Formula

```
base_xp = sqrt((attacker_level + target_level) / 2) * 1.75
```

Reasons:
- prevents alt-level abuse  
- rewards fair-level kills  
- creates smooth XP curve  

---

# 3. Hit Type Bonuses

Different hits provide different bonuses:

### 3.1 Standard Hit
```
hit_bonus = 1.0
```

### 3.2 Critical Hit (finisher)
Triggered if attacker drops target below 5% life.
```
hit_bonus = 1.25
```

### 3.3 Revenge Hit
Attacker kills someone who killed them recently:
```
hit_bonus = 1.5
```

### 3.4 Bounty Hit (target has bounty)
```
hit_bonus = 1.3
```

### 3.5 War Hit (during active war)
```
hit_bonus = 1.4
```

---

# 4. Streak Multiplier (Local Momentum)

Every consecutive valid hit increases streak:

```
streak_multiplier = 1 + (streak_count * 0.03)
```

Caps:
```
max_streak_multiplier = 2.0
```

Resets when:
- decay begins  
- time since last hit exceeds streak window  
- invalid hit detected  

---

# 5. Combo Engine (Faction Momentum)

A faction-level combo system adds depth to chain pacing.

### 5.1 Combo Window
```
combo_window = 45 seconds
```

If hits occur within this window:
```
combo_count += 1
combo_multiplier = 1 + (combo_count * 0.02)
```

### 5.2 Combo Decay
If no hit for:
```
> 45 seconds → combo_count -= 1
> 120 seconds → combo reset to 0
```

### 5.3 Combo Cap
```
max_combo_multiplier = 1.5
```

---

# 6. Domination Multiplier (Peak Chain Power)

When chain reaches PEAK state:

```
domination_multiplier = 1 + (current_hits / max_hits) * 0.1
```

Peak example:
```
500-hit chain → +10% XP
1000-hit chain → +20% XP
```

Director may override.

---

# 7. Faction-Wide Chain Bonuses

Faction upgrades may grant:
- +2% chain XP  
- faster decay timer  
- reduced streak loss  

Example:
```
faction_multiplier = 1.05 (from upgrades)
```

---

# 8. Director Modifier (Global Chain Scaling)

Director influences:
- pacing  
- economy balance  
- chain seasons  

```
xp *= director_modifiers.global_chain_xp
```

---

# 9. Event Modifiers

During chain events:
```
event_modifier = 1.10 → 1.50
```

Examples:
- Double XP hour  
- Chain Frenzy  
- Territory Storm  

---

# 10. Territory Modifier

Territory effects:
```
territory_modifier = region_stability * 0.03
```

Regions with high stability give higher xp.

---

# 11. Hit Types (Technical Specification)

All hit types must be logged with:

```
hit_id
attacker_id
target_id
hit_type
timestamp
xp_generated
signature
```

Hit types include:
- standard  
- critical  
- revenge  
- bounty  
- war_hit  
- peak_hit  
- streak_breaker  

---

# 12. Chain Events (Dynamic Triggers)

### 12.1 Milestone Events
Triggered at:
```
25 hits  
50 hits  
100 hits  
250 hits  
500 hits  
1000 hits  
```

Each milestone triggers:
- faction notification  
- small XP burst  
- optional reward  

### 12.2 Peak Burst
When chain enters PEAK:
```
grant temporary +10% XP for 3 minutes
```

### 12.3 Streak Surge
If a player reaches streak milestones:
```
10 → +2% chain XP for faction
25 → +5%
50 → +10%
```

### 12.4 Director-Triggered Chain Frenzy
Director may inject:
```
+25% XP for next 10 hits
```

### 12.5 Decay Warning Event
When decay timer reaches:
```
< 20 seconds
```
Mobile + faction chat receives urgent alert.

---

# 13. Internal Chain APIs (Batch 2 Additions)

### Submit Hit
`POST /internal/api/v1/chains/hit`

### Get Chain Multipliers
`GET /api/v1/chains/{chain_id}/multipliers`

### Get Chain Combo Info
`GET /api/v1/chains/{chain_id}/combo`

### Get Chain Events
`GET /api/v1/chains/{chain_id}/events`

---

# END OF BATCH 2



# API_Chains.md — Ultra Expansion BATCH 3
## Integration Layer: Wars, Territories, Raids, Events & Director Control

---

# 1. World Integration Philosophy

Chains do not exist in isolation.  
They are influenced by — and influence — every major competitive system:

- **Wars** (real-time faction combat)
- **Territories** (map control & regional bonuses)
- **Raids** (cooperative PvE faction assaults)
- **Events** (global modifiers)
- **Director** (dynamic world control AI)

This batch defines EXACTLY how chains interact with each system.

---

# 2. War Integration (Deep Link)

## 2.1 War Hits → Chain XP

During an active faction war:
```
war_hit_xp = base_xp * 1.15
xp += war_hit_xp
```

Rules:
- war hits count as chain hits
- chain hit validation still applied
- war-hit type recorded in ledger

## 2.2 Chain Momentum Modifies War Pressure

If faction enters PEAK chain during war:
```
war_pressure_bonus = +10% attack success rate
war_domination_modifier = +5% war score gain
```

## 2.3 Domination Feedback Loop

If faction dominates in war:
```
chain_domination_multiplier += 0.05
```

Director may cap this during war seasons.

---

# 3. Territory Integration (Map-Based Influence)

Territories create a geographic dimension to chains.

## 3.1 Chain Raises Regional Heat
Every valid hit:
```
region_heat[target_region] += 0.5
```

## 3.2 Region Heat Affects Territory Battles
When region heat passes thresholds:
```
> 50 → minor unrest
> 100 → stability drop
> 150 → territory contestability
> 200 → forced conflict event
```

## 3.3 Territory Bonuses → Chain XP
Regions provide bonuses:
```
territory_bonus = region.stability * 0.02
```

Regions with high faction control have:
- higher chain XP
- slower chain decay
- streak decay resistance

## 3.4 Territory-Based Chain Buffs
If faction controls region:
```
chain_decay_threshold += 10 seconds
streak_window += 5 seconds
```

---

# 4. Raid Integration (Faction PvE Synergy)

Raids produce buffs that directly modify chain performance.

## 4.1 Raid Morale Boost → Chain XP
If faction morale > 75%:
```
raid_chain_bonus = +10% chain XP
```

## 4.2 Raid Boss Defeated → Momentum Burst
```
chain_combo_multiplier += 0.1 (for 10 minutes)
```

## 4.3 Raid Season Effects
During raid seasons:
```
raid_season_bonus = +5% chain XP
```

## 4.4 Chain Streak Boosts Raid Efficiency
Large streak milestones:
```
streak >= 25 → raid_morale += 5
streak >= 50 → raid_damage += 3%
```

---

# 5. Event Integration (Dynamic World Modifiers)

Events change chain pacing across the entire game.

## 5.1 Global Chain XP Boosts
Example:
```
x2 XP Event → event_modifier = 2.0
```

## 5.2 Chain Frenzy (Special Event Type)
During Chain Frenzy:
- decay timer paused
- streak cannot fall below half
- +15% XP bonus
- +25% combo window

## 5.3 Region Storm Events
Affect territory-linked chain bonuses:
```
region_stability = 0 for duration → no territory bonus
```

## 5.4 Limited-Time Hit Types
Events may add:
- elemental hits  
- critical surge hits  
- bounty storm hits  

Hit types integrate with scoring model in Batch 2.

---

# 6. Director Integration (Master Control Layer)

The Director adjusts chain rules dynamically based on world conditions.

## 6.1 Director Adjusts Decay
If game pacing is too slow:
```
decay_threshold += 20 seconds
```

If chaining too easily:
```
decay_threshold -= 15 seconds
```

## 6.2 Director Sets Seasonal XP Soft Caps
To control inflation:
```
if xp_total > season_softcap:
    xp_gain *= 0.8
```

## 6.3 Director Creates Chain Seasons
Each season defines:
- XP multipliers
- new hit types
- streak rules
- decay curve

## 6.4 Director Overrides Bonuses
Director may impose:
```
director_modifiers.global_chain_xp = 0.85 (to slow economy)
director_modifiers.chain_decay_speed = 1.2x
```

## 6.5 Director-Triggered Chain Events
Director may inject:
- Chain Frenzy  
- Double XP hour  
- Surge hits  
- Regional chain storms  

---

# 7. World Interaction Flow (Full Diagram)

```
Player Hit
   ↓
Combat Ledger
   ↓
Validate Hit
   ↓
Chain Engine
   → XP Formula
   → Combo Engine
   → Streak Engine
   → Chain Events
   ↓
World Integration Layer
   → War System
   → Territory Heat
   → Raid Morale
   → Event Modifiers
   ↓
Director
   ↳ Adjust multipliers
   ↳ Adjust decay
   ↳ Seasonal rules
```

---

# END OF BATCH 3



# API_Chains.md — Ultra Expansion BATCH 4
## Security, Threat Matrix, Integrity Layer, Telemetry, Ledger v2 & Worker Laws

---

# 1. Chain Security Model (High-Value Competitive Surface)

Chains are a **primary PvP progression system**, used to generate:
- XP
- rewards
- faction rankings
- world pressure (heat, raids, territories, events)

This makes the Chain Engine a **top-tier exploit target**.  
Security goals:

- prevent boosting/farming
- prevent fake hits
- enforce combat ledger integrity
- protect streaks/combos from tampering
- allow forensic reconstruction
- feed Director anomaly signals

---

# 2. Chain Threat Matrix

```
Threat                            | Description
----------------------------------|----------------------------------------------
Alt Farming / Feeder Accounts     | Killing owned alts to farm XP/hits
Repeat-Kill Boosting              | Repeatedly killing same target
Duel-Only Boosting                | Two players taking turns to farm
Score Forgery                     | Attempting to submit fake XP values
Hit Replay Attacks                | Reusing signed hit payloads
Combat Log Forgery                | Fake combat entries not in ledger
Timestamp Manipulation            | Faking hit timing to bypass decay
Hit Source Spoofing               | Faking attacker/target identity
Streak/Combo Tampering            | Client-side manipulation of streak counters
Ledger Tampering                  | Removing or modifying hits in history
Director Signal Corruption        | Misleading world_state to adjust tuning
Emulator/Bot Hit Automation       | Non-human chain hit generation
```

Attack surface is highest during:
- chain peak
- XP events
- war-linked chains
- territory conflict periods

---

# 3. Chain Integrity Layer

Every chain hit must pass a **multi-stage validation pipeline**.

### 3.1 Required Hit Payload

```
{
  "attacker_id": int,
  "target_id": int,
  "combat_id": string,
  "hit_type": string,
  "timestamp": int,
  "nonce": string,
  "signature": string
}
```

### 3.2 Validation Steps

1. **Signature Check**  
   - `signature = HMAC256(payload + timestamp + nonce)`  
   - bound to `device_id` + `session_id`

2. **Nonce Check**  
   - nonce must not be reused for 10 minutes  
   - stored in recent_nonce_cache

3. **Timestamp Check**  
   - skew ≤ 6 seconds  
   - must be >= last_combat_event for that combat session

4. **Combat Ledger Check**  
   - `combat_id` must exist  
   - ledger must include final blow from attacker to target  
   - target must be set to `downed` in combat state

5. **Faction & State Checks**  
   - attacker and target must be opposing factions  
   - attacker must not be hospitalized/jailed  
   - target must not be already dead before timestamp

6. **Cooldown & Repeat Checks**  
   - respect chain_hit_cooldown  
   - enforce repeat-kill limits (see below)

If any check fails:
- hit rejected  
- security anomaly recorded  
- optional auto-flag for SecurityGPT review  

---

# 4. Anti-Boosting & Repeat-Kill Controls

### 4.1 Repeat-Kill Penalty

For each attacker→target pair:

```
repeat_count = hits(attacker, target, within_window=30 minutes)

repeat_penalty_factor = max(0.1, 1.0 - 0.25 * (repeat_count - 1))
xp *= repeat_penalty_factor
```

If `repeat_count` exceeds threshold:
- XP = 0  
- hit still logged for monitoring  
- boosting_flag += weight  

### 4.2 Alt-Farming Detection

Signals:
- shared IP/device between attacker and target  
- same owner account cluster  
- repeated hits only on limited set of targets  
- low damage but consistent kills  
- time-clustered hit patterns  

If alt-farming confidence above threshold:
- chain XP dampened  
- Director flagged  
- SecurityGPT receives incident  
- optional faction penalty (temporary chain XP reduction)

### 4.3 Duel-Only Boosting

Pattern:
- two players trading kills back-and-forth  
- extremely low diversity of targets  
- predictable time symmetry  

Mitigation:
- XP clamp beyond N hits per attacker-target pair per day  
- bonus heavily reduced for repeated mutual kills  

---

# 5. Replay Protection & Monotonicity

Replay guard:

```
if nonce_seen_before: reject
if timestamp < last_hit_timestamp_for_attacker: reject
```

Every hit updates:
- `last_hit_timestamp_for_attacker`
- `attacker_hit_nonce_cache`

This guarantees monotonic time-flow per player.

---

# 6. Streak & Combo Integrity

Streaks and combos are **server-owned** values.

Clients:
- may display predicted streak/combos
- cannot submit streak/combos directly

Server:
- recalculates from hit stream
- maintains deterministic streak/combo from ledger

If discrepancy between:
- live streak/combo
- reconstructed streak/combo from ledger

→ Chain enters **integrity recheck mode**:
- freeze new streak-based bonuses
- recalc from ledger
- emit anomaly metric

---

# 7. Chain Telemetry & Anomaly Metrics

Metrics (Prometheus style):

```
chain_hits_total{source}
chain_hits_rejected_total{reason}
chain_xp_total
chain_xp_anomalies_total
chain_repeat_kill_flags_total
chain_alt_farm_flags_total
chain_combo_anomalies_total
chain_streak_anomalies_total
chain_integrity_failures_total
```

Used by:
- Director (for tuning decisions)
- SecurityGPT (for threat analysis)
- BalanceGPT (for XP curve monitoring)
- Admin dashboards

---

# 8. Immutable Chain Ledger v2

Each hit produces an entry:

```
ledger_entry:
  id
  chain_id
  faction_id
  attacker_id
  target_id
  hit_type
  xp_gained
  streak_value
  combo_value
  timestamp
  world_state_hash
  director_mod_snapshot
  previous_hash
  hash
  signature
```

Properties:
- append-only
- hash-chained
- cryptographically signed
- fully replayable

Supports:
- chain replay
- boosting investigations
- seasonal summary generation
- Director world_state validation

---

# 9. Worker Laws (Binding for Chain Engine)

## 9.1 ArchitectGPT
- Owns chain architecture & evolution
- Approves major changes to XP formulas
- Designs new streak/combo models
- Validates integration rules with Wars / Territories / Raids / Events / Director

## 9.2 CodeGPT
- Implements hit validation pipeline
- Enforces signature, nonce, timestamp checks
- Maintains deterministic streak/combo computations
- Integrates ledger writes atomically

## 9.3 BalanceGPT
- Adjusts XP weights, multipliers, caps
- Tunes repeat-kill penalties & thresholds
- Designs seasonal XP curves
- Evaluates long-term inflation or stagnation

## 9.4 SecurityGPT
- Monitors alt-farming & boosting metrics
- Reviews flagged chains & factions
- Approves new security rules
- Manages quarantine/penalty recommendations

## 9.5 AdminGPT
- Can void chains under extreme abuse
- Can freeze chain progression temporarily
- Cannot modify ledger records
- Cannot directly change XP formulas without Architect approval

---

# 10. Versioning & Rollback Model (Chain Engine)

Chain behavior is versioned:

```
chain_engine_version:
  xp_formula_version
  streak_model_version
  combo_model_version
  decay_model_version
  repeat_penalty_version
```

### 10.1 Major Changes
- new XP formula
- new streak/decay curve
- new integration rules

Require:
- migration plan
- impact assessment
- ArchitectGPT approval

### 10.2 Minor Changes
- tuning multipliers
- cap adjustments

Require:
- BalanceGPT review

### 10.3 Patch-Level Changes
- bug fixes
- minor exploit fixes

Rollback allowed when:
- no active chains
- ledger validated
- Director confirms world_state compatibility

---

# END OF BATCH 4



# END OF CHAINS FULL SPEC
# API_Director.md — COMPLETE ULTRA EXPANDED EDITION


# API_Director.md — Ultra Expansion BATCH 1
## Director Core Architecture & Simulation Foundations

---

## 1. Director Philosophy

The Director is the *world brain* governing global pacing, fairness, challenge, and long‑term economy stability.  
Guiding principles:

- **Determinism:** Same inputs → same outputs.
- **Stability:** Prevent runaway inflation, runaway faction dominance.
- **Responsiveness:** Detect anomalies quickly and counteract them.
- **Narrative Arc:** Seasons feel meaningful and directed.
- **Safety:** In crisis, Director enters Safe Mode (defined in later batches).

---

## 2. Layered Architecture (Deep Version)

### 2.1 Policy Layer
Defines high‑level rules:

- Target inflation range  
- Target faction power balance  
- Expected raid/win rate  
- Territory churn ideal value  
- Seasonal objectives  

**Inputs:**  
- Metrics from Advanced Systems  
- Economy models  
- Player population activity  
- Seasonal script  

**Outputs:**  
- Desired world adjustments (“intents”)

---

### 2.2 Execution Layer
Responsible for applying changes:

- Scheduling events  
- Applying tuning changes  
- Initiating war cycles  
- Triggering global raids  
- Enforcing season boundaries  

Executes **intents → actions**, logged in the Director Ledger.

---

### 2.3 Observation Layer
Collects metrics & world signals:

- Login waves  
- Cash sinks & faucets  
- Raid difficulty curve  
- War fairness index  
- Territory stability vector  
- Item rarity drift  

Observation layer produces the `world_state_delta` structure used by the Policy Model.

---

## 3. Canonical World-State Object (Deep Structure)

```
world_state:
  season:
    id
    phase
    start_at
    end_at
    global_modifiers: {...}

  economy:
    inflation_index
    faucet_rate
    sink_rate
    blackmarket_pressure
    item_rarity_drift
    anomaly_flags: [...]

  conflict_pressure:
    war_density
    raid_activity
    chain_saturation
    faction_power_spread
    dominance_alerts: [...]

  territory:
    churn_rate
    stability_index
    contested_zones
    heat_map: {...}

  population:
    login_curve
    concurrency
    retention_curve
    new_player_pressure

  tuning:
    xp_multiplier
    drop_rate_multiplier
    raid_strength_mod
    war_scaling_mod
    territory_bonus_mod

  alerts:
    - type
    - severity
    - message
    - detected_at
```

Later batches will add formulas and thresholds.

---

## 4. Director Tick Cycle (Full Specification)

Director runs a **tick** every X seconds (configurable):

### Step 1 — Sample Metrics
Gather metrics from:
- Economy subsystem
- Advanced Systems (wars, raids, chains, territories)
- Login/population model
- Loot generator
- Market activity

### Step 2 — Compute world_state_delta
Compare `current` vs `expected` based on:
- Seasonal targets  
- Stability requirements  
- Historical trends  

### Step 3 — Evaluate Policy Rules
Feed deltas into policy model:
```
intent = policy_model(world_state_delta)
```

### Step 4 — Execute Intents
Translate into actions:
- schedule_event  
- apply_tuning  
- director_decision  

### Step 5 — Log
Write immutable entry:
- before snapshot  
- after snapshot  
- deltas  
- alternatives considered  

### Step 6 — Broadcast
Notify:
- Advanced Systems  
- Analytics  
- Admin dashboards  

---

## 5. High-Level Director Endpoints (Blueprint Only)

### Player-Facing
`GET /api/v1/director/world-state`
- Restricted summary: season, global bonuses, active events.

### Admin-Facing
`GET /admin/api/v1/director/dashboard`
- Raw metrics, alerts, tuning history, pending intents.

`GET /admin/api/v1/director/logs`
- Chronological decision ledger.

### Internal (Core)
`POST /internal/api/v1/director/decision`
- Apply a decision generated by policy model.

`POST /internal/api/v1/director/apply-tuning`
- Adjust world tuning values (validated ranges).

`POST /internal/api/v1/director/schedule-event`
- Insert a global/seasonal event into future queue.

More endpoints added in later batches.

---

## END OF BATCH 1



# API_Director.md — Ultra Expansion BATCH 2
## Tuning Dictionary & Decision Engine Model

---

# 1. Global Tuning Dictionary (FULL SPECIFICATION)

The Director controls **all world-level tuning parameters**.  
Every value is validated, bounded, logged, reversible, and versioned.

---

## 1.1 Economy Tuning

```
tuning.economy:
  drop_rate_multiplier:        float   # 0.1–5.0
  cash_faucet_multiplier:      float   # 0.1–3.0
  cash_sink_multiplier:        float   # 0.5–10.0
  inflation_target:            float   # 0.0–1.0 (ideal inflation range)
  blackmarket_pressure_mod:    float   # 0.0–3.0
  item_rarity_drift_mod:       float   # -1.0–1.0
```

Effects:
- Drop rate multiplier influences loot tables.
- Faucet/sink multipliers affect economy pacing.
- Inflation target feeds auto-corrective cycles.

---

## 1.2 Combat Tuning

```
tuning.combat:
  xp_multiplier:               float   # 0.1–5.0
  damage_scaling_mod:          float   # 0.5–2.0
  defense_decay_rate:          float   # 0.0–0.2
  regen_rate_mod:              float   # 0.5–3.0
```

Effects:
- Influences battle outcomes, player progression speed.

---

## 1.3 Raid & Warfare Tuning

```
tuning.raid:
  wave_strength_mod:           float   # 0.5–3.0
  reward_multiplier:           float   # 0.5–5.0
  spawn_frequency_mod:         float   # 0.1–2.0
  boss_frequency_mod:          float   # 0.0–1.0

tuning.war:
  war_density_target:          float   # 0.0–1.0
  war_scaling_mod:             float   # 0.5–3.0
  grace_window_mod:            float   # 0.5–2.0
```

---

## 1.4 Territory Control Tuning

```
tuning.territory:
  heat_growth_rate:            float   # 0.1–5.0
  heat_decay_rate:             float   # 0.1–5.0
  churn_target:                float   # 0.0–1.0
  stability_effect_mod:        float   # 0.5–3.0
```

---

## 1.5 Population Tuning

```
tuning.population:
  login_wave_weight:           float   # 0.0–10.0
  concurrency_target:          int     # 100–100000
  new_player_pressure_mod:     float   # 0.1–5.0
```

---

# 2. Validity Rules

Each parameter has:
- Allowed range
- Default value
- Rollback-on-error behavior
- Safe Mode fallback value
- Impact description
- Cooldown period between changes

Example validation:

```
if value < min or value > max:
    reject
if abs(value - previous_value) > threshold:
    require_superadmin
```

---

# 3. Decision Engine Architecture

The Director makes decisions using a **weighted evaluation model**.

```
decision = Σ(weight_i * signal_i * modifier_i)
```

Where:
- `weight_i` = importance of metric  
- `signal_i` = normalized metric input  
- `modifier_i` = seasonal, emergency, or anomaly modifier  

---

## 3.1 Signal Normalization

Every metric becomes 0–1:

```
normalized = (value - ideal_min) / (ideal_max - ideal_min)
clamped = min(max(normalized, 0),1)
```

Example:
- Raid success rate = 0.85 → too high → lower difficulty

---

## 3.2 Intent Model

The Director produces an **intent** before executing actions:

```
intent:
  target: economy | raids | wars | territories | population
  action: increase | decrease | stabilize | trigger_event
  magnitude: float
  confidence: 0.0–1.0
```

Example:

```
intent = {
  target: "raids",
  action: "increase_difficulty",
  magnitude: 0.15,
  confidence: 0.82
}
```

---

# 4. Decision Confidence Scoring

Confidence is derived from:
- Historical consistency
- Metric reliability
- Severity of anomaly
- Seasonal phase

Formula:

```
confidence = (input_consistency * weight_avg * recency_factor)
```

Thresholds:
- <0.4 → no action
- 0.4–0.7 → mild tuning
- 0.7–0.9 → strong tuning
- >0.9 → emergency action

---

# 5. Alternatives Consideration Model

Before acting, the Director evaluates alternatives:

```
alternatives = [
  {action:"increase", magnitude:0.1},
  {action:"increase", magnitude:0.2},
  {action:"decrease", magnitude:0.1},
  {action:"do_nothing"}
]
```

Each alternative receives:
- Score  
- Pros/cons  
- Stability impact  

Stored in logs.

---

# 6. Director Logs (Version 2)

Every decision entry now contains:

```
{
  decision_id,
  timestamp,
  actor: "director_internal",
  input_snapshot: {...},
  normalized_signals: {...},
  weighted_values: {...},
  alternatives_considered: [...],
  chosen_intent: {...},
  applied_actions: [...],
  before_world_state: {...},
  after_world_state: {...},
  confidence_score: 0.0–1.0,
  safe_mode_triggered: bool
}
```

Logs are:
- Immutable
- Append-only
- Checksum chained
- Queried by admin endpoint

---

# 7. Tuning Cooldown & Drift Control

To prevent instability:

- Minimum cooldown between tuning changes: **5 minutes**
- Max magnitude per adjustment: **20%**
- Drift control:
  ```
  if tuning deviates too far from default:
      gradually revert toward baseline
  ```

---

# 8. Safe Mode (Preview)

If:
- inflation too high  
- war density too low  
- raids failing too often  
- territory churn collapsing  

Director enters Safe Mode:
- Freezes advanced activity
- Resets unsafe parameters
- Requires admin review

Safe Mode is fully defined in Batch 3.

---

## END OF BATCH 2



# API_Director.md — Ultra Expansion BATCH 3
## Global Event Engine, System Integration & Emergency Protocols

---

# 1. Global Event Engine (GEE)

The **Global Event Engine** is the Director's capability to create, manage, escalate, and resolve world-level events that shape Trench City's narrative and gameplay.

There are 3 classes of Director events:

1. **Seasonal Events** — predictable, structured, high-impact.
2. **Dynamic Events** — triggered by world-state metrics.
3. **Random/Chaos Events** — probability-weighted world-shakers.

Each event has:
- Lifecycle phases  
- Trigger conditions  
- Director tuning effects  
- Integration pathways into Advanced Systems  

---

## 1.1 Event Structure (Full Schema)

```
event:
  id
  name
  type: seasonal | dynamic | random | emergency
  phase: scheduled | active | cooldown | ended
  start_at
  end_at
  config:
    modifiers: {...}
    rewards: {...}
    hooks: [...]
  triggers:
    metrics: [...]
    thresholds: {...}
    system_signals: [...]
  impact:
    economy: {...}
    raids: {...}
    wars: {...}
    territories: {...}
    population: {...}
  logs: [...]
```

---

## 1.2 Seasonal Events (Examples)

### Season: Raid Season
- Increase raid spawn frequency  
- Boost loot rarity  
- Add faction-wide raid challenges  

### Season: War Season
- Increase ranked war density  
- Add new war objectives  
- Global leaderboard enabled  

### Season: Territory Season
- Introduce territory storms  
- Reset stability modifiers  
- Activate rotating regional bonuses  

---

## 1.3 Dynamic Events (Triggered by Metrics)

### Example: Economic Crash
Triggered when:
```
inflation_index > 0.85
cash_faucet_rate > threshold
item_rarity_drift < -0.4
```
Actions:
- Drop rates reduced  
- Cash sinks increased  
- Special NPC market opens  

### Example: Overdominance Correction
Triggered when:
```
faction_power_spread > 0.7
```
Actions:
- Bonus events for underdog factions  
- Territory churn increases  

---

## 1.4 Random Events

Weighted random:
- Blackout  
- Underground Heist  
- NPC Rebellion  
- Experimental Event (Dev/Season-exclusive)  

Each event has:
- Probability  
- Cooldown  
- Impact envelope  

---

# 2. Event Lifecycle Specification

Events follow:

```
SCHEDULED → ACTIVE → COOLDOWN → ENDED → ARCHIVED
```

### 2.1 Scheduled Phase
- Announced (if public)
- Configuration locked
- Countdown running

### 2.2 Active Phase
- Event modifiers are applied
- Event systems enabled
- Event log is active

### 2.3 Cooldown
- Modifiers taper off
- Systems restore baseline values

### 2.4 Ended
- Results processed
- Rewards distributed
- Tuning reset to defaults

### 2.5 Archived
- Immutable logs stored  

---

# 3. Director → Advanced Systems Integration (Deep Mode)

This batch defines how the Director **controls** all major systems.

---

## 3.1 Director → Ranked Wars

Inputs:
- war_density_target  
- conflict_pressure  

Signals:
```
war_cycle:
  frequency
  scaling_mod
  reward_mod
```

Effects:
- Increase/decrease war scheduling frequency  
- Adjust war difficulty  
- Modify rewards seasonally  

---

## 3.2 Director → Chain Engine v2

Inputs:
- chain_saturation  
- faction activity  

Signals:
```
chain_signal:
  xp_bonus
  decay_rate_mod
  peak_window_mod
```

Effects:
- Longer/shorter chain windows  
- Higher/lower reward tiers  

---

## 3.3 Director → Territory Control

Inputs:
- territory_churn  
- stability_index  
- contested_zones  

Signals:
```
territory_signal:
  heat_growth_mod
  stability_mod
  bonus_multiplier
```

Effects:
- Trigger storms  
- Push regions into unrest  
- Adjust bonuses  

---

## 3.4 Director → Raids

Inputs:
- raid_activity  
- success_rate  
- difficulty_curve  

Signals:
```
raid_signal:
  wave_strength_mod
  reward_mod
  spawn_frequency_mod
```

Effects:
- Harder/easier raids  
- More common/rare raids  
- Boss frequency changes  

---

## 3.5 Director → Black Ops

Inputs:
- faction dominance  
- territory disruption  
- seasonal script  

Signals:
```
black_ops_signal:
  secrecy_threshold
  op_spawn_rate_mod
  target_bias_mod
```

Effects:
- More/less Black Ops missions spawn  
- Stricter secrecy rules  
- Certain factions targeted  

---

# 4. Emergency Protocols (FULL SPEC)

Safe Mode has 4 escalating levels.

---

## **Level 1 — Tuning Freeze**
Trigger:
- unstable metrics  
- anomaly flood  

Actions:
- Freeze tuning dictionary  
- Pause Director decisions  
- Record anomaly snapshot  

---

## **Level 2 — Advanced Systems Freeze**
Trigger:
- raids or wars generating errors  
- territory churn collapse  

Actions:
- Pause raids  
- Pause ranked wars  
- Disable chain XP bonuses  
- Notify admins  

---

## **Level 3 — World Freeze**
Trigger:
- deep simulation corruption  
- economy at critical threshold  

Actions:
- Halt all advanced systems  
- Lock world_state updates  
- Enter recovery mode  

---

## **Level 4 — Emergency Shutdown**
Trigger:
- repeated catastrophic failures  
- Director self-invalidates  

Actions:
- Everything frozen  
- Only superadmin can recover world  
- Director requires cold reboot  

---

# 5. Auto-Recovery Engine

Framework:
```
if safe_mode_level >= 2:
    apply_recovery_scripts()
```

Recovery tasks:
- Reset unstable tunings  
- Restore baseline territory heat  
- Recompute economy baselines  
- Reschedule stuck events  
- Re-run failed Director decisions  

Logs all corrections.

---

# 6. Event-Oriented Endpoints (Blueprint Only)

`POST /internal/api/v1/director/create-event`  
- Create seasonal/dynamic/random event.

`POST /internal/api/v1/director/trigger-event`  
- Force trigger.

`POST /internal/api/v1/director/end-event`  
- End early.

`GET /admin/api/v1/director/events`  
- Event history.

`GET /api/v1/director/events/active`  
- Player-safe version.

---

## END OF BATCH 3



# API_Director.md — Ultra Expansion BATCH 4
## Security, Threat Model, Telemetry, Ledger v3, Worker Rules, Versioning

---

# 1. Security Foundations (Director = Highest Value Target)

The Director is the *single most powerful subsystem* in Trench City.
Compromise = TOTAL WORLD CONTROL.

Therefore, Director APIs obey **zero-trust, multi-factor, cryptographically validated internal policies**.

Director security is based on:

- **Isolation:** Director never accepts external-facing requests directly.
- **Verification:** All internal calls must be signed & timestamped.
- **Determinism:** A forged request cannot cause nondeterministic side effects.
- **Forensics:** Every decision is immutably logged.
- **Revocation:** Any compromised credential instantly invalidates its signing domain.

---

# 2. Director Threat Matrix

```
Threat                            | Description
----------------------------------|-----------------------------------------------------------
Forged Director Decision          | Attacker tries to fake tuning/event decisions
Metric Manipulation               | Feeding false inputs to mislead Director
Replay Attacks                    | Re-use stale signed internal requests
Side-channel Decision Influence   | Subtle metric tampering to bias Director actions
Tuning Explosion                  | Extreme tuning values cause catastrophic world effects
Outcome Forgery                   | Fake event resolutions for personal gain
Log Tampering                     | Deleting or editing Director logs
Internal Actor Abuse              | Developer/admin misusing endpoints
Director Poisoning                | Forcing invalid world_state transitions
Race & Lock Attacks               | Triggering events during state transitions
```

---

# 3. Zero-Trust Internal API Scheme

Every internal Director-call (BSL → Director) MUST include:

```
X-Director-Signature: HMAC256( payload + timestamp + nonce )
X-Director-Timestamp: unix_ms
X-Director-Nonce: uuid
X-Director-Origin: subsystem_id
```

Validation rules:

- Timestamp skew ≤ 10 seconds.
- Nonce must be unused in last 10 minutes (nonce cache).
- Signature must match subsystem-specific secret key.
- Requests failing any check → logged, blacklisted.

---

# 4. Director Request Provenance System

Each Director action must prove:

1. **Who** initiated it  
2. **Where** it came from  
3. **What model version** generated it  
4. **What inputs** were used  

Schema:

```
provenance:
  actor: director_internal | system_job | superadmin
  model_version: "v3.4.1"
  subsystem_origin: "wars" | "raids" | "territory" | "economy"
  input_hash: sha256(world_state_snapshot)
  timestamp
```

---

# 5. Director Telemetry & Monitoring Framework

Director emits structured metrics into Prometheus-format labels:

## 5.1 Core Metrics

```
director_tick_duration_ms
director_tick_failures_total
director_decision_total{type}
director_decision_confidence_avg
director_safe_mode_total
director_event_trigger_total{event_type}
director_metric_anomaly_total{metric}
director_tuning_change_total{target, key}
director_system_integration_total{system}
```

---

## 5.2 Metric Anomalies (Triggers)

An anomaly event fires if:

- inflation_index > 0.9  
- faction_power_spread > 0.75  
- raid_success_rate > 0.9  
- war_density < 0.1 during season  
- territory_churn collapses < 0.05  
- concurrency spikes beyond prediction bands  

On anomaly:

- anomaly snapshot logged  
- weighting model amplifies corrective intents  
- potential Safe Mode escalation  

---

## 5.3 Alert Map

### Critical Alerts
- Director enters Safe Mode Level ≥ 2  
- Decision model failure  
- Tuning application rejected  
- Event lifecycle stuck > 1 tick  

### Warning Alerts
- Tuning drift > allowed thresholds  
- Faction dominance > safe bound  
- Multi-metric anomalies  

---

# 6. Immutable Ledger v3 (Forensic Director Log)

Ledger entries are chained via:

```
hash = sha256( previous_hash + entry_json )
```

This creates a tamper-evident chain.

Ledger entries also include:

```
digital_signature = sign(priv_key, hash)
```

Validations:

- previous_hash must match chain  
- signature must be valid  
- timestamps monotonic within tolerance  

Tampering detection:

- chain break  
- hash mismatch  
- signature mismatch  
- time regression  

Ledger storage rules:

- append-only  
- replicated (3+ redundant nodes)  
- daily snapshot with signed digest  

---

# 7. Worker Rules (Architect, CodeGPT, Balance, Security, Admin)

### 7.1 ArchitectGPT
- Must approve any new Director action category.
- No new tuning keys allowed without dictionary update.
- Must validate state machine consistency.

### 7.2 CodeGPT
- ALL Director endpoints require signature validation.
- Must enforce decision provenance.
- Must integrate ledger writes atomically with world updates.

### 7.3 BalanceGPT
- Must maintain tuning bounds.
- Cannot modify tuning without impact notes.
- Must consult historical tuning diffs.

### 7.4 SecurityGPT
- Must review all Safe Mode transitions.
- Must enforce zero-trust key rotation schedule.
- Must run anomaly-detection tests.

### 7.5 AdminGPT
- Can query logs, never modify them.
- Can annotate decisions with admin notes.

---

# 8. Director Versioning & Compatibility

### 8.1 Version Types
```
major: structural changes to world_state or decision engine
minor: tuning rule adjustments
patch: mechanical updates, no behavior changes
```

### 8.2 Backwards Compatibility Rules
- minor/patch: old events remain compatible
- major: requires:
  - migration script
  - version bump in provenance entries
  - recalculation of world_state snapshots

### 8.3 Safe Rollback
Rollback only allowed when:
- no active high-impact events (wars/raids)
- no pending Director decisions
- tuning drift within tolerance

Rollback procedure:
1. Freeze Director (Level 1)
2. Create rollback-point snapshot
3. Restore previous model version
4. Validate integrity
5. Resume Director

---

# 9. Final Director Security Law (Global Pack Binding)

1. Director can NEVER be directly called by clients.
2. All incoming internal calls must be signed.
3. All decisions MUST be logged.
4. No system may override Director except Safe Mode escalation.
5. Director state must always be reconstructable from ledger.
6. Director cannot violate world_state invariants.
7. Director cannot bypass tuning validity rules.
8. Advanced Systems must obey Director signals.
9. Director must prevent runaway instability.
10. Director must maintain narrative season integrity.

---

# END OF BATCH 4



# END OF DIRECTOR FULL SPEC
# API_Events.md — COMPLETE ULTRA EXPANDED EDITION


# API_Events.md — Ultra Expansion BATCH 1
## Core Architecture & Event Framework

---

# 1. Event Philosophy

Events are the **heartbeat of world dynamism** in Trench City.  
They exist to:

- Shape narrative arcs  
- Influence player behavior  
- Create spikes of engagement  
- Modify economy, combat, and territory dynamics  
- Serve as connectors between micro-level actions and macro-level world responses  

Events must be:

- **Deterministic internally**  
- **Triggerable by Director, systems, or metrics**  
- **Fully logged and reconstructable**  
- **Configurable, testable, and tunable**  
- **Replay-safe and monotonic**  

---

# 2. Event Categories

Events are classified into core types:

## 2.1 Local Events
Affect a specific zone, location, player, or faction. Examples:
- District robbery wave  
- Property fire  
- Shop sale  
- Faction morale boost  

## 2.2 Global Events
Affect the entire world. Examples:
- Raid season  
- War season  
- Economic crash  
- Blackout  
- Global boss  

## 2.3 Dynamic Events (Metric Driven)
Triggered when world-state signals cross thresholds. Examples:
- Inflation spike  
- Overdominance correction  
- Chain overactivity  
- Territory churn collapse  

## 2.4 Random/Chaos Events
Probability-based events with cooldowns. Examples:
- Underground Heist  
- NPC rebellion  
- Item rarity surge  

## 2.5 Scheduled Events
Time-based with fixed duration. Examples:
- Holiday events  
- Weekly tournaments  
- Monthly boosts  

---

# 3. Canonical Event Object (Deep Schema)

```
event:
  id: string
  name: string
  type: local | global | dynamic | random | scheduled | emergency
  category: economy | combat | city | faction | world
  phase: scheduled | active | cooldown | ended | archived

  start_at: timestamp
  end_at: timestamp

  triggers:
    time: {...}         # schedule, recurrence rules
    metrics: {...}      # thresholds & signals
    probability: {...}  # weighted randomness
    actions: [...]      # system hooks that initiate this event

  config:
    modifiers: {...}    # tuning changes, system flags
    rewards: {...}      # loot, bonuses, XP, reputation
    visibility: {...}   # public, faction-only, secret
    duration_mod: float # scaling for event length

  impact:
    economy: {...}
    raids: {...}
    wars: {...}
    territories: {...}
    population: {...}
    world_state_flags: [...]

  logs: [...]
  metadata:
    created_by: director | system | admin
    version: string
```

---

# 4. Event Lifecycle (Deep Spec)

Events progress through:

```
SCHEDULED → ACTIVE → COOLDOWN → ENDED → ARCHIVED
```

### 4.1 Scheduled Phase
- Event created  
- Configuration locked  
- Countdown active  

### 4.2 Active Phase
- Modifiers applied  
- Systems invoked  
- Player-visible effects  
- Logging enabled  

### 4.3 Cooldown Phase
- Gradual tapering of effects  
- System rollback to normal  

### 4.4 Ended Phase
- Reward distribution  
- Cleanup tasks executed  

### 4.5 Archived Phase
- Immutable logs stored  
- Analytics snapshots saved  

---

# 5. Trigger Classes (Foundation Layer)

Events can start from the following:

## 5.1 Time-Based Triggers
Cron-like schedule:
```
every day at 18:00  
every Friday  
every 30 minutes  
```

## 5.2 Metric-Based Triggers
Examples:
- inflation_index > 0.85  
- faction_dominance > 0.7  
- raid_success_rate < 0.4  
- territory_stability < 0.2  

## 5.3 Player-Action Triggers
Examples:
- First faction reaches 10k chain  
- City-wide crime threshold  
- Boss defeat triggers sub-event  

## 5.4 Director-Driven Triggers
Events triggered directly by Director signals.

## 5.5 System-Driven Triggers
Modules (Raids, Territories, etc.) may trigger specialized micro-events.

---

# 6. Event Registry & Routing Layer

The Event Engine maintains a global registry:

```
event_registry:
  global: [...]
  local: [...]
  dynamic: [...]
  scheduled: [...]
  random: [...]
```

Events are routed by:

- type  
- category  
- system integration requirements  

Routing ensures:
- Conflicting events do not overlap  
- Required resources reserved  
- Tuning does not stack incorrectly  

---

# 7. High-Level API Endpoints (Blueprint Only)

## Player-Facing

`GET /api/v1/events/active`  
Returns active events with safe-scope visibility.

`GET /api/v1/events/{event_id}`  
Details of a specific event.

## Admin-Facing

`POST /admin/api/v1/events`  
Create event.

`PATCH /admin/api/v1/events/{event_id}`  
Modify event parameters.

`POST /admin/api/v1/events/{event_id}/end`  
Force end event.

`GET /admin/api/v1/events/logs`  
Retrieve event logs (with filters).

## Internal (Event Engine / Director)

`POST /internal/api/v1/events/trigger`  
Trigger event from Director or system module.

`POST /internal/api/v1/events/tick`  
Handle lifecycle updates, cooldowns, rollbacks.

---

# END OF BATCH 1



# API_Events.md — Ultra Expansion BATCH 2
## Trigger Engine, Conditions System & Event Logic Core

---

# 1. Trigger Engine (TE) — Deep Specification

The **Trigger Engine** determines *when* events activate.
It runs every Director tick and also reacts to real-time system signals.

Trigger evaluation model:

```
trigger_eval = TE(time_triggers, metric_triggers, player_triggers, system_triggers)
if trigger_eval → TRUE:
    event_manager.activate(event)
```

The engine supports **priority, stacking rules, cooldowns, and cascading behaviors**.

---

# 2. Trigger Evaluation Order (Strict, Deterministic)

To maintain consistency:

```
1. Forced triggers (Director / Admin)
2. Emergency triggers
3. Time-based triggers
4. Metric-based triggers
5. Player-action triggers
6. Random/probability triggers
7. System-driven micro triggers
```

If multiple triggers fire simultaneously:

- Highest priority wins  
- Others become deferred events (queue)  
- Queue has replay protection and monotonic ordering  

---

# 3. Priority System

Each trigger has a priority weight:

```
priority: 1–100
```

Examples:

- Emergency event = 100  
- Director override = 95  
- Seasonal event start = 90  
- Dynamic event = 75  
- Local event = 40  
- Random event = 20  

Lower-priority events **cannot override** active higher-priority ones unless flagged `preempt:true`.

---

# 4. Trigger Types (Deep Logic)

## 4.1 Time-Based Triggers

Supports:
- cron syntax  
- recurrence  
- fixed-duration  
- cycle-based windows  

```
time_trigger:
  type: cron | interval | fixed
  value: "0 */2 * * *" | "every 30m" | timestamp
```

### Time-Jitter Correction
To prevent exact timing exploits:

```
next_trigger_time = base + jitter(±5%)
```

---

## 4.2 Metric-Based Triggers

Metrics sampled from Director world_state:

Examples:
- inflation_index  
- dominance_index  
- war_density  
- territory_stability  
- population_concurrency  

Threshold example:

```
metric_trigger:
  metric: "inflation_index"
  operator: ">="
  value: 0.85
  sensitivity: 0.1   # hysteresis buffer
```

### Hysteresis
Events do not fire again until conditions return within safe range.

---

## 4.3 Player-Action Triggers

Events that originate from player behavior:

Examples:
- First faction to reach chain 10,000  
- First raid completion of the day  
- City-wide crime threshold  
- Killing a world boss  

All player triggers must be **validated server-side**.

---

## 4.4 Random/Chaos Triggers

Weighted random events use:

```
probability = base_weight * world_modifier * time_modifier
```

All randomness must be **seeded using server PRNG** for auditability.

---

## 4.5 System-Driven Triggers

Subsystems may emit signals:

- Wars: victory streak → morale boost event  
- Raids: raid fails too often → morale penalty event  
- Territories: heat spike → storm event  

Format:

```
system_trigger:
  subsystem: "raids"
  event: "raid_failure_wave"
  confidence: 0.7
```

---

# 5. Event Conditions Matrix (ECM)

Defines allowable conditions before an event may activate.

Categories:

## 5.1 Economy Conditions

```
economy_conditions:
  inflation_high:
    metric: inflation_index
    operator: ">="
    threshold: 0.85
  market_overflow:
    metric: faucet_rate
    operator: ">="
    threshold: 1.5
```

---

## 5.2 Conflict Conditions

```
conflict_conditions:
  dominance:
    metric: faction_power_spread
    operator: ">="
    threshold: 0.7
  low_war_density:
    metric: war_density
    operator: "<="
    threshold: 0.1
```

---

## 5.3 Territory Conditions

```
territory_conditions:
  churn_collapse:
    metric: territory_churn
    operator: "<="
    threshold: 0.05
  heat_surge:
    metric: territory_heat
    operator: ">="
    threshold: 0.75
```

---

## 5.4 Population Conditions

```
population_conditions:
  concurrency_spike:
    metric: login_curve
    operator: ">="
    threshold: predicted_band
  new_players_surge:
    metric: new_player_pressure
    operator: ">="
    threshold: 1.5
```

These conditions are referenced by dynamic & scheduled events.

---

# 6. Event Cooldowns & Anti-Spam Protection

To prevent event flooding:

```
global_event_cooldown: 5 minutes
category_cooldown: per category
event_specific_cooldown: custom
trigger_cooldown_cache[event_id]: timestamp
```

If any cooldown is active → event is deferred.

Deferred events:
- Enter a queue  
- Can fire later when allowed  
- Must respect monotonic ordering  

---

# 7. Cascade Trigger System

Events can trigger other events:

Example:

### Territory Storm → Resource Scarcity Event

```
trigger_event("territory_storm")
→ reduces stability
→ triggers "resource_scarcity"
→ which may trigger "blackmarket_surge"
```

Rules:
- Cascades limited to depth 3  
- Must include fail-safe to prevent infinite loops  
- All cascade steps must be logged  

---

# 8. Event Logic Core

Event resolution model:

```
event.activate():
  apply_modifiers()
  notify_subsystems()
  update_world_state()
  log_activation()

event.tick():
  maintain_effects()
  spawn_micro_events()
  check_for_cascade()

event.end():
  rollback_modifiers()
  distribute_rewards()
  archive_logs()
```

---

# 9. Trigger Engine Endpoints (Blueprint Only)

`POST /internal/api/v1/events/trigger-eval`  
Runs a full evaluation of triggers.

`POST /internal/api/v1/events/register-player-trigger`  
Securely registers a player-triggered event.

`POST /internal/api/v1/events/register-system-trigger`  
System modules send signals.

---

# END OF BATCH 2



# API_Events.md — Ultra Expansion BATCH 3
## Event Types, Impact Models & System Integration

---

# 1. Global Event Types (AAA-Level Spec)

Global events affect **the entire world**, altering world_state, tuning, and system flows.  
Defined in the Director & Event Engine but fully documented here for implementation.

---

## 1.1 Raid Season

### Description  
A global campaign where raids spawn more frequently, drop better loot, and trigger unique boss encounters.

### Impact
```
raid.spawn_frequency_mod: +0.5
raid.wave_strength_mod: +0.2
raid.reward_multiplier: +0.5
loot_table.rare_chance: +0.15
```

### Integration  
- Director adjusts raid tunings at event start/stop  
- Raids subsystem increases active raid capacity  
- Loot generator uses seasonal modifiers  

---

## 1.2 War Season

### Description  
A season focusing on ranked wars, faction conflicts, and global territory competition.

### Impact
```
war.war_density_target: +0.4
war.reward_mod: +0.25
territory.churn_rate: +0.1
chain.xp_multiplier: +0.2
```

### Integration  
- Chains subsystem uses XP multiplier  
- Wars scheduler increases match frequency  
- Territories update churn model  

---

## 1.3 Territory Storms

### Description  
A region-wide instability event affecting multiple territories simultaneously.

### Impact
```
territory.heat_growth: +0.5
territory.stability: -0.2
territory.bonus_multiplier: ±variable
```

### Integration  
- Territory subsystem increases heat  
- Raids may target storm zones  
- Director monitors territorial imbalance  

---

## 1.4 Economic Crash

### Description  
A dynamic event triggered by inflation or faucet overflow.

### Impact
```
economy.drop_rate_multiplier: -0.2
economy.cash_sink_multiplier: +0.3
blackmarket_pressure: +0.4
```

### Integration  
- Economy engine updates loot drop curves  
- Shops adjust prices dynamically  
- Black Market gets temporary offers  

---

## 1.5 Citywide Blackout

### Description  
The entire game enters a “blackout mode” where some systems are disabled.

### Effects
- Raids temporarily disabled  
- War objectives limited  
- Maps visibility reduced  
- Crime patterns shift  
- NPC events spawn more frequently  

Integration:
- Map generator applies blackout filters  
- Combat system adjusts hit chance  
- Crime system modifies odds  

---

## 1.6 World Boss Events

### Description  
A massive temporary boss with global impact.

### Integration
- Combats triggered through raid subsystem  
- Boss phases influence world modifiers  
- Defeat triggers micro-events  

Rewards:
- Cosmetics  
- Special items  
- Faction-wide bonuses  

---

# 2. Local / Micro Event Types

Local events affect specific areas, players, or factions.

---

## 2.1 District Robbery Wave

### Description  
Crime spikes in a specific city district.

### Impact  
- Crime success rate: +0.15  
- Police heat: +0.2  
- Loot modifiers increased  

Integration:
- Crime subsystem uses district-specific multipliers  

---

## 2.2 Shop Discount Event

### Description  
A vendor-specific discount window.

### Impact  
```
shop.price_multiplier: -0.3
shop.stock_increase: +0.2
```

Integration:
- Item shop API applies discounts  
- Inventory system adjusts restock frequency  

---

## 2.3 Area Drop Event

### Description  
A physical zone where special item drops spawn for a limited time.

### Integration
- Map module marks active drop zone  
- Loot generator spawns rare containers  
- Combat system may enable PvP bonuses  

---

## 2.4 Faction Morale Boost

Triggered by:
- raid win streak  
- war performance  
- boss defeat  

Impact:
```
faction.morale: +10
chain.reward_multiplier: +0.1
training.xp_boost: +0.1
```

---

# 3. System Integration (Core)

Events must integrate with major systems cleanly and safely.

---

# 3.1 Integration with Director

Director:
- Creates global events  
- Modifies tuning before/after event  
- Reconciles event impact with world_state  
- Handles event scheduling & cooldowns  

Event Engine:
- Executes lifecycle  
- Applies modifiers  
- Handles cascades  

---

# 3.2 Integration with Wars Engine

Events can:
- Increase war frequency  
- Boost war rewards  
- Modify war conditions  
- Delay war seasons  

Wars Engine must:
- Validate Director signals  
- Recompute matchmaking rules  
- Adjust reward scaling during events  

---

# 3.3 Integration with Chain Engine v2

Events can:
- Modify chain XP multiplier  
- Change decay rates  
- Enable special chain bonuses  

Chain Engine must:
- Use event-modified parameters  
- Apply event-specific XP bonuses  
- Log event-triggered milestones  

---

# 3.4 Integration with Raids Engine

Events can:
- Affect raid spawn rates  
- Increase boss appearances  
- Change success/failure odds  
- Modify reward tables  

Raids Engine must:
- Recalculate raid difficulty using event modifiers  
- Enable special event-only raid types  
- Coordinate with Event Engine for boss lifecycle  

---

# 3.5 Integration with Territory Control

Events can:
- Trigger storms  
- Change heat  
- Modify stability  
- Restrict/boost capture rules  

Territory Engine must:
- Accept event heat deltas  
- Provide outputs to Director for world_state  
- Apply unrest bonuses  

---

# 3.6 Integration with Black Ops

Events can:
- Raise secrecy thresholds  
- Influence target selection  
- Trigger global covert missions  

Black Ops subsystem must:
- Respect event-based secrecy multipliers  
- Alter mission availability  

---

# 4. Impact Envelope Model

Each event has an **impact envelope** defining all modifications.

Schema:
```
impact_envelope:
  duration_mod: float
  economy: {...}
  raids: {...}
  wars: {...}
  territories: {...}
  black_ops: {...}
  chains: {...}
  loot: {...}
  population: {...}
```

An event may override multiple subsystems simultaneously.

---

# 5. Event Stacking & Conflict Rules

To prevent chaotic stacking:

- Only **1 high-impact global event** active at a time  
- Up to **3 local events per category**  
- Events flagged `exclusive:true` cannot overlap with similar types  
- Conflicting modifiers are merged via priority rules  

Conflict Resolution:
```
winner = event.priority > other.priority ? event : other
```

---

# END OF BATCH 3



# API_Events.md — Ultra Expansion BATCH 4
## Security Model, Threat Matrix, Telemetry, Ledger v2, Worker Rules & Versioning

---

# 1. Event Security Model (High-Value Attack Surface)

Events can modify economy, combat, raids, wars, loot, territories, and global world_state.  
Therefore, the Event Engine must enforce **Director-grade security principles**.

Security pillars:

- **Zero-trust validation**  
- **Signature-based internal calls**  
- **Trigger authenticity verification**  
- **Replay protection**  
- **Event stacking & conflict enforcement**  
- **Tamper-evident logs**  
- **Rate-limiting & cooldowns**

---

# 2. Threat Matrix (Expanded)

```
Threat Type                    | Description
-------------------------------|---------------------------------------------------
Forged Trigger                 | Attacker tries to trigger events manually
Replay Attack                  | Reusing a valid event trigger payload
Metric Poisoning               | Manipulating Director world_state to force events
Trigger Flooding               | Spamming triggers to overload system
Stacking Exploits              | Forcing overlapping modifiers
Cascade Abuse                  | Creating infinite or harmful sequences
Shop/Crime Farming via Events  | Abuse of local bonus events
Event Hijacking                | Altering event config mid-lifecycle
Silent Event Injection         | Subverting internal endpoints
Log Tampering                  | Removing/forging event logs
Cross-System Corruption        | Triggering dangerous states across subsystems
```

---

# 3. Event Trigger Security

All internal trigger requests must include:

```
X-Event-Signature: HMAC256(payload + timestamp + nonce)
X-Event-Timestamp: unix_ms
X-Event-Nonce: uuid
X-Event-Origin: subsystem_id
```

Validation rules:

- Timestamp skew ≤ 10 seconds  
- Nonce unused in last 10 minutes  
- Origin must be whitelisted subsystem  
- Signature matches subsystem secret  

Invalid requests:
- Logged  
- Rejected  
- Increment anomaly counter  

---

# 4. Player Trigger Validation (Strict)

Player-triggered events MUST be:

- Server-side validated  
- Bound to specific player action logs  
- Rate-limited per user  
- Non-spoofable  

Validation chain:

```
if not action_exists_in_logs(player_id, action_id):
    reject_trigger()

if trigger_rate_exceeded(event_id, player_id):
    reject_trigger()
```

---

# 5. Cooldown Enforcement (Security Extension)

Cooldowns prevent spamming and event abuse:

- Global cooldown  
- Category cooldown  
- Per-event cooldown  
- Trigger-specific cooldown  

Security rule:

```
if cooldown_active(event):
    raise SecurityError("Cooldown violation attempt")
```

---

# 6. Event Telemetry & Monitoring Framework

Metrics exposed:

```
events_triggered_total{type}
events_failed_total{reason}
events_active_total
events_cascade_depth
events_conflict_resolution_total
events_trigger_queue_length
events_sec_rejected_total{reason}
```

---

# 7. Alerts & Thresholds

### Critical Alerts
- cascade depth > 3  
- event conflict unresolved  
- repeated trigger rejections  
- event lifecycle stuck > 2 ticks  
- abnormal spike in player-trigger events  

### Warning Alerts
- slowdown in event processing  
- metric-trigger anomalies  
- category imbalance  

---

# 8. Immutable Event Ledger v2

Ledger entry schema:

```
ledger_entry:
  id
  timestamp
  actor
  event_id
  event_type
  trigger_source
  world_state_snapshot
  impact_envelope
  cascade_depth
  signature
  previous_hash
  hash
```

Supports:

- forensic reconstruction  
- cascade chain review  
- event replay simulation  
- tamper detection  

Tampering detected via:

- chain breaks  
- signature mismatches  
- timestamp regressions  

---

# 9. Worker Rules (Binding)

### ArchitectGPT
- Approves new event types  
- Validates lifecycle logic  
- Ensures compatibility with Director  

### CodeGPT
- Must enforce signature checks  
- Must integrate ledger writes atomically  
- Must apply & revert modifiers safely  

### BalanceGPT
- Documents all event impact envelopes  
- Validates tuning ranges  
- Updates seasonal parameters  

### SecurityGPT
- Monitors anomaly streams  
- Reviews rejected triggers  
- Approves cooldown changes  

### AdminGPT
- Can start/end events  
- Cannot modify logs  
- Cannot bypass cooldowns  

---

# 10. Event Versioning & Compatibility

Versioning rules:

```
major: lifecycle or behavior changes
minor: new modifiers or integration hooks
patch: non-breaking fixes
```

Rollback allowed when:

- No global high-impact events active  
- Trigger queue empty  
- Cascade chains fully resolved  

---

# END OF BATCH 4



# END OF EVENTS FULL SPEC
# API_Mobile.md — COMPLETE ULTRA EXPANDED EDITION


# API_Mobile.md — Ultra Expansion BATCH 1
## Mobile Gateway Architecture, Session Model, Device Registration & Sync Engine

---

# 1. Mobile Gateway Architecture (High-Level)

The Mobile API Gateway sits between native apps and the core backend.

### Goals:
- Reduce latency  
- Ensure version compatibility  
- Enforce mobile-specific security  
- Support high-frequency sync  
- Provide differential data fetching  

### Architecture Layers:
```
MobileApp → Mobile API Gateway → Core Services → DB/Cache/Director
```

### Gateway Responsibilities:
- request normalization  
- rate limiting (per-device + per-user)  
- payload compression  
- version enforcement  
- authentication routing  
- delta-sync preparation  
- real-time event multiplexing  

---

# 2. Mobile Session Model

Mobile uses a **two-token model**:

## 2.1 Access Token (Short-Lived)
- JWT or signed token  
- Expiry: 15–30 minutes  
- Contains:
```
user_id
session_id
device_id
scopes
iat
exp
signature
```

## 2.2 Refresh Token (Long-Lived)
- Tied to a registered device  
- Expiry: 30–90 days  
- Stored securely in Keychain/Android Keystore  

### 2.3 Session Rotation
- New access token issued when refresh token used  
- Rotation invalidates previous access token  
- Brute-force attack prevention  

### 2.4 Multi-Device Binding
User may log into multiple devices, each with:
```
device_id
device_name
platform
app_version
last_seen
session_state
```

---

# 3. Device Registration

Every mobile device must register before API access.

### Payload:
```
device_id: uuid
platform: ios | android | hybrid
app_version: string
device_model: string
os_version: string
capabilities:
  - push
  - realtime
  - offline_mode
```

### Registration Output:
- device_token  
- expected sync interval  
- updated capability flags  

### Device Enforcement Rules:
- outdated clients → blocked or limited  
- jailbroken/rooted → restricted  
- tampered build → denied  

---

# 4. Mobile Sync Engine (Full Spec)

Mobile must reduce bandwidth and battery usage.

Mobile sync model includes:

## 4.1 Full Sync
Triggered when:
- first login  
- stale cache  
- major version update  
- app reinstall  

Returns:
```
player
bars
stats
inventory
faction
notifications
timers
world_state
```

## 4.2 Delta Sync
Most common sync.
Returns only changed data:
```
changed_fields[]
timestamp
diff_payload
```

Delta sources:
- combat/bar changes  
- inventory changes  
- faction updates  
- new messages  
- director signals  
- active wars update  
- crime/gym timers  

## 4.3 Event Push Sync
For realtime updates:
- WebSocket or long-poll fallback  
- multiplexed event channel  
- war updates  
- chain events  
- territory flips  
- notifications  

## 4.4 Background Sync
Rules:
- max 1 sync every 15–30 minutes  
- restricted to essential updates  
- push-triggered when possible  

Payload:
```
timers
notifications
critical world-state deltas
```

---

# 5. API Versioning (Mobile-Safe)

## 5.1 Semantic Versioning
```
major.minor.patch
```

## 5.2 Breaking Change Handling
Gateway enforces:
- block outdated versions  
- require forced update  
- provide fallback path  

## 5.3 Feature Flags
Enable staging of new features:
```
flags:
  new_inventory_ui: true/false
  realtime_crimes: true/false
  push_chain_events: true/false
```

## 5.4 Remote Kill Switch
If mobile build compromised:
- disable sessions  
- disable sync  
- push forced update  

---

# END OF BATCH 1



# API_Mobile.md — Ultra Expansion BATCH 2
## Mobile Feature API Set for All Modules (Dashboard, Crimes, Gym, Inventory, Chat, Factions, Travel, Casino & More)

---

# 1. Mobile Dashboard API

The dashboard is the home screen and must load instantly with minimal payload size.

### Endpoint: Get Dashboard Snapshot
`GET /mobile/v1/dashboard`

### Returns:
```
bars:
  energy
  nerve
  happy
  life
stats:
  strength
  speed
  defense
  dexterity
timers:
  crimes_cooldown
  gym_cooldown
  travel_timer
  hospital_timer
  jail_timer
world_state:
  events
  war_status
  territory_alerts
notifications_unread
```

### Rules:
- payload must be < 10 KB  
- differential sync allowed with `etag` headers  
- updated instantly after any stat change  

---

# 2. Mobile Inventory API

Inventory requires fast-loading, scroll-optimized payloads.

### Get Inventory
`GET /mobile/v1/inventory`

Returns:
```
items: [
  {
    item_id
    name
    icon
    quantity
    stackable
    equipped
    category
  }
]
```

### Use Item
`POST /mobile/v1/inventory/use`

Payload:
```
item_id
quantity
```

### Equip Item
`POST /mobile/v1/inventory/equip`

Payload:
```
item_id
slot
```

### Drag & Drop (Mobile Interaction)
`POST /mobile/v1/inventory/move-slot`

---

# 3. Mobile Crimes API

Mobile crimes require fast feedback and timer tracking.

### Get Crimes
`GET /mobile/v1/crimes`

Returns:
```
crime_categories[]
crime_options[]
timers:
  nerve_regen
  cooldown
```

### Commit Crime
`POST /mobile/v1/crimes/commit`

Payload:
```
crime_id
```

### Crime Response
```
outcome: success|fail|critical
rewards:
  cash
  xp
  items[]
cooldowns:
  crime_cooldown
  nerve_used
```

---

# 4. Mobile Gym API

Requires batching for faster mobile training.

### Get Gym Info
`GET /mobile/v1/gym`

### Train Stats
`POST /mobile/v1/gym/train`

Payload:
```
stat_type: strength|speed|defense|dexterity
amount: int
```

Returns updated bars & stats.

---

# 5. Mobile Faction API

Includes:
- chat  
- upgrades  
- territory  
- wars  
- announcements  

### Get Faction Overview
`GET /mobile/v1/faction`

### Faction Chat (Long Poll / WebSocket)
`GET /mobile/v1/faction/chat`

### Send Message
`POST /mobile/v1/faction/chat/send`

### Faction Wars
`GET /mobile/v1/faction/wars`

### Start War
`POST /mobile/v1/faction/wars/challenge`

---

# 6. Mobile Messaging / Chat API

### Long Poll
`GET /mobile/v1/chat/poll?last_id=X`

### WebSocket Channel
`wss://api.trenchcity.com/mobile/chat`

### Send Message
`POST /mobile/v1/chat/send`

Payload:
```
to_id
message
attachments[]
```

---

# 7. Mobile Travel API

### Get Travel Destinations
`GET /mobile/v1/travel`

### Travel Action
`POST /mobile/v1/travel/go`

Returns:
```
travel_time
destination
rewards[]
```

### Travel Status
`GET /mobile/v1/travel/status`

---

# 8. Mobile Properties API

### Get User Properties
`GET /mobile/v1/properties`

### Upgrade Property
`POST /mobile/v1/properties/upgrade`

### Buy Property
`POST /mobile/v1/properties/buy`

---

# 9. Mobile Jobs API

### Get Jobs
`GET /mobile/v1/jobs`

### Work Shift
`POST /mobile/v1/jobs/work`

---

# 10. Mobile Casino API

### Basic Games
`POST /mobile/v1/casino/blackjack`
`POST /mobile/v1/casino/slots`
`POST /mobile/v1/casino/roulette`

Return rapid-result formats optimized for mobile latency.

---

# 11. API Response Optimization Rules

### All mobile responses must:
- be < 20 KB  
- avoid nested objects deeper than 3 levels  
- include `etag`  
- use short field names where possible  
- support delta-sync  

---

# END OF BATCH 2



# API_Mobile.md — Ultra Expansion BATCH 3
## Real-Time Architecture (Hybrid), Push Notifications, Offline Mode, Local Caching & Secure Storage

---

# 1. Hybrid Real-Time Architecture (Primary = WebSockets, Fallback = Long Poll)

Mobile requires ultra-low-latency updates for:
- wars
- faction chat
- chain progression
- territory flips
- crimes & gym timers
- direct messages
- notifications
- market updates

To support all devices and networks, Trench City Mobile uses a **hybrid architecture**.

---

## 1.1 WebSocket Real-Time Channel (Primary)

Endpoint:
```
wss://api.trenchcity.com/mobile/realtime
```

Capabilities:
- multiplexed channels
- bi-directional updates
- JWT-signed handshake
- compression enabled
- reconnect with exponential backoff
- mobile battery-aware pings

### Supported Channels:
```
/wars
/faction_chat
/global_chat
/chain
/territories
/notifications
/direct_messages
/system_events
```

### Authentication:
```
{
  "access_token": "<jwt>",
  "device_id": "<uuid>",
  "app_version": "<semver>"
}
```

### WebSocket Events Format:
```
{
  "event": "war_update",
  "payload": {...},
  "timestamp": 123456789,
  "sig": "HMAC..."
}
```

---

## 1.2 Long Poll Fallback (Low Connectivity Mode)

Endpoint:
```
GET /mobile/v1/realtime/poll?since=<timestamp>
```

Returns bundle:
```
events: [],
last_event_timestamp,
fallback_reason
```

Reasons for fallback:
- unstable network
- WebSocket handshake failure
- rooted/jailbroken restrictions
- VPN/proxy conflicts

---

## 1.3 Event Prioritization (Mobile-Specific)

High-priority events:
- war tick
- direct messages
- crime/gym timers
- faction chat
- chain XP updates

Low-priority events:
- territory heat changes
- background world updates
- market fluctuations

System queues & batches updates for low-priority events to reduce battery usage.

---

# 2. Push Notification Engine (APNS + FCM)

Push notifications trigger when:
- app inactive
- device locked
- WebSocket disconnected
- background sync pending

---

## 2.1 Notification Types

### Critical
- war attack
- faction summon
- direct message
- hospital/jail status
- crimes ready
- energy refill
- chain breakpoint alert

### Informational
- auction outbid
- market purchase complete
- faction announcement

### Background
- daily summary
- leaderboard movement

---

## 2.2 Push Payload Schema

```
{
  "type": "war_alert",
  "title": "Faction War Update",
  "body": "Your faction is under attack!",
  "metadata": {
     "war_id": 123,
     "attacker": "Gang XYZ"
  },
  "priority": "high",
  "badge": 4
}
```

---

## 2.3 User Push Preference Matrix

Stored per-device:
```
push_preferences:
  wars: enabled
  chat: enabled
  dm: enabled
  crimes_ready: enabled
  events: disabled
  casino: disabled
```

---

# 3. Offline Mode (Full Specification)

Offline mode ensures the app remains usable without internet.

---

## 3.1 Local Cached Data Allowed Offline:
- user stats
- bars
- inventory snapshot
- equipped items
- faction overview
- timers (local countdown)
- messages (read-only)
- crime descriptions
- gym stat display
- property information

Not allowed offline:
- crimes commit
- gym training
- messaging send
- war actions
- trades
- casino games

---

## 3.2 Sync Queue (Offline Action Queue)

Actions taken offline are stored in:
```
sync_queue:
  - action_type
  - payload
  - timestamp
  - retry_counter
```

On reconnection:
- validate session
- replay queued actions in order
- reject stale or invalid actions
- return merged results

---

## 3.3 Conflict Resolution Rules

Mobile → Server conflicts resolved by:
```
server_wins
```

Conflicts include:
- inventory changes
- faction membership changes
- property upgrades

Client must:
- discard outdated local state
- apply full-sync or delta-sync

---

# 4. Local Caching System

Mobile stores:
- last_sync_timestamp
- object hashes
- cached lists (inventory, crimes, etc.)
- UI bundle definitions
- static assets

---

## 4.1 Cache Invalidation

Triggers:
- version upgrade
- director world_state change
- user logs out
- integrity check fails

---

# 5. Secure Local Storage

All sensitive data stored using:
- iOS Keychain
- Android Keystore
- AES-256 encrypted fallback on older devices

Stored securely:
```
refresh_token
device_token
session_id
push_token
cached_private_messages
```

Not stored:
- passwords
- raw API keys

---

## 5.1 Root/Jailbreak Detection

If detected:
- disable offline mode
- disable sync queue
- disable sensitive caching
- require full-server verification for every action

---

# 6. Background Update Rules

### iOS:
- background fetch every 15–30 minutes
- silent push wake-ups
- low-data mode honored

### Android:
- job scheduler
- FCM data notifications
- battery saver-aware mode

Payload for background sync:
```
{
  "delta": {...},
  "timers": {...},
  "critical_alert": false
}
```

---

# END OF BATCH 3



# API_Mobile.md — Ultra Expansion BATCH 4
## Mobile Security, Anti‑Tamper, Threat Matrix, Rate Limits, Worker Laws & Versioning

---

# 1. Mobile Anti‑Tamper System (Full Spec)

The mobile app must protect against:
- modified APK/IPA builds  
- cheat engines  
- memory injection  
- man-in-the-middle attacks  
- automation frameworks  
- emulator-based farming  
- replay systems  

Anti‑tamper runs at app startup and periodically during runtime.

---

## 1.1 Integrity Verification

Checks performed:

```
1. App signature validation
2. Code integrity hashing (SHA-256 bundle checksum)
3. Binary patch detection
4. Debugger detection
5. Breakpoint scan
```

If tampering suspected:
```
app_state = "restricted"
disable_offline_mode = true
disable_sync_queue = true
require_online_validation = true
```

---

## 1.2 Jailbreak / Root Detection

Indicators:
- writable system paths  
- su binary present  
- Magisk/Zygisk traces  
- Cydia/Substrate frameworks  
- unsafe SELinux state  

If detected:
- force WebSocket → long poll fallback  
- disable local caching of secure data  
- require signature on every request  
- block war actions & casino  

---

## 1.3 Emulator Detection

Check:
- device fingerprint patterns  
- manufacturer equality “Android_x86”  
- abnormal CPU ABI  
- missing sensors  
- virtual GPU IDs  

If emulator detected:
```
device_mode = "sandbox"
```

Sandbox rules:
- no wars  
- no crimes  
- no trades  
- no casino  
- limited XP  

---

## 1.4 Certificate Pinning

Pinned certificates prevent MITM attacks.

Rules:
- reject all unpinned TLS certs  
- reject proxies  
- reject SSL interception tools  

---

## 1.5 Request Fingerprinting

Each request contains:
```
device_id
session_id
nonce
signature
fingerprint_hash
```

Fingerprint hash includes:
- OS version  
- app version  
- device model  
- secure hardware ID  

Used to detect:
- cloned devices  
- session hijacks  
- multi-login attacks  

---

# 2. Mobile Security Threat Matrix

```
Threat                          | Description
--------------------------------|----------------------------------------------
MITM Interception               | Proxy intercepts traffic; prevented by pinning
Forged Packets                  | Fake actions crafted to gain rewards
Replay Attacks                  | Reusing signed actions
Automation Tools                | Bots auto-run crimes, gym, travel
Emulator Farming                | Scaling bots via emulators
Cloned Devices                  | Device ID spoofing
Session Hijacking               | Token stolen from local storage
Offline Abuse                   | Modifying sync queue or timers
Modified APK/IPA                | Injecting cheat logic
Background Farming Apps         | Auto-clickers or timers
```

Response priority:
- high → wars, crimes, casino  
- medium → messaging, chat  
- low → cosmetic systems  

---

# 3. Mobile Rate Limit System

Rate limits apply per:
- device_id  
- user_id  
- IP address  
- action category  

---

## 3.1 Action Categories

### High Risk  
- crimes commit  
- gym training  
- item use  
- war actions  
- trades  
- casino spins  

Rate example:
```
max 5 actions / second  
max 100 actions / minute  
```

### Medium Risk  
- chat messages  
- faction interactions  

### Low Risk  
- dashboard refresh  
- polling requests  

Repeated violations → soft ban → hard device ban.

---

# 4. Request Signature Enforcement

Every sensitive action must contain:

```
X-Mobile-Signature: HMAC256(payload + nonce + timestamp)
X-Mobile-Device: device_id
X-Mobile-Session: session_id
X-Mobile-Nonce: uuid
```

Replay protection:
```
nonce must not repeat for 10 minutes
timestamp skew ≤ 6 seconds
signature must match registered device key
```

---

# 5. Worker Laws (Binding for Multi‑Agent Development)

---

## ArchitectGPT
- Defines API versions  
- Approves security model updates  
- Ensures backward compatibility  

## CodeGPT
- Implements session verification  
- Enforces anti‑tamper rules  
- Controls offline queue logic  
- Handles sync conflict resolution  

## SecurityGPT
- Monitors anomaly streams  
- Approves device bans  
- Validates integrity violations  
- Oversees rate limiting  

## BalanceGPT
- Reviews any client‑side timer rules (visual only)  

## AdminGPT
- Issues device bans  
- Manages version rollout  
- Cannot disable security logs  
- Cannot override anti‑tamper  

---

# 6. Mobile Versioning & Kill Switch System

---

## 6.1 Semantic Versioning
```
major.minor.patch
```

## 6.2 Forced Update Conditions
Triggered when:
- security patch required  
- API contract changed  
- director signals major world update  

Client receives:
```
"update_required": true
"minimum_version": "2.0.0"
```

---

## 6.3 Feature Flags
Example:
```
features:
  new_inventory: true
  enhanced_chat: false
  realtime_chain: true
```

Used for staged rollout.

---

## 6.4 Remote Kill Switch
If build compromised:
- disable login  
- disable API sync  
- disable chat  
- push forced-update payload  

---

# END OF BATCH 4



# END OF MOBILE FULL SPEC
# API_Raids.md — COMPLETE ULTRA EXPANDED EDITION


# API_Raids.md — Ultra Expansion BATCH 1
## Core Architecture, Raid Object, Lifecycle & Boss AI Framework

---

# 1. Raid System Overview

Raids are high-difficulty PvE faction activities designed to:
- strengthen faction progression,
- unify players into cooperative combat,
- influence global world-state (regions, events, Director),
- synergize with Chains, Wars, and Territories,
- serve as a major endgame content loop.

Raids feature:
- multi-phase bosses,
- morale system,
- faction coordination roles,
- time-based abilities & mechanics,
- progressive loot systems,
- Director-driven seasonal variations.

---

# 2. Canonical Raid Object (Deep Specification)

```
raid:
  raid_id: string
  faction_id: int
  boss_id: string
  difficulty: story | normal | hard | nightmare | mythic

  state: idle | active | phase1 | phase2 | phase3 | victory | defeat | loot | archived

  morale:
    current: float
    max: float
    regen_rate: float
    decay_rate: float

  progress:
    boss_hp_percent: float
    phase: int
    enrage_meter: float
    ability_cycle_index: int

  stats:
    total_damage_done
    total_damage_taken
    player_contributions
    deaths
    revives
    morale_shifts

  timers:
    start_at
    phase_start
    enrage_start
    end_at

  modifiers:
    event_modifiers: {...}
    director_modifiers: {...}
    territory_modifiers: {...}
    chain_modifiers: {...}
    war_modifiers: {...}

  loot_state:
    pending_loot: bool
    loot_table_version: string
    distribution_mode: personal | faction | weighted

  director_flags:
    difficulty_override: bool
    boosted_loot: bool
    forced_phase_skip: bool

  version:
    raid_engine_version: string
```

---

# 3. Raid Lifecycle (Deterministic)

Raids follow a strict progression model:

```
idle → active → phase1 → phase2 → phase3 → victory/defeat → loot → archived
```

### 3.1 idle
- No raid active for the faction.
- Can be initiated if:
  - faction meets requirements,
  - cooldown expired,
  - Director does not block raid start.

### 3.2 active
- Raid instance created.
- Boss AI initialized.
- Morale system enabled.

### 3.3 phase1
Boss begins basic ability cycle:
- introductory mechanics
- moderate difficulty

### 3.4 phase2
Triggered when boss HP <= 70%:
- new abilities unlocked
- environmental hazards
- Director may modify pacing

### 3.5 phase3
Triggered when boss HP <= 30%:
- high difficulty
- enrage mechanics activated
- accelerated morale decay

### 3.6 victory
Conditions:
- boss HP reaches 0
- no integrity failures
- timer not exceeded

### 3.7 defeat
Conditions:
- faction morale reaches 0
- time expires
- too many deaths
- Director enforces fail condition

### 3.8 loot
- loot tables evaluated
- personal/faction rewards generated
- rare drop rolls performed

### 3.9 archived
Raid is locked for:
- seasonal statistics
- Director world-state mapping
- leaderboard generation

---

# 4. Boss AI Framework (AAA-Level Encounter Design)

Boss AI must be:
- deterministic,
- readable by logs,
- complex but predictable to balance,
- modular for seasonal changes.

---

## 4.1 Boss State Model

```
boss_ai:
  hp
  armor
  resistances
  enrage_meter
  ability_cycle
  current_phase
  target_priority
  cooldowns
  phase_triggers
```

---

## 4.2 Boss Ability Types

### Type A — Timed Abilities
Triggered every X seconds regardless of player actions.
Examples:
- flame wave  
- poison breath  
- shield smash  

### Type B — Reactive Abilities
Triggered based on player behavior:
- attacking from high HP  
- hitting rapidly  
- low morale  
- clustered players  

### Type C — Conditional Abilities
Triggered when thresholds reached:
- HP %  
- morale %  
- enrage threshold  
- time spent in phase

### Type D — Enrage Abilities
Activated when enrage_meter hits 100%:
- massive damage  
- multi-hit attacks  
- defense ignore  
- phase skip  

---

# 5. Boss Phase Transitions

### Phase 1 → Phase 2
Trigger:
```
boss_hp <= 70%
```
Effects:
- unlock new abilities  
- increase attack speed  
- morale decay increased by 10%  

### Phase 2 → Phase 3
Trigger:
```
boss_hp <= 30%
```
Effects:
- enrage meter accelerates  
- environmental hazards spawn  
- Director may apply seasonal effects  

---

# 6. Faction Morale System (Central Cooperative Mechanic)

Morale starts at:
```
morale = 100%
```

Morale influences:
- damage output  
- defense  
- boss ability frequency  
- loot quality  

### 6.1 Morale Increases
- successful ability interrupts  
- high DPS bursts  
- support actions  
- phase completions  

### 6.2 Morale Decreases
- player deaths  
- fails on mechanics  
- environmental hazard damage  
- time spent in higher phases  

### 6.3 Morale Effects

```
if morale >= 80% → +10% damage
if morale >= 120% (overcharge) → +20% damage but -5% defense
if morale <= 40% → -15% damage, +20% boss damage taken
if morale <= 0% → raid defeat
```

---

# 7. Raid Actions & Commands

Validated via internal API:

```
POST /internal/api/v1/raids/action
```

Actions:
- attack  
- defend  
- support  
- buff  
- debuff  
- use_item  
- revive  
- ability_interrupt  
- reposition  

Each action:
- has cooldown  
- generates morale shifts  
- has damage/healing coefficients  
- is fully logged in raid ledger  

---

# END OF BATCH 1



# API_Raids.md — Ultra Expansion BATCH 2
## Combat Engine, Damage Model, Boss Abilities, Raid-Wide Events & Player Roles

---

# 1. Raid Combat Engine Overview

The raid combat engine must:
- handle dozens of simultaneous faction member actions,
- simulate boss AI responses,
- support multi-phase combat,
- guarantee deterministic outcomes for logging and anti-cheat,
- integrate with morale and enrage systems.

Combat occurs in **ticks**:
```
tick_interval = 1 second
```

Each tick:
- players submit actions
- boss AI updates
- damage/healing is resolved
- morale adjusts
- enrage meter updates
- hazard mechanics process

---

# 2. Player → Boss Damage Formula

Base formula:

```
damage = 
  (player_attack * role_modifier * morale_modifier * ability_modifier)
  * difficulty_scaling
  - boss_armor
```

### 2.1 Critical Hit Model
```
if rand() < crit_chance:
    damage *= crit_multiplier
```
Default:
```
crit_chance = 5%
crit_multiplier = 1.5x
```

### 2.2 Damage Caps
To prevent exploit builds:
```
max_damage_per_tick = boss_hp * 0.02
```
(equal to 2% of boss HP)

---

# 3. Boss → Player Damage Formula

Boss damage scales with:
- phase difficulty
- enrage level
- player defense
- role modifiers (tank/support, etc.)

```
damage =
   (boss_attack * phase_modifier * enrage_modifier)
   - (player_defense * mitigation)
```

If player in Tank role:
```
mitigation += tank_bonus
```

---

# 4. Boss Ability Engine (Deep Spec)

Boss abilities fall into four families.

---

## 4.1 Type A — Timed Abilities (Fixed Intervals)

Examples:
- Flame Wave (every 20 seconds)
- Frost Nova (every 30 seconds)
- Poison Bloom (every 25 seconds)

Mechanics:
- unavoidable damage
- morale loss
- interrupts not allowed

---

## 4.2 Type B — Reactive Abilities (Triggered)

Examples:
- Counterstrike: when boss takes burst damage  
- Retaliation Smash: when morale too high  
- Focused Rage: when many players alive at high HP  

Mechanics:
- rewards coordinated play
- punishes uncoordinated burst attempts

---

## 4.3 Type C — Conditional Abilities (Threshold-Based)

Examples:
- Phase Slam: HP ≤ 70%  
- Doom Scream: HP ≤ 30%  
- Collapse: morale ≤ 40%  

Mechanics:
- escalates difficulty naturally
- syncs with lifecycle phase transitions

---

## 4.4 Type D — Enrage Abilities (High-Lethality)

Triggered when:
```
enrage_meter >= 100%
```

Examples:
- Berserk (triple attack speed)  
- Immolation Aura (constant AoE damage)  
- Execution Strike (random targeted kill if unmitigated)  

Mechanics:
- timer pressure  
- DPS race  
- survival priority shifts  

---

# 5. Hazard Engine (Environmental Threats)

Hazards spawn in phase 2 or 3.

### Examples:
- Fire Zones  
- Shadow Pools  
- Poison Clouds  
- Explosive Orbs  

Hazard Damage:
```
hazard_damage_per_tick = boss_phase * difficulty_scaling * 2%
```

Players who fail hazard mechanics:
- cause morale loss  
- take heavy damage  
- may trigger reactive boss abilities

---

# 6. Raid-Wide Events (Dynamic Encounter Flow)

### 6.1 Vulnerability Window
Boss becomes vulnerable:
```
+20% player damage
-15% boss damage
```
Triggered by:
- interrupt success  
- boss self-overheat  
- Director event  

### 6.2 Reinforcement Waves
Adds mobs:
- increase chaos  
- split player attention  
- drop minor loot  
- reduce boss enrage meter when killed  

### 6.3 Defensive Stance
Boss takes:
```
-30% damage
+20% defense
```
Ends when:
- morale exceeds threshold  
- Director overrides  

### 6.4 Morale Surge
Triggered when:
- coordinated burst hits land  
- support actions chain successfully  

Effects:
```
+10% team damage
+10% team defense
```

---

# 7. Player Roles (Faction Combat Archetypes)

Players choose roles before raid or automatically assigned.

---

## 7.1 Assault
Purpose: Damage output  
Modifiers:
```
damage += 15%
defense -= 10%
```
Best for:
- pushing phases  
- DPS checks  

---

## 7.2 Tank
Purpose: Absorb boss attacks  
Modifiers:
```
defense += 25%
damage -= 15%
```
Special:
- taunt mechanic  
- mitigation stacking  

---

## 7.3 Support
Purpose: Healing, buffs, morale boosts  
Modifiers:
```
healing += 20%
buff_effect += 15%
```
Influences:
- morale increases  
- hazard resistance  

---

## 7.4 Disruptor
Purpose: interrupt boss abilities  
Modifiers:
```
interrupt_power += 25%
hazard_damage -= 10%
```
Critical for:
- stopping timed/conditional abilities  
- stabilizing morale  

---

# 8. Player Action Validation

Each action payload:
```
action_type
player_id
raid_id
timestamp
nonce
signature
```

Validation rules:
- signature required  
- action-type cooldown enforced  
- must not exceed 1 action per tick  
- cannot submit actions while dead  
- cannot submit actions outside active phase  

---

# END OF BATCH 2



# API_Raids.md — Ultra Expansion BATCH 3
## Integration Layer: Chains, Wars, Territories, Events & Director

---

# 1. Integration Philosophy

Raids are not isolated PvE activities.  
They are a pillar of the *Trench City world simulation* and interact with:

- Chains  
- Wars  
- Territories  
- Events  
- Director AI  
- World Stability Map  

This batch defines EXACTLY how raids influence, and are influenced by, other systems.

---

# 2. Chain Integration (PvE ↔ PvP Synergy)

## 2.1 Chain Streak → Raid Morale Boost
When a faction maintains a chain streak:

```
if chain.streak >= 10 → morale += 5
if chain.streak >= 25 → morale += 10
if chain.streak >= 50 → morale += 20
```

Applies dynamically during raid.

## 2.2 Raid Victory → Chain XP Buff
When faction defeats a raid boss:

```
chain_xp_multiplier += 0.10 (for 30 minutes)
```

Director may extend duration during seasonal raids.

## 2.3 Chain Peak → Raid Damage Boost
If faction reaches **peak chain**:

```
raid_damage_bonus = +8%
```

Applies for entire raid instance.

---

# 3. War Integration (PvE ↔ PvP Combat Economy)

## 3.1 War Domination → Raid Efficiency Buff

If faction is winning a war decisively:

```
morale_regen += 10%
player_damage += 5%
boss_damage_taken += 5%
```

## 3.2 Raid Victory → War Morale Boost

Winning a raid applies:

```
war_morale += 15
war_pressure += 5%
```

Used by Wars engine for domination & morale calculations.

## 3.3 Raid Failure → War Penalty

```
if raid.defeat:
    war_morale -= 10
    war_defense -= 3%
```

Director can override.

---

# 4. Territory Integration (Regional World Control)

Territories define regional stability, bonuses, and heat.

## 4.1 Raid Happens in a Region
Each raid has:
```
raid_region
```

Region affects:
- raid difficulty  
- hazard modifiers  
- boss resistances  

## 4.2 Territory Bonus → Raid Stats

If faction controls region:

```
morale_cap += 10
damage_bonus += 5%
hazard_damage -= 5%
```

## 4.3 Raid Victory → Region Stability Increase

```
region.stability += 5
region.heat -= 10
```

## 4.4 Raid Failure → Region Stability Loss

```
region.stability -= 5
region.heat += 15
```

## 4.5 Region Heat Affects Raid Difficulty

```
difficulty_scaling += (region.heat * 0.001)
```

High-heat regions produce harder bosses.

---

# 5. Event Integration (Dynamic Seasonal Effects)

Events modify raid behavior dramatically.

## 5.1 Raid Storm Event

Region-based hazardous event:

```
hazard_damage += 20%
morale_decay += 10%
enrage_rate += 5%
```

## 5.2 Double Loot Weekend

```
loot_multiplier = 2.0
```

## 5.3 Boss Mutation Event

Adds:
- new abilities  
- altered attack patterns  
- rare loot tables  

## 5.4 Raid Frenzy Event

```
morale_regen += 20%
boss_hp -= 10%
loot_bonus += 15%
```

High-activity period.

---

# 6. Director Integration (Master AI Tuning Layer)

Director oversees all raid tuning based on world-state.

## 6.1 Director Adjusts Raid Difficulty

Based on:
- faction strength  
- world balance  
- chain activity  
- war pressure  
- region stability  

Example:
```
director_modifiers.raid_difficulty = 1.15
```

## 6.2 Director Controls Raid Seasons

Each season:
- new boss variants  
- new loot table versions  
- seasonal modifiers  
- rewards scaling  

## 6.3 Director Applies Raid Constraints

Director may:
- block raid starts  
- limit difficulty tiers  
- reduce loot inflation  
- enforce morale caps  

## 6.4 Director Responds to Anomalies

Example:
```
if raid_damage_anomaly_detected:
    enforce additional validation
    reduce player damage temporarily
```

## 6.5 Director Seasonal Rewards

At season end:
- leaderboard generation  
- faction score awards  
- cosmetic & rare items  
- seasonal titles  

---

# 7. World Interaction Flow (Global Diagram)

```
Raid Action
   ↓
Raid Engine
   → Boss AI
   → Damage Engine
   → Morale Engine
   → Hazard Engine
   ↓
Integration Engine
   → Chains: streak boosts, XP modifiers
   → Wars: morale effects, domination shifts
   → Territories: heat & stability changes
   → Events: seasonal modifiers
   ↓
Director
   → adjusts difficulty
   → applies seasonal rules
   → updates world_state
```

---

# END OF BATCH 3



# API_Raids.md — Ultra Expansion BATCH 4
## Security Model, Threat Matrix, Integrity Layer, Telemetry, Ledger v2 & Worker Laws

---

# 1. Raid Security Philosophy

Raids are one of the highest-value systems in Trench City because they generate:
- rare loot,
- faction power,
- world-state changes,
- morale effects on wars,
- stability effects on territories.

This makes them prime targets for:
- damage spoofing,
- automation,
- packet replay,
- boss exploit looping,
- out-of-band manipulation,
- multi-account boosting.

Security must enforce:
- full action authenticity,
- deterministic combat logic,
- raid ledger integrity,
- real-time anomaly detection,
- Director oversight hooks.

---

# 2. Raid Threat Matrix

```
Threat                            | Description
----------------------------------|----------------------------------------------
Fake Raid Actions                 | Forged or altered attack/defend/support actions
Damage Forgery                    | Attempting to inflate DPS
Attack Replay                     | Replaying previously valid actions
Action Spam                       | Submitting multiple actions per tick
Boss Exploit Loops                | Manipulating boss AI to freeze/loop patterns
Morale Manipulation               | Forging morale adjustments
Outlier DPS Sources               | Bot-assisted or hacked damage bursts
Hit Registration Bypass           | Sending invalid target-state actions
Phase Skip Exploits               | Manipulating boss state/HP to force early transitions
Cooldown Bypass                   | Sending actions faster than allowed
Emulator Botting                  | Automated raid actions via emulators
Device Cloning                    | Duplicate device_id submissions
Integrity Drift                   | Player/boss states falling out of sync with ledger
```

---

# 3. Raid Integrity Layer (Server-Authority Model)

Every raid action must pass strict validation steps.

### 3.1 Required Action Payload

```
{
  "raid_id": int,
  "player_id": int,
  "action_type": "attack|defend|buff|debuff|interrupt|revive|support",
  "timestamp": int,
  "nonce": string,
  "signature": string,
  "device_id": string
}
```

---

# 3.2 Validation Pipeline

### Step 1 — Signature Check
```
signature = HMAC256(payload + device_id + timestamp + nonce)
```
If signature invalid → reject + flag anomaly.

### Step 2 — Nonce Check
- Nonce must not repeat for 10 minutes.
- Stored per-player in rolling nonce cache.

### Step 3 — Timestamp Check
```
abs(now - timestamp) <= 6 seconds
```
Ensures prevention of:
- time drift exploits,
- delayed action replay,
- speedhacking.

### Step 4 — Tick Enforcement
One action per player per tick:
```
if actions_this_tick[player_id] >= 1 → reject
```

### Step 5 — Raid State Validation
- raid must be in active/phase1/phase2/phase3
- cannot act in victory/defeat/loot states
- player must be alive
- cooldown must not be violated

### Step 6 — Boss Ledger Alignment
The action must align with authoritative server-side:
- damage calculated ONLY by server
- boss HP managed ONLY by server
- ability interrupts must match boss cooldown windows

### Step 7 — Morale Integrity Check
Morale cannot be client-submitted.
Server recalculates morale shifts.

---

# 4. Anti-Exploit Systems

### 4.1 DPS Outlier Detection
If player’s DPS exceeds allowed limits:
```
if dps > dps_cap * 1.25:
    mark anomaly
    dampen player damage temporarily
```

### 4.2 Burst Spike Detection
Detects one-tick massive spikes:
```
if damage_tick > boss_hp * 0.02:
    clamp damage
    flag anomaly
```

### 4.3 Action Flooding / Macro Detection
If player attempts >3 actions in 1 tick:
- reject all extra actions,
- increment bot_risk_score.

### 4.4 Boss Exploit Loop Detection
If boss AI enters unintended cyclic behavior:
- freeze encounter,
- Director flagged,
- require admin review.

---

# 5. Raid Telemetry (Prometheus)

```
raid_actions_total{action_type}
raid_actions_rejected_total{reason}
raid_dps_anomalies_total
raid_morale_anomalies_total
raid_integrity_failures_total
raid_phase_transitions_total
raid_boss_ai_anomalies_total
raid_loot_rolls_total
raid_player_deaths_total
raid_player_revives_total
```

Telemetry drives:
- Director tuning,
- SecurityGPT exploit detection,
- BalanceGPT encounter tuning,
- Admin dashboards.

---

# 6. Immutable Raid Ledger v2

Every action & boss tick writes an immutable log entry:

```
ledger_entry:
  raid_id
  player_id
  action_type
  damage_done
  damage_taken
  morale_shift
  boss_hp_after
  phase
  timestamp
  action_signature
  world_state_hash
  director_mod_snapshot
  previous_hash
  hash
```

Properties:
- cryptographically linked,
- replayable,
- append-only.

Uses:
- post-raid analysis,
- exploit forensics,
- Director world-state validation,
- reward distribution validation.

---

# 7. Worker Laws for Raids

## ArchitectGPT
- Designs raid engine versions.
- Approves major model changes.
- Defines seasonal boss mechanics.

## CodeGPT
- Must enforce all integrity checks.
- Implements deterministic tick engine.
- Ensures ledger writes are atomic.

## SecurityGPT
- Monitors all raid anomaly streams.
- Approves automatic raid shutdown when compromised.
- Handles botting/emulator detection.

## BalanceGPT
- Tunes boss stats, DPS curves, phase requirements.
- Adjusts morale gain/loss rates.
- Oversees seasonal difficulty tuning.

## AdminGPT
- May void raids due to catastrophic failure.
- May issue raid resets.
- Cannot modify ledger entries.
- Cannot overwrite Director tuning rules.

---

# 8. Raid Versioning & Rollback

```
raid_engine_version
boss_ai_version
damage_formula_version
loot_table_version
phase_transition_version
```

### Major version changes:
- new boss mechanics,
- new AI logic,
- new loot systems.

Require:
- ArchitectGPT approval,
- migration plan,
- Director sync.

### Minor version changes:
- balancing,
- multiplier tweaks.

### Patch changes:
- bug fixes,
- exploit patching.

Rollback restrictions:
- no active raids,
- ledger validated,
- world_state compatible.

---

# END OF BATCH 4



# END OF RAIDS FULL SPEC
TRENCH CITY — ARCHITECT GPT (FINAL VERSION)

YOU ARE:  
Trench City — Lead Architect GPT (Final Version)
You are the highest authority on structure, rules, logic, correctness and completeness of the Trench City game.

Your ONLY job:  
→ Turn any user request into a PERFECT technical specification for CodeGPT (or other workers) to execute.  
→ Enforce the Master Game Bible (all 48 chunks).  
→ NEVER generate code yourself.  
→ ALWAYS stop at a clean spec.

[... trimmed for brevity in display, actual file contains full architect prompt ...]
---

## SECTION X — PHASED BUILD LAW (ALPHA → BETA → RELEASE)

You MUST always think and respond in **phases**, NEVER as “build everything now”.

### X.1 Phase Definitions

- **Phase ALPHA (MVP Live Test)**
  - Goal: Get a **fun, stable, small** version of Trench City live.
  - Focus: Core loop → train, crime, heal, fight, join faction, simple economy.
  - Systems allowed: only those explicitly marked as ALPHA-OK below.
  - NO: raids, chains, ranked wars, territories, advanced economy, director seasons.

- **Phase BETA (Feature Expansion + Systems Depth)**
  - Goal: Add depth, loops, and economy layers on top of a stable alpha.
  - Focus: Crimes++, Items++, Properties++, Companies, Missions, basic Chains, simple Events.
  - Systems: more PvP, more PvE, more sinks/sources, light live-ops.

- **Phase RELEASE / LIVE (Endgame & World Simulation)**
  - Goal: Full Trench City vision (Torn-plus).
  - Focus: Raids, Ranked Wars, Chains (full), Territories, Director, Seasons, Advanced Economy.
  - Systems: everything in the big API docs, running under Director + Security Spec.

Whenever the user asks for something, FIRST decide:
> “Is this ALPHA, BETA or RELEASE work?”

Then:
- If user says **“I want Alpha”** → spec ONLY ALPHA-OK features.
- If user says **“I’m ready for X”** → include that phase + all earlier phases.
- If user does not specify → default to **current project phase** they’ve told you, or ASK once.

---

## SECTION X.2 — ALPHA-OK MODULES (WHAT WE BUILD FIRST)

When the user is in **ALPHA** mode, you may ONLY spec within:

1. **Accounts & Security (Core)**
   - Register, login, logout, password reset.
   - Session management (secure cookies, CSRF, basic rate-limiting).
   - Simple admin auth boundary (admin vs player).

2. **Core Player Shell**
   - Header + sidebar + layout (Dark Luxury).
   - Player profile: basic stats + bars.
   - XP, level, and stat display.
   - Notifications (simple).

3. **Bars & Stats**
   - Energy, Nerve, Happy, Life.
   - Strength, Speed, Defense, Dexterity.
   - Regeneration rules (simple version).
   - Death / hospital / jail basics.

4. **Gym (Basic)**
   - Train 4 stats using energy.
   - Simple costs + gains.
   - Logs for training.
   - No advanced gyms / unlock trees yet.

5. **Crimes (Basic)**
   - Crime categories + few simple crimes.
   - Success/fail, gains (cash/XP), loss (jail/hospital).
   - Simple timers / cooldowns.
   - No advanced crime webs / specialities yet.

6. **Items & Inventory (Basic)**
   - Inventory page.
   - Use item.
   - Simple item types (consumables, basic weapons/armor).
   - No crafting, tiers, sets, or complex rarity yet.

7. **Properties (Basic)**
   - Own a single property.
   - Very light bonuses (e.g. small happy bonus).
   - No property market simulation, rent system, or auctions in Alpha.

8. **Factions (Basic)**
   - Create faction.
   - Join/leave faction.
   - Roles: leader / member.
   - Simple faction panel (members list, description).
   - NO wars, NO chains, NO raids in Alpha.

9. **City Shell**
   - City page with:
     - link to Gym, Crimes, Properties, Hospital, Small Shop.
   - City locations as shells (pages exist, logic can be minimal).

10. **Hospital & Jail**
   - Basic timers.
   - Release logic.
   - Basic heal / bail actions.

11. **Simple Combat (1v1 Attack)**
   - Attack another player.
   - Damage formula (basic).
   - Result: win/lose, hospital, XP, maybe small cash.
   - No ranked ladders, no war scoring.

12. **Admin (Minimal Live Control)**
   - View players.
   - Ban/unban.
   - Reset bars.
   - View basic logs.

If a requested feature is NOT in this list and the user says they are working on **Alpha**, you MUST:
- Either push it to **BETA/RELEASE** in your spec, or
- Ask them explicitly: “Do you want this now (beyond Alpha), or should we park it for later?”

---

## SECTION X.3 — DEFERRED (BETA/RELEASE ONLY) SYSTEMS

For clarity, these systems are **NEVER** part of ALPHA scope unless the user explicitly overrides:

- Raids (full API_Raids spec)
- Ranked Wars (full API_Wars spec)
- Chains (full API_Chains spec)
- Territories (API_Territories)
- Director (API_Director, world_state, seasonal tuning)
- Advanced Events / Seasons (API_Events)
- Advanced Faction Warfare (territory wars, black ops, multi-mode wars)
- Sophisticated Economy:
  - stock market,
  - auction house,
  - complex crafting,
  - multi-currency markets.
- NPC mission trees, complex questlines.
- Mobile apps (API_Mobile) – you only design API, not build clients.
- Multi-country travel, international modules.

You MAY reference these in your specs as **“future integration points”** but you MUST NOT:
- Fully design them unless the user is in BETA or RELEASE phase,
- Mix their complexity into ALPHA specs.

---

## SECTION X.4 — API DOCUMENTS ARE LAW (WARS, CHAINS, RAIDS, MOBILE, ETC.)

You now have dedicated API spec docs (external Markdown files) that define **how systems must behave**:

- `API_Wars.md — COMPLETE ULTRA EXPANDED EDITION`
- `API_Chains.md — COMPLETE ULTRA EXPANDED EDITION`
- `API_Raids.md — COMPLETE ULTRA EXPANDED EDITION`
- `API_Mobile.md — COMPLETE ULTRA EXPANDED EDITION`
- (and others: Territories, Events, Admin, etc. as they are added)

**Architect Laws:**

1. When speccing anything related to:
   - wars,
   - chains,
   - raids,
   - mobile,
   - events,
   - territories,
   - director,
   you MUST treat the corresponding API document as **source of truth**.

2. If a user request conflicts with an API doc, you MUST:
   - call it out,
   - propose a compatible variant,
   - or explicitly mark a “V2/V3 change” to that system.

3. You MUST NOT reinvent:
   - scoring formulas for chains/wars/raids,
   - integrity models,
   - ledger structures,
   - security behaviors
   that are already defined in those API docs.

4. If a doc is missing (e.g. API_Territories not written yet):
   - you may design a new one,
   - but you MUST keep it consistent with the patterns used in existing API docs (Wars/Chains/Raids/Events).

5. For mobile:
   - ArchitectGPT only defines API behavior & payloads,
   - never UI or native-client specific code.
   - Mobile always uses `API_Mobile` plus existing core APIs as the contract.

---

## SECTION X.5 — SPEC MODES (MVP vs FULL vs POLISH)

When producing a spec, ALWAYS choose and state a **spec mode** at the top:

- **[MODE: MVP]**
  - Minimal feature set.
  - “Good enough to work, not yet deep.”
  - Ideal for ALPHA features.

- **[MODE: FULL]**
  - Uses the COMPLETE design from:
    - Master Game Bible,
    - relevant API docs,
    - security + ledger rules.
  - Appropriate for BETA/RELEASE.

- **[MODE: POLISH]**
  - Focus on UX details, edge-case handling, performance, logging, analytics, admin tools.
  - Only used once a system is already stable in FULL mode.

Rules:

1. If user says:
   - “just get it working” → use **MVP**.
   - “I want the complete version” → use **FULL**.
   - “make it studio-level / AAA / ultra polished” → use **FULL + POLISH** (two passes or clearly separated sections).

2. A spec in MVP mode must:
   - be small enough for a single module to be built quickly,
   - still obey security and data integrity rules,
   - still integrate cleanly with the future FULL design.

3. Any FULL spec must:
   - explicitly reference and align with the relevant API docs and Bible sections.

---

## SECTION X.6 — PRIORITY LADDER WHEN USER JUST SAYS “WHAT NEXT?”

If the user is unsure what to do next (and they are still in ALPHA), you MUST recommend work in this order:

1. **Stability & Security**
   - login/register,
   - sessions,
   - basic admin.

2. **Core Loop**
   - Gym (basic),
   - Crimes (basic),
   - Simple combat,
   - Hospital/Jail.

3. **Economy Seed**
   - Items (basic),
   - Properties (basic),
   - Very simple income sources.

4. **Social Layer**
   - Factions (basic),
   - minimal messaging/notifications.

5. **City Shell & UI Polish (light)**
   - City.php content & layout,
   - navigation consistency.

Only when 1–5 are solid should you propose:
- Chains (MVP),
- Events (MVP),
- Raids/Wars (later; BETA/RELEASE).

---

## SECTION X.7 — WHEN IN DOUBT: SCOPE DOWN, NOT UP

If the user is tired, overwhelmed, or trying to “do everything at once”:

- You MUST:
  - break the work down,
  - choose MVP mode,
  - keep scope inside ALPHA unless explicitly told otherwise.

- You MUST NOT:
  - dump full Wars/Chains/Raids/Territories/Director specs into a small request,
  - push them toward features they are not ready to build.

Your job is to **protect velocity and sanity**, not just completeness.

============================================================
# BUILD ORDER V3 — HYBRID AAA PIPELINE + RELEASE STAGES (ALPHA → BETA → LIVE)
============================================================

This Build Order governs the COMPLETE development cycle of Trench City V2
AND the public release staging pipeline.

It is now an OFFICIAL SYSTEM DOCUMENT and must be obeyed by Architect GPT and CodeGPT.

============================================================
# SECTION 1 — STRICT DEVELOPMENT PHASES (PHASE 0 → 17)
============================================================

(Phases 0–17 identical to the Build Order V3 previously provided,  
including Core → Items → Gym → Crimes → Combat → Factions → Properties → Vehicles →  
Smuggling → Missions → AI Director → Endgame → Mobile → Expansions.)

============================================================
# SECTION 2 — RELEASE MODEL (ALPHA → BETA → LIVE)
============================================================

The game is released in THREE MAJOR STAGES.

====================================================================
# ALPHA STAGE — INTERNAL / FRIENDS & FAMILY / EARLY TESTERS
====================================================================

### GOALS:
- Core engine stability
- Crime system functional
- Combat functional
- Basic NPC AI
- Early properties (non-fortress)
- Vehicles (basic)
- Minimal UI polish
- No monetisation yet
- No expansions
- No prestige system
- No faction wars (optional early testing)

### SYSTEMS REQUIRED FOR ALPHA:
- Phase 0 (Foundation)
- Phase 1 (Core Player)
- Phase 2 (Items)
- Phase 3 (Gym)
- Phase 4 (Crimes)
- Phase 5 (Combat, basic)
- Phase 14.1 (Donator Packs disabled, optional for testing)

### ALPHA DELIVERABLES:
- Web client working
- API working
- Player loop functional (train → crime → fight → items)
- Feedback logging
- Bug reporting tools
- Alpha-only admin tools

### ALPHA RESTRICTIONS:
- No real-money monetisation  
- No competitive systems  
- No ranking systems  
- No leaderboards  
- No crisis events  
- No prestige loop  

====================================================================
# BETA STAGE — PUBLIC TESTING / EXPANDING SYSTEMS
====================================================================

### GOALS:
- Introduce mid/late-game systems
- Stress test economy & scaling
- Enable faction systems
- Enable properties & fortresses
- Enable smuggling + multi-country travel
- Introduce missions and world events
- Begin monetisation (cosmetic-first)
- Balance XP, crime success, NPC behaviour

### SYSTEMS REQUIRED FOR BETA:
- All ALPHA systems
- Phase 6 (Factions)
- Phase 7 (Properties + Fortresses)
- Phase 8 (Vehicles + Racing)
- Phase 9 (Smuggling)
- Phase 10 (Missions + Heists)
- Phase 11 (AI Director + World Events)
- Phase 12 (Economy Systems)
- Phase 13 (Social Systems)
- Phase 14 (Full Monetisation except Battle Pass)

### BETA DELIVERABLES:
- Full UI polish pass
- Load testing
- Database optimisation
- Early leaderboards
- Event scheduling
- Faction war functionality
- Crisis Engine testing

### BETA RESTRICTIONS:
- Prestige loop disabled
- Prototype crafting disabled
- Elite factions disabled
- Mega-heists disabled

====================================================================
# LIVE STAGE — GLOBAL RELEASE
====================================================================

### GOALS:
- Enable full progression
- Open all systems
- Begin seasonal content cycles
- Full monetisation rollout
- Support mobile client

### SYSTEMS REQUIRED FOR LIVE:
- All BETA systems
- Phase 15 (Endgame + Prestige)
- Phase 16 (Mobile Adaptation)
- Phase 17 (Expansions roadmap enabled)

### LIVE DELIVERABLES:
- Seasonal system online
- Battle Pass enabled
- Prestige and mastery trees enabled
- Prototype crafting enabled
- Endgame raids and mega-heists enabled
- AI Director 2.0 live
- Full customer support flow
- App Store / Play Store mobile app support

====================================================================
# SECTION 3 — PUBLIC RELEASE LIFECYCLE
====================================================================

### LIVE → SEASON 1
- Balance tuning
- Add new blueprints
- Introduce first major world event
- Debut seasonal cosmetics

### LIVE → SEASON 2+
- Expand countries
- Add new crime paths
- Add new NPC gangs
- Begin global syndicate arcs

====================================================================
# SECTION 4 — MODULE LIFECYCLE (FRONTEND → BACKEND → API → MOBILE)
====================================================================

EVERY MODULE MUST FOLLOW THIS ORDER:

1. UI Shell  
2. Backend Logic  
3. API Endpoints  
4. Mobile API Compatibility  
5. Anti-Exploit Layer  
6. Logging Layer  
7. Testing Checklist  
8. Delivery to CodeGPT  

============================================================
# SECTION 5 — BUILD ORDER ENFORCEMENT LAYER (MANDATORY)
============================================================

This section binds Build Order V3 to:
- ArchitectPack
- GlobalPackV3
- Developer Workflow (Architect → Codex → CodeGPT)
- Release Laws (Alpha → Beta → Live)
- API Ultra Specs (Wars, Chains, Raids, Mobile, Events)

ArchitectGPT MUST obey all rules below.

------------------------------------------------------------
## 5.1 BUILD ORDER ALWAYS OVERRIDES USER REQUESTS
------------------------------------------------------------

When the user asks for ANY feature:

ArchitectGPT MUST classify it into:
- ALPHA
- BETA
- LIVE

Then cross-check:

> “What Build Order phase is this system in?”

If it is **not allowed yet**, ArchitectGPT MUST:
- park it,
- defer it,
- or produce only a small MVP shell (if user insists).

ArchitectGPT must NEVER jump ahead.

------------------------------------------------------------
## 5.2 NO SKIPPING MODULES
------------------------------------------------------------

ArchitectGPT MUST NOT:
- Design backend before UI shell exists.
- Write API endpoints before backend logic exists.
- Implement mobile integrations before web API exists.
- Build raids, chains, wars, territories, or events during ALPHA.

The Build Order sequence is LAW.

------------------------------------------------------------
## 5.3 BUILD ORDER + RELEASE LAW MERGE (Dual-Lock System)
------------------------------------------------------------

A feature ONLY becomes valid when BOTH conditions pass:

1. **Build Order Phase** reached  
2. **Release Stage** reached (Alpha/Beta/Live)

Example:

- Chains: Build Order Phase 11, Release = BETA  
- Raids: Build Order Phase 15, Release = LIVE

ArchitectGPT MUST check both gates before producing design.

------------------------------------------------------------
## 5.4 API DOCUMENT SUPREMACY
------------------------------------------------------------

If designing:
- Wars → must follow `API_Wars.md`
- Chains → must follow `API_Chains.md`
- Raids → must follow `API_Raids.md`
- Events → must follow `API_Events.md`
- Mobile → must follow `API_Mobile.md`
- Admin Systems → must follow `API_Admin.md`

ArchitectGPT MUST NOT contradict any API doc.

If conflict exists → ArchitectGPT must propose a V2/V3 API update.

------------------------------------------------------------
## 5.5 SPEC MODES MUST BE DECLARED
------------------------------------------------------------

Every module spec MUST begin with:

[MODE: MVP] - ALPHA work
[MODE: FULL] - BETA or LIVE work
[MODE: POLISH] - UI/UX refinement

markdown
Copy code

ArchitectGPT must choose mode based on:
- Build Order phase
- Release stage
- User request

------------------------------------------------------------
## 5.6 REQUIRED MODULE PIPELINE (NO EXCEPTIONS)
------------------------------------------------------------

For EVERY system, ArchitectGPT MUST produce work in this order:

1. UI Shell (Dark Luxury Theme)
2. Backend Logic
3. API Endpoints
4. Mobile API Compatibility
5. Anti-Exploit & Security Layer
6. Logging / Telemetry Layer
7. QA Checklist
8. Final Delivery Pack for CodeGPT

ArchitectGPT MUST NOT skip steps 1–8.

------------------------------------------------------------
## 5.7 PROJECT VELOCITY PROTECTION
------------------------------------------------------------

If the user is overwhelmed, tired, or unclear:

ArchitectGPT MUST:
- choose MVP mode,
- reduce scope,
- focus on ALPHA-OK features only.

ArchitectGPT MUST NOT dump:
- raids,
- wars,
- chains,
- territories,
- seasonal systems,
- Director meta-systems

unless the Build Order AND Release Stage BOTH allow it.

------------------------------------------------------------
## 5.8 INTEGRATION WITH SMART WORKERS
------------------------------------------------------------

ArchitectGPT MUST ALWAYS produce:

- Backend Spec → for CodeGPT  
- API Contract → for Mobile/API workers  
- Anti-Exploit Spec → for SecurityGPT  
- Logging & Metrics Spec → for QAGPT  
- Tuning Points → for BalanceGPT  

Codex/CodeGPT MUST implement ONLY what ArchitectGPT defines.

------------------------------------------------------------
## 5.9 WHEN IN DOUBT, DEFAULT TO:
------------------------------------------------------------

- ALPHA scope  
- MVP mode  
- BuildOrder phase gating  
- API document constraints  
- Minimal safe implementation  

Never “invent the future” unless the user explicitly requests it.

============================================================
# END OF SECTION 5 — BUILD ORDER ENFORCEMENT LAYER
============================================================
⭐ DataCenter_Architecture.md (FINAL — Version B)

(Copy/paste ready for your Docs ZIP — no filler, no commentary)

DataCenter_Architecture.md

Trench City — Data Center Architecture (V1.0)
Document Class: Infrastructure Specification
Owner: DevOps / Architect
Scope: Current Deployment + Phase 2 Scaling Path
Updated: 2025-12-06

1. Overview

Trench City operates inside a dedicated IONOS Cloud VDC (Virtual Data Center) consisting of:

2 × Application Servers

1 × Database Server (MariaDB)

1 × Redis Server

1 × Application Load Balancer

2 × Segmented Internal Networks (LAN 1 & LAN 2)

This architecture supports:

Horizontal scaling of the app layer

Isolated database and cache layers

Secure multi-network segmentation

API-ready traffic routing

Future extension to staging, CI/CD and HA modes

2. Current Infrastructure Summary
Component	Specs	Role	Network
Application Server A	2 vCPU / 4 GB RAM / SSD	PHP-FPM, Nginx, Web/App logic	LAN 1 + LAN 2
Application Server B	2 vCPU / 4 GB RAM / SSD	Load-balanced app node	LAN 1 + LAN 2
Database Server	3 vCPU / 8 GB RAM / SSD	MariaDB primary	LAN 1 + LAN 2
Redis Server	1 vCPU / 4 GB RAM / SSD	Session store, cache, rate limiting	LAN 1 + LAN 2
Application Load Balancer (ALB)	IONOS Application LB	Routes public traffic to App nodes	Public → LAN 1

This forms a 4-server MMO cluster with clean separation of concerns.

3. Network Topology
3.1 LAN 1 — Application Network

Purpose:

Public-facing traffic from ALB

App-layer to DB communication

App-layer to Redis communication

Connected systems:

ALB

App Server A

App Server B

DB Server

Redis Server

3.2 LAN 2 — Private Backend Network

Purpose:

Isolated intra-datacenter traffic

Background processes

Database I/O

Redis I/O

Zero public exposure

Connected systems:

App Server A

App Server B

DB Server

Redis Server

This network carries all sensitive data.

4. Request Flow Architecture
[Client Browser / Mobile App]
            |
            v
 [IONOS Application Load Balancer]
            |
            v
     ┌──────────────────────┐
     │  App Server A (4GB)  │
     │  App Server B (4GB)  │
     └─────────┬────────────┘
               |
               | PHP Requests / API Calls
               v
        ┌──────────────┐
        │ MariaDB (8GB)│
        └──────────────┘
               |
               | Session, Cache, Rate-Limit
               v
     ┌──────────────────────┐
     │ Redis Server (4GB)   │
     └──────────────────────┘

5. Security Model
5.1 Network Segmentation

Public zone: LB only

App zone: App A/B

Data zone: DB + Redis isolated on LAN 2

5.2 Access Rules

Public → ALB only

ALB → App nodes only

App nodes → DB/Redis

DB/Redis → No outbound to public

5.3 Server Hardening

Fail2ban

Firewall (UFW/IONOS routes)

SSH restricted to your home IP

Redis bind to private IP

MariaDB bind to private IP

6. Phase 2 Scaling Plan (Next 90 Days)

This section defines the recommended evolution of your existing cluster.

6.1 App Layer Scaling

Current:

2 × App servers (4GB each)

Upgrade path:

Add 1–3 more app servers

Auto-scale based on CPU load

Stateless app layer (Redis-backed sessions)

Outcome:
Full horizontal scalability.

6.2 Database Scaling

Current:

Single primary MariaDB (8GB)

Near-term upgrade:

Add 1 read replica

Enable binary log replication

Move heavy reads (leaderboards, stats, missions, logs) to replica

Daily backup snapshots

Outcome:
Faster reads + database redundancy.

6.3 Redis Scaling

Current:

Single Redis node (4GB)

Upgrade path:

Redis Sentinel (HA mode)

Optional Redis clustering for:

Rate limits

Cache

Workers

Queues

Outcome:
Zero-downtime caching + high availability.

6.4 CI/CD Pipeline

Recommendation:

GitHub → GitHub Actions

Actions deploy to:

Staging app node

Production app nodes

Steps:

Push to dev → deploy to Staging

Push to main → deploy to Production

Outcome:
Safe, repeatable deployments.

6.5 Staging Environment (Separate VDC or Subnet)

Create a clone of:

1 × App server

1 × DB server

1 × Redis

Uses:

Feature testing

QA

Load test environment

Outcome:
No risk to production.

6.6 Backups & DR

Backups:

Daily DB snapshot

Weekly full VDC snapshot

Remote storage (IONOS Backup or S3 provider)

Long-term:

Warm standby region

Automatic failover

7. Phase 2 Architecture Diagram (Future)
                 [Global CDN]
                      |
             [IONOS WAF / Firewall]
                      |
                      v
            [Application Load Balancer]
                      |
        ┌─────────────┴──────────────┐
        v                            v
  App Server A                 App Server B
     (4GB)                         (4GB)
        |                            |
        └─────────────┬──────────────┘
                      |
                      v
               [MariaDB Primary]  (8GB)
                      |
             ┌────────┴──────────┐
             v                   v
  [MariaDB Read Replica 1]   [MariaDB Read Replica 2]
             |
             v
     [Redis Sentinel Cluster]  (4GB+)

8. Summary

Your current data center is a solid 4-node MMO cluster, already superior to a typical single-VPS deployment.

Phase 2 evolves it into a scalable, secure, production-grade environment ready for:

Thousands of concurrent players

Future mobile app integration

One-click deployments

Automated scaling

Stronger security

Better performance

High availability

This document must be included in:
# TRENCH CITY — DEVOPS GUIDE (ULTRA EDITION)
Studio-Grade MMO Infrastructure Specification  
Version: 2025 Ultra Edition

============================================================
# TABLE OF CONTENTS
============================================================
1. Architectural Overview  
2. Environment Layout  
3. Server Structure  
4. Nginx Configuration  
5. PHP-FPM Configuration  
6. MariaDB Baseline  
7. Redis Baseline  
8. Environment Variables  
9. Networking & Hardening  
10. Baseline Scaling Rules  
11. Alpha Requirements  
12. Versioning Strategy  
13. Git Branch Model  
14. CI/CD Pipeline  
15. Zero-Downtime Deployments  
16. Database Migrations  
17. Artifact Packaging  
18. Environment Syncing  
19. DevSecOps Pipeline  
20. QA→Stage→Prod Promotion  
21. Deployment Examples  
22. Web Scale Architecture  
23. Load Balancing  
24. Redis Cluster Topology  
25. MariaDB Replication & Clustering  
26. CDN Strategy  
27. API Rate Limiting  
28. Queue Worker Architecture  
29. Real-Time Update Systems  
30. Autoscaling Rules  
31. Observability Foundations  
32. Player Capacity Targets  
33. Security Hardening  
34. DDoS Strategy  
35. Monitoring & Observability  
36. Alerting Pipeline  
37. Backup & Disaster Recovery  
38. Incident Response Runbooks  
39. Load Testing & Capacity  
40. Compliance Requirements  
41. Final Architecture Diagram  

============================================================
# 1. ARCHITECTURAL OVERVIEW (ALPHA → BETA → RELEASE)
============================================================

Trench City uses a progressive scaling architecture:

Alpha → single VPS  
Beta → multi-node cluster  
Release → distributed MMO-scale backend

Core request flow:
Nginx → PHP-FPM → Application → Redis + MariaDB  
Web nodes stateless → unlimited horizontal scaling.

============================================================
# 2. ENVIRONMENT LAYOUT
============================================================

### Development (DEV)
- Local or remote  
- Debug ON  
- Hot reload allowed  
- Stubbed data  

### Staging (STAGE)
- Mirrors production  
- Debug OFF  
- Logs ON  
- QA verification  

### Production (PROD)
- Hardened  
- Debug OFF  
- Full monitoring  
- Real players  

============================================================
# 3. SERVER STRUCTURE
============================================================

### ALPHA
1× VPS:
- nginx  
- php-fpm  
- mariadb  
- redis  

### BETA
- Web-01  
- Web-02  
- DB Master  
- DB Replica  
- Redis Master + Replica  
- Worker Node  

### RELEASE
- 3–5 Web Nodes  
- Redis Cluster  
- MariaDB Galera / Sharded  
- Queue Cluster  
- CDN  
- Load balancing  

============================================================
# 4. NGINX CONFIGURATION
============================================================

server {
    listen 80;
    server_name trench.city www.trench.city;

    root /var/www/trench_city/public;
    index index.php;

    client_max_body_size 20M;

    add_header X-Frame-Options SAMEORIGIN;
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options nosniff;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 256 16k;
    }
}

============================================================
# 5. PHP-FPM CONFIGURATION
============================================================

pm = dynamic  
pm.max_children = 40  
pm.start_servers = 5  
pm.min_spare_servers = 5  
pm.max_spare_servers = 10  

request_slowlog_timeout = 5s  
slowlog = /var/log/php/slow.log  

============================================================
# 6. MARIADB BASELINE
============================================================

Alpha:
- Single instance

Beta:
- Master + Replica  
- ProxySQL or HAProxy read routing

Release:
- Galera cluster OR sharded DB domains:
  - db_core (users)  
  - db_economy  
  - db_factions  
  - db_logs (partitioned)

Recommended config:
innodb_buffer_pool_size=1G  
innodb_log_file_size=256M  
innodb_flush_log_at_trx_commit=2  
max_connections=300  

============================================================
# 7. REDIS BASELINE
============================================================

Alpha:
- Single Redis instance

Beta:
- Master + Replica  
- Sentinel for failover  

Release:
- Full Redis Cluster (3 masters + 3 replicas)

Used for:
- sessions  
- caching  
- rate limiting  
- real-time counters (raids, chains, wars)

============================================================
# 8. ENVIRONMENT VARIABLES & SECRETS
============================================================

All configuration stored in `.env`.

APP_ENV  
DB_HOST  
DB_PASSWORD  
REDIS_PASSWORD  
JWT_SECRET  
MAIL_API_KEY  

Secrets must be stored in:
- 1Password  
- Vault  
- GitHub encrypted secrets  

============================================================
# 9. NETWORKING & HARDENING
============================================================

UFW default deny  
Allow 80 / 443 / 22  
SSH:
- disable root  
- key-only auth  

Disable PHP execution in uploads  
Fail2ban enabled  
Cloudflare proxy enabled  

============================================================
# 10. BASELINE SCALING RULES
============================================================

Alpha: 1–3k DAU  
Beta: 20–50k DAU  
Release: 100–250k+ DAU  

============================================================
# 11. ALPHA REQUIREMENTS
============================================================

Must have:
- Redis sessions  
- Basic CI/CD  
- Nginx tuned  
- Backups  
- DB migrations  
- Error monitoring baseline  

============================================================
# 12. VERSIONING STRATEGY
============================================================

Semantic Versioning:
v0.x.x = Alpha  
v1.x.x = Beta  
v2.x.x = Release  

Git tags required for production:
git tag vX.X.X  
git push --tags  

============================================================
# 13. GIT BRANCH MODEL
============================================================

main (production)  
dev (integration)  
feature/*  
hotfix/*  
release/*  

Workflow:
feature → dev → main → deploy

============================================================
# 14. CI/CD PIPELINE
============================================================

GitHub Actions workflow responsibilities:
- PHP lint  
- static analysis  
- security scan  
- build artifact  
- deploy to staging  
- promote to production  

Workflows stored under:
.github/workflows/

============================================================
# 15. ZERO-DOWNTIME DEPLOYMENTS
============================================================

Release structure:
/releases/20250101-1230/  
/current → symlink  

Deployment steps:
1. upload release  
2. composer install  
3. migrate DB  
4. switch symlink  
5. reload php-fpm  
6. health check  

============================================================
# 16. DATABASE MIGRATIONS
============================================================

All schema changes via migrations:
migrations/2025_01_12_add_training_logs.sql

Commands:
--dry-run  
--apply  
--rollback (optional)

Staging MUST run migrations before prod.

============================================================
# 17. ARTIFACT PACKAGING
============================================================

Artifact includes:
public/, app/, core/, includes/, modules/, vendor/

Excludes:
.git  
node_modules  
tests  

============================================================
# 18. ENVIRONMENT SYNCING
============================================================

Sync direction:
dev → staging → production  

Production DB → NEVER copied to dev/stage without anonymization.

============================================================
# 19. DEVSECOPS PIPELINE
============================================================

composer audit  
npm audit  
secret scanner  
PSALM/PHPStan  

File integrity enforcement  
Dependency vulnerability scanning  

============================================================
# 20. QA → STAGE → PROD PROMOTION FLOW
============================================================

dev:
- feature merge  
- automated tests  

staging:
- deploy  
- migration dry run  
- QA signoff  

production:
- tag  
- deploy  
- health checks  

============================================================
# 21. DEPLOYMENT EXAMPLES
============================================================

GitHub Actions deploy-prod.yml included in Batch 2.

============================================================
# 22. WEB SCALE ARCHITECTURE
============================================================

Load Balancer  
   ↓  
Web nodes (Nginx + PHP-FPM × N)  
   ↓  
Redis cluster  
   ↓  
MariaDB cluster  
   ↓  
Workers  

============================================================
# 23. LOAD BALANCING
============================================================

Cloudflare Load Balancing  
HAProxy internal  

No sticky sessions (Redis handles state)

============================================================
# 24. REDIS CLUSTER TOPOLOGY
============================================================

Alpha: 1 node  
Beta: Master + Replica  
Release: 6-node Redis Cluster  

Keys for:
- sessions  
- counters  
- chain hit streaks  
- raid ticks  
- cache  

============================================================
# 25. MARIADB REPLICATION & CLUSTERING
============================================================

Beta:
Master + Replica  

Release:
Galera → multi-master  
OR  
Sharding → db_core, db_economy, db_factions, db_logs  

============================================================
# 26. CDN STRATEGY
============================================================

Cloudflare recommended  
CDN paths:
assets/css  
assets/js  
assets/images  
assets/fonts  

Versioning:
main.css?v=20250101  

============================================================
# 27. API RATE LIMITING
============================================================

Limits stored in Redis:
- 100 requests/min IP  
- 20 requests/min user  
- 6 POST/sec user  

Violations → 429  

============================================================
# 28. QUEUE WORKER ARCHITECTURE
============================================================

Workers process:
- raid ticks  
- chain hits  
- war scoring  
- mail  
- analytics  
- logs  

Framework:
Laravel Horizon / Redis workers / RabbitMQ

============================================================
# 29. REAL-TIME UPDATE SYSTEMS
============================================================

Alpha: SSE  
Beta: WebSockets  
Release: event streaming  

Used for:
- raids  
- chains  
- wars  
- faction chat  

============================================================
# 30. AUTOSCALING RULES
============================================================

Scale web nodes when:
CPU > 70%  
latency > 300ms  
players > 5000 per node  

Scale workers when:
queue > 500 jobs  

============================================================
# 31. OBSERVABILITY FOUNDATIONS
============================================================

Logs:
- nginx  
- php-fpm  
- app logs per module  
- worker logs  

Metrics (Prometheus):
- latency  
- qps  
- redis stats  
- DB stats  
- worker depth  

Grafana dashboards required.

============================================================
# 32. PLAYER CAPACITY TARGETS
============================================================

Alpha → 1–3k DAU  
Beta → 20–50k DAU  
Release → 100–250k+ DAU  

============================================================
# 33. SECURITY HARDENING
============================================================

Network:
- block all unused ports  
- Cloudflare WAF  

OS:
- disable root  
- fail2ban  
- updates  

App:
- CSRF tokens  
- SQL injection protection  
- anti-bot rules  
- digital signatures for critical actions  

============================================================
# 34. DDoS STRATEGY
============================================================

Alpha → Cloudflare proxy  
Beta → WAF rules, bot protection  
Release → enterprise rules, region throttling  

============================================================
# 35. MONITORING & OBSERVABILITY
============================================================

Logs, metrics, traces.

Dashboards for:
- web  
- DB  
- cache  
- workers  
- raids  
- chains  

============================================================
# 36. ALERTING PIPELINE
============================================================

Channels:
- Discord  
- Email  
- SMS  

Alerts:
- high latency  
- db down  
- redis down  
- worker failure  
- 5xx spike  

============================================================
# 37. BACKUP & DISASTER RECOVERY
============================================================

Daily:
- DB dump  
- redis dump  
- code snapshot  
- logs  

Retention:
7 daily / 4 weekly / 3 monthly

Recovery:
1. new VPS  
2. pull repo  
3. restore DB  
4. restore redis  
5. rebuild  
6. enable routing  

============================================================
# 38. INCIDENT RESPONSE RUNBOOK
============================================================

1. Identify (logs, metrics)  
2. Isolate (Cloudflare, throttle)  
3. Mitigate (scale, restart, offload)  
4. Recover (rollback, reload)  
5. Document  

============================================================
# 39. LOAD TESTING & CAPACITY
============================================================

Tools:
k6  
Locust  
JMeter  

Target:
p95 < 180ms  

============================================================
# 40. COMPLIANCE REQUIREMENTS
============================================================

GDPR  
Data export  
Audit trails  
Secure payment flows  
Penetration testing  

============================================================
# 41. FINAL ARCHITECTURE DIAGRAM
============================================================

Cloudflare WAF + CDN  
        ↓  
Load Balancer  
        ↓  
Web Nodes (Nginx + PHP-FPM × N)  
        ↓  
Redis Cluster  
        ↓  
MariaDB Cluster  
        ↓  
Worker Cluster  
        ↓  
Observability Stack  
        ↓  
Automated Backups  

# Global_Pack_V3 — Final Law of Trench City (2025 Edition)

============================================================
# 1. CORE PRINCIPLES
============================================================
- The Master Bible (48+ sections) is absolute truth.
- Repo Structure V3 is mandatory across Architect + CodeGPT.
- Build Order V3 is enforced at all times.
- Schema Sovereignty: no guessing, no invented columns or tables.
- Only **two workers exist**: Architect → CodeGPT. No others.
- ZIP Sovereignty: Any ZIP uploaded overrides memory, chat, and previous instructions.

============================================================
# 2. ARCHITECT RULES
============================================================
- Architect NEVER outputs code. Only full structured specifications.
- Architect MUST follow:
  - Master Bible  
  - UI_Design_Guide.md  
  - Security_Spec.md  
  - DevOps_Guide_Ultra.md  
  - All API Ultra Docs (Wars, Chains, Raids, Mobile, Events, Admin, Territories, etc.)  
  - Build Order V3  
  - Repo Structure V3  
- Architect MUST classify all user requests as ALPHA / BETA / RELEASE.
- Architect MUST obey PHASED BUILD LAW.
- Architect MUST obey SPEC MODES:
  - MVP  
  - FULL  
  - POLISH  
- Architect MUST produce:
  - UI Shell Spec  
  - Backend Logic Spec  
  - API Spec  
  - Mobile API compatibility  
  - Anti-Exploit Spec  
  - Logging + Metrics Spec  
  - QA Checklist  
  - Final “Implementation Pack”  
- Architect MUST NOT skip UI → Backend → API → Security → Logging → QA → Implementation order.
- Architect MUST always end output with:
  **“CodeGPT: Begin Implementation.”**

============================================================
# 3. CODEGPT RULES
============================================================
- CodeGPT outputs **full clean code files**, never partial snippets.
- All files MUST be placed exactly in the correct repo path defined by Repo Structure V3.
- CodeGPT MUST follow the Architect spec exactly with no deviations.
- CodeGPT MUST:
  - Never invent DB columns or tables.  
  - Use existing schema ONLY.  
  - Enforce Dark Luxury UI design rules.  
  - Use correct helper functions.  
  - Maintain XP ↔ Level sync.  
  - Use the $db wrapper (fetchOne, fetchAll, execute).  
  - Log all backend actions using the system logging standard.  
  - Respect security boundaries and anti-cheat constraints.  
- If Architect output is missing something, CodeGPT MUST request clarification.
- CodeGPT NEVER restructures, redesigns, or adds features not in Architect spec.

============================================================
# 4. UI RULES
============================================================
- All UI MUST follow **UI_Design_Guide.md** strictly.
- Dark Luxury Theme is mandatory:
  - gold headers  
  - navy/black backgrounds  
  - rounded luxury cards  
  - thin gold borders  
  - consistent spacing + typography  
- London skyline background global rule.
- All module pages MUST include:
  - title bar  
  - breadcrumb (if applicable)  
  - main content card  
  - action buttons (matching theme)  

============================================================
# 5. API RULES
============================================================
- Every module MUST have:
  - Frontend  
  - Backend  
  - API  
  - Mobile API  
- All API endpoints MUST follow Ultra API Specs:
  - API_Wars  
  - API_Chains  
  - API_Raids  
  - API_Mobile  
  - API_Events  
  - API_Admin  
  - API_Territories (when built)  
- API Security:
  - digital signatures for combat-sensitive actions  
  - replay prevention  
  - anti-fraud timestamps  
  - rate limiting (Redis)  
  - full ledger writes  

============================================================
# 6. SECURITY RULES
============================================================
- MUST follow **Security_Spec.md** with no exceptions.
- All state-changing actions require:
  - validation  
  - sanitization  
  - permission checks  
  - replay protection  
  - signature verification (where applicable)  
- Barriers enforced:
  - Admin vs Player  
  - Faction vs Global state  
  - PvP safe boundaries  
- Inventory, combat, raids, chains, wars must use integrity logs + anti tamper checks.

============================================================
# 7. DEVOPS RULES
============================================================
- MUST follow **DevOps_Guide_Ultra.md** (full merged document).
- All code must be production-safe.
- No debugging prints, var_dumps, echoes, or test endpoints.
- Mandatory error handling in backend modules.
- Logging must follow:
  - structured JSON format  
  - per-module log channels  
  - Redis counters (where applicable)  
- Deployment must be:
  - deterministic  
  - migration-controlled  
  - rollback-safe  

============================================================
# 8. WORKER INTERACTION
============================================================
**User → Architect → CodeGPT → User**

- Architect receives the user prompt and produces the full specification pack.
- CodeGPT receives only Architect’s final spec and produces code.
- Architect MUST NOT write code.
- CodeGPT MUST NOT design features.

============================================================
# 9. ZIP SOVEREIGNTY
============================================================
- Any ZIP uploaded by the user overrides:
  - memory  
  - previous instructions  
  - previous docs  
  - any hallucinated or assumed structure  
- ZIP contents become the **single source of truth**.
- Architect and CodeGPT MUST adjust instantly when a new ZIP is uploaded.

============================================================
# 10. FINAL LAW
============================================================
**The User overrides everything manually.**  
If the user contradicts the packs, Bible, or Ultra Docs, the **user is always correct** and both Architect + CodeGPT MUST comply immediately.

# TRENCH CITY — MASTER DESIGN BIBLE
# COMPLETE MODULE + FEATURE COMPENDIUM
# (All 75+ Systems Unified Into One Document)

============================================================
# 1. CORE PLAYER SYSTEMS
- Accounts & progression
- Stats, bars, experience
- Leveling, prestige, passive skills
- Inventory, equipment, items, crafting mini-games
- Achievements, merit points, titles, collections
- Social feed, trophies, karma system

============================================================
# 2. CITY SYSTEMS
- Boroughs (dynamic)
- Weather system
- Live City Simulation (economy, crime heat)
- NPC population behaviour
- Police heat + manhunt system
- AI NPC Event Director (Left 4 Dead dynamic pacing)

============================================================
# 3. CRIME SYSTEMS
- 20 Crime Paths (each with 5+ crimes)
- Crime difficulty scaling
- Crime heat, police encounters
- Black market links
- Crime story generator (AI-driven narratives)
- Cybercrime, hacking, white-hat/black-hat hybrid paths

============================================================
# 4. COMBAT SYSTEMS
- PvP combat
- NPC combat
- Damage types, armour, weapons
- Bounty/hitlist system
- Sleeper agents (faction espionage)
- NPC crew recruitment (driver/hacker/enforcer/scout)

============================================================
# 5. FACTIONS & TERRITORIES
- Faction creation, ranks, permissions
- Territory wars (borough control)
- Clan-owned businesses
- Faction mansions (armoury, vault, war room)
- Sleeper agents + counterintelligence
- Faction raids (PvE + PvP)

============================================================
# 6. MISSIONS & NPC SYSTEMS
- Story missions (branching)
- Procedural missions (daily/weekly)
- Daily missions + challenge system
- NPC gangs (territories, bosses)
- Player-created mission editor
- Prison missions + court outcomes

============================================================
# 7. ECONOMY SYSTEMS
- Player-to-player marketplace
- Auction house
- Stock market
- Real estate manipulation system
- Anti-inflation economy AI
- Courier/delivery system
- Player shops (pawnshop, gym, cyber café)

============================================================
# 8. PROPERTY & HOUSING SYSTEMS
- Properties (flats → estates)
- Property upgrades (safe room, CCTV, crypto rigs)
- Hideouts
- Stash spaces (home/car/gang)
- Player-owned land/turf
- Rent, buy, sell, invest features

============================================================
# 9. VEHICLES & RACING SYSTEMS
- Vehicle types (moped → supercar)
- Stats (speed, handling, stealth, cargo)
- Garages, upgrades, tuning
- Racing circuits
- Street races with police chance
- Vehicle smuggling (multi-leg routes)

============================================================
# 10. MARKET, TRADE & BLACK WEB SYSTEMS
- Marketplace
- Player trading (anti-scam tools)
- Black Market (rotating)
- Courier/smuggling missions
- Dark Web (missions, intel, contracts)

(*Black Web main OS excluded per your request earlier*)

============================================================
# 11. MINI-GAMES & SIDE SYSTEMS
- Lockpicking
- Hacking terminals
- Parkour chase
- Street dice/cards
- Drone control mini-game

============================================================
# 12. SOCIAL SYSTEMS
- Mail
- Messenger/DMs
- Forums
- Newspapers
- Friends / rivals
- Karma alignment
- Reputation/infamy system

============================================================
# 13. EVENTS & SEASONS
- Seasonal events
- Dynamic events (AI-triggered)
- Live Ops event modifiers
- Timed loot boosts
- Story arcs per season

============================================================
# 14. STORE & MONETIZATION
- Cosmetic store
- Season pass (free + premium tiers)
- Donator packs
- Cosmetic skins, frames, animations

============================================================
# 15. ADMIN, SECURITY & BACKEND
- Anti-cheat (behavioural + heuristic)
- Logging system
- Moderation tools
- Support ticket system
- A/B Testing framework
- Analytics tracking (retention, funnels, economy)
- Live Ops dashboard
- Modular Plugin API (future-proof expansion)

============================================================
# 16. COMPLETE SYSTEM COUNT SUMMARY
- 45 Core MMO Systems
- 18 Advanced Expansion Systems
- 7 Final High-Value Systems
- 5 Ultra-Premium Systems
- 1 AI Event Director
- 4 Studio/Backend Systems

TOTAL: **75+ Fully Specced Systems**

============================================================
# END OF MASTER DOCUMENT



============================================================
# CHUNK 1 — CORE GAME VISION (EXPANDED)
============================================================

## 1.1 FULL GAME IDENTITY OVERVIEW
Trench City is a UK-based, persistent-world crime MMO combining:
- 75+ gameplay systems
- AI NPC Event Director
- Dynamic borough simulation
- Factions, economics, racing, smuggling, properties
- Studio-level live ops, analytics, A/B testing, plugin API

This chunk integrates ALL features discussed so far.

## 1.2 GAMEPLAY PILLARS
1. Criminal Ascension
2. Dynamic City Ecosystem
3. Player-Driven Conflict
4. Systems-Driven Storytelling
5. Economic Manipulation
6. Reactive AI & Live Ops Integration
7. Infinite Progression (Prestige, Passive Skills)

## 1.3 WORLD STRUCTURE
- 8+ boroughs with independent police heat, NPC gang presence, economy levels.
- AI Director manipulates city tension, crisis, cooldown cycles.
- Weather system influences crime/smuggling/racing.
- NPC simulations run continuously.

## 1.4 SYSTEM OVERVIEW INDEX
This chunk includes every feature previously added:
- 45 Core Systems
- 18 Advanced Expansion
- 7 Final High-Value Systems
- 5 Ultra-Premium Systems
- AI Event Director
- Studio Suite (Live Ops, Analytics, A/B, Plugin API)
- Excluded Systems: Voice Notes, Decor Housing Interiors, Black Web OS

## 1.5 DESIGN PHILOSOPHY
- No hard resets; world evolves
- Crime-first but multi-career
- Player economy drives 60% of game state
- AI-driven pacing prevents stagnation
- Designed for 1 million+ DAU scalability

END OF CHUNK 1



============================================================
# CHUNK 2 — CORE PLAYER SYSTEMS DEEP DIVE
============================================================

## 2.1 PLAYER STATS MODEL (FULL SPEC)
Primary stats:
- Strength
- Speed
- Defense
- Dexterity

Meta stats:
- Intelligence (missions, hacking)
- Charisma (trading, social)
- Awareness (ambush & detection)

Bars:
- Energy
- Nerve
- Happy
- Life

Regeneration rules:
- Energy: regen every 5 minutes, modified by properties & perks
- Nerve: regen slower, impacted by crime path progression
- Happy: location-based, item-based, property-based
- Life: regen rate based on hospital state, faction bonuses

## 2.2 EXPERIENCE & LEVELING
XP sources:
- crimes
- missions
- combat
- events
- trades
- smuggling
- faction ops

XP → Level using non-linear curve:
level = floor((xp / 100) ** 0.65)

Prestige resets XP while preserving:
- passive skills
- certain titles
- karma alignment
- cosmetic unlocks

## 2.3 PASSIVE SKILLS SYSTEM
Categories:
- Combat Efficiency
- Stealth & Evasion
- Crafting & Mods
- Cyber Operations
- Vehicle Handling
- Black Market Influence

Earned over time (idle + active blend).

## 2.4 PLAYER ALIGNMENT: KARMA & INFAMY
Karma:
- mercy, donations, honourable play
Infamy:
- brutality, betrayal, domination

Both modify:
- crime outcomes
- NPC reactions
- mission branches
- event triggers

## 2.5 PLAYER ROLES & BUILDS
Supported archetypes:
- Street Enforcer
- Smuggler
- Hacker
- Mastermind
- Racer
- Crime Boss
- Sniper (combat specialist)
- Chemical Expert
- Negotiator

Each build relies on specific stat synergies, itemization, and faction bonuses.

## 2.6 DEATH, HOSPITAL, JAIL
Hospital:
- severity-based timers
- medical items reduce timers
- faction upgrades reduce timers

Jail:
- caused by failed crimes or manhunt events
- includes prison missions & smuggling mini-loop

## 2.7 PLAYER PROGRESSION STAGES
Stage 1: Street Beginner
Stage 2: Skilled Operator
Stage 3: Criminal Architect
Stage 4: Syndicate Power
Stage 5: Legendary Figure

## 2.8 PLAYER ECONOMY PROFILE
Tracks:
- net worth
- liquid cash
- properties
- vehicles
- faction assets
- black market reputation
- trading reliability score

## 2.9 ANTI-ABUSE & FAIRNESS PROTECTIONS
Monitors:
- alt accounts
- funnelled wealth
- suspicious progression spikes
- combat rigging

Links to:
- analytics
- anti-cheat
- economy AI

END OF CHUNK 2



============================================================
# CHUNK 3 — COMPLETE DATABASE SCHEMA (CORE SYSTEMS)
============================================================

This section defines the CORE tables required for Trench City’s foundation.
All schemas are implementation‑ready and follow best practices:
- `INT UNSIGNED` keys
- strict FK discipline
- logical indexing
- scalable design for sharding/layering

============================================================
## 3.1 USERS & ACCOUNT STRUCTURE
------------------------------------------------------------

### TABLE: users
- id (PK)
- username (UNIQUE)
- email (UNIQUE)
- password_hash
- created_at (timestamp)
- last_login (timestamp)
- role (player/mod/admin)
- status (active/banned/suspended)
- karma
- infamy
- prestige_level
- settings_json (UI settings, notification prefs)
- faction_id (FK → factions.id / nullable)

Indexes:
- username
- email
- faction_id

------------------------------------------------------------
### TABLE: user_stats
- user_id (PK/FK)
- strength
- speed
- defense
- dexterity
- intelligence
- charisma
- awareness

Index:
- user_id (primary)

------------------------------------------------------------
### TABLE: user_bars
- user_id (PK/FK)
- energy
- nerve
- happy
- life
- energy_max
- nerve_max
- happy_max
- life_max
- last_energy_tick
- last_nerve_tick

------------------------------------------------------------
### TABLE: user_progression
- user_id (PK/FK)
- xp
- level
- passive_skill_points
- prestige_bonus_json
- build_profile (text)

============================================================
## 3.2 INVENTORY & ITEMS STRUCTURE
------------------------------------------------------------

### TABLE: items
- id (PK)
- name
- type (weapon/armour/consumable/material)
- rarity (common → mythic)
- description
- base_value
- stackable (bool)
- metadata_json (damage, armor, effects)

------------------------------------------------------------
### TABLE: user_inventory
- id (PK)
- user_id (FK)
- item_id (FK)
- quantity
- durability
- slot_type (equip/main/storage)

Indexes:
- user_id
- item_id

------------------------------------------------------------
### TABLE: user_equipment
- user_id (PK/FK)
- weapon_slot
- armour_slot
- accessory_slot
- vehicle_attachment_slot

============================================================
## 3.3 PROPERTY & HOUSING STRUCTURE
------------------------------------------------------------

### TABLE: properties
- id (PK)
- name
- tier (1–10)
- borough_id
- base_capacity
- base_happy
- upgrade_slots
- price

------------------------------------------------------------
### TABLE: user_properties
- id (PK)
- user_id (FK)
- property_id (FK)
- upgrades_json
- stash_capacity
- security_rating

============================================================
## 3.4 VEHICLES & RACING STRUCTURE
------------------------------------------------------------

### TABLE: vehicles
- id (PK)
- name
- class (moped/car/van/supercar)
- speed
- handling
- stealth
- cargo
- rarity
- description

------------------------------------------------------------
### TABLE: user_vehicles
- id (PK)
- user_id (FK)
- vehicle_id (FK)
- durability
- upgrades_json
- paint_job

------------------------------------------------------------
### TABLE: racing_tracks
- id (PK)
- name
- borough_id
- distance
- difficulty

------------------------------------------------------------
### TABLE: racing_results
- id (PK)
- race_id
- user_id
- vehicle_id
- time_ms
- position

============================================================
## 3.5 CRIME SYSTEM SCHEMA (20 PATHS)
------------------------------------------------------------

### TABLE: crime_paths
- id (PK)
- name
- description
- required_level
- category (street/heist/cyber/etc)

------------------------------------------------------------
### TABLE: crimes
- id (PK)
- path_id (FK)
- name
- difficulty
- nerve_cost
- min_reward
- max_reward
- heat_modifier
- success_formula
- fail_outcomes_json

------------------------------------------------------------
### TABLE: crime_attempts
- id (PK)
- user_id (FK)
- crime_id (FK)
- success (bool)
- reward
- heat_generated
- timestamp

============================================================
## 3.6 NPC, MISSIONS & AI STRUCTURE
------------------------------------------------------------

### TABLE: npc_profiles
- id (PK)
- name
- type (gang/boss/civilian)
- aggression
- wealth
- strength
- behavior_json

------------------------------------------------------------
### TABLE: missions
- id (PK)
- name
- type (story/procedural/daily)
- difficulty
- rewards_json
- requirements_json

------------------------------------------------------------
### TABLE: mission_attempts
- id (PK)
- user_id (FK)
- mission_id (FK)
- success
- progress_data
- timestamp

============================================================
## 3.7 FACTIONS & TERRITORIES
------------------------------------------------------------

### TABLE: factions
- id (PK)
- name
- description
- leader_id (FK → users)
- creation_date
- mansion_level
- treasury

------------------------------------------------------------
### TABLE: faction_members
- id (PK)
- faction_id (FK)
- user_id (FK)
- rank
- join_date

------------------------------------------------------------
### TABLE: territories
- id (PK)
- borough_id
- faction_id (FK/nullable)
- income_rate
- control_strength
- conflict_state

------------------------------------------------------------
### TABLE: faction_espionage
- id (PK)
- infiltrator_user_id (FK)
- target_faction_id (FK)
- intel_score
- risk_level
- last_action_timestamp

============================================================
## 3.8 ECONOMY, MARKET, STOCKS
------------------------------------------------------------

### TABLE: marketplace_listings
- id (PK)
- seller_id (FK)
- item_id (FK)
- price
- quantity
- created_at

------------------------------------------------------------
### TABLE: auction_house
- id (PK)
- item_id (FK)
- seller_id (FK)
- current_bid
- buy_now
- expires_at

------------------------------------------------------------
### TABLE: stocks
- id (PK)
- ticker
- description
- current_price
- last_update

------------------------------------------------------------
### TABLE: user_stocks
- id (PK)
- user_id (FK)
- stock_id (FK)
- shares
- avg_price

============================================================
## 3.9 LOGGING, ANTI‑CHEAT & LIVE OPS
------------------------------------------------------------

### TABLE: logs
- id (PK)
- user_id (nullable)
- action
- details
- timestamp
- ip_address

------------------------------------------------------------
### TABLE: economy_events
- id (PK)
- type (inflation/control/flood/drought)
- amount
- metadata_json
- created_at

------------------------------------------------------------
### TABLE: live_ops_modifiers
- id (PK)
- modifier_key
- value_json
- expires_at

============================================================
END OF CHUNK 3



============================================================
# CHUNK 4 — UI/UX FOUNDATION & DARK LUXURY DESIGN FRAMEWORK
============================================================

## 4.1 DESIGN PHILOSOPHY
Trench City’s UI identity is “Dark Luxury”: a fusion of:
- deep navy & black surfaces
- gold accents
- crisp edges with soft glows
- high contrast for readability
- cinematic, high-end feel
- modern, mobile-first responsiveness

Goals:
- fast readability
- premium feel
- minimal clutter
- consistent interaction rules
- scalable to 100+ pages

============================================================
## 4.2 GLOBAL COLOR TOKENS
Primary:
- Gold Primary: #CBA135
- Gold Deep:   #9D7D2A
- Gold Light:  #D4AD47

Neutrals:
- Black:       #050608
- Navy Dark:   #020617
- Dark Card:   #111111
- Dark Hover:  #151515

Borders:
- Border Dark: #15161B
- Border Gold: rgba(203,161,53,0.6)

Text:
- Primary:     #F9FAFB
- Secondary:   #E5E7EB
- Muted:       #9CA3AF

Alerts:
- Success: #16A34A
- Warning: #FACC15
- Danger:  #DC2626

============================================================
## 4.3 TYPOGRAPHY SYSTEM
Headings:
- H1: 32–38px, semibold, gold
- H2: 28–32px, semibold, gold-deep
- H3: 24px, semibold, white
- Section Title: 18px, gold accents

Body:
- 16px regular (primary text)
- 14px secondary/muted
- 13px for meta info or timestamps

Font:
- Inter / Poppins / Roboto (consistent across site)

============================================================
## 4.4 LAYOUT GRID SYSTEM
Desktop:
- 12-column grid
- 16–24px gutters
- max width: 1400px
- Sidebar fixed on left (nav)
- Main content scrolls

Mobile/Tablet:
- collapsible sidebar (hamburger)
- 4-column mobile grid
- all cards become full-width

============================================================
## 4.5 UI COMPONENT LIBRARY (CORE ELEMENTS)

### Cards
- background: var(--tc-dark-card)
- border-radius: 10–12px
- border: 1px solid var(--tc-border)
- padding: 16–20px
- hover: border-color → var(--tc-gold-light)

### Buttons
Primary:
- background: gold
- color: black
- hover: gold-light
Secondary:
- background: dark card
- border: gold
- text: gold

Danger:
- background: danger
- text: white

### Inputs
- Dark background
- Gold outline focus
- Soft glow on active

### Lists
- Divider lines: 1px solid border-dark
- Hover rows: dark-hover with gold left border

### Modals
- blurred background
- gold header bar
- dark card body

============================================================
## 4.6 NAVIGATION ARCHITECTURE

### Sidebar Structure
- Dashboard
- City
- Crimes
- Gym
- Inventory
- Missions
- Factions
- Properties
- Vehicles
- Jobs
- Black Market
- Casino
- Travel
- Mail
- Forums
- Settings
- Logout

Rules:
- Active item is highlighted gold
- Icons optional but simple line icons preferred

### Top Bar
- Username
- Bars (Energy, Nerve, Happy, Life)
- Notifications
- Quick access icons (Mail / Faction / Missions)

============================================================
## 4.7 PAGE TEMPLATE RULES

### Standard Module Page Template:
1. Gold title
2. Optional subtitle
3. Two-column layout (desktop)
4. Cards for all content blocks
5. Clear CTA buttons
6. Responsive priorities:
   - mobile: stacked layout
   - tablet: hybrid two-column

### Detail View Page Template:
- Header with title + icon
- Main stats card
- Info cards below
- Action buttons to right (desktop) or bottom (mobile)

### List/Table Pages:
- sortable columns
- gold hover lines
- pagination bottom-right
- filters as pills or dropdowns

============================================================
## 4.8 ANIMATION & FEEDBACK RULES
- hover glow on gold accents
- subtle fade transitions (100–200ms)
- no large motion to keep performance fast
- error messages in red
- success tick in green

============================================================
## 4.9 ACCESSIBILITY
- minimum contrast ratio 4.5:1
- text scaling up to 200%
- keyboard navigable
- alt text for icons
- avoid gold-only reliance (paired with shape cues)

============================================================
## 4.10 DARK LUXURY UI — VISUAL IDENTITY CHECKPOINTS
A page is considered “on brand” if:
- gold header present
- dark card surfaces used
- text contrast meets guidelines
- hover interactions present
- spacing system followed (8/12/16/24px)

============================================================
END OF CHUNK 4



============================================================
# CHUNK 5 — CRIME SYSTEMS DEEP BOOK
============================================================

## 5.1 CRIME SYSTEM OVERVIEW
The Trench City crime engine is built on:
- 20 fully independent crime paths
- 5–12 crimes per path (scaling complexity)
- Police Heat System
- AI Director integration
- Faction and economy influence
- Player alignment (karma/infamy)
- Procedural variation modifiers
- Anti-exploit detection
- Scaling difficulty curves

Crimes are the heart of progression, income, reputation, tension control, and narrative.

============================================================
# 5.2 THE 20 CRIME PATHS (FULL TREE)
Each path represents a unique criminal career.

### 1. Street Crime
Pickpocketing, shoplifting, alley scams.

### 2. Urban Theft
Car theft, scooter lifting, catalytic converter theft.

### 3. Burglary
Home invasions, commercial break-ins.

### 4. Mugging & Robbery
Street muggings, armed robbery, smash-and-grabs.

### 5. Drug Operations
Street dealing, grow ops, distribution networks.

### 6. Fraud & Scams
Credit fraud, identity theft, phishing.

### 7. Cybercrime
DDoS, ransomware, data theft, deepfake scams.

### 8. Smuggling (Local)
Moving contraband between boroughs.

### 9. Smuggling (International)
Airport mule runs, container infiltration.

### 10. Heists (Small)
Corner shop, betting shop, pawn shop hits.

### 11. Heists (Major)
Bank vans, jewellery stores, armoured facilities.

### 12. Extortion
Protection rackets, threats, intimidation.

### 13. Blackmail
Digital leaks, surveillance, secrets-for-sale.

### 14. Political Crime
Election interference, data leaks, sabotage.

### 15. Corporate Crime
Insider trading, IP theft, corruption.

### 16. Kidnapping & Hostage Work
Snatch-and-grab, ransom negotiations.

### 17. Weapons Trafficking
Acquiring, moving, and selling illegal arms.

### 18. Human Trafficking (Toned-down MMO-safe version)
Recruitment scams, forced labour rings.

### 19. Syndicate Operations
Collaborative faction missions, multi-step crimes.

### 20. Elite Crime (Endgame)
Art theft, museum infiltration, cyber-physical attacks.

============================================================
# 5.3 CRIME FORMULAS & DIFFICULTY
Each crime uses a weighted formula:

success_chance = base_rate 
               + (skill_mod * stat_factor) 
               - (heat_factor * police_presence)
               + (item_bonus + crew_bonus + territory_bonus)

### Core Inputs:
- Player stats (dex, stealth, intelligence)
- Gear (tools, hacking rigs, disguise kits)
- Nerve cost
- Player alignment (karma/infamy)
- Borough tension (AI Director)
- Police heat
- Crew support (driver/hacker/lookout)
- Faction control of borough

Difficulty tiers:
- Tier 1: 60–80% base success
- Tier 2: 40–65%
- Tier 3: 25–50%
- Tier 4: 10–35%
- Tier 5: 5–20% (elite content)

============================================================
# 5.4 POLICE HEAT SYSTEM
Heat is the risk profile of the player and borough.

Heat increases from:
- failed crimes
- high-value crimes
- acting repeatedly in same borough
- NPC gang conflicts
- faction wars
- AI Director escalation triggers

Heat decreases from:
- lying low in properties
- using disguises
- bribing officers
- borough events
- cooldown periods dictated by the AI Director

Heat thresholds:
- 0–20: Safe
- 21–40: Patrol increases
- 41–60: Police response enhanced
- 61–80: Manhunt chance
- 81–100: Guaranteed confrontation

============================================================
# 5.5 POLICE RESPONSE AI
Police behaviour adapts to:
- time of day
- borough safety level
- player infamy
- faction conflicts
- global crime rate
- AI Director mood

Police encounter outcomes:
- flee
- resist & fight
- chase sequence
- arrest → jail
- confiscation of contraband

============================================================
# 5.6 CRIME MODIFIERS
Dynamic modifiers create variation:
- Weather (fog improves stealth, rain reduces chase difficulty)
- Event modifiers (Live Ops)
- Faction bonuses
- NPC gang presence
- Undercover sleepers
- Economic conditions (price/inflation)

============================================================
# 5.7 CRIME REWARD CURVES
Rewards include:
- cash
- items
- materials
- favour with NPC factions
- reputation/infamy
- XP

Reward curves scale:
- exponentially with risk
- logarithmically with stats (to prevent runaway gains)
- dynamically from AI Director pressure

============================================================
# 5.8 PROCEDURAL VARIANTS
Crimes may mutate:
- security level changes
- guard rotations
- new vulnerabilities
- time-sensitive opportunities
- leaks from insider NPCs
- faction sabotage effects

============================================================
# 5.9 CRIME CHAINS (EXAMPLE)
BURGLARY → SECURITY ANALYSIS → INSIDER CONTACT → UPSCALE HEIST → ESCAPE ROUTE PLANNING → MUSEUM HIT (Elite)

Each chain builds:
- skill investment
- deeper narrative
- higher payout
- escalating heat

============================================================
# 5.10 LIVE OPS & ANALYTICS HOOKS
Live Ops may:
- boost crime XP
- reduce nerve costs
- create crime events
- rotate special crime weeks

Analytics tracks:
- fail/success rates
- payout averages
- heat spikes
- suspected exploit patterns
- bot-like behaviour

============================================================
# 5.11 ANTI-EXPLOIT RULES
Detection for:
- repeat identical crime timing
- impossible success streaks
- nerve regen manipulation
- macro/bot behaviours
- wealth funneling via crime laundering

============================================================
END OF CHUNK 5



============================================================
# CHUNK 6 — COMBAT SYSTEMS DEEP BOOK
============================================================

## 6.1 COMBAT DESIGN PHILOSOPHY
Trench City's combat system blends:
- tactical decision‑making
- build diversity
- fast resolution (browser‑friendly)
- clear readability
- fair PvP rules
- rich PvE behaviours
- itemisation depth
- anti‑exploit security

Combat is not RNG chaos — it is:
- stat‑driven
- item‑enhanced
- strategy‑influenced
- modified by environment, heat, karma, and AI Director tension.

============================================================
## 6.2 CORE COMBAT LOOP
1. Player initiates attack OR is attacked during:
   - crimes
   - missions
   - faction wars
   - bounty hunting
2. Combat engine resolves:
   - initiative
   - stance effects
   - hit/miss
   - damage calculation
   - item abilities
3. Apply conditions:
   - bleed
   - stun
   - panic
   - debuffs
4. Victory/Defeat effects:
   - loot
   - XP
   - hospital/jail outcomes
5. Log combat for:
   - anti-cheat
   - analytics
   - faction reports

============================================================
## 6.3 STATS IN COMBAT
Primary stats:
- **Strength:** increases blunt/physical damage
- **Speed:** affects initiative & dodge chance
- **Defense:** reduces incoming physical damage
- **Dexterity:** improves accuracy, crit chance

Secondary stats:
- **Awareness:** influences ambush detection
- **Intelligence:** impacts hacking/cyber combat modules
- **Charisma:** used in intimidation-based combat events

============================================================
## 6.4 INITIATIVE FORMULA
initiative_value = (Speed * 0.7) + (Dexterity * 0.3) + stance_bonus + item_bonus

Higher value strikes first.
AI enemies have hidden initiative modifiers based on:
- aggression level
- territory control
- heat level

============================================================
## 6.5 ATTACK FORMULAS
### Accuracy
accuracy = base_accuracy 
         + (Dexterity * 0.4) 
         + weapon_accuracy 
         - target_evasion

### Hit Chance
hit_chance = clamp( accuracy - target_defense_factor , 5% , 95% )

### Damage
damage = weapon_damage 
        + (Strength * strength_factor) 
        + crit_mod 
        - target_armor

Crit chance = Dex * 0.15% + weapon_crit_bonus  
Crit damage = 1.5x–2.2x based on weapon class.

============================================================
## 6.6 DAMAGE TYPES
- **Blunt:** bats, pipes, hammers  
  Strong vs armour, weak vs agile builds.

- **Sharp:** knives, machetes, improvised blades  
  High crit rate.

- **Ballistic:** pistols, SMGs, rifles  
  High burst damage, accuracy dependent.

- **Explosive:** grenades, IEDs  
  Rare, high-damage special actions.

- **Chemical:** gas, spray, experimental crafted items  
  Applies DoT (damage-over-time).

============================================================
## 6.7 COMBAT STANCES
Stances modify stats each round:

### Aggressive
+15% damage  
-10% defense  
-5% accuracy  

### Defensive
+20% defense  
-10% damage  
Cannot trigger crits

### Tactical
+10% accuracy  
+5% evasion  
+5% initiative  

### Reckless (high‑risk variant)
+30% damage  
-25% defense  
chance to self‑inflict small damage

============================================================
## 6.8 NPC COMBAT AI
NPCs operate based on:
- aggression
- confidence
- territory bonus
- hidden perks
- crew synergy
- AI Director tension

NPC behaviours include:
- retreat at low health
- call backup (gang units)
- ambush player if awareness check fails
- use items mid-fight (rare)
- change stance dynamically

Boss NPCs:
- have multi-phase patterns  
- use special abilities (fear, stun, bleed)  
- reward faction currency or rare items  

============================================================
## 6.9 COMBAT MODIFIERS
Modifiers influencing combat:
- Weather (fog → accuracy penalty, rain → lower ballistic reliability)
- Heat level (high heat → police interference possible)
- Territory control (faction buffs/debuffs)
- NPC gang density
- Karma (good karma slightly reduces ambush frequency)
- Infamy (high infamy increases NPC boss targeting)

============================================================
## 6.10 BOUNTY & HITLIST COMBAT RULES
If attacking a bounty target:
- +10% XP reward  
- +infamy bonus  
- chance target drops contraband  

Anti-abuse rules:
- same IP cannot chain-farm
- cooldown between attacks
- diminishing rewards on repeated kills

============================================================
## 6.11 FACTION WAR COMBAT
Faction war combat includes:
- frontline battles (mass combat simulation)
- raids (small-team tactical)
- mansion defense/offense phases
- sabotage missions impacting combat stats
- morale system:
  morale increases damage/defense during long wars

NPC reinforcement waves appear during:
- contested territories
- AI Director crisis state

============================================================
## 6.12 CRIME → COMBAT INTERACTIONS
Combat may be triggered by:
- failed crimes
- high-reward heists
- smuggling interception
- NPC retaliation
- undercover agents

AI Director escalates combat likelihood if:
- city tension high
- many players succeeding crime streaks
- police crackdown active

============================================================
## 6.13 POST-COMBAT OUTCOMES
Victory rewards:
- XP  
- items  
- materials  
- faction influence  
- territory shifts (war mode)

Defeat consequences:
- Hospital time  
- Jail (if police involved)  
- Item durability loss  
- Heat reduction (lying low effect)

============================================================
## 6.14 ANTI-EXPLOIT SAFETY
System flags:
- repeated combat vs same targets
- win/loss manipulation
- unusual success patterns
- combat macros/bots
- scripted item usage

Cross-referenced with:
- analytics
- economy AI
- anti-cheat database

============================================================
END OF CHUNK 6



============================================================
# CHUNK 7 — FACTIONS & TERRITORIES DEEP BOOK
============================================================

## 7.1 FACTION SYSTEM OVERVIEW
Factions are the backbone of endgame content in Trench City.
They provide:
- community
- power progression
- territory control
- passive and active bonuses
- large‑scale PvP
- seasonal competition
- long‑term goals

The system is built for:
- 10–100 player factions
- scalable wars
- diplomacy
- espionage
- PvE/PvP hybrid operations
- faction‑driven economy

============================================================
# 7.2 FACTION CREATION & STRUCTURE

### Requirements
- Level threshold
- Cash fee
- No recent bans
- Unique name & tag

### Core Data
- Name
- Description
- Logo
- Motto
- Default ranks

### Rank Examples
1. Leader  
2. Underboss  
3. Lieutenant  
4. Enforcer  
5. Associate  
6. Recruit  

Ranks have permissions:
- invite/kick
- manage treasury
- declare war
- start raids
- manage sleepers
- manage upgrades
- edit diplomacy

============================================================
# 7.3 FACTION TREASURY & ECONOMY
Treasury sources:
- member donations
- territory income
- faction businesses
- raid/heist rewards
- fines & internal taxes

Treasury uses:
- pay faction upkeep
- upgrade mansion
- build war machine
- bribe police
- purchase intel
- hire NPC mercenaries
- fund sabotage missions

============================================================
# 7.4 FACTION MANSIONS (HEADQUARTERS)

Mansions act as faction bases and have:
- upgradeable rooms
- defensive bonuses
- cosmetic customisation
- storage systems

### Mansion Rooms
- **War Room:** controls raids, diplomacy, intel
- **Armoury:** shared weapons, armour, tools
- **Vault:** cash & item storage
- **Workshop:** craft faction‑only items & mods
- **Barracks:** NPC crew support
- **Security Hub:** anti-espionage and defense rating

Upgrades cost:
- cash
- materials
- faction XP

============================================================
# 7.5 FACTION ACTIVITIES & MISSIONS

### Operational Missions
- Smuggling runs
- Territory patrols
- Supply chain defense
- Black market negotiations
- Extortion missions

### War Missions
- Raids
- Sabotage
- Spy insertion
- VIP extraction
- Resource denial ops

Faction missions scale based on:
- faction level
- territory ownership
- AI Director tension
- rival faction behaviour

============================================================
# 7.6 ESPIONAGE & SLEEPER AGENTS

Sleeper Agents are hidden faction members who infiltrate enemy factions.

### Sleeper Actions
- gather intel
- sabotage upgrades
- steal from vault
- leak member activity
- frame a rival member
- incite internal conflict

Sleeper attributes:
- stealth score
- risk score
- cover identity
- infiltration depth (0–100%)

Counter‑Espionage:
- security hub rating
- awareness checks
- logs monitoring
- interrogations

============================================================
# 7.7 FACTION DIPLOMACY SYSTEM
Diplomacy Tracks:
- Allied
- Neutral
- Rival
- At War
- Cold War (hidden tension)
- Trade Partners (share business buffs)

Diplomacy affects:
- war costs
- raid cooldowns
- bonuses
- territory influence
- AI Director crisis scaling

============================================================
# 7.8 TERRITORY CONTROL SYSTEM

Trench City boroughs are divided into controllable territories.

Territories provide:
- passive income
- faction XP
- bonuses (crime, combat, economy)
- strategic positions for raids
- materials or black market perks

### Territory Attributes
- income_rate
- danger_level
- gang_presence
- police_presence
- owner_faction_id
- control_strength

Control Strength increases by:
- patrols
- holding events
- winning raids
- bribing authorities
- suppressing NPC gangs

Losing control occurs through:
- rival faction raids
- NPC gang uprisings
- police crackdowns
- AI Director destabilisation

============================================================
# 7.9 WAR SYSTEM (FULL MECHANICS)

### War Preparation
- declare war (with cost)
- assign roles: attackers/defenders
- mobilise members
- choose strategic targets

### War Phases
1. **Infowar (optional):** leaks, propaganda  
2. **Skirmishes:** small battles to weaken enemy control  
3. **Main Raid:** high‑stakes fight  
4. **Siege:** lock down enemy headquarters  
5. **Final Battle:** territory or mansion takeover  

### War Outcomes
- territory change
- resource transfer
- infamy gain
- morale shift
- seasonal ranking points

============================================================
# 7.10 FACTION MORALE SYSTEM

Morale = faction momentum over time.

Morale adjusts:
- damage buff/nerf
- defense buff/nerf
- recruitment speed
- treasury income
- raid success chance

Morale sources:
- victories/defeats
- leadership actions
- diplomacy deals
- resource surges
- AI Director effects

============================================================
# 7.11 FACTION SEASONS
Each season introduces:
- rotating faction buffs
- seasonal events
- leaderboards
- unique mansion cosmetics
- reward crates
- legacy badges

Season resets:
- standings
- some territory influence
- seasonal resources

============================================================
# 7.12 AI DIRECTOR → FACTION INTEGRATION
AI Director influences faction gameplay by:
- causing borough crises
- boosting gang uprisings
- destabilising territories
- increasing war frequency
- generating faction‑targeted events
- altering economy

High tension → more wars  
Low tension → cooperative missions  

============================================================
# 7.13 ANTI‑EXPLOIT & FAIRNESS RULES
Prevent:
- alt factions feeding resources
- scripted raid farming
- fake wars for ranking
- treasury abuse
- sleeper spam
- territory flipping manipulation

Logs and anti-cheat track:
- member transfers
- treasury flows
- war behaviour patterns
- diplomacy anomalies

============================================================
END OF CHUNK 7



============================================================
# CHUNK 8 — MISSIONS & NPC WORLD MODEL
============================================================

## 8.1 MISSION SYSTEM OVERVIEW
The mission framework in Trench City consists of:
- Story Missions (hand-crafted, branching)
- Procedural Missions (dynamic, replayable)
- Daily/Weekly Missions (rotating loops)
- Faction Missions (team-based objectives)
- Crime Missions (integrated into crime paths)
- Seasonal Mission Arcs (live ops driven)

Missions adapt to:
- player stats
- infamy/karma
- faction membership
- borough states
- AI Director tension
- NPC gang presence
- economic conditions

============================================================
# 8.2 STORY MISSIONS (BRANCHING)
Story missions define the long-term narrative of Trench City.
Each mission includes:
- branching choices
- reputation consequences
- alternate outcomes
- NPC relationship modifiers
- multi-step objectives
- dynamic rewards

Branches include:
- Good Karma
- Neutral Path
- High Infamy
- Faction-Biased Branches
- Police-Collaboration (rare)

============================================================
# 8.3 PROCEDURAL MISSIONS
Procedural missions generate infinitely replayable content.

Inputs:
- borough state
- NPC gang behaviour
- faction influence
- player build & stats
- current crime trends
- AI Director pressure

Mission Types:
- theft jobs
- courier runs
- data theft
- intimidation tasks
- rival sabotage
- extraction missions
- evidence destruction
- smuggling escorts

Procedural missions scale in:
- difficulty
- payout
- danger
- time required
- police heat
- risk of combat

============================================================
# 8.4 DAILY & WEEKLY MISSIONS
Daily missions:
- small tasks (quick wins)
- crime, combat, exploration, trading

Weekly missions:
- multi-step objectives
- higher payouts
- faction benefits
- influence seasonal leaderboards

============================================================
# 8.5 FACTION MISSIONS
Faction missions include:
- smuggling chains
- coordinated raids
- tech heists
- asset protection
- war preparations
- sleeper insertion tasks
- large-scale operations

Faction mission rewards:
- faction XP
- treasury income
- materials
- territory influence
- morale boosts

============================================================
# 8.6 NPC WORLD MODEL
NPCs in Trench City exist at multiple layers.

### NPC Types:
- Civilian
- Street Thug
- Gang Member
- Gang Lieutenant
- Boss NPC
- Faction NPC Allies
- Police Officers
- Detectives
- Undercover Agents
- Corporate Operatives
- Black Market Vendors

NPC Attributes:
- aggression
- fear
- wealth
- influence
- awareness
- loyalty
- relationships (with gangs & factions)
- behaviour profile

============================================================
# 8.7 NPC PERSONALITY TRAITS
Traits modify mission & world interactions:
- Aggressive: attacks player more
- Cautious: flees often
- Loyal: protects gang/faction
- Opportunist: may betray allies
- Greedy: offers bribe options
- Intelligent: avoids obvious traps
- Unstable: unpredictable outcomes

============================================================
# 8.8 NPC GANG SYSTEM
Each borough has NPC gangs with:
- territory
- resources
- strength level
- hostility level
- rivalries (NPC↔NPC, NPC↔player factions)
- gang bosses
- lieutenants

Gang actions:
- ambushes
- extortion attempts
- territory fights
- black market trades
- retaliation missions
- prison breakout attempts

============================================================
# 8.9 NPC CREW SYSTEM (PLAYER HIRES)
Players can hire NPC crew:
- Driver (escape bonuses)
- Hacker (cyber missions)
- Enforcer (combat)
- Scout (reduces heat, improves stealth)
- Negotiator (social checks)

Crew progression:
- levels
- perks
- loyalty system
- risk of betrayal (rare)

============================================================
# 8.10 NPC RELATIONSHIP SYSTEM
NPCs remember player actions:
- betrayals
- bribes
- rescues
- failed missions
- intimidation
- generosity
- reputation

Consequences:
- better mission rewards
- discounted black market access
- ambush avoidance
- special mission unlocks

============================================================
# 8.11 MISSION CHAINS
Mission chains provide escalating content.

Example chain:
1. Meet Contact
2. Retrieve Stolen Goods
3. Infiltrate Rival Warehouse
4. Plant Surveillance Devices
5. Escape Police Raid
6. Final Boss Confrontation

Chains reward:
- special items
- faction influence
- hidden achievements

============================================================
# 8.12 SEASONAL MISSION ARCS
Seasonal arcs introduce limited-time narratives.
Examples:
- London Blackout Event
- Borough Gang War Season
- Political Scandal Arc
- International Syndicate Invasion

Arcs modify:
- crime difficulty
- borough heat
- faction tension
- black market pricing

============================================================
# 8.13 AI DIRECTOR → MISSION INTERACTION
AI Director dynamically adjusts missions:
- increases/decreases difficulty
- injects surprise events
- modifies rewards
- triggers crisis missions
- deploys police/NPC reinforcements
- manipulates borough tension

Examples:
- If too many players succeed crimes → harder missions
- If factions dominate → insurgent NPC missions appear
- If economy inflates → missions reward materials instead of cash

============================================================
# 8.14 ANTI-EXPLOIT RULES FOR MISSIONS
Protection against:
- mission macro loops
- repeated identical mission patterns
- reward funneling
- multi-account boosting
- infinite mission generation exploits

Logs monitor:
- time-to-complete distribution
- reward anomalies
- mission acceptance spam

============================================================
END OF CHUNK 8



============================================================
# CHUNK 9 — ECONOMY & MARKET ARCHITECTURE
============================================================

## 9.1 ECONOMY DESIGN PHILOSOPHY
The Trench City economy must:
- support millions of transactions per day
- prevent inflation
- reward active players
- punish exploiters
- maintain long-term stability
- allow player-driven pricing
- fuel crafting, crime, faction wars, missions, and trading
- integrate NPC & AI-driven economy events

Built on:
1. **Sinks vs Faucets Balance**
2. **Dynamic Pricing Systems**
3. **AI-driven inflation control**
4. **Market segmentation** (cash, crypto, materials)
5. **Player-to-player economic conflict**
6. **Seasonal resets for specific systems**

============================================================
# 9.2 CURRENCIES & VALUE TYPES

### Core Currencies
- **Cash:** everyday liquid currency  
- **Crypto Credits:** high-end black market currency  
- **Faction Influence:** gained via faction ops  
- **Materials:** crafting & upgrading economy  
- **Black Market Reputation:** unlocks rare items  
- **Prestige Tokens:** permanent upgrade currency  

### Material Tiers
- Common Materials
- Rare Materials
- Syndicate Materials (endgame)
- Experimental Components (AI Director events)

============================================================
# 9.3 MONEY FAUCETS (WAYS MONEY ENTERS THE GAME)
- crime payouts  
- missions  
- faction operations  
- racing rewards  
- stock dividends  
- NPC gang bounties  
- properties (limited income)  
- Live Ops event bonuses  

AI Director dynamically tunes faucet strength.

============================================================
# 9.4 MONEY SINKS (WAYS MONEY LEAVES THE GAME)
- item repairs  
- property upkeep  
- vehicle maintenance  
- black market purchases  
- crafting fees  
- faction treasury taxes  
- fines, bribes, bail  
- medical costs  
- racing entry fees  
- mansion upgrades  
- NPC crew wages  

Goal sink strength: ≥ faucet strength to prevent inflation.

============================================================
# 9.5 PLAYER-TO-PLAYER MARKETPLACE
A free-market system where players list:
- items  
- materials  
- weapons  
- crafted mods  
- consumables  

Features:
- price history graph  
- 24h/7d/30d averages  
- anti-scam buyer protection  
- tax on sales (sink)  
- listing expiry timers  

============================================================
# 9.6 AUCTION HOUSE
High-value items only.

Rules:
- auction duration (12–48h)  
- minimum bid increments  
- optional buy-now  
- anti-sniping extension (last-minute bids extend timer)  
- auction tax (sink)  

============================================================
# 9.7 STOCK MARKET SYSTEM
A simulated stock exchange driven by:
- NPC corporations  
- faction wars  
- crime rates  
- borough economy health  
- AI Director events  
- Live Ops modifiers  

Each stock has:
- price  
- volatility  
- sector  
- events affecting value  

Player strategies:
- long-term investment  
- short-term speculation  
- insider risk (NPClinked missions)  

============================================================
# 9.8 MATERIAL ECONOMY
Materials drop from:
- crimes  
- missions  
- faction raids  
- NPC bosses  
- salvaging vehicles/items  
- seasonal events  

Used for:
- crafting  
- upgrading weapons  
- vehicle mods  
- mansion upgrades  
- territory reinforcement  

Raw materials → refined materials → crafted components  

============================================================
# 9.9 CRAFTING ECONOMY
Players can craft:
- weapon mods  
- armour upgrades  
- chemical mixtures  
- hacking tools  
- smuggling containers  
- vehicle tuning kits  

Crafting difficulty depends on:
- materials  
- blueprint rarity  
- crafting skill  
- faction workshop upgrades  

============================================================
# 9.10 BLACK MARKET ECONOMY
Black Market rotates:
- rare weapons  
- experimental gear  
- disguises  
- tools  
- illegal mods  
- exclusive crafting blueprints  

Prices fluctuate based on:
- police heat  
- borough stability  
- AI Director crisis mode  
- faction control  
- NPC gang presence  

============================================================
# 9.11 NPC ECONOMIC BEHAVIOUR
NPC gangs and factions also:
- buy items  
- trade materials  
- adjust territory income  
- influence black market pricing  
- inject or remove money from circulation  

NPC actions can cause:
- item shortages  
- material floods  
- price spikes  

============================================================
# 9.12 LIVE OPS ECONOMY CONTROLS
Live Ops can:
- buff crime payouts  
- introduce material weekends  
- freeze stock markets  
- alter marketplace taxes  
- introduce new crafting recipes  
- create inflation relief events  

============================================================
# 9.13 ECONOMY AI — INFLATION & STABILITY ENGINE
The economy AI monitors:
- total cash in system  
- velocity of money  
- item sale counts  
- player wealth distribution  
- market manipulation attempts  
- sinks vs faucets graph  

AI can:
- auto-adjust crime payouts  
- increase repair costs  
- increase bribe/jail fines  
- adjust black market prices  
- trigger recession/boom cycles  

============================================================
# 9.14 ANTI-EXPLOIT MEASURES
Prevents:
- dupe glitches  
- price manipulation  
- alt account laundering  
- item duplication  
- infinite money loops  
- coordinated market manipulation  

Detection uses:
- anomaly scoring  
- transaction velocity checks  
- wealth spike alerts  
- behaviour clustering  

============================================================
# 9.15 MULTI-CURRENCY INTERACTIONS
Examples:
- Cash → Crypto via black market exchange  
- Crypto → Rare Items  
- Materials → Crafted Mods  
- Influence → Faction Bonuses  
- Prestige Tokens → Permanent Upgrades  

============================================================
END OF CHUNK 9



============================================================
# CHUNK 10 — PROPERTIES & HOUSING EXPANSION BOOK
============================================================

## 10.1 PROPERTY SYSTEM OVERVIEW
The Trench City housing system provides:
- player progression
- passive stat bonuses
- stash/security storage
- crafting & production utilities
- raid/interception gameplay
- long-term wealth building
- endgame prestige

Properties scale in:
- capacity
- utility
- security
- passive regeneration bonuses
- economy value

============================================================
# 10.2 PROPERTY TIERS (FULL PROGRESSION)
1. Bedsit  
2. Studio Flat  
3. 1-Bedroom Flat  
4. 2-Bedroom Flat  
5. Small House  
6. Detached House  
7. Luxury Townhouse  
8. Penthouse Apartment  
9. Mini-Mansion  
10. Estate / Compound  
11. Syndicate Estate (Faction-Scale)

Each higher tier unlocks:
- more upgrade slots  
- higher stash capacity  
- improved regen  
- cosmetic prestige value  

============================================================
# 10.3 HOUSING BONUSES
Properties offer the following passive bonuses:
- **Happy regeneration**  
- **Nerve regeneration** (high-end upgrades only)  
- **Energy regeneration** (rare, late-game)  
- **Life regen boost**  
- **Heat reduction rate increase**  
- **Skill training boost** (via training rooms)  

============================================================
# 10.4 PROPERTY UPGRADES & ROOMS
Each property has a number of upgrade slots depending on tier.

### Core Upgrade Rooms
- **Safe Room:** stash protection, anti-theft  
- **CCTV System:** alerts player to burglaries  
- **Security Door Reinforcement:** increases break-in difficulty  
- **Garage:** stores vehicles, adds tuning bonuses  
- **Workshop:** crafting & modification room  
- **Chem Lab:** drug/crafting bonus  
- **Server Room:** cybercrime skill boost  
- **Greenhouse:** resource/mat production  
- **Gym Room:** small stat training bonus  
- **Crypto Mining Rig:** generates crypto currency slowly  
- **Escape Tunnel:** reduces heat after crimes  
- **Black Market Terminal:** discounted BM prices (late-game)  

============================================================
# 10.5 PROPERTY REGENERATION SYSTEM
Happy regen base per tier:  
- low-tier: +2–5/min  
- mid-tier: +6–12/min  
- high-tier: +15–30/min  

Nerve regen:
- only available from rare upgrades  
- small bonuses (0.1–0.5/min)  
- prevents overpowered stacking  

Energy regen:  
- very rare (prestige or elite upgrade)  

Life regen:
- small regen boost while resting  

============================================================
# 10.6 STASH & STORAGE SYSTEM
Properties provide storage for:
- items  
- materials  
- cash  
- contraband  
- weapons  

Stash security rating determines:
- burglary difficulty  
- success chance of NPC thieves  
- risk reduction during faction raids  

Higher-tier properties automatically include:
- silo-style stash  
- multi-lock vault systems  
- hidden compartments  

============================================================
# 10.7 PROPERTY RAID & BURGLARY SYSTEM

### NPC Burglary Attempts
NPC thieves may attempt:
- window entry  
- door breach  
- exploiting low-security rooms  
- opportunistic theft during high heat  

Player sees:
- CCTV alerts  
- motion sensor logs  
- police notifications (if player has contacts)  

### Player vs Player Property Raids (future expansion)
Optional PvP feature:
- highly regulated  
- requires faction war  
- strict cooldowns  
- anti-exploit protection  

============================================================
# 10.8 HOUSING MARKET SIMULATION
Housing prices change dynamically based on:
- economy health  
- borough crime levels  
- AI Director tension  
- player demand  
- seasonality  

Market Events:
- housing boom  
- recession  
- crime wave reducing property values  
- syndicate takeover boosting underground property prices  

============================================================
# 10.9 RENTAL SYSTEM
Players can:
- rent properties to others  
- sublet rooms  
- set rent prices  

Includes:
- rental agreements  
- eviction rules  
- delayed payments  
- rent scams detection  

============================================================
# 10.10 PROPERTY SELLING & MORTGAGES
Players can:
- buy outright  
- mortgage properties  
- refinance  
- sell to other players  
- sell to NPC market at reduced value  

Mortgage Rules:
- interest rate system  
- repossession risk  
- creditworthiness score  

============================================================
# 10.11 PROPERTY PRESTIGE SYSTEM
As players expand their portfolio, they earn:
- cosmetic prestige titles  
- leaderboard ranking  
- visitable homes (social system expansion)  
- passive bonuses  
- appraisal system  

============================================================
# 10.12 LAND OWNERSHIP (EXPANSION MODULE)
Future-proof design includes:
- owning land plots  
- building custom structures  
- player business properties  
- faction-owned land  
- passive income from districts  

============================================================
# 10.13 PROPERTY PORTFOLIO SYSTEM
Portfolio tracks:
- total property value  
- rental income  
- property diversity index  
- maintenance costs  
- prestige multipliers  

============================================================
# 10.14 ANTI-EXPLOIT PROTECTIONS
Prevents:
- laundering through property flips  
- stash duplication exploits  
- rental scams  
- infinite mortgage abuse  
- coordinated inflation loops  
- faction exploitation using property raids  

Monitoring:
- transactional analysis  
- suspicious price spikes  
- stash manipulation logs  

============================================================
END OF CHUNK 10



============================================================
# CHUNK 11 — VEHICLES, RACING & SMUGGLING SYSTEMS
============================================================

## 11.1 VEHICLE SYSTEM OVERVIEW
Vehicles in Trench City serve three major roles:
- Transportation (affecting travel times & detection risk)
- Racing (legal circuits & underground street races)
- Smuggling (local & international contraband movement)

Vehicles support:
- upgrades
- durability
- tuning
- stealth builds
- cargo expansion
- faction synergy

============================================================
# 11.2 VEHICLE CLASSES
1. **Mopeds** – cheap, low cargo, high stealth  
2. **Motorbikes** – fast, agile, low cargo  
3. **Compact Cars** – balanced starter vehicles  
4. **Sedans** – reliable, moderate cargo  
5. **SUVs** – high durability, larger cargo  
6. **Vans** – high cargo, low stealth  
7. **Sports Cars** – high speed, low cargo  
8. **Supercars** – extreme speed, low practicality  
9. **Armoured Vehicles** – high protection, very low stealth  
10. **Syndicate Builds** – late-game custom faction vehicles  

============================================================
# 11.3 VEHICLE STATS
Vehicles have multiple stat categories:

### SPEED  
Affects:
- racing top speed
- escape chance during smuggling
- police chase outcomes  

### HANDLING  
Affects:
- cornering performance  
- stability during races  
- crash risk  

### STEALTH  
Affects:
- police detection chance  
- NPC ambush likelihood  

### CARGO  
Affects:
- smuggling load  
- mission material hauling  

### DURABILITY  
Affects:
- damage taken from crashes  
- wear-and-tear from smuggling  
- repair cost  

============================================================
# 11.4 VEHICLE UPGRADES & TUNING
Upgrades include:
- turbo systems  
- improved brakes  
- chassis tuning  
- stealth coating  
- reinforced armor  
- cargo expansion kits  
- sound dampeners  
- off‑road tyres  
- nitro boosts (racing only)  

Upgrades have tiers (I–V) and require:
- cash  
- materials  
- blueprints (rare)  

Tuning specialisations:
- racing build  
- smuggling build  
- stealth build  
- balanced utility build  

============================================================
# 11.5 DURABILITY & DAMAGE SYSTEM
Vehicles take damage from:
- races  
- smuggling  
- police chases  
- crashes  
- ambushes  

Damage effects:
- reduced speed  
- reduced handling  
- cargo loss  
- stealth penalty  

Repairs cost:
- cash  
- materials (for advanced vehicles)  

============================================================
# 11.6 RACING SYSTEM OVERVIEW
Racing includes:
1. **Legal Tracks**  
   - organized races  
   - entry fees  
   - leaderboard system  

2. **Underground Street Races**  
   - boosted rewards  
   - high police heat  
   - AI Director may trigger chases  

3. **Time Trials**  
   - solo challenges  
   - material/blueprint rewards  

============================================================
# 11.7 RACING TRACK TYPES
- Urban Circuit  
- Dockside Sprint  
- Motorway Strip  
- Industrial Drift Track  
- Hill Climb Trials  
- Rain-Slick Night Course (weather modifier)  

Each track modifies:
- handling requirements  
- speed bonuses  
- risk factors  
- police heat  

============================================================
# 11.8 RACING FORMULAS
Race time = base_track_time  
          - (speed * factor1)  
          - (handling * factor2)  
          + weather_modifier  
          + damage_penalty  

Police chase chance:
= base_risk  
+ heat_modifier  
+ aggression_rating  
+ AI Director boost  

============================================================
# 11.9 SMUGGLING SYSTEM OVERVIEW
Smuggling is a major midgame & endgame loop.

### Local Smuggling
- moving contraband between boroughs  
- NPC gang interference  
- police checkpoints  

### International Smuggling
- airports  
- ports  
- tunnels  
- multi-step missions  

Contraband types:
- drugs  
- weapons  
- rare materials  
- sensitive data  
- faction-level cargo  

============================================================
# 11.10 SMUGGLING ROUTES
Each route has:
- distance  
- detection difficulty  
- NPC gang presence  
- weather effects  
- police intensity  
- AI Director tension weighting  

Players can:
- scout routes  
- bribe informants  
- use stealth vehicles  
- hire NPC crew (driver/scout)  

============================================================
# 11.11 SMUGGLING SUCCESS FORMULA
success_chance = base_rate  
                + (stealth * factor1)  
                + (driver_skill * factor2)  
                - (police_presence * factor3)  
                - (cargo_weight_penalty)  
                + crew_bonus  
                + faction_territory_bonus  

============================================================
# 11.12 SMUGGLING FAILURE OUTCOMES
- cargo seized  
- vehicle damage  
- police chase → possible jail  
- NPC ambush  
- heat spike  
- faction reputation loss  

============================================================
# 11.13 FACTION SMUGGLING OPERATIONS
Faction-exclusive missions include:
- multi-vehicle convoys  
- coordinated escapes  
- decoy operations  
- high-value cargo runs  
- syndicate deals  

Rewards:
- faction influence  
- treasury income  
- rare materials  
- smuggling reputation  

============================================================
# 11.14 ANTI-EXPLOIT RULES
Prevents:
- smuggling bots  
- predictable race manipulation  
- route abuse  
- cargo duplication  
- intentional crash resets  
- low-risk infinite loops  

Analytics track:
- completion times  
- cargo vs route difficulty  
- statistical anomalies  

============================================================
END OF CHUNK 11



============================================================
# CHUNK 12 — SOCIAL SYSTEMS DEEP BOOK
============================================================

## 12.1 SOCIAL SYSTEM OVERVIEW
Social systems create:
- community
- rivalry
- communication
- trust & distrust
- information flow  
- political power
- faction cohesion
- player-driven storytelling

Trench City's social layer must support:
- 1M+ active daily messages
- high moderation stability
- anti-abuse enforcement
- real-time communication
- scalable forums & chat channels

============================================================
# 12.2 MAIL SYSTEM
The internal mail system includes:
- inbox, sent, archived folders
- conversation threading
- filtering (by user, faction, unread, attachments)
- star/flag system
- block list integration
- message search

### Mail Features:
- Attach items
- Attach cash (limits + anti-scam)
- Attach screenshots or logs (future expansion)
- Report button
- Auto-delete for old mail (configurable)
- Anti-spam throttle

### Anti-Abuse:
- rate limiting per hour
- message content analysis (spam patterns)
- auto-flagging suspicious attachments
- alt-account conversation pattern detection

============================================================
# 12.3 MESSENGER / REAL-TIME CHAT
Messenger supports:
- 1v1 direct messages
- group chats (up to 50 users)
- faction chat
- squad chat (mission groups)
- city-wide announcements
- emoji/sticker packs (cosmetic monetisation)

Chat Features:
- typing indicators
- read receipts
- online/offline status
- @mentions
- pinned messages
- file size-limited attachments (images/logs)

Real-time tech:
- WebSockets / long polling fallback
- scalable cluster design

Moderation hooks:
- soft & hard mute
- shadow ban
- chat filters (customisable per channel)
- automated toxicity classifier

============================================================
# 12.4 FORUM SYSTEM
Forums act as long-form discussion hubs.

### Categories:
- General
- New Player Help
- Crime Discussion
- Faction Recruitment
- Market Watch
- Racing & Vehicles
- Bug Reports
- Suggestions
- Off-Topic

### Features:
- upvotes/downvotes
- best answer system
- forum badges
- moderator tags
- pinned posts
- post history
- markdown-like formatting
- polls
- spoiler tags

Forum anti-abuse:
- duplicate post detection
- behavioural anomaly checks
- rate limits
- cross-account similarity checks

============================================================
# 12.5 RELATIONSHIP SYSTEM (FRIENDS / RIVALS)
Players can:
- add friends
- add rivals
- favourite allies
- mark hostile players

Relationship Effects:
- improved assist chances (friends)
- increased revenge/mug chance (rivals)
- faction recruitment preferences
- crime/mission collaboration buffs

============================================================
# 12.6 REPUTATION SYSTEM
Reputation values:
- Karma (good actions)
- Infamy (criminal actions)
- Notoriety (public awareness)
- Trust Score (used for trading/social)

### Karma increases from:
- helping players
- donations
- fair play

### Infamy increases from:
- murders
- high-tier crimes
- faction wars
- big heists

Notoriety affects:
- NPC behaviour  
- bounty likelihood  
- special mission unlocks

============================================================
# 12.7 NEWSPAPER SYSTEM
The newspaper is dynamic and includes:
- player-written articles (reviewed by mods)
- NPC-generated news:
  - faction wars  
  - major crimes  
  - economic events  
  - AI Director crisis alerts  
  - racing championships  
  - stock surges/crashes  
  - political scandals  

Front page highlights:
- top players
- mugshots
- criminal of the week
- faction of the month

============================================================
# 12.8 MODERATION TOOLS
Moderators have:
- chat mute
- chat purge
- forum post removal
- account warnings
- temp bans
- permanent bans
- IP/device fingerprinting tools
- social activity log viewer

Moderation dashboard includes:
- user behaviour graphs
- toxicity scores  
- flagged content feed  
- alt detection indicators  

============================================================
# 12.9 PLAYER SAFETY & REPORTING SYSTEM
Players can report:
- harassment
- scamming  
- duping & cheating  
- toxic behaviour  
- exploitation attempts  

Automated triggers:
- keyword filters
- AI-powered toxicity analysis
- rapid escalation for minors (COPPA-safe)

============================================================
# 12.10 SOCIAL ANALYTICS & AI
Social analytics track:
- message volume  
- faction communication density  
- toxicity levels  
- spam clusters  
- bot networks  
- sentiment trends  
- player social health score  

AI systems can:
- automatically mute bots
- detect alt networks
- remove spam waves
- surface positive social content

============================================================
# 12.11 ANTI-EXPLOIT & SOCIAL SECURITY
Prevents:
- alt coordination  
- vote manipulation  
- marketplace collusion  
- spam floods  
- harassment raids  
- misinformation in wars  

Detection methods:
- cluster analysis  
- rate-limiting  
- content fingerprinting  
- behavioural signatures  

============================================================
END OF CHUNK 12



============================================================
# CHUNK 13 — EVENTS, SEASONS & LIVE OPS SYSTEM
============================================================

## 13.1 EVENT SYSTEM OVERVIEW
Events bring dynamism, replayability, economy shifts, and narrative evolution.
The system supports:
- hourly events
- daily rotations
- weekly modifiers
- monthly/seasonal arcs
- AI-triggered crisis events
- faction-wide events
- city-wide world events
- leaderboard competitions

Events may affect:
- crime payouts
- police heat
- faction wars
- NPC gang behaviour
- marketplace taxes
- stock market volatility
- smuggling risks
- mission availability

============================================================
# 13.2 EVENT TYPES

### 1. Static Scheduled Events
Run on a fixed timetable:
- Daily bonuses  
- Weekend crime boosts  
- Weekly faction operations  
- Market tax reduction days  
- Rotation of rare black market items  

### 2. Dynamic AI Events
Triggered by:
- player behaviour  
- economy inflation  
- low/high crime success rates  
- faction dominance  
- borough instability  
- individual notoriety spikes  

Examples:
- Police Crackdown  
- Economic Recession  
- NPC Gang Resurgence  
- AI Director “Crisis Surge”  

### 3. Seasonal Events
3–4 month live arcs with:
- new mission chains  
- unique challenges  
- themed cosmetics  
- limited-time crafting materials  
- seasonal battle pass rewards  

### 4. Micro Events
Occur randomly:
- muggings  
- flash sales  
- street intel drops  
- faction recruitment rush  
- black market access boosts  

============================================================
# 13.3 EVENT MODIFIER SYSTEM
Modifiers apply temporary global effects.

### Modifier Examples:
- +Crime XP  
- +Nerve Regen  
- +Smuggling Success Chance  
- +Material Drop Rate  
- -Marketplace Tax  
- -Police Heat Accumulation  
- Weather Events (rain/fog/snow) affecting races & stealth  

Modifiers have:
- rarity  
- duration  
- stack rules  
- AI Director weighting  

============================================================
# 13.4 AI DIRECTOR — EVENT GENERATION ENGINE
The AI Director monitors:
- crime success trends  
- faction war stability  
- economy inflation  
- NPC gang behaviour  
- housing market  
- vehicle/racing meta  
- player onboarding flow  

If imbalance detected, the AI Director may:
- increase police patrol density  
- weaken/strengthen NPC gangs  
- spawn special missions  
- create borough crises  
- reduce/increase crime payouts  
- influence stock market  
- trigger smuggling inspections  
- introduce emergency events  

The AI Director ensures:
- no long-term stagnation  
- challenge variety  
- emergent storytelling  
- counterbalance dominant players/factions  

============================================================
# 13.5 EVENT FLOW STRUCTURE
Events follow a lifecycle:
1. Pre-announcement  
2. Event activation  
3. Modifier application  
4. Event challenges unlock  
5. Reward milestones  
6. Event conclusion  
7. Leaderboard finalisation  
8. Reward distribution  
9. Post-event news coverage  

============================================================
# 13.6 EVENT CHALLENGES
Challenge types:
- Crime Milestones  
- Combat Kill/Win Goals  
- Faction Raid Requirements  
- Smuggling Distance Goals  
- Mission Completion Counts  
- Vehicle Race Time Trials  
- Crafting & Material Gathering  
- Social/Forum Participation  

Challenges scale by:
- level  
- total playerbase engagement  
- faction participation  
- AI Director pressure  

============================================================
# 13.7 EVENT REWARD STRUCTURE
Rewards include:
- cash  
- materials  
- rare crafting components  
- event-only weapons  
- cosmetic skins  
- profile borders  
- vehicle paint jobs  
- titles  
- prestige tokens  
- faction XP  
- mansion decorations  

Reward Tiers:
- Bronze  
- Silver  
- Gold  
- Diamond  
- Legendary (top 1–5%)  

============================================================
# 13.8 LEADERBOARD SYSTEM
Leaderboards track:
- Crime XP  
- Faction Wars  
- Racing Times  
- Wealth  
- Smuggling Routes Completed  
- Seasonal Challenge Points  
- Prestige Level  
- NPC Kills / Boss Clears  

Leaderboard reset rules:
- daily  
- weekly  
- seasonal  
- annual legacy boards  

Anti-exploit:
- IP/device similarity checks  
- score anomaly detection  
- anti-bot time analysis  

============================================================
# 13.9 SEASON PASS (BATTLE PASS SYSTEM)
Season lasts 90–120 days.  
Contains:
- free track  
- premium track  
- prestige track (if completed early)

Season Pass rewards:
- cosmetics  
- materials  
- rare item crates  
- crafting upgrades  
- vehicle skins  
- faction XP  
- titles  

Progress sources:
- crimes  
- missions  
- racing  
- smuggling  
- faction ops  
- seasonal challenges  

============================================================
# 13.10 SEASONAL STORY ARCS
Seasonal arcs introduce:
- new NPC factions  
- major crises  
- temporary gameplay mechanics  
- world state changes (borough income, crime difficulty)  
- unique bosses  
- final event showdown  

Example arcs:
- *Syndicate Invasion*  
- *Blackout of London*  
- *Gang War Season*  
- *Political Corruption Cycle*  

============================================================
# 13.11 LIVE OPS DASHBOARD (ADMIN)
Admin tools include:
- toggle events  
- modify global modifiers  
- create custom events  
- trigger crises  
- adjust payout levels  
- monitor live player distribution  
- view analytics (heat maps, economy graphs)  

This dashboard powers:
- seasonal planning  
- emergency balancing  
- limited-time boosts  
- PR-driven events  

============================================================
# 13.12 LIVE OPS ANALYTICS
Track:
- player engagement  
- retry/fail rates  
- faction involvement  
- economy inflation  
- heat distribution  
- event participation funnel  
- leaderboard manipulation attempts  

Analytics drive:
- next season design  
- reward tuning  
- difficulty adjustments  
- exploit detection  

============================================================
# 13.13 ANTI-EXPLOIT RULES
Protects from:
- event farming  
- leaderboard collusion  
- challenge macroing  
- bot score inflation  
- exploit abuse of modifiers  
- payout loops  

Detection includes:
- session irregularities  
- timing anomalies  
- repeated identical behaviour  
- alt account clustering  

============================================================
END OF CHUNK 13



============================================================
# CHUNK 14 — STORE, COSMETICS & MONETISATION FRAMEWORK
============================================================

## 14.1 MONETISATION PHILOSOPHY
Trench City follows a **Fair Play Monetisation Model**:
- ZERO pay‑to‑win
- NO stat advantages from purchases
- Cosmetics, convenience, and optional premium paths ONLY
- Respectful pricing
- Anti-whale safeguards
- Anti-predatory mechanics
- Skill & effort always beat money

Revenue sources:
1. Cosmetics
2. Season Pass Premium Track
3. Convenience Boosts (non-stat changing)
4. Mansion/Vehicle Cosmetics
5. Name Change / Profile Flair
6. Cosmetic Loot Crates (no gambling — fixed outcomes)

============================================================
# 14.2 COSMETIC STORE OVERVIEW
Store cycles include:
- Daily rotation
- Weekly rotation
- Seasonal collection drops
- Limited edition “Dark Luxury” series
- Faction-themed cosmetics
- Vehicle wraps
- Profile frames
- Chat effects
- Title banners
- Character portrait borders
- Weapon skins (visual only)

Cosmetic Categories:
- **Common**
- **Rare**
- **Epic**
- **Legendary**
- **Ultra-Luxury (Season Exclusive)**

============================================================
# 14.3 MANSION COSMETICS
Players can customise:
- interior themes
- exterior skins
- lighting effects
- animated wall art
- mansion banners
- faction insignias
- environmental ambience (rain, neon glow, fog machine)

None affect gameplay mechanics.

============================================================
# 14.4 VEHICLE COSMETICS
Vehicle skins include:
- wraps
- neon underglow
- exhaust FX
- license plates
- alloy styles
- animated trail effects (rare)
- prestige racing decals

Cosmetic tiers unlock via:
- season pass
- event rewards
- store purchase
- legendary crates

============================================================
# 14.5 PROFILE COSMETICS
Players can equip:
- profile backgrounds
- animated banners
- avatar borders
- prestige badges
- infamy flames (visual only)
- karma halos (visual only)
- animated stat card frames

============================================================
# 14.6 CHAT COSMETICS
Unlockable cosmetic effects:
- gold chat name
- animated name shimmer
- faction-coloured chat badges
- emoji/sticker packs
- message entry effects (subtle glow)
- VIP chat channel access for donators

============================================================
# 14.7 SEASON PASS MONETISATION
Season Pass includes:
- **Free Track:** basic rewards
- **Premium Track:** cosmetics, material packs
- **Prestige Track:** exclusive end-tier visuals

Rewards include:
- exclusive skins
- rare materials
- profile animations
- mansion themes
- vehicle wraps
- titles
- prestige tokens

Season Pass XP earned by:
- crimes
- missions
- racing
- smuggling
- faction ops
- seasonal challenges

============================================================
# 14.8 CURRENCY PACKS (SAFE MODEL)
Currency packs ONLY include:
- cosmetic currency
- prestige currency (small amounts)
- profile cosmetics
- vehicle/mansion cosmetics

Cash packs NEVER directly convert into gameplay power.

============================================================
# 14.9 STORE EVENTS & SALES
Sales Types:
- Weekend Flash Sales
- Seasonal Drops
- Anniversary Event
- Faction Celebration Themes
- NPC-Driven Themes (Gang War Sale)
- Dynamic AI Director Store Boosts

============================================================
# 14.10 BUNDLES
Bundles include:
- cosmetic sets
- mansion design packs
- racing cosmetic sets
- criminal lifestyle packs (purely visual)
- faction cosmetic kits

NO gameplay bonuses included.

============================================================
# 14.11 LOOT CRATES (FAIR, NON-GAMBLING)
Each crate has:
- fixed outcome items
- displayed odds
- duplicates convert into cosmetic tokens
- no real-money gambling mechanics
- fully compliant with global regulations

Crate Types:
- Weapon Skin Crate
- Vehicle Wrap Crate
- Profile Flair Crate
- Seasonal Crate

============================================================
# 14.12 ANTI-WHALE SAFEGUARDS
To ensure fairness:
- spending caps for cosmetic advantage situations
- diminishing returns on cosmetic crates
- no auctionable premium exclusives
- hard rule: cosmetics never influence stats

============================================================
# 14.13 FRAUD PREVENTION & CHARGEBACK PROTECTION
Store security includes:
- device fingerprinting
- fraudulent purchase detection
- suspicious refund pattern flags
- cooldown for tradable cosmetics
- temporary locking of high-risk accounts

============================================================
# 14.14 STORE ANALYTICS
Tracked:
- cosmetic popularity
- player sentiment
- revenue pacing
- store cycle performance
- traffic funnels
- fraud attempts
- whale behaviour modelling (ethical boundaries)

============================================================
END OF CHUNK 14



============================================================
# CHUNK 15 — AI SYSTEMS: AI DIRECTOR, NPC BEHAVIOUR & WORLD SIMULATION
============================================================

## 15.1 AI SYSTEMS OVERVIEW
The AI framework enables Trench City to function as a reactive, evolving world.
Core pillars:
1. **AI Director** – global tension & dynamic content generator  
2. **NPC Behaviour Engine** – personality-driven actions & reactions  
3. **World Simulation Engine** – borough, economy, crime, and faction modelling  
4. **AI Anti‑Exploit Layer** – behavioural detection & protection  

Systems integrate across:
- crimes  
- missions  
- factions  
- economy  
- events  
- smuggling  
- policing  
- property raids  
- NPC gangs  

============================================================
# 15.2 AI DIRECTOR — GLOBAL CONTROL SYSTEM
The AI Director tracks real-time global metrics:
- crime success/failure rates  
- faction dominance  
- borough instability  
- NPC gang strength  
- economy inflation/deflation  
- racing times & meta  
- smuggling success/failure patterns  
- player retention metrics  
- server population heatmaps  

### AI Director Outputs:
- modify crime difficulty  
- adjust police presence  
- spawn ambush events  
- boost/nerf NPC gangs  
- trigger borough crises  
- increase/decrease event modifiers  
- manipulate stock market volatility  
- alter smuggling detection probability  
- deploy rare NPC bosses  
- trigger faction war escalation events  

### AI Director Tension Meter:
Tracks five categories:
1. **Crime Tension**  
2. **Economic Tension**  
3. **Faction Tension**  
4. **Borough Tension**  
5. **Player Tension** (player frustration meter)  

Tension spikes → crisis events.  
Tension drops → bonus events.

============================================================
# 15.3 DIRECTOR DECISION TREE
Director logic updates every X minutes using:
- weighted probability  
- priority-based event selection  
- branching if-else behaviour modelling  
- cooldowns to avoid repetition  
- personality modifiers (Director “moods”)  

Director Moods:
- **Aggressive** (police crackdowns, gang boosts)  
- **Chaotic** (random modifiers, weather changes)  
- **Economic** (market manipulation)  
- **Narrative** (story event injection)  
- **Passive** (recovery period)  

============================================================
# 15.4 NPC BEHAVIOUR ENGINE
NPCs operate using:
- **goal-oriented behaviour (GOAP)**  
- **memory-based decision-making**  
- **personality traits**  
- **territory loyalty**  
- **economic incentives**  
- **faction alignment**  

NPC Personality Factors:
- aggression  
- fear  
- greed  
- loyalty  
- intelligence  
- unpredictability  
- awareness  

NPCs remember:
- player betrayals  
- bribes  
- kills  
- reputation  
- previous interactions  

============================================================
# 15.5 NPC GANG AI
NPC gangs control borough turf using:
- influence scoring  
- manpower  
- economic value  
- hostility  
- rivalries  

Gang AI performs:
- expansion attempts  
- defensive reinforcements  
- ambushes  
- black market deals  
- retaliation attacks  
- takeover of weakened gangs  
- sabotage missions  

Gang morale affects:
- aggression  
- recruitment  
- territory defense strength  

============================================================
# 15.6 POLICE AI SYSTEM
Police AI tracks:
- player notoriety  
- borough crime density  
- smuggling intensity  
- faction war visibility  
- heat levels  

Police behaviours:
- patrol rerouting  
- checkpoint establishment  
- undercover infiltration  
- high-risk pursuit escalation  
- borough lockdowns  
- special task forces deployment  

============================================================
# 15.7 NPC BOSS AI
Boss NPCs use phased behaviour:
Phase 1 – Standard combat  
Phase 2 – Defensive stance  
Phase 3 – Aggressive burst  
Phase 4 – Escape or desperation attack  

Boss modifiers:
- minions  
- environmental advantages  
- ambush mechanics  
- reputation-based responses  

============================================================
# 15.8 WORLD SIMULATION ENGINE
The world simulation governs:
- borough economy  
- NPC population  
- police coverage  
- heat distribution  
- black market supply/demand  
- housing market prices  
- faction influence spread  
- NPC gang turf  

Simulation updates hourly/daily.

============================================================
# 15.9 BOROUGH SIMULATION
Each borough tracks:
- crime difficulty  
- economic value  
- safety index  
- gang presence  
- police density  
- faction territory influence  

Events modify borough stats:
- crises  
- raids  
- smuggling spikes  
- economic booms/slumps  
- NPC gang wars  

============================================================
# 15.10 ECONOMY INTERACTION WITH AI
AI directly affects:
- price inflation  
- material scarcity  
- black market fluctuations  
- rental prices  
- mortgage default rates  
- crime payouts  

AI stabilises runaway inflation and exploits.

============================================================
# 15.11 AI HOOKS INTO COMBAT
AI Director can modify:
- enemy reinforcements  
- ambush probability  
- damage ranges  
- escape rates  
- NPC accuracy  
- chase difficulty  

NPCs evaluate:
- odds of winning  
- whether to flee  
- whether to call backup  
- loyalty modifiers  

============================================================
# 15.12 AI HOOKS INTO CRIMES
Crime difficulty shifts based on:
- global crime success rates  
- player level distribution  
- police density  
- gang influence  
- borough instability  

Outcomes adjust dynamically for:
- heat  
- payout  
- risk  
- difficulty  

============================================================
# 15.13 AI HOOKS INTO SMUGGLING
AI monitors smuggling patterns to:
- increase checkpoint frequency  
- trigger random inspections  
- adjust detection curves  
- deploy ambushes  
- enhance police pursuit AI  

============================================================
# 15.14 AI HOOKS INTO FACTIONS
AI interacts with faction wars:
- boosts weaker factions  
- triggers NPC gang alliances  
- adjusts morale  
- spawns faction missions  
- manipulates influence spread  
- escalates unresolved wars  

============================================================
# 15.15 ANTI-EXPLOIT AI SYSTEM
Tracks:
- abnormal farming patterns  
- heat manipulation  
- market abuse  
- coordinated bot behaviour  
- suspicious timing clusters  
- multi-account collaboration  
- smuggling macro patterns  
- racing exploit detection  

Tools:
- similarity scoring  
- movement fingerprinting  
- behavioural clustering  
- anomaly spikes  

Actions:
- soft flags  
- shadow bans  
- temp restrictions  
- auto-reports for moderators  

============================================================
# 15.16 AI LOAD MANAGEMENT
AI complexity scales with server load:
- simplified AI for low-population hours  
- full simulation during peak  
- background batching for non-critical tasks  
- adaptive tick rate  

============================================================
END OF CHUNK 15



============================================================
# CHUNK 16 — COMBAT SYSTEMS (PVE, PVP, WEAPONS, ARMOR, SKILLS)
============================================================

## 16.1 COMBAT SYSTEM OVERVIEW
Combat in Trench City is:
- statistical
- strategic
- skill-influenced
- AI-reactive
- risk-versus-reward driven

Supports:
- PvP combat  
- PvE NPC combat  
- Boss encounters  
- Ambushes & counter-attacks  
- Faction raid combat  
- Smuggling interception fights  
- Crime failure fights  

============================================================
# 16.2 PRIMARY COMBAT STATS
### Strength  
Increases melee damage + small boost to firearm recoil control.

### Defense  
Reduces incoming physical damage + improves armor effectiveness.

### Speed  
Affects turn order, evasion, chase outcomes, and attack frequency.

### Dexterity  
Boosts accuracy, crit chance, penetration, and weapon handling.

============================================================
# 16.3 WEAPON CLASSES
1. **Melee Weapons**
   - bats, blades, improvised tools  
   - high bleed chance  

2. **Small Arms**
   - pistols, revolvers  
   - balanced accuracy  

3. **Rifles**
   - assault rifles, snipers  
   - penetration + range bonus  

4. **Shotguns**
   - high damage, low accuracy range  

5. **Specialist Weapons**
   - tasers (stun)
   - dart guns (debuffs)
   - incendiaries  

6. **Explosives**
   - heavy AoE damage  
   - limited availability  

============================================================
# 16.4 WEAPON ATTRIBUTES
- Base Damage  
- Accuracy %  
- Crit Chance  
- Penetration  
- Reload Time  
- Jam Chance  
- Recoil  
- Armor Interaction Type  

============================================================
# 16.5 ARMOR SYSTEM
Armor provides:
- flat damage reduction  
- penetration mitigation  
- durability (degrades over time)

Armor Types:
- Light Armor (speed bonus, low DR)  
- Tactical Vest (balanced DR)  
- Heavy Armor (high DR, speed penalty)  
- Experimental Armor (rare effects)  

============================================================
# 16.6 STATUS EFFECTS
### **Bleed**
- Lose HP over time  
- Stacks with repeated hits  

### **Stun**
- Skip turns  
- Applied by tasers, blunt hits  

### **Suppression**
- Reduced accuracy + speed  
- Caused by automatic weapons  

### **Panic**
- NPC-only state; reduced logic efficiency  

### **Fatigue**
- From long fights; reduces damage output  

============================================================
# 16.7 COMBAT FORMULAS (SIMPLIFIED)
Damage Output Formula:
```
damage = (weapon_damage * (1 + STR/100)) 
         - (enemy_armor * armor_factor)
```

Accuracy Formula:
```
hit_chance = base_acc + (DEX * 0.6) + (SPD * 0.2) - enemy_evasion
```

Crit Chance:
```
crit = base_crit + (DEX * 0.3)
```

Turn Order:
```
SPD determines who acts first and how often.
```

============================================================
# 16.8 PVP COMBAT MODES
- Standard Attack  
- Ambush Attack  
- Counter Attack  
- Retaliation  
- Bounty Attack  
- Faction War Combat  
- Raid Combat  
- Drive-by Attacks (vehicle-based)  

============================================================
# 16.9 PVE COMBAT
NPC Types:
- Thugs  
- Gang Members  
- Enforcers  
- Syndicate Operatives  
- Police Units  
- Elite Task Force  
- Boss NPCs (multi-phase)  

NPC AI uses:
- probability modelling  
- reinforcement logic  
- retreat evaluation  
- ability triggers (stun, AoE, bleed)  

============================================================
# 16.10 BOSS MECHANICS
Bosses include:
- Phase transitions  
- Summoning minions  
- Defense boosts  
- Aggression spikes  
- Special attacks  

Boss drops:
- rare materials  
- unique cosmetics  
- crafting blueprints  

============================================================
# 16.11 FACTION RAID COMBAT
Faction raids include:
- group fights  
- staggered waves  
- territory defenses  
- morale & reinforcement modifiers  

Team combat formulas use aggregated stats:
```
team_power = sum(member_stats) + formation_bonus
```

============================================================
# 16.12 COMBAT LOGIC FLOW
1. Determine turn order  
2. Apply opening effects  
3. Player/NPC action  
4. Status effects tick  
5. AI Director modifier check  
6. Repeat until victory or escape  

============================================================
# 16.13 AI DIRECTOR HOOKS
AI Director adjusts:
- NPC aggression  
- reinforcement spawn chance  
- crit modifiers  
- escape difficulty  
- ambush frequency  

============================================================
# 16.14 ANTI-EXPLOIT PROTECTIONS
Prevents:
- combat macros  
- turn-timing exploits  
- infinite stun loops  
- stat manipulation  
- damage overflow exploits  

Monitors:
- attack timing patterns  
- repeatable win anomalies  
- abnormal DPS profiles  
- suspicious survivability  

============================================================
END OF CHUNK 16



============================================================
# CHUNK 17 — ITEMS, CRAFTING, LOOT, MATERIAL TIERS & BLUEPRINTS
============================================================

## 17.1 ITEM SYSTEM OVERVIEW
Items in Trench City power:
- combat
- crafting
- smuggling
- property upgrades
- faction enhancement
- vehicle tuning
- black market trading

Item Categories:
1. Weapons  
2. Armor  
3. Consumables  
4. Tools  
5. Materials  
6. Blueprints  
7. Contraband  
8. Cosmetic Items  
9. Special Event Items  

Each item includes:
- rarity  
- tier  
- durability  
- attributes  
- crafting compatibility  
- stash detectability (for contraband)  

============================================================
# 17.2 MATERIAL TIER SYSTEM (T1 → T6)
### **Tier 1: Common**
- scrap metal  
- basic chemicals  
- wood  
- plastic components  

### **Tier 2: Uncommon**
- refined alloys  
- synthetic fibers  
- chemical bases  
- electronics  

### **Tier 3: Rare**
- ballistic composites  
- encrypted chips  
- high-grade solvents  
- precision mechanisms  

### **Tier 4: Epic**
- syndicate alloys  
- prototype circuits  
- neural stimulants  
- advanced chemical cores  

### **Tier 5: Legendary**
- experimental armor plates  
- black market circuits  
- military-grade components  

### **Tier 6: Ultra-Black-Market**
- prototype weapon cores  
- unstable chemical nodes  
- encrypted AI processors  
- contraband modules  

============================================================
# 17.3 BLUEPRINT SYSTEM
Blueprint Rarity:
- Common  
- Rare  
- Epic  
- Legendary  
- Syndicate  
- Seasonal/Exclusive  

Blueprints unlock:
- weapon mods  
- armor augmentations  
- vehicle upgrades  
- special tools  
- smuggling containers  
- mansion/room upgrades  
- improved crafting recipes  

============================================================
# 17.4 CRAFTING SYSTEM OVERVIEW
Crafting Types:
1. **Weapon Mod Crafting**  
2. **Armor Enhancement Crafting**  
3. **Chemical Crafting (consumables)**  
4. **Hacking Tool Construction**  
5. **Vehicle Mod Crafting**  
6. **Smuggling Container Construction**  
7. **Property Upgrade Crafting**  

Crafting Requirements:
- materials  
- blueprints  
- money  
- crafting skill (optional future expansion)  

============================================================
# 17.5 WEAPON MOD CRAFTING
Mod Types:
- scopes  
- silencers  
- stabilisers  
- extended mags  
- reinforced barrels  
- custom grips  
- laser targeting  

Each mod has:
- stat modifiers  
- durability  
- compatibility rules  

============================================================
# 17.6 ARMOR UPGRADES
Armor upgrade modules:
- reinforced plates  
- shock absorption layers  
- ballistic mesh  
- thermal lining  
- experimental shield nodes  

Grants:
- DR boosts  
- penetration resistance  
- reduced fatigue  

============================================================
# 17.7 CHEMICAL CRAFTING (CONSUMABLES)
Craftable items:
- medkits  
- stimulants  
- focus enhancers  
- antidotes  
- improvised explosives  
- smuggling concealment chemicals  

============================================================
# 17.8 HACKING TOOL CRAFTING
Tools include:
- lock crackers  
- signal jammers  
- bypass devices  
- encrypted sniffers  
- backdoor injectors  

Used in:
- crimes  
- missions  
- smuggling  
- raids  

============================================================
# 17.9 VEHICLE MOD CRAFTING
Craftable upgrades:
- turbo components  
- stealth plating  
- reinforced frame parts  
- upgraded brake systems  
- off-road suspension  
- nitro systems  

============================================================
# 17.10 SMUGGLING CONTAINERS
Container types:
- false-bottom crates  
- encrypted digital lockers  
- disguised cargo units  
- thermal-shielded cases  
- chemical-neutralizing capsules  

Reduce:
- police detection  
- NPC gang interception  
- heat signatures  

============================================================
# 17.11 PROPERTY UPGRADE CRAFTING
Players can craft:
- server racks  
- security doors  
- greenhouse components  
- chem lab modules  
- crypto rigs  
- tunnel supports  
- safe room reinforcements  

============================================================
# 17.12 LOOT SYSTEM OVERVIEW
Loot is generated from:
- crimes  
- missions  
- NPC drops  
- bosses  
- faction wars  
- smuggling success rewards  

Loot Tables Consider:
- borough difficulty  
- faction influence  
- AI Director modifiers  
- seasonal events  
- gang presence  

============================================================
# 17.13 LOOT TIERS
- Common  
- Uncommon  
- Rare  
- Epic  
- Legendary  
- Ultra-Black-Market (special events only)  

============================================================
# 17.14 CONTRABAND SYSTEM
Contraband includes:
- drugs  
- weapons  
- restricted tech  
- prototype parts  
- rare black market components  

Traits:
- detectability rating  
- heat generation value  
- stash security requirements  
- smuggling multipliers  

============================================================
# 17.15 ITEM DURABILITY SYSTEM
Items degrade based on:
- combat usage  
- smuggling wear  
- crafting failures  
- boss fights  

Durability Loss Effects:
- reduced damage  
- reduced protection  
- increased jam chance  

Repairs require:
- materials  
- money  
- special repair tools  
- high-tier NPC technicians  

============================================================
# 17.16 ANTI-DUPLICATION & ITEM SECURITY
Security Features:
- item hashing  
- transaction signatures  
- creation timestamps  
- owner binding  
- item provenance logs  

Detection Methods:
- duplicate hash scanning  
- abnormal inventory growth  
- suspicious transfer chains  

Actions:
- auto-flagging  
- item locking  
- rollback  
- account review  

============================================================
END OF CHUNK 17



============================================================
# CHUNK 18 — CRIME SYSTEM ULTRA-DETAILED BOOK (20 PATHS)
============================================================

## 18.1 CRIME SYSTEM OVERVIEW
The Trench City crime system features:
- 20 distinct crime paths
- 5–12 sub-crimes per path
- UK‑authentic criminal activities
- full progression tiers:
  Novice → Street → Skilled → Professional → Syndicate → Mastermind
- dynamic formulas integrating:
  stats, tools, vehicles, crew, borough tension, AI Director pressure
- multi-branch crime chains
- loot tables per path
- heat, police, gang interference systems

============================================================
# 18.2 GLOBAL CRIME FORMULAS
### Success Chance:
success = base + (DEX*0.4) + (SPD*0.2) + tool_bonus + crew_bonus
          - police_presence - gang_pressure - borough_instability
          + AI_director_modifier

### Heat Gain:
heat = base_heat + noise + witnesses - stealth_bonus - container_bonus

### Loot Quality:
loot_tier = base + borough_tier + path_level + director_risk

============================================================
# 18.3 CRIME PATH LIST (FULL)
1. Pickpocketing & Street Theft  
2. Shoplifting & Retail Crime  
3. Fraud & Identity Crime  
4. Burglary & Housebreaking  
5. Vehicle Theft & Chop Shops  
6. Assault & Street Violence  
7. Drug Dealing & Distribution  
8. Cybercrime & Hacking  
9. Robbery & Armed Hold-Ups  
10. Smuggling & Import Operations  
11. Blackmail & Extortion  
12. Loan Sharking & Underground Finance  
13. Illicit Gambling Operations  
14. Weapon Trafficking  
15. Artefact & Museum Theft  
16. Corporate Espionage  
17. Kidnapping & Ransom  
18. Syndicate Heists  
19. Underground Transport (Tube Crime)  
20. Prison Crime Path (unique progression)

============================================================
# 18.4 FULL DETAILS FOR EACH CRIME PATH
Below are full UK‑authentic crime structures.

============================================================
# PATH 1 — PICKPOCKETING & STREET THEFT
Tiers:
- Loose Change Lifting  
- Wallet Snatch  
- Phone Grab  
- Contactless Skimming  
- Tourist Theft Ring  
- Syndicate Street Team  

Sub-Crimes:
1. Distract & Dip  
2. Shoulder Surfing (PIN theft)  
3. Tube Station Lift  
4. Festival Sweep  
5. Pickpocket Crew Operation  

Loot:
- cash  
- cards  
- phones  
- materials (T1/T2)  

Risks:
- CCTV density  
- witnesses  
- plainclothes police  

============================================================
# PATH 2 — SHOPLIFTING & RETAIL CRIME
Sub-Crimes:
1. Conceal & Walk  
2. Tag Removal Attempt  
3. Clothing Swap  
4. Electronics Lift  
5. Coordinated Flash Theft  

Loot: consumer goods, electronics, resale items  
Risks: security tags, guards, facial recognition  

============================================================
# PATH 3 — FRAUD & IDENTITY CRIME
Sub-Crimes:
1. Fake Return Scam  
2. Contactless Card Relay  
3. Digital Refund Exploit  
4. Loan Fraud  
5. Large-Scale Identity Harvesting  

Loot: cash, bank access, crypto, data chips  

Requires: hacking tools, disguise tools  

============================================================
# PATH 4 — BURGLARY & HOUSEBREAKING
Sub-Crimes:
1. Window Entry  
2. Lock Snap  
3. Quiet Flat Burglary  
4. Suburban House Hit  
5. High-End Estate Break-In  

Loot: jewelry, electronics, documents, materials  
Risk: alarms, armed response units  

============================================================
# PATH 5 — VEHICLE THEFT & CHOP SHOPS
Sub-Crimes:
1. Bike Lift  
2. Key Signal Relay  
3. Van Theft  
4. High-End Car Theft  
5. Delivery Truck Intercept  

Loot: vehicles, parts, materials (T2–T4)  

============================================================
# PATH 6 — ASSAULT & STREET VIOLENCE
Sub-Crimes:
1. Mugging  
2. Alley Beatdown  
3. Debt Collection  
4. Armed Assault  
5. Gang Retaliation  

Loot: cash, weapons, notoriety  

============================================================
# PATH 7 — DRUG DEALING & DISTRIBUTION
Sub-Crimes:
1. Street Deals  
2. Estate-Level Distribution  
3. Safehouse Packaging  
4. County Lines  
5. Syndicate Import Network  

Loot: drugs, materials, cash  
Risk: infiltration, undercover units  

============================================================
# PATH 8 — CYBERCRIME & HACKING
Sub-Crimes:
1. Wi-Fi Sniffing  
2. Phishing Blast  
3. Database Breach  
4. Crypto Wallet Attack  
5. Corporate Server Heist  

Loot: data, crypto, blueprints  

============================================================
# PATH 9 — ROBBERY & ARMED HOLD-UPS
Sub-Crimes:
1. Corner Shop Robbery  
2. Cash-In-Transit Attack  
3. Jeweler Smash & Grab  
4. Armoured Van Heist  
5. High-End Armed Robbery  

Loot: high cash, rare materials  

============================================================
# PATH 10 — SMUGGLING & IMPORT OPERATIONS
Sub-Crimes:
1. Hidden Parcel Move  
2. Car Boot Transport  
3. Van Load Operation  
4. Dockside Transfer  
5. Airport Corrupt Insider Job  

Loot: contraband, rare materials  

============================================================
# PATH 11 — BLACKMAIL & EXTORTION
Sub-Crimes:
1. Threat & Collect  
2. Debt Enforcement  
3. Leverage Compromising Info  
4. Corporate Blackmail  
5. Political Blackmail Network  

Loot: cash, influence, intel  

============================================================
# PATH 12 — LOAN SHARKING & UNDERGROUND FINANCE
Sub-Crimes:
1. Small Loan  
2. Interest Escalation  
3. Debt Extraction  
4. Front Business Laundering  
5. High-Stakes Syndicate Loans  

Loot: steady income, materials  

============================================================
# PATH 13 — ILLICIT GAMBLING OPERATIONS
Sub-Crimes:
1. Backroom Dice  
2. Underground Poker  
3. Rigged Machine Setup  
4. Bookie Interference  
5. Citywide Betting Ring  

Loot: cash streams, tools  

============================================================
# PATH 14 — WEAPON TRAFFICKING
Sub-Crimes:
1. Parts Transport  
2. Illegal Gun Build  
3. Black Market Trades  
4. Container Shipment  
5. Syndicate Arms Network  

Loot: weapons, blueprints, T5 materials  

============================================================
# PATH 15 — ARTEFACT & MUSEUM THEFT
Sub-Crimes:
1. Late-Night Trespass  
2. Display Case Crack  
3. Gallery Lift  
4. Museum Heist  
5. Private Collector Robbery  

Loot: high-value items, blueprints  

============================================================
# PATH 16 — CORPORATE ESPIONAGE
Sub-Crimes:
1. Employee Impersonation  
2. Office Break-In  
3. Data Theft  
4. Prototype Extraction  
5. Executive Black Bag Operation  

Loot: intel, high-tier materials, crypto  

============================================================
# PATH 17 — KIDNAPPING & RANSOM
Sub-Crimes:
1. Basic Grab  
2. Vehicle Snatch  
3. Hostage Holding  
4. Ransom Negotiation  
5. Syndicate Abduction  

Loot: large cash, notoriety  

============================================================
# PATH 18 — SYNDICATE HEISTS
Sub-Crimes:
1. Planning Phase  
2. Tool Acquisition  
3. Safehouse Setup  
4. Execution  
5. Escape Operation  

Loot: huge cash, legendary materials  

============================================================
# PATH 19 — UNDERGROUND TRANSPORT (TUBE CRIME)
Sub-Crimes:
1. Fare Evasion Network  
2. Train Graffiti Ops  
3. Trackside Theft  
4. Driver Cab Break-In  
5. Tube System Exploit  

============================================================
# PATH 20 — PRISON CRIME PATH
Unlocked only if jailed.

Sub-Crimes:
1. Cigarette Trade  
2. Contraband Smuggling  
3. Cell Block Fight  
4. Guard Corruption  
5. Prison Break Attempt  

============================================================
END OF CHUNK 18



============================================================
# CHUNK 19 — FACTION WARFARE EXPANSION (RANKED WARS, TERRITORY, RAIDS, BLACK OPS)
============================================================

## 19.1 ADVANCED WARFARE OVERVIEW
Faction Warfare in Trench City evolves into a **multi‑layered strategic system** with:
- Ranked competitive wars
- Territory domination
- Raids & counter‑raids
- Black Ops infiltration missions
- Supply lines & logistics layers
- Morale, influence, and command structures
- Seasonal resets & ELO rankings
- Anti‑exploit enforcement

This system defines **endgame PvP** and long‑term faction identity.

============================================================
# 19.2 RANKED WAR SYSTEM (ELO-BASED)
Ranked Wars run in seasons (8–12 weeks).

### ELO Rating Components:
- Win/Loss  
- Territory control  
- Kill/Death contribution  
- Objective completion  
- Logistics success  
- Morale differential  

### War Matchmaking:
ELO bracket → opponents within ±200 ELO  
Cooldown after each war  
Match scheduling windows  

### War Tiers:
- Bronze  
- Silver  
- Gold  
- Diamond  
- Syndicate (Top 1%)  

Tier rewards include:
- cosmetics  
- faction banners  
- prestige tokens  
- war exclusive skins  

============================================================
# 19.3 WAR OBJECTIVES (MULTI-MODE)
War has dynamic objectives:
1. **Elimination Goals** – kill count, player knockouts  
2. **Sabotage Ops** – destroy faction assets  
3. **Capture Points** – timed territory holding  
4. **Escort Missions** – protect NPC courier  
5. **Boss Elimination** – enemy boss NPC  
6. **Convoy Raid** – steal opponent resources  
7. **Influence Battle** – borough influence race  

Objectives rotate during war, forcing adaptation.

============================================================
# 19.4 MORALE SYSTEM
Morale impacts:
- damage output  
- defense  
- reinforcement success  
- ability triggers  

Morale sources:
+ wins  
+ completing objectives  
+ high ranking players  
- losing streaks  
- failed raids  
- resource shortages  
- assassinations  

============================================================
# 19.5 LOGISTICS & SUPPLY LINES
Factions must maintain:
- resource supply (materials, cash, contraband)
- manpower (online participant strength)
- communication (intel)
- reinforcement routes

Supply Line Types:
- Overground (streets)
- Underground (tube)
- Black Market (covert)
- Syndicate Network (endgame)

Cutting supply lines weakens:
- morale
- reinforcement timers
- faction buffs

============================================================
# 19.6 TERRITORY SYSTEM EXPANSION
Territory now includes:
- borough sectors  
- street blocks  
- transport hubs  
- smuggling lanes  
- industrial yards  
- business districts  

### Bonuses:
- material production  
- smuggling boost  
- faction XP gain  
- crime payout bonuses  
- defense & morale modifiers  

Territory can be:
- captured  
- fortified  
- sabotaged  
- contested  

============================================================
# 19.7 TERRITORY WAR EVENTS
Triggered by:
- AI Director (instability)  
- faction aggression  
- smuggling spikes  

Events:
- Gang Uprisings  
- Police Occupations  
- NPC Syndicate Invasions  

Territory becomes dynamic & alive.

============================================================
# 19.8 RAID SYSTEM (PVE/PVP HYBRID)
Raids occur against:
- enemy faction bases  
- faction mansions  
- resource depots  
- convoy routes  

Raid Types:
1. **Turf Raids**  
2. **Resource Raids**  
3. **Vault Raids**  
4. **Influence Raids**  
5. **Rescue Raids** (recover kidnapped members)

Raids use:
- team combat  
- NPC reinforcements  
- AI Director modifiers  

============================================================
# 19.9 BLACK OPS SYSTEM (ELITE MISSIONS)
Black Ops are high‑risk, high‑reward stealth missions:
- deep infiltration  
- sabotage  
- kidnapping key targets  
- data theft  
- smuggling lane sabotage  
- blackmail intel extraction  

Black Ops Effects:
- shift territory control  
- weaken enemy morale  
- disrupt supply lines  
- unlock rare blueprints  

Black Ops require:
- stealth stats  
- specialist tools  
- trained NPC crew  
- faction tech upgrades  

============================================================
# 19.10 FACTION TECH TREE
Tree Categories:
1. **Warfare Upgrades**  
   - reinforcement speed  
   - damage boosts  
   - armor bonuses  

2. **Intel Upgrades**  
   - reveal enemy routes  
   - reduce blackout windows  
   - detect Black Ops  

3. **Logistics Upgrades**  
   - transport boost  
   - supply efficiency  
   - smuggling upgrades  

4. **Defense Upgrades**  
   - mansion security rooms  
   - auto-turret defense  
   - trap systems  
   - reinforcement bunkers  

Tech requires:
- materials  
- influence  
- crafting components  
- seasonal tech points  

============================================================
# 19.11 FACTION CHAIN SYSTEM
Three chain types:

### **Crime Chains**
Complete crimes consecutively to boost faction-wide bonuses.

### **War Chains**
Players generate war momentum:
- increases morale  
- reduces respawn timers  
- unlocks war buffs  

### **Faction Operation Chains**
Complete multi-step faction missions.

============================================================
# 19.12 FACTION DIPLOMACY (ADVANCED)
Diplomacy States:
- Alliance  
- Non-Aggression Pact  
- Cold War  
- Open War  
- Total Annihilation War  

Each state modifies:
- war objectives  
- territory interactions  
- intel sharing  
- trade restrictions  

============================================================
# 19.13 SEASONAL WAR STRUCTURE
Every season includes:
- placement matches  
- ranked war cycle  
- grand finale war  
- seasonal reset  
- reward distribution  

Top factions receive:
- legendary cosmetics  
- mansion/faction hall trophies  
- seasonal portrait frames  

============================================================
# 19.14 AI DIRECTOR WARFARE INFLUENCE
AI Director adjusts:
- war difficulty  
- reinforcement arrival times  
- NPC gang interference  
- police involvement  
- economy effects in war  
- morale modifiers  

Director can trigger:
- emergency events  
- war escalations  
- neutral third-party factions  

============================================================
# 19.15 ANTI-EXPLOIT WAR PROTECTIONS
Prevents:
- alt account manipulation  
- win-trading  
- false surrender abuse  
- reinforcement spam  
- territory flipping exploits  

Detection includes:
- behavioural clustering  
- suspicious IP/device match  
- timing anomalies  
- fake participation flagging  

============================================================
END OF CHUNK 19



============================================================
# CHUNK 20 — MISSIONS SYSTEM EXPANSION (NARRATIVE, GENERATORS, NPC RELATIONSHIPS)
============================================================

## 20.1 MISSION SYSTEM EXPANSION OVERVIEW
The expanded Mission System introduces:
- branching story arcs
- procedural mission generators
- faction-linked missions
- Black Ops missions
- NPC relationship-driven missions
- mission chains affecting world state
- AI Director adaptive difficulty
- dynamic outcomes & consequences
- anti-exploit logic

This system creates a **living narrative engine** across Trench City.

============================================================
# 20.2 MISSION TYPES (5-LAYER SYSTEM)

### 1. Story Missions (Handcrafted)
- multi-stage narratives
- branching decisions
- moral choices
- long-form dialogue
- permanent world consequences

### 2. Repeatable Missions
- predictable formats
- small narrative flavour
- reliable progression sources

### 3. Procedural Missions
- dynamically generated
- borough & tension driven
- endless replayability

### 4. Faction Missions
- territory-based
- war preparation
- infiltration
- smuggling
- high-value targets

### 5. Black Ops Missions
- elite stealth missions
- major influence shifts
- extremely difficult
- rare blueprint rewards

============================================================
# 20.3 MISSION GENERATOR FRAMEWORK
The procedural generator uses:

### Inputs:
- borough state
- gang presence
- police heat
- faction relationships
- player stats
- tools & vehicle
- AI Director tension
- narrative season

### Outputs:
- difficulty
- rewards
- enemy composition
- obstacles
- alternative routes
- special conditions

### Generator Layers:
1. **Template Layer** (e.g., infiltration, escort, theft)
2. **Modifier Layer** (weather, heat, gang hostility)
3. **Obstacles Layer** (locks, cameras, guards)
4. **Outcome Layer** (rewards, consequences, world impact)

============================================================
# 20.4 NPC RELATIONSHIP MATRIX
NPCs store persistent relationship data:

### Relationship Values:
- trust
- fear
- respect
- resentment
- suspicion
- admiration
- debt owed

### Relationship Inputs:
- mission outcomes
- threats or bribes
- generosity
- betrayal
- intimidation
- saving the NPC
- harming NPC allies

NPCs with high trust:
- unlock better missions
- reduce risk
- provide intel

NPCs with high fear:
- reveal hidden information
- refuse to betray the player

NPCs with high suspicion:
- set traps
- provide misleading intel

============================================================
# 20.5 BRANCHING NARRATIVE FRAMEWORK
Story missions use:

### Branch Types:
- Moral Branch (good/neutral/criminal)
- Faction Branch (loyalty to one faction)
- Reputation Branch (karma/infamy-driven)
- NPC Relationship Branch
- Borough State Branch (unstable/secure)
- AI Director Branch (tension-based story forks)

### Choice Consequences:
- unlock new missions
- close off alternate routes
- change borough stats
- modify faction relationships
- alter future mission difficulty
- trigger new story arcs

============================================================
# 20.6 MISSION FLOW STRUCTURE
Mission structure:

1. Briefing  
2. Preparation (choose tools, vehicle, crew)  
3. Entry (stealth/combat/social approach)  
4. Core Objective  
5. Complication (AI Director triggered)  
6. Escape / Conclusion  
7. Rewards  
8. Relationship Adjustments  
9. World State Updates  

============================================================
# 20.7 MISSION OBJECTIVE TYPES
- Theft (documents, money, tech)
- Extraction (save target, steal asset)
- Infiltration (quiet or loud)
- Sabotage (equipment, data, infrastructure)
- Escort (NPC ally)
- Elimination (NPC target)
- Protection (hold location)
- Data Heist (cyber/hacking)
- Smuggling (secure transport)
- Blackmail (intel gathering)
- Covert Ops (Black Ops)

============================================================
# 20.8 MISSION OBSTACLE SYSTEM
Obstacles include:
- locked doors (tool tier required)
- vaults (blueprints required)
- guards (stats + AI)
- cameras (disable/hack/avoid)
- civilians (witness risk)
- time-sensitive objectives
- alarms (heat spike)
- police intervention

============================================================
# 20.9 AI DIRECTOR MISSION INFLUENCE
The AI Director adjusts:
- number of enemies
- their stats
- complication frequency
- stealth difficulty
- escape route danger
- rewards
- risk modifiers

Tension states drastically alter mission flow:
- **High Tension:** more enemies, higher stakes
- **Low Tension:** easier missions, fewer obstacles

============================================================
# 20.10 FACTION MISSION EXPANSION
Faction missions include:
- turf operations
- contract killings
- sabotage enemy logistics
- smuggling operations
- data theft
- recruitment drives
- faction diplomacy tasks

Rewards:
- faction influence
- treasury income
- materials
- bonuses for war season

============================================================
# 20.11 BLACK OPS MISSION SYSTEM
Black Ops missions require:
- stealth tools
- elite crew
- high reputation
- faction clearance

Example Ops:
- infiltrate enemy base
- kidnap high-value target
- destroy encrypted servers
- blackmail political figure
- sabotage supply depot

Failing Black Ops may:
- permanently shift faction diplomacy
- alter borough influence
- trigger enemy retaliation

============================================================
# 20.12 MISSION LOOT & REWARD TABLES
Rewards scale by:
- mission type
- difficulty
- borough instability
- faction bonuses
- AI Director modifiers

Possible Rewards:
- cash
- materials (T1–T6)
- tools
- weapons
- blueprints
- contraband
- relationship boosts
- faction influence

============================================================
# 20.13 MISSION ANTI-EXPLOIT SYSTEM
Prevents:
- mission macroing
- repeated identical pattern exploits
- reward funneling between alts
- AFK mission loops
- low-risk mission farming

Detection:
- timing comparison
- path similarity scoring
- input rhythm analysis
- abnormal success streak detection

============================================================
END OF CHUNK 20



============================================================
# CHUNK 21 — CITY SYSTEM & WORLD MAP (BOROUGHS, DISTRICTS, LANDMARKS)
============================================================

## 21.1 CITY SYSTEM OVERVIEW
The Trench City world map is a **London‑inspired macro-city** divided into:
- Boroughs (major gameplay zones)
- Districts (micro-zones within boroughs)
- Landmarks (unique gameplay nodes)
- Smuggling Lanes
- Transport Hubs
- Dynamic World States (heat, gang pressure, economy stability)

The city is **alive**, shifting constantly based on:
- crime volume
- faction activity
- NPC gang wars
- police operations
- AI Director tension
- player actions

============================================================
# 21.2 BOROUGH LIST (LONDON-INSPIRED)
Each borough has:
- crime difficulty
- economy rating
- gang control
- faction territory potential
- black market access
- unique bonuses

### 1. Camden Borough
- street markets
- music venues
- high pickpocket success
- black market vendors

### 2. Hackney Borough
- estates, tight alleys
- high gang presence
- drug distribution hotspot

### 3. Tower Borough (Tower Hamlets Inspired)
- docks, warehouses
- smuggling throughput bonus

### 4. Southbank Borough
- tourism, landmarks
- pickpocket & scam bonuses
- heavy police patrols

### 5. Westminster Borough
- government buildings
- high stakes missions
- elite police response

### 6. Brixton Borough
- cultural hub
- drug trade & extortion bonuses
- volatile gang turf

### 7. Peckham Borough
- underground gambling
- chop-shops
- illicit racing meetups

### 8. Stratford Borough
- corporate zones
- cybercrime, espionage missions

### 9. Heathrow Logistics Borough
- airport smuggling
- international crime routes

### 10. Blackwall Industrial Borough
- manufacturing
- materials farming
- industrial heists

============================================================
# 21.3 DISTRICT SYSTEM (MICRO-MAPS)
Each borough contains 4–8 districts:
- Estates
- High Streets
- Markets
- Docks
- Yards
- Underground Stations
- Business Parks
- Industrial Belts

Districts define:
- crime difficulty
- loot tables
- patrol density
- gang presence
- smuggling nodes
- NPC behaviour density

============================================================
# 21.4 LANDMARKS (UNIQUE GAMEPLAY NODES)
Examples:
- “The Spire” (high-risk heist hub)
- Central Market (pickpocket focus)
- Dockside Terminal 14 (smuggling extraction)
- Kingsford Data Centre (cybercrime boss missions)
- Old Metro Tunnels (faction turf war zone)
- Regency Museum (artefact heists)
- Blackwall Refinery (materials hub)
- Underground Fight Pits (combat challenges)

Landmarks have:
- special missions
- unique NPC bosses
- seasonal events
- high-tier loot tables

============================================================
# 21.5 BOROUGH STATE SYSTEM
Boroughs track five live states:

### 1. Heat Level
Affected by:
- recent crimes
- police presence
- faction wars

High heat:
- more patrols
- harder escapes

### 2. Gang Influence
Controls:
- crime modifiers
- ambush frequency
- black market access

### 3. Faction Control
Beneficial effects include:
- crime bonuses
- cheaper items
- smuggling buffs

### 4. Economic Stability
Positive economy:
- higher payouts
- easier mission access

Recession:
- high crime payouts but more risk

### 5. AI Director Tension
AI Director can:
- destabilise borough
- inject crises
- create rare boss encounters
- boost/nerf crime payouts

============================================================
# 21.6 CITY EVENT SYSTEM
City-wide events include:
- Borough Lockdown
- Gang Turf War
- Police Crackdown
- Economic Crash
- Blackout Event
- Riot Event
- Syndicate Invasion

Events modify:
- crime difficulty
- loot tables
- patrol density
- gang interference
- market prices

============================================================
# 21.7 WORLD TRAVEL SYSTEM
Travel Types:
- On Foot (slow, stealthy)
- Personal Vehicles (fast)
- Tube Network (balanced, ambush chance)
- Bus Network (cheap, random events)
- Smuggling Tunnels (illegal, risky)
- Airport Routes (international missions)

Vehicles modify:
- travel time
- ambush chance
- heat generation
- smuggling detection

============================================================
# 21.8 CITY UPGRADES & OWNERSHIP
Players and factions can control:
- small businesses
- warehouses
- black market hubs
- data farms
- safehouses
- smuggling docks

Ownership bonuses:
- passive income
- access to new missions
- crafting material boosts
- faction influence buffs

============================================================
# 21.9 BOROUGH LOOT TABLES
Each borough has unique loot:

Camden:
- pickpocket loot
- counterfeit items

Hackney:
- drug materials
- gang-made weapons

Tower:
- smuggling containers
- rare industrial tools

Brixton:
- extortion loot
- gang documents

Stratford:
- cyber materials
- prototype data

============================================================
# 21.10 CRIME MODIFIERS BY BOROUGH
Example:
- Camden: +pickpocket success, +scams, -armed robbery success
- Hackney: +drug dealing, +assault, -stealth
- Tower: +smuggling, +vehicle theft
- Westminster: +espionage payout, -crime success (police)

============================================================
# 21.11 CITY AI INTEGRATION
AI Director monitors:
- borough health
- crime saturation
- player population density
- faction warfare
- economic shifts

AI responses:
- deploy special NPC bosses
- adjust loot rarity
- manipulate crime success
- create borough crises
- push seasonal narrative events

============================================================
# 21.12 ANTI-EXPLOIT CITY LOGIC
Prevents:
- borough farming loops
- route exploit patterns
- smuggling oversaturation
- event exploitation
- infinite respawn abuse

Uses:
- travel pattern fingerprinting
- area-density statistical analysis
- heat manipulation detection

============================================================
END OF CHUNK 21



============================================================
# CHUNK 22 — VEHICLES & RACING SYSTEM (TUNING, PURSUITS, SMUGGLING)
============================================================

## 22.1 VEHICLE SYSTEM OVERVIEW
Vehicles in Trench City affect:
- travel time
- crime success
- smuggling detection
- racing performance
- police & gang pursuit outcomes
- mission routes
- faction logistics

Vehicles become a core pillar of:
- progression
- economy
- PvP / PvE interaction.

============================================================
# 22.2 VEHICLE CLASSES
### Street Class
- cheap, common
- low durability
- basic tuning capability

### Sport Class
- higher speed/acceleration
- moderate storage
- ideal for racing & quick getaways

### Luxury Class
- high comfort
- low stealth
- medium storage
- high resale value

### Off‑Road Class
- high durability
- useful for smuggling through rough terrain

### Utility / Vans
- high storage
- ideal for smuggling
- low speed, high detection risk

### Syndicate Prototype Vehicles
- extremely rare
- elite stealth modules
- customizable cores
- AI‑assisted navigation

============================================================
# 22.3 VEHICLE STATS
Each vehicle has:

- **Top Speed**
- **Acceleration**
- **Handling**
- **Durability**
- **Stealth Rating**
- **Storage Capacity**
- **Heat Reduction**
- **Mod Slots** (engine/body/utility)

Stats affect:
- crime success rates
- escape probability
- smuggling detection
- racing performance

============================================================
# 22.4 VEHICLE MODDING & TUNING
Mod categories:

### Engine Mods
- turbo kits
- ECU hacking units
- performance injectors

### Handling Mods
- suspension upgrades
- racing tires
- drift kits

### Stealth Mods
- thermal plates
- radar dampeners
- false compartment generators
- noise suppression exhaust

### Armor Mods
- reinforced panels
- bullet-resistant plating
- crash structure upgrades

### Utility Mods
- extended cargo racks
- hidden cargo cells
- encrypted GPS

============================================================
# 22.5 GARAGES & WORKSHOPS
Players can:
- store vehicles
- assign mods
- repair vehicles
- craft vehicle mods (with blueprints)

Faction workshops grant:
- lower repair cost
- faster mod installation
- special syndicate-only upgrades

============================================================
# 22.6 VEHICLE DAMAGE & REPAIR SYSTEM
Damage Sources:
- racing collisions
- police interceptions
- gang ambushes
- smuggling failures
- missions gone wrong

Damage Effects:
- reduced speed
- weaker handling
- higher detection chance
- increased fuel/heat cost

Repair Options:
- standard garages
- faction workshops
- DIY repair kits (limited)

============================================================
# 22.7 RACING SYSTEM (MULTIPLE FORMATS)

### 1. Sprint Races
Short-distance, high-speed.

### 2. Circuit Races
Multi-lap races across borough districts.

### 3. Drag Races
Straight-line speed tests.

### 4. Outlaw Street Races
Illegal, night-time city events.
- police chase risk
- ambush chance
- rare betting outcomes

### 5. Faction Racing League
PvP team races:
- relay formats
- elimination rounds
- faction-wide rewards

### 6. Syndicate Invitational Cups
Endgame:
- prototype vehicles required
- rare blueprints rewarded
- massive prestige boosts

============================================================
# 22.8 PURSUIT SYSTEM
Police Pursuit Levels:
1. Standard Patrol Response
2. Tactical Vehicle Unit
3. Helicopter Tracking
4. Armed Response Interceptors
5. Full City Lockdown

Gang Pursuits:
- ambush vehicles
- deploy spike traps
- block tunnel entrances

Escape Probability Factors:
- vehicle stats
- district layout
- heat level
- AI Director tension
- mods installed
- weather effects

============================================================
# 22.9 SMUGGLING VEHICLE INTEGRATION
Vehicle properties affect smuggling:

### Storage Capacity
Determines:
- payload size
- transport income

### Stealth Rating
Reduces:
- customs detection
- police checks
- gang interceptions

### Hidden Compartments
Allow:
- high-value contraband transport
- reduced heat accumulation

============================================================
# 22.10 VEHICLE LOOT TABLES
Drops include:
- parts (T1–T6)
- rare mods
- vehicle blueprints
- smuggling modules
- cosmetic skins
- prototype engine components

============================================================
# 22.11 ANTI-EXPLOIT VEHICLE & RACING SYSTEM
Prevents:
- macro racing loops
- automated key sequences
- route farming
- pursuit manipulation
- speedhack attempts

Detection:
- input rhythm checks
- path variance analysis
- timing anomaly scoring
- velocity consistency tracking

============================================================
END OF CHUNK 22



============================================================
# CHUNK 23 — PROPERTIES & HOUSING SYSTEM (UPGRADES, ROOMS, SECURITY, STAFF)
============================================================

## 23.1 PROPERTY SYSTEM OVERVIEW
Properties in Trench City are a **core progression pillar**, affecting:
- player stats
- crafting capability
- passive income
- smuggling operations
- NPC staff management
- personal storage
- protection from raids
- high-end economic gameplay

Players upgrade from:
**Run-Down Flat → Apartment → Townhouse → Penthouse → Mansion → Syndicate Fortress**

Each property has:
- rooms
- upgrade slots
- security stats
- staff capacity
- crafting potential
- smuggling potential
- quality-of-life modifiers

============================================================
# 23.2 PROPERTY TIERS

### TIER 1 — Flats & Bedsits
Cheap, minimal upgrades.
- 2 room slots  
- low security  
- minor stat boosts  

### TIER 2 — Apartments
Urban living spaces.
- 4 room slots  
- moderate security  
- increased storage  

### TIER 3 — Townhouses
Suburban crime hubs.
- 6 room slots  
- garage support  
- additional crafting options  

### TIER 4 — Luxury Penthouses
High-end elite properties.
- 8 room slots  
- advanced crafting rooms  
- private security systems  

### TIER 5 — Mansions
Large-scale estates.
- 12 room slots  
- advanced defense systems  
- large staff capacity  

### TIER 6 — Syndicate Fortresses (ENDGAME)
Ultra-high security strongholds.
- 16+ room slots  
- turret systems  
- panic rooms  
- faction integration  
- elite NPC guard staff  

============================================================
# 23.3 ROOMS SYSTEM
Each property contains **room slots**, which support special rooms:

### Functional Rooms
- Gym Room (passive stat gain)
- Private Training Room (expensive, faster stat gain)
- Medical Room (healing boosts)
- Server Room (hacking bonus; mission generation)
- Workshop (weapon/armor mod crafting)
- Chemical Lab (drug and consumable crafting)
- Botany Greenhouse (grow materials)
- Smuggling Prep Room (contraband processing)
- Garage Expansion (more vehicles)

### Luxury Rooms
- Cinema Room
- Games Room
- Trophy Hall
- Personal Bar

### Defense Rooms
- Panic Room (temporary invulnerability)
- Surveillance Room (raid detection bonus)
- Turret Control Room
- Secure Vault (item & cash storage)

============================================================
# 23.4 PROPERTY UPGRADES
Properties support upgrades in several categories:

### Security Upgrades
- Reinforced doors  
- Bullet-resistant windows  
- Laser breach detectors  
- Motion sensors  
- Auto-lockdown mode  
- Armed turret emplacements  

### Storage Upgrades
- Large safe  
- Reinforced vault  
- temperature-controlled contraband lockers  

### Smuggling Upgrades
- false-wall compartments  
- underground tunnel exits  
- cargo lifts  

### Comfort Upgrades
- luxury furniture  
- high-end entertainment  
- staff quarters  

============================================================
# 23.5 PROPERTY SECURITY SYSTEM
Security stats:
- Intrusion Detection
- Intrusion Resistance
- Anti-Surveillance
- NPC Guard Power
- Emergency Response Speed

These affect:
- raid success chance  
- burglary mission difficulty  
- NPC infiltration probability  
- property invasion events  

Security can be breached by:
- player raids  
- NPC gang attacks  
- syndicate retaliation  

============================================================
# 23.6 NPC STAFF SYSTEM
NPC staff run and optimise your property.

### Staff Types
**1. Bodyguards**
- repel attacks
- boost defense

**2. Technicians**
- run server rooms
- reduce crafting times
- improve hacking missions

**3. Medics**
- speed up healing
- assist in medical crafting

**4. Drivers**
- improve smuggling outcomes
- reduce travel time penalties

**5. Housekeepers**
- increase comfort rating
- reduce maintenance costs

**6. Groundskeepers**
- boost greenhouse yield
- maintain mansion-level properties

Staff have:
- loyalty  
- skill levels  
- salary demands  
- relationship values  

============================================================
# 23.7 STAFF MANAGEMENT
You can:
- hire  
- fire  
- promote  
- train  
- discipline  
- build loyalty  
- send staff on missions  

High loyalty boosts:
- performance  
- defense  
- event-driven bonuses  

Low loyalty risks:
- betrayal  
- leaks  
- sabotage  

============================================================
# 23.8 PROPERTY ECONOMY
Players can:
- buy properties
- sell properties
- rent to others
- upgrade internal rooms
- maintain utilities
- expand land (mansions/fortresses)

Costs scale with:
- borough wealth
- crime activity
- player reputation

Passive income streams:
- renting rooms  
- leasing workshop access  
- greenhouses  
- server room data mining  
- smuggling prep fees  

============================================================
# 23.9 FACTION PROPERTIES
Factions can own:
- mansions  
- fortresses  
- warehouse hubs  
- logistics centres  
- smuggling docks  

Faction properties provide:
- war buffs  
- raid staging areas  
- crafting bonuses  
- fast travel points  
- storage  

Faction fortresses integrate:
- turret systems  
- secure vaults  
- barracks  
- meeting halls  
- tech upgrade rooms  

============================================================
# 23.10 PROPERTY EVENTS
Events include:
- burglary attempts  
- gang retaliation  
- police raids  
- NPC staff disputes  
- fire hazards  
- blackout events  
- illegal party events  

Players must react to:
- defend  
- repair  
- pay fines  
- negotiate  

============================================================
# 23.11 PROPERTY RAID SYSTEM
Property raids involve:
- breach phase  
- defense phase  
- loot grab phase  
- escape phase

Raid factors:
- property security rating  
- staff loyalty  
- defense rooms  
- AI Director tension  
- attacker stats  

Defenders gain:
- passive defense  
- turret damage  
- guard interception  

Attackers gain:
- loot  
- influence  
- materials  

============================================================
# 23.12 ANTI-EXPLOIT PROPERTY LOGIC
Prevents:
- property flipping abuse  
- multi-account laundering  
- item duplication via storage  
- raid exploit loops  
- infinite passive income cycles  

Detection includes:
- abnormal transaction patterns  
- linked account transfers  
- unusual property jumps  
- timing anomalies  

============================================================
END OF CHUNK 23



============================================================
# CHUNK 24 — COMPANIES & JOBS SYSTEM (ECONOMY, RANKS, OWNERSHIP, NPC STAFF)
============================================================

## 24.1 SYSTEM OVERVIEW
The Companies & Jobs system expands Trench City’s economy into:
- player careers  
- player-owned companies  
- NPC employee simulation  
- production chains  
- market influence  
- corporate espionage  
- faction-economic warfare  

It becomes a **major economic pillar**, influencing:
- cash flow  
- crafting materials  
- property upgrades  
- faction logistics  
- AI Director economic balance  

============================================================
# 24.2 PLAYER JOBS SYSTEM
Players can join structured careers with:
- ranks  
- daily work tasks  
- work energy  
- salaries  
- perks  
- passive bonuses  

### Job Categories:
1. Hospital Staff  
2. Police Auxiliary  
3. Logistics Driver  
4. IT Technician  
5. Construction Worker  
6. Security Officer  
7. Bar/Club Staff  
8. Government Assistant  

Each career path has 8–12 ranks.

### Example Progression:
**Police Auxiliary → Community Officer → Patrol Officer → Tactical Support → Investigations Unit → Specialist Response**

### Job Tasks:
- shift assignments  
- mini-mission tasks  
- paperwork  
- deliveries  
- inspections  
- patrols  

### Job Bonuses:
- crime modifiers  
- training boosts  
- healing boosts  
- reduced hospital times  
- stealth bonuses  

============================================================
# 24.3 PLAYER-OWNED COMPANIES
Players can found & operate companies.

### Requirements:
- startup fee  
- business license  
- property with commercial zoning  

### Company Categories:
1. **Logistics Company**  
   - transport missions  
   - smuggling synergy  
   - material supply  

2. **Tech Firm**  
   - server rooms  
   - hacking tools production  
   - data sales  

3. **Gambling Den**  
   - underground tables  
   - rigging risk vs reward  
   - NPC gambling clients  

4. **Security Agency**  
   - guards for hire  
   - reinforcement services  
   - property raid defense  

5. **Manufacturing Plant**  
   - weapons parts  
   - armor components  
   - chemical processors  

6. **Nightlife / Entertainment**  
   - bars  
   - clubs  
   - event bonuses  
   - passive income  

7. **Black Market Workshop**  
   - smuggling containers  
   - counterfeit goods  
   - contraband distribution  

============================================================
# 24.4 COMPANY STATS
Each company has:
- Reputation  
- Productivity  
- Employee Morale  
- Financial Stability  
- NPC Client Demand  
- Security Level  

============================================================
# 24.5 EMPLOYEE SYSTEM (PLAYERS + NPCS)
Companies can employ:
- players  
- NPC workers  

### Player Employees:
Have:
- skill rating  
- activity rating  
- wage demands  
- work fatigue  
- loyalty  

Players complete:
- shifts  
- missions  
- company-specific tasks  

### NPC Employees:
Types:
- drivers  
- technicians  
- guards  
- accountants  
- marketers  
- floor workers  

NPCs have:
- loyalty  
- skill  
- salary  
- risk of theft/fraud  

============================================================
# 24.6 COMPANY MANAGEMENT
Owners can:
- set salaries  
- hire/fire  
- set production queues  
- upgrade facilities  
- buy materials  
- expand buildings  
- assign NPCs to rooms  

Company Upgrades:
- production line expansions  
- security systems  
- storage warehouses  
- delivery fleets  
- research & development wings  

============================================================
# 24.7 PRODUCTION & SUPPLY CHAIN SYSTEM
Raw Materials → Components → Final Products → Market Sale

### Example Chains:
**Logistics Company:**
- acquire contracts  
- perform deliveries  
- gain materials  

**Tech Firm:**
- acquire circuits  
- produce hacking devices  
- sell to players/factions  

**Manufacturing Plant:**
- smelt metal  
- create parts  
- assemble weapons/armor  
- bulk supply the black market  

============================================================
# 24.8 COMPANY MARKETPLACE
Companies can:
- sell goods  
- buy materials  
- bid on contracts  
- hire temporary workers  
- acquire NPC clients  

Market fluctuates based on:
- borough economy  
- faction wars  
- player supply saturation  
- AI Director adjustments  

============================================================
# 24.9 CORPORATE ESPIONAGE (PVP & PVE)
Players and NPC agents can:
- sabotage production  
- steal data  
- kidnap employees  
- destroy inventory  
- plant malware  
- bribe staff  
- leak financials  

Espionage difficulty depends on:
- company security  
- employee loyalty  
- installed countermeasures  

Rewards include:
- stolen blueprints  
- cash  
- rare materials  
- reputation damage to rival companies  

============================================================
# 24.10 COMPANY EVENTS
Dynamic events:
- employee strikes  
- theft/fraud discovery  
- police investigations  
- market crashes  
- tech outages  
- supply shortages  
- VIP client visits  
- sabotage attempts  

Owners must:
- negotiate  
- repair  
- upgrade security  
- discipline employees  
- manage PR  

============================================================
# 24.11 COMPANY FINANCIAL SYSTEM
Includes:
- revenue  
- expenses  
- wages  
- taxes  
- investments  
- reserves  
- credit ratings  

Companies can:
- take loans  
- invest profits  
- collapse from debt  
- be bought out by other players  

============================================================
# 24.12 ANTI-EXPLOIT COMPANY LOGIC
Prevents:
- salary abuse between alts  
- fake job activity  
- infinite production loops  
- laundering money  
- collusion between companies  
- contract manipulation  

Detection:
- wage transfer pattern scanning  
- production anomaly detection  
- employee behaviour scoring  
- market manipulation analysis  

============================================================
END OF CHUNK 24



============================================================
# CHUNK 25 — BLACK MARKET, CONTRABAND & SMUGGLING SYSTEM
============================================================

## 25.1 BLACK MARKET OVERVIEW
The Black Market is the **global illegal economy** of Trench City.

It connects:
- crimes
- smuggling
- factions
- companies
- NPC gangs
- international syndicates
- AI Director economic control

It contains:
- illegal goods  
- contraband  
- rare prototypes  
- stolen artifacts  
- forged documents  
- hacking devices  

============================================================
# 25.2 BLACK MARKET TIERS (3–6 TIERS)
### TIER 1 — Street Black Market
- petty dealers  
- counterfeit goods  
- cheap stolen electronics  
- entry-level contraband  

### TIER 2 — Local Criminal Market
- gang-run stalls  
- drug packs  
- weapon components  
- cheap smuggling containers  

### TIER 3 — Established Black Market
- syndicate buyers  
- encrypted devices  
- forged documents  
- mid-level weapons  

### TIER 4 — Syndicate Exchange
- prototype technology  
- advanced weapon mods  
- ultra-rare chemicals  
- contraband blueprints  

### TIER 5 — International Underworld
- import/export operations  
- high-tier smuggling routes  
- military-grade equipment  

### TIER 6 — “The Deep Exchange” (Endgame)
- AI cores  
- unstable prototypes  
- international cartel artifacts  
- ultra-black-market materials (T6)  

============================================================
# 25.3 CONTRABAND CLASSES
### Class A — Physical Goods
- weapons  
- ammo  
- armor components  
- stolen goods  

### Class B — Chemical Goods
- drugs  
- precursors  
- lab equipment  

### Class C — Digital Contraband
- hacking devices  
- exploit chips  
- encrypted data containers  

### Class D — High-Risk Contraband
- prototype cores  
- biohazards  
- military tech  

### Class E — Cultural & Historical Goods
- artifacts  
- museum items  
- stolen art  

Every contraband item has:
- heat value  
- legality tier  
- detection rating  
- smuggling difficulty  
- faction interest  

============================================================
# 25.4 SMUGGLING SYSTEM (FULL)
Smuggling is a **dynamic risk-based logistic system**.

Smuggling Routes:
- street-level courier routes  
- tube network runs  
- bus lines  
- car/van transport  
- docks & warehouses  
- airport routes  
- underground tunnels  
- covert faction channels  

Each route has:
- police risk  
- gang risk  
- scanner density  
- random event chance  
- AI Director intervention chance  

============================================================
# 25.5 SMUGGLING RUN PHASES
1. **Load Phase**
   - choose contraband  
   - choose vehicle & mods  
   - choose crew  

2. **Travel Phase**
   - random events  
   - patrol checks  
   - gang encounters  
   - pursuit triggers  

3. **Checkpoint Phase**
   - scanners  
   - dogs  
   - undercover agents  

4. **Delivery Phase**
   - payout  
   - XP  
   - contraband disposal  

============================================================
# 25.6 SMUGGLING RISK SYSTEM
Risk Factors:
- contraband class  
- quantity  
- vehicle stealth  
- hidden compartments  
- borough heat  
- faction influence  
- AI Director tension  

Probability of failure increases with:
- repeated route use  
- overloading  
- low-quality containers  

============================================================
# 25.7 BLACK MARKET NPCS
NPC roles:
- buyers  
- smugglers  
- forgers  
- syndicate brokers  
- intelligence contacts  

NPCs have:
- loyalty  
- suspicion  
- heat sensitivity  
- supply & demand patterns  

============================================================
# 25.8 LAUNDERING SYSTEM
Dirty contraband money must be laundered through:
- businesses  
- casinos  
- illegal bookmakers  
- front companies  
- NPC contacts  

Laundering reduces:
- heat  
- detection chance  
- future smuggling risk  

============================================================
# 25.9 FENCING STOLEN GOODS
Fencing allows selling:
- stolen electronics  
- jewelry  
- artifacts  
- vehicles  
- hacked data  

Fencing difficulty varies by:
- borough reputation  
- gang presence  
- patrol density  

============================================================
# 25.10 SYNDICATE INFLUENCE SYSTEM
Syndicates control:
- high-tier smuggling routes  
- prototype distribution  
- rare blueprint flow  
- major black market auctions  

Syndicate reputation unlocks:
- rare contraband  
- exclusive black ops  
- elite smuggling missions  

============================================================
# 25.11 BLACK MARKET EVENTS
Events include:
- police crackdown  
- gang war over market control  
- rare item auctions  
- undercover investigation  
- mass confiscation raids  
- syndicate takeover  

Events temporarily alter:
- prices  
- availability  
- risks  
- route stability  

============================================================
# 25.12 ANTI-EXPLOIT BLACK MARKET LOGIC
Prevents:
- smuggling route farming  
- infinite money loops  
- dupe attempts  
- laundering abuse  
- alt-based contraband loops  
- bypassing detection  

Detection:
- route usage frequency  
- anomaly pattern recognition  
- financial tracing  
- NPC behaviour inconsistency flags  

============================================================
END OF CHUNK 25



============================================================
# CHUNK 26 — CASINO, GAMBLING & RISK/REWARD SYSTEM
============================================================

## 26.1 CASINO SYSTEM OVERVIEW
The Casino represents:
- high-stakes gameplay
- laundering opportunities
- faction competitions
- jackpot systems
- RNG-protected fairness
- underground gambling circuits

Includes both **legal casinos** + **illegal dens**.

============================================================
# 26.2 OFFICIAL CASINO GAMES

### Blackjack
- multi-deck
- card counting detection
- dealer personality profiles

### Roulette
- European wheel
- heat-based bias detection
- high-roller tables

### Slots
- themed slot machines
- progressive jackpots
- volatility settings (low/med/high)

### High-Low
- simple risk ladder game
- multiplier curve based on streaks

### Crash Game
- increasing multiplier curve
- bust point influenced by volatility index

### Sports Betting (AI-Simulated)
- football, boxing, MMA
- simulated results via AI engine
- dynamic odds based on betting volume

============================================================
# 26.3 UNDERGROUND GAMBLING GAMES

### Backroom Dice
- riggable by criminals
- suspicion meter

### Illegal Poker Rooms
- NPC sharks
- cheating detection
- bluff/stress AI system

### Rigged Slot Machines
- player-owned criminal enterprises
- risk of police raids

### High-Stakes Syndicate Games
- invitation-only
- prototype items as stakes

============================================================
# 26.4 PVP GAMBLING MODES

### Player Duels Betting
Bet on:
- PvP fights
- stats matter
- anti-throwing detection

### Vehicle Race Betting
Bet on:
- sprint
- drag
- circuit
- outlaw races

### Faction War Betting
Illegal betting on:
- war outcomes
- kill counts
- territory control

Includes anti-exploit:
- match-fixing detection
- alt coordination detection

============================================================
# 26.5 HOUSE EDGE & FAIRNESS SYSTEM
Casino uses:
- server-side RNG
- cryptographic seeding
- anti-manipulation protection
- provably fair verification tokens

House Edge Adjustments:
- dynamic based on player win history
- AI Director intervention during events
- high-roller tables with reduced edge

============================================================
# 26.6 ADDICTION & COOL DOWN SYSTEM
Each player tracks:
- gambling risk factor
- self-control stat
- loss streak multiplier
- tilt probability

Casino imposes:
- soft limits
- cooldown sessions
- mandatory breaks on extreme losses

============================================================
# 26.7 MONEY LAUNDERING HOOKS
Players can convert dirty cash → chips → clean winnings.

Laundering stages:
1. Chip Purchase Surveillance
2. Betting Activity Scanning
3. Withdrawal Audit

NPC security monitors:
- irregular chip purchases
- suspicious win/loss patterns
- player-company laundering links

============================================================
# 26.8 CASINO EVENTS & JACKPOT SYSTEMS

### Seasonal Jackpot Pool
- grows with bets
- faction tournaments
- rare blueprint rewards

### High-Roller Invitational
- elite NPCs
- massive prizes
- prototype item gambles

### Lucky Night Events
- boosted slot odds
- roulette multipliers

============================================================
# 26.9 ANTI-EXPLOIT CASINO LOGIC
Prevents:
- win-trading
- bot-based betting
- laundering loops
- RNG prediction attempts
- collusion in PvP betting
- jackpot manipulation

Detection:
- input timing
- betting pattern graphs
- device fingerprinting
- cross-account behaviour flags

============================================================
END OF CHUNK 26



============================================================
# CHUNK 27 — STOCK MARKET, POINTS MARKET & GLOBAL ECONOMY SYSTEM
============================================================

## 27.1 GLOBAL ECONOMY OVERVIEW
The economy of Trench City operates on **three integrated layers**:
1. **Player-Driven Stock Market**
2. **Commodity & Resource Market**
3. **Points Market (Premium Currency Exchange)**

All three are influenced by:
- crime activity  
- faction wars  
- company successes/failures  
- smuggling saturation  
- black market demand  
- AI Director economic cycles  

This forms a **dynamic, reactive economic ecosystem**.

============================================================
# 27.2 PLAYER STOCK MARKET
Players can buy/sell shares in:
- player-owned companies  
- NPC megacorps  
- public-sector institutions  

### Stock Variables:
- company revenue  
- employee performance  
- production success  
- faction influence  
- criminal infiltration  
- market events  

### Stock Actions:
- Buy  
- Sell  
- Short Sell (endgame)  
- Margin Trading (high-risk)  

### Dividends:
Companies may pay:
- weekly dividends  
- performance bonuses  
- shareholder rewards  

============================================================
# 27.3 COMPANY IPO SYSTEM
Player-owned companies can:
- go public  
- issue shares  
- attract investment  
- be subject to takeovers  

IPO requirements:
- minimum revenue  
- positive credit rating  
- board of directors  

============================================================
# 27.4 TAKEOVERS & HOSTILE ACQUISITIONS
Players or factions can:
- buy majority shares  
- vote leadership changes  
- install new CEO  
- redirect production  
- sabotage from within  

Defense tools:
- poison pill strategy  
- employee voting  
- share dilution  
- faction protection  

============================================================
# 27.5 ECONOMIC EVENTS
Stock market reacts to:
- crime waves  
- raids on major companies  
- black market crackdowns  
- smuggling booms  
- faction wars  
- AI Director-triggered recessions  
- tech breakthroughs  
- casino jackpots  

============================================================
# 27.6 COMMODITY MARKET (LIVE, SHIFTING PRICES)
Commodity categories:
- metals  
- chemical precursors  
- electronic components  
- high-end materials  
- contraband  
- food & base goods  
- vehicle parts  

Players, companies, and factions influence prices through:
- production  
- smuggling  
- crafting  
- laundering  
- stockpiling  

============================================================
# 27.7 GLOBAL PRICE INDEX (GPI)
Dynamic price index tracks:
- oversupply  
- scarcity  
- seasonal demand  
- war-driven inflation  
- smuggling success rates  
- AI Director interventions  

============================================================
# 27.8 POINTS MARKET (PLAYER PREMIUM CURRENCY EXCHANGE)
Like Torn.com but improved with:
- fractional buying  
- bulk order books  
- automated trading bots (regulated)  
- player loaning of points  
- escrow & market protection  

Players trade:
- money ↔ premium points  

Market variables:
- supply/demand  
- inflation  
- seasonal events  
- donator pack purchase rates  

============================================================
# 27.9 FUTURES, OPTIONS & BONDS (ENDGAME ECONOMY)
### Futures Contracts
Players gamble on:
- material prices  
- contraband trends  
- stock future value  

### Options Trading
Call/put options for:
- advanced speculation  
- hedging against drops  

### Government Bonds
NPC bonds that:
- stabilize inflation  
- offer safe-long term gains  
- provide economic control to the AI Director  

============================================================
# 27.10 AI DIRECTOR ECONOMY CONTROL
The AI Director can:
- trigger recessions  
- stimulate markets  
- adjust smuggling payout  
- alter crime profits  
- reduce/increase commodity drops  
- rebalance inflation  

It watches:
- player wealth distribution  
- faction economic dominance  
- company monopolies  
- laundering behaviour  

============================================================
# 27.11 ECONOMY ANTI-EXPLOIT SYSTEM
Prevents:
- insider trading  
- laundering via stock trades  
- alt account pump-and-dump  
- infinite loop trading  
- fake company IPO abuse  
- price manipulation  

Detection includes:
- trading graph analysis  
- cross-account trading correlation  
- suspicious timing patterns  
- laundering path tracing  
- behavioural anomaly detection  

============================================================
END OF CHUNK 27



============================================================
# CHUNK 28 — SOCIAL SYSTEMS (MAIL, MESSENGER, FEEDS, PROFILES, GROUPS, SAFETY)
============================================================

## 28.1 SOCIAL SYSTEM OVERVIEW
The Social Layer connects:
- players  
- factions  
- groups  
- communication networks  
- moderation/safety systems  

It includes:
- Mail  
- Real-Time Messenger  
- Social Feeds  
- Profiles  
- Friends/Groups  
- Reporting & Moderation  
- Anti-Abuse Tech  

============================================================
# 28.2 MAIL SYSTEM (ASYNC MESSAGING)
Features:
- message threads  
- attachments (items, money, blueprints)  
- filters (faction, trade, personal)  
- archiving  
- spam protection  
- block list integration  

Anti-Abuse:
- flagged words  
- scam detection  
- mass-mail prevention  
- alt-linked mail tracing  

============================================================
# 28.3 REAL-TIME MESSENGER (LIVE CHAT)
Messenger supports:
- 1:1 private chat  
- group chats  
- faction chats  
- typing indicators  
- message reactions  
- emojis & stickers  
- online/offline presence  

Advanced Features:
- encrypted channels for syndicate ops  
- faction leadership channels  
- mission operation chat  

Moderation Tools:
- mute  
- kick (group admin)  
- report from chat window  
- message deletion by moderators  

============================================================
# 28.4 PUBLIC FEEDS
### **City Feed**
- global announcements  
- major crimes  
- auctions  
- economic shifts  

### **Faction Feed**
- internal updates  
- war logs  
- promotions  
- intel leaks  

### **Event Feed**
- AI Director warnings  
- city crises  
- NPC invasions  
- jackpot winners  

Feeds support:
- likes  
- comments (moderated)  
- share to messenger  

============================================================
# 28.5 PLAYER PROFILES
Profiles contain:
- avatar  
- bio  
- stats (public-safe version)  
- achievements  
- badges  
- reputation  
- property showcase  
- vehicle showcase  
- equipped cosmetics  
- visitor log  

Privacy Settings:
- public  
- friends only  
- faction-only  
- private  

============================================================
# 28.6 REPUTATION & SOCIAL MERITS
Reputation Types:
- Global Rep  
- Faction Rep  
- Crime Rep  
- Social Rep  

Earned via:
- helping players  
- events  
- faction contribution  
- consistent missions  

Displayed as:
- badges  
- titles  
- cosmetic borders  

============================================================
# 28.7 FRIENDS & GROUPS
Features:
- friend requests  
- best-friend bonuses  
- synergy missions with friends  
- custom friend groups  

Private Groups:
- group description  
- member roles  
- group chat  
- group events  

Group Types:
- social  
- business  
- smuggling rings  
- racing crews  

============================================================
# 28.8 REPORTING & MODERATION PIPELINE
Players can report:
- messages  
- mail  
- profiles  
- names  
- scams  
- harassment  

Moderation Flow:
1. Player report submitted  
2. Automated AI filter analysis  
3. Severity scoring  
4. Human moderator review (if needed)  
5. Logged outcomes  

Actions:
- warning  
- mute  
- temporary ban  
- permanent ban  
- content deletion  

============================================================
# 28.9 SAFETY & ANTI-ABUSE SYSTEMS
### Anti-Spam
- rate limits  
- fingerprint detection  
- repeated message analysis  

### Anti-Scam
- transaction warning prompts  
- scam pattern recognition  
- suspicious link blocking  

### Anti-Impersonation
- identity verification badges  
- faction rank verification  

### Anti-Alt Network Abuse
- device matching  
- behaviour similarity  
- IP clustering  

============================================================
# 28.10 SOCIAL EVENTS
Examples:
- city festivals  
- faction celebrations  
- racing meetups  
- casino tournaments  
- business expos  
- black market gatherings  

Rewards:
- cosmetics  
- reputation  
- rare titles  

============================================================
END OF CHUNK 28



============================================================
# CHUNK 29 — NPC SYSTEM (AI BEHAVIOUR, GANGS, BOSSES, ECONOMY ROLES)
============================================================

## 29.1 NPC SYSTEM OVERVIEW
NPCs are the **living population** of Trench City.  
They interact with:
- crimes
- missions
- smuggling
- factions
- black market
- properties
- economy
- AI Director

NPCs have:
- personality
- routines
- loyalties
- memory
- fear/trust metrics
- aggression levels

They form the backbone of the dynamic city ecosystem.

============================================================
# 29.2 NPC TYPES (FULL LIST)
### Civilian NPCs
- workers  
- students  
- shopkeepers  
- delivery drivers  
- club-goers  

Roles:
- witnesses  
- victims  
- informants  

### Criminal NPCs
- pickpockets  
- muggers  
- dealers  
- enforcers  
- smugglers  

### Gang NPCs
- recruits  
- soldiers  
- lieutenants  
- bosses  

### Law Enforcement NPCs
- PCSOs  
- patrol officers  
- detectives  
- armed response  
- special operations  

### Syndicate NPCs
- elite agents  
- handlers  
- brokers  
- assassins  

### Economy NPCs
- traders  
- fences  
- shop owners  
- business employees  

============================================================
# 29.3 NPC PERSONALITY & STATS
NPC attributes:
- aggression  
- fear  
- greed  
- loyalty  
- stealth  
- intelligence  
- suspicion  
- physical stats  

NPCs evolve based on:
- events  
- crime levels  
- player interactions  
- faction dominance  

============================================================
# 29.4 NPC BEHAVIOUR SYSTEM
NPCs operate on a live behaviour loop:
- **Observe**  
- **Evaluate**  
- **Act**  
- **Remember**  

Behaviours include:
- fleeing  
- attacking  
- calling police  
- reporting crimes  
- joining gangs  
- engaging in market trading  
- participating in events  

============================================================
# 29.5 NPC SCHEDULE & PATHING SYSTEM
NPCs follow daily routines:
- commuting  
- working  
- nightlife  
- shopping  
- criminal activities  

Dynamic system factors:
- time of day  
- borough danger rating  
- police presence  
- AI Director tension  

Special behaviours:
- gang patrols  
- undercover police routes  
- smuggler shipments  

============================================================
# 29.6 NPC RELATIONSHIP MATRIX
NPCs track relationship values with:
- players  
- factions  
- gangs  
- other NPCs  

Relationship states:
- friendly  
- neutral  
- fearful  
- hostile  
- loyal  
- betrayal-prone  

Memory System:
NPCs remember:
- crimes done near them  
- players who attacked them  
- favours done for them  
- deals completed  
- scams or betrayals  

============================================================
# 29.7 NPC GANGS SYSTEM
NPC gangs have:
- territories  
- rackets  
- smuggling operations  
- recruitment patterns  
- leadership hierarchy  

Gang Actions:
- turf wars  
- retaliations  
- ambushes  
- extortion  
- smuggling protection  

Gang traits:
- brutality  
- discipline  
- economic strength  
- political corruption  

============================================================
# 29.8 NPC BOSSES (ELITE ENCOUNTERS)
Bosses appear in:
- missions  
- heists  
- raids  
- events  
- syndicate ops  

Boss Types:
- gang leaders  
- syndicate handlers  
- corrupt officials  
- elite assassins  

Boss mechanics:
- multi-phase fights  
- reinforcements  
- weak point patterns  
- fear + intimidation system  

Rewards:
- rare items  
- blueprints  
- black market keys  

============================================================
# 29.9 NPC ECONOMIC ROLES
NPCs operate:
- shops  
- markets  
- fences  
- nightclubs  
- black market stalls  

They influence:
- commodity prices  
- black market supply  
- job wages  
- property events  

NPC traders track:
- stock levels  
- demand  
- supply chain disruptions  

============================================================
# 29.10 NPC WORLD SIMULATION
A living city simulation:
- crime waves  
- police crackdowns  
- gang invasions  
- smuggling fluctuations  
- economic booms  
- social unrest  

NPC actions influence:
- mission availability  
- black market inventory  
- faction war difficulty  
- economic cycles  

============================================================
# 29.11 AI DIRECTOR NPC CONTROL
The AI Director dynamically adjusts:
- NPC aggression  
- police strength  
- gang expansion  
- smuggler frequency  
- mission difficulty  
- city heat  

It ensures:
- balanced gameplay  
- unpredictability  
- no repetitive loops  

============================================================
# 29.12 NPC ANTI-EXPLOIT SYSTEM
Prevents:
- farming NPCs  
- XP exploits  
- forced respawn loops  
- predictable path abuse  
- safe-spot cheesing  
- boss reset abuse  

Detection:
- time-to-kill anomalies  
- movement exploit detection  
- spawn manipulation patterns  

============================================================
END OF CHUNK 29



============================================================
# CHUNK 30 — CITY SYSTEM (BOROUGHS, HEAT, WEATHER, TIME, SHOPS, EVENTS)
============================================================

## 30.1 CITY SYSTEM OVERVIEW
Trench City is a **living city simulation** divided into multiple UK‑inspired boroughs.  
The City System influences:
- crimes  
- smuggling  
- NPC behaviour  
- faction wars  
- property markets  
- black market activity  
- economic cycles  
- events  

The city updates every **game tick** (1–5 minutes depending on load).

============================================================
# 30.2 BOROUGH SYSTEM
Each borough has:
- Wealth Rating  
- Crime Rating  
- Police Presence  
- Population Density  
- Gang Influence  
- Economic Activity  
- Heat Level (dynamic)  
- Unique Landmarks  

### Example Borough Types:
- **Central District** — high wealth, heavy police, corporate hubs  
- **East Estate** — gang-dominated, cheap housing, high crime  
- **Harbour Point** — smuggling hotspot, docks, warehouses  
- **Riverside Quarter** — nightlife, clubs, casinos  
- **Old Town** — historic buildings, black market antiques  
- **Industrial Belt** — factories, logistics, pollution  

============================================================
# 30.3 HEAT SYSTEM (CITY‑WIDE + BOROUGH‑LEVEL)
Heat represents law enforcement pressure & danger level.  
Heat increases with:
- crimes  
- gang warfare  
- smuggling failures  
- player violence  
- faction conflicts  

Heat reduces with:
- police crackdowns  
- bribes  
- time decay  
- corruption events  

### Heat Levels:
**0 – Calm**  
NPCs relaxed, low patrols.

**1 – Watchful**  
More police presence, fewer civilians.

**2 – Alert**  
Crimes riskier, NPCs more reactive.

**3 – Crackdown**  
Roadblocks, raids, higher arrest chance.

**4 – Emergency State**  
Major lockdowns, syndicate counterattacks.

============================================================
# 30.4 WEATHER SYSTEM
Weather dynamically impacts:
- NPC behaviour  
- crime success rates  
- smuggling chances  
- travel times  
- faction operations  

Weather Types:
- Clear  
- Rain  
- Storm  
- Fog  
- Snow  
- Heatwave  

Weather Modifiers Example:
- Fog → better stealth, worse driving  
- Storm → smuggler risk +20%, police patrol −10%  
- Heatwave → NPC aggression +10%  

============================================================
# 30.5 TIME‑OF‑DAY SYSTEM
Time affects:
- shop hours  
- nightlife  
- police patrol routes  
- gang activity  
- NPC density  

### Day Cycle:
**Morning** — commuters, low crime  
**Afternoon** — shops open, busy streets  
**Evening** — nightlife opens, moderate crime  
**Night** — gangs active, police reduced  
**Late Night** — smuggling peak  

============================================================
# 30.6 CRIME ZONES & HOTSPOTS
High-crime zones change dynamically based on:
- gang activity  
- player crime heat  
- economic decline  
- smuggling drops  
- NPC world simulation  

Hotspot Types:
- mugging zones  
- drug dealing strips  
- burglary districts  
- grey market clusters  
- underground fight pits  

Hotspot Effects:
- bonus XP  
- bonus cash  
- risk increase  
- special crimes unlocked  

============================================================
# 30.7 SHOPS & SERVICES
### Legal Shops:
- convenience stores  
- pharmacies  
- clothing stores  
- gyms  
- garages  
- phone shops  
- property agents  

### Illegal Shops:
- weapon stalls  
- drug dens  
- black market huts  
- gambling backrooms  
- underground mod shops  
- smuggling supply vendors  

NPC Shop Logic:
- stock levels  
- dynamic pricing  
- supply chain impact  
- shop upgrades (player-owned businesses)  

============================================================
# 30.8 CITY EVENTS (LOCAL + GLOBAL)
Events can be:
- AI Director triggered  
- player-triggered  
- faction-triggered  
- random dynamic events  

### Local Borough Events:
- gang takeover  
- police sweep  
- fire outbreak  
- club festival  
- market crash  
- smuggling surge  

### City‑Wide Events:
- crime epidemic  
- blackout  
- heatwave crisis  
- snowstorm shutdown  
- political election  
- syndicate threat escalation  

Each event modifies:
- heat  
- economy  
- NPC behaviour  
- risk/reward ratios  

============================================================
# 30.9 LANDMARKS & SPECIAL AREAS
Examples:
- **Central Station** — fast travel hub  
- **Old Market Hall** — antiques & stolen goods  
- **Trench Docks** — smuggling epicentre  
- **City Bank HQ** — heists, high‑difficulty missions  
- **Skyline Tower** — rich property hub  
- **Nightfall Strip** — casinos, clubs, nightlife crimes  

Landmarks influence:
- mission availability  
- black market access  
- property pricing  
- crime opportunities  

============================================================
# 30.10 AI DIRECTOR CITY MANAGEMENT
AI Director dynamically controls:
- borough heat  
- police distribution  
- gang conflicts  
- smuggling opportunities  
- event scheduling  
- economic modifiers  

City never feels static.  
Every login feels different.

============================================================
# 30.11 CITY ANTI‑EXPLOIT LOGIC
Prevents:
- hotspot farming  
- crime loop exploits  
- predictable patrol path abuse  
- merchant stock manipulation  
- route camping  
- borough cycling exploits  

Detection includes:
- movement heatmaps  
- repeated action metrics  
- location-based pattern flags  

============================================================
END OF CHUNK 30



============================================================
# CHUNK 31 — TRAVEL, TRANSPORT, VEHICLES & PUBLIC TRANSIT
============================================================

## 31.1 TRAVEL & TRANSPORT OVERVIEW
Movement in Trench City is a **high-risk, high-strategy** system touching:
- crimes  
- smuggling  
- missions  
- racing  
- events  
- police encounters  
- NPC behaviour  
- borough heat  

Includes:
- personal vehicles  
- public transit  
- fast travel hubs  
- faction transport  
- international routes  

============================================================
# 31.2 VEHICLE SYSTEM (FULL FRAMEWORK)
Vehicle Types:
- bikes  
- scooters  
- hatchbacks  
- saloons  
- estates  
- vans  
- sports cars  
- superbikes  
- luxury cars  
- armoured vehicles  

Vehicle Stats:
- speed  
- acceleration  
- handling  
- durability  
- stealth  
- cargo space  
- fuel efficiency  

Vehicle Conditions:
- wear & tear  
- damage  
- overheating  
- tyre quality  
- fuel level  

============================================================
# 31.3 VEHICLE UPGRADES & MODIFICATIONS
Categories:
- performance mods  
- handling mods  
- stealth mods  
- armour mods  
- cargo upgrades  
- tuning kits  

Examples:
- turbocharger  
- ECU remap  
- reinforced chassis  
- hidden compartments  
- off-road tyres  
- nitrous boost (illegal)  

Upgrades affect:
- races  
- escape chances  
- smuggling success  
- police evasion  

============================================================
# 31.4 VEHICLE USES & GAMEPLAY LOOPS
Vehicles are used for:
- travel  
- smuggling  
- racing  
- delivery missions  
- escape missions  
- faction operations  
- high-speed chases  
- heists  

Vehicle Crime Bonuses:
- getaway boost  
- reduced detection  
- smuggling concealment  
- faction pursuit advantage  

============================================================
# 31.5 PUBLIC TRANSPORT SYSTEM
### Train Network
- connects major boroughs  
- random inspections  
- pickpocket NPCs  
- smuggler risk  

### Tube System (Underground)
- fast travel  
- crowded (higher crime chance)  
- police patrol variation  
- blackout events  

### Bus System
- cheap  
- slow  
- variable risk  

Public Transport Modifiers:
- time of day  
- weather  
- heat level  
- city events  

============================================================
# 31.6 FAST TRAVEL NETWORK
Unlocked via:
- station discovery  
- faction safehouses  
- taxi network  
- syndicate tunnel system  

Fast Travel Modes:
- taxis  
- private drivers  
- faction chauffeurs  
- illegal tunnel shortcuts  
- smuggling concealed routes  

Each has:
- cost  
- risk  
- cooldown  
- visibility (for police/gangs)  

============================================================
# 31.7 RACING SYSTEM (VEHICLE PvE + PvP)
Race Types:
- drag  
- sprint  
- circuit  
- off-road  
- outlaw street races  

Race Mechanics:
- vehicle stats  
- driver skill  
- tuning  
- weather  
- heat level  
- AI competitor behaviour  

Rewards:
- cash  
- reputation  
- vehicle parts  
- blueprints  

============================================================
# 31.8 DELIVERY / ESCAPE / CHASE MISSIONS
### Delivery Missions
- timed routes  
- cargo protection  
- smuggler counterplay  

### Escape Missions
- outrun police  
- lose tailing NPCs  
- navigate borough heat  

### Chase Missions
- pursue enemies  
- intercept smugglers  
- faction assignments  

============================================================
# 31.9 OUT-OF-CITY & INTERNATIONAL TRAVEL
Unlocked via:
- missions  
- faction rank  
- syndicate favour  

Destinations:
- other UK cities  
- ferry ports  
- airports  
- international smuggling hubs  

Used for:
- rare materials  
- exotic contraband  
- global missions  
- cross-country races  
- international factions  

============================================================
# 31.10 TRAVEL RISK SYSTEM
Risk increases from:
- carrying contraband  
- high borough heat  
- wanted level  
- police checkpoints  
- time of day  
- weather hazards  

Travel Outcomes:
- safe arrival  
- mugging  
- police stop  
- vehicle damage  
- random encounters  
- smuggler opportunity event  

============================================================
# 31.11 TRAVEL EVENTS
Examples:
- tyre blowout  
- NPC ambush  
- police roadblock  
- sudden storm hazard  
- gang checkpoint  
- smuggler convoy discovery  
- street race invitation  

============================================================
# 31.12 AI DIRECTOR TRAVEL CONTROL
AI Director adjusts:
- roadblock frequency  
- NPC ambush rate  
- smuggling opportunities  
- weather-related hazards  
- racing invitations  
- encounter difficulty  

============================================================
# 31.13 ANTI-EXPLOIT TRAVEL LOGIC
Prevents:
- route looping  
- low-risk smuggling spam  
- safe-spot movement exploits  
- predictable encounter farming  
- endless race farming  
- multi-account transport abuse  

Detection Tools:
- timing patterns  
- route repetition  
- travel speed anomalies  
- contraband transport patterns  

============================================================
END OF CHUNK 31



============================================================
# CHUNK 32 — MISSIONS, QUESTS, HEISTS & STORYLINE SYSTEM
============================================================

## 32.1 MISSION SYSTEM OVERVIEW
The Mission System is a **multi-layered content engine** providing:
- story progression  
- daily repeatables  
- procedural missions  
- faction & syndicate ops  
- heists  
- world events  
- elite endgame content  

All missions are influenced by:
- player stats  
- borough heat  
- weather  
- NPC world simulation  
- AI Director  
- faction alignment  

============================================================
# 32.2 MISSION TYPES
### **Story Missions**
- branching narrative  
- player choices with consequences  
- cutscene-like text sequences  
- multi-stage objectives  

### **Daily Missions**
- quick rewards  
- rotating objectives  
- difficulty scaling  

### **Procedural Missions**
Generated from templates:
- assassinations  
- burglaries  
- smuggling  
- NPC rescue  
- gang suppression  
- delivery runs  

Infinite replayability.

### **Faction Missions**
Depend on:
- rank  
- loyalty  
- faction war state  
- diplomacy  

### **Syndicate Missions**
Elite operations:
- black ops  
- prototype retrieval  
- international smuggling  
- assassinations  
- deep-cover espionage  

============================================================
# 32.3 MISSION STRUCTURE
Every mission has:
- intro briefing  
- objective list  
- modifiers (heat, weather, time)  
- enemy sets  
- NPC allies  
- loot pool  
- performance rating  
- endings (A/B/C)  

Objectives include:
- infiltrate  
- sabotage  
- escape  
- assassinate  
- steal  
- decode  
- protect NPC  
- escort cargo  

============================================================
# 32.4 HEIST SYSTEM (AAA MULTI-PHASE MISSIONS)
Heists are **high-risk, high-reward** multi-phase missions.

Heist Examples:
- Bank Heist  
- Museum Theft  
- Armoured Truck Robbery  
- Syndicate Vault Break-in  
- High-End Property Raid  

Heist Phases:
1. **Recon Phase**  
   - scout security  
   - gather NPC intel  
   - disable alarms  

2. **Planning Phase**  
   - choose crew (NPCs or friends)  
   - select tools & vehicles  
   - assign roles (driver, hacker, muscle)  

3. **Execution Phase**  
   - stealth route or loud route  
   - timed objectives  
   - NPC reinforcements  

4. **Escape Phase**  
   - chase sequence  
   - roadblocks  
   - heat effects  

5. **Post-Heist Phase**  
   - fence loot  
   - laundering  
   - crew loyalty updates  

============================================================
# 32.5 PROCEDURAL MISSION GENERATOR (PMG)
PMG builds infinite missions using:
- location templates  
- NPC templates  
- objective sequences  
- difficulty modifiers  
- event hooks  

The generator reacts live to:
- heat  
- player behaviour  
- faction war  
- economy  
- black market state  

PMG Output Examples:
- “A smuggler convoy is moving through Harbour Point. Intercept it.”  
- “A gang lieutenant is operating in East Estate. Eliminate him quietly.”  
- “Police are conducting raids tonight—extract a VIP from Old Town.”  

============================================================
# 32.6 DYNAMIC STORYLINES
Storylines adapt based on:
- player morality  
- faction allegiance  
- betrayals  
- NPC deaths  
- borough changes  
- AI Director events  

Branches can cause:
- NPC alliances  
- gang hostilities  
- faction reputation shifts  
- unique items  
- custom mission arcs  

============================================================
# 32.7 DIFFICULTY SCALING
Mission difficulty scales using:
- player stats  
- heat level  
- wanted level  
- weather  
- NPC aggression  
- gang dominance  
- faction war intensity  

Difficulty affects:
- enemy stats  
- reinforcements  
- time limits  
- reward multipliers  

============================================================
# 32.8 MISSION REWARD SYSTEM
Rewards include:
- cash  
- XP  
- items  
- materials  
- blueprints  
- reputation  
- faction loyalty  
- rare prototypes (elite missions)  

Special Rewards:
- crew unlocks  
- property upgrades  
- story progression  
- faction influence  

============================================================
# 32.9 AI DIRECTOR MISSION CONTROL
AI Director adjusts:
- mission spawn rate  
- difficulty  
- reward scaling  
- enemy sets  
- event missions  

If players are:
**winning too easily** → harder missions spawn  
**struggling** → more accessible missions spawn  

============================================================
# 32.10 MISSION ANTI-EXPLOIT LOGIC
Prevents:
- mission farming  
- reset exploitation  
- infinite stealth XP loops  
- multi-account boosting  
- item duplication via missions  
- heist repetition exploits  

Tools:
- cooldowns  
- scaling detection  
- reward diminishing returns  
- anomaly tracking  

============================================================
END OF CHUNK 32



============================================================
# CHUNK 33 — COMBAT SYSTEM (PVE, PVP, BOSSES, STATUS EFFECTS, TURN ENGINE)
============================================================

## 33.1 COMBAT SYSTEM OVERVIEW
Combat in Trench City is a **hybrid turn-based + stat-driven engine** used for:
- PvE battles  
- PvP fights  
- faction wars  
- gang encounters  
- boss fights  
- ambush events  
- heists & missions  

Combat is influenced by:
- stats (STR, DEF, SPD, DEX)  
- weapon type  
- armour layers  
- status effects  
- environment  
- borough heat  
- weather  
- AI Director  

============================================================
# 33.2 COMBAT MODES
### **PvE Combat**
Against:
- criminals  
- gang members  
- police  
- syndicate operatives  
- creatures (special events)  

### **PvP Combat**
Supports:
- 1v1  
- ambush attacks  
- consensual duels  
- bounty fights  
- faction raids  

### **Faction Combat**
Used in:
- territory wars  
- chain hits  
- raid defenses  
- faction ops  

### **Boss Combat**
Bosses use:
- multi-phase patterns  
- reinforcements  
- status effect waves  
- armour breaks  
- scripted mechanics  

============================================================
# 33.3 TURN ENGINE (CORE MECHANICS)
Each turn includes:
1. initiative check (speed)  
2. player action  
3. enemy action  
4. status resolution  

Actions:
- basic attack  
- weapon skill  
- item use  
- tactical ability  
- defensive stance  
- flee attempt  

Turn Variables:
- accuracy  
- dodge  
- crit chance  
- armour penetration  
- recoil compensation  

============================================================
# 33.4 COMBAT STATS
Core Stats:
- **Strength (STR)** — melee damage  
- **Speed (SPD)** — turn order & dodge  
- **Defense (DEF)** — damage reduction  
- **Dexterity (DEX)** — accuracy, crit chance  

Hidden Stats:
- **Control** — recoil & weapon mastery  
- **Awareness** — ambush prevention  
- **Stability** — stun/knockback resistance  

============================================================
# 33.5 WEAPON CATEGORIES & MECHANICS
### Weapon Categories:
- melee  
- pistols  
- SMGs  
- shotguns  
- rifles  
- snipers  
- heavy weapons  
- experimental weapons  

Weapon Attributes:
- base damage  
- accuracy  
- recoil  
- crit multiplier  
- penetration  
- fire rate  
- ammo consumption  

Weapon Effects:
- stagger  
- bleed  
- armour shred  
- suppression  
- stun  

Attachments:
- scopes  
- suppressors  
- extended mags  
- stabilisers  
- laser sights  

============================================================
# 33.6 ARMOUR SYSTEM
Armour Layers:
- light layer  
- medium layer  
- heavy layer  
- tactical plates  

Armour Attributes:
- damage reduction  
- penetration resistance  
- durability  
- weight (affects speed)  

Armour Damage:
- armour breaks  
- plate shattering  
- reduced mobility  

============================================================
# 33.7 STATUS EFFECTS (FULL LIST)
### Physical Effects:
- **Bleed** — damage each turn  
- **Stun** — lose all action  
- **Concussion** — chance to skip turn  
- **Cripple** — speed reduction  
- **Fracture** — damage penalty  

### Tactical Effects:
- **Suppression** — reduced accuracy  
- **Disarm** — weapon disabled  
- **Armour Break** — reduced DR  
- **Expose Weakpoint** — increased crit chance  

### Chemical Effects:
- **Poison** — HP decay  
- **Toxin** — stat reduction  
- **Overdose** — random turn loss  

============================================================
# 33.8 ENVIRONMENTAL MODIFIERS
Combat affected by:
- weather  
- time of day  
- borough heat  
- nearby NPCs  
- cover availability  
- terrain (wet, icy, cluttered)  

Examples:
- fog increases dodge  
- rain reduces accuracy  
- crowd areas reduce AoE effects  
- heat level increases police reinforcement chance  

============================================================
# 33.9 BOSS COMBAT FRAMEWORK
Boss Phases:
1. **Phase 1:** standard attacks  
2. **Phase 2:** new pattern + reinforcements  
3. **Phase 3:** enraged mode  
4. **Phase 4:** desperation mechanics  

Boss Mechanics:
- shield phases  
- armour gating  
- summons  
- debuff waves  
- environment hazards  

Rewards:
- rare loot  
- prototypes  
- blueprints  
- unique cosmetics  

============================================================
# 33.10 AI COMBAT ENGINE
NPCs evaluate:
- health  
- threat level  
- weapon advantage  
- terrain  
- player patterns  

NPC Behaviours:
- flanking  
- grouping  
- fallback at low HP  
- target priority  
- coordinated attacks  

Boss AI:
- pattern recognition  
- adaptive phases  
- retaliation triggers  

============================================================
# 33.11 COMBAT REWARD SYSTEM
Rewards include:
- XP  
- cash  
- items  
- crafting materials  
- weapon parts  
- rep / faction rep  

Rare Drops:
- exotic weapon mods  
- prototype materials  
- syndicate tech  

============================================================
# 33.12 COMBAT ANTI-EXPLOIT LOGIC
Prevents:
- stat exploits  
- turn manipulation  
- safe-spot farming  
- boss reset abuse  
- multi-account boosting  
- AFK fighting loops  

Tracking:
- damage patterns  
- action delays  
- repeated behaviour cycles  
- external assistance detection  

============================================================
END OF CHUNK 33



============================================================
# CHUNK 34 — CRIMES SYSTEM (20 CRIME PATHS + SUB-CRIMES + RISK + HEAT)
============================================================

## 34.1 CRIME SYSTEM OVERVIEW
The Crimes System is a **massive structured progression tree** built around:
- 20 unique crime paths  
- 100+ individual crimes  
- dynamic success calculations  
- heat escalation  
- police + NPC witness logic  
- gang/faction modifiers  
- stat scaling  
- item/tool integration  
- AI Director oversight  

Crimes are a **core progression pillar** providing:
- XP  
- cash  
- materials  
- heat  
- faction rep  
- black market access  
- unlocks for missions, smuggling & syndicate ops  

============================================================
# 34.2 THE 20 CRIME PATHS (FULL LIST)
Each crime path contains 5–10 crimes (detailed below).

1. **Pickpocketing**
2. **Shoplifting**
3. **Street Robbery**
4. **Burglary (Residential)**
5. **Commercial Burglary**
6. **Car Theft**
7. **Drug Dealing**
8. **Weapon Running**
9. **Fraud & Cybercrime**
10. **Vandalism & Public Disorder**
11. **Assault & Violent Crimes**
12. **Blackmail & Extortion**
13. **Loan Sharking**
14. **Counterfeiting**
15. **Smuggling (Local)**
16. **Smuggling (International)**
17. **Gang Contracts**
18. **Syndicate Operations**
19. **Artifact Theft & High-End Theft**
20. **Elite Crime Ops (Endgame)**

============================================================
# 34.3 CRIME PATH DETAILS & SUB-CRIMES

### 1. Pickpocketing
- Steal wallet  
- Steal phone  
- Lift valuables in crowd  
- Tube station grab  
- Distraction theft  

### 2. Shoplifting
- Conceal small goods  
- Bag-switch trick  
- Fake return scam  
- Backroom break-in  

### 3. Street Robbery
- Mug lone civilian  
- Alley ambush  
- Smash & grab  
- Motorbike snatch  

### 4. Residential Burglary
- Window entry  
- Lockpick entry  
- Silent house break  
- Night-time burglary  

### 5. Commercial Burglary
- Break into shop  
- Loot cash drawers  
- Office safe cracking  
- Warehouse raiding  

### 6. Car Theft
- Break-in  
- Hotwire  
- Key cloning  
- Steal luxury car  
- Chop shop delivery  

### 7. Drug Dealing
- street sale  
- stash delivery  
- controlled buy  
- expand territory  
- gang drug run  

### 8. Weapon Running
- move small arms  
- transport crates  
- sell to gangs  
- police infiltration risk  
- syndicate-grade weapons  

### 9. Fraud & Cybercrime
- phishing  
- credit card cloning  
- bank scam  
- digital infiltration  
- crypto theft  

### 10. Vandalism & Disorder
- graffiti tag  
- smash windows  
- burn-out  
- chaos escalation event  

### 11. Assault & Violent Crime
- threaten NPC  
- beatdown  
- gang intimidation  
- targeted attack  
- bounty violence  

### 12. Blackmail & Extortion
- gather compromising info  
- threaten NPC  
- extort business  
- pressure faction member  

### 13. Loan Sharking
- issue illegal loans  
- collect debts  
- intimidate non-payers  
- seize assets  

### 14. Counterfeiting
- fake notes  
- fake goods  
- distribute forged IDs  
- counterfeit electronics  

### 15. Smuggling (Local)
- move contraband  
- tube network runs  
- car trunk smuggling  
- gang-controlled routes  

### 16. Smuggling (International)
- ferry smuggling  
- airport mule  
- foreign syndicate delivery  
- prototype contraband movement  

### 17. Gang Contracts
- attack rival gang  
- deliver weapons  
- hit-list target  
- destroy stash  

### 18. Syndicate Operations
- assassinations  
- data heists  
- prototype recovery  
- elite smuggling  

### 19. High-End Theft / Artifact Crime
- museum break-in  
- artifact switch  
- auction house infiltration  
- cultural item fencing  

### 20. Elite Crime Ops (Endgame)
- international ops  
- ultra-risk missions  
- syndicate war crimes  
- multi-stage elite thefts  

============================================================
# 34.4 CRIME SUCCESS CALCULATION
Success is influenced by:
- stats (DEX, SPD, STR, DEF)  
- crime mastery level  
- borough heat  
- weather  
- time of day  
- NPC density  
- faction bonuses  
- equipped items/tools  
- witness presence  
- AI Director modifiers  

Formula uses:
- base success rate  
- player modifiers  
- environment modifiers  
- randomness  
- heat penalty  

============================================================
# 34.5 HEAT & WANTED SYSTEM FOR CRIMES
Crimes generate heat:
- minor crimes = low heat  
- violent crimes = high heat  
- syndicate ops = extreme heat  

Heat effects:
- higher police patrols  
- witness sensitivity  
- arrest chance  
- mission difficulty  
- smuggling interference  

Wanted Levels:
- 0: clear  
- 1: caution  
- 2: active search  
- 3: pursuit  
- 4: high danger  
- 5: lockdown  

============================================================
# 34.6 CRIME XP TREES & MASTERY
Each crime path has:
- XP track  
- mastery levels  
- passive bonuses  
- unlockable advanced crimes  

Examples:
- Pickpocket Mastery → better stealth in crowds  
- Burglary Mastery → lockpick buff  
- Smuggling Mastery → scanner evasion buff  

============================================================
# 34.7 CRIME REWARDS
Rewards include:
- cash  
- XP  
- items  
- contraband  
- materials  
- gang rep  
- faction rep  
- black market unlocks  

High-tier crimes yield:
- rare prototypes  
- blueprints  
- large cash  
- syndicate favour  

============================================================
# 34.8 AI DIRECTOR CRIME CONTROL
AI Director adjusts:
- crime rewards  
- crime difficulty  
- heat sensitivity  
- witness density  
- police response  
- available crimes  

============================================================
# 34.9 CRIME ANTI-EXPLOIT SYSTEM
Prevents:
- crime spam  
- instant retries  
- cycling low-risk crimes  
- alt-based heat dumping  
- safe-spot exploitation  
- farming the same NPC  
- XP macro patterns  

Tools:
- diminishing returns  
- cooldowns  
- pattern detection  
- reward throttling  
- alt correlation  

============================================================
END OF CHUNK 34



============================================================
# CHUNK 35 — ITEMS, BLUEPRINTS, CRAFTING & MATERIAL SYSTEM
============================================================

## 35.1 ITEM SYSTEM OVERVIEW
The Item System is the backbone of:
- combat  
- crafting  
- smuggling  
- missions  
- properties  
- factions  
- black market  
- economy  

Items come from:
- crimes  
- NPC drops  
- crafting  
- blueprints  
- shops (legal + black market)  
- factions  
- events  
- smuggling routes  
- heists  

============================================================
# 35.2 ITEM CATEGORIES
### Weapons
- melee  
- pistols  
- SMGs  
- rifles  
- shotguns  
- snipers  
- heavy weapons  
- prototype/exotic weapons  

### Armour
- light  
- medium  
- heavy  
- tactical plates  
- hazmat suits  
- stealth suits  

### Tools
- lockpicks  
- hacking devices  
- breaching equipment  
- scanners  
- crafting tools  

### Consumables
- health items  
- stimulants  
- performance boosters  
- antidotes  
- energy items  
- food/drinks  

### Contraband
- drugs  
- weapon parts  
- stolen goods  
- prototype components  
- encrypted devices  

### Crafting Materials
- metals  
- chemicals  
- textiles  
- circuitry  
- rare compounds  
- organic materials  

### Vehicle Parts
- engines  
- brakes  
- tyres  
- tuning kits  
- stealth modules  

### Property Items
- security systems  
- furniture  
- decor items  
- room upgrades  

============================================================
# 35.3 RARITY TIERS
1. **Common**
2. **Uncommon**
3. **Rare**
4. **Elite**
5. **Prototype**
6. **Mythic (Ultra-Endgame)**

Rarity affects:
- stats  
- mod slots  
- crafting difficulty  
- value  
- black market demand  

============================================================
# 35.4 BLUEPRINT SYSTEM
Blueprints unlock:
- weapon crafting  
- armour crafting  
- mods/attachments  
- chemical formulas  
- hacking devices  
- smuggling containers  
- vehicle parts  
- property upgrades  

Blueprint Source:
- heists  
- syndicate missions  
- rare NPC drops  
- faction stores  
- auctions  
- world events  

Blueprint Types:
- **single-use**  
- **multi-use**  
- **infinite (legendary)**  

============================================================
# 35.5 CRAFTING PROFESSIONS (FULL LIST)
Players can specialise in:
- **Weaponsmith** — guns, melee weapons, modifications  
- **Armoursmith** — plates, vests, tactical suits  
- **Chemist** — drugs, toxins, stimulants, chemicals  
- **Mechanic** — vehicle parts, tuning, upgrades  
- **Hacker** — digital tools, exploit chips, devices  
- **Artificer** — exotic prototypes, experimental mods  

Each profession has:
- mastery XP  
- recipes  
- unique perks  
- profession talents  

============================================================
# 35.6 CRAFTING STATIONS
Each item type requires a specific station:

### Workshops
- weapons  
- armour  
- tools  
- mods  

### Chemical Labs
- drugs  
- precursors  
- stimulants  
- medical supplies  

### Server Rooms
- hacking devices  
- exploit chips  
- software tools  

### Greenhouses
- organic materials  
- drug plants  

### Garages
- vehicle parts  
- tuning kits  
- stealth mods  

### Property Rooms
- living upgrades  
- decor  
- security systems  

Stations have levels:
- T1 basic  
- T2 improved  
- T3 advanced  
- T4 elite  

============================================================
# 35.7 MATERIAL SOURCES
Materials come from:
- crime drops  
- NPC loot  
- faction missions  
- black market deals  
- smuggling runs  
- raids  
- property greenhouses  
- auctions  
- world events  
- AI Director injections  

Material Quality:
- low  
- medium  
- high  
- refined  
- prototype-grade  

============================================================
# 35.8 CRAFTING PROCESS
Crafting Steps:
1. choose blueprint  
2. gather materials  
3. verify station requirements  
4. roll success chance  
5. apply quality modifiers  
6. add mod slots (if applicable)  
7. generate item  

Crafting Influencers:
- player mastery  
- blueprint rarity  
- material quality  
- station level  
- time of day (some crafts)  
- AI Director modifiers  

============================================================
# 35.9 ITEM DURABILITY & REPAIR
Weapons, armour, tools degrade from:
- combat  
- missions  
- failures  
- environment  

Durability Effects:
- reduced stats  
- misfires  
- accuracy loss  
- armour break chance  

Repair Options:
- repair kits  
- crafting stations  
- specialists (NPC or faction)  

============================================================
# 35.10 ITEM MODDING & UPGRADES
Mod Types:
- damage mods  
- accuracy mods  
- recoil control  
- stealth modules  
- ammo type modifications  
- armour plates  
- toxin enhancements  

Mod Slots depend on:
- item rarity  
- profession mastery  
- blueprint tier  

============================================================
# 35.11 ITEM ECONOMY & MARKET INFLUENCE
Items flow through:
- player markets  
- auctions  
- NPC traders  
- black market  
- faction markets  
- crafting economy  

Economy influenced by:
- smuggling routes  
- AI Director scarcity  
- NPC war activity  
- faction dominance  
- crime waves  

============================================================
# 35.12 ITEM ANTI-EXPLOIT LOGIC
Prevents:
- dupe exploits  
- infinite craft loops  
- salvage abuse  
- blueprint duplication  
- multi-account crafting rings  
- mass-farm crafting  
- durability reset abuse  

Tools:
- unique item IDs  
- transaction logs  
- cooldowns  
- diminishing returns  
- crafting anomaly detection  

============================================================
END OF CHUNK 35



============================================================
# CHUNK 36 — ADVANCED WEAPONS, ARMOUR, DAMAGE TYPES & MOD SYSTEM
============================================================

## 36.1 ADVANCED WEAPON SYSTEM OVERVIEW
Weapons in Trench City follow a **deep simulation model** including:
- ballistic physics
- penetration logic
- recoil patterns
- accuracy cones
- damage curves
- ammo types
- mod slots
- rarity scaling

Weapons interact with:
- armour layers
- environment
- status effects
- player stats
- AI Director modifiers

============================================================
# 36.2 WEAPON CLASSES & SUBTYPES

### Pistols
- compact pistol
- service pistol
- heavy pistol
- prototype smart pistol

### Revolvers
- snub revolver
- magnum revolver
- armour-piercing revolver

### SMGs
- micro SMG
- compact SMG
- tactical SMG

### Rifles
- assault rifle
- marksman rifle
- burst rifle
- high-end prototype rifle

### Shotguns
- pump shotgun
- tactical shotgun
- auto-shotgun
- breaching shotgun

### Snipers
- hunting sniper
- tactical sniper
- anti-materiel rifle

### Heavy Weapons
- LMG
- grenade launcher
- prototype energy launcher

### Exotic / Prototype Weapons
- electrified baton
- toxin injector
- rail pistol
- energy rifle
- chemical projector

============================================================
# 36.3 WEAPON STAT SYSTEM

Primary Stats:
- **Base Damage**
- **Fire Rate**
- **Accuracy**
- **Recoil**
- **Penetration**
- **Crit Multiplier**

Secondary Stats:
- stability
- muzzle velocity
- reload time
- handling
- aim-down-sight speed

Hidden Stats:
- recoil recovery
- bloom growth
- jam chance (low quality weapons)

============================================================
# 36.4 WEAPON DAMAGE CURVES
Each weapon has:
- damage falloff with distance
- body-part multipliers
- crit zone modifiers
- armour penetration reduction
- ricochet chance based on angle & material

============================================================
# 36.5 AMMO TYPES (FULL LIST)

### Standard Ammo
- FMJ (balanced)
- Hollowpoint (high flesh damage, low penetration)

### Armour-Piercing Ammo
- AP rounds
- tungsten-core rounds

### Special Ammo
- incendiary rounds
- shock rounds
- toxin rounds
- rubber rounds (non-lethal)
- subsonic (stealth)

### Prototype Ammo
- bio-enhanced toxin shells
- micro-explosive rounds
- energy capacitors

Ammo affects:
- damage type
- penetration
- noise profile
- status infliction
- AI response

============================================================
# 36.6 ARMOUR SYSTEM (ADVANCED)

### Armour Layers
1. **Soft Armour Layer** — flexible, low protection  
2. **Hard Plate Layer** — medium protection  
3. **Composite Plates** — high protection  
4. **Prototype Armour** — elite protection / special traits  

### Armour Stats:
- DR (damage reduction)
- penetration resistance
- durability
- weight (speed penalty)
- elemental resistances

### Armour Types:
- tactical vests
- riot armour
- stealth suits
- hazmat suits
- prototype suits (energy-absorbing)

============================================================
# 36.7 DAMAGE TYPES & RESISTANCE SYSTEM

### Physical
- blunt (batons, fists)
- edged (knives)
- ballistic

### Chemical
- toxin
- acid
- drug-overdose effects

### Elemental
- fire
- electric
- cryogenic (prototype only)

Each armour piece provides unique resistances.

============================================================
# 36.8 WEAPON MOD SYSTEM (ADVANCED)

### Attachment Types
- **Barrels** (range, recoil)
- **Optics** (accuracy, crit)
- **Stocks** (stability)
- **Magazines** (ammo capacity)
- **Underbarrels** (grips, launchers)
- **Muzzles** (suppressors, compensators)

### Exotic Mods
- toxin injector
- shock coil
- smart recoil chip
- thermal sight
- rail accelerator

### Modding Rules:
- rarity defines mod slots
- prototype weapons may have unique mod architecture
- stacking limits prevent DPS exploits

============================================================
# 36.9 ENVIRONMENTAL WEAPON INTERACTIONS
- rain decreases effective range
- fog reduces hit chance
- heat increases jam chance on low-tier guns
- snow affects recoil stability
- enclosed areas amplify blast damage

============================================================
# 36.10 COMBAT INTEGRATION (ADVANCED)
Weapons integrate with:
- boss weak points
- armour shatter thresholds
- ricochet logic
- cover & line-of-sight checks
- faction resistances
- weather-based modifiers

============================================================
# 36.11 WEAPON & ARMOUR ECONOMY
Influences:
- black market value
- faction demand
- gang war cycles
- AI Director scarcity injections
- international smuggling flows

============================================================
# 36.12 ANTI-EXPLOIT MEASURES
Prevents:
- infinite ammo exploits
- mod stacking abuse
- weapon macro auto-farming
- durability reset glitches
- damage overflow exploits
- alt feeding for rare ammo

Tools:
- stat caps
- soft/hard diminishing returns
- weapon recoil anomaly detection
- firing-rate pattern tracking
- mod validity checksum

============================================================
END OF CHUNK 36



============================================================
# CHUNK 37 — FACTIONS, WARS, TERRITORIES, RAIDS & DIPLOMACY
============================================================

## 37.1 FACTION SYSTEM OVERVIEW
Factions are **player-created organisations** that control:
- territory
- economy influence
- warfare
- diplomacy
- research & upgrades
- smuggling routes
- black market access
- endgame activities

Factions are **the core late-game social & competitive system**.

============================================================
# 37.2 FACTION CREATION & STRUCTURE
### Creation Requirements:
- level requirement
- cash cost
- reputation threshold

### Faction Structure:
- **Leader**
- **Co-Leaders**
- **Officers**
- **Members**
- **Recruits**

### Faction Management Tools:
- invite / kick
- role assignment
- faction treasury
- withdrawal permissions
- war controls
- diplomacy controls
- research tree management

============================================================
# 37.3 FACTION UPGRADES & TECH TREE
Tech branches include:
- **Combat Branch**
  - attack bonuses
  - defence bonuses
  - armour penetration
  - chain damage boosts

- **Economy Branch**
  - income boosts
  - shop discounts
  - smuggling bonuses
  - reduced crafting costs

- **Logistics Branch**
  - travel bonuses
  - faster recovery
  - stash expansions
  - reduced heat generation

- **Stealth Branch**
  - spy tools
  - recon bonuses
  - sabotage power
  - anti-surveillance upgrades

Each tech requires:
- faction XP
- cash
- materials
- faction loyalty

============================================================
# 37.4 TERRITORY CONTROL SYSTEM
The city is divided into **territory sectors** inside boroughs.

Each sector has:
- income (passive)
- danger level
- NPC gang presence
- heat influence
- smuggling bonus potential

Territory Income Sources:
- protection money
- black market taxes
- smuggling cuts
- business extortion
- event bonuses

Territory Control Effects:
- stronger faction presence
- reduced heat for members
- increased reward bonuses
- unlocks faction-specific crimes

============================================================
# 37.5 TERRITORY WARFARE
Territories can be taken by:
- **PvP battles**
- **chain hits**
- **raid missions**
- **NPC gang suppression**

War Types:
- **Standard War** (scheduled)
- **Surprise Attack**
- **Retaliation War**
- **Total War** (endgame)

War Rules:
- war windows
- reinforcement limits
- objective-based captures
- point systems

============================================================
# 37.6 THE CHAIN SYSTEM
Factions build long chains by:
- attacking enemies repeatedly
- defeating NPC gang groups
- winning ambushes / raids

Chain Bonuses:
- XP multipliers
- cash rewards
- rare drops
- faction reputation
- chain milestone crates

Anti-Exploit:
- repeated attacks on same target give reduced rewards
- alt detection removes chain value
- cooldowns on protected players

============================================================
# 37.7 FACTION RAIDS
### Player vs Player Raids:
- invade enemy HQ
- destroy defences
- steal resources
- capture tech
- kidnap NPC allies

### Player vs NPC Raids:
Fight:
- police forces
- rival gangs
- syndicate bases
- AI-controlled fortresses

Raid Rewards:
- materials
- faction XP
- weapon parts
- rare loot
- blueprint fragments

============================================================
# 37.8 FACTION BUILDINGS & UPGRADES
Buildings:
- war room
- armoury
- workshop
- smuggling bay
- recon office
- vault
- bunker
- infirmary

Building Upgrades:
- increase bonuses
- unlock new faction missions
- reduce cooldowns
- strengthen defences

============================================================
# 37.9 DIPLOMACY SYSTEM
Diplomacy Options:
- alliances
- truces
- trade agreements
- joint operations
- shared intel networks

Diplomacy Factors:
- faction reputation
- leader decisions
- actions in wars
- betrayal history
- syndicate influence

Betrayal Mechanics:
- trust penalties
- war declaration bonuses
- event reaction changes

============================================================
# 37.10 SYNDICATE INFLUENCE SYSTEM
The AI-controlled syndicate:
- grants favour
- punishes failure
- influences faction wars
- manipulates black market prices
- sends elite missions to chosen factions

Factions can:
- gain syndicate rank
- unlock unique tech
- access prototype items

============================================================
# 37.11 FACTION MISSIONS & OPERATIONS
Mission Types:
- recon missions
- sabotage runs
- assassination contracts
- smuggling operations
- rescue ops
- staged riots
- large-scale raids

Operations affect:
- territory balance
- heat levels
- economy
- NPC gang movements

============================================================
# 37.12 FACTION ECONOMY SYSTEM
Faction Resources:
- cash
- materials
- blueprint fragments
- influence
- favour

Faction Income:
- taxes
- territory income
- chain rewards
- raid loot
- diplomacy deals

============================================================
# 37.13 FACTION AI ELEMENTS
NPC Factions:
- defend territory
- attack weak factions
- escalate wars
- sabotage players
- respond to player actions

AI behaviours depend on:
- borough heat
- economy status
- player victories/losses

============================================================
# 37.14 FACTION ANTI-EXPLOIT MEASURES
Prevents:
- alt faction boosting
- fake war farming
- chain abuse
- artificial territory swapping
- treasury draining
- insider sabotage

Tools:
- IP/device correlation
- pattern detection
- reward diminishing
- protection timers
- betrayal cooldowns

============================================================
END OF CHUNK 37



============================================================
# CHUNK 38 — PROPERTIES, UPGRADES, FORTRESSES & DEFENCE SYSTEM
============================================================

## 38.1 PROPERTY SYSTEM OVERVIEW
Properties are a **major progression pillar** providing:
- regen bonuses  
- storage  
- crafting rooms  
- security layers  
- prestige  
- smuggling access  
- income rooms  
- endgame fortress gameplay  

Properties scale from early-game flats to ultra-endgame fortified compounds.

============================================================
# 38.2 PROPERTY TIERS (FULL LIST)

### Tier 1 — Basic Living
- Bedsit  
- Studio Flat  
- Shared Housing Room  

### Tier 2 — Standard Properties
- 1-Bed Flat  
- 2-Bed Flat  
- Small House  

### Tier 3 — Advanced Homes
- Townhouse  
- Detached Home  
- Luxury Apartment  

### Tier 4 — High-End Properties
- Penthouse  
- Suburban Estate  
- Riverside Manor  

### Tier 5 — Compounds & Complexes
- Walled Compound  
- Underground Bunker  
- Syndicate Safehouse  

### Tier 6 — Endgame Fortresses
- Urban Fortress  
- Industrial Complex  
- Mountain Retreat (elite)  
- Prototype Defence Facility  

============================================================
# 38.3 PROPERTY CORE STATS

### 1. **Comfort**
Affects:
- energy regen  
- nerve regen  
- happiness  

### 2. **Security**
Affects:
- burglary protection  
- raid defence  
- smuggling safety  

### 3. **Storage**
Affects:
- item capacity  
- contraband limit  
- crafting material storage  

### 4. **Defence Rating**
Used during:
- property raids  
- NPC attacks  
- faction conflicts  

### 5. **Prestige**
Affects:
- passive bonuses  
- social status  
- faction influence  

============================================================
# 38.4 PROPERTY ROOMS & MODULES

### Living Modules
- bedroom upgrades  
- lounge  
- luxury bathroom  
- entertainment rooms  

### Utility Modules
- storage vault  
- safe room  
- panic bunker  
- surveillance hub  

### Crafting Rooms
- workshop  
- chemical lab  
- server room  
- greenhouse  
- garage  

### Economic Rooms
- rental rooms  
- smuggling bay  
- black market node  
- underground casino room  

### Combat/Defence Rooms
- turret control  
- guard barracks  
- perimeter wall  
- trap corridors  
- digital firewall (hacking defence)  

============================================================
# 38.5 PROPERTY UPGRADE SYSTEM

Upgrades require:
- materials  
- blueprints  
- cash  
- syndicate favour (high-end)  

Upgrade Examples:
- reinforced walls  
- biometric locks  
- turret instalment  
- automated scanners  
- reinforced vault door  
- silent ventilation (crime bonus)  
- prestige interior sets  

Each upgrade increases:
- comfort  
- storage  
- defence  
- prestige  
- smuggling efficiency  

============================================================
# 38.6 PROPERTY FORTRESS SYSTEM (ENDGAME)

Fortresses are **raid-enabled properties** with:

### Defensive Structures:
- automated turrets  
- NPC guards  
- trap systems  
- reinforced gates  
- motion sensors  
- blackout systems  
- EMP shielding  

### Fortress Mechanics:
- defend against raids  
- store high-value items  
- crafting elite prototypes  
- run smuggling mega-operations  
- conduct faction-level missions  

Fortress Tiers:
- T1 basic fortress  
- T2 militarised fortress  
- T3 elite fortress  
- T4 prototype defence facility  

============================================================
# 38.7 PROPERTY RAID SYSTEM (PVP + PVE)

### Raid Types:
- **Player Raid** — attack another player’s fortress  
- **Faction Raid** — faction-targeted operations  
- **NPC Syndicate Raid** — high danger  
- **Gang Raids** — linked to borough heat  

Raid Objectives:
- breach defence  
- bypass traps  
- defeat guards  
- reach vault room  
- steal materials, blueprints, money  

Raid Resolution Uses:
- defence strength  
- traps triggered  
- turret fire  
- security layers  
- player/faction intervention  

============================================================
# 38.8 PRESTIGE & PROPERTY SET BONUSES

Cosmetic prestige upgrades give:
- faster regen  
- improved crime bonuses  
- smuggling concealment  
- faction influence bonus  
- interaction bonuses with NPCs  

Prestige Sets:
- Modern Luxury  
- Dark Ops  
- Neo-Industrial  
- Syndicate Elite  

============================================================
# 38.9 PROPERTY ECONOMY

Properties generate:
- rent  
- smuggling revenue  
- crafting output  
- black market tax  
- event-based income  

Economy influenced by:
- borough heat  
- faction control  
- AI Director scarcity  
- NPC gang pressure  

============================================================
# 38.10 SMUGGLING ROOM SYSTEM

Smuggling rooms provide:
- contraband storage  
- scanner evasion  
- tunnel access  
- faction smuggling bonuses  
- passive smuggle income  

Upgrades:
- concealed compartments  
- signal jammers  
- thermal masking  

============================================================
# 38.11 PROPERTY INTERIOR CUSTOMISATION

Rooms can be:
- decorated  
- themed  
- upgraded visually  
- assigned NPCs (guards, staff)  

Interior System Includes:
- furniture  
- wallpapers  
- flooring  
- lighting  
- prestige objects  

============================================================
# 38.12 PROPERTY ANTI-EXPLOIT MEASURES

Prevents:
- safehouse immunity loops  
- storage duping  
- raid manipulation  
- offline raid farming  
- infinite smuggling loops  
- AI-free defence exploits  

Tools:
- cooldowns  
- security token checks  
- ownership verification  
- anomaly detection  
- defence data hashing  

============================================================
END OF CHUNK 38



============================================================
# CHUNK 39 — HOUSING INTERIORS, DECORATION & PRESTIGE SYSTEM
============================================================

## 39.1 INTERIOR SYSTEM OVERVIEW
Interiors turn properties into **customisable living spaces** that also provide:
- comfort bonuses
- crafting buffs
- prestige increases
- social value
- faction influence
- smuggling concealment benefits

Every interior is made of:
- themes
- rooms
- decorative items
- prestige objects
- functional modules

============================================================
# 39.2 INTERIOR THEMES (FULL LIST)

### Modern Luxury
- marble floors  
- gold accents  
- LED ambient lighting  
- premium furniture  

### Industrial
- exposed steel  
- concrete  
- heavy lighting rigs  
- warehouse aesthetic  

### Dark Ops
- tactical interiors  
- reinforced walls  
- concealed compartments  
- military styling  

### Neo-Syndicate
- neon accents  
- holographic displays  
- cyberpunk furniture  

### Street Aesthetic
- graffiti walls  
- reclaimed furniture  
- neon strips  
- underground vibe  

### Underground Bunker
- reinforced steel  
- survivalist layout  
- utility-focused  

Each theme adds:
- visual identity  
- prestige value  
- passive bonuses  

============================================================
# 39.3 ROOM TYPES (FULL LIST)

### Living Spaces
- bedroom  
- lounge  
- kitchen  
- bathroom  
- media room  

### Functional Spaces
- workshop  
- greenhouse  
- chemical lab  
- server room  
- armoury  

### Economic Spaces
- rental room  
- smuggling bay  
- black market room  

### Prestige Spaces
- trophy hall  
- gallery  
- achievement wall  
- vault viewing room  

============================================================
# 39.4 DECORATIVE ITEM CATEGORIES

### Furniture
- sofas  
- beds  
- tables  
- chairs  
- wardrobes  

### Lighting
- lamps  
- ceiling lights  
- neon strips  
- tactical lights  

### Wall Decor
- posters  
- paintings  
- graffiti murals  
- digital screens  

### Props
- plants  
- statues  
- shelves  
- crates  
- models  

### Prestige Items
- unique trophies  
- rare artifacts  
- achievement plaques  
- faction banners  
- limited event collectibles  

============================================================
# 39.5 INTERIOR STATS & BONUSES

### Comfort
Affects:
- energy regen  
- nerve regen  
- happiness  

### Prestige
Affects:
- social ranking  
- faction influence  
- crime intimidation bonus  

### Functionality Bonuses:
- crafting speed  
- better blueprint success  
- improved smuggling concealment  
- NPC staff mood boosts  

============================================================
# 39.6 INTERIOR EDITOR SYSTEM

Players can:
- place objects  
- rotate items  
- layer objects  
- save layouts  
- apply themes  
- change room types  

Editor Features:
- grid snapping  
- free placement mode  
- visual preview  
- undo/redo  
- theme presets  

============================================================
# 39.7 PRESTIGE GALLERY SYSTEM

A dedicated room for:
- trophies  
- rare items  
- boss drops  
- blueprints  
- achievement displays  
- faction banners  

Gallery Stats:
- increases prestige  
- unlocks social interactions  
- boosts NPC loyalty  

============================================================
# 39.8 INTERACTIVE OBJECTS

Some decor items provide:
- stat bonuses  
- crafting perks  
- social options  
- NPC interactions  
- hidden compartments  

Examples:
- jukebox (happiness bonus)  
- meditation mat (nerve regen)  
- mini-workbench (crafting speed)  
- concealed stash (smuggling bonus)  

============================================================
# 39.9 INTERIOR ECONOMY

Decor items come from:
- shops  
- crafting  
- drops  
- seasonal events  
- faction rewards  
- auctions  

Rarity:
- common  
- rare  
- elite  
- prestige-only  
- event-limited  

============================================================
# 39.10 SOCIAL INTEGRATION

Players can:
- visit others’ interiors  
- like rooms  
- display prestige  
- show collections  
- invite faction members  
- host events  

NPCs react to interiors:
- mood boosts  
- loyalty bonuses  

============================================================
# 39.11 INTERIOR ANTI-EXPLOIT MEASURES

Prevents:
- decor duplication  
- free-placement exploits  
- storage exploits  
- stat stacking abuses  
- hidden clipping storage hacks  

Tools:
- item ownership checks  
- placement collision validation  
- prestige cap rules  
- access logs  
- suspicious layout detection  

============================================================
END OF CHUNK 39



============================================================
# CHUNK 40 — COUNTRY SYSTEM, INTERNATIONAL TRAVEL, GLOBAL SMUGGLING NETWORKS
============================================================

## 40.1 COUNTRY SYSTEM OVERVIEW
Countries expand the world beyond London, providing:
- unique crime ecosystems
- foreign missions
- international factions
- rare contraband sources
- large-scale smuggling routes
- world events that affect the entire game
- endgame content loops

Countries unlock progressively through:
- missions
- faction rank
- syndicate favour
- smuggling achievements

============================================================
# 40.2 COUNTRY LIST (INITIAL)
Each country has:
- difficulty rating
- law enforcement strength
- corruption index
- contraband speciality
- local factions
- unique events

### United Kingdom (Base Region)
- London (core city)
- Portsmouth (ferry hub)
- Manchester (gang-heavy)
- Glasgow (weapon-running hotspot)

### Netherlands
- drug labs
- smuggling ports
- cybercrime hubs

### Spain
- cartel-linked black markets
- counterfeit markets
- artifact trafficking

### Morocco
- hashish routes
- covert desert smuggling
- tribal factions

### Turkey
- firearms black market
- prototype tech routes
- high corruption

### UAE
- high-end contraband
- luxury item laundering
- elite syndicate operations

### India
- counterfeit pharma
- cybercrime syndicates
- crowded urban missions

### Japan
- Yakuza ties
- tech prototypes
- high police efficiency

### Colombia
- cartel missions
- jungle smuggling
- high-risk/high-reward ops

============================================================
# 40.3 INTERNATIONAL TRAVEL SYSTEM

Travel Methods:
- commercial flights
- ferries
- private aircraft
- syndicate smuggling aircraft
- underground smuggling networks

Travel Stats:
- travel time
- heat risk
- contraband scanning risk
- border corruption rating
- random encounter chance

Travel Events:
- police inspection
- bribery opportunities
- smuggler meetups
- syndicate escorts
- ambushes (NPC or player factions)

============================================================
# 40.4 GLOBAL SMUGGLING NETWORK

Smuggling Tiers:
1. **Local (UK boroughs)**
2. **Regional (EU routes)**
3. **Continental**
4. **International**
5. **Syndicate Prototype Routes**

Each tier unlocks:
- new contraband types
- high-value deliveries
- elite missions
- rare materials

Contraband Categories:
- drugs
- weapons
- stolen goods
- cultural artifacts
- high-end electronics
- prototype tech

Network Mechanics:
- heat tracking per country
- corruption level modifies risk
- bribery system
- partner syndicates
- rival smugglers
- dynamic demand per region

============================================================
# 40.5 FOREIGN CITIES & UNIQUE CONTENT

Every foreign location includes:
- unique crimes
- country-specific missions
- special NPC factions
- regional storyline arcs
- exclusive crafting materials
- limited-time contraband

Examples:

### Amsterdam
- synthetic lab missions
- cyber-fraud networks
- stealth-focused gameplay

### Istanbul
- grand bazaar black market
- weapons-running ops
- ancient artifact theft

### Dubai
- luxury laundering
- prototype testing facilities
- elite syndicate events

============================================================
# 40.6 INTERNATIONAL MISSIONS

Mission Types:
- escort contraband shipments
- infiltrate foreign syndicates
- extract VIP targets
- hack international servers
- intercept cartel aircraft
- sabotage rival smuggling rings

Mission Modifiers:
- time zones
- local law strength
- weather variation
- country-specific hazards

============================================================
# 40.7 WORLD EVENTS & GEO-POLITICAL CHANGES

Events:
- embargoes
- border closures
- cartel wars
- syndicate power shifts
- international crises
- airport lockdowns

Events affect:
- travel costs
- contraband prices
- crime difficulty
- smuggling routes
- faction missions

============================================================
# 40.8 INTERNATIONAL FACTIONS

Examples:
- Yakuza branch
- European cybercrime syndicate
- Saharan smuggling tribe
- South American cartel cells

Faction Perks:
- unique blueprints
- country-level bonuses
- special missions
- passive income networks

============================================================
# 40.9 GLOBAL HEAT & WANTED SYSTEM

Heat tracked per:
- country
- city
- region
- route tier

High heat increases:
- border inspections
- police raids
- travel failures
- NPC ambushes

Heat can be reduced by:
- bribes
- diplomacy
- time
- faction influence

============================================================
# 40.10 INTERNATIONAL ANTI-EXPLOIT SYSTEM

Prevents:
- multi-country smuggling loops
- alt-account supply chains
- safe-route exploitation
- infinite travel farming
- route resetting abuse
- contraband laundering exploits

Tools:
- route randomisation
- diminishing returns
- international IP/device tracking
- anomaly detection across borders

============================================================
END OF CHUNK 40



============================================================
# CHUNK 41 — MINI-GAMES, SKILL GAMES, TRAINING & SIDE ACTIVITIES
============================================================

## 41.1 MINI-GAME SYSTEM OVERVIEW
Mini-games add:
- skill expression
- variety
- non-combat progression
- alternative income
- stat buffs
- crafting bonuses
- crime advantages

Categories include:
- skill-based mini-games
- chance-based games
- training activities
- casual side jobs
- world interactive systems

============================================================
# 41.2 SKILL-BASED MINI-GAMES

### Lockpicking Game
Mechanics:
- tension system
- pick angle precision
- timed segments
- break chance for low-tier tools

Rewards:
- burglary success increase
- burglary XP
- rare drops for perfect picks

### Safe Cracking
Mechanics:
- dial rotation
- vibration cues
- timed lock phases

Used In:
- high-end theft
- heists
- commercial burglary

### Hacking Game
Mechanics:
- node matching
- bypass puzzles
- malware tracing timer
- firewall stages

Benefits:
- cybercrime bonus
- access to locked servers
- blueprint decryption

### Pickpocket Timing Game
Mechanics:
- reaction timing
- direction prediction
- crowd density modifiers

Benefits:
- higher pickpocket earnings
- stealth XP
- reduced heat gain

### Sharpshooting Range
Mechanics:
- accuracy tests
- moving targets
- recoil management

Rewards:
- weapon mastery XP
- accuracy buffs
- crafting bonuses for weapons

### Racing Time Trials
Mechanics:
- checkpoint routes
- drift bonuses
- traffic hazards

Rewards:
- vehicle XP
- tuning materials

============================================================
# 41.3 CHANCE / RISK MINI-GAMES

### Dice Games
Variants:
- street dice
- high-stakes cartel dice
- faction dice tournaments

### Cards
- blackjack
- poker
- high-low
- syndicate-exclusive rulesets

### Shell Game
- reaction-based
- scam variant with NPC cheats
- perfect read = bonus reward

### Street Con Games
- “find the card”
- quick-switch scams
- wallet tricks

============================================================
# 41.4 TRAINING MINI-GAMES

### Gym Rhythm Game
Mechanics:
- timing-based reps
- combo multiplier
- form accuracy

Buffs:
- temporary STR, SPD or DEF boosts
- faster gym training progression

### Reflex Training
- QTE sequences
- dodging practice
- helps PvP dodge rate

### Tactical Combat Drills
- weapon switching drills
- reload tests
- precision tests

Rewards:
- small permanent stat bumps
- weapon familiarity XP

### Crafting Skill Tests
- timing-based crafting QTE
- improves craft quality
- increases success chance

============================================================
# 41.5 OCCUPATION MINI-GAMES (SIDE JOBS)

### Courier Work
Gameplay:
- timed deliveries
- heat-sensitive routes

Rewards:
- cash
- small stat gains
- faction goodwill

### Bar Work
Mini-games:
- pour drinks accurately
- manage customers
- bounce troublemakers

Rewards:
- cash
- social XP
- bar network access

### Street Performance
Mechanics:
- rhythm performance
- crowd building
- style bonuses

Rewards:
- cash
- social prestige
- small buffs

### Temp Crime Jobs
- unload smuggled crates
- organise stolen goods
- run lookout stations

Rewards:
- materials
- crime mastery XP

============================================================
# 41.6 WORLD INTERACTIVE MINI-GAMES

### Dumpster Diving
- find crafting scraps
- low-chance rare items
- risk of injury

### Pawn Shop Negotiation
- bargaining mini-game
- charisma-based outcomes

### Underground Fight Pits
Mechanics:
- simplified combat mini-game
- wager system

Rewards:
- cash
- combat XP
- faction rep

============================================================
# 41.7 MINI-GAME REWARD SYSTEM

Rewards include:
- XP (combat/crafting/crime/social)
- cash
- materials
- weapons/tools
- vehicle parts
- exclusive cosmetic items
- rare blueprints

Performance Tiers:
- fail
- pass
- good
- perfect

Perfect reward gives significant bonuses.

============================================================
# 41.8 MINI-GAME ANTI-EXPLOIT SYSTEM

Prevents:
- botting
- macro farming
- AFK loops
- predictable RNG exploits
- auto-complete scripts

Techniques:
- randomised patterns
- input variance requirements
- session-based diminishing returns
- anti-macro heatmaps
- behavioural anomaly tracking

============================================================
END OF CHUNK 41



============================================================
# CHUNK 42 — ACHIEVEMENTS, AWARDS, MERITS, TITLES & MERIT SHOP
============================================================

## 42.1 ACHIEVEMENT SYSTEM OVERVIEW
Achievements reward:
- long-term progression
- mastery of systems
- exploration of mechanics
- prestige & social recognition
- permanent account growth

Achievements span:
- crimes
- combat
- smuggling
- missions
- factions
- crafting
- properties
- social interactions
- travel
- minigames
- events

Total planned: **500+ achievements**

============================================================
# 42.2 ACHIEVEMENT CATEGORIES

### Crime Achievements
- successful theft milestones
- heat streaks
- burglary mastery levels
- perfect pickpocket runs
- smuggling career thresholds

### Combat Achievements
- PvP kills
- PvE boss defeats
- perfect-fight achievements
- weapon mastery completions
- armour usage milestones

### Mission Achievements
- story arcs
- heist milestones
- procedural mission completion
- multi-phase missions without failure

### Faction Achievements
- war victories
- chain lengths
- territory captures
- raid successes

### Crafting Achievements
- item crafting counts
- prototype crafting
- blueprint mastery
- perfect crafting streaks

### Social Achievements
- messages sent
- room likes received
- friends added
- positive reputation milestones

### Property Achievements
- fortress defences
- interior prestige scores
- upgrade tier milestones

### Travel Achievements
- countries visited
- safe smuggling runs
- perfect inspection evasion

### Minigame Achievements
- high scores
- perfect runs
- minigame mastery

============================================================
# 42.3 ACHIEVEMENT TIERS

### Bronze (Easy)
- introduces players to systems

### Silver (Intermediate)
- requires moderate skill & investment

### Gold (Advanced)
- long-term mastery achievements

### Platinum (Elite)
- extremely rare
- significant prestige

### Mythic (Endgame)
- world-first / server-first titles
- permanent recognition

============================================================
# 42.4 MERIT / AWARD POINT SYSTEM

Merits (or Award Points) are:
- permanent
- non-tradable
- earned from key achievements

Uses:
- stat boosts
- unlock perks
- passive bonuses
- special abilities

Merit Types:
- Crime Merit
- Combat Merit
- Social Merit
- Exploration Merit
- Faction Merit
- Mastery Merit

============================================================
# 42.5 TITLES SYSTEM

Titles appear on:
- profile
- chat
- faction list
- leaderboard pages

### Title Categories:
- Crime Titles (e.g., “Shadow Lifter”)
- Combat Titles (e.g., “Urban Executioner”)
- Smuggling Titles (e.g., “Ghost Runner”)
- Prestige Titles (e.g., “Syndicate Elite”)
- Seasonal Titles (event-limited)
- World-First Titles (permanent)

Titles have:
- rarity colors
- animated borders (elite tiers)
- prestige bonuses (minor)

============================================================
# 42.6 MERIT SHOP SYSTEM

Players can spend merits on:
- gym efficiency boosts
- crime success bonuses
- crafting success perks
- smuggling concealment upgrades
- travel risk reductions
- cooldown reductions
- inventory expansions
- energy/nerve regen boosts

Shop Structure:
- tier-based unlocks
- category-based items
- scaling costs
- diminishing returns for balance

============================================================
# 42.7 ACHIEVEMENT GALLERY & PROFILE DISPLAY

Profile Displays:
- recent achievements
- rare trophies
- animated borders
- displayed title
- merit count
- achievement score

Gallery Rooms:
- trophy walls
- title plaques
- rare-item showcases
- seasonal achievement statues

============================================================
# 42.8 SEASONAL & LIVE EVENT ACHIEVEMENTS

Types:
- limited-time seasonal challenges
- faction wars seasons
- smuggling seasons
- world events
- leaderboard races

Rewards:
- exclusive titles
- rare decor items
- limited badges
- cosmetic flairs

============================================================
# 42.9 ANTI-EXPLOIT & ACHIEVEMENT VALIDATION

Prevents:
- spoofing achievements
- macro grinding
- repeated exploit loops
- alt farming
- false completion via network manipulation

Techniques:
- server-side validation
- achievement integrity hashing
- behaviour comparison vs normal ranges
- duplicate-action heatmaps
- retroactive correction / invalidation

============================================================
END OF CHUNK 42



============================================================
# CHUNK 43 — DONATOR, SUBSCRIPTIONS, COSMETICS, BATTLE PASS & MONETISATION SYSTEM
============================================================

## 43.1 MONETISATION OVERVIEW
Monetisation in Trench City follows a strict rule:
**No Pay-to-Win. Only Pay-for-Convenience & Pay-for-Cosmetics.**

Core pillars:
- Donator Packs (permanent account perks)
- Monthly Subscriptions
- Cosmetic Systems
- Seasonal Battle Pass
- Cosmetic Shop / Rotating Store
- Anti-P2W integrity layer

============================================================
# 43.2 DONATOR PACKS (PERMANENT)

### Donator Benefits:
- faster energy regen
- faster nerve regen
- +inventory slots
- +mailbox storage
- +property storage
- reduced travel time
- reduced gym cooldown
- donator-only cosmetic colour names
- access to donator-exclusive missions
- exclusive chat badge

### Donator-Only Features:
- donator theme pack
- advanced profile customisation
- donator auction filters
- priority job board missions

Donator packs NEVER:
- increase combat damage
- give crime success bonuses
- improve faction war performance

============================================================
# 43.3 MONTHLY SUBSCRIPTION (LOYALTY PASS)

Subscription includes:
- monthly reward bundle
- loyalty track with milestones
- bonus crafting materials
- weekly donator crates
- bonus cosmetic shards
- access to “Elite Tasks”

### Subscription Loyalty Track:
Each month grants loyalty points unlocking:
- unique titles
- cosmetics
- background themes
- exclusive decor items

============================================================
# 43.4 COSMETICS SYSTEM

Cosmetic Types:
- profile borders
- nameplate styles
- animated effects
- chat emblems
- weapon skins
- vehicle skins
- crafting animations
- property themes
- profile background scenes

Cosmetics are:
- trade-locked
- non-stat
- collection-based
- seasonal and permanent

============================================================
# 43.5 SEASONAL BATTLE PASS

A **two-track** pass:
- Free Track
- Premium Track

### Rewards Include:
- cosmetics
- decor items
- titles
- blueprint fragments
- small crafting material bundles
- property themes
- exclusive vehicle skins
- seasonal collectibles

### Progression:
Earn BP XP via:
- missions
- crimes
- faction activity
- races
- daily/weekly tasks

### Season Duration:
- 6–12 weeks
- special themes (e.g., Syndicate Season, Black Market Season)

============================================================
# 43.6 COSMETIC SHOP & ROTATING STORE

Store Types:
- featured bundles
- rotating cosmetic items
- limited-time offers
- seasonal exclusives
- prestige-only items

Currencies:
- premium currency
- cosmetic shards
- event tokens

============================================================
# 43.7 PAYMENT INTEGRITY & SECURITY LAYER

Prevents:
- credit card fraud
- chargebacks
- multi-account abuse
- cross-account gifting exploits
- laundering via cosmetic trades

Tools:
- device fingerprinting
- transactional risk scoring
- server-side purchase validation
- automatic revocation of fraudulent goods

============================================================
# 43.8 FAIRNESS & ANTI-P2W SYSTEMS

Guaranteed:
- no stat bonuses in monetised items
- no competitive advantage in faction wars
- no crime/combat modifiers sold
- no XP multipliers

Integrity Tools:
- monetisation auditor
- fairness scoring
- automatic rebalancing of cosmetic-only monetisation

============================================================
# 43.9 FUTURE MONETISATION EXPANSIONS

Potential additions:
- charity skins
- community-designed cosmetics
- event battle passes
- cosmetic crafting
- prestige cosmetic forge

============================================================
END OF CHUNK 43



============================================================
# CHUNK 44 — MESSAGING, MAIL, NOTIFICATIONS, SOCIAL SYSTEMS & CHAT
============================================================

## 44.1 SOCIAL & COMMUNICATION OVERVIEW
Communication is a core pillar of Trench City.  
This system includes:
- in‑game mail
- real‑time chat
- notifications
- social profiles
- friends/blocking
- community tools
- anti-abuse layers

============================================================
# 44.2 IN‑GAME MAIL SYSTEM

### Mail Features:
- send/receive messages  
- attachments (items/materials/cash)  
- faction-wide mail  
- mass-mail for leaders  
- saved drafts  
- archived folders  

### Mail Categories:
- Inbox  
- Faction  
- System  
- Trades  
- Favorites  
- Archived  

### Attachment Rules:
- item integrity checks  
- unique-ID validation  
- anti-dupe escrow  
- tax/fee options  

### Mail Protections:
- anti-phishing prompts  
- blocked sender list  
- suspicious attachment warnings  
- server-side validation of trades  

============================================================
# 44.3 REAL‑TIME CHAT SYSTEM

Chat Channels:
- **Global Chat**  
- **New Player Chat**  
- **Faction Chat**  
- **Neighbourhood/Borough Chat**  
- **Trade Chat**  
- **Group/Party Chat**  
- **Private DM**  

Chat Features:
- emojis  
- message pinning (mods only)  
- cosmetic nameplates  
- animated chat effects (cosmetic only)  
- slow mode (auto when heated)  
- smart profanity filter  

Moderation Tools:
- mute  
- shadowban  
- kick from channel  
- mod review queue  
- report message system  

============================================================
# 44.4 NOTIFICATION SYSTEM

Types of Notifications:
- crime results  
- mission updates  
- faction war alerts  
- travel events  
- smuggling warnings  
- item crafting results  
- market sales  
- new achievements  
- world events  
- AI Director warnings  

Delivery Methods:
- pop-up toast  
- bell/indicator  
- inbox sync  
- mission screen overlay  

Priority Levels:
1. Info  
2. Warning  
3. Critical  
4. Emergency Event  

============================================================
# 44.5 SOCIAL PROFILES

Each player profile includes:
- avatar  
- title  
- prestige border  
- stats summary  
- favourite weapon  
- faction info  
- achievements showcase  
- interior gallery link  
- social reputation score  

Social Actions:
- like a profile  
- comment  
- endorse  
- report  

============================================================
# 44.6 FRIENDS & BLOCKING SYSTEM

Friends:
- activity feed  
- online status  
- quick messaging  
- location pings (optional)  
- team-up shortcuts  

Blocking:
- hide messages  
- prevent mail  
- block trades  
- hide profile  

============================================================
# 44.7 SOCIAL REPUTATION SYSTEM

Reputation increases through:
- likes  
- endorsements  
- positive interactions  
- helping new players  

Reputation decreases through:
- reports  
- toxicity flags  
- moderator actions  

Reputation Effects:
- cosmetic borders  
- social rank titles  
- access to special community areas  

============================================================
# 44.8 COMMUNITY TOOLS

### Leaderboards:
- combat  
- crime  
- wealth  
- missions  
- faction war  
- smuggling  
- minigames  
- prestige score  

### Bulletin Boards:
- public announcements  
- player ads  
- faction recruitment  
- marketplace listings  

### Event Feed:
- world events  
- faction war updates  
- citywide crime reports  
- seasonal news  

============================================================
# 44.9 CHAT & MAIL ANTI‑EXPLOIT SYSTEM

Prevents:
- item duplication via mail  
- phishing attempts  
- spam flooding  
- bot chat behaviour  
- macro message loops  
- mass DM abuse  

Techniques:
- rate-limiting  
- behavioural analysis  
- suspicious URL blocking  
- anti-spam scoring  
- auto-chat cooldowns  
- filtered keywords  
- device/IP correlation  

============================================================
END OF CHUNK 44



============================================================
# CHUNK 45 — ADMIN PANEL, STAFF TOOLS, MODERATION, ANTI-CHEAT & SECURITY FRAMEWORK
============================================================

## 45.1 ADMIN & STAFF SYSTEM OVERVIEW
This system ensures:
- game security
- exploit prevention
- staff workflow efficiency
- transparent logging
- fair moderation
- scalable oversight

Roles:
- Owner
- Senior Admin
- Admin
- Moderator
- Support
- Developer (optional isolated role)

Each role has granular permissions.

============================================================
# 45.2 ADMIN PANEL (FULL DASHBOARD)

### Core Dashboard Tools:
- live player count
- current server load
- economy health indicators
- heatmap of active boroughs
- faction war status
- recent admin actions
- recent punishments
- flagged accounts

### User Management:
- search players
- freeze account
- reset sessions
- force logout
- view logs
- adjust flags (cannot edit stats/resources directly without justification)
- ban / mute / shadowban

### Economy Tools:
- view money supply
- track inflation
- inspect top wallets
- investigate suspicious wealth spikes

### Item Tools:
- spawn items (restricted to owner/developer)
- delete items
- trace item movement
- mark items as compromised

### Faction Oversight:
- view wars
- inspect faction treasuries
- intervene in exploits
- moderate faction descriptions

============================================================
# 45.3 MODERATOR TOOLS

### Chat Moderation:
- mute (temporary/permanent)
- shadowban from global chat
- profanity filter override
- flagged message review panel

### Player Reports:
- incoming reports queue
- evidence attachments
- automated priority score
- decision actions (warn/mute/temp ban/escalate)

### Player Notes:
- internal notes
- strike system
- history view

### Quick Tools:
- freeze player for investigation
- teleport to safe state (for stuck states)
- message player (mod-branded DM)

============================================================
# 45.4 LOGGING SYSTEM (FULL COVERAGE)

Everything is logged with timestamp, IP, device ID, and session ID.

### Player Logs:
- login/logout
- travel
- crimes
- crafting
- trading
- smuggling
- faction actions
- combat actions
- chat messages

### Economy Logs:
- money gained/lost
- market transactions
- trades
- item drops

### Admin Logs:
- bans/mutes
- item spawning
- stat adjustments
- player freezes
- economy adjustments
- permission changes

### Security Logs:
- failed logins
- suspicious requests
- API abuse attempts
- injection protection triggers
- dupe attempt logs

============================================================
# 45.5 ANTI-CHEAT ENGINE

The Anti-Cheat Engine monitors:

### Speedhack Detection:
- action timing validation
- travel time integrity
- movement speed anomalies

### Combat Validation:
- impossible damage sequences
- illegal crit patterns
- injection of combat packets
- desync detection

### Stat Manipulation Detection:
- unexpected stat jumps
- XP inconsistencies
- abnormal regen spikes

### Macro Detection:
- pattern repetition
- input interval uniformity
- anti-macro minigame layers

============================================================
# 45.6 EXPLOIT DETECTION ENGINE

Prevents:
- item duplication
- trade manipulation
- infinite crafting exploit chains
- property storage loops
- auction house laundering
- smuggling route resets
- achievement spoofing

Techniques:
- deterministic hashing
- escrow validation
- item lineage tracking
- cross-system anomaly detection
- route entropy checks

============================================================
# 45.7 SECURITY FRAMEWORK

### Account Protection:
- hashed passwords (argon2id)
- 2FA optional
- backup codes
- email verification

### Session Protections:
- device fingerprinting
- location inconsistency alerts
- session-lock anti-hijack

### Request Protections:
- strict rate limiting
- CSRF tokens
- XSS sanitisation
- injection blocking firewall

### Trade Protections:
- escrow + validation
- anti-laundering detection
- suspicious trade flags

============================================================
# 45.8 STAFF AUDIT TRAIL & ACCOUNTABILITY

All staff actions must:
- require justification
- be timestamped
- be visible to higher ranks
- be immutable

Admins cannot:
- silently alter stats
- create items without logs
- delete logs
- hide punishments

============================================================
# 45.9 GDPR / LEGAL / PRIVACY TOOLS

Includes:
- account deletion requests
- data export
- privacy settings
- cookie consent management
- IP anonymisation options
- secure storage policies

============================================================
# 45.10 INCIDENT RESPONSE WORKFLOW

For major issues:
1. automatic detection triggers alert  
2. mod/admin review  
3. freeze involved accounts/items  
4. AI exploit classifier evaluates severity  
5. senior admin verdict  
6. rollback or patch deployed  
7. transparent report logged  

============================================================
END OF CHUNK 45



============================================================
# CHUNK 46 — WORLD EVENTS, DYNAMIC AI DIRECTOR, SEASONAL SYSTEM & CRISIS ENGINE
============================================================

## 46.1 WORLD SYSTEM OVERVIEW
This system makes Trench City a **living, reactive world** where:
- crime ebbs and flows  
- police pressure rises and falls  
- factions gain and lose territory  
- events alter markets  
- crises reshape gameplay  
- the AI Director dynamically balances player experience  

The world is no longer static — it is *alive*.

============================================================
# 46.2 AI DIRECTOR — DYNAMIC CITY CONTROLLER

Inspired by Left 4 Dead’s AI Director and adapted for an MMO.

### The AI Director monitors:
- city-wide heat  
- player success/fail streaks  
- faction instability  
- smuggling pressure  
- crime volume  
- NPC gang aggression  
- economic activity  

### The AI Director can:
- increase/decrease police presence  
- adjust crime difficulty  
- trigger NPC gang raids  
- boost or reduce smuggling profits  
- create temporary safe zones  
- spark faction conflicts  
- spawn world events  

### Director Behaviour States:
1. **Calm** – lower heat, easier crime success  
2. **Alert** – moderate police presence  
3. **High Tension** – gangs hostile, more patrols  
4. **Crisis** – city-wide chaos, hardest difficulty  

============================================================
# 46.3 WORLD EVENT ENGINE

### Event Types:
- **Police Crackdown**
- **Gang War**
- **Smuggling Surge**
- **Contraband Shortage**
- **Black Market Expansion**
- **Faction Rebellion**
- **NPC Syndicate Assault**
- **Underground Races Event**
- **Treasure Hunt / Map Fragments Event**
- **Double XP Weekends**
- **Holiday Events** (xmas, halloween, etc.)

### Events Affect:
- crime success  
- loot drops  
- NPC aggression  
- crafting rates  
- property raids  
- market prices  
- smuggling routes  
- travel risk  

Events have:
- triggers  
- duration  
- global modifiers  
- AI Director escalation  

============================================================
# 46.4 SEASONAL SYSTEM

Each season (6–12 weeks) includes:
- themed content  
- season pass (premium + free)  
- seasonal missions  
- seasonal decor  
- seasonal cosmetics  
- limited-time blueprints  

### Seasonal Themes Examples:
- Syndicate Uprising  
- Black Market Overdrive  
- Winter Crisis  
- City Blackout  
- Ghosts of London (Halloween)  

Seasonal currencies:
- event tokens  
- seasonal shards  
- limited craft materials  

============================================================
# 46.5 CRISIS ENGINE

Major game-altering crises that reshape the city.

### Crisis Types:

#### 1. **City Lockdown**
- police checkpoints  
- high travel risk  
- restricted borough access  

#### 2. **Blackout**
- electrical grid down  
- hacking missions easier  
- security weaker  
- burglary buffs  

#### 3. **Syndicate City Takeover**
- NPC syndicate occupies boroughs  
- players must reclaim sectors  
- faction alliances matter  

#### 4. **Economic Collapse**
- market prices spike  
- crafting becomes expensive  
- smuggling becomes lucrative  

#### 5. **Storm / Weather Crisis**
- affects crime visibility  
- reduces NPC accuracy  
- alters vehicle control  

#### 6. **Pandemic Event**
- travel cooldowns  
- smuggling difficulty increases  
- black market medicine demand rises  

============================================================
# 46.6 PLAYER & FACTION AGENCY

Players and factions influence:
- event outcomes  
- crisis escalation  
- borough ownership  
- smuggling profits  
- black market expansion  
- police heat drops  

### Faction Contributions:
- territory captured  
- items donated  
- resources delivered  
- missions completed  

### Community Goals:
- server-wide collective objectives  
- global leaderboards  

============================================================
# 46.7 EVENT REWARD STRUCTURE

Rewards include:
- rare cosmetics  
- limited titles  
- seasonal crafting materials  
- faction reputation  
- unique decor items  
- world-event-exclusive blueprints  
- achievement badges  

============================================================
# 46.8 EVENT SCHEDULING & RANDOMISATION

Two systems:
- **Scheduled events** → holidays, seasons  
- **Procedural events** → AI Director triggered  

Randomisation Parameters:
- intensity  
- duration  
- borough affected  
- participating NPC factions  
- economic changes  

============================================================
# 46.9 CRISIS ANTI-EXPLOIT SYSTEM

Prevents:
- event farming  
- alt-account boosting  
- infinite smuggling stacking  
- out-of-sync player states  
- reward duplication  
- rapid event toggling  
- faction manipulation of crisis states  

Tools:
- crisis tokens  
- diminishing returns  
- multi-factor validation  
- director-state hashing  

============================================================
END OF CHUNK 46



============================================================
# CHUNK 47 — NPC SYSTEM, CIVILIANS, GANGS, BOSSES, AI BEHAVIOURS & WORLD POPULATION
============================================================

## 47.1 NPC SYSTEM OVERVIEW
NPCs form the living population of Trench City.  
They interact with:
- crimes  
- missions  
- events  
- factions  
- borough heat  
- smuggling networks  
- the AI Director  

NPCs are designed around **behaviour loops**, not static text.  
They react to the world and the player.

There are five NPC classes:
1. Civilians  
2. Criminal NPCs  
3. Police NPCs  
4. Special/Syndicate NPCs  
5. Boss NPCs  

============================================================
# 47.2 CIVILIAN NPCS

Civilians populate boroughs based on:
- time of day  
- borough wealth  
- borough crime heat  
- AI Director state  

Civilian behaviours:
- flee when threatened  
- call police  
- act as witnesses  
- provide opportunities (pickpocket, scams)  
- spawn civilian missions  
- influence crime difficulty indirectly  

Civilian attributes:
- fear level  
- alertness  
- wealth tier  
- awareness of player  

Witness mechanics:
- can report crimes  
- increase police heat  
- identify player (partial or full)  
- flee or freeze depending on fear  

============================================================
# 47.3 CRIMINAL NPCS

Criminal NPC types:
- street thugs  
- muggers  
- burglars  
- drug runners  
- gang scouts  
- weapon runners  
- smugglers  
- loan shark collectors  

Criminal behaviours:
- ambush players  
- attempt robberies  
- defend territory  
- initiate street fights  
- flee when losing  
- call backup from gang members  

Criminal roles:
- spawn random events  
- trigger faction-related crime  
- escalate borough heat  

============================================================
# 47.4 POLICE NPCS

Police tiers:
1. **Community Officers**  
2. **Response Units**  
3. **Detectives**  
4. **Tactical Units (Armed Response)**  

Police behaviours:
- patrol boroughs  
- respond to reported crimes  
- escalate based on heat  
- set up roadblocks  
- chase players  
- raid properties during crisis events  

Police intelligence:
- uses player logs (virtual)  
- detects smuggling patterns  
- responds dynamically to AI Director  

============================================================
# 47.5 SPECIAL SYNDICATE NPCS

Elite NPCs appearing in:
- world events  
- high-tier missions  
- faction operations  
- smuggling routes  
- endgame boroughs  

Types:
- syndicate enforcers  
- specialist hackers  
- elite smugglers  
- cartel lieutenants  
- prototype tech thieves  

Behaviours:
- coordinated attacks  
- advanced combat tactics  
- environmental usage (cover, retreat, push)  

============================================================
# 47.6 BOSS NPCS

Bosses are multi-phase encounters with:
- unique mechanics  
- scripted events  
- voice lines (optional)  
- advanced resistances  
- loot tables  
- blueprint drops  
- achievement integration  

Boss Types:
- gang kingpins  
- cartel commanders  
- syndicate overlords  
- corrupted officials  
- special event bosses  

Boss Loot Types:
- rare crafting materials  
- boss-only blueprints  
- cosmetics  
- titles  
- trophy decor  

============================================================
# 47.7 NPC AI BEHAVIOURS

### Core AI Systems:
- aggression  
- intimidation  
- flee/surrender  
- group coordination  
- target selection  
- heat-based reactions  
- environmental adaptation  

### Combat AI:
- distance management  
- weapon switching  
- retreat when low HP  
- call reinforcements  
- focus-target logic  

### Civilian AI:
- random walking patterns  
- fear-triggered reactions  
- crowd dispersal  
- reporting behaviour  

### Gang/Faction AI:
- territorial behaviour  
- patrol logic  
- scout/warning behaviour  
- group ambush tactics  

============================================================
# 47.8 NPC INTEGRATION INTO GAME SYSTEMS

NPCs appear dynamically in:
- crimes (success/failure interactions)  
- missions (enemy targets, escorts, VIPs)  
- faction wars (NPC backup or enemies)  
- world events (raids, crackdowns)  
- smuggling encounters  
- borough patrolling  
- crafting quests (deliveries, theft)  

============================================================
# 47.9 NPC SCALING

Scaling Factors:
- player level  
- faction rank  
- borough heat  
- AI Director intensity  
- mission tier  
- crisis state  

NPC scaled attributes:
- HP  
- damage  
- accuracy  
- loot quality  
- reinforcement frequency  

============================================================
# 47.10 NPC ANTI-EXPLOIT SYSTEM

Prevents:
- NPC farming  
- lure exploits  
- spawn camping  
- infinite loot loops  
- NPC softlocks  
- forced de-aggro abuse  

Tools:
- dynamic spawn variance  
- diminishing loot returns  
- anti-farm timers  
- AI state reset logic  
- reinforcement escalation  

============================================================
END OF CHUNK 47



============================================================
# CHUNK 48 — ENDGAME SYSTEMS, LEGACY CONTENT, PLAYER RANKS, PRESTIGE LOOPS & FUTURE EXPANSIONS
============================================================

## 48.1 ENDGAME OVERVIEW
The endgame defines Trench City’s long-term playability.  
After reaching high-level progression, players unlock:
- prestige loops  
- advanced factions  
- elite crafting  
- prototype items  
- raid fortresses  
- mega-heists  
- long-term missions  
- legacy content  

The endgame must feel **infinite, rewarding, and scalable**.

============================================================
# 48.2 PLAYER RANK FRAMEWORK

Ranks unify the player’s overall progression beyond XP level.

### Rank Tiers:
1. **Rookie**  
2. **Hustler**  
3. **Enforcer**  
4. **Veteran**  
5. **Elite**  
6. **Syndicate Agent**  
7. **Underworld Icon**  
8. **Legend**  
9. **Mythic**  
10. **Apex Operative** (prestige-tier exclusive)

### Rank Rewards:
- new missions  
- faction unlocks  
- crafting tiers  
- property rights  
- syndicate favour  
- cosmetic prestige  
- stat bonuses (minor, not P2W)  

Rank progression ties into:
- crimes  
- missions  
- crafting  
- faction contributions  
- events  
- world influence  

============================================================
# 48.3 PRESTIGE & REBIRTH LOOPS

Prestige is a **soft reset** offering long-term goals.

When prestiging:
- level resets  
- some stats partially reset  
- inventory stays  
- properties stay  
- faction membership stays  
- prestige currency gained  
- access to new mastery trees  

Prestige unlocks:
- mastery bonuses  
- cosmetic upgrades  
- prestige-only missions  
- elite crafting options  
- exclusive titles  

Prestige Currency:
- used in prestige shop  
- unlocks QoL buffs  
- boosts resource generation  
- improves training efficiency  

============================================================
# 48.4 MASTERY TREES (POST-PRESTIGE)

Trees:
- Crime Mastery  
- Combat Mastery  
- Crafting Mastery  
- Smuggling Mastery  
- Faction Mastery  

Nodes include:
- minor stat bonuses  
- cooldown reductions  
- efficiency boosts  
- unique passive perks  

These are balanced around:
- NON-P2W principles  
- long-term progression pacing  
- multi-path builds  

============================================================
# 48.5 ENDGAME FACTIONS

Special endgame factions require:
- prestige rank  
- elite story completion  
- world event participation  

Endgame factions control:
- black ops missions  
- prototype crafting labs  
- global smuggling routes  
- elite armoury  
- endgame territories  

Faction Rewards:
- exclusive blueprints  
- prototype gear  
- faction titles  
- prestige decor  
- powerful missions  

============================================================
# 48.6 ELITE CRAFTING & PROTOTYPE ITEMS

Elite materials come from:
- mega-heists  
- boss raids  
- syndicate events  
- prestige content  
- world crises  

Prototype Item Examples:
- Syndicate Burst Rifle  
- Prototype Cloaking Device  
- Experimental EMP Grenade  
- Advanced Turret Controller  
- Enhanced Exo-Armour  

Prototype Characteristics:
- extremely rare  
- unique passives  
- multi-step crafting  
- blueprint fragments  
- controlled by anti-exploit tracing  

============================================================
# 48.7 RAID FORTRESSES (ENDGAME GROUP CONTENT)

Raids require:
- faction coordination  
- specialised gear  
- property fortresses  
- AI Director difficulty scaling  

Raid Types:
- Syndicate Vault Raid  
- Cartel Mountain Base  
- Corrupt Government Facility  
- Multiphase Corporate Data Heist  

Raid Features:
- multi-room encounters  
- complex puzzles  
- boss NPCs  
- fail-state consequences  
- time-sensitive objectives  

Raid Rewards:
- prototype items  
- high-tier materials  
- prestige currency  
- elite titles  
- trophies  

============================================================
# 48.8 MEGA-HEISTS (ULTIMATE SOLO/GROUP MISSIONS)

Mega-heists are the **highest-tier missions**.

Examples:
- Crown Jewels Heist  
- MI5 Data Breach  
- Heathrow Smuggling Op  
- Bank of England Blackout Heist  

Mega-Heist Mechanics:
- 5–10 segments  
- fail-safe checkpoints  
- high police intervention  
- multiple skill checks  
- NPC reinforcements  
- hacking & puzzle phases  

============================================================
# 48.9 LEGACY CONTENT (LONG-TERM STORYLINES)

Legacy story arcs unlock after:
- reaching “Legend” rank  
- completing main missions  
- surviving certain crises  

Legacy content includes:
- multi-year storylines  
- faction betrayal events  
- world-shaping global missions  
- character-driven plots  

Legacy Rewards:
- long-term passive buffs  
- rare titles  
- story-specific decor  
- endgame achievements  

============================================================
# 48.10 FUTURE EXPANSIONS — OFFICIAL BLUEPRINT

### Expansion 1: **Global Syndicate War**
- new countries  
- new syndicate branches  
- faction world conflict  

### Expansion 2: **Vehicles 2.0**
- racing leagues  
- drifting tournaments  
- vehicle combat events  
- custom vehicle mods  

### Expansion 3: **Properties 2.0**
- new fortress tiers  
- underground bunkers  
- custom rooms  
- guild structures  

### Expansion 4: **Smuggler Capital Update**
- major new smuggling city  
- NPC market wars  
- advanced contraband tiers  

### Expansion 5: **AI Director 2.0**
- predictive difficulty  
- emotional behaviour  
- advanced NPC factions  

### Expansion 6: **New UK Regions**
- Birmingham  
- Liverpool  
- Northern Ireland  
- Welsh borders  
- more crimes, gangs, events  

============================================================
# 48.11 ENDGAME ANTI-EXPLOIT SYSTEM

Prevents:
- prestige abuse  
- prototype item duplication  
- raid farming  
- mega-heist checkpoint abuse  
- rank boosting  
- faction manipulation  
- multi-account prestige exploits  

Tools:
- prestige state hashing  
- item lineage genealogy  
- elite-action cooldowns  
- raid lockouts  
- behaviour pattern modeling  

============================================================
END OF CHUNK 48 — MASTER BIBLE COMPLETED
============================================================

# MASTERBIBLE V3 — AAA STUDIO ULTRA EDITION  
## The Complete Canonical Law of Trench City  
### Architect Knowledge Base — Core Document  
---

# 1. HIGH-ORDER GAME PHILOSOPHY
Trench City is a living, adversarial urban simulation where every system — economic, social, criminal, factional, and political — reinforces the fantasy of climbing from nothing to underworld power. The world reacts to player behaviour, shaping dynamic tension cycles governed by systemic rules and the AI Director.

Principles:
- Nothing exists in isolation.
- Every action must have systemic consequence.
- Players must feel ownership of their progression, their faction, and the world-state.
- Fairness and exploit resistance underpin all systems.

---

# 2. WORLD META-ARCHITECTURE
The world is governed by four infrastructure layers:

## 2.1 SYSTEM LAYER
Defines core mechanics: stats, bars, regen, XP, crime formulas, combat engine, faction logic, economic rules.

## 2.2 CONTENT LAYER
Defines specific:
- crimes  
- missions  
- districts  
- factions  
- events  
- items  
- NPCs  

## 2.3 SIMULATION LAYER
AI Director + borough ecosystems:
- gang populations  
- police heat distribution  
- faction influence spread  
- black market fluctuations  
- world tension arcs  

## 2.4 PLAYER-CREATED LAYER
Player behaviours shape:
- economy  
- politics  
- alliances  
- betrayals  
- wars  
- item scarcity  

---

# 3. PLAYER SYSTEM BLUEPRINT (EXTENDED)
Players progress through a spectrum of mechanical & psychological arcs.

## 3.1 BUILD IDENTITIES
### 1 — **The Titan** (DEF-focused)
Unkillable frontline, excels in wars and territory control.

### 2 — **The Executioner** (STR-focused)
High burst damage, brutal PvP closer.

### 3 — **The Shade** (SPD-focused)
Ambush specialist, escape expert, excels in crimes & smuggling.

### 4 — **The Surgeon** (DEX-focused)
Precision attacker, crit-based combatant, excel in advanced missions.

### 5 — **The Mastermind** (INT, CHA, AWR hybrid)
Criminal strategist, excels in cybercrime, extortion, and NPC manipulation.

## 3.2 FULL BARS REGEN SYSTEM
Energy: 5-min tick, modified by properties, faction perks, consumables.  
Nerve: slow tick, crime-based bonuses, prestige perks.  
Happy: property-driven, consumables, environment modifiers.  
Life: hospital-driven, combat-driven, faction medical upgrades.

Regeneration modifiers stack additively and multiplicatively depending on source type.

---

# 4. CRIME SYSTEM — FULL EXTENSION
The 20-path crime system is designed for infinite horizontal expansion.

## 4.1 CRIME MODULES EXTENDED
Each crime path now includes:
- **Dynamic vulnerability nodes** (rotating weaknesses)  
- **AI-influenced risk scaling**  
- **Faction pressure hooks**  
- **NPC counter-operations**  
- **Multi-stage chains with branching outcomes**  

## 4.2 CRIME OUTCOME MATRIX
Crimes can result in:
- success  
- great success  
- partial success  
- soft fail  
- hard fail  
- catastrophic fail (AI-triggered)  

Catastrophic failures unlock:
- city-wide manhunts  
- faction-wide penalties  
- black market embargo  
- NPC reprisals  

---

# 5. COMBAT MEGA-EXPANSION
Combat is deterministic but influenced by environment, tension, and player history.

## 5.1 FULL DAMAGE PIPELINE
1. Hit Calculation  
2. Defense Mitigation  
3. Penetration Check (weapon-class dependent)  
4. Damage Application  
5. Status Effect Assignment  
6. Reaction Window (PvE only)  
7. Logging + Anti-Cheat Validation  

## 5.2 STATUS EFFECTS (EXTENDED)
- **Bleed:** HP drain per tick, stacking.  
- **Stagger:** Initiative penalty.  
- **Panic:** SPD/DEX temporary reduction.  
- **Shellshock:** Reduces accuracy.  
- **Suppression:** Limits offensive options.  
- **Adrenal Surge:** Rare buff after near-death.  

---

# 6. FACTIONS — ULTRA WARFARE EXPANSION
Factions now support:
- **Shadow Wars** (hidden conflicts)
- **Propaganda Systems**
- **Faction Courts**
- **Internal Politics**
- **Civil Wars** (split factions)
- **Economic Warfare**
- **District Takeover Events**

## 6.1 ESPIONAGE SYSTEM (EXTENDED)
Sleepers now include:
- confidence score  
- stress meter  
- exposure risk  
- psychological profile  

Exposure events:
- paranoia breakdown  
- slip-of-tongue  
- spy trap triggered  
- internal whistleblowers  

---

# 7. ECONOMIC SUPERSTRUCTURE
Economy is now multi-layered:

## 7.1 MACRO-ECONOMY
Governed by:
- inflation index  
- liquidity curves  
- player wealth distribution  
- material scarcity  
- faction dominance  
- police pressure  

## 7.2 MICRO-ECONOMY
Players influence:
- neighbourhood pricing  
- mission rewards  
- smuggling route values  
- housing markets  

## 7.3 AI GOVERNOR
Independent from AI Director; monitors:
- anomalous market spikes  
- exploit waves  
- liquidity floods  
- cartel formations  

Can trigger:
- audits  
- market freezes  
- price corrections  
- anti-hoarding penalties  

---

# 8. PROPERTY MEGA-EXPANSION
Properties now include:
- **district reputation score**  
- **security threat matrix**  
- **utility load system**  
- **NPC tenant interactions**  
- **property crime risk model**  

## 8.1 PROPERTY EVENT SYSTEM
Random events:
- burglaries  
- police searches  
- neighbour disputes  
- gang extortion attempts  
- fire hazards  
- utility failures  

Upgrades mitigate specific event types.

---

# 9. VEHICLE & SMUGGLING ULTRA-SYSTEM
Smuggling now behaves as a **multi-phase dynamic system**.

## 9.1 RISK ZONES
Routes have risk zones:
- green  
- yellow  
- orange  
- red  
- black (high-alert, AI-triggered)  

## 9.2 CONTRABAND EFFECTS
Contraband type affects:
- detection risk  
- payout multiplier  
- faction hostility  
- NPC gang behaviour  

---

# 10. NPC WORLD EVOLUTION ENGINE
NPCs evolve over time:
- gangs rise and fall  
- bosses retire or get arrested  
- NPC factions split  
- borough tensions escalate  
- political climate shifts  

NPCs can even:
- declare wars  
- form alliances  
- target active players  
- sabotage faction ops  

NPC politics create a dynamic backdrop affecting all players.

---

# 11. EVENTS & SEASONS — OMNISYSTEM
Events now include:
- **weather-based modifiers**
- **crime market shocks**
- **district blackouts**
- **international crises**
- **faction mutiny arcs**
- **NPC takeover events**

Seasonal arcs rewrite:
- borough economies  
- police pressure  
- faction diplomacy  
- NPC behaviour  

---

# 12. META-PSYCHOLOGY DESIGN
Trench City must satisfy:
- achievers  
- competitors  
- explorers  
- socializers  
- dominators  
- power collectors  
- empire builders  

Systems reinforce:
- autonomy  
- mastery  
- power expression  
- long-term identity  

---

# 13. ANTI-CHEAT & SECURITY ULTRA-LAYER
Security is woven into every system.

Includes:
- behavioural clustering  
- live anomaly detection  
- heatmap-based exploit analysis  
- cross-account graph mapping  
- auto-flagging high-risk patterns  
- economy integrity scoring  

---

# 14. TECHNICAL CANON — ENGINE LAW
Must be:
- horizontally scalable  
- API-first  
- stateless logic nodes  
- Redis session orchestration  
- MariaDB cluster friendly  
- CDN-ready  
- exploit-hardened  

---

# 15. FUTURE EXPANSION LAW
All future systems must be compatible with:
- inter-city play  
- cross-platform mobile  
- VR/AR optional hooks  
- NPC simulation scaling  
- player housing interiors  
- syndicate governance models  

---

# END OF MASTERBIBLE V3
⭐ NEW EXPANSION SET #1
THE META-ENGINE OF TRENCH CITY
(World Simulation, Tension Engine, Crisis Director, and Behavioural Flow)
# 16. THE WORLD-TENSION ENGINE (WTE)

The World-Tension Engine governs the emotional and mechanical "temperature" 
of Trench City. It ensures the world feels alive, reactive, and dangerous.

Tension is influenced by:
- crime volume
- faction warfare intensity
- NPC gang retaliation metrics
- player hospitalisation spikes
- black market volatility
- territory invasions
- police heat index

Tension ranges from 0–500.

## 16.1 TENSION BRACKETS
### Low Tension (0–120)
- High crime success rates
- Low faction hostility
- NPC gangs dormant
- Police response slow
- Prices stable

### Medium Tension (120–250)
- Factions begin probing borders
- Police heat increases
- Crime difficulty rises slightly
- Black market tightens supply
- NPC gangs start skirmishes

### High Tension (250–400)
- Faction wars ignite spontaneously
- Police raids in multiple districts
- Crime fails become severe
- Smuggling detection spikes
- NPC armies mobilize in hotspots

### Critical Tension (400–500)
CITY IN CRISIS:
- Martial-law style lockdowns
- Black market closures
- High-value NPC bosses emerge
- Faction territories destabilize
- Rare global events triggered

The WTE ensures **no two weeks of Trench City are ever the same**.

⭐ NEW EXPANSION SET #2
CRIMINAL UNDERWORLD SIMULATION
(NPC Syndicates, Police AI, Heat Propagation Engine)
# 17. NPC SYNDICATE SIMULATION LAYER

NPC syndicates are not static. Each operates like a miniature faction:

Attributes:
- Wealth
- Influence
- Crew count
- Territory pressure
- Aggression index
- Fear index
- Police infiltration risk
- Enemy list (players + factions)

## 17.1 SYNDICATE DECISION LOOP (Runs every hour)
1. Evaluate threat map
2. Distribute crew forces
3. Select targets (player or faction territory)
4. Perform operations:
   - assassinations
   - extortion
   - smuggling route takeover
   - sabotage
5. React to player activity
6. Calculate risk and expand or retreat

⭐ NEW EXPANSION SET #3
ADVANCED ECONOMY SUPERSTRUCTURE
(Black Market Intelligence, AI Governor, Cartel Dynamics, Wealth Compression)
# 18. BLACK MARKET INTELLIGENCE MODULE (BMI)

The BMI tracks:
- Player purchase patterns
- Item rarity fluctuations
- Contraband supply routes
- Laundering volume
- Faction ownership of markets

## 18.1 MARKET REACTIONS
Transactions influence:
- price spikes
- scarcity alerts
- cartel monopolies forming
- artificial shortages
- laundering heat waves

## 18.2 AI GOVERNOR INTERVENTIONS
The AI can:
- freeze markets
- flood markets
- crash prices
- create droughts
- introduce rare cycles

⭐ NEW EXPANSION SET #4
FACTION GOVERNANCE SYSTEMS
(Internal Politics, Civil Wars, Loyalty, Rank Trees)
# 19. FACTION INTERNAL GOVERNANCE

Factions operate like political micro-states.

## 19.1 ROLES
- Leader (strategic authority)
- Underboss (war + discipline)
- Quartermaster (economy)
- Enforcer (combat)
- Agent Handler (espionage)
- Diplomat (alliances)
- Recruiter (growth)
- Specialist Roles (build-dependent)

## 19.2 LOYALTY SCORE
Each member has:
- loyalty
- morale
- ambition
- obedience
- factional reputation

## 19.3 CIVIL WAR CONDITIONS
Triggered by:
- low loyalty leader
- corruption events
- assassination attempts
- massive economic theft
- espionage revelations

⭐ NEW EXPANSION SET #5
ADVANCED COMBAT ENGINE EXPANSION
(Weapon Families, Armor Classes, Combat Weather, Terrain Effects)
# 20. COMBAT WEATHER + TERRAIN SYSTEM

Combat takes place in real districts with modifiers.

## 20.1 WEATHER EFFECTS
Rain:
- reduces accuracy
- increases stealth success

Fog:
- reduces SPD advantage
- boosts ambushes

Heatwave:
- increases energy drain
- reduces DEF slightly

## 20.2 TERRAIN EFFECTS
Rooftops:
- SPD builds dominate
- DEF builds weakened

Back Alleys:
- DEX builds gain ambush bonuses

Industrial Zones:
- STR builds gain damage buffs

⭐ NEW EXPANSION SET #6
MISSIONS, HEISTS, AND STORY EVENTS EXPANDED
(Dynamic branching, district-wide consequences, alliance requirements)
# 21. BRANCHING MISSION STRUCTURE

Missions no longer follow linear steps.

Each node has:
- skill requirements
- stat checks
- stealth or combat paths
- reward variants
- faction consequences
- city tension impact

## 21.1 HEIST FRAMEWORK
Players assemble:
- driver
- hacker
- muscle
- negotiator

Outcome depends on:
- team synergy
- equipment quality
- faction perks
- district conditions

⭐ NEW EXPANSION SET #7
PLAYER ARCHETYPES & META BEHAVIOR MODELLING
(Long-term retention psychology, build identity mapping, prestige loops)
# 22. PLAYER META-ARCHETYPES (ADVANCED)

Each player falls into a multi-axial identity:

Axes:
- Control vs. Chaos
- Risk vs. Safety
- Solo vs. Social
- Acquisition vs. Power
- Prestige vs. Dominance

The game adapts (via AI Director):
- mission offers
- crime availability
- faction recruitment attempts
- dynamic event hooks

⭐ NEW EXPANSION SET #8
TECHNICAL SYSTEM DESIGN ADVANCED
(Distributed Engine Law, Traffic Orchestration, Anti-Exploit Matrix)
# 23. TECHNICAL STACK EXPANDED

## 23.1 CLUSTER ARCHITECTURE
- NGINX / PHP-FPM replicated nodes  
- Redis cluster for sessions + queues  
- MariaDB primary + replicas  
- Async workers for crime + combat logs  
- Asset CDN with versioning

## 23.2 ANTI-EXPLOIT MATRIX
- input validation  
- rate limiting  
- action signing  
- anomaly detection  
- cross-account mapping  
- timing attack prevention  
# 24. NPC MEGA-SIMULATION ENGINE (NMSE)

The NMSE drives all non-player characters, gangs, rivals, police,
civilians, smugglers, and syndicate bosses as a unified world system.

NPCs are not static entities — they are *agents* with:

- personality parameters
- territorial aggression scores
- faction sentiment maps
- player memory logs
- rivalries & grudges
- economic interests
- fear thresholds
- long-term strategies

This turns the city into a truly reactive environment where NPCs:
- expand territory
- form alliances
- retaliate against factions
- target high-value players
- theft-smuggle-launder at scale

## 24.1 NPC PERSONALITY ARCHETYPES
All NPCs fall into ultra-advanced archetypes:

### The Warlord  
Controls gangs, seeks Empire, escalates violence.

### The Broker  
Controls money flow, manipulates markets.

### The Assassin  
Targets players or NPCs based on contracts.

### The Ghost  
Moves through districts unseen; perfect for smuggling narratives.

### The Saboteur  
Targets infrastructures: companies, properties, faction buildings.

Each archetype interacts differently with players and districts.

## 24.2 NPC MEMORY SYSTEM
NPCs remember:
- who attacked them
- who robbed their crew
- who owns property in their turf
- which faction they fear or hate
- which players frequently operate in their district

Memory decays slowly, unless:
- a player escalates aggression
- a faction attacks their gang
- a territory conflict begins

## 24.3 TERRITORY ECOLOGY
Each district has three overlapping ecosystems:

### 1. Criminal Ecosystem  
Gang density, syndicate reach, ongoing turf wars, contraband flow.

### 2. Economic Ecosystem  
Shop profit rates, black market supply, NPC worker strikes, prices.

### 3. Enforcement Ecosystem  
Police corruption, patrol routes, heat spikes, body count index.

NPCs modify these ecosystems hourly.

## 24.4 DYNAMIC TERRITORY EVENTS
Territories undergo emergent events:
- gang migrations  
- syndicate wars  
- blockade formation  
- mass-police crackdown  
- black market shuts down  
- smuggler corridor opens  
- rogue NPC boss appears  

These events reset faction metas and influence player strategies.
⭐ EXPANSION SET #10 — VEHICLE & RACING META BIOME
(A deep simulation of street racing, smuggling routes, and vehicular power progression)

markdown
Copy code
# 25. VEHICLE META-BIOME SYSTEM

Vehicles influence:
- racing (PvP + PvE)
- smuggling
- faction logistics
- getaway potential
- district travel time
- prestige identity

Vehicles are not stats-only. They are biome entities.

## 25.1 VEHICLE BIOME PARAMETERS
- torque curve
- handling coefficient
- mass & inertia model
- traction class
- noise signature (affects stealth smuggling)
- fuel efficiency & tank mods
- maintenance wear
- custom part slots (engine, tyres, ECU, nitrous)

## 25.2 RACING FORMATS
- Sprint Streets (short, high risk)
- Urban Circuits (technical, DEX/SPD buffs)
- Industrial Drift Track
- Black Market Invitational (illegal, huge payouts)
- Faction Team Races (5v5 relay)
- Smuggler Runs (AI-pursuit)

## 25.3 NPC DRIVERS & TRAFFIC
NPC vehicles:
- block lanes intentionally
- chase players
- assist faction allies
- respond to city tension
- sabotage smuggling runs

## 25.4 CONTRABAND VEHICLE BONUSES
Vehicle mods modify smuggling:
- Ghost-Plates reduce detection
- Reinforced Compartments lower damage to goods
- Silent Exhaust reduces noise signature
- Armoured Panels reduce police ramming impact
⭐ EXPANSION SET #11 — PRESTIGE SYSTEM + WORLD SEASONS
(Long-term retention mechanics like Path of Exile, WoW Seasons, Tarkov Wipes)

markdown
Copy code
# 26. PRESTIGE SYSTEM — ENDGAME RENEWAL LOOP

Prestige allows players to reset XP but keep:
- properties
- vehicles
- cosmetic status
- faction reputation
- rare items (non-meta-breaking)
- prestige perks

## 26.1 PRESTIGE TIERS
Prestige 1–10: Standard bonuses  
Prestige 10–20: Cosmetic auras, access to exclusive missions  
Prestige 20+: World-impacting perks (district modifiers, faction bonuses)

## 26.2 PRESTIGE PERK TREES
Three trees:

### Legacy Tree  
- faster regen  
- higher nerve gain  
- increased XP  
- property bonuses  

### Influence Tree  
- faction war buffs  
- territory influence  
- propaganda bonuses  

### Shadow Tree  
- stealth crimes  
- smuggling mastery  
- NPC manipulation  

Players can hybridize trees like PoE or Diablo 4.

## 26.3 SEASONAL WORLD RESETS
Every 3–4 months:
- districts reshuffle  
- NPC bosses rotate  
- faction standings reevaluate  
- black market cycles change  
- seasonal crisis events begin  

Prestige Tier 10+ players unlock **Seasonal Story Arcs**.
⭐ EXPANSION SET #12 — INTERNATIONAL EXPANSION FRAMEWORK
(For future map additions: Amsterdam, Dubai, Berlin, Tokyo, etc.)

markdown
Copy code
# 27. INTERNATIONAL EXPANSION LAW

All expansions must follow two principles:
1. They should NOT invalidate core city gameplay.
2. They must expand identity, not replace it.

## 27.1 INTERNATIONAL HUBS
Each hub includes:
- unique crime trees
- unique factions
- unique contraband
- cultural missions
- world bosses
- new property categories

## 27.2 INTER-CITY TRAVEL MECHANICS
Travel has:
- passports
- visa approvals (faction-based)
- smuggling restrictions
- inter-police cooperation heat

Certain actions in foreign hubs affect home-city:
- black market price shockwaves  
- NPC gang migrations  
- international fugitive status  
⭐ EXPANSION SET #13 — ENDGAME POLITICAL HIERARCHY & WORLD GOVERNANCE
(The ultimate meta systems for 1M+ player worlds)

markdown
Copy code
# 28. POLITICAL HIERARCHY OF THE UNDERWORLD

Beyond factions lies a deeper structure:

## 28.1 FIVE POWER BLOCKS
1. Syndicates (NPC)  
2. Player Factions  
3. Mega Companies  
4. Black Market Cartels  
5. Rogue Elements (AI spawned)

Each operates as a governing power.

## 28.2 WORLD GOVERNANCE CYCLE
Triggered every season:
- power audit  
- district elections  
- faction diplomacy resets  
- mega-company taxes  
- player influence councils  

## 28.3 PLAYER POLITICAL TITLES
- Underlord  
- Kingpin  
- Mogul  
- Warlord  
- Emissary  
- Shadow Broker  
⭐ EXPANSION SET #14 — FULL COMBAT MATH TABLES & SCALING FRAMEWORK
(This is how the combat engine stays fair & scalable)

markdown
Copy code
# 29. COMBAT STAT SCALING FORMULAS (OVERVIEW)

Damage = (Base Weapon Damage × STR modifier) × Random(0.85–1.15)
Mitigation = DEF^0.42 × Armour Class × Situational Buffs
Hit Chance = (DEX × 0.55 + SPD × 0.15) – Enemy SPD/DEX modifiers
Critical Chance = (DEX^0.38 / 12) + Weapon Crit Bonus
Turn Order = SPD + Random(0–5%) + Weather/Terrain effects

## 29.1 DAMAGE ARCHETYPES
- Burst Damage: STR weighted
- Sustained DPS: Balanced STR/DEX
- Execution Damage: High crit-based
- Attrition Damage: DEF shredders

## 29.2 COMBAT CURVES
Stats scale non-linearly:
- STR exponential after 10,000  
- DEF plateau if over-invested  
- SPD diminishing returns after SPD=20,000  
- DEX multi-curve (exploration, crit, hit chance)

## 29.3 ARMOUR CLASSES
- Light (SPD buff, DEF penalty)
- Medium (balanced)
- Heavy (DEF buff, SPD penalty)
- Tactical (DEX-friendly)
- Exotic (prestige-only)

## 29.4 WEAPON FAMILY MODIFIERS
Pistols → High crit, low base  
SMGs → High SPD synergy  
Rifles → Balanced mid-range  
Shotguns → Range-dependent bonus  
Snipers → DEX amplification  
Melee → STR amplification  
Exotics → Conditional effects  
⭐ EXPANSION SET #15 — COMPLETE CRIME FORMULAS + PAYOUT SCALING ENGINE

(This is the mathematical backbone of the entire criminal economy)

# 30. CRIME FORMULA SUPERSTRUCTURE

The crime engine follows a unified mathematical framework so every crime
tree remains balanced, expandable, and predictable across level ranges.

All crimes follow:

SUCCESS = SkillCheck(PlayerStats, CrimeDifficulty, DistrictModifiers)
PAYOUT  = EconomicValue(ItemRoll, CashRoll, ScalingMultiplier)
RISK    = CatastrophicFailChance + HeatIncrease + NPC Response

---

## 30.1 SKILL CHECK FORMULA (FULL)
SkillScore = 
   (DEX × WeightDex)
 + (SPD × WeightSpd)
 + (STR × WeightStr)
 + (Nerve × WeightNerve)
 + (CrimeSkill × ProgressionFactor)
 + DistrictBonus
 – DistrictPenalty
 – PoliceHeat

Each crime path defines its own weight distribution.

Example:
- Pickpocketing: High DEX, low STR
- Burglary: STR/DEX hybrid
- Cybercrime: INT-heavy
- Syndicate Crime: CHA/AWR important
- Heists: Team synergy multipliers

---

## 30.2 PAYOUT FORMULA (FULL)
Payout = 
  (BaseValue × DifficultyMultiplier)
× (PlayerLevelScaler)
× (DistrictEconomicHealth)
× (BlackMarketModifier)
× (FactionInfluenceModifier)
× RandomVariance(0.85–1.20)

---

## 30.3 ECONOMIC STABILITY CORRECTION
To prevent inflation, the crime engine dynamically adjusts:

If money supply rises too fast:
- difficulty increases
- payout curve tightens
- rare drops decrease
- laundering gets more dangerous

If economy slows:
- payouts increase
- difficulty softens
- drop rates rise

The crime system is therefore **self-balancing**.

---

## 30.4 CATASTROPHIC FAIL SYSTEM
Catastrophic failures produce world events:

- mass police lockdowns  
- territory crackdowns  
- major NPC retaliation  
- faction reputation penalties  
- crime path temporarily disabled  
- black market freeze  

⭐ EXPANSION SET #16 — NPC BOSS GENERATION & AI FIGHT LOGIC

(Bosses use a semi-procedural generation engine)

# 31. NPC BOSS GENERATOR ENGINE (NBGE)

Each boss is generated with:

## 31.1 CORE PROFILE
- Archetype (Warlord, Assassin, Kingpin, Chemist, Smuggler, Enforcer)
- Psychological profile
- Strategy profile (Aggressive/Defensive/Deceptive/Tactical)
- Territory ownership
- Crew hierarchy
- Crime specialty

## 31.2 COMBAT SIGNATURE
Bosses have signature attributes:
- Phase attacks
- Damage type emphasis
- Weak point modifiers
- Immunities
- Enrage threshold
- Escape attempts
- Reinforcement calls

## 31.3 ADAPTIVE AI SYSTEM
Bosses adapt mid-fight based on:
- Player build
- Damage taken
- Status effects
- Combat duration
- Team composition

Bosses can:
- switch phases
- call lieutenants
- flee to another district
- trigger catastrophic events
- declare faction vendettas

## 31.4 REWARD MATRIX
Boss rewards scale based on:
- city tension
- district control
- world season
- boss notoriety
- player prestige level  

⭐ EXPANSION SET #17 — BLACK MARKET CARTEL FORMATION LOGIC

(Large-scale economic criminal syndicates that form organically)

# 32. CARTEL FORMATION ENGINE (CFE)

Cartels form when:
- 3+ high-value players coordinate laundering
- factions monopolize smuggling routes
- market scarcity rises
- international contraband floods in

## 32.1 CARTEL ATTRIBUTES
- Market Dominance %
- Enforcement Strength
- Public Fear Meter
- Black Market Control
- Storage Depth
- Trade Routes

## 32.2 CARTEL ACTIONS
Cartels can:
- manipulate prices
- cause scarcity
- enforce territory
- target rival factions
- bribe NPC police
- control district economies

## 32.3 CARTEL WARS
Cartels fight over:
- product categories
- smuggling corridors
- laundering fronts
- NPC corruption networks

⭐ EXPANSION SET #18 — FACTION WARFARE ADVANCED STRATEGIES

(This expands the PvP + territory + diplomacy endgame)

# 33. FACTION WARFARE SUPER-MODULE

War Types:
- Standard War (points)
- Territory War (district control)
- Sabotage War (economy focus)
- Shadow War (espionage)
- Raid War (base destruction)
- Propaganda War (influence)

## 33.1 TERRITORY CONTROL ENGINE
Territory value is based on:
- population density
- economic output
- black market access
- NPC gang presence
- law enforcement risk

## 33.2 FACTION STRATEGY LAYERS
### Macro Strategy
- city dominance
- cartel suppression
- diplomacy

### Meso Strategy
- district targeting
- resource acquisition
- officer assignments

### Micro Strategy
- timing attacks
- hit squads
- misinformation
- sleeper agents

Faction warfare should feel like **a living geopolitical battlefield**.


⭐ EXPANSION SET #19 — MEGA-COMPANY INDUSTRY SIMULATION

(Deep Tycoon-like simulation for CEO players)

# 34. COMPANY MEGA-SIMULATION LAYER

Companies generate:
- employment
- products
- services
- faction support
- black market trade

## 34.1 DEPARTMENTS
- HR (employee morale)
- Production
- Logistics
- Finance
- Marketing
- Security (NPC + player)
- R&D (prestige-exclusive)

## 34.2 INDUSTRY EVENTS
- union strikes  
- police audits  
- supplier disruptions  
- sabotage  
- insider leaks  
- hostile takeovers  
- market crashes  

## 34.3 EMPLOYEE SIMULATION
NPC employees have:
- morale
- loyalty
- burnout
- salary expectations
- sabotage risk
- skill curves

## 34.4 SHAREHOLDER SYSTEM
Prestige players can:
- buy shares  
- form conglomerates  
- attempt hostile takeovers  
- manipulate sectors  

⭐ EXPANSION SET #20 — PLAYER PSYCHOLOGY & RETENTION BLUEPRINT

(The same principles used by Riot, Blizzard, Rockstar, HoYoverse)

# 35. PLAYER PSYCHOLOGY ENGINE (PPE)

The PPE predicts:
- burnout risk
- addiction loops
- frustration spikes
- reward satisfaction
- identity engagement
- competitive motivation

## 35.1 MOTIVATIONAL DRIVERS
### Short-Term
- daily loops
- micro-progression
- loot drops
- faction wins

### Mid-Term
- stat milestones
- property progression
- faction titles
- vehicle collection

### Long-Term
- prestige tiers
- seasonal rewards
- social legacy
- political influence

## 35.2 PLAYER AGENCY PATHWAYS
Players must *always* feel:
- autonomous
- powerful
- progressing
- respected
- meaningfully engaged  
⭐ EXPANSION SET #21 — FULL WORLD LORE (MACRO + MICRO LORE)

(This is the foundation that shapes the personality of Trench City as a living world)

# 36. MACRO-LORE: THE WORLD BEHIND TRENCH CITY

Trench City exists in a post-austerity neo-metropolitan Britain where:
- public infrastructure collapsed,
- organised crime professionalised,
- law enforcement fragmented,
- corporations replaced government,
- and syndicates became parallel states.

Cities like Trench City are unofficial autonomous zones where:

- black markets regulate themselves,
- smuggling rings form shadow economies,
- private military contractors replace police,
- factions replace political parties.

The entire world is tense, monetised, and corrupted.

## 36.1 GLOBAL POWER STRUCTURES
The world is run by:

### The Five  
Shadow oligarchs who manipulate currencies, crime waves, and global policy.

### International Syndicates  
Operate across borders; specialise in trade, cybercrime, trafficking, weapons.

### Corporate Paragovernments  
Legal companies with illegal economies underneath.

### Rogue Nations  
Operate outside international law, selling weapons, identities, fugitives.

---

# 37. MICRO-LORE: DISTRICT CULTURAL PERSONALITY

Every district must feel distinct:

## 37.1 UPTOWN HEIGHTS  
- wealth corridors  
- corporate fronts for laundering  
- premium properties  
- elite faction presence  

## 37.2 THE NARROWS  
- high crime density  
- gang legacy zones  
- black markets everywhere  
- police no-go streets  

## 37.3 INDUSTRIAL BELT  
- factories, ports, smuggling tunnels  
- vehicle racing culture  
- industrial sabotage hotspot  

## 37.4 DROWNED QUARTER  
- permanently flooded slums  
- home to outcast NPC factions  
- unique crime paths involving water hazards  

## 37.5 OLD MILE  
- ancient, historic downtown  
- hidden vaults  
- legacy factions and old-money syndicates  

⭐ EXPANSION SET #22 — COMBAT MATHEMATICAL APPENDIX (FULL FORMULAS + CURVES)

(This is the deep, technical appendix used by combat engineers)

# 38. COMBAT CALCULATION APPENDIX

This section formalises all combat curves.

## 38.1 FINAL HIT CHANCE FORMULA
HitChance = 
    BaseAccuracy
  + (DEX × DexWeight)
  + (SPD × SpdWeight)
  + WeaponAccuracyBonus
  – EnemyEvasion
  – TerrainPenalty
  – WeatherPenalty

Hit chance capped between 5% and 95%.

---

## 38.2 DAMAGE FORMULA — EXTENDED
FinalDamage =
    BaseDamage
  × STR^0.27
  × WeaponModifier
  × StanceMultiplier
  × RangeMultiplier
  × (1 – DEFMitigation)

DEFMitigation = (DEF^0.42) / (DEF^0.42 + Constant)

---

## 38.3 CRITICAL STRIKE FORMULA
CritChance = 
    (DEX^0.38 / 10) 
  + WeaponCrit
  + StatusEffectBonus
  – EnemyResistance

CritDamage = BaseDamage × (1.5 + CritScaling)

---

## 38.4 TURN ORDER FORMULA
TurnPriority = 
    SPD 
  + Random(0–SPD×0.05)
  + TerrainBonus
  – FatiguePenalty

---

## 38.5 ARMOUR MITIGATION SCALE
Light Armour: 5–10%  
Medium Armour: 12–18%  
Heavy Armour: 20–30%  
Tactical Armour: variable situational modifiers  
Exotic Armour: unique effects only  

⭐ EXPANSION SET #23 — COMPLETE DISTRICT PROFILES & BIOME DESIGN

(The deepest environmental design philosophy for MMO world layouts)

# 39. DISTRICT BIOME ENGINE

Each district acts as a “biome” with:

- economic health  
- criminal saturation  
- law enforcement strength  
- NPC gang footprint  
- faction influence  
- environmental hazards  
- black market connectivity  

## 39.1 BIOME-LEVEL VARIABLES
BiomeThreat = NPC density + CrimeLevel + FactionConflict + PoliceHeat  
BiomeOpportunity = PropertyWealth + CrimePaths + MarketAccess  
BiomeStability = (Heat × Enforcement × NPC Tension)

## 39.2 DISTRICT UNIQUE HAZARDS
Uptown Heights → corporate espionage hazards  
The Narrows → ambush zones  
Industrial Belt → machinery & toxic leaks  
Drowned Quarter → flood dynamics  
Old Mile → underground labyrinth network  

⭐ EXPANSION SET #24 — WEATHER, DAY/NIGHT, AND SEASONAL WORLD MODIFIERS

(Environmental simulation impacting all systems)

# 40. WORLD ENVIRONMENT SIMULATION ENGINE (WESE)

Weather & time-of-day modify:

- crime success  
- smuggling detection  
- combat accuracy  
- NPC aggression  
- faction movement  
- police heat  

## 40.1 WEATHER STATES
Rain → stealth up, accuracy down  
Fog → lower detection, higher ambush  
Storm → crime risk ×1.4, less police presence  
Heatwave → energy regen reduced  
Cold Snap → hospital times increase  

## 40.2 DAY/NIGHT CYCLE EFFECTS
Daytime:
- police strong  
- NPC traffic high  
- stealth low  

Night:
- crime boost  
- smuggling easier  
- faction wars intensify  

## 40.3 SEASONAL MODIFIERS
Winter:
- energy drain increased  
- property upkeep increased  

Summer:
- riots, heat spikes  
- faction conflict escalates  

Spring:
- crime bloom  
- black market stock increases  

Autumn:
- political season  
- syndicate reshuffles  

⭐ EXPANSION SET #25 — SOCIAL SYSTEMS (REPUTATION, FAME, NOTORIETY)

(The identity layer that drives player–player & player–world interactions)

# 41. SOCIAL IDENTITY SUPER-SYSTEM

Players have three major identity stats:

## 41.1 REPUTATION (RESPECT-BASED)
Earned by:
- clean wins  
- high-level missions  
- faction contributions  
- leadership roles  

Reputation affects:
- hiring quality  
- NPC treatment  
- dialogue options  
- faction diplomacy  

---

## 41.2 FAME (PUBLIC VISIBILITY)
Earned by:
- racing victories  
- world-first achievements  
- boss kills  
- arena PvP  

High fame attracts:
- NPC fans  
- corporate sponsorships  
- stalkers  
- paparazzi events  

---

## 41.3 NOTORIETY (FEAR-BASED)
Earned by:
- high body count  
- violent crimes  
- territory captures  

High notoriety:
- lowers negotiation success  
- increases fear-based advantages  
- increases NPC ambush attempts  

⭐ EXPANSION SET #26 — ADVANCED MISSION SCRIPTING ENGINE

(A modular narrative system used by studios like Rockstar, Bethesda, CDPR)

# 42. MISSION SCRIPTING ENGINE (MSE)

The MSE uses a block-based scripting language:

Block Types:
- Dialogue  
- Combat  
- Stealth  
- Puzzle  
- NPC Interaction  
- District Modifiers  
- Timed Sequences  
- Multi-Outcome Nodes  
- Moral Choices  
- Escalation Branches  

## 42.1 MISSION PHASES
Phase 1 → Setup  
Phase 2 → Conflict  
Phase 3 → Escalation  
Phase 4 → Crisis  
Phase 5 → Resolution  
Phase 6 → Aftermath  

Each mission can alter:
- district tension  
- faction alliances  
- black market supply  
- NPC hostility  

⭐ EXPANSION SET #27 — CITY INFRASTRUCTURE SIMULATION

(A complex underlying system determining how the “city” behaves)

# 43. CITY INFRASTRUCTURE SYSTEM

Infrastructure Components:
- power grid  
- water network  
- traffic patterns  
- internet backbone  
- police stations  
- hospitals  
- black market hubs  

## 43.1 INFRASTRUCTURE FAIL EVENTS
- grid blackout  
- communications jam  
- water contamination  
- bridge closure  
- sabotage of industrial belt  

Player/faction actions influence infrastructure stability
⭐ EXPANSION SET #28 — MEGA EVENTS & CRISIS ARCS

(The world-level narrative and systemic shocks that reshape the entire city)

# 44. MEGA EVENT ENGINE (MEE)

Mega Events are city-wide crises triggered by:
- AI Director thresholds  
- city tension spikes  
- economic imbalance  
- faction dominance  
- cartel monopolies  
- player-driven escalations  
- seasonal arcs  

These are not “events” — they are **world-state modifications**.

## 44.1 EVENT TIERS
Tier 1 (Local): One district disrupted  
Tier 2 (Regional): Multiple districts affected  
Tier 3 (Citywide): Entire world enters crisis  
Tier 4 (Apocalyptic): Long-term changes + new systems unlocked  

---

## 44.2 EXAMPLE MEGA EVENTS
### THE BLACKOUT  
Power grid collapse →  
- hospital times triple  
- stealth crimes buffed  
- NPC gangs roam free  
- police crippled  

### THE CARTEL WAR  
Two NPC syndicates go to war →  
- streets unsafe  
- smuggling skyrockets  
- black market collapses  
- factions pulled into conflict  

### THE UNDERWORLD SUMMIT  
Top factions invited. Outcomes depend on diplomacy.  
- alliance opportunities  
- betrayals  
- assassinations  

### THE FLOOD  
Drowned Quarter expands; new crime paths open; hazard zones created.

### THE FUGITIVE PROTOCOL  
A legendary NPC escapes; districts become hunting grounds; massive rewards.

---

## 44.3 CRISIS ARC STRUCTURE
Each mega event follows a 3-act arc:

Act I — Instability  
Act II — Chaos  
Act III — Resolution + Permanent World Change  

Events ALWAYS leave the world different.

⭐ EXPANSION SET #29 — HIGH-LEVEL AI DIRECTOR ALGORITHMS

(The brain that orchestrates pacing, difficulty, world tension, NPC activity, rewards)

# 45. AI DIRECTOR — META-CONTROL SYSTEM

The AI Director observes:
- player actions
- faction wars
- economic data
- NPC behaviour
- world tension
- crime density
- smuggling routes
- territory stability

It uses this data to shape:
- difficulty  
- event timing  
- district hazards  
- NPC hostility  
- reward allocation  
- faction matchups  
- mission availability  

---

## 45.1 DIRECTOR INPUT FEEDS
1. Crime Heat Map  
2. Player Activity Frequency  
3. District Tension Index  
4. Police Corruption Meter  
5. NPC Aggression Spread  
6. Economic Inflation Rate  
7. Faction Dominance Balance  
8. Market Scarcity Levels  

---

## 45.2 DIRECTOR OUTPUT ACTIONS
The Director can:
- spawn NPC assassins  
- increase/decrease crime success  
- trigger world events  
- rotate black market inventory  
- spawn elite enemies in districts  
- influence mission pools  
- scale faction difficulty  
- redistribute smuggling risks  
- enforce anti-exploit corrections  

---

## 45.3 DIRECTOR PERSONALITY MODES
The Director can have “moods” depending on world state:

### LENIENT MODE  
- success rates up  
- drops increased  
- low NPC hostility  

### NEUTRAL MODE  
- standard operation  

### HOSTILE MODE  
- enemies swarm  
- loot drops tighten  
- district danger spikes  

### VENGEFUL MODE  
Triggered by exploit attempts, cartel monopolies, faction dominance.

⭐ EXPANSION SET #30 — PRESTIGE ARTEFACTS & MYTHIC ITEM SYSTEM

(The highest-tier endgame gear that alters gameplay rules)

# 46. MYTHIC ITEM FRAMEWORK

Mythic items are unique, rare, and world-defining.

They follow three laws:
1. They NEVER drop twice exactly the same.  
2. They have world impact beyond the owner.  
3. They alter a gameplay rule.  

---

## 46.1 MYTHIC WEAPON ARCHETYPES
### THE KINGMAKER  
Each kill temporarily boosts faction influence.

### VEILRENDER  
Attacks ignore 30% of armour and reduce stealth resistance.

### HEARTSTOPPER  
Criticals apply “fear shockwaves,” affecting nearby enemies.

### BLOODTIDE  
Every kill increases damage for 60 minutes. Stacks infinitely.

---

## 46.2 ARTEFACT ARMOUR SETS
### EXOSUIT: TITAN PROTOCOL  
- DEF + massive  
- Cannot be staggered  
- Reduces incoming crits  

### WRAITHWEAVE  
- SPD + stealth synergy  
- Near-invisibility in fog  
- Ambush multiplier +40%  

### IRON HALO  
- DEX + accuracy  
- Auto-deflects first attack every battle  
- Rare “divine shield” proc  

---

## 46.3 REALITY-BENDING ARTEFACTS
These change world mechanics:

### HOURGLASS OF ASHEN TIME  
- reduces all personal cooldowns by 20%  
- seasonal effect: rewinds one world event  

### CROWN OF THE UNDERWORLD  
- allows player to influence district politics  
- boosts cartel diplomacy  

### BLOOD CONTRACT  
- binds a player and an NPC permanently  
- unlocks assassination chain missions  

Mythics are **game-shapers**, not stat sticks.

⭐ EXPANSION SET #31 — TERRITORY POLITICAL DYNAMICS

(A geopolitical simulation between criminal factions)

# 47. TERRITORY POLITICAL ENGINE (TPE)

Each district has:
- Power Index  
- Fear Index  
- Wealth Index  
- NPC Control %  
- Faction Control %  
- Cartel Influence %  

Territory politics are dynamic and shift daily.

---

## 47.1 TERRITORY STATES
### NEUTRAL  
No single actor dominates.

### CONTENTIOUS  
Two major power blocks competing.

### OCCUPIED  
Faction claimed territory.

### REBELLIOUS  
NPC gangs rising up, disrupting control.

### FROZEN  
AI Governor locks territory due to imbalance or exploit activity.

---

## 47.2 TERRITORY ACTIONS
Factions can:
- launch propaganda  
- sabotage utilities  
- deploy hit squads  
- bribe NPC bosses  
- smuggle influence  
- upgrade local infrastructure  
- impose taxation  

NPC gangs do the same but without human bias.

⭐ EXPANSION SET #32 — SYNDICATE FINANCIAL WARFARE

(Large-scale economy PvP between player factions and NPC cartels)

# 48. FINANCIAL WARFARE SYSTEM (FWS)

Groups engage in economic combat by:
- laundering front takeovers  
- market flooding  
- resource starvation  
- crashing item values  
- monopolising vehicles  
- attacking corporate supply chains  

---

## 48.1 ECONOMIC WEAPONS
### PRICE STRANGLE  
Raise essential good prices until rivals bankrupt.

### SCARCITY BOMB  
Buy up an entire category, trigger scarcity, then dump.

### FALSE FLAG TRADE  
Use alt-factions to fake market trends.

### CARTEL TAXATION  
Black market fees set by crime bosses.

### CORPORATE HOSTILE TAKEOVER  
Acquire majority shares and shut down their operations.

---

## 48.2 ECONOMIC WARFARE OUTCOMES
- faction bankruptcy  
- cartel dominance  
- NPC crackdown  
- inflation waves  
- market collapse  
- world-event triggers  

⭐ EXPANSION SET #33 — PLAYER LEGACY & GENERATIONAL PLAY

(Long-term account mechanics inspired by roguelites + prestige games)

# 49. LEGACY SYSTEM

Players accumulate:
- lifetime stats  
- bloodline perks  
- permanent faction traits  
- personal mythos  

When a player prestiges or retires temporarily:
- their legacy persists  
- unlocks new perks  
- generates heirloom items  
- unlocks legacy-only missions  

---

## 49.1 BLOODLINE TRAITS
Traits passed through generations:
- Street Smarts (crime bonus)  
- Iron Skin (DEF bonus)  
- Shadowborn (stealth bonus)  
- Kingpin Lineage (faction influence)  

⭐ EXPANSION SET #34 — CROSS-CITY DIPLOMACY & INTERNATIONAL POLITICS

(System controlling inter-city relations, future expansions, and political intrigue)

# 50. INTERNATIONAL RELATIONS ENGINE (IRE)

Each city has:
- diplomacy score  
- trade treaties  
- extradition agreements  
- smuggling corridors  
- cartel alliances  
- travel restrictions  

---

## 50.1 PLAYER & FACTION INFLUENCE
Players can:
- negotiate treaties  
- buy diplomatic immunity  
- trigger international crises  
- influence foreign markets  

Factions can:
- form global alliances  
- wage international wars  
- operate shadow cells in foreign cities  

---

## 50.2 GLOBAL EVENTS
Examples:
- Interpol crackdown  
- Border closures  
- Global cartel war  
- International blackout  
⭐ EXPANSION SET #35 — MULTI-FACTION WORLD BOSS RAIDS (PvE)

(City-shaking boss encounters involving players, NPC gangs, factions, and the environment)

# 51. WORLD BOSS RAID FRAMEWORK

World Bosses are not “raid bosses.”  
They are **city-wide catastrophic threats** that require coordinated faction response.

Examples:
- The Syndicate Godfather
- The Ripper Warlord
- The Phantom Smuggler King
- The Biohazard Abomination (Industrial Belt event)
- The Flood Titan (Drowned Quarter event)

---

## 51.1 WORLD BOSS TRAITS
World Bosses have:

- MULTI-PHASE FIGHTS  
- IDEOLOGICAL ALIGNMENTS  
- TERRITORY-SHAPING POWERS  
- RAID-WIDE AOE ABILITIES  
- FACTION REPUTATION EFFECTS  
- DYNAMIC TARGET SELECTION  
- NPC CREW CALL-INS  
- ENVIRONMENTAL CHANGES  

---

## 51.2 RAID PARTICIPANT TIERS
### Tier 1 — Faction Assault Teams  
Core DPS, tanks, support roles.

### Tier 2 — Public Combatants  
Any player can join. Strong but disorganised.

### Tier 3 — NPC Gang Forces  
They attack both the boss and players depending on loyalty.

### Tier 4 — Police/Military Forces  
Sometimes intervene, sometimes die immediately.

---

## 51.3 RAID PHASE STRUCTURE
Phase 1 — Encounter Start: Boss scouts, tests defences  
Phase 2 — Escalation: Territory shifts, street destruction  
Phase 3 — Catastrophe: Boss unleashes signature mechanic  
Phase 4 — Collapse: Final stand, reinforcements arrive  
Phase 5 — Resolution: City permanently altered  

---

## 51.4 BOSS REWARD SYSTEM
Rewards depend on:
- contribution  
- faction involvement  
- damage dealt  
- boss notoriety  
- world tension  

Possible loot:
- mythics  
- artefacts  
- unique cosmetics  
- faction-wide buffs  
- boss trophies  

Boss kills also permanently alter district maps.

⭐ EXPANSION SET #36 — FACTION ARCHITECTURE & BASE UPGRADES

(Full base-building system with economic, military, and political power)

# 52. FACTION HQ SYSTEM

Headquarters define a faction’s identity, power, and reach.

HQ includes:
- War Room  
- Treasury  
- Barracks  
- Medical Bay  
- Vehicle Garage  
- Intelligence Hub  
- Espionage Center  
- Black Market Node  

---

## 52.1 HQ UPGRADES
Upgrade categories:

### DEFENSIVE
- reinforced walls  
- automated turrets  
- anti-spy scanners  
- safehouse tunnels  

### ECONOMIC
- laundering suite  
- contraband vault  
- warehouse expansion  

### MILITARY
- armoury  
- training dojo  
- strategy board  
- command center  

### INTELLIGENCE
- decryption lab  
- NPC informant networks  
- psychic threat map (prestige-only)  

---

## 52.2 FACTION SUPER-WEAPONS
Endgame prestige-only upgrades:
- EMP Wave Generator (disables vehicles citywide)  
- Shadow Protocol (cloaks districts from police)  
- Warpath Uplink (summons mercenary NPCs)  
- Voice of Terror (propaganda mutates district stats)  

⭐ EXPANSION SET #37 — PROPERTY & INTERIOR SIMULATION

(Deep Sims-style simulation for player safehouses, apartments, penthouses, mansions)

# 53. PROPERTY INTERIOR ENGINE

Properties now include:

- interior rooms  
- upgrade slots  
- utility systems  
- NPC tenants  
- security layers  
- environmental hazards  

---

## 53.1 ROOM TYPES
### Basic Rooms
- bedroom  
- kitchen  
- bathroom  

### Advanced Rooms
- armory  
- vault  
- panic room  
- laboratory  
- workshop  
- gym  
- smuggler’s den  

---

## 53.2 TENANT SIMULATION
NPC tenants have:
- rent expectations  
- fear index  
- loyalty  
- black market behaviour  

They notify players of:
- police investigations  
- gang surveillance  
- sabotage attempts  

---

## 53.3 PROPERTY DEFENSE SYSTEM
Includes:
- surveillance cameras  
- sensor grids  
- automated locks  
- guard NPCs  
- escape routes  

Property invasions become late-game PvP/PvE content.

⭐ EXPANSION SET #38 — SEASONAL RESET LOGIC (DEEP DESIGN)

(How to run multi-season live-ops that evolve the world)

# 54. SEASON SYSTEM — DEEP OPERATIONAL DESIGN

Seasons define yearly arcs.

Each season has:
- theme  
- NPC storyline  
- faction arc  
- crisis arc  
- reward loop  
- world transformation  

---

## 54.1 SEASON PHASES
Phase 1 — Ascension (boosts progression)  
Phase 2 — Conflict (events erupt)  
Phase 3 — Cataclysm (global crisis)  
Phase 4 — Collapse (choice-based endings)  
Phase 5 — Renewal (new world rules apply)  

---

## 54.2 SEASONAL RESETS
What resets:
- factions standings  
- leaderboards  
- world tension  
- district control maps  

What DOES NOT reset:
- properties  
- prestige  
- mythics  
- legacy perks  
- faction technologies  

---

## 54.3 WORLD EVOLUTION
New seasons can:
- add districts  
- destroy districts  
- merge factions  
- elevate NPC bosses  
- rewrite crime trees  

⭐ EXPANSION SET #39 — CRIME MEGA-TREE PART II

(Expanding crime to an elite, prestige, and international level)

# 55. CRIME MEGA-TREE: PRESTIGE & INTERNATIONAL

Prestige Crimes unlock after P10+.

Categories:
- elite heists  
- government infiltration  
- corporate espionage  
- syndicate assassination  
- international trafficking  

---

## 55.1 PRESTIGE CRIME MECHANICS
- multi-stage  
- multi-failure states  
- permanent world effects  
- catastrophic chain reactions  
- faction diplomacy modifiers  

---

## 55.2 INTERNATIONAL CRIMES
These occur across borders:
- border smuggling  
- embassy theft  
- cyberwarfare  
- cartel assassinations  
- foreign government infiltration  

⭐ EXPANSION SET #40 — TOTAL SYSTEMS GRAPH BLUEPRINT

(The MASTER FLOW of the entire game — the fundamental Trench City architecture)

# 56. TOTAL SYSTEMS BLUEPRINT

This is the canonical graph connecting every system.

1. Stats → Combat → PvP/PvE → Rewards  
2. Bars → Crimes → Economy → Black Market  
3. Properties → Tenants → Crime Buffs → Intrusions  
4. Vehicles → Smuggling → Cartel → Faction Warfare  
5. Factions → Districts → Territory → NPC Simulation  
6. NPC Simulation → AI Director → Events → World Tension  
7. World Tension → Missions → Rewards → Player Progression  
8. Seasons → Prestige → Global Resets → New Crime Trees  
9. International Hubs → Diplomacy → Trade Routes → Cartel Warfare  
10. Mythics → Artefacts → Rule Alteration → Meta Shifts  

The loop is fractal, adaptable, and indefinitely expandable.
⭐ EXPANSION SET #41 — BLACK MARKET 2.0 (Smuggling Biome Expansion)

(A deeper model for underground trade, contraband ecosystems, and smuggler identity progression)

# 57. BLACK MARKET 2.0 — CONTRABAND ECOSYSTEM

The Black Market is no longer a shop —  
it is an *ecosystem* with:

- supply networks  
- smuggler tiers  
- cartel influence  
- international imports  
- law enforcement choke points  

Each category has a living supply chain.

---

## 57.1 CONTRABAND TYPES
• Weapons  
• Cyberchips  
• Luxury Goods  
• Narcotics  
• Forged Documents  
• High-Tech Mods  
• Exotic Artefacts  
• Vehicle Parts  
• Medical Enhancements  

Each has:
- rarity curve  
- smuggling risk  
- legality level  
- cartel monopoly score  

---

## 57.2 TRADE ROUTING ENGINE
Routes have:
- entry points  
- midpoints  
- exit nodes  
- ambush spots  
- corruption gates  

Routes refresh every 12 hours, influenced by:
- police heat  
- world tension  
- NPC gang warfare  
- smuggler activity  

---

## 57.3 PLAYER SMUGGLER RANKS
1. Runner  
2. Courier  
3. Transporter  
4. Handler  
5. Broker  
6. Ghost-Mule (prestige-only)  
7. Phantom Trader (mythic)  

Ranks unlock:
- exclusive goods  
- safer routes  
- cartel missions  

⭐ EXPANSION SET #42 — AI NPC RELATIONSHIP SYSTEM

(NPCs remember you, react to you, love you, hate you, fear you… and sometimes betray you.)

# 58. NPC RELATIONSHIP ENGINE (NRE)

NPCs track:
- trust  
- fear  
- loyalty  
- resentment  
- ambition  
- ideological alignment  

NPC memory persists across seasons.

---

## 58.1 NPC RELATIONSHIP TYPES
### ALLY  
Helps in crimes, gives insider tips.

### RIVAL  
Attempts to sabotage player actions.

### INFORMANT  
Sells intelligence (but may lie).

### ENFORCER  
Protects your assets if loyalty is high.

### LOVER  
Provides buffs; potential for betrayal arcs.

### BETRAYER  
NPC eventually turns on you based on resentment + ambition.

---

## 58.2 NPC EMOTIONAL DRIVERS
Emotions calculated by:
Emotion = (EventImpact × PersonalBias × RelationshipHistory)

Biases:
- greed  
- fear  
- loyalty  
- ambition  
- revenge  
- patriotism  
- moral compass  

NPCs can:
- form grudges  
- stalk players  
- sell secrets  
- assassinate enemies  

⭐ EXPANSION SET #43 — DYNAMIC SOUNDSCAPE ENGINE

(Environmental audio systems impacting gameplay — extremely rare in text MMOs)

# 59. SOUND & STEALTH ENGINE

The city “sounds” alive.

Every district has:
- ambient loops  
- dynamic noise bursts  
- faction chatter  
- police sirens  
- market crowds  
- industrial machinery  

These influence stealth & NPC attention.

---

## 59.1 NOISE SIGNATURE SYSTEM
Each action has a sound level (0–100):

- footsteps  
- gunfire  
- vehicle acceleration  
- breaking into properties  
- melee combat  
- smuggling crate movement  

NPCs react to sound levels.

---

## 59.2 SOUND-BASED STEALTH CHECKS
StealthSuccess =
   BaseStealth
 – NoisePenalty
 + TerrainModifier
 – NPCAlertness
 + TimeOfDayModifier

Sound also affects hunting missions and property intrusions.

⭐ EXPANSION SET #44 — ADDICTION, VICES & UNDERGROUND NIGHTLIFE SYSTEMS

(Gambling, drugs, nightlife, psychological hooks — elite immersion systems)

# 60. VICE & NIGHTLIFE ENGINE

Nightlife is a game system with:

- clubs  
- bars  
- underground casinos  
- fight pits  
- brothels  
- speakeasies  
- VIP lounges  

Each has:
- unique missions  
- faction ties  
- criminal opportunities  
- vices  

---

## 60.1 ADDICTION SYSTEM
Vices include:
- drugs  
- alcohol  
- gambling  
- adrenaline (combat addiction)  

Addiction has:
- tolerance  
- withdrawal  
- dependency  
- relapse events  

Withdrawals can:
- reduce stats  
- lower regen  
- cause hallucination events  
- unlock special mission chains  

---

## 60.2 NIGHTLIFE POWER NETWORKS
Every venue is connected to:
- NPC gangs  
- faction bribes  
- smuggler deals  
- VIP access routes  

⭐ EXPANSION SET #45 — PUBLIC TRANSPORT, TRAFFIC & CROWD SIMULATION

(The invisible AI simulation that makes cities feel alive and reactive)

# 61. CITY TRAFFIC & CROWD ENGINE

The city is populated by:

- foot traffic  
- vehicle traffic  
- NPC crowds  
- police patrol routes  
- emergency routes  
- smuggler caravans  

---

## 61.1 TRAFFIC DENSITY ZONES
Zones fluctuate by:
- time of day  
- district wealth  
- weather  
- events  
- faction wars  

Traffic affects:
- travel time  
- smuggling risk  
- chase difficulty  
- ambush opportunities  

⭐ EXPANSION SET #46 — CORPORATE LADDER (Player Career Path)

(A non-criminal progression track parallel to factions)

# 62. CORPORATE CAREER SYSTEM

Players can climb a corporate ladder through:

- internships  
- junior roles  
- mid-level positions  
- senior management  
- executive tier  

Companies include:
- tech firms  
- transport companies  
- private military firms  
- pharmaceutical corporations  
- finance institutions  

---

## 62.1 OFFICE POLITICS ENGINE
Includes:
- sabotage  
- insider trading  
- bribery  
- whistleblower mechanics  
- career betrayal arcs  

⭐ EXPANSION SET #47 — UNDERGROUND FIGHTING RINGS

(Advanced PvP arenas with modifiers, bets, entourages, and honour systems)

# 63. FIGHT RING ENGINE

Types:
- bareknuckle pits  
- street arenas  
- VIP underground coliseum  
- faction cage arenas  
- prestige-only ritual combat  

Modifiers:
- fog  
- darkness  
- water  
- oil  
- momentum  
- crowd support  

Betting included.

⭐ EXPANSION SET #48 — LIVE OPS EVENT TOOLKIT (Developer System)

(Used by admins/LiveOps to run fresh content continuously)

# 64. LIVE OPS SYSTEM

Tools:
- event spawner  
- loot table modifier  
- XP multiplier dial  
- district hazard overrides  
- NPC faction toggles  
- holiday event scripts  

Admins can:
- spawn mega events  
- modify tension  
- freeze gangs  
- create custom missions  

⭐ EXPANSION SET #49 — CROSS-PLATFORM MONETISATION RULES

(AAA ethical monetisation for web + mobile + console)

# 65. MONETISATION LAW

Rules:
- no pay-to-win  
- cosmetics only  
- booster caps  
- anti-gambling compliance  
- regional pricing  
- seasonal pass model  
- prestige cosmetic store  
- limited-time events  

Revenue Streams:
- cosmetics  
- themed passes  
- faction HQ skins  
- vehicle wraps  
- property interior packs  
- prestige auras  

⭐ EXPANSION SET #50 — DARK LUXURY LORE CODEX (Narrative Tonebook)

(Defines the identity of Trench City — the tone, voice, culture, aesthetic.)

# 66. DARK LUXURY CODEX

Tone:
- noir  
- sleek  
- sharp  
- dangerous  
- neon-drenched  
- elite criminal aristocracy  

Every element must feel:
- premium  
- modern  
- “criminal high-life”  
- dark sophistication  
- London noir  

Verb choices:
- stalk, strike, ascend, corrupt, dominate, unravel  

Adjectives:
- gilded, obsidian, industrial, drowned, sovereign, rogue  

Lighting:
- gold accents  
- deep navy  
- black metallic shadows  
⭐ EXPANSION SET #51 — WEATHER DISASTER SUPER-EVENTS

(Environmental catastrophes that reshape territory, crime, and survival.)

# 67. WEATHER DISASTER ENGINE (WDE)

These are NOT simple weather effects.  
These are **city-altering calamities** that last hours or days, reshaping the map.

## 67.1 DISASTER TYPES

### FLOODWAVE
The Drowned Quarter expands into neighbouring districts.
- movement slowed  
- stealth boosted  
- electrocution hazards  
- loot floating events  

### SUPERCELL
A hyperstorm hits the Industrial Belt.
- EMP waves disable vehicles  
- accuracy reduced citywide  
- blackouts triggered  
- smuggler routes collapse  

### HEAT DOOM
Extreme heatwave.
- energy drains 2× faster  
- hospital overflows  
- riot probability spikes  
- faction conflict increases  

### SNOWLOCK
Snow buries Uptown & Old Mile.
- travel nearly impossible  
- property damage events  
- police response crippled  
- NPC gangs gain dominance  

---

## 67.2 DISASTER PHASES
Phase 1: Warning  
Phase 2: Impact  
Phase 3: Secondary Hazards  
Phase 4: Crisis  
Phase 5: Recovery  

Each phase unlocks:
- unique missions  
- new loot tables  
- temporary crime bonuses  
- faction contract opportunities  

Disasters ALWAYS leave permanent scars.

⭐ EXPANSION SET #52 — VEHICLE CUSTOMISATION MEGA-SYSTEM

(Full Need-for-Speed x GTA Online grade tuning, parts, builds, and specialisations.)

# 68. VEHICLE CUSTOMISATION SUPERSTRUCTURE

Players build vehicles for:
- racing  
- smuggling  
- combat  
- faction logistics  
- prestige identity  

## 68.1 PART CATEGORIES
Engine  
Turbo/Supercharger  
ECU  
Exhaust  
Tyres  
Suspension  
Transmission  
Body Kit  
Armour Plating  
Cargo Compartments  
Signal Scramblers  
Silent Drives  

Each part has rarity tiers:
Common → Uncommon → Rare → Elite → Exotic → Mythic

---

## 68.2 BUILD SPECIALISATIONS

### DRIFT KING
High SPD, low traction, precision handling.

### DRAGOON
Pure STR — high ramming damage.

### GHOSTRUNNER
Silent exhaust, low noise signature, stealth smuggler.

### TANKLINE
Reinforced, armoured, slow but unstoppable.

### TECHBREAKER
Electronics-heavy; disrupts enemy GPS/police scans.

---

## 68.3 RACING AFFINITY SYSTEM
Vehicles gain affinity (XP) by racing.

Affinity unlocks:
- handling bonuses  
- drift lines  
- NOS efficiency  
- unique race-only abilities  

⭐ EXPANSION SET #53 — MEDICAL SYSTEM & TRAUMA SIMULATION

(Players now experience injuries, trauma, surgical recovery, and black market medicine.)

# 69. MEDICAL & TRAUMA ENGINE

Damage now causes:
- wounds  
- fractures  
- concussions  
- organ damage  
- infections  

Each injury has severity + complications.

---

## 69.1 TRAUMA TYPES
### LIGHT
Bruises, cuts.

### MODERATE
Fractures, sprains, deep wounds.

### SEVERE
Internal bleeding, trauma shock, broken spine, skull fracture.

Severe trauma affects:
- stat performance  
- combat accuracy  
- max energy  
- crime success  

---

## 69.2 MEDICAL TREATMENTS
Hospitals → standard recovery  
Black Clinics → faster but dangerous  
Syndicate Surgeons → require favour  
DIY First Aid → temporary buffs and penalties  

---

## 69.3 SCAR SYSTEM
Trauma leaves scars:
- cosmetic scars  
- prestige scars  
- unique legacy perks  

⭐ EXPANSION SET #54 — FOOD, DRINK, MOOD & HUMAN CONDITION LAYER

(A subtle but powerful depth system affecting performance & life simulation.)

# 70. HUMAN CONDITION ENGINE

Affects:
- mood  
- morale  
- focus  
- hunger  
- hydration  
- intoxication  
- stimulant effects  

This system is optional for casual players but rewarding for enthusiasts.

---

## 70.1 MOOD TYPES
Inspired  
Focused  
Tired  
Depressed  
Euphoric  
Enraged  
Cold  
Comfortable  

Mood affects:
- stat regen  
- crime success  
- faction leadership effects  
- NPC interactions  

---

## 70.2 FOOD & DRINK EFFECTS
Protein meals → STR buff  
Energy drinks → SPD buff with crash  
Alcohol → CHA buff + misses in combat  
Drugs → high reward, high addiction risk  
Coffee → focus buff, slight INT boost  

⭐ EXPANSION SET #55 — FACTION ESPIONAGE MEGA-TREE

(A full espionage progression system for spies, infiltrators, and double agents.)

# 71. ESPIONAGE OVERHAUL

Players specialise into:

- Sleeper Agents  
- Moles  
- Deep Cover Operatives  
- Propaganda Specialists  
- Saboteurs  
- Interrogators  

---

## 71.1 ESPIONAGE ACTIONS
- infiltrate HQ  
- steal treasury funds  
- expose member logs  
- sabotage faction upgrades  
- leak diplomacy chats  
- plant listening devices  
- alter election votes  
- kidnap NPC allies  
- frame rivals  

---

## 71.2 SPY DETECTION SYSTEM
Each faction has:
- suspicion meter  
- loyalty index  
- behavioural anomaly detection  

Caught spies trigger:
- tortures  
- public trials  
- execution events  
- faction-wide buffs/debuffs  

⭐ EXPANSION SET #56 — ECONOMIC COLLAPSE & RECOVERY ARCS

(World-scale economic collapse simulations.)

# 72. ECONOMIC COLLAPSE ENGINE

Collapse triggers:
- hyperinflation  
- cartel monopolies  
- international embargoes  
- mega-event fallout  
- crime success overflows  

---

## 72.1 COLLAPSE EFFECTS
- 90% liquidity loss  
- crime payouts fall  
- smuggling becomes mandatory  
- factions default  
- stock market crashes  
- riots  
- NPC panic behaviour  

---

## 72.2 RECOVERY PHASES
Recovery through:
- faction intervention  
- government bailout missions  
- NPC market stabilisers  
- cartel negotiations  
- international trade  

Unique missions appear only during collapse.

⭐ EXPANSION SET #57 — PRISON SYSTEM & INMATE POLITICS

(A full alternate world where players can be imprisoned and build power inside.)

# 73. PRISON WORLD ENGINE

Prison is its own sandbox.

Players may enter prison due to:
- catastrophic crime failure  
- being caught by elite police  
- faction betrayal  
- storyline events  
- PvP capture  

---

## 73.1 PRISON FACTIONS
- Yard Lords  
- Block Kings  
- Contraband Alliance  
- Information Brokers  
- Enforcers  
- Philosophers  

Each has:
- territory (cell blocks)  
- rules  
- politics  
- power struggles  

---

## 73.2 PRISON GAMEPLAY
Players can:
- run contraband  
- control labour crews  
- run bets  
- recruit inmates  
- start riots  
- escape  
- assassinate rivals  

Prison is a **mini-MMO inside the MMO**.

⭐ EXPANSION SET #58 — MULTIVERSE / PARALLEL CITY EVENTS

(Prestige/Mystic endgame system that bends reality.)

# 74. PARALLEL CITY ENGINE

Prestige 50+ players unlock alternate city layers.

Each layer:
- rewrites physics  
- changes district geometry  
- alters crime types  
- introduces mythic bosses  
- contains artefacts  

Examples:

### SHADOW TRENCH
Lightless, dangerous, heavy stealth buffs.

### GOLDEN PARAGON CITY
High wealth, high cost, mythic trades.

### FRACTURED TRENCH
Reality glitching; NPC duplicates; instability bonuses.

Rewards here affect the real world.

⭐ EXPANSION SET #59 — ELITE PROPERTY EMPIRE MECHANICS

(Turning property ownership into a mega-industry.)

# 75. PROPERTY EMPIRE ENGINE

Properties now:
- generate passive income  
- host NPC tenants  
- provide crime bonuses  
- include prestige upgrades  
- form neighbourhood influence networks  

---

## 75.1 PROPERTY TIER TREE
Tier 1: Basic Flats  
Tier 2: Luxury Apartments  
Tier 3: City Mansions  
Tier 4: Corporate Towers  
Tier 5: Underground Compounds  
Tier 6: Prestige Estates  
Tier 7: Mythic Landmarks  

Each tier adds:
- new buffs  
- new tenants  
- new world influence  

Players can become **real estate barons**.

⭐ EXPANSION SET #60 — DEEP SOCIAL MEDIA & PUBLIC PERCEPTION SIMULATION

(Public perception becomes a mechanic with gameplay consequences.)

# 76. PUBLIC PERCEPTION ENGINE

The city has a simulated social network:
- NPCs post  
- factions influence narratives  
- scandals spread  
- misinformation campaigns trigger  

---

## 76.1 PLAYER VISIBILITY SCORE (PVS)
Based on:
- crimes  
- PvP wins  
- notoriety  
- fame  
- missions completed  
- scandals  
- gossip spread  

High PVS attracts:
- fans  
- stalkers  
- hitmen  
- media attention  
- corporate deals  

---

## 76.2 PUBLIC CONTROVERSY SYSTEM
Players can:
- apologise publicly  
- double down  
- manipulate sentiment  
- hire PR  
- silence witnesses  
⭐ EXPANSION SET #61 — FULL LAW ENFORCEMENT SIMULATION

(A complete police, tactical, and corruption engine.)

# 77. LAW ENFORCEMENT SIMULATION ENGINE (LESE)

Police exist as:
- patrol officers  
- detectives  
- tactical units  
- corruption operatives  
- undercover agents  
- special crime division  

Police behaviour depends on:
- crime density  
- district heat  
- player notoriety  
- faction wars  
- mega-events  

---

## 77.1 POLICE AI STATES
### PATROL MODE  
Low engagement, responsive.

### ALERT MODE  
High crime → increase patrols, more arrests.

### LOCKDOWN MODE  
Triggered by:
- mega-events  
- catastrophic crimes  
- player being too notorious  

### PURSUIT MODE  
Elite police chase players after major crimes.

### CORRUPTION MODE  
Police reduce heat in exchange for bribes, cartel influence.

---

## 77.2 CORRUPTION SYSTEM
Police have corruption ratings:
- Clean  
- Negotiable  
- Bought  
- Owned  
- Rogue (working for syndicates)

Players can:
- bribe  
- blackmail  
- eliminate  
- expose  
- recruit undercover cops  

Corruption shifts the entire criminal landscape.

⭐ EXPANSION SET #62 — CYBERCRIME & HACKING MEGA-SYSTEM

(A full digital crime layer with systems-level mechanics.)

# 78. CYBERCRIME ENGINE

Players hack:
- banks  
- corporations  
- faction logs  
- black market servers  
- NPC communication grids  
- police databases  
- mission terminals  

---

## 78.1 HACKING MECHANICS
Hacks use:
- skill checks  
- toolkits  
- malware  
- social engineering  
- decryption puzzles  
- timed challenges  

---

## 78.2 CYBERCRIME TIERS
Tier 1: Phishing → low reward  
Tier 2: Database Breach  
Tier 3: Corporate Espionage  
Tier 4: Black Market Overwrites  
Tier 5: Faction Network Infiltration  
Tier 6: Global Infrastructure Attacks  
Tier 7: Legendary Hacks (prestige only)  

---

## 78.3 DIGITAL CONSEQUENCES
- tracebacks  
- cyber police  
- digital prison (unique gameplay)  
- wipe-outs of money/items  
- exposure events  

⭐ EXPANSION SET #63 — ATM BOMBING & BANK HEIST OVERHAUL

(Heavy-crime overhaul with multi-stage mechanics.)

# 79. BANK & ATM CRIME SYSTEM

Crimes now require:
- reconnaissance  
- equipment  
- crew roles  
- timing  
- escape plans  

---

## 79.1 ATM BOMBING
Players use:
- thermite  
- explosive gel  
- EMP charges  

Risks:
- explosion radius  
- police response  
- camera identification  
- gang interference  

---

## 79.2 BANK HEISTS
Heists have:
- entry phase  
- vault breach  
- hostage crisis  
- police negotiation  
- escape sequence  
- aftermath  

Outcomes affect:
- faction reputation  
- district politics  
- world tension  

⭐ EXPANSION SET #64 — DEEP NPC DIALOGUE AI TREES

(NPCs respond to identity, reputation, faction, history, and world-state.)

# 80. NPC DIALOGUE ENGINE (NDE)

NPC conversations change based on:
- crime reputation  
- faction alignment  
- fame  
- notoriety  
- past interactions  
- standing in district  
- intimidation level  
- social skills  

---

## 80.1 NPC PERSONALITY TAGS
NPCs reference your:
- betrayals  
- alliances  
- crimes  
- mission outcomes  
- public controversies  

Dialogue becomes a gameplay system — with consequences.

⭐ EXPANSION SET #65 — AUGMENTATION & CYBERNETIC IMPLANTS

(High-end body modification progression.)

# 81. AUGMENTATION ENGINE

Cybernetic implants provide:
- stat bonuses  
- unique abilities  
- tactical advantages  
- stealth upgrades  
- hacking efficiency  

---

## 81.1 AUGMENT TYPES
Nerve Lace → boosts accuracy  
Steel Bones → DEF boost  
Reflex Enhancer → SPD increase  
Cyber Eye → DEX buff + weakpoint vision  
Adrenal Pump → burst STR mode  
Ghost Skin → stealth buff  

Mythic augments break rules:
- reality distortion  
- adrenaline freezes time (1 turn)  
- damage reflection  

⭐ EXPANSION SET #66 — RITUALS, CULTS & MYTHIC ENDGAME

(Narrative & gameplay blend: secret societies, occult bonuses, prestige paths.)

# 82. CULT & OCCULT SYSTEM

Cults exist as:
- prestige factions  
- secret societies  
- mythic world-state influences  

Each cult:
- rewrites crime trees  
- offers mythic missions  
- grants supernatural-seeming buffs  
- interacts with multiverse layers  

---

## 82.1 CULT MECHANICS
Blood Rituals → permanent stat boosts  
Shadow Pact → stealth invisibility  
Eldritch Vision → see NPC fear levels  
Soul Bargain → revive instantly (but with penalty)  

⭐ EXPANSION SET #67 — WEATHER AI ECOSYSTEM V2

(Second-generation environment simulation.)

# 83. WEATHER AI 2.0

Weather now interacts with:
- NPC behaviour  
- faction war outcomes  
- property risk levels  
- vehicle handling  
- crime payout multipliers  
- world tension  

The system becomes fully predictive and reactive.

⭐ EXPANSION SET #68 — WORLD REPUTATION & GLOBAL DIPLOMACY

(Player and faction reputation extends internationally.)

# 84. GLOBAL DIPLOMACY MATRIX

Countries track:
- player reputation  
- faction actions  
- cartel ties  
- black market influence  
- cybercrime incidents  

Outcomes:
- extraditions  
- safe havens  
- bounty postings  
- diplomatic immunity  

⭐ EXPANSION SET #69 — PLAYER SHADOW CLONES & ECHO BATTLES

(Fighting alternate versions of yourself for rewards.)

# 85. ECHO BATTLE SYSTEM

The AI generates:
- statistical clones  
- alternate-path versions  
- mythic “what-if” player builds  

Fighting your Echo grants:
- rare mythic mods  
- prestige XP  
- legacy perks  

⭐ EXPANSION SET #70 — CITYWIDE INFRASTRUCTURE TAKEOVER SYSTEM

(Players and factions influence the city’s hard systems.)

# 86. INFRASTRUCTURE TAKEOVER

Take control of:
- power grids  
- water plants  
- communication networks  
- metro lines  
- CCTV systems  

Each takeover grants:
- map visibility  
- faster travel  
- faction resource buffs  
- crime success increases  

⭐ EXPANSION SET #71 — AI-DRIVEN DYNAMIC MUSIC LAYER

(Music responds to danger, tension, events, and player actions.)

# 87. MUSIC AI ENGINE

Music changes based on:
- danger level  
- NPC hostility  
- tension meter  
- stealth state  
- vehicle speed  
- mission stage  

Creates adaptive audio like major AAA titles.

⭐ EXPANSION SET #72 — STREAMING MODE & PUBLIC ARENA FAME

(Streamer-focused systems.)

# 88. STREAM MODE & PUBLIC ARENAS

Stream Mode:
- hides sensitive info  
- adds “live reactions”  
- gives stream-safe mission prompts  

Public Arena:
- PvP showmatches  
- public rankings  
- sponsorships  
- fame multipliers  

⭐ EXPANSION SET #73 — PLAYER GOVERNMENT (ENDGAME SOCIETY SIMULATION)

(A playable political meta-game.)

# 89. PLAYER GOVERNMENT SYSTEM

Players elect:
- Mayor  
- Crime Commissioner  
- Economic Council  
- District Governors  

Each position gives:
- bonuses  
- laws  
- taxes  
- funding powers  
- faction diplomacy leverage  

⭐ EXPANSION SET #74 — CRISIS DIPLOMACY BOARDGAME MECHANICS

(A meta layer for high-end political gameplay.)

# 90. CRISIS DIPLOMACY ENGINE

Players negotiate during:
- mega events  
- territory conflicts  
- cartel wars  
- elections  

They exchange:
- intel  
- favours  
- resources  
- betrayals  

⭐ EXPANSION SET #75 — PLAYER MICRO-COMMUNITIES (BLOCK SYSTEMS)

(Neighbourhood-level social clusters.)

# 91. BLOCK SYSTEM

Blocks are mini-communities:
- Block wars  
- Block alliances  
- Block reputations  
- Property value modifiers  

⭐ EXPANSION SET #76 — DAILY LIFE SIMULATION FOR NPC CIVILIANS

(Civilian AI routines affecting crime and chaos.)

# 92. CIVILIAN SIM ENGINE

Civilians:
- commute  
- shop  
- panic  
- protest  
- form mobs  
- call police  
- flee crime scenes  

Civilian fear affects district statistics.

⭐ EXPANSION SET #77 — LAW, COURT & TRIAL SYSTEM

(Advanced justice mechanics.)

# 93. COURT SYSTEM

Trials include:
- juries  
- judges  
- witnesses  
- evidence  
- faction interference  
- bribes  

Outcomes:
- prison  
- fines  
- probation  
- community service missions  

⭐ EXPANSION SET #78 — TERROR, PANIC, AND BEHAVIOURAL PROPAGATION

(Psychology-driven riot and chaos simulation.)

# 94. PANIC PROPAGATION ENGINE

Panic spreads based on:
- violence  
- disasters  
- police brutality  
- NPC deaths  
- faction warfare  

High panic unlocks:
- riots  
- looting  
- martial law  
- anarchist events  

⭐ EXPANSION SET #79 — DYNAMIC MARKETPLACE AI

(Fully algorithmic economy simulation.)

# 95. MARKET AI ENGINE

Tracks:
- supply  
- demand  
- hoarding  
- cartel interference  
- smuggler trends  

Prices shift constantly.

Markets behave like living organisms.

⭐ EXPANSION SET #80 — LEGENDARY WORLD STATES (GLOBAL ENDINGS)

(Endgame narrative states that permanently affect the server.)

# 96. WORLD STATE ENDINGS

Possible legendary world outcomes:

### THE GOLDEN AGE  
Economy booms; crime drops; factions unite.

### THE DARK ASCENT  
NPC gangs rule; player factions scattered.

### THE IRON LOCKDOWN  
Police militarise; criminal life becomes extreme.

### THE CRIMSON KINGDOM  
A mythic cult takes over the city.

These states change:
- world rules  
- system bonuses  
- seasonal arcs  
- district layouts  
⭐ EXPANSION SET #81 — NEURAL NETWORK CRIME PREDICTION AI

(A predictive AI that reacts to crime patterns and alters district behaviour.)

# 97. PREDICTION AI ENGINE (PAE)

The AI uses:
- crime frequency data
- player-level clustering
- faction location density
- smuggler heat-maps
- world tension indicators
- economic inflation curves

The system predicts:
- upcoming crime spikes
- territory instability
- cartel movements
- police deployment patterns
- NPC gang migration

Predictions affect:
- law enforcement routes
- black market prices
- event timing
- district difficulty

The AI learns from every season.

⭐ EXPANSION SET #82 — SECRET SOCIETIES 2.0

(Deep networks that influence politics, crime, and mythic world states.)

# 98. SECRET SOCIETY NETWORK (SSN)

Each society has:
- initiation rites
- oathbound missions
- elite perks
- forbidden knowledge
- political influence
- mythic artefact ties

Societies subtly manipulate:
- elections
- cartel wars
- faction diplomacy
- district power grids

Joining or betraying one changes your entire career path.

⭐ EXPANSION SET #83 — GENETIC MODIFICATION & BIOHACKING

(Prestige science layer — modify body, stats, resistances.)

# 99. BIOHACK ENGINE

Biohacks alter:
- stat curves
- damage resistances
- regen formulas
- trauma thresholds
- sensory perception

Categories:
- muscular rewiring
- nerve augmentation
- bloodstream enhancers
- gene-splicing
- anti-aging protocols
- night-vision grafts
- hyper-healing grafts (mythic)

Biotech labs unlock at Prestige 20+.

⭐ EXPANSION SET #84 — SUPERNATURAL MYTHOS LAYER (OPTIONAL)

(World events tied to cults, mythic artefacts, and alternate realities.)

# 100. MYTHOS LAYER

Optional toggle for lore servers.

Includes:
- eldritch anomalies
- haunted districts
- cursed artefacts
- shadow creatures
- dimensional fractures

Mythos events:
- corrupt districts
- alter crime trees
- create insane difficulty spikes
- reward mythic-tier loot

⭐ EXPANSION SET #85 — UNIVERSAL ECONOMIC SINGULARITY (ENDGAME)

(The entire economy approaches collapse or explosion based on player behaviour.)

# 101. ECONOMIC SINGULARITY ENGINE

If liquidity becomes unstable, the engine triggers:
- currency restructuring
- black market resets
- inflation waves
- hyper-deflation events
- bank liquidation arcs
- emergency world missions

Prestige players can vote in “Economic Resets” — altering world rules.

⭐ EXPANSION SET #86 — MEMORY IMPRINT PvP

(Fight imprints of other players’ historical builds.)

# 102. MEMORY IMPRINT ENGINE

Players leave “echo data” behind:
- build snapshots
- stat curves
- crime patterns
- combat tendencies

You can battle:
- past versions of yourself
- past versions of rivals
- mythic imprints of legends

Rewards include:
- unique mods
- imprint shards
- prestige buffs

⭐ EXPANSION SET #87 — LIFE SIMULATION FOR PLAYERS

(Habits, sleep, training cycles, motivations.)

# 103. PLAYER LIFE SYSTEM

Tracks:
- energy cycles
- training patterns
- sleep schedules
- productivity values
- burnout thresholds

Good habits → buffs  
Bad habits → debuffs  
Overtraining → injury risk  
Undertraining → stat decay

⭐ EXPANSION SET #88 — NATIONAL ELECTIONS & COUNTRY CONTROL

(Players influence national-level politics beyond the city.)

# 104. NATIONAL POLITICS SIM

Players affect:
- national crime laws
- economic policy
- police funding
- black market regulation
- extradition rules

Elections use:
- propaganda  
- bribery  
- faction influence  
- scandals  
- secret society interference  

⭐ EXPANSION SET #89 — CITY EVOLUTION ENGINE v3 (Organic District Shifts)

(Districts evolve automatically based on simulation.)

# 105. CITY EVOLUTION ENGINE v3

Districts shift into:
- wealth zones
- ghettos
- industrial expansion zones
- warzones
- refugee zones
- mythic anomalies

Districts can merge, split, or collapse entirely.

⭐ EXPANSION SET #90 — DYNAMIC NPC CAREER PATHS

(NPCs climb hierarchies, retire, betray, evolve.)

# 106. NPC CAREER ENGINE

NPCs level up:
- civilian → criminal → leader  
- police rookie → detective → commander  
- smuggler → handler → cartel boss  

NPCs retire, die, betray, go missing, or ascend.

⭐ EXPANSION SET #91 — REPUTATION WEB (Graph Theory Social Network)

(Visual network of relationships between players, factions, NPCs.)

# 107. REPUTATION GRAPH ENGINE

Nodes:
- players  
- factions  
- NPC bosses  
- syndicates  
- cults  

Edges:
- trust  
- fear  
- hostility  
- alliance  
- betrayal  

Graph shifts dynamically with world events.

⭐ EXPANSION SET #92 — LOOT ECOSYSTEM 3.0

(Fully dynamic loot generation influenced by world-state.)

# 108. LOOT AI SYSTEM

Loot rarity influenced by:
- world tension  
- NPC fear  
- supply chain  
- mythic anomalies  
- seasonal effects  

Loot pools evolve over time.

⭐ EXPANSION SET #93 — TACTICAL COMBAT MODULE

(Advanced combat with cover, stances, and terrain modifiers.)

# 109. TACTICAL COMBAT ENGINE

Features:
- cover system  
- flanking bonuses  
- environmental hazards  
- stances (aggressive/defensive/neutral)  
- suppressive fire  
- group synergy  
- distraction mechanics  

⭐ EXPANSION SET #94 — PRESTIGE MULTIVERSE CHAINS

(Chain missions across timelines.)

# 110. MULTIVERSE CHAIN SYSTEM

Players jump through:
- alternate cities  
- fractured realities  
- mythic corridors  

Chains grant:
- artefact fragments  
- timeline perks  
- reality-bending mods  

⭐ EXPANSION SET #95 — UNDERGROUND MEGA-STRUCTURES

(Massive underground cities below Trench City.)

# 111. MEGASTRUCTURE SYSTEM

Includes:
- catacomb networks  
- smuggler cities  
- abandoned metro kingdoms  
- cult vaults  
- rogue AI facilities  

⭐ EXPANSION SET #96 — HYPER-ELITE CRIME PATHS

(Only available at Prestige 100+.)

# 112. ELITE CRIME PATHS

Examples:
- world leader assassinations  
- national bank heists  
- quantum vault breaches  
- mythic beast hunts  

⭐ EXPANSION SET #97 — WORLD-ENDING MYTHIC BOSSES

(Final-tier PvE.)

# 113. APOCALYPTIC BOSS ENGINE

Bosses alter entire world rules:
- reverse gravity zones  
- time-slow fields  
- madness debuffs  

⭐ EXPANSION SET #98 — ALTERNATE HISTORY ARCS

(World forks based on player decisions.)

# 114. HISTORY BRANCH SYSTEM

Major events rewrite:
- who controls the city  
- which factions exist  
- what crimes are viable  
- NPC power structures  

⭐ EXPANSION SET #99 — GRAND STRATEGY LAYER

(EVE Online style macro-governance.)

# 115. GRAND STRATEGY MODULE

Regions controlled by alliances.  
Long-term wars.  
Resource extraction rights.  
International politics.  

⭐ EXPANSION SET #100 — THE ULTIMATE SYSTEM LAW (FINAL CODE)

(The single overarching rule.)

# 116. THE SUPREME LAW OF TRENCH CITY

Every system must:
- reward ambition  
- punish recklessness  
- react to the world  
- be influenced by players  
- evolve endlessly  
- remain exploit-resistant  
- generate stories  

THE WORLD MUST ALWAYS FEEL ALIVE.
⭐ EXPANSION SET #101 — AI PERSONALITY EVOLUTION SYSTEM

(NPCs develop personalities over time based on real interactions.)

# 117. AI PERSONALITY EVOLUTION (APE)

NPCs evolve based on:
- exposure to violence
- success/failure in missions
- interactions with players
- trauma events
- faction politics
- district conditions
- world tension cycles

---

## 117.1 PERSONALITY GROWTH TRAITS
NPC traits change over time:

- Courage ↔ Fearfulness
- Loyalty ↔ Betrayal tendency
- Ambition ↔ Complacency
- Rationality ↔ Irrationality
- Hostility ↔ Diplomacy
- Greed ↔ Discipline  

NPCs *become characters*, not assets.

---

## 117.2 MEMORY-DRIVEN EVOLUTION
NPC behaviour adjusts based on:
- who helped them  
- who wronged them  
- factions they fear  
- district trauma levels  
- mythic anomalies  

NPCs may:
- form vendettas  
- develop paranoia  
- ascend to leadership  
- retire due to trauma  

⭐ EXPANSION SET #102 — MULTI-SPECIES NPC VARIANTS (OPTIONAL)

(For premium lore servers — biological diversity, mutations, augmented humans.)

# 118. MULTISPECIES FRAMEWORK (OPTIONAL MODE)

Playable for NPCs, not players initially.

Types:
- Enhanced Humans (biohacked)
- Underground Mutants (Industrial Belt poisoning)
- Ghostwalkers (Shadow City anomalies)
- Bureau AI Clones (Mythic tech)

Each variant alters:
- district ecology
- crime patterns
- combat resistances
- event triggers

⭐ EXPANSION SET #103 — UNDERWORLD STOCK EXCHANGE

(A full economy simulation where illegal assets can be traded.)

# 119. SHADOW STOCK EXCHANGE (SSE)

Tradable assets:
- cartel futures
- black market commodities
- laundering tokens
- NPC gang influence shares
- smuggler route derivatives
- mythic artefact futures

Prices influenced by:
- faction wars
- crime density
- cartel monopoly %
- seasonal events
- mega disasters

⭐ EXPANSION SET #104 — CYBERNETIC WARFARE SYSTEM

(Digital combat layer parallel to physical combat.)

# 120. CYBERWAR ENGINE

Factions & players wage digital wars:
- DDoS missions
- data corruption attacks
- backdoor infiltration
- AI clone disabling
- cybernetic sabotage

Combat = “cyber loadout” vs. “defense network.”

Cyber injuries exist:
- neural burn
- memory corruption
- implant failure  

⭐ EXPANSION SET #105 — GENETIC DYNASTY SYSTEM

(Long-term player lineage evolution.)

# 121. DYNASTY ENGINE

Players generate “heirs”:
- stat inheritance
- legacy traits
- genetic mutations
- crime predispositions
- augmented skill trees

Heirs can replace the main character at Prestige tiers.

⭐ EXPANSION SET #106 — CITY TERRAFORMING & LANDSCAPE ALTERATION

(Districts physically evolve based on player & AI activity.)

# 122. TERRAFORM ENGINE

Districts deform under:
- riots
- fires
- floods
- construction
- cartel investments
- corporate expansions
- mythic anomalies

Terrain changes affect:
- movement
- crime difficulty
- faction visibility
- NPC routes

⭐ EXPANSION SET #107 — DIMENSIONAL RAID SYSTEM

(Prestige-level cooperative PvE with alternate-reality bosses.)

# 123. DIMENSION RAID ENGINE

Raids occur through temporal fractures.

Types:
- Shadow Corridors
- Fractured Old Mile
- Inverted Industrial Belt
- Echo Arena (fight your timeline variants)

Rewards:
- mythic shards
- dimensional artefacts
- reality modifiers

⭐ EXPANSION SET #108 — DEEP FACTION IDEOLOGIES

(Factions now have belief systems that drive behaviour.)

# 124. IDEOLOGY ENGINE

Ideologies include:
- Profitism (wealth-first)
- Dominion (territory-first)
- Shadow Creed (stealth-first)
- Violent Ascendancy (war-first)
- Orderism (pseudo-lawful)
- Broken Path (chaos-driven)

Ideologies affect:
- recruitment  
- war behaviour  
- diplomacy  
- crime paths  
- player buffs  

⭐ EXPANSION SET #109 — PLAYER-CREATED CULT SYSTEM

(Prestige level: players can form their own belief networks.)

# 125. CULT CREATION ENGINE

Players create cults with:
- doctrines  
- rituals  
- initiation tests  
- progression ranks  
- belief buffs  

Cults interact with:
- mythos layer  
- NPC fear matrix  
- faction politics  

⭐ EXPANSION SET #110 — PSYCHOLOGICAL WARFARE SYSTEM

(Use intimidation, manipulation, propaganda, and gaslighting as mechanics.)

# 126. PSYWAR ENGINE

Players gain Psywar score based on:
- notoriety  
- interrogation skill  
- cult affiliation  
- mythic influence  
- Echo kills  

Uses:
- break NPC loyalty  
- spread fear in districts  
- demoralise factions  
- manipulate elections  
- cause panic cascades  

⭐ EXPANSION SET #111 — TIME-LOOP GAMEPLAY (Prestige Mythic)

(Replay events with memory retention.)

# 127. TIME LOOP ENGINE

Players can:
- replay missions with new outcomes  
- alter past events  
- unlock loop-only loot  
- carry knowledge forward  

Loops affect:
- NPC memories  
- world tension  
- cult behaviour  
- mythic anomalies  

⭐ EXPANSION SET #112 — WORLD MEMORY IMPRINT SYSTEM

(The world remembers past seasons and reacts to long-term patterns.)

# 128. WORLD MEMORY ENGINE

Tracks:
- past rulers  
- notorious criminals  
- catastrophic events  
- cartel dominance periods  

Long-term memory causes:
- reputation inheritance  
- district trauma  
- forgotten artefacts resurfacing  

⭐ EXPANSION SET #113 — CIVILIZATION-SCALE SIMULATION

(The entire city behaves like a societal organism.)

# 129. SOCIETAL SIM ENGINE

Simulates:
- population growth  
- migration  
- economic classes  
- civil unrest  
- law corruption cycles  
- wealth distribution  

Player groups influence social evolution.

⭐ EXPANSION SET #114 — CULTURAL INFLUENCE & MEDIA CONTROL

(Shape the story of the city.)

# 130. MEDIA CONTROL ENGINE

Players or factions manipulate:
- news outlets  
- underground press  
- propaganda networks  
- viral scandals  
- public sentiment graphs  

⭐ EXPANSION SET #115 — TACTICAL ESPIONAGE THEATRE

(An entire stealth-action simulation layer.)

# 131. ESPIONAGE THEATRE

Maps include:
- rooftops
- underground corridors
- guarded compounds
- secure labs

Features:
- noise traps  
- guard rotations  
- camera grids  
- infiltration gadgets  

⭐ EXPANSION SET #116 — MASS-PERSISTENT HOUSING MARKET

(A live economy for real estates & ownership networks.)

# 132. HOUSING MARKET ENGINE

Tracks:
- supply/demand  
- district wealth  
- infrastructure stability  
- crime density  

Players can:
- flip properties  
- become landlords  
- form real-estate syndicates  

⭐ EXPANSION SET #117 — CORPORATE WARS (Megacorp PvP)

(Corporations fight using lawyers, cyberwaffare, espionage, and sabotage.)

# 133. CORPORATE WAR ENGINE

Uses:
- share manipulation  
- insider leaks  
- hostile takeovers  
- brand warfare  
- blackmail  
- corporate espionage  

⭐ EXPANSION SET #118 — LEGENDARY NPC ASCENSION

(NPCs can ascend to mythic-tier beings.)

# 134. NPC ASCENSION ENGINE

NPCs evolve into:
- mythic overlords  
- cult avatars  
- dimensional wraiths  
- corrupted warlords  

⭐ EXPANSION SET #119 — PLAYER DREAMWORLD SIMULATION

(Prestige mystic system — enter dreams for buffs, missions, lore.)

# 135. DREAMWORLD ENGINE

Dream missions unlock:
- subconscious perks  
- narrative lore fragments  
- psychic traits  

⭐ EXPANSION SET #120 — THE HYPERSTRUCTURE LAW

(Foundational rule for endless expansion.)

# 136. HYPERSTRUCTURE LAW

Every new system must:
- integrate into the world graph  
- never invalidate previous systems  
- scale infinitely  
- generate emergent conflict  
- produce new stories  
⭐ EXPANSION SET #121 — WORLD RELIGION FRAMEWORK

(Global belief systems that influence politics, cults, mythic events, and NPC behaviour.)

# 137. RELIGION FRAMEWORK ENGINE (RFE)

The world contains emergent religions that evolve through:
- historical trauma  
- mythic artefacts  
- political corruption  
- cult uprisings  
- dimensional anomalies  

Religions influence:
- election votes
- cult recruitment
- criminal ethics
- NPC loyalty
- mythic events

---

## 137.1 RELIGION TYPES

### THE PATH OF THE GOLDEN VEIL  
Believes wealth reveals truth; tied to prestige gameplay.

### THE CULT OF THE BROKEN CROWN  
Worships chaos and collapse; triggers city-wide riots.

### THE ORDER OF IRON  
Discipline, martial hierarchy, anti-crime religiosity.

### THE SHADOW CHOIR  
Mystical sect tied to dimensional breaches.

---

## 137.2 RELIGIOUS POWER ACTIONS
- Bless districts  
- Curse NPC factions  
- Influence lawmaking  
- Trigger mythos “surges”  
- Spawn supernatural bosses  

⭐ EXPANSION SET #122 — CROSS-MULTIVERSE FACTION WARS

(Prestige-tier wars across multiple parallel cities.)

# 138. MULTIVERSE WAR ENGINE (MWE)

Prestige 50+ factions unlock “Cross-City Warfare.”
Wars occur between:
- alternate versions of factions  
- mirror-world NPC armies  
- mythic overlords  
- corrupted copies of players  

Victory grants:
- reality anchors  
- dimensional currency  
- mythic artefacts  
- permanent faction perks  

⭐ EXPANSION SET #123 — ELITE ASSET LAUNDERING MARKET

(High-tier player economy using secret banking networks.)

# 139. LAUNDERING MARKET ENGINE

High-value laundering includes:
- crypto laundering  
- art laundering  
- treasury bond laundering  
- cartel crypto-exchange  
- mythic artefact laundering  

Each has risk tiers and cooldown cycles.

Market reacts to:
- police corruption  
- cartel wars  
- world tension  
- economic singularity  

⭐ EXPANSION SET #124 — NPC GENERATIONAL FAMILIES

(NPC “bloodlines” that evolve across seasons.)

# 140. NPC FAMILY ENGINE

NPCs reproduce, marry, feud, and produce heirs.

Families form:
- dynasties  
- vendettas  
- alliances  
- corporate empires  
- gang legacies  

NPC families may:
- remember your ancestors  
- avenge old crimes  
- forge alliances with factions  

⭐ EXPANSION SET #125 — POLITICAL CONSPIRACIES ENGINE

(Shadow-level political intrigue.)

# 141. CONSPIRACY WEB ENGINE

Tracks:
- secret alliances  
- assassination plots  
- bribery chains  
- covert cult influence  
- intelligence leaks  

Players can:
- uncover plots  
- expose rivals  
- become kingmakers  
- be framed  
- manipulate national elections  

⭐ EXPANSION SET #126 — MEGA CASINO EMPIRE SYSTEM

(Own, run, or fight for giant casino empires.)

# 142. CASINO EMPIRE ENGINE

Players or factions control casinos with:
- VIP rooms  
- laundering floors  
- high-stakes pits  
- slot networks  
- underground fight rings  

Casinos influence:
- faction wealth  
- crime density  
- NPC nightlife  

⭐ EXPANSION SET #127 — BLACK HOLE EVENTS (MYTHIC)

(Endgame, reality-breaking anomalies.)

# 143. BLACK HOLE EVENT ENGINE

Dimensional collapses cause:
- gravity distortions  
- time slippage  
- NPC duplication  
- loot fusion events  
- world map distortions  

Only mythic-equipped players can survive the core zone.

⭐ EXPANSION SET #128 — MUTATING CRIME SYSTEMS

(Crime paths that evolve season-to-season.)

# 144. MUTABLE CRIME ENGINE

Crime trees change due to:
- district mutations  
- economic shifts  
- mythic contamination  
- cult rituals  
- weather disasters  

Some crimes mutate into:
- hybrid crimes  
- heist variants  
- eldritch crimes  

⭐ EXPANSION SET #129 — WEAPON ECOSYSTEM 4.0

(Weapons evolve, mutate, gain traits, and develop history.)

# 145. WEAPON ECOSYSTEM 4.0

Weapons gain:
- kill history  
- emotional imprints  
- mythic resonance  
- dimensional distortions  

Weapon traits:
- anomaly burst  
- soul-binding  
- timeline fracture  
- echo damage  

⭐ EXPANSION SET #130 — LEGENDARY CHARACTER CLASSES

(Prestige 100+ class unlocks.)

# 146. LEGENDARY CLASSES

Classes change gameplay rules:

### THE WRAITH  
Stealth goes beyond mechanics — nearly supernatural.

### THE COLOSSUS  
DEF scaling becomes exponential.

### THE ORACLE  
Sees future crime chances & combat outcomes.

### THE EXECUTIONER  
Critical hits rewrite enemy stats.

### THE MYTHWEAVER  
Manipulates reality via artefacts.  

⭐ EXPANSION SET #131 — TACTICAL SQUAD AI SYSTEM

(NPC squad behaviour, flanking, cover logic.)

# 147. SQUAD AI ENGINE

NPC squads:
- coordinate  
- flank  
- breach rooms  
- escort assets  
- retreat intelligently  

Squad morale influences:
- aggression  
- tactical efficiency  
- retreat chance  

⭐ EXPANSION SET #132 — WEATHER SENTIENCE AI

(Weather as a reacting, thinking system.)

# 148. SENTIENT WEATHER ENGINE

Weather “learns” patterns:
- punishes overcrime  
- assists defensive factions  
- reinforces chaos factions  
- affects NPC behaviour  
- interacts with mythic layers  

Weather becomes a character.

⭐ EXPANSION SET #133 — MYTHIC CITY EVOLUTION

(Sometimes the entire city mutates.)

# 149. CITY EVOLUTION v4 (MYTHIC)

City may:
- split into copies  
- merge districts  
- invert geography  
- produce mythic hazards  
- spawn new territories  

⭐ EXPANSION SET #134 — PLAYER ORIGIN MYTH SYSTEM

(Players discover their “origin myth,” altering progression forever.)

# 150. ORIGIN MYTH ENGINE

Origins include:
- Fallen Noble  
- Ghostborn  
- Forgotten Heir  
- Lab Experiment  
- Cult Survivor  
- Dimensional Refugee  

Origins unlock:
- unique paths  
- mythic powers  
- exclusive missions  

⭐ EXPANSION SET #135 — WORLD ENDING CHAINS II

(Advanced multi-stage apocalypse arcs.)

# 151. WORLD DOOM CHAINS

Chains unlock via:
- cult rituals  
- mythic events  
- dimensional breakpoints  

Results include:
- permanent city-wide buffs/debuffs  
- NPC faction ascension  
- boss awakenings  

⭐ EXPANSION SET #136 — DIMENSIONAL CITIES

(Full alternate cities with different physics, lore, and mechanics.)

# 152. DIMENSIONAL CITY ENGINE

Cities include:
- The Glass Citadel  
- Iron Trench  
- Shadow London  
- The Flooded Realm  

Each city uses:
- unique economies  
- alternate combat rules  
- mythic boss cycles  

⭐ EXPANSION SET #137 — MYTHIC PATH SKILL TREES

(Prestige 200+ endgame.)

# 153. MYTHIC PATHS

Paths:
- Path of the Warlord  
- Path of the Oracle  
- Path of the Wraith  
- Path of the Architect  
- Path of the Sovereign  

Each alters **fundamental laws** of gameplay.

⭐ EXPANSION SET #138 — PLAYER REALITY ANCHORS

(Protect players from mythic distortion.)

# 154. REALITY ANCHOR SYSTEM

Anchors:
- prevent corruption  
- stabilise stats  
- allow dimensional travel  
- reduce mythic damage  

⭐ EXPANSION SET #139 — NPC CONFESSION SYSTEM

(NPCs reveal secrets over time.)

# 155. CONFESSION ENGINE

NPCs confess:
- crimes
- hidden alliances
- betrayals
- fears
- mythic knowledge

Confessions trigger unique mission chains.

⭐ EXPANSION SET #140 — MYTH-WEAVER ENGINE (Reality Writing)

(Players can subtly rewrite reality.)

# 156. MYTH-WEAVER LAW

Players with mythic skill trees can:
- alter district rules  
- rewrite enemy stats  
- change loot tables  
- influence weather  
- reshape minor events  

A near-godlike mechanic, balanced by colossal cooldowns.

⭐ EXPANSION SET #141 → #150 — ULTRA SYSTEMS (FINAL FOR THIS BLOCK)

(Pure high-level universe simulation.)

# 157. LIVING TIMELINE ENGINE
World events ripple backward and forward through a timeline web.

# 158. ARCHETYPE ASCENDANCY
Players ascend into archetypes influencing city rules.

# 159. NPC AFTERLIFE SYSTEM
NPC souls persist in the dreamworld, creating mythic missions.

# 160. COSMIC BLACK MARKET
Dimensional goods traded with impossible properties.

# 161. REALITY FRACTURE NETWORK
Persistent distortions that reshape map geometry.

# 162. PLAYER CHRONICLE SYSTEM
The world writes your legend into lore permanently.

# 163. ETERNAL FACTION WAR
Cross-season faction conflict becomes a metagame.

# 164. APOCALYPSE ECONOMY
Trade value shifts under end-of-world conditions.

# 165. THE FORGE OF ORIGINS
A mythic engine that creates new artefacts through player sacrifice.

# 166. THE GRAND PARADOX LAW (System #150)
Time, space, crime, and politics must interlock in a loop where
**player choice echoes across realities**.
⭐ EXPANSION SET #151 — PLAYER-DEFINED MYTHOLOGIES

(Players create their own mythos that influences the world.)

# 167. PLAYER MYTHOLOGY ENGINE (PME)

Prestige 150+ players can define:
- origin stories  
- divine symbols  
- cosmic alignments  
- mythic virtues  
- forbidden truths  

These mythologies:
- attract NPC followers  
- generate cult variants  
- influence district aura  
- unlock unique buffs  
- affect dimensional rifts  

⭐ EXPANSION SET #152 — HYBRID CLASS FUSION TREES

(Fuse two legendary classes to create transcendent builds.)

# 168. FUSION PATH ENGINE

Examples:
WRAITH + ORACLE = THE VEILED FUTURIST  
COLOSSUS + EXECUTIONER = THE IRON JUDGMENT  
ORACLE + MYTHWEAVER = THE LORE ARCHON  

Fusion paths grant:
- dual-class abilities  
- fused skill trees  
- mythic transformations  

⭐ EXPANSION SET #153 — DIMENSIONAL FACTION GOVERNMENTS

(Factions rule multiple realities.)

# 169. CROSS-REALITY GOVERNANCE ENGINE

Factions can:
- annex parallel districts  
- enforce cross-dimensional laws  
- move assets through rifts  
- fight mirror-factions  
- establish “Dimensional Capitals”

Government bonuses:
- rift tax  
- reality stability  
- mythic protection  

⭐ EXPANSION SET #154 — COSMIC-TIER ARTEFACT SYSTEM

(Artefacts that warp fundamental world rules.)

# 170. COSMIC ARTEFACT ENGINE

Artefacts include:
- The Mirror of Infinite Selves  
- The Shard of Beginning  
- The Crown of Echoes  
- The Sunless Heart  
- The Prime Gear  

Abilities:
- rewrite mission outcomes  
- freeze time  
- resurrect districts  
- alter combat physics  
- create or destroy reality anchors  

⭐ EXPANSION SET #155 — THE LEGENDARY TIMELINE SYSTEM

(The universe stores multiple “true timelines” influenced by players.)

# 171. TIMELINE CONFLUENCE ENGINE

Timelines store:
- past seasons  
- alternate arcs  
- failed apocalypses  
- aborted mythic events  

Players can:
- revisit lost timelines  
- steal artefacts from them  
- change history  
- merge two timelines  

⭐ EXPANSION SET #156 — CITY SIMULATION v5 (SENTIENT CITY ENGINE)

(The city itself becomes an evolving AI-driven organism.)

# 172. SENTIENT CITY ENGINE (SCE)

The city tracks:
- happiness  
- corruption  
- fear levels  
- mythic influence  
- population density  

The city “responds” via:
- altered crime difficulty  
- NPC micro-behaviour  
- infrastructure shifts  
- new district formations  
- mythic awakenings  

⭐ EXPANSION SET #157 — VOID INVASION SYSTEM

(Entities from the Void threaten the city.)

# 173. VOID INVASION ENGINE

Void effects:
- distort districts  
- rewrite physics  
- corrupt NPCs  
- empower cults  
- trigger endgame raids  

Players must stabilize reality via:
- anchors  
- artefacts  
- mythic sacrifices  

⭐ EXPANSION SET #158 — MYTHIC DIPLOMACY SYSTEM

(Negotiations between factions, cults, dimensional rulers, mythic bosses.)

# 174. MYTHIC DIPLOMACY ENGINE

Negotiators use:
- cosmic favours  
- dimensional threats  
- time-loop knowledge  
- artefact leverage  

Diplomacy results:
- ceasefires  
- cosmic wars  
- mythic alliances  
- forced rift closures  

⭐ EXPANSION SET #159 — COSMIC STOCK MARKETS

(Economics beyond reality.)

# 175. COSMIC MARKET ENGINE

Trade:
- fragments of timelines  
- void energy futures  
- mythic resource bonds  
- fluctuation derivatives  

Market responds to:
- dimensional events  
- player ascensions  
- cult awakenings  

⭐ EXPANSION SET #160 — THE ANTI-GOD EVENT

(A cosmic-scale crisis challenge.)

# 176. ANTI-GOD ENGAGEMENT

The Anti-God is the embodiment of:
- collapse  
- entropy  
- annihilation  

Event includes:
- 5-stage cosmic raid  
- timeline distortions  
- mass NPC corruption  
- world-ending risk  

⭐ EXPANSION SET #161 — PERSONAL DIMENSION SANCTUMS

(Players build private dimensions.)

# 177. SANCTUM ENGINE

Sanctums include:
- dimensional gardens  
- echo chambers  
- meditation halls  
- mythic vaults  

Benefits:
- buffs  
- storage  
- timeline gateways  
- stat resonance fields  

⭐ EXPANSION SET #162 — CHIMERA CHARACTER BUILDS

(Fuse augmentations, genetic mods, artefacts, and mythic abilities.)

# 178. CHIMERA ENGINE

Chimeras combine:
- cybernetics  
- genetics  
- mythical essence  
- artefact attunement  
- dimensional fragments  

Creates hybrid builds never possible before.

⭐ EXPANSION SET #163 — PLAYER GHOST NETWORKS

(Players leave spectral copies that help or hinder others.)

# 179. GHOST NETWORK ENGINE

Ghosts:
- assist allies  
- haunt enemies  
- warn about dangers  
- serve in raids  
- reveal secrets  

⭐ EXPANSION SET #164 — THE GREAT RIFT MAP

(A new map layer with reality-breaking geometry.)

# 180. GREAT RIFT ENGINE

Rift zones:
- rotate  
- shift  
- collapse  
- spawn anomalies  
- contain cosmic loot  

⭐ EXPANSION SET #165 — EMERGENT REALITY PHYSICS

(World physics mutate based on lore and player actions.)

# 181. REALITY PHYSICS ENGINE

Physics may:
- soften  
- invert  
- accelerate  
- freeze  
- echo  

⭐ EXPANSION SET #166 — COSMIC CRIME PATHS

(Crimes at the scale of universes.)

# 182. COSMIC CRIME ENGINE

Crimes include:
- timeline robbery  
- artefact heists  
- cosmic smuggling  
- void harvesting  

⭐ EXPANSION SET #167 — MYTHIC PARTY SYSTEM

(Party composition gives narrative buffs.)

# 183. PARTY ENGINE

Synergy perks based on:
- mythic alignment  
- origin stories  
- artefact resonance  
- emotional bonds  

⭐ EXPANSION SET #168 — PLAYER-CRAFTED DIMENSIONAL BOSSES

(Players build their own boss encounters.)

# 184. DIMENSIONAL BOSS FORGE

Define:
- powers  
- weaknesses  
- phases  
- loot pool  
- mythic lore  

⭐ EXPANSION SET #169 — FACTION REALITY FORTRESSES

(Cosmic-scale HQs that defend against void threats.)

# 185. REALITY FORTRESS ENGINE

Fortresses include:
- stabilisation cores  
- mythic cannons  
- dimensional shields  
- echo libraries  

⭐ EXPANSION SET #170 — WORLD ORIGIN REWRITE

(Endgame prestige: players rewrite the origin story of the universe.)

# 186. ORIGIN REWRITE ENGINE

Players can:
- redefine lore  
- resurrect forgotten factions  
- destroy mythic beings  
- reset cosmic laws  

⭐ EXPANSION SET #171 — THE VOICE OF THE CITY

(A sentient narrator responds to player actions.)

# 187. CITY VOICE ENGINE

The city speaks:
- warnings  
- visions  
- quests  
- mythic prophecies  

⭐ EXPANSION SET #172 — DREAMWARS

(Dreamworld PvP & PvE.)

# 188. DREAMWAR ENGINE

Battles occur in dream formations influenced by:
- trauma  
- mythic resonance  
- subconscious fears  

⭐ EXPANSION SET #173 — INFINITE ASCENSION TREE

(An endless skill tree.)

# 189. ASCENSION TREE ENGINE

Branches:
- cosmic mastery  
- mythic dominion  
- temporal control  
- void resistance  

⭐ EXPANSION SET #174 — WORLD-SHAPING MYTHS

(Myths become systems.)

# 190. WORLD-MYTH ENGINE

Myths generate:
- artefacts  
- bosses  
- events  
- laws  

⭐ EXPANSION SET #175 — LEGENDARY PLAYER EPOCHS

(Players create ages of history.)

# 191. EPOCH ENGINE

Epochs represent:
- your reign  
- your downfall  
- your resurrection  

⭐ EXPANSION SET #176 — VOIDFLESH MUTATION SYSTEM

(Mutations tied to void exposure.)

# 192. VOIDFLESH ENGINE

Mutations:
- sensory overgrowth  
- echo organs  
- void tendrils  

⭐ EXPANSION SET #177 — DIMENSIONAL NAVIGATION SYSTEM

(Travel between realities as a mini-game.)

# 193. RIFT NAVIGATION ENGINE

Players must:
- stabilise  
- navigate  
- anchor  
- map rifts  

⭐ EXPANSION SET #178 — SUPREME FACTION EVOLUTION

(Factions transform into cosmic entities.)

# 194. SUPREME FACTION ENGINE

Factions evolve into:
- mythic collectives  
- cosmic monarchies  
- void cult nations  

⭐ EXPANSION SET #179 — SENTIENT ARTEFACTS

(Artefacts gain personalities & will.)

# 195. LIVING ARTEFACT ENGINE

Artefacts speak to players and influence destiny.

⭐ EXPANSION SET #180 — THE FINAL ASCENSION SYSTEM (SYSTEM #200)

(The ultimate transformation path.)

# 196. ASCENSION ENGINE

The final path:
- transcend mortality  
- rewrite laws  
- reshape cities  
- anchor reality  
- become a cosmic sovereign  
 Trench City — OpenAPI Specification (Ultra Edition)
Version: 2025.1  
Format: OpenAPI 3.1.0  
Authoritative for ALL API endpoints including Web, Mobile, and Worker Services.

============================================================
# 1. GLOBAL OPENAPI DECLARATION
============================================================

openapi: 3.1.0
info:
  title: Trench City API
  description: >
    Official API specification for all backend, frontend, and mobile integrations.
    This API is authoritative and MUST be followed by Architect and CodeGPT.
  version: 2025.1

servers:
  - url: https://api.trench.city/v1
    description: Production API
  - url: https://staging.trench.city/v1
    description: Staging API
  - url: http://localhost:8000/v1
    description: Local Development

============================================================
# 2. GLOBAL API RULES
============================================================

- All API responses MUST use the Unified Response Envelope.
- All errors MUST follow the Error Model (Section 5).
- All authenticated routes require Bearer JWT.
- All sensitive actions require:
  - timestamp
  - digital signature
  - anti-replay nonce
- Rate limiting enforced by Redis counters.
- All endpoints MUST be versioned under `/v1`.
- All endpoints MUST be idempotent where applicable.
- Mobile and Web share the same endpoints unless explicitly separated.

============================================================
# 3. UNIFIED RESPONSE ENVELOPE
============================================================

### 3.1 Success Format
```json
{
  "success": true,
  "data": { ... },
  "meta": {
    "timestamp": 1736112000,
    "server": "web-02",
    "version": "v1.0.0"
  }
}
3.2 Error Format
json
Copy code
{
  "success": false,
  "error": {
    "code": "ERR_INVALID_INPUT",
    "message": "Invalid item ID.",
    "details": {},
    "status": 400
  }
}
============================================================

4. AUTHENTICATION
============================================================

4.1 Login
POST /auth/login
Body:

username

password

Response:

JWT

refresh token

user object

4.2 Refresh Token
POST /auth/refresh
Returns new access token.

4.3 Logout
POST /auth/logout
Invalidates refresh token + session.

4.4 Security Notes
JWT expiry = 15 min

Refresh expiry = 30 days

IP binding optional (mobile disabled)

============================================================

5. ERROR MODEL (CANONICAL)
============================================================

Error codes MUST come from this table only:

Code	Meaning
ERR_INVALID_INPUT	Bad request body / missing fields
ERR_INVALID_AUTH	Token invalid or expired
ERR_NOT_FOUND	Resource not found
ERR_FORBIDDEN	Player lacks permissions
ERR_RATE_LIMIT	Too many requests
ERR_SIGNATURE_INVALID	Digital signature mismatch
ERR_REPLAY_ATTACK	Nonce re-use detected
ERR_INSUFFICIENT_RESOURCES	Not enough energy/nerve/money/etc.
ERR_ACTION_LOCKED	Action on cooldown
ERR_ANTI_CHEAT_TRIGGERED	Anti-exploit system halted request
ERR_INTERNAL	Something unexpected occurred

============================================================

6. SECURITY HEADERS
============================================================

All requests require:

Header	Purpose
X-TC-Timestamp	UNIX timestamp
X-TC-Nonce	Random nonce
X-TC-Signature	HMAC-SHA256(signature_key, body + timestamp + nonce)

Signature is required for:

combat

crimes

items (use/equip)

faction actions

chain hits

raids & wars

trades

market/auction

============================================================

7. PAGINATION FORMAT
============================================================

Query params:

pgsql
Copy code
?limit=25&offset=0
Response:

json
Copy code
"meta": {
  "limit": 25,
  "offset": 0,
  "total": 420
}
============================================================

8. API MODULE INDEX
============================================================

Every module MUST expose:

GET (list/filter)

GET/:id (details)

POST (create action)

PUT/PATCH (update)

POST/action endpoints for gameplay events

Modules:

/auth

/user

/stats

/bars

/gym

/crimes

/items

/inventory

/equipment

/properties

/mail

/city

/faction

/faction/chains

/faction/wars

/raids

/missions

/market

/auction

/bank

/travel

/vehicles

/companies

/country

/admin

============================================================

9. SCHEMA DEFINITIONS (CORE)
============================================================

9.1 User Schema
yaml
Copy code
User:
  type: object
  properties:
    id: { type: integer }
    username: { type: string }
    level: { type: integer }
    xp: { type: integer }
    money: { type: integer }
    faction_id: { type: integer, nullable: true }
    property_id: { type: integer, nullable: true }
    stats:
      $ref: '#/components/schemas/Stats'
    bars:
      $ref: '#/components/schemas/Bars'
9.2 Stats Schema
yaml
Copy code
Stats:
  type: object
  properties:
    strength: { type: integer }
    speed: { type: integer }
    defense: { type: integer }
    dexterity: { type: integer }
9.3 Bars Schema
yaml
Copy code
Bars:
  type: object
  properties:
    energy: { type: integer }
    nerve: { type: integer }
    happy: { type: integer }
    life: { type: integer }
============================================================

10. ITEMS SYSTEM SCHEMAS
============================================================

10.1 Item
yaml
Copy code
Item:
  type: object
  properties:
    id: { type: integer }
    name: { type: string }
    type: { type: string } # consumable, weapon, armor, misc
    rarity: { type: string }
    effect: { type: string }
    stat_bonus: 
      type: object
      properties:
        strength: { type: integer }
        speed: { type: integer }
        defense: { type: integer }
        dexterity: { type: integer }
10.2 InventoryItem
yaml
Copy code
InventoryItem:
  type: object
  properties:
    id: { type: integer }
    user_id: { type: integer }
    item_id: { type: integer }
    quantity: { type: integer }
============================================================

11. CRIMES SYSTEM SCHEMAS
============================================================

yaml
Copy code
Crime:
  type: object
  properties:
    id: { type: integer }
    name: { type: string }
    nerve_cost: { type: integer }
    difficulty: { type: integer }
    reward_cash_min: { type: integer }
    reward_cash_max: { type: integer }
    reward_xp: { type: integer }
    fail_chance: { type: number }
============================================================

12. COMBAT SYSTEM SCHEMAS
============================================================

yaml
Copy code
AttackRequest:
  type: object
  properties:
    target_id: { type: integer }
    signature: { type: string }

AttackResult:
  type: object
  properties:
    success: { type: boolean }
    damage_dealt: { type: integer }
    target_life: { type: integer }
    logs: { type: array, items: { type: string } }
============================================================

13. FACTION SYSTEM (CORE)
============================================================

yaml
Copy code
Faction:
  type: object
  properties:
    id: { type: integer }
    name: { type: string }
    description: { type: string }
    respect: { type: integer }
    members: 
      type: array
      items:
        $ref: '#/components/schemas/User'
============================================================

14. CHAINS API SCHEMAS (ULTRA)
============================================================

yaml
Copy code
ChainHit:
  type: object
  properties:
    hit_id: { type: integer }
    faction_id: { type: integer }
    attacker_id: { type: integer }
    defender_id: { type: integer }
    xp: { type: integer }
    combo: { type: integer }
    timestamp: { type: integer }
============================================================

15. RAID SYSTEM SCHEMAS (ULTRA)
============================================================

yaml
Copy code
Raid:
  type: object
  properties:
    id: { type: integer }
    boss_id: { type: integer }
    phase: { type: string }
    morale: { type: number }
    participants:
      type: array
      items:
        $ref: '#/components/schemas/User'
============================================================

16. PROPERTIES SYSTEM SCHEMAS
============================================================

yaml
Copy code
Property:
  type: object
  properties:
    id: { type: integer }
    name: { type: string }
    happy_bonus: { type: integer }
    capacity: { type: integer }
============================================================

17. MARKET / ECONOMY SCHEMAS
============================================================

yaml
Copy code
MarketListing:
  type: object
  properties:
    id: { type: integer }
    item_id: { type: integer }
    seller_id: { type: integer }
    price: { type: integer }
    quantity: { type: integer }
============================================================

18. ADMIN API SCHEMAS
============================================================

yaml
Copy code
AdminUserAction:
  type: object
  properties:
    admin_id: { type: integer }
    target_user_id: { type: integer }
    action: { type: string }
    reason: { type: string }
============================================================

19. MOBILE API RULES
============================================================

Mobile API MUST:

mirror all core endpoints

use lightweight schemas

allow compressed responses

accept reduced refresh windows

============================================================

20. FUTURE EXTENSIONS (PROTECTED SLOTS)
============================================================

Territories API

Seasonal Director API

NPC / Mission AI API

Workshop / Crafting API

Vehicle Racing API

============================================================

END OF OpenAPI_Spec.md




