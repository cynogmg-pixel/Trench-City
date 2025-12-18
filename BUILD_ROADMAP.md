# Trench City V2 - Complete Build Roadmap
## From Alpha to Full Release

---

## Current Status: Alpha 1.0 Complete ✅

**Date:** 2025-12-18
**Completion:** 21.7% (10/46 planned modules)
**Security Grade:** A
**Production Ready:** Yes (for alpha testing)

### What's Working Right Now:
✅ Authentication (login/register)
✅ Dashboard with stats
✅ Crimes (21 crimes, 5 categories)
✅ Gym (training with 5 tiers)
✅ Combat (PvP with hospital system)
✅ Bank (deposit/withdraw/transfer)
✅ Mail (send/receive messages)
✅ Market (buy/sell 18 items)
✅ Jobs (15 jobs, 3 tiers, cooldown system)
✅ Settings (password/email change)

### What's Integrated:
✅ Items → Combat stats
✅ XP → Leveling
✅ Cash → Market economy
✅ Stats → Crime success rates
✅ Energy → Training/Combat
✅ Nerve → Crimes

---

## Phase 1: Polish Alpha (1-2 weeks)

**Goal:** Make existing features shine before adding new ones

### 1.1 UI/UX Improvements
**Priority:** HIGH
**Effort:** 1 week

- [ ] Responsive mobile layout for all pages
- [ ] Add loading spinners on form submissions
- [ ] Improve error message styling
- [ ] Add success animations
- [ ] Create consistent card layouts
- [ ] Add tooltips for complex features
- [ ] Improve navigation sidebar
- [ ] Add breadcrumb navigation

**Files to modify:**
- `includes/postlogin-header.php`
- `includes/postlogin-sidebar.php`
- All public pages (market.php, jobs.php, etc.)

### 1.2 Balance Tuning
**Priority:** MEDIUM
**Effort:** 3 days

- [ ] Adjust crime success rates based on playtesting
- [ ] Balance item prices vs earnings
- [ ] Tune XP requirements for leveling
- [ ] Adjust gym training costs
- [ ] Balance combat damage calculations
- [ ] Set appropriate job cooldown times

**Files to modify:**
- `core/crimes_data.sql` (crime rewards)
- `core/market_schema.sql` (item prices)
- `core/jobs_schema.sql` (job pay)
- `modules/combat/combat_shell.php` (damage calc)

### 1.3 Performance Optimization
**Priority:** MEDIUM
**Effort:** 2 days

- [ ] Add missing database indexes (6 identified in audit)
- [ ] Implement query caching for static data
- [ ] Optimize combat stat calculations
- [ ] Add Redis caching for leaderboards
- [ ] Minimize redundant database calls

**Files to modify:**
- Create `core/add_indexes.sql`
- `modules/combat/combat_shell.php`
- `public/leaderboards.php`

### 1.4 Bug Fixes & Edge Cases
**Priority:** HIGH
**Effort:** 2 days

- [ ] Handle negative cash exploits
- [ ] Prevent selling equipped items
- [ ] Fix jail/hospital timer display
- [ ] Handle concurrent attacks gracefully
- [ ] Validate all numeric inputs
- [ ] Add rate limiting to all POST handlers

**Files to modify:**
- `public/market.php` (prevent selling equipped)
- All module shells (add rate limiting)
- `core/helpers.php` (add validation functions)

---

## Phase 2: Core Expansion (3-4 weeks)

**Goal:** Add essential RPG features that tie into existing systems

### 2.1 Faction/Gang System
**Priority:** HIGH (player-requested)
**Effort:** 1 week

**Features:**
- Create/join factions
- Faction wars (territory control)
- Faction bank (shared resources)
- Faction chat
- Faction perks (bonuses for members)
- Faction ranks with permissions

**New Files:**
- `core/factions_schema.sql`
- `modules/factions/factions_shell.php`
- `public/factions.php`

**Integrations:**
- Faction bonuses affect combat stats
- Faction wars consume faction bank funds
- Crimes can benefit faction (shared XP/cash)

