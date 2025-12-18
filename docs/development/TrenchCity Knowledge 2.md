# SECTION 000 — MASTER INDEX & WORKER GUIDE

## 0.1 What This Bible Is

This Bible is the master game design document for **Trench City**, covering all core systems, subsystems, overlays, economy, and progression. Each `SECTION_###.md` file is a self-contained design chapter with mechanics, edge cases, and worker notes for Architect, Code, Balance, and QA.

It is written as a **systems Bible** (not lore): it defines how the game works,
how players progress, and how every major feature should behave.

## 0.2 Reading Order (Human)

- **Foundation (001–020):** Core identity, stats, combat, XP/level, money, items, gym, crimes, factions, city, jobs, education, travel, properties, casino, stocks, missions.
- **Core Systems & Expansions (021–080):** Deeper mechanics, risk systems, logs, NPCs, events, advanced combat, territory, chains, raids, black ops, special modes.
- **Overlays, Flavour & Late Systems (081–152):** Drugs/alcohol, fashion, armour, pets, vehicles, collectibles, meta-systems, overlays and long-tail features.

You **do not** need to read everything in one go:
- When working on a feature, jump to the relevant SECTION and skim related ones.
- Use the worker notes at the bottom of each section to know how to apply it.

## 0.3 Section Table of Contents

| Section | File | Title | Notes |
|--------:|------|-------|-------|
| 001 | `SECTION_001.md` | WORLD, SETTING, THEME & NAMING ENGINE | Core / Read early |
| 002 | `SECTION_002.md` | PLAYER IDENTITY & PROFILE | Core / Read early |
| 003 | `SECTION_003.md` | BARS, RESOURCES & DAILY LOOPS | Core / Read early |
| 004 | `SECTION_004.md` | COMBAT SYSTEM | Core / Read early |
| 005 | `SECTION_005.md` | WORKING STATS, JOBS & COMPANIES | Core / Read early |
| 006 | `SECTION_006.md` | XP, LEVEL, RANK & TITLES | Core / Read early |
| 007 | `SECTION_007.md` | ITEMS, WEAPONS, ARMOUR, DRUGS, VARIANTS & GEAR | Core / Read early |
| 008 | `SECTION_008.md` | GYM, TRAINING & BATTLE STATS (AAA+ ULTRA EDITION) | Core / Read early |
| 009 | `SECTION_009.md` | COMPLETE AAA ULTRA EDITION | Core / Read early |
| 010 | `SECTION_010.md` | AAA+ ULTRA EDITION | Core / Read early |
| 011 | `SECTION_011.md` | AAA ULTRA EDITION | Core / Read early |
| 012 | `SECTION_012.md` | AAA ULTRA EXPANDED | Core / Read early |
| 013 | `SECTION_013.md` | FULL UK URBAN SIMULATION | Core / Read early |
| 014 | `SECTION_014.md` | FULL UK ECONOMY SIMULATION | Core / Read early |
| 015 | `SECTION_015.md` | FULL ACADEMIC TREES, CERTIFICATIONS | Core / Read early |
| 016 | `SECTION_016.md` | UK REGIONS, REGIONAL ECONOMY, SAFETY | Core / Read early |
| 017 | `SECTION_017.md` | UK LOCATION SYSTEM, UPGRADES, TENANTS | Core / Read early |
| 018 | `SECTION_018.md` | CASINO, TOKENS, GAMBLING, ODDS MODELS, ADDICTION | Core / Read early |
| 019 | `SECTION_019.md` | STOCK MARKET, POINTS BUILDING, BENEFITS, INVESTOR SYSTEM | Core / Read early |
| 020 | `SECTION_020.md` | MISSIONS, EVENTS, NPCS, NARRATIVE ENGINE | Core / Read early |
| 021 | `SECTION_021.md` | FORUMS, MAIL, CHAT, NEWSPAPER, CONTRACTS | Core system / Expansion |
| 022 | `SECTION_022.md` | JOBS, COMPANIES, WORKING STATS, ECONOMY, INDUSTRY & TRADE | Core system / Expansion |
| 023 | `SECTION_023.md` | PROPERTIES, HOUSING, REAL ESTATE, HAPPY CAP, SECURITY (EXPANDED) | Core system / Expansion |
| 024 | `SECTION_024.md` | UK STREET CATEGORIES, ADDICTION, TOLERANCE, CRASH | Core system / Expansion |
| 025 | `SECTION_025.md` | TRAINING, STAT CURVES, ENHANCERS (EXPANDED) | Core system / Expansion |
| 026 | `SECTION_026.md` | TRAINING, STAT CURVES, ENHANCERS (ALTERNATE DETAIL) | Core system / Expansion |
| 027 | `SECTION_027.md` | STATUS, ARMOUR, WEAPON DETAIL (EXPANDED) | Core system / Expansion |
| 028 | `SECTION_028.md` | SECTOR MAP & DIPLOMACY (EXPANDED) | Core system / Expansion |
| 029 | `SECTION_029.md` | ACCESS, RISKS, GOODS (EXPANDED) | Core system / Expansion |
| 030 | `SECTION_030.md` | EFFECTS, TOLERANCE, ADDICTION (DETAILED CHARTS) | Core system / Expansion |
| 031 | `SECTION_031.md` | HEALTH, HOSPITAL, DAMAGE STATES, REVIVES (EXPANDED) | Core system / Expansion |
| 032 | `SECTION_032.md` | HEALTH, HOSPITAL, DAMAGE STATES (ALT CONTEXT) | Core system / Expansion |
| 033 | `SECTION_033.md` | STRUCTURE, RANKS, PERMISSIONS, RESPECT (DETAIL) | Core system / Expansion |
| 034 | `SECTION_034.md` | PLAYER-RUN BUSINESSES, STAR RATINGS, RATINGS (DETAIL) | Core system / Expansion |
| 035 | `SECTION_035.md` | 15+ PROPERTY TIERS, UPGRADES, STAFF, HOUSING (DETAIL) | Core system / Expansion |
| 036 | `SECTION_036.md` | FULL UK REGIONAL TRAVEL, TRAINS, ROADS, SAFEHOUSES | Core system / Expansion |
| 037 | `SECTION_037.md` | GANGS, BOSSES, CIVILIANS, SHOPKEEPERS, EVENTS | Core system / Expansion |
| 038 | `SECTION_038.md` | HAPPY ENGINE, ESTATES, STAFF (ALTERNATE DETAIL) | Core system / Expansion |
| 039 | `SECTION_039.md` | STOCK MARKET, POINTS BUILDING, INVESTMENTS (SUPPLEMENT) | Core system / Expansion |
| 040 | `SECTION_040.md` | VEHICLES, RACING, GARAGES, STREET CULTURE | Core system / Expansion |
| 041 | `SECTION_041.md` | HOUSING, PROPERTIES, ESTATES, STAFF, UPGRADES (SUPPLEMENT) | Core system / Expansion |
| 042 | `SECTION_042.md` | FORUMS, MAIL, CHAT, NEWSPAPER (SUPPLEMENT) | Core system / Expansion |
| 043 | `SECTION_043.md` | MISSIONS, NPCs, STORY ARCS, GANG BOSSES, NATIONAL QUESTLINES (SUPPLEMENT) | Core system / Expansion |
| 044 | `SECTION_044.md` | REGIONS, DISTRICTS, HISTORY (EXPANDED) | Core system / Expansion |
| 045 | `SECTION_045.md` | FULL HOUSING SYSTEM, NATION ESTATES (SUPPLEMENT) | Core system / Expansion |
| 046 | `SECTION_046.md` | VEHICLES, TRANSPORT, RACING, CAR PARTS (SUPPLEMENT) | Core system / Expansion |
| 047 | `SECTION_047.md` | GUN CATEGORIES (ULTRA AAA+ EDITION) | Core system / Expansion |
| 048 | `SECTION_048.md` | MELEE WEAPONS (UK STREET BLADES, BLUNT, IMPROVISED) | Core system / Expansion |
| 049 | `SECTION_049.md` | THROWABLES & EXPLOSIVES | Core system / Expansion |
| 050 | `SECTION_050.md` | ARMOUR SYSTEM | Core system / Expansion |
| 051 | `SECTION_051.md` | SHIELDS | Core system / Expansion |
| 052 | `SECTION_052.md` | WEAPON MODS & ATTACHMENTS | Core system / Expansion |
| 053 | `SECTION_053.md` | ARMOUR MODS & WEARABLE AUGMENTS | Core system / Expansion |
| 054 | `SECTION_054.md` | CLOTHING & COSMETIC FASHION SYSTEM | Core system / Expansion |
| 055 | `SECTION_055.md` | HAIRSTYLES, BARBERS, TATTOOS & APPEARANCE EDITING | Core system / Expansion |
| 056 | `SECTION_056.md` | PETS, ANIMALS & COMPANION SYSTEM | Core system / Expansion |
| 057 | `SECTION_057.md` | WEATHER, TIME & ENVIRONMENTAL SYSTEM | Core system / Expansion |
| 058 | `SECTION_058.md` | SOUND DESIGN, AMBIENCE & AUDIO SYSTEM | Core system / Expansion |
| 059 | `SECTION_059.md` | CLOTHING, OUTFITS & STREETWEAR SYSTEM (SUPPLEMENT) | Core system / Expansion |
| 060 | `SECTION_060.md` | FOOD, DRINKS & CONSUMABLES | Core system / Expansion |
| 061 | `SECTION_061.md` | DRUGS SYSTEM (AAA EDITION, CONSOLIDATED) | Core system / Expansion |
| 062 | `SECTION_062.md` | JOBS, WORKING STATS & UK INDUSTRIES (SUPPLEMENT) | Core system / Expansion |
| 063 | `SECTION_063.md` | PLAYER-RUN COMPANIES (UK GANG FRONTS • LEGIT BUSINESSES • INDUSTRY) | Core system / Expansion |
| 064 | `SECTION_064.md` | PROPERTIES, HOUSING & ENDGAME COUNTRY OWNERSHIP | Core system / Expansion |
| 065 | `SECTION_065.md` | FACTIONS, GANGS & WARFARE (SUPPLEMENT) | Core system / Expansion |
| 066 | `SECTION_066.md` | CRIMES 1.0 + CRIMES 2.0 (UK STREET EDITION) | Core system / Expansion |
| 067 | `SECTION_067.md` | DRUGS • ADDICTION • WITHDRAWAL • REHAB (DEEP DIVE) | Core system / Expansion |
| 068 | `SECTION_068.md` | GYM, TRAINING, MUSCLE GROUPS, 25+ GYMS | Core system / Expansion |
| 069 | `SECTION_069.md` | CRIMES 3.0: BLACK OPS, FRAUD SYNDICATES, HIGH-LEVEL CRIME | Core system / Expansion |
| 070 | `SECTION_070.md` | NPC GANGS 2.0 | Core system / Expansion |
| 071 | `SECTION_071.md` | INFORMANT SYSTEM 2.0 | Core system / Expansion |
| 072 | `SECTION_072.md` | POLICE SYSTEM 3.0 | Core system / Expansion |
| 073 | `SECTION_073.md` | NATIONAL THREAT SYSTEM 3.0 | Core system / Expansion |
| 074 | `SECTION_074.md` | BLACK OPS SYSTEM 3.0 | Core system / Expansion |
| 075 | `SECTION_075.md` | SHADOW ECONOMY 3.0 | Core system / Expansion |
| 076 | `SECTION_076.md` | BLACK MARKET CRAFTING SYSTEM 3.0 | Core system / Expansion |
| 077 | `SECTION_077.md` | VEHICLES & MODDED VEHICLE SYSTEM 3.0 | Core system / Expansion |
| 078 | `SECTION_078.md` | CLOTHING, ARMOUR SETS & COSMETIC FASHION SYSTEM 3.0 | Core system / Expansion |
| 079 | `SECTION_079.md` | TATTOOS, GANG MARKINGS & BODY MODS SYSTEM 2.0 | Core system / Expansion |
| 080 | `SECTION_080.md` | PETS, ANIMALS, COMPANIONS & ILLEGAL EXOTICS SYSTEM 3.0 | Core system / Expansion |
| 081 | `SECTION_081.md` | FOOD, DRINK, STREET EATS & BOOSTER SYSTEM 4.0 | Overlay / Late system |
| 082 | `SECTION_082.md` | RELATIONSHIPS, REPUTATION, STREET STATUS & SOCIAL PROGRESSION 4.0 | Overlay / Late system |
| 083 | `SECTION_083.md` | WEATHER, TIME, ROUTINES & DYNAMIC WORLD EVENTS 5.0 | Overlay / Late system |
| 084 | `SECTION_084.md` | NPC FACTIONS, GANGS, STREET CREWS & UNDERWORLD STRUCTURES | Overlay / Late system |
| 085 | `SECTION_085.md` | DRUG SYSTEM 5.0 | Overlay / Late system |
| 086 | `SECTION_086.md` | THE COMPLETE CRAFTING & DRUG LAB SYSTEM | Overlay / Late system |
| 087 | `SECTION_087.md` | THE COMPLETE FOOD & DRINK SYSTEM | Overlay / Late system |
| 088 | `SECTION_088.md` | UK SHOPPING, STORES & ECONOMY NETWORK | Overlay / Late system |
| 089 | `SECTION_089.md` | UK REGIONAL TRAVEL SYSTEM (REPLACES COUNTRIES) | Overlay / Late system |
| 090 | `SECTION_090.md` | VEHICLES, CAR CRIMES, MODS & STREET RACING SYSTEM | Overlay / Late system |
| 091 | `SECTION_091.md` | THE UK WEAPON SYSTEM | Overlay / Late system |
| 092 | `SECTION_092.md` | THE UK DRUG SYSTEM | Overlay / Late system |
| 093 | `SECTION_093.md` | THE UK GANG CULTURE SYSTEM | Overlay / Late system |
| 094 | `SECTION_094.md` | THE UK BLACK MARKET NETWORK | Overlay / Late system |
| 095 | `SECTION_095.md` | CRIME SYSTEM 3.0 | Overlay / Late system |
| 096 | `SECTION_096.md` | UK VEHICLE & STREET RACING SYSTEM | Overlay / Late system |
| 097 | `SECTION_097.md` | THE BLACK MARKET SYSTEM | Overlay / Late system |
| 098 | `SECTION_098.md` | UK DRUG SYSTEM 3.0 | Overlay / Late system |
| 099 | `SECTION_099.md` | UK WEAPON SYSTEM 4.0 | Overlay / Late system |
| 100 | `SECTION_100.md` | ARMOUR, SHIELDS & DEFENCE SYSTEM 4.0 | Overlay / Late system |
| 101 | `SECTION_101.md` | CLOTHING, STYLE, MASKS & COSMETIC IDENTITY SYSTEM 5.0 | Overlay / Late system |
| 102 | `SECTION_102.md` | VEHICLES & TRANSPORTATION SYSTEM | Overlay / Late system |
| 103 | `SECTION_103.md` | TRAINS, BIKES & ALTERNATIVE TRANSPORT | Overlay / Late system |
| 104 | `SECTION_104.md` | PROPERTY SYSTEM 2.0 | Overlay / Late system |
| 105 | `SECTION_105.md` | COMPANY SYSTEM 2.0 | Overlay / Late system |
| 106 | `SECTION_106.md` | EDUCATION SYSTEM 2.0 | Overlay / Late system |
| 107 | `SECTION_107.md` | DEEP CRIMES SYSTEM 3.0 | Overlay / Late system |
| 108 | `SECTION_108.md` | COMBAT SYSTEM 3.0 | Overlay / Late system |
| 109 | `SECTION_109.md` | ARMOUR & PROTECTION SYSTEM 3.0 | Overlay / Late system |
| 110 | `SECTION_110.md` | WEAPONS SYSTEM 4.0 (REFINEMENT) | Overlay / Late system |
| 111 | `SECTION_111.md` | THROWABLES & EXPLOSIVES ENGINE 4.0 | Overlay / Late system |
| 112 | `SECTION_112.md` | STATUS EFFECTS ENGINE 6.0 | Overlay / Late system |
| 113 | `SECTION_113.md` | ARMOUR SYSTEM 8.0 | Overlay / Late system |
| 114 | `SECTION_114.md` | CLOTHING & COSMETICS ENGINE 5.0 | Overlay / Late system |
| 115 | `SECTION_115.md` | WEAPONS SYSTEM 10.0 | Overlay / Late system |
| 116 | `SECTION_116.md` | THE DAMAGE ENGINE 10.0 | Overlay / Late system |
| 117 | `SECTION_117.md` | ARMOUR SYSTEM 5.0 | Overlay / Late system |
| 118 | `SECTION_118.md` | NPC SYSTEM 20.0 | Overlay / Late system |
| 119 | `SECTION_119.md` | UK DRUG SYSTEM 20.0 | Overlay / Late system |
| 120 | `SECTION_120.md` | PLAYER-OWNED COUNTRIES (THE TRUE ENDGAME) | Overlay / Late system |
| 121 | `SECTION_121.md` | ADVANCED PLAYER HOUSING SYSTEM 12.0 | Overlay / Late system |
| 122 | `SECTION_122.md` | ADVANCED VEHICLES & RACING SYSTEM 14.0 | Overlay / Late system |
| 123 | `SECTION_123.md` | WEAPON MODDING & CRAFTING SYSTEM 15.0 | Overlay / Late system |
| 124 | `SECTION_124.md` | ARMOUR & PROTECTIVE SYSTEMS 16.0 | Overlay / Late system |
| 125 | `SECTION_125.md` | EXPLOSIVES, THROWABLES & TACTICAL DEVICES 20.0 | Overlay / Late system |
| 126 | `SECTION_126.md` | MELEE WEAPONS SYSTEM (AAA+ UK STREET x CINEMATIC x TORN-PARITY) | Overlay / Late system |
| 127 | `SECTION_127.md` | SHIELDS & DEFENSIVE EQUIPMENT (AAA+ RIOT • MAKESHIFT • ENERGY • TRENCHMADE) | Overlay / Late system |
| 128 | `SECTION_128.md` | ARMOUR SYSTEM (BODY ARMOUR • PLATES • HELMETS • FUTURISTIC • TRENCHMADE) | Overlay / Late system |
| 129 | `SECTION_129.md` | EXPLOSIVES • GRENADES • BREACH DEVICES • IEDs • FUTURISTIC • TRENCHMADE (AAA+ EDITION) | Overlay / Late system |
| 130 | `SECTION_130.md` | MELEE WEAPONS (BLADES • BATONS • MACHETES • IMPROVISED • EXOTIC • ENERGY • TRENCHMADE) | Overlay / Late system |
| 131 | `SECTION_131.md` | THROWABLES (STREET • MARTIAL • UTILITY • CHEMICAL • ENERGY • TRENCHMADE) | Overlay / Late system |
| 132 | `SECTION_132.md` | MEDICAL ITEMS (HEALING • RECOVERY • CLEANSE • STABILISATION • TRENCHMADE) | Overlay / Late system |
| 133 | `SECTION_133.md` | DRUGS (REAL DRUG FAMILIES • UK STREET SLANG • POWER SCALES • ADDICTION • ECONOMY • TRENCHMADE) | Overlay / Late system |
| 134 | `SECTION_134.md` | BOOSTERS (ENERGY • HAPPY • NERVE • MULTI-BAR • STAT • ECONOMY • TRENCHMADE) | Overlay / Late system |
| 135 | `SECTION_135.md` | FOOD & DRINK (UK CUISINE • MEAL DEALS • RESTAURANTS • BUFFS • ECONOMY • EVENTS • PRESTIGE) | Overlay / Late system |
| 136 | `SECTION_136.md` | ALCOHOL SYSTEM (UK REALISM • STREET CULTURE • BUFFS • DRUNK MECHANICS • PRESTIGE BREWS) | Overlay / Late system |
| 137 | `SECTION_137.md` | WORKING STATS SYSTEM (MAN • INT • END) | Overlay / Late system |
| 138 | `SECTION_138.md` | BASIC FACTORY SYSTEM (MASS PRODUCTION • WORKING-STATS SYNERGY • SUPPLY CHAINS • PLAYER ECONOMY) | Overlay / Late system |
| 139 | `SECTION_139.md` | ADVANCED FACTORY SYSTEM | Overlay / Late system |
| 140 | `SECTION_140.md` | PROPERTY SYSTEM (UK REAL ESTATE • HAPPINESS ENGINE • UPGRADE TREES • STAFF • MEGA-PROPERTY • ENDGAME COUNTRY ESTATES) | Overlay / Late system |
| 141 | `SECTION_141.md` | HEALTH, INJURY & MEDICAL SYSTEM | Overlay / Late system |
| 142 | `SECTION_142.md` | DRUG SYSTEM (UK STREET CATEGORIES • SLANG STRENGTH TIERS • ADDICTION • PURITY • OVERDOSE • WITHDRAWAL • BLACK MARKET • CRIME 2.0) | Overlay / Late system |
| 143 | `SECTION_143.md` | ALCOHOL SYSTEM (UK DRINK CULTURE • DRUNK EFFECTS • MIXOLOGY • EVENTS • PRESTIGE SPIRITS) | Overlay / Late system |
| 144 | `SECTION_144.md` | TOBACCO & NICOTINE SYSTEM | Overlay / Late system |
| 145 | `SECTION_145.md` | SPORTS SYSTEM | Overlay / Late system |
| 146 | `SECTION_146.md` | PET SYSTEM | Overlay / Late system |
| 147 | `SECTION_147.md` | VEHICLES & TRANSPORT SYSTEM | Overlay / Late system |
| 148 | `SECTION_148.md` | BLACK MARKET SYSTEM | Overlay / Late system |
| 149 | `SECTION_149.md` | PETS & ANIMAL SYSTEM | Overlay / Late system |
| 150 | `SECTION_150.md` | SKILLS SYSTEM | Overlay / Late system |
| 151 | `SECTION_151.md` | WEATHER & DYNAMIC CITY SYSTEM | Overlay / Late system |
| 152 | `SECTION_152.md` | TORN.COM LEVEL & XP REFERENCE (READ-ONLY) | External reference / do-not-implement |

## 0.4 How Each Worker Should Use This Bible

### Architect GPT

- Treat each SECTION as a **contract** for how that feature must behave in Trench City.
- When planning new work, always identify which SECTIONS it touches (e.g. Gym uses Gym, Stats, Bars, Logs, Anti-Abuse, Economy).
- Keep the **Build Order** and progression in mind: don’t design features that contradict the Bible.
- When in doubt, defer to the most recent or most specific SECTION on a topic.

### CodeGPT

- Use the Bible to decide **what code should exist**, which actions/endpoints are needed, and which edge cases to cover.
- Never invent mechanics that conflict with this Bible. If the Bible is vague, prefer the safest/clearest interpretation and note it for Architect/Balance.
- Map design concepts to existing helpers, DB tables, and modules rather than adding new systems without design coverage.

### BalanceGPT

- Look for numeric tables, tunable variables, timer values, payout bands, and progression notes in each SECTION.
- Propose updated numbers while preserving the **shape** of the economy and progression as defined here.
- Treat any explicit anti-exploit and sink/source notes as **hard constraints**: do not remove sinks or introduce infinite loops.

### QAGPT

- Convert each SECTION’s edge cases, abuse vectors, and failure modes into test plans.
- Ensure that every major feature has tests for: happy path, invalid input, rate limiting, exploits, and logging.
- Where a SECTION mentions logs or audit trails, design tests to confirm these are written correctly and consistently.

## 0.5 When This Bible Wins

This Bible is **doing its job** when Architect, Code, Balance, and QA can each:
- Read the relevant SECTIONS for a feature,
- Agree on what “correct” looks like,
- Implement or test without guessing,
- And hand work back and forth without contradictions.

If a future feature or change is not clearly described here, it should be added as a new SECTION or an explicit update to an existing one before large-scale implementation.

### Detailed Mechanics — UK Drug System Core

**Drug Families & Roles**  
The UK Drug System is split into clear families, each with a gameplay role:

- **Soft Stimulants** (energy drinks, mild pills): cheap, low-risk, small Energy/Nerve boosts, near-zero addiction. Good for new players.
- **Hard Stimulants** (strong pills, powders): high Energy/Nerve spikes, crime and combat buffs, medium to high addiction and crash risk.
- **Depressants & Sedatives** (downers, painkillers): reduce incoming damage or hospital time, boost Life/Happy, may reduce accuracy and initiative.
- **Performance Enhancers** (steroids, combat enhancers): temporarily increase battle stats or working stats (MAN/INT/END) with serious long-term side effects.
- **Psychedelics** (trip-style drugs): medium buffs to Happy/creative missions, heavy debuffs to precise combat and high paranoia effects.
- **Medical & Legalised** (prescriptions, government-approved): low buffs with special missions, low addiction but tightly controlled and expensive.

Each drug is defined by: **family, potency tier, onset time, peak duration, cooldown, addiction weight, legality, trafficking risk, and rarity.**

**Consumption Flow**  
When a player uses a drug, apply these steps in order:

1. **Check Cooldowns & Stacking**
   - If the player has an active effect from the same family, apply diminishing returns and increase overdose risk instead of full effect.
   - Global “recent high-risk drug use” flags can also increase police heat and random event chances.

2. **Apply Primary Effects**
   - Modify **bars**: Energy, Nerve, Happy, Life according to drug family and potency.
   - Apply **temporary modifiers**: e.g. accuracy +X%, crit chance +Y%, stealth +Z, working stat multipliers, or defence buffs.
   - Mark a **hidden effect token** so other systems (Crimes, Combat, Missions, Factions) know the player is currently under influence.

3. **Schedule Decay & Crash**
   - Each drug instance creates a timed effect with:
     - Onset → Peak → Fade → Crash (where applicable).
   - Crash phases can apply stat maluses, Happy drops, Life ticks, or reduced Nerve regen.

4. **Log Usage & Risk Signals**
   - Every dose writes to a **Drug Log** (for QA, anti-abuse and faction intel):
     - Player, drug, dose, location, source (NPC dealer, faction lab, travel, market), timestamp, and any linked events (crime immediately after, PvP, etc.).

**Addiction & Withdrawal Model**  
Addiction is tracked per **drug family** rather than single items to keep it manageable:

- Each dose adds **Addiction Points (AP)** to that family, scaled by potency and current AP (diminishing returns at extreme values to avoid integer overflow).
- Thresholds:
  - **Mild addiction:** small Happy penalty when sober, occasional cravings (mission prompts, flavour text).
  - **Moderate addiction:** stronger Happy penalties, reduced bar regen when clean, increased crash severity.
  - **Severe addiction:** heavy debuffs (damage, accuracy, Nerve regen), high chance of random negative events if the player refuses to use again.

Withdrawal is triggered if:

- AP is above a threshold AND the player hasn’t used that family for X hours/days.
- Apply time-limited debuffs that can be eased by:
  - Using again (short-term relief, long-term worse AP),
  - Using detox items or visiting a **Rehab/Clinic** (cash sink),
  - Completing specific missions or counselling events.

**Overdose & Medical Consequences**  
Overdose (OD) is calculated from:

- Active stacked effects,
- Recent doses (last N minutes),
- Drug family risk,
- Player modifiers (perks, faction bonuses, medical traits).

Outcomes can include:

- Heavy Life damage and instant hospitalisation.
- Item loss (dropped drugs / cash in a panic or during police intervention).
- Temporary stat damage (soft permanent debuffs that can be repaired slowly).
- Police heat spikes, extra logs, or special “OD incident” missions.

**Economy & Supply Chains**  
Drugs are integrated into multiple economies:

- **City Dealers:** mid-price, safe baseline supply; prices react slowly to demand.
- **Faction Labs / Turf:** discounted or buffed drugs for members, but increase faction exposure to raids and special police events.
- **Travel & Smuggling:** buy low abroad, sneak back into Trench City through Travel and Risk & Reward; failure feeds items into city seizures or NPC markets.
- **Black Market:** rare, experimental or ultra-potent variants with extreme risk/reward, often tied to events or narrative arcs.

Prices and availability should subtly react to **arrests, big busts, major events, and faction control of key territories**, giving BalanceGPT clear levers for tuning sinks and spikes.

**Anti-Abuse & Exploit Notes**  

- Cap beneficial stacking: only top N active drug effects can apply full buffs, others are heavily diminished.
- Detect suspicious patterns:
  - Perfectly timed loops of use → crime → hospital → use, 24/7.
  - Unusual volumes of rare drugs moving through a single account/faction with no corresponding Travel/Crime history.
- Use server-side checks instead of client-visible constraints so abusers can’t see exact thresholds.
- Ensure every drug faucet (loot, events, faction lab output) has at least one clear sink (use, decay, spoilage, raids, confiscation).

### Detailed Mechanics — Pets & Animal System

**Pet Roles & Categories**  
Pets are split into functional categories so they’re more than cosmetics:

- **Companion Pets:** primarily flavour and Happy buffs, minor passive bonuses (e.g. +small Happy/hour, tiny crime/working stat boosts).
- **Utility Pets:** provide focused benefits such as increased loot find, better scouting in Crimes/Travel, or improved success in specific missions.
- **Combat-Adjacent Pets:** do not replace player combat, but can provide:
  - small damage-over-time,
  - enemy debuffs (fear, bleed, distraction),
  - or extra intel (revealing enemy loadouts, hiding spots, etc.).
- **Economic/Collector Pets:** ultra-rare event pets, cosmetic prestige pets, or breeds tied to specific limited content.

Each pet instance stores: **species, rarity tier, level, experience, loyalty, temperament, current mood, and unique traits.**

**Acquisition & Growth**  

- **Shelter & Shops:** baseline common pets available for cash; good intro sink.
- **Events & Missions:** themed pets for Halloween, Christmas, story arcs, faction wars.
- **Breeding & Trading:** high-end/meta system where certain pets can breed to pass traits, with breeding cooldowns and risk of undesirable traits.
- **Black Market / Illegal Exotics:** dangerous pets with strong abilities but strict legality and risk implications.

Pets gain **Pet XP** from:

- Being equipped and active when the player runs Crimes, Missions, Fights, or Jobs.
- Direct training actions that cost Energy/Money and sometimes items (treats, toys, training tools).

Pet Level increases unlock:

- Higher loyalty caps,
- Stronger passive bonuses,
- New abilities or tricks,
- Cosmetic upgrades (collars, skins, nameplates).

**Loyalty, Mood & Care**  

Track at least three key pet states:

- **Loyalty:** how strongly the pet is bonded to the owner. Influenced by time together, successful activities, and care frequency.
- **Mood:** short-term happiness; reacts to neglect, injuries, environment, training success/failure.
- **Needs:** hunger, cleanliness, and stimulation thresholds.

Neglect leads to:

- Reduced bonuses or temporary refusal to assist.
- Visual feedback in UI (sad icons, flavour text).
- Potential run-away events or forced rehoming if abuse is extreme.

Good care yields:

- Small but steady buffs,
- Access to pet-only missions or events,
- Better odds of passing on positive traits in breeding.

**Combat Integration (Optional but Supported)**  

To avoid pets fully replacing PvP:

- Only certain pet types may be combat-adjacent.
- Limit combat impact to **supportive roles**:
  - Reveal enemy info, apply small DoTs, grant small defensive buffs, or provide one-off “escape” or “second wind” abilities.
- Tie powerful pet combat abilities to clear trade-offs:
  - expensive upkeep,
  - limited uses per day,
  - or faction-bound pets that expose the faction to risk if the pet is injured/stolen.

Pets have their own lightweight **HP / Injury** track:

- Knocked-out pets require cooldown and vet care (cash sink).
- Permanent pet death should be extremely rare, opt-in (hardcore features), or narrative-only to avoid rage quits.

**Economy & Sinks**  

The pet system should meaningfully circulate money and items via:

- Food, toys, grooming, training, vet bills, accessories, skins.
- Special pet crates or eggs with controlled drop rates and pity timers.
- Faction-level pet perks that require ongoing upkeep.

High-rarity pets and cosmetics form a **long-tail collector economy**, tradable via the market or faction channels.

**Anti-Abuse Notes**  

- Limit concurrent active pets and combat effects to avoid multi-pet exploit builds.
- Enforce global rate limits on breeding and high-tier pet acquisitions.
- Tie the strongest pet bonuses to **account age, progression milestones and missions**, not just raw cash, to reduce pay-to-win.
- Ensure pet XP and loyalty gains have diminishing returns from repetitive low-effort actions to prevent simple macro loops.

### Detailed Mechanics — Armour System Core

**Armour Slots & Coverage**  

The player can equip armour in a set of defined slots:

- Head
- Torso
- Arms/Hands
- Legs
- Feet

Each armour piece defines:

- **Armour Rating (AR):** base % damage reduction for normal hits.
- **Coverage:** which body region(s) it protects (for locational hit systems).
- **Damage Type Modifiers:** ballistic, melee, explosive, environmental.
- **Penetration Threshold:** how much weapon penetration is required before damage starts bypassing protection.
- **Weight & Bulk:** affects initiative, dodge, stealth, and some jobs/missions.

Full sets and mixed setups must be viable: players can choose between heavy defence, mobility, or stealth-driven armour strategies.

**Damage Resolution with Armour**  

When a hit occurs, resolve in this order:

1. **Determine Hit Location (if used)**
   - Roll a hit location (head/torso/limbs) based on weapon and stance.
   - Pick the relevant armour piece for that location; if none, treat as unarmoured.

2. **Calculate Effective Armour**
   - Start with piece AR and apply:
     - Quality tier (basic/advanced/elite),
     - Condition (0–100%),
     - Temporary buffs/debuffs (drugs, perks, weather, missions).
   - Result is **Effective AR%**.

3. **Apply Penetration**
   - Compare weapon penetration vs armour **Penetration Threshold**.
   - If penetration < threshold → most damage is reduced, only a small minimum leak-through.
   - If penetration >= threshold → part of the hit bypasses armour:
     - e.g. 40–70% bypass, remainder reduced by AR.

4. **Degrade Armour**
   - Each hit reduces condition by an amount scaled to damage and penetration.
   - Low condition reduces AR up to a floor; at 0 condition, the item is effectively cosmetic.

5. **Apply Damage & Effects**
   - Remaining damage is applied to Life and any on-hit effects are handled (bleeds, stuns, fractures).

**Armour Rarity, Mods & Synergies**  

Armour is grouped into tiers (Common, Uncommon, Rare, Elite, Legendary) with:

- Increasing base AR,
- Unique set bonuses,
- Mod slots (plates, padding, tech modules).

Example mod hooks:

- Lighter materials (reduced weight penalties),
- Special resistances (flashbang reduction, fire resistance, toxin filters),
- Integrated pouches (ammo, tools, smuggling capacity).

Clothing systems (style, masks, cosmetics) may stack visually with armour but should respect mechanical rules:

- Some clothing layers provide **soft bonuses** (intimidation, stealth, job respect) while armour provides hard defence.
- Certain outfits unlock armour set bonuses when worn together (faction uniforms, SWAT gear, riot gear).

**Repair, Maintenance & Sinks**  

- Armour repair is a primary cash sink:
  - Quick Repair (cheap, small condition restore),
  - Full Service (expensive, large condition restore, cosmetics preserved),
  - DIY kits (player item sink, slower but cheaper).
- Severely damaged armour can be salvaged for parts, feeding crafting/upgrading systems.

**Anti-Abuse & Edge Cases**  

- Prevent infinite tank builds by capping maximum effective AR and limiting stacking from armour + drugs + temporary buffs.
- Ensure armour with high AR comes with clear trade-offs (weight, mobility, visibility in crimes, job penalties).
- Guard against “zero-penalty” mixed builds by making sure every strong benefit has a matching drawback in another system (e.g. stealth vs protection).
- PvP logs should clearly show when armour contributed significantly, so BalanceGPT and QAGPT can detect outliers and overperforming items.

### Detailed Mechanics — Advanced Armour & Protective Systems

This section extends the core armour rules with advanced protections, specialised gear, and late-game systems.

**Specialised Protection Types**  

Beyond basic ballistic/melee armour, high-end and specialist gear can include:

- **Covert Armour:** low-visibility vests and liners that provide modest protection with minimal style penalties and low suspicion in the City.
- **Riot & Crowd-Control Gear:** high protection vs melee/projectiles, but heavy, conspicuous, and penalised in stealth and certain jobs.
- **Hazmat & Environmental Suits:** protect against toxins, radiation, environmental hazards during specific missions or events.
- **Tactical Shields:** hand-held shields that protect a portion of incoming attacks at the cost of offence and initiative.

Each category should explicitly state:

- Allowed slots and exclusivity (e.g. shield occupies off-hand, blocking two-handed weapons).
- Movement, stealth, and job impact.
- What mechanics they are intended to counter (grenades, gas, environmental events).

**Layering & Conflicts**  

Advanced protection may layer with base armour, but must obey strict rules:

- Only one **primary armour layer** per slot (e.g. one torso armour).
- Optional **underlayers/overlays** (e.g. stab vest under clothing, hi-vis overcoat on top) that primarily affect social/visibility stats rather than pure defence.
- Priority rules for damage reduction and condition loss when multiple layers exist.

**Progression & Unlocks**  

- Tie advanced protective gear to **late-game content**:
  - Faction war rewards,
  - High-tier missions and raids,
  - Special shops that require reputation/standing.
- This gear should feel aspirational but not mandatory for normal play, avoiding hard gating of basic content.

**Integration with Other Systems**  

- **Crimes & Raids:** certain armour types unlock or modify options in high-risk content (e.g. riot gear for prison breaks, hazmat for lab raids).
- **Jobs & Companies:** uniform armour may be required for specific roles; wearing obviously hostile gear (riot armour, masks) may be penalised in civilian-facing jobs.
- **Police Heat & Visibility:** heavy or tactical armour in public should increase attention, CCTV hits, and specific event triggers.

**Balance & Anti-Abuse Notes**  

- Clearly define diminishing returns on stacking multiple small sources of protection to avoid invulnerable niche builds.
- Avoid gear that is “strictly better” in all contexts; every top item should have a scenario where it’s a bad choice.
- Use logs and analytics to track which armour sets dominate PvP and high-end content; if one set is universal, adjust weight, costs, or counters accordingly.

### Detailed Mechanics — Clothing, Style & Mask Identity

**Style vs Function**  

Clothing in Trench City sits between three axes:

- **Style:** how the outfit looks; contributes to social perception, intimidation, and certain mission checks.
- **Function:** small, focused stat bonuses (stealth, job performance, crime modifiers), not raw combat power.
- **Identity:** how recognisable or anonymous the player appears during crimes, missions, and social encounters.

Clothing is not meant to compete with armour in pure defence but should matter for:

- Job success and promotions,
- Social/faction reputation,
- Crime detection chances,
- NPC reactions in the City and Missions.

**Outfit Slots & Layers**  

Define clear slots: headwear, face, torso, legs, footwear, accessories, outerwear.

- Certain outerwear layers can visually cover armour or other clothing layers.
- Masks and face coverings are the primary way to alter **identity exposure** during crimes and PvP.

**Masks & Anonymity Mechanics**  

Masks have dedicated rules:

- Each mask has an **Anonymity Rating** and **Suspicion Rating**:
  - High anonymity helps hide identity when committing crimes and PvP.
  - High suspicion makes NPCs and systems more alert when worn in inappropriate contexts (banks, shops, day jobs).
- When a crime or PvP event is logged:
  - Check whether the player was masked, partially disguised, or fully visible.
  - This influences whether victims, witnesses, and CCTV logs record a **named offender**, a **masked offender**, or only vague descriptions.

Consequences of poor disguise:

- Faster and stronger police heat accumulation.
- Easier targeting by enemies/factions via hitlists and bounties.
- Reputation penalties in legitimate jobs if caught.

**Fashion Stats & Sets**  

Clothing introduces soft stats such as:

- **Presence/Intimidation:** influences some dialogue, extortion crimes, and negotiation events.
- **Professionalism:** affects job performance and promotions in white/grey-collar roles.
- **Stealth/Blend:** makes blending into crowds easier for surveillance, tailing, and pickpocket-style crimes.

Set bonuses:

- Themed outfits (business suits, roadman fits, designer tracksuits, faction uniforms) can grant small bonuses when worn together.
- Limited sets from events or Black Market drops act as long-term collector targets and prestige badges.

**Economy & Sinks**  

- Clothing is a major **non-combat sink**:
  - Shops for basic and mid-tier items,
  - High-end boutiques for designer/limited pieces,
  - Tailors and customisation services for recolours, patterns, or tags.
- Resale markets allow players to trade rare cosmetics at a premium but should include fees to keep money circulating.

**Anti-Abuse & Edge Cases**  

- Avoid clothing that grants large raw combat stats; keep bonuses mostly contextual and capped.
- Ensure disguise systems can’t be exploited to become permanently untraceable:
  - Logs should still capture masked offenders and allow for investigative mechanics (witnesses, CCTV, intel missions).
- Provide clear UI feedback when an outfit is a bad match for the current activity (e.g. heavy tactical gear in a white-collar office job).

### Detailed Mechanics — Working Stats (MAN, INT, END)

**Purpose of Working Stats**  

MAN (Manual), INT (Intelligence), and END (Endurance) represent long-term professional capability, mirroring Torn-style working stats but branded for Trench City. They power:

- Job entry requirements and promotion thresholds.
- Company roles (directors, managers, specialists).
- Special mission branches, investigations, and complex multi-step tasks.
- Certain crime types that require real competence rather than raw street power.

These stats are intentionally **slow to grow** and form a deep progression backbone separate from combat.

**Sources of MAN/INT/END**  

- **Jobs & Companies:** daily work ticks grant small amounts of the relevant stat(s), scaled by job level and performance.
- **Education & Training:** specific courses reward focused working stat gains (e.g. accounting = INT, construction = MAN, security = MAN+END).
- **Books & Rare Items:** limited-use items grant one-time boosts, often gated behind missions or high prices.
- **Events & Missions:** certain storylines temporarily boost or permanently reward working stats.

Gains should be:

- Diminishing per day to discourage abuse via AFK or low-effort looping.
- Capped per time window so late-game players can’t instantly max new alts.

**Usage & Gating**  

Examples of how MAN/INT/END should gate content:

- **Jobs:**
  - MAN-heavy roles: construction, security, manual labour companies.
  - INT-heavy roles: finance, tech, consultancy, law.
  - END-heavy roles: emergency services, logistics, stamina-driven work.

- **Companies:**
  - Directors require a minimum combined working stat total plus high stat in one domain.
  - Special roles (e.g. Head of Security, Lead Analyst) require specific thresholds.

- **Missions/Crimes:**
  - Complex heists require minimum INT for planning, MAN for execution, END for long-duration operations.
  - Certain stealth or infiltration tasks require a blend of stats rather than just combat power.

**Scaling & Balance Model**  

- Working stats should follow a **curved progression**:
  - Early gains (0–10k) feel noticeable and unlock basic roles quickly.
  - Mid-range (10k–1M) opens strong career paths and powerful company roles.
  - High-end (1M+) is prestige territory with very slow growth and niche benefits.

- BalanceGPT should tune:
  - Daily cap per stat and per source.
  - Conversion rates from job performance ratings to stat gains.
  - Impact of bonuses (education, items, faction perks) to avoid trivialising the grind.

**Anti-Abuse & Edge Cases**  

- Prevent trivially bot-able loops (e.g. spam-click low-tier actions with zero risk) from giving meaningful working stats.
- Require account age, Level, or mission completion for high-yield learning activities.
- Make sure powerful working stat thresholds are **soft gates**: provide alternate paths to content for players who prefer crime/combat-first progression, albeit with different rewards.

# SECTION 001 — WORLD, SETTING, THEME & NAMING ENGINE

## 0.0 Overview
Trench City is a premium, dark-luxury UK megacity inspired by London and real British urban life. Every mechanic, system, UI page, and narrative beat must respect this identity: grounded UK realism, cinematic crime drama, and a polished upscale presentation. No later section may contradict the world rules set here; when in doubt, default to London authenticity, Dark Luxury styling, and Torn-grade density. This section is the canonical contract: aesthetic, geography, cultural tone, naming, overlays, background assets, copywriting voice, environmental logic, and how every other module inherits context.

## 0.1 World Identity — "The City of Dark Luxury"
- Core feel: recognisably British, culturally grounded, gang-coded, premium, dense, volatile, economically alive, crime-saturated, faction-controlled, cinematic. Players should read a profile or log line and immediately feel the UK tone.
- Influences: London (primary), Manchester nightlife, Birmingham conflict, Bristol rave/MDMA, Liverpool docks/smuggling, Glasgow underbelly; real high streets, council estates, borough divisions, police rhythms; nightlife and pub culture; council estate signage; Oyster-style transit references; CCTV-heavy surveillance.
- Tone guardrails: never parody or meme; believable danger with refined presentation; Dark Luxury overlay on every page; text copy uses UK spelling and slang without overdoing it; no American cop-show drift.
- Player perception: the city feels lived-in, with slang, signage, and environmental cues that match UK culture; weather and time-of-day tie to the skyline; news tickers and logs sound like UK tabloids blended with noir; soundscape matches urban ambience (sirens, rain on metal, distant trains).
- Cultural tension: wealth vs estates, polished penthouses vs concrete towers, premium styling over grit without erasing danger.

## 0.2 Geography & Macro Structure
The city is layered to support gameplay variety, faction warfare, travel clarity, and UI signposting.

### 0.2.1 Borough Layer (Primary Gameplay Layer)
- Boroughs: Brixton Sector, Peckham Bloc, Camden High, Towerblock Row, Hackney Cut, North Circular Rim.
- Each borough carries: combat hotspots, item find ranges, crime difficulty bands, NPC gang presence, faction territory, weather variance, economic variance, local slang identity, policing tempo, nightlife density, transit quality.
- Player loop: borough choice affects crime risk, NPC density, faction pressure, and shop pricing; map UI shows borough status, heat, ownership, current events, and weather overlay; travel times mimic UK transit expectations (bus/rail motifs).
- Asset rules: borough cards use distinct gold-accent silhouettes; map boundaries clearly separated; mini-map chips on every page show current borough; background accent shifts subtly per borough (colour temperature only).

### 0.2.2 District Layer (Functional Layer)
- Districts house gameplay buildings: gyms, casino, hospital, jail, job centre, market, shops, education centres, mission hubs, docks/smuggling yards, underground fight pits, black-market fronts, police stations.
- Constraints: building limits, daily caps, NPC classes, district events, live player crowd counts; some districts specialize (medical, nightlife, industrial) influencing shop stock, crime odds, and bar modifiers.
- UX: district pages show building lineup, current caps, active events, police heat, crowd indicator; quick links to recurring actions; breadcrumb shows Borough > District > (Sector/Street).

### 0.2.3 Sector Layer (Faction Warfare Layer)
- Tile-based territories spanning the map; capture/defend/enhance/profit; provide buffs; attackable in war windows; weather/time modifiers apply to visibility and initiative.
- Warfare hooks: respect/rep rewards, income streams, control-based buffs to members (regen, damage, crime odds), influence over district pricing; upkeep costs; sabotage actions by enemies.
- Logs: every capture/defense/upkeep generates faction logs and city feed entries with sector coordinates, attackers, defenders, outcome, timers; heat impact recorded.
- UI: sector grid overlay on borough map; hover reveals ownership, buffs, and war timers.

### 0.2.4 Street Layer (Flavor Layer)
- Streets matter: crimes and OCs reference them; NPC gangs own estates; players earn Street Credits for reputation and cosmetics; travel overlays reference street names.
- Street types: council blocks, high streets, undercity tunnels, alleys, rooftops, bus/train hubs, docks lanes, night markets, estates with tower identifiers, industrial backroads, estates with block letters.
- UX: street context shown on crime pages, travel overlays, logs; street filters for crimes; flavor text from naming engine; random street events spawn based on weather/time.

### 0.2.5 Interior/Exterior Context
- Certain actions are indoor (reduced weather effect) vs outdoor (weather applies fully).
- Interiors: casinos, hospitals, clubs; use darker overlays without rain/fog effects.
- Exteriors: streets, docks, rooftops; apply weather, police heat visuals, and crowd density chips.

## 0.3 Environmental Design — London Background Mandate
- Rule: every page uses the London background; non-optional. Night-time skyline, moody, fog/smoke, neon reflections, crane silhouettes, estate towers blurred. No white screens.
- Behaviour: responsive to weather/time-of-day overlays; subtle parallax allowed; performance-optimised assets (multiple resolutions); fallback image for low-end devices; loading states use dark gradients with skyline watermark.
- Coverage: login, register, all modules, popups, modals, tooltips; HUD glassmorphism acceptable but must keep contrast; error pages still show background; maintenance pages use dimmed skyline.
- Audio: optional ambient loops (rain, distant sirens, tube rumble) toggleable; default muted; per-page override for missions/events.
- Performance: GPU-friendly overlays; max texture sizes defined; memory budgets enforced on mobile; lazy load heavy assets after first paint.

## 0.4 Aesthetic Coding — "Dark Luxury"
- Palette: deep charcoals/ink base, gold accents, muted neons; high contrast for readability; avoid pure black to keep depth; gold used sparingly for hierarchy.
- UI rules: rounded cards, minimal shadow, tight spacing, dense data tables; consistent typography hierarchy; premium button states; disabled states visibly dimmed; chips for statuses with gold outline; iconography consistent.
- Motion: restrained—micro easing on hovers, tab transitions, log expansions. No jittery or bouncy animations; parallax limited to background; reduced-motion mode respected.
- Accessibility: maintain legible contrast; support reduced-motion toggle; readable font sizes; colour-blind safe status colours; keyboard navigation clear; focus states visible.
- Copy voice: concise, confident, UK-street inflected without heavy slang; system errors remain professional; flavour text for events/crimes concise noir lines.
- Layout density: emulate Torn’s multi-column density; limit empty whitespace; group actions logically.

## 0.5 Cultural Design Principles (Tone Rules)
- UK realism: slang, signage, police presence, transit patterns; no Americanisms in copy; currency is GBP; sirens, pub closing times, CCTV density, council estate naming.
- Cinematic crime drama: narrative framing, stakes, consequences, voice; combat and crimes feel like scenes from a British crime series; dialogue terse and tense.
- Dark Luxury overlay: even gritty content is presented with polish; tooltips and cards stay premium; use gold line work and dark glass panels; typography consistent.
- Anti-drift: if a feature risks feeling generic MMO, anchor it back to UK street detail and Dark Luxury visuals; avoid sci-fi/fantasy leaks; no superheroes or magic metaphors.
- Social texture: gossip feeds mirror UK tabloids; forum tone moderated to stay in-universe; achievements named with UK flavour.

## 0.6 Naming Engine — Global System
- Consistency: all items, NPCs, streets, properties, drugs, weapons use deterministic naming engines defined in later sections; reusable seed lists stored centrally; no one-off ad-hoc naming.
- Rules: UK-centric slang, estate references, brand-like weapon lines, designer-drug monikers; avoid parody brand theft; keep names pronounceable and not overlong; avoid real gang names.
- Components: prefix/suffix pools, borough/estate tags, luxury inflections, gang tags, serial numbers for rare items, seasonal variants, chem codes for drugs, property postcode nods.
- Governance: naming seeds versioned; collisions prevented; moderation review for edge seeds; localization hooks for rare cases.
- Cross-references: see Section 006 (items), Section 017 (properties), Section 148 (black market) for specific engines; ensure cross-module reuse to avoid drift; enforce through helper library.

## 0.7 Environmental Systems Interaction
- Weather & time: driven by Section 151; affects crimes, smuggling, combat visibility, NPC presence, market demand, bar regen; overlays update the background and HUD chips; travel times adjust by weather/time.
- Events: citywide or borough-level overlays (fog nights, heatwaves) change odds and UI chrome; event banners adapt to background; event loot tables tagged by weather/time.
- Police heat: location-dependent; escalates after crimes; decays with time; shown in HUD; affects spawn of patrols in crimes and faction wars; influences jail risk and mugging success.
- Crowd density: peak commuter hours increase NPCs and police; night increases nightlife NPCs; density chips shown on UI and modify crime/ambush odds.

## 0.8 UI & UX Requirements
- Layout: two/three-column Torn-density layouts; sidebars carry actions, logs, timers; headers show location, weather, police heat, player status; breadcrumbs for navigation.
- Always show: player HUD, borough/district/sector context, current weather/time, police heat; action availability based on status (hospital/jail/travel/stealth); tooltips for modifiers.
- Logs everywhere: city feed, faction feed, personal activity feed; timestamps in 24h UK format; include location/context; colour-coded severity.
- Mobile: responsive while retaining density via collapsible side panels; HUD condenses into top bar with expandable drawers; background scales without cropping critical skyline elements.
- Alerts: consistent toast style; warnings for high heat areas; prompts when actions are location-locked.

## 0.9 Anti-Abuse & Integrity
- Location validation: all actions require valid location context; spoofing blocked server-side with IP/device risk scoring; mismatched travel timers deny actions; VPN risk scoring informs soft limits.
- Cooldowns: per borough/district actions enforce timers; logged for audit; repeated failures increase police heat; cooldown bypass items capped.
- Smurf/automation detection: abnormal travel/crime timing flagged; feeds into mod tools; shadow penalties possible (reduced finds, increased heat); captcha escalation when flagged.
- Dupes: naming engine prevents collisions; city map prevents overlapping territories; item naming seeds tracked to avoid near-collisions; duplicated logs prevented by idempotent IDs.
- Compliance: GDPR-ready toggles, privacy modes for backgrounds/audio; PII never stored in logs; moderation tools redact sensitive fields.

## 0.10 Cross-System Hooks
- Crimes pull street/budget/weather modifiers (Section 023); property and faction ownership can influence crime odds locally; police heat directly modifies jail risk.
- Faction warfare uses sector control and borough bonuses (Section 011/045); background overlays show faction colour tint on sector pages; war timers aligned with time-of-day.
- Travel uses UK regions mapped onto borough exits (Section 016); time-of-day modifies travel availability for some routes; weather impacts travel times and risk.
- Properties respect borough prestige tiers and local buffs (Section 017); property UI shows borough/district icons and weather effects on comfort.
- Items/Black Market (Sections 006/148) embed naming engine outputs; illegal items may be borough-specific; shop stock rotates per borough/district.
- Missions/Events (Section 020): narrative references boroughs, weather, and heat; mission staging uses street names.

## 0.11 Asset & Performance Standards
- Background assets: multiple resolutions; lazy-loaded; cached; dark fallback for slow connections; CDN-ready paths; hashed filenames for cache busting.
- Iconography: consistent gold outline for core stats; status chips use desaturated neons; avoid skeuomorphic clutter; maintain small sprite sheets for performance.
- Performance: overlays and animations GPU-friendly; no heavy canvas effects on mobile; image sizes capped with WebP where possible; LCP targets monitored; background swap throttled.
- Offline/low-bandwidth: fallback to flat gradient with skyline silhouette; warn if assets disabled; keep UI functional.

## 0.12 Copy & Localization Rules
- UK spelling enforced; slang curated list; avoid overuse; no US-centric idioms; currency symbols set to GBP; date/time 24-hour, day-month-year.
- Tone: concise, confident, noir; avoid jokes unless explicit event flavour; respect Dark Luxury style even in tooltips.
- Localization-ready strings: key texts stored in resource files; placeholder braces supported; avoid embedding HTML in copy.
- Moderation of text inputs: profanity filters with UK slang awareness; friendly error feedback; logs for rejected strings.

## 0.13 Data & Logging
- Every action must log borough/district/sector/street context; weather/time; police heat; player status; device flags for anti-abuse.
- Background choice logged for A/B if multiple variants exist; measure performance impact and user preference; store anonymized metrics.
- Naming engine outputs logged to ensure uniqueness and audit for moderation; collisions raise alerts.
- Map interactions logged to tune UX; travel path selections captured for analytics.

## 0.14 Moderation & Compliance
- Visual content: no IRL brand infringement; no explicit content; avatars/banners moderated; auto-blur pending review; frames and banners vetted for IP issues.
- Location spoofing, botting, and exploit attempts flagged; IP/device fingerprints stored per privacy policy; appeals handled via support.
- GDPR-ready: background/audio toggles remembered; profiling disclosures in settings; data export/delete flows documented.
- Safeguards: news feed and logs avoid doxxing; location displayed only at borough/district level to avoid stalking risk; precise coordinates reserved for wars and consensual contexts.

## 0.15 Example Flows
- Crime run: player in Hackney Cut at night fog—crime page shows Hackney badge, fog chip, police heat medium; nerve cost adjusted; logs capture street, fog, heat; background overlays fog and moisture sheen on panels.
- Faction war: Camden High sector assault at dawn—background tinted with faction colour; weather clear; sector buffs listed; capture logs include sector ID and weather; war timer visible; police heat rises rapidly.
- Travel: player leaves Brixton Sector to Manchester route—travel timer set; status chip shows Traveling; location-locked actions blocked until arrival; weather at destination previewed; travel log emitted.
- Market visit: North Circular Rim market under rain—shop UI shows rain chip; firearm accuracy notes updated; price variance shown; police presence chip warns of higher bust risk.
- Mission scene: undercover meet in Peckham Bloc alley at midnight—background darkened with neon bleed; stealth bonuses highlighted; failure pushes police heat; log tagged with alley/street name.

### For Architect GPT
- This section defines the immutable world contract: location hierarchy (borough → district → sector → street), Dark Luxury aesthetic, naming engine dependencies, environmental overlays, copy rules, and performance guardrails. All modules must reference these layers for context and modifiers. Ensure global services for location context, background assets, naming engine, weather/time signals, police heat, and analytics/logging.

### For CodeGPT
- Enforce location context on every action; inject borough/district/sector IDs into requests and logs; reject mismatches with travel/status. Centralize background/overlay assets and weather/time hooks; supply client-friendly payloads for UI chips and breadcrumbs. Provide naming-engine utilities globally with seed pools, collision checks, and moderation hooks. Implement logging middleware that records location + environment on every action; expose analytics for heat/density. Honour reduced-motion and low-bandwidth modes.

### For BalanceGPT
- Tunables: borough/district modifiers, police heat decay/gain, weather impact scaling, background overlay intensity, faction control bonuses per layer, crowd density effects. Guardrails: avoid making any borough strictly optimal; ensure weather variance changes behaviour without soft-locking players; keep resource bonuses small but meaningful; maintain pacing parity across boroughs despite flavour differences.

### For QAGPT
- Test: location validation on all actions; background present on all pages including modals/error states; weather/time overlays update without breaking UI; naming engine outputs unique, UK-appropriate names; logs capture borough/sector context; performance on mobile and low bandwidth; reduced-motion/low-bandwidth modes. Watch for exploits via spoofed locations, missing heat checks, naming collisions, or broken breadcrumbs; validate police heat adjustments; ensure A/B asset loading respects privacy/performance toggles.
# SECTION 002 — PLAYER IDENTITY & PROFILE

## 1.0 Overview
Identity is a gameplay system, not a cosmetic layer. The profile communicates power, reputation, social intent, eligibility, and risk. Every field is actionable; every badge and title signals opportunity or danger. UK realism, Dark Luxury visuals, and Torn-grade density guide the presentation. Profiles must expose quick actions, state, history, and trust signals while protecting against abuse and impersonation.

## 1.1 Core Identity Pillars
- Recognisable: readable name, distinct vibe, consistent visual brand; reputation visible via badges, titles, rank, faction/company affiliation.
- Deep: long-term chase for ranks, titles, achievements, medals, stats, wealth, reputation; 1–5 year journey with prestige layers and seasonal exclusives.
- Social: identity ties into factions, companies, marriage, beef history, enemies/friends, trade, chat/forums, contracts, bounties.
- Functional: profile is an action panel (attack, mug, trade, send items/cash, invite to faction/company, marry, bounty, revive, message, contract offer, report).
- Customisable: banners, frames, titles, badges, layout presets, accent colours, premium profile themes; cosmetic only; signals status without altering mechanics.

## 1.2 Identity Fields
### 1.2.1 Username
- 3–24 chars, unique, Naming Engine rules (UK street, clean viral nicknames; no slurs/politics/real gangs/self-harm). Sanitised and logged on change; history visible to reduce impersonation.
- Similarity warnings when close to existing names; staff-like prefixes blocked; profanity filter aware of UK slang.

### 1.2.2 Numeric ID
- Permanent, sequential; primary key for API, logs, trade, faction sorting, database indexing, social lookups; always displayed on profile and in logs to disambiguate name changes.

### 1.2.3 Avatar & Frames
- Upload required; moderated queue; default silhouette if absent. Stored in 128x128 + 512x512. EXIF stripped; size/type limits enforced; content rules enforced (no IRL gang signs).
- Frames (cosmetic tiers): Standard (free), Silver (supporter), Gold TrenchMade (prestige), Obsidian (Dark Luxury signature), Event frames (seasonal), Faction frames (war rewards), Company frames (tenure). Frames show acquisition source; no stats.

### 1.2.4 Banners & Backgrounds
- Banner slot behind avatar/stats; Dark Luxury palettes only. Premium themes purchasable; seasonal/event variants time-limited; animated banners optional with reduced-motion fallback; brightness auto-balanced for readability.

### 1.2.5 Titles
- Earned via ranks, achievements, events, factions, properties, companies, missions; player-selectable; some gated by prestige/donator. Title history stored for audit; seasonal titles expire; title change cooldown prevents spam.

### 1.2.6 Badges & Medals
- Permanent proofs of feats (crimes cleared, chains, wars, events, anniversaries, market reputation, contracts fulfilled). Displayed in compact bar; expandable grid for details. Badges tier (bronze/silver/gold/obsidian) with recorded date of upgrade; duplicate prevention enforced.

### 1.2.7 Last Action / Status
- Last action timer (minutes) plus status chips: Online, Idle, Traveling, Hospital, Jail, In Mission, In Event, Stealthed (obscured timer via items/perks), Under Cooldown. Travel and stealth rules defined in Sections 016/023/151. Hospital/jail durations visible; stealth shows “concealed” with allowed window lengths.

### 1.2.8 Reputation & Influence
- Composite score from rank, faction respect, company role, marriage, crime stars, war history, market trust, contract completion rate. Shown as a bar + breakdown tooltips. Influences recruitment filters and bounty pricing; market trust reduces escrow fees.

### 1.2.9 Social Graph
- Friends/enemies lists with caps; mutual indicators; recency of interaction; opt-in profile visit counter for donators; block list with enforcement across chat/DM/trade/bounties.
- Beef history: recent conflicts summarized for transparency; optional privacy for donators within limits.

## 1.3 Profile Layout (UI/UX)
- Header: avatar + frame, username/ID, title, badges, reputation bar, quick action buttons (attack/mug/trade/send cash/items/invite/bounty/message/revive).
- Left column: identity stack, bars snapshot, active effects, location/weather/heat chips, status timer, travel route (if any).
- Right/center: battle stats, working stats, faction/company info, property/home, spouse, last action, city heat, recent logs, contract hooks.
- Tabs: Overview, Stats, Crimes, Faction, Companies, Properties, Achievements, Logs, Social. Each tab shows data + actionable controls; tab content cached and invalidated on change.
- Density: Torn-style multi-panel with tooltips; no empty whitespace; responsive collapsible sidebars on mobile; breadcrumbs to borough/district.

## 1.4 Social Systems Integration
- Factions: show faction name, rank, respect contribution, chain role, war status. Actions: invite/kick (if leader), declare rival (Section 011/045), donate items/cash, view chain readiness. War deserter tag if applicable.
- Companies: show employer, role, performance, perks (Section 014); apply/quit buttons respect cooldown; company badge shows tenure tier.
- Marriage: spouse link, anniversary, shared perks/cooldowns (Section 020 social hooks); divorce flow with cooldown and fee; shared property perks listed.
- Friends/Enemies: add/remove; affects notifications and bounty filters; lists searchable; bulk management tools; enemy highlight on logs.
- Messaging: quick DM entry point; spam/harassment protections; rate limits; report tools; staff inbox separate.
- Contracts: view open/closed contracts; invite to contract; reputation impact for defaults.

## 1.5 Security & Moderation
- Name/Avatar/Banner reviewed on change; automated filters + human queue; blurred pending review for flagged content; strike system for violations.
- Privacy toggles: show/hide last action (bounded by rules), hide medals (not badges), DM permissions (everyone/friends/faction), visit counter opt-in, block list; stealth hides timer but not status.
- Anti-impersonation: username change fee + cooldown; historical names visible; cannot mimic staff formatting; similar-name warnings and search de-confliction.
- Audit: all changes logged with timestamp/IP/device; moderation view for content and history; ban escalations recorded; appeals documented.

## 1.6 Progression & Unlocks
- Cosmetics unlock via level, rank, events, faction wars, company performance, achievements, properties, missions. Prestige frames/titles gated behind high rank and TrenchMade tier; seasonal exclusives archived but viewable.
- Verified seller badge unlocks with market trust; medic title unlocks with revive count; war medals tied to chain/sector victories.

## 1.7 Logs & Tracking
- Identity changes (name, avatar, banner, titles, frames) logged with timestamp/IP; visible to moderators and partially to players (name history). Profile visit logs for donators aggregated (no exact IPs). Action buttons generate logs (attack, mug, trade, bounty, contract offer).
- Reputation delta log for transparency; negative events (scams, defaults) reduce trust; appeals can annotate logs without deletion.

## 1.8 Anti-Exploit Notes
- Username changes impose cooldown + fee; prevent rapid impersonation; whitelist/blacklist enforced; homoglyph detection blocks lookalikes.
- Avatar/banner uploads virus-scanned; enforce size/type; rate limited; metadata stripped; AI-detected explicitness triggers review.
- Title selection cooldown (short) to reduce log spam; achievements cannot be spoofed; badge granting server-authoritative.
- Status spoofing blocked (cannot set Online while Traveling/Hospital/Jail). Stealth timer has caps; stealth disabled in certain events/wars.
- DM spam throttles; bounty/contract abuse detection; trade scam reports tied to identity trust.

## 1.9 Interactions & Edge Cases
- Crimes: reputation can gate certain high-end crimes/OCs; mugging option hidden if target immune (hospital/jail/travel/peace timer); crime heat may display on profile.
- Factions: high-rep players raise faction recruitment quality and bounty attractiveness; deserter flag shows on profile if recently left a war; spy risk flagged.
- Market: verified seller badge reduces escrow; dispute history shown; scam flags reduce visibility; buyers can filter by trust.
- Marriage: shared property perks and cooldowns; divorce resets shared perks and sets cooldown on remarriage; domestic perks listed in property UI.
- Travel: while Traveling, certain actions disabled; profile shows route and ETA; attack button disabled unless special intercept missions apply; last action timer continues.
- Hospital/Jail: quick actions disabled; revive and bust buttons shown; status timer visible; profile accessible with limited tabs.

## 1.10 UI Copy & Tone
- Buttons concise (Attack, Mug, Trade, Invite, Bounty, Message, Revive). Status chips short (Online, Idle, Traveling 12m, Hospital 23m).
- Tooltips explain consequences (bounty cost, mugging jail risk); warnings for friendly-fire restrictions; Dark Luxury styling maintained.

## 1.11 Data Model & Storage (Conceptual)
- Identity table: username, numeric ID, avatar frame/banner references, titles owned/active, badges, trust scores, privacy flags, last action timestamps, status, location context.
- Logs table: identity changes with IP/device; action logs linked to profile; reputation deltas.
- Privacy: only necessary fields exposed to clients; sensitive fields hidden behind moderation access.

## 1.12 Example Flows
- New player: chooses username, uploads avatar (pending review), picks starter banner; gets Standard frame; limited badges; profile shows tutorial title; actions limited until level 3.
- Rank-up: gains title and badge; prompted to select title; reputation bar increases; logs record unlock.
- Name change: pays fee; change queued for review; name history updated; friends/enemies lists retain numeric ID; old name visible on history.
- War deserter: leaving faction mid-war flags profile; trust drops; rank decays faster for a period; badge removed if tied to current war.

### For Architect GPT
- Profile is the hub that binds identity, social, and action shortcuts. Depends on bars (Section 002), battle stats (Section 003), working stats (Section 004), XP/rank (Section 006), factions (Section 011/045), companies (Section 014), travel (Section 016), properties (Section 017), missions/events (Section 020), weather/time (Section 151 overlays). Requires centralized identity service, moderation queues, trust/reputation service, and consistent logging.

### For CodeGPT
- Endpoints: profile view (tabbed), update identity fields (name/avatar/banner/title/frame), apply cosmetics, fetch action availability, enforce rate limits. Enforce status/location affects available actions. Provide moderators with change logs and content queues. Cache profile but invalidate on changes/bars/status; protect against impersonation and homoglyphs. Implement privacy toggles, visit counters (opt-in), and trust score updates.

### For BalanceGPT
- Tunables: name-change fees/cooldowns, avatar/banner upload limits, profile visit counter availability, title/frame gating thresholds, rep weighting across systems, stealth timer lengths, deserter penalties, trust decay for disputes. Avoid cosmetics creating power creep; keep signals meaningful but not gating core play.

### For QAGPT
- Test identity change workflows, validation, and moderation queues; ensure profile quick actions respect status (hospital/jail/travel/stealth); verify privacy toggles; ensure logs record changes; test rate limits against spam/impersonation; confirm banned content filters block edge cases; check mobile layout parity; verify homoglyph detection and history display.
# SECTION 003 — BARS, RESOURCES & DAILY LOOPS

## 2.0 Overview
Bars set the heartbeat of Trench City: they gate combat, crimes, training, travel, survival, missions, faction wars, and events. Each bar is meaningful, regenerates deliberately, and is cross-linked. Buffs come from donator status, properties, factions, education, items, events, weather, and time-of-day. The goal is predictable cadence with meaningful variance and clear UX feedback.

## 2.1 Core Bars
- Energy: combat, gym, missions, some crimes/OCs; the power bar.
- Nerve: crimes, black market interactions, covert actions; the risk bar.
- Happy: training multipliers, rare event influence, property comfort; the morale bar.
- Life (HP): survival in combat/wars/travel mishaps; the vitality bar.

### 2.1.1 Energy
- Caps: Base 100; Donator 150; TrenchMade 175; faction/property/education bonuses small additive; temporary boosts from consumables.
- Regen: +5 per 5 min base; Donator +6; property/faction/education minor bonuses; weather/time mods (fog night +1 per hour; heatwave -1 per hour). Regen is server-ticked; no client authority.
- Uses: attacks, muggings, gym sets, missions, faction raids/black ops, high-end crimes, hunting. Some events consume energy shards (partial cost) to smooth pacing.
- Items: energy drinks, boosters, faction stims; diminishing returns per hour; hard cap on consecutive uses; crash effects if overdosed (temporary happy/nerve drop).
- Debuffs: severe injury can increase energy costs; intoxication can reduce effective energy by percentage for a window.

### 2.1.2 Nerve
- Caps: Base 25; Donator 30; TrenchMade 35; faction upgrades +2; education reduces cost for certain categories instead of raising cap.
- Regen: +1 per 5 min; boosters and properties can add small regen; jail sets current nerve to floor; long-term failure can temporarily reduce cap until cleared by time/education/perks.
- Uses: crimes (all tiers), OCs, black market deals, certain mission steps, covert faction ops.
- Risk: failures can temp-reduce nerve cap; high police heat reduces regen; items with nerve boosts can carry crash to happy/life; max cap damage threshold per day to prevent perma-locks.

### 2.1.3 Happy
- Caps: Base 1000; properties drive main increases; drugs swing happy sharply (up then crash); events/seasonals can spike; hospital/jail reduce to floor values.
- Regen: property-driven baseline; reduced in hospital/jail; weather (heatwave) can add small passive to outdoor properties; faction perks add %; education adds stability (reduced crash severity).
- Uses: gym multiplier (higher happy increases stat gains up to cap); some crimes get small bonus; some missions require minimum happy; property parties consume happy for buffs.
- Crashes: drug and booster crashes reduce happy and sometimes bar regen; severity reduced by education or perks.

### 2.1.4 Life (HP)
- Caps: Base 100; scales with level, stats, items, armor, education; hospital raises cap briefly via meds; faction upgrades add %; drugs may lower effective cap briefly.
- Regen: slow passive; medical items, hospital, faction med bays speed it up; weather (cold) slows regen outdoors slightly; intoxication can slow regen.
- Uses: combat uptime; travel mishaps; event hazards; persistent damage effects (bleed, burn) tick against life.
- Floors: minimum life after defeat; hospital sets regen context; revive sets to threshold based on medic quality.

## 2.2 Regeneration & Modifiers
- Tick: global 5-minute server cadence; paused during maintenance; catch-up not granted to avoid abuse.
- Stacking: flat bonuses then multiplicative small factors; diminishing returns beyond thresholds to avoid runaway regen.
- Suppression: jail/hospital apply regen penalties; certain debuffs (drug crash, severe injury) reduce or pause regen; cap reductions recover over time.
- Display: HUD shows time to next tick, time to full, active modifiers, suppression states; logs show source and magnitude.
- Weather/time: nights may slightly boost nerve regen; heatwaves may slightly suppress energy; fog can modestly aid stealth crime nerve efficiency.

## 2.3 Refills & Consumables
- Energy: drinks/boosters; cooldown stacking; overfill not allowed unless specific consumable with decay; crashes reduce happy/nerve.
- Nerve: nerve kits, black market tinctures; higher crash risk; cannot exceed cap; may add temporary crime crit bonus with later crash.
- Happy: sweets, nightlife items, property parties; crashes possible; stacking debuffs if spammed; donator perks lessen crash duration.
- Life: medkits, first-aid, hospital services, faction medics; revives consume items/energy for medic; revive logs recorded with success/fail and cost.
- Anti-spam: per-item cooldown, global refill throttle, diminishing returns; suspicious refill loops flagged; IP/device correlation checks.

## 2.4 Daily Loops & Pacing
- Sessions: 3–6 meaningful actions per login; bars encourage return every few hours; donators get slightly smoother pacing but not infinite loops.
- Dailies: login streaks, property upkeep, gym sets, crime batches, faction chain windows, company shifts, missions; daily bonuses tied to bars (e.g., first full energy spend gives small bonus XP once per day).
- Soft caps: stacking refills decay effectiveness; crime/jail loops discourage botting via pattern detection and reduced XP on repetition.
- Event cadence: special events may temporarily alter regen or costs; always logged and time-boxed; tooltips show event modifiers.

## 2.5 UI/UX
- HUD: always show bars with caps, regen timers, buff/debuff icons, crash states; hover tooltips list sources and suppressions; colour-coded chips for normal/boosted/suppressed.
- Alerts: warn before actions if bars insufficient; suggest refill sources where appropriate; show upcoming tick time; confirm when crash risk is high.
- Mobile: condensed HUD with expandable details; background remains Dark Luxury; timers accurate within seconds; offline warnings if drift detected.
- Accessibility: numeric values always visible; tooltips readable; reduced-motion mode disables animated bar fills.

## 2.6 Logs & Tracking
- Every bar change logged with reason (item, tick, action, crash, suppression). Crime failures log nerve cap hits. Refills log item ID and cooldown state. Visible to player and auditable by mods; analytics events for pacing metrics and abuse detection.
- Crash logs include source, severity, duration; suppression logs include cause and recovery time.

## 2.7 Anti-Abuse
- Rate limits on refills; diminishing returns within windows; captchas on suspicious refill/crime loops; impossible regen patterns flagged; time-skew exploits blocked server-side.
- No client authority; all bar math server-side; reconcile on login; detect duplicate session abuse.
- Jail/hospital farming patterns monitored; bar gains during scripted macros throttled.

## 2.8 Interactions
- Gym (Section 008): happy multiplier influences stat gain; energy cost per set; debuffs reduce effectiveness; crash states reduce gym efficiency.
- Crimes (Section 023): nerve cost, modifiers from weather and district heat; jail impacts bars; nerve cap damage on failures; police heat interacts with nerve regen.
- Combat (Section 010): energy spend; life damage; drug effects can alter bars; post-fight hospital timers influence regen; mugging success affected by current energy/happy.
- Factions (Section 011/045): upgrades and war cooldowns; chain windows drive bar planning; faction med bays alter life regen; energy/nerve boosts during chains with caps; respect rewards may include temporary bar bonuses.
- Properties (Section 017): primary happy source; some regen perks; property parties consume/boost bars; comfort reduces crash severity.
- Weather (Section 151): fog/night minor nerve boost; heatwave minor energy penalty; rain may reduce happy decay for indoor properties; smog events reduce regen slightly outdoors.
- Travel (Section 016): travel consumes time; bars regen during travel unless event modifies; some travel mishaps cost life/energy.

## 2.9 Edge Cases & Error States
- Overfill attempts rejected with clear message; consumables only consumed if effect applied; race conditions resolved server-side.
- Disconnected mid-action: action atomic server-side; bars updated or rolled back; logs include failure reason; client can request sync on reconnect.
- Time desync: server authoritative; client displays server time; no offline regen stacking; warnings if device clock drifts.
- Multiple sessions: last write wins on actions; bars reconciled per tick; duplicate action requests deduped by nonce.

### For Architect GPT
- Bars are core resources referenced by combat, crimes, gym, travel, missions, factions, companies, properties, weather. Ensure a centralized bar service with modifier registry, suppression rules, crash logic, logging, and HUD API. Support future bars if needed with same pattern; design for server-authority and multi-session safety.

### For CodeGPT
- Implement server-side tick scheduler; modifier stacking (flat then mult); item cooldowns and diminishing returns; crash effects; suppression states; logging with reasons. Expose HUD endpoint with timers/effects. Validate all action costs atomically; prevent overfill exploits and time-skew abuse; dedupe requests; enforce cooldown stacking.

### For BalanceGPT
- Tunables: base caps/regen, donator/TrenchMade bonuses, item refill values/cooldowns, crash severities, weather impacts, faction/property bonuses, soft-cap curves, nerve cap damage on failure. Goal: meaningful pacing without hard stalls; varied builds via modifiers; protect against refill spam dominance.

### For QAGPT
- Test regen cadence accuracy, cap enforcement, refill cooldown stacking, crash application, suppression effects, log correctness, mobile HUD integrity. Watch for exploits via time skew, duplicate refills, nerve-cap manipulation, or overfill races; validate action denial messaging; test multi-session consistency and disconnect/reconnect sync.
# SECTION 004 — COMBAT SYSTEM

## 3.0 Overview
Combat must feel familiar to Torn veterans (math parity) while being uniquely UK-street and cinematic. Builds emerge from stats, perks, drugs, items, faction bonuses, territory, weather, and time-of-day. Logs are rich, readable, and auditable. The system supports PvP, faction wars, missions, NPC encounters, and events with consistent rules and anti-abuse safeguards.

## 3.1 Philosophy
- Real: damage, weapons, armor, accuracy scale with believable UK weaponry and outcomes; hospital/jail risk makes choices matter.
- RPG Depth: battle stats, perks, drug tolerance, faction/territory buffs enable build diversity; no single-stat dominance; diminishing returns protect balance.
- Cinematic: stylised logs, effects, and pacing; fast resolution; rich feedback; Dark Luxury overlays on battle pages; sound cues optional.
- UK Street DNA: knives, bottles, bats, DIY firearms, chem-mixed drugs, borough-specific flavor, estate footwork; police response risk tied to mugging/war actions.
- Math Parity: predictable formulas akin to Torn; transparent enough for theorycraft; server authoritative with secure RNG.

## 3.2 Primary Battle Stats
- Strength: melee damage, recoil control, armor break chance; slight influence on throwables and shield break.
- Speed: initiative, dodge chance, double-hit chance, crit evasion, escape chance when fleeing; affects reload speed minimally.
- Defense: damage mitigation, crit damage reduction, stagger resistance; reduces bleed severity and knockdown odds.
- Dexterity: accuracy, crit chance, weapon handling, reload speed; boosts status application success and headshot odds.

## 3.3 Derived Sub-Stats
- Hit Chance: attacker Dex vs defender Speed; weapon accuracy and status effects modify; capped to avoid 100% or 0%.
- Dodge Chance: defender Speed vs attacker Dex; diminishing returns to prevent untouchable builds; floor to prevent unwinnable fights.
- Crit Chance: Dex, weapon rarity, perks, drug boosts; capped; some weapons have floor crit chances; certain armor lowers incoming crit chance.
- Crit Damage: weapon base + perks/drugs; mitigated by Defense and armor; explosive crits differ with splash falloff.
- Mitigation %: armor + Defense + perks; piercing weapons reduce mitigation; minimum damage floor prevents 0 damage hits.
- Initiative: Speed + weapon readiness + effects (surprise, weather visibility, time-of-day); some consumables modify first turns only.

## 3.4 Combat Flow
1) Engagement: attack action validates location, bars, status (not hospital/jail/travel unless special missions). Checks faction rules (no same-faction friendly fire unless spar), peace timers, and police heat if mugging.
2) Initiative roll: Speed + modifiers; ambush bonuses from crimes/stealth; fog/night bonuses apply for stealth builds; surprise missions override.
3) Turn loop: attacker/defender exchange attacks using equipped weapons; consumables usable if rules allow; accuracy/crit/dodge rolled per hit; status effects applied; ammo tracked.
4) Resolution: life to zero -> hospital/jail/outcome; mug logic if applicable; loot rules enforced; durability reduced; faction respect assigned if relevant.
5) Cooldowns: attacker energy spent, defender hospital timer applied; anti-snipe timers may trigger in events/wars; protection timers start if configured.

## 3.5 Weapons & Damage Types
- Melee: knives, bats, improvised; higher Strength scaling; can apply bleed; lower noise for stealth crimes; some weapons stun.
- Firearms: pistols, SMGs, shotguns, rifles; accuracy ranges; recoil; ammo quality matters; wet weather reduces firearm accuracy; shotguns gain close-range bonus; suppressors reduce noise but lower damage.
- Explosives: limited use; area damage; risk collateral; faction war objectives; trigger police heat spikes; have arming timers.
- Exotic/DIY: chem sprayers, shock batons; apply status (stun, burn, slow); legal risk higher; limited ammo and durability.
- Damage types: blunt, sharp, ballistic, explosive, elemental/chem; armor has type resistances; enemies have vulnerabilities/resists; head/limb hit tables possible.

## 3.6 Armor & Mitigation
- Slots: head, torso, legs; categories: light/medium/heavy; special suits (chem-resistant) for events.
- Stats: flat mitigation, % mitigation, crit resist, status resist, encumbrance (initiative penalty), noise reduction (stealth benefit); some armor adds regen penalties.
- Degradation: durability loss per hit; repair via items/companies; black-market mods can alter durability and resistances at risk of penalties.
- Set bonuses: certain matched sets grant small bonuses; no overpowering set effects.

## 3.7 Status Effects
- Bleed (HP loss over time, reduced regen), Stun (skip/penalize turns), Burn (ongoing damage, accuracy drop), Slow (initiative penalty), Suppressed (crit down), Adrenaline (temp Speed up, crash after), Bruised (Defense down), Wet/Soaked (electrical vulnerability), Dazed (accuracy down), Intoxicated (randomness up), Shocked (action skip chance), Pierced (mitigation reduced).
- Stacking: some stack intensity, others refresh duration; caps per effect type; cleansing via meds, time, or skills; crashes applied after some buffs expire.

## 3.8 Drugs & Boosts
- Pre-fight boosts: accuracy, crit, Speed; crash penalties to bars and stats later; tolerance builds, reducing effect and increasing crash chance; stacking limited.
- In-fight consumables: medic kits, stims, anti-status sprays; action cost and cooldown; cannot exceed one use per few turns; medics may reduce action cost.
- Testing: effects logged; abuse flagged when tolerance thresholds exceeded repeatedly; police heat increased for public drug use in certain districts.

## 3.9 Environment Modifiers
- Weather (Section 151): fog reduces accuracy/initiative; rain lowers firearm accuracy; heatwave minor Speed drop; night boosts stealth/ambush; lightning storms increase chance of shock effects with electrical weapons; snow slows melee swings slightly.
- Location: sector buffs, faction control bonuses, building interiors reduce weather impact; underground areas negate rain/wind; docks add slip risk; rooftops boost crit chance for ranged but lower dodge.
- Time-of-day: night bonuses for stealth builds; day improves police interference chance (affects mugging outcomes and escape attempts); dusk/dawn minor visibility penalties.

## 3.10 Logs & UI
- Log content: initiative order, hit/miss, damage, crits, status applied/cleansed, armor mitigation, item use, bar changes, final outcome, mug loot, police heat change. Rich text with icons; expandable details for math-curious players; concise summary for casuals.
- Replay: allow viewing recent combat logs from profile/faction war page; privacy respect for stealth missions; share link within faction.
- Accessibility: concise summary + full detail toggle; mobile-friendly; timestamps; colour-coded outcomes; sounds toggle.

## 3.11 Anti-Abuse & Fairness
- Server-side RNG; no client seeds; double-submit protection; idempotent attack endpoints; request nonces.
- Cooldowns on chain abuse; revive/mug chains monitored; diminishing returns on repeat farm of same target; bounty abuse detection.
- Anti-snipe windows configurable for events/wars; spawn protection for freshly revived players (short window); friendly-fire rules obeyed.
- Exploit watch: scripted attack loops, duplicate damage packets, status-stack exploits, sync bugs; log anomaly detection; ammo duplication prevention.

## 3.12 Interactions
- Bars (Section 002): energy spend; life damage; crashes; suppression from drugs impacts combat; happy indirectly via stat gains over time.
- Gym (Section 008): battle stat growth curves and diminishing returns; caps inform balance and hit/dodge probabilities.
- Crimes (Section 023): ambush/stealth bonuses feed into initiative and mugging; police heat influences escape chance; crime weapons may be cheap/unstable.
- Factions (Section 011/045): war buffs, sector bonuses, chain mechanics; faction medics and armories supply consumables; respect gains tied to opponent rank.
- Items (Section 006/011): weapon/armor stats, rarity, mods; black-market exclusives with legal risk; durability and legal flags tracked per item.
- Weather/Travel: traveling players cannot attack; weather modifies on-map fights; travel ambush missions possible; time-of-day gates some missions.

## 3.13 Edge Cases
- Attacking from jail/hospital/travel/mission lockout must fail with clear message; no resource spend.
- Disconnections mid-fight: server resolves fully; client can fetch final log; no partial states; retry safe to pull result only.
- Tie handling: if both hit zero simultaneously, attacker wins but hospital timers adjusted; mug not granted if tie triggered by mutual KO.
- Faction friendly-fire sparring: reduced damage; no loot; reduced respect impact; clear labeling to avoid confusion.

## 3.14 Data & Logging (Conceptual)
- Combat log table: attacker/defender IDs, location, weather/time, heat, rolls, effects, damage numbers, items used, durability changes, result, timestamps, RNG seed reference.
- Anti-abuse flags: repeated target detection, impossible hit streaks, missing cost deductions; alerts to moderators.
- Privacy: stealth operations redact attacker identity in public feeds but store privately; faction logs may show masked names if covert.

### For Architect GPT
- Combat depends on bars, battle stats, items/armor, drugs, weather/time, faction/territory buffs. Needs a central combat resolver service with pluggable modifiers, status engine, durability tracking, mugging flow, police heat hooks, and consistent logging used by PvP, NPC, and mission combat.

### For CodeGPT
- Implement validated attack endpoint, initiative calc, hit/dodge/crit rolls, damage/mitigation pipeline, status effect engine, consumable rules, durability changes, mugging flow, respect assignment, and detailed logs. Enforce server RNG, cooldowns, and anti-duplication. Support replay retrieval and privacy for stealth ops; integrate police heat; ensure idempotency with request IDs.

### For BalanceGPT
- Tunables: stat weights for hit/dodge/crit, mitigation curves, weapon/armor baselines, drug boosts/crashes, status durations, weather/territory modifiers, hospital timers, mug payouts, revive timers, spawn protection, police heat gains. Guard against invincible dodge tanks, one-shot metas, infinite stun-lock, or unkillable heal loops; maintain diverse viable builds.

### For QAGPT
- Test hit/miss/crit math across stat ranges; status stacking/expiry; armor durability changes; consumable limits; weather/time effects; log accuracy; anti-abuse triggers on rapid attacks; edge cases (invalid states); replay consistency; spawn protection; police heat adjustments; anti-duplication of costs/damage.
# SECTION 005 — WORKING STATS, JOBS & COMPANIES

## 4.0 Overview
Working stats power the UK economy simulation: hiring, promotions, company performance, mission unlocks, and crime support roles. Three stats—Manual Labour (MAN), Intelligence (INT), Endurance (END)—govern eligibility, efficiency, and special effects. Companies and jobs use Torn-like depth with Trench City flavour, Dark Luxury presentation, and anti-abuse safeguards. Economic loops must feel authentic to a UK city: logistics, security, nightlife, medical, tech, media, and underground support.

## 4.1 Working Stat Trinity
- Manual Labour (MAN): physical strength, mechanical skill, discipline, reliability; affects heavy tasks, security, construction, logistics.
- Intelligence (INT): awareness, education, technical skill, business sense; affects medical, tech, finance, legal, hacking.
- Endurance (END): stamina, stress tolerance, shift reliability; affects delivery, policing/security, nightlife, transport.

## 4.2 Effects & Uses
- Jobs: eligibility thresholds, promotion chances, shift success, special procs (bonus outputs, reduced cooldowns, discounts); higher stats unlock elite shifts.
- Companies: performance multipliers, service quality, customer bonuses, supply yields; staff stats weighted per role; upgrades amplify.
- Crimes/OCs: roles (muscle, hacker, driver) scale off working stats to improve success and reduce timers; failures damage morale in companies if tied.
- Missions: certain stages require INT/END checks; branching outcomes when checks fail.
- Crafting (future): MAN/INT for quality/success; END for batch size; reputations linked to output quality.
- Properties: staff effectiveness influenced by working stats where applicable; property staff pay tied to roles.

## 4.3 Acquisition & Training
- Primary growth via job shifts and company work; side growth via education courses; minor boosts via missions/achievements; limited consumables for temporary boosts.
- Diminishing returns per day to prevent macro abuse; soft caps that reduce gains, not hard stops; weekly bonus for varied roles to encourage spread; anti-bot detection on repetitive shift spam.

## 4.4 Jobs (NPC Employers)
- Tiers: Entry, Skilled, Professional, Elite. Each has base pay, XP, working stat gains, and unique perks.
- UK-flavoured roles: Hospital/Clinic (medic, porter), Met Security, Logistics/Warehouse, Construction, Nightlife/Bouncer, Tech Support, Legal Clerk, Media/PR, Transport/Courier, Rail Maintenance.
- Requirements: MAN/INT/END bands, sometimes level gates; background checks (crime history) for certain roles; region/borough preferences possible.
- Shifts: different tasks per job with cooldowns, success odds, reward spread; critical success/failure events; overtime option with higher risk; rare event hooks (strike days, tube delays).
- Promotions: require stat thresholds + tenure + performance score; demotions for inactivity or repeated failures; warnings before demotion.
- Quit/rejoin: cooldown to prevent hopping; rehire may reset tenure perks; blacklist if fired for fraud.

## 4.5 Companies (Player-Owned)
- Types: Medical, Transport, Security, Tech, Media, Hospitality, Retail, Manufacturing, Underground-adjacent (black-market support with risk).
- Structure: owner, directors, employees with roles; capacity scales with upgrades; roles define weightings for working stats and profit share.
- Mechanics: effectiveness = base * (weighted employee stats) * upgrades * morale * supply; customers receive perks/discounts; certain companies produce items or services (revives, transport fast lanes, intel reports, security passes).
- Upkeep: wages, supplies, maintenance; neglect lowers morale/effectiveness and triggers reputation loss; automated alerts for low supplies.
- Reputation: performance, customer ratings, faction contracts; impacts hiring and pricing; public rating displayed; fake reviews detected.
- Special contracts: factions can hire companies for services; risk/reward shaped by role and war state.

## 4.6 Morale, Performance & Wages
- Morale drivers: wages vs market, owner activity, success/fail events, workplace perks (property proximity), faction wars (risk/stress), safety incidents, strikes, supply shortages.
- Performance feeds back into revenue, perk strength, and employee stat gains; low morale reduces outputs and increases failure odds.
- Wage controls: min/max bounds; sudden spikes flagged; delayed payment penalizes morale; bonuses possible after profitable weeks; dividends tracked.
- Overtime: increases stat gain/payout chance but increases failure/stress; cooldown enforced.

## 4.7 Economy & Logs
- Shifts logged (time, role, outcome, rewards, stat gains, critical events, overtime flag).
- Company actions logged (hiring, firing, wage changes, dividends, upgrades, supply purchases, customer transactions, contract signings).
- Anti-abuse: wage laundering alerts, dummy employee detection, rapid hire/fire loops flagged; reputation penalties for scams; escrow for large service payments.
- Taxes/fees: optional system-level deductions; company ledger shows all flows.

## 4.8 UI/UX
- Job Center: listings with requirements, perks, cooldowns; clear progression tracks; comparison tool; filter by borough/role.
- Company Dashboard: revenue, morale, roster, upgrades, supplies, tasks, logs; Dark Luxury charts; faction contract status; risk warnings for underground types.
- Employee Panel: personal performance, next promotion needs, shift cooldown, wage; resignation button with warning; overtime toggle with risk note.
- Customer View: services offered, prices, reputations, restrictions; timers for service cooldowns; trust badges shown.
- Owner Tools: wage sliders with bounds, upgrade purchase flows, supply ordering, contract negotiation, blacklist management.

## 4.9 Interactions
- Factions: companies can supply faction consumables or services at discounts; faction bonuses can help employees; faction wars may disrupt deliveries; raids can target company supplies (risk for underground companies).
- Properties: high-end properties impress employers (minor rep); certain jobs require residence in safer boroughs; property staff benefits stack with company perks where allowed; commuting time may affect shift success slightly.
- Travel: some jobs/companies have regional bonuses; supply chains use travel timers (Section 016); delays if weather/heat high; rail strikes events affect transport companies.
- Crimes: certain roles provide intel/discounts on black market; working stats improve OC role outcomes; criminal history may block legal jobs but boost underground jobs.
- Market: company products list on market; trust scores influence sales; fraud detection ties to identity.

## 4.10 Edge Cases & Compliance
- Employees in jail/hospital cannot run shifts; company UI shows unavailable; morale impact minor if short; long absence triggers auto-unassign after grace period.
- Owner inactivity triggers caretaker mode; directors can pause wages/upgrades; extended inactivity can force ownership transfer via vote or liquidation with compensation.
- Bankruptcy flow: if upkeep unpaid, company enters arrears; perks disabled; staff paid from escrow if available; auto-liquidation sells assets; logs recorded for transparency.
- Scams/fraud: chargebacks reduce rep; repeat offenders blacklisted; moderator tools to freeze payouts; customers refunded from escrow when possible.

## 4.11 Data & Logging (Conceptual)
- Working stat service: stat values, daily DR trackers, gain sources; APIs for jobs/companies/crimes/missions.
- Company tables: roster with roles/stats, morale, wages, supplies, upgrades, reputation, contracts, ledger entries.
- Logs: immutable audit for hires, fires, wage changes, payouts, dividends, upgrades, critical failures, strikes, ownership changes.

## 4.12 Example Flows
- Promotion: player meets MAN/END thresholds and tenure; promotion request processed; wage bump; new shift unlocked; log recorded; morale boost.
- Hire with fraud detection: owner hires alt; system flags wage laundering risk; pay capped until trust built; log alerts moderators.
- Supply shortage: transport company fails to deliver; morale drops; reputation hits; customers notified; owner can expedite at higher cost.
- Bankruptcy: wages unpaid; morale collapses; services disabled; liquidation after grace period; staff released with severance; reputation reset penalty.

### For Architect GPT
- Working stats sit between economy, crimes, and progression. Needs shared services for stat checks, gains, diminishing returns, and logging. Jobs/companies modules depend on this; crimes/OCs reference roles. Company system requires morale, wage, supply, reputation, escrow, and contract subsystems; must tolerate inactivity and handle bankruptcy.

### For CodeGPT
- Implement job shift endpoint, promotion/demotion logic, company performance calc, morale system, wage/payment flows, supply consumption, reputation changes, contract flows, logging, anti-abuse detectors. Expose working stat service with caps/DR and APIs for other modules. Handle inactivity, arrears, and bankruptcy flows; integrate escrow for services; enforce hire/fire cooldowns.

### For BalanceGPT
- Tunables: stat gain per shift, soft caps, job pay, company perk strength, morale effects, promotion thresholds, quit cooldowns, wage bounds, anti-abuse thresholds, reputation decay/growth, overtime risk/reward, escrow fees. Keep wages competitive without eclipsing crimes/factions; ensure black-market companies carry risk and higher variance.

### For QAGPT
- Test eligibility checks, promotions/demotions, morale impacts, pay flows, logging accuracy, anti-abuse triggers (hire/fire loops, wage spikes, laundering), inactivity handling, bankruptcy, escrow refunds, and cross-module stat checks (OCs, missions) using working stats. Validate UI limits and warnings; ensure underground companies trigger risk flags properly.
# SECTION 006 — XP, LEVEL, RANK & TITLES

## 5.0 Overview
XP, level, rank, and titles form the backbone of long-term progression. Levels gate access and onboarding; ranks signal deep mastery; titles express identity. The curve mirrors Torn-style pacing: fast early growth, deliberate midgame, and a long tail for veterans. Prestige layers add long-term goals without invalidating prior effort. Progression must be transparent, table-driven, and integrated across crimes, combat, economy, missions, factions, and events.

## 5.1 XP System
- Sources: combat (attacks, hospitalisations, muggings, escapes, defenses), crimes (all tiers, OCs, black ops), economy (job shifts, promotions, company tasks, market sales), exploration (travel arrivals, hunting, city finds), social (revives, marriage milestones, events/contracts), education completions, seasonal events, limited passive (property staff, long donator streaks), faction wars (respect converted to XP with cap), missions/story arcs.
- Multipliers: donator, company perks, faction perks, territory bonuses, seasonal boosts, education; stack small (1–10%) to avoid trivialising the curve; soft caps on stacking; time-boxed boosts with clear timers.
- Anti-abuse: cap XP from identical actions in short windows; jail/failed crimes reduce gain; bots flagged by pattern detection; XP from staged fights discounted; diminishing XP from repeatedly farming same NPC; repeat mission exploitation blocked by cooldown and reduced reward.
- Transparency: UI shows current multipliers, sources applied to last gains, and remaining boosted duration.

## 5.2 Level System
- Purpose: unlock systems/features, matchmaking bands, soft power indicator; no hard cap; prestige available after milestones.
- Gains: cumulative XP increases level; prestige tokens offered after key milestones (e.g., 50, 75, 100) to reset partial systems for cosmetic/utility perks.
- Unlock cadence: early levels unlock basics; midgame opens crimes, travel, OCs; late game opens high-end factions/black market/events; property and company tiers tied; missions scale with level bands.

### 5.2.1 Trench City Progression Chart (Torn-like Curve)
| Level | Total XP | XP To Next | Notes / Unlocks |
| --- | --- | --- | --- |
| 1 | 350 | 350 | Profile basics, starter crimes, basic attacks |
| 2 | 1,039 | 689 | Intro missions, gym enabled |
| 3 | 2,150 | 1,111 | Gym multiplier shift, starter missions |
| 4 | 3,842 | 1,692 | Basic jobs open |
| 5 | 6,295 | 2,453 | Weapon categories expand |
| 6 | 9,757 | 3,462 | Nerve kit tutorial, small property access |
| 7 | 14,461 | 4,704 | Job Tier II eligibility |
| 8 | 20,655 | 6,194 | Crime tiers expand |
| 9 | 28,610 | 7,955 | Early missions branch |
| 10 | 38,618 | 10,008 | Deep Crimes first categories |
| 11 | 51,009 | 12,391 | Basic OCs prep, market tips |
| 12 | 64,039 | 13,030 | Organized Crimes access |
| 13 | 79,097 | 15,058 | Property Tier I upgrades |
| 14 | 96,438 | 17,341 | Higher gym multipliers |
| 15 | 116,423 | 19,985 | Hunting unlocked (Section 016) |
| 16 | 136,601 | 20,178 | Travel & Hunting expansion |
| 17 | 159,026 | 22,425 | Mid-tier missions |
| 18 | 185,503 | 26,477 | Casino mid-stakes, Property upgrades Tier II |
| 19 | 214,770 | 29,267 | Higher job tiers |
| 20 | 244,313 | 28,810 | Faction chains participation unlocked |
| 22 | 314,451 | 34,071 | Advanced crimes tiers |
| 24 | 397,612 | 41,080 | Black Market Tier I (Section 148) |
| 26 | 495,765 | 48,153 | Education advanced branches (Section 015) |
| 28 | 611,177 | 57,707 | Company leadership credibility bump |
| 30 | 746,440 | 65,263 | Faction officer tools expand |
| 32 | 904,627 | 79,094 | Advanced OC roles |
| 35 | 1,242,302 | 99,412 | High-end mission arcs |
| 40 | 1,866,911 | 122,165 | Sector warfare bonuses unlocked |
| 45 | 2,653,232 | 157,264 | Chain leader tools, advanced black ops |
| 50 | 3,635,987 | 171,551 | Prestige path opens; TrenchMade frame eligibility |
| 55 | 4,840,269 | 241,656 | Elite crimes, rare OC roles |
| 60 | 6,291,628 | 290,271 | Advanced black-market gear |
| 65 | 8,017,577 | 344,085 | Property luxury tier |
| 70 | 10,046,415 | 393,842 | Faction war command tools |
| 75 | 12,407,200 | 472,917 | Event-exclusive raids |
| 80 | 15,129,670 | 544,899 | Ultra missions, rare titles |
| 85 | 18,244,163 | 628,813 | Max gym multipliers plateau |
| 90 | 21,781,595 | 704,432 | Travel express lanes |
| 95 | 25,773,340 | 794,796 | Legendary item unlocks |
| 100 | 30,251,195 | 877,855 | Endgame prestige badges/titles |

- Shape: convex; early levels quick (<30 minutes to Level 5 with guidance), midgame deliberate, late-game slow to sustain long-term competition. Values approximate Torn-style curves with Trench unlock mapping.
- Bands:
  - 1–10: onboarding, core UI, basic crimes/combat.
  - 11–25: deep crimes, jobs/companies advance, travel opens, missions layer.
  - 26–50: faction chains/OCs, black market entry, property upgrades.
  - 50–100: prestige grind, elite content, vanity titles/frames, legendary unlocks.

## 5.3 Rank System
- Rank tracks mastery via action-weighted scoring: combat quality (stronger opponents give more), crime stars, war participation, missions, chains, events. Less volatile than level; slow climb; visible badge on profile and faction UI.
- Decay: inactivity reduces rank score slowly; never full wipe; war deserter penalty applied if quitting during conflict; heavy penalties for staged abuse.
- Uses: recruitment filters, bounty pricing, faction command gating, matchmaking weighting, black-market trust gates; market fee reductions for high rank.
- Transparency: rank breakdown shows contribution weights; decay timer shown.

## 5.4 Titles
- Earned via ranks, achievements, events, faction wars, missions, properties, professions; player-selected; some exclusive/seasonal; display acquisition source; expiration dates for seasonal titles; duplicates prevented.
- No stats; pure identity flex; some social gates (e.g., verified trader title lowers market fees modestly).
- Title inventory persists through prestige; selection cooldown prevents spam.

## 5.5 Prestige & TrenchMade
- After milestones, players can enter prestige cycles: reset partial systems (e.g., level to 1, keep items/faction) for cosmetic flex and minor QoL boosts (inventory slots, small regen bonus). TrenchMade tier awards Obsidian/Gold frames and unique titles; prestige tokens tracked and displayed with dates.
- Safeguards: confirm flow, warn about reset impacts, cooldown between prestiges; cannot prestige during active wars/events; titles retained unless seasonal expiry.
- Rewards: cosmetic, small QoL (bank interest cap, gym cost reduction), leaderboard badge.

## 5.6 UI/UX
- Level bar with projected time to next level (based on last hour rate), multipliers breakdown, recent XP events log.
- Rank badge with tooltip showing factors; decay timer; deserter flags; war participation summary.
- Title selector with preview; history viewer; filters; seasonal badges tagged; lock icons for gated titles.
- Progression chart accessible in-game; planning tips for new players; recommended activities per band.

## 5.7 Interactions
- Crimes: level gates difficulty; rank influences OC invites (Section 023); prestige may unlock unique crime paths; crime XP reduced at very high levels for trivial actions.
- Factions: chain roles unlocked by level/rank; respect gains scale with opponent rank (Section 011/045); war rewards give rank bonus; deserter penalties from rank feed into recruitment filters.
- Jobs/Companies: level gates elite roles; working stats interplay (Section 004); rank may improve hireability; prestige may reset job tenure unless opted out.
- Properties/Travel: higher levels unlock luxury tiers and fast lanes (Sections 016/017); prestige unlocks special property cosmetics.
- Missions/Events: difficulty scaling uses level bands; rewards scale with rank; seasonal events can grant unique titles/badges.

## 5.8 Anti-Abuse
- XP throttles on repetitive low-risk actions; alt detection on XP funneling; mission XP cannot be replay-farmed; staged fights discounted; AFK crime macros flagged; idle farm sessions capped.
- Rank exploits (staged wars/OCs) flagged and reduced; deserter penalties for leaving wars mid-fight; leaderboard audits; dupe detection for XP packets; exploits logged to moderation.

## 5.9 Implementation Notes
- Central progression service calculating XP with modifiers; emits events for analytics/logs; table-driven unlocks; feature flags per level for tuning; data-driven progression chart.
- Rank calculator with decay; prestige handler; title inventory and selection with cooldown; migration-friendly data model; API to show projected unlocks.
- Audit logging for XP grants, prestige activations, title awards; watchdog on abnormal grant size.

### For Architect GPT
- Progression is a shared service used by crimes, combat, jobs/companies, factions, missions, events. Needs unlock map, rank calculator with decay and deserter penalties, prestige manager, title inventory. Tie into identity (Section 001), bars (Section 002), gym (Section 008), factions (Section 011/045), and economy modules.

### For CodeGPT
- Implement XP gain pipeline with sources, multipliers, throttles; level unlock map; rank score accumulator with decay and penalties; title inventory and selection; prestige flow with safeguards and cooldowns. Expose progression chart to UI; ensure all actions call progression hooks; audit logs for anti-abuse; idempotent grant handling.

### For BalanceGPT
- Tunables: XP per action, multiplier caps, progression curve constants, unlock levels, rank weighting, decay rates, prestige rewards, deserter penalties, trust impacts. Targets: Level 5 quickly, Level 25 within days, Level 50 within weeks, Level 100 as long-term goal; rank progression slower and harder to spoof; prestige valuable but not mandatory.

### For QAGPT
- Test XP accrual across sources, multiplier stacking, unlock gating, rank updates/decay, title selection persistence, prestige reset rules, deserter penalties. Watch for farming loops, duplicated XP events, early/late unlock firing, leaderboard integrity, and idempotency under retries; verify UI shows correct projections and multipliers.
# SECTION 007 — ITEMS, WEAPONS, ARMOUR, DRUGS, VARIANTS & GEAR

## 6.0 Overview
The item system underpins combat, crimes, economy, crafting, black market, and collections. It must be Torn-depth with Trench City flavour: UK street gear, designer-edged Dark Luxury skins, and mechanical clarity. Items are deterministic via naming engines; every category has rarity, quality, degradation, legal risk, and upgrade paths. Logs, anti-duplication, and moderation are mandatory.

## 6.1 Item Taxonomy
- Categories: Weapons (melee/ranged/explosive/exotic), Armour (head/torso/legs/sets), Consumables (drugs, meds, boosters, food, drinks), Utilities (lockpicks, signal jammers, trackers), Attachments/Mods, Resources (craft mats), Collectibles (cosmetics, event items), Black-Market Specials (illegal tech/chem).
- Rarity tiers: Common, Uncommon, Rare, Epic, Legendary, TrenchMade (prestige). Rarity drives stats, drop rates, legal scrutiny, and repair costs.
- Quality grades: Poor → Standard → Fine → Pristine; affects base stats and durability; shown in item name suffix.
- Legal flags: Legal, Restricted, Illegal. Restricted/Illegal trigger police heat if detected (searches, crimes, travel).

## 6.2 Naming Engine
- Deterministic seeds: prefix/suffix, borough tags, brand lines, chem codes, seasonal variants. Avoid collisions; ensure UK flavour.
- Examples: “Camden Edge MkII”, “Blocline Suppressor .45”, “Obsidian Nightshade”, “Brixton Moloko Stim”.
- Mods inherit base name + mod tag (e.g., “+Reflex”, “+AP Drum”).

## 6.3 Weapons
### 6.3.1 Melee
- Types: knives, bats, crowbars, machetes, improvised bottles/pipes; specialty: collapsible batons, trench blades.
- Stats: damage, accuracy, crit, speed modifier, status (bleed/stun), noise (for crimes), durability.
- Use: stealth crimes (low noise), close combat; some grant mugging bonus; legal risk low unless “combat knife restricted”.

### 6.3.2 Firearms
- Types: pistols, SMGs, shotguns, rifles, DMRs. DIY variants with higher malfunction rate.
- Stats: base damage, accuracy range, recoil (affects follow-up accuracy), crit, ammo capacity, reload time, noise, durability.
- Ammo: standard, hollow point, AP, non-lethal rubber (reduced damage, low heat), incendiary (illegal). Ammo quality impacts jams and armor penetration.
- Legal risk: restricted/illegal, increases police heat when carried openly in high-heat districts; travel scans can seize and fine/jail.

### 6.3.3 Explosives
- Types: grenades (frag, flash, smoke), IEDs. Limited stack size; high heat; faction-war objectives; collateral logs.
- Stats: area damage, radius, status (stun/smoke), fuse time; misfire chance for DIY.

### 6.3.4 Exotic/DIY
- Chem sprayers, shock batons, nailguns, taser mods. Apply status (stun, burn, slow); higher malfunction; legal risk high.

## 6.4 Armour
- Slots: head, torso, legs; light/medium/heavy; chem-resistant suits; covert vests (low visibility, lower mitigation).
- Stats: flat mitigation, % mitigation, crit resist, status resist (chem/fire/shock), encumbrance (initiative penalty), noise reduction, durability.
- Sets: minor bonuses when wearing matching set; no overpowering set effects. Durability repairable via companies/black market.

## 6.5 Consumables
### 6.5.1 Drugs
- Types: stimulants (speed/accuracy), painkillers (mitigation), hallucinogens (high risk/reward), designer blends (luxury buffs). Each has boost, duration, crash, tolerance, addiction risk.
- Effects: bar boosts, combat stat buffs, status resist; crashes reduce bars/stats; tolerance reduces future effect and increases crash severity.
- Legality: many illegal; carrying/using in public may raise heat; overdoses send to hospital; addiction debuff reduces happy regen.

### 6.5.2 Meds
- First aid kits, revives (requires medic skill/items), bandages (bleed stop), detox sprays (remove status), hospital-only services. Quality affects potency.

### 6.5.3 Boosters/Food/Drink
- Energy drinks, nerve tonics, happy snacks; stacking limits; diminishing returns; some with social/party effects for missions/events.

## 6.6 Attachments & Mods
- Weapon mods: scopes (accuracy), grips (recoil), extended mags, suppressors (noise vs damage), laser sights (crit), AP drums (armor pen, jam chance up). Limited slots per weapon class; compatibility enforced.
- Armour mods: padding (mitigation), inserts (chem resist), stealth liners (noise reduction), cooling mesh (heatwave debuff resist).
- Installation: requires tools/skills; risk of failure for DIY/illegal installs; logs record mod changes; mods removable with chance to break.

## 6.7 Durability, Repair, and Wear
- All gear degrades on use; explosives one-time. Durability loss proportional to damage dealt/taken and item quality; malfunction risk rises when low.
- Repair: via companies (Section 014) or black market; cost scales with rarity/quality; illegal mods may block standard repair.
- Salvage: broken items can be scrapped for materials; chance to recover mods if removed before break.

## 6.8 Inventory Rules
- Slots: soft cap; backpacks increase; weight/encumbrance impacts initiative in combat; illegal items increase scan risk.
- Stacking: consumables stack; weapons/armor single-slot; limits per category for travel/airport checks.
- Binding: some items bound on equip or on pickup (event rewards); tradability flags enforced.
- Sorting/Filters: by category, rarity, legality, durability, recent; quick actions (equip, use, repair, sell, stash).

## 6.9 Acquisition & Sinks
- Sources: shops (legal/restricted), black market (illegal), faction armories, loot drops (crimes, missions, events), crafting, company production, travel imports.
- Sinks: durability loss/repair costs, crafting consumption, confiscation (police/airport), event turn-ins, donations to faction armory, scrapping.
- Events: limited-time items; seasonal skins; balance by keeping stats in line but cosmetics unique.

## 6.10 Legal & Heat Systems
- Carrying restricted/illegal items increases chance of searches during crimes/travel; confiscation possible; fines/jail; faction wars may ignore certain checks temporarily.
- Logs record seizures; insurance (rare) can refund partial value; items flagged on detection lists; stashes (properties) reduce scan risk.

## 6.11 Black Market Layer
- Special items with high risk/reward: covert weapons, nerve boosters, forged IDs. Requires access (Section 148), reputation, and level; purchase logs hidden from public but moderated.
- Fail states: scams, busts, counterfeit items with reduced stats; chance to trigger police heat spikes.

## 6.12 UI/UX
- Item cards show stats, rarity, quality, legality, durability, mods, effects, crash/tolerance, weight. Tooltips with roll ranges and caps.
- Inventory: bulk actions (sell, stash, repair), filters, quick-equip sets, compare view. Dark Luxury styling, dense tables.
- Warnings before using drugs/boosters about crashes and tolerance; confirm on illegal carry in high-heat zones; scan risk indicator.

## 6.13 Data & Logging (Conceptual)
- Items: unique IDs, template ID, quality, rarity, durability, mods, legality, bind state, owner, location (inventory/armory/property), creation source.
- Logs: creation, trade, equip/unequip, use, mod install/remove, repair, confiscation, salvage, destruction. Anti-duplication checks on UID; checksum for inventory snapshots.

## 6.14 Anti-Abuse
- Duplication protection: unique IDs, signed transactions, periodic inventory audits; rollback path for detected dupes.
- Mod stacking limits enforced; illegal stat inflation blocked; tamper-resistant roll generation server-side.
- Trade scams: escrow option; verified seller badge (Section 002) reduces fees; item preview with real stats; counterfeit detection chance for black-market items.

## 6.15 Example Flows
- Player buys restricted pistol: heat indicator warns; purchase logged; carrying through airport risks seizure; equip applies noise and accuracy stats; durability tracked per fight.
- Drug binge: player uses two stims; tolerance rises; crash applied after duration; logs show effects; next dose weaker; hospital if overdose.
- Repair: rare rifle at 20% durability repaired at company—cost scales; mod preserved; log created; if illegal mod, repair refused unless black-market.

### For Architect GPT
- Items sit under a unified item service with templates, quality/rarity roll logic, durability, legality, mods, and logging. Depends on naming engine (Section 001), black market (Section 148), economy/shops (Section 019), faction armory (Section 011/045), and progression gates (Section 006). Inventory must be server-authoritative.

### For CodeGPT
- Implement item templates with rarity/quality, legality, durability; CRUD with unique IDs; equip/unequip flows; mod install/remove; consumable use with effects/crashes; seizure/confiscation; repair/salvage; trade with escrow; logging and anti-duplication checks. Provide inventory APIs with filters and batch actions; enforce slot/weight limits; integrate heat checks during travel/crimes.

### For BalanceGPT
- Tunables: weapon/armor baselines, rarity multipliers, quality effects, durability loss rates, repair costs, drug boosts/crashes/tolerance, mod bonuses, seizure odds, black-market price/quality variance. Guard against power creep from mods and drugs; ensure illegal items carry meaningful risk.

### For QAGPT
- Test equip/use flows, durability changes, mod compatibility, crash/tolerance application, trade/escrow integrity, seizure events, inventory filters, duplicate detection, and logging. Validate heat indicators and warnings; check black-market counterfeit behaviours; ensure no stat inflation from stacking mods.  
# SECTION 008 — GYM, TRAINING & BATTLE STATS (AAA+ ULTRA EDITION)

## 7.0 Overview
The gym is the primary source of battle stat growth (Strength, Speed, Defense, Dexterity). It must mirror Torn’s depth while adding Trench City flavour: borough-themed gyms, Dark Luxury UI, weather/time modifiers, and anti-bot protections. Training is expensive in energy and driven by happy; diminishing returns and caps prevent runaway power while allowing long-term growth.

## 7.1 Stats & Functions
- Strength: melee damage, recoil control, armor break chance.
- Speed: initiative, dodge, double-hit chance, escape odds.
- Defense: damage mitigation, crit damage reduction, stagger resistance.
- Dexterity: accuracy, crit chance, weapon handling, headshot odds.
- Derived: hit/dodge/crit formulas from Section 003; gym only increases base stats; modifiers from gear/consumables apply after.

## 7.2 Gyms & Access
- Tiers: Starter → Street → Pro → Elite → TrenchMade; each with stat thresholds, fee multipliers, and bonus formulas.
- Borough flavour: gyms themed to borough culture (Brixton boxing, Camden fight clubs, Towerblock calisthenics). Minor flavour modifiers without regional imbalance.
- Access: level/stat gates; some require membership fees; faction-owned gyms for bonuses during wars; travel gyms in regions (Section 016) with unique bonuses.
- UI: gym list with requirements, cost per set, expected gains, current happy multiplier, active buffs/debuffs.

## 7.3 Training Mechanics
- Cost: energy per set; happy multiplier; gym-specific multiplier; diminishing returns (DR) curve per stat; optional boosters for temporary gain.
- Calculation (conceptual): gain = base * gym multiplier * happy multiplier * (1 - DR(stat_value)) * temporary buffs. DR increases with stat magnitude to slow high-end growth.
- Happy multiplier: scales up to cap; crash states reduce; hospital/jail sets happy floor (low gains).
- Crit training events: rare “focus” events give small bonus; logged.
- Failure: none; but poor happy/low gym tier yields low gains; overcaps blocked.

## 7.4 Buffs, Debuffs, and Modifiers
- Buffs: property comfort, faction upgrades, education courses, consumables (pre-workout stims), weather (cool evening + tiny stamina boost), events (double-gym weekends).
- Debuffs: drug crashes, injuries (bleed/broken bones), heatwave (minor penalty unless gym is indoor cooled), fatigue from back-to-back sets (soft penalty).
- Caps: max daily buff stacking; DR ensures balance; warnings when gains low.

## 7.5 Diminishing Returns & Caps
- DR curve per stat similar to Torn’s exponential; configurable constants. Prevents infinite growth speed; still allows long-term grind.
- Soft daily DR: repeated sets in short time grant slightly less to discourage macro spam; resets slowly.
- Hard caps: none; but growth approaches asymptote; prestige titles for hitting thresholds.

## 7.6 Progression & Unlocks
- Unlock higher gyms as stats rise; unlock special trainings (sparring dummies, precision drills) that bias towards Dex/Speed gains.
- Achievements for milestones; titles for multi-stat thresholds; TrenchMade gym cosmetics at elite levels.

## 7.7 Sparring & NPC Drills
- Optional sparring consumes energy, yields smaller stat gain but grants combat logs for practice; no loot; small XP.
- NPC drills for accuracy/dodge practice; yields Dex/Speed modest gains; uses energy; logs results; potential small skill XP for future systems.

## 7.8 UI/UX
- Dense layout: stat bars, current values, projected gains per set, cost, happy multiplier, active buffs/debuffs, DR indicator, time to regen.
- Quick-set buttons (1 set, 5 sets) with confirmation when energy low or crash present.
- Logs of recent training sessions with gains; graphs for stat progression.
- Dark Luxury visuals; borough-specific accents; weather chips shown if modifiers apply.

## 7.9 Anti-Abuse & Integrity
- Server-side calc; no client influence on gain; requests idempotent; nonce-based to prevent double-submit.
- Rate limits on set spam; captcha on suspicious patterns; logs audited; action denied if happy too low to gain meaningfully.
- DR and soft caps prevent scripting advantage; analytics to detect impossible gains.

## 7.10 Interactions
- Bars: consumes energy; happy multiplier key; crashes reduce gains (Section 002).
- Items/Drugs: pre-workout stims boost gains briefly; crashes follow (Section 006).
- Properties: higher happy baselines; property gyms provide small bonuses (Section 017).
- Factions: upgrades for gym effectiveness; war states may grant temporary gym buffs or lock certain gyms.
- Weather/Time: heatwave penalties unless indoor; night calm bonus small; events can override.
- Progression: stat thresholds gate content (crimes, missions, combat) and gym tiers; prestige may apply cosmetic gym badges.

## 7.11 Data & Logging
- Training records: stat before/after, gym ID, costs, buffs applied, DR factor, happy at time, weather/time, location context.
- Audit: detect anomalies; expose to mods; store for progression analytics.

### For Architect GPT
- Gym is a core progression engine; depends on bars (Section 002), items/drugs (Section 006), properties (Section 017), factions (Section 011/045), weather/time (Section 151). Needs DR functions, buff registry, and secure training endpoint.

### For CodeGPT
- Implement training endpoint with validation (energy/happy/gym access), gain calc with DR, buff/debuff application, logging, rate limits. Provide projections to UI; handle multi-set requests atomically; ensure idempotency; store history for graphs.

### For BalanceGPT
- Tunables: base gains, gym multipliers, DR constants, happy cap, soft daily DR, buff strengths, crash penalties. Aim for steady growth without trivializing high-end; protect against stim abuse; allow events to spike gains temporarily.

### For QAGPT
- Test gain accuracy at low/mid/high stats; DR application; buff/debuff stacking; multi-set atomicity; logs correctness; rate limits; mobile UI projections; weather/time modifiers; crash impacts; edge cases (low happy, wrong gym tier).  
# SECTION 009 — COMPLETE AAA ULTRA EDITION

## 8.0 Overview
Crimes are a core progression pillar alongside combat and economy. The system must match Torn’s depth: multiple categories, nerve scaling, difficulty tiers, success formulas, loot tables, police heat, jail/hospital outcomes, organized crimes (OCs), and black ops. Trench City overlays UK street flavour, borough/street context, weather/time modifiers, and Dark Luxury UI. All actions are logged, anti-abuse protected, and tuned for long-term replayability.

## 8.1 Crime Categories & Structure
- Categories: Pickpocketing, Theft/Burglary, Fraud/Scams, Assault/Mugging, Smuggling, Cyber/Tech Crimes, Vandalism, Car Theft, Robberies (stores/banks), Kidnap/Ransom, Black Ops (faction), Special Events (seasonal), Organized Crimes (OCs).
- Sub-tiers: Each category has difficulty bands; higher tiers require nerve, level, stats, tools, education, faction roles, and location access.
- Street context: Crimes reference streets/estates; modifiers from borough, district, street type, police heat, crowd density, weather/time.
- Unlocks: Level and education gate higher tiers; OCs require faction role and minimum stats/nerve cap.

## 8.2 Core Mechanics
- Cost: Nerve cost per attempt; some consume items (lockpicks, jammers). Energy not used except hybrid crimes (assault/mugging).
- Success chance: Base formula using player stats (nerve, working stats, battle stats for violent crimes), crime difficulty, tools, education, faction bonuses, weather/time, police heat. Hard caps prevent 100% at high tiers.
- Rewards: Cash, items, respect (if faction black ops), XP, crime stars, unique loot tables. Rare outcomes (blue stars) for record logs and achievements.
- Failure states: Nothing found, partial success, jail, hospital, injury, heat spike. Jail duration scales with crime severity and recent heat; hospital for violent backfires.
- Heat: Police heat increases with failures and violent crimes; decays over time; modifies success and jail odds.
- Cooldowns: Category-specific cooldowns; OCs have prep timers; black ops have lockout windows.

## 8.3 Tools, Gear, and Requirements
- Tools: Lockpicks, signal jammers, disguises, burner phones, forged IDs, van rentals, crowbars, hacking kits. Quality affects success and failure risk; some consumed on fail.
- Gear synergy: Silent weapons reduce noise; armor lowers injury risk; vehicles improve escape; drugs boost stats but crash later.
- Education: Courses unlock categories, reduce nerve costs, improve escape, lower heat gain (Section 015).
- Location requirements: Certain crimes only in specific boroughs/districts (e.g., docks smuggling, bank in financial district).

## 8.4 Organized Crimes (OCs)
- Structure: Leader sets plan, invites roles (muscle, hacker, driver, lookout, negotiator). Each role has stat/working stat thresholds and tool requirements.
- Phases: Planning (assign roles, gather tools), Countdown (cooldown timer), Execution (server-side resolution), Outcome (rewards/failures logged).
- Success: Weighted by role fit, stats, tools, faction bonuses, morale, police heat, weather/time; minimum fail chance persists.
- Rewards: Cash, items, faction respect, XP, rare loot; failure can jail entire team, injure, or wipe tools.
- Logs: Detailed OC log to participants and faction; city log redacted for stealth OCs; anti-abuse detection for staged OCs.

## 8.5 Black Ops (Faction Crimes)
- High risk/high reward faction missions with bespoke objectives: sabotage supplies, sector interference, intel theft.
- Requirements: faction role, level/rank thresholds, special tools, time windows; nerve + energy costs combined.
- Outcomes: Respect, unique loot, intel for wars; heavy heat; failure triggers faction-wide penalties or war timers.
- Visibility: Hidden from public logs; faction/internal logs only; mods visible to staff.

## 8.6 Crime Stars, Achievements, and Progression
- Stars: Unique outcomes per crime recorded; completionism meta; repeatable for log but diminishing XP per repeat.
- Achievements: Milestones per category, per outcome, per difficulty; titles and badges; unlock black-market perks (Section 148).
- Difficulty scaling: Some crimes scale with player level/heat; others fixed; high-end crimes always risky.

## 8.7 Jail System
- Causes: Crime failures, police patrols, caught with illegal gear, faction war penalties.
- Duration: Scales with crime severity, heat, repeat offenses; capped to prevent soft-locks; reduced by faction perks/education.
- Actions in jail: limited chat, bust attempts by others, bribes (costs), wait, read education materials (tiny gains), request revive? (not from jail).
- Busting: Requires energy; success chance from stats/education; failure extends timers; logs and heat applied to buster.
- Escape items: rare black-market items to reduce timers; cooldowns apply; abuses flagged.

## 8.8 Hospitalization from Crimes
- Violent failures can hospitalize; duration based on damage roll; mitigated by armor, defense, and meds; faction medics can reduce.
- Crashes (drug/booster) can trigger hospital at high stacks.

## 8.9 Heat & Detection
- Heat gained by failure, violent actions, carrying illegal items; decays per tick with max decay caps; weather/time modifies patrol density.
- Effects: lowers success, increases jail odds, triggers random patrol encounters; high heat may block certain crimes temporarily.
- Visibility: HUD chip shows current heat; crime UI shows projected heat change; logs capture heat before/after.

## 8.10 Random Events & Crowd Density
- Street crowds modify pickpocket success; peak hours increase targets but also police; night reduces crowds, boosts stealth.
- Weather: rain reduces crowds outdoors, increases shop crime difficulty; fog aids stealth; heatwaves increase nightlife targets.
- Events: special crime variants during events (Halloween heists, Xmas shipments); temporary loot tables.

## 8.11 UI/UX
- Crime page: category tabs, difficulty bands, requirements, cost, success odds band (low/med/high, not exact %), projected rewards band, heat impact, tool selection, team invites for OCs.
- Filters: by borough/street, by difficulty, by cost; show locked crimes with clear requirements.
- Logs: personal crime log with outcome details, stars, heat changes, tools consumed; faction log for OCs/black ops.
- Warnings: show jail/hospital risk and heat spike; confirm if carrying illegal items in high-heat zones.

## 8.12 Data & Logging (Conceptual)
- Crime attempts table: player, crime ID, location, weather/time, heat pre/post, tools, stats snapshot, outcome, rewards, jail/hospital timers if any.
- OCs/Black Ops: team composition, roles, prep time, success factors, loot distribution, failures, penalties.
- Heat tracking: per-player heat value with decay timestamps.
- Anti-abuse: detect repeated same easy crime spam, staged OCs, impossible success streaks, identical-IP team stacking.

## 8.13 Anti-Abuse
- Rate limits on identical crime spam; XP/loot diminishing on rapid repeats; captcha if patterns trip detectors.
- OCs require diverse IDs; repeat teaming with same IP flagged; loot throttled if staged.
- Tool duplication checks; illegal item seizure on detection; logs immutable.
- Jail bust abuse detection; bust cooldowns; repeated failed busts increase bust heat.

## 8.14 Example Flows
- Pickpocket in Camden High at noon rain: moderate crowd, rain lowers visibility; success yields small cash; failure jail 5–10 mins; heat + small; log records weather/location.
- OC bank run: leader sets roles, gathers tools; countdown; success yields large cash/respect; failure jails team; tools consumed; heat spike logged.
- Black op sabotage: faction task at night fog; requires jammer + hacker; success reduces enemy sector buff; failure triggers war alert and respect loss.

### For Architect GPT
- Crimes require a crime service with categories, formulas, heat decay, jail/hospital flows, OCs/black ops orchestration, and location/environment hooks. Depends on bars (Section 002), stats (Sections 003/004/007/008), items/tools (Section 006/011), factions (Section 012/045), weather/time (Section 151), and travel/location (Section 016). Logging and anti-abuse are central.

### For CodeGPT
- Implement crime endpoints with validation (costs, tools, location, heat), success formula, rewards, failures, heat updates, jail/hospital timers, and logs. Build OC orchestration (role checks, countdown, execution) and black ops. Add heat decay scheduler, bust mechanics, and anti-abuse detectors. Provide UI APIs for requirements/projections and personal/faction crime logs.

### For BalanceGPT
- Tunables: nerve costs, success formula weights, heat gains/decay, jail/hospital durations, loot tables, XP per category, OC timers/rewards, bust odds, failure penalties, tool bonuses, event modifiers. Keep risk/reward balanced; preserve minimum fail chance; ensure high-tier crimes stay lucrative but risky.

### For QAGPT
- Test crime outcomes across bands; heat gain/decay; jail/hospital timer correctness; tool consumption; OC role enforcement and countdown; black ops visibility and penalties; bust success/fail; anti-spam diminishing returns; logging integrity; weather/time/location modifiers; edge cases with illegal items and high heat.  
# SECTION 010 — AAA+ ULTRA EDITION

## 9.0 Overview
This section specifies the combat resolver details: turn loop, targeting, multi-weapon handling, consumable rules, AI/NPC hooks, and logging fidelity. It extends Section 003 with implementation-grade behaviours to ensure Torn-parity math, UK flavour, Dark Luxury UX, and robust anti-abuse.

## 9.1 Resolver Components
- Initiative module: calculates starting order and turn priority with surprise/ambush rules and environment modifiers.
- Hit/dodge/crit module: deterministic formulas with secure RNG; caps and floors.
- Damage module: weapon/armor stats, mitigation, penetration, resistances, status effects, location (head/torso/legs).
- Status engine: applies/refreshes/cleanses effects with stacking rules and durations.
- Resource module: energy/life costs, consumable cooldowns, drug tolerance/crashes.
- Logging module: structured combat log events for UI and audit.

## 9.2 Turn Loop
1) Initiative: computed once at fight start; ambush modifies first round; tie-breaker by Speed then Dex then RNG.
2) Turn execution:
   - Select weapon/attack (primary; offhand if dual-wield allowed) or consumable if available.
   - Roll hit/dodge; if hit, roll crit; compute damage; apply mitigation and statuses; adjust durability and bars.
   - Check defeat; if defeated, exit loop.
3) Switch attacker/defender; repeat until one side defeated or timeout (anti-stall).
4) Resolution: outcome (win/hospital/jail), mug logic (if enabled), respect/XP assignment, heat adjustments, logs written.

## 9.3 Multi-Weapon & Loadouts
- Primary/secondary slots; swap costs a turn unless perk; dual-wield limited to light weapons with accuracy penalty.
- Ammo tracking per weapon; reload costs a turn; partial reload allowed; misfire chance at low durability or poor ammo.
- Weapon proficiency (future) may adjust handling; not required now.

## 9.4 Targeting & Hit Locations
- Head/torso/legs weighting by weapon; helmets reduce head crits; leg hits may slow; torso hits standard.
- Called shots: limited to specific missions/skills; increase hit difficulty but raise status chance.

## 9.5 Status Effect Details
- Duration in turns; intensity per application; some refresh, others stack up to cap.
- Cleanse: consumables/skills can cleanse specific types; cleanse logged.
- Interaction: Wet amplifies Shock; Burn blocks some regen; Stun blocks actions; Suppressed lowers crit; Bleed ticks before next turn damage.

## 9.6 Consumables In-Fight
- Allowed: medkits, antidotes, select stims; one use every N turns; costs action; logged.
- Crashes post-fight where applicable; tolerance tracked across fights; stacking capped.

## 9.7 NPC Combat
- AI profiles: aggressive, evasive, balanced, support; determines move selection and consumable use.
- Scaling: stats and gear scaled by level band and mission difficulty; loot tied to profile; no infinite farm.
- Logs: NPC actions logged same as players; drops recorded; anti-farm throttles per NPC type.

## 9.8 Environment Integration
- Weather/time modifiers from Section 151; interiors reduce weather effects; rooftops boost ranged crit but lower dodge; docks add slip risk.
- Police heat may interrupt certain public fights (muggings), forcing early stop or jail; logged.

## 9.9 UI/UX
- Battle view: Dark Luxury cards, clear turn order, health/energy bars, status chips with durations, weapon icons, ammo counts.
- Toggles: summary vs detailed log; sound on/off; reduced-motion; mobile condensed view.
- Pre-flight warnings: durability low, ammo low, illegal gear heat warning, drug crash incoming.

## 9.10 Data & Logging (Conceptual)
- Combat event log: ordered events with timestamps, attacker/defender IDs, rolls, damage, statuses, durability, items used, RNG seed reference, outcome.
- Metrics: win/loss per matchup, average turns, crit rates, dodge rates, status frequency; used for balance.
- Privacy: stealth ops redact attacker in public feed; full detail in audit log.

## 9.11 Anti-Abuse & Stability
- Idempotent attack endpoint with request nonce; double submission returns same result.
- Timeouts to prevent stall; anti-loop detection; max turn cap; server resolves if client disconnects.
- Duplicate damage packets prevented; ammo/consumable double-use blocked; RNG server-side only.
- Anti-automation: rate limits, pattern detection for scripting, captcha if triggered (outside wars).

## 9.12 Example Flows
- Ambush mug: attacker stealth bonus → initiative win → shotgun blast reduced by rain → defender hospitalized; heat increased; mug payout logged.
- War snipe: faction battle in clear weather; attacker uses rifle; crit reduced by target helmet; armor mitigates; respect awarded; sector log updated.
- NPC mission: player vs armored thug; AI uses medkit at 30%; fight logs show status cleanses; loot drops limited once per cooldown.

### For Architect GPT
- Combat resolver must be modular: initiative, roll formulas, damage, status, resources, logging, and environment hooks. Integrates with items (Section 006/011), bars (Section 002), stats (Sections 003/008), factions (Section 012/045), heat/police (Section 009), and weather/time (Section 151).

### For CodeGPT
- Build attack endpoint with nonce, validation, and lock; implement turn loop modules, ammo/reload, durability, statuses, consumables, environment modifiers, and logging. Ensure deterministic replay with stored events; handle disconnect/timeout; enforce cooldowns and heat effects on public fights.

### For BalanceGPT
- Tunables: roll weights, crit caps, dodge caps, damage/mitigation curves, status durations, ammo/reload costs, consumable cooldowns, turn cap, heat interruption odds. Guard against one-shot metas and evade tanks; maintain viable build diversity.

### For QAGPT
- Test hit/dodge/crit/mitigation across stat ranges; dual-wield penalties; ammo/reload flows; status stacking/cleansing; consumable cadence; disconnect/retry; timeout resolution; logging completeness; anti-duplication of costs/damage; environment and heat modifiers.  
# SECTION 011 — AAA ULTRA EDITION

## 10.0 Overview
This section complements Section 006 with deeper inventory, armory, attachment, legality, and audit rules, focusing on player-facing management, faction/company armories, and trade pipelines. Goal: Torn-grade functionality with Trench City flavour, Dark Luxury UX, strict anti-duplication, and robust logging.

## 10.1 Inventory Architecture
- Server-authoritative inventory with unique item IDs; supports multiple containers: personal inventory, property stash, faction armory, company storage, travel luggage.
- Weight/encumbrance impacts combat initiative; slot caps configurable; illegal items flagged; binding rules enforced (bind on equip/pickup/event).
- Sorting/filtering: category, rarity, durability, legality, bound/unbound, location; bulk actions (sell, stash, repair, scrap, donate).

## 10.2 Armories & Shared Storage
- Faction armory: role-based permissions (leader/officer/member); logs for deposits/withdrawals; quotas; lock during wars if leader enables; respect cost for armory upgrades.
- Company storage: owner/director controls; supplies for services (medkits, transport parts); permissions by role; logs; escrow for client deliveries.
- Property stash: capacity based on property tier; optional hidden compartments reduce seizure risk; share access with spouse (Section 002) with permissions.

## 10.3 Attachments & Mods (Expanded)
- Compatibility tables per weapon class; illegal mods (e.g., AP drums) flagged; install requires tools/skills; risk of failure on illegal installs.
- Removal: chance to break unless using proper kit; log success/fail; installed mods affect legality (suppressors reduce heat, AP increases).
- Stacking rules: limited slots; no duplicate same-slot mod stacking beyond cap; diminishing returns on accuracy/crit mods.

## 10.4 Item Lifecycle
- Creation: drops, crafting, shop purchase, black market, events, company production.
- Transfer: trade, market listing, faction/company deposit, gift, mail (if allowed). Trades use escrow; bindings respected.
- Use: consume, equip, install mod, repair, salvage; all logged.
- Deletion: destruction when durability zero (if non-repairable) or explicit scrap; illegal seizure; logs persist.

## 10.5 Legality & Seizure
- States: Legal, Restricted, Illegal. Carriage checked during crimes/travel/raids; seizure chance based on heat and location; fines/jail for restricted/illegal finds.
- Concealment: items with concealment stats reduce detection; stashes in properties lower scan odds; faction armory immune unless raided.
- Scans: airports/border checks, police patrols during crimes; results logged with item IDs and cause.

## 10.6 Trade & Market Safeguards
- Escrow by default; verified seller badge reduces fees (Section 002). Counterfeit detection for black-market items (random quality downgrade if fake).
- Price bounds to avoid laundering; trade cooldown for new accounts; IP/device checks to detect alt funneling.
- Dispute flow: hold items/cash, escalate to mods; trust score impact.

## 10.7 UI/UX
- Inventory grid/list with filters, quick actions, compare view, mod slots display, durability bars, legality icons, weight.
- Armory views show permissions, quotas, and logs; bulk move with confirmation; donate buttons show faction/company benefits.
- Repair/salvage dialogs show costs, success chance (if applicable), and outcomes; black-market repair warnings for illegal mods.
- Travel bag view shows scan risk indicator; warnings before travel with illegal items.

## 10.8 Data & Logging (Conceptual)
- Item table: UID, template ID, quality, rarity, durability, mods, legality, bind state, location, owner, creation source, trade state, weight.
- Log table: creation, trades, equips/unequips, uses, mod installs/removals, repairs, seizures, scrapping, transfers between containers.
- Snapshot/audit: periodic inventory snapshots for anti-dupe; diff tooling for moderation.

## 10.9 Anti-Abuse
- Duplication: signed transactions; snapshot diffs; rollback paths; alerts on impossible quantity changes.
- Trade laundering: price bounds, escrow, cooldowns, trust score; alt detection through IP/device/behavior.
- Mod stacking abuse: enforce compatibility; detect illegal combos; block stat inflation.
- Seizure evasion: detect repeated stash/travel exploits; increase scan odds on flagged accounts.

## 10.10 Example Flows
- Deposit to faction armory: player selects items, confirms; permissions checked; logs entry; armory capacity enforced; illegal items flagged for war use only.
- Market sale: list legal rifle with durability; escrow holds item; buyer receives on purchase; fee deducted; log created; verified seller fee reduction applied.
- Travel with illegal gear: scan risk shown; player proceeds; patrol detects; items seized; fine + jail; log; trust score hit; heat increased.

### For Architect GPT
- Inventory/armory needs a unified item service (Section 006) with legality, containers, permissions, trade/escrow, seizure, and audit. Depends on factions (Section 012/045), companies (Section 014), properties (Section 017), travel (Section 016), and black market (Section 148).

### For CodeGPT
- Implement container model, permissions, transfer endpoints, escrow, seizure checks, mod install/remove, repair/salvage, logging, anti-duplication snapshots. Enforce legality flags on actions; integrate with travel/crime scans; provide efficient filter APIs; ensure idempotent trades.

### For BalanceGPT
- Tunables: container capacities, weight effects, repair costs, seizure odds, escrow fees, price bounds, mod bonuses, durability loss rates. Ensure illegal gear carries risk; balance repair vs replacement; keep laundering unprofitable.

### For QAGPT
- Test container permissions, transfers, escrow flows, seizure events, mod compatibility, durability changes, repair/salvage outcomes, logging completeness, anti-duplication snapshot recovery. Validate UI warnings for travel/heat; price bounds enforcement; counterfeit detection.  
# SECTION 012 — AAA ULTRA EXPANDED

## 11.0 Overview
Factions are organized crews that own territory, wage wars, run black ops, and provide communal buffs. System must mirror Torn depth: respect, chains, wars, upgrades, armory, roles, diplomacy, logs. Trench City adds sector warfare (Section 045), UK borough flavour, weather/time modifiers, and Dark Luxury UI. Anti-abuse, logging, and moderation are critical.

## 11.1 Core Concepts
- Respect: primary currency earned via combat, crimes, wars, black ops; used for upgrades and diplomacy.
- Chains: consecutive hits within a timer; increases respect gain and unlocks chain milestones; breaks on timer expiry.
- Territory: sectors controlled yield income/buffs; warfare happens on sector grid; influenced by weather/time.
- Roles: Leader, Officers, Enforcers, Members, Recruits; permissions tied to role; customizable ranks optional.
- Armory: shared storage with permissions and logs; respect upkeep.
- Diplomacy: NAP, alliances, rivalries, war declarations; cooldowns and penalties for betrayal.

## 11.2 Creation & Governance
- Creation: cost in cash/respect; requires level/rank; name follows naming rules; tag unique; motto optional.
- Roles/Permissions: granular toggles for inviting, kicking, spending respect, declaring wars, moving armory items, launching chains/OCs/black ops.
- Activity: inactivity timers; leadership transfer rules; vote or auto-transfer if leader idle beyond threshold; audit trail.

## 11.3 Respect & Progression
- Earned from attacks (scaled by opponent rank/level), wars, chains, black ops, OCs, missions, territory events.
- Spend on upgrades: regen buffs, damage buffs, nerve cap, hospital reduction, armory size, chain timers, territory buffs, intel tools.
- Decay: small decay to prevent hoarding; paused during certain wars; minimum floor.
- Logs: respect gains/spends recorded; visible to leadership; filters by source.

## 11.4 Chains
- Mechanic: hits within a timer increase chain count; chain milestones grant bonuses (respect bursts, loot drops, temporary buffs).
- Timer: resets if no hit within window; extensions from upgrades/items; cap on max timer extension.
- Restrictions: no friendly fire; same target hit decay; anti-boosting detects repeated same IP targets; hospital/jail targets reduce value.
- Chain UI: shows count, timer, recent hits, multipliers, active buffs, target queue.

## 11.5 Wars & Sector Control
- War types: Standard war (respect race), Territory war (sector capture), Chain war (chain milestones), Contract war (objectives), Event war (seasonal rules).
- Declarations: respect cost; cooldown between wars; prep window; time-boxed.
- Victory: based on respect, sectors held, objectives; tiebreakers by damage/respect ratio.
- Sector control: tiles attackable during war windows; capture grants income/buffs; upkeep cost; sabotage possible via black ops.
- Weather/time: visibility and initiative affected in sector fights; fog and night favour stealth; heat increases patrol risk.

## 11.6 Black Ops & Intel
- Faction-only crimes that sabotage or gather intel: reduce enemy buffs, steal supplies, reveal armory, delay chain timer.
- Requirements: role, tools, level/rank; nerve + energy; cooldowns.
- Risk: heavy heat, jail/hospital; failure can give away intel on attacker; logged privately.

## 11.7 Upgrades & Facilities
- Categories: Combat, Crime, Regen, Armory, Chain, Territory, Intel, Medical.
- Examples: Energy/Nerve regen buffs; hospital time reduction; chain timer extension; accuracy/damage buffs; sector income boosts; intel scan reduces fog of war; med bay reduces revive cost.
- Costs: respect scaling; higher tiers expensive; some require territory or war wins.

## 11.8 Armory
- Shared storage; permissions by role; quotas; logs for deposits/withdrawals; illegal items flagged; war lockdown option.
- Contribution tracking: members earn contribution score for deposits and war hits; used for payouts/eligibility.
- Faction shop: internal prices for members; respect discounts; donation options.

## 11.9 Diplomacy & Relations
- States: Neutral, Ally, NAP, Rival, War. Cooldowns on changing states; betrayal penalties (respect loss, temporary debuffs).
- Bounties: faction can place bounties; tracked in diplomacy panel; costs scale with target rank.
- Peace offers: surrender/respect payment; enforced cooldown after peace.

## 11.10 UI/UX
- Overview: respect, upgrades, chain status, active wars, territory map, recent logs.
- Chain panel: timer, recent hits, targets, bonuses, history.
- War map: sectors with ownership, buffs, attack windows, weather overlays, heat indicators.
- Logs: recruitment, kicks, donations, armory changes, war events, chain hits, black ops, diplomacy changes; filters and exports.
- Permissions management: role matrix with toggles; audit trail for changes.

## 11.11 Anti-Abuse
- Boosting detection: repeated farming of same targets/IP/device; reduced respect; flags to mods.
- War exploitation: declaring/ending to dodge losses penalized; deserter flag for leaving mid-war; respect fines.
- Armory theft: permissions and quotas; logs immutable; sudden mass withdrawals flagged; escrow for valuable items during leadership changes.
- Chain padding: low-value hits on hospital/travel targets devalued; timer freezing exploits blocked.

## 11.12 Data & Logging (Conceptual)
- Tables: factions, roles/permissions, members, respect ledger, upgrades, wars, chains, territories, armory items, logs, diplomacy states.
- Logs immutable; support filters; export for moderation; key events push notifications to leadership.

## 11.13 Example Flows
- Chain push: officer starts chain; targets queued; hits logged; chain hits milestone → respect burst; timer extended by upgrade; chain ends at timeout.
- Territory war: declaration → prep → attack window; sectors contested; weather fog lowers accuracy; faction captures tile; income/ buffs applied; logs updated.
- Black op: team attempts intel theft; success reveals enemy armory contents; heat spike; cooldown set; failure alerts enemy with partial intel.

### For Architect GPT
- Faction system spans respect economy, chains, wars, territories, upgrades, armory, diplomacy, and black ops. Depends on combat (Sections 003/010), crimes (Section 009), items/armory (Sections 006/011), bars (Section 002), progression (Section 006), and weather/location (Sections 001/151). Needs services for respect, war orchestration, chain engine, territory map, and logs.

### For CodeGPT
- Implement faction CRUD, roles/permissions, respect ledger, upgrades, chain engine (timer, milestones), war engine (types, objectives, victory), territory control (capture/defense, income), black ops, armory with permissions/logs, diplomacy states. Anti-boosting detectors, deserter flags, immutable logs, notifications. Map APIs with overlays.

### For BalanceGPT
- Tunables: respect gains/caps, upgrade costs/effects, chain timer and milestones, war declaration costs/cooldowns, territory income/buffs, black op rewards/risks, deserter penalties. Ensure wars are meaningful but not perpetual griefing; prevent respect inflation.

### For QAGPT
- Test roles/permissions, respect earn/spend, upgrade application, chain timer, war declarations/resolution, sector capture/defense, armory permissions/quota, black op outcomes, diplomacy changes, logs integrity, anti-boost detection. Validate heat/weather effects in wars; test deserter penalties.  
# SECTION 013 — FULL UK URBAN SIMULATION

## 12.0 Overview
The city/world layer provides spatial context for every action: boroughs, districts, sectors, streets, interiors/exteriors, crowd density, weather/time, police heat. It must expose navigation, events, finds, NPC spawns, and economic variation. Dark Luxury aesthetic overlays every page; location context threads through logs and systems (crimes, factions, travel, properties).

## 12.1 Hierarchy Recap
- Borough → District → Sector → Street; Interiors/Exteriors.
- Boroughs: Brixton Sector, Peckham Bloc, Camden High, Towerblock Row, Hackney Cut, North Circular Rim.
- Each layer carries modifiers: crime odds, shop prices, NPC spawns, events, weather variance, heat, transit times.

## 12.2 Navigation & Map
- Global map with borough tiles; sector grid overlay; district markers; street search.
- Heat/weather overlays; ownership tint for sectors; event markers.
- Quick travel links between districts/boroughs with timers (Section 016); fees/time based on transit quality and heat.
- Mobile map: collapsible layers; fast filters.

## 12.3 Location Modifiers
- Crime: success, heat gain, jail odds, patrol chance influenced by borough heat, crowd density, weather/time.
- Economy: shop pricing, item availability, black market accessibility; richer districts lower heat but higher prices.
- NPCs: gangs by estate; merchants by district; special event NPCs spawn by weather/time.
- Events: district/borough events (market day, strike, blackout) adjust systems temporarily.
- Police heat: per-location; rises with crime density; affects patrols, searches, and jail durations.

## 12.4 Finds & Exploration
- City finds: random items/cash; rarity by location; frequency limited per time window; heat influences detection risk.
- Exploration actions: alley searches, rooftop scouting, dock watching; consume small energy/nerve; yields intel or items; logs location.
- Anti-bot: caps, cooldowns, diminishing returns; captchas if patterns detected.

## 12.5 Interiors vs Exteriors
- Interiors: reduced weather effect; certain crimes restricted; NPC types differ; CCTV density higher in malls/banks.
- Exteriors: weather applies; crowd density; line-of-sight; rooftop/underground offer unique modifiers.

## 12.6 Events & World State
- Scheduled and dynamic events: strikes (transport delays), power outages (CCTV down), festivals (crowds/happy buffs), rainstorms (visibility), smog (health penalties).
- Global tick updates events; UI banners; logs; end timers.
- Seasonal overlays (Halloween fog, Xmas snow) with crime variants and loot.

## 12.7 NPC & Encounter System
- NPC types: civilians, gangs, merchants, medics, police, special event NPCs. Spawn tables by borough/district/time/weather.
- Encounters: random events during travel/exploration; choices affect heat, loot, injuries; logs show location/context.
- Difficulty scales with player level band; rare NPCs drop unique loot.

## 12.8 Economy Variation
- Prices and stock vary by borough/district; black market access limited to certain areas/time windows; luxury shops in wealthier districts.
- Rent/property costs tied to borough prestige; company supply costs vary by region; transport fees tied to distance/heat.

## 12.9 UI/UX
- Location chips on every page; breadcrumbs; hover tooltips show modifiers (heat, weather, events).
- Map page with filters, overlays, and quick actions (travel, crimes, shops, faction targets).
- City feed showing recent events (captures, crimes bursts, weather changes).
- Dark Luxury styling with skyline background; per-borough accent colour subtle.

## 12.10 Data & Logging
- Location state: heat values, event flags, weather/time, crowd index per borough/district/sector/street.
- Logs: captures, events, crimes counts, finds, NPC encounters; stored with location context; exposed in feeds.
- Analytics: movement patterns to tune travel times and heat decay.

## 12.11 Anti-Abuse
- Teleport/warp prevention: travel timers enforced; location stored server-side; action denied if mismatch.
- Find farming: cooldowns, diminishing returns, pattern detection; IP/device correlation.
- Multi-session: last location authoritative; reconcile on login; block concurrent conflicting actions.

## 12.12 Example Flows
- Market day in Camden: prices down, crowds up; pickpocket risk/reward shifts; heat rises; city feed shows event banner.
- Blackout in Towerblock Row: CCTV off; crime success improves; police heat spike risk; events spawn tech looters.
- Rain in Hackney Cut: fewer civilians; shop crimes harder; stealth crimes easier; map overlay shows rain; heat decays slower due to patrol sheltering.

### For Architect GPT
- World layer service must expose location context, heat, events, weather/time, NPC spawns, and modifiers to crimes, combat, travel, economy, factions, properties. Depends on weather (Section 151), travel (Section 016), factions/territory (Sections 012/045), and crimes (Section 009).

### For CodeGPT
- Implement location state store, heat calculations/decay, event scheduler, spawn tables, finds, map APIs with overlays, and logging. Enforce location on actions; reconcile on login; prevent desync/teleport. Provide feeds and modifiers to other modules.

### For BalanceGPT
- Tunables: heat gain/decay per location, event frequencies/effects, find rates/loot, price variances, spawn rates, travel times. Ensure no borough is strictly best; rotate events; keep heat meaningful.

### For QAGPT
- Test travel timers/enforcement, heat updates, event scheduling start/stop, finds cooldowns, spawn tables variation, location chips correctness, map overlays, anti-teleport, and logging completeness. Validate effects on crimes/economy/combat.  
# SECTION 014 — FULL UK ECONOMY SIMULATION

## 13.0 Overview
This section expands Section 004 with full economy loops, job ladders, company depth, regional effects, and anti-abuse. Jobs and player-owned companies must feel like Torn’s economy with UK flavour and Dark Luxury UX: wages, perks, performance, morale, supplies, reputation, contracts, and fraud prevention.

## 13.1 Jobs (NPC Employers)
- Ladders: Entry → Skilled → Professional → Elite; each with roles, shift types, cooldowns, pay, stat gains, perks.
- UK-flavoured sectors: NHS/Clinic (medic/porter), Met Security, Logistics/Warehouse, Construction, Nightlife/Bouncer, Tech Support, Legal Clerk, Media/PR, Transport/Courier, Rail Maintenance, Hospitality.
- Requirements: MAN/INT/END thresholds, level gates, clean/dirty record gating (some roles block high crime heat; others prefer it).
- Shifts: multiple tasks per job with varying risk/reward; critical success/failure events; overtime option; weather/time may affect outcomes (e.g., night shifts for bouncers).
- Promotions/Demotions: tenure + performance + stat thresholds; inactivity demotes; warnings before demotion; probation for new hires.
- Quit/Rehire: cooldowns; rehire may reset tenure perks; blacklist for fraud/misconduct.
- Perks: discounts, XP boosts, revive bonuses (medical), crime heat reduction (security), transport speed (courier), intel tips (media/tech).
- Events: strikes, overtime bonuses, hazard pay during crises; displayed on job board.

## 13.2 Companies (Player-Owned)
- Types: Medical, Transport, Security, Tech, Media, Hospitality, Retail, Manufacturing, Underground-support (high risk).
- Structure: owner/directors/employees; roles define stat weighting and permissions; capacity via upgrades.
- Performance formula: base * weighted employee stats * upgrades * morale * supplies * reputation. Output influences customer perks and revenue.
- Supplies: consumed per service; shortages reduce performance; procurement via market/travel; weather/strikes can delay.
- Upgrades: capacity, quality, speed, reputation, supply efficiency, customer slots; cost cash + items; downtime during installation.
- Reputation: earned via successful services, customer ratings, contracts; reduced by failures, scams, delays; public rating displayed.
- Contracts: with players/factions/companies for services; escrow-backed; SLAs with penalties; log outcomes; high-risk for underground types.
- Pricing: owner sets prices within bounds; discounts for faction/allies; dynamic pricing possible; anti-gouging caps during events.
- Wages: per-employee; bonuses; payroll cycle; arrears impact morale/reputation; auto-pay option.

## 13.3 Morale & Workforce Management
- Drivers: wages vs market, owner activity, success/fail rates, safety incidents, perks, events, faction war stress, property commute.
- Effects: morale impacts performance, stat gain for employees, customer satisfaction.
- Recovery: bonuses, events, perks, leadership actions, resolving arrears; morale decays if neglected.
- Strikes: triggered by low morale/pay; halts services; requires negotiation/payment to resolve; logged.

## 13.4 Fraud & Abuse Prevention
- Wage laundering detection: price/wage bounds, trust scores, alt detection; escrow for contracts; transaction limits for new accounts.
- Dummy employees: repeated hire/fire loops flagged; contribution checks; tenure requirements for bonuses.
- Scam services: customer disputes; escrow holds; reputation penalties; moderators can freeze funds; blacklists shared across market.

## 13.5 Regional & World Hooks
- Location: company HQ in a borough/district; local heat/events/weather can affect service quality and supply chains.
- Travel (Section 016): supply delivery times; courier companies can self-buff travel speeds; strikes/blackouts add delays.
- Properties (Section 017): proximity perks; high-end offices boost reputation; property utilities reduce upkeep.

## 13.6 UI/UX
- Job Center: filters by role, requirements, pay, perks, location; event banners; promotion track visualization.
- Company Dashboard: revenue, morale, roster, upgrades, supplies, tasks, contracts, reputation, logs; Dark Luxury charts; risk warnings.
- Employee Panel: personal performance, promotion needs, cooldowns, wage; resign button with warnings; overtime toggle.
- Customer View: services, prices, SLAs, reputation, restrictions; escrow indicator.
- Owner Tools: wage sliders with bounds, upgrade purchases, supply ordering, contract negotiation, blacklist controls; audit trail.

## 13.7 Data & Logging
- Jobs: shift logs with outcomes, stat gains, pay, events, location, weather/time; promotion/demotion logs.
- Companies: hires/fires/wage changes/dividends/upgrades/supplies/contracts/strikes/payroll; revenue/expense ledger.
- Reputation: per-transaction ratings; dispute records; trust scores; fraud flags.

## 13.8 Anti-Abuse
- Cooldowns on hires/quits; wage and price bounds; escrow for contracts; alt detection; strike abuse detection (staged strikes).
- Supply duplication prevented; contract farming throttled; repeated failure refunds limited.

## 13.9 Example Flows
- Courier company during rain: deliveries slowed; morale dip if overworked; owner offers bonus; performance stabilized; reputation saved.
- Security company contract: faction hires for guard duty; escrow funded; services delivered; success boosts rep; failure penalizes and triggers refund.
- Strike: unpaid wages → morale crash → strike; owner pays arrears + bonus; strike ends; reputation partially restored.

### For Architect GPT
- Economy layer needs job service (NPC), company service (player-owned), morale, supplies, contracts, reputation, escrow, fraud detection. Integrates with working stats (Section 004), travel (Section 016), properties (Section 017), factions (Section 012/045), market (Section 019).

### For CodeGPT
- Implement job board, shift endpoints, promotion/demotion logic, company performance calc, supply consumption, morale/strike system, contracts with escrow, reputation and dispute flow, wage/payroll system, logging, anti-abuse detectors. Permissions for company roles; location effects on services.

### For BalanceGPT
- Tunables: pay ranges, stat gains, morale effects, supply costs, upgrade effects/costs, reputation weights, contract penalties, strike triggers, price bounds, escrow fees. Keep jobs competitive but not eclipsing crimes/factions; underground companies high variance.

### For QAGPT
- Test job eligibility, shift outcomes, promotions/demotions, morale changes, strike triggers/resolution, supply depletion, contract escrow, reputation changes, fraud detection, logging completeness, and UI warnings. Validate location/weather effects on performance.  
# SECTION 015 — FULL ACADEMIC TREES, CERTIFICATIONS

## 14.0 Overview
Education unlocks skills, efficiencies, and access across systems: crimes, combat, jobs/companies, medical, tech, black market, travel, and crafting. It mirrors Torn’s course trees but with UK flavour and Dark Luxury UI. Courses have prerequisites, costs, durations, and effects; some require location or items. Anti-abuse ensures no instant-complete exploits.

## 14.1 Structure
- Trees: General, Crime, Medical, Tech/Cyber, Engineering, Business, Legal, Black-Market, Travel/Logistics, Combat Support.
- Courses: each with duration, cost (cash/points), prerequisites (courses/level/stats), effects (unlocks, modifiers), location requirements (universities, colleges, private institutes).
- Certifications: grouped achievements when completing branches; grant titles/badges.

## 14.2 Progression & Scheduling
- One active course at a time by default; donators may queue one; premium institutes allow parallel micro-courses with fee.
- Duration: real-time hours/days; timers persist across logout; courses can be paused with penalty.
- Costs: cash; some consume items/books; advanced courses need reputation or black-market access.
- Fail states: missing prerequisites, insufficient funds, jailed/hospitalized at start; course pauses in jail/hospital (configurable for reading).

## 14.3 Course Effects (Examples)
- Crime: reduced nerve cost for certain categories; increased success for hacking/lockpicking; shorter jail times; improved bust success.
- Combat Support: improved medkit potency; reduced bleed; faster reload; better status cleanse; reduced drug crash.
- Medical: higher revive success; shorter hospital stays; unlock advanced meds; company medical perks.
- Tech/Cyber: unlock cyber crimes; improve hacking tools; reduce detection; enable intel scanning in faction wars.
- Engineering: improved repair efficacy; mod install success; crafting quality; explosive handling.
- Business/Legal: better market fees; reduced contract disputes; improved company reputation; reduced fines when caught.
- Travel/Logistics: reduced travel times; lower seizure odds at borders; improved smuggling success; cargo capacity.
- Black-Market: unlock black-market tiers; reduce scam risk; improve quality detection; unlock covert tools.

## 14.4 Delivery & Locations
- Institutions mapped to districts; prestigious schools in wealthy boroughs; underground tutors for illegal courses.
- Travel required for some courses; travel timers apply; boarding options for long courses.
- Environmental hooks: weather/time usually not affecting courses, except outdoor survival classes.

## 14.5 UI/UX
- Course catalog with filters (tree, duration, cost, prerequisites); lock icons with requirement tooltips.
- Course detail: duration, cost, effects, prerequisites, location; start/queue buttons; progress bar; pause/abort (with penalties).
- History: completed courses, effects summary, titles earned.
- Dark Luxury styling; academic crest motifs per tree; progress notifications.

## 14.6 Data & Logging
- Courses table: id, tree, duration, cost, effects, prerequisites, location, flags (legal/illegal).
- Enrollments: player id, course id, start/end, status (active/paused/completed/aborted), timestamps.
- Logs: starts, completions, pauses, aborts, failures; moderators see illegal course flags; analytics on completion rates.

## 14.7 Anti-Abuse
- No speed-ups beyond designed boosts; time-skip exploits blocked; server authoritative timers.
- Course swaps limited; abort refunds partial at most; cooldown after abort to prevent cherry-picking effects.
- Illegal courses flag risk; doing them under high heat can trigger events; multiple illegal enrollments raise scrutiny.

## 14.8 Interactions
- Crimes: unlock categories, reduce nerve, improve success, reduce jail; black ops require certain courses.
- Combat/Medical: revive strength, hospital reduction, status cleanse; medics need certifications.
- Companies: higher roles require degrees/certs; efficiency boosts from related courses.
- Properties: study bonuses from high-end properties; libraries reduce duration slightly.
- Progression: some titles locked behind academic completion; XP awarded on completion.

## 14.9 Example Flows
- Player enrolls in Hacking 201: pays fee; timer starts; completes to unlock cyber crimes and small success boost; log created; title “Scriptkiddie” earned.
- Black-market Chemistry: requires access; increases drug crafting quality; flagged as illegal; increases heat slightly; completion grants covert title.
- Medical Certification: grants revive bonus and hospital time reduction; required for company medical leadership role.

### For Architect GPT
- Education service provides time-based courses with prerequisites and effects. Integrates with crimes (Section 009), combat/medical (Sections 003/010), jobs/companies (Section 014), black market (Section 148), properties (Section 017), and travel (Section 016). Needs timer management, prerequisites engine, and effect hooks.

### For CodeGPT
- Implement course catalog, enrollment, timers, pause/abort, prerequisites checks, effects application, logging. Prevent time-skips; handle jail/hospital interactions; support illegal course flags; expose UI APIs for catalog/progress/history.

### For BalanceGPT
- Tunables: durations, costs, effect magnitudes, prerequisites, parallel slots, abort penalties, illegal heat risk. Ensure benefits are meaningful but not overpowering; keep illegal paths high risk/high reward.

### For QAGPT
- Test enroll/complete/pause/abort flows; prerequisite enforcement; timer persistence; effect application; illegal course flags; logging; interactions with jail/hospital; UI progress accuracy; anti-speedup checks.  
# SECTION 016 — UK REGIONS, REGIONAL ECONOMY, SAFETY

## 15.0 Overview
Travel moves players between boroughs and UK regions, enabling trade, hunting, missions, and supply runs. Hunting provides combat/loot loops in regional zones. System must enforce timers, risk, legality scans, weather/time effects, and Dark Luxury UI. Torn-like travel pacing with Trench City flavour; anti-teleport and anti-smuggling abuse.

## 15.1 Travel Model
- Origins: primary boroughs; Destinations: other UK regions/cities (Manchester, Birmingham, Bristol, Liverpool, Glasgow, Cardiff), plus local inter-borough moves.
- Transport modes: Train, Coach, Car/Van, Plane (regional), Special Fast Lanes (high-level/perk), Smuggling Routes (black market).
- Timers: duration based on distance, mode, weather, heat; fast lanes reduce; smuggling routes add risk; server authoritative.
- Costs: cash; fuel/maintenance for vehicles; tickets; smuggling fees.
- Status: Traveling status blocks many actions; profile shows route and ETA; logs travel start/arrival.

## 15.2 Checks & Risks
- Scans: border/rail/airport checks for illegal items; seizure/fines/jail; chance scales with heat/legality and mode; concealment reduces.
- Events: ambushes, delays (strikes, weather), bonus finds; blackouts can halt routes temporarily.
- Heat: high heat increases scan/ambush odds; may block smuggling routes; timers lengthen under alerts.
- Insurance: optional travel insurance reduces loss on delays/cancellations (costly).

## 15.3 Smuggling
- Special routes with higher risk/reward; requires black-market access and tools (false bottoms, forged papers).
- Cargo limits; failure → seizures/jail/heat; success → cash/rare items/black-market rep.
- Weather/time/location impact detection; night/fog favorable; police events increase risk.

## 15.4 Hunting
- Regional hunting zones unlocked by level and progression; consumes energy; yields loot (skins, meat, rare drops), XP, and occasional injuries.
- NPCs scale by region; weather/time influences spawn (night predators, rain reduces visibility).
- Risks: injury/hospitalization; gear damage; legal fines for protected animals if caught.
- Tools: hunting weapons, traps, bait; quality affects success; encumbrance affects travel timers if overpacked.
- Logs: hunts record region, weather, loot, injuries.

## 15.5 UI/UX
- Travel planner: list of destinations, modes, costs, duration, scan risk, smuggling indicator; warnings for illegal cargo; start button with confirmation.
- ETA/status chip on HUD; progress bar; arrival notifications.
- Hunting UI: region select, costs, expected loot, risk, weather; log of past hunts.
- Dark Luxury styling with route overlays; mobile-friendly condensed route cards.

## 15.6 Data & Logging
- Travel records: origin/destination, mode, start/end, costs, cargo legality, heat, weather/time, delays, scans/ambush outcomes.
- Hunting records: region, costs, loot, injuries, weather/time, tools used, XP.
- Anti-abuse logs: teleport attempts, repeated cancel/refund abuse, smuggling flags.

## 15.7 Anti-Abuse
- Teleport prevention: server timers; actions blocked until arrival; location authoritative.
- Cancel/refund abuse: partial refunds with cooldown; repeated cancels flagged.
- Smuggling abuse: escalating scans for repeated offenders; IP/device correlation; stash swap exploits detected; seizure logs immutable.
- Macro hunting: cooldowns, diminishing returns, captcha on suspicious farm loops.

## 15.8 Interactions
- Crimes: smuggling ties to black market (Section 148); travel status blocks most crimes; some intercept missions allowed.
- Factions: faction travel perks (reduced times), war logistics (moving between sectors), contracts to transport goods.
- Companies: transport/logistics companies gain bonuses on travel routes; can reduce member times.
- Properties: storage for cargo; proximity to stations reduces local travel times.
- Weather (Section 151): delays, scan odds changes; storms increase ambush risk; fog helps smuggling.

## 15.9 Example Flows
- Player travels Brixton → Manchester by train: pays fare; 25m timer; carrying illegal pistol triggers scan risk; arrives if clean; if caught, item seized + fine/jail.
- Smuggling run to Liverpool docks at night fog: uses van + false bottom; timer extended; success yields cash and rare item; failure seizes cargo and jails; heat spikes.
- Hunting in Scottish Highlands (high level): consumes energy; weather snow reduces visibility; player injures leg → hospital; gains rare pelt; log recorded.

### For Architect GPT
- Travel/hunting service enforces timers, scans, smuggling risk, weather effects, and status. Integrates with inventory (Sections 006/011), heat/crimes (Section 009), factions/companies (Section 012/014/045), properties (Section 017), weather/time (Section 151), and progression (Section 006).

### For CodeGPT
- Implement travel planner, start/cancel, timers, status enforcement, scans/seizures, ambush/delay events, smuggling logic, hunting actions, logging. Ensure server-authority, idempotent calls, anti-teleport checks. Provide HUD APIs for status/ETA.

### For BalanceGPT
- Tunables: travel times per mode/route, costs, scan odds, smuggling rewards/risks, hunting loot tables, energy costs, injury rates, delay chances, insurance pricing. Balance smuggling to be profitable but risky; prevent travel monopolies via perks.

### For QAGPT
- Test start/arrival timing, action blocking while traveling, scan/seizure logic, cancel/refund rules, smuggling outcomes, hunting loot/injury rates, logging accuracy, weather effects, ambush/delay events, anti-teleport enforcement. Validate UI warnings and HUD status.  
# SECTION 017 — UK LOCATION SYSTEM, UPGRADES, TENANTS

## 16.0 Overview
Properties provide housing, storage, happy regen, buffs, and prestige. They are location-dependent, upgradable, and can host tenants/staff. System must match Torn depth with UK flavour: council flats to penthouses and estates. Integrates with bars (happy), travel, companies, factions, and security. Dark Luxury UI, strict logging, anti-abuse.

## 16.1 Property Types & Tiers
- Types: Bedsit, Studio, Council Flat, Terrace, Semi-Detached, Penthouse, Luxury Estate, Safehouse, Underground Bunker (illegal), Event/Limited properties.
- Location: borough-specific; prestige/price vary; some types restricted to certain boroughs; view of skyline for luxury.
- Capacity: item storage, tenant slots, staff slots scale with tier; happy bonuses scale; utility slots for upgrades.

## 16.2 Acquisition & Ownership
- Purchase with cash/points; deeds tied to owner ID; taxes/upkeep optional; prestige properties gated by level/rank or prestige.
- Selling: market with fees; cooldown between sales; cannot sell while tenants/staff present; logs recorded.
- Transfers: gifted to spouse (Section 002) with cooldown; escrow for high-value trades; anti-laundering checks.

## 16.3 Upgrades & Utilities
- Upgrades: security systems, comfort packs, gyms, medical room, workshop, hidden stash, climate control, helipad (rare), pet housing.
- Effects: happy increase, regen boosts, stash capacity, scan risk reduction, repair bonuses, hunting prep buffs, travel time reduction (helipad).
- Installation: costs cash/items; time to install; quality tiers; some require education/contractor; illegal upgrades for black-market use.
- Utilities maintenance: upkeep; failure reduces bonuses; logs of install/repair.

## 16.4 Tenants & Staff
- Tenants: rent rooms; pay daily/weekly; affect upkeep; can boost happy if high satisfaction; default if unhappy; background checks possible.
- Staff: cleaners/chefs/security/medics/trainers; improve happy, regen, security, revives; effectiveness influenced by working stats.
- Permissions: who can enter/use stash; spouse access; faction safehouse access by role; logs for entries and stash access.

## 16.5 Security
- Systems: locks, CCTV, alarms, panic rooms, guard staff; reduces burglary risk; improves stash safety; impacts police scan success.
- Raids/burglaries: crimes can target properties; success affected by security and location heat; raid logs; insurance for losses (optional).
- Keys/access: digital keys with revocation; tenant/staff access tracked; alerts on unusual access times.

## 16.6 Happy & Bars
- Happy baseline: primary happy source; higher tiers grant more; upgrades add; events/parties temporarily boost happy; crashes possible after parties.
- Regen buffs: small energy/nerve regen from luxury utilities; med room improves life regen.
- Effects displayed on property UI; capped to prevent stacking with other sources excessively.

## 16.7 Storage & Stash
- Item storage capacity by tier; hidden stash reduces seizure risk; per-user permissions; logs for deposit/withdrawal; anti-dupe via server authority.
- Faction safehouses may add shared stash; permissions tied to roles; raid risk during wars.

## 16.8 UI/UX
- Property list: owned, for sale; filters by borough, tier, price; legality flags for bunkers.
- Property view: happy bonus, upgrades, staff/tenants, stash capacity, security rating, location/heat, weather overlay; logs; upgrade/install buttons.
- Tenant/staff management: hire/fire, wages/rent, satisfaction meter, background checks; payment schedules.
- Dark Luxury styling; skyline view in background; borough badge.

## 16.9 Data & Logging
- Tables: properties, ownership, upgrades, staff/tenants, payments, stash contents, access logs, raids, maintenance.
- Logs: purchase/sale, upgrade install/remove, access attempts, raids, stash moves, tenant rent payments, staff wages.
- Audit: immutable logs for disputes; insurance claims refer to logs.

## 16.10 Anti-Abuse
- Housing flips for laundering detected via price bounds and cooldowns; escrow for high-value trades; alt detection.
- Stash abuse: rapid in/out flagged; permissions enforced; location check; raid exploits blocked by cooldowns.
- Tenant fraud: unpaid rent triggers eviction; repeated evader flag across properties; background checks reduce risk.
- Illegal bunkers: increased scan risk; heat from raids; cannot hide during war timers.

## 16.11 Interactions
- Bars: happy and regen (Section 002); property parties consume/boost bars.
- Jobs/Companies: proximity perks; staff hiring uses working stats (Section 004/014); med rooms assist revives.
- Factions: safehouses; war-related raids; bonuses for members; stash for armory overflow.
- Travel: helipad/garage reduce travel times; storage for smuggling cargo; scan risk adjusted by security.
- Black market: hidden rooms reduce detection; some upgrades only via black market.

## 16.12 Example Flows
- Player buys Penthouse in Camden: gains high happy boost; installs security and gym; staff hired; stash expanded; logs created.
- Burglary attempt: attacker targets mid-tier property with weak security; fails due to alarm; police heat increases; raid log recorded.
- Tenant eviction: tenant misses rent; eviction after grace; satisfaction drops; property gains vacancy; log recorded; rent refunded pro-rata if configured.

### For Architect GPT
- Property system includes acquisition, upgrades, tenants/staff, security, stash, happy/regen effects. Integrates with bars (Section 002), items/inventory (Sections 006/011), jobs/companies (Section 014), factions (Section 012/045), travel (Section 016), black market (Section 148).

### For CodeGPT
- Implement property CRUD, purchase/sell with cooldown/escrow, upgrades install/maintenance, staff/tenant management, rent/wage payments, security checks, stash container with permissions, raid/scan logic, logging. Enforce location/heat effects; anti-abuse for flips and stash shuffling.

### For BalanceGPT
- Tunables: property prices, happy/regen bonuses, upgrade effects/costs, staff wages/effects, rent income, security strength, raid odds, insurance pricing, stash capacity. Ensure high tiers valuable but not game-breaking; illegal bunkers high risk/high reward.

### For QAGPT
- Test purchase/sell flows, upgrade installs, staff/tenant hire/fire, rent/wage payments, stash permissions, raid outcomes, security effects, logging completeness, anti-flip checks, heat/scans interaction, helipad/travel effects. Validate UI warnings and access controls.  
# SECTION 018 — CASINO, TOKENS, GAMBLING, ODDS MODELS, ADDICTION

## 17.0 Overview
The casino provides risk/reward loops: games with transparent odds, token economies, leaderboards, and anti-addiction safeguards. Must feel Torn-like but UK/Dark Luxury themed. Games include slots, blackjack, poker, roulette, sports bets, high-low, crash, loot boxes (regulated), and faction jackpots. Odds and RTP must be clear; anti-abuse and fairness are mandatory.

## 17.1 Currencies & Access
- Cash and Casino Tokens (non-withdrawable) used for certain games; tokens bought with cash/points; limits per day to curb abuse.
- VIP tables unlocked by level/rank/donator; high-stakes rooms; private faction tables.
- Entry checks: location (casino district), status (not jailed/hospital/travel), heat (extreme heat may block entry), age verification in lore (18+ implied).

## 17.2 Games
- Slots: themed reels; published RTP; volatility settings; jackpots (local/faction pooled); token and cash variants.
- Blackjack: standard rules; dealer stands on soft 17; multi-deck; insurance; splits; bet limits; anti-counting measures (shuffle frequency).
- Poker: Texas Hold’em/Sit-n-Go/cash tables; blinds scaled; rake capped; table timers; disconnection handling; bot detection.
- Roulette: European wheel; bet limits; table speed; max multipliers.
- High-Low/Crash: simple odds games; published house edge; cooldown to prevent rapid-fire abuse.
- Sports Bets: UK leagues/events; odds feeds simulated; settlement on match end; max exposure per player; no real-world betting integration (simulated).
- Loot Boxes/Crates: cosmetic/consumable rewards; published drop rates; pity timers optional; regulator-friendly disclosures.
- Faction Jackpots: faction-only pools funded by tokens; periodic draws; logs to faction.

## 17.3 Odds & Fairness
- RNG server-side; seeds logged; provable fairness where applicable; RTP displayed per game.
- House edge defined and fixed; volatility tuned for engagement without exploit loops.
- Anti-pattern detection: rapid max-bet cycles flagged; table-collusion detection in poker.

## 17.4 Limits & Safeguards
- Daily/weekly wager caps; loss limits; cooling-off periods; self-exclusion toggle; reminders after long sessions.
- Donator perks cannot bypass responsible gaming limits; VIP only affects stakes, not odds.
- Anti-laundering: token purchase limits; token-to-cash conversions restricted; transaction monitoring; suspicious wins flagged.

## 17.5 Rewards & Meta
- Achievements and titles for milestones (hands won, jackpots, flawless blackjack streaks).
- Leaderboards per game; seasons for competitive modes; rewards cosmetic/tokens (not pay-to-win).
- Events: boosted jackpots, themed tables; strictly time-boxed; odds disclosed; RTP not lowered during events.

## 17.6 UI/UX
- Game lobby with filters (stakes, game, tokens/cash); clear odds/house edge labels.
- Table/game UIs: Dark Luxury chrome, readable bets/payouts, timers, action confirmations; mobile layouts for portrait.
- Warnings: session time, loss limit approaching, house edge reminders; token balance and caps visible.
- Logs: bet history, wins/losses, RTP summary; export for player and mod review.

## 17.7 Data & Logging
- Bets table: player, game, stake, outcome, RNG seed ref, time, location, tokens/cash used.
- Pools: jackpots, faction pools; contributions and payouts logged.
- Limits: per-player caps stored; exclusion flags.
- Moderation: suspicious patterns flagged; audit trail; rollback procedures for outages.

## 17.8 Anti-Abuse
- Bot detection in poker; anti-collusion (shared IP/device alerts); rate limits for high-low/crash spam; token faucet abuse detection.
- Disconnect handling: poker folds on timer; refunds only on server fault; crash/high-low resolved server-side regardless of client.
- RNG tamper prevention: server-only; hashes for verification; no client seeds.

## 17.9 Interactions
- Economy: cash sink; token purchases; rewards feed back as consumables; achievements link to titles (Section 006).
- Factions: faction jackpots; casino events can be faction-sponsored; respect not directly affected to avoid war exploits.
- Properties: luxury properties may grant small token stipend or casino access perks; travel (Section 016) required to reach regional casinos.
- Bars: long sessions can reduce happy (fatigue) if safeguards ignored; refreshments items sold on-site affect bars.

## 17.10 Example Flows
- Player buys tokens within daily cap; plays blackjack; hits loss limit → cooldown message; logs recorded; responsible gaming notice shown.
- Poker collusion attempt: two accounts same IP; pattern detection flags; table kicked; moderators alerted; winnings frozen pending review.
- Faction jackpot: members buy tickets with tokens; draw occurs; log published; winner receives tokens; faction feed updated.

### For Architect GPT
- Casino service includes games, tokens, limits, jackpots, RNG, logs, and responsible gaming. Integrates with economy (Section 019), identity (Section 002), factions (Section 012/045), properties/travel (Sections 017/016), progression (Section 006 for achievements).

### For CodeGPT
- Implement lobby, games with server RNG, bet settlement, token purchase limits, jackpots, leaderboards, logs, anti-collusion/anti-bot, limits/exclusions, outage rollback. Provide APIs for history and moderation.

### For BalanceGPT
- Tunables: house edge per game, wager caps, token pricing, jackpot contributions, event modifiers, loss limits, cooldowns. Keep odds transparent; prevent farming/exploits; ensure casino remains sink not faucet.

### For QAGPT
- Test bet flows, RNG fairness, limit enforcement, exclusion toggles, jackpot accrual/payout, poker anti-collusion, crash/high-low rate limits, disconnect handling, log completeness, and mobile UI. Validate odds display and RTP consistency.  
# SECTION 019 — STOCK MARKET, POINTS BUILDING, BENEFITS, INVESTOR SYSTEM

## 18.0 Overview
The finance layer mirrors Torn’s markets and points economy while fitting Trench City’s UK theme and Dark Luxury UX. It includes a stock exchange, points as a soft currency, investor benefits, dividends, volatility, and anti-laundering safeguards. Markets must be transparent, logged, and tuned for long-term engagement without pay-to-win abuse.

## 18.1 Currencies & Instruments
- Cash (GBP): primary spendable currency.
- Points: soft currency purchasable with cash, event rewards, limited faucet; used for boosts, services, and stock perks.
- Stocks: fictional UK-flavoured tickers; each with price, volatility, volume, dividend profile, and benefit thresholds.
- Bonds/Notes (optional future): time-locked instruments; not required initially.

## 18.2 Stock Exchange Model
- Tick-based pricing: periodic updates (e.g., every minute) driven by simulated fundamentals/events and player order flow.
- Order types: market, limit; quantity caps per order; minimum tick size; trading hours configurable (could be 24/7 for simplicity).
- Fees: per-trade fee (cash); tax on quick flips to discourage micro-scaling; fee reductions via benefits/points.
- Volatility bands: per-ticker variance caps; circuit-breakers on extreme moves; news events shift bands temporarily.

## 18.3 Benefits & Thresholds
- Each stock grants benefits when holding minimum shares for a minimum duration:
  - Points stipends, regen boosts (small), travel discounts, job/company perks, crime bonuses, gym multipliers, market fee reductions, property upkeep discounts.
  - Benefits stack per ticker but capped globally to avoid runaway buffs.
- Vesting: benefits activate after hold period; deactivate on dropping below threshold; cooldown before reactivation to prevent cycling.
- Visibility: UI shows benefit thresholds, active status, and timers.

## 18.4 Points Economy
- Acquisition: purchase with cash (daily cap), mission/event rewards, faction war prizes, casino milestones, rare finds.
- Uses: bar refills (limited), cooldown skips (tight caps), name change, extra travel slots, gym passes, donator time, benefit purchases, market fee coupons.
- Anti-abuse: purchase caps, cooldowns on certain redemptions, no direct cash-out; transfer between players limited with tax; laundering detection on bulk transfers.

## 18.5 Dividends & Payouts
- Some stocks pay periodic dividends (cash or points) based on holdings at record time; minimum holding duration required.
- Payout logs visible; taxed modestly; bots detected if cycling around payout windows.
- Reinvest option converts dividends to auto-buy if enabled.

## 18.6 Events & News
- Simulated news affects sectors (Tech, Security, Transport, Media, Pharma); events shift volatility/price temporarily.
- Faction/company events can influence related tickers (e.g., city security alert boosts security stock); capped impact to avoid manipulation.
- Calendar shows scheduled events (earnings) and random events; logs recorded.

## 18.7 UI/UX
- Exchange dashboard: tickers with price, change, volume, volatility, benefits, news. Filters by sector/benefit.
- Order ticket: buy/sell with live fee estimate; warning for benefit loss; tax notice for short holds.
- Portfolio: holdings, cost basis, P/L, active benefits, dividend schedule, tax timers; Dark Luxury charts.
- Points shop: items/services with caps; clear cooldowns; responsible-use notices for refill items.

## 18.8 Data & Logging
- Tables: tickers, prices, volatility params, news/events; orders, trades, holdings, benefits status, dividends, points transactions.
- Logs: every order/trade/dividend/benefit activation/points spend/transfer; anti-abuse flags; audit trails for moderator review.
- Snapshots: periodic price/volume snapshots for analytics; circuit-breaker triggers logged.

## 18.9 Anti-Abuse & Fairness
- Laundering: monitor points transfers, quick-flip loops, wash trading between linked accounts/IPs; apply taxes/locks.
- Exploit prevention: circuit-breakers, order throttles, minimum hold for benefits, anti-sniping on dividends, cap on stacked benefits.
- Market integrity: server authoritative pricing; no client-driven ticks; news generation logged.

## 18.10 Interactions
- Economy: points tie into boosts; stocks provide buffs affecting bars/gym/crimes/travel; companies/factions can hold stocks (optional future, gated).
- Crimes: white-collar crime missions could temporarily affect financial heat; not required at launch.
- Factions: respect rewards may include points; faction events shouldn’t directly move market beyond small flavour events.
- Properties: upkeep discounts from certain benefits; travel discounts for fast lanes.
- Casino: token purchases not convertible to cash; avoid indirect laundering via markets.

## 18.11 Example Flows
- Player buys 1,000 shares of “BlocRail” (transport): holds 24h; benefit activates → small travel time reduction + fee discount; sells half → benefit pauses until threshold regained.
- Points spend: buys name change and small energy pack; hits daily cap → further refills locked; logs recorded.
- News event: “Security alert” boosts security stock volatility; price spike capped; circuit-breaker halts excessive moves; logs show trigger.

### For Architect GPT
- Finance service includes exchange pricing, orders, benefits, points economy, dividends, news/events, and anti-laundering. Integrates with bars (Section 002), progression (Section 006), gym (Section 008), travel (Section 016), properties (Section 017), and economy modules (Section 014/019 market). Requires benefit manager and pricing engine.

### For CodeGPT
- Implement tick engine, order book (market/limit), fees, taxes, holdings, benefit activation with hold timers, dividends, points shop with caps, transfers with tax, news injection, circuit-breakers, and comprehensive logging. Enforce purchase/transfer caps and anti-wash rules; server authoritative prices.

### For BalanceGPT
- Tunables: volatility bands, fee/tax rates, benefit thresholds/effects, dividend yields, points pricing/caps, transfer taxes, circuit-breaker limits. Ensure benefits useful but not overpowering; points refills capped to avoid breaking bars.

### For QAGPT
- Test order placement/cancel/fill, benefit activation/deactivation, dividend payouts, points purchases/transfers with caps/taxes, news impact within bounds, circuit-breakers, anti-wash triggers, logging completeness, UI warnings for benefit loss and short-hold taxes.  
# SECTION 020 — MISSIONS, EVENTS, NPCS, NARRATIVE ENGINE

## 19.0 Overview
Missions and events deliver structured content, guided progression, and narrative. NPCs populate the world, drive quests, and appear in crimes/combat. The system must be modular, repeatable, and Torn-parity in depth: multi-stage missions, branching, timers, loot, difficulty scaling, and event frameworks. Dark Luxury UI and UK crime drama tone are mandatory.

## 19.1 Mission Types
- Story Arcs: multi-chapter narratives; linear or branching; unlock systems; gated by level/rank/education.
- Side Missions: repeatable tasks with cooldowns; tied to boroughs/NPCs; scale with player level band.
- Contracts: player-created or system-provided objectives (deliveries, hits, smuggling); time-boxed; escrow for rewards.
- Faction Ops: faction-only missions (intel theft, sabotage, escort); reward respect/intel; tied to wars.
- Tutorial/Onboarding: guided steps for new players; unskippable critical flows; rewards starter gear/XP.

## 19.2 Structure & Flow
- Stages: dialogue/setup → objective → resolution; each stage has requirements (location, bars, items, stats), timers, and outcomes.
- Fail states: time expiry, death/hospital, jail, detected during stealth; failures logged; partial rewards or penalties.
- Cooldowns: per mission or pool; prevent spam; scaling cooldown for failures on high-value contracts.
- Checkpoints: long arcs save progress; deaths may roll back a stage.

## 19.3 NPC System
- NPC types: quest-givers, vendors, rivals, bosses, faction leaders, civilians, informants, police. Each with borough/district home, schedule, and hostility level.
- Stats: scaled by player band; gear and AI profile; legality flags; drop tables; dialogue set.
- Reputation: per NPC or faction; actions can improve/harm; unlocks missions or prices.
- Spawn: tied to events, times, weather, or mission stages; some ambient on city map.

## 19.4 Events Framework
- Scheduled Events: holidays (Halloween fog, Xmas snow), city events (strikes, blackouts), casino nights, crime waves; announced in calendar.
- Dynamic Events: random crises (fires, protests, police raids), weather extremes; trigger mission hooks and modifiers.
- Rewards: cosmetics, consumables, rare items, points; event currencies (time-limited); leaderboards where appropriate with anti-cheat.
- Rules: published start/end; modifiers to crimes/combat/economy; no hidden nerfs; logs for transparency.

## 19.5 Objectives & Variations
- Objective types: kill/defeat, steal, deliver, escort, defend, hack, plant device, scout, photograph, negotiate, survive timer.
- Variations: stealth vs loud routes; optional objectives for bonus; branching dialogue affecting rewards.
- Constraints: no hospital/jail; consumable restrictions; location/time/weather requirements; gear restrictions for stealth.

## 19.6 Rewards & Scaling
- Rewards: XP, cash, items, points, unique cosmetics, titles, faction respect, intel. Loot tables by difficulty and branch.
- Scaling: player level/rank band adjusts enemy stats and loot quantity; minimum guaranteed reward to avoid dry runs; diminishing returns on rapid repeats.
- Daily/Weekly caps on certain high-value contracts; event missions bypass caps during window.

## 19.7 UI/UX
- Mission journal: active/completed, objectives, timers, locations, required items, recommended stats, rewards preview.
- Map integration: highlights mission locations; breadcrumbs; travel buttons; weather/time noted.
- Dialogue: concise UK noir tone; skip/replay options; choices logged.
- Notifications: stage updates, timer warnings, failure reasons; Dark Luxury overlays.

## 19.8 Data & Logging
- Tables: missions, stages, requirements, rewards, cooldowns, NPCs, events schedule, contracts.
- Logs: mission start/complete/fail, choices, rewards, timers, NPC interactions, contract escrow.
- Analytics: completion rates, fail reasons, average time; used for tuning.

## 19.9 Anti-Abuse
- Cooldowns on repeats; diminishing rewards for spam; prevent multi-account boosting (IP/device correlation) on contracts; escrow to prevent scams.
- Event leaderboard anti-cheat: detect scripted runs; validate server-side completion; disqualify suspicious scores.
- Timer exploits blocked; offline progress not advanced; death/jail interrupts appropriately.

## 19.10 Interactions
- Crimes: missions may require crimes with modifiers; crime success improved/penalized per mission design.
- Combat: NPC fights use combat engine; gear drops; hospital/jail outcomes enforced.
- Factions: faction ops consume respect/nerve; war state can modify available ops; rewards include intel.
- Travel/Weather: missions with time/weather requirements; travel timers enforced; delays can fail time-sensitive tasks.
- Properties: stash/delivery points; mission-specific hiding spots; safehouse bonuses for stealth.

## 19.11 Example Flows
- Story arc: “Fog over Camden” — multi-stage stealth/hack/heist; fog required; failure sends to jail; rewards cosmetic title + rare item.
- Contract: delivery with timer; travel required; player intercepted by random event; succeeds and receives escrow payout; failure forfeits escrow.
- Faction op: sabotage enemy sector power; requires tools, nerve/energy; success reduces enemy buffs; failure triggers alert and respect loss.

### For Architect GPT
- Mission/event/contract engine must be modular with stages, requirements, timers, rewards, scaling, and logging. NPC system integrated with combat and world. Depends on travel/location (Sections 001/016), crimes (Section 009), combat (Sections 003/010), factions (Section 012/045), and progression (Section 006).

### For CodeGPT
- Implement mission definitions, stage state machine, timers, requirements validation, reward distribution, cooldowns, contract escrow, NPC templates, event scheduler, logging, and anti-abuse checks. Provide journal APIs and map markers; support branching choices; ensure server authority.

### For BalanceGPT
- Tunables: mission rewards, cooldowns, scaling curves, contract payouts, event modifiers, leaderboard scoring, NPC stats per band, timer lengths. Ensure rewards meaningful but not farmable; events exciting but fair; contracts profitable with risk.

### For QAGPT
- Test mission start/advance/complete/fail flows, timers, choice logging, reward scaling, cooldown enforcement, contract escrow payouts/refunds, NPC combat balance, event scheduling, anti-cheat on leaderboards, map markers, and travel/weather gating.  
# SECTION 021 — FORUMS, MAIL, CHAT, NEWSPAPER, CONTRACTS

## 20.0 Overview
Social systems enable communication, trading, recruitment, and roleplay. They must be dense and moderated: forums, mail/DMs, live chat, newspapers/feeds, and contracts. Tone is UK street/noir with Dark Luxury UI. Anti-abuse (spam, scams, harassment) is critical; logs are comprehensive.

## 20.1 Forums
- Boards: News/Announcements, General, Faction Recruitment, Company Recruitment, Market/Trades, Crimes/Tips, Bug Reports, Events, Off-topic (lightly moderated).
- Threads: pagination, sticky/pin, lock, delete (mods), edits with history; voting optional; report system.
- Permissions: posting gated by level/age to prevent spam; new accounts cooldown; bans/mutes per board.
- BBCode/Markdown subset; image limits; no external links to malicious sites; profanity filters with UK slang awareness.
- Logs: posts/edits/deletes, reports, mod actions; IP/device (hashed) for abuse detection.

## 20.2 Mail/DMs
- Person-to-person messaging; attachments (cash/items/contracts) via secure trade flow, not raw mail; templated warnings for scams.
- Rate limits; spam filters; block list; report button; optional encrypted flavour.
- Cooldowns for new accounts; bulk messaging caps; no HTML; profanity filter.

## 20.3 Live Chat
- Channels: Global, Borough, Faction, Company, Help, Events, Trade; optional private channels.
- Moderation: mutes, slow mode, channel-specific caps; automated spam detection; link filters.
- Features: mentions, reply, emoji (safe set), /commands for info (time, stats, heat) carefully limited.
- Persistence: short history (e.g., last few hundred messages); logs for mods longer-term.

## 20.4 Newspaper & Feeds
- City Newspaper: curated stories from wars, events, top crimes, leaderboards, market movers; noir UK tabloid tone.
- Feeds: personal activity, faction feed, city feed; filters; severity colour-coding; timestamps 24h.
- Ads: in-game ads for factions/companies; moderated; paid via points/cash; impression caps; no external IRL ads.

## 20.5 Contracts & Player Services
- Contract board: offers for deliveries, hits, crafting, escorts, intel; escrow-backed; reputation scored on completion/failure.
- Terms: reward, deadline, required items/stats, penalties for failure; faction-only and public options.
- Anti-scam: escrow mandatory; dispute resolution; reputation hits for defaults; cooldown for repeated failures.

## 20.6 Identity & Safety
- Identity hooks: verified seller/trader badges (Section 002), trust scores; anonymity options for certain contracts (with higher fees).
- Safety: block/mute, report flows, harassment escalation; auto-hide repeated offenders; IP/device correlation for sockpuppets; cooldowns for new accounts posting in high-visibility boards.

## 20.7 UI/UX
- Dark Luxury forums with dense lists, tags (War, Trade, Help), and filters; quick-reply with preview.
- Mail: conversation view; unread counts; attachment summaries; warnings on risky attachments.
- Chat: compact messages with status chips (hospital/jail/travel icons), borough badges; slow-mode indicator.
- Newspaper: cards with images/icons; per-story tags; archive search.
- Contracts: clear terms, escrow amount, reputation, deadline timers; accept/abort buttons; logs visible.

## 20.8 Data & Logging
- Tables: posts, threads, reports, messages, chat messages, feeds, contracts, ads, moderation actions.
- Logs: content hashes, timestamps, user IDs, IP/device (hashed), attachments, contract state changes, payments, disputes.
- Retention: configurable; PII minimized; GDPR-aware exports/deletes.

## 20.9 Anti-Abuse
- Spam detection: rate limits, content scoring, captcha on flagged behaviour; link filters; profanity checks.
- Scam prevention: escrow-only trades; warning banners; new-account restrictions; reputation decay for scammers.
- Harassment: mute/ban escalation; block lists enforced across chat/mail/forums; report SLAs; auto-squelch on repeated reports.
- Botting: activity heuristics; slow mode enforcement; channel join caps; /command abuse monitored.

## 20.10 Interactions
- Factions/Companies: recruitment boards; private channels; faction news surfaced to newspaper; contracts targeted by orgs.
- Market/Trades: contract board complements market; verified traders pay lower escrow fees.
- Events: event channels; newspaper event specials; forum badges for participation.
- Progression: posting requirements by level/age; achievements for clean participation; titles for community contributions.

## 20.11 Example Flows
- Player posts faction recruitment thread; hits cooldown; gets replies; mod pins for quality; logs track edits.
- Contract for delivery: poster funds escrow; runner accepts; completes within timer; escrow releases; reputation adjusted.
- Chat spam attempt: user hits rate limit; slow mode applies; repeated offence triggers captcha/mute; logs to mods.

### For Architect GPT
- Social stack includes forums, mail, chat, feeds, newspaper, contracts. Needs moderation, escrow, reputation, and identity hooks. Integrates with identity (Section 002), contracts/missions (Section 019), factions/companies (Sections 012/014), market/economy (Section 019), and feeds (Section 013 world layer).

### For CodeGPT
- Build forum/thread/post services with reports/mod actions; mail with attachments via secure trades; chat with channels, slow mode, and moderation; newspaper/feed aggregation; contract board with escrow and reputation. Implement rate limits, filters, block lists, logging, and GDPR data handling.

### For BalanceGPT
- Tunables: rate limits, posting requirements, escrow fees, contract penalties, ad pricing, reputation weights, slow mode durations. Balance openness with spam control; keep escrow fees enough to deter scams without killing use.

### For QAGPT
- Test posting/editing/reporting, mail send/receive with attachment restrictions, chat rate limits/slow mode/mutes, contract create/accept/complete/fail with escrow and reputation, newspaper/feed accuracy, logging completeness, and block/report flows. Validate anti-spam triggers and GDPR export/delete.  
# SECTION 022 — JOBS, COMPANIES, WORKING STATS, ECONOMY, INDUSTRY & TRADE

## 21.0 Overview
This section merges working stats, jobs, companies, industry, and trade into a unified economy loop. It extends Sections 004/014 with supply chains, wholesale/retail flows, regional variation, and integration with market and factions. The goal: Torn-depth economy with UK flavour, Dark Luxury UI, anti-abuse safeguards, and meaningful interplay between production, services, and trade.

## 21.1 Working Stats & Economy Hooks
- MAN/INT/END affect: job eligibility, company performance, crafting/production quality, supply efficiency, logistical risk, repair success, and OCs roles.
- Stat DR: daily soft caps; training via shifts; achievements for diverse roles; stats influence wages and contract payouts.
- Economy leverage: high working stats enable premium services (medical revives, tech repairs, security escorts).

## 21.2 Industry & Supply Chains
- Company categories: Manufacturing (weapons/armor/consumables), Medical, Transport/Logistics, Security, Tech/Cyber, Media, Hospitality/Retail, Underground support.
- Supply chain: raw materials → components → finished goods → retail/market. Transport times and risks (heat/weather) affect delivery.
- Wholesale vs retail: companies can bulk-sell to other companies/factions at wholesale; retail to players; price bands enforced to curb laundering.
- Inventory: company stock tracked separately; spoilage/expiry for certain goods; supply orders logged.

## 21.3 Trade & Market Integration
- Market listings (Section 019) consume stock; escrow optional for high-value; trust scores adjust fees.
- Contracts: B2B supply contracts with SLAs, penalties, and escrow; recurring deliveries possible.
- Regional pricing: borough/regional demand affects prices; events can spike demand (e.g., medical supplies during outbreaks).

## 21.4 Jobs (Extended)
- Additional roles: R&D (improves quality), Procurement (reduces costs), QA (reduces defect rate), Sales (raises revenue), Compliance (reduces seizure/fines).
- Shift variants: production, delivery, customer service, security detail; each has risk/reward and stat gains.
- Compliance checks: crime history may block compliance roles; underground companies invert this (prefer “dirty” resumes).

## 21.5 Companies (Extended)
- Facilities: production lines, labs, warehouses, storefronts; upgrades impact capacity/quality/risk.
- Quality system: output quality affects price and customer satisfaction; defects lower reputation; recalls possible with cost and log.
- Reputation: per-company rating; impacts contracts and pricing; hit by defects, delays, scams; boosted by on-time deliveries and quality.
- Services: revives, repairs, fast travel, intel reports, escorts; priced dynamically; require staff with stats/education.

## 21.6 Morale, Safety, and Compliance
- Safety incidents: accidents during production/delivery; reduce morale; may cause hospital visits; logged.
- Compliance: adherence to legality; illegal production raises heat and seizure risk; fines/jail for owners if raided.
- Morale: wages, leadership activity, success rates, safety, upgrades (break rooms), events; affects performance and defect rates.

## 21.7 Anti-Fraud & Auditing
- Wage laundering detection; price bounds; IP/device correlation; repeated hire/fire loops flagged.
- Inventory tamper detection; supply duplication prevention; contract scam detection; escrow mandatory for risky goods.
- Audit logs: immutable records for hires, fires, wages, stock changes, contracts, deliveries, incidents; moderator tools.

## 21.8 UI/UX
- Economy dashboard: production queues, stock, orders, contracts, finances, morale, safety, reputation.
- Trade console: wholesale offers, retail listings, contract creation, SLA trackers, route risks (weather/heat), compliance flags.
- Staff panel: roles, stats, performance, wages, training suggestions; auto-assign tools.
- Dark Luxury styling; dense tables; warnings for risk/compliance.

## 21.9 Data & Logging
- Tables: companies, facilities, stock, materials, orders, contracts, incidents, morale, reputation, audits.
- Logs: production start/finish, defects, deliveries, SLA results, fines/raids, wage changes, morale changes, accidents.
- Analytics: margin tracking, defect rates, on-time percentages, fraud flags.

## 21.10 Anti-Abuse
- Anti-laundering on contracts and wages; price caps/floors; cooldown on leadership wage hikes.
- Delivery manipulation detection (cancel/reorder loops); repeat defect exploitation flagged; alt collusion detection on contracts.
- Raids for illegal production with escalating risk; seizures logged; owner penalties.

## 21.11 Interactions
- Factions: contracts to supply war gear; respect bonuses for reliable suppliers; faction-owned companies possible with governance.
- Properties: workshops/warehouses as upgrades; improve capacity and reduce delivery time.
- Travel/Weather: impacts delivery SLAs; strikes/blackouts disrupt; insurance options for delays.
- Market: stock feeds into player market; benefits from Section 019 may reduce fees.

## 21.12 Example Flows
- Manufacturing company runs production: procures materials; production queue started; quality influenced by staff stats; outputs logged; sells wholesale to faction with SLA; on-time delivery boosts reputation.
- Compliance failure: underground lab produces illegal stims; raid triggered; stock seized; owner fined/jail; reputation hit; log recorded.
- Contract scam attempt: alt company posts overpriced contract; price bounds and escrow prevent execution; account flagged.

### For Architect GPT
- Economy backbone spanning working stats, jobs, companies, production, contracts, and trade. Needs services for production, stock, contracts/escrow, compliance/legality, morale, reputation, and audit. Integrates with market (Section 019), factions (Section 012/045), properties (Section 017), travel/weather (Section 016/151), and items (Section 006/011).

### For CodeGPT
- Implement production queues, stock/inventory for companies, quality/defect calc, contracts with SLA/escrow, wholesale/retail pricing with bounds, reputation/morale/safety systems, compliance checks, raid/seizure logic, audit logging, fraud detectors. Provide dashboards and APIs for orders, deliveries, and staff management.

### For BalanceGPT
- Tunables: production times, material costs, quality/defect rates, wage ranges, morale effects, reputation weights, contract penalties/bonuses, price bounds, compliance fines, raid odds. Balance profitability so crimes/factions remain competitive; illegal ops higher risk/higher reward.

### For QAGPT
- Test production start/finish, stock accounting, quality/defect outcomes, contract SLA success/failure, escrow payouts, price bounds, wage changes, morale/reputation changes, raid/seizure triggers, anti-laundering flags, logging completeness, UI warnings. Validate travel/weather impacts on deliveries.  
# SECTION 023 — PROPERTIES, HOUSING, REAL ESTATE, HAPPY CAP, SECURITY (EXPANDED)

## 22.0 Overview
Expanded property system detailing acquisition, upgrades, happy caps, security, tenants, staff, and raids. Builds on Section 017 with more economic hooks, risk, and UK flavour. Properties anchor happy/regen, storage, prestige, and safety; they also tie into crimes (burglary), factions (safehouses), and black market.

## 22.1 Property Portfolio & Prestige
- Tiers: Bedsit → Studio → Council Flat → Terrace → Semi-Detached → Penthouse → Luxury Estate → Safehouse → Bunker (illegal) → Event estates.
- Prestige: higher tiers unlock titles/frames; happy caps scale; property score contributes to profile prestige; borough prestige affects value.
- Multiple ownership: limited slots; diminishing happy if hoarding without upgrades; anti-hoard tax optional.

## 22.2 Acquisition, Sale, and Tax
- Purchase via market with fees; escrow for high-value; cooldown between purchases; taxes/upkeep for luxury tiers; arrears reduce bonuses.
- Sale requires emptying stash/tenants/staff; cooldown to prevent flip abuse; price bounds to stop laundering; capital gains tax optional.

## 22.3 Upgrades & Utilities
- Security: locks, CCTV, alarms, reinforced doors, panic room; increases burglary resistance, reduces stash seizure; logs access attempts.
- Comfort: furniture packs, entertainment, climate control; boosts happy and reduces crash duration.
- Functional: gym, med bay, workshop, hidden stash, helipad/garage, pet facilities; boosts bars/regen, repair quality, stash capacity.
- Maintenance: degradation over time; upkeep cost; failure lowers bonuses until repaired; logs install/maintenance with timestamps.

## 22.4 Happy Cap & Regen
- Happy baseline by tier; upgrades/staff boost; caps to prevent stacking beyond design; displayed clearly.
- Regen: small energy/nerve boosts for luxury; med bay boosts life regen; crash states reduce benefits temporarily.
- Parties: temporary happy boosts; cost cash/items; crash afterwards; logs; cooldown.

## 22.5 Tenants, Staff, and Permissions
- Tenants: pay rent; satisfaction affects retention; eviction rules; background checks; tenant defaults reduce reputation.
- Staff: cleaners, chefs, security, medics, trainers; wages; stats influence effectiveness; morale from pay/treatment; logs for shifts.
- Permissions: spouse access, faction safehouse access, tenant/staff access scopes; stash access logging; keys revocable.

## 22.6 Security & Raids
- Burglary crimes target properties; success based on security level, location heat, player heat, time/weather; loot from stash if access.
- Raids: police raids for illegal upgrades/items; seizure and fines; higher risk for bunkers/black market storage.
- Insurance: optional; covers partial loss; premiums scale with risk and claims history; fraud detection.
- Alerts: notifications on attempted access/raid; logs with time/location; cooldown to prevent spam raids.

## 22.7 Storage & Stash
- Capacity scales with tier/upgrades; hidden stash reduces detection; categories (legal/illegal); permissions per user; stash in safehouses separate from armory.
- Anti-dupe: server authoritative; immutable logs for deposits/withdrawals; rate limits on rapid moves.

## 22.8 UI/UX
- Property portfolio view: tiers, bonuses, upkeep, location/heat, weather overlay, security rating.
- Detail view: upgrades, staff/tenants, stash, logs, access controls, maintenance status, party controls.
- Dark Luxury styling; borough badge; skyline background; warnings for arrears/heat/raids.

## 22.9 Data & Logging
- Tables: properties, upgrades, staff/tenants, payments, stash, access logs, raids, maintenance, parties.
- Logs: purchase/sale, upgrade install/maint, stash moves, access attempts, raids, parties, tenant rent, staff wages, insurance claims.
- Audits: used for disputes and insurance; immutable; accessible to mods; player-visible filtered logs.

## 22.10 Anti-Abuse
- Flip/laundering detection via price bounds, cooldowns, escrow; alt detection on transfers; taxes for rapid flips.
- Stash abuse: rate limits; location checks; duplicate detection; stash cannot exceed capacity.
- Insurance fraud: claim limits; investigation flags for frequent claims; hidden stash not insured.
- Tenant scams: background checks; eviction; reputation hits shared; repeated defaults flagged across accounts.

## 22.11 Interactions
- Bars: happy/regen (Section 002); parties affect bars; crashes impact regen.
- Crimes: burglary targets properties; heat impacts raid risk; illegal stash influences detection (Section 009/148).
- Factions: safehouses; war-time raid risk; stash for overflow; security upgrades tied to faction perks.
- Travel: helipad/garage reduces travel time; storage for smuggling; scans adjusted by security.
- Economy: property value tied to borough events; upkeep sinks cash; staff wages tie into jobs/working stats.

## 22.12 Example Flows
- Luxury Estate setup: owner buys, installs security and med bay, hires staff; happy cap high; stash expanded; upkeep paid weekly; logs updated.
- Raid: illegal bunker flagged; raid seizes illegal items; fine + heat; insurance denies; logs show seizure; reputation hit.
- Party: owner hosts party; happy spikes for occupants; crash after duration; cooldown; logs; bar effects applied.

### For Architect GPT
- Property layer includes acquisition, upgrades, happy/regen, stash, security, tenants/staff, raids, insurance. Integrates with bars (Section 002), items (Sections 006/011), economy (Section 022), crimes/raids (Section 009/148), factions (Sections 012/045), travel (Section 016), and progression (Section 006 for prestige gates).

### For CodeGPT
- Implement property buy/sell with escrow/cooldowns, upgrades/maintenance, staff/tenant management, payments, stash container with permissions, security/raid checks, insurance, parties, logging. Enforce capacity, price bounds, and anti-abuse. Provide UI APIs with heat/weather overlays and warnings.

### For BalanceGPT
- Tunables: property prices/upkeep, happy/regen caps, upgrade effects/costs, staff wages/effects, rent income, raid odds, insurance premiums/payout caps, flip taxes. Balance risk/reward for illegal bunkers; keep happy as primary property value without breaking bar economy.

### For QAGPT
- Test property CRUD, upgrade installs/maintenance, staff/tenant flows, rent/wage payments, stash permissions/capacity, raids/seizures, insurance claims, parties/crashes, logging, anti-flip checks, heat/weather overlays, and UI warnings. Validate stash anti-dupe and access logs.  
# SECTION 024 — UK STREET CATEGORIES, ADDICTION, TOLERANCE, CRASH

## 23.0 Overview
Drugs provide powerful buffs with crashes, tolerance, and addiction risk. The system mirrors Torn depth with UK street flavour and Dark Luxury UX. It integrates with bars, combat, crimes, black market, and medical systems. All effects are server-side, logged, and balanced to avoid permanent metas.

## 23.1 Drug Categories
- Stimulants: speed/accuracy/initiative boosts (e.g., “Camden Line”, “BlocRush”).
- Painkillers/Downers: mitigation/recoil control; lower perception; can reduce crit received.
- Hallucinogens: high-risk/high-reward stat swings; vision effects (UI flavour), elevated crit but accuracy penalty.
- Performance Blends: mixed boosts to stats/bars; small regen; often designer/illegal.
- Medical: legitimate meds (hospital use) with minimal crash; require prescriptions or medical roles.
- Black-Market Specials: strong boosts; high crash/addiction; illegal; may trigger legal heat if caught.

## 23.2 Effects & Crashes
- Effects: buffs to battle stats, bars (energy/nerve/happy), status resist, accuracy/crit, initiative. Duration fixed per drug; stacking rules; caps to prevent multi-drug invulnerability.
- Crashes: inverse effects after duration; bar suppression, stat penalties; duration scales with tolerance/addiction.
- Tolerance: repeated use reduces effect, increases crash severity; decays over time; tracked per category.
- Addiction: threshold from repeated use; triggers ongoing debuffs (regen reduction, stat penalties); requires detox/medical treatment; visible status.

## 23.3 Usage Rules
- Consumption costs: some require energy/nerve to ingest (time/effort); some usable in combat (Section 010) with cooldown.
- Limits: category stacking limits; hard cap on simultaneous drug effects; warnings on overdose risk.
- Legality: many illegal; carrying/using in public can raise heat; seizures in scans (Section 016); fines/jail if caught.
- Quality: quality tiers influence potency, duration, crash severity, addiction chance; black-market quality variance higher.

## 23.4 Acquisition & Risk
- Sources: black market (Section 148), factions, loot, crafting/chemistry (future), events. Pharmacies for legal meds (limited).
- Risk: illegal possession increases detection; crafting labs can be raided; counterfeit drugs with reduced effects or heightened crash.
- Price: tied to region/heat; events/weather can spike demand (heatwave → stim demand).

## 23.5 Medical & Detox
- Detox programs: reduce addiction/tolerance over time; cost cash/points; downtime; bar penalties during detox.
- Medical treatment: reduces crash duration; medics (Section 014) improve outcomes; hospital services available.
- Rehab items: limited-use; partially clear tolerance/addiction; cooldowns to prevent spam.

## 23.6 UI/UX
- Drug panel: shows effects, duration, crash, tolerance/addiction meters, legality, quality, timers, warnings; tooltip on interactions (combat, crimes, bars).
- Use flow: confirmation with warning; displays current active drugs and stacking rules; crash preview.
- Status display: active effects and crashes in HUD; timers; colour-coded; reduced-motion respects for hallucinogen effects.

## 23.7 Data & Logging
- Tables: drug definitions (effects, duration, crash, legality, quality ranges, category limits), tolerance/addiction per player per category.
- Logs: consumption, source, quality, effects applied, crashes, addiction/tolerance changes, seizures, overdoses; detox sessions.
- Analytics: usage frequency, addiction rates, overdose incidents for tuning.

## 23.8 Anti-Abuse
- Overdose prevention: block consumption when risk too high; diminish effects when stacking; enforce server-side.
- Farming: cooldowns on crafting (when added); drop rates balanced; illegal seizures prevent stockpiling; IP/device checks on bulk trades.
- Macro use: rate limits; captchas if suspicious rapid use; server tracks nonces for use requests.

## 23.9 Interactions
- Combat: boosts and crashes alter stats and bars; tolerance influences effectiveness; detox influences hospital times.
- Crimes: nerve boosts help; crashes hurt; illegal possession increases heat and jail odds; drug crimes tie into black market.
- Bars: immediate boosts; crashes reduce regen; happy swings tied to some drugs.
- Properties: luxury properties reduce crash severity; med rooms aid detox.
- Factions: supply buffs; chain pushes may allow controlled use; war rules may restrict heavy drugs for fairness.

## 23.10 Example Flows
- Player uses “BlocRush” stim: +Speed/+Dex/+energy boost for X minutes; crash reduces happy/energy regen; tolerance up; log recorded.
- Addiction: repeated stims push addiction threshold; player suffers regen penalty until detox; HUD shows addicted state; detox program initiated.
- Seizure: caught at airport with illegal chems; items seized; fine/jail; heat increased; log and trust hit.

### For Architect GPT
- Drug system needs definitions, effects, crashes, tolerance/addiction, legality, and logging. Integrates with bars (Section 002), combat (Sections 003/010), crimes/black market (Sections 009/148), properties (Section 017/022), factions (Section 012/045), and medical/jobs (Section 014/015). Requires timers, stacking rules, and anti-abuse.

### For CodeGPT
- Implement drug use endpoint with validation, effect/crash application, timers, tolerance/addiction tracking, legality checks, seizure handling, detox flows, logging. Enforce stacking limits and overdose prevention. Provide UI data for active effects and warnings.

### For BalanceGPT
- Tunables: effect magnitudes/durations, crash severity, tolerance growth/decay, addiction thresholds, detox efficacy/cost, seizure odds, quality variance, stacking limits. Balance so drugs are strong but risky; prevent permanent stim metas.

### For QAGPT
- Test use flows, stacking enforcement, effect/crash timing, tolerance/addiction changes, detox, seizure handling, logging, UI warnings, reduced-motion settings for visuals. Validate interactions with combat/crimes/heat and bar impacts.  
# SECTION 025 — TRAINING, STAT CURVES, ENHANCERS (EXPANDED)

## 24.0 Overview
Deeper gym specification extending Section 008: stat curves, enhancers, DR tuning, special trainings, and anti-botting. Mirrors Torn math with Trench City flavour, borough gyms, weather/time modifiers, and Dark Luxury UX.

## 24.1 Stat Curves & DR
- Base gain formula scales with gym tier and happy multiplier; exponential DR by stat value to slow high-end.
- Daily soft DR on repetitive sets; resets gradually; event overrides allowed.
- Gym multipliers per tier; publish ranges to allow planning; caps to avoid infinite ROI.

## 24.2 Gym Network
- Gyms per borough with themes; unlocks by stats/level; membership fees; faction-owned gyms possible.
- Special gyms: stealth gym (focus on Speed/Dex with stealth bonuses), strength gyms, endurance boxes. Minor flavour differences only.
- Traveling gyms (Section 016) in regions; temporary passes; unique cosmetics, not overpowering.

## 24.3 Enhancers & Consumables
- Pre-workout stims, protein stacks, focus pills; boost gains modestly; crashes apply; stacking limits; tolerance.
- Happy items: snacks, parties; crash afterwards; property comfort mitigates crash.
- Equipment rentals: temporary gym-specific buff; limited stock; cooldowns.

## 24.4 Training Modes
- Standard sets: cost energy; gain all stats with weights; selectable focus (e.g., Strength focus) that biases gains but still DR-limited.
- Sparring: lower gains, yields combat logs and small XP; uses energy; optional for practice.
- Precision drills: Dex/Speed emphasis; higher cost; diminishing returns; requires focus items.
- Endurance circuits: Defense/Speed emphasis; may impose fatigue debuff after.

## 24.5 Buffs/Debuffs & Environment
- Buffs: property comfort, faction upgrades, education, consumables, event bonuses; weather (cool nights minor buff), indoor gyms ignore heatwave penalties.
- Debuffs: drug crashes, injury debuffs, heatwaves (outdoor gyms), fatigue from long sessions, low happy floor from jail/hospital.
- Warnings when gains are inefficient due to low happy or heavy debuffs.

## 24.6 UI/UX
- Gym panel: stats, DR indicator, expected gain, cost, active buffs/debuffs, happy multiplier, gym tier, membership status, enhancer selection.
- Graphs for stat history; DR curve preview; event indicators.
- Quick-set buttons with confirmations; Dark Luxury styling; borough accent.

## 24.7 Anti-Abuse
- Server-side calc; idempotent requests; rate limits; captcha on suspect macro patterns; daily DR limits; logging of every session with params.
- Multi-session reconciliation; prevent double-submission; nonces on requests.

## 24.8 Interactions
- Bars: energy/happy from Section 002; crashes reduce gains.
- Drugs: boosts/crashes influence gains (Section 024); tolerance impacts enhancer effectiveness.
- Properties: on-site gyms reduce cost or add small bonus; staff trainers (Section 017/022) can add minor gain.
- Factions: upgrades for gains/regen; war states may disable some buffs.
- Progression: stat thresholds gate content; gym achievements/titles for milestones.

## 24.9 Example Flows
- Player uses pre-workout, trains Dex focus: gain boosted; crash after; DR applies due to high stats; log recorded.
- Outdoor gym during heatwave: warning shows penalty; player switches to indoor gym in another borough.
- Spar session: gains small; combat log generated; XP gained; no loot.

### For Architect GPT
- Gym service needs stat gain calc with DR, buff/debuff registry, enhancer consumption, gym access/membership, logging, and anti-abuse. Integrates with bars (Section 002), drugs (Section 024), properties (Section 017/022), factions (Section 012/045), and progression (Section 006).

### For CodeGPT
- Implement training endpoint with DR, buffs/debuffs, enhancer handling, gym access checks, memberships, logging, rate limits, nonces. Provide projections and history APIs; enforce daily DR and anti-macro.

### For BalanceGPT
- Tunables: base gains, DR constants, gym multipliers, enhancer boosts/crashes, fatigue penalties, membership costs, event bonuses. Ensure high-end grind remains long; prevent stim abuse; keep early game welcoming.

### For QAGPT
- Test gains across tiers/stats, DR correctness, enhancer stacking and crashes, membership gating, rate limits, logging completeness, multi-session safety, warning prompts, weather/environment penalties, and property/faction bonus application.  
# SECTION 026 — TRAINING, STAT CURVES, ENHANCERS (ALTERNATE DETAIL)

## 25.0 Overview
This section expands on gym mechanics with additional specificity for stat growth curves, multi-gym strategies, and data/telemetry expectations. It sits alongside Section 024; use both as a combined specification.

## 25.1 Growth Model
- Core formula: gain = base * gym tier mult * happy mult * (1 - DR(stat_value)) * buffs. DR is exponential with configurable constants; caps prevent runaway at extreme stats.
- Per-stat DR: Strength/Defense DR curves slightly steeper than Speed/Dex to limit tank metas; published constants for transparency.
- Daily session DR: per-stat session counter that slightly reduces gains after many consecutive sets; recovers with time or varied activities.

## 25.2 Gyms & Memberships
- Multiple gyms per borough; players can hold multiple memberships; best gym auto-selected unless overridden.
- Membership perks: small cost reduction, access to specialty equipment; expires after set time; renewal reminders; no auto-renew by default.
- Guest passes: limited uses; can be gifted; logs to prevent resale abuse.

## 25.3 Specialty Training
- Weighted splits: focus modes (Str, Spd, Def, Dex, balanced) adjust gain ratios while preserving total; DR applied per stat.
- Circuit bonuses: completing mixed sets grants tiny bonus to next set (once per session) to incentivize variety.
- Coach NPC sessions: consume extra energy; provide minor crit/accuracy training bonus; limited per day; costs cash.

## 25.4 Enhancers & Safety
- Enhancer categories: stimulants (short burst), focus aids (accuracy/Dex bias), endurance gels (reduce fatigue penalty), recovery drinks (mild crash).
- Safety: auto-block enhancer use when active crash severe; warnings for high tolerance; server enforces cooldowns and category caps.
- Injury risk: extremely low; only if ignoring severe crash/fatigue; causes temporary Def penalty; logged.

## 25.5 Telemetry & Analytics
- Track gains per session, per stat, per gym; DR hit rates; enhancer usage; warnings shown.
- Use analytics to tune DR constants, membership costs, and enhancer potency; detect anomalies (impossible gains).

## 25.6 Anti-Abuse
- Nonce-based request validation; rate limit; daily DR; session caps; captcha on suspicious automation; reject client-side manipulated costs.
- Membership sharing exploits blocked by binding passes to account; guest pass abuse flagged by IP/device.

## 25.7 Interactions
- Bars/Happy (Section 002): happy multiplier key; crashes reduce gains.
- Drugs (Section 024): stimulant overlap tracked via tolerance; double-stim penalties.
- Properties (Sections 017/022): in-property gyms give minor convenience; not stackable with high-tier public gym multiplier.
- Factions (Sections 012/045): training bonuses during war off-hours to prep; chain windows still consume energy.

## 25.8 Example Flows
- Player rotates focus: Str sets then Dex sets; circuit bonus applied once; DR reduced by variety; log recorded with split gains.
- High tolerance warning: enhancer blocked; player must wait; UI shows time to safe use.
- Guest pass use: friend visits borough gym; limited sets; pass consumed; log created; no membership perks applied.

### For Architect GPT
- Supplementary gym spec focusing on multiple memberships, specialty modes, analytics, and stricter anti-abuse. Integrate with core gym service, bars, drugs, properties, and faction timers.

### For CodeGPT
- Add membership handling, guest passes, focus modes, circuit bonus, coach sessions, enhanced logging/telemetry, and stricter cooldown checks. Bind passes; enforce DR and session counters; expose analytics endpoints.

### For BalanceGPT
- Tunables: DR constants per stat, session DR slope, membership costs/duration, enhancer potency/cooldowns, circuit bonus size, coach bonus. Aim for strategic variety without overpowering any single path.

### For QAGPT
- Test membership expiry/renewal, guest pass usage, focus mode ratios, circuit bonus, enhancer/tolerance blocking, session DR effects, analytics integrity, and anti-abuse (duplicate requests, automation).  
# SECTION 027 — STATUS, ARMOUR, WEAPON DETAIL (EXPANDED)

## 26.0 Overview
Adds deeper weapon/armor/status detail to complement Sections 003/010. Focus on resistances, penetration, ammo types, set bonuses, and edge-case handling.

## 26.1 Weapon Detail
- Accuracy profiles by range band; shotguns peak close, rifles mid/long, SMGs close/mid, pistols versatile short.
- Penetration: AP ammo reduces mitigation; hollow points increase flesh damage but reduce armor damage; non-lethal rubber reduces damage/heat.
- Noise: affects crime stealth; suppressors reduce noise but lower damage/accuracy; logged for crimes.
- Malfunction: chance increases with low durability, poor ammo quality, DIY weapons; malfunction skips or backfires; logged.
- Reload types: mag vs shell-by-shell; reload time affects initiative; perks can reduce.

## 26.2 Armour & Resistances
- Resist tables: blunt, sharp, ballistic, explosive, chem/electric; each armor piece has specific resist mix; heavy armor slows initiative.
- Encumbrance: initiative penalty; dodge penalty at high encumbrance; reduced by Strength/Speed.
- Set interactions: small set bonus for full matching set; no OP bonuses; mixed sets allow custom resist profiles.
- Durability and penetration: AP reduces durability faster; explosives damage all pieces slightly.

## 26.3 Status Effects (Deep)
- Bleed: periodic life loss; severity scales with weapon; stops on bandage or time; reduced by Defense and armor quality.
- Burn: periodic damage; accuracy penalty; some armor resists; water status reduces burn duration.
- Shock: chance to skip turn; increased if Wet; electric weapons/shocks under storms amplified.
- Stun: hard action block; capped duration; diminishing returns on repeated stun applications.
- Slow: initiative penalty; stacked slows cap; cleansed by certain consumables.
- Suppressed: crit chance reduced; duration short; applied by suppressive fire.
- Adrenaline: short buff to Speed; crash reduces Speed after; stacking limited.

## 26.4 Head/Torso/Leg Targeting
- Head: higher crit chance; helmets reduce; small chance to inflict Dazed.
- Torso: standard; best mitigation; status application standard.
- Legs: can apply Slow; some weapons specialize (baton sweep).

## 26.5 Environment & Terrain
- Rooftops: ranged crit up; dodge down; fall risk if stunned; logs if fall.
- Docks/rain: slip chance; impacts melee accuracy; electric shock amplified.
- Interiors: reduce weather impact; suppressors more effective; explosives risk collateral fines/heat.

## 26.6 Anti-Abuse & Consistency
- RNG seed per fight; deterministic replay; ammo and durability decremented atomically; no double-hit exploits.
- Caps on stun/slow stacking; crit/dodge caps enforced.
- Malfunction protection: cannot trigger infinite loops; failures logged for audit.

## 26.7 UI/UX
- Weapon card shows range bands, penetration, noise, malfunction risk, ammo type; armor card shows resist profile and encumbrance.
- Status chips with durations and severity; logs detail resist interactions and penetration outcomes.
- Warnings for high malfunction risk and encumbrance penalties.

## 26.8 Example Flows
- AP rifle vs heavy armor: penetration reduces mitigation; durability loss higher; defender slowed by encumbrance; log shows resist math.
- Shotgun in rain docks: accuracy penalty; slip chance; target knocked to hospital; heat spike if mugging in public.
- Electrical baton on Wet target during storm: shock chance high; stun applies; log shows storm modifier.

### For Architect GPT
- Extend combat resolver with richer weapon/armor attributes, resist tables, penetration, and status interactions. Hook into environment (Section 013/151) and logging. Ensure compatibility with items (Section 006/011) and combat core (Section 010).

### For CodeGPT
- Implement range profiles, penetration math, resist tables, encumbrance effects, malfunction handling, targeting, status caps, and logging. Update data models for ammo types and noise. Ensure server-side authority and replay determinism.

### For BalanceGPT
- Tunables: penetration percentages, resist values, encumbrance penalties, malfunction chances, status durations/caps, range accuracy curves. Avoid dominant weapon/armor combos; keep DIY gear risky.

### For QAGPT
- Test penetration vs resist combos, range effects, encumbrance penalties, malfunction triggers, status stacking caps, head/torso/leg targeting, environment modifiers, logging accuracy, and anti-duplication of ammo/durability.  
# SECTION 028 — SECTOR MAP & DIPLOMACY (EXPANDED)

## 27.0 Overview
Adds sector map specifics, war types, diplomacy rules, and governance to complement Section 012. Focus on territory economy, war timers, and anti-boosting.

## 27.1 Sector Map
- Grid per borough with sectors; each sector has income, buff, upkeep, and heat. Ownership stored; fog-of-war optional for non-owners.
- Attacks allowed only in war windows; defenders get notification and prep period; weather/time overlay influences accuracy/initiative.
- Upgrades per sector: fortifications (defense buff), surveillance (reduces enemy stealth), supply depots (income), med tents (hospital reduction).
- Upkeep: daily respect cost; missed upkeep degrades sector; abandonment after grace.

## 27.2 War Types (Expanded)
- Territory War: objective is sector control; points per held sector per tick; victory by points or wipe.
- Respect War: respect race; chain multipliers apply; surrender possible with penalty.
- Objective War: specific tasks (destroy depots, capture intel) tracked; points per objective.
- Contract War: paid war with escrow; terms set; time-boxed; penalties for desertion.
- Event War: seasonal rules; modifiers (fog all day, increased patrols).

## 27.3 Diplomacy & Treaties
- States: Neutral, NAP, Alliance, Rivalry, War. Changing state has cooldown; betrayal penalty (respect loss, diplomacy lockout).
- Treaties: optional clauses (no armory theft, no chain padding); violations logged; automatic penalties on breach.
- NAP/Alliance can include shared intel on sectors; time-limited and renewable; costs respect to maintain.

## 27.4 Governance & Roles
- Custom roles with permission matrix: declare war, spend respect, move armory, promote/demote, start chains/OCs/black ops, manage treaties.
- Leadership change rules: inactivity transfer, vote, or coup (cost respect, triggers cooldown).
- Contribution tracking: respect earned, chain hits, donations; used for payouts/eligibility.

## 27.5 Anti-Boosting & Fairness
- Same-IP/linked-account detection reduces respect gains; chain padding on hospital/travel targets devalued; repeated farming flagged.
- War hopping (drop faction to dodge) triggers deserter penalty and temp war ban; respect fines.
- Contract wars: escrow prevents non-payment; staged outcomes flagged; penalties applied automatically.

## 27.6 Territory Economy
- Income: daily cash/resources; scales with sector quality and upgrades; diminishing returns to avoid runaway income.
- Buffs: small regen/damage/nerve benefits to members in owned sectors; capped globally.
- Heat: owning too many high-heat sectors increases patrol risk; can raise jail odds for crimes in those sectors.

## 27.7 UI/UX
- Sector map with ownership tint, buffs, income, upkeep, attack windows; filters for heat, weather, events.
- War dashboard: current wars, objectives, timers, scores, logs, surrender options; chain status integrated.
- Diplomacy panel: states, timers, treaties, penalties; history of changes.
- Notifications: attacks, breaches, upkeep due, betrayal alerts; Dark Luxury styling.

## 27.8 Data & Logging
- Tables: sectors, ownership, upgrades, upkeep, wars, treaties, roles, contributions, penalties.
- Logs: captures/defenses, upkeep payments/misses, treaty changes/violations, war starts/ends, deserter flags, chain hits in war.
- Audit: immutable; used for moderation and dispute resolution.

## 27.9 Example Flows
- Territory war: faction attacks sector during window; weather fog gives defender stealth; attacker wins; sector flips; upkeep set; log created.
- Treaty breach: ally hits during NAP; system logs violation; auto penalty respect fine; diplomacy lockout; notification to both sides.
- War desertion: member leaves mid-war; deserter flag applied; respect fine; temp war ban; profile shows flag.

### For Architect GPT
- Sector/diplomacy layer extends faction system with territory economy, war orchestration, and treaties. Integrates with combat (Sections 003/010/027), crimes/heat (Section 009), weather (Section 151), and logging.

### For CodeGPT
- Implement sector ownership, upgrades, upkeep, war types/objectives, treaty states/penalties, contribution tracking, deserter logic, anti-boost filters, and logging. Provide map and war dashboards; enforce windows and cooldowns.

### For BalanceGPT
- Tunables: sector income/buffs/upkeep, war costs/cooldowns, treaty penalties, deserter fines, anti-boost thresholds, heat effects. Keep territory valuable but not runaway; ensure wars end decisively.

### For QAGPT
- Test sector capture/defense flows, upkeep decay, war declarations/resolution, treaty state changes/violations, deserter flags, anti-boost respect scaling, map overlays, logging completeness. Validate weather/time modifiers and attack windows.  
# SECTION 029 — ACCESS, RISKS, GOODS (EXPANDED)

## 28.0 Overview
Black market provides illegal goods, services, and covert actions. It must be high risk/high reward, gated by reputation and level, with strong anti-abuse and seizure mechanics. Integrates with crimes, travel/smuggling, items, drugs, and factions. Dark Luxury UI with covert overlays; no pay-to-win loopholes.

## 28.1 Access & Reputation
- Access tiers: Tier I (basic illegal consumables/tools), Tier II (weapons/mods), Tier III (special gear/black ops tools). Gated by level, faction status, crime stars, and black-market rep.
- Reputation: earned via successful purchases/deliveries/black ops; reduced by busts/scams; displayed as covert rating; affects prices/availability.
- Invite-only vendors: special NPCs unlocked by missions; limited stock/time windows; location-based (docks, alley, underground club).

## 28.2 Goods & Services
- Goods: illegal weapons/mods, high-potency drugs, nerve kits, forged IDs, signal jammers, lockpicks, counterfeit points (risk), rare crafting mats, illegal upgrades for properties.
- Services: smuggling transport, debt collection, counter-surveillance, intel leaks, reputation laundering (small, with risk), illicit repairs for illegal mods.
- Quality variance: some goods counterfeit; chance scales with rep; counterfeit carries reduced effect or higher crash.

## 28.3 Pricing & Availability
- Dynamic pricing based on heat, weather (fog reduces price slightly), events, and location. Stock rotates; limited quantities; timers.
- Bulk discounts at high rep; surge pricing under crackdowns.
- Payment: cash only (no points); escrow not available; risk is part of design; high-value items may require partial payment upfront and pickup later.

## 28.4 Risks & Enforcement
- Bust chance: scales with heat, location (airports/stations high), item type; success leads to seizure, fines/jail/rep loss; items removed.
- Sting ops: rare events where vendor is compromised; purchase triggers chase/jail; logged.
- Scam vendors: low-rep interactions risk counterfeit; rep mitigates.
- Travel scans (Section 016): illegal goods at borders seized; chance influenced by concealment and heat.

## 28.5 Smuggling Integration
- Special routes and delivery missions; cargo capacity; failure → seizures and jail; success → rep gain and profit.
- Weather/time: night/fog favorable; storms increase ambush risk; heat spikes reduce smuggling availability.
- Tools: false bottoms, forged papers, decoy cargo; quality affects risk reduction.

## 28.6 UI/UX
- Covert market interface: dark overlays, minimal signage; items show risk (bust chance band), quality, legality, stock, timers.
- Warnings before purchase; logs of transactions privately visible to player; no public logs.
- Reputation meter and unlock hints; location/time requirements shown.

## 28.7 Data & Logging
- Tables: vendors, stock, tiers, prices, rep, transactions, busts, seizures, scams.
- Logs: purchases, busts, seizures, rep changes, smuggling runs; moderator view redacted but auditable.
- Analytics: bust rates, counterfeit rates, rep distribution; used for tuning.

## 28.8 Anti-Abuse
- Limit purchases per window; anti-mule detection (alts funneling illegal goods); IP/device correlation; surge bust chance for flagged accounts.
- No escrow to prevent laundering; price bounds to prevent cash washing; counterfeits prevent deterministic profit loops.
- Travel exploit checks: stash swaps near borders flagged; cooldowns on repeated smuggling runs.

## 28.9 Interactions
- Crimes: crime tools and drugs; black ops gear; busts feed into heat and jail (Section 009).
- Items/Inventory: illegal mods/gear (Sections 006/011); durability repair via illicit services; illegal upgrades for properties.
- Factions: faction-only stock; black ops support; rep boosts for war successes; faction can host temporary black-market vendor (at heat cost).
- Properties: hidden rooms reduce seizure chance; bunkers favored for storage but high raid risk.
- Travel: smuggling routes; scans and ambushes; weather/time effects.

## 28.10 Example Flows
- Player with mid rep buys jammer in alley at night fog: lower bust chance; succeeds; rep +; log private.
- High heat traveler with illegal chems hits airport scan: items seized; fine + jail; rep -; heat spikes; trust reduced.
- Sting op: player buys rare weapon; vendor compromised; chase event triggers; failure leads to jail and rep loss.

### For Architect GPT
- Black market service with tiers, rep, dynamic stock, bust/scam mechanics, smuggling, and logging. Integrates with crimes (Section 009), items/inventory (Sections 006/011), travel (Section 016), properties (Section 017/022), factions (Section 012/045), drugs (Section 024), and heat/legality systems.

### For CodeGPT
- Implement access gating, rep tracking, stock rotation, purchases with bust/scam resolution, dynamic pricing, smuggling runs, travel scan hooks, logging, anti-mule detection. Provide UI APIs with risk bands and timers; ensure server-only resolution.

### For BalanceGPT
- Tunables: bust chances, rep gains/losses, stock rarity, counterfeit odds, price ranges, purchase limits, smuggling rewards/risks, heat impacts. Keep risk meaningful; profits attractive but not guaranteed; prevent safe farming.

### For QAGPT
- Test access gating, purchase/bust flows, rep changes, stock rotation timers, smuggling outcomes, travel scan seizures, anti-mule detection, logging accuracy, UI warnings. Validate counterfeit behavior and dynamic pricing within bounds.  
# SECTION 030 — EFFECTS, TOLERANCE, ADDICTION (DETAILED CHARTS)

## 29.0 Overview
Supplemental drug specification adding tabular detail, category limits, and crash math to complement Section 024. Use together for full implementation.

## 29.1 Category Limits
- Stimulants: max 1 active; second dose blocked unless first nearly expired; tolerance +2 per use; decay -0.5/hour.
- Painkillers: max 1 active; stacking blocked; tolerance +1.5/use; decay -0.4/hour.
- Hallucinogens: max 1 active; crashes severe; tolerance +3/use; decay -0.3/hour.
- Performance blends: max 1; tolerance +2.5/use; decay -0.4/hour.
- Medical: max 2 (non-conflicting); low tolerance; minimal crash.
- Global cap: no more than 2 drug categories active simultaneously (excluding medical); enforced server-side.

## 29.2 Effect/Crash Templates (Example)
- Stimulant (e.g., BlocRush): +Speed/+Dex/+5 energy; duration 20m; crash -happy regen/-Speed for 20m.
- Painkiller (e.g., Brickwall): +mitigation/+recoil control; duration 30m; crash -crit/-Dex for 15m.
- Hallucinogen (e.g., Neon Veil): +crit/+happy spike/-accuracy; duration 15m; crash -happy/-accuracy for 30m; small chance of self-stun event.
- Performance blend (e.g., Obsidian Mix): small boosts to all battle stats + energy + nerve; duration 15m; crash reduces all stats and regen; tolerance growth higher.
- Medical med (e.g., MedPak): heal HP over time; minimal crash; no tolerance.

## 29.3 Tolerance & Addiction Math
- Tolerance accumulates per category; effect multiplier = base * (1 - (tol / tol_cap)); crash multiplier = base * (1 + (tol / tol_cap*0.5)).
- Addiction threshold when tolerance average over window exceeds threshold; addiction applies regen debuff and small stat debuff until detox.
- Detox reduces tolerance and addiction; slower if addiction active; costs bars or time; can be accelerated by medical roles/education.

## 29.4 Overdose & Blocks
- Overdose risk when attempting multiple categories beyond cap or re-dosing too early; server blocks and logs; optional injury if forced via exploit attempt.
- Crashes can overlap; effects never stack beyond caps; newest refresh blocked if crash pending on same category.

## 29.5 UI/UX Enhancements
- Drug meter per category: current tolerance, active effect, crash timer, addiction risk indicator.
- Warnings before use if tolerance high or addiction likely; block if overdose risk.
- Logs show deltas to tolerance/addiction; show detox progress; reduced-motion toggles for hallucinogen visuals.

## 29.6 Anti-Abuse & Logging
- Nonce-protected use requests; rate limits; category caps; cooldowns; server authoritative timers.
- Logs: every use with category, quality, effects/crash, tolerance changes, addiction state, blocks, overdose attempts, seizures.
- Analytics: tolerance distributions, addiction incidence, overdose attempts, blocked uses; used for tuning.

## 29.7 Interactions
- Combat/Crimes: same as Section 024; crash severity scales with tolerance; addiction lowers performance until treated.
- Properties: comfort mitigates crash by small factor; med rooms accelerate detox.
- Factions: war rules may cap drug categories; chain pushes may allow temporary overrides (with caps).

## 29.8 Example Flows
- High tolerance stimulant user: effect reduced to 60%; crash increased; warning displayed; tolerance logged.
- Addiction triggered: regen debuff applied; HUD shows addicted; detox program started; tolerance decays slower until detox completes.
- Overdose block: player tries to pop hallucinogen while on stim/painkiller; request blocked; log recorded; cooldown applied.

### For Architect GPT
- Use this as detailed parameter spec for drug caps, tolerance/addiction, and crash math, tied to Section 024. Ensure system-wide enforcement via central drug manager.

### For CodeGPT
- Implement category caps, effect/crash multipliers based on tolerance, addiction state, overdose blocks, and logging. Expose UI data for meters and warnings. Ensure detox logic and rate limits are enforced server-side.

### For BalanceGPT
- Tunables: category caps, tolerance gains/decay, crash multipliers, addiction thresholds, detox rates, overdose block rules. Adjust to keep drugs powerful but risky, preventing permanent buffs.

### For QAGPT
- Test category cap enforcement, tolerance/decay math, crash scaling, addiction triggers, detox progress, overdose blocks, logging completeness, and UI warnings. Validate interactions with combat/crimes and property/med room modifiers.  
# SECTION 031 — HEALTH, HOSPITAL, DAMAGE STATES, REVIVES (EXPANDED)

## 30.0 Overview
The medical system handles life damage, hospitals, revives, injuries, and recovery. It must support combat/crime fallout, drug crashes, faction medics, and company medical services. Torn-like depth with Trench City flavour; Dark Luxury UI; strict anti-abuse and logging.

## 30.1 Health & Damage States
- Life (HP) from Section 002; modified by level, stats, gear, education, perks.
- Damage sources: combat, crimes, events, hunting, drugs (overdose), travel mishaps.
- States: Healthy, Injured (minor debuffs), Critical (heavy debuffs), Hospitalized, Dead (used only for immediate hospital entry; no permadeath).
- Injuries: bleed, fractures, burns, shock; apply regen penalties and combat penalties; duration until treated or elapsed.

## 30.2 Hospital
- Entry: HP at/below 0; severe injuries; overdose; certain event outcomes.
- Duration: base timer from damage severity; reduced by medical skills/education, faction med bays, property med rooms, consumables; increased by drug crashes or lack of treatment.
- Actions in hospital: limited chat/mail; can buy meds; request revive; start detox; read education (minimal gains if allowed).
- Discharge: timer end or successful revive; logs reason and duration.

## 30.3 Revives
- Reviver requirements: medical items, energy cost, medical stat/education; success chance scales; failure extends hospital briefly.
- Cooldowns: per patient; per medic; prevent revive chaining exploits.
- Costs: optional fee; faction/company medics may waive or discount; logs payment.
- Restrictions: cannot revive during certain events/war rules if blocked; cannot bypass critical debuffs illegally.

## 30.4 Medical Items & Services
- Items: medkits, bandages (stop bleed), burn salves, antidotes, shock kits, stim crash reducers. Quality affects potency and failure chance.
- Services: hospital treatments (fee), company medical services (Section 014), faction med bay (Section 012/045), property med rooms (Section 017/022).
- Illegal chems: risky short hospital reduction with chance of injury extension; found in black market.

## 30.5 Injuries & Recovery
- Injury system: tagged statuses with severity/duration; can be treated to shorten; untreated decays slower.
- Stacking rules: limited stacking of same injury; new injury refreshes duration with cap; treatment logs outcomes.
- Regen penalties: injuries reduce bar regen; may cap happy temporarily; recovery removes penalties.

## 30.6 Hospital & Heat/Police
- Hospital entry logs location/context; high heat may increase hospital time (police questioning) and allow arrests for illegal items unless stored.
- Illegal gear seized if scanned; fines/jail possible; recorded in logs; property stash avoids seizure.

## 30.7 UI/UX
- Hospital view: timer, injuries, treatment options, revive requests, costs, medics online. Dark Luxury styling; borough badge; weather overlay.
- HUD: hospital status chip with time remaining; actions disabled as appropriate; tooltips for debuffs.
- Logs: reason for hospital, damage source, treatments, revives, seizures.

## 30.8 Data & Logging
- Tables: hospital stays (start/end, reason, damage, location), injuries, revives (reviver, target, success/fail, cost), seizures, treatments.
- Logs: every injury application/clear; hospital entry/exit; revive attempts; item usage; seizures; illegal finds.
- Analytics: avg hospital times, revive success rates, injury prevalence; used for tuning.

## 30.9 Anti-Abuse
- Revive abuse: cooldowns; diminishing returns on repeated immediate revives; logs to detect farm loops.
- Hospital hopping: timers set by severity; cannot self-inflict to skip timers; self-harm actions blocked.
- Illegal bypass: scripts to avoid hospital blocked; status server authoritative.
- AFK farming in hospital: limited gains; no regen boosts; anti-bot.

## 30.10 Interactions
- Combat (Sections 003/010/027): primary damage source; injuries map from status; armor/mitigation reduce severity.
- Drugs (Sections 024/029): overdose causes hospital; crash increases hospital; detox possible in hospital.
- Factions/Companies: med bays, company medical services reduce timers; faction war rules may adjust revive permissions.
- Properties: med rooms reduce timers; staff medics improve treatment.
- Travel/Crimes: hospital can seize illegal items; travel halted; crimes unavailable; jail transfers possible if arrests in hospital.

## 30.11 Example Flows
- Player KO’d in fight: hospital 45m; injury bleed; buys treatment to shorten; faction medic revives early; log records all actions.
- Overdose: hospital + addiction flag; detox offered; illegal drugs seized; heat spikes.
- Revive fail: medic attempts revive; fails; adds 5m; logs fail; cooldown applies; second medic can try after cooldown.

### For Architect GPT
- Medical system needs hospital, injuries, revives, treatments, seizures, and logging. Integrates with combat, drugs, crimes, properties, factions/companies, and heat/legality. Central medical service governs timers and statuses.

### For CodeGPT
- Implement hospital entry/exit, injury tracking, revive flow with success calc and cooldowns, treatments, seizures, detox hooks, logging. Enforce server authority; block self-harm exploits; integrate with heat/police for seizures.

### For BalanceGPT
- Tunables: hospital base times, injury severities/durations, revive success curve, cooldowns, treatment costs/effects, seizure odds in hospital, illegal chems risk. Balance to keep death impactful without hard-locking play; reward medics meaningfully.

### For QAGPT
- Test hospital timers, injury stacking/clearing, revive success/fail, cooldowns, treatment effects, illegal seizure handling, logging completeness, UI timers, and interactions with heat/police. Validate anti-abuse on revive loops and self-harm attempts.  
# SECTION 032 — HEALTH, HOSPITAL, DAMAGE STATES (ALT CONTEXT)

## 30.A Overview
This companion entry provides alternate perspectives and edge-case handling for the medical system, ensuring coverage for duplicate references in source material. Use with Section 031.

## 30.A.1 Long-Term Injuries
- Persistent debuffs that last beyond hospital release (e.g., limp reducing Speed slightly for a time). Cleared via treatment or natural decay; logged.
- Triggered by extreme damage, explosions, or failed illegal chems; rare to avoid frustration.

## 30.A.2 Special Cases
- Event-specific injuries (radiation, curse-like debuffs) with unique treatments; time-boxed to events.
- Chain-specific war wounds: applied only during wars; reduced by faction med bays; expire after war.
- Jail hospital transfers: if arrested while hospitalized; timer may reset partially; items seized per legality.

## 30.A.3 Medical Roles & Skills
- Medics: players with education/certs; higher revive success; reduced cooldown; can run company medical services.
- Field kits: allow small heals outside hospital; limited per day; do not bypass hospital if HP hits zero.
- Training: medics gain minor proficiency over time (optional future system); capped to avoid power creep.

## 30.A.4 UI/UX Enhancements
- Injury detail panel: severity, duration, treatments available, effect on bars/stats.
- Medics list: nearby/faction/company medics online; request button with fee toggle; log requests.
- Reduced-motion and colour-blind options for injury/crash visuals; accessible tooltips.

## 30.A.5 Anti-Abuse Reinforcement
- Prevent intentional injury loops for farm: diminishing XP from repeated self-harm triggers; track suspicious patterns.
- Revive market abuse: cap fees; rate limit requests; cooldown per requester to prevent spam.

### For Architect GPT
- Edge-layer for medical to cover long-term injuries, event-specific effects, medic roles, and UI accessibility. Integrate with the core medical service.

### For CodeGPT
- Add support for long-term debuffs, event-specific injuries, medic discovery requests, revive fee caps, and anti-spam. Ensure logs capture transfers (hospital→jail).

### For BalanceGPT
- Tunables: long-term injury chance/duration, medic fee caps, field kit limits, event injury effects. Keep rare and meaningful without soft-locking players.

### For QAGPT
- Test long-term injury application/clear, medic request flows, fee caps, transfer jail/hospital handling, event injuries, anti-farm detection, and accessibility toggles.  
# SECTION 033 — STRUCTURE, RANKS, PERMISSIONS, RESPECT (DETAIL)

## 31.0 Overview
Supplemental faction structure focusing on ranks, permissions, recruitment, payouts, and respect handling. Use with Sections 012/028/045 for full coverage.

## 31.1 Ranks & Permissions
- Default roles: Leader, Officer, Enforcer, Member, Recruit; custom ranks allowed with permission matrix (invite/kick, spend respect, war declare, armory move, chain start, black ops, diplomacy changes).
- Promotion rules: leader/officer authority; cooldowns to prevent rank hopping; logs for all changes; deserter tag blocks promotion temporarily.
- Role limits: configurable counts for officers; safeguards against rank inflation.

## 31.2 Recruitment & Intake
- Requirements: level/rank minima, stat checks, background (deserter flag), interview questions (optional).
- Auto-accept lists: friends/allies; invite-only; application queue with review; anti-spam filters on applications.
- Trials: probation period; limited armory access; reduced payouts until passed.

## 31.3 Respect Handling
- Earned from combat, wars, chains, black ops, OCs; scaled by opponent rank/level; reduced for repeat targets/IP links.
- Ledger: gains/spends; permissions to spend respect; proposals for large spends require officer/leader approval.
- Payouts: respect payouts convertible to items/cash via faction rules; logged; tax optional; contribution scores used for splits.
- Decay: small periodic decay to keep activity high; pauses during wars/events.

## 31.4 Payouts & Benefits
- Member benefits: regen buffs, damage buffs, hospital reduction, nerve cap, chain timer extension, intel tools, territory buffs; purchased with respect.
- Distribution: contribution-weighted payouts; weekly bonuses; chain milestone rewards; transparency in logs.
- Caps: prevent stacking beyond global limits; war-time temporary buffs expire after war.

## 31.5 Governance & Audits
- Leadership transfer: inactivity triggers vote; emergency transfer if leader banned/inactive; logs; cooldown after transfer.
- Audit: immutable logs for rank changes, respect transactions, armory moves, war declarations, diplomacy changes; accessible to leadership and mods.
- Alerts: large respect spend, mass armory withdrawals, rank mass changes.

## 31.6 Anti-Abuse
- Rank selling: detected via sudden promotions with payments; flags; penalties.
- Armory theft: quotas, permissions, cooldowns; logs; risk alerts; optional escrow for high-value items to prevent theft.
- Respect farming: same-target/linked-IP reduction; bot detection; staged wars flagged; deserter penalties enforced.

## 31.7 UI/UX
- Rank matrix editor with toggle permissions; warnings for unsafe settings.
- Recruitment dashboard with applications, filters, and probation status.
- Respect ledger view; payout planner; alerts; Dark Luxury styling.
- Role badges on profiles and faction pages.

## 31.8 Example Flows
- Recruit joins: placed on probation; limited armory access; respect share reduced; after criteria met, promoted; logs recorded.
- Large respect spend: officer proposes; leader approves; upgrade purchased; alert sent; ledger updated.
- Deserter: member leaves mid-war; flag applied; rejoin blocked for cooldown; respect penalty applied; profile shows flag.

### For Architect GPT
- Use to solidify rank/permission and respect governance within the broader faction system. Integrate with chains, wars, armory, diplomacy, and logging services.

### For CodeGPT
- Implement rank matrix, promotion/demotion with cooldowns, recruitment queue/probation, respect ledger with approvals, payout distribution, alerts, and anti-abuse checks. Ensure auditability.

### For BalanceGPT
- Tunables: respect gain scaling, decay, payout weights, probation length, quotas, quotas for armory, promotion cooldowns, deserter penalties. Keep recruitment meaningful and prevent rank/pay exploitation.

### For QAGPT
- Test promotions/demotions with cooldowns, probation flow, respect earn/spend with approvals, payout splits, armory quotas, anti-boosting on respect, deserter handling, and logging visibility. Validate UI permissions editor.  
# SECTION 034 — PLAYER-RUN BUSINESSES, STAR RATINGS, RATINGS (DETAIL)

## 32.0 Overview
Detailed company system expansion: star ratings, customer reviews, upgrades, and service quality. Complements Sections 014/022. Focus on balancing profitability, reputation, and anti-fraud within UK-flavoured economy.

## 32.1 Star Ratings & Reputation
- Star rating (0–5) computed from recent customer reviews, on-time deliveries, defect rates, dispute outcomes; decay over time.
- Reputation score underneath rating; used for matchmaking contracts and fee adjustments.
- Fake review detection: IP/device correlation, abnormal patterns; suspicious reviews discounted; penalties for manipulation.

## 32.2 Services & Products
- Service companies: medical (revives), transport (fast travel), security (escorts), tech (repairs/hacks), media (ads/intel), hospitality (buffs).
- Product companies: manufacturing weapons/armor/consumables/components; retail reselling.
- Quality impacts rating; defects raise disputes; recalls possible; logged.

## 32.3 Upgrades & Facilities
- Facilities: production lines, labs, QA rooms, delivery fleet, storefront, customer support.
- Upgrades improve capacity, quality, speed, customer slots; some reduce defect rates; others unlock premium services (priority queues).
- Downtime during installation; logs; progress bars.

## 32.4 Customers & Reviews
- After service/product delivery, customers prompted to rate/review (1–5 stars + short text); cooldown between reviews for same company/user.
- Disputes: triggered on poor delivery/defect; mediator flow; partial refunds via escrow; affects reputation.
- Incentives: optional small discount for review; capped to avoid farming; bribes discouraged and detectable.

## 32.5 Staffing & Performance
- Staffing roles and working stats from Section 022 influence quality and speed. Understaffing increases wait times, lowers rating.
- Morale affects performance and customer satisfaction; safety incidents lower reputation.

## 32.6 Contracts & SLAs
- Contracts with SLA terms (delivery time, quality threshold). Breach triggers penalties, refunds, reputation hit.
- SLA monitoring: timers and quality checks; notifications for risk of breach.
- Repeated SLA breaches reduce rating faster; escrow may auto-refund on breach.

## 32.7 Pricing & Profitability
- Price bounds to stop gouging and laundering; dynamic pricing allowed within bounds based on demand and rating.
- Discounts for allies/factions; cannot undercut below cost floor to launder.
- Analytics: margin, repeat customer rate, breach rate; used for tuning.

## 32.8 Anti-Fraud
- Detect self-dealing reviews, laundering via contracts, false disputes, refund abuse. IP/device checks; trust scores; temporary freezes for investigation.
- Staff sabotage detection: sudden defect spikes tied to specific staff; action logs to trace.

## 32.9 UI/UX
- Company profile: rating, reputation, services/products, prices, SLA stats, recent reviews, dispute rate, uptime.
- Owner dashboard: upgrades, staffing, contracts, reviews, disputes, finances, alerts.
- Customer flow: clear SLA terms, prices, expected delivery time, review prompt; dispute button.
- Dark Luxury styling; risk/warning chips; mobile-friendly lists.

## 32.10 Data & Logging
- Tables: reviews, ratings, SLA metrics, disputes, upgrades, facilities, contracts, deliveries, refunds.
- Logs: deliveries, SLA timers, breaches, disputes outcomes, review submissions, reputation changes, fraud flags.
- Audits: moderator access for fraud; immutable dispute records.

## 32.11 Example Flows
- Delivery SLA breach: late transport job; auto penalty; reputation hit; customer leaves low review; rating drops; alert to owner.
- Fake review attempt: pattern detected; review discounted; user warned; trust score reduced.
- Upgrade install: company adds QA lab; downtime logged; defect rate drops post-install; rating improves.

### For Architect GPT
- Enhance company module with ratings, reviews, SLA enforcement, upgrades, and anti-fraud. Integrates with economy (Sections 014/022), market/contracts (Section 019), factions (Section 012/045), and identity/trust (Section 002).

### For CodeGPT
- Implement ratings aggregation, review submission with cooldowns, SLA tracking/enforcement, disputes/escrow refunds, upgrade handling with downtime, fraud detection hooks. Provide dashboards and APIs for customer/owner views.

### For BalanceGPT
- Tunables: rating decay, review weights, SLA penalties, price bounds, discount caps, upgrade effects/costs, dispute refund rules. Ensure ratings are meaningful and resistant to manipulation; profitability balanced with risk.

### For QAGPT
- Test review flows, cooldowns, fake review detection, SLA timers/breaches, refunds, rating updates, upgrade downtime/effects, fraud flags, logging completeness, and UI indicators. Validate price bounds and dispute resolutions.  
# SECTION 035 — 15+ PROPERTY TIERS, UPGRADES, STAFF, HOUSING (DETAIL)

## 33.0 Overview
Detailed property catalog and mechanics, expanding Sections 017/022. Includes tier lists, specific upgrades, staff/tenant behaviours, and risk. Goal: full UK housing ladder with Dark Luxury UX and Torn-parity depth.

## 33.1 Property Tiers (Example 15+)
1) Bedsit  
2) Studio  
3) Council Flat  
4) Terrace  
5) Semi-Detached  
6) Townhouse  
7) Warehouse Loft  
8) Luxury Apartment  
9) Penthouse  
10) Urban Villa  
11) Suburban Estate  
12) Luxury Estate  
13) Safehouse  
14) Underground Bunker (illegal)  
15) Skyline Penthouse (event)  
16) Manor (event/seasonal)  
- Each tier: base happy, stash size, staff slots, tenant slots, security rating, upkeep.

## 33.2 Upgrades Catalog
- Security: locks, CCTV, alarms, reinforced doors, panic room, biometric entry, guard post.
- Comfort: premium furniture sets, entertainment suite, climate control, soundproofing.
- Functional: gym room, med bay, workshop, hidden stash, helipad/garage, vault (high cap), pet facilities.
- Aesthetic: Dark Luxury skins, skyline views, borough accent lighting.
- Illegal: false walls, jammer rooms, illicit lab (high risk), contraband lockers (reduce detection).
- Each upgrade: cost, install time, effect, upkeep; some require education/contractors; illegal boosts heat risk.

## 33.3 Staff & Tenants
- Staff roles: cleaner, chef, security, medic, trainer. Wages; effectiveness scales with working stats; morale impacts output.
- Tenants: pay rent; satisfaction from comfort/security; defaults trigger eviction; rent based on tier/borough.
- Permissions: set access per staff/tenant; stash access restricted; logs track entries and actions.
- Morale: staff morale influenced by pay, workload, safety; tenants by rent vs quality; impacts happy bonuses and security effectiveness.

## 33.4 Security & Raids
- Security rating derived from tier + upgrades + staff. Higher rating reduces burglary/raid success; diminishing returns at top end.
- Raids: triggered by illegal items/upgrades and high heat; can seize stash; fines/jail; insurance may partially cover legal items.
- Burglary: crime outcome; success based on attacker skill vs security; loot from stash; cooldown on repeat attacks; logs for both parties.

## 33.5 Happy & Regen Engine
- Base happy per tier; upgraded by comfort/staff; caps apply; display sources in UI.
- Regen: minor energy/nerve/life boosts for luxury tiers; med bay adds life regen; party crashes reduce regen temporarily.
- Parties: timed events boosting happy; cost and crash; cooldown; logs.

## 33.6 Stash & Capacity
- Stash capacity by tier/upgrades; hidden stash reduces detection; categories for legal/illegal; permissions enforced; anti-dupe logging.
- Vault upgrade increases capacity and security; may require high tier and education.

## 33.7 UI/UX
- Catalog view with tiers, stats, prices, upkeep; filters by borough/legality.
- Property page: bonuses, upgrades, staff/tenants, stash, logs, maintenance, heat risk; borough badge and weather overlay.
- Actions: buy/sell (with escrow), upgrade, hire/fire staff, set rents/wages, host party, view logs, claim insurance.
- Dark Luxury styling; skyline background; warnings for arrears/heat/illegal risk.

## 33.8 Data & Logging
- Tables: properties, tiers, upgrades, staff/tenants, wages/rent, stash, access logs, raids, maintenance, parties, insurance policies.
- Logs: purchase/sale, upgrade install/maintenance, access, stash moves, raids, rent/wage payments, morale changes, insurance claims.
- Audits: immutable for disputes; insurance uses logs; moderation access for suspicious activity.

## 33.9 Anti-Abuse
- Flip/laundering: price bounds, cooldowns, escrow, alt detection; taxes on rapid flips.
- Stash churn: rate limits; location validation; duplicate detection; hidden stash not insured.
- Staff/tenant abuse: delayed pay triggers morale loss; repeated evictions flagged; alt tenants flagged.
- Insurance fraud: claim caps; cooldowns; investigation flags for repeat claims; illegal items excluded.

## 33.10 Interactions
- Bars: happy/regen (Section 002); staff boosts; parties affect bars.
- Crimes: burglary targets properties; raid risk from illegal upgrades/items (Section 029/148); heat (Section 013/009).
- Factions: safehouses; stash overflow; war raid risk; faction buffs to security possible.
- Travel: helipad/garage; smuggling storage; scan risk modified by security.
- Economy: wages/rent upkeeps; property market tied to borough events; contractor companies (Section 032) install upgrades.

## 33.11 Example Flows
- Upgrade path: player moves from Council Flat to Penthouse; installs vault and med bay; hires staff; happy increases; stash expands; heat risk moderate.
- Raid on bunker: illegal lab triggers raid; stash seized; fine/jail; insurance denies; reputation hit.
- Tenant default: tenant misses rent; eviction after grace; satisfaction drops; logs; property vacancy restored.

### For Architect GPT
- Property catalog and upgrade/staff/tenant systems to be implemented via property service. Integrates with bars, items, crimes/black market, factions, travel, economy (contractors), and insurance.

### For CodeGPT
- Implement tier data, purchase/sale with escrow/cooldowns, upgrade install/maintenance, staff/tenant management with wages/rent, security/raid checks, stash container with permissions, parties, insurance, logging, anti-abuse. Enforce capacity and legality; integrate contractor services.

### For BalanceGPT
- Tunables: tier prices/upkeep, happy/regen bonuses, upgrade effects/costs, staff wages/effects, rent income, raid odds, insurance premiums/payouts, flip taxes. Keep progression meaningful; illegal options high risk/high reward.

### For QAGPT
- Test tier progression, upgrades, staff/tenant flows, rent/wage payments, stash permissions/capacity, raids/burglaries, insurance claims, flip cooldowns, logs, and UI warnings. Validate anti-dupe and price bounds.  
# SECTION 036 — FULL UK REGIONAL TRAVEL, TRAINS, ROADS, SAFEHOUSES

## 34.0 Overview
Expanded travel/transport specification: schedules, vehicle ownership, public transit, safe travel routes, and anti-teleport protections. Complements Sections 016/028 with deeper UK transport flavour and risk models.

## 34.1 Transport Modes & Schedules
- Public Transit: trains (National Rail feel), underground/overground, coaches. Timetables simulated; delays possible from weather/strikes; purchase tickets; class tiers (standard/premium).
- Road: personal vehicles (Section 040), rental cars/vans; traffic affects times; accidents possible on riskier routes.
- Air: regional flights (limited); security scans strict; higher scan odds for illegal items.
- Special: smuggling boats at docks; faction convoys; emergency medical transport (faster, expensive).
- Timers: base duration by distance/mode; modifiers from weather/time/heat/traffic; trains/planes may have fixed departures; road departures immediate but variable ETA.

## 34.2 Routes & Regions
- Regions: London boroughs (hub), Manchester, Birmingham, Bristol, Liverpool, Glasgow, Cardiff, coastal docks; each with entry/exit points.
- Route traits: cost, time, scan risk, ambush risk, comfort (affects happy), cargo capacity.
- Safehouses: some routes allow stopovers at faction/company safehouses (reduce risk/time).

## 34.3 Tickets, Boarding, and Delays
- Tickets: refundable with fee; class affects comfort/happy; premium reduces delay chance slightly.
- Boarding: must be at departure location; timer starts at departure; early arrival waits; miss departure → ticket partially refunded.
- Delays/Cancellations: weather/strikes/events cause delay; compensation (partial refund, small happy) if non-player fault; cancellations auto-refund minus fee.

## 34.4 Security & Scans
- Scans at trains/airports; random spot checks on coaches/roadblocks; scan intensity increases with heat/events.
- Detection: illegal items seized; fines/jail; black-market rep loss; travel status updated to jail/hospital if caught.
- Concealment: items with concealment stats reduce risk; hidden stash in vehicles (Section 040) helps; property stashes avoid scans.

## 34.5 Ambushes & Events
- Ambushes: rare encounters based on heat, route, time, weather; can trigger combat or loss of cargo; logs; faction enemies may target.
- Events: protests/strikes cause reroutes/delays; police checkpoints increase scans; festivals increase crowd (slight time increase).

## 34.6 Cargo & Smuggling
- Cargo slots per mode; weight limits; overpacking slows travel; illegal cargo increases scan/ambush odds.
- Smuggling routes: higher risk, higher reward; requires black-market access, tools (false bottoms, forged docs); success yields cash/rep; failure seizes cargo and jails.
- Insurance: optional cargo insurance (legal goods only); excludes illegal; premium scales with value.

## 34.7 Vehicle Ownership & Road Travel
- Owned vehicles (Section 040) modify road travel times, cargo, ambush risk; maintenance affects breakdown chance; MOT/insurance flavour.
- Accidents: low chance; damage vehicle; hospital possibility; logs; insurance may cover (legal routes only).

## 34.8 UI/UX
- Travel planner: routes, modes, costs, ETA, departure times, scan/ambush risk bands, cargo capacity; warnings for illegal items.
- Status: HUD chip with mode, route, ETA, risk icons; delay alerts; option to view log.
- Tickets view: active/past tickets, refunds, class, compensation.
- Dark Luxury styling with route overlays; mobile cards; real-time countdowns.

## 34.9 Data & Logging
- Tables: routes, schedules, tickets, travel sessions, scans, seizures, delays, ambush events, cargo manifests.
- Logs: travel start/end, mode, route, costs, scans, seizures, delays, ambush outcomes, refunds/comp; insurance claims; breakdowns.
- Analytics: on-time %, delay causes, seizure rates, ambush frequency; used to tune risks.

## 34.10 Anti-Abuse
- Teleport prevention: must be at origin; server timers authoritative; action blocks while traveling.
- Refund abuse: cooldown on cancellations; fee on voluntary cancel; pattern detection for farming compensation.
- Smuggling mule detection: IP/device correlation; repeated small runs flagged; bust odds escalate.
- Multi-session conflicts: single active travel session; second start denied.

## 34.11 Interactions
- Crimes: smuggling ties to black market; travel status blocks most crimes; intercept missions may allow specialized attacks.
- Factions: convoys reduce ambush risk; war logistics (moving between sectors) follow same timers; sabotage possible via black ops.
- Properties: helipad/garage reduce local leg time; stash for cargo; travel comfort influences happy if property luxury used pre/post trip.
- Weather (Section 151): delays and scan odds; storms increase ambush/accident; fog helps smuggling.

## 34.12 Example Flows
- Train to Manchester (standard): buys ticket; 30m timer; rain causes 5m delay; arrives; illegal items seized? none; log recorded.
- Smuggling van to Liverpool docks at night fog: uses concealed compartment; risk lowered; ambush chance moderate; success yields cash/rep; heat +small; log recorded.
- Flight with illegal weapon: airport scan triggers; item seized; fine + jail; travel aborted; log and rep hit.

### For Architect GPT
- Travel/transport service with schedules, scans, ambushes, cargo, refunds, and vehicle modifiers. Integrates with inventory (Sections 006/011), black market (Section 029/148), factions (Sections 012/028/045), properties (Sections 017/022/035), and weather (Section 151).

### For CodeGPT
- Implement planner, ticketing, schedules, travel session timers, scans, ambush events, cargo handling, refunds/comp, insurance, logging. Enforce origin checks and single active travel; anti-abuse for refunds/smuggling; server authority.

### For BalanceGPT
- Tunables: travel times, delay probabilities, scan/ambush odds, cargo limits, smuggling rewards/risks, refund fees, insurance pricing, class comfort effects. Keep risk meaningful; ensure legal travel reliable; smuggling profitable but risky.

### For QAGPT
- Test travel start/end, schedule adherence, delay handling, scan/seizure logic, ambush outcomes, cargo limits, refunds/compensation, origin enforcement, multi-session blocking, logging completeness, and UI warnings. Validate weather/heat effects and vehicle modifiers.  
# SECTION 037 — GANGS, BOSSES, CIVILIANS, SHOPKEEPERS, EVENTS

## 35.0 Overview
NPCs populate the world: gangs, bosses, civilians, merchants, medics, police, event characters. They provide missions, shops, combat encounters, ambience, and dynamic events. System must scale with player level/rank, respond to weather/time/heat, and integrate with crimes, missions, factions, and economy.

## 35.1 NPC Categories
- Civilians: ambient, pickpocket targets, witnesses; affect heat/patrol triggers.
- Gangs: estate-specific; control street crimes; provide missions; fight players; drop loot.
- Bosses: storyline/event/faction leaders; higher stats; unique loot; scripted mechanics.
- Merchants/Shopkeepers: legal/illegal vendors; stock influenced by location/events; shop UI hooks.
- Medics: hospital/company services; revive and treat; pricing varies.
- Police/Patrols: intervene in crimes; trigger jail; scale with heat; spawn frequency location-based.
- Event NPCs: seasonal characters with missions/shops (Halloween, Xmas).

## 35.2 Spawn & Scaling
- Spawn tables per borough/district/street; weighted by time/weather/heat/events.
- Scaling: NPC stats and gear scale by player band; bosses have fixed floors; loot tables adjusted to avoid farm loops.
- Density: crowd index affects civilian/police presence; night reduces civilians, raises gangs; events spike certain NPCs.

## 35.3 Behaviour & AI Profiles
- Aggressive: engage on sight; used for gangs/bosses.
- Defensive: flee/alert police; civilians, some merchants.
- Support: medics; buff allies; event helpers.
- Merchant: static; offers goods; closes by time; stock rotates.
- Patrol: moves through streets; may scan for illegal items; interacts with heat.

## 35.4 NPC Missions & Interactions
- NPCs give missions (Section 020); dialogue based on UK street tone; choices affect reputation with that NPC/faction.
- Reputation per NPC group (gangs, police, merchants): impacts prices, mission access, aggression.
- Encounters: random events triggered by travel/exploration (Section 013); choices lead to combat, loot, or penalties.

## 35.5 Loot & Rewards
- Loot tables per NPC type; gang members drop crime tools/cash; bosses drop rare items/titles; merchants drop nothing.
- Anti-farm: diminishing loot on repeated identical NPC kills; cooldowns; daily caps for bosses.
- Event drops: seasonal currencies/items; time-boxed; disclosed rates.

## 35.6 Shops & Stock
- Legal shops: hours; stock tied to district wealth; prices vary; events can discount/markup.
- Illegal shops: hidden; require rep/access; stock rotates; higher risk; black market integration.
- Merchants can refuse service if reputation low or heat high.

## 35.7 Police & Heat
- Patrol spawn rate increases with heat; police scan for illegal items; can trigger jail during crimes/travel; logs.
- Gangs vs police: dynamic skirmishes can spawn; players can intervene; outcomes affect heat.

## 35.8 UI/UX
- NPC tooltips: type, hostility, rep effect; colour-coded; Dark Luxury cards for bosses/merchants.
- Encounter screens: choices, risks, timers; clear outcomes; combat logs for fights.
- Shops: stock, prices, legality, hours; rep requirements shown; restock timers.

## 35.9 Data & Logging
- Tables: NPC templates, spawn tables, loot tables, reputations, shops/stock, encounters, schedules.
- Logs: spawns/defeats, missions, loot, rep changes, police interactions, shop purchases, refusal events.
- Analytics: kill rates, loot frequency, rep distribution; tune spawn/loot.

## 35.10 Anti-Abuse
- Farm detection: diminishing returns; cooldown on identical NPC farms; IP/device correlation for botting.
- Boss lockouts: timers; daily/weekly caps; no multi-instance abuse.
- Shop abuse: rate limits; exploit detection on price errors; stock duplication checks.

## 35.11 Example Flows
- Night in Hackney: gangs spawn more; police less; player ambushed; wins; loot drops; heat rises.
- Boss fight: scripted mechanics (stun immunity phase); reward rare drop; lockout set; log stored.
- Merchant refusal: player with low merchant rep and high heat gets refused; option to bribe (raises heat).

### For Architect GPT
- NPC system service with templates, spawns, AI profiles, rep, shops, and encounters. Integrates with missions (Section 020), crimes (Section 009), combat (Sections 003/010/027), black market (Section 029), heat (Section 013), and economy (shops).

### For CodeGPT
- Implement spawn tables, scaling, AI behaviours, encounters, shops with stock/rotation, rep system, police patrol logic, logging. Anti-farm and lockouts; server-side authority.

### For BalanceGPT
- Tunables: spawn rates by time/weather/heat, scaling curves, loot tables, rep gains/losses, shop pricing variance, patrol frequency. Keep NPCs meaningful without farm exploits; bosses challenging with fair rewards.

### For QAGPT
- Test spawns across conditions, scaling, loot drops, rep changes, shop stock/rotation, patrol scans, anti-farm decay, boss lockouts, logging accuracy, and UI warnings. Validate merchant refusal and bribe flows.  
# SECTION 038 — HAPPY ENGINE, ESTATES, STAFF (ALTERNATE DETAIL)

## 36.0 Overview
Alternate property detail focusing on happy engine mechanics, estate upgrades, staff morale, and estate-wide buffs. Complements Sections 017/022/035.

## 36.1 Happy Engine
- Base happy per tier; additive bonuses from comfort/staff; multiplicative caps to prevent runaway.
- Diminishing returns on stacking comfort upgrades; property-level cap displayed; crashes reduce effective happy temporarily.
- Daily decay if upkeep unpaid; happy penalty until resolved.

## 36.2 Estate Upgrades & Buffs
- Estate-wide perks: neighborhood watch (reduces burglary), concierge (small regen bonus), estate events (temporary happy spike), landscaped grounds (minor happy), art installations (prestige).
- Utilities: water/heat reliability reduces crash severity; backup generators mitigate blackout events.
- Shared amenities for multi-property owners (if contiguous estates) granting small prestige bonus; avoid power creep.

## 36.3 Staff Morale & Output
- Staff morale tied to wages, workload, safety incidents, leadership activity; morale affects buff strength (med bay effectiveness, training bonus).
- Burnout: overworked staff reduce output; require rest or bonus; logs morale changes.
- Training staff: improves output slightly; cost/time; capped to avoid stacking.

## 36.4 Estate Events & Risks
- Events: parties, community fairs, charity galas; temporary happy/prestige boosts; crash afterward; costs cash/consumables.
- Risks: noise complaints raise local heat slightly; illegal events risk raids; events logged.
- Weather impact: outdoor events penalized by rain; indoor events unaffected.

## 36.5 Stash & Security Nuances
- Separate family/tenant stash with limited access; logs per user; capacity smaller; illegal items blocked unless flagged.
- Security layering: base security + staff + upgrades; stacking with diminishing returns; display effective security score.
- False alarms: low chance to trigger alert; repeated false alarms reduce tenant satisfaction; manual reset option.

## 36.6 UI/UX
- Happy breakdown widget: base, upgrades, staff, events, penalties; caps; current effective happy.
- Morale panel for staff; sliders for wages; workload indicators; burnout warnings.
- Event planner: select event, cost, expected bonus/crash, duration; schedule; logs.
- Security scorecard: components and diminishing returns shown; raid/burglary risk band.

## 36.7 Anti-Abuse
- Event spam prevented by cooldowns; crash applied; diminishing returns on back-to-back events.
- Staff training abuse: daily cap; cost scaling; morale manipulation exploits blocked (pay spam detection).
- Stash churn limits; location validation; illegal items in family stash blocked.

## 36.8 Interactions
- Bars: happy flows to bar effects; crash reduces regen; property events interact with bars.
- Economy: staff wages tie to jobs (Section 022); events consume consumables from market.
- Heat/Crimes: illegal events raise heat; burglary risk tied to security score; raids from illegal upgrades.
- Travel: estate amenities can grant minor travel comfort bonus; helipad/garage still covered elsewhere.

## 36.9 Example Flows
- Happy analysis: property shows 2,500 base + 400 upgrades + 200 staff - 150 crash = 2,950 effective; cap 3,000; UI displays sources.
- Event: host gala; happy +400 for 2h; crash -200 for 1h; cooldown set; logs created; small heat increase.
- Staff burnout: overworked security; morale drops; security effectiveness down 10%; warning; owner raises wages and adds staff; morale recovers.

### For Architect GPT
- Supplement property model with happy engine breakdown, estate events, and staff morale. Integrate with bars, economy, heat/crimes, and UI analytics.

### For CodeGPT
- Implement happy decomposition, caps, events with bonuses/crashes/cooldowns, staff morale/training, security score calculation with diminishing returns, stash permissions, logging. Enforce anti-spam on events and staff manipulation.

### For BalanceGPT
- Tunables: happy caps, upgrade/staff contributions, event bonuses/crashes, cooldowns, morale effects, security diminishing returns, false alarm rates. Keep property buffs impactful but bounded.

### For QAGPT
- Test happy calculations, caps, event flows, crash application, staff morale changes, training caps, security scoring, stash permissions, logging, and cooldown enforcement. Validate UI displays and anti-abuse triggers.  
# SECTION 039 — STOCK MARKET, POINTS BUILDING, INVESTMENTS (SUPPLEMENT)

## 37.0 Overview
Supplementary finance detail to augment Section 019: advanced instruments, investor behaviours, anti-manipulation, and UI analytics.

## 37.1 Advanced Instruments
- Sector ETFs: baskets of related tickers; lower volatility; reduced benefits; no individual perks.
- Options (future optional): restricted, cash-settled calls/puts with strict limits to avoid exploitation; not enabled by default.
- Savings/Notes: time-locked cash products with modest yield; early withdrawal penalty; no points generation.

## 37.2 Investor Profiles
- Risk profiles: cautious (low-volatility preference), balanced, aggressive (higher volatility). Used for tutorials and suggested portfolios; no AI automation.
- Behaviour tags: day-trader (fees higher after threshold), long-term holder (benefit stability), arbitrage attempts flagged.

## 37.3 Manipulation & Safeguards
- Wash trading detection: IP/device links, rapid buy/sell same price/volume; trades discounted; warnings; penalties.
- Pump/dump events: sudden coordinated buys flagged; circuit-breakers; temporary trade limits for involved accounts.
- Benefit cycling: hold-period checks; cooldown after selling before re-qualifying; benefit abuse penalized.
- Insider-like events: news is simulated; no player info edge beyond public calendar; dev-triggered events logged.

## 37.4 Points Integration (Detail)
- Points transfer tax bands; daily/weekly caps; alert on unusual flows; transfers logged with reason codes.
- Points sinks expanded: prestige cosmetics, background variants, banner frames, small XP boost tokens (capped), queue slots for education.
- Points faucet: events, missions, login streaks; tightly capped; no AFK faucets.

## 37.5 UI/UX
- Analytics dashboard: P/L over time, allocation by sector, realized vs unrealized, benefit status, taxes paid.
- Alerts: price move alerts (server-side), benefit loss alert, tax timer alert for short holds, circuit-breaker notifications.
- Education: inline tooltips for risk/fees; warnings for high-volatility buys; suggested reading for new investors.

## 37.6 Data & Logging
- Additional tables: ETF compositions, hold timers, manipulation flags, alert subscriptions.
- Logs: flagged trades, benefit cycling rejections, circuit-breaker triggers, alert deliveries, points transfers with reasons.
- Audits: mod access to flagged accounts; replay of trade sequences.

## 37.7 Anti-Abuse
- IP/device checks on high-frequency trading; throttle if suspected automation; captcha on repeated flags.
- Points laundering: large transfers taxed; pattern detection; freezing suspicious accounts; moderation workflow.
- ETF abuse: weight caps prevent heavy single-ticker concentration; prevents hiding manipulation.

## 37.8 Interactions
- Economy: ETFs provide safer exposure; savings notes act as cash sink; points sinks prevent inflation.
- Missions/Events: may grant temporary fee waivers or small yield boosts; always time-boxed and logged.
- Companies/Factions: optional future—treasury holdings with stricter caps and disclosure; disabled by default to avoid complexity.

## 37.9 Example Flows
- Day-trader flagged: rapid in/out same ticker; system increases fee tier; alert sent; repeat triggers throttle.
- Benefit abuse blocked: user sells below threshold then rebuys; hold-period cooldown prevents immediate benefit; log recorded.
- ETF purchase: lower risk; no individual perks; price moves tracked; user sees allocation analytics.

### For Architect GPT
- Extend finance service with ETFs, manipulation guards, advanced UI analytics, and stricter benefit cycling. Integrate with points management and logging.

### For CodeGPT
- Implement ETFs, hold timers, manipulation detection, alert system, enhanced logging, points transfer reason codes, fee tier adjustments. Ensure circuit-breakers and benefit cooldowns enforced server-side.

### For BalanceGPT
- Tunables: ETF volatility/fees, fee tier thresholds, wash-trade detection sensitivity, benefit cooldown durations, points tax rates/caps, savings yields/penalties. Maintain healthy market without exploit loops.

### For QAGPT
- Test ETF buys/sells, benefit cooldowns, manipulation flagging, alert delivery, points transfer taxes/caps, circuit-breaker effects, analytics accuracy. Validate throttles/captchas trigger appropriately.  
# SECTION 040 — VEHICLES, RACING, GARAGES, STREET CULTURE

## 38.0 Overview
Vehicles add mobility, smuggling capacity, racing, and street identity. System includes ownership, maintenance, garages, mods, races (legal/illegal), and integration with travel/smuggling (Section 036/016). Dark Luxury styling with UK street culture; anti-abuse on dupes and race exploits.

## 38.1 Vehicle Types & Stats
- Types: bikes, hatchbacks, sedans, vans, SUVs, sports cars, muscle cars, trucks, smuggling vans, event exotics.
- Stats: speed, handling, acceleration, cargo, reliability, noise, legality. Quality tiers; rarity influences base stats.
- Legality: some vehicles illegal (no plates, stolen) increasing scan/heat; legal vehicles safer but may have lower cargo or speed.

## 38.2 Ownership & Garages
- Ownership tracked by unique ID; titles; registration status; stolen flags.
- Garages: capacity tied to property upgrades (Section 035); storage reduces decay; hidden bays for illegal vehicles; permissions for spouse/faction safehouse.
- Maintenance: wear from travel/racing; repair at garages/companies; cost based on damage/rarity; neglect reduces stats and increases breakdown chance.
- Insurance: legal vehicles only; covers accidents/breakdowns (not races/smuggling); premiums by risk; claims logged.

## 38.3 Mods & Tuning
- Mods: engine, tires, brakes, suspension, nitrous (illegal), armor plating (adds weight), concealment compartments (cargo, reduces detection), trackers/jammers (risk).
- Install requires tools/skills/companies; illegal mods increase heat; durability impacts mod effectiveness.
- Tuning: minor stat tweaks within bounds; anti-overclock caps; logs all changes.

## 38.4 Racing
- Legal races: organized track events; entry fee; matched by vehicle class; rewards cash/tokens/cosmetics; leaderboards; anti-collusion checks.
- Street races: higher risk/reward; heat gain; police chase chance; illegal betting; damage risk; ambush chance.
- Race mechanics: performance from vehicle stats, driver stats (Speed/Dex), weather/road surface, mods; RNG for mishaps; damage applied to vehicle and sometimes player (minor).
- Cooldowns: per vehicle and per player to prevent spam; lockouts after major crashes.

## 38.5 Smuggling & Transport
- Vehicles affect road travel time and cargo (Section 036); concealment reduces scans; noise influences patrol attention.
- Breakdowns: chance increases with damage/neglect; can trigger ambush or loss of cargo; roadside repair kits reduce severity.

## 38.6 UI/UX
- Garage view: vehicles, stats, condition, legality, mods, cargo; repair/install buttons; storage slots; risk indicators.
- Race lobby: class filters, entry fees, track/weather, risk (legal vs street), rewards; countdown; results logs.
- Mod screen: compatible mods, costs, install times, legality flags; warnings for heat.
- Dark Luxury visuals; street-culture accents; mobile-friendly cards.

## 38.7 Data & Logging
- Tables: vehicles, ownership, condition, mods, races, results, bets, insurance, garages, breakdowns.
- Logs: purchases, transfers, repairs, mod installs/removals, races (with seeds), crashes, police chases, seizures, insurance claims.
- Anti-dupe snapshots; audit trails for trades and races.

## 38.8 Anti-Abuse
- Dupe protection on vehicle IDs; transfers logged; price bounds to prevent laundering.
- Race collusion: detect repeated same-IP matchups; adjust rewards; ban if persistent; anti-sandbagging.
- Betting scams: escrow; odds caps; no multi-account betting on own races.
- Mod stacking limits; tuning bounds; illegal mod detection; seizure risk for illegal/nitrous in scans.

## 38.9 Interactions
- Travel: modifies road speeds, cargo, scan risk; breakdowns affect travel time.
- Crimes: getaway bonuses; certain crimes require vehicle quality; police chases affect heat.
- Factions: convoy buffs; faction races for respect/cosmetics; shared garages in safehouses.
- Properties: garages and hidden bays; insurance discounts for secure properties.
- Economy: repair/mod services via companies (Section 014/032); parts market; race rewards feed into tokens/cash.

## 38.10 Example Flows
- Player buys sports car: stores in garage; installs performance tires and legal tune; speed improves; insurance purchased; logs updated.
- Street race in rain: handling penalty; player crashes; car damage high; hospital minor; heat +; cooldown; repair needed.
- Smuggling van with concealment: road trip with illegal cargo; reduced scan risk; breakdown chance low due to maintenance; arrival successful; profit and rep gain.

### For Architect GPT
- Vehicle system covering ownership, garages, mods, racing, smuggling effects. Integrates with travel (Sections 016/036), economy/companies (Section 014/032), factions (Section 012/028), properties (Section 035), crimes/heat (Section 009), and black market for illegal mods (Section 029/148).

### For CodeGPT
- Implement vehicle model with condition, mods, legality; garage containers; repair/insurance; travel modifiers; racing engine with matchmaking, results, and anti-collusion; logging; anti-dupe. Enforce transfer bounds and scan/seizure hooks.

### For BalanceGPT
- Tunables: vehicle base stats, mod effects, maintenance costs, breakdown chances, race rewards/fees, heat from street races, scan odds with concealment, insurance premiums/payouts. Balance races as fun sink with fair rewards; keep smuggling profitable but risky.

### For QAGPT
- Test vehicle transfers/dupe protection, garage capacity, repair/mod install, tuning bounds, racing flows (legal/street), collision with weather, anti-collusion, scan/seizure with illegal mods, breakdown effects, logging. Validate UI risk warnings and cooldowns.  
# SECTION 041 — HOUSING, PROPERTIES, ESTATES, STAFF, UPGRADES (SUPPLEMENT)

## 39.0 Overview
Supplement to property sections (017/022/033/035/038): focus on estate clusters, national estates, staff scaling, and prestige ladders across regions.

## 39.1 Estate Clusters & National Estates
- Clusters: owning multiple adjacent properties in the same borough unlocks minor prestige and a shared service layer (concierge, shared security), with strict caps to prevent stacking.
- National Estates: rare, high-prestige properties across UK regions (e.g., countryside manor). Massive happy, high upkeep, raid risk if used for illegal storage. Require high level/rank/prestige tokens.
- Estate management: cluster UI to manage shared staff/upgrades; diminishing returns on cluster buffs.

## 39.2 Staff Scaling
- Staff caps grow with estate size/cluster; morale affected by number of properties managed; burnout risk if understaffed.
- Shared staff pools across cluster; effectiveness split; additional staff needed to avoid dilution.
- Training staff improves output modestly; training caps; logs.

## 39.3 Upgrades & Prestige Ladder
- Prestige upgrades: art collections, rare decor, skyline views, bespoke Dark Luxury themes, national flags; boost prestige/happy slightly.
- Estate-wide upgrades: central security hub, shared generator, shared stash vault; increases security and stash but with cap.
- Prestige ladder awards titles/frames and small QoL (faster property UI, reduced upkeep) but no power creep.

## 39.4 Risks & Heat
- Owning clusters increases visibility; higher chance of raids if storing illegal items; heat modifier applied.
- National estates attract attention; police heat adjusted by notoriety; insurance expensive.
- Anti-hoard: tax/upkeep escalation for excessive holdings; cooldown on flipping clusters.

## 39.5 UI/UX
- Estate dashboard: cluster list, shared staff, shared upgrades, prestige score, heat risk, upkeep summary.
- National estate view: unique background, high detail; clear warnings on upkeep and raid risk.
- Logs consolidated for cluster actions; filters by property/cluster.

## 39.6 Anti-Abuse
- Cluster flipping detection; escrow; price bounds; alt detection; increased tax on rapid cluster trades.
- Staff exploitation: wage spam detection; morale abuse prevented by cooldowns; training caps.
- Stash overflow prevention across shared vaults; capacity enforced; logs immutable.

## 39.7 Interactions
- Bars/happy: stack from estates but capped; cluster buffs minor.
- Factions: possible faction lease of safehouse in cluster (with permissions); war raid risk increases.
- Travel: helipads/garages across cluster reduce local travel time slightly; no stacking beyond cap.
- Economy: upkeep sinks; contractor companies install shared upgrades (Section 032/034).

## 39.8 Example Flows
- Player builds cluster of 3 properties: unlocks shared security hub; staff shared; security up modestly; heat up slightly; logs show cluster changes.
- National estate purchase: requires prestige token; upkeep high; installs central vault; raid risk if storing contraband; happy massive but capped.
- Cluster flip attempt: rapid sale flagged; tax applied; cooldown enforced; logs to moderation queue.

### For Architect GPT
- Adds cluster/national estate layer to property system. Integrate with existing property services, staff, stash, security, and heat.

### For CodeGPT
- Implement cluster grouping, shared staff/upgrades, prestige tracking, national estate gating, tax/upkeep scaling, and logging. Enforce caps and anti-abuse; consolidate logs.

### For BalanceGPT
- Tunables: cluster bonus caps, prestige rewards, upkeep scaling, heat modifiers, national estate stats, anti-hoard taxes. Keep prestige cosmetic/QoL, not power creep.

### For QAGPT
- Test cluster creation, shared staff/upgrades effects, caps, national estate purchase/gating, upkeep/heat scaling, anti-flip/tax enforcement, logging, and UI displays.  
# SECTION 042 — FORUMS, MAIL, CHAT, NEWSPAPER (SUPPLEMENT)

## 40.0 Overview
Supplement to Section 020: focuses on moderation tooling, trust/reputation integration, rate-limiting strategies, and content safety for social channels.

## 40.1 Moderation Tooling
- Dashboards: reports queue, user history, IP/device fingerprints (hashed), action logs, mute/ban controls, escalations.
- Workflows: SLA for reports; auto-flag thresholds; shadow mutes for spam; appeal system; audit of mod actions.
- Content filters: UK-aware profanity and slur lists; link filters; image scanning for avatars/banners; ML-assisted spam detection with human override.

## 40.2 Trust & Reputation
- Trust scores from trades/contracts/forums; affect posting limits, attachment permissions, ad purchases, and escrow fees.
- Low trust: stricter rate limits; higher captcha frequency; mail/chat attachment blocks.
- High trust: relaxed caps, faster ad approvals; still no power over odds/economy.

## 40.3 Rate Limits & Safety
- Per-channel limits: messages/min, threads/hour, mail/day; adaptive throttling during spam waves.
- Cooldowns: new accounts gated; staged unlock as account ages and trust increases.
- Slow mode: per channel; event-driven; mods can toggle; applies to trade spam surges.
- Attachment safety: only in mail/forum posts after trust threshold; scanned; size/type limits.

## 40.4 Newspaper & Feeds (Safety)
- Editorial controls: curated front page; filters to avoid doxxing or sensitive data; lore-consistent tone.
- Ads: moderation before publish; rate limits; no external IRL ads; pricing tied to trust.
- Feeds: personal/faction/city with filters; privacy controls; block/mute respected; no sensitive coordinates in public feeds.

## 40.5 Anti-Abuse
- Botting/spam: captcha on trigger; behaviour scoring; IP/device correlation; auto-mute; repeat offenders banned.
- Scams: warnings on risky keywords in mail/contracts; escrow defaults; scam reports impact trust; mod intervention pipeline.
- Harassment: block lists enforced across channels; report escalations; repeated offenders auto-muted; threat keywords trigger high-priority review.

## 40.6 UI/UX
- Clear warnings on limits (rate, trust), captcha prompts; report buttons prominent.
- Mod action transparency: user-facing notices for mutes/bans with duration/reason; appeal link.
- Channel status indicators (slow mode, locked); Dark Luxury styling.

## 40.7 Data & Logging
- Tables: reports, mod actions, trust scores, rate-limit states, ads, filters.
- Logs: posts/messages with hashes, actions, limits triggered, captcha prompts, ad approvals, appeals.
- Retention policies and GDPR compliance; export/delete respected with redactions for moderation data.

## 40.8 Example Flows
- Spam wave: system raises throttles, applies captcha; mods shadow-mute offenders; logs captured; slow mode enabled; wave subsides; limits normalize.
- Scam mail: keyword detection shows warning; escrow enforced; user reports; trust of sender drops; mod reviews.
- Appeal: user appeals mute; mod reviews history; upholds or lifts; log updated; trust adjusted if wrongful.

### For Architect GPT
- Layered social safety: moderation dashboards, trust integration, adaptive rate limits, and content safety. Integrate with identity/trust (Section 002), contracts/escrow (Section 020), ads/feeds, and GDPR tooling.

### For CodeGPT
- Implement trust-based rate limits, moderation dashboards, report pipelines, captcha triggers, content filters, ad approvals, feed privacy, and audit logs. Enforce attachment gates; respect block lists across all channels.

### For BalanceGPT
- Tunables: rate-limit baselines, trust thresholds, captcha triggers, ad pricing, report SLAs, spam detection sensitivity. Balance openness with safety; protect performance.

### For QAGPT
- Test rate limits and slow mode, trust gating, captcha triggers, report/appeal flows, ad approvals, block list enforcement, content filter edge cases, logging completeness, and GDPR export/delete. Validate mod tools and transparency to users.  
# SECTION 043 — MISSIONS, NPCs, STORY ARCS, GANG BOSSES, NATIONAL QUESTLINES (SUPPLEMENT)

## 41.0 Overview
Supplement to Section 020/037: focuses on national questlines, gang boss mechanics, branching choices, and replayability safeguards.

## 41.1 National Questlines
- Multi-region arcs spanning UK cities; require travel (Section 036) and certain levels/ranks/education.
- Chapters unlock sequentially; checkpoints saved; failures can roll back one stage.
- Rewards: unique titles, cosmetics, rare items, points, faction respect; no repeat farming (cooldowns/one-time rewards).
- Narrative tone: UK noir, gang politics, police pressure; Dark Luxury presentation in dialogue.

## 41.2 Gang Boss Mechanics
- Bosses with phases (e.g., immunity to stun, adds spawn); mechanics telegraphed; requires specific tools (flashbang, jammer).
- Lockouts: daily/weekly per boss; team or solo versions; rewards scaled.
- Loot: unique items, titles, story progression items; diminishing loot on repeat.
- Heat: defeating boss may spike heat in borough temporarily; police presence increases; logs.

## 41.3 Branching & Choices
- Branches affect reputation with NPC factions; may change future mission availability or costs.
- Moral choices (help cops vs gangs) adjust rewards and heat; no permanent deadlocks—alternate paths exist.
- Dialogue choices short and impactful; consequences logged; UI shows expected risk bands, not exact probabilities.

## 41.4 Replayability & Anti-Farm
- Cooldowns on repeatable arcs; reduced rewards after first completion; daily/weekly cap on boss drops.
- Randomized elements: encounter order, minor objectives, NPC spawn variants; major beats fixed.
- Anti-boost: multi-account teaming tracked; reward scaling reduced for linked IP/device; logs.

## 41.5 UI/UX
- Quest journal: shows national arcs, bosses, progress, lockouts, cooldowns; travel links; warnings on requirements.
- Boss UI: phase hints, required items, lockout timers; team management; logs.
- Dialogue: concise, noir; Dark Luxury styling; skip/replay after first run; choices clearly labeled.

## 41.6 Data & Logging
- Tables: questlines, chapters, branching flags, boss lockouts, rewards, choices, rep changes.
- Logs: quest starts/completions/failures, choices, boss attempts/outcomes, rewards, cooldowns, heat effects.
- Analytics: completion rates, fail points, popular branches; used to tune difficulty and rewards.

## 41.7 Interactions
- Travel: required for national arcs; timers enforced; delays can fail time-sensitive stages.
- Factions: faction ops may intersect questlines; war state could block some arcs temporarily.
- Crimes/Heat: certain branches alter crime odds or heat temporarily; police quests reduce heat.
- Items: specific tools/gear required; bosses may require counters (anti-stun gear, high pen weapons).

## 41.8 Example Flows
- National arc: player travels to Glasgow for chapter; completes stealth stage; choice to aid gang or police; outcome changes next chapter’s ally and reward; log captures branch.
- Boss fight: team engages boss with stun immunity; uses jammer to bypass adds; victory rewards unique item and title; lockout set; heat in borough rises.
- Repeat attempt: player replays for achievements; reduced loot; cooldown enforced; no duplicate uniques.

### For Architect GPT
- Questline subsystem with branching, lockouts, national travel, boss mechanics. Integrate with travel, combat, NPC rep, factions, and heat.

### For CodeGPT
- Implement quest state, branches, lockouts, boss mechanics with phase flags, required items, team management, reward distribution, logs, and cooldowns. Enforce anti-boosting; handle travel gating.

### For BalanceGPT
- Tunables: boss stats/lockouts, quest rewards/cooldowns, branch rewards, heat effects, anti-boost scaling. Ensure first-time rewards strong; repeats limited.

### For QAGPT
- Test quest progression, branch persistence, boss phases, lockouts, team invite/attempt flows, travel gating, reward scaling, cooldowns, anti-boost detection, logging, and UI clarity.  
# SECTION 044 — REGIONS, DISTRICTS, HISTORY (EXPANDED)

## 42.0 Overview
Lore framework for regions, districts, history, and cultural texture. Guides naming, quests, and environmental flavour. Must remain UK-centric, Dark Luxury in presentation, and align with world identity (Section 001).

## 42.1 Regions & Districts
- London boroughs (core) plus UK regions (Manchester, Birmingham, Bristol, Liverpool, Glasgow, Cardiff, coastal docks). Each with distinct flavour: industries, slang hints, crime flavour, music scenes.
- District traits: wealth, crime prevalence, policing intensity, nightlife, industry focus; influence events and NPC types.
- Naming rules: UK slang, estate references, realistic street names; avoid parody; use naming engine seeds.

## 42.2 History & Backstory
- Recent history: economic downturn, gang consolidation, police budget cuts, influx of tech/black market. World events drive current tensions.
- Faction origins: borough-based crews merging into larger factions; turf wars; historic alliances/rivalries.
- Institutions: hospitals, universities, media outlets, transport hubs; flavour text used in missions/events.

## 42.3 Cultural Markers
- Language: UK English, roadman slang used sparingly; tabloids influence tone; grime/drill/nightlife references; avoid caricature.
- Visuals: estates, cranes, moody skyline, neon reflections, Dark Luxury overlays on gritty infrastructure.
- Music/nightlife: clubs, raves, record shops; inform events and NPC dialogue; drive happy buffs in nightlife districts.

## 42.4 Environmental Events
- Strikes, blackouts, protests, festivals, storms/fog/smog; tied to districts and weather (Section 151); affect crimes/travel/economy.
- Seasonal: Halloween fog, Xmas snow; lore-consistent overlays; event missions tied to cultural beats.

## 42.5 Lore Delivery
- Newspaper stories; mission dialogue; flavour text on streets/shops; item descriptions; loading tips; achievements/titles.
- Consistency: central lore bible references; reuse of factions/locations; no retcons without update note.

## 42.6 UI/UX
- Lore codex: unlockable entries for boroughs/regions/NPCs/factions/events; searchable; Dark Luxury styling.
- Map tooltips with lore snippets; mission journal references; newspaper archives.

## 42.7 Anti-Drift
- No fantasy/sci-fi; no US drift; maintain UK realism; avoid parody of real gangs/brands; keep tone cinematic noir.
- Localization: UK spelling; cultural references aligned; avoid sensitive real-world tragedies.

## 42.8 Example Flows
- Player unlocks “Hackney Cut” lore entry after missions; sees backstory of docks and gang conflicts; future missions reference same factions.
- Event: Tube strike; travel delays; newspaper stories; missions to exploit or mitigate; lore updated.
- Festival: Nightlife district rave; happy buffs; special items with flavour text; event missions tie into music scene.

### For Architect GPT
- Lore framework to keep all systems consistent; feeds naming, missions, events, NPCs, items, and UI. Tie to world identity and regional traits.

### For CodeGPT
- Implement lore codex storage/unlock, map tooltips, newspaper hooks, and localization rules; centralize lore strings; support updates with versioning.

### For BalanceGPT
- Minimal: ensure events tied to lore aren’t overpowering; buffs modest; focus on consistency.

### For QAGPT
- Test unlock conditions for codex, map tooltip accuracy, lore consistency across missions/events, localization/spelling, and absence of drift (USisms, fantasy).  
# SECTION 045 — FULL HOUSING SYSTEM, NATION ESTATES (SUPPLEMENT)

## 43.0 Overview
Additional property-era detail for national estates, prestige, and global housing progression. Complements Sections 041/035/038.

## 43.1 National Estates & Prestige Tokens
- National estates: unique, limited properties in UK regions; purchased with prestige tokens + cash; high upkeep; massive happy but capped; severe heat if used for illegal storage.
- Tokens: earned via high-level progression, wars, events; tradeable? If allowed, with tax and limits to prevent pay-to-win; logged.
- Restrictions: only one national estate per account; cooldown on selling/buying another; escrow enforced.

## 43.2 Estate Governance
- Estate staff scales larger (multiple teams); requires management UI; morale impacted by large footprint; wages high.
- Security layered: central security hub, patrols, sensors; burglary/raid odds low but penalties severe if compromised.
- Visitors: allow guest access (events/meetings); permissions; logs; heat consideration for hosting high-heat players.

## 43.3 Upkeep & Taxes
- Upkeep significant; escalates with add-ons; missed upkeep downgrades bonuses and security; eventual foreclosure if unpaid with grace period.
- Taxes for national estates higher; anti-hoard measures; selling incurs fees.

## 43.4 Illegal Use & Penalties
- Using estates for black market/illegal labs drastically increases raid risk; penalties heavy (seizure/fines/jail); insurance void.
- Heat scaling: national visibility; police/political pressure; modifiers applied to related crimes in vicinity.

## 43.5 Prestige & Cosmetics
- Visual customizations (Dark Luxury estates, regional themes); titles/frames for ownership; estate-only decor; no gameplay power beyond happy/regen caps already set.
- Events may grant temporary estate decor; non-stacking; logged.

## 43.6 UI/UX
- Estate panel: prestige token balance, upkeep timer, staff, security, happy, stash, permissions, heat risk; national badge.
- Foreclosure warnings; tax/upkeep alerts; raid risk indicators; guest logs.

## 43.7 Anti-Abuse
- Token laundering detection; transfer caps; cooldowns; escrow; alt detection; cluster hoard tax.
- Stash management enforcement; illegal item detection; raid cooldowns to prevent spam abuse.

## 43.8 Interactions
- Factions: may rent event access; diplomatic meetings; increased heat if hosting enemy factions; war raids possible (special rules).
- Missions/Events: national estates used in high-level missions; rewards align with prestige level.
- Travel: helipad/garage; minor travel perk; nothing overpowering.

## 43.9 Example Flows
- Player redeems prestige token + cash to buy national estate; upkeep set; happy capped high; logs; token transfer taxed.
- Missed upkeep: bonuses reduced; foreclosure warning; after grace, estate repossessed; stash moved (fees) or seized if illegal.
- Raid due to illegal lab: seizure; fines; jail; heat spikes; reputation loss; insurance void.

### For Architect GPT
- National estate layer tied to prestige tokens, governance, and risk. Integrate with property core, heat/raids, economy/tax, and missions/events.

### For CodeGPT
- Implement national estate purchase with tokens/escrow, staff/security scaling, upkeep/tax timers, foreclosure flow, raid penalties, logging, token transfer safeguards. UI for estate management and warnings.

### For BalanceGPT
- Tunables: token cost, upkeep/tax, happy caps, raid odds for illegal use, foreclosure grace, token transfer tax. Keep estates prestigious but not overpowering; illegal use punishing.

### For QAGPT
- Test purchase/transfer of tokens/estates, upkeep/foreclosure, staff/security scaling, raid triggers, illegal use penalties, logging, warnings, and UI accuracy.  
# SECTION 046 — VEHICLES, TRANSPORT, RACING, CAR PARTS (SUPPLEMENT)

## 44.0 Overview
Supplement to Sections 036/040: adds car parts, maintenance depth, transport company hooks, and street-culture cosmetics. Emphasizes legality, performance vs cargo trade-offs, and anti-abuse.

## 44.1 Parts & Maintenance
- Parts: engines, transmissions, brakes, tires, suspension, exhaust, electronics (ECU), body kits. Quality tiers; durability; legal vs illegal variants.
- Wear: travel and racing degrade parts; performance drops as wear rises; repairs restore; replacement needed if broken.
- Maintenance schedule: recommended service intervals; skipping increases breakdown/scan risk (faulty lights/exhaust noise).
- Diagnostics: garages/companies provide health reports; parts with hidden faults flagged; illegal parts increase heat.

## 44.2 Transport Companies Integration
- Transport firms (Section 032) can service/upgrade vehicles; provide warranties (legal parts only); offer fleet discounts; log work.
- Fleet management: company-owned vehicles for contracts; upkeep costs; breakdowns impact SLA; driver assignments tracked.
- Compliance: MOT/insurance flavours for legal routes; absent compliance increases scan/penalty odds on public roads.

## 44.3 Parts Market & Crafting
- Parts purchasable from shops, black market (illegal/performance), events; crafted/upgraded via company workshops with required working stats/education.
- Counterfeit parts risk: cheaper, lower durability; can trigger failure/bust; flagged in logs.
- Price bounds to prevent laundering; escrow for high-value trades; logs item origin.

## 44.4 Cosmetics & Culture
- Cosmetic mods: wraps, rims, underglow (illegal for street?), interiors; Dark Luxury skins; borough emblems; event cosmetics.
- No stat changes from cosmetics; some increase heat if overtly illegal (underglow on public roads).
- Titles/frames for racing achievements; garage display mode.

## 44.5 Racing Enhancements
- Track conditions: dry/wet; weather from Section 151; tire choice matters; rain penalties to slicks; all-weather tires safer but slower.
- Pit/repair: between heats; costs tokens/cash; fixes minor wear; illegal nitrous disallowed in legal races.
- Anti-collusion reinforcement: random seating, IP/device checks, reward throttles; logs with seeds.

## 44.6 UI/UX
- Vehicle parts panel: health % per part, legal status, recommended service, performance impact; repair/replace buttons.
- Fleet dashboard for companies: vehicles, assignments, SLA risk alerts, compliance status, maintenance timers.
- Cosmetics editor: preview wraps/rims; cost; legality warnings.

## 44.7 Data & Logging
- Tables: parts, wear, compliance, services, warranties, fleet assignments, cosmetics, races.
- Logs: installs/replacements, wear changes, breakdowns, compliance checks, failures, counterfeit detections, racing results, SLA impacts.
- Audit: mod/illegal parts tagged; seizure if discovered; history persists on ownership transfer.

## 44.8 Anti-Abuse
- Dupe checks on parts; counterfeit detection; price bounds; escrow.
- Race collusion: reinforced with device/IP and randomization; rewards scaled if flagged.
- Compliance spoofing blocked; server authoritative on wear/condition; no client overrides.

## 44.9 Interactions
- Travel: wear affects breakdown risk/time; compliance influences scan odds; cargo capacity unchanged by cosmetics.
- Smuggling: concealed compartments as part type; maintenance affects concealment effectiveness.
- Companies: maintenance/upgrade services; fleets for contracts; SLA penalties if breakdown.
- Black market: illegal performance parts; higher bust risk; parts can be seized.

## 44.10 Example Flows
- Player buys counterfeit brakes: cheap; fail during race; crash; car damaged; heat +; log; insurance denies.
- Fleet van overdue service: breakdown mid-delivery; SLA breach; reputation hit; maintenance reminder triggered.
- Cosmetic wrap applied: no stat change; heat +small if flashy in high-heat area; logged.

### For Architect GPT
- Adds parts/maintenance/compliance/cosmetic layers to vehicle system. Integrates with transport companies, races, travel/scans, black market, and logging.

### For CodeGPT
- Implement parts with wear, legal flags, maintenance schedule, services, warranties, diagnostics, cosmetics, and logging. Enforce compliance checks, anti-dupe, and race anti-collusion.

### For BalanceGPT
- Tunables: wear rates, repair costs, breakdown odds, counterfeit penalties, compliance scan modifiers, cosmetic heat bump. Balance maintenance as meaningful sink; illegal parts risky but rewarding.

### For QAGPT
- Test part wear/repair/replace, compliance checks, breakdown events, counterfeit detection, fleet SLA impacts, cosmetic application, race anti-collusion, logging. Validate price bounds and escrow.  
# SECTION 047 — GUN CATEGORIES (ULTRA AAA+ EDITION)

## 46.0 Overview
Detailed gun taxonomy with UK flavour, legality, stats, and special rules. Complements Sections 006/027/040.

## 46.1 Categories & Roles
- Pistols: versatile, low noise, good for stealth crimes; moderate damage; legal/restricted variants.
- SMGs: close/mid-range, high ROF, higher noise; good for street fights; recoil management needed.
- Shotguns: close-range burst; armor pen moderate; spread; excels in confined spaces; heavy noise.
- Rifles: mid/long-range; higher accuracy/crit; penetration; requires Dex; noise high.
- DMRs: precision mid/long; semi-auto; high crit; slower ROF; legal rare.
- Exotic/DIY: zip guns, pipe carbines, chem sprayers; high malfunction; illegal.
- Non-lethal: rubber rounds launchers; low damage; reduce heat; niche for missions.

## 46.2 Stats & Scaling
- Damage, Accuracy (by range), Crit, Penetration, Recoil, Noise, Weight, Ammo capacity, Reload time, Durability.
- Legality flag; malfunction risk influenced by durability/ammo quality; range profiles per category.
- Headshot bias: Dex increases headshot odds; helmets mitigate.

## 46.3 Ammo Types
- Standard, Hollow Point (HP), Armor Piercing (AP), Incendiary (illegal), Rubber (non-lethal), Subsonic (reduced noise, slightly less damage), DIY rounds (high malfunction).
- Ammo quality affects jams and penetration; subsonic reduces heat in crimes; AP increases wear on weapon.

## 46.4 Mods & Attachments
- Sights/scopes (accuracy/crit), grips (recoil), extended mags (capacity; reload slower), suppressors (noise down, damage/accuracy down), stocks (stability), barrels (range tweaks).
- Compatibility per category; illegal mods flagged; diminishing returns on stacking accuracy/crit mods.

## 46.5 Legality & Heat
- Legal/restricted/illegal classification affects shop access, scans, and heat. Carrying illegal weapons increases patrol risk; seizures possible.
- Crimes: noise and legality influence jail odds; suppressors reduce noise but not legality of weapon itself if illegal.

## 46.6 Handling & Skills
- Stats influence handling: Dex/Speed for recoil/accuracy; Strength for recoil control; Education can reduce jams.
- Training courses can unlock advanced handling, reduce malfunction, and improve reload speed.

## 46.7 UI/UX
- Weapon cards show category, stats, range profile, legality, ammo type, mods, durability, malfunction risk, noise.
- Crime/mission warnings for illegal/noisy gear; tooltips for ammo effects; Dark Luxury presentation.

## 46.8 Anti-Abuse
- Mod stacking limits; no combining contradictory mods; stat caps enforced; anti-dupe on weapon IDs; logs for ammo swaps.
- Farm prevention: illegal farming by disassembly blocked; parts tracked; laundering via trades limited by price bounds and escrow.

## 46.9 Example Flows
- Player equips pistol with subsonic ammo and suppressor: stealth crime noise low; damage reduced; legality still restricted if gun is restricted; log captures ammo/mods.
- AP rifle vs armored target: pen reduces mitigation; durability loss higher; ammo logged; wear tracked.
- DIY SMG: cheap; high malfunction; jams mid fight; turn lost; log records malfunction.

### For Architect GPT
- Gun taxonomy and behaviours integrate with items/inventory, combat, crimes/heat, black market, and training/education. Ensure data model covers ammo, mods, legality, and range profiles.

### For CodeGPT
- Implement weapon templates with category stats, ammo compatibility, mod slots, legality flags, noise profiles, malfunction calc, and logging. Update combat/crime resolvers to consider ammo/mods/noise/legality.

### For BalanceGPT
- Tunables: base stats per category, ammo effects, mod bonuses/penalties, malfunction probabilities, noise impacts, legality penalties. Keep category niches; prevent one best gun; DIY risky.

### For QAGPT
- Test ammo/mod compatibility, noise/legality effects on crimes, malfunction rates, range profiles, stat scaling, logging, and anti-dupe. Validate warnings in UI.  
# SECTION 048 — MELEE WEAPONS (UK STREET BLADES, BLUNT, IMPROVISED)

## 47.0 Overview
Melee weapons define close-quarters flavour: UK street blades, blunt objects, and improvised tools. They are central for stealth crimes, muggings, and energy-efficient combat. This section specifies categories, stats, legality, and special effects.

## 47.1 Categories
- Blades: knives (folding, kitchen, combat), machetes, karambits; sharp damage; high crit/bleed; low noise.
- Blunt: bats (wood/aluminium), pipes, hammers; blunt damage; stagger/slow chance; moderate noise.
- Improvised: bottles, bricks, wrenches, chair legs; lower durability; cheap; common in crimes; high break chance.
- Specialty: collapsible batons (low profile), tomahawks, crowbars (crime tool + melee).

## 47.2 Stats & Effects
- Damage (sharp/blunt), Crit, Bleed/Stagger chance, Accuracy, Speed modifier, Noise, Durability, Weight.
- Bleed severity higher on blades; stagger more on blunt; improvised has high break chance; collapsible batons low noise, lower damage.
- Headshot bias lower than guns; leg hits can slow.

## 47.3 Legality & Heat
- Many melee items legal to own; carrying certain blades illegal in public; heat increases on police interactions when illegal blade carried.
- Crimes: low noise benefits stealth; legality still matters; seizures possible if searched; crowbars as dual-use flagged.

## 47.4 Mods & Quality
- Sharpening increases crit/bleed modestly; balance wraps improve accuracy/Speed slightly; spiked bats (illegal) increase bleed but add noise and legality risk.
- Quality tiers affect durability and base stats; improvised cannot be modded; specialty batons may have upgrade slots (grip).

## 47.5 Combat Handling
- Strength scales blunt damage; Dex scales blade accuracy/crit; Speed influences initiative and double-hit.
- Malfunction equivalent: breakage when durability low; weapon destroyed mid-fight; log recorded.

## 47.6 UI/UX
- Cards show damage type, crit/bleed/stagger chances, noise, legality, durability, mods; warnings for illegal carry.
- Crime UI: highlights low-noise benefit; shows heat risk if illegal.

## 47.7 Anti-Abuse
- No infinite sharpen stacking; mod caps; illegal mod detection; anti-dupe on IDs; durability decremented server-side.
- Laundering via trades bounded by price limits; crowbar dual-use tracked to prevent free tool duplication.

## 47.8 Example Flows
- Player uses machete in mugging: high bleed, low noise; illegal carry increases jail risk if caught; log includes legality.
- Improvised bottle: breaks after hit; damage low; cheap; log shows breakage.
- Spiked bat mod: increases bleed; noise up; illegal flag set; scan risk rises.

### For Architect GPT
- Melee spec integrates with combat, crimes/heat, inventory, and mods. Ensure data model includes legality, noise, bleed/stagger, breakage.

### For CodeGPT
- Implement melee templates, mod options, legality flags, noise profiles, breakage, and logging. Hook into combat/crime resolvers; enforce anti-dupe and price bounds.

### For BalanceGPT
- Tunables: damage/crit/bleed/stagger per category, mod effects, breakage rates, legality penalties, noise impact. Maintain niche for blades (crit/bleed) and blunt (stagger), improvised cheap but fragile.

### For QAGPT
- Test mod limits, legality handling, noise effects, breakage logic, stat scaling, logging, and anti-dupe. Validate crime UI warnings.  
# SECTION 049 — THROWABLES & EXPLOSIVES

## 48.0 Overview
Throwable weapons provide area control, crowd effects, and burst damage. Includes grenades, improvised throwables, and faction war tools. Must balance power with scarcity, legality, and risk.

## 48.1 Categories
- Grenades: Frag (damage/bleed), Flash (stun/blind), Smoke (concealment), Incendiary (burn), EMP (disrupt electronics; optional event), Gas (status; illegal).
- Improvised: Molotovs, acid bottles (illegal), bricks/rocks (low damage).
- Faction War Tools: breaching charges (objective damage), signal flares (mark targets; minor heat).

## 48.2 Stats & Effects
- Damage, radius, status (stun/blind/burn/slow), fuse time, throw range, weight, legality, noise, durability (single-use).
- Friendly fire risk; indoors amplify blast (higher damage, higher heat/police attention).
- Weather: rain reduces incendiary effectiveness; wind affects smoke; fog stacks concealment.

## 48.3 Legality & Heat
- Many throwables illegal; carrying increases scan/police risk; use in public increases heat significantly; seizures at scans.
- War exceptions: faction wars may allow restricted use with reduced legal consequences in war zones (still logged).

## 48.4 Usage Rules
- Equipped in slot; single-use; ammo counted; cooldown between throws; limited per combat/mission to avoid spam.
- Fuse: short; misthrow possible if stunned; blind can affect user if in radius.
- Objective damage: breaching charges only work on certain objectives; not for PvP direct damage.

## 48.5 UI/UX
- Item cards show radius, fuse, effects, legality, weight; warnings for illegality and self-harm risk.
- Combat UI: limited throw button; shows remaining; warns about friendly fire; logs outcomes.
- Crime UI: risk warning; heat impact note; stealth penalty for noisy throwables.

## 48.6 Anti-Abuse
- Spam prevention via cooldowns and per-fight caps; inventory caps; price bounds; anti-dupe IDs.
- Self-farming blocked: no exp from self-inflicted throws; logs for moderation; repeated friendly fire flagged.

## 48.7 Example Flows
- Smoke grenade in mugging: reduces visibility; initiative impacted; heat increases for public use; log recorded.
- Molotov in rain: burn reduced; damage lower; still illegal; scan risk high; log shows weather impact.
- Breach charge in war objective: damages objective only; respects cap; log to war feed.

### For Architect GPT
- Throwable system integrates with combat, crimes/heat, faction wars, inventory. Needs legality flags, caps, and logging.

### For CodeGPT
- Implement throwable templates, equip/use with cooldowns/caps, fuse/status handling, weather effects, legality checks, logging. Enforce inventory caps and anti-dupe.

### For BalanceGPT
- Tunables: damage/status values, radius, cooldowns, per-fight caps, weather modifiers, heat penalties, price/rarity. Keep throwables impactful but scarce; illegal items high risk.

### For QAGPT
- Test equip/use, cooldown/cap enforcement, weather impacts, friendly fire, legality/heat handling, objective-only damage for breaching charges, logging completeness, and anti-spam/dupe protections.  
# SECTION 050 — ARMOUR SYSTEM

## 49.0 Overview
Armour governs mitigation, resistances, encumbrance, and durability. This section defines armor types, slots, resist tables, legality, and mods. Complements Sections 006/027/047/048.

## 49.1 Slots & Types
- Slots: Head, Torso, Legs. Optional shields (Section 050) handled separately.
- Types: Light (low encumbrance, low mitigation), Medium (balanced), Heavy (high mitigation, high encumbrance), Specialized (chem/fire/shock resist), Covert (low noise/visibility, reduced stats).
- Sets: themed sets grant small bonuses; mixing allowed; no overpowering set bonuses.

## 49.2 Stats
- Flat mitigation, % mitigation, resistances (blunt/sharp/ballistic/explosive/chem/electric), crit resist, status resist, encumbrance (initiative/dodge penalty), noise, durability.
- Weight influences encumbrance; armor quality affects durability and stats.

## 49.3 Legality & Heat
- Heavy military armor often restricted/illegal; increases scan/police attention; seizures possible when caught.
- Covert armor lower heat; can be worn in public with less risk.

## 49.4 Durability & Repair
- Durability lost when hit; AP/explosives increase loss; zero durability → broken (no effect) until repaired.
- Repairs via companies/black market; cost by rarity/quality; illegal mods may block legal repairs.
- Salvage possible for broken pieces; chance to recover mods.

## 49.5 Mods & Enhancements
- Mods: padding (flat mitigation), plates (ballistic), liners (chem/fire resist), stealth mesh (noise down, encumbrance up), kinetic dampers (reduce stagger).
- Slots limited; diminishing returns on stacking same type; illegal mods flagged; installation risk minimal but tracked.

## 49.6 Encumbrance & Mobility
- Penalties applied to initiative/dodge; caps to avoid total immobility; Strength/Speed can mitigate slightly.
- Heavy armor reduces stealth; displayed in crime UI; racing/travel penalties minimal but can affect smuggling stealth if bulky.

## 49.7 UI/UX
- Armour cards: slot, type, stats, resist table, encumbrance, noise, durability, mods, legality.
- Warnings: encumbrance too high, durability low, illegal gear risk.
- Compare view vs equipped; set bonus indicators.

## 49.8 Anti-Abuse
- Mod stacking caps; no combining conflicting mods; anti-dupe on item IDs; price bounds on trades.
- Repair exploitation blocked (no infinite value gain); durability changes server-side.

## 49.9 Example Flows
- Player equips heavy ballistic armor: mitigation high; encumbrance penalty; dodge down; heat risk up; log records legality.
- Covert vest: low mitigation but low noise; used in stealth crime; legality acceptable; low heat.
- Durability zero: armor provides no mitigation; UI warns; player repairs via company; cost deducted; durability restored.

### For Architect GPT
- Armour system integrates with combat, crimes/heat, inventory, repairs, and mods. Ensure data model covers resistances, encumbrance, legality, and durability.

### For CodeGPT
- Implement armor templates with stats/resists/encumbrance, legality flags, durability loss, repair/salvage, mod slots, and logging. Hook into combat/crime resolvers; enforce anti-dupe and price bounds.

### For BalanceGPT
- Tunables: mitigation/resist values, encumbrance penalties, mod effects, durability loss rates, repair costs, legality penalties. Balance to keep multiple viable armor choices; prevent invincible tanks.

### For QAGPT
- Test equip/compare, mitigation/resist calculations, encumbrance effects, durability loss/repair, mod compatibility, legality/heat, logging, and anti-dupe. Validate warnings for low durability/illegal armor.  
# SECTION 051 — SHIELDS

## 50.0 Overview
Shields provide supplementary mitigation and status resistance, used in combat and riot scenarios. They are distinct from armor: occupy off-hand/aux slot, affect encumbrance and noise, and may impact weapon usage. Balancing keeps shields situationally strong without making players invulnerable.

## 50.1 Types
- Riot Shields: high blunt/impact mitigation; decent ballistic deflection; heavy; legal for security roles, restricted otherwise.
- Tactical Shields: balanced mitigation; more ballistic; medium encumbrance; restricted/illegal.
- Improvised Shields: makeshift (bin lids, plywood); low mitigation; high break chance; legal; cheap.
- Energy/Tech (event/rare): limited-time; small status resist; high heat/illegal; avoid power creep.

## 50.2 Stats
- Mitigation (flat/%), Resist (blunt/sharp/ballistic), Encumbrance (initiative/dodge penalty), Durability, Noise, Coverage (chance to block frontal hits), Status resist (stun/bleed partial).
- Weight influences encumbrance; durability loss on block; piercing/armor-piercing rounds reduce effectiveness.

## 50.3 Usage Rules
- Slot: off-hand/aux; blocks dual-wield; some two-handed weapons incompatible.
- Coverage: frontal arc block chance; not guaranteed; reduced effectiveness vs flanks; logs show blocked hits.
- Weapon compatibility: pistols/SMGs fine; rifles penalized; melee fine; shotguns possible with penalty.
- Recharge: none (not energy); rely on durability/repairs.

## 50.4 Legality & Heat
- Riot/tactical often restricted; carrying in public raises police attention; seizures on scans; legal for security jobs/faction war zones may have exceptions.
- Improvised legal; minimal heat unless used in crimes.

## 50.5 Durability & Repair
- Durability drops on block; explosives/heavy ammo damage more; zero durability -> breaks; cannot block.
- Repairs via companies; illegal shields need black-market repairs; cost scales with rarity/damage.

## 50.6 Mods & Upgrades
- Limited: viewport reinforcement (stun resist), edge padding (noise down), weight reduction (encumbrance down, durability down), ballistics coating (ballistic resist up). Slots few; diminishing returns.

## 50.7 UI/UX
- Shield card: mitigation/resists, coverage, encumbrance, durability, legality, mods; warnings for incompatible weapons.
- Combat log shows blocks and coverage outcomes; status resist applied.

## 50.8 Anti-Abuse
- Coverage caps; cannot stack multiple shields; encumbrance prevents dodge-tank combos; price bounds; anti-dupe IDs; repair exploitation blocked.

## 50.9 Example Flows
- Security role uses riot shield + pistol: blocks some frontal hits; encumbrance lowers initiative; legal in job; illegal elsewhere -> heat.
- Tactical shield with rifle: compatibility penalty; reduced accuracy; block still possible; encumbrance applied.
- Improvised bin lid: low block chance; breaks quickly; cheap; no legal risk.

### For Architect GPT
- Shield subsystem integrates with combat, items/inventory, legality/heat, and repairs. Ensure compatibility logic with weapons and encumbrance.

### For CodeGPT
- Implement shield templates, coverage/block chance, encumbrance, durability loss/repair, legality flags, compatibility checks, mods, and logging. Hook into combat resolver for block events.

### For BalanceGPT
- Tunables: coverage %, mitigation values, encumbrance penalties, durability loss, mod effects, legality penalties. Prevent invulnerability; keep shields situational.

### For QAGPT
- Test equip with compatible/incompatible weapons, block calculations, durability loss, encumbrance effects, legality handling, mod limits, logging, and anti-dupe. Validate coverage caps prevent abuse.  
# SECTION 052 — WEAPON MODS & ATTACHMENTS

## 51.0 Overview
Weapon mods/attachments customize guns/melee for performance, stealth, or utility. Must prevent stat inflation and illegal stacking. Integrates with legality/heat, durability, and compatibility.

## 51.1 Mod Categories
- Optics: red dot, holo, scopes; improve accuracy/crit at range; add weight.
- Grips/Stocks: reduce recoil; improve stability; some reduce accuracy if mismatched.
- Magazines: extended mags increase capacity; slower reload; drums increase malfunction/heat; legal flags.
- Barrels/Muzzles: suppressors (noise down, damage/accuracy down), compensators (recoil down, noise up), extended barrels (range up, handling down).
- Ammo Feeds: speed loaders, tactical reload kits; minor reload speed buff.
- Special: laser (crit assist), flashlights (accuracy in dark; heat risk), underbarrel (grenade/flash; restricted).
- Melee Mods: wraps, sharpen kits, spikes (illegal), counterweights (accuracy/speed balance).

## 51.2 Slots & Compatibility
- Slot model per category; weapons define allowed slots; cannot stack multiple of same slot unless explicitly allowed.
- Weight and handling penalties accumulate; encumbrance considered for some heavy mods.
- Illegal mods flagged; some only fit specific weapon classes; melee mods restricted to melee.

## 51.3 Effects & Diminishing Returns
- Each mod provides defined bonuses/penalties; stacking similar effects has diminishing returns; hard caps on accuracy/crit/recoil reduction.
- Suppressors reduce noise but not legality; AP drums boost pen but raise jam risk and legality/heat.

## 51.4 Install/Remove
- Requires tools/services; cost; time; chance to damage mod or weapon on removal (small).
- Illegal mods may only be installed at black-market/underground service; logged; legality persisted.
- Wear: mods have durability? optional; if used, durability lowers if weapon malfunctions; repair possible.

## 51.5 UI/UX
- Mod screen: compatible mods, slot availability, effects, legality, weight, penalties; preview resulting stats; warnings on caps/illegality.
- Inventory view shows installed mods; quick remove/install with cooldown; Dark Luxury styling.

## 51.6 Anti-Abuse
- Cap stacking; block conflicting mods; anti-dupe IDs; price bounds; installation logs; cooldown on repeated install/remove to prevent buff cycling.
- Illegal mods increase scan risk; flagged in logs; seizure possible on scans.

## 51.7 Example Flows
- Player installs suppressor + holo on pistol: noise down, accuracy up; damage down slightly; legality unchanged if pistol restricted; logs install.
- SMG with drum and grip: capacity up, recoil down; jam risk up; heat up; logged.
- Melee wrap and sharpen: crit/accuracy up modestly; cap enforced; logs changes.

### For Architect GPT
- Mod system with slots, compatibility, caps, and legality hooks. Integrates with weapons (Section 047), combat (Sections 003/010/027), inventory (Section 011), and heat/scans.

### For CodeGPT
- Implement slot schema, compatibility checks, install/remove flows with costs/time, effects application with caps, durability (if used), logging, and anti-dupe. Enforce legality impacts on scans.

### For BalanceGPT
- Tunables: mod bonuses/penalties, caps, install/remove costs, failure chance, durability loss, heat impacts. Prevent stat inflation and illegal stack metas.

### For QAGPT
- Test compatibility, cap enforcement, install/remove flow, logging, legality/heat effects, anti-dupe, and UI warnings. Validate cooldown on buff cycling.  
# SECTION 053 — ARMOUR MODS & WEARABLE AUGMENTS

## 52.0 Overview
Armor mods and wearable augments customize resistances, encumbrance, and utility. Must respect caps, legality, and anti-inflation rules. Integrates with armor (Section 050), combat, and scans.

## 52.1 Mod Categories
- Padding: blunt/sharp resist; minor encumbrance up.
- Plates/Inserts: ballistic; chem/fire/electric inserts; increase resist; weight up.
- Stealth Liners: noise down; encumbrance slightly up; reduces stealth penalties; illegal variants reduce scan chance.
- Cooling/Heating Mesh: reduces heatwave/cold penalties; minor encumbrance.
- Status Dampeners: reduce bleed/burn/stun durations; small.
- Utility: ammo pouches (small capacity), tool loops (crime tools), med pockets (faster med use).

## 52.2 Augments (Wearables)
- Smart HUD visors: display info; minor accuracy boost; legality neutral; could increase heat if obvious.
- Exo-assists (light): small encumbrance offset; capped; illegal heavier exos not allowed to avoid sci-fi creep.
- Bio-monitors: alert on low HP; faster med use; low buff.

## 52.3 Slots & Compatibility
- Slots per armor piece; limited; cannot stack same type beyond slot count; diminishing returns.
- Some mods mutually exclusive (e.g., stealth liner vs heavy plate if slot limited).
- Augments occupy accessory slots; caps to avoid overlap with clothing system.

## 52.4 Effects & Caps
- Resist boosts small/moderate; encumbrance adds; status reduction capped; stealth/scan reductions capped; utility minor.
- Illegal mods flagged; increase scan risk; seizures possible.

## 52.5 Install/Remove
- Done via companies/black market; cost/time; low risk of failure; logs actions; illegal installs flagged.
- Mods transferable; durability loss minimal; removal safe with small fee.

## 52.6 UI/UX
- Armor mod screen: slots, compatible mods, effects, encumbrance, legality; preview final stats; warnings on caps/conflicts.
- Augments view: accessory slots, buffs, legality, visibility.

## 52.7 Anti-Abuse
- Caps on resist/status reductions; stacking limited; anti-dupe IDs; price bounds; installation logs; cooldown on swap spam.
- Illegal mods raise scan odds; cannot be hidden by removing visibility only; server tracks legality.

## 52.8 Example Flows
- Player adds ballistic plate and stealth liner: resist up; encumbrance up; noise down; caps enforced; logged.
- Exo-assist: reduces encumbrance modestly; capped; illegal heavy exo blocked.
- Chem insert: reduces chem status; weight up; legal? flagged if military-grade.

### For Architect GPT
- Armor mod/augment subsystem with slots, caps, legality. Integrates with armor templates, combat, inventory, and scan/heat systems.

### For CodeGPT
- Implement slot schema, compatibility/cap checks, install/remove flows, effects application, legality tracking, logging, and anti-dupe. Enforce scan impacts for illegal mods.

### For BalanceGPT
- Tunables: resist gains, encumbrance costs, status reduction caps, stealth/scan effects, install costs. Keep mods impactful but bounded to prevent tank/stealth extremes.

### For QAGPT
- Test compatibility/caps, install/remove, logging, legality/scan impacts, encumbrance updates, augment slot enforcement, and UI warnings. Validate swap cooldown to prevent buff cycling.  
# SECTION 054 — CLOTHING & COSMETIC FASHION SYSTEM

## 53.0 Overview
Clothing and fashion provide identity and prestige without gameplay stats. They follow Dark Luxury styling and UK street culture. This section defines categories, acquisition, customization, and anti-abuse (no camouflage granting stealth). Cosmetics must not break readability or confer power.

## 53.1 Categories
- Outfits: full looks (streetwear, formal, tactical, nightlife, workwear).
- Layers: tops, bottoms, footwear, outerwear, accessories (chains, watches), masks (cosmetic; not stealth).
- Themes: borough-inspired, event/seasonal, faction-branded, prestige (TrenchMade), Dark Luxury exclusives.
- Emblems: faction/company logos; personal motifs; must pass moderation.

## 53.2 Acquisition
- Shops (legal fashion), events, missions, achievements, faction rewards, prestige purchases (points), black-market cosmetic drops (rare looks).
- Limited-time drops for events; reruns possible; no stat advantage; rarity only cosmetic.
- Crafting (future): combine fabrics/dyes for variants; purely visual.

## 53.3 Customization
- Colours/patterns within curated palette; prevents unreadable combos; borough accents allowed.
- Layer mixing allowed; outfit presets; save/load looks; preview with background.
- Faction/company branding optional; moderation for offensive content; templates for badges.

## 53.4 UI/UX
- Wardrobe: filter by category/theme/rarity; preview on avatar; quick apply; save presets.
- Shop: Dark Luxury storefront; prices (cash/points); event banners; clear “cosmetic only” messaging.
- Badges/emblems editor with moderation; upload pipeline restricted; templates encouraged.
- Reduced-motion and contrast-friendly previews; mobile-friendly.

## 53.5 Anti-Abuse
- No stat bonuses; no stealth from dark outfits; masks cosmetic only.
- Moderation: profanity/imagery filters; approvals for uploads; report/strike system.
- Trade: cosmetics tradeable within bounds; price limits prevent laundering; rarity respected; anti-dupe IDs.

## 53.6 Interactions
- Titles/frames (Section 001/006) complement outfits; identity system shows clothing.
- Events: themed outfits; festivals; rewards for participation.
- Market: cosmetic listings; trust reduces fees; no boost to combat/crime.

## 53.7 Example Flows
- Player buys Camden streetwear set: applies; no stat change; profile updates; logs purchase.
- Event mask: cosmetic only; no stealth; limited time; tradeable with bounds.
- Emblem upload: sent to moderation; approved; usable on outfits; logged.

### For Architect GPT
- Clothing system separate from stats; integrate with identity/profile, shops/market, moderation, and titles/frames for presentation.

### For CodeGPT
- Implement wardrobe storage, presets, shop purchases, moderation queue for emblems/uploads, trade with bounds, logging. Enforce no-stat rule in combat/crime systems.

### For BalanceGPT
- Minimal: ensure pricing/rarity reasonable; trade bounds prevent laundering; no gameplay impact.

### For QAGPT
- Test outfit apply/save, shop purchases, moderation flow for emblems, trade bounds, logging, and confirmation that cosmetics do not alter stats/stealth.  
# SECTION 055 — HAIRSTYLES, BARBERS, TATTOOS & APPEARANCE EDITING

## 54.0 Overview
Appearance systems provide additional identity customization: hair, beards, tattoos, and cosmetic edits. They follow Dark Luxury styling, UK street culture, and strict moderation. No gameplay stats; purely visual.

## 54.1 Hairstyles & Barbers
- Hair options: fades, braids, curls, mohawks, buzz, long styles; UK street-inspired; colour options within curated palette.
- Barbers: locations in boroughs; services include cuts, dyes, beard trims; prices in cash/points; preview before apply; save presets.
- Cooldowns: short cooldown on changes to prevent spam; logs changes; no stats.

## 54.2 Tattoos & Ink
- Slots: arms, neck, back, chest, legs; layered; styles include script, geometric, cultural motifs (moderated), faction/company logos (if approved).
- Application: tattoo shops; cost cash/points; pain/time flavour; removal/cover-up available (cost).
- Restrictions: no offensive/real-gang content; moderation queue for custom uploads; curated packs safe.

## 54.3 Appearance Editing
- Sliders: face shape, skin tone (inclusive range), eye colour; constrained to realistic values; no distortion.
- Accessories: piercings, glasses, minimal jewellery; cosmetic only.
- Body type presets; no stat effects; Dark Luxury rendering; avoid caricature.

## 54.4 UI/UX
- Character editor: tabs for hair, beard, tattoos, accessories, facial features; preview with background; undo/redo; save/load looks.
- Barbershop/tattoo UI: service list, costs, cooldown info, moderation notices.
- Mobile-friendly controls; accessibility (colour contrast, text labels).

## 54.5 Moderation & Anti-Abuse
- Upload filters; mod queue; strikes for violations; blocklist of forbidden terms/symbols; report button.
- Price bounds for trades (if trading cosmetic tokens allowed); anti-laundering.
- Log changes; cooldown to reduce spam/name-change style grief.

## 54.6 Interactions
- Identity profile displays selected appearance; titles/frames/clothing complement look.
- Events: limited-time styles; barber discounts; tattoos themed to events.
- No impact on combat/crime/economy; purely visual; still subject to moderation.

## 54.7 Example Flows
- Player visits barber: previews fade with gold dye; pays; applies; log recorded; cooldown; profile updates.
- Tattoo: selects approved design; applies to arm; cost deducted; removal available later.
- Custom emblem tattoo request: uploaded; enters moderation; either approved and applied or rejected with notice.

### For Architect GPT
- Appearance system integrates with identity and cosmetics; requires moderation and storage of selections; no gameplay effects.

### For CodeGPT
- Implement editors, shop services, preset saves, moderation for uploads, cooldowns, logging. Ensure selections propagate to profile/UI; enforce no-stat rule.

### For BalanceGPT
- Minimal: pricing/cooldowns and trade bounds for cosmetic tokens if used; ensure accessibility of basic styles.

### For QAGPT
- Test style apply/change, cooldowns, moderation flows, logging, profile rendering, and confirmation that appearance changes don’t alter stats.  
# SECTION 056 — PETS, ANIMALS & COMPANION SYSTEM

## 55.0 Overview
PETS provide flavour, minor utility, and collection goals. They must not unbalance combat or crimes. UK urban/wildlife flavour with Dark Luxury presentation. Anti-abuse to prevent bot farming. No fantasy creatures.

## 55.1 Pet Types
- Urban: dogs (staffy, bulldog, mutt), cats, pigeons/ravens (messenger flavour), foxes (rare, event).
- Exotic (gated/event): snakes, owls; high upkeep; no combat advantage.
- Event/Seasonal: cosmetic skins; limited-time; no stat bonuses.

## 55.2 Acquisition & Care
- Sources: pet shops, rescues (missions), events, achievements. Adoption fee; pet slot limit; prestige unlock for rare types.
- Care: feeding, grooming, vet visits; neglect reduces happiness/utility; pets cannot die permanently but can become inactive until cared for.
- Upkeep: small recurring costs; happiness affects utility.

## 55.3 Utility (Bounded)
- Fetch/Find: tiny boost to city find rate (capped); cooldown; logged.
- Mood Buff: small happy buff to owner when pet is happy; capped; cosmetic animations.
- Messenger flavour: cosmetic delivery animations for mail/notifications; no speed change.
- No combat: pets do not fight; no damage/defense buffs; avoids pay-to-win.

## 55.4 Training & Traits
- Simple traits: obedient, curious, vigilant; minor effects on fetch cooldown, find chance, notification flavour. Traits capped; no stacking beyond small boosts.
- Training mini-actions consume time/cost; soft caps; logs; anti-bot.

## 55.5 UI/UX
- Pet panel: type, happiness, hunger, traits, upkeep timers; actions (feed, groom, vet, train); cosmetic skins; Dark Luxury cards.
- Notifications: care reminders; inactivity warnings; fetch results; all logged.
- Accessibility: option to hide animated pets; still show status text.

## 55.6 Anti-Abuse
- Fetch cooldowns; diminishing returns on rapid fetch; anti-bot detection on repetitive care loops.
- Trading/adoption limits; price bounds; anti-laundering.
- No farming rare pets: adoption gated by achievements/events; logs.

## 55.7 Interactions
- Properties: some properties allow pets; small happy bonus; higher upkeep if property not pet-friendly.
- Events: pet-themed events; skins; limited-time missions.
- Market: cosmetic pet skins tradeable with bounds; no stat items.

## 55.8 Example Flows
- Player adopts staffy: pays fee; pet added; care timers start; fetch ability unlocked; happy buff when cared for.
- Neglect: happiness drops; utility off; reminder sent; player feeds/grooms to restore.
- Event fox skin: cosmetic; no stat; tradeable within bounds; log recorded.

### For Architect GPT
- Pet system is cosmetic/utility-light; integrate with identity, properties, events, and logging; keep balanced.

### For CodeGPT
- Implement pet ownership, care timers, traits, fetch action with cooldown, skins, reminders, logging, anti-bot. Enforce slot limits and trade bounds.

### For BalanceGPT
- Tunables: fetch cooldown/chance, happy buff size, upkeep costs, trait effects, adoption caps. Keep impact minimal; focus on flavour/collection.

### For QAGPT
- Test adopt/care/train, fetch cooldowns, happy buffs, neglect/inactivity, trade bounds, logging, and accessibility toggle. Validate no combat effects.  
# SECTION 057 — WEATHER, TIME & ENVIRONMENTAL SYSTEM

## 56.0 Overview
Weather and time drive modifiers, visuals, events, and NPC behaviour. UK realism (fog, rain, overcast, smog) with Dark Luxury overlays. System-wide hooks: crimes, combat, travel, economy, NPC spawns, UI backgrounds. See Section 151 for core; this supplements with more detail.

## 56.1 Weather Types & Attributes
- Clear, Cloudy, Fog/Heavy Fog, Light/Heavy Rain, Storm/Thunder, Drizzle, Overcast/Gloom, Snow/Blizzard, Heatwave, Pollution Smog, Night Mist, Event Weather (Halloween fog, Xmas snow).
- Attributes: visibility, traction, crowd factor, patrol factor, temperature, pollution index.

## 56.2 Time-of-Day
- Cycles: Morning (5–11), Day (11–18), Evening (18–23), Night (23–5). Each affects NPCs, crimes, travel, shops, heat decay, and UI overlays.
- Daylight savings: optional flavour; not required mechanically.

## 56.3 Effects on Systems (Examples)
- Crimes: fog improves stealth; rain lowers pickpocket success; storm increases electronics failure (tech crimes risk/reward); snow slows outdoor crimes; heatwave boosts nightlife targets but reduces energy regen slightly.
- Combat: rain reduces firearm accuracy; fog lowers initiative; storm boosts electric shock chance; heatwave small Speed penalty; night boosts stealth builds.
- Travel: rain/snow delays; storm raises ambush risk; fog lowers scan chance slightly; heatwave minor comfort penalty.
- Economy: shop demand shifts (rain gear, umbrellas); smog increases mask sales; heatwave increases drink sales.
- NPCs: police patrols shelter during heavy rain; gangs more active at night; civilians fewer in bad weather.

## 56.4 Global Tick & Forecast
- Weather updated on schedule (e.g., every 15 minutes); forecast 6 hours; published to UI; events can override.
- Regional variation: borough-level differences; coastal vs inland; smog localized to industrial districts.
- Persistence: event weather lasts set duration; extreme weather rare; logs for transitions.

## 56.5 UI/UX
- HUD chips: weather + time with tooltips listing modifiers; city map overlay; background overlays (fog/rain/snow/heat shimmer).
- Performance: lightweight overlays; reduced-motion mode; quality toggles.
- Notifications: weather changes that impact active timers (travel delays) or crimes; warnings for storms/strikes.

## 56.6 Data & Logging
- Tables: weather states per region, forecast, events; modifiers; transition schedule.
- Logs: weather changes, applied modifiers, delays triggered, event overrides; analytics on player behaviour vs weather.

## 56.7 Anti-Abuse
- No client control; server authoritative; replay prevention; forecasting limited to published window; no perfect foresight beyond UI forecast.
- Travel/crime rerolls not allowed to fish for better weather; actions use server state at start time.

## 56.8 Interactions
- Events: seasonal weather overlays; event missions require certain weather/time.
- Properties: climate control reduces comfort penalties; backup power mitigates blackouts (if modelled).
- Factions: wars affected by weather on sector map; intel tools may show forecast for targets.

## 56.9 Example Flows
- Fog night crime: stealth bonus; police patrols reduced; player succeeds; heat gain smaller; log shows fog modifier.
- Storm travel: train delayed; compensation issued; ambush risk increased; log recorded.
- Heatwave: energy regen -1 per hour; drink demand up; players receive warning; comfortable properties reduce penalty.

### For Architect GPT
- Weather/time service drives modifiers across systems; integrate with crimes, combat, travel, economy, NPCs, UI overlays. Ensure forecast and transitions centralized.

### For CodeGPT
- Implement weather state machine, forecast, per-region overrides, modifiers application per action, logging, UI APIs, and performance-friendly overlays. Enforce server authority; block rerolls; handle delay triggers.

### For BalanceGPT
- Tunables: modifier magnitudes per weather/time, frequency/duration, forecast window, delay/ambush rates. Keep variance meaningful but not crippling; avoid hard-locks.

### For QAGPT
- Test weather/time updates, modifier application across systems, forecast accuracy, delay/ambush triggers, UI chips/overlays, reduced-motion toggles, and anti-reroll enforcement. Validate logging and analytics.  
# SECTION 058 — SOUND DESIGN, AMBIENCE & AUDIO SYSTEM

## 57.0 Overview
Audio reinforces Dark Luxury and UK street ambience: rain, sirens, distant trains, club bass, construction, and UI cues. Must be optional, performance-friendly, and non-intrusive. No gameplay stats; purely UX.

## 57.1 Soundscape Layers
- Ambience: weather (rain, wind, thunder), city (sirens, trains, chatter), districts (market buzz, docks horns, nightlife bass), interiors (muffled crowd, HVAC).
- Events: war drums/alerts, faction captures, chain milestones, mission cues.
- UI: subtle clicks/hovers, notifications, toasts; no harsh tones; reduced-motion analog for audio (reduced audio intensity).

## 57.2 Contextual Audio
- Weather-driven sounds; day/night variants; location (borough/district) changes ambience; interiors reduce exterior noise.
- Crime/combat: muffled during stealth; louder impacts when needed; no advantage gained.
- Travel: departure/arrival chimes; delay alerts; smuggling routes have tense cues.

## 57.3 Controls & Accessibility
- Master, music/ambience, SFX sliders; mute toggle; per-channel mute; default low volume; off by default if needed for accessibility.
- Reduced-audio mode: minimal cues; no sudden loud sounds; crucial alerts use soft tones.
- Captions/subtitles for key cues (chain start, war alerts, delays); optional.

## 57.4 Performance & Delivery
- Streamed/looped lightweight files; device-cap; fallback to silence; no blocking loads.
- Prefetch common loops; lazy-load rare cues; cache-aware; mobile-friendly bitrates.

## 57.5 Anti-Abuse
- No information leaks via audio beyond displayed UI; no positional audio exploits.
- Rate-limit notification sounds; spam prevention; debouncing.

## 57.6 UI/UX
- Audio settings page; per-channel sliders; test button; Dark Luxury styling.
- Context indicator showing which ambience layer is active; optional display.

## 57.7 Example Flows
- Player in rain: ambient rain + distant traffic; reduced indoors; volume per user setting.
- War alert: soft drum cue + toast; caption if enabled; rate-limited.
- Travel delay: chime and toast; obeys SFX slider; caption available.

### For Architect GPT
- Audio system decoupled from gameplay; hooks for weather, location, events, and UI. Provide optional layers and accessibility controls.

### For CodeGPT
- Implement audio manager with channels, context switching, user settings, caching, captions, and rate limits. Integrate with weather/location/event hooks; ensure no gameplay logic depends on audio.

### For BalanceGPT
- None mechanically; ensure cues don’t imply mechanics; volumes and rates comfortable.

### For QAGPT
- Test audio controls, context switching, captions, rate limits, mobile performance, and default states. Ensure no info leak and that muted settings persist.  
# SECTION 059 — CLOTHING, OUTFITS & STREETWEAR SYSTEM (SUPPLEMENT)

## 58.0 Overview
Additional detail for clothing/streetwear to complement Section 053: deeper themes, borough sets, and market handling. All cosmetic; no stats.

## 58.1 Themes & Sets
- Borough sets: Brixton grime, Camden alt, Peckham bloc, Hackney docks, Towerblock night, North Circular drivers. Each set contains mix-and-match pieces.
- Lifestyle sets: nightlife luxe, underground fight club, courier, medic, techie, security, formal noir.
- Event sets: Halloween, Xmas, summer festival; limited-time reruns possible.

## 58.2 Rarity & Distribution
- Common → Rare → Epic → Legendary → TrenchMade (prestige). Rarity affects looks and availability, not power.
- Distribution: shops (common/rare), events (rare/epic), achievements/titles (legendary), prestige shop (TrenchMade).
- Duplicate protection: pity tokens for events to trade for missing items; cosmetic-only.

## 58.3 Market & Trading
- Cosmetics tradeable within bounds; price floors/ceilings to prevent laundering; rarity-aware fees.
- Listing UI shows preview; authenticity guaranteed (no counterfeits).
- Gifts allowed with cooldown; logs to prevent laundering via mass gifts.

## 58.4 Customization Rules
- Palette restricted per set for coherence; allow accent swaps; prevent unreadable combos.
- Masks/hoodies purely cosmetic; no stealth; crime systems ignore clothing.
- Gender/body neutral fits; adjustable sizing; accessibility: high-contrast variants for visibility.

## 58.5 UI/UX
- Wardrobe filters by theme, borough, rarity; previews with background; save loadouts.
- Event collection tracker; progress to pity token; Dark Luxury styling.
- Market listing preview; warning that items are cosmetic-only.

## 58.6 Anti-Abuse
- No stat effects; cannot spoof stealth; anti-laundering via price bounds and gift cooldowns; dupes tracked; trade logs immutable.
- Moderation: no offensive designs; report flow; strikes for violations.

## 58.7 Example Flows
- Player completes Peckham set: unlocks badge/title; no stats; market allows trades within bounds.
- Event pity: misses final Halloween piece; uses tokens to claim; collection complete; log recorded.
- Gift spree: attempts mass gifts flagged; cooldown enforced; trust score adjusted.

### For Architect GPT
- Cosmetic-only expansion for clothing/trade; integrate with identity, shop/market, moderation, and events.

### For CodeGPT
- Implement wardrobe expansions, event collections/pity tokens, market bounds for cosmetics, gift cooldowns, logging, moderation checks.

### For BalanceGPT
- Tunables: rarity drop rates, pity token thresholds, trade bounds/fees, gift cooldowns. Ensure cosmetics remain aspirational without economy abuse.

### For QAGPT
- Test set collection, pity redemption, market bounds, gift cooldowns, cosmetic-only enforcement, logging, and moderation/report flows.  
# SECTION 060 — FOOD, DRINKS & CONSUMABLES

## 59.0 Overview
Food and drinks provide small, bounded effects: happy tweaks, minor regen assists, and crash interactions. They support flavour, economy, and events. No pay-to-win; effects capped. Integrates with bars, property parties, events, and market.

## 59.1 Categories
- Food: meals, snacks, sweets; impacts happy modestly; some reduce crash severity; region-themed (UK fare).
- Drinks: soft drinks, coffee/tea, energy drinks (small energy), alcohol (happy up then crash to happy/nerve), event beverages.
- Buff items: minimal, time-limited bonuses (e.g., small regen bump); capped; no stacking beyond one buff; separate from drugs.

## 59.2 Effects & Crashes
- Happy boost: small; duration short; diminishing returns on spam; crash small drop to happy/regen.
- Energy/nerve: tiny boosts compared to drugs; cooldowns; stacking capped.
- Alcohol: happy up; accuracy down briefly; crash reduces happy/nerve slightly; addiction not modeled here (drugs handle addiction).
- Meals: property buff synergy (parties); reduce drug crash slightly if consumed before crash.

## 59.3 Legality & Availability
- Mostly legal; some event drinks restricted (age flavour only); no seizures.
- Sold in shops, restaurants (property/borough), events; crafted recipes optional; property kitchens can host meals/parties.

## 59.4 UI/UX
- Consumable cards: effect, duration, crash, cooldown, stack rules; tooltip; Dark Luxury visuals.
- Warnings on alcohol debuffs; limits shown; property party menus customizable.

## 59.5 Anti-Abuse
- Cooldowns; diminishing returns; cannot stack with drug buffs of same type; server authoritative; logs.
- No infinite loop with happy; caps enforce ceiling; feeding macros detected.

## 59.6 Economy
- Shops/market: price bounds; event items tradeable within bounds; trust influences fees.
- Property parties consume items; drives demand; catering services via companies.

## 59.7 Interactions
- Bars (Section 002): small boosts; crashes affect happy/regen briefly.
- Drugs (Section 024/029): meals can cushion crash slightly; not replace detox.
- Properties (Section 017/022): parties use food/drinks; happy synergy; staff can auto-serve.
- Events: themed foods/drinks; limited-time; collection achievements.

## 59.8 Example Flows
- Player drinks coffee: small energy; short duration; cooldown; crash negligible; log recorded.
- Party menu: owner sets items; guests gain happy; crash later; items consumed; logs.
- Alcohol: happy up; small accuracy penalty; crash minor; stacking blocked with stimulant drinks.

### For Architect GPT
- Consumable system for food/drinks with capped buffs/crashes, tied to bars, events, and properties. Keep separate from drug system.

### For CodeGPT
- Implement consumable templates, effects/crashes, cooldowns, stack rules, property party integration, logging, and price bounds. Enforce server-side application.

### For BalanceGPT
- Tunables: boost sizes, durations, crash sizes, cooldowns, price bounds, party effects. Keep minor vs drugs; prevent happy inflation.

### For QAGPT
- Test consumable use, cooldowns, stack rules, crashes, party flows, logging, market bounds, and interaction with drugs/bars. Validate alcohol debuff and warnings.  
# SECTION 061 — DRUGS SYSTEM (AAA EDITION, CONSOLIDATED)

## 60.0 Overview
Consolidates and extends drug rules from Sections 024/029: full category definitions, tolerance/addiction flows, rehab, and policing. Emphasizes UK street flavour, Dark Luxury UX, and high risk/high reward without meta-breaking.

## 60.1 Categories & Examples
- Stimulants: BlocRush, RailLine, DockSpark. Boost Speed/Dex/energy; legality: illegal; high crash/tolerance.
- Painkillers: Brickwall, Night Doc. Mitigation/recoil; moderate crash; some legal (prescription flavour).
- Hallucinogens: Neon Veil, Estate Trip. Crit/happy up, accuracy down; severe crash; high addiction.
- Performance blends: Obsidian Mix. Small boosts across stats/bars; high tolerance growth.
- Medical: MedPaks, antivirals; minimal crash; low tolerance; legal.
- Black-Market Specials: bespoke chems with strong boosts; heavy crash/addiction; illegal; bust risk.

## 60.2 Effects, Crashes, Tolerance, Addiction
- Effects: stat/bar boosts with fixed durations; stacking blocked per category (see Section 029 caps).
- Crashes: inverse effects; severity scales with tolerance; duration fixed per drug; can overlap if careless.
- Tolerance: category-based; grows per use; decays over time; reduces effect and increases crash.
- Addiction: triggered when tolerance high over window; applies ongoing debuffs (regen/stat penalties) until detox; visible status; influences crime/heat risk (erratic behaviour flavour).
- Overdose protection: server blocks excessive stacking; logs attempts; possible self-injury if forced via exploit; exploit attempts flagged.

## 60.3 Legality, Heat, and Enforcement
- Illegal drugs increase scan/police risk; seizures on travel scans (Section 016/036); fines/jail on bust; black-market rep loss.
- Public use may raise heat; faction wars may impose limits; hospital seizures on overdose.
- Quality impacts detection chance slightly; counterfeit increases crash/addiction.

## 60.4 Rehab & Detox
- Detox programs: time-based; reduce tolerance/addiction; apply temporary debuffs; cost cash/points; cannot be bypassed; logs.
- Rehab items: small tolerance reduction with cooldown; not instant cures.
- Medical roles (Section 014/031): reduce crash/addiction length slightly; improve rehab speed.

## 60.5 UI/UX
- Drug HUD: active effects/crashes, timers, category caps, tolerance/addiction meters; warnings for overdose risk.
- Use flow: confirmation with warnings; shows interaction with bars/stacking; crash preview; Dark Luxury styling.
- Rehab UI: progress, costs, debuffs; cooldown info.

## 60.6 Data & Logging
- Definitions: effects, durations, crashes, legality, quality ranges, caps; tolerance/addiction per player.
- Logs: consumption, effects applied, crashes, tolerance/addiction changes, seizures/busts, rehab sessions, blocked overdose attempts.
- Analytics: usage, addiction rates, overdose attempts; used for tuning.

## 60.7 Anti-Abuse
- Category caps enforced; cooldowns; diminishing returns; tolerance prevents infinite gains; anti-automation (rate limits, nonces).
- Counterfeit farming blocked via drop rates and seizure; laundering via drug trades limited by price bounds and logs.

## 60.8 Interactions
- Combat/Crimes: boosts/crashes affect stats/bars; illegal possession increases heat/jail odds; black ops may require specific drugs.
- Bars: energy/nerve/happy affected; crashes reduce regen; meals can cushion crash slightly (Section 060).
- Properties: comfort reduces crash severity; med rooms aid detox; parties can affect happy and minor drug crash mitigation.
- Factions: war rules may cap drug use; faction perks may reduce crash slightly; abuse detection across members.

## 60.9 Example Flows
- Player uses BlocRush: Speed/Dex/energy up; tolerance rises; crash later; heat risk if caught; logs; tolerance meter updates.
- Addiction: tolerance high; addiction debuff applied; rehab started; cooldown; logs; debuff cleared on completion.
- Seizure: travel scan finds chems; seized; fine/jail; black-market rep down; log; tolerance unaffected.

### For Architect GPT
- Unified drug spec with legality, tolerance/addiction, rehab, and enforcement. Integrates with bars, combat, crimes, travel/scans, properties, factions, and black market.

### For CodeGPT
- Implement drug manager with caps, effects/crashes, tolerance/addiction, overdose blocks, rehab flows, legality checks, logging. Enforce server authority and rate limits.

### For BalanceGPT
- Tunables: effect sizes/durations, crash severity, tolerance growth/decay, addiction thresholds, rehab costs/duration, seizure odds, heat impacts. Keep drugs impactful but risky; prevent meta dominance.

### For QAGPT
- Test use/caps, effect/crash timing, tolerance/addiction progression, rehab, seizures/busts, blocking overdose, logging, UI warnings, and interactions with bars/combat/crimes.  
# SECTION 062 — JOBS, WORKING STATS & UK INDUSTRIES (SUPPLEMENT)

## 61.0 Overview
Supplement to Sections 004/014/022/032: emphasises UK industries, advanced shifts, compliance, and anti-abuse for jobs and working stats.

## 61.1 UK Industry Focus
- Sectors: NHS/Clinic, Met Security, Logistics/Transport, Construction, Nightlife/Hospitality, Tech/Cyber, Legal/Finance, Media/PR, Rail/Infrastructure, Retail.
- Region flavour: certain roles pay/perform better in specific boroughs/regions (e.g., rail roles in Manchester/Glasgow lines).
- Compliance flavor: background checks for legal roles; underground roles prefer “dirty” history.

## 61.2 Advanced Shifts
- Multi-step shifts: prep + action + wrap-up; higher reward/XP; failure states logged.
- Hazard shifts: higher risk/reward; safety gear reduces incident chance; incident → injury/hospital and morale hit.
- Overtime with scaling risk; capped per day; diminishing returns.

## 61.3 Working Stat Gains & DR
- MAN/INT/END gains per shift; DR per day to prevent macro; variety bonus for mixing roles; weekly bonus for multi-sector experience.
- Education synergy: related courses boost gains or reduce incident chance.

## 61.4 Compliance, Safety & Incidents
- Safety incidents logged; reduce morale/reputation; fines if negligence; repeat incidents trigger audits.
- Compliance checks: fail blocks shift; illegal items trigger penalties in legal jobs.
- PPE items (cosmetic flavour) reduce incident chance; no stat changes beyond shift safety modifiers.

## 61.5 Promotions & Performance
- Metrics: attendance, success rate, incidents, stats, reputation; thresholds for promotions; demotions for inactivity/performance.
- Performance reviews: periodic; apply bonuses or warnings; affect wages and role eligibility.

## 61.6 Anti-Abuse
- Shift spam: cooldowns; DR; captcha if botting suspected; IP/device checks.
- Wage laundering: price bounds, escrow for contracts; audit logs; pattern detection for hire/fire loops.
- Incident farming: reduced gains after repeated intentional fails; flags to moderation.

## 61.7 UI/UX
- Job board with risk/reward indicators, compliance needs, location bonuses, incident history; Dark Luxury styling.
- Shift detail: steps, time, rewards, risk, required stats/gear; warnings; cooldown displayed.
- Performance panel: stats, promotion needs, incidents, morale.

## 61.8 Interactions
- Companies: advanced shifts feed working stats and morale (Section 032); companies prefer candidates with strong records.
- Factions: roles may grant small faction respect for supplying services; contracts possible.
- Travel: region-specific bonuses; strikes/events affect job availability; delays reduce shift success.

## 61.9 Example Flows
- Hazard shift in construction: requires PPE; higher pay; incident chance; player succeeds; gains MAN; morale up; log recorded.
- Background check fail: player with high heat/illegal items denied shift; cooldown applied; compliance log.
- Variety bonus: player rotates sectors; weekly bonus to working stats; logged.

### For Architect GPT
- Adds advanced shift/compliance layer to jobs system. Integrate with working stat service, incidents, education, and economy.

### For CodeGPT
- Implement multi-step shifts, hazard/incidents with logs, DR and variety bonuses, compliance checks, performance reviews, and anti-abuse. Tie into jobs UI and logs.

### For BalanceGPT
- Tunables: shift rewards, hazard risks, incident penalties, DR curves, promotion thresholds, compliance strictness. Balance earnings vs crimes; keep legal paths viable without eclipsing criminal play.

### For QAGPT
- Test shift flows, incidents, DR application, variety bonus, compliance checks, promotions/demotions, anti-abuse triggers, logging, and UI warnings. Validate region bonuses and event/strike effects.  
# SECTION 063 — PLAYER-RUN COMPANIES (UK GANG FRONTS • LEGIT BUSINESSES • INDUSTRY)

## 62.0 Overview
Expanded player-run company rules: fronts vs legit, audits, contracts, fraud prevention. Complements Sections 014/022/032/034/062.

## 62.1 Company Archetypes
- Legit: Medical, Transport, Security, Tech, Media, Hospitality, Retail, Manufacturing.
- Fronts: cover for illicit operations (black market logistics, chem labs); higher profit variance; high heat; audit risk.
- Hybrid: legit services with optional grey-area add-ons; require compliance toggles to avoid accidental illegality.

## 62.2 Front Mechanics
- Hidden illegal lines (smuggling, counterfeit, illicit repairs). Access locked behind rep/level; toggled by owner; risk spikes heat/seizure; illegal revenue cannot exceed set ratio to prevent full-crime companies.
- Raids/audits: random or triggered by heat/incidents; seizures, fines, jail; reputation hit; logs.
- Laundering safeguards: revenue caps, tax, escrow, price bounds; IP/device checks on buyers.

## 62.3 Contracts & Services
- Services: revives, repairs, transport, intel, catering, security escorts; defined SLAs; escrow; penalties for breach.
- Goods: production with quality/defect rates; QA and recalls; front goods may be illegal variants with higher margin and risk.
- Wholesale/retail flows; faction/ally pricing; trust affects fees.

## 62.4 Compliance & Reputation
- Compliance level: scale from clean to dirty; affects scan risk, audit frequency, access to certain clients.
- Reputation (public) and Underworld rep (for fronts); separate scores; actions change both; some clients require clean rep.
- Blacklist/whitelist: restrict customers; reduce scam risk; may lower revenue.

## 62.5 Staffing & Roles
- Roles: Owner, Director, Manager, Staff. Permissions for contracts, payroll, inventory, illegal toggles, upgrades.
- Morale/reputation ties: illegal busts harm morale; legit wins improve; staff may quit if too dirty (unless underground perks).

## 62.6 Audits & Raids
- Triggers: heat, repeated incidents, price anomalies, reports. Outcomes: fines, seizures, temporary shutdown, arrests.
- Mitigation: compliance investments, legal counsel (service), insurance for legal goods (not illegal), cooperation reducing penalties.

## 62.7 Anti-Abuse
- Laundering detection: price bounds, revenue caps, escrow, IP/device correlation, audit logs, freezing suspicious flows.
- Contract fraud: escrow; dispute resolution; repeated bad faith lowers rep; possible shutdown.
- Supply duplication/exploit detection; stock reconciliation; immutable logs.

## 62.8 UI/UX
- Company panel: legal/illegal toggles (fronts), compliance meter, reputations, contracts, inventory, SLAs, audits, alerts.
- Logs: services delivered, contracts, audits/raids, revenue, disputes, rep changes.
- Warnings: when illegal revenue high, audit risk, SLA at risk; Dark Luxury styling.

## 62.9 Interactions
- Black market: fronts supply/repair illegal items; rep tied to Section 029; busts reduce underworld rep.
- Factions: contracts to supply; fronts may help black ops; heat shared if caught.
- Jobs: staff drawn from working stats; legal roles require clean record; underground roles prefer dirty record.
- Properties: workshops/warehouses; security reduces raid risk slightly.

## 62.10 Example Flows
- Transport front: legal courier with hidden smuggling; heat rises; audit triggers; illegal stock seized; fine; underworld rep drops; public rep tanks.
- Legit media company: high reputation; contracts with factions for ads; audits rare; revenue steady.
- Contract fraud attempt: overpriced contract flagged; escrow holds; account investigated; rep drop; possible shutdown.

### For Architect GPT
- Company fronts vs legit, with compliance/audits and dual reputation. Integrate with economy, black market, factions, jobs, and logging.

### For CodeGPT
- Implement company archetypes with legal/illegal toggles, dual reputation, audit/raid system, contract SLAs, escrow, price bounds, laundering detection, and logs. Permissions per role; anti-abuse enforcement.

### For BalanceGPT
- Tunables: illegal revenue caps, audit frequency, penalties, compliance investments, rep gain/loss, contract fees, price bounds. Keep illegal fronts high risk/high variance; legit steady and safer.

### For QAGPT
- Test legal/illegal toggles, revenue caps, audits/raids, contract SLA flows, escrow, reputation changes, fraud detection, logging, and UI warnings. Validate anti-laundering and price bounds.  
# SECTION 064 — PROPERTIES, HOUSING & ENDGAME COUNTRY OWNERSHIP

## 63.0 Overview
Endgame property layer beyond city estates: country properties and national estates. Complements property sections (017/022/035/041/045). Focus on prestige, travel, upkeep, and risk; no game-breaking power.

## 63.1 Country Properties
- Types: countryside manor, coastal villa, island lodge (event), highland retreat. One active country property per account to prevent stacking.
- Acquisition: prestige tokens + large cash; gated by level/rank; escrow; cooldown on transfers.
- Bonuses: large happy cap, modest regen QoL; travel convenience (minor reduction for certain routes); prestige titles/frames. No combat/crime buffs.
- Upkeep: high recurring cost; missing payments reduces bonuses and can trigger foreclosure; taxes apply.

## 63.2 Travel & Access
- Travel required to visit; timers similar to regional travel; fast lane from helipad/airstrip on property; guests need invite; actions limited if not on-site.
- Storage: stash with high capacity; illegal items allowed but high raid risk; insurance void for illegal.

## 63.3 Security & Raids
- Security tiers: private security, surveillance, safe rooms; reduce burglary/raid odds; diminishing returns.
- Raid triggers: illegal storage, high heat, events; outcomes: seizures, fines, jail; prestige hit.
- Insurance: legal items only; high premiums; claims logged; cooldown between claims.

## 63.4 Staff & Services
- Staff: groundskeeper, chef, security, pilot/driver; wages high; morale affected by pay/safety; improves QoL bonuses (comfort, travel convenience).
- Guests: invite friends/faction; permission controls; logs; guest stays may affect heat slightly if high-heat guests present.

## 63.5 Prestige & Cosmetics
- Visual customizations: regional themes, Dark Luxury estate skins; titles/frames; leaderboards for prestige (cosmetic).
- Events: country property events (garden parties) with temporary happy buffs and crashes; logs.

## 63.6 Anti-Abuse
- One country property cap; cooldown on sale/purchase; escrow; price bounds; alt detection; tax to deter flipping.
- Laundering through property trades blocked; stash abuse monitored; raid cooldowns to prevent exploit.

## 63.7 UI/UX
- Country estate panel: location, travel, upkeep timer, staff, security, stash, permissions, heat risk, prestige score.
- Warnings: upkeep due, raid risk, illegal storage, guest heat.
- Logs consolidated; Dark Luxury styling; unique backgrounds.

## 63.8 Interactions
- Travel: travel perks minor; obey timers; no teleport; smuggling risk remains.
- Factions: can host meetings; no war shelters; high-heat guests raise risk.
- Economy: high upkeep sinks; staff wages; insurance costs; prestige tokens tied to progression/events.

## 63.9 Example Flows
- Player buys highland retreat: pays tokens+cash; upkeep set; travel required to access stash; happy high; raid risk if illegal stash; logs.
- Missed upkeep: bonuses reduced; warning; foreclosure after grace; stash moved or seized (illegal seized); prestige lost.
- Raid: illegal goods trigger raid; seizure; fine/jail; insurance void; log and heat spike.

### For Architect GPT
- Endgame property layer with country estates, prestige tokens, travel, security, and raids. Integrate with property core, travel, heat/raids, and progression.

### For CodeGPT
- Implement country property purchase/transfer with cap/escrow/cooldown, upkeep/tax timers, travel gating, staff/security, stash, insurance, raid logic, logging, and anti-abuse. UI with warnings and prestige.

### For BalanceGPT
- Tunables: token/cash cost, upkeep/tax, happy cap, regen QoL, raid odds, insurance premiums, cooldowns, one-property cap enforcement. Keep prestige meaningful but balanced.

### For QAGPT
- Test purchase/sale with cap, travel access, stash capacity and legality, upkeep/foreclosure, raid triggers, insurance, staff effects, logging, and warnings. Validate anti-flip and alt detection.  
# SECTION 065 — FACTIONS, GANGS & WARFARE (SUPPLEMENT)

## 64.0 Overview
Adds gang flavour and warfare variants to faction systems (Sections 012/028/033). Focus on gang hierarchy, recruitment, turf skirmishes, and anti-boosting.

## 64.1 Gang vs Faction
- Gangs: smaller crews, borough-tied; lower entry requirements; simpler upgrades; can graduate into full factions.
- Factions: larger, sector control, full respect/war system.
- Migration: gang can convert to faction by meeting respect/size thresholds; logs.

## 64.2 Turf Skirmishes
- Lightweight wars between gangs over streets/district tiles; shorter timers; rewards: small cash/respect, minor buffs.
- Attack windows; heat influences patrol presence; weather/time applies.
- Logs to city feed; anti-boost rules same as factions.

## 64.3 Gang Upgrades & Economy
- Cheaper, fewer tiers: small regen buffs, minor chain timer, limited armory, small med buff.
- Income from small protection rackets/OC cuts; capped to avoid farm.
- Respect gain scaled down; decay slower to help small crews.

## 64.4 Recruitment & Roles
- Roles: Leader, Lieutenant, Member, Prospect. Permissions simplified.
- Applications: faster; background checks lighter; deserter flags still apply.
- Promotions: quicker but still logged; quotas enforced.

## 64.5 Anti-Abuse
- Boosting detection: same-target/IP scaling; respect throttled; deserter penalties for war dodging.
- Chain padding: hospital/travel targets devalued; repeated hits reduced.
- War hopping: cooldown after leaving gang mid-war; respect fine; temp lockout.

## 64.6 Diplomacy Lite
- States: Neutral, Rival, Truce. Simple cooldowns; betrayal penalty.
- No complex treaties; meant for fast-paced skirmishes.

## 64.7 UI/UX
- Gang panel: respect, upgrades, turf tiles, skirmish status, chain info, logs.
- Skirmish UI: targets, timers, rewards; map overlay; weather/heat chips.
- Upgrade view simplified; clear scaling to faction path.

## 64.8 Interactions
- Gangs can ally with factions; mentorship; eventual absorption.
- Turf skirmish outcomes can raise/lower heat in districts; impacts crimes.
- OCs/black ops limited to small versions; rewards scaled.

## 64.9 Example Flows
- Gang turf clash: quick war over street; attacker wins; small respect; heat up; log; cooldown.
- Gang upgrades: buys minor regen buff; chain timer slightly extended; logs.
- Gang promotes to faction: meets thresholds; converted; retains members/respect; gains access to full systems.

### For Architect GPT
- Gang layer sits below factions, sharing war/respect infrastructure but scaled. Integrate with maps, heat, and crimes.

### For CodeGPT
- Implement gang entity with simpler upgrades, turf skirmishes, lite diplomacy, migration to faction, anti-boost, and logging. Use shared war/chain engines with scaled values.

### For BalanceGPT
- Tunables: skirmish rewards/timers, upgrade costs/effects, respect scaling, migration thresholds, anti-boost scaling. Keep gangs viable onboarding to factions without exploit loops.

### For QAGPT
- Test gang creation/migration, skirmish start/resolve, respect gains/decay, upgrades, anti-boost, deserter handling, UI overlays, and logging. Validate heat impacts from skirmishes.  
# SECTION 066 — CRIMES 1.0 + CRIMES 2.0 (UK STREET EDITION)

## 65.0 Overview
Combined crime specification covering base crimes (1.0) and deeper crimes (2.0). Builds on Section 009 with category detail, difficulty scaling, blue stars, and anti-farm rules. UK street flavour; Dark Luxury UI; server authoritative.

## 65.1 Crime Categories (1.0/2.0)
- Pickpocketing, Shoplifting, Vandalism, Mugging, Burglary, Car Theft, Fraud/Scams, Cyber Crimes, Smuggling, Robberies (stores/banks), Kidnap/Ransom, Organized Crimes (OCs), Black Ops (faction).
- Each crime has difficulty bands, nerve cost, heat gain, jail/hospital risks, loot tables, and blue star rare outcomes.

## 65.2 Difficulty & Success
- Success formula uses nerve, working stats, battle stats for violent crimes, tools, education, location/weather/heat. Minimum fail chance always present.
- Difficulty scales with player level/rank bands; some crimes fixed; blue star requires high success roll + rare trigger.
- Police heat: raises failure/jail odds; lowers rewards if excessive; decays with time.

## 65.3 Tools & Prereqs
- Lockpicks, jammers, disguises, burners, forged IDs, vehicles; quality affects odds and failure consequences.
- Education unlocks advanced crimes; faction/company perks small bonuses; location/time/weather modifiers.

## 65.4 Rewards & Blue Stars
- Rewards: cash, items, XP, points (rare), crime stars/achievements; blue star gives unique log and extra reward.
- Diminishing returns on rapid repeats of same crime; XP/loot scaled down; heat scaled up for spam.

## 65.5 Jail & Hospital
- Jail from failures; duration scales with severity/heat; busts allowed with energy; bust failure adds heat/jail time.
- Hospital from violent backfires; duration scales with damage; mitigated by armor/defense.

## 65.6 Logs & UI
- Crime UI: categories, requirements, estimated risk band, potential rewards band, heat impact, tool selection; location/weather chips.
- Logs: outcome, heat change, tools used, rewards, jail/hospital timers; blue star noted; heat decay separate.

## 65.7 Anti-Abuse
- Spam detection: diminishing returns; captchas on patterns; IP/device correlation; staged crimes flagged.
- Tool dupe checks; illegal item seizures; location validation; server authority.
- OCs require unique participants to prevent solo spam; role checks enforced.

## 65.8 Example Flows
- Shoplifting in rain: visibility lower; success up slightly; reward modest; heat +small; log.
- Car theft with jammer: success; vehicle gained; heat significant; failure → jail longer; tool consumed if failed.
- Blue star: rare on high-difficulty fraud; extra cash/item; log shows star; XP bonus; cooldown unaffected but DR still applies.

### For Architect GPT
- Crime combined spec: categories, tools, heat, scaling, blue stars. Integrates with heat/weather, tools/inventory, education, factions/OCs, and logging.

### For CodeGPT
- Implement crime definitions with bands, success formula, tool use, blue star triggers, diminishing returns, heat/jail, logging. Enforce server authority and anti-abuse; UI endpoints for requirements and risk bands.

### For BalanceGPT
- Tunables: nerve costs, success weights, heat gain/decay, jail times, loot tables, blue star rates, DR thresholds. Balance risk/reward; keep fail chance; deter spam.

### For QAGPT
- Test crime outcomes across bands, tool effects, heat changes/decay, jail/hospital timers, blue star logging, DR on repeats, anti-abuse triggers, and UI risk bands.  
# SECTION 067 — DRUGS • ADDICTION • WITHDRAWAL • REHAB (DEEP DIVE)

## 66.0 Overview
Deep dive into addiction/withdrawal/rehab, complementing Sections 024/029/060. Focus on states, timers, UI, and policing.

## 66.1 States
- Clean: no addiction/tolerance beyond baseline.
- Tolerant: reduced effect; increased crash; no ongoing debuff.
- Addicted: active debuff (regen/stat penalty); withdrawal risk if abstaining.
- Withdrawal: harsher debuff if addicted and off drugs; resolves via time or rehab; cannot be bypassed quickly.

## 66.2 Triggers & Thresholds
- Tolerance accrues per category; addiction triggers when rolling average exceeds threshold; logged.
- Withdrawal triggers after addiction if no use for set time; duration fixed; can be shortened by rehab.

## 66.3 Effects
- Addiction debuff: reduced happy regen, small stat penalty, minor energy/nerve regen penalty; visible status.
- Withdrawal debuff: stronger penalties; possible temporary action cooldown (crimes) to simulate impairment; no hard locks.
- Rehab debuff: temporary stat/regen penalty while in program; clears addiction on completion.

## 66.4 Rehab & Treatment
- Programs: durations based on addiction severity; costs; cooldown between programs; progress tracked.
- Items: mild withdrawal relief; cooldown; no instant cure.
- Medical assist: medics/education reduce duration/penalties slightly.
- Failure: quitting rehab early restores addiction; cooldown before retry; logged.

## 66.5 Policing & Heat
- Addicted status may increase chance of police attention in some crimes (flavour); small effect; not punitive.
- Hospital overdoses log addiction; could increase scan frequency temporarily.

## 66.6 UI/UX
- Status chips for Tolerant/Addicted/Withdrawal/Rehab with timers and effects; tooltips.
- Rehab UI: progress bar, remaining time, debuff summary, exit (with warning).
- Warnings before drug use if near addiction; suggest rehab; show cooldown.

## 66.7 Anti-Abuse
- No benefit from staying addicted; debuffs only. Prevents cycling to exploit buffs; server enforces.
- Rehab speed-ups limited; cooldowns; anti-macro on drug use with nonces and rate limits.

## 66.8 Interactions
- Crimes/combat: debuffs reduce performance; ensure visible; cannot be hidden.
- Properties: comfort reduces withdrawal penalty slightly; med rooms accelerate rehab; not a full cure.
- Factions: war rules may cap drug use; addiction debuff still applies; no exemption.

## 66.9 Example Flows
- Player abuses stims: hits addiction; debuff applied; prompted for rehab; rehab started; timer; debuff clears after completion.
- Withdrawal: player stops using; withdrawal debuff kicks; crime success lower; rehab shortens duration.
- Rehab quit: player exits early; addiction persists; cooldown before new program; log recorded.

### For Architect GPT
- Addiction/withdrawal subsystem with states, timers, and rehab. Integrate with drug manager, UI, and policing/heat hooks.

### For CodeGPT
- Implement state tracking, thresholds, debuffs, rehab flows, cooldowns, warnings, logging, anti-macro. Ensure server authority and persistent timers.

### For BalanceGPT
- Tunables: thresholds, debuff magnitudes, rehab durations/costs, withdrawal penalties, cooldowns. Keep drugs risky; rehab meaningful but not abusable.

### For QAGPT
- Test addiction progression, withdrawal triggering, rehab start/complete/quit, debuff application, UI timers, warnings, anti-macro, and interactions with combat/crimes.  
# SECTION 068 — GYM, TRAINING, MUSCLE GROUPS, 25+ GYMS

## 67.0 Overview
Extended gym content with multiple gyms, muscle-group flavour, and wider variety. Complements Sections 008/024/025/026.

## 67.1 Gym Network
- 25+ gyms across boroughs/regions; each themed; tiered access by stats/level; memberships; guest passes.
- Specialty gyms: boxing, calisthenics, powerlifting, agility, stealth; flavour differences; small focus bias only.
- Traveling gyms: limited-time pop-ups during events; cosmetics; same math.

## 67.2 Muscle Groups & Flavour
- Flavour-only muscle groups (arms, legs, core) map to battle stats (Str/Spd/Def/Dex) for immersion; no extra complexity to math.
- Training descriptions reference groups; logs show flavour; stats still four core battle stats.

## 67.3 Training Variety
- Exercises per gym: categorized by focus; same gain formula; variety bonus for mixing exercises; DR still per stat.
- Coaches/NPCs: optional paid sessions for minor projection bonus; limited per day; logged.

## 67.4 Events & Challenges
- Gym events: limited-time boosted gains (small), leaderboards for volume (cosmetics), spar tournaments; anti-boosting enforced.
- Challenges: daily/weekly goals for sets; rewards cosmetics/XP; capped; no stat inflation.

## 67.5 Anti-Abuse
- DR per stat; session DR; rate limits; captcha if bot pattern; membership/guest pass binding; nonces.
- Leaderboard anti-cheat: detect macro; require diverse exercises; same-IP throttling.

## 67.6 UI/UX
- Gym finder: shows gyms, tiers, perks, costs, travel; recommended based on stats.
- Exercise list with focus tags; projected gains; DR indicator; buffs/debuffs; happy multiplier.
- Event panels; challenge progress; logs of sessions with flavour.

## 67.7 Example Flows
- Player joins boxing gym: focus Str/Spd; trains; gains per standard formula; coach session adds small bonus; log recorded.
- Challenge: complete 10 sets mixed; reward cosmetic wrap; no stat boost; DR unaffected beyond normal.
- Event pop-up gym: cosmetic badge; standard gains; expires after event; logs.

### For Architect GPT
- Extend gym service with multi-gym content, exercises, challenges, and events. Keep math consistent; flavour rich.

### For CodeGPT
- Implement gym catalog, exercise tagging, variety bonuses, event/challenge tracking, coach sessions, membership handling, logging, anti-cheat.

### For BalanceGPT
- Tunables: gym access thresholds, membership costs, variety bonus size, event boost size, challenge rewards, coach bonus. Keep gains bounded by DR.

### For QAGPT
- Test gym selection, exercise flows, DR application, variety bonus, coach sessions, event/challenge tracking, anti-bot, logging, and UI indicators.  
# SECTION 069 — CRIMES 3.0: BLACK OPS, FRAUD SYNDICATES, HIGH-LEVEL CRIME

## 68.0 Overview
High-end crime content beyond base crimes: black ops, fraud syndicates, and elite heists. Integrates with factions, black market, and heat/policing. High risk/high reward; strong anti-abuse.

## 68.1 Black Ops (Faction)
- Targets: enemy factions, sectors, infrastructure. Objectives: sabotage upgrades, steal intel, disrupt chains, plant false flags.
- Requirements: faction role, level/rank, nerve+energy, tools (jammers, forged IDs), team composition.
- Phases: planning (assign roles/tools), execution (server-resolved), escape. Cooldowns; minimum fail chance.
- Rewards: respect, intel, rare items; failure penalties: heat spike, jail/hospital, respect loss, alert enemy.
- Visibility: faction logs; enemy notified on fail/partial; city feed redacted.

## 68.2 Fraud Syndicates
- High-end fraud crimes: bank wire scams, corporate hacks, investment fraud. Require high INT/education/tools; high nerve cost.
- Risks: large jail times, heat spikes, asset seizure (cash/items); possibility of multi-stage missions; boss-like NPC counters.
- Rewards: large cash/points; unique achievements; diminishing returns; anti-farm detection.

## 68.3 Elite Heists
- Faction/crew-based; large prep: gather tools, scout (mission stages), disable security (tech crimes), execute robbery.
- Roles: leader, hacker, muscle, driver; stat requirements; multi-stage timers.
- Outcomes: big payouts or big failures; high jail/hospital risk; police pursuit events.
- Cooldowns: long; lockout per player/crew; logs.

## 68.4 Heat & Policing
- Black ops and elite crimes trigger high heat; police response increases; random patrol events; temporary heat debuff to crime success.
- Countermeasures: bribery (limited), legal cover (temporary; expensive); not guaranteed; logs.

## 68.5 Anti-Abuse
- Solo abuse blocked: minimum team/role diversity; unique IP/device checks; diminishing returns on repeats; cooldowns; staged farm detection.
- Tool dupe/cheap spam prevented; costs meaningful; failure penalties significant.
- Respect/loot scaling reduced for linked accounts; moderation flags for suspicious patterns.

## 68.6 UI/UX
- Black ops dashboard: objectives, roles, requirements, timers, risk bands, rewards; Dark Luxury styling; warnings.
- Heist planner: stage progress, tools checklist, cooldowns; invites; logs.
- Fraud UI: risk/reward band, tools needed, nerve cost, heat impact, potential seizures.

## 68.7 Logging & Data
- Records: ops/heists attempts, teams, roles, tools, outcomes, heat changes, loot, cooldowns, alerts sent.
- Analytics: success rates, failure causes, heat impact; used for tuning and anti-abuse.

## 68.8 Example Flows
- Black op sabotage: team plants device in enemy sector; success reduces enemy upgrade; heat spike; enemy notified; logs; cooldown.
- Fraud run: corporate hack with high INT; success yields big cash; failure → big jail/asset seizure; heat up.
- Elite heist: multi-stage bank robbery; planner sets roles; execution succeeds; large payout; long cooldown; respect gain; police attention.

### For Architect GPT
- High-level crime layer for factions/crews with multi-stage ops, high stakes, and strict anti-abuse. Integrates with factions, black market, heat, policing, and logging.

### For CodeGPT
- Implement black ops/fraud/heist definitions, requirements, multi-stage flows, role checks, cooldowns, heat/police responses, seizures, logging, anti-boost detection. Server-side resolution; UI dashboards.

### For BalanceGPT
- Tunables: rewards, cooldowns, success weights, heat penalties, seizure amounts, team size/roles, diminishing returns. Keep lucrative but risky; prevent farm and abuse.

### For QAGPT
- Test role enforcement, multi-stage progression, cooldowns, heat/police reactions, seizure penalties, logging, anti-boost detection, and UI warnings. Validate failure modes and alerts.  
# SECTION 070 — NPC GANGS 2.0

## 69.0 Overview
Expanded NPC gang system: territories, behaviours, escalation, and interactions with player crimes/factions. Integrates with world/heat (Section 013), crimes (Section 009/065/068), and factions (Section 065).

## 69.1 Territories & Presence
- NPC gangs own streets/estates; presence measured per district; affects crime odds, NPC spawns, and random encounters.
- Territory shifts dynamically with player actions/events; heat can attract/repel gangs.
- Gang density influences patrol responses; high gang presence reduces police patrol slightly but increases ambush risk.

## 69.2 Behaviour & Escalation
- States: Passive, Alert, Hostile. Changes with player actions (attacks, crimes, helping rival gangs, boss kills).
- Escalation: repeated hits raise hostility; gang retaliations (ambushes); temporary truce possible via missions.
- Boss fights: defeat reduces presence; triggers cooldown; boss respawns after timer.

## 69.3 Interactions with Crimes/Black Ops
- Crimes in gang turf: modifiers to success/heat; gangs may intervene; demand cuts (reduced payout) if hostile.
- Black ops/faction wars: gangs can be hired (missions) or oppose factions; affects respect/heat.
- Smuggling routes: gang-controlled docks/streets can increase or reduce risk depending on rep.

## 69.4 Reputation & Missions
- Rep per gang; actions adjust; high rep grants discounts/intel/missions; low rep triggers ambush; neutral is safest.
- Missions to aid/attack gangs; outcomes shift territory; reward items/rep; logged.

## 69.5 Loot & Economy
- Gang drops: crime tools, cash, low-tier weapons; rare gang-branded cosmetics; diminishing loot on farm.
- Economy: gangs influence black-market stock availability regionally; hostile gangs increase prices/heat.

## 69.6 UI/UX
- Gang overlay on map: presence/hostility per district; tooltips with modifiers.
- Reputation panel: standings, benefits/penalties, missions available; hostility timer.
- Encounter logs: ambushes, demands, boss fights; outcomes.

## 69.7 Anti-Abuse
- Farming: diminishing returns; cooldown on bosses; ambush exploit prevention; IP/device correlation for botting.
- Territory manipulation exploits blocked; server authoritative; randomization to prevent predictable loops.

## 69.8 Example Flows
- Player commits crimes in hostile turf: reduced payout; ambush chance; heat adjusted; log.
- Player raises rep via missions: gains intel discounts; ambush chance lowered; map shows improved standing.
- Boss defeat: gang presence drops temporarily; loot gained; boss lockout; gang hostility increases short-term.

### For Architect GPT
- NPC gang layer interacts with crime, black market, factions, and world heat. Needs territory tracking, rep, and dynamic modifiers.

### For CodeGPT
- Implement territory presence, gang states, rep changes, ambush/encounter triggers, boss timers, map overlays, logging, anti-farm. Tie into crime and black ops flows.

### For BalanceGPT
- Tunables: presence effects, ambush odds, rep thresholds, loot tables, boss lockouts, payout modifiers, price impacts. Keep gangs impactful but not oppressive; avoid farm loops.

### For QAGPT
- Test presence/hostility changes, crime modifiers in turf, ambush triggers, rep changes, boss lockouts, loot DR, map overlays, and anti-abuse detection. Validate logs and UI warnings.  
# SECTION 071 — INFORMANT SYSTEM 2.0

## 70.0 Overview
Informants provide intel on crimes, gangs, factions, and police activity. They act as a bridge between players and world state. Must be risk-based, logged, and resistant to abuse. Integrates with heat, crimes, factions, and black market.

## 70.1 Informant Types
- Street Informants: low-level intel (police patrols, crowd density); inexpensive; unreliable; may betray.
- Gang Insiders: intel on NPC gang hostility, turf changes; moderate cost; requires rep.
- Faction Moles: intel on enemy faction war plans/chain timing/sector status; high cost; risk of exposure.
- Black Market Brokers: intel on vendor stock, bust/sting risk; costs cash/points; illegal; heat risk.

## 70.2 Acquisition & Trust
- Found via missions, events, or purchased intros; require rep/level; trust score per informant based on history.
- Betrayal chance: low-trust informants may feed bad intel or leak to police; chance reduced as trust rises.
- Upkeep: some require periodic payments; neglect reduces trust; betrayal more likely if unpaid.

## 70.3 Intel Types & Uses
- Police: patrol routes, scan intensity, temporary heat modifiers, raid windows.
- Crimes: best streets/boroughs by time/weather; risk bands; recommended tools.
- Factions: sector weaknesses, war windows, chain readiness (approx), armory hints; never exact numbers to avoid imbalance.
- Black Market: vendor locations/times, stock hints, sting likelihood.
- NPC Gangs: hostility levels, boss respawn timers, ambush risks.

## 70.4 Delivery & Timers
- Intel delivered via messages/logs; expires after timer; stale intel risky.
- Cooldowns per informant; cannot spam queries; cost per pull; server authoritative.

## 70.5 Risk & Exposure
- Using informants can raise heat if caught; exposure chance based on trust, repeated use, and heat.
- Enemy factions can plant false intel (rare, high cost); flagged to prevent abuse; logs.
- Betrayal consequences: misinfo, increased heat, ambush, or police sting; logged.

## 70.6 UI/UX
- Informant panel: list, trust, cost, cooldown, intel categories; warnings on trust/heat; expiry timers.
- Intel display: concise bullet with timestamp and expiry; risk band; not exact numbers.
- Dark Luxury styling; alerts for betrayals/expired intel.

## 70.7 Anti-Abuse
- Rate limits; cost per intel; diminishing returns; trust decay on spam; IP/device correlation for informant farming; anti-fake intel spam.
- Faction moles limited; high cost; cooldown; logs to moderation; anti-alt.

## 70.8 Logging & Data
- Tables: informants, trust, intel pulls, outcomes, betrayals.
- Logs: intel requests, content, expiry, costs, heat changes, betrayal events; accessible to moderators.

## 70.9 Example Flows
- Player pays street informant: gets patrol intel; expires in 15m; trust up slightly; heat unchanged.
- Faction mole intel: cost high; reveals enemy chain window approx; betrayal chance; logs; cooldown applied.
- Broker sting: player buys black-market intel; broker compromised; heat spike; ambush; log recorded.

### For Architect GPT
- Informant system links intel to crimes/factions/black market with trust and risk. Integrate with heat, gang presence, faction wars, and logging.

### For CodeGPT
- Implement informant entities with trust, intel categories, costs, cooldowns, expiry, betrayal, and logging. Enforce rate limits and anti-abuse; server authority only.

### For BalanceGPT
- Tunables: costs, trust gain/decay, betrayal rates, intel accuracy, expiry, heat risk. Keep intel useful but not omniscient; preserve uncertainty.

### For QAGPT
- Test intel pulls, trust changes, betrayal triggers, expiry, rate limits, heat impacts, and logging. Validate faction mole limits and moderation visibility.  
# SECTION 072 — POLICE SYSTEM 3.0

## 71.0 Overview
Police system governs patrols, scans, raids, heat response, and jail/justice flows. Must counter crimes without hard-locking players, using risk scaling and transparency. Integrates with crimes, heat, travel, raids, and informants.

## 71.1 Patrols & Presence
- Patrol density per borough/district; influenced by heat, events, time, weather. Higher heat → more patrols; storms may reduce patrols.
- Patrol actions: random checks, crime intervention, seizure of illegal items, arrests leading to jail. Logs and heat adjustments.
- Special units: riot squads during events; detectives for fraud/cyber; armed response for high-threat wars (flavour).

## 71.2 Scans & Checks
- Locations: travel hubs (trains/airports), roadblocks, random street checks, raids on properties/companies/fronts.
- Detection influenced by legality of items, concealment, heat, weather (fog lowers slightly), compliance status (companies), and informant intel.
- Outcomes: seizure, fines, jail; heat spikes; black-market rep loss for illegal finds.

## 71.3 Heat & Response
- Heat from crimes/illegal items/failures; decays per tick; police response scaling with bands: Low, Med, High, Critical.
- Critical heat triggers special events: increased scans, raids, ambush attempts, higher jail times.
- Bribery limited: small heat reduction with diminishing returns; risk of sting; logged.

## 71.4 Raids
- Targets: properties (illegal items/upgrades), companies (fronts), black-market vendors, gang/faction safehouses (rare; war context).
- Triggers: high heat, informant betrayal, audits, events. Outcomes: seizures, fines, jail, temporary shutdowns.
- Cooldowns: between raids; prevents spam; logs reasons and results; appeals possible.

## 71.5 Jail & Justice
- Arrest leads to jail with duration; busts possible (Section 009); legal aid reduces time (cost).
- Fines scale with offense; repeat offender penalties; assets seizure possible for major fraud.
- Logs show reason, duration, items seized, fines, bust attempts.

## 71.6 UI/UX
- Police presence indicator (heat band) on HUD; patrol/scan risk shown in travel/crime UI; warnings at High/Critical.
- Jail UI: timer, bust/aid options, fines; arrest log; Dark Luxury styling.
- Raid notifications: target, outcome, penalties; appeals link.

## 71.7 Anti-Abuse
- Prevent abuse of bribes; cap; sting chance; logs; lockout on spam.
- Bust spam: cooldowns; diminishing success; repeated failed busts increase time.
- Raids cannot be forced repeatedly by same player; cooldown enforced; anti-grief.

## 71.8 Logging & Data
- Tables: patrol events, scans, seizures, raids, arrests, fines, bribery attempts, busts.
- Logs: heat bands over time, triggers, outcomes; exposed to mods; some summaries to players.

## 71.9 Example Flows
- High heat crime spree: patrols increase; player caught; illegal items seized; fine + jail; heat persists; log recorded.
- Raid on company front: triggered by audit; illegal stock seized; shutdown 12h; rep hit; log; cooldown.
- Bribe attempt: small heat reduction; sting triggers; heat +; jail; log.

### For Architect GPT
- Police system with patrols, scans, raids, and justice flows. Integrate with heat/crimes, travel, properties/companies, informants, and logging.

### For CodeGPT
- Implement patrol/scan events, heat scaling, raids, arrests/jail, fines, bribery with sting, bust cooldowns, logging. Server-side authority; anti-spam; UI APIs for risk indicators.

### For BalanceGPT
- Tunables: patrol rates, scan odds, heat band thresholds, raid triggers/cooldowns, fines/jail durations, bribe effects, bust success, sting odds. Balance deterrence without hard-lock.

### For QAGPT
- Test patrol/scan outcomes, heat transitions, raids triggers, arrests/jail timers, bust/bribe flows, cooldowns, logging accuracy, UI risk indicators, and anti-abuse (no repeated forced raids).  
# SECTION 073 — NATIONAL THREAT SYSTEM 3.0

## 72.0 Overview
National threat tracks large-scale events beyond city-level: coordinated attacks, national alerts, and cross-region impacts. Designed as an overlay that affects multiple systems (travel, policing, events, economy) without permanent lockdowns. Must be transparent, time-boxed, and logged.

## 72.1 Threat Levels
- Levels: Normal, Elevated, High, Critical. Driven by scripted events, war escalations, or story arcs.
- Effects scale with level: Increased scans/patrols, travel delays, certain crimes harder, black market stock reduced, casino checks, slight heat decay changes.
- Time-boxed: each level has duration; returns to baseline after event; no indefinite critical.

## 72.2 Triggers
- Story events (national arcs), faction wars reaching thresholds, successful/failed black ops, coordinated player actions, random national incidents (rare).
- Manual admin triggers for events (logged).

## 72.3 System Effects
- Travel: higher scans; route closures possible at Critical; compensation for cancellations; ambush risk may change.
- Police: patrol density up; raids more likely; bribes less effective; fines higher.
- Economy: some shops close briefly at High/Critical; prices for certain goods rise; black market stock limited; faction income reduced slightly.
- Crimes: success down for high-profile crimes; jail times up; heat decay slower.
- Events: special missions to reduce threat (counter-ops); rewards when threat lowered.

## 72.4 UI/UX
- Threat indicator on HUD; tooltips with effects; countdown timer; news banners; mission prompts to respond.
- Map overlays showing affected regions/routes; warnings before travel/crimes.

## 72.5 Anti-Abuse
- Prevent exploitation of closures for monopolies: compensation and alternative routes; limited duration.
- No infinite reward loops from counter-ops; rewards capped; cooldowns.
- Transparency: published effects to avoid hidden nerfs.

## 72.6 Logging & Data
- Tables: threat state, triggers, durations, applied modifiers.
- Logs: transitions, triggers, actions taken, player participation in counter-ops, compensation payouts.
- Analytics: impact on player behaviour; tune effect strength/duration.

## 72.7 Example Flows
- Elevated: more scans; small travel delay; news banner; minor price shifts.
- Critical triggered by storyline: travel routes partially closed; special counter-ops missions open; successful missions reduce threat; after timer, returns to Elevated then Normal.
- Black ops fail triggers High: raids increase; bribes ineffective; logs; players adjust crimes.

### For Architect GPT
- National threat overlay integrates with travel, policing, crimes, economy, events, and UI. Must be centralized and time-boxed.

### For CodeGPT
- Implement threat state machine, triggers, effect application, timers, logging, and UI indicators. Enforce effects server-side; handle compensation and counter-op missions.

### For BalanceGPT
- Tunables: effect magnitudes per level, durations, triggers, compensation amounts, counter-op rewards. Keep impactful but not oppressive; avoid permanent states.

### For QAGPT
- Test threat transitions, effect applications across systems, UI indicators, counter-op missions, compensation flows, and anti-abuse (no monopolies, no infinite rewards). Validate logging.  
# SECTION 074 — BLACK OPS SYSTEM 3.0

## 73.0 Overview
Advanced black ops layer for factions/crews: high-stakes covert missions with multi-phase planning, execution, and counterplay. Builds on Sections 068/070/072; integrates with factions, black market, policing, and national threat. High risk, high reward, heavy anti-abuse.

## 73.1 Ops Types
- Sabotage: disable enemy upgrades/sector defenses; temporary debuffs.
- Intel Theft: steal war plans/chain timings; reveals partial info; increases enemy heat.
- Supply Raid: steal armory stock; respect bonus; illegal items risk seizure if caught.
- Disinformation: plant false intel in enemy feeds; limited; risk exposure.
- Counter-ops: reduce national threat (Section 072); reward points/respect/loot.

## 73.2 Phases
- Planning: select target, assemble team/roles (leader/hacker/muscle/driver/spotter), gather tools; costs nerve/energy; prep timer; success modifiers shown.
- Execution: server-resolved; uses stats, tools, heat, weather/time, target defenses, informant trust; minimum fail chance.
- Escape: chance to avoid heat/arrest; vehicle bonuses; failure increases penalties.

## 73.3 Requirements & Costs
- Role/stat thresholds; specific tools (jammers, forged IDs, vehicles); faction level/rep; cooldowns; ops points (optional faction resource).
- Costs: nerve+energy; consumables/tools; black-market-only items for advanced ops.

## 73.4 Outcomes & Penalties
- Success: respect, intel, loot, temporary debuffs on enemy; possible national threat change.
- Failure: heat spike, jail/hospital, tool loss, alert enemy (who gains small respect), potential raid trigger.
- Partial: some objectives achieved; reduced rewards; still triggers heat.

## 73.5 Counterplay
- Defending faction can invest in counter-intel (reduces success), alerts when ops attempts detected (delayed), temporary shields (cooldowns) that raise failure chance.
- Informant betrayal can reveal ops and increase fail odds; enemy may get partial intel if op fails.

## 73.6 Anti-Abuse
- Team uniqueness; no solo; IP/device checks; diminishing returns on repeated target/op; cooldowns; respect/loot scaled for linked accounts.
- Logging and audit; staged fake ops flagged; must pay costs upfront to prevent free scouting.

## 73.7 UI/UX
- Ops dashboard: list ops, requirements, risks, rewards, timers; team selection; tool checklist; Dark Luxury styling.
- Notifications: success/fail/partial with details; defender alerts; national threat tie-ins.
- Logs: attempts, outcomes, costs, heat changes.

## 73.8 Data & Logging
- Tables: op definitions, attempts, teams, roles, costs, outcomes, defender buffs, heat impacts.
- Logs: planning start, execution result, escape, penalties, alerts; mod visibility for abuse review.

## 73.9 Example Flows
- Sabotage: team meets thresholds; executes; success reduces enemy sector buff; heat spike; enemy notified; cooldown set.
- Intel theft fails: heat +large; jail; tools lost; enemy gains alert; respect gained by defender; national threat +small.
- Counter-op: faction runs mission during national threat; success reduces threat; rewards points/respect.

### For Architect GPT
- Black ops 3.0 requires multi-phase ops, defender counterplay, heat, and national threat hooks. Integrate with factions, black market, policing, and logging.

### For CodeGPT
- Implement ops definitions, planning/execution/escape flows, requirements/costs, defender buffs, alerts, cooldowns, heat effects, logging, anti-abuse checks. Server-only resolution; no client RNG.

### For BalanceGPT
- Tunables: success weights, rewards/penalties, cooldowns, team size/roles, defender buff strength, national threat deltas, cost requirements. Ensure high risk/high reward; prevent farm.

### For QAGPT
- Test planning/exec/escape flows, requirements validation, defender buffs, alerts, cooldowns, heat penalties, national threat adjustments, logging accuracy, and anti-boost detection.  
# SECTION 075 — SHADOW ECONOMY 3.0

## 74.0 Overview
Shadow economy covers illicit trade, laundering, off-the-books services, and covert currencies. It overlays legal economy with risk and anti-abuse safeguards. Integrates with black market, companies/fronts, factions, informants, and policing.

## 74.1 Components
- Illicit Goods: illegal items, counterfeit goods, forged documents, stolen data. Sourced from black market, heists, fraud.
- Off-Books Services: covert transport, money movement, protection, false IDs, smuggling insurance.
- Shadow Currency: IOUs, favours, informal debt; tracked to prevent exploitation; no direct cash-out; caps.

## 74.2 Trade Flows
- Front companies move shadow goods under cover; freight via smuggling routes; properties used as stash.
- Laundering paths: convert shadow gains to legal cash via fronts; taxed/limited; detection risk; logs.
- Price volatility higher; stock limited; stings possible; seizures if caught.

## 74.3 Risk & Detection
- Heat increases detection; high volumes trigger audits/raids; informant stings; counterfeit risk.
- Trust/reputation in underworld reduces scams but not risk; repeated high-volume moves raise profile.
- Shadow deals leave traces: logs for moderation; analytics flag patterns.

## 74.4 Anti-Abuse
- Laundering caps; price bounds; escrow not used for illegal trades; IP/device correlation; freeze suspicious accounts.
- Shadow currency caps; no direct conversion to points; favours tracked; disputes resolved via missions rather than payouts.
- Duplicate item prevention; counterfeit tagging; seizure events.

## 74.5 UI/UX
- Shadow market overlay: risk bands, limited info; warnings; requires access (rep/level).
- Front company panel shows legal vs illegal revenue ratio; compliance meter; audit risk indicator.
- Stash UI shows shadow goods with legality flags; seizure risk.

## 74.6 Interactions
- Crimes/Heists (Section 068): produce shadow goods; heat; feeds black market.
- Companies (Section 063): fronts launder; audits raid; rep impacts trust.
- Factions: fund wars via shadow economy; risk of stings; informants may sell intel.
- Properties: hide goods; raids; insurance void; heat modifier.
- National threat: elevated levels reduce shadow activity; bust odds higher.

## 74.7 Example Flows
- Shadow shipment via front: moves illegal stock; audit triggers; seizure; fine; jail; underworld rep hit.
- Laundering attempt: tries to push large illegal revenue through legit sales; cap and tax reduce; flag raised; potential freeze.
- Sting: undercover broker offers deal; player accepts; sting triggers; items seized; heat spikes; log.

### For Architect GPT
- Shadow economy connects black market, fronts, laundering, and risk. Integrate with audits/raids, heat/police, informants, and underworld reputation.

### For CodeGPT
- Implement shadow goods tracking, laundering caps, compliance meters, audit/sting triggers, shadow currency ledger (favours), logging, and anti-abuse freezes. Server authority; no escrow for illegal trades.

### For BalanceGPT
- Tunables: laundering caps/taxes, seizure odds, shadow currency caps, trust effects, audit triggers, sting frequency. Keep profits tempting but risky; prevent laundering exploits.

### For QAGPT
- Test shadow trade flows, caps, seizures, audits, laundering limits, freezes, UI warnings, logging, and national threat interactions. Validate no direct conversion exploits.  
# SECTION 076 — BLACK MARKET CRAFTING SYSTEM 3.0

## 75.0 Overview
Black market crafting lets players produce illegal gear/consumables with risk. Integrates with black market, shadow economy, companies/fronts, and raids. High reward, high heat; strict anti-abuse.

## 75.1 Crafting Categories
- Illegal weapons/mods (DIY guns, silencers, AP drums), high-potency drugs, counterfeit IDs, jammer devices, concealment compartments.
- Quality tiers with variance; failure can produce duds or dangerous items; risk of injury/raid.

## 75.2 Requirements
- Labs/workshops (property upgrade or front company facility), tools, recipes, materials (legal + illegal), working stats/education, black-market rep.
- Permits? None (illegal); increases heat/raid risk; location matters (bunkers safer but high raid consequence).

## 75.3 Process & Risk
- Start craft: consumes materials/cost; sets timer; server-resolved; success chance based on stats/tools/quality.
- Outcomes: success (item crafted with quality roll), partial (lower quality), fail (materials lost), catastrophe (injury, heat spike, raid chance).
- Heat: crafting illegal items raises heat; higher for bulk batches; cumulative over time.

## 75.4 Quality & Counterfeits
- Quality roll affects stats and failure rates of crafted items (e.g., jams for DIY guns).
- Counterfeit: intentionally lower-quality goods; cheaper; risk of detection/seizure higher.
- Marking: crafted items tagged; seizure more likely if caught; logs keep source.

## 75.5 Anti-Abuse
- Batch limits; cooldowns; diminishing returns; IP/device correlation; repeat crafts flagged for raids.
- No laundering: price bounds on sales; crafted items tracked; trades logged; cannot craft currency/points.
- Exploit checks: server-only rolls; no client influence; anti-duplication.

## 75.6 Raids & Audits
- Crafting raises raid risk; higher when labs in high-heat areas; audit for fronts; raids seize items/materials; fines/jail; injuries on catastrophe.
- Cooldown after raid; logs; insurance void for illegal labs.

## 75.7 UI/UX
- Crafting panel: recipes, requirements, success/quality bands, timers, costs, risk warnings, heat impact. Dark Luxury styling.
- Logs: results, quality, heat changes, raids/catastrophes; analytics for tuning.

## 75.8 Interactions
- Black market: sells crafted items; rep affects prices; counterfeit detection risk; seizures.
- Shadow economy: supplies materials; laundering caps apply to revenue.
- Companies/fronts: can host labs; risk to reputation; audits.
- Crimes/black ops: crafted tools enhance success; malfunctions possible if quality low.

## 75.9 Example Flows
- Player crafts silencers: uses front lab; success; quality moderate; heat rises; sells on black market; logs.
- Catastrophe: DIY AP drum blows; player injured; hospital; raid chance triggers; materials lost.
- Counterfeit IDs: crafted and sold; detection chance high; if caught, heat spike and jail.

### For Architect GPT
- Illegal crafting system with risk, quality, raids, and logging. Integrate with black market, shadow economy, companies/fronts, and heat/police.

### For CodeGPT
- Implement recipes, requirements, timers, quality rolls, outcomes, heat changes, raids, logging, anti-dupe. Enforce batch limits and price bounds on sales; flag crafted items.

### For BalanceGPT
- Tunables: success/quality curves, batch limits, cooldowns, heat per craft, raid odds, catastrophe odds, material costs, price bounds. Keep profitable but risky; prevent safe mass production.

### For QAGPT
- Test crafting flows, quality outcomes, heat/raid triggers, catastrophe handling, batch limits, logging, sales with price bounds, anti-dupe, and integration with black market/shadow economy.  
# SECTION 077 — VEHICLES & MODDED VEHICLE SYSTEM 3.0

## 76.0 Overview
Advanced vehicle modding beyond Section 040/046: deeper mod trees, illegal overclocking, fleet ops, and race/smuggling crossovers. Must prevent stat inflation and abuse; integrate with maintenance/compliance.

## 76.1 Mod Trees
- Performance: engine tunes, turbo/supercharger (illegal if extreme), ECU remap, lightweight parts; improve speed/accel; increase wear and heat.
- Handling: suspension kits, tire compounds, brake upgrades; improve handling; may reduce cargo.
- Utility: concealment compartments, jammer suites, reinforced chassis (adds weight), cargo racks.
- Safety: roll cages (race), fire suppression; may add weight; reduce injury chance slightly.
- Visual: wraps/rims/underglow (cosmetic; heat if illegal on streets).

## 76.2 Limits & Caps
- Mod slots per vehicle class; diminishing returns on stacking similar mods; hard caps on speed/accel/handling to prevent OP builds.
- Illegal overclock: temporary performance spike; massive heat; high breakdown chance; short duration; logged; banned in legal races.

## 76.3 Installation & Risk
- Requires tools/companies; costs; time; quality affects reliability; illegal installs increase scan/raid risk.
- Over-tuned builds raise maintenance; breakdown risk rises; compliance checks fail if illegal mods detected on public roads.

## 76.4 Fleet Operations
- Fleet bonuses for coordinated convoys: slight ambush risk reduction; requires multiple vehicles; diminishing returns; logs.
- Heat sharing: fleets with illegal mods raise collective risk; scans more likely if flagged.
- Faction/company fleets can schedule runs; SLA penalties if breakdowns/delays.

## 76.5 Racing & Smuggling Crossovers
- Street races: illegal mods allowed; heat and breakdown risk apply; police chase chance increases with illegal mods.
- Legal races: illegal mods disallowed; scrutineering checks; disqualify if found.
- Smuggling: concealment compartments and jammer suites reduce scan odds; overclocking may reduce travel time but increases heat/ambush.

## 76.6 UI/UX
- Mod tree UI: shows slots, caps, effects, heat/maintenance impact; warnings for illegal/overclock; Dark Luxury styling.
- Fleet planner: convoy setup, routes, risks, compliance status, timers.
- Scrutineering view for legal races: shows pass/fail; lists illegal mods found.

## 76.7 Anti-Abuse
- Cap stacking; illegal mod detection; anti-dupe on parts; price bounds; logs; scrutineering; server-side performance calc.
- Overclock spam blocked by cooldown; heat penalties; breakdown guarantees if abused.

## 76.8 Example Flows
- Player overclocks car for smuggling run: speed up; heat/breakdown risk; run succeeds; breakdown avoided; heat spikes; log; cooldown on overclock.
- Legal race: scrutineering catches illegal turbo; disqualified; reward lost; log.
- Fleet convoy: 3 vans with concealment; ambush risk reduced; scan risk lowered; heat moderate; SLA met; logs.

### For Architect GPT
- Advanced vehicle mod system with caps, overclocking, fleets. Integrate with travel/smuggling, races, maintenance/compliance, and logging.

### For CodeGPT
- Implement mod trees with caps, overclock effects/cooldowns, scrutineering, fleet convoy logic, maintenance impact, logging, anti-dupe. Server-authoritative performance calcs.

### For BalanceGPT
- Tunables: mod effects, caps, overclock penalties, breakdown odds, fleet bonuses, scrutineering strictness. Keep illegal mods high risk; prevent overpowered builds.

### For QAGPT
- Test mod install/caps, overclock cooldown/penalties, scrutineering disqualifications, fleet convoy risks/bonuses, breakdown events, logging, and anti-dupe. Validate race legality enforcement.  
# SECTION 078 — CLOTHING, ARMOUR SETS & COSMETIC FASHION SYSTEM 3.0

## 77.0 Overview
Advanced cosmetic system covering clothing sets, armor cosmetics, and cross-system presentation. No gameplay stats; purely visual and prestige. Builds on Sections 053/059.

## 77.1 Set Types
- Clothing sets by borough/theme, events, factions; armor skins for helmets/vests/legs; weapon skins optional (cosmetic).
- Prestige sets (TrenchMade) for high-rank/achievements; no stat change.
- Seasonal/event sets with limited availability; reruns possible.

## 77.2 Collection & Progression
- Collections with milestones: complete set awards title/frame/badge (cosmetic only).
- Pity mechanics for event drops; token exchange for missing pieces; capped; no stat effect.
- Achievements for full wardrobe milestones; profiles can showcase favourite sets.

## 77.3 Customization Rules
- Skins cannot alter hitboxes/readability; armour skins keep silhouettes readable; no stealth advantage.
- Colour palettes curated; high-contrast modes available; faction logos allowed with moderation.
- Mix-and-match allowed; set bonuses purely visual (glow/particle minimal and toggleable).

## 77.4 Market & Trading
- Tradeable cosmetics with price bounds; rarity-aware fees; anti-laundering; authenticity tags.
- Lock skins to owner if bound (event exclusives); otherwise tradeable.
- Gift system with cooldown; logs; moderation for offensive uploads.

## 77.5 UI/UX
- Unified wardrobe for clothing/armor/weapon skins; previews; save loadouts; Dark Luxury UI.
- Collection tracker; token exchange; badges/titles display.
- Accessibility: reduced-effects toggle for skins with particles; colour-blind friendly options.

## 77.6 Anti-Abuse
- No stat effects; enforce visibility; disallow dark-on-dark stealth skins.
- Anti-dupe IDs; trade bounds; gift cooldowns; report flow; moderation for custom emblems.

## 77.7 Example Flows
- Player completes armor skin set: earns cosmetic title; no stat changes; profile updates.
- Event weapon skin: drops; bound; cannot trade; can equip/unequip freely; logged.
- Attempted stealth skin: rejected by palette rules; warning shown.

### For Architect GPT
- Cosmetic-only system for clothing/armor/weapon skins, collections, and trading. Integrates with identity, market, and moderation.

### For CodeGPT
- Implement wardrobe for skins, collection tracking, token exchange, trade bounds, gift cooldowns, anti-stealth palette checks, logging, and moderation hooks. Ensure zero gameplay impact.

### For BalanceGPT
- Minimal: rarity distribution, token costs, trade bounds. Keep cosmetics aspirational without economy abuse.

### For QAGPT
- Test skin equip/trade/gift with bounds, collection completion, token exchange, anti-stealth checks, logging, and UI visibility. Validate no stat changes or hitbox/visibility impact.  
# SECTION 079 — TATTOOS, GANG MARKINGS & BODY MODS SYSTEM 2.0

## 78.0 Overview
Expanded body mod system with gang markings and cosmetic-only tattoos/piercings. Maintains Dark Luxury and UK street tone; strictly no gameplay stats. Moderation and anti-abuse enforced.

## 78.1 Tattoos & Markings
- Slots: arms, neck, back, chest, legs, hands; multiple layers with ordering; opacity/colour controls within curated palette.
- Styles: script, geometric, traditional, UK street motifs, faction/company emblems (approved), event designs. Gang markings are cosmetic; no mechanical influence.
- Moderation: all custom uploads go through review; profanity/real-gang/illegal symbols blocked; report flow with strikes.

## 78.2 Piercings & Body Mods
- Cosmetic piercings (ears, nose, brow, lip), minimal jewellery; small cosmetic-only cyber-lite (LED accents) allowed for style—no sci-fi stats.
- No stat effects; cannot imply armor/stealth.

## 78.3 Application & Removal
- Shops apply/remove; cost cash/points; cooldown to prevent spam; logs recorded.
- Removals/cover-ups cost and have cooldown; covers preserve history for moderation.

## 78.4 Gang Markings
- Cosmetic emblems/tattoos showing allegiance; tied to faction/gang membership; auto-hidden if membership lost.
- Approval required for custom emblems; palette restrictions; cannot spoof other factions.
- Visibility toggle for privacy; default visible.

## 78.5 UI/UX
- Body mod editor: slot selection, layer order, palette, preview with Dark Luxury backdrop; undo/redo; save/load looks.
- Moderation status indicators for pending uploads; history of applied designs.
- Accessibility: reduced-motion option for LED accents; high-contrast preview.

## 78.6 Anti-Abuse
- No stat effects; no stealth perks; anti-laundering via price bounds; cooldown on apply/remove; logs immutable.
- Upload filters; mod review; strikes for violations; report button on profiles.

## 78.7 Interactions
- Identity/profile shows tattoos/piercings; titles/frames/clothing complement; no combat/crime impact.
- Events: limited-time designs; achievements for collections; cosmetic-only.

## 78.8 Example Flows
- Player applies faction marking: approved emblem; shows on profile; removed automatically on leaving faction.
- Custom upload rejected: blocked for forbidden symbol; strike applied; message sent.
- Cover-up: applies new design; old design hidden but kept in history for mods.

### For Architect GPT
- Body mod system integrated with identity and cosmetics; moderation critical. Ensure linkage to faction membership for gang markings.

### For CodeGPT
- Implement editor with slots/layers, apply/remove with cooldowns, moderation queue, auto-hide on faction exit, logging. Enforce no-stat rule.

### For BalanceGPT
- Minimal: pricing/cooldowns and trade bounds if trading cosmetic tokens; maintain accessibility to basics.

### For QAGPT
- Test apply/remove, moderation flow, faction marking hide on exit, cooldowns, logging, and cosmetic-only enforcement. Validate filters and reports.  
# SECTION 080 — PETS, ANIMALS, COMPANIONS & ILLEGAL EXOTICS SYSTEM 3.0

## 79.0 Overview
Expanded pet/companion system adding illegal exotics with risk. Maintains cosmetic/light utility only. High risk for illegal exotics; anti-abuse enforced; no combat advantage.

## 79.1 Pet Classes
- Legal: dogs, cats, birds (ravens/pigeons), fox (event), reptiles (small); happy/fetch buff minor.
- Illegal exotics (high risk): certain reptiles/owls; cosmetic skins; increases heat/raid risk; seized on scans/raids.
- Event skins: seasonal looks; cosmetic; tradeable within bounds.

## 79.2 Care & Upkeep
- Feeding/grooming/vet; neglect => inactive pet; illegal exotics require special care items; higher upkeep; failure increases seizure risk.
- Happiness influences minor buff (happy/fetch) with caps; no combat stats.
- Pet slot limits; exotic slots separate and capped; require permits? Not formal—black-market care; risk higher.

## 79.3 Traits & Training
- Traits: obedient, curious, vigilant; minor cooldown/utility impact; capped.
- Training: consumes time/cost; diminishing returns; logs; anti-bot.

## 79.4 Risk & Enforcement
- Illegal exotics raise heat; scans/raids can seize; fines/jail if seized; black-market rep drop.
- Transport restrictions: some modes block exotics; smuggling possible with high risk; concealment reduces slightly.
- Events can lower risk temporarily (e.g., carnival pets amnesty).

## 79.5 UI/UX
- Pet stable: legal vs exotic tabs; care timers; traits; risk indicator; Dark Luxury cards.
- Warnings: heat/scan risk for exotics; upkeep due; inactivity.
- Logs: care actions, seizures, training, happiness changes.

## 79.6 Anti-Abuse
- Buffs capped; no combat; fetch cooldowns; pet farming blocked; exotic hoard limits; price bounds; IP/device checks on mass trades.
- Illegal exotics cannot be used to launder (trade caps; logs).

## 79.7 Interactions
- Properties: some disallow exotics; illegal exotics increase raid risk; staff can reduce upkeep slightly.
- Black market: source of exotics/care items; rep requirements; seizures if caught.
- Events: pet events with missions; cosmetic rewards; no stat changes.

## 79.8 Example Flows
- Player smuggles exotic owl: risk warning; scan catches; owl seized; fine/jail; rep down; log.
- Legal pet cared for: happy buff active; fetch on cooldown; small utility; logged.
- Exotic neglect: risk increases; warning; if raid hits, exotic seized; heat +.

### For Architect GPT
- Pet system with legal vs exotic branches; integrates with heat/policing, black market, properties, and events. Keep utility minimal.

### For CodeGPT
- Implement pet slots (legal/exotic), care/training, happiness buffs, risk/seizure logic for exotics, logging, anti-abuse caps, and warnings. Enforce no combat effects.

### For BalanceGPT
- Tunables: buff sizes, care costs, exotic risk/seizure odds, slot limits, training effects, trade bounds. Keep exotic risk meaningful; utility minimal.

### For QAGPT
- Test adopt/care/training, exotic risk/seizure, heat/scan interactions, slot limits, trade caps, logging, and UI warnings. Validate no combat impacts.  
# SECTION 081 — FOOD, DRINK, STREET EATS & BOOSTER SYSTEM 4.0

## 80.0 Overview
Advanced consumables spec building on Section 059: street food, drinks, boosters, and catering. Maintains small, capped effects; integrates with events, properties, companies, and economy. UK street flavour; Dark Luxury presentation.

## 80.1 Street Food & Drinks
- Categories: meals (pies, curries, kebabs), snacks (crisps, sweets), drinks (tea/coffee, softs), alcohol (pints, spirits), energy drinks, event specials.
- Effects: minor happy/regen tweaks; small energy/nerve bumps for energy drinks; alcohol happy up + accuracy down; all with short durations and small crashes; caps prevent stacking.
- Region flavour: borough/regional specials; events add limited items; no stat power.

## 80.2 Boosters (Non-Drug)
- Booster items distinct from drugs: small timed buffs (e.g., +tiny regen or reduced crash severity) with strict cooldowns and caps; cannot stack with drug buffs of same type.
- Anti-crash snacks: slightly reduce upcoming drug crash; minimal; cooldown; logs.

## 80.3 Crafting & Catering
- Companies (hospitality/catering) can produce food/drink; quality affects happy gain duration slightly; defects reduce effect.
- Property parties consume catering; menu configurable; bulk discounts; logs.
- Event catering contracts; SLAs; penalties for late delivery.

## 80.4 Cooldowns & DR
- Consumable cooldown per category; diminishing returns on spam; happy caps prevent inflation; server authority.
- Alcohol adds short-term debuff; stacking alcoholic drinks increases crash; anti-abuse warnings.

## 80.5 UI/UX
- Consumable cards: effect, duration, crash, cooldown, stack rules; flavour text; Dark Luxury visuals.
- Party menu builder; catering order UI; event specials highlighted.
- Warnings for alcohol debuffs and overuse; caps displayed.

## 80.6 Anti-Abuse
- Cooldowns, DR, category caps; no stacking with drugs; logs; rate limits on use; no combat stat boosts.
- Trade bounds to prevent laundering; authenticity for event items.

## 80.7 Economy
- Shops/market: price bounds; event items tradeable; catering drives demand; trust reduces market fees.
- Companies gain revenue; quality impacts reputation; defects logged; refunds for bad batches optional.

## 80.8 Interactions
- Bars (Section 002): happy/regen small; crashes minor; no major bar shifts.
- Drugs (Sections 024/029/060/066): anti-crash snacks cushion slightly; not a replacement for detox.
- Properties: parties boost happy temporarily; staff auto-serve; catering stored in property stash.
- Events: themed consumables with cosmetics/achievements.

## 80.9 Example Flows
- Player eats kebab: happy +small; short duration; crash small; cooldown; log.
- Party catering: owner orders menu; guests gain happy buff; crash later; items consumed; logs and payments recorded.
- Energy drink spam: DR reduces effect; cooldown blocks; warning displayed.

### For Architect GPT
- Consumable system expanded for street food/drink/boosters and catering. Integrate with bars, parties, companies, economy, and events.

### For CodeGPT
- Implement consumable categories with effects/crashes/cooldowns/DR, catering production/orders, party menus, logging, trade bounds. Enforce server-side rules and anti-stack with drugs.

### For BalanceGPT
- Tunables: effect sizes/durations, crashes, cooldowns, DR slopes, catering quality impact, price bounds. Keep boosts minor; prevent happy inflation.

### For QAGPT
- Test consumable use, cooldown/DR, anti-stack with drugs, catering production/orders, party flows, logging, and UI warnings. Validate alcohol debuff behaviour.  
# SECTION 082 — RELATIONSHIPS, REPUTATION, STREET STATUS & SOCIAL PROGRESSION 4.0

## 81.0 Overview
Social progression system covering relationships (friends/enemies/marriage), reputation, street status, and social achievements. Builds on identity (Section 002), social systems (Section 020/042), and factions/gangs (Sections 012/065). Must avoid pay-to-win; focus on signals and access gating.

## 81.1 Reputation Components
- Personal Rep: actions across combat/crimes/factions/companies/market; shown as bar + tags (e.g., “Reliable,” “Untrustworthy”).
- Street Status: prestige from crimes/gangs/fights; influences NPC interactions and some crime availability.
- Trust Score: trade/contract history; scam reports; affects fees/limits in market/contracts.
- Titles/Badges: earned through achievements; cosmetic; displayed on profile.

## 81.2 Relationships
- Friends/Enemies: caps; effects on notifications, bounty filters; enemies more likely to appear in logs; no gameplay buffs.
- Marriage/Partnership: shared property perks, small QoL (revive priority), cooldowns on divorce; no combat power.
- Faction/Company Affinity: displayed on profile; contributes to rep tags (e.g., “Officer,” “CEO”).

## 81.3 Social Progression
- Achievements for milestones (missions, crimes, wars, contracts, community posts); unlock titles/cosmetics; no stats.
- Social tiers: cosmetic milestones (Street, Known, Respected, Notorious); thresholds based on rep/achievements; unlocks cosmetic frames/themes.
- Negative status: deserter, scammer; impacts recruitment and fees; decays slowly with good behaviour.

## 81.4 UI/UX
- Profile: rep bar with tag breakdown; trust score; status titles; relationship section; badges.
- Social hub: achievements list, progress, unlockable cosmetic rewards; reputation history; appeals for negative tags.
- Notifications: rep changes (positive/negative), status tier changes; Dark Luxury styling.

## 81.5 Anti-Abuse
- Rep farming detection: repeated trivial actions; capped gains; IP/device checks; decay on inactivity.
- Trust manipulation: alt trades/contracts flagged; scam reports verified; disputes with moderation; penalties for false reports.
- Marriage abuse: cooldowns; cost; shared property anti-laundering; divorce cooldown; logs.

## 81.6 Interactions
- Crimes: certain high-end crimes may require minimum street status; negative status can block invites.
- Factions/Companies: recruitment filters by trust/rep; deserter tag blocks leadership roles temporarily.
- Market/Contracts: trust affects fees/limits; scammer tag increases escrow; verified reduces fees.
- Missions: story arcs may branch based on reputation.

## 81.7 Example Flows
- Player scams contracts: trust drops; scammer tag; market fees rise; contract limits; decay after sustained clean record.
- War deserter: leaves mid-war; deserter tag; faction recruitment harder; decay timer; logs.
- Social tier up: reaches “Respected” via achievements; unlocks cosmetic frame; no stats; profile updates.

### For Architect GPT
- Social progression layer managing rep/trust/status and relationships. Integrates with identity, market/contracts, crimes/factions, and achievements. Must be cosmetic/QoL, not stat power.

### For CodeGPT
- Implement rep/trust calculations, tags, tiers, relationships (friend/enemy/marriage), achievements, appeals, logging, anti-abuse detection. Provide APIs for UI and gating checks; enforce cooldowns and fees.

### For BalanceGPT
- Tunables: rep gains/decay, trust impacts, fee modifiers, thresholds for tiers/tags, decay rates for negative statuses. Ensure signals matter without overpowering core progression.

### For QAGPT
- Test rep changes, trust impacts on market/contracts, status tiers, marriage flows, deserter/scammer tags, decay/appeals, gating on crimes/recruitment, and logging. Validate no pay-to-win effects.  
# SECTION 083 — WEATHER, TIME, ROUTINES & DYNAMIC WORLD EVENTS 5.0

## 82.0 Overview
Advanced dynamic world layer integrating weather/time with NPC routines and timed events. Builds on Section 057/013/056; ensures the world feels alive, reactive, and Torn-dense without breaking balance.

## 82.1 NPC Routines
- NPCs (civilians, gangs, merchants, police) have schedules by time/weather: day vs night presence, shelter during storms, nightlife spikes in evening, reduced patrols in heavy rain.
- Routine shifts affect crime odds, NPC encounters, shop hours, and crowd density; logged.
- Boss/NPC quest-givers may have availability windows; communicated in UI.

## 82.2 Dynamic Events
- Minor: street fairs, protests, traffic jams, small blackouts; short duration; adjust crime/travel/market slightly.
- Major: strikes, large blackouts, citywide raids, festival weeks; larger impact; time-boxed; may tie to national threat (Section 072).
- Randomized occurrences with cooldowns; no oppressive chaining; published timers/banners.

## 82.3 System Effects
- Crimes: routines/events modify success/heat; protests increase crowd and police; blackouts reduce CCTV (stealth bonus) but increase police sweeps.
- Travel: events cause delays/closures; compensation; alternate routes; smuggling risk changes.
- Market/Economy: price swings from events (blackout -> generator demand); shop closures; merchant availability windows.
- Factions: wars may be influenced by events (reduced visibility in blackout), but wars proceed; no hard locks.

## 82.4 UI/UX
- World timeline: upcoming events, weather forecast, NPC availability; Dark Luxury timeline UI.
- HUD chips for active events; map overlays; shop/mission pages show availability windows; warnings for closures.
- Notifications for event start/end; compensation notices for travel disruptions.

## 82.5 Anti-Abuse
- Prevent event farming: caps on event-specific rewards; cooldowns on repeat participation; anti-bot checks for rapid event hopping.
- Randomization within bounds to avoid perfect optimization; server authority on schedules.

## 82.6 Logging & Data
- Tables: event definitions, schedules, effects, NPC routines, availability windows.
- Logs: event triggers, effects applied, player participation, rewards, compensation, routine changes.
- Analytics: player engagement, disruption impact, reward distribution; used for tuning.

## 82.7 Example Flows
- Protest: increases police and crowd; pickpocket risk/reward shifts; travel delay; missions adjust; log recorded.
- Blackout: CCTV off; stealth crime bonus; police sweeps; travel delays; shops limited; faction war fights in blackout have reduced accuracy.
- Festival: happy buffs in nightlife districts; special consumables; limited-time missions; rewards capped.

### For Architect GPT
- Dynamic world service linking weather/time, NPC routines, and events. Integrates with crimes, travel, economy, factions, and UI overlays. Central schedule and logging.

### For CodeGPT
- Implement routine scheduler, event triggers/effects, UI timeline/overlays, compensation for disruptions, logging, anti-abuse caps. Server authoritative; no client adjustments.

### For BalanceGPT
- Tunables: event frequency/duration/effects, routine impacts, reward caps, compensation amounts. Keep world lively but not oppressive; avoid locking core actions.

### For QAGPT
- Test event scheduling, effect application, UI timeline accuracy, compensation flows, participation caps, anti-bot, and interactions with crimes/travel/economy/factions. Validate logs.  
# SECTION 084 — NPC FACTIONS, GANGS, STREET CREWS & UNDERWORLD STRUCTURES

## 83.0 Overview
Defines NPC-led underworld structures beyond player factions/gangs: rival factions, crews, and their interactions with players. Integrates with missions, crimes, territory, black market, and events.

## 83.1 NPC Factions & Crews
- Types: rival major factions, mid-tier street crews, specialist syndicates (fraud, smuggling), mercenary outfits.
- Territories: claim sectors/streets; contested with player actions; presence influences crime odds, black-market availability, and patrols.
- Hierarchy: bosses, lieutenants, grunts; stats scale by level band; bosses have unique mechanics/loot.

## 83.2 Behaviour
- States: Passive, Neutral, Hostile; change based on player/faction actions, missions, and events.
- Conflict: NPCs fight each other in background; outcomes adjust presence; player can intervene.
- Diplomacy: limited—player actions can earn temporary truces or provoke hostility; not full alliance.

## 83.3 Missions & Contracts
- NPC factions offer missions/contracts; rewards items/rep/cash; failure may decrease rep.
- Hit contracts against NPC targets; escort/protection missions; smuggling runs; intel theft.
- Boss arcs: multi-stage missions to weaken faction; culminate in boss fight; lockouts after defeat.

## 83.4 Economy & Black Market
- NPC control of certain black-market vendors; hostility can restrict stock or increase prices; truces may grant discounts.
- Shadow economy influence: launder routes more/less safe; events can shift control.

## 83.5 Territory Impact
- NPC presence modifies sector bonuses, crime success/heat, and ambush risk; overlays on map.
- Players can push back via missions, fights, or wars; presence decays if not reinforced.

## 83.6 UI/UX
- Underworld map overlay: NPC factions/crews presence; hostility; sectors/streets affected.
- Faction dossier: leader, speciality, hostility, missions available, rewards, lockouts.
- Logs: encounters, missions, territory shifts; notifications for boss respawn/hostility changes.

## 83.7 Anti-Abuse
- Farming NPC bosses limited with lockouts; diminishing loot; IP/device bot checks.
- Reputation exploits blocked: repeat trivial missions cap gains; betrayal tracked; hostility rises on exploitation.
- Map manipulation server-side; no client trust.

## 83.8 Example Flows
- Player helps smuggling syndicate: gains rep; vendor discount; police heat up in that district; rival gang hostility rises.
- Boss defeat: reduces NPC faction presence; unique loot; respawn timer; hostility temporarily high.
- Crew hostility triggered: player attacks patrol; crew becomes hostile; ambush chance rises; missions lock until rep repaired.

### For Architect GPT
- NPC underworld system layering onto player factions/gangs; needs presence tracking, missions, hostility, and vendor control. Integrate with map, crimes, black market, and events.

### For CodeGPT
- Implement NPC faction/crew data, presence maps, missions/contracts, boss lockouts, hostility state machine, vendor control, logging. Anti-farm safeguards and server authority.

### For BalanceGPT
- Tunables: presence effects, rep gains/losses, mission rewards, boss lockouts, vendor pricing changes, hostility thresholds. Keep NPCs meaningful but not farmable; maintain risk.

### For QAGPT
- Test missions/contracts, presence changes, hostility shifts, boss lockouts, vendor stock/price changes, map overlays, anti-farm detection, and logging. Validate interactions with player factions/gangs.  
# SECTION 085 — DRUG SYSTEM 5.0

## 84.0 Overview
Latest drug spec harmonizing all prior sections (024/029/060/066) into a final rule set: categories, effects, tolerance/addiction, enforcement, crafting, and balance. UK street flavour; Dark Luxury UI; high risk/high reward; zero pay-to-win.

## 84.1 Categories & Hierarchy
- Stimulants, Painkillers, Hallucinogens, Performance Blends, Medical, Black-Market Specials. Each has: effect profile, crash profile, legality, quality range, tolerance/addiction weights.
- Sub-categories for crafting variants (APX stim, Deep Blend) with explicit stats; illegal.

## 84.2 Effects/Crashes/Caps
- One active per category; global cap of two categories (medical excluded). Effects fixed duration; crashes inverse; severity scales with tolerance; caps enforce diminishing returns.
- Overdose block: server denies use if risk threshold crossed; logs; may injure on exploit attempts.

## 84.3 Tolerance & Addiction
- Tolerance grows per use; decays over time; modifies effect/crash. Addiction triggers on sustained high tolerance; applies ongoing debuff; requires rehab (Section 066).
- Withdrawal if addicted and abstaining; harsher debuff; resolves via time or rehab; logged.

## 84.4 Legality & Enforcement
- Illegal drugs increase scan/bust risk; seizures at travel/raids; fines/jail; black-market rep loss.
- Public use may raise heat; faction war rules cap drug use; hospital overdoses trigger seizure/heat.
- Quality influences detection slightly; counterfeit risk; seized items logged.

## 84.5 Crafting & Labs
- Illegal crafting (Section 075): recipes, quality rolls, catastrophe risk, heat; labs required; materials tracked; crafted items tagged.
- Catastrophes: injury, raid chance, material loss; logs; hospital.

## 84.6 UI/UX
- Drug manager UI: categories, effects/crashes, timers, caps, tolerance/addiction meters, rehab status; warnings for overdose/legality.
- Crafting UI: recipes, success/quality bands, timers, heat impact; risk warnings.

## 84.7 Anti-Abuse
- Caps, cooldowns, DR; anti-automation; logs; price bounds; seizure/sting for mule accounts; laundering via drug trades limited.
- No stat-permanent buffs; addiction penalties ensure cost; detox cannot be bypassed by repeated small doses.

## 84.8 Interactions
- Combat/Crimes: boost/crash influence; illegal possession affects heat; black ops may require chems.
- Bars: energy/nerve/happy affected; crashes reduce regen; food cushions slightly.
- Properties: comfort/med rooms reduce crash and rehab time slightly; illegal labs increase raid risk.
- Factions: war drug caps; perks reduce crash marginally; faction labs possible with high risk.

## 84.9 Example Flows
- Player uses high-tier stim: effect strong; tolerance rises; crash heavy; heat risk if caught; log.
- Addiction + rehab: addiction debuff; rehab timer; rehab clears; cooldown; logs.
- Lab catastrophe: batch explodes; injury; raid chance; materials lost; heat spike; log recorded.

### For Architect GPT
- Final drug ruleset: caps, tolerance/addiction, legality, crafting, and UI. Integrate across bars, combat, crimes, black market, labs, properties, and factions.

### For CodeGPT
- Implement central drug manager with category caps, tolerance/addiction states, overdose blocks, rehab, crafting/lab outcomes, legality checks, logging. Server authority; anti-abuse detectors.

### For BalanceGPT
- Tunables: effect/crash magnitudes/durations, tolerance growth/decay, addiction thresholds, rehab costs/duration, craft success/quality, catastrophe odds, seizure/bust rates. Keep powerful but risky.

### For QAGPT
- Test use/caps, tolerance/addiction/withdrawal, rehab, crafting, seizures, overdose blocks, logging, and UI warnings; validate integration with combat/crimes and heat.  
# SECTION 086 — THE COMPLETE CRAFTING & DRUG LAB SYSTEM

## 85.0 Overview
Unified crafting/lab system for legal and illegal production. Covers recipes, facilities, quality, risk, and anti-abuse. Integrates with companies, properties, black market, shadow economy, and raids.

## 85.1 Crafting Domains
- Legal: consumables (food/drink), basic meds, legal weapon parts, clothing/cosmetics. Low risk; standard QA/defect rates; legal shops/companies handle.
- Illegal: drugs, illegal weapon mods, counterfeit IDs, jammers, concealment, black-market gear. High risk; heat/raids; catastrophe possible.

## 85.2 Facilities & Requirements
- Facilities: workshops (legal), kitchens, labs (illegal), chemistry benches, mod benches. Hosted at properties or companies/fronts; require upgrades/tools.
- Requirements: recipes, materials, tools, working stats/education, access flags (legal vs illegal).
- Capacity and queue limits; upgrades improve capacity/time/quality modestly; illegal upgrades increase heat.

## 85.3 Process
- Start job: consume materials; set timer; server resolves; success/quality roll; logs.
- Outcomes: success (quality roll), partial (lower quality), fail (materials lost), catastrophe (injury, fire, raid chance).
- QA: defects lower effectiveness; recalls for legal products; reputation impact for companies.

## 85.4 Quality & Tagging
- Quality tiers affect item stats/durability/crash; illegal items tagged; counterfeit flagged; sources logged.
- Crafted items carry origin for seizures/recalls; cannot be laundered; price bounds.

## 85.5 Heat & Raids
- Illegal crafting raises heat; batch size and facility location affect risk; repeat runs escalate.
- Raids: triggered by heat/audits/catastrophes; seize illegal items/materials; fines/jail; cooldown after raid; logs.

## 85.6 Anti-Abuse
- Batch limits, cooldowns, DR; IP/device checks; server-only rolls; anti-duplication; price bounds prevent laundering via crafted goods.
- Front laundering caps: illegal revenue ratio limits; auto audits on anomalies.

## 85.7 UI/UX
- Crafting console: recipes, requirements, timers, success/quality bands, risk/heat, batch size, costs; Dark Luxury styling.
- Logs: job results, quality, defects, catastrophes, recalls, raids; analytics for tuning.
- Warnings for illegal crafts, raid risk, catastrophe odds.

## 85.8 Interactions
- Black Market: illegal outputs sold; seizure risk; rep gating.
- Companies: production lines; QA; recalls; reputation; SLAs; audits.
- Properties: labs/workshops; increase stash risk for illegal; insurance void.
- Shadow Economy: materials and outputs tracked; laundering caps enforced.
- Missions/Events: craft-focused missions; event recipes; rewards cosmetic/items.

## 85.9 Example Flows
- Legal batch: company produces meds; quality good; defect low; sells in shop; rep up; log.
- Illegal lab batch: produces stim; quality varied; heat rises; raid triggered; items seized; fine/jail; log.
- Catastrophe: explosion injures player; hospital; materials lost; raid chance spikes; recall of affected batch.

### For Architect GPT
- Unified crafting framework with legal/illegal paths, quality, risk, and logging. Integrate with companies, properties, black market, raids, and economy controls.

### For CodeGPT
- Implement facility/recipe system, job queues, success/quality/catastrophe rolls, heat/raid triggers, tagging, recalls, QA, logging, anti-duplication. Enforce batch limits and price bounds.

### For BalanceGPT
- Tunables: job times, success/quality curves, catastrophe odds, heat per batch, raid triggers, batch caps, QA/defect rates, recall penalties. Ensure illegal profitable but risky; legal stable.

### For QAGPT
- Test job start/complete, quality outcomes, defects/recalls, raids, catastrophe handling, tagging/seizure, batch limits, logging, and UI warnings. Validate anti-laundering via price bounds.  
# SECTION 087 — THE COMPLETE FOOD & DRINK SYSTEM

## 86.0 Overview
Comprehensive food/drink system, combining street eats, shops, catering, and property parties. Builds on Sections 059/080. Effects are minor, capped, and balanced; primary purpose is flavour, economy, and social loops.

## 86.1 Items & Categories
- Meals: hearty dishes, street food, event specials; happy boosts small; durations short; crashes minor.
- Snacks: small happy; cooldowns short; minimal crash.
- Drinks: soft, caffeine (tiny energy), alcohol (happy up, accuracy down, crash), energy drinks (small energy; cooldown), event drinks.
- Buff items: slight regen/happy modifiers; separate from drugs; category caps.

## 86.2 Effects & Rules
- Effects minor; capped; cannot stack with same category; cooldowns enforce pacing; crashes small and short.
- Alcohol debuff: accuracy down; stacking increases crash; warnings shown.
- Energy/caffeine: tiny energy; diminishing returns; respect bar caps.

## 86.3 Shops & Supply
- Shops/restaurants by district; stock varies by wealth/region; prices vary; events change stock.
- Supply from companies; quality influences effect duration slightly; defects reduce effect; recalls if contaminated.
- Market: items tradeable within bounds; authenticity ensured.

## 86.4 Catering & Parties
- Catering orders from hospitality companies; bulk supplies; quality affects happy duration.
- Property parties consume food/drink; provide temporary happy buffs; crash follows; cooldown to prevent spam.
- Menus configurable; staff auto-serve; logs of consumption.

## 86.5 Events & Achievements
- Event-exclusive foods/drinks; cosmetic achievements for collections; pity tokens optional; effects same scale.
- Achievements for trying regional foods; titles cosmetic.

## 86.6 UI/UX
- Menus show effects, duration, crash, cooldown, stack rules; property party builder; catering order UI; Dark Luxury styling.
- Warnings for alcohol and spam; cooldown displayed; logs.

## 86.7 Anti-Abuse
- Cooldowns/DR; caps; no stacking with drugs; server-side; anti-macro; price bounds for trades; no stat buffs.
- Food/drink cannot bypass rehab or bar limits; small only.

## 86.8 Interactions
- Bars: small happy/energy influences; minimal; crashes minor.
- Drugs: anti-crash cushion minimal; cannot remove addiction.
- Properties: parties; staff; catering; stash for food; spoilage optional (small).
- Companies: supply chain; QA/recalls; reputation; contracts.

## 86.9 Example Flows
- Player buys meal: happy small; crash minor; cooldown; logged.
- Party: guests get happy buff; crash after; items consumed; catering paid; logs.
- Recall: contaminated batch found; items flagged; refunded; reputation hit for company.

### For Architect GPT
- Unified consumable system for food/drink/catering/parties. Integrate with bars, properties, companies, events, and logging; keep effects minor.

### For CodeGPT
- Implement items, effects, cooldowns/caps, shops/stock, catering/parties, QA/recalls, logging, and price bounds. Server authority; anti-macro; no overlap with drug buffs.

### For BalanceGPT
- Tunables: effect sizes/durations, crashes, cooldowns, shop pricing, catering quality impact, recall penalties. Keep balanced and flavourful.

### For QAGPT
- Test consumable effects, cooldowns, party flows, catering orders, recalls, logging, and anti-abuse. Validate no interference with drug systems.  
# SECTION 088 — UK SHOPPING, STORES & ECONOMY NETWORK

## 87.0 Overview
Defines the shopping network: stores, stock, regional pricing, legality, and economy integration. Dark Luxury presentation; UK flavour; anti-laundering safeguards.

## 87.1 Store Types
- Legal shops: general stores, fashion, electronics, sports, medical, food/drink, travel, property utilities.
- Specialized: weapon shops (legal/restricted), armor shops (legal), garage/parts, pet shops, bookstores/education.
- Hidden/illegal: black-market vendors (Section 029/075); access gated; risk of bust.
- Event pop-ups: limited-time stock; cosmetics and consumables; same balance rules.

## 87.2 Stock & Pricing
- Stock varies by district wealth, events, weather (umbrellas in rain), heat (restricted items pulled during crackdowns).
- Prices vary by region; bulk discounts limited; sale events; dynamic restock timers.
- Legality: items flagged; restricted/illegal not sold openly; seized if found; shops enforce age/compliance flavour.

## 87.3 Purchasing & Limits
- Daily purchase caps for sensitive items (points, restricted gear, meds); anti-hoarding.
- Price bounds to prevent laundering; escrow not used for store buys; taxes/fees possible on restricted items.
- Refunds: limited to defects; logs; no abuse loops.

## 87.4 UI/UX
- Storefront: categories, stock, legality, prices, restock timer, region badge; Dark Luxury styling.
- Warnings for restricted/illegal items; risk banners during crackdowns; discount banners for sales/events.
- Mobile-friendly grids; filters; search.

## 87.5 Economy Integration
- Supply chain from companies; stock depletion triggers orders; delays possible from events/strikes; price shifts.
- Market resale allowed within bounds; trust influences fees; restricted items may be non-resaleable.
- Contracts between stores and companies for supply; SLA penalties; logged.

## 87.6 Anti-Abuse
- Laundering: price bounds, purchase caps, cooldowns, IP/device checks on bulk buys; limit resale margins.
- Dupes: store stock server-authoritative; anti-duplication of purchases.
- Point sales: daily caps; logs; monitored for laundering.

## 87.7 Interactions
- Events/weather: dynamic stock/pricing; crackdown pulls restricted items; festival pop-ups.
- Heat/police: high heat reduces availability of restricted items; increases chance of ID checks (flavour).
- Factions/Companies: discounts for allies; reputation affects access to certain stores; supply contracts affect availability.

## 87.8 Example Flows
- Rainy day: umbrella stock up; prices steady; restricted items pulled due to police sweep; warning in UI.
- Bulk ammo attempt: hits cap; purchase limited; log; resale price bound blocks laundering.
- Event shop: sells seasonal cosmetics; limited time; tradeable within bounds; logs.

### For Architect GPT
- Shopping network integrated with economy, companies supply, events/weather, legality/heat. Ensure store rules and anti-abuse consistent.

### For CodeGPT
- Implement store inventory/pricing, purchase caps, legality checks, dynamic restock by region/event, supply contracts, logging, anti-laundering limits. Server authority on purchases; UI APIs.

### For BalanceGPT
- Tunables: caps, price bounds, restock timers, regional multipliers, event effects, contract SLA penalties. Keep availability balanced; prevent stock exploits.

### For QAGPT
- Test purchases with caps, restricted warnings, restock timers, dynamic stock changes from events/weather, supply contract effects, logging, anti-laundering enforcement. Validate UI warnings and price bounds.  
# SECTION 089 — UK REGIONAL TRAVEL SYSTEM (REPLACES COUNTRIES)

## 88.0 Overview
Regional travel across UK cities/areas replaces international travel. Builds on Sections 016/036 with more routes, schedule flavour, and regional hooks. Risk, scans, and heat remain core; smuggling integrated; Dark Luxury UI.

## 88.1 Regions & Routes
- Regions: London (hub), Manchester, Birmingham, Bristol, Liverpool, Glasgow, Cardiff, Coastal/Docks, Highlands (event).
- Routes: train, coach, car/van, ferry/boat, regional flights (limited). Each with base time, cost, scan risk, ambush risk, cargo capacity.
- Route traits: weather and heat modifiers; strikes/blackouts can close/slow routes; alternate paths available.

## 88.2 Schedules & Tickets
- Trains/coaches/ferries have departure windows; timers start at departure; delays possible (weather/strikes).
- Tickets refundable with fee; class affects comfort only (happy tweak); no speed buff except premium reduced delay chance.
- Cars/vans depart instantly; time varies; ambush risk depends on route/time/weather.

## 88.3 Scans, Heat & Smuggling
- Scans at hubs; spot checks on roads; ferry scans moderate; flights strict. Heat and illegal cargo raise detection; concealment reduces slightly.
- Smuggling: high risk, high reward; certain routes favoured (night ferries, foggy trains); bust seizes cargo, fines/jail, rep hit; logs.
- Police events: checkpoints increase scan odds; national threat escalates scans (Section 072).

## 88.4 Ambush & Events
- Ambush chance based on heat, route, time, weather; gangs may target; combat resolves; cargo at risk.
- Events: strikes, protests, accidents; cause delays/closures; compensation; route reroutes.

## 88.5 UI/UX
- Travel planner: region list, modes, times/costs, scan/ambush risk bands, cargo info, departure timers; warnings for illegal items.
- HUD: status chip with route/mode/ETA; delay/ambush notifications; logs accessible.
- Dark Luxury styling; mobile route cards.

## 88.6 Anti-Abuse
- Teleport prevention; single active travel; refunds with cooldown/fee; pattern detection on cancel farming.
- Smuggling mule detection; escalating scans; IP/device checks.
- Server-authoritative timers; no client manipulation.

## 88.7 Interactions
- Crimes/black market: smuggling ties to black market; heat affects crime success regionally.
- Factions: regional war ops/logistics; convoys; events may restrict war travel temporarily (with notice).
- Properties: regional properties (Sections 017/064) require travel; stash accessible on arrival.
- Weather: delays/risks; fog aids smuggling; storms increase ambush.

## 88.8 Example Flows
- Train London→Manchester: ticket bought; 25m base; fog reduces scans; arrives; log.
- Ferry smuggling: night route; concealment; ambush chance; success yields profit/rep; failure seized + jail; log.
- Strike: route closed; refund with fee waived; compensation applied; timer cancelled; notification.

### For Architect GPT
- Regional travel system with schedules, scans, ambushes, and smuggling; integrates with black market, heat, weather, factions, properties, and logging.

### For CodeGPT
- Implement regional routes/modes, tickets, timers, delays, scans, ambush events, refunds/comp, logging, anti-abuse. Server authority; UI APIs for planner/status.

### For BalanceGPT
- Tunables: travel times/costs, scan/ambush odds, refund fees, compensation, smuggling rewards/risks, strike frequency. Keep legal travel reliable; smuggling profitable but risky.

### For QAGPT
- Test travel start/arrival, schedules/delays, scans/seizures, ambush outcomes, refunds/comp, single-trip enforcement, logging, and warnings. Validate weather/heat effects and smuggling odds.  
# SECTION 091 — THE UK WEAPON SYSTEM

## 90.0 Overview
Weapons system with UK legality, categories, stats, and acquisition. Complements Sections 006/047/051/052/090. Emphasizes legality, heat, and realistic flavour.

## 90.1 Categories
- Melee (blades/blunt/improvised), Firearms (pistols, SMGs, shotguns, rifles, DMRs), Exotic/DIY, Non-lethal (rubber), Throwables (Section 048), Shields (Section 051).
- Each defined with stats, legality, noise, durability, mod slots.

## 90.2 Legality & Access
- Legal: basic knives/tools, some sporting shotguns; Restricted: many firearms; Illegal: DIY, high-capacity mags, automatic conversions, illegal mods.
- Shops sell legal/restricted (with gating); illegal via black market; seizures if caught; travel scans.
- Licenses: flavour only; used as gating for some restricted purchases; logs; not real-world legal compliance but consistent flavour.

## 90.3 Stats & Balance
- Stats per category: damage, accuracy, crit, penetration, recoil, noise, weight, durability, range profile, mod slots.
- Caps: accuracy/crit/dodge caps; penetration balanced to avoid one-shot metas; encumbrance impacts initiative.
- DIY: high malfunction; lower damage; high heat risk.

## 90.4 Acquisition
- Legal shops (restricted gating), black market, loot (crimes/heists), crafting (illegal DIY), events (cosmetic skins).
- Duplicates prevented by IDs; price bounds; escrow for trades; legality persists through trades.

## 90.5 Mods/Ammo
- Mods per Section 052; ammo types per Section 047; legality of mods/ammo affects heat; subsonic reduces noise; AP raises wear.

## 90.6 Heat & Policing
- Carrying illegal/restricted in high-heat areas raises patrol risk; scans seize; fines/jail; heat increase.
- Crimes: noise and legality affect jail odds; suppressors reduce noise but not legality; illegal weapons raise failure penalties if caught.

## 90.7 UI/UX
- Weapon cards: stats, legality, ammo/mods, noise, durability, origin; warnings for legality and noise.
- Shop UI shows gating and heat risk; black market shows bust risk; Dark Luxury styling.

## 90.8 Anti-Abuse
- Anti-dupe; price bounds; mod stacking caps; legality checks on equip/travel/crimes; seizure logging.
- Collusion on trades detected; laundering blocked via bounds and logs.

## 90.9 Example Flows
- Player buys restricted pistol with license gating: allowed; noise warns; heat risk; logs.
- Illegal DIY rifle: high malfunction; seized at scan; jail/fine; heat up; log.
- Subsonic ammo + suppressor: noise reduced; damage down; legality unchanged; crime risk lower for noise, not legality.

### For Architect GPT
- Weapon system with legality and UK flavour; integrate with mods/ammo, combat, crimes, policing, shops/black market.

### For CodeGPT
- Implement weapon templates with stats/legality, acquisition gating, mod/ammo integration, heat checks, logging, anti-dupe. Enforce legality on travel/crimes; shop gating and black-market risk.

### For BalanceGPT
- Tunables: base stats, legality gating, mod/ammo effects, heat penalties, malfunction for DIY, price bounds. Keep variety viable; prevent meta dominance.

### For QAGPT
- Test purchase/equip with legality gating, mod/ammo effects, heat/seizure, malfunction, logging, and anti-dupe. Validate warnings in UI.  
# SECTION 092 — THE UK DRUG SYSTEM

## 91.0 Overview
UK drug system flavour and legality overlay for the consolidated drug rules (Sections 024/029/060/066/084). Emphasizes street categories, slang, and enforcement without changing mechanics.

## 91.1 Categories & Slang
- Stims: “Lines,” “Boosters,” borough-branded (BlocRush, RailLine).
- Downers/Painkillers: “Bricks,” “Night Doc.”
- Hallucinogens: “Veil,” “Trip.”
- Performance blends: “Obsidian Mix,” “Designer Chems.”
- Medical: legit meds (scripts), over-the-counter basics.
- Specials: Black-market exclusives with UK street branding.

## 91.2 Legality & Enforcement (UK Flavour)
- Simple flavour licenses for certain meds; illegal for most street chems; possession with intent increases penalties.
- Police heat bands reflect UK policing rhythms; stings, raids, scans; seizures logged; fines/jail similar to core rules.
- Public use frowned; increases patrol chance; certain districts (nightlife) slightly more tolerant but still risky.

## 91.3 Distribution & Scenes
- Nightlife districts fuel stim demand; estates fuel painkiller/downer abuse; festivals/events increase hallucinogen demand; docks/rail hubs for smuggling.
- Black market distribution nodes at estates, clubs, docks; risk varies by heat and events.

## 91.4 UI/UX & Lore
- Use UK slang in flavour text; maintain clarity; keep Dark Luxury presentation; legality warnings.
- Missions reference UK scenes (clubs, estates, docks, rail yards); drug names and effects stay within established mechanics.

## 91.5 Anti-Drift
- No US DEA tropes; no glamorization; grounded UK crime drama; no fantasy chems.

### Detailed Mechanics — UK Drug System Core

**Drug Families & Roles**  
The UK Drug System is split into clear families, each with a gameplay role:

- **Soft Stimulants** (energy drinks, mild pills): cheap, low-risk, small Energy/Nerve boosts, near-zero addiction. Good for new players.
- **Hard Stimulants** (strong pills, powders): high Energy/Nerve spikes, crime and combat buffs, medium to high addiction and crash risk.
- **Depressants & Sedatives** (downers, painkillers): reduce incoming damage or hospital time, boost Life/Happy, may reduce accuracy and initiative.
- **Performance Enhancers** (steroids, combat enhancers): temporarily increase battle stats or working stats (MAN/INT/END) with serious long-term side effects.
- **Psychedelics** (trip-style drugs): medium buffs to Happy/creative missions, heavy debuffs to precise combat and high paranoia effects.
- **Medical & Legalised** (prescriptions, government-approved): low buffs with special missions, low addiction but tightly controlled and expensive.

Each drug is defined by: **family, potency tier, onset time, peak duration, cooldown, addiction weight, legality, trafficking risk, and rarity.**

**Consumption Flow**  
When a player uses a drug, apply these steps in order:

1. **Check Cooldowns & Stacking**
   - If the player has an active effect from the same family, apply diminishing returns and increase overdose risk instead of full effect.
   - Global “recent high-risk drug use” flags can also increase police heat and random event chances.

2. **Apply Primary Effects**
   - Modify **bars**: Energy, Nerve, Happy, Life according to drug family and potency.
   - Apply **temporary modifiers**: e.g. accuracy +X%, crit chance +Y%, stealth +Z, working stat multipliers, or defence buffs.
   - Mark a **hidden effect token** so other systems (Crimes, Combat, Missions, Factions) know the player is currently under influence.

3. **Schedule Decay & Crash**
   - Each drug instance creates a timed effect with:
     - Onset → Peak → Fade → Crash (where applicable).
   - Crash phases can apply stat maluses, Happy drops, Life ticks, or reduced Nerve regen.

4. **Log Usage & Risk Signals**
   - Every dose writes to a **Drug Log** (for QA, anti-abuse and faction intel):
     - Player, drug, dose, location, source (NPC dealer, faction lab, travel, market), timestamp, and any linked events (crime immediately after, PvP, etc.).

**Addiction & Withdrawal Model**  
Addiction is tracked per **drug family** rather than single items to keep it manageable:

- Each dose adds **Addiction Points (AP)** to that family, scaled by potency and current AP (diminishing returns at extreme values to avoid integer overflow).
- Thresholds:
  - **Mild addiction:** small Happy penalty when sober, occasional cravings (mission prompts, flavour text).
  - **Moderate addiction:** stronger Happy penalties, reduced bar regen when clean, increased crash severity.
  - **Severe addiction:** heavy debuffs (damage, accuracy, Nerve regen), high chance of random negative events if the player refuses to use again.

Withdrawal is triggered if:

- AP is above a threshold AND the player hasn’t used that family for X hours/days.
- Apply time-limited debuffs that can be eased by:
  - Using again (short-term relief, long-term worse AP),
  - Using detox items or visiting a **Rehab/Clinic** (cash sink),
  - Completing specific missions or counselling events.

**Overdose & Medical Consequences**  
Overdose (OD) is calculated from:

- Active stacked effects,
- Recent doses (last N minutes),
- Drug family risk,
- Player modifiers (perks, faction bonuses, medical traits).

Outcomes can include:

- Heavy Life damage and instant hospitalisation.
- Item loss (dropped drugs / cash in a panic or during police intervention).
- Temporary stat damage (soft permanent debuffs that can be repaired slowly).
- Police heat spikes, extra logs, or special “OD incident” missions.

**Economy & Supply Chains**  
Drugs are integrated into multiple economies:

- **City Dealers:** mid-price, safe baseline supply; prices react slowly to demand.
- **Faction Labs / Turf:** discounted or buffed drugs for members, but increase faction exposure to raids and special police events.
- **Travel & Smuggling:** buy low abroad, sneak back into Trench City through Travel and Risk & Reward; failure feeds items into city seizures or NPC markets.
- **Black Market:** rare, experimental or ultra-potent variants with extreme risk/reward, often tied to events or narrative arcs.

Prices and availability should subtly react to **arrests, big busts, major events, and faction control of key territories**, giving BalanceGPT clear levers for tuning sinks and spikes.

**Anti-Abuse & Exploit Notes**  

- Cap beneficial stacking: only top N active drug effects can apply full buffs, others are heavily diminished.
- Detect suspicious patterns:
  - Perfectly timed loops of use → crime → hospital → use, 24/7.
  - Unusual volumes of rare drugs moving through a single account/faction with no corresponding Travel/Crime history.
- Use server-side checks instead of client-visible constraints so abusers can’t see exact thresholds.
- Ensure every drug faucet (loot, events, faction lab output) has at least one clear sink (use, decay, spoilage, raids, confiscation).

### For Architect GPT
- Flavour/lore layer for drug system; integrates with existing mechanics; no stat changes.

### For CodeGPT
- Ensure naming, flavour, and legality messaging align with UK context; mechanics unchanged. Strings centralized for localization; maintain warnings.

### For BalanceGPT
- No mechanical tunables here; ensure flavour doesn’t imply extra power.

### For QAGPT
- Validate flavour consistency, warnings, and legality messaging; ensure no drift or mechanical changes.  
# SECTION 093 — THE UK GANG CULTURE SYSTEM

## 92.0 Overview
UK gang culture flavour and structural rules to ground gangs/factions in authentic street context without real-gang references. Supports missions, crimes, NPCs, and social cues. Dark Luxury presentation; no glamorization; grounded crime drama.

## 92.1 Gang Identity & Flavour
- Names: fictional, UK-influenced; estate/tower/block references; no real gangs; naming engine enforces.
- Symbols: abstract; borough colours; avoid real gang insignia; moderated.
- Language: UK slang used sparingly; authentic but readable; no caricature.

## 92.2 Structure & Roles
- Hierarchy: leader, lieutenants, soldiers, associates. Prospects in street crews; graduation to factions allowed.
- Ranks reflect UK street flavour; titles moderated to avoid real-world references.
- Codes: loyalty, territory, rep; betrayal triggers hostility; deserter flags; consistent with faction systems.

## 92.3 Territory & Activity
- Turf tied to estates/blocks/streets; disputes over corners, shops, docks; reflected in crimes and NPC gangs (Sections 065/070/084).
- Activities: smuggling, protection, fraud, robberies, black market influence. No glorified real-world gangs.
- Heat interplay: high-profile acts attract police; raids possible; gang presence modifies crime odds.

## 92.4 Social & Lore Integration
- Missions and dialogue reference UK estates, council life, CCTV, knives vs guns debate, youth slang; keep tone serious.
- Newspapers/feeds cover gang disputes; factions/gangs appear in logs; cosmetic gang markings allowed (Section 079) with moderation.

## 92.5 Anti-Drift & Safety
- No real-world gang names/logos; moderated; filters in naming engine.
- No glamorization of violence; consequences shown (hospital/jail/heat); Dark Luxury tone not cartoonish.
- Cultural respect: avoid stereotypes; keep writing grounded and responsible.

### For Architect GPT
- Flavour framework for gang culture; ties into naming, missions, NPC gangs, and territory. Mechanics already defined in faction/gang sections.

### For CodeGPT
- Enforce naming/marking moderation; ensure flavour text uses UK context; maintain filters; apply to gangs/factions and cosmetics.

### For BalanceGPT
- Not mechanical; ensure lore cues don’t imply extra power; maintain risk/consequence messaging.

### For QAGPT
- Check for prohibited names/insignia enforcement, lore consistency, and tone alignment; ensure consequences shown and no glamorization.  
# SECTION 094 — THE UK BLACK MARKET NETWORK

## 93.0 Overview
Black market network flavour/spec for UK context; aligns with Sections 029/075/088/089. Defines vendor types, routes, busts, and risk. Emphasizes covert access, heat, and anti-abuse.

## 93.1 Vendor Types
- Alley Vendors: small stock (tools, low-tier drugs); mobile; low cost; high counterfeit risk.
- Dock Brokers: smuggling gear, illegal weapons/mods, concealment; higher prices; moderate bust risk.
- Club Contacts: stim-heavy stock, forged IDs; tied to nightlife; stock rotates with events.
- Syndicate Suppliers: high-tier items (illegal mods, black ops gear); gated by rep/level; highest risk; limited windows.

## 93.2 Access & Routes
- Access gated by rep, level, informants; location/time/weather (night/fog favourable); events may add pop-ups.
- Routes: docks, rail yards, estates, clubs; travel needed; smuggling routes from Section 089 tie in; patrol/bust risk varies.

## 93.3 Stock & Pricing
- Dynamic stock; limited quantities; price variance by heat/weather/events; surge pricing during crackdowns; discounts at high rep.
- Counterfeits possible at low rep; quality displayed as band; legality flagged.

## 93.4 Busts & Stings
- Bust chance on purchase; higher with heat, low rep, high-tier items; outcomes: seizure, fines/jail, rep loss.
- Stings: rare events; vendor compromised; triggers ambush/police; logged.
- Seizures logged; items removed; heat increases.

## 93.5 Anti-Abuse
- Purchase limits per window; IP/device correlation; mule detection; price bounds; no escrow to prevent laundering.
- Counterfeit detection chance; prevents guaranteed profit flips; tagged items.
- Travel reroll abuse blocked; server uses current state at purchase.

## 93.6 UI/UX
- Covert UI: risk bands, stock, prices, rep requirements, timers; warnings for bust/counterfeit; Dark Luxury styling.
- Logs: purchases, busts, stings, rep changes; accessible to player and moderation.

## 93.7 Interactions
- Crimes: tools/drugs; black ops gear; busts affect heat and jail; black-market rep changes.
- Smuggling: vendors feed routes; seizures on travel; heat modifies availability.
- Factions: faction-only suppliers possible; war-state may change stock; risk high.
- Shadow economy: goods and currency tied; laundering caps apply.

## 93.8 Example Flows
- Dock broker at night fog: player buys illegal mod; bust chance moderate; succeeds; rep up; log.
- Sting: club contact compromised; purchase triggers ambush; item seized; jail; rep down.
- Counterfeit: low rep; buys stim; quality poor; effect reduced; log shows counterfeit; no refund.

### For Architect GPT
- UK black market network flavour with risk/busts; integrates with smuggling, crimes, factions, and shadow economy. Keep mechanics consistent with earlier sections.

### For CodeGPT
- Implement vendor types, stock rotation, rep gating, bust/counterfeit/sting logic, purchase limits, logging, and anti-abuse. Server authority; tie into heat/travel.

### For BalanceGPT
- Tunables: bust/counterfeit odds, stock rarity, price ranges, rep thresholds, purchase limits. Keep risk meaningful; profits not guaranteed.

### For QAGPT
- Test access gating, purchase/bust flows, counterfeit behaviour, stock rotations, limits, logging, and interactions with heat/travel. Validate no laundering via price bounds.  
# SECTION 095 — CRIME SYSTEM 3.0

## 94.0 Overview
Final crime system layer consolidating 1.0/2.0/3.0 into a single reference (Sections 009/065/068). Covers categories, scaling, heat/police, OCs/black ops, and anti-abuse.

## 94.1 Crime Taxonomy
- Base: pickpocketing, shoplifting, vandalism, mugging, burglary, car theft, fraud, cyber, smuggling, robberies, kidnap, assaults.
- Advanced: OCs (multi-role), black ops (faction), fraud syndicates, elite heists.
- Support: busting, bribery (limited), scouting (intel).

## 94.2 Mechanics & Scaling
- Success formula uses nerve, stats, tools, education, location, weather/time, heat, gang presence; minimum fail chance.
- Difficulty bands by level/rank; adaptive scaling; blue star rare outcomes remain; DR on repeats.
- Heat integral: increases jail odds and patrol/scan risk; decays; critical heat triggers police events.

## 94.3 Resources & Costs
- Costs: nerve (primary), sometimes energy; tool consumption; optional cash costs (bribes/prep).
- Cooldowns: per crime; OCs/black ops longer; fraud/heist lockouts; anti-spam.

## 94.4 Rewards & Penalties
- Rewards: cash, items, XP, points (rare), respect (for faction crimes), crime stars, achievements.
- Penalties: jail, hospital, heat spike, tool loss, asset seizure (fraud), respect loss if war context.
- Blue star remains rare; logged; no bypass of fail chance.

## 94.5 Tools & Roles
- Tools improve odds; quality matters; mandatory for some crimes; vehicle roles for heists; IP/device checks to enforce team uniqueness on OCs/black ops.
- Roles: leader, hacker, muscle, driver, lookout, negotiator depending on crime.

## 94.6 Anti-Abuse
- Diminishing returns on repeated easy crimes; captcha on spam patterns; location/time gating enforced server-side; heat prevents trivial spam; staged OCs flagged; same-IP teams throttled.
- Auto-block teleport/exploit; crime rerolls not allowed; server authoritative.

## 94.7 UI/UX
- Crime console: category tabs, requirements, risk band, projected rewards band, heat impact, tool/role assignment for OCs/black ops; timers and cooldowns.
- Logs: outcomes, rewards, heat changes, jail/hospital, tools used, blue stars; faction/city logs for OCs/ops.

## 94.8 Interactions
- Heat/police (Section 072), informants (Section 071), black market (Section 093), gangs (Section 070), factions (Sections 012/065/074), travel/smuggling (Section 089), weather/events (Section 083).

## 94.9 Example Flows
- Fraud 3.0: high nerve/INT; success big payout; failure seizure/jail; cooldown long; log.
- Black op sabotage: team executes; heat spike; enemy notified; respect awarded; cooldown.
- OC: roles set; countdown; success yields cash/respect; failure jails team; DR on repeats of same OC.

### For Architect GPT
- Final crime spec integrating heat, roles, OCs/black ops, and anti-abuse. Ensure all modules reference central crime service.

### For CodeGPT
- Implement crime service with category data, success calc, heat/jail, tools/roles, cooldowns, DR, OCs/ops orchestration, logging, anti-abuse. Server authority; IP/device checks for team exploits.

### For BalanceGPT
- Tunables: success weights, heat gains/decay, jail times, loot tables, blue star odds, cooldowns, DR slopes, seizure penalties. Maintain risk/reward and minimum fail chance.

### For QAGPT
- Test crime outcomes across bands, heat effects, tool/role checks, OCs/ops flows, cooldowns, DR, logging, anti-abuse triggers, and UI risk bands. Validate seizure and critical heat behaviours.  
# SECTION 096 — UK VEHICLE & STREET RACING SYSTEM

## 95.0 Overview
UK-focused vehicle and street racing system, synthesizing Sections 040/046/077/089. Emphasizes legal vs street, police response, weather/road impact, and anti-collusion.

## 95.1 Vehicle Classes & Legality
- Classes: A (exotics), B (sports), C (sedan/coupe), D (bikes/hatchbacks), Vans/Trucks (utility), Illegal DIY (high risk).
- Legality: street races with illegal mods allowed but risky; legal races require compliance and scrutineering; illegal vehicles raise patrol risk during travel.

## 95.2 Tracks & Routes
- Legal tracks: organized circuits; weather-aware; entry fees; scheduled events.
- Street routes: borough roads, docks, industrial estates, ring roads; ambush/police risk; traffic/weather affect handling.
- Events: time trials, sprints, drag, checkpoint races; leaderboards; anti-repeat pairing.

## 95.3 Performance Calculations
- Performance = vehicle base stats + mods + driver stats (Speed/Dex) + handling penalties/bonuses from weather/road.
- RNG for mishaps (spin, minor crash) influenced by maintenance and illegal mods; damage applies to vehicles; small injury chance.

## 95.4 Police & Heat
- Street races raise heat; police chase chance; roadblocks; fines/jail if caught; vehicles can be seized if illegal/extreme.
- Legal races safe from police; heat not affected.

## 95.5 Rewards & Progression
- Rewards: cash/tokens/cosmetics; legal races pay less but safe; street races pay more but risk; seasonal events grant skins/titles.
- Cooldowns: per vehicle/player to prevent spam; lockout after major crash/police bust.

## 95.6 Anti-Collusion & Abuse
- Matchmaking avoids repeat same-IP/device; reward scaling down if detected; disqualifications for collusion.
- Anti-throwing: minimum performance standards; sandbag detection; logs with seeds.
- Illegal mod scrutineering for legal races; disqualify if found.

## 95.7 UI/UX
- Racing lobby: legal/street tabs, class filters, track/route info, weather, risk bands, entry fees, rewards; scrutineering results.
- Post-race log: placement, times, mishaps, damage, rewards, heat/police outcomes; Dark Luxury styling.

## 95.8 Interactions
- Vehicles/mods/maintenance (Section 077); travel (Section 089); car crimes (Section 090); heat/police (Section 072); weather (Section 083).
- Companies: racing teams or garages can host events or service vehicles.
- Factions: internal races for respect/cosmetics; war logistics unaffected by racing heat.

## 95.9 Example Flows
- Legal race: passes scrutineering; finishes 2nd; reward modest; wear applied; no heat.
- Street race in rain: handling penalty; illegal mods; police chase triggers; heat +; small injury; cooldown.
- Collusion attempt: same IP opponents repeatedly; rewards reduced; warning; repeat → disqualify and flag.

### For Architect GPT
- Vehicle/racing system with UK context, legal vs street, police heat, and anti-collusion. Integrates with vehicles, mods, heat/police, weather, and logging.

### For CodeGPT
- Implement racing matchmaker, performance calc, mishap RNG, scrutineering, police chase logic, cooldowns, logging, anti-collusion checks. Server authority.

### For BalanceGPT
- Tunables: rewards/fees, mishap odds, police chase odds, cooldowns, heat impact, class balance, scrutineering strictness. Keep risk/reward for street vs safety for legal.

### For QAGPT
- Test race flows, scrutineering, mishaps, police chases, cooldowns, anti-collusion, logging, UI risk bands, and weather effects. Validate seizures on illegal extremes if caught.  
# SECTION 097 — THE BLACK MARKET SYSTEM

## 96.0 Overview
General black market system summary aligning all prior black-market sections (029/075/093). Defines access, stock, risk, busts, and anti-abuse as a central reference.

## 96.1 Access & Reputation
- Requires level/rep and informant intros; tiers unlock higher goods; rep gained by successful buys/smuggles; lost on busts/counterfeits/stings.
- Access influenced by time/weather/location; events add/limit vendors.

## 96.2 Goods & Services
- Goods: illegal weapons/mods, drugs, nerve kits, forged IDs, jammers, concealment, illicit upgrades, crafting mats.
- Services: smuggling routes, covert transport, illicit repairs, intel. High cost; risk of sting; logs.

## 96.3 Pricing & Stock
- Dynamic; small ranges; limited quantities; surge during crackdowns; discounts at high rep; counterfeit risk at low rep.
- Stock rotation; time-limited; quality bands shown as ranges.

## 96.4 Risk & Enforcement
- Bust/sting chances scale with heat, rep, item tier, location/time; outcomes: seizure, fines/jail, rep loss, heat spike.
- Travel scans seize illegal goods; raids on known vendors; logs.

## 96.5 Anti-Abuse
- Purchase caps; cooldowns; IP/device checks; mule detection; price bounds to stop laundering; no escrow.
- Counterfeits prevent guaranteed profit; tagged; logging; cannot cleanse via trade.
- Server authoritative; no reroll by reconnect; state fixed at purchase.

## 96.6 UI/UX
- Black market UI: risk bands, stock, prices, rep requirements, timers, warnings; Dark Luxury styling.
- Logs for purchases, busts, rep changes, seizures; player view and mod audit.

## 96.7 Interactions
- Crimes/smuggling, factions, shadow economy, labs/crafting, heat/police, travel.
- Events/National threat alter stock/risk; informants can reveal windows.

## 96.8 Example Flows
- High-rep buy: illegal mod with low bust chance; success; rep up; log.
- Counterfeit: low rep; item weak; effect reduced; log; no refund.
- Sting: high heat; purchase triggers bust; item seized; jail; rep down; heat spikes.

### For Architect GPT
- Central black market reference integrating access, stock, risk, and anti-abuse. Ties to heat, smuggling, crafting, shadow economy, and policing.

### For CodeGPT
- Implement rep/tiers, stock rotation, risk calc, purchases with bust/counterfeit, caps, mule detection, logging. Enforce price bounds and server authority.

### For BalanceGPT
- Tunables: bust/counterfeit odds, rep thresholds, stock rarity, purchase limits, price ranges, national threat effects. Keep high risk/reward; prevent laundering.

### For QAGPT
- Test access gating, stock rotation, bust/counterfeit/sting outcomes, caps, logging, and interactions with heat/travel. Validate price bounds and anti-mule checks.  
# SECTION 098 — UK DRUG SYSTEM 3.0

## 97.0 Overview
UK-focused flavour wrap for the consolidated drug mechanics (Sections 084/091/066). Reinforces legality, slang, and scene context without changing the math.

## 97.1 Categories & Scenes
- Stims (“Lines,” “Boosters”), Downers (“Bricks”), Hallucinogens (“Veil”), Performance blends (“Designer Chems”), Medical (scripts), Specials (black-market exclusives).
- Scenes: nightlife districts for stims, estates for downers, festivals/events for hallucinogens, docks/rail for smuggling.

## 97.2 Legality & Enforcement
- Most street chems illegal; possession/use increases heat; seizures on scans; fines/jail; black-market rep loss.
- Prescription flavour for medical; checks minimal (gameplay gate only).
- Public use in high-heat zones more dangerous; nightlife slightly more tolerant but still risky.

## 97.3 Distribution & Vendors
- Black-market vendors with regional flavour: estate runners, club dealers, dock brokers; rep gating; stock shifts with events/weather.
- Counterfeit risk at low rep; quality bands; stings possible; bust risk influenced by heat/time.

## 97.4 UI/UX & Tone
- Use UK slang sparingly in names/descriptions; keep clarity; Dark Luxury styling; legality warnings.
- Missions/events reference UK settings (clubs, estates, docks); consequences shown (hospital/jail/heat).

## 97.5 Anti-Drift
- No real brands/gangs; no glamorization; grounded crime drama; enforce consequences; UK spelling/slang.

### For Architect GPT
- Flavour wrapper for drug system; integrate with existing mechanics; ensure UK tone.

### For CodeGPT
- Ensure flavour strings, vendor placements, and legality warnings reflect UK context; no mechanical changes.

### For BalanceGPT
- Not mechanical; ensure flavour doesn’t imply stronger effects.

### For QAGPT
- Validate flavour consistency, legality messaging, vendor context, and that mechanics remain unchanged.  
# SECTION 099 — UK WEAPON SYSTEM 4.0

## 98.0 Overview
Further refinement of UK weapon system with clarity on legality, sourcing, and balance. Builds on Sections 091/047/052/095. Ensures no single-meta weapon and tight legality enforcement.

## 98.1 Categories & Balance Goals
- Pistols/SMGs/Shotguns/Rifles/DMRs/Exotic/DIY/Non-lethal/Melee/Throwables/Shields. Each fills a niche: pistols versatile, SMGs close/mid, shotguns close burst, rifles mid/long pen, DMRs precision, exotic/DIY high risk, non-lethal niche, melee stealth/low noise.
- Balance: prevent one-shot metas; protect melee viability in stealth; DIY risky.

## 98.2 Legality & Sourcing
- Legal/restricted/illegal flags; shop gating for restricted; black market for illegal; scans and heat applied.
- Licenses (flavour) required for some restricted buys; logs; cannot bypass legality via skins.
- DIY and converted full-auto always illegal; high malfunction; bust risk high.

## 98.3 Stats & Caps
- Damage, accuracy by range, crit, penetration, recoil, noise, weight, durability, mod slots; caps on accuracy/crit/dodge; penetration tuned to avoid bypassing armor completely.
- Noise impacts crimes; suppressed weapons reduce noise but damage/accuracy penalty; noise does not legalize illegal weapons.

## 98.4 Mods/Ammo Interaction
- Mods (Section 052) and ammo (Section 047) apply; diminishing returns; jam chance rises with drums/AP; subsonic lowers noise; AP increases wear.
- Compatibility strictly enforced; illegal mods flagged; scrutineering in legal races/events prevents use.

## 98.5 Acquisition & Trade
- Shops for legal/restricted; black market for illegal; loot/crafting; trades with price bounds; anti-dupe IDs; legality persists.
- Event cosmetics separate; zero stat change; cannot alter legality.

## 98.6 Heat & Enforcement
- Carrying illegal/restricted in public increases patrol/scan risk; seizures; fines/jail; heat spike.
- Crimes: noise/legality influence jail odds; suppressed helps noise only; illegal weapon still illegal.

## 98.7 UI/UX
- Weapon cards with legality, range profile, stats, mods/ammo, noise, durability; warnings.
- Shop/black market messaging clear on risk/gating; Dark Luxury styling.

## 98.8 Anti-Abuse
- Anti-dupe; price bounds; cap stacking; enforcement on legality checks; IP/device checks for trade laundering; server authority on legality status.

## 98.9 Example Flows
- Restricted rifle buy with license: allowed; legality retained; heat risk; logs.
- DIY conversion: illegal; malfunctions; seizure at scan; jail/fine; heat.
- Subsonic + suppressor: quiet; damage down; legality unchanged; crime risk reduced for noise but still illegal if weapon is.

### For Architect GPT
- Refined weapon spec with legality/balance; integrate with combat, crimes, shops/black market, and policing.

### For CodeGPT
- Enforce legality gating on acquisition/equip/travel, mod/ammo compatibility, noise/legality effects, anti-dupe/trade bounds. Keep caps and server authority.

### For BalanceGPT
- Tunables: category baselines, cap values, mod/ammo effects, malfunction rates, heat penalties. Ensure multiple viable builds; avoid dominant weapon.

### For QAGPT
- Test legality checks, mod/ammo compatibility, caps, noise/legal interactions, malfunction rates, logging, and trade bounds. Validate UI warnings and scrutineering.  
# SECTION 100 — ARMOUR, SHIELDS & DEFENCE SYSTEM 4.0

## 99.0 Overview
Finalized defence spec combining armor, shields, mods, and defensive items. Builds on Sections 050/051/053/099; focuses on resistances, encumbrance, legality, and balance.

## 99.1 Armour & Shields Recap
- Armour slots: head/torso/legs; types: light/medium/heavy/specialized/covert.
- Shields: riot/tactical/improvised/rare tech; off-hand coverage; encumbrance penalties; legality enforced.
- Stats: flat/% mitigation, resist types, crit/status resist, encumbrance, noise, durability, legality.

## 99.2 Mods & Enhancements
- Armour mods: plates, padding, liners, stealth mesh, status dampeners, utility pouches; capped stacking; illegal variants raise heat.
- Shield mods: viewport reinforcement, padding, coatings, weight reduction; limited slots; diminishing returns.
- Augments: HUD, exo-assist (light), biomonitor; cosmetic/utility minor; no sci-fi power; legality noted.

## 99.3 Encumbrance & Mobility
- Encumbrance reduces initiative/dodge; Strength/Speed mitigate slightly; caps to prevent immobility.
- Heavy gear reduces stealth; crime UI warns; racing/travel penalties minimal but present for bulky illegal gear.

## 99.4 Durability & Repair
- Durability loss on hits; AP/explosives increase loss; zero durability = no mitigation; repairs via companies/black market; illegal mods may block legal repair.
- Salvage broken items for materials; mods may be recovered.

## 99.5 Legality & Heat
- Restricted/illegal armor/shields raise scan/police risk; seizures; fines/jail; heat spikes; covert gear lowers noise but not legality.
- Scrutineering for legal events/races disallows illegal armour/shields.

## 99.6 Anti-Abuse & Balance
- Cap stacking to avoid invincible tanks; status resist caps; mod slots limited; price bounds; anti-dupe IDs; server authority.
- No stealth invisibility from cosmetics; armour skins cosmetic only.

## 99.7 UI/UX
- Armour/shield cards: stats, resist tables, encumbrance, durability, mods, legality; warnings for illegal/low durability/encumbrance.
- Compare and set indicators; Dark Luxury styling; scrutineering results shown when relevant.

## 99.8 Example Flows
- Player equips heavy armor + shield: mitigation high; encumbrance/heat up; dodge down; logs; seizures if scanned in public.
- Armour with stealth liner: noise down; encumbrance up; heat unchanged; crime stealth better; caps enforced.
- Broken armor: no mitigation; warning; repair or salvage; logs updates.

### For Architect GPT
- Defence system unify armour/shields/mods with legality and balance controls; integrate with combat, crimes/heat, repairs, and shops/black market.

### For CodeGPT
- Implement defence templates, encumbrance/caps, durability loss/repair, legality checks, mod/augment handling, scrutineering, and logging. Enforce anti-dupe and price bounds.

### For BalanceGPT
- Tunables: mitigation/resist values, encumbrance penalties, mod effects/caps, durability loss/repair costs, heat penalties. Ensure multiple viable builds; prevent invincible setups.

### For QAGPT
- Test equip/encumbrance, resist calc, durability loss/repair, mod caps, legality/scan, scrutineering, logging, and UI warnings. Validate anti-dupe and price bounds.  
# SECTION 101 — CLOTHING, STYLE, MASKS & COSMETIC IDENTITY SYSTEM 5.0

## 100.0 Overview
Final cosmetic identity layer: clothing, masks, style presets. Purely visual; no stealth/defense. Dark Luxury + UK street flavour; heavy moderation; integrates with identity and market.

## 100.1 Clothing & Style
- Wardrobe covers outfits, layers, accessories; themes by borough/event/faction; rarity tiers; no stats.
- Style presets: save/load looks; mix-and-match allowed within palette rules; high-contrast options.
- Masks: cosmetic only; cannot grant stealth; moderated; event/faction variants; no voice filters affecting gameplay.

## 100.2 Acquisition & Trading
- Shops, events, achievements, faction/company rewards, prestige shop; some bound; others tradeable.
- Trade bounds to prevent laundering; anti-dupe; authenticity tags; gift cooldowns; moderation for custom emblems.

## 100.3 UI/UX
- Wardrobe UI with filters, previews, presets; Dark Luxury; background context; accessibility toggles.
- Market listings show cosmetic-only; risk-free; rarity; bounds.
- Profile integration: displays chosen style; badges/titles complement; no clutter.

## 100.4 Anti-Abuse
- No gameplay effects; stealth/defense unaffected; palette rules prevent invisibility.
- Moderation: filter offensive content; reports; strikes; blocklist enforcement.
- Anti-laundering via price bounds and gift cooldowns; server-authoritative inventories.

## 100.5 Example Flows
- Player equips event mask and borough outfit; profile updates; no stats; log recorded.
- Market trade: cosmetic jacket sold within bounds; authenticity verified; no laundering.
- Attempted dark-invisible skin: blocked by palette; warning; not applied.

### For Architect GPT
- Cosmetic identity system integrated with identity/profile, shops/market, moderation, and accessibility. Ensure zero mechanical impact.

### For CodeGPT
- Implement wardrobe, presets, mask handling, trade bounds, gift cooldowns, moderation pipeline, anti-dupe. Enforce palette rules and no-stat effects.

### For BalanceGPT
- Minimal: rarity distribution, price bounds, gift cooldowns. Ensure cosmetics aspirational without economy abuse.

### For QAGPT
- Test equip/trade/gift with bounds, palette enforcement, moderation, logging, and confirmation of zero gameplay impact.  
# SECTION 102 — VEHICLES & TRANSPORTATION SYSTEM

## 101.0 Overview
Core transport system recap: vehicle ownership, maintenance, travel integration, smuggling, and compliance. Synthesizes Sections 040/046/077/089/095 for a unified view.

## 101.1 Ownership & Garages
- Unique IDs per vehicle; titles; legality flags; garages tied to properties (Section 035) with capacity; hidden bays for illegal vehicles; permissions.
- Maintenance: wear from travel/racing; repairs via companies; neglect increases breakdown/scan risk; insurance for legal vehicles only.
- Transfers: trade with price bounds, anti-dupe, escrow; illegal status persists; logs.

## 101.2 Travel Integration
- Road travel uses vehicle stats/mods to adjust time/ambush risk; cargo tied to vehicle capacity; concealment reduces scan odds.
- Travel status blocks most actions; single active trip; heat/illegal mods raise scan risk; weather affects handling/time.

## 101.3 Smuggling
- Vehicles enable higher cargo; concealment compartments; overclocking shortens time but raises heat/breakdown.
- Scans and roadblocks can seize; bust leads to fines/jail; heat spikes; black-market rep down.

## 101.4 Compliance & Legality
- Legal vehicles with compliance (MOT/insurance flavour) reduce scan/police penalties; illegal/stolen/overmodded vehicles raise risk.
- Scrutineering for legal races; illegal mods disallowed; travel scans seize illegal conversions.

## 101.5 UI/UX
- Garage view: vehicles, condition, legality, mods, cargo, maintenance timers, insurance; Dark Luxury styling.
- Travel/Race planner: route, risk, scan/ambush odds, compliance status; warnings for illegal gear.

## 101.6 Anti-Abuse
- Anti-dupe IDs; price bounds; overclock cooldowns; anti-collusion in races; smuggling mule detection; server authority on travel state.

## 101.7 Interactions
- Crimes (Section 090/095): car crimes use vehicles; heat/police ties; chop shops.
- Factions: convoys, war logistics; faction garages/safehouses.
- Companies: fleets for contracts; maintenance services; reputation on failures.
- Properties: garages and hidden bays; travel convenience; stash ties.

## 101.8 Example Flows
- Legal road trip: maintained car; compliant; low scan risk; arrives; wear applied; log.
- Illegal overmodded van smuggling: concealment; overclock; scan risk high; success yields profit; failure seizure/jail.
- Transfer: vehicle sold within bounds; illegal flag persists; log; buyer assumes risk.

### For Architect GPT
- Unified vehicle/transport layer integrating travel, smuggling, compliance, and economy. Ensure consistent legality and logging across modules.

### For CodeGPT
- Implement garage/vehicle model, maintenance, travel modifiers, smuggling checks, compliance, transfers with bounds, logging, anti-dupe, and anti-collusion hooks for races. Server authoritative travel state.

### For BalanceGPT
- Tunables: wear rates, repair costs, scan/ambush odds, overclock effects, cargo capacity, compliance benefits, price bounds. Balance profit/risk for smuggling; keep maintenance meaningful.

### For QAGPT
- Test vehicle transfers with legality persistence, travel modifiers, smuggling seizures, maintenance impact, overclock cooldowns, anti-dupe, logging, and UI warnings. Validate single-trip enforcement and compliance effects.  
# SECTION 103 — TRAINS, BIKES & ALTERNATIVE TRANSPORT

## 102.0 Overview
Alternative transport modes within the UK network: trains, bikes, and niche options. Complements Sections 088/101 with specific rules and flavour. Maintains risk/scan logic; Dark Luxury UX.

## 102.1 Trains
- Scheduled departures; class tickets (comfort only); delays from weather/strikes; scans at stations; concealment reduces scan slightly; ambush chance low but possible on night/fog routes.
- Refunds on cancellations; compensation for delays; smuggling risk moderate; cargo limited.
- UI: timetable, risk bands, scan warning, class, refund rules.

## 102.2 Bikes
- Personal bikes/scooters: low cargo, low scan profile; speed moderate; ambush risk low; accidents possible; maintenance/repairs minimal.
- Illegal mods (nitrous) raise heat; seizures if caught; weather (rain/ice) increases accident risk.
- Bikes not allowed for large smuggling; good for quick borough travel.

## 102.3 Alternative Options
- Ride-shares (flavour): similar to cars but with less cargo; compliance handled by provider; small heat reduction unless carrying illegal items.
- Ferries (regional): moderate scans; weather impact; ambush low; cargo moderate; tied to docks schedules.
- Courier services: NPC delivery with time/cost; risk of loss; not for illegal items.

## 102.4 Anti-Abuse & Checks
- Single active trip; teleport prevention; refund abuse caps; scan/ambush calcs server-side.
- Illegal items seized on scans; bikes with illegal mods flagged; logs.

## 102.5 Interactions
- Smuggling: trains/ferries moderate risk; bikes minimal cargo so limited; concealment still helps; national threat raises scans.
- Properties: bike storage; minor travel QoL; garages not required for bikes.
- Companies: courier/transport firms can leverage trains/ferries; SLAs affected by delays.

## 102.6 Example Flows
- Train night fog: buys ticket; scan risk low; ambush chance small; arrives; log.
- Bike commute: fast borough move; rain increases accident risk; illegal nitrous seized at scan/checkpoint.
- Ferry smuggle: moderate risk; weather delay; concealment helps; success yields profit; failure seizure.

### For Architect GPT
- Alternative transport spec to augment regional travel. Integrates with smuggling/heat, companies, and events.

### For CodeGPT
- Implement train schedules/tickets/refunds, bike handling with mods/accidents, ferry rides, scans, single-trip enforcement, logging. Server authority on risk calcs.

### For BalanceGPT
- Tunables: scan/ambush odds per mode, delay/comp rates, accident odds, cargo limits, nitrous penalties. Keep trains reliable, bikes low risk/low capacity.

### For QAGPT
- Test train/ferry tickets, delays/refunds, scans/seizures, bike trips with illegal mods, accidents, single-trip enforcement, logging, and UI warnings.  
# SECTION 104 — PROPERTY SYSTEM 2.0

## 103.0 Overview
Refined property system pass: focuses on QoL, security tuning, and cross-module hooks. Complements previous property sections; ensures consistency and balance.

## 103.1 Ownership & Limits
- Caps on total properties to prevent hoarding; cluster bonuses capped; national estate cap enforced.
- Cooldowns and escrow on trades; price bounds; anti-laundering.
- Upkeep reminders; auto-downgrade of bonuses if unpaid; foreclosure after grace.

## 103.2 Security & Risk
- Security score = base + upgrades + staff + location modifiers; diminishing returns; displayed.
- Raids/burglaries use security score vs attacker skill/heat; cooldown between raids; logs.
- Illegal upgrades/items increase raid risk; insurance void on illegal seizures.

## 103.3 QoL & Services
- Auto-pay upkeep; auto-hire staff (bounded); alerts for stash nearing capacity; batch actions for upgrades (with safeguards).
- Property presets for upgrade/staff layouts; no gameplay advantage; convenience only.
- Travel convenience from helipad/garage; capped; cannot stack with fast lanes excessively.

## 103.4 Stash & Permissions
- Capacity enforced; hidden stash reduces detection; permissions per role (spouse, faction, tenants/staff); access logs; rate limits to prevent churn abuse.
- Illegal items flagged; seize on raid; logs.

## 103.5 Happy/Bonuses
- Happy/regen bonuses displayed with breakdown; caps enforced; parties/crashes handled; comfort upgrades diminishing returns.
- Staff effects bounded; med rooms/gym rooms provide small QoL only.

## 103.6 Anti-Abuse
- Flip tax; cooldown; anti-hoard tax; escrow; alt detection; stash churn limits; insurance fraud detection.
- Logging immutable; audits for suspicious moves; IP/device checks.

## 103.7 UI/UX
- Property dashboard: security score, bonuses, upgrades, staff, stash, upkeep, heat risk, logs; Dark Luxury styling.
- Warnings for illegal risk, capacity, unpaid upkeep, raid cooldowns.

## 103.8 Example Flows
- Upkeep missed: bonuses reduced; warning; grace; foreclosure if ignored; stash handled.
- Raid: illegal items seized; insurance void; heat up; log; cooldown starts.
- Cluster capped: attempting extra property triggers warning; denied if over cap; logs.

### For Architect GPT
- Property 2.0 reinforces caps, security, and QoL; integrates with raids, stash, travel, and economy.

### For CodeGPT
- Enforce caps/trade cooldowns/escrow, security calc with diminishing returns, stash permissions/logs, auto-pay/auto-hire bounded, raid handling. Keep server authority.

### For BalanceGPT
- Tunables: caps, security scaling, upkeep costs, flip taxes, bonus caps, raid odds, hoard taxes. Maintain balance and prevent exploits.

### For QAGPT
- Test caps enforcement, security calc, raids, stash permissions, auto-pay/auto-hire, flip taxes, logging, and warnings. Validate illegal risk handling and foreclosure flow.  
# SECTION 105 — COMPANY SYSTEM 2.0

## 104.0 Overview
Second-pass company refinement: caps, compliance, QoL, and anti-abuse. Builds on Sections 014/022/032/063/086 with tightened controls and better UX.

## 104.1 Caps & Scaling
- Employee caps per upgrade tier; role limits; wage bounds; contract value bounds; prevents runaway scaling and laundering.
- Production/service capacity scales with upgrades, staff stats, morale, and supplies; diminishing returns to avoid infinite scaling.

## 104.2 Compliance & Audits
- Compliance meter: reflects legality and safety; low compliance raises audit/raid risk; impacts customer trust.
- Audits triggered by anomalies (price spikes, illegal toggles, incidents); outcomes: fines, shutdown, seizures; cooldown; logs.
- Legal/illegal toggles locked to owner/director; logs all changes; approvals for risky toggles optional.

## 104.3 QoL & Automation (Bounded)
- Auto-payroll and auto-supply reorder with caps and alerts; can’t exceed bounds; pauses if funds low.
- Templates for wages/roles; batch scheduling; caretaker mode on owner inactivity (limited).
- Dashboards with SLA risk warnings, morale, supplies, contracts, compliance; Dark Luxury charts.

## 104.4 Contracts & SLAs
- Contract creation with clear SLAs, penalties, escrow; bounds on penalties to prevent abuse.
- Breach handling: auto penalties; reputation changes; dispute resolution; logging.
- Recurring contracts supported with caps; cancellation cooldowns; anti-spam.

## 104.5 Reputation & Reviews
- Star rating and reputation decay; fake review detection; dispute logs; trust-based fee adjustments.
- Public profile shows uptime, breach rate, dispute rate; boosts/hurts recruitment and contracts.

## 104.6 Anti-Abuse
- Price/wage laundering detection; hire/fire spam throttled; contract collusion flagged; IP/device checks.
- Dummy employees detection; morale exploits blocked; escrow enforced; transaction logs immutable.

## 104.7 UI/UX
- Company dashboard: compliance, morale, supplies, revenue/expenses, contracts, audits; alerts for risks; Dark Luxury styling.
- Employee panel: roles, stats, morale, wage; promotion needs; inactivity warnings.
- Customer view: services/products, prices, SLAs, reputation; escrow indicator; dispute button.

## 104.8 Example Flows
- Audit hit: illegal toggle on; audit triggered; stock seized; fine; reputation drops; cooldown; log.
- Contract breach: late delivery; penalty auto-applied; rating drops; dispute filed; log.
- Owner inactive: caretaker mode kicks; payroll capped; no new contracts; alerts; owner can resume.

### For Architect GPT
- Company 2.0 enforces caps, compliance, and anti-abuse while adding QoL. Integrates with economy, contracts, audits, and logging.

### For CodeGPT
- Implement caps/bounds, compliance meter, audit triggers/resolution, bounded automation, contract SLAs with penalties/escrow, reputation systems, anti-abuse detectors, logging, and dashboards. Server authority; prevent laundering.

### For BalanceGPT
- Tunables: caps, wage/price bounds, audit frequency, compliance effects, morale impacts, SLA penalties, reputation decay. Keep companies profitable but not exploitable; illegal toggles high risk.

### For QAGPT
- Test caps, compliance changes, audit triggers, auto-pay/supply with bounds, contract flows, breach penalties, reputation updates, anti-abuse detection, and logging. Validate UI warnings and caretaker behavior.  
# SECTION 106 — EDUCATION SYSTEM 2.0

## 105.0 Overview
Education refinement: clearer trees, parallel slots, illegal courses, and anti-abuse. Builds on Section 015 with expanded structure and UX.

## 105.1 Trees & Branches
- Trees: General, Crime, Medical, Tech/Cyber, Engineering, Business/Legal, Black Market, Travel/Logistics, Combat Support.
- Branch prerequisites: level/stats/previous courses; clear dependencies; course map UI.
- Certifications for completing branches; titles; cosmetic rewards; no stat direct boosts beyond effects already defined.

## 105.2 Slots & Scheduling
- Base: 1 active course; donators: queue 1 extra; premium institutes allow micro-courses in parallel (small/short).
- Pause/resume with penalty; abort with partial refund and cooldown; timers server-side; no time-skip.

## 105.3 Effects & Scope
- Effects: unlock crimes/tools, reduce nerve cost, improve success, reduce hospital/jail, improve revives, repair quality, market/legal perks, travel smuggling odds. All table-driven; no hidden effects.
- Illegal courses: unlock black-market crafting/tools; increase heat risk if caught; flagged; can raise scan odds briefly.

## 105.4 Locations & Access
- Institutes placed by district; prestige schools in wealthy boroughs; underground tutors for illegal courses; travel required.
- Capacity/queues optional; events can discount courses; not pay-to-win.

## 105.5 Anti-Abuse
- No instant completion; cooldowns on abort; parallel slot limits; repeated abuse flagged; server authoritative timers.
- Illegal course farming raises heat temporarily; diminishing returns if spammed; logs for audits.

## 105.6 UI/UX
- Course catalog with filters, prerequisites, effects, duration, cost, location; map view; progress bars; warnings for illegal courses.
- History view; certifications; branch completion status; Dark Luxury styling.

## 105.7 Interactions
- Crimes/Black ops: unlocks and success boosts; reduced jail/heat for specific categories.
- Companies: role requirements; performance boosts; compliance for legal roles.
- Properties: study bonuses from high-end properties; minor duration reduction; staff tutors optional cosmetic flavour.
- Travel: course location requires travel; timers not paused during travel unless paused explicitly.

## 105.8 Example Flows
- Player enrolls in Cyber 201: pays; timer starts; unlocks advanced cyber crimes; reduces detection chance; log; completion grants cert/title.
- Illegal Chem course: increases black-market crafting success; heat up slightly; flagged; log.
- Abort: player quits; partial refund; cooldown before new course; timer cleared; log.

### For Architect GPT
- Education 2.0 clarifies trees, slots, effects, and illegal paths. Integrate with crimes/black ops, companies, properties, travel, and logging.

### For CodeGPT
- Implement catalog, prerequisites, timers, pause/abort, effects application, illegal flags, logging, anti-abuse (slots/cooldowns). Server authority; UI APIs.

### For BalanceGPT
- Tunables: durations, costs, effect magnitudes, prerequisites, illegal heat impact, slot counts. Ensure meaningful progression without pay-to-win.

### For QAGPT
- Test enroll/pause/abort/complete flows, effect application, illegal flags, heat impact, prerequisites, travel/location enforcement, slot limits, logging, and UI accuracy.  
# SECTION 107 — DEEP CRIMES SYSTEM 3.0

## 106.0 Overview
Deep crimes refinement focused on advanced categories (fraud, cyber, smuggling, black ops) with layered defenses and anti-abuse. Complements Sections 094/068/071/072.

## 106.1 Advanced Categories
- Fraud: bank wire scams, insurance scams, corporate theft; high nerve/INT; risk of asset seizure; long cooldowns.
- Cyber: hacks, data theft, ransomware (flavour); requires tools/education; detection triggers heat/jail; loot = cash/data items.
- Smuggling: multi-step routes, concealment, informant intel; high reward; bust/raid risk.
- Black Ops: faction-only covert actions (see Section 074) with high penalties for failure.

## 106.2 Defenses & Countermeasures
- Fraud/cyber defenses: detection rolls; NPC security; risk-based on player stats/tools and target security level; success never guaranteed; multi-stage with checkpoints.
- Smuggling defenses: scans, patrols, checkpoints, informant betrayal; weather/time impact.
- Counter-ops: NPC/players can trigger responses; failure leads to jail/seizure; respect loss in faction context.

## 106.3 Rewards & Penalties
- High rewards (cash/items/respect/intel); diminishing returns on repeats; caps on daily high-tier payouts.
- Penalties: asset seizure, long jail, hospital risk (violence during busts), heat spikes; black-market rep loss on smuggling failures.

## 106.4 Anti-Abuse
- Cooldowns and daily caps; diminishing returns; IP/device checks for team crimes; staged farming detection; unique participant enforcement for team ops.
- Tool consumption enforced; no rerolls; server authority; logs for all steps; alerts for mods.

## 106.5 UI/UX
- Deep crime console: risk/reward bands, requirements, multi-stage indicators, tool list, heat impact, cooldowns; Dark Luxury styling.
- Logs: stage outcomes, detections, seizures, rewards; analytics for tuning.

## 106.6 Interactions
- Informants (Section 071): intel affects smuggling and target selection; betrayal risk.
- Policing (Section 072): high-level crimes raise heat; trigger raids/scans.
- Black market/shadow economy: supplies tools; smuggled goods feed economy; failures affect rep.
- Factions: respect gains/losses; black ops integrated; wars may adjust penalties.

## 106.7 Example Flows
- Fraud attempt: high INT/tools; detection rolls; success yields cash; failure seizes assets and jails; cooldown long.
- Cyber run: multi-stage; caught at stage 2 → heat spike + jail; success yields data item; log.
- Smuggling chain: multi-leg route; concealment; informant gives intel; bust at final checkpoint; cargo seized; jail; rep down.

### For Architect GPT
- Deep crimes layer with strong countermeasures and anti-abuse; integrates with informants, policing, factions, and shadow economy. Uses central crime service.

### For CodeGPT
- Implement advanced crime definitions with stages, defenses, detection, rewards/penalties, cooldowns/caps, logging, and anti-abuse. Server authoritative; enforce unique participants and tool use.

### For BalanceGPT
- Tunables: success/detection weights, payout caps, cooldowns, seizure rates, heat gains, asset seizure severity. Keep lucrative but risky; prevent farm.

### For QAGPT
- Test advanced crimes flows, detection handling, penalties, caps, cooldowns, logging, participant enforcement, and interactions with informants/police. Validate no rerolls/exploits.  
# SECTION 108 — COMBAT SYSTEM 3.0

## 107.0 Overview
Combat refinement: tighter caps, logs, anti-abuse, and environment hooks. Builds on Sections 003/010/027/095 with final tuning for fairness and readability.

## 107.1 Core Pillars
- Parity: Torn-like math; predictable; theorycraftable; server authority.
- Fairness: caps on crit/dodge, diminishing returns; anti-one-shot; anti-infinite-dodge.
- Flavour: UK street weapons, Dark Luxury logs; weather/time effects.

## 107.2 Stats & Formulas
- Hit/dodge/crit formulas using Str/Spd/Def/Dex with weapon/armor modifiers; capped; diminishing returns.
- Mitigation floor to prevent 0 damage; penetration reduces mitigation; bounded.
- Initiative uses Speed + modifiers + environment; ambush modifiers limited.

## 107.3 Status & Stacking
- Status effects (bleed/burn/stun/shock/slow/suppressed/adrenaline/dazed/intoxicated) with caps; stacking rules; diminishing returns; cleanse options; crash effects logged.
- Immunity windows to prevent stun-lock/chain abuse.

## 107.4 Weapons/Armor/Mods Integration
- Weapons/armor/mods per Sections 047/050/052/099; legality enforced; durability tracked.
- Range bands, noise, penetration, encumbrance applied; malfunctions/breakage server-side.

## 107.5 Consumables & Drugs
- Combat consumables limited per fight; cooldowns; drugs apply boosts/crashes per rules; tolerance affects potency; logs.

## 107.6 Environment & Weather
- Weather/time effects on accuracy/initiative; interiors reduce weather; terrain modifiers (rooftop/docks); police heat can interrupt public fights (muggings).

## 107.7 Anti-Abuse & Stability
- Nonce/idempotent attacks; anti-duplication of damage; RNG server-side; replay logs deterministic.
- Anti-snipe windows configurable; spawn protection after revive; rate limits on rapid attacks; collusion detection.

## 107.8 UI/UX
- Rich logs: rolls, damage, statuses, mitigation, item use, heat changes; summary + detail; mobile-friendly; Dark Luxury.
- Warnings for low durability, illegal gear heat risk, crash incoming.

## 107.9 Example Flows
- Ambush mug: stealth bonus applied; capped; rain reduces firearm accuracy; defender hospitalized; heat up; log.
- Long fight: status stacks within caps; stun immunity kicks; armor durability drops; consumable used; log shows all.
- Malfunction: DIY gun jams; turn lost; log; durability lowers; malfunction chance recalculated.

### For Architect GPT
- Final combat tuning with caps, status rules, environment, and anti-abuse. Integrates with items, drugs, weather, heat/police, and logs.

### For CodeGPT
- Implement capped formulas, status engine with immunity windows, durability/malfunction handling, environment modifiers, anti-duplication, logging. Ensure server authority and replayability.

### For BalanceGPT
- Tunables: caps, DR, status durations/limits, penetration/mitigation curves, malfunction rates, consumable limits, weather effects, anti-snipe windows, spawn protection. Keep fights fair and diverse.

### For QAGPT
- Test hit/dodge/crit/mitigation with caps, status stacking/cleansing, durability/malfunction, consumable limits, weather impacts, anti-abuse (nonce/anti-snipe), logging correctness, and heat interruptions.  
# SECTION 109 — ARMOUR & PROTECTION SYSTEM 3.0

## 108.0 Overview
Intermediate armour pass aligning with combat 3.0. Reinforces resist caps, encumbrance, legality, and repair. Complements Sections 050/053/099/100.

## 108.1 Armour Types & Slots
- Slots: head/torso/legs. Types: light/medium/heavy/covert/specialized.
- Stats: flat/% mitigation, resist (blunt/sharp/ballistic/explosive/chem/electric), crit/status resist, encumbrance, noise, durability, legality.

## 108.2 Caps & Balance
- Caps on resist/status reduction to avoid invincible builds; diminishing returns on stacking; encumbrance penalties enforced.
- Penetration ensures some damage; mitigation floor prevents zero hits.

## 108.3 Legality & Heat
- Restricted/illegal armor raises scan/police risk; seizures; fines/jail; covert lowers noise but not legality.
- Legal events/races scrutineering disallows illegal armor.

## 108.4 Durability & Repair
- Durability loss per hit; AP/explosive increase loss; zero durability disables mitigation; repair via companies/black market; salvage yields materials; illegal mods can block legal repair.

## 108.5 Mods & Augments
- Mods: plates, padding, liners, stealth mesh, dampeners, utility pouches; slots limited; DR on stacking; illegal variants raise heat.
- Augments: HUD, light exo-assist, biomonitor; minor utility only; no major stat changes; legality tracked.

## 108.6 UI/UX
- Armour cards: stats, resist, encumbrance, durability, mods, legality; warnings for low durability/illegal gear.
- Compare; set bonus indicators (cosmetic); Dark Luxury styling.

## 108.7 Anti-Abuse
- Anti-dupe; price bounds; mod stacking caps; legality checks on equip/travel; server authority on stats/durability; logs.

## 108.8 Example Flows
- Heavy armor: mitigation high; encumbrance penalty; heat risk; log; seizures possible.
- Covert armor with stealth liner: low noise; resist modest; encumbrance moderate; caps enforced.
- Broken armor: no mitigation; warning; repair or salvage; log updates.

### For Architect GPT
- Armour 3.0 ensures balanced resist/encumbrance with legality. Integrates with combat, shops/black market, and repair services.

### For CodeGPT
- Implement armour templates, caps, durability loss/repair, mod/augment handling, legality checks, logging, anti-dupe. Enforce scrutineering for legal events.

### For BalanceGPT
- Tunables: resist/mitigation values, caps, encumbrance, mod effects, durability loss, repair costs, heat penalties. Keep multiple viable options.

### For QAGPT
- Test equip, resist calc with caps, durability loss/repair, mod stacking, legality/scan, logging, and UI warnings. Validate scrutineering disqualifies illegal gear.  
# SECTION 110 — WEAPONS SYSTEM 4.0 (REFINEMENT)

## 109.0 Overview
Refinement of weapon system to align with combat 3.0 and legality rules. Consolidates categories, caps, mods/ammo interactions, and anti-abuse. Complements Sections 047/091/098.

## 109.1 Categories & Roles
- Pistols, SMGs, Shotguns, Rifles, DMRs, Exotic/DIY, Non-lethal, Melee, Throwables, Shields (shields covered separately). Each has niche; no dominant meta.
- Roles: pistols versatile/stealth-friendly; SMGs close/mid DPS; shotguns close burst; rifles mid/long pen; DMRs precision; DIY risky; melee low-noise.

## 109.2 Stats & Caps
- Stats: damage, accuracy/range, crit, penetration, recoil, noise, weight, durability, mod slots. Caps on crit/accuracy/dodge; penetration tuned to avoid bypassing armor entirely.
- Noise affects crimes; suppressors reduce noise with penalties; illegal weapons remain illegal regardless of noise.

## 109.3 Legality & Enforcement
- Legal/restricted/illegal flags; purchase gating; scans; seizures; heat penalties. DIY and conversions illegal with high malfunction/heat risk.
- Licenses (flavour) for some restricted purchases; logs; no way to bypass legality via mods/skins.

## 109.4 Mods & Ammo
- Mods (Section 052) with compatibility; stacking DR; anti-inflation caps. Ammo types (AP/HP/subsonic/incendiary/rubber) adjust pen/noise/heat/wear.
- Jam chance rises with low durability/poor ammo/drums; logged.

## 109.5 Acquisition & Trade
- Shops (legal/restricted), black market (illegal), loot, crafting (DIY). Trade with price bounds; anti-dupe IDs; legality persists.
- Cosmetics separate; zero stat change.

## 109.6 Anti-Abuse
- Anti-dupe, price bounds, cap stacking; mod compatibility enforced; malfunctions server-side; noise/legality checks on crimes/travel; IP/device checks for laundering.

## 109.7 UI/UX
- Weapon cards with stats, range profile, legality, ammo/mods, noise, durability; warnings; Dark Luxury styling.
- Crime UI shows noise/legal risk; shop/black market gating; scrutineering for legal events.

## 109.8 Example Flows
- Legal pistol with suppressor/subsonic: quieter; damage down; legality still restricted; crime noise reduced; log.
- DIY SMG: cheap; jams; heat risk; seized if scanned; jail; log.
- AP rifle vs armor: pen reduces mitigation; durability loss up; caps enforced; log.

### For Architect GPT
- Weapon refinement aligning legality, caps, and mods/ammo with combat 3.0. Integrate with crimes, policing, shops/black market, and logging.

### For CodeGPT
- Implement weapon templates with legality, caps, mod/ammo compatibility, jam handling, anti-dupe/trade bounds, and legality/noise enforcement in crimes/travel. Server authority.

### For BalanceGPT
- Tunables: base stats per category, caps, mod/ammo effects, malfunction rates, heat penalties, price bounds. Ensure multiple viable options.

### For QAGPT
- Test legality gating, caps, mod/ammo compatibility, jam/pen effects, noise/legal handling, anti-dupe, logging, and scrutineering.  
# SECTION 111 — THROWABLES & EXPLOSIVES ENGINE 4.0

## 110.0 Overview
Throwable refinement aligned with combat 3.0: grenades, improvised throwables, breaching tools. Focus on caps, legality, weather effects, and anti-spam. Complements Section 048/095.

## 110.1 Categories
- Grenades: frag, flash, smoke, incendiary, EMP (event), gas (illegal).
- Improvised: molotov, acid bottle (illegal), bricks/rocks.
- Breaching charges: objective-only; not for direct PvP damage; faction/ops use.

## 110.2 Stats & Rules
- Damage/radius/status, fuse, throw range, weight, legality, noise. Friendly fire possible; indoors amplify effects; weather impacts (rain reduces incendiary, wind affects smoke).
- Single-use; per-fight caps; cooldown between throws; equip required.

## 110.3 Legality & Heat
- Many illegal; carrying raises scan/police risk; use in public increases heat; seizures at scans.
- War zones may relax legality for certain items; still logged; not fully exempt.

## 110.4 Anti-Abuse
- Caps per fight; inventory caps; cooldowns; price bounds; anti-dupe; no XP gain for self-damage; friendly-fire abuse flagged; breaching charges restricted to objectives.

## 110.5 UI/UX
- Item cards: radius, fuse, effects, legality, weight, caps; warnings for self-harm and heat.
- Combat UI: throw button with remaining count; friendly-fire warning; log shows effect/heat.
- Crime UI: risk warning; heat impact; stealth penalty for noisy throwables.

## 110.6 Interactions
- Combat: status/damage within caps; weather/indoors modify; logs.
- Crimes: throwables raise heat; risk of public panic; may trigger police quickly.
- Faction wars/ops: breaching charges for objectives; smoke for cover; caps enforced.

## 110.7 Example Flows
- Smoke grenade in mugging: visibility reduced; initiative impacted; heat increased; log.
- Molotov in rain: burn reduced; damage down; still illegal; scan risk.
- Breach charge: damages objective; respects caps; logged to war feed; no PvP damage.

### For Architect GPT
- Throwable engine with caps/legality/weather hooks and anti-abuse. Integrates with combat, crimes/heat, policing, and faction ops.

### For CodeGPT
- Implement throwable templates, caps/cooldowns, weather/indoor modifiers, legality/heat handling, anti-dupe, logging. Restrict breaching charges to objectives; enforce price bounds.

### For BalanceGPT
- Tunables: damage/status values, radius, fuse, caps, cooldowns, weather modifiers, heat penalties, price/rarity. Keep impactful but scarce; illegal = high risk.

### For QAGPT
- Test equip/use, caps/cooldowns, weather/indoor effects, heat/legal handling, breaching restrictions, logging, anti-dupe, and friendly-fire handling.  
# SECTION 112 — STATUS EFFECTS ENGINE 6.0

## 111.0 Overview
Status effects engine governs application, stacking, duration, cleansing, and caps. It underpins combat, drugs, throwables, and environment. Goal: clarity, fairness, and anti-abuse. Integrates with combat 3.0 (Section 108) and throwables (Section 111).

## 111.1 Effects Catalog
- Bleed, Burn, Shock, Stun, Slow, Suppressed, Adrenaline, Dazed, Intoxicated, Wet/Soaked, Bruised, Poison (event), Gas (event), Concealment (smoke).
- Each has: source, severity, duration, stack rules, cap, cleanse methods.

## 111.2 Stacking & Caps
- Some stack intensity (bleed, burn) up to cap; others refresh duration (stun with diminishing returns).
- Caps per effect type; immunity windows after heavy stun/shock to prevent lock; global status cap to avoid overload.

## 111.3 Application Rules
- Apply from weapons, throwables, drugs, environment, missions. Success chance uses attacker stats/weapon mods; resisted by target stats/armor/resists.
- Reapplication respects caps; weaker applications ignored if at cap; logged.

## 111.4 Cleansing & Decay
- Natural decay per tick; consumables/skills can cleanse specific effects; armor mods reduce duration/severity.
- Adrenaline crash applies after buff ends; logged; crash rules align with drug system.

## 111.5 Interaction Rules
- Wet amplifies shock; reduces burn duration; smoke reduces visibility; poison ignores armor but capped; gas masked by specific gear.
- Concealment affects accuracy/initiative; not invisibility; capped.

## 111.6 UI/UX
- Status chips with icons, timers, severity; colour-coded; tooltips; Dark Luxury styling; reduced-motion respects.
- Logs show application, stack, cleanse, expiry, immunity triggers.

## 111.7 Anti-Abuse
- Caps/immunity windows; server authority; no client stacking exploits; rate limits on application; anti-duplication of events; friendly-fire abuse flagged.

## 111.8 Example Flows
- Bleed stacked to cap; further applications refresh duration; cleanse via bandage; log.
- Stun applied twice; diminishing returns; immunity window triggers; no lock; log.
- Shock on Wet target during storm: higher skip chance; capped; log shows interaction.

### For Architect GPT
- Central status engine with caps, decay, cleansing, and interactions. Integrates with combat, throwables, drugs, environment, and logging.

### For CodeGPT
- Implement status definitions, caps/immunity, application/resistance, decay/cleanse, interactions, logging. Enforce server authority and anti-abuse.

### For BalanceGPT
- Tunables: caps, durations, application/resist weights, immunity windows, interaction modifiers. Keep effects impactful but fair; prevent lock or runaway stacking.

### For QAGPT
- Test status application/removal, stacking caps, immunity, interactions (wet/shock, burn/rain), logging, and UI timers. Validate anti-lock behaviour.  
# SECTION 113 — ARMOUR SYSTEM 8.0

## 112.0 Overview
Additional armour refinement to ensure consistency across later sections. Emphasizes resist caps, encumbrance, legality, and UI clarity. Complements Sections 050/099/108/109/100.

## 112.1 Resist & Mitigation Caps
- Hard caps on resistances and mitigation to prevent invincible builds; penetration and minimum damage ensure hits land.
- Status resist caps separate; no full immunity except temporary immunity windows from status engine.

## 112.2 Encumbrance & Mobility
- Encumbrance penalties enforced; mitigation cannot exceed design without penalty; Strength/Speed mitigate slightly; caps.
- Stealth penalties with heavy armor; crime UI reflects; no stealth from dark skins.

## 112.3 Legality & Enforcement
- Restricted/illegal armor raises scan risk; seizures; fines/jail; covert gear reduces noise but not legality; scrutineering for events.
- Logging on equip/use; warnings for illegal/low durability.

## 112.4 Durability & Repair
- Durability loss scaled by damage type; AP/explosive harsher; zero durability removes benefits; repair/salvage as before.
- Illegal mods may block legal repair; black-market repair available at risk.

## 112.5 Mods & Slots
- Slots limited; mods (plates, padding, liners, stealth mesh, dampeners) with diminishing returns; illegal variants flagged; status of mods shown in UI.

## 112.6 UI/UX
- Clear resist tables, caps, encumbrance, durability, legality, mod slots; alerts for caps exceeded or illegal gear; Dark Luxury styling.

## 112.7 Anti-Abuse
- Anti-dupe IDs; price bounds; cap enforcement; server authority; logging; scrutineering; no stealth/invisible skins.

## 112.8 Example Flows
- Player tries to stack resists over cap: system clamps; warning; log.
- Illegal armor scan: seized; fine/jail; heat up; log.
- Broken armor equipped: no mitigation; warning; repair or salvage; log.

### For Architect GPT
- Armour 8.0 restates caps/legality/encumbrance for consistency. Integrates with combat, policing, and UI.

### For CodeGPT
- Ensure cap enforcement, legality checks, durability handling, mod slots, logging, anti-dupe. Scrutineering applied to events/travel where needed.

### For BalanceGPT
- Tunables: caps, encumbrance penalties, repair costs, durability loss rates, heat penalties. Keep multiple viable builds; no invincible setups.

### For QAGPT
- Test cap clamping, legality scans, durability loss/repair, mod slot enforcement, logging, and warnings. Validate scrutineering and anti-dupe.  
# SECTION 114 — CLOTHING & COSMETICS ENGINE 5.0

## 113.0 Overview
Cosmetics engine refinement for outfits, armor skins, weapon skins, and emblems. Purely visual; no gameplay stats. Builds on Sections 053/059/078/100 with clearer rules, trading bounds, and moderation.

## 113.1 Collections & Rarity
- Collections grouped by borough, faction, event, and prestige. Rarity tiers (Common → TrenchMade) affect availability only.
- Collection completion grants titles/frames/badges; cosmetic only; no stats.
- Pity tokens for event collections; capped; prevent endless farm.

## 113.2 Customization Rules
- Mix-and-match allowed within palette rules; anti-stealth (no invisible/dark-on-dark); high-contrast options.
- Armor/weapon skins cannot change silhouettes/hitboxes; no readability loss; particles minimal and toggleable.
- Emblems/logos moderated; no offensive/real-gang content.

## 113.3 Acquisition & Trading
- Sources: shops, events, achievements, faction/company rewards, market. Some bound; others tradeable with price bounds; authenticity tags; anti-dupe.
- Gifts with cooldowns; logs; moderation for custom uploads.

## 113.4 UI/UX
- Wardrobe with filters, previews, presets, collection tracker, token exchange; Dark Luxury styling; mobile-friendly.
- Market listing shows cosmetic-only; rarity; bounds; warnings that no stats.
- Accessibility: reduced effects toggle; contrast modes; clear labelling.

## 113.5 Anti-Abuse
- No stat effects; anti-stealth palette enforcement; anti-dupe IDs; price bounds/gift cooldowns to prevent laundering; moderation pipeline for uploads.

## 113.6 Example Flows
- Completes event collection: earns badge/title; no stats; logs.
- Trades weapon skin within bounds; authenticity verified; no laundering.
- Attempted stealth skin rejected by palette; warning; not applied.

### Detailed Mechanics — Clothing, Style & Mask Identity

**Style vs Function**  

Clothing in Trench City sits between three axes:

- **Style:** how the outfit looks; contributes to social perception, intimidation, and certain mission checks.
- **Function:** small, focused stat bonuses (stealth, job performance, crime modifiers), not raw combat power.
- **Identity:** how recognisable or anonymous the player appears during crimes, missions, and social encounters.

Clothing is not meant to compete with armour in pure defence but should matter for:

- Job success and promotions,
- Social/faction reputation,
- Crime detection chances,
- NPC reactions in the City and Missions.

**Outfit Slots & Layers**  

Define clear slots: headwear, face, torso, legs, footwear, accessories, outerwear.

- Certain outerwear layers can visually cover armour or other clothing layers.
- Masks and face coverings are the primary way to alter **identity exposure** during crimes and PvP.

**Masks & Anonymity Mechanics**  

Masks have dedicated rules:

- Each mask has an **Anonymity Rating** and **Suspicion Rating**:
  - High anonymity helps hide identity when committing crimes and PvP.
  - High suspicion makes NPCs and systems more alert when worn in inappropriate contexts (banks, shops, day jobs).
- When a crime or PvP event is logged:
  - Check whether the player was masked, partially disguised, or fully visible.
  - This influences whether victims, witnesses, and CCTV logs record a **named offender**, a **masked offender**, or only vague descriptions.

Consequences of poor disguise:

- Faster and stronger police heat accumulation.
- Easier targeting by enemies/factions via hitlists and bounties.
- Reputation penalties in legitimate jobs if caught.

**Fashion Stats & Sets**  

Clothing introduces soft stats such as:

- **Presence/Intimidation:** influences some dialogue, extortion crimes, and negotiation events.
- **Professionalism:** affects job performance and promotions in white/grey-collar roles.
- **Stealth/Blend:** makes blending into crowds easier for surveillance, tailing, and pickpocket-style crimes.

Set bonuses:

- Themed outfits (business suits, roadman fits, designer tracksuits, faction uniforms) can grant small bonuses when worn together.
- Limited sets from events or Black Market drops act as long-term collector targets and prestige badges.

**Economy & Sinks**  

- Clothing is a major **non-combat sink**:
  - Shops for basic and mid-tier items,
  - High-end boutiques for designer/limited pieces,
  - Tailors and customisation services for recolours, patterns, or tags.
- Resale markets allow players to trade rare cosmetics at a premium but should include fees to keep money circulating.

**Anti-Abuse & Edge Cases**  

- Avoid clothing that grants large raw combat stats; keep bonuses mostly contextual and capped.
- Ensure disguise systems can’t be exploited to become permanently untraceable:
  - Logs should still capture masked offenders and allow for investigative mechanics (witnesses, CCTV, intel missions).
- Provide clear UI feedback when an outfit is a bad match for the current activity (e.g. heavy tactical gear in a white-collar office job).

### For Architect GPT
- Cosmetics engine with collections, trading, and moderation; zero mechanical impact; integrate with identity/profile and market.

### For CodeGPT
- Implement wardrobe/presets, collection tracker, token exchange, trade bounds, gift cooldowns, palette enforcement, anti-dupe, and moderation for emblems/uploads. Server authority on inventories.

### For BalanceGPT
- Minimal: rarity drop rates, token costs, price bounds, gift cooldowns. Ensure cosmetics aspirational without economic abuse.

### For QAGPT
- Test equip/trade/gift, palette enforcement, collection completion, token exchange, moderation, logging, and confirmation of zero stat impact.  
# SECTION 115 — WEAPONS SYSTEM 10.0

## 114.0 Overview
Ultimate weapon system spec consolidating legality, stats, caps, mods, ammo, and anti-abuse. Builds on Sections 109/091/098/110 with final guardrails.

## 114.1 Categories & Roles
- Pistols, SMGs, Shotguns, Rifles, DMRs, Exotic/DIY, Non-lethal, Melee, Throwables, Shields. Each balanced with clear niche; no dominant meta.

## 114.2 Legality & Enforcement
- Legal/restricted/illegal flags; purchase gating; scans/seizures; heat penalties. DIY/conversions illegal with high malfunction.
- Licenses (flavour) for restricted buys; scrutineering for legal events; illegality persists through trades; cosmetics don’t change legality.

## 114.3 Stats & Caps
- Damage, accuracy, crit, penetration, recoil, noise, weight, durability, range profile, mod slots. Caps on crit/accuracy/dodge; minimum damage floor; penetration limited to avoid bypassing armour fully.
- Noise impacts crimes; suppressors reduce noise but carry penalties; not a legality bypass.

## 114.4 Mods & Ammo
- Mod slots with compatibility; DR on stacking; caps; illegal mods flagged; influence heat. Ammo types (AP/HP/subsonic/incendiary/rubber) adjust pen/noise/wear/heat; jam chance rises with low durability/cheap ammo.

## 114.5 Acquisition & Trade
- Shops for legal/restricted; black market for illegal; loot/crafting; trades with price bounds and anti-dupe IDs; legality retained; logs.
- Event skins cosmetic only; no stat change; cannot hide illegality.

## 114.6 Anti-Abuse
- Cap enforcement; anti-dupe; price bounds; mod stacking limits; legality checks on equip/travel/crimes; IP/device checks on laundering; server authority on rolls.
- Collusion in races/events prevented by scrutineering; illegal gear disallowed in legal contexts.

## 114.7 UI/UX
- Weapon cards showing full stats, legality, mods/ammo, noise, durability; warnings; Dark Luxury styling; crime UI shows risk bands.

## 114.8 Example Flows
- Restricted rifle with legal mods: ok; legality maintained; heat risk; logs.
- Illegal conversion: high malfunction; seized at scan; jail/fine; log.
- Subsonic + suppressor: quieter; damage down; legality unchanged; crime risk for noise reduced.

### For Architect GPT
- Final weapon spec aligning legality, caps, and mods/ammo across systems. Integrate with combat, crimes/policing, shops/black market, and logging.

### For CodeGPT
- Implement templates with caps/legality, mod/ammo compatibility, jam handling, scrutineering, anti-dupe/trade bounds, and legality/noise enforcement. Server authority.

### For BalanceGPT
- Tunables: category baselines, caps, mod/ammo effects, malfunction/heat rates, price bounds. Ensure diverse viable builds; prevent meta dominance.

### For QAGPT
- Test legality gating, caps, mod/ammo, jam/pen effects, noise/heat handling, anti-dupe, scrutineering, and logging. Validate cosmetic-only skins.  
# SECTION 116 — THE DAMAGE ENGINE 10.0

## 115.0 Overview
Damage engine defines how attacks translate to HP loss with mitigation, penetration, resistances, caps, and logs. Aligns with combat 3.0 and weapon/armor 4.0. Server authoritative; fair; readable.

## 115.1 Pipeline
- Inputs: attacker stats, weapon stats/mods/ammo, defender armor/resists/encumbrance, statuses, environment (weather/terrain), RNG.
- Rolls: hit/dodge, crit, damage calc, mitigation/penetration, status application, durability loss.
- Outputs: HP loss, status applied, armor durability change, logs. Minimum damage floor enforced.

## 115.2 Mitigation & Penetration
- Mitigation = flat + % from armor/Defense; penetration reduces % portion; caps on mitigation and penetration; minimum damage floor prevents 0.
- Resist tables per damage type (blunt/sharp/ballistic/explosive/chem/electric); applied before mitigation caps; capped.

## 115.3 Crit & Variance
- Crit chance capped; crit damage multiplier bounded; variance narrow to keep predictable; RNG seed stored for replay.
- DIY/unstable weapons may have wider variance; logged.

## 115.4 Status & Effects
- Status applied post-damage if hit lands and passes roll; status caps handled by status engine (Section 111); logs show status result.

## 115.5 Durability
- Armor and weapon durability reduced by damage dealt/taken; AP/explosives increase loss; zero durability disables benefit; logged.

## 115.6 Environment
- Weather/terrain modify accuracy/initiative and sometimes damage (e.g., explosives indoors more effective); storm amplifies electric shock; rain reduces incendiary; logged.

## 115.7 Anti-Abuse
- Server-side calc; no client influence; idempotent endpoints; double-submit guarded; anti-dup damage events; caps prevent extremes.

## 115.8 UI/UX
- Logs show rolls, penetration, mitigation, resist, variance, crit, status, durability change; concise summary + detail; mobile-friendly; Dark Luxury styling.

## 115.9 Example Flows
- Rifle AP vs armored target: penetration reduces % mitigation; damage dealt above floor; armor durability drops; log shows calc.
- Shotgun in interior: blast amplified; damage up; log notes environment; defender hospitalized.
- DIY weapon: variance higher; crit capped; jam risk; logged.

### For Architect GPT
- Damage engine sets calc order, caps, and logging; integrates with combat, weapons/armor, status, environment. Server authority required.

### For CodeGPT
- Implement pipeline: hit/dodge/crit, damage with penetration/resists/caps, status, durability, environment; logging; anti-dup. Store RNG seeds; idempotent API.

### For BalanceGPT
- Tunables: mitigation/penetration caps, damage floors, variance bounds, crit caps, environment modifiers, durability loss. Target fairness and predictability.

### For QAGPT
- Test calc ordering, caps, penetration vs resist, damage floor, variance, environment effects, durability loss, logging accuracy, and idempotency. Validate anti-duplication.  
# SECTION 117 — ARMOUR SYSTEM 5.0

## 116.0 Overview
Armour 5.0 provides another pass for consistency: resist caps, legality, repair, and UI clarity. Keeps alignment with combat/damage engines and avoids invincible builds.

## 116.1 Resist & Caps
- Resistances for blunt/sharp/ballistic/explosive/chem/electric; caps enforced; mitigation floors; penetration limits. Status resist separate with caps.

## 116.2 Encumbrance
- Penalties to initiative/dodge; mitigated slightly by Strength/Speed; caps; no stealth benefits from dark skins.

## 116.3 Legality
- Restricted/illegal gear raises scan risk; seizures; fines/jail; scrutineering blocks illegal in legal contexts; logs.

## 116.4 Durability & Repair
- Durability loss on hits; zero = no benefit; repairs via companies/black market; salvage; illegal mods may block legal repair.

## 116.5 Mods & Slots
- Limited slots; diminishing returns; illegal mods flagged; show in UI; cap stacking.

## 116.6 UI/UX
- Cards show resist, encumbrance, durability, legality, mods; warnings; Dark Luxury styling.

## 116.7 Anti-Abuse
- Anti-dupe; price bounds; cap enforcement; legality checks; server authority; logs; scrutineering.

## 116.8 Example Flows
- Over-cap resist clamped; warning; log.
- Illegal armor seized at scan; fine/jail; heat up; log.
- Broken armor warning; repair/salvage; log.

### Detailed Mechanics — Armour System Core

**Armour Slots & Coverage**  

The player can equip armour in a set of defined slots:

- Head
- Torso
- Arms/Hands
- Legs
- Feet

Each armour piece defines:

- **Armour Rating (AR):** base % damage reduction for normal hits.
- **Coverage:** which body region(s) it protects (for locational hit systems).
- **Damage Type Modifiers:** ballistic, melee, explosive, environmental.
- **Penetration Threshold:** how much weapon penetration is required before damage starts bypassing protection.
- **Weight & Bulk:** affects initiative, dodge, stealth, and some jobs/missions.

Full sets and mixed setups must be viable: players can choose between heavy defence, mobility, or stealth-driven armour strategies.

**Damage Resolution with Armour**  

When a hit occurs, resolve in this order:

1. **Determine Hit Location (if used)**
   - Roll a hit location (head/torso/limbs) based on weapon and stance.
   - Pick the relevant armour piece for that location; if none, treat as unarmoured.

2. **Calculate Effective Armour**
   - Start with piece AR and apply:
     - Quality tier (basic/advanced/elite),
     - Condition (0–100%),
     - Temporary buffs/debuffs (drugs, perks, weather, missions).
   - Result is **Effective AR%**.

3. **Apply Penetration**
   - Compare weapon penetration vs armour **Penetration Threshold**.
   - If penetration < threshold → most damage is reduced, only a small minimum leak-through.
   - If penetration >= threshold → part of the hit bypasses armour:
     - e.g. 40–70% bypass, remainder reduced by AR.

4. **Degrade Armour**
   - Each hit reduces condition by an amount scaled to damage and penetration.
   - Low condition reduces AR up to a floor; at 0 condition, the item is effectively cosmetic.

5. **Apply Damage & Effects**
   - Remaining damage is applied to Life and any on-hit effects are handled (bleeds, stuns, fractures).

**Armour Rarity, Mods & Synergies**  

Armour is grouped into tiers (Common, Uncommon, Rare, Elite, Legendary) with:

- Increasing base AR,
- Unique set bonuses,
- Mod slots (plates, padding, tech modules).

Example mod hooks:

- Lighter materials (reduced weight penalties),
- Special resistances (flashbang reduction, fire resistance, toxin filters),
- Integrated pouches (ammo, tools, smuggling capacity).

Clothing systems (style, masks, cosmetics) may stack visually with armour but should respect mechanical rules:

- Some clothing layers provide **soft bonuses** (intimidation, stealth, job respect) while armour provides hard defence.
- Certain outfits unlock armour set bonuses when worn together (faction uniforms, SWAT gear, riot gear).

**Repair, Maintenance & Sinks**  

- Armour repair is a primary cash sink:
  - Quick Repair (cheap, small condition restore),
  - Full Service (expensive, large condition restore, cosmetics preserved),
  - DIY kits (player item sink, slower but cheaper).
- Severely damaged armour can be salvaged for parts, feeding crafting/upgrading systems.

**Anti-Abuse & Edge Cases**  

- Prevent infinite tank builds by capping maximum effective AR and limiting stacking from armour + drugs + temporary buffs.
- Ensure armour with high AR comes with clear trade-offs (weight, mobility, visibility in crimes, job penalties).
- Guard against “zero-penalty” mixed builds by making sure every strong benefit has a matching drawback in another system (e.g. stealth vs protection).
- PvP logs should clearly show when armour contributed significantly, so BalanceGPT and QAGPT can detect outliers and overperforming items.

### For Architect GPT
- Armour consistency layer; integrates with combat/damage/policing/logging; redundant guardrails to prevent drift.

### For CodeGPT
- Ensure cap checks, legality enforcement, durability handling, mod slots, logging, and scrutineering. Server authoritative.

### For BalanceGPT
- Tunables: resist caps, encumbrance, durability loss/costs, heat penalties. Ensure variety; no invincible builds.

### For QAGPT
- Test caps, legality scans, durability loss/repair, mod enforcement, logging, and warnings; scrutineering behaviour.  
# SECTION 118 — NPC SYSTEM 20.0

## 117.0 Overview
NPC system finalization with dense behaviours, scaling, and integrations. Builds on Sections 037/070/083/084. NPCs drive missions, shops, gangs, events, and encounters. Must be lively, fair, and anti-farm.

## 117.1 NPC Archetypes
- Civilians, Merchants (legal/illegal), Gangs/Crews, Bosses, Police/Patrols, Medics, Event NPCs, Informants.
- Each has stats, AI profile, schedule, location, hostility, loot/stock, and rep hooks.

## 117.2 Spawning & Scaling
- Spawn tables by region/district/time/weather/event; density varies with heat and events.
- Scaling: stats/gear by player band; bosses have floors and unique mechanics; loot adjusted to avoid farm.
- Dynamic presence: gangs shift with player actions/events; merchants close in raids/strikes; police scale with heat.

## 117.3 AI Behaviours
- Aggressive (attack), Defensive (flee/alert), Support (heal/buff), Merchant (trade), Patrol (scan/intervene), Event (scripted).
- AI reacts to status/health; uses consumables if allowed; obeys cooldowns; logs actions.

## 117.4 Missions & Contracts
- NPCs offer missions/contracts; rep affects availability/pricing; failure impacts rep.
- Boss arcs with lockouts; event missions; random encounters trigger mini-missions.

## 117.5 Loot & Economy
- Loot tables per archetype; diminishing returns on repeat farming; daily caps for bosses; merchants stock rotates; illegal stock gated by rep.
- Market influence: NPC vendors’ stock/prices shift with events/heat; raids remove stock temporarily.

## 117.6 Reputation & Hostility
- Rep per NPC faction; affects prices, missions, aggression; hostility states per gang/crew; ambush chance when hostile.
- Police rep/heat interplay: high heat increases patrol hostility; bribes limited; arrests logged.

## 117.7 Events & Routines
- Schedules by time/weather; events override; closures/availability windows shown in UI; routine shifts adjust encounters and crime odds.

## 117.8 Anti-Abuse
- Farm detection: DR on repeat kills; boss lockouts; IP/device bot detection; spawn randomization.
- Vendor abuse: purchase caps; stock limits; price bounds; anti-dupe; counterfeit detection for black-market NPCs.
- Encounter manipulation blocked; server authoritative spawns and loot rolls.

## 117.9 UI/UX
- NPC overlays on map; hostility/presence; vendor panels with stock and rep requirements; mission dialogs with timers; logs of encounters.
- Dark Luxury styling; mobile-friendly; warnings for hostility/heat.

## 117.10 Example Flows
- Boss fight: unique mechanics; loot; lockout; hostility spike; log.
- Merchant closure during raid: stock unavailable; event banner; returns after cooldown.
- Hostile gang ambush: triggered by low rep; fight; loot; heat up; log; rep adjusts.

### For Architect GPT
- NPC 20.0 integrates spawns/AI/rep/economy/missions. Central service driving encounters, vendors, and events across systems.

### For CodeGPT
- Implement spawn tables, AI behaviours, scaling, missions/contracts, rep/hostility, vendor stock/limits, logging, anti-abuse (DR, lockouts, bot detection). Server authority; synchronized with world/events.

### For BalanceGPT
- Tunables: spawn rates, scaling curves, loot tables, rep thresholds, lockouts, hostility triggers, vendor caps. Ensure content density without farm exploits; fairness across bands.

### For QAGPT
- Test spawns across time/weather/events, AI behaviours, loot DR, boss lockouts, rep changes, vendor stock/limits, hostility ambush, logging, and anti-bot detection. Validate UI overlays and warnings.  
# SECTION 119 — UK DRUG SYSTEM 20.0

## 118.0 Overview
UK drug system flavour at maximum detail, wrapping consolidated mechanics. Reinforces legality, slang, scenes, and enforcement. No mechanical changes beyond existing caps/tolerance/addiction; this is a lore/UX anchor.

## 118.1 Categories & Scenes
- Stims (“Lines/Boosters”), Downers (“Bricks”), Hallucinogens (“Veil/Trip”), Performance Blends (“Designer Chems”), Medical (scripts), Specials (black-market exclusives).
- Scenes: estates (downers), nightlife/clubs (stims), festivals (hallucinogens), docks/rail (smuggling), upscale clinics (medical).

## 118.2 Legality & Enforcement
- Most street chems illegal; possession/use increases heat; seizures on scans/raids; fines/jail; black-market rep hit.
- Prescription flavour for medical; ID checks (gating); enforcement uses UK policing rhythm; stings possible.
- Public use risks higher in high-heat zones; nightlife slightly more tolerant but still risky.

## 118.3 Vendors & Distribution
- Vendors: estate runners, club dealers, dock brokers, syndicate suppliers. Rep gates; stock shifts with events/weather.
- Counterfeit risk at low rep; quality bands; stings/busts influenced by heat/time.

## 118.4 UI/UX & Tone
- UK slang in names/descriptions, used sparingly for clarity; Dark Luxury styling; legality warnings.
- Missions reference UK settings; consequences shown; no glamorization; grounded crime drama.

## 118.5 Anti-Drift
- No real brands/gangs; no fantasy chems; UK spelling; serious tone; consequences emphasized (hospital/jail/heat).

### For Architect GPT
- Flavour anchor for drug system; ensures consistency with UK context across missions/vendors/UI.

### For CodeGPT
- Ensure strings, vendor placement, and warnings match UK tone; no mechanic changes; enforce legality messaging.

### For BalanceGPT
- None mechanical; ensure flavour doesn’t imply greater effects.

### For QAGPT
- Check flavour consistency, legality messaging, and tone; ensure mechanics unchanged.  
# SECTION 120 — PLAYER-OWNED COUNTRIES (THE TRUE ENDGAME)

## 119.0 Overview
Extreme endgame concept: player-owned “countries” as ultra-prestige estates. High risk, massive upkeep, purely prestige/QoL; no game-breaking power. Strong anti-abuse; optional feature gate. Aligns with Dark Luxury, UK context, and existing property/estate rules.

## 119.1 Acquisition & Limits
- Requires maximum level/rank, prestige tokens, and massive cash; one country per account; gated event/quest if enabled.
- Escrow, cooldowns, and anti-hoard tax; trades heavily restricted; alt detection; logs.

## 119.2 Benefits (Bounded)
- Large happy cap/QoL (slightly above national estates); minor travel convenience; unique cosmetics (backgrounds/titles/frames). No combat/crime buffs.
- Access to unique cosmetic events/venues; no economy-breaking income.

## 119.3 Upkeep & Risk
- Enormous upkeep/taxes; missed payments degrade benefits; foreclosure after grace; heavy penalties for illegal use.
- Raids possible if used for illegal storage; seizures; fines/jail; prestige loss; insurance void for illegal.

## 119.4 Governance & Permissions
- Owner sets guest/staff permissions; logs all access; can host events; guest heat considered; no war immunity/shelter.
- Staff morale/wages scaled; security mandatory; upkeep tied to compliance.

## 119.5 Anti-Abuse
- One-per-account cap; transfer cool-down; price bounds; alt detection; laundering via trades blocked; stash caps enforced.
- Illegal use triggers high raid odds; cannot bypass heat/police; travel timers still apply.

## 119.6 UI/UX
- Country dashboard: upkeep timer, happy, staff/security, travel, stash, heat risk, prestige score; unique background; Dark Luxury.
- Warnings for unpaid upkeep, raid risk, illegal storage, guest heat.

## 119.7 Interactions
- Travel: dedicated routes; timers; minor convenience only.
- Factions: meetings/events allowed; no war shelters; raids if hosting illegal activities.
- Events: exclusive cosmetic events; no stat gains.

## 119.8 Example Flows
- Purchase: pays tokens+cash; country created; upkeep starts; logs.
- Missed upkeep: benefits reduced; foreclosure if unpaid; stash handled; prestige loss.
- Illegal stash: raid; seizure; fines/jail; benefits reduced; log.

### For Architect GPT
- Endgame country concept that must remain prestige/QoL-only. Integrate with property/estate systems, travel, and heat/police. Consider feature gating.

### For CodeGPT
- Implement if enabled: purchase with caps/escrow, upkeep/foreclosure, permissions, stash, raid logic, logging, anti-abuse. Server authority; strict legality checks.

### For BalanceGPT
- Tunables: costs, upkeep/taxes, happy/QoL bonuses, raid odds, foreclosure grace. Ensure no power creep; purely prestige.

### For QAGPT
- Test purchase, upkeep/foreclosure, permissions, stash caps, raid handling, anti-laundering, logging, and UI warnings. Validate no combat/economy advantage.  
# SECTION 121 — ADVANCED PLAYER HOUSING SYSTEM 12.0

## 120.0 Overview
Advanced housing refinement: automation, personalization, and risk controls without adding power creep. Builds on all property sections; emphasizes UX, moderation, and anti-abuse.

## 120.1 Automation (Bounded)
- Auto-pay upkeep with caps; auto-staff scheduling; auto-maintenance reminders; cannot bypass funds constraints; logs.
- Smart rules: pause auto-actions when illegal items present (to prompt user); safety first.

## 120.2 Personalization
- Expanded cosmetic themes (Dark Luxury variants, borough/regional accents); housing layouts presets; lighting/sound ambience per property; purely visual.
- Display collectibles (cosmetics/trophies) in property view; no buffs.
- Custom labels for rooms/stashes; moderated; no offensive text.

## 120.3 Security & Safety
- Safety checks on illegal upgrades; prompts before enabling; higher raid warnings; insurance void flags.
- Panic protocols: temporary stash lock during raids; notifications; cooldown to prevent abuse.
- Access lists with multi-factor prompts for high-value stashes; logs.

## 120.4 Stash & Inventory QoL
- Search, filters, batch move with rate limits; stash categories; alerts for over-cap; audit trail; anti-dupe.
- Auto-sort presets; no gameplay impact; convenience only.

## 120.5 Events & Guests
- Event hosting with schedules; guest permissions; temporary buffs (happy) per standard rules; crashes; cooldowns; logs.
- Guest heat considered; warnings; ability to block high-heat guests automatically.

## 120.6 Anti-Abuse
- Automation bounded; no bypass of upkeep or security; anti-laundering for trades; IP/device checks; cooldowns on layout/theme changes to prevent spam exploits.
- Logging of all auto-actions; audits available.

## 120.7 UI/UX
- Housing control panel: automation toggles, security warnings, cosmetic presets, stash management, access controls; Dark Luxury styling.
- Clear distinction between visual changes and mechanical effects; warnings for illegal/raid risks.

## 120.8 Example Flows
- Auto-pay runs; funds insufficient; pauses; warning; bonuses reduce accordingly.
- User enables illegal upgrade: security warnings; raid risk up; insurance void; log.
- Guest event: scheduled; happy buff; crash after; cooldown; guest heat filter blocked hostile guests.

### For Architect GPT
- Housing 12.0 adds automation/personalization within bounds. Integrate with property systems, stash, raids, and moderation. Keep no power creep.

### For CodeGPT
- Implement bounded automation, personalization presets, stash QoL with logs, security prompts, guest filters, anti-abuse. Server authority; moderation for labels.

### For BalanceGPT
- Tunables: auto-action limits, event buffs/cooldowns (unchanged caps), raid warnings thresholds. Keep balance intact.

### For QAGPT
- Test automation caps, security warnings, stash QoL functions, guest/event flows, logs, and moderation for labels/themes. Validate no unintended buffs.  
# SECTION 122 — ADVANCED VEHICLES & RACING SYSTEM 14.0

## 121.0 Overview
Advanced vehicle/racing refinement building on Sections 040/046/077/089/095/102. Adds deeper classes, weather/road effects, tournament structure, and compliance enforcement. Anti-collusion and anti-abuse tightened.

## 121.1 Vehicle Classes & Progression
- Classes expanded: A (exotic), B (sports), C (sedan/coupe), D (hatch/bike), Utility (vans/trucks), Illegal DIY, TrenchMade prestige. Class progression via ownership and race performance; no stat creep beyond caps.
- Compliance tiers: legal, restricted, illegal; influences scan/chase risk; scrutineering enforced in legal events.

## 121.2 Racing Modes
- Legal: circuits, time trials, sprints; scheduled tournaments; class-locked; scrutineering; rewards tokens/cosmetics/cash; leaderboards with anti-collusion.
- Street: drag, checkpoint, pursuit; illegal mods allowed; police chase chance; ambush risk; higher rewards; cooldowns.
- Tournaments: brackets/seasonal events; anti-smurf; rewards cosmetic titles/skins.

## 121.3 Performance & Environment
- Performance calc: vehicle base + mods + driver stats (Speed/Dex) + maintenance + weather/road (rain/ice reduce handling; fog reduces visibility; night increases police chance in street races).
- Mishaps: spinouts, minor crashes; odds influenced by maintenance/illegal mods/weather; damage to vehicles; small injury chance.
- Overclock: temporary boost with heat/breakdown risk; cooldown; banned in legal races.

## 121.4 Police & Heat
- Street races raise heat; chase odds scaled by heat/illegal mods; outcomes: fines/jail/seizure of illegal gear/vehicle.
- Legal races do not add heat; compliance checked; illegal gear triggers disqualification and possible seizure if severe.

## 121.5 Mods & Maintenance
- Mod trees per Section 077; diminishing returns; caps. Maintenance affects reliability; neglect raises mishap/breakdown chance.
- Illegal mods increase scan/heat; legal events disallow; street allows with risk.

## 121.6 Anti-Collusion & Abuse
- Matchmaking avoids repeat IP/device opponents; reward scaling reduction if detected; disqualifications.
- Throw detection: minimum performance thresholds; sandbagging flagged; logs with seeds.
- Race spam throttled; cooldowns per player/vehicle; overclock spam blocked; server authority on results.

## 121.7 UI/UX
- Racing hub: legal/street tabs, tournaments, classes, track/route info, weather, risk bands, entry fees, rewards; scrutineering report.
- Post-race: results, times, mishaps, damage, heat/police outcomes; logs; Dark Luxury styling.
- Leaderboards with anti-collusion indicators; bracket views.

## 121.8 Interactions
- Vehicles/mods/maintenance; travel/smuggling; car crimes; heat/police; companies (garages/teams); factions (internal races).
- Events may alter tracks/weather; national threat can raise police response in street races.

## 121.9 Example Flows
- Legal tournament: scrutineering pass; bracket; finishes 1st; cosmetic title; wear applied; no heat.
- Street checkpoint in rain: handling penalty; illegal mods; police chase; heat spike; damage; cooldown.
- Collusion attempt: repeated same-IP matches; rewards reduced; warning; persistent => disqualify.

### For Architect GPT
- Advanced vehicle/racing system integrating compliance, tournaments, environment, and anti-collusion. Uses existing vehicle/mod/heat/police systems.

### For CodeGPT
- Implement tournament brackets, scrutineering, performance calc with environment, mishaps, police chase logic, cooldowns, anti-collusion detection, logging. Server authoritative; enforce caps and illegal mod checks.

### For BalanceGPT
- Tunables: rewards/fees, mishap odds, chase odds, overclock effects, cooldowns, class balance, scrutineering strictness, tournament rewards. Balance safe legal vs risky street.

### For QAGPT
- Test legal/street race flows, scrutineering, mishaps, chase outcomes, tournaments, cooldowns, anti-collusion flags, logging, and UI. Validate caps and illegal gear enforcement.  
# SECTION 123 — WEAPON MODDING & CRAFTING SYSTEM 15.0

## 122.0 Overview
Advanced weapon modding/crafting system unifying mods, attachments, and crafted weapons. Ensures caps, legality, and anti-abuse. Integrates with crafting (Section 086), weapons (Sections 109/114), and black market (Section 097).

## 122.1 Modding Framework
- Slots per weapon class; compatibility tables; mod categories (optics, grips/stocks, mags, barrels/muzzles, underbarrel, special, melee wraps).
- Caps and diminishing returns on stacking similar effects; accuracy/crit/recoil caps enforced.
- Illegal mods flagged; increase heat/scan risk; scrutineering blocks in legal contexts.

## 122.2 Crafting Weapons/Mods
- Legal crafts: basic weapons/mods with stable quality; require legal facilities; low risk.
- Illegal crafts: DIY guns, illegal mods, AP drums; higher malfunction; heat; raid/catastrophe risk from labs (Section 086).
- Quality rolls affect stats/durability/malfunction; counterfeits possible (lower quality); tagged; logs store origin.

## 122.3 Installation & Removal
- Install/removal costs/time; tools/skills; small risk of damaging mod/weapon on removal; illegal installs require black-market/front services.
- Cooldown to prevent buff cycling; server logs all changes; anti-dupe IDs.

## 122.4 Anti-Abuse
- Price bounds for mods/weapons to prevent laundering; anti-dupe; batch craft limits; IP/device checks.
- Mod stacking caps; illegal status persists; cannot cleanse via trade/skin; crafts tagged with origin.
- Scrutineering for legal races/events; illegal mods disallowed; disqualification if found.

## 122.5 UI/UX
- Modding UI: slots, compatible mods, effects/penalties, caps, legality, weight; preview final stats; warnings.
- Crafting UI: recipes, success/quality/risk, timers, costs, legality; Dark Luxury styling.
- Logs visible for installs/crafts; moderation/audit accessible.

## 122.6 Interactions
- Combat/crimes: mods affect performance/noise; legality affects heat; crafting feeds black market.
- Companies/fronts: can produce mods; audits on illegal; reputation tied to quality/defects.
- Shadow economy: illegal mods tracked; laundering caps.

## 122.7 Example Flows
- Craft illegal suppressors: quality varied; heat up; risk of raid; mods tagged; sold on black market.
- Install AP drum: capacity up; jam risk up; legality risk; crime noise unchanged; heat considered.
- Remove mod: small damage chance; cooldown; log.

### For Architect GPT
- Advanced modding/crafting framework aligning with legality, caps, and anti-abuse. Integrates with combat, crafting, black market, companies.

### For CodeGPT
- Implement slot/compatibility, caps, install/remove flows with cooldowns/logs, crafting with quality/risk, tagging, price bounds, scrutineering. Server authority.

### For BalanceGPT
- Tunables: mod effects/caps, quality variance, craft success/catastrophe odds, cooldowns, price bounds, jam risks. Keep balanced; prevent overpowered builds and laundering.

### For QAGPT
- Test install/remove with caps, crafting outcomes, illegal detection, scrutineering, price bounds, logging, cooldowns, and anti-dupe. Validate origin tagging and jam penalties.  
# SECTION 124 — ARMOUR & PROTECTIVE SYSTEMS 16.0

## 123.0 Overview
Further armour/protection refinement to align with damage/weapon/throwable specs. Reinforces caps, legality, mods, and anti-abuse. Complements Sections 109/112/116/117/100.

## 123.1 Armour Types & Slots
- Head/Torso/Legs; types: light/medium/heavy/covert/specialized. Stats: mitigation, resist types, crit/status resist, encumbrance, noise, durability, legality.

## 123.2 Caps & Balance
- Resist/status caps; mitigation floors; penetration caps; encumbrance penalties; ensures no invincible builds; melee/stealth viability preserved with covert options.

## 123.3 Legality & Enforcement
- Restricted/illegal pieces raise scan/police risk; seizures; fines/jail; scrutineering blocks illegal gear in legal contexts.
- Logging on equip/travel; warnings for illegality/low durability; heat penalties displayed.

## 123.4 Mods & Augments
- Limited slots; mods (plates/padding/liners/stealth/dampeners/utility) with diminishing returns; illegal variants flagged; augments minor utility only.
- Compatibility enforced; anti-stack caps; UI shows slot usage and effects.

## 123.5 Durability & Repair
- Durability loss per hit; AP/explosive harsher; zero durability removes benefit; repairs via companies/black market; salvage possible; illegal mods may block legal repair.

## 123.6 Anti-Abuse
- Anti-dupe IDs; price bounds; cap enforcement; server authority; scrutineering; no stealth from cosmetics; mod stacking capped.

## 123.7 UI/UX
- Armour cards with stats/resists/encumbrance/durability/legality/mods; warnings; Dark Luxury styling; compare view; cap indicators.

## 123.8 Example Flows
- Over-cap resist clamped; warning; log.
- Illegal armor scan: seized; fine/jail; heat up; log.
- Broken armor: no mitigation; warning; repair or salvage; log.

### Detailed Mechanics — Advanced Armour & Protective Systems

This section extends the core armour rules with advanced protections, specialised gear, and late-game systems.

**Specialised Protection Types**  

Beyond basic ballistic/melee armour, high-end and specialist gear can include:

- **Covert Armour:** low-visibility vests and liners that provide modest protection with minimal style penalties and low suspicion in the City.
- **Riot & Crowd-Control Gear:** high protection vs melee/projectiles, but heavy, conspicuous, and penalised in stealth and certain jobs.
- **Hazmat & Environmental Suits:** protect against toxins, radiation, environmental hazards during specific missions or events.
- **Tactical Shields:** hand-held shields that protect a portion of incoming attacks at the cost of offence and initiative.

Each category should explicitly state:

- Allowed slots and exclusivity (e.g. shield occupies off-hand, blocking two-handed weapons).
- Movement, stealth, and job impact.
- What mechanics they are intended to counter (grenades, gas, environmental events).

**Layering & Conflicts**  

Advanced protection may layer with base armour, but must obey strict rules:

- Only one **primary armour layer** per slot (e.g. one torso armour).
- Optional **underlayers/overlays** (e.g. stab vest under clothing, hi-vis overcoat on top) that primarily affect social/visibility stats rather than pure defence.
- Priority rules for damage reduction and condition loss when multiple layers exist.

**Progression & Unlocks**  

- Tie advanced protective gear to **late-game content**:
  - Faction war rewards,
  - High-tier missions and raids,
  - Special shops that require reputation/standing.
- This gear should feel aspirational but not mandatory for normal play, avoiding hard gating of basic content.

**Integration with Other Systems**  

- **Crimes & Raids:** certain armour types unlock or modify options in high-risk content (e.g. riot gear for prison breaks, hazmat for lab raids).
- **Jobs & Companies:** uniform armour may be required for specific roles; wearing obviously hostile gear (riot armour, masks) may be penalised in civilian-facing jobs.
- **Police Heat & Visibility:** heavy or tactical armour in public should increase attention, CCTV hits, and specific event triggers.

**Balance & Anti-Abuse Notes**  

- Clearly define diminishing returns on stacking multiple small sources of protection to avoid invulnerable niche builds.
- Avoid gear that is “strictly better” in all contexts; every top item should have a scenario where it’s a bad choice.
- Use logs and analytics to track which armour sets dominate PvP and high-end content; if one set is universal, adjust weight, costs, or counters accordingly.

### For Architect GPT
- Armour 16.0 ensures consistent defense rules with caps/legality/repair. Integrates with combat/damage/policing/logging and modding.

### For CodeGPT
- Enforce caps, legality, durability, mod slots, scrutineering, logging, anti-dupe; server authority.

### For BalanceGPT
- Tunables: resist/mitigation caps, encumbrance, durability loss/costs, heat penalties, mod effects. Keep multiple viable builds and no invincible tanks.

### For QAGPT
- Test cap clamping, legality scans, durability loss/repair, mod slot enforcement, scrutineering, logging, warnings, and anti-dupe.  
# SECTION 125 — EXPLOSIVES, THROWABLES & TACTICAL DEVICES 20.0

## 124.0 Overview
Ultimate throwable/explosive/tactical device spec consolidating legality, caps, weather effects, and anti-abuse. Builds on Sections 048/111/110/095.

## 124.1 Categories
- Grenades: frag, flash, smoke, incendiary, gas (illegal), EMP (event), concussive.
- Breaching charges: objective-only; faction/ops use; not PvP damage.
- Improvised: molotov, acid bottle (illegal), bricks/rocks.
- Tactical devices: flares, signal jammers (illegal), decoys; utility with cooldowns.

## 124.2 Stats & Behaviour
- Damage/status, radius, fuse, throw range, weight, legality, noise; friendly fire possible; indoors amplifies some effects.
- Weather impacts: rain reduces incendiary; wind affects smoke; storms boost EMP flavour; fog increases concealment effectiveness.
- Caps: per-fight use; inventory caps; cooldown between throws; damage/status caps to prevent spam kills.

## 124.3 Legality & Enforcement
- Many items illegal; carrying raises scan/police risk; use in public increases heat; seizures at scans/raids.
- War zones may allow restricted items temporarily; still logged; no exemption from tracking.

## 124.4 Anti-Abuse
- Cooldowns, per-fight caps, price bounds, anti-dupe IDs; no XP from self-damage; friendly-fire abuse detection; breaching charges locked to objectives.
- Reroll/spam blocked; server authority on throws/resolution.

## 124.5 UI/UX
- Cards show stats, legality, caps, weather notes; warnings for self-harm/heat; Dark Luxury styling.
- Combat UI: remaining uses; friendly-fire warning; logs show effects and heat changes.
- Crime UI: risk/heat warnings; stealth penalties for noisy devices.

## 124.6 Interactions
- Combat: status/damage within caps; environment modifies; logs.
- Crimes: public use raises heat; potential immediate police response; gas illegal adds big heat.
- Faction ops/wars: breaching/tactical devices used for objectives; caps enforced.

## 124.7 Example Flows
- Smoke + flash combo: concealment and stun; caps respected; heat up; log.
- EMP event device: disrupts electronics in mission; storm boosts effect slightly; logged.
- Illegal gas: high heat; scan risk; if used, police response sharp; log.

### For Architect GPT
- Explosive/tactical device system with caps, legality, and environment. Integrate with combat, crimes/heat, ops/wars, and logging.

### For CodeGPT
- Implement device templates, caps/cooldowns, weather modifiers, legality/heat handling, anti-dupe, logging, and objective restrictions. Server authority.

### For BalanceGPT
- Tunables: damage/status values, radius, caps, cooldowns, weather modifiers, heat penalties, price/rarity. Keep impactful but controlled; illegal = high risk.

### For QAGPT
- Test equip/use, caps/cooldowns, weather/indoor effects, legality/heat handling, breaching restrictions, logging, and anti-abuse (self-damage, spam).  
# SECTION 126 — MELEE WEAPONS SYSTEM (AAA+ UK STREET x CINEMATIC x TORN-PARITY)

## 126.0 Overview
Complete melee spec: UK street blades, blunt weapons, improvised and prestige melee. Balanced for stealth/low-noise crimes and close combat. No pay-to-win; legality and breakage enforced.

## 126.1 Categories
- Blades: knives (folding/kitchen/combat), machetes, karambits; sharp damage; high crit/bleed; low noise.
- Blunt: bats (wood/aluminium), pipes, hammers; blunt damage; stagger/slow; moderate noise.
- Improvised: bottles, bricks, wrenches; low durability; cheap; high break chance.
- Specialty/Prestige: collapsible batons (low profile), tomahawks, TrenchMade ceremonial blades (cosmetic flair; stats within bounds).

## 126.2 Stats & Effects
- Damage (sharp/blunt), Crit, Bleed/Stagger chance, Accuracy, Speed modifier, Noise, Durability, Weight, Legality.
- Bleed severity higher on blades; stagger higher on blunt; improvised has high break chance; collapsible batons low noise/lower damage.
- Head/leg targeting flavours: leg hits can slow; head has small daze chance; no overpower.

## 126.3 Legality & Heat
- Many melee legal; some blades illegal in public; carrying illegal blades increases scan risk; seizures/fines/jail if caught.
- Crimes: low noise helps stealth; legality still matters; crowbars flagged dual-use; raids seize illegal stock.

## 126.4 Mods & Quality
- Mods: sharpening, wraps, balance weights; spiked bats (illegal) increase bleed/noise/legality risk.
- Quality tiers affect durability and base stats; improvised cannot be modded; prestige skins cosmetic only.

## 126.5 Breakage & Repair
- Durability loss on use; improvised break quickly; broken = destroyed or scrap; repair possible for non-improvised at companies; illegal mods may force black-market repair.

## 126.6 Combat Handling
- Strength scales blunt damage; Dex scales blade accuracy/crit; Speed influences initiative/double-hit.
- Breakage equivalent of malfunction; logged; loses turn if weapon breaks mid-combat.

## 126.7 UI/UX
- Melee cards: stats, legality, noise, durability, mods; warnings for illegal carry and low durability; Dark Luxury styling.
- Crime UI: highlights low-noise; shows heat risk if illegal.

## 126.8 Anti-Abuse
- Mod stacking caps; illegal mods flagged; anti-dupe; price bounds; server durability loss; no stealth from dark skins.
- Farming via disassembly blocked; crowbar dual-use tracked; laundering via trades limited.

## 126.9 Example Flows
- Machete mugging: high bleed; low noise; illegal carry risk; log shows bleed; heat from crime.
- Improvised bottle: breaks on hit; damage low; cheap; logged.
- Spiked bat: bleed up; noise up; illegal; scan risk higher; logs.

### For Architect GPT
- Melee system integrates with combat, crimes/heat, inventory, legality, and mods. Ensure stats balanced and breakage handled.

### For CodeGPT
- Implement melee templates, mod options, legality flags, breakage, durability loss, logging, anti-dupe, price bounds. Hook into combat/crime resolvers; enforce legality checks.

### For BalanceGPT
- Tunables: damage/crit/bleed/stagger, durability/break rates, mod effects, legality penalties, noise. Preserve niche differentiation; no dominant melee.

### For QAGPT
- Test mod limits, legality handling, breakage logic, stat scaling, logging, anti-dupe, and crime UI warnings. Validate dark skins do not affect stealth.  
# SECTION 127 — SHIELDS & DEFENSIVE EQUIPMENT (AAA+ RIOT • MAKESHIFT • ENERGY • TRENCHMADE)

## 127.0 Overview
Shields and defensive gear refinement: riot, tactical, improvised, and prestige variants. Ensures coverage, encumbrance, legality, and anti-abuse. Integrates with combat/damage and legality systems.

## 127.1 Types & Stats
- Riot: high blunt/impact mitigation, decent ballistic deflection; heavy; restricted/legal for security; restricted elsewhere.
- Tactical: balanced; ballistic focus; medium encumbrance; restricted/illegal.
- Improvised: bin lids/plywood; low mitigation; high break chance; legal.
- Prestige/Energy (event/TrenchMade): cosmetic flair; stats within bounds; may offer slight status resist; illegal if high-tech; heat risk.
- Stats: mitigation, resists, coverage %, encumbrance, durability, noise, legality; status resist minor.

## 127.2 Coverage & Handling
- Coverage is frontal; cap coverage; flanks/backs not protected; logs show blocks.
- Weapon compatibility: pistols/SMGs/melee ok; rifles penalized; dual-wield blocked; two-handers incompatible.
- Encumbrance reduces initiative/dodge; caps; cannot negate penalties entirely.

## 127.3 Legality & Enforcement
- Restricted shields raise scan/police risk; seizures/fines/jail; scrutineering blocks illegal shields in legal events; riot legal only for certain roles; logs.
- Improvised carry no legal risk unless used in crime (heat from action).

## 127.4 Durability & Repair
- Durability loss on block; AP/explosives damage more; zero durability → breaks; repair via companies/black market; illegal shields need covert repair.

## 127.5 Mods & Upgrades
- Limited slots: padding, coatings, viewport reinforcement, weight reduction. Diminishing returns; illegal variants flagged.
- No stacking beyond slots; caps on coverage/status resist.

## 127.6 Anti-Abuse
- Coverage caps; encumbrance penalties; anti-dupe IDs; price bounds; mod stacking limits; server authority; legality checks.
- No stacking multiple shields; collision with armor encumbrance enforced.

## 127.7 UI/UX
- Shield cards: stats, coverage, encumbrance, durability, legality, mods; warnings; Dark Luxury styling; compatibility hints.
- Combat logs show blocks, coverage, durability loss.

## 127.8 Example Flows
- Riot shield + pistol: blocks some frontal hits; encumbrance lowers initiative; legal only in specific contexts; illegal elsewhere -> heat.
- Tactical shield with rifle: accuracy penalty; block still possible; encumbrance applied; log.
- Improvised: cheap; low block; breaks quickly; no legal risk; log.

### For Architect GPT
- Shield/defensive gear system aligned with combat and legality. Integrate with armor/encumbrance, mods, and repair services.

### For CodeGPT
- Implement shield templates, coverage, compatibility, encumbrance, durability loss/repair, legality checks, mod slots, logging, anti-dupe. Enforce caps and scrutineering.

### For BalanceGPT
- Tunables: coverage %, mitigation, encumbrance, durability loss, mod effects, legality penalties. Prevent invulnerability; keep shields situational.

### For QAGPT
- Test coverage/block calc, compatibility, encumbrance, durability loss/repair, mod caps, legality/scan, logging, and anti-dupe. Validate caps and scrutineering for illegal shields.  
# SECTION 128 — ARMOUR SYSTEM (BODY ARMOUR • PLATES • HELMETS • FUTURISTIC • TRENCHMADE)

## 128.0 Overview
Armour system culmination for body armour, plates, helmets, specialized/futuristic, and TrenchMade cosmetics. Reinforces caps, legality, encumbrance, and UI clarity. Maintains realism; avoids sci-fi power creep.

## 128.1 Armour Classes
- Body Armour: light/medium/heavy; core mitigation; resist profiles; encumbrance.
- Plates/Inserts: ballistic/chem/fire/electric; slotted; weight; diminishing returns; caps.
- Helmets: head slot; crit resist; status resist; encumbrance; legality.
- Covert: low noise/encumbrance; lower mitigation; legality safer; stealth aid but no invisibility.
- Futuristic/TrenchMade (cosmetic flair): stats within allowed ranges; visual only for flair beyond set bonuses.

## 128.2 Stats & Caps
- Mitigation (flat/%), resist per type, crit/status resist, encumbrance, noise, durability, legality. Caps on resist/status; mitigation floors; penetration cap to prevent full bypass.
- Encumbrance penalties enforced; Strength/Speed mitigate slightly; caps.

## 128.3 Legality & Enforcement
- Restricted/illegal items raise scan/police risk; seizures; fines/jail; scrutineering for events/races; covert gear reduces noise not legality.
- Futuristic skins do not alter legality; cosmetic only.

## 128.4 Durability & Repair
- Durability loss on hits; AP/explosive harsher; zero durability removes benefit; repair/salvage paths; illegal mods may force black-market repair.

## 128.5 Mods & Slots
- Mods per piece: plates, padding, liners, stealth mesh, dampeners, utility; limited slots; diminishing returns; illegal variants flagged; show in UI; cap enforcement.

## 128.6 Anti-Abuse
- Anti-dupe IDs; price bounds; cap enforcement; server authority; scrutineering; no stealth from dark skins; illegal gear flagged.
- No stacking multiple plates beyond slots; no invincible builds; logs for mod changes.

## 128.7 UI/UX
- Armour cards with stats, resist table, encumbrance, durability, legality, mods; warnings; Dark Luxury styling. Compare view; set/skin indicators (cosmetic only).

## 128.8 Example Flows
- Heavy armour with plates: mitigation high; encumbrance up; heat risk; caps enforced; log.
- Covert set: low noise; lower mitigation; legal; used for stealth crimes; warnings show legal/heat status.
- Futuristic skin applied: visuals change; stats unchanged; legality unchanged; log.

### For Architect GPT
- Final armour class spec; integrate with combat/damage, legality/heat, repairs, and cosmetics. Enforce caps and legality.

### For CodeGPT
- Implement armour classes with caps, durability, mods, legality checks, scrutineering, logging, anti-dupe. Ensure skins do not alter stats.

### For BalanceGPT
- Tunables: resist/mitigation values, encumbrance, plate effects, durability loss, heat penalties, price bounds. Maintain multiple viable builds; avoid invincible combos.

### For QAGPT
- Test equip/caps, durability loss/repair, mod slot enforcement, legality/scan, cosmetic skin non-impact, logging, and scrutineering.  
# SECTION 129 — EXPLOSIVES • GRENADES • BREACH DEVICES • IEDs • FUTURISTIC • TRENCHMADE (AAA+ EDITION)

## 129.0 Overview
Consolidated explosives spec with high-tier/futuristic/TrenchMade cosmetics. Aligns with Sections 125/111/110/095. Ensures caps, legality, weather effects, and anti-abuse.

## 129.1 Categories
- Grenades: frag, flash, smoke, incendiary, gas (illegal), EMP (event), concussive, cryo (event cosmetic).
- Breaching: charges for objectives; not PvP damage; faction/ops.
- IEDs: improvised; higher malfunction; illegal; risk of self-damage; heat.
- Futuristic/TrenchMade: cosmetic variants of above; stats within bounds; legality unchanged if base is illegal.

## 129.2 Stats & Behaviour
- Damage/status, radius, fuse, throw range, weight, legality, noise. Friendly fire possible. Indoors amplify some effects; weather alters incendiary/smoke/EMP.
- Caps: per-fight use; inventory caps; cooldowns; damage/status caps prevent spam wipes.

## 129.3 Legality & Enforcement
- Most explosives illegal; carrying raises scan/police risk; use in public spikes heat; seizures/jail/fines.
- War zones may allow restricted use; still logged; heat may rise.

## 129.4 Anti-Abuse
- Cooldowns; per-fight caps; price bounds; anti-dupe; no XP from self-damage; friendly-fire abuse detection; IED malfunction risk.
- Reroll/spam blocked; server authoritative resolution.

## 129.5 UI/UX
- Cards: stats, legality, caps, weather notes; warnings; Dark Luxury styling.
- Combat UI: remaining; friendly-fire warning; logs show effects/heat.
- Crime UI: risk/heat warnings; stealth penalty for noisy explosives.

## 129.6 Interactions
- Combat: status/damage within caps; environment modifies.
- Crimes: public use triggers heat/police; gas illegal big heat.
- Faction ops/wars: breaching charges objective-only; caps enforced.

## 129.7 Example Flows
- IED: high damage; malfunction risk; illegal; heat spike; log.
- Cryo (event cosmetic): visual only; stats same as concussive/flash; legality per base type.
- Breach device: damages objective; not PvP; logged to war feed.

### For Architect GPT
- Explosive system with caps/legality/weather; integrates with combat, crimes/heat, ops/wars, and logging.

### For CodeGPT
- Implement explosive templates, caps/cooldowns, weather modifiers, legality/heat handling, anti-dupe, logging, malfunction for IEDs. Enforce objective-only for breaching; server authority.

### For BalanceGPT
- Tunables: damage/status values, caps, cooldowns, weather modifiers, heat penalties, malfunction odds. Keep impactful but controlled; illegal = high risk.

### For QAGPT
- Test equip/use, caps/cooldowns, weather effects, legality/heat, IED malfunctions, breaching restrictions, logging, and anti-abuse (self-damage).  
# SECTION 130 — MELEE WEAPONS (BLADES • BATONS • MACHETES • IMPROVISED • EXOTIC • ENERGY • TRENCHMADE)

## 130.0 Overview
Expanded melee catalogue including exotic/event skins; mechanics consistent with Section 126. Balanced for stealth crimes and close combat; legality and breakage enforced.

## 130.1 Categories
- Blades: knives, machetes, karambits; sharp damage; bleed/crit; low noise.
- Batons/Blunt: bats, pipes, hammers, batons; stagger/slow; moderate noise.
- Improvised: bottles, bricks; low durability; high break chance.
- Exotic/Prestige: tomahawks, trench blades, energy-flair skins (cosmetic); stats within bounds; legality per base type.

## 130.2 Stats & Effects
- Damage (sharp/blunt), Crit, Bleed/Stagger, Accuracy, Speed mod, Noise, Durability, Weight, Legality. Caps and breakage rules apply.
- Bleed higher on blades; stagger on blunt; improvised breaks; exotic skins cosmetic only.

## 130.3 Legality & Heat
- Many melee legal; certain blades illegal in public; carrying illegal raises scan risk; seizures/fines/jail.
- Crimes: low noise aids stealth; legality still checked; dual-use tools (crowbars) flagged; raids seize illegal stash.

## 130.4 Mods & Quality
- Mods: sharpening, wraps, spikes (illegal), balance weights; caps; diminishing returns.
- Quality tiers affect durability and base stats; improvised not moddable; energy skins cosmetic.

## 130.5 Breakage & Repair
- Durability loss on use; improvised high break; broken destroyed/scrapped; repair via companies for mod-capable; illegal mods may force black-market repair.

## 130.6 Combat Handling
- Strength scales blunt; Dex scales blade accuracy/crit; Speed for initiative/double-hit; breakage logs and loses turn if mid-fight.

## 130.7 UI/UX
- Melee cards: stats, legality, noise, durability, mods; warnings; Dark Luxury styling; crime UI shows stealth/heat.

## 130.8 Anti-Abuse
- Mod stacking caps; anti-dupe IDs; price bounds; legality checks; no stealth from skins; server durability loss; laundering via trades limited.

## 130.9 Example Flows
- Karambit crime: bleed/crit; low noise; illegal carry risk; log.
- Spiked bat: stagger/bleed higher; noise/legal risk up; log.
- Bottle: breaks on first hit; minimal damage; cheap; logged.

### For Architect GPT
- Melee catalogue aligned with legality, caps, and breakage. Integrate with combat, crimes/heat, mods, and inventory.

### For CodeGPT
- Implement melee templates, mods, legality flags, breakage, durability, logging, anti-dupe, price bounds. Hook into combat/crime resolvers.

### For BalanceGPT
- Tunables: damage/crit/bleed/stagger, durability, mod effects, legality penalties, noise. Ensure multiple viable melee picks; no OP exotic skins.

### For QAGPT
- Test mod limits, legality handling, breakage, stat scaling, logging, anti-dupe, UI warnings, and skin non-impact on stealth.  
# SECTION 131 — THROWABLES (STREET • MARTIAL • UTILITY • CHEMICAL • ENERGY • TRENCHMADE)

## 131.0 Overview
Throwable refinement: broader catalogue (street/martial/utility/chemical/energy skins) consistent with caps/legality. Builds on Sections 111/125/129.

## 131.1 Categories
- Street: bricks, bottles (improvised).
- Martial: shuriken (flavour), throwing knives; low damage; stealth; legality varies.
- Utility: smoke, flash, flares, decoys.
- Chemical: gas (illegal), acid (illegal), EMP (event).
- Energy/TM skins: cosmetic variants; stats per base type.

## 131.2 Stats & Rules
- Damage/status, radius, range, legality, noise, durability (single-use), caps (per fight and inventory), cooldown.
- Weather: rain reduces incendiary/chemical; wind affects smoke/decoys; fog boosts concealment effect.
- Friendly fire possible; indoors amplifies; self-harm risk if careless.

## 131.3 Legality & Heat
- Many illegal; scans seize; heat increases on carry/use; martial throwables may be restricted; gas/acid high heat.
- War/event contexts may allow certain restricted items; still logged.

## 131.4 Anti-Abuse
- Caps/cooldowns; price bounds; anti-dupe IDs; no XP for self-harm; friendly-fire abuse flagged; objective-only restriction for certain utility in ops.
- No stealth from dark skins; cosmetics non-impactful.

## 131.5 UI/UX
- Cards: stats, legality, caps, weather notes; warnings; Dark Luxury styling.
- Combat UI: throw count; friendly-fire warning; logs effects/heat.
- Crime UI: heat warnings; stealth penalty for noisy throwables.

## 131.6 Example Flows
- Throwing knife: low noise; damage modest; legality warning; log.
- Gas grenade: illegal; heat spike; scan risk; status applied; log.
- Smoke + decoy: concealment; caps respected; log.

### For Architect GPT
- Throwable catalogue alignment with caps/legality/weather; integrates with combat, crimes, ops, and logging.

### For CodeGPT
- Implement templates, caps/cooldowns, legality checks, weather modifiers, anti-dupe, logging, and objective restrictions where needed. Server authority.

### For BalanceGPT
- Tunables: damage/status values, caps, cooldowns, weather modifiers, heat penalties, price bounds. Keep useful but controlled; illegal high risk.

### For QAGPT
- Test throwables across categories, caps/cooldowns, legality/heat, weather effects, logging, and UI warnings; confirm cosmetics non-impact.  
# SECTION 132 — MEDICAL ITEMS (HEALING • RECOVERY • CLEANSE • STABILISATION • TRENCHMADE)

## 132.0 Overview
Medical items system: heals, recovery, cleanse, and stabilisation. Supports combat, hospital reduction, detox, and status cleanse. Balances potency with cooldowns and legality; integrates with medical system and combat.

## 132.1 Categories
- Healing: medkits, bandages, first aid (stop bleed, restore HP chunk).
- Recovery: stim crash reducers, minor energy/happy boosts (legal meds), regen accelerators (limited).
- Cleanse: antidotes (poison), anti-burn/anti-chem rinses, status removers.
- Stabilisation: revive kits (faction/company medics), defibs (restricted), pain management (reduces debuffs briefly).
- TrenchMade/Event: cosmetic skins; potency within bounds.

## 132.2 Rules & Cooldowns
- Combat use: limited uses per fight; action cost; cooldown between uses; cannot exceed HP caps; no stacking cleanses beyond caps.
- Out-of-combat: hospital reduction items; cooldowns; diminishing returns; cannot bypass severe timers completely.
- Legality: some restricted (defibs, strong meds); seizures if caught with restricted without role; logs.

## 132.3 Effects & Limits
- Healing capped; no instant full restores; diminishing returns if spammed; server authority.
- Crash reducers moderate severity/duration slightly; cannot erase crashes; cooldown.
- Revives: require medic role/items; success chance based on items/skills; failure extends hospital.

## 132.4 UI/UX
- Item cards: effect, cooldown, restrictions, legality, use context; warnings; Dark Luxury styling.
- Combat UI: available uses; cooldown timers; status cleanse indicators.
- Hospital UI: items applicable; reduction estimates; diminishing returns displayed.

## 132.5 Anti-Abuse
- Per-fight use limits; cooldowns; no bypass of hospital via item spam; anti-dupe; price bounds; legality checks.
- Revive spam blocked via cooldowns and failure penalties; server authority on HP changes.

## 132.6 Interactions
- Combat: heals/cleanses; logs; consumes items; affected by status caps.
- Medical system: hospital time reduction; revive flows; legality; heat if restricted meds misused.
- Drugs: crash reducers interact with drug system slightly; cannot remove addiction.
- Companies: medical services provide items; quality affects potency; audits.

## 132.7 Example Flows
- Bandage in combat: stops bleed; small heal; uses one charge; cooldown; log.
- Revive kit: medic uses; success returns to threshold HP; fail adds hospital time; cooldown.
- Hospital reduction item: shortens timer a bit; diminishing returns; legal unless abused; log.

### For Architect GPT
- Medical item system aligned with combat and hospital rules; integrates legality, cooldowns, and anti-abuse.

### For CodeGPT
- Implement item definitions, per-fight limits, cooldowns, legality checks, revive success, hospital reduction with DR, logging, anti-dupe. Server-authoritative HP changes.

### For BalanceGPT
- Tunables: heal amounts, cooldowns, crash reduction magnitude, revive success, hospital reduction caps, legality penalties. Keep fights fair; avoid bypassing hospital.

### For QAGPT
- Test use limits, heals, cleanses, revive success/fail, hospital reduction DR, legality checks, logging, UI timers; ensure no spam bypasses.  
# SECTION 133 — DRUGS (REAL DRUG FAMILIES • UK STREET SLANG • POWER SCALES • ADDICTION • ECONOMY • TRENCHMADE)

## 133.0 Overview
Drug catalogue aligned to real families with UK slang; consistent with consolidated mechanics. Defines power scales, addiction, economy, and cosmetic TrenchMade variants. No new mechanics; flavour + organization.

## 133.1 Families & Examples
- Stimulants: amphetamines, coke (“Lines”), designer stims (TrenchMade skins).
- Downers/Painkillers: opioids (“Bricks”), benzos (limited; high addiction), legal pain meds.
- Hallucinogens: LSD-like (“Veil”), mushrooms (“Trip”), event visuals.
- Performance blends: mixed chems for small all-stat boosts; high crash/tolerance.
- Medical: legit meds; low crash; scripts flavour.
- Specials: black-market exclusives with unique names; illegal; strong crashes.

## 133.2 Power Scales & Crashes
- Stims high boost/high crash; downers moderate boost/nerve pain relief/high addiction; hallucinogens crit/happy up with accuracy penalty/heavy crash; blends small all-stat boost with high tolerance growth; medical minimal.
- Power capped by category; crashes scale with tolerance; addiction on heavy use.

## 133.3 Economy
- Sources: black market, events, missions; legal meds via shops; price bands; rarity influences price; counterfeit risk for low rep.
- Demand shifts by region/weather/events; nightlife increases stim demand; smog/cold increases downer demand.
- Price bounds to prevent laundering; no points for direct purchase; rep gates for high-tier.

## 133.4 Legality & Enforcement
- Illegal for most families; seizures/busts; heat; fines/jail; rep loss; public use risky.
- Scripts for medical as gate; still logged.

## 133.5 TrenchMade Variants
- Cosmetic skins/names for prestige; stats within family bounds; no mechanical buff; rarity cosmetic.

## 133.6 UI/UX
- Catalogue showing families, slang, effects/crashes, legality, addiction risk; Dark Luxury styling; warnings.
- Logs for purchases/uses; addiction/tolerance meters separate.

### For Architect GPT
- Flavour and organization for drug families; tie to existing mechanics; UK street tone with realism.

### For CodeGPT
- Ensure catalogue entries/strings reflect families/slang; apply existing effect/crash/addiction rules; price bounds; legality warnings.

### For BalanceGPT
- Not mechanical; ensure power scales reflect existing caps; price ranges align with rarity.

### For QAGPT
- Validate catalogue consistency, warnings, price bounds, and no stat inflation from TrenchMade skins.  
# SECTION 134 — BOOSTERS (ENERGY • HAPPY • NERVE • MULTI-BAR • STAT • ECONOMY • TRENCHMADE)

## 134.0 Overview
Booster system for non-drug consumables that affect bars/stats minimally. Distinct from drugs; capped; cooldowns; no addiction. Integrates with bars and economy; TrenchMade cosmetic variants possible.

## 134.1 Categories
- Energy Boosters: small energy refills; cooldown; DR; crash minor.
- Happy Boosters: small happy spike; crash small; diminishing returns.
- Nerve Boosters: tiny nerve tick; higher cooldown; possible crash to happy.
- Multi-bar Boosters: small combined boosts; capped; crash applies; rare.
- Stat Boosters (temporary): tiny % buff to battle stats for short duration; capped; crash; not stackable with similar.
- Economy Boosters: minor market fee reduction/time-limited; not stackable; heavily capped; no pay-to-win.
- TrenchMade/Prestige boosters: cosmetic skins; effects within category caps.

## 134.2 Rules & Cooldowns
- Category caps; one booster active per category; global booster cap (excluding food/drink/drugs) to prevent stacking.
- Cooldowns between uses; diminishing returns on repeated use; server authority; logs.
- Crashes small and short; no addiction/tolerance like drugs.

## 134.3 Legality & Acquisition
- Mostly legal; some event boosters; economy boosters limited-sale; price bounds; no direct cash-to-advantage beyond small QoL.
- Sold in shops/events; rewards; achievements; limited per day.

## 134.4 UI/UX
- Cards show boost, duration, crash, cooldown, caps; warnings; Dark Luxury styling.
- HUD shows active boosters; timers; upcoming crash; booster category indicators.

## 134.5 Anti-Abuse
- Caps and cooldowns enforced; DR; price bounds; no stacking with drugs of same effect; server authoritative.
- No market manipulation: economy boosters capped; cooldowns; logs; cannot chain for permanent advantage.

## 134.6 Interactions
- Bars: small boosts; crashes minor.
- Drugs: cannot stack similar effects; booster use blocked if drug active in same category; logs.
- Events: boosters as rewards; time-limited; effects within caps.

## 134.7 Example Flows
- Energy booster: +small energy; cooldown; crash tiny; log.
- Economy booster: market fee reduced 5% for 30m; once/day; capped; log.
- Stat booster: +2% battle stats for 10m; crash -2%; cooldown; not stackable with other stat boosters.

### For Architect GPT
- Booster system separate from drugs; integrates with bars/market; uses caps/cooldowns to prevent advantage stacking.

### For CodeGPT
- Implement booster categories, caps, cooldowns, crash application, blocking when conflicting drug active, logging, price bounds. Server authority on bar/stat changes.

### For BalanceGPT
- Tunables: boost/crash values, durations, cooldowns, daily limits, price bounds. Keep boosts minor/QoL; avoid pay-to-win.

### For QAGPT
- Test booster use, caps/cooldowns, crash timing, conflict with drugs, logging, price bounds, and market booster limits.  
# SECTION 135 — FOOD & DRINK (UK CUISINE • MEAL DEALS • RESTAURANTS • BUFFS • ECONOMY • EVENTS • PRESTIGE)

## 135.0 Overview
Food/drink catalogue with UK cuisine, restaurants, meal deals, events, and prestige variants. Effects remain minor and capped; primary value is flavour/economy/social. Builds on Sections 059/080/087/086.

## 135.1 Categories & Cuisine
- UK staples: pies, fish & chips, curries, kebabs, fry-ups, sandwiches/meal deals, pub snacks; drinks: tea/coffee, softs, pints, spirits, energy drinks.
- Event specials and prestige brews (cosmetic rarity); effects same scale.
- Happy/regen/energy effects small; crashes minor; alcohol adds accuracy penalty and small crash to happy/nerve.

## 135.2 Restaurants & Meal Deals
- Restaurants by district (wealth affects menu/price); seating flavour; no gameplay beyond items.
- Meal deals: bundled items with minor discount; capped purchases/day to prevent abuse.
- Catering: bulk orders for parties (properties); quality affects duration slightly; defects logged.

## 135.3 Economy & Supply
- Supply from companies; stock varies by region/weather/events; price bounds; reputation impacts restaurant ratings (cosmetic).
- Event foods tradeable within bounds; authenticity tags; no laundering.

## 135.4 Effects & Rules
- Minor boosts only; cooldowns/caps; DR on spam; crashes small; alcohol debuffs; no stacking with drugs/boosters of same category.
- Spoilage optional (small); stale items reduced effect; logs.

## 135.5 UI/UX
- Menus show effects/duration/crash/cooldowns; restaurant UI; meal deal builder; Dark Luxury styling.
- Warnings for alcohol debuffs and caps; property party menus.

## 135.6 Anti-Abuse
- Purchase caps; price bounds; cooldowns; server authority on effects; no bypass of bars; no stat buffs.
- Meal deal spam blocked; catering farming limited; anti-macro on rapid buys.

## 135.7 Interactions
- Bars: happy/energy small; crashes minor; cannot override drug/booster conflicts.
- Properties: parties consume items; happy buffs; crash; staff serving.
- Companies: catering production; ratings cosmetic; recalls for defects; reputation hits.
- Events: themed foods/brews; achievements cosmetic.

## 135.8 Example Flows
- Meal deal: sandwich + crisps + drink; happy +small; crash tiny; cooldown; log.
- Pub pint: happy up; accuracy down briefly; crash small; warning shown.
- Catering order: delivered; party buff; crash later; logs; defects trigger recall.

### For Architect GPT
- Food/drink catalogue with UK flavour and capped effects. Integrate with bars, properties, companies, economy, and events; keep effects minor.

### For CodeGPT
- Implement items/menus, meal deals with caps, effects/cooldowns/crashes, catering flows, price bounds, logging. Server authority; anti-macro.

### For BalanceGPT
- Tunables: effect sizes/durations, crashes, cooldowns, meal deal caps, catering quality impact, price bounds. Keep boosts minor/QoL.

### For QAGPT
- Test item effects, cooldowns, meal deal caps, catering orders, alcohol debuff, logging, and anti-abuse. Validate no overlap with drug/booster buffs.  
# SECTION 136 — ALCOHOL SYSTEM (UK REALISM • STREET CULTURE • BUFFS • DRUNK MECHANICS • PRESTIGE BREWS)

## 136.0 Overview
Alcohol system with UK realism and street culture. Effects are minor, capped, and mostly happy/accuracy trade-offs. No addiction system separate from drugs. Integrates with food/drink, bars, events, and economy.

## 136.1 Categories
- Pints (lager/ale), spirits, cocktails, wine, event brews (seasonal), prestige brews (cosmetic rarity).
- Strength tiers influence effect magnitude/duration; all capped; crashes mild.

## 136.2 Effects & Debuffs
- Happy up; slight accuracy/Speed down depending on strength; duration short; crash: small happy/nerve down; regen slight drop.
- Stacking raises debuff/crash; caps prevent heavy impairment; warnings shown.
- No addiction beyond general drug system; tolerance not tracked separately.

## 136.3 Cooldowns & Caps
- Cooldown between drinks; daily soft cap; diminishing returns; server authority; logs.
- Cannot stack with stimulant boosters that would create contradictory effects; highest debuff applies.

## 136.4 Economy & Legality
- Legal; age flavour only; sold in pubs/shops/restaurants; price bounds; event brews limited; prestige brews cosmetic rarity only.
- No seizures; but drunk state in crimes could raise failure odds slightly (flavour) if implemented conservatively.

## 136.5 UI/UX
- Drink cards: effects, debuffs, duration, cooldown, caps; warnings; Dark Luxury styling.
- Buff/debuff display on HUD with timers; property party menus include drinks; pubs have menus with UK flavour.

## 136.6 Anti-Abuse
- Caps and cooldowns enforce minor impact; no stat gain stacking; anti-macro on spam; price bounds.
- No laundering via prestige brews; trade bounds; cosmetic rarity only.

## 136.7 Interactions
- Bars: happy minor; debuff to accuracy; crash small; cannot override drug effects; conflicts resolved by applying worst debuff.
- Properties/events: parties serve drinks; buffs apply; crash later; cooldowns still apply.
- Crimes/combat: optionally apply small debuff when drunk; keep minimal to avoid frustration.

## 136.8 Example Flows
- Player drinks pint: happy +small; accuracy -small; duration short; crash tiny; cooldown; log.
- Multiple drinks: diminishing returns; debuff increases modestly; warning; cap prevents excessive stacking.
- Event brew: cosmetic rarity; effects within normal range; log.

### For Architect GPT
- Alcohol system tied to food/drink and bars; minor buffs/debuffs; no addiction. Integrate with menus, parties, events, and logs.

### For CodeGPT
- Implement drink items with effects/debuffs/cooldowns/caps, HUD display, logging, price bounds, conflict resolution with other consumables. Server authority.

### For BalanceGPT
- Tunables: effect/debuff sizes, durations, cooldowns, caps, price bounds. Keep flavourful and minor; avoid frustration.

### For QAGPT
- Test drink effects/debuffs, cooldowns/caps, conflict resolution with drugs/boosters, logging, UI warnings, and price bounds. Validate no laundering via prestige brews.  
# SECTION 137 — WORKING STATS SYSTEM (MAN • INT • END)

## 137.0 Overview
Recap and tightening of working stats (MAN/INT/END) and their economy hooks. Builds on Sections 004/022/061/105. Ensures DR, variety incentives, and anti-abuse.

## 137.1 Uses
- Job eligibility and promotions; shift success; special procs.
- Company performance and quality; production/QA; services efficacy.
- Crimes/OCs roles (muscle/hacker/driver); mission checks; crafting quality.
- Future crafting/professions; property staff effectiveness.

## 137.2 Gains & DR
- Gains from shifts/company work/education/missions; minor from achievements; consumables limited.
- Daily DR; variety bonus for working in multiple roles; weekly bonus for multi-sector experience; caps to prevent macro.
- Education synergies reduce DR slightly in related fields.

## 137.3 Checks & Effects
- Thresholds gate jobs/roles; scale shift outcomes; influence company revenue/defect rates; alter OC success in roles.
- No direct combat effect; distinct from battle stats; kept separate in UI.

## 137.4 Anti-Abuse
- Shift spam throttled; DR; captcha on bot patterns; hire/fire loop detection; wage laundering alerts.
- Alt boosting blocked via IP/device checks; logging for audits.

## 137.5 UI/UX
- Working stat panel; gains per shift; DR indicator; variety bonus status; clear separation from battle stats; Dark Luxury styling.
- Job/company UI shows requirements and current stats; progress to next tier.

## 137.6 Example Flows
- Player rotates roles: variety bonus applied; DR reduced; gains logged.
- Promotion check: stats meet threshold; promotion succeeds; log.
- Shift spam: DR kicks; captcha if abusive; gains reduced; log.

### Detailed Mechanics — Working Stats (MAN, INT, END)

**Purpose of Working Stats**  

MAN (Manual), INT (Intelligence), and END (Endurance) represent long-term professional capability, mirroring Torn-style working stats but branded for Trench City. They power:

- Job entry requirements and promotion thresholds.
- Company roles (directors, managers, specialists).
- Special mission branches, investigations, and complex multi-step tasks.
- Certain crime types that require real competence rather than raw street power.

These stats are intentionally **slow to grow** and form a deep progression backbone separate from combat.

**Sources of MAN/INT/END**  

- **Jobs & Companies:** daily work ticks grant small amounts of the relevant stat(s), scaled by job level and performance.
- **Education & Training:** specific courses reward focused working stat gains (e.g. accounting = INT, construction = MAN, security = MAN+END).
- **Books & Rare Items:** limited-use items grant one-time boosts, often gated behind missions or high prices.
- **Events & Missions:** certain storylines temporarily boost or permanently reward working stats.

Gains should be:

- Diminishing per day to discourage abuse via AFK or low-effort looping.
- Capped per time window so late-game players can’t instantly max new alts.

**Usage & Gating**  

Examples of how MAN/INT/END should gate content:

- **Jobs:**
  - MAN-heavy roles: construction, security, manual labour companies.
  - INT-heavy roles: finance, tech, consultancy, law.
  - END-heavy roles: emergency services, logistics, stamina-driven work.

- **Companies:**
  - Directors require a minimum combined working stat total plus high stat in one domain.
  - Special roles (e.g. Head of Security, Lead Analyst) require specific thresholds.

- **Missions/Crimes:**
  - Complex heists require minimum INT for planning, MAN for execution, END for long-duration operations.
  - Certain stealth or infiltration tasks require a blend of stats rather than just combat power.

**Scaling & Balance Model**  

- Working stats should follow a **curved progression**:
  - Early gains (0–10k) feel noticeable and unlock basic roles quickly.
  - Mid-range (10k–1M) opens strong career paths and powerful company roles.
  - High-end (1M+) is prestige territory with very slow growth and niche benefits.

- BalanceGPT should tune:
  - Daily cap per stat and per source.
  - Conversion rates from job performance ratings to stat gains.
  - Impact of bonuses (education, items, faction perks) to avoid trivialising the grind.

**Anti-Abuse & Edge Cases**  

- Prevent trivially bot-able loops (e.g. spam-click low-tier actions with zero risk) from giving meaningful working stats.
- Require account age, Level, or mission completion for high-yield learning activities.
- Make sure powerful working stat thresholds are **soft gates**: provide alternate paths to content for players who prefer crime/combat-first progression, albeit with different rewards.

### For Architect GPT
- Working stat system with DR and variety incentives; integrates with jobs, companies, crimes/OCs, crafting. Keep distinct from battle stats.

### For CodeGPT
- Implement stat tracking, DR, variety bonuses, thresholds, logging, anti-abuse detectors. Expose APIs to jobs/companies/crimes/missions; UI separation from battle stats.

### For BalanceGPT
- Tunables: gains per source, DR curves, variety bonus size, thresholds, caps, anti-abuse sensitivity. Keep economy meaningful without macro farming.

### For QAGPT
- Test stat gains, DR, variety bonuses, promotion checks, anti-abuse triggers, logging, and UI separation.  
# SECTION 138 — BASIC FACTORY SYSTEM (MASS PRODUCTION • WORKING-STATS SYNERGY • SUPPLY CHAINS • PLAYER ECONOMY)

## 138.0 Overview
Basic factory system for mass production, tied to working stats, supply chains, and player economy. Extends company/crafting systems (Sections 014/022/032/063/086/105/137). Designed to be balanced, audit-friendly, and resistant to laundering.

## 138.1 Facilities & Setup
- Factories owned by companies; require upgrades for capacity/quality; consume supplies; staffed by employees with working stats.
- Types: manufacturing (weapons/armor/consumables), parts, packaging; legal only—illegal production handled in black-market labs (Section 086/075).

## 138.2 Production Flow
- Queue jobs: input materials, set batch size; success/quality influenced by staff stats, upgrades, morale, and compliance.
- Outputs: items with quality tags; defects possible; defect rate reduced by QA; batches logged.
- Capacity and throughput capped; diminishing returns on stacking upgrades; upkeep costs.

## 138.3 Supply Chains
- Inputs from suppliers (companies/market); contracts with SLA; delays from events/travel/weather; shortages reduce output.
- Logistics: transport times; ambush risk if high heat/illegal items (if attempted illegally).

## 138.4 Economy & Pricing
- Produced goods sold to market/stores/contracts; price bounds to prevent laundering; reputation impacted by defect rate and SLA performance.
- Taxes/fees optional; revenue logged; laundering detection on anomalous prices/volumes.

## 138.5 Working Stats Synergy
- MAN influences throughput/defect rate; INT influences quality/efficiency; END influences uptime/fatigue penalties.
- DR on stat contribution to prevent runaway scaling; weekly bonus for balanced teams.

## 138.6 Compliance & Audits
- Compliance meter tracks safety/legality; low compliance raises audit/raid risk; incidents reduce compliance; fines/shutdowns possible.
- Safety incidents logged; repeated incidents trigger audits; insurance optional for legal goods.

## 138.7 Anti-Abuse
- Capacity caps, price bounds, audit triggers, logging of batches/materials, IP/device checks for laundering via orders; no illegal production allowed here.
- Duplicate output detection; anti-duplication IDs; no craft currency/points.

## 138.8 UI/UX
- Factory dashboard: queues, capacity, supplies, compliance, morale, output quality, defect rate, contracts; Dark Luxury styling.
- Warnings for shortages, audits, defect spikes, compliance risks; logs accessible.

## 138.9 Example Flows
- Batch run: inputs set; success; quality good; defects low; sold to market; revenue logged.
- Defect spike: morale low; QA weak; defect rate up; reputation drops; warning; owner adjusts staff/upgrades.
- Audit: triggered by incidents; fines; shutdown; compliance lowered; cooldown.

### For Architect GPT
- Factory system ties production to working stats and compliance; integrates with companies, supply chains, market, audits. Keep legal-only; illegal handled separately.

### For CodeGPT
- Implement factory queues, capacity, quality/defect calc, compliance, audits, logging, price bounds, anti-duplication, and supply chain timing. Enforce legal-only production; server authority.

### For BalanceGPT
- Tunables: capacity, quality curves, defect rates, compliance effects, audit frequency, price bounds, stat DR. Ensure profitability balanced; no exploit via laundering.

### For QAGPT
- Test job queues, capacity caps, quality/defect outcomes, compliance changes, audits, supply delays, price bounds, logging, and anti-dupe. Validate legal-only enforcement.  
# SECTION 139 — ADVANCED FACTORY SYSTEM

## 139.0 Overview
Advanced factory layer expanding Section 138 with automation, specialization, and tighter compliance. Still legal-only; illegal production belongs to labs. Focus on QoL within bounds, anti-abuse, and deeper supply chain hooks.

## 139.1 Specialization & Upgrades
- Specializations: precision (quality up, capacity down), throughput (capacity up, quality down), balanced, eco (lower costs, slower). Choose per factory; change with cooldown/cost; logged.
- Upgrades: automation modules, QA labs, logistics hubs, safety systems; diminishing returns; caps.

## 139.2 Automation (Bounded)
- Auto-queue reorders within capacity; supply auto-order with caps; stops if funds low or compliance low.
- Alerts for shortages/defects; auto-pause on compliance breach or audit; logs all auto-actions.

## 139.3 Compliance & Safety
- Compliance meter affects audit/raid risk; specializations impact compliance (throughput reduces compliance slightly, precision improves).
- Safety incidents reduce compliance/morale; repeated incidents trigger audits and possible shutdown.
- Insurance for legal production; excludes illegal items.

## 139.4 Workforce & Morale
- Workforce management: shifts, overtime (risk up, morale down), training boosts quality slightly; DR on training gains.
- Morale affects defect rates and uptime; morale drops on incidents; wages/bonuses restore.

## 139.5 Supply Chain Deepening
- Multi-tier supply: components from other factories; contract chains; delays propagate; weather/events affect logistics; monitoring dashboard.
- Warehousing: stock limits; spoilage for perishables; stock aging affects quality for certain goods.

## 139.6 Anti-Abuse
- Capacity, automation, and price bounds; audit triggers on anomalies; anti-laundering via price/volume caps; IP/device checks for order farming.
- Auto-actions cannot exceed bounds; server authority; immutable logs.

## 139.7 UI/UX
- Factory control panel: specialization, automation toggles, compliance, incidents, morale, supplies, queues, warehousing; Dark Luxury styling.
- Alerts for audits, shortages, defects, overtime risk; logs accessible.

## 139.8 Example Flows
- Switch to precision: quality up, capacity down; compliance improves; log.
- Supply delay: upstream factory late; queue slows; alert; possible SLA impact.
- Overtime push: capacity up temporarily; morale down; defect rate rises; logged.

### For Architect GPT
- Advanced factory layer with specialization, bounded automation, and compliance. Integrate with company, supply chain, audits, and economy; keep legal-only.

### For CodeGPT
- Implement specializations, bounded automation, compliance effects, incident handling, warehousing with aging, logging, and anti-abuse checks. Server authority; caps enforced.

### For BalanceGPT
- Tunables: specialization modifiers, automation caps, compliance impacts, defect rates, morale effects, supply delays. Maintain profitability without exploits.

### For QAGPT
- Test specialization swaps, automation bounds, compliance/audit triggers, workforce morale effects, supply delays, warehousing caps, logging, and anti-laundering.  
# SECTION 140 — PROPERTY SYSTEM (UK REAL ESTATE • HAPPINESS ENGINE • UPGRADE TREES • STAFF • MEGA-PROPERTY • ENDGAME COUNTRY ESTATES)

## 140.0 Overview
Property consolidation across city estates, mega-properties, and country estates. Includes happy engine, upgrades, staff, security, and endgame holdings. Aligns with Sections 017/022/035/041/045/064/121/120.

## 140.1 Tiers & Holdings
- City tiers (bedsit→estate), mega-properties (luxury estates, bunkers), country estates, and player-owned countries (Section 120). Caps to prevent hoarding; one country estate; cluster caps; flip taxes.
- Prestige tokens + cash for highest tiers; escrow; cooldowns; anti-laundering.

## 140.2 Happy & QoL
- Happy baseline by tier; upgrades/staff add; caps; parties/events add temporary boosts with crashes; comfort DR to prevent stacking; breakdown UI shows sources/caps.
- Regen QoL small; med rooms/gym rooms minor; no combat buffs.

## 140.3 Upgrades & Trees
- Security tree (locks, CCTV, alarms, panic room), Comfort (furniture, entertainment, climate), Functional (stash, vault, helipad/garage, workshop, med bay), Illegal (hidden stash, jammer room, illicit lab—raises heat/raid risk).
- Install times/costs; maintenance; diminishing returns; illegal voids insurance; logs.

## 140.4 Staff & Tenants
- Staff roles: cleaner, chef, security, medic, trainer, concierge. Wages; morale affects effectiveness; staff caps per tier; shared pools for clusters.
- Tenants: rent; satisfaction; eviction rules; background checks; defaults logged; rent income bounded.
- Permissions: spouse/faction/guests; stash access per role; logs; rate limits to prevent churn abuse.

## 140.5 Security & Raids
- Security score with diminishing returns; influences burglary/raid success. Raids triggered by illegal items/heat; seizures/fines/jail; cooldowns; logs; insurance void on illegal.
- Burglary crimes use security vs attacker skill; loot from stash; cooldown on repeat.

## 140.6 Stash & Storage
- Capacity by tier/upgrades; hidden stash reduces detection; categories for legal/illegal; logs; anti-dupe; stash churn limits.
- Vaults for high capacity; insurance covers legal items only.

## 140.7 Upkeep & Taxes
- Upkeep per tier; auto-pay option; missed upkeep reduces bonuses; foreclosure after grace; flip/hoard taxes for anti-abuse.

## 140.8 Mega-Property & Country Estates
- Mega-properties in city: larger capacity/happy; higher upkeep; heat risk if illegal use.
- Country estates: high happy/QoL, travel requirement, high upkeep; raid risk if illegal; no combat/economy buffs; prestige only.

## 140.9 UI/UX
- Property dashboard: security, happy breakdown, upgrades, staff/tenants, stash, upkeep, heat risk; Dark Luxury styling.
- Warnings: illegal risk, upkeep due, capacity, raid cooldown, foreclosure alerts.
- Cluster/national views; logs consolidated; travel shortcuts.

## 140.10 Anti-Abuse
- Caps, taxes, cooldowns, escrow, alt detection; anti-laundering via price bounds; stash churn limits; insurance fraud detection.
- Illegal use raises raid risk; cannot bypass heat/police; logs immutable.

## 140.11 Example Flows
- Upgrade tree: installs CCTV and vault; security up; stash capacity up; heat risk unchanged; logs.
- Missed upkeep: bonuses reduced; warning; foreclosure if unpaid; stash handled; prestige hit.
- Illegal lab: raid; seizure; fines/jail; insurance void; log; cooldown.

### For Architect GPT
- Consolidated property spec across tiers/mega/country; integrates happy engine, security, stash, staff, raids, and travel. Ensure caps and anti-abuse safeguards.

### For CodeGPT
- Implement tiers, upgrades, staff/tenant systems, stash, security calc, raids, upkeep/taxes, cluster/country views, logging, anti-laundering. Server authority; caps enforced.

### For BalanceGPT
- Tunables: happy caps, upgrade effects/costs, staff wages/effects, raid odds, upkeep/taxes, hoard/flip penalties. Keep properties strong in happy/QoL without combat/economy power.

### For QAGPT
- Test purchase/trade caps, upgrades/security, staff/tenant flows, stash permissions/capacity, raids/seizures, upkeep/foreclosure, logs, and warnings. Validate illegal risk and insurance behaviour.  
# SECTION 141 — HEALTH, INJURY & MEDICAL SYSTEM

## 141.0 Overview
Health/injury/medical system summary combining hospital, injuries, revives, seizures, and detox. Aligns with Sections 031/032/132/136. Focus on fairness, logging, and anti-abuse.

## 141.1 Health & Injuries
- HP from bars/stats/gear; states: Healthy, Injured, Critical, Hospitalized. Injuries: bleed, fractures, burns, shock, concussive, long-term (rare).
- Injuries apply regen/combat penalties; durations; stacking caps; treatment reduces duration; untreated decays slower.

## 141.2 Hospital
- Entry from HP ≤ 0, severe injuries, overdose, events. Timer based on damage; reduced by medical skills, meds, faction/company med facilities, properties; increased by drug crashes.
- Actions in hospital: limited; buy meds; request revive; detox; minimal education gains; no crime/travel.
- Discharge on timer or revive; logs reason/duration; seizures for illegal items possible.

## 141.3 Revives
- Require medic role/items; success based on item/skill; failure adds hospital time; cooldowns per patient/medic; fee optional; logs.
- Restrictions: certain events/war rules may limit; cannot bypass critical debuffs.

## 141.4 Medical Items & Services
- Medkits/bandages/antidotes/crash reducers/revive kits; quality impacts potency; legality for strong meds.
- Services: hospital treatments, company medical services, faction med bays, property med rooms. Illegal chems risky; may extend injuries/heat.

## 141.5 Seizures & Heat
- Hospital/scan can seize illegal items; fines/jail; heat up; logs; black-market rep loss possible.
- Overdose logs flagged; may increase scan frequency temporarily.

## 141.6 UI/UX
- Hospital view: timer, injuries, treatment options, revive requests, costs; Dark Luxury styling; warnings for illegal seizure risk.
- HUD chip: hospital timer; status chips for injuries; tooltips.
- Logs: injury application/clear, hospital in/out, revives, seizures, treatments.

## 141.7 Anti-Abuse
- Revive spam blocked with cooldowns; self-harm to skip timers blocked; illegal bypass prevented; server authority.
- Macro detection on item spam; seizure on illegal items not suppressed by tricks.

## 141.8 Interactions
- Combat/crimes/events: main injury sources; armor reduces severity; drugs can cause overdose/hospital.
- Properties/factions/companies: med facilities reduce timers; insurance optional for legal items; illegal voids.
- Policing: seizures tie to heat; jail possible if illegal items found.

## 141.9 Example Flows
- KO in combat: hospital timer; injury bleed; med treatment shortens; revive clears hospital early; log.
- Overdose: hospital + addiction flag; detox option; illegal items seized; heat spike; log.
- Revive fail: adds time; cooldown; log; medic pays cost; restrictions respected.

### For Architect GPT
- Health/injury system integrated with combat, drugs, policing, and medical services. Server authority; clear logs.

### For CodeGPT
- Implement injury tracking, hospital timers, revives with cooldowns/success calc, seizures, detox hooks, logging, anti-abuse (self-harm, spam). Enforce restrictions in events/wars.

### For BalanceGPT
- Tunables: hospital times, injury severities, revive success/cooldowns, treatment effects/costs, seizure odds. Keep impact meaningful; avoid hard locks.

### For QAGPT
- Test injury application/clear, hospital timers, revives success/fail/cooldowns, treatments, seizures, logging, and anti-abuse. Validate UI timers/warnings and event/war restrictions.  
# SECTION 142 — DRUG SYSTEM (UK STREET CATEGORIES • SLANG STRENGTH TIERS • ADDICTION • PURITY • OVERDOSE • WITHDRAWAL • BLACK MARKET • CRIME 2.0)

## 142.0 Overview
Expanded drug spec focusing on purity/strength tiers, overdose rules, and crime integration. Builds on consolidated drug systems (Sections 084/118/133). Mechanics unchanged; adds organization and flavour for purity and strength tiers.

## 142.1 Categories & Strength Tiers
- Families: stims, downers, hallucinogens, blends, medical, specials.
- Strength tiers: Low/Street, Standard, Pure, TrenchMade (cosmetic prestige). Higher purity increases effect slightly within caps, increases crash and overdose risk; illegal.
- Purity shown as band; affects price and detection risk marginally.

## 142.2 Effects, Crashes, Overdose
- Effects/crashes per family per consolidated rules; purity scales both effect and crash within caps.
- Overdose: server blocks use if risk threshold passed; attempt logged; exploit attempts may injure. Overdose risk rises with high purity + stacking + high tolerance.
- Withdrawal/addiction per Section 066/118; unchanged.

## 142.3 Crime Integration
- Certain high-end crimes/black ops may require purity thresholds; reward scales; risk higher; seizures if caught.
- Heat/police: high-purity drugs increase scan/bust risk; bigger fines; black-market rep impact.

## 142.4 Black Market & Purity
- Vendors sell varied purity; low rep gets lower purity and counterfeit risk; high rep unlocks higher purity with higher bust odds.
- Crafting (Section 086/075): purity roll based on recipe/skill/tools; catastrophe risk; tagged items.

## 142.5 UI/UX
- Drug cards show family, effects/crash, purity band, overdose warning; Dark Luxury styling.
- Logs include purity, effects, crashes, seizures, overdose blocks; addiction/tolerance meters separate.

## 142.6 Anti-Abuse
- Caps on effect regardless of purity; overdose blocks; price bounds; anti-dupe; laundering via purity premiums prevented; server authority.

### For Architect GPT
- Purity/strength layer on top of drug mechanics; integrates with crimes, black market, and crafting. No new math beyond scaling within caps.

### For CodeGPT
- Add purity attribute to drug items; apply scaling within caps; integrate overdose checks; update vendors/crafting outputs; logging. Ensure heat/bust risk adjusts with purity.

### For BalanceGPT
- Tunables: purity scaling factors, overdose thresholds, price multipliers, detection risk; ensure caps hold and risk rises with purity.

### For QAGPT
- Test purity scaling, overdose blocking, vendor/craft outputs, crime requirements, logging, and price/detection adjustments. Validate caps and anti-abuse.  
# SECTION 143 — ALCOHOL SYSTEM (UK DRINK CULTURE • DRUNK EFFECTS • MIXOLOGY • EVENTS • PRESTIGE SPIRITS)

## 143.0 Overview
Alcohol system refinement with UK drink culture and mixology. Effects remain minor; happy vs accuracy trade-offs; no addiction. Builds on Section 136/135. Dark Luxury tone; no glamorization without consequences.

## 143.1 Drink Types
- Pints (lager/ale), cider, spirits, cocktails, wine, shots; event/prestige brews (cosmetic rarity).
- Mixology: crafted cocktails for events; effects still within minor caps; flavour-only recipes.

## 143.2 Effects & Debuffs
- Happy up; slight accuracy/Speed down; duration short; crash small happy/nerve drop; regen slightly down briefly.
- Stacking raises debuff/crash; caps; warnings; no addiction tracked.
- Drunk state may reduce crime/attack success slightly (optional); keep minimal to avoid frustration.

## 143.3 Cooldowns & Caps
- Cooldown between drinks; daily soft cap; diminishing returns; server authority; logs.
- Cannot stack conflicting buffs; worst debuff applies; alcohol blocked if certain drug states active (configurable).

## 143.4 Economy & Events
- Sold in pubs/shops/restaurants; price bounds; event/prestige spirits limited-run; cosmetic prestige only.
- Events: tasting missions; pub crawls (achievements/cosmetics); effects same scale.

## 143.5 UI/UX
- Drink cards with effects/debuffs/caps; warnings; Dark Luxury styling; pub UI; party menus.
- HUD shows drunk state timer; debuff indicators.

## 143.6 Anti-Abuse
- Caps/cooldowns; DR; price bounds; anti-macro; no laundering via prestige bottles; logs.
- No stat buffs; only minor happy; debuffs enforced; cannot bypass rehab/drug systems.

## 143.7 Interactions
- Food (Section 135) may slightly reduce alcohol crash if consumed; minor only.
- Drugs/Boosters: conflicts resolved by applying worst debuff; no stacking to negate crashes.
- Properties/Events: parties use drinks; happy buff; crash; cooldowns apply.

## 143.8 Example Flows
- Cocktail: happy +small; accuracy -small; crash tiny; cooldown; log.
- Multiple shots: debuff up; crash up; warning; cap stops further use; log.
- Event prestige spirit: cosmetic rarity; same effects; log.

### For Architect GPT
- Alcohol culture layer with minor effects/debuffs; integrate with food/parties/events and economy; no addiction.

### For CodeGPT
- Implement drinks with caps/cooldowns/debuffs, mixology recipes (flavour), price bounds, logging, conflict resolution with drugs/boosters. Server authority.

### For BalanceGPT
- Tunables: effect/debuff sizes, durations, caps, cooldowns, price bounds. Keep flavourful and minor.

### For QAGPT
- Test drink effects/debuffs, cooldowns/caps, conflicts with drugs/boosters, logging, price bounds, and event/prestige items.  
# SECTION 144 — TOBACCO & NICOTINE SYSTEM

## 144.0 Overview
Tobacco/nicotine system for flavour and minor effects. No combat/economy power; small happy/regen tweak and long-term minor debuff for heavy use (flavour). Dark Luxury presentation; UK context; anti-abuse.

## 144.1 Items & Use
- Cigarettes, cigars, vapes (flavour), roll-ups; event skins. Effects: tiny happy bump, negligible regen tweak; no combat buff; cosmetic smoke optional (toggle).
- Cooldowns to prevent spam; daily soft cap; no stacking with similar boosters; logs.

## 144.2 Effects & Debuffs
- Minor happy; tiny regen effect; long-term heavy use can apply small stamina debuff (flavour) until a short detox; displayed; no addiction system like drugs.
- No impact on battle stats; optional small social flavour (chat emotes).

## 144.3 Health & Detox
- Heavy use flag triggers detox suggestion; detox clears minor debuff; short timer; no hospital.
- No bar refills; purely cosmetic/minor; crash negligible.

## 144.4 Legality & Economy
- Legal; age flavour; sold in shops/events; price bounds; no seizures; prestige skins cosmetic only.
- Market trade allowed within bounds; no laundering; logs.

## 144.5 UI/UX
- Item cards: effect, cooldown, debuff note for heavy use; toggle for smoke visuals; Dark Luxury styling.
- HUD chip optional to show active minor effect; detox prompt when flagged.

## 144.6 Anti-Abuse
- Cooldowns; caps; no stacking with boosters/drugs of similar category; no stat buffs; server authority; anti-macro; price bounds.

## 144.7 Interactions
- Bars: negligible impact; no conflict with drugs beyond shared cooldown category.
- Properties/events: cosmetic only; parties can serve; no extra buff.

## 144.8 Example Flows
- Cigarette: tiny happy; cooldown; log.
- Heavy use: debuff flag; detox suggested; short timer clears; log.
- Vape skin: cosmetic only; no mechanical change; tradeable within bounds.

### For Architect GPT
- Tobacco system is flavour/QoL only; integrate with items/shops and UI; ensure no gameplay power.

### For CodeGPT
- Implement items with caps/cooldowns, minor effects, detox flag, smoke toggle, price bounds, logging. Server authority.

### For BalanceGPT
- Tunables: effect size (very small), cooldowns, caps, debuff thresholds, price bounds. Keep impact negligible; flavour focus.

### For QAGPT
- Test use, cooldowns, heavy-use flag/detox, logging, smoke toggle, price bounds, and conflict blocks with similar boosters.  
# SECTION 145 — SPORTS SYSTEM

## 145.0 Overview
Sports system for flavour, mini-games, and economy hooks. Includes betting (simulated), training, and events. Must avoid real gambling issues (use in-game tokens with caps) and keep effects cosmetic/QoL with minor bars where noted.

## 145.1 Sports Types
- Football, boxing, racing leagues, athletics, e-sports (flavour), gym challenges. NPC/player participation in events; player actions limited to training mini-games and token bets.

## 145.2 Training & Participation
- Sports training mini-games consume small energy; give tiny happy or working stat flavour; capped; no battle stat boosts.
- Events: scheduled matches; players can spectate/bet with tokens; limited interaction; rewards cosmetic/tokens; no stat gains.

## 145.3 Betting & Tokens
- Use in-game tokens (not cash) with caps; odds simulated; house edge transparent; anti-collusion; anti-bot.
- Limits per day; no real-money implications; logs; cooldowns after big wins.

## 145.4 Economy & Companies
- Sports companies/gyms can host events; revenue from tickets (cash) and bets (tokens); reputation cosmetic.
- Merchandising (cosmetics) tied to teams/events; no stats.

## 145.5 UI/UX
- Sports hub: schedules, odds, caps, rewards, training mini-games, logs; Dark Luxury styling.
- Warnings for caps and house edge; logs of bets and results.

## 145.6 Anti-Abuse
- Caps on bets and training; IP/device checks for collusion; anti-bot on betting; logs; no laundering via tokens (price bounds/caps).
- No farmable stat gains; rewards cosmetic/tokens only; DR on training mini-games.

## 145.7 Interactions
- Events feed newspaper/feeds; achievements; titles; social content.
- Companies can tie into contracts for events (security, catering).
- Bars: training uses minor energy; happy gains tiny.

## 145.8 Example Flows
- Player bets tokens on match within cap; wins tokens; logs; cooldown; cosmetic badge for season participation.
- Training mini-game: small happy; working stat flavour; capped daily.
- Event attendance: pays ticket; gets cosmetic item; no stats; log.

### For Architect GPT
- Sports system is cosmetic/QoL with token betting caps; integrate with events, companies, and feeds; ensure no pay-to-win.

### For CodeGPT
- Implement schedules, token betting with caps/odds, training mini-games with caps, logging, anti-collusion/bot, and UI. Server authority.

### For BalanceGPT
- Tunables: bet caps, house edge, training gains (tiny), cooldowns, reward rates. Keep risk minor and cosmetic.

### For QAGPT
- Test betting caps/odds/results/logs, training caps, anti-bot/collusion detection, rewards, and UI warnings. Validate tokens not used for laundering.  
# SECTION 146 — PET SYSTEM

## 146.0 Overview
Pet system summary; aligns with Sections 056/080. Cosmetic/light utility; caps; anti-abuse; illegal exotics risky.

## 146.1 Pet Types & Slots
- Legal pets (dogs, cats, birds, foxes event); exotic illegal (owls/reptiles) with risk; slots limited; exotic slots separate and capped.
- Adoption via shops/rescues/events; fees; rep gates for exotics; no combat stats.

## 146.2 Care & Upkeep
- Feed/groom/vet; neglect => inactivity; happiness drives tiny buff (happy/fetch) with caps; logs.
- Upkeep costs; exotics higher; special care items; failure increases seizure risk for exotics.

## 146.3 Traits & Training
- Traits (obedient/curious/vigilant); minor cooldown/utility effects; capped; training costs time/cash; DR; logs.

## 146.4 Risk & Enforcement
- Illegal exotics raise heat/scan/raid risk; seizures/fines/jail if caught; black-market rep down; events may temporarily reduce risk.
- Travel restrictions; smuggling exotics high risk; concealment minor help.

## 146.5 UI/UX
- Pet stable: happiness, care timers, traits, risk indicator (for exotics), skins; Dark Luxury cards; reminders.
- Accessibility: hide pet visuals toggle; status text remains.

## 146.6 Anti-Abuse
- Buffs capped; no combat; fetch cooldown; pet farming blocked; trade bounds; IP/device checks on mass trades; illegal exotics cannot launder.

## 146.7 Interactions
- Properties: some disallow exotics; staff reduce upkeep; raids seize illegal exotics; happy bonus small.
- Events: pet events with skins/achievements; no stat effects.
- Market: pet skins tradeable within bounds; no power.

## 146.8 Example Flows
- Adopt legal pet: care timers start; small happy buff when cared; fetch on cooldown; log.
- Exotic smuggle fail: seizure; fine/jail; rep loss; log.
- Neglect: pet inactive; warning; care restores; buff resumes; log.

### For Architect GPT
- Pet system with legal vs exotic, risk, and minimal utility. Integrates with heat/police, properties, and events; anti-abuse caps.

### For CodeGPT
- Implement pet slots, care timers, traits, risk logic for exotics, buffs with caps, logging, trade bounds, and anti-abuse. Enforce no combat effects.

### For BalanceGPT
- Tunables: buff sizes, care costs, exotic risk, slot limits, training effects, trade bounds. Keep utility minimal; risk meaningful for exotics.

### For QAGPT
- Test adoption/care/training, buffs, exotic seizures, slot limits, logging, risk warnings, and accessibility toggle. Validate no combat impact.  
# SECTION 147 — VEHICLES & TRANSPORT SYSTEM

## 147.0 Overview
Transport recap for vehicles/travel; synthesizes Sections 101/102/122/090/095/121. Focus on legality, smuggling, compliance, and anti-abuse.

## 147.1 Modes & Routes
- Road (cars/vans/trucks/bikes), trains, coaches, ferries, limited regional flights. Routes with time/cost/scan/ambush; weather/heat modify.
- Schedules for trains/ferries/flights; road immediate with variable time; refunds/compensation rules; single active trip.

## 147.2 Vehicles & Compliance
- Ownership, garages, maintenance, legality flags; compliance (MOT/insurance) reduces scan penalties; illegal mods raise risk; scrutineering for legal races.
- Transfers with price bounds; illegal status persists; logging; anti-dupe.

## 147.3 Smuggling & Cargo
- Cargo capacity per vehicle; concealment compartments; overclock to reduce time with heat/breakdown risk.
- Scans/roadblocks seize illegal cargo; fines/jail; heat; black-market rep impact; mule detection; anti-cancel farming.

## 147.4 Police/Heat & Ambush
- Heat increases scans/patrols; ambush risk based on route/time/weather; gangs may attack; police chases on street races or flagged routes.
- National threat raises scan odds; events (strikes) cause delays/closures; compensation applied.

## 147.5 UI/UX
- Travel planner: modes, routes, times/costs, risk bands, cargo; warnings for illegal items/illegal mods; Dark Luxury styling.
- HUD: status chip with ETA; alerts for delays/ambush; logs.

## 147.6 Anti-Abuse
- Teleport prevention; single trip; refund caps; mule detection; IP/device checks; server authority on timers; anti-collusion for races.
- Price bounds on vehicle trades; anti-dupe; compliance checks; smuggling reroll blocked.

## 147.7 Interactions
- Crimes (car crimes, smuggling), black market, shadow economy, factions (convoys), companies (transport services), properties (garages), weather/events.

## 147.8 Example Flows
- Train travel: ticket; scan risk; delay; compensation; arrival; log.
- Van smuggle: concealment; scan risk high; success profit; failure seizure/jail; heat spike.
- Illegal mod travel: scan finds; vehicle seized/fine/jail; log.

### For Architect GPT
- Transport synthesis with legality, smuggling, and compliance. Integrates across crime, black market, factions, companies, properties, and events.

### For CodeGPT
- Implement planner, timers, scans/ambush, compliance checks, smuggling handling, refunds/comp, logging, anti-abuse; server authority.

### For BalanceGPT
- Tunables: times/costs, scan/ambush odds, compensation, cargo limits, overclock penalties, refund caps. Balance reliability vs smuggling risk.

### For QAGPT
- Test travel/race flows, scans/seizures, ambush, single-trip enforcement, refunds, compliance, logging, and anti-abuse checks. Validate warnings and heat interactions.  
# SECTION 148 — BLACK MARKET SYSTEM

## 148.0 Overview
Final black market recap integrating vendors, smuggling, crafting, and shadow economy. Builds on Sections 093/097/124/129/142. Focus on access, risk, busts, and anti-abuse.

## 148.1 Access & Reputation
- Tiered access via level/rep/informants; time/location/weather gates; events modify availability.
- Rep gained from successful buys/smuggles; lost on busts/counterfeits/stings.

## 148.2 Goods & Services
- Goods: illegal weapons/mods, drugs, nerve kits, tools, concealment, forged IDs, illegal upgrades, crafting mats.
- Services: smuggling routes, illicit repairs, intel; high cost/risk; no escrow.

## 148.3 Stock & Pricing
- Dynamic stock; limited quantities; quality bands; surge during crackdowns; discounts at high rep; counterfeit risk at low rep.
- Price bounds to stop laundering; purchase caps; cooldowns.

## 148.4 Risk & Enforcement
- Bust/sting chance scales with heat, item tier, rep, location/time; outcomes: seizure, fines/jail, rep loss, heat spike.
- Travel scans seize illegal goods; raids on known vendors; logs; national threat increases risk.

## 148.5 Smuggling Integration
- Vendors feed smuggling cargo; routes vary by risk; concealment modifies; busts affect rep; logs; seizures remove goods.
- Mules detected via IP/device patterns; escalating scan odds.

## 148.6 Anti-Abuse
- Purchase caps; cooldowns; IP/device checks; anti-mule; price bounds; counterfeits; server authority; no reroll on reconnect.
- Items tagged with origin; laundering blocked; anti-dupe IDs.

## 148.7 UI/UX
- Covert shop UI with risk bands, stock, prices, rep requirements, timers; warnings; Dark Luxury styling.
- Logs: purchases, busts, counterfeits, rep changes; player view and mod audit.

## 148.8 Example Flows
- High-rep buy: low bust; success; rep up; log.
- Sting: high heat; purchase triggers bust; item seized; jail; rep down; heat spikes.
- Counterfeit: low rep; weak item; log; no refund.

### For Architect GPT
- Black market synthesis: vendors, smuggling, crafting, shadow economy. Integrate with heat, travel, policing, companies/fronts, and logging.

### For CodeGPT
- Implement tiers/rep, stock rotation, risk calc, purchases with bust/counterfeit, smuggling ties, caps, anti-mule, logging. Enforce price bounds and server authority.

### For BalanceGPT
- Tunables: bust/counterfeit odds, rep thresholds, stock rarity, caps, price ranges, national threat effects. Keep risk/reward sharp; prevent laundering.

### For QAGPT
- Test access, purchases, busts/counterfeits, caps, smuggling seizures, logging, and anti-abuse (mules, rerolls). Validate UI warnings.  
# SECTION 149 — PETS & ANIMAL SYSTEM

## 149.0 Overview
Final pet/animal recap consolidating prior pet specs. Cosmetic/light utility only; illegal exotics carry risk; anti-abuse enforced.

## 149.1 Pet Classes & Slots
- Legal pets (dogs, cats, birds, foxes event) and illegal exotics (owls/reptiles). Separate slot caps; exotics limited; require rep/level for adoption.
- Adoption sources: shops, rescues, events; fees; cooldowns; logs.

## 149.2 Care, Traits, Buffs
- Care loop: feed/groom/vet; neglect => inactive; happiness drives tiny happy/fetch buff; caps; logs.
- Traits: obedient/curious/vigilant; minor cooldown/utility effects; training with DR; no combat stats.

## 149.3 Risk & Enforcement
- Exotics raise heat/scan/raid risk; seizures/fines/jail if caught; black-market rep down; events may reduce risk temporarily.
- Travel restrictions for exotics; smuggling high risk; concealment minor help.

## 149.4 Anti-Abuse
- Buffs capped; fetch cooldown; no combat; trade bounds; IP/device checks; exotic hoard blocked; laundering via pets/skins prevented.
- Server authority on buffs and care timers; logs immutable.

## 149.5 UI/UX
- Pet stable: care timers, happiness, traits, risk (exotics), skins; reminders; Dark Luxury styling; accessibility toggle to hide visuals.
- Warnings for exotic risk and neglect; logs visible.

## 149.6 Interactions
- Properties: pet allowance; staff reduce upkeep; raids seize illegal exotics; small happy bonus.
- Events: pet events/skins/achievements; cosmetic only.
- Market: pet skins tradeable within bounds; no power gain.

## 149.7 Example Flows
- Adopt legal pet: buff active when cared; fetch on cooldown; log.
- Exotic seizure: scan/raid finds exotic; seized; fine/jail; rep loss; log.
- Neglect recovery: pet inactive until cared; buff resumes after care; log.

### Detailed Mechanics — Pets & Animal System

**Pet Roles & Categories**  
Pets are split into functional categories so they’re more than cosmetics:

- **Companion Pets:** primarily flavour and Happy buffs, minor passive bonuses (e.g. +small Happy/hour, tiny crime/working stat boosts).
- **Utility Pets:** provide focused benefits such as increased loot find, better scouting in Crimes/Travel, or improved success in specific missions.
- **Combat-Adjacent Pets:** do not replace player combat, but can provide:
  - small damage-over-time,
  - enemy debuffs (fear, bleed, distraction),
  - or extra intel (revealing enemy loadouts, hiding spots, etc.).
- **Economic/Collector Pets:** ultra-rare event pets, cosmetic prestige pets, or breeds tied to specific limited content.

Each pet instance stores: **species, rarity tier, level, experience, loyalty, temperament, current mood, and unique traits.**

**Acquisition & Growth**  

- **Shelter & Shops:** baseline common pets available for cash; good intro sink.
- **Events & Missions:** themed pets for Halloween, Christmas, story arcs, faction wars.
- **Breeding & Trading:** high-end/meta system where certain pets can breed to pass traits, with breeding cooldowns and risk of undesirable traits.
- **Black Market / Illegal Exotics:** dangerous pets with strong abilities but strict legality and risk implications.

Pets gain **Pet XP** from:

- Being equipped and active when the player runs Crimes, Missions, Fights, or Jobs.
- Direct training actions that cost Energy/Money and sometimes items (treats, toys, training tools).

Pet Level increases unlock:

- Higher loyalty caps,
- Stronger passive bonuses,
- New abilities or tricks,
- Cosmetic upgrades (collars, skins, nameplates).

**Loyalty, Mood & Care**  

Track at least three key pet states:

- **Loyalty:** how strongly the pet is bonded to the owner. Influenced by time together, successful activities, and care frequency.
- **Mood:** short-term happiness; reacts to neglect, injuries, environment, training success/failure.
- **Needs:** hunger, cleanliness, and stimulation thresholds.

Neglect leads to:

- Reduced bonuses or temporary refusal to assist.
- Visual feedback in UI (sad icons, flavour text).
- Potential run-away events or forced rehoming if abuse is extreme.

Good care yields:

- Small but steady buffs,
- Access to pet-only missions or events,
- Better odds of passing on positive traits in breeding.

**Combat Integration (Optional but Supported)**  

To avoid pets fully replacing PvP:

- Only certain pet types may be combat-adjacent.
- Limit combat impact to **supportive roles**:
  - Reveal enemy info, apply small DoTs, grant small defensive buffs, or provide one-off “escape” or “second wind” abilities.
- Tie powerful pet combat abilities to clear trade-offs:
  - expensive upkeep,
  - limited uses per day,
  - or faction-bound pets that expose the faction to risk if the pet is injured/stolen.

Pets have their own lightweight **HP / Injury** track:

- Knocked-out pets require cooldown and vet care (cash sink).
- Permanent pet death should be extremely rare, opt-in (hardcore features), or narrative-only to avoid rage quits.

**Economy & Sinks**  

The pet system should meaningfully circulate money and items via:

- Food, toys, grooming, training, vet bills, accessories, skins.
- Special pet crates or eggs with controlled drop rates and pity timers.
- Faction-level pet perks that require ongoing upkeep.

High-rarity pets and cosmetics form a **long-tail collector economy**, tradable via the market or faction channels.

**Anti-Abuse Notes**  

- Limit concurrent active pets and combat effects to avoid multi-pet exploit builds.
- Enforce global rate limits on breeding and high-tier pet acquisitions.
- Tie the strongest pet bonuses to **account age, progression milestones and missions**, not just raw cash, to reduce pay-to-win.
- Ensure pet XP and loyalty gains have diminishing returns from repetitive low-effort actions to prevent simple macro loops.

### For Architect GPT
- Pet/animal system summary; integrate with heat/police, properties, events; enforce caps and no combat impact.

### For CodeGPT
- Implement pet slots, care timers, traits, buffs, exotic risk/seizure, trade bounds, logging, and accessibility toggle. Server authority; anti-abuse checks.

### For BalanceGPT
- Tunables: buff sizes, care costs, exotic risk, slot limits, training effects, trade bounds. Keep utility minimal; risk meaningful for exotics.

### For QAGPT
- Test adoption/care/training, buffs, exotic risk/seizures, slot caps, logging, warnings, and accessibility. Validate no combat stats.  
# SECTION 150 — SKILLS SYSTEM

## 150.0 Overview
Skills provide long-term, small, deterministic perks to support builds. They must avoid power creep and stay within caps. Skills augment existing systems (combat, crimes, economy) without replacing stats/bars. No RNG perks; progression transparent.

## 150.1 Skill Trees
- Trees: Combat Support, Crime Support, Economy/Trades, Utility. Each tree has tiers with prerequisites (level, education, actions).
- Examples: Combat Support (reload handling, minor status resist, durability preservation), Crime Support (reduced tool loss chance, small success bump for specific categories), Economy (small fee reduction caps, improved repair efficiency), Utility (inventory QoL, reduced travel delay chance slightly).
- No direct damage/crit/mitigation buffs beyond small support; caps enforced; skills stack additively only where allowed.

## 150.2 Progression
- Skill points earned sparingly via milestones (levels, missions, achievements); capped per tier; respec with cost/cooldown.
- Unlock path linear within tier; choices within a branch limited to avoid stacking same effect; UI shows caps.

## 150.3 Effects & Caps
- Effects small and bounded (e.g., reload speed +3% cap, tool loss chance -5% cap, fee -2% cap). Never stack to bypass core balance; no additive to damage/crit beyond trivial support.
- Global caps to prevent abuse; diminishing returns across similar skills.

## 150.4 Anti-Abuse
- No skills that alter loot tables meaningfully; no gambling bonuses; no bypass of cooldowns/heat; no stealth advantages.
- Respec cooldown/cost to prevent swapping for situational exploits; logs.

## 150.5 UI/UX
- Skill tree UI: branches, prerequisites, effects, caps; respec button with warnings/cost; Dark Luxury styling; tooltips explain scope and caps.
- Clear separation from stats/bars; skills are support perks only.

## 150.6 Interactions
- Combat: minor QoL (reload, durability) and status resist; respects combat caps.
- Crimes: small tool preservation/success bumps for specific categories; respects minimum fail chance.
- Economy: slight fee reductions within caps; repair quality efficiency small.
- Travel/Utility: small delay reduction chance; inventory QoL.

## 150.7 Example Flows
- Player unlocks reload handling: reload slightly faster; capped; log.
- Crime support skill: reduces lockpick loss chance by small %; capped; log.
- Respec: pays cost; cooldown; skills reset; logs; cannot respec during active missions/wars.

### For Architect GPT
- Skills system of bounded, support-only perks; integrate with combat, crimes, economy, travel. Enforce caps and respec rules.

### For CodeGPT
- Implement skill trees, prerequisites, point earning, effect application with caps, respec with cost/cooldown, logging. Server authority; prevent stacking beyond limits.

### For BalanceGPT
- Tunables: point earn rate, effect magnitudes/caps, branch prerequisites, respec cost/cooldown. Keep skills meaningful yet minor; avoid meta-breaking.

### For QAGPT
- Test unlocks, effect application, caps, respec, logging, and interactions with core systems. Validate no bypass of cooldowns/heat and no combat power creep.  
# SECTION 151 — WEATHER & DYNAMIC CITY SYSTEM

## 151.0 Overview
Final weather/dynamic city spec integrating all environmental systems. Weather/time/events affect crimes, combat, travel, NPCs, economy, and UI. Server authority; transparent; anti-abuse. Dark Luxury presentation; UK realism.

## 151.1 Weather & Time
- Weather types: clear, cloudy, fog/heavy fog, light/heavy rain, storm/thunder, drizzle, overcast, snow/blizzard, heatwave, smog, night mist, event weather (Halloween fog, Xmas snow).
- Time cycles: morning/day/evening/night. Regional variation per borough; forecast window (e.g., 6h).

## 151.2 System Effects (Summary)
- Crimes: fog aids stealth; rain reduces pickpocket; storm affects electronics; snow slows outdoor crimes; heatwave shifts targets; police patrols adjust.
- Combat: rain reduces firearm accuracy; fog lowers initiative; storm boosts electric shock; heatwave small Speed penalty; night stealth boost.
- Travel: delays from rain/snow/storm; ambush odds change; scan odds adjust; comfort changes.
- NPCs: spawn density changes with weather/time; merchants close in storms; gangs active at night/fog.
- Economy: shop demand shifts (rain gear, masks, drinks); events modify stock.

## 151.3 Events & Dynamic World
- Dynamic events: protests, strikes, blackouts, festivals; time-boxed; affect systems (travel delays, CCTV down, crowd changes).
- National threat overlays; increases scans/patrols; closures; counter-ops reduce threat.
- Schedule engine prevents oppressive chaining; publishes timers; compensation for disruptions where appropriate.

## 151.4 UI/UX
- HUD chips for weather/time/events with tooltips on modifiers; map overlays; event timeline; Dark Luxury styling; reduced-motion mode.
- Notifications for impactful changes (travel delays, heat band changes); logs.

## 151.5 Anti-Abuse
- Server authoritative state; no client reroll; actions use server weather at start; forecast limited; cannot farm rerolls by reconnect.
- Event rewards capped; anti-bot on event hopping; compensation prevents exploit of cancellations.

## 151.6 Data & Logging
- Tables: weather state per region, forecast, events, modifiers, national threat; logs: transitions, effects applied, delays, compensation.
- Analytics: behaviour vs weather/events; tuning knobs for frequencies/effects.

## 151.7 Example Flows
- Fog night crime: stealth bonus; police patrol reduced; success; log shows modifiers.
- Storm travel: delay; ambush risk up; compensation; log.
- Blackout: CCTV off; stealth crimes easier; police sweeps; shops close; war fights reduced visibility; logs.

### For Architect GPT
- Central environment engine; feeds modifiers to crimes, combat, travel, NPCs, economy, and UI. Integrates with national threat and events; server authority and logging required.

### For CodeGPT
- Implement weather/time/event state machine, forecast, effect application hooks, notifications/compensation, logging, anti-reroll safeguards. Provide APIs for HUD and modules; ensure regional variation.

### For BalanceGPT
- Tunables: effect magnitudes, frequencies, durations, forecast length, compensation amounts, event reward caps. Keep impactful but not oppressive; maintain playability.

### For QAGPT
- Test weather/event transitions, effect application, forecast accuracy, delay/compensation flows, anti-reroll, logging, HUD display, and module integrations (crimes/combat/travel/NPCs/economy).  
# SECTION 152 — TORN.COM LEVEL & XP REFERENCE (READ-ONLY)

## 152.0 Purpose & Scope

This section exists as a **reference-only appendix**. It does **not** define Trench City mechanics.
Instead, it summarises what is publicly known about **Torn.com's hidden level & XP behaviour** so that:

- ArchitectGPT can understand the *feel* Torn players expect from long-term levelling.
- BalanceGPT can keep Trench City's XP pacing in the same **ballpark** without trying to reverse-engineer Torn.
- CodeGPT and QA GPT have a single, stable statement: **there is no official public XP table to copy.**

> Design rule: **Section 006 — XP, Level, Rank & Titles** remains the **source of truth** for Trench City's XP curve.
This appendix is *observational*, not prescriptive.

## 152.1 What Is Publicly Known About Torn XP

From the official Torn wiki and long-running community discussions, the following high-level facts are clear:

- **XP is hidden.** Torn does not show a numeric XP bar; players only see that they are "ready" to level or ask the fortune teller in China for their % progress for a fee.
- **Almost everything grants XP.** Attacking and *leaving* targets gives the most XP; crimes, training, and general activity also add XP, but in smaller amounts.
- **XP requirements scale non‑linearly.** Each level requires more total XP than the previous one; late levels (60+) become dramatically slower, with 99 → 100 being a multi‑year grind for most players.
- **Level is not everything.** High level with weak battle stats is punished; many top factions strongly discourage "level rushing" because it makes you easy to farm.
- **Weapon XP is separate.** Torn also has weapon‑specific XP that levels individual weapons over ~2,000 hits; this is distinct from character level XP but adds to the long‑term grind feel.
- **Progress checks are intentionally awkward.** Having to fly to China (fortune teller) to check progress acts as a soft friction and flavour element; it's meant to feel opaque and slightly mysterious.

**Key implication:** there is **no official public numeric XP table** mapping Level → Total XP. Community tools can only *estimate* based on observed behaviour and internal formulas, which Torn keeps private.

## 152.2 Relationship To Trench City's XP Curve

Trench City deliberately mirrors Torn's *emotional* progression without copying any hidden math.

- **Early levels (1–15):** should feel fast and rewarding, teaching core systems and giving frequent unlocks.
- **Mid levels (16–50):** become a measured grind; XP gains are steady, unlock cadence slows, and players invest in stats, properties, and factions.
- **Late levels (51–100+):** are long‑haul prestige territory; grinding to new levels may take months or years depending on activity.

Design anchors:

- Section 006 defines a **clear, explicit XP curve** for Trench City (XP per level, total XP, and unlocks).
- That curve is tuned so that:
  - Time‑to‑level for 1–15, 16–50, and 51–100 sits in a similar *order of magnitude* to Torn for comparable activity.
  - There is room for **XP boosters, donator bonuses, faction perks, and events** without breaking the grind.
  - Level rushing with weak stats is a **valid but risky** playstyle, as in Torn.

This appendix exists to remind workers that the Torn reference is **behavioural and pacing‑based**, not an exact numeric copy.

## 152.3 Worker Notes — Architect, Code, Balance, QA

### ArchitectGPT

- Treat Torn as a **pacing benchmark**, not a spec to clone.
- When designing new systems that grant XP (missions, events, minigames), ask:
  - "Would this trivialise long‑term levelling compared to the current Section 006 curve?"
  - "Does this preserve the feeling that Level 60+ is a serious achievement, not a weekend sprint?"
- Keep **prestige, titles, and late‑game unlocks** tied to the existing Trench City XP curve, not to any guessed Torn values.

### CodeGPT

- Never attempt to **import or replicate a "Torn XP table"**; use the helper functions and constants defined for Trench City:
  - `calculateLevel(xp)`
  - `getXPForLevel(level)`
  - Any XP source multipliers defined in config or Section 006 implementation.
- Ensure every XP‑granting action:
  - Calls the central XP award function.
  - Triggers a **level recalculation** and handles unlocks/notifications cleanly.
- If a future dev tries to bolt in an "external XP reference", explicitly defer to **Section 006 + this Section 152** and keep Trench City self‑contained.

### BalanceGPT

- Tune **XP per action** and **XP multipliers** to hit desired time‑to‑level brackets, using Torn only as a *comparative feel*:
  - Roughly similar attacks‑per‑level and crimes‑per‑level targets, not exact clones.
  - Allow whales / no‑lifers to progress faster, but keep level 80–100+ a long‑term aspiration.
- Periodically review:
  - Average Level vs account age distribution.
  - XP inflow from events and limited‑time boosts.
  - Whether any new content has accidentally become a "free XP fountain".
- If in doubt, err on the side of **slightly slower progression** rather than trivialising the grind.

### QA GPT

- Write tests to confirm:
  - All XP sources flow through the same central mechanics as documented in Section 006.
  - Level recalculation is stable and deterministic given a total XP value.
  - No action or exploit path allows players to bypass the intended levelling pace.
- Treat this appendix as a reminder that:
  - There is **no authoritative external XP table** to compare against.
  - Validation is done against **Trench City's own documented curve** and desired time‑to‑level ranges.