### 2.2 Achievement System
**Priority:** HIGH (retention)
**Effort:** 4 days

**Features:**
- 50+ achievements across all modules
- Progressive achievements (bronze/silver/gold)
- Reward bonuses (cash/XP/special items)
- Achievement showcase on profile
- Notifications on unlock

**New Files:**
- `core/achievements_schema.sql`
- `modules/achievements/achievements_shell.php`
- `public/achievements.php`

**Achievement Categories:**
- Combat (100 wins, 1000 wins, etc.)
- Crimes (complete all crimes, commit 1000 crimes)
- Training (max all stats, train 1000 times)
- Economic (earn $1M, own all items)
- Social (recruit 10 players, send 100 mails)

### 2.3 Mission System
**Priority:** HIGH (structured gameplay)
**Effort:** 1 week

**Features:**
- Daily missions (3 random per day)
- Story missions (progressive campaign)
- Faction missions (team objectives)
- Mission tiers (easy/medium/hard)
- Mission rewards (better than crimes)
- Mission streaks (complete 7 days in a row)

**New Files:**
- `core/missions_schema.sql`
- `modules/missions/missions_shell.php`
- `public/missions.php`

**Mission Types:**
- "Commit 5 petty thefts" → reward: $5,000
- "Win 3 combat attacks" → reward: $10,000
- "Train strength 10 times" → reward: 50,000 XP
- "Buy item worth $5,000+" → reward: rare item

### 2.4 Item System Expansion
**Priority:** MEDIUM
**Effort:** 3 days

**Features:**
- Item rarity tiers (common/uncommon/rare/legendary)
- Item durability (break after X uses)
- Item repair shop
- Item upgrade system
- Item sets (equip 3/5 for set bonus)
- Special item effects (lifesteal, dodge chance)

**Files to modify:**
- `core/market_schema.sql` (add rarity, durability fields)
- `public/market.php` (show rarity colors)
- `modules/combat/combat_shell.php` (reduce durability on use)

**Item Rarity Colors:**
- Common: White
- Uncommon: Green
- Rare: Blue
- Epic: Purple
- Legendary: Gold

---

## Phase 3: World Building (2-3 weeks)

**Goal:** Create a living, breathing game world

### 3.1 Travel System
**Priority:** MEDIUM
**Effort:** 1 week

**Features:**
- 5 cities with unique characteristics
- Travel costs (time + money)
- City-specific crimes/jobs
- City-specific items
- City bonuses (higher crime success in certain cities)
- Fast travel (instant for higher cost)

**New Files:**
- `core/cities_schema.sql`
- `modules/travel/travel_shell.php`
- `public/travel.php`

**Cities:**
1. **Trench City** (starter city) - balanced
2. **Neon Heights** - high-tech crimes, expensive items
3. **The Docks** - smuggling, cheap items
4. **Downtown** - organized crime, casinos
5. **Suburbs** - legitimate jobs, low risk

### 3.2 Property System
**Priority:** MEDIUM
**Effort:** 5 days

**Features:**
- Buy houses/apartments/mansions
- Passive income from properties
- Property upgrades
- Property storage (extra inventory space)
- Property protection (reduce raid success)

**New Files:**
- `core/properties_schema.sql`
- `modules/properties/properties_shell.php`
- `public/properties.php`

**Property Types:**
- **Apartment:** $50K, $500/day income
- **House:** $200K, $2K/day income
- **Mansion:** $1M, $10K/day income
- **Warehouse:** $500K, 100 extra inventory slots
- **Casino:** $5M, $50K/day income

### 3.3 Vehicle System
**Priority:** LOW
**Effort:** 3 days

**Features:**
- Vehicles provide speed bonuses
- Vehicle garages (store multiple vehicles)
- Vehicle upgrades (engine, armor)
- Vehicle racing (mini-game)
- Getaway success bonus in crimes

**Files to modify:**
- Market already has vehicles, just need to:
- Add vehicle effects to crimes
- Add racing mechanic
- Add garage storage

---

## Phase 4: Advanced Features (3-4 weeks)

**Goal:** Deep endgame content

### 4.1 Casino & Gambling
**Priority:** MEDIUM (player-requested)
**Effort:** 1 week

**Features:**
- Slots machine
- Blackjack
- Poker (player vs dealer)
- Roulette
- Lottery (daily draw)
- High roller room (high stakes)

**New Files:**
- `core/casino_schema.sql`
- `modules/casino/casino_shell.php`
- `public/casino.php`

**Games:**
- **Slots:** Bet $100-$10,000, RTP 95%
- **Blackjack:** Bet $500-$50,000, RTP 99%
- **Lottery:** Ticket $1,000, jackpot $1M+

### 4.2 Stock Market
**Priority:** LOW (advanced economy)
**Effort:** 1 week

**Features:**
- 10 companies with fluctuating stock prices
- Buy/sell shares
- Dividends (passive income)
- Stock news (affects prices)
- Portfolio tracking

**New Files:**
- `core/stocks_schema.sql`
- `modules/stocks/stocks_shell.php`
- `public/stocks.php`

**Stock Companies:**
1. **TechCorp** (volatile, high risk/reward)
2. **SafeBank** (stable, low risk)
3. **WeaponsCo** (affected by war/peace)
4. **RealEstate** (slow growth)
5. **Casino Royale** (affected by gambling activity)

### 4.3 NPC & Bounty System
**Priority:** MEDIUM
**Effort:** 5 days

**Features:**
- NPCs with unique personalities
- NPC missions (one-time quests)
- Player bounties (place bounty on rival)
- Bounty hunting (earn cash killing bounties)
- Wanted level (affects jail time)

**New Files:**
- `core/npcs_schema.sql`
- `core/bounties_schema.sql`
- `modules/npcs/npcs_shell.php`
- `modules/bounties/bounties_shell.php`
- `public/bounties.php`

**NPCs:**
- **Vinny the Fence** - buys stolen goods for 150% value
- **Mad Dog Mike** - offers dangerous missions
- **Dr. Feelgood** - reduces hospital time for $$$
- **Dirty Cop Dave** - can bust you out of jail

### 4.4 Event System
**Priority:** HIGH (engagement)
**Effort:** 4 days

**Features:**
- Daily events (2x XP hour)
- Weekly events (faction wars)
- Seasonal events (holiday themes)
- Random events (bank heist, police raid)
- Event leaderboards
- Exclusive event rewards

**New Files:**
- `core/events_schema.sql`
- `modules/events/events_shell.php`
- `public/events.php`

**Event Types:**
- **Happy Hour:** 2x cash from crimes (1 hour/day)
- **Training Day:** 50% off gym training
- **Market Crash:** 30% off all items
- **Police Crackdown:** 2x jail risk, 3x rewards
- **Faction War Weekend:** Territory battles

---

## Phase 5: Social & Community (2 weeks)

**Goal:** Build player retention through social features

### 5.1 Enhanced Chat System
**Priority:** HIGH
**Effort:** 4 days

**Features:**
- Global chat (all players)
- Faction chat (faction members only)
- Private messages (enhanced mail)
- Trade chat (marketplace discussions)
- Chat moderation (report/ban)
- Emotes and reactions

**New Files:**
- `core/chat_schema.sql`
- `modules/chat/chat_shell.php`
- `public/chat.php`

**Technical:**
- WebSocket or long-polling for real-time updates
- Rate limiting (1 message per 2 seconds)
- Profanity filter

### 5.2 Forum System
**Priority:** MEDIUM
**Effort:** 5 days

**Features:**
- Multiple forum categories
- Thread creation/replies
- Upvote/downvote system
- Thread pinning (moderators)
- User signatures
- Thread subscriptions (notifications)

**New Files:**
- `core/forum_schema.sql`
- `modules/forum/forum_shell.php`
- `public/forum.php`

**Forum Categories:**
- General Discussion
- Game Guides & Tips
- Faction Recruitment
- Trading Post
- Bug Reports
- Suggestions

### 5.3 Friends & Rivals System
**Priority:** MEDIUM
**Effort:** 3 days

**Features:**
- Add friends (mutual)
- Friends list with online status
- Friend bonuses (5% cash boost when playing together)
- Rival system (mark enemy, get bonus for defeating)
- Friend activities feed

**New Files:**
- `core/friends_schema.sql`
- `modules/friends/friends_shell.php`
- `public/friends.php`

### 5.4 Newspaper & Game Logs
**Priority:** LOW
**Effort:** 2 days

**Features:**
- Daily newspaper (auto-generated)
- Major events (biggest heist, richest player)
- Player achievements featured
- In-game advertisements
- Historical logs

**New Files:**
- `core/newspaper_schema.sql`
- `modules/newspaper/newspaper_shell.php`
- `public/newspaper.php`

---

## Phase 6: Admin & Management (1 week)

**Goal:** Tools for game management

### 6.1 Admin Panel
**Priority:** HIGH
**Effort:** 4 days

**Features:**
- User management (ban/unban/delete)
- Economy tools (adjust prices, give items)
- Database browser
- Server statistics
- Moderation queue
- Announcement system

**New Files:**
- `modules/admin/admin_shell.php`
- `public/admin.php`

**Admin Permissions:**
- **Super Admin:** Full access
- **Moderator:** Ban users, delete messages
- **Support:** View tickets, no bans

### 6.2 Analytics Dashboard
**Priority:** MEDIUM
**Effort:** 2 days

**Features:**
- Daily active users (DAU)
- Revenue tracking (if monetized)
- Popular features (most used)
- Player retention rates
- Economy health (inflation tracking)

**New Files:**
- `modules/analytics/analytics_shell.php`
- `public/analytics.php`

### 6.3 Support Ticket System
**Priority:** MEDIUM
**Effort:** 2 days

**Features:**
- Players submit tickets
- Admin/mod responses
- Ticket categories (bug/account/other)
- Ticket status tracking
- Email notifications

**New Files:**
- `core/support_schema.sql`
- `modules/support/support_shell.php`
- `public/support.php`

---

## Phase 7: Monetization (Optional, 1 week)

**Goal:** Sustainable revenue without pay-to-win

### 7.1 Premium Membership
**Features:**
- $5/month subscription
- **Benefits:**
  - 2x energy/nerve regeneration
  - 10% discount on market items
  - Exclusive cosmetic items
  - Priority support
  - No ads (if you add them)
  - Custom profile themes

**Implementation:**
- Stripe or PayPal integration
- Premium status in users table
- Check premium status in energy regen code

### 7.2 Cosmetic Shop
**Features:**
- Profile borders
- Custom avatars
- Chat badges
- Name colors
- Victory animations
- **Priced:** $1-$10 per cosmetic

**Rules:**
- NO stat bonuses (not pay-to-win)
- All cosmetics are visual only

### 7.3 Energy/Nerve Refills (Controversial)
**Features:**
- $1 = Full energy refill
- $1 = Full nerve refill
- Limit: 3 refills per day

**Balancing:**
- Expensive enough to not break economy
- Limited enough to not be pay-to-win
- Consider removing if community backlash

---

## Phase 8: Mobile App (Optional, 4-6 weeks)

**Goal:** Native mobile experience

### 8.1 React Native App
**Features:**
- iOS + Android from single codebase
- Push notifications
- Offline mode (cache data)
- Biometric login
- Better performance than mobile web

**Tech Stack:**
- React Native
- Redux for state management
- API-first architecture (build REST API)

### 8.2 REST API Development
**Required for mobile app:**
- `/api/v1/auth/login` (POST)
- `/api/v1/crimes/list` (GET)
- `/api/v1/crimes/commit` (POST)
- `/api/v1/market/items` (GET)
- `/api/v1/market/buy` (POST)
- ... (full API for all features)

**New Files:**
- `api/v1/` directory
- JWT authentication
- Rate limiting per endpoint

---

## Effort Summary

| Phase | Priority | Effort | Completion |
|-------|----------|--------|------------|
| **Phase 1: Polish Alpha** | HIGH | 2 weeks | 0% |
| **Phase 2: Core Expansion** | HIGH | 4 weeks | 0% |
| **Phase 3: World Building** | MEDIUM | 3 weeks | 0% |
| **Phase 4: Advanced Features** | MEDIUM | 4 weeks | 0% |
| **Phase 5: Social & Community** | HIGH | 2 weeks | 0% |
| **Phase 6: Admin & Management** | HIGH | 1 week | 0% |
| **Phase 7: Monetization** | OPTIONAL | 1 week | 0% |
| **Phase 8: Mobile App** | OPTIONAL | 6 weeks | 0% |

**Total Effort (excluding optional):** ~16 weeks (4 months)
**Total Effort (including optional):** ~23 weeks (5.75 months)

---

## Recommended Build Order

### Sprint 1 (Week 1-2): Phase 1 - Polish
Make what exists perfect before adding more

### Sprint 2 (Week 3-6): Phase 2 - Core Expansion
Factions, Achievements, Missions - high player engagement

### Sprint 3 (Week 7-9): Phase 5 - Social
Chat, Forums, Friends - build community

### Sprint 4 (Week 10-13): Phase 3 - World Building
Travel, Properties - add depth

### Sprint 5 (Week 14-17): Phase 4 - Advanced
Casino, Events, NPCs - endgame content

### Sprint 6 (Week 18-19): Phase 6 - Admin
Tools for managing growing player base

### Sprint 7 (Week 20+): Phase 7 & 8 - Optional
Monetization and mobile if needed

---

## Development Team Recommendations

**For Solo Developer:** Follow sprints in order, 1-2 features per week

**For Small Team (2-3 devs):**
- Dev 1: Backend (schemas, shell logic)
- Dev 2: Frontend (UI, forms, styling)
- Dev 3: Integration & Testing

**For Larger Team (5+ devs):**
- Parallel development of multiple phases
- Complete in 8-10 weeks instead of 16+

---

## Testing Strategy

### Alpha Testing (Now - Phase 1)
- 10-20 closed alpha testers
- Focus on finding bugs
- Balance tuning

### Beta Testing (Phase 2-3)
- 100-200 beta testers
- Test social features at scale
- Economy balancing
- Server load testing

### Soft Launch (Phase 4-5)
- 1,000+ players
- Marketing campaign
- Monitor server stability
- Community building

### Full Launch (Phase 6+)
- Open to public
- Press release
- Continuous updates

---

## Success Metrics

Track these KPIs throughout development:

### Engagement:
- Daily Active Users (DAU)
- Session duration (target: 30+ min/session)
- Retention rate (D1, D7, D30)

### Economy:
- Average player cash
- Market transaction volume
- Inflation rate

### Social:
- Faction membership rate
- Mail/chat messages per day
- Forum posts per day

### Monetization (if applicable):
- Conversion rate (free → paid)
- Average revenue per user (ARPU)
- Lifetime value (LTV)

---

## Technical Debt

Issues to address during development:

1. **Consolidate Module Locations**
   - Move all shells to single location
   - Update all require paths

2. **Database Schema Migrations**
   - Create migration system
   - Version control schema changes

3. **Code Documentation**
   - PHPDoc comments on all functions
   - API documentation
   - Developer onboarding guide

4. **Testing Framework**
   - Unit tests for core functions
   - Integration tests for workflows
   - Load testing for scale

5. **CI/CD Pipeline**
   - Automated testing on commit
   - Automated deployment to staging
   - Database backup before deployment

---

## Final Notes

**This is a living document.** As development progresses:
- Priorities may shift based on player feedback
- New features may be added
- Features may be cut if not engaging
- Timelines are estimates, not guarantees

**Focus on quality over quantity.** It's better to have 10 polished features than 46 half-working ones.

**Listen to your players.** They'll tell you what they want. Build that, not what you think they want.

**Ship often.** Weekly or bi-weekly updates keep players engaged.

---

**Last Updated:** 2025-12-18
**Version:** 1.0
**Status:** Phase 1 Ready to Begin
