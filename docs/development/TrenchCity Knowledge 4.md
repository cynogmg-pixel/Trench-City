# ADVANCED SYSTEMS

## 5. FACTIONS & TERRITORIES
- Anchor: 5-factions-territories
- Depends on: []
- Feeds into: ['9. VEHICLES & RACING SYSTEMS']
- Related: ['9. VEHICLES & RACING SYSTEMS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING', '165. THE FORGE OF ORIGINS']

## 9. VEHICLES & RACING SYSTEMS
- Anchor: 9-vehicles-racing-systems
- Depends on: ['5. FACTIONS & TERRITORIES']
- Feeds into: ['10. MARKET, TRADE & BLACK WEB SYSTEMS']
- Related: ['5. FACTIONS & TERRITORIES', '10. MARKET, TRADE & BLACK WEB SYSTEMS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10. MARKET, TRADE & BLACK WEB SYSTEMS
- Anchor: 10-market-trade-black-web-systems
- Depends on: ['9. VEHICLES & RACING SYSTEMS']
- Feeds into: ['3.4 VEHICLES & RACING STRUCTURE']
- Related: ['9. VEHICLES & RACING SYSTEMS', '3.4 VEHICLES & RACING STRUCTURE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.4 VEHICLES & RACING STRUCTURE
- Anchor: 3-4-vehicles-racing-structure
- Depends on: ['10. MARKET, TRADE & BLACK WEB SYSTEMS']
- Feeds into: ['TABLE: vehicles']
- Related: ['10. MARKET, TRADE & BLACK WEB SYSTEMS', 'TABLE: vehicles', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: vehicles
- Anchor: table-vehicles
- Depends on: ['3.4 VEHICLES & RACING STRUCTURE']
- Feeds into: ['TABLE: user_vehicles']
- Related: ['3.4 VEHICLES & RACING STRUCTURE', 'TABLE: user_vehicles', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: user_vehicles
- Anchor: table-user-vehicles
- Depends on: ['TABLE: vehicles']
- Feeds into: ['3.7 FACTIONS & TERRITORIES']
- Related: ['TABLE: vehicles', '3.7 FACTIONS & TERRITORIES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.7 FACTIONS & TERRITORIES
- Anchor: 3-7-factions-territories
- Depends on: ['TABLE: user_vehicles']
- Feeds into: ['TABLE: factions']
- Related: ['TABLE: user_vehicles', 'TABLE: factions', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: factions
- Anchor: table-factions
- Depends on: ['3.7 FACTIONS & TERRITORIES']
- Feeds into: ['TABLE: faction_members']
- Related: ['3.7 FACTIONS & TERRITORIES', 'TABLE: faction_members', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: faction_members
- Anchor: table-faction-members
- Depends on: ['TABLE: factions']
- Feeds into: ['TABLE: faction_espionage']
- Related: ['TABLE: factions', 'TABLE: faction_espionage', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: faction_espionage
- Anchor: table-faction-espionage
- Depends on: ['TABLE: faction_members']
- Feeds into: ['TABLE: marketplace_listings']
- Related: ['TABLE: faction_members', 'TABLE: marketplace_listings', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: marketplace_listings
- Anchor: table-marketplace-listings
- Depends on: ['TABLE: faction_espionage']
- Feeds into: ['CHUNK 7 — FACTIONS & TERRITORIES DEEP BOOK']
- Related: ['TABLE: faction_espionage', 'CHUNK 7 — FACTIONS & TERRITORIES DEEP BOOK', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 7 — FACTIONS & TERRITORIES DEEP BOOK
- Anchor: chunk-7-factions-territories-deep-book
- Depends on: ['TABLE: marketplace_listings']
- Feeds into: ['7.1 FACTION SYSTEM OVERVIEW']
- Related: ['TABLE: marketplace_listings', '7.1 FACTION SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.1 FACTION SYSTEM OVERVIEW
- Anchor: 7-1-faction-system-overview
- Depends on: ['CHUNK 7 — FACTIONS & TERRITORIES DEEP BOOK']
- Feeds into: ['7.2 FACTION CREATION & STRUCTURE']
- Related: ['CHUNK 7 — FACTIONS & TERRITORIES DEEP BOOK', '7.2 FACTION CREATION & STRUCTURE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.2 FACTION CREATION & STRUCTURE
- Anchor: 7-2-faction-creation-structure
- Depends on: ['7.1 FACTION SYSTEM OVERVIEW']
- Feeds into: ['7.4 FACTION MANSIONS (HEADQUARTERS)']
- Related: ['7.1 FACTION SYSTEM OVERVIEW', '7.4 FACTION MANSIONS (HEADQUARTERS)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.4 FACTION MANSIONS (HEADQUARTERS)
- Anchor: 7-4-faction-mansions-headquarters
- Depends on: ['7.2 FACTION CREATION & STRUCTURE']
- Feeds into: ['7.5 FACTION ACTIVITIES & MISSIONS']
- Related: ['7.2 FACTION CREATION & STRUCTURE', '7.5 FACTION ACTIVITIES & MISSIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.5 FACTION ACTIVITIES & MISSIONS
- Anchor: 7-5-faction-activities-missions
- Depends on: ['7.4 FACTION MANSIONS (HEADQUARTERS)']
- Feeds into: ['7.6 ESPIONAGE & SLEEPER AGENTS']
- Related: ['7.4 FACTION MANSIONS (HEADQUARTERS)', '7.6 ESPIONAGE & SLEEPER AGENTS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.6 ESPIONAGE & SLEEPER AGENTS
- Anchor: 7-6-espionage-sleeper-agents
- Depends on: ['7.5 FACTION ACTIVITIES & MISSIONS']
- Feeds into: ['7.7 FACTION DIPLOMACY SYSTEM']
- Related: ['7.5 FACTION ACTIVITIES & MISSIONS', '7.7 FACTION DIPLOMACY SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.7 FACTION DIPLOMACY SYSTEM
- Anchor: 7-7-faction-diplomacy-system
- Depends on: ['7.6 ESPIONAGE & SLEEPER AGENTS']
- Feeds into: ['7.10 FACTION MORALE SYSTEM']
- Related: ['7.6 ESPIONAGE & SLEEPER AGENTS', '7.10 FACTION MORALE SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.10 FACTION MORALE SYSTEM
- Anchor: 7-10-faction-morale-system
- Depends on: ['7.7 FACTION DIPLOMACY SYSTEM']
- Feeds into: ['7.11 FACTION SEASONS']
- Related: ['7.7 FACTION DIPLOMACY SYSTEM', '7.11 FACTION SEASONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.11 FACTION SEASONS
- Anchor: 7-11-faction-seasons
- Depends on: ['7.10 FACTION MORALE SYSTEM']
- Feeds into: ['7.12 AI DIRECTOR → FACTION INTEGRATION']
- Related: ['7.10 FACTION MORALE SYSTEM', '7.12 AI DIRECTOR → FACTION INTEGRATION', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.12 AI DIRECTOR → FACTION INTEGRATION
- Anchor: 7-12-ai-director-faction-integration
- Depends on: ['7.11 FACTION SEASONS']
- Feeds into: ['8.5 FACTION MISSIONS']
- Related: ['7.11 FACTION SEASONS', '8.5 FACTION MISSIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.5 FACTION MISSIONS
- Anchor: 8-5-faction-missions
- Depends on: ['7.12 AI DIRECTOR → FACTION INTEGRATION']
- Feeds into: ['9.5 PLAYER-TO-PLAYER MARKETPLACE']
- Related: ['7.12 AI DIRECTOR → FACTION INTEGRATION', '9.5 PLAYER-TO-PLAYER MARKETPLACE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.5 PLAYER-TO-PLAYER MARKETPLACE
- Anchor: 9-5-player-to-player-marketplace
- Depends on: ['8.5 FACTION MISSIONS']
- Feeds into: ['9.7 STOCK MARKET SYSTEM']
- Related: ['8.5 FACTION MISSIONS', '9.7 STOCK MARKET SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.7 STOCK MARKET SYSTEM
- Anchor: 9-7-stock-market-system
- Depends on: ['9.5 PLAYER-TO-PLAYER MARKETPLACE']
- Feeds into: ['10.1 PROPERTY SYSTEM OVERVIEW']
- Related: ['9.5 PLAYER-TO-PLAYER MARKETPLACE', '10.1 PROPERTY SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.1 PROPERTY SYSTEM OVERVIEW
- Anchor: 10-1-property-system-overview
- Depends on: ['9.7 STOCK MARKET SYSTEM']
- Feeds into: ['10.2 PROPERTY TIERS (FULL PROGRESSION)']
- Related: ['9.7 STOCK MARKET SYSTEM', '10.2 PROPERTY TIERS (FULL PROGRESSION)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.2 PROPERTY TIERS (FULL PROGRESSION)
- Anchor: 10-2-property-tiers-full-progression
- Depends on: ['10.1 PROPERTY SYSTEM OVERVIEW']
- Feeds into: ['10.4 PROPERTY UPGRADES & ROOMS']
- Related: ['10.1 PROPERTY SYSTEM OVERVIEW', '10.4 PROPERTY UPGRADES & ROOMS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.4 PROPERTY UPGRADES & ROOMS
- Anchor: 10-4-property-upgrades-rooms
- Depends on: ['10.2 PROPERTY TIERS (FULL PROGRESSION)']
- Feeds into: ['10.5 PROPERTY REGENERATION SYSTEM']
- Related: ['10.2 PROPERTY TIERS (FULL PROGRESSION)', '10.5 PROPERTY REGENERATION SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.5 PROPERTY REGENERATION SYSTEM
- Anchor: 10-5-property-regeneration-system
- Depends on: ['10.4 PROPERTY UPGRADES & ROOMS']
- Feeds into: ['10.7 PROPERTY RAID & BURGLARY SYSTEM']
- Related: ['10.4 PROPERTY UPGRADES & ROOMS', '10.7 PROPERTY RAID & BURGLARY SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.7 PROPERTY RAID & BURGLARY SYSTEM
- Anchor: 10-7-property-raid-burglary-system
- Depends on: ['10.5 PROPERTY REGENERATION SYSTEM']
- Feeds into: ['Player vs Player Property Raids (future expansion)']
- Related: ['10.5 PROPERTY REGENERATION SYSTEM', 'Player vs Player Property Raids (future expansion)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Player vs Player Property Raids (future expansion)
- Anchor: player-vs-player-property-raids-future-expansion
- Depends on: ['10.7 PROPERTY RAID & BURGLARY SYSTEM']
- Feeds into: ['10.10 PROPERTY SELLING & MORTGAGES']
- Related: ['10.7 PROPERTY RAID & BURGLARY SYSTEM', '10.10 PROPERTY SELLING & MORTGAGES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.10 PROPERTY SELLING & MORTGAGES
- Anchor: 10-10-property-selling-mortgages
- Depends on: ['Player vs Player Property Raids (future expansion)']
- Feeds into: ['10.11 PROPERTY PRESTIGE SYSTEM']
- Related: ['Player vs Player Property Raids (future expansion)', '10.11 PROPERTY PRESTIGE SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.11 PROPERTY PRESTIGE SYSTEM
- Anchor: 10-11-property-prestige-system
- Depends on: ['10.10 PROPERTY SELLING & MORTGAGES']
- Feeds into: ['10.13 PROPERTY PORTFOLIO SYSTEM']
- Related: ['10.10 PROPERTY SELLING & MORTGAGES', '10.13 PROPERTY PORTFOLIO SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.13 PROPERTY PORTFOLIO SYSTEM
- Anchor: 10-13-property-portfolio-system
- Depends on: ['10.11 PROPERTY PRESTIGE SYSTEM']
- Feeds into: ['CHUNK 11 — VEHICLES, RACING & SMUGGLING SYSTEMS']
- Related: ['10.11 PROPERTY PRESTIGE SYSTEM', 'CHUNK 11 — VEHICLES, RACING & SMUGGLING SYSTEMS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 11 — VEHICLES, RACING & SMUGGLING SYSTEMS
- Anchor: chunk-11-vehicles-racing-smuggling-systems
- Depends on: ['10.13 PROPERTY PORTFOLIO SYSTEM']
- Feeds into: ['11.1 VEHICLE SYSTEM OVERVIEW']
- Related: ['10.13 PROPERTY PORTFOLIO SYSTEM', '11.1 VEHICLE SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 11.1 VEHICLE SYSTEM OVERVIEW
- Anchor: 11-1-vehicle-system-overview
- Depends on: ['CHUNK 11 — VEHICLES, RACING & SMUGGLING SYSTEMS']
- Feeds into: ['11.2 VEHICLE CLASSES']
- Related: ['CHUNK 11 — VEHICLES, RACING & SMUGGLING SYSTEMS', '11.2 VEHICLE CLASSES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 11.2 VEHICLE CLASSES
- Anchor: 11-2-vehicle-classes
- Depends on: ['11.1 VEHICLE SYSTEM OVERVIEW']
- Feeds into: ['11.3 VEHICLE STATS']
- Related: ['11.1 VEHICLE SYSTEM OVERVIEW', '11.3 VEHICLE STATS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 11.3 VEHICLE STATS
- Anchor: 11-3-vehicle-stats
- Depends on: ['11.2 VEHICLE CLASSES']
- Feeds into: ['11.4 VEHICLE UPGRADES & TUNING']
- Related: ['11.2 VEHICLE CLASSES', '11.4 VEHICLE UPGRADES & TUNING', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 11.4 VEHICLE UPGRADES & TUNING
- Anchor: 11-4-vehicle-upgrades-tuning
- Depends on: ['11.3 VEHICLE STATS']
- Feeds into: ['11.13 FACTION SMUGGLING OPERATIONS']
- Related: ['11.3 VEHICLE STATS', '11.13 FACTION SMUGGLING OPERATIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 11.13 FACTION SMUGGLING OPERATIONS
- Anchor: 11-13-faction-smuggling-operations
- Depends on: ['11.4 VEHICLE UPGRADES & TUNING']
- Feeds into: ['14.4 VEHICLE COSMETICS']
- Related: ['11.4 VEHICLE UPGRADES & TUNING', '14.4 VEHICLE COSMETICS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 14.4 VEHICLE COSMETICS
- Anchor: 14-4-vehicle-cosmetics
- Depends on: ['11.13 FACTION SMUGGLING OPERATIONS']
- Feeds into: ['15.14 AI HOOKS INTO FACTIONS']
- Related: ['11.13 FACTION SMUGGLING OPERATIONS', '15.14 AI HOOKS INTO FACTIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.14 AI HOOKS INTO FACTIONS
- Anchor: 15-14-ai-hooks-into-factions
- Depends on: ['14.4 VEHICLE COSMETICS']
- Feeds into: ['**Tier 6: Ultra-Black-Market**']
- Related: ['14.4 VEHICLE COSMETICS', '**Tier 6: Ultra-Black-Market**', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Tier 6: Ultra-Black-Market**
- Anchor: tier-6-ultra-black-market
- Depends on: ['15.14 AI HOOKS INTO FACTIONS']
- Feeds into: ['17.9 VEHICLE MOD CRAFTING']
- Related: ['15.14 AI HOOKS INTO FACTIONS', '17.9 VEHICLE MOD CRAFTING', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 17.9 VEHICLE MOD CRAFTING
- Anchor: 17-9-vehicle-mod-crafting
- Depends on: ['**Tier 6: Ultra-Black-Market**']
- Feeds into: ['17.11 PROPERTY UPGRADE CRAFTING']
- Related: ['**Tier 6: Ultra-Black-Market**', '17.11 PROPERTY UPGRADE CRAFTING', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 17.11 PROPERTY UPGRADE CRAFTING
- Anchor: 17-11-property-upgrade-crafting
- Depends on: ['17.9 VEHICLE MOD CRAFTING']
- Feeds into: ['PATH 5 — VEHICLE THEFT & CHOP SHOPS']
- Related: ['17.9 VEHICLE MOD CRAFTING', 'PATH 5 — VEHICLE THEFT & CHOP SHOPS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 5 — VEHICLE THEFT & CHOP SHOPS
- Anchor: path-5-vehicle-theft-chop-shops
- Depends on: ['17.11 PROPERTY UPGRADE CRAFTING']
- Feeds into: ['PATH 16 — CORPORATE ESPIONAGE']
- Related: ['17.11 PROPERTY UPGRADE CRAFTING', 'PATH 16 — CORPORATE ESPIONAGE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 16 — CORPORATE ESPIONAGE
- Anchor: path-16-corporate-espionage
- Depends on: ['PATH 5 — VEHICLE THEFT & CHOP SHOPS']
- Feeds into: ['CHUNK 19 — FACTION WARFARE EXPANSION (RANKED WARS, TERRITORY, RAIDS, BLACK OPS)']
- Related: ['PATH 5 — VEHICLE THEFT & CHOP SHOPS', 'CHUNK 19 — FACTION WARFARE EXPANSION (RANKED WARS, TERRITORY, RAIDS, BLACK OPS)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 19 — FACTION WARFARE EXPANSION (RANKED WARS, TERRITORY, RAIDS, BLACK OPS)
- Anchor: chunk-19-faction-warfare-expansion-ranked-wars-territory-raids-black-ops
- Depends on: ['PATH 16 — CORPORATE ESPIONAGE']
- Feeds into: ['19.1 ADVANCED WARFARE OVERVIEW']
- Related: ['PATH 16 — CORPORATE ESPIONAGE', '19.1 ADVANCED WARFARE OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19.1 ADVANCED WARFARE OVERVIEW
- Anchor: 19-1-advanced-warfare-overview
- Depends on: ['CHUNK 19 — FACTION WARFARE EXPANSION (RANKED WARS, TERRITORY, RAIDS, BLACK OPS)']
- Feeds into: ['19.10 FACTION TECH TREE']
- Related: ['CHUNK 19 — FACTION WARFARE EXPANSION (RANKED WARS, TERRITORY, RAIDS, BLACK OPS)', '19.10 FACTION TECH TREE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19.10 FACTION TECH TREE
- Anchor: 19-10-faction-tech-tree
- Depends on: ['19.1 ADVANCED WARFARE OVERVIEW']
- Feeds into: ['19.11 FACTION CHAIN SYSTEM']
- Related: ['19.1 ADVANCED WARFARE OVERVIEW', '19.11 FACTION CHAIN SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19.11 FACTION CHAIN SYSTEM
- Anchor: 19-11-faction-chain-system
- Depends on: ['19.10 FACTION TECH TREE']
- Feeds into: ['**Faction Operation Chains**']
- Related: ['19.10 FACTION TECH TREE', '**Faction Operation Chains**', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Faction Operation Chains**
- Anchor: faction-operation-chains
- Depends on: ['19.11 FACTION CHAIN SYSTEM']
- Feeds into: ['19.12 FACTION DIPLOMACY (ADVANCED)']
- Related: ['19.11 FACTION CHAIN SYSTEM', '19.12 FACTION DIPLOMACY (ADVANCED)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19.12 FACTION DIPLOMACY (ADVANCED)
- Anchor: 19-12-faction-diplomacy-advanced
- Depends on: ['**Faction Operation Chains**']
- Feeds into: ['4. Faction Missions']
- Related: ['**Faction Operation Chains**', '4. Faction Missions', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 4. Faction Missions
- Anchor: 4-faction-missions
- Depends on: ['19.12 FACTION DIPLOMACY (ADVANCED)']
- Feeds into: ['20.10 FACTION MISSION EXPANSION']
- Related: ['19.12 FACTION DIPLOMACY (ADVANCED)', '20.10 FACTION MISSION EXPANSION', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 20.10 FACTION MISSION EXPANSION
- Anchor: 20-10-faction-mission-expansion
- Depends on: ['4. Faction Missions']
- Feeds into: ['3. Faction Control']
- Related: ['4. Faction Missions', '3. Faction Control', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3. Faction Control
- Anchor: 3-faction-control
- Depends on: ['20.10 FACTION MISSION EXPANSION']
- Feeds into: ['CHUNK 22 — VEHICLES & RACING SYSTEM (TUNING, PURSUITS, SMUGGLING)']
- Related: ['20.10 FACTION MISSION EXPANSION', 'CHUNK 22 — VEHICLES & RACING SYSTEM (TUNING, PURSUITS, SMUGGLING)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 22 — VEHICLES & RACING SYSTEM (TUNING, PURSUITS, SMUGGLING)
- Anchor: chunk-22-vehicles-racing-system-tuning-pursuits-smuggling
- Depends on: ['3. Faction Control']
- Feeds into: ['22.1 VEHICLE SYSTEM OVERVIEW']
- Related: ['3. Faction Control', '22.1 VEHICLE SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.1 VEHICLE SYSTEM OVERVIEW
- Anchor: 22-1-vehicle-system-overview
- Depends on: ['CHUNK 22 — VEHICLES & RACING SYSTEM (TUNING, PURSUITS, SMUGGLING)']
- Feeds into: ['22.2 VEHICLE CLASSES']
- Related: ['CHUNK 22 — VEHICLES & RACING SYSTEM (TUNING, PURSUITS, SMUGGLING)', '22.2 VEHICLE CLASSES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.2 VEHICLE CLASSES
- Anchor: 22-2-vehicle-classes
- Depends on: ['22.1 VEHICLE SYSTEM OVERVIEW']
- Feeds into: ['Syndicate Prototype Vehicles']
- Related: ['22.1 VEHICLE SYSTEM OVERVIEW', 'Syndicate Prototype Vehicles', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Syndicate Prototype Vehicles
- Anchor: syndicate-prototype-vehicles
- Depends on: ['22.2 VEHICLE CLASSES']
- Feeds into: ['22.3 VEHICLE STATS']
- Related: ['22.2 VEHICLE CLASSES', '22.3 VEHICLE STATS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.3 VEHICLE STATS
- Anchor: 22-3-vehicle-stats
- Depends on: ['Syndicate Prototype Vehicles']
- Feeds into: ['22.4 VEHICLE MODDING & TUNING']
- Related: ['Syndicate Prototype Vehicles', '22.4 VEHICLE MODDING & TUNING', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.4 VEHICLE MODDING & TUNING
- Anchor: 22-4-vehicle-modding-tuning
- Depends on: ['22.3 VEHICLE STATS']
- Feeds into: ['22.6 VEHICLE DAMAGE & REPAIR SYSTEM']
- Related: ['22.3 VEHICLE STATS', '22.6 VEHICLE DAMAGE & REPAIR SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.6 VEHICLE DAMAGE & REPAIR SYSTEM
- Anchor: 22-6-vehicle-damage-repair-system
- Depends on: ['22.4 VEHICLE MODDING & TUNING']
- Feeds into: ['5. Faction Racing League']
- Related: ['22.4 VEHICLE MODDING & TUNING', '5. Faction Racing League', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5. Faction Racing League
- Anchor: 5-faction-racing-league
- Depends on: ['22.6 VEHICLE DAMAGE & REPAIR SYSTEM']
- Feeds into: ['22.9 SMUGGLING VEHICLE INTEGRATION']
- Related: ['22.6 VEHICLE DAMAGE & REPAIR SYSTEM', '22.9 SMUGGLING VEHICLE INTEGRATION', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.9 SMUGGLING VEHICLE INTEGRATION
- Anchor: 22-9-smuggling-vehicle-integration
- Depends on: ['5. Faction Racing League']
- Feeds into: ['22.10 VEHICLE LOOT TABLES']
- Related: ['5. Faction Racing League', '22.10 VEHICLE LOOT TABLES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.10 VEHICLE LOOT TABLES
- Anchor: 22-10-vehicle-loot-tables
- Depends on: ['22.9 SMUGGLING VEHICLE INTEGRATION']
- Feeds into: ['22.11 ANTI-EXPLOIT VEHICLE & RACING SYSTEM']
- Related: ['22.9 SMUGGLING VEHICLE INTEGRATION', '22.11 ANTI-EXPLOIT VEHICLE & RACING SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22.11 ANTI-EXPLOIT VEHICLE & RACING SYSTEM
- Anchor: 22-11-anti-exploit-vehicle-racing-system
- Depends on: ['22.10 VEHICLE LOOT TABLES']
- Feeds into: ['23.1 PROPERTY SYSTEM OVERVIEW']
- Related: ['22.10 VEHICLE LOOT TABLES', '23.1 PROPERTY SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.1 PROPERTY SYSTEM OVERVIEW
- Anchor: 23-1-property-system-overview
- Depends on: ['22.11 ANTI-EXPLOIT VEHICLE & RACING SYSTEM']
- Feeds into: ['23.2 PROPERTY TIERS']
- Related: ['22.11 ANTI-EXPLOIT VEHICLE & RACING SYSTEM', '23.2 PROPERTY TIERS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.2 PROPERTY TIERS
- Anchor: 23-2-property-tiers
- Depends on: ['23.1 PROPERTY SYSTEM OVERVIEW']
- Feeds into: ['23.4 PROPERTY UPGRADES']
- Related: ['23.1 PROPERTY SYSTEM OVERVIEW', '23.4 PROPERTY UPGRADES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.4 PROPERTY UPGRADES
- Anchor: 23-4-property-upgrades
- Depends on: ['23.2 PROPERTY TIERS']
- Feeds into: ['23.5 PROPERTY SECURITY SYSTEM']
- Related: ['23.2 PROPERTY TIERS', '23.5 PROPERTY SECURITY SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.5 PROPERTY SECURITY SYSTEM
- Anchor: 23-5-property-security-system
- Depends on: ['23.4 PROPERTY UPGRADES']
- Feeds into: ['23.9 FACTION PROPERTIES']
- Related: ['23.4 PROPERTY UPGRADES', '23.9 FACTION PROPERTIES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.9 FACTION PROPERTIES
- Anchor: 23-9-faction-properties
- Depends on: ['23.5 PROPERTY SECURITY SYSTEM']
- Feeds into: ['23.10 PROPERTY EVENTS']
- Related: ['23.5 PROPERTY SECURITY SYSTEM', '23.10 PROPERTY EVENTS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.10 PROPERTY EVENTS
- Anchor: 23-10-property-events
- Depends on: ['23.9 FACTION PROPERTIES']
- Feeds into: ['23.11 PROPERTY RAID SYSTEM']
- Related: ['23.9 FACTION PROPERTIES', '23.11 PROPERTY RAID SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.11 PROPERTY RAID SYSTEM
- Anchor: 23-11-property-raid-system
- Depends on: ['23.10 PROPERTY EVENTS']
- Feeds into: ['23.12 ANTI-EXPLOIT PROPERTY LOGIC']
- Related: ['23.10 PROPERTY EVENTS', '23.12 ANTI-EXPLOIT PROPERTY LOGIC', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.12 ANTI-EXPLOIT PROPERTY LOGIC
- Anchor: 23-12-anti-exploit-property-logic
- Depends on: ['23.11 PROPERTY RAID SYSTEM']
- Feeds into: ['24.8 COMPANY MARKETPLACE']
- Related: ['23.11 PROPERTY RAID SYSTEM', '24.8 COMPANY MARKETPLACE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 24.8 COMPANY MARKETPLACE
- Anchor: 24-8-company-marketplace
- Depends on: ['23.12 ANTI-EXPLOIT PROPERTY LOGIC']
- Feeds into: ['24.9 CORPORATE ESPIONAGE (PVP & PVE)']
- Related: ['23.12 ANTI-EXPLOIT PROPERTY LOGIC', '24.9 CORPORATE ESPIONAGE (PVP & PVE)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 24.9 CORPORATE ESPIONAGE (PVP & PVE)
- Anchor: 24-9-corporate-espionage-pvp-pve
- Depends on: ['24.8 COMPANY MARKETPLACE']
- Feeds into: ['CHUNK 25 — BLACK MARKET, CONTRABAND & SMUGGLING SYSTEM']
- Related: ['24.8 COMPANY MARKETPLACE', 'CHUNK 25 — BLACK MARKET, CONTRABAND & SMUGGLING SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 25 — BLACK MARKET, CONTRABAND & SMUGGLING SYSTEM
- Anchor: chunk-25-black-market-contraband-smuggling-system
- Depends on: ['24.9 CORPORATE ESPIONAGE (PVP & PVE)']
- Feeds into: ['25.1 BLACK MARKET OVERVIEW']
- Related: ['24.9 CORPORATE ESPIONAGE (PVP & PVE)', '25.1 BLACK MARKET OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.1 BLACK MARKET OVERVIEW
- Anchor: 25-1-black-market-overview
- Depends on: ['CHUNK 25 — BLACK MARKET, CONTRABAND & SMUGGLING SYSTEM']
- Feeds into: ['25.2 BLACK MARKET TIERS (3–6 TIERS)']
- Related: ['CHUNK 25 — BLACK MARKET, CONTRABAND & SMUGGLING SYSTEM', '25.2 BLACK MARKET TIERS (3–6 TIERS)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.2 BLACK MARKET TIERS (3–6 TIERS)
- Anchor: 25-2-black-market-tiers-3-6-tiers
- Depends on: ['25.1 BLACK MARKET OVERVIEW']
- Feeds into: ['TIER 1 — Street Black Market']
- Related: ['25.1 BLACK MARKET OVERVIEW', 'TIER 1 — Street Black Market', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TIER 1 — Street Black Market
- Anchor: tier-1-street-black-market
- Depends on: ['25.2 BLACK MARKET TIERS (3–6 TIERS)']
- Feeds into: ['TIER 2 — Local Criminal Market']
- Related: ['25.2 BLACK MARKET TIERS (3–6 TIERS)', 'TIER 2 — Local Criminal Market', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TIER 2 — Local Criminal Market
- Anchor: tier-2-local-criminal-market
- Depends on: ['TIER 1 — Street Black Market']
- Feeds into: ['TIER 3 — Established Black Market']
- Related: ['TIER 1 — Street Black Market', 'TIER 3 — Established Black Market', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TIER 3 — Established Black Market
- Anchor: tier-3-established-black-market
- Depends on: ['TIER 2 — Local Criminal Market']
- Feeds into: ['25.11 BLACK MARKET EVENTS']
- Related: ['TIER 2 — Local Criminal Market', '25.11 BLACK MARKET EVENTS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.11 BLACK MARKET EVENTS
- Anchor: 25-11-black-market-events
- Depends on: ['TIER 3 — Established Black Market']
- Feeds into: ['25.12 ANTI-EXPLOIT BLACK MARKET LOGIC']
- Related: ['TIER 3 — Established Black Market', '25.12 ANTI-EXPLOIT BLACK MARKET LOGIC', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.12 ANTI-EXPLOIT BLACK MARKET LOGIC
- Anchor: 25-12-anti-exploit-black-market-logic
- Depends on: ['25.11 BLACK MARKET EVENTS']
- Feeds into: ['Vehicle Race Betting']
- Related: ['25.11 BLACK MARKET EVENTS', 'Vehicle Race Betting', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Vehicle Race Betting
- Anchor: vehicle-race-betting
- Depends on: ['25.12 ANTI-EXPLOIT BLACK MARKET LOGIC']
- Feeds into: ['Faction War Betting']
- Related: ['25.12 ANTI-EXPLOIT BLACK MARKET LOGIC', 'Faction War Betting', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Faction War Betting
- Anchor: faction-war-betting
- Depends on: ['Vehicle Race Betting']
- Feeds into: ['27.2 PLAYER STOCK MARKET']
- Related: ['Vehicle Race Betting', '27.2 PLAYER STOCK MARKET', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.2 PLAYER STOCK MARKET
- Anchor: 27-2-player-stock-market
- Depends on: ['Faction War Betting']
- Feeds into: ['27.6 COMMODITY MARKET (LIVE, SHIFTING PRICES)']
- Related: ['Faction War Betting', '27.6 COMMODITY MARKET (LIVE, SHIFTING PRICES)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.6 COMMODITY MARKET (LIVE, SHIFTING PRICES)
- Anchor: 27-6-commodity-market-live-shifting-prices
- Depends on: ['27.2 PLAYER STOCK MARKET']
- Feeds into: ['27.8 POINTS MARKET (PLAYER PREMIUM CURRENCY EXCHANGE)']
- Related: ['27.2 PLAYER STOCK MARKET', '27.8 POINTS MARKET (PLAYER PREMIUM CURRENCY EXCHANGE)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.8 POINTS MARKET (PLAYER PREMIUM CURRENCY EXCHANGE)
- Anchor: 27-8-points-market-player-premium-currency-exchange
- Depends on: ['27.6 COMMODITY MARKET (LIVE, SHIFTING PRICES)']
- Feeds into: ['**Faction Feed**']
- Related: ['27.6 COMMODITY MARKET (LIVE, SHIFTING PRICES)', '**Faction Feed**', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Faction Feed**
- Anchor: faction-feed
- Depends on: ['27.8 POINTS MARKET (PLAYER PREMIUM CURRENCY EXCHANGE)']
- Feeds into: ['CHUNK 31 — TRAVEL, TRANSPORT, VEHICLES & PUBLIC TRANSIT']
- Related: ['27.8 POINTS MARKET (PLAYER PREMIUM CURRENCY EXCHANGE)', 'CHUNK 31 — TRAVEL, TRANSPORT, VEHICLES & PUBLIC TRANSIT', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 31 — TRAVEL, TRANSPORT, VEHICLES & PUBLIC TRANSIT
- Anchor: chunk-31-travel-transport-vehicles-public-transit
- Depends on: ['**Faction Feed**']
- Feeds into: ['31.2 VEHICLE SYSTEM (FULL FRAMEWORK)']
- Related: ['**Faction Feed**', '31.2 VEHICLE SYSTEM (FULL FRAMEWORK)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31.2 VEHICLE SYSTEM (FULL FRAMEWORK)
- Anchor: 31-2-vehicle-system-full-framework
- Depends on: ['CHUNK 31 — TRAVEL, TRANSPORT, VEHICLES & PUBLIC TRANSIT']
- Feeds into: ['31.3 VEHICLE UPGRADES & MODIFICATIONS']
- Related: ['CHUNK 31 — TRAVEL, TRANSPORT, VEHICLES & PUBLIC TRANSIT', '31.3 VEHICLE UPGRADES & MODIFICATIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31.3 VEHICLE UPGRADES & MODIFICATIONS
- Anchor: 31-3-vehicle-upgrades-modifications
- Depends on: ['31.2 VEHICLE SYSTEM (FULL FRAMEWORK)']
- Feeds into: ['31.4 VEHICLE USES & GAMEPLAY LOOPS']
- Related: ['31.2 VEHICLE SYSTEM (FULL FRAMEWORK)', '31.4 VEHICLE USES & GAMEPLAY LOOPS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31.4 VEHICLE USES & GAMEPLAY LOOPS
- Anchor: 31-4-vehicle-uses-gameplay-loops
- Depends on: ['31.3 VEHICLE UPGRADES & MODIFICATIONS']
- Feeds into: ['31.7 RACING SYSTEM (VEHICLE PvE + PvP)']
- Related: ['31.3 VEHICLE UPGRADES & MODIFICATIONS', '31.7 RACING SYSTEM (VEHICLE PvE + PvP)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31.7 RACING SYSTEM (VEHICLE PvE + PvP)
- Anchor: 31-7-racing-system-vehicle-pve-pvp
- Depends on: ['31.4 VEHICLE USES & GAMEPLAY LOOPS']
- Feeds into: ['**Faction Missions**']
- Related: ['31.4 VEHICLE USES & GAMEPLAY LOOPS', '**Faction Missions**', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Faction Missions**
- Anchor: faction-missions
- Depends on: ['31.7 RACING SYSTEM (VEHICLE PvE + PvP)']
- Feeds into: ['Vehicle Parts']
- Related: ['31.7 RACING SYSTEM (VEHICLE PvE + PvP)', 'Vehicle Parts', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Vehicle Parts
- Anchor: vehicle-parts
- Depends on: ['**Faction Missions**']
- Feeds into: ['Property Items']
- Related: ['**Faction Missions**', 'Property Items', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Property Items
- Anchor: property-items
- Depends on: ['Vehicle Parts']
- Feeds into: ['Property Rooms']
- Related: ['Vehicle Parts', 'Property Rooms', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Property Rooms
- Anchor: property-rooms
- Depends on: ['Property Items']
- Feeds into: ['CHUNK 36 — ADVANCED WEAPONS, ARMOUR, DAMAGE TYPES & MOD SYSTEM']
- Related: ['Property Items', 'CHUNK 36 — ADVANCED WEAPONS, ARMOUR, DAMAGE TYPES & MOD SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 36 — ADVANCED WEAPONS, ARMOUR, DAMAGE TYPES & MOD SYSTEM
- Anchor: chunk-36-advanced-weapons-armour-damage-types-mod-system
- Depends on: ['Property Rooms']
- Feeds into: ['36.1 ADVANCED WEAPON SYSTEM OVERVIEW']
- Related: ['Property Rooms', '36.1 ADVANCED WEAPON SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 36.1 ADVANCED WEAPON SYSTEM OVERVIEW
- Anchor: 36-1-advanced-weapon-system-overview
- Depends on: ['CHUNK 36 — ADVANCED WEAPONS, ARMOUR, DAMAGE TYPES & MOD SYSTEM']
- Feeds into: ['36.6 ARMOUR SYSTEM (ADVANCED)']
- Related: ['CHUNK 36 — ADVANCED WEAPONS, ARMOUR, DAMAGE TYPES & MOD SYSTEM', '36.6 ARMOUR SYSTEM (ADVANCED)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 36.6 ARMOUR SYSTEM (ADVANCED)
- Anchor: 36-6-armour-system-advanced
- Depends on: ['36.1 ADVANCED WEAPON SYSTEM OVERVIEW']
- Feeds into: ['36.8 WEAPON MOD SYSTEM (ADVANCED)']
- Related: ['36.1 ADVANCED WEAPON SYSTEM OVERVIEW', '36.8 WEAPON MOD SYSTEM (ADVANCED)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 36.8 WEAPON MOD SYSTEM (ADVANCED)
- Anchor: 36-8-weapon-mod-system-advanced
- Depends on: ['36.6 ARMOUR SYSTEM (ADVANCED)']
- Feeds into: ['CHUNK 37 — FACTIONS, WARS, TERRITORIES, RAIDS & DIPLOMACY']
- Related: ['36.6 ARMOUR SYSTEM (ADVANCED)', 'CHUNK 37 — FACTIONS, WARS, TERRITORIES, RAIDS & DIPLOMACY', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 37 — FACTIONS, WARS, TERRITORIES, RAIDS & DIPLOMACY
- Anchor: chunk-37-factions-wars-territories-raids-diplomacy
- Depends on: ['36.8 WEAPON MOD SYSTEM (ADVANCED)']
- Feeds into: ['37.1 FACTION SYSTEM OVERVIEW']
- Related: ['36.8 WEAPON MOD SYSTEM (ADVANCED)', '37.1 FACTION SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.1 FACTION SYSTEM OVERVIEW
- Anchor: 37-1-faction-system-overview
- Depends on: ['CHUNK 37 — FACTIONS, WARS, TERRITORIES, RAIDS & DIPLOMACY']
- Feeds into: ['37.2 FACTION CREATION & STRUCTURE']
- Related: ['CHUNK 37 — FACTIONS, WARS, TERRITORIES, RAIDS & DIPLOMACY', '37.2 FACTION CREATION & STRUCTURE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.2 FACTION CREATION & STRUCTURE
- Anchor: 37-2-faction-creation-structure
- Depends on: ['37.1 FACTION SYSTEM OVERVIEW']
- Feeds into: ['Faction Structure:']
- Related: ['37.1 FACTION SYSTEM OVERVIEW', 'Faction Structure:', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Faction Structure:
- Anchor: faction-structure
- Depends on: ['37.2 FACTION CREATION & STRUCTURE']
- Feeds into: ['Faction Management Tools:']
- Related: ['37.2 FACTION CREATION & STRUCTURE', 'Faction Management Tools:', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Faction Management Tools:
- Anchor: faction-management-tools
- Depends on: ['Faction Structure:']
- Feeds into: ['37.3 FACTION UPGRADES & TECH TREE']
- Related: ['Faction Structure:', '37.3 FACTION UPGRADES & TECH TREE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.3 FACTION UPGRADES & TECH TREE
- Anchor: 37-3-faction-upgrades-tech-tree
- Depends on: ['Faction Management Tools:']
- Feeds into: ['37.7 FACTION RAIDS']
- Related: ['Faction Management Tools:', '37.7 FACTION RAIDS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.7 FACTION RAIDS
- Anchor: 37-7-faction-raids
- Depends on: ['37.3 FACTION UPGRADES & TECH TREE']
- Feeds into: ['37.8 FACTION BUILDINGS & UPGRADES']
- Related: ['37.3 FACTION UPGRADES & TECH TREE', '37.8 FACTION BUILDINGS & UPGRADES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.8 FACTION BUILDINGS & UPGRADES
- Anchor: 37-8-faction-buildings-upgrades
- Depends on: ['37.7 FACTION RAIDS']
- Feeds into: ['37.11 FACTION MISSIONS & OPERATIONS']
- Related: ['37.7 FACTION RAIDS', '37.11 FACTION MISSIONS & OPERATIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.11 FACTION MISSIONS & OPERATIONS
- Anchor: 37-11-faction-missions-operations
- Depends on: ['37.8 FACTION BUILDINGS & UPGRADES']
- Feeds into: ['37.13 FACTION AI ELEMENTS']
- Related: ['37.8 FACTION BUILDINGS & UPGRADES', '37.13 FACTION AI ELEMENTS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.13 FACTION AI ELEMENTS
- Anchor: 37-13-faction-ai-elements
- Depends on: ['37.11 FACTION MISSIONS & OPERATIONS']
- Feeds into: ['37.14 FACTION ANTI-EXPLOIT MEASURES']
- Related: ['37.11 FACTION MISSIONS & OPERATIONS', '37.14 FACTION ANTI-EXPLOIT MEASURES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.14 FACTION ANTI-EXPLOIT MEASURES
- Anchor: 37-14-faction-anti-exploit-measures
- Depends on: ['37.13 FACTION AI ELEMENTS']
- Feeds into: ['38.1 PROPERTY SYSTEM OVERVIEW']
- Related: ['37.13 FACTION AI ELEMENTS', '38.1 PROPERTY SYSTEM OVERVIEW', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.1 PROPERTY SYSTEM OVERVIEW
- Anchor: 38-1-property-system-overview
- Depends on: ['37.14 FACTION ANTI-EXPLOIT MEASURES']
- Feeds into: ['38.2 PROPERTY TIERS (FULL LIST)']
- Related: ['37.14 FACTION ANTI-EXPLOIT MEASURES', '38.2 PROPERTY TIERS (FULL LIST)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.2 PROPERTY TIERS (FULL LIST)
- Anchor: 38-2-property-tiers-full-list
- Depends on: ['38.1 PROPERTY SYSTEM OVERVIEW']
- Feeds into: ['Tier 3 — Advanced Homes']
- Related: ['38.1 PROPERTY SYSTEM OVERVIEW', 'Tier 3 — Advanced Homes', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Tier 3 — Advanced Homes
- Anchor: tier-3-advanced-homes
- Depends on: ['38.2 PROPERTY TIERS (FULL LIST)']
- Feeds into: ['38.4 PROPERTY ROOMS & MODULES']
- Related: ['38.2 PROPERTY TIERS (FULL LIST)', '38.4 PROPERTY ROOMS & MODULES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.4 PROPERTY ROOMS & MODULES
- Anchor: 38-4-property-rooms-modules
- Depends on: ['Tier 3 — Advanced Homes']
- Feeds into: ['38.5 PROPERTY UPGRADE SYSTEM']
- Related: ['Tier 3 — Advanced Homes', '38.5 PROPERTY UPGRADE SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.5 PROPERTY UPGRADE SYSTEM
- Anchor: 38-5-property-upgrade-system
- Depends on: ['38.4 PROPERTY ROOMS & MODULES']
- Feeds into: ['38.6 PROPERTY FORTRESS SYSTEM (ENDGAME)']
- Related: ['38.4 PROPERTY ROOMS & MODULES', '38.6 PROPERTY FORTRESS SYSTEM (ENDGAME)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.6 PROPERTY FORTRESS SYSTEM (ENDGAME)
- Anchor: 38-6-property-fortress-system-endgame
- Depends on: ['38.5 PROPERTY UPGRADE SYSTEM']
- Feeds into: ['38.7 PROPERTY RAID SYSTEM (PVP + PVE)']
- Related: ['38.5 PROPERTY UPGRADE SYSTEM', '38.7 PROPERTY RAID SYSTEM (PVP + PVE)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.7 PROPERTY RAID SYSTEM (PVP + PVE)
- Anchor: 38-7-property-raid-system-pvp-pve
- Depends on: ['38.6 PROPERTY FORTRESS SYSTEM (ENDGAME)']
- Feeds into: ['38.8 PRESTIGE & PROPERTY SET BONUSES']
- Related: ['38.6 PROPERTY FORTRESS SYSTEM (ENDGAME)', '38.8 PRESTIGE & PROPERTY SET BONUSES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.8 PRESTIGE & PROPERTY SET BONUSES
- Anchor: 38-8-prestige-property-set-bonuses
- Depends on: ['38.7 PROPERTY RAID SYSTEM (PVP + PVE)']
- Feeds into: ['38.11 PROPERTY INTERIOR CUSTOMISATION']
- Related: ['38.7 PROPERTY RAID SYSTEM (PVP + PVE)', '38.11 PROPERTY INTERIOR CUSTOMISATION', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.11 PROPERTY INTERIOR CUSTOMISATION
- Anchor: 38-11-property-interior-customisation
- Depends on: ['38.8 PRESTIGE & PROPERTY SET BONUSES']
- Feeds into: ['38.12 PROPERTY ANTI-EXPLOIT MEASURES']
- Related: ['38.8 PRESTIGE & PROPERTY SET BONUSES', '38.12 PROPERTY ANTI-EXPLOIT MEASURES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.12 PROPERTY ANTI-EXPLOIT MEASURES
- Anchor: 38-12-property-anti-exploit-measures
- Depends on: ['38.11 PROPERTY INTERIOR CUSTOMISATION']
- Feeds into: ['40.8 INTERNATIONAL FACTIONS']
- Related: ['38.11 PROPERTY INTERIOR CUSTOMISATION', '40.8 INTERNATIONAL FACTIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 40.8 INTERNATIONAL FACTIONS
- Anchor: 40-8-international-factions
- Depends on: ['38.12 PROPERTY ANTI-EXPLOIT MEASURES']
- Feeds into: ['Faction Achievements']
- Related: ['38.12 PROPERTY ANTI-EXPLOIT MEASURES', 'Faction Achievements', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Faction Achievements
- Anchor: faction-achievements
- Depends on: ['40.8 INTERNATIONAL FACTIONS']
- Feeds into: ['Property Achievements']
- Related: ['40.8 INTERNATIONAL FACTIONS', 'Property Achievements', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Property Achievements
- Anchor: property-achievements
- Depends on: ['Faction Achievements']
- Feeds into: ['Gold (Advanced)']
- Related: ['Faction Achievements', 'Gold (Advanced)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Gold (Advanced)
- Anchor: gold-advanced
- Depends on: ['Property Achievements']
- Feeds into: ['Faction Oversight:']
- Related: ['Property Achievements', 'Faction Oversight:', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Faction Oversight:
- Anchor: faction-oversight
- Depends on: ['Gold (Advanced)']
- Feeds into: ['46.6 PLAYER & FACTION AGENCY']
- Related: ['Gold (Advanced)', '46.6 PLAYER & FACTION AGENCY', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 46.6 PLAYER & FACTION AGENCY
- Anchor: 46-6-player-faction-agency
- Depends on: ['Faction Oversight:']
- Feeds into: ['Faction Contributions:']
- Related: ['Faction Oversight:', 'Faction Contributions:', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Faction Contributions:
- Anchor: faction-contributions
- Depends on: ['46.6 PLAYER & FACTION AGENCY']
- Feeds into: ['Gang/Faction AI:']
- Related: ['46.6 PLAYER & FACTION AGENCY', 'Gang/Faction AI:', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Gang/Faction AI:
- Anchor: gang-faction-ai
- Depends on: ['Faction Contributions:']
- Feeds into: ['48.5 ENDGAME FACTIONS']
- Related: ['Faction Contributions:', '48.5 ENDGAME FACTIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 48.5 ENDGAME FACTIONS
- Anchor: 48-5-endgame-factions
- Depends on: ['Gang/Faction AI:']
- Feeds into: ['Expansion 2: **Vehicles 2.0**']
- Related: ['Gang/Faction AI:', 'Expansion 2: **Vehicles 2.0**', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Expansion 2: **Vehicles 2.0**
- Anchor: expansion-2-vehicles-2-0
- Depends on: ['48.5 ENDGAME FACTIONS']
- Feeds into: ['6. FACTIONS — ULTRA WARFARE EXPANSION']
- Related: ['48.5 ENDGAME FACTIONS', '6. FACTIONS — ULTRA WARFARE EXPANSION', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6. FACTIONS — ULTRA WARFARE EXPANSION
- Anchor: 6-factions-ultra-warfare-expansion
- Depends on: ['Expansion 2: **Vehicles 2.0**']
- Feeds into: ['6.1 ESPIONAGE SYSTEM (EXTENDED)']
- Related: ['Expansion 2: **Vehicles 2.0**', '6.1 ESPIONAGE SYSTEM (EXTENDED)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.1 ESPIONAGE SYSTEM (EXTENDED)
- Anchor: 6-1-espionage-system-extended
- Depends on: ['6. FACTIONS — ULTRA WARFARE EXPANSION']
- Feeds into: ['8. PROPERTY MEGA-EXPANSION']
- Related: ['6. FACTIONS — ULTRA WARFARE EXPANSION', '8. PROPERTY MEGA-EXPANSION', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8. PROPERTY MEGA-EXPANSION
- Anchor: 8-property-mega-expansion
- Depends on: ['6.1 ESPIONAGE SYSTEM (EXTENDED)']
- Feeds into: ['8.1 PROPERTY EVENT SYSTEM']
- Related: ['6.1 ESPIONAGE SYSTEM (EXTENDED)', '8.1 PROPERTY EVENT SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.1 PROPERTY EVENT SYSTEM
- Anchor: 8-1-property-event-system
- Depends on: ['8. PROPERTY MEGA-EXPANSION']
- Feeds into: ['9. VEHICLE & SMUGGLING ULTRA-SYSTEM']
- Related: ['8. PROPERTY MEGA-EXPANSION', '9. VEHICLE & SMUGGLING ULTRA-SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9. VEHICLE & SMUGGLING ULTRA-SYSTEM
- Anchor: 9-vehicle-smuggling-ultra-system
- Depends on: ['8.1 PROPERTY EVENT SYSTEM']
- Feeds into: ['18. BLACK MARKET INTELLIGENCE MODULE (BMI)']
- Related: ['8.1 PROPERTY EVENT SYSTEM', '18. BLACK MARKET INTELLIGENCE MODULE (BMI)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 18. BLACK MARKET INTELLIGENCE MODULE (BMI)
- Anchor: 18-black-market-intelligence-module-bmi
- Depends on: ['9. VEHICLE & SMUGGLING ULTRA-SYSTEM']
- Feeds into: ['18.1 MARKET REACTIONS']
- Related: ['9. VEHICLE & SMUGGLING ULTRA-SYSTEM', '18.1 MARKET REACTIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 18.1 MARKET REACTIONS
- Anchor: 18-1-market-reactions
- Depends on: ['18. BLACK MARKET INTELLIGENCE MODULE (BMI)']
- Feeds into: ['19. FACTION INTERNAL GOVERNANCE']
- Related: ['18. BLACK MARKET INTELLIGENCE MODULE (BMI)', '19. FACTION INTERNAL GOVERNANCE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19. FACTION INTERNAL GOVERNANCE
- Anchor: 19-faction-internal-governance
- Depends on: ['18.1 MARKET REACTIONS']
- Feeds into: ['22. PLAYER META-ARCHETYPES (ADVANCED)']
- Related: ['18.1 MARKET REACTIONS', '22. PLAYER META-ARCHETYPES (ADVANCED)', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 22. PLAYER META-ARCHETYPES (ADVANCED)
- Anchor: 22-player-meta-archetypes-advanced
- Depends on: ['19. FACTION INTERNAL GOVERNANCE']
- Feeds into: ['25. VEHICLE META-BIOME SYSTEM']
- Related: ['19. FACTION INTERNAL GOVERNANCE', '25. VEHICLE META-BIOME SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25. VEHICLE META-BIOME SYSTEM
- Anchor: 25-vehicle-meta-biome-system
- Depends on: ['22. PLAYER META-ARCHETYPES (ADVANCED)']
- Feeds into: ['25.1 VEHICLE BIOME PARAMETERS']
- Related: ['22. PLAYER META-ARCHETYPES (ADVANCED)', '25.1 VEHICLE BIOME PARAMETERS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.1 VEHICLE BIOME PARAMETERS
- Anchor: 25-1-vehicle-biome-parameters
- Depends on: ['25. VEHICLE META-BIOME SYSTEM']
- Feeds into: ['25.4 CONTRABAND VEHICLE BONUSES']
- Related: ['25. VEHICLE META-BIOME SYSTEM', '25.4 CONTRABAND VEHICLE BONUSES', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.4 CONTRABAND VEHICLE BONUSES
- Anchor: 25-4-contraband-vehicle-bonuses
- Depends on: ['25.1 VEHICLE BIOME PARAMETERS']
- Feeds into: ['33. FACTION WARFARE SUPER-MODULE']
- Related: ['25.1 VEHICLE BIOME PARAMETERS', '33. FACTION WARFARE SUPER-MODULE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33. FACTION WARFARE SUPER-MODULE
- Anchor: 33-faction-warfare-super-module
- Depends on: ['25.4 CONTRABAND VEHICLE BONUSES']
- Feeds into: ['33.2 FACTION STRATEGY LAYERS']
- Related: ['25.4 CONTRABAND VEHICLE BONUSES', '33.2 FACTION STRATEGY LAYERS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.2 FACTION STRATEGY LAYERS
- Anchor: 33-2-faction-strategy-layers
- Depends on: ['33. FACTION WARFARE SUPER-MODULE']
- Feeds into: ['50.1 PLAYER & FACTION INFLUENCE']
- Related: ['33. FACTION WARFARE SUPER-MODULE', '50.1 PLAYER & FACTION INFLUENCE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 50.1 PLAYER & FACTION INFLUENCE
- Anchor: 50-1-player-faction-influence
- Depends on: ['33.2 FACTION STRATEGY LAYERS']
- Feeds into: ['Tier 1 — Faction Assault Teams']
- Related: ['33.2 FACTION STRATEGY LAYERS', 'Tier 1 — Faction Assault Teams', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Tier 1 — Faction Assault Teams
- Anchor: tier-1-faction-assault-teams
- Depends on: ['50.1 PLAYER & FACTION INFLUENCE']
- Feeds into: ['52. FACTION HQ SYSTEM']
- Related: ['50.1 PLAYER & FACTION INFLUENCE', '52. FACTION HQ SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 52. FACTION HQ SYSTEM
- Anchor: 52-faction-hq-system
- Depends on: ['Tier 1 — Faction Assault Teams']
- Feeds into: ['52.2 FACTION SUPER-WEAPONS']
- Related: ['Tier 1 — Faction Assault Teams', '52.2 FACTION SUPER-WEAPONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 52.2 FACTION SUPER-WEAPONS
- Anchor: 52-2-faction-super-weapons
- Depends on: ['52. FACTION HQ SYSTEM']
- Feeds into: ['53. PROPERTY INTERIOR ENGINE']
- Related: ['52. FACTION HQ SYSTEM', '53. PROPERTY INTERIOR ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 53. PROPERTY INTERIOR ENGINE
- Anchor: 53-property-interior-engine
- Depends on: ['52.2 FACTION SUPER-WEAPONS']
- Feeds into: ['Advanced Rooms']
- Related: ['52.2 FACTION SUPER-WEAPONS', 'Advanced Rooms', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Advanced Rooms
- Anchor: advanced-rooms
- Depends on: ['53. PROPERTY INTERIOR ENGINE']
- Feeds into: ['53.3 PROPERTY DEFENSE SYSTEM']
- Related: ['53. PROPERTY INTERIOR ENGINE', '53.3 PROPERTY DEFENSE SYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 53.3 PROPERTY DEFENSE SYSTEM
- Anchor: 53-3-property-defense-system
- Depends on: ['Advanced Rooms']
- Feeds into: ['57. BLACK MARKET 2.0 — CONTRABAND ECOSYSTEM']
- Related: ['Advanced Rooms', '57. BLACK MARKET 2.0 — CONTRABAND ECOSYSTEM', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 57. BLACK MARKET 2.0 — CONTRABAND ECOSYSTEM
- Anchor: 57-black-market-2-0-contraband-ecosystem
- Depends on: ['53.3 PROPERTY DEFENSE SYSTEM']
- Feeds into: ['68. VEHICLE CUSTOMISATION SUPERSTRUCTURE']
- Related: ['53.3 PROPERTY DEFENSE SYSTEM', '68. VEHICLE CUSTOMISATION SUPERSTRUCTURE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 68. VEHICLE CUSTOMISATION SUPERSTRUCTURE
- Anchor: 68-vehicle-customisation-superstructure
- Depends on: ['57. BLACK MARKET 2.0 — CONTRABAND ECOSYSTEM']
- Feeds into: ['69. MEDICAL & TRAUMA ENGINE']
- Related: ['57. BLACK MARKET 2.0 — CONTRABAND ECOSYSTEM', '69. MEDICAL & TRAUMA ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 69. MEDICAL & TRAUMA ENGINE
- Anchor: 69-medical-trauma-engine
- Depends on: ['68. VEHICLE CUSTOMISATION SUPERSTRUCTURE']
- Feeds into: ['69.2 MEDICAL TREATMENTS']
- Related: ['68. VEHICLE CUSTOMISATION SUPERSTRUCTURE', '69.2 MEDICAL TREATMENTS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 69.2 MEDICAL TREATMENTS
- Anchor: 69-2-medical-treatments
- Depends on: ['69. MEDICAL & TRAUMA ENGINE']
- Feeds into: ['71. ESPIONAGE OVERHAUL']
- Related: ['69. MEDICAL & TRAUMA ENGINE', '71. ESPIONAGE OVERHAUL', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 71. ESPIONAGE OVERHAUL
- Anchor: 71-espionage-overhaul
- Depends on: ['69.2 MEDICAL TREATMENTS']
- Feeds into: ['71.1 ESPIONAGE ACTIONS']
- Related: ['69.2 MEDICAL TREATMENTS', '71.1 ESPIONAGE ACTIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 71.1 ESPIONAGE ACTIONS
- Anchor: 71-1-espionage-actions
- Depends on: ['71. ESPIONAGE OVERHAUL']
- Feeds into: ['73.1 PRISON FACTIONS']
- Related: ['71. ESPIONAGE OVERHAUL', '73.1 PRISON FACTIONS', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 73.1 PRISON FACTIONS
- Anchor: 73-1-prison-factions
- Depends on: ['71.1 ESPIONAGE ACTIONS']
- Feeds into: ['75. PROPERTY EMPIRE ENGINE']
- Related: ['71.1 ESPIONAGE ACTIONS', '75. PROPERTY EMPIRE ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 75. PROPERTY EMPIRE ENGINE
- Anchor: 75-property-empire-engine
- Depends on: ['73.1 PRISON FACTIONS']
- Feeds into: ['75.1 PROPERTY TIER TREE']
- Related: ['73.1 PRISON FACTIONS', '75.1 PROPERTY TIER TREE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 75.1 PROPERTY TIER TREE
- Anchor: 75-1-property-tier-tree
- Depends on: ['75. PROPERTY EMPIRE ENGINE']
- Feeds into: ['95. MARKET AI ENGINE']
- Related: ['75. PROPERTY EMPIRE ENGINE', '95. MARKET AI ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 95. MARKET AI ENGINE
- Anchor: 95-market-ai-engine
- Depends on: ['75.1 PROPERTY TIER TREE']
- Feeds into: ['131. ESPIONAGE THEATRE']
- Related: ['75.1 PROPERTY TIER TREE', '131. ESPIONAGE THEATRE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 131. ESPIONAGE THEATRE
- Anchor: 131-espionage-theatre
- Depends on: ['95. MARKET AI ENGINE']
- Feeds into: ['139. LAUNDERING MARKET ENGINE']
- Related: ['95. MARKET AI ENGINE', '139. LAUNDERING MARKET ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 139. LAUNDERING MARKET ENGINE
- Anchor: 139-laundering-market-engine
- Depends on: ['131. ESPIONAGE THEATRE']
- Feeds into: ['160. COSMIC BLACK MARKET']
- Related: ['131. ESPIONAGE THEATRE', '160. COSMIC BLACK MARKET', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 160. COSMIC BLACK MARKET
- Anchor: 160-cosmic-black-market
- Depends on: ['139. LAUNDERING MARKET ENGINE']
- Feeds into: ['163. ETERNAL FACTION WAR']
- Related: ['139. LAUNDERING MARKET ENGINE', '163. ETERNAL FACTION WAR', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 163. ETERNAL FACTION WAR
- Anchor: 163-eternal-faction-war
- Depends on: ['160. COSMIC BLACK MARKET']
- Feeds into: ['175. COSMIC MARKET ENGINE']
- Related: ['160. COSMIC BLACK MARKET', '175. COSMIC MARKET ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 175. COSMIC MARKET ENGINE
- Anchor: 175-cosmic-market-engine
- Depends on: ['163. ETERNAL FACTION WAR']
- Feeds into: ['194. SUPREME FACTION ENGINE']
- Related: ['163. ETERNAL FACTION WAR', '194. SUPREME FACTION ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 194. SUPREME FACTION ENGINE
- Anchor: 194-supreme-faction-engine
- Depends on: ['175. COSMIC MARKET ENGINE']
- Feeds into: []
- Related: ['175. COSMIC MARKET ENGINE', 'CORE SYSTEMS', 'Class E — Cultural & Historical Goods', 'DRIFT KING', '165. THE FORGE OF ORIGINS']

# CORE SYSTEMS

## CORE SYSTEMS
- Anchor: core-systems
- Depends on: []
- Feeds into: ['1. CORE PLAYER SYSTEMS']
- Related: ['1. CORE PLAYER SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING', '165. THE FORGE OF ORIGINS']

## 1. CORE PLAYER SYSTEMS
- Anchor: 1-core-player-systems
- Depends on: ['CORE SYSTEMS']
- Feeds into: ['3. CRIME SYSTEMS']
- Related: ['CORE SYSTEMS', '3. CRIME SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3. CRIME SYSTEMS
- Anchor: 3-crime-systems
- Depends on: ['1. CORE PLAYER SYSTEMS']
- Feeds into: ['4. COMBAT SYSTEMS']
- Related: ['1. CORE PLAYER SYSTEMS', '4. COMBAT SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 4. COMBAT SYSTEMS
- Anchor: 4-combat-systems
- Depends on: ['3. CRIME SYSTEMS']
- Feeds into: ['6. MISSIONS & NPC SYSTEMS']
- Related: ['3. CRIME SYSTEMS', '6. MISSIONS & NPC SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6. MISSIONS & NPC SYSTEMS
- Anchor: 6-missions-npc-systems
- Depends on: ['4. COMBAT SYSTEMS']
- Feeds into: ['7. ECONOMY SYSTEMS']
- Related: ['4. COMBAT SYSTEMS', '7. ECONOMY SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7. ECONOMY SYSTEMS
- Anchor: 7-economy-systems
- Depends on: ['6. MISSIONS & NPC SYSTEMS']
- Feeds into: ['8. PROPERTY & HOUSING SYSTEMS']
- Related: ['6. MISSIONS & NPC SYSTEMS', '8. PROPERTY & HOUSING SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8. PROPERTY & HOUSING SYSTEMS
- Anchor: 8-property-housing-systems
- Depends on: ['7. ECONOMY SYSTEMS']
- Feeds into: ['CHUNK 1 — CORE GAME VISION (EXPANDED)']
- Related: ['7. ECONOMY SYSTEMS', 'CHUNK 1 — CORE GAME VISION (EXPANDED)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 1 — CORE GAME VISION (EXPANDED)
- Anchor: chunk-1-core-game-vision-expanded
- Depends on: ['8. PROPERTY & HOUSING SYSTEMS']
- Feeds into: ['CHUNK 2 — CORE PLAYER SYSTEMS DEEP DIVE']
- Related: ['8. PROPERTY & HOUSING SYSTEMS', 'CHUNK 2 — CORE PLAYER SYSTEMS DEEP DIVE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 2 — CORE PLAYER SYSTEMS DEEP DIVE
- Anchor: chunk-2-core-player-systems-deep-dive
- Depends on: ['CHUNK 1 — CORE GAME VISION (EXPANDED)']
- Feeds into: ['2.8 PLAYER ECONOMY PROFILE']
- Related: ['CHUNK 1 — CORE GAME VISION (EXPANDED)', '2.8 PLAYER ECONOMY PROFILE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 2.8 PLAYER ECONOMY PROFILE
- Anchor: 2-8-player-economy-profile
- Depends on: ['CHUNK 2 — CORE PLAYER SYSTEMS DEEP DIVE']
- Feeds into: ['CHUNK 3 — COMPLETE DATABASE SCHEMA (CORE SYSTEMS)']
- Related: ['CHUNK 2 — CORE PLAYER SYSTEMS DEEP DIVE', 'CHUNK 3 — COMPLETE DATABASE SCHEMA (CORE SYSTEMS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 3 — COMPLETE DATABASE SCHEMA (CORE SYSTEMS)
- Anchor: chunk-3-complete-database-schema-core-systems
- Depends on: ['2.8 PLAYER ECONOMY PROFILE']
- Feeds into: ['3.2 INVENTORY & ITEMS STRUCTURE']
- Related: ['2.8 PLAYER ECONOMY PROFILE', '3.2 INVENTORY & ITEMS STRUCTURE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.2 INVENTORY & ITEMS STRUCTURE
- Anchor: 3-2-inventory-items-structure
- Depends on: ['CHUNK 3 — COMPLETE DATABASE SCHEMA (CORE SYSTEMS)']
- Feeds into: ['TABLE: user_inventory']
- Related: ['CHUNK 3 — COMPLETE DATABASE SCHEMA (CORE SYSTEMS)', 'TABLE: user_inventory', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: user_inventory
- Anchor: table-user-inventory
- Depends on: ['3.2 INVENTORY & ITEMS STRUCTURE']
- Feeds into: ['3.3 PROPERTY & HOUSING STRUCTURE']
- Related: ['3.2 INVENTORY & ITEMS STRUCTURE', '3.3 PROPERTY & HOUSING STRUCTURE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.3 PROPERTY & HOUSING STRUCTURE
- Anchor: 3-3-property-housing-structure
- Depends on: ['TABLE: user_inventory']
- Feeds into: ['3.5 CRIME SYSTEM SCHEMA (20 PATHS)']
- Related: ['TABLE: user_inventory', '3.5 CRIME SYSTEM SCHEMA (20 PATHS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.5 CRIME SYSTEM SCHEMA (20 PATHS)
- Anchor: 3-5-crime-system-schema-20-paths
- Depends on: ['3.3 PROPERTY & HOUSING STRUCTURE']
- Feeds into: ['TABLE: crime_paths']
- Related: ['3.3 PROPERTY & HOUSING STRUCTURE', 'TABLE: crime_paths', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: crime_paths
- Anchor: table-crime-paths
- Depends on: ['3.5 CRIME SYSTEM SCHEMA (20 PATHS)']
- Feeds into: ['TABLE: crimes']
- Related: ['3.5 CRIME SYSTEM SCHEMA (20 PATHS)', 'TABLE: crimes', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: crimes
- Anchor: table-crimes
- Depends on: ['TABLE: crime_paths']
- Feeds into: ['TABLE: crime_attempts']
- Related: ['TABLE: crime_paths', 'TABLE: crime_attempts', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: crime_attempts
- Anchor: table-crime-attempts
- Depends on: ['TABLE: crimes']
- Feeds into: ['3.6 NPC, MISSIONS & AI STRUCTURE']
- Related: ['TABLE: crimes', '3.6 NPC, MISSIONS & AI STRUCTURE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.6 NPC, MISSIONS & AI STRUCTURE
- Anchor: 3-6-npc-missions-ai-structure
- Depends on: ['TABLE: crime_attempts']
- Feeds into: ['TABLE: npc_profiles']
- Related: ['TABLE: crime_attempts', 'TABLE: npc_profiles', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: npc_profiles
- Anchor: table-npc-profiles
- Depends on: ['3.6 NPC, MISSIONS & AI STRUCTURE']
- Feeds into: ['3.8 ECONOMY, MARKET, STOCKS']
- Related: ['3.6 NPC, MISSIONS & AI STRUCTURE', '3.8 ECONOMY, MARKET, STOCKS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 3.8 ECONOMY, MARKET, STOCKS
- Anchor: 3-8-economy-market-stocks
- Depends on: ['TABLE: npc_profiles']
- Feeds into: ['TABLE: economy_events']
- Related: ['TABLE: npc_profiles', 'TABLE: economy_events', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## TABLE: economy_events
- Anchor: table-economy-events
- Depends on: ['3.8 ECONOMY, MARKET, STOCKS']
- Feeds into: ['4.5 UI COMPONENT LIBRARY (CORE ELEMENTS)']
- Related: ['3.8 ECONOMY, MARKET, STOCKS', '4.5 UI COMPONENT LIBRARY (CORE ELEMENTS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 4.5 UI COMPONENT LIBRARY (CORE ELEMENTS)
- Anchor: 4-5-ui-component-library-core-elements
- Depends on: ['TABLE: economy_events']
- Feeds into: ['CHUNK 5 — CRIME SYSTEMS DEEP BOOK']
- Related: ['TABLE: economy_events', 'CHUNK 5 — CRIME SYSTEMS DEEP BOOK', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 5 — CRIME SYSTEMS DEEP BOOK
- Anchor: chunk-5-crime-systems-deep-book
- Depends on: ['4.5 UI COMPONENT LIBRARY (CORE ELEMENTS)']
- Feeds into: ['5.1 CRIME SYSTEM OVERVIEW']
- Related: ['4.5 UI COMPONENT LIBRARY (CORE ELEMENTS)', '5.1 CRIME SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5.1 CRIME SYSTEM OVERVIEW
- Anchor: 5-1-crime-system-overview
- Depends on: ['CHUNK 5 — CRIME SYSTEMS DEEP BOOK']
- Feeds into: ['5.2 THE 20 CRIME PATHS (FULL TREE)']
- Related: ['CHUNK 5 — CRIME SYSTEMS DEEP BOOK', '5.2 THE 20 CRIME PATHS (FULL TREE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5.2 THE 20 CRIME PATHS (FULL TREE)
- Anchor: 5-2-the-20-crime-paths-full-tree
- Depends on: ['5.1 CRIME SYSTEM OVERVIEW']
- Feeds into: ['1. Street Crime']
- Related: ['5.1 CRIME SYSTEM OVERVIEW', '1. Street Crime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 1. Street Crime
- Anchor: 1-street-crime
- Depends on: ['5.2 THE 20 CRIME PATHS (FULL TREE)']
- Feeds into: ['7. Cybercrime']
- Related: ['5.2 THE 20 CRIME PATHS (FULL TREE)', '7. Cybercrime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7. Cybercrime
- Anchor: 7-cybercrime
- Depends on: ['1. Street Crime']
- Feeds into: ['14. Political Crime']
- Related: ['1. Street Crime', '14. Political Crime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 14. Political Crime
- Anchor: 14-political-crime
- Depends on: ['7. Cybercrime']
- Feeds into: ['15. Corporate Crime']
- Related: ['7. Cybercrime', '15. Corporate Crime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15. Corporate Crime
- Anchor: 15-corporate-crime
- Depends on: ['14. Political Crime']
- Feeds into: ['20. Elite Crime (Endgame)']
- Related: ['14. Political Crime', '20. Elite Crime (Endgame)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 20. Elite Crime (Endgame)
- Anchor: 20-elite-crime-endgame
- Depends on: ['15. Corporate Crime']
- Feeds into: ['5.3 CRIME FORMULAS & DIFFICULTY']
- Related: ['15. Corporate Crime', '5.3 CRIME FORMULAS & DIFFICULTY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5.3 CRIME FORMULAS & DIFFICULTY
- Anchor: 5-3-crime-formulas-difficulty
- Depends on: ['20. Elite Crime (Endgame)']
- Feeds into: ['Core Inputs:']
- Related: ['20. Elite Crime (Endgame)', 'Core Inputs:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Core Inputs:
- Anchor: core-inputs
- Depends on: ['5.3 CRIME FORMULAS & DIFFICULTY']
- Feeds into: ['5.6 CRIME MODIFIERS']
- Related: ['5.3 CRIME FORMULAS & DIFFICULTY', '5.6 CRIME MODIFIERS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5.6 CRIME MODIFIERS
- Anchor: 5-6-crime-modifiers
- Depends on: ['Core Inputs:']
- Feeds into: ['5.7 CRIME REWARD CURVES']
- Related: ['Core Inputs:', '5.7 CRIME REWARD CURVES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5.7 CRIME REWARD CURVES
- Anchor: 5-7-crime-reward-curves
- Depends on: ['5.6 CRIME MODIFIERS']
- Feeds into: ['5.9 CRIME CHAINS (EXAMPLE)']
- Related: ['5.6 CRIME MODIFIERS', '5.9 CRIME CHAINS (EXAMPLE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5.9 CRIME CHAINS (EXAMPLE)
- Anchor: 5-9-crime-chains-example
- Depends on: ['5.7 CRIME REWARD CURVES']
- Feeds into: ['CHUNK 6 — COMBAT SYSTEMS DEEP BOOK']
- Related: ['5.7 CRIME REWARD CURVES', 'CHUNK 6 — COMBAT SYSTEMS DEEP BOOK', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 6 — COMBAT SYSTEMS DEEP BOOK
- Anchor: chunk-6-combat-systems-deep-book
- Depends on: ['5.9 CRIME CHAINS (EXAMPLE)']
- Feeds into: ['6.1 COMBAT DESIGN PHILOSOPHY']
- Related: ['5.9 CRIME CHAINS (EXAMPLE)', '6.1 COMBAT DESIGN PHILOSOPHY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.1 COMBAT DESIGN PHILOSOPHY
- Anchor: 6-1-combat-design-philosophy
- Depends on: ['CHUNK 6 — COMBAT SYSTEMS DEEP BOOK']
- Feeds into: ['6.2 CORE COMBAT LOOP']
- Related: ['CHUNK 6 — COMBAT SYSTEMS DEEP BOOK', '6.2 CORE COMBAT LOOP', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.2 CORE COMBAT LOOP
- Anchor: 6-2-core-combat-loop
- Depends on: ['6.1 COMBAT DESIGN PHILOSOPHY']
- Feeds into: ['6.3 STATS IN COMBAT']
- Related: ['6.1 COMBAT DESIGN PHILOSOPHY', '6.3 STATS IN COMBAT', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.3 STATS IN COMBAT
- Anchor: 6-3-stats-in-combat
- Depends on: ['6.2 CORE COMBAT LOOP']
- Feeds into: ['6.7 COMBAT STANCES']
- Related: ['6.2 CORE COMBAT LOOP', '6.7 COMBAT STANCES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.7 COMBAT STANCES
- Anchor: 6-7-combat-stances
- Depends on: ['6.3 STATS IN COMBAT']
- Feeds into: ['6.8 NPC COMBAT AI']
- Related: ['6.3 STATS IN COMBAT', '6.8 NPC COMBAT AI', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.8 NPC COMBAT AI
- Anchor: 6-8-npc-combat-ai
- Depends on: ['6.7 COMBAT STANCES']
- Feeds into: ['6.9 COMBAT MODIFIERS']
- Related: ['6.7 COMBAT STANCES', '6.9 COMBAT MODIFIERS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.9 COMBAT MODIFIERS
- Anchor: 6-9-combat-modifiers
- Depends on: ['6.8 NPC COMBAT AI']
- Feeds into: ['6.10 BOUNTY & HITLIST COMBAT RULES']
- Related: ['6.8 NPC COMBAT AI', '6.10 BOUNTY & HITLIST COMBAT RULES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.10 BOUNTY & HITLIST COMBAT RULES
- Anchor: 6-10-bounty-hitlist-combat-rules
- Depends on: ['6.9 COMBAT MODIFIERS']
- Feeds into: ['6.11 FACTION WAR COMBAT']
- Related: ['6.9 COMBAT MODIFIERS', '6.11 FACTION WAR COMBAT', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.11 FACTION WAR COMBAT
- Anchor: 6-11-faction-war-combat
- Depends on: ['6.10 BOUNTY & HITLIST COMBAT RULES']
- Feeds into: ['6.12 CRIME → COMBAT INTERACTIONS']
- Related: ['6.10 BOUNTY & HITLIST COMBAT RULES', '6.12 CRIME → COMBAT INTERACTIONS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.12 CRIME → COMBAT INTERACTIONS
- Anchor: 6-12-crime-combat-interactions
- Depends on: ['6.11 FACTION WAR COMBAT']
- Feeds into: ['6.13 POST-COMBAT OUTCOMES']
- Related: ['6.11 FACTION WAR COMBAT', '6.13 POST-COMBAT OUTCOMES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 6.13 POST-COMBAT OUTCOMES
- Anchor: 6-13-post-combat-outcomes
- Depends on: ['6.12 CRIME → COMBAT INTERACTIONS']
- Feeds into: ['Core Data']
- Related: ['6.12 CRIME → COMBAT INTERACTIONS', 'Core Data', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Core Data
- Anchor: core-data
- Depends on: ['6.13 POST-COMBAT OUTCOMES']
- Feeds into: ['7.3 FACTION TREASURY & ECONOMY']
- Related: ['6.13 POST-COMBAT OUTCOMES', '7.3 FACTION TREASURY & ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.3 FACTION TREASURY & ECONOMY
- Anchor: 7-3-faction-treasury-economy
- Depends on: ['Core Data']
- Feeds into: ['CHUNK 8 — MISSIONS & NPC WORLD MODEL']
- Related: ['Core Data', 'CHUNK 8 — MISSIONS & NPC WORLD MODEL', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 8 — MISSIONS & NPC WORLD MODEL
- Anchor: chunk-8-missions-npc-world-model
- Depends on: ['7.3 FACTION TREASURY & ECONOMY']
- Feeds into: ['8.6 NPC WORLD MODEL']
- Related: ['7.3 FACTION TREASURY & ECONOMY', '8.6 NPC WORLD MODEL', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.6 NPC WORLD MODEL
- Anchor: 8-6-npc-world-model
- Depends on: ['CHUNK 8 — MISSIONS & NPC WORLD MODEL']
- Feeds into: ['NPC Types:']
- Related: ['CHUNK 8 — MISSIONS & NPC WORLD MODEL', 'NPC Types:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## NPC Types:
- Anchor: npc-types
- Depends on: ['8.6 NPC WORLD MODEL']
- Feeds into: ['8.7 NPC PERSONALITY TRAITS']
- Related: ['8.6 NPC WORLD MODEL', '8.7 NPC PERSONALITY TRAITS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.7 NPC PERSONALITY TRAITS
- Anchor: 8-7-npc-personality-traits
- Depends on: ['NPC Types:']
- Feeds into: ['8.8 NPC GANG SYSTEM']
- Related: ['NPC Types:', '8.8 NPC GANG SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.8 NPC GANG SYSTEM
- Anchor: 8-8-npc-gang-system
- Depends on: ['8.7 NPC PERSONALITY TRAITS']
- Feeds into: ['8.9 NPC CREW SYSTEM (PLAYER HIRES)']
- Related: ['8.7 NPC PERSONALITY TRAITS', '8.9 NPC CREW SYSTEM (PLAYER HIRES)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.9 NPC CREW SYSTEM (PLAYER HIRES)
- Anchor: 8-9-npc-crew-system-player-hires
- Depends on: ['8.8 NPC GANG SYSTEM']
- Feeds into: ['8.10 NPC RELATIONSHIP SYSTEM']
- Related: ['8.8 NPC GANG SYSTEM', '8.10 NPC RELATIONSHIP SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 8.10 NPC RELATIONSHIP SYSTEM
- Anchor: 8-10-npc-relationship-system
- Depends on: ['8.9 NPC CREW SYSTEM (PLAYER HIRES)']
- Feeds into: ['CHUNK 9 — ECONOMY & MARKET ARCHITECTURE']
- Related: ['8.9 NPC CREW SYSTEM (PLAYER HIRES)', 'CHUNK 9 — ECONOMY & MARKET ARCHITECTURE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 9 — ECONOMY & MARKET ARCHITECTURE
- Anchor: chunk-9-economy-market-architecture
- Depends on: ['8.10 NPC RELATIONSHIP SYSTEM']
- Feeds into: ['9.1 ECONOMY DESIGN PHILOSOPHY']
- Related: ['8.10 NPC RELATIONSHIP SYSTEM', '9.1 ECONOMY DESIGN PHILOSOPHY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.1 ECONOMY DESIGN PHILOSOPHY
- Anchor: 9-1-economy-design-philosophy
- Depends on: ['CHUNK 9 — ECONOMY & MARKET ARCHITECTURE']
- Feeds into: ['Core Currencies']
- Related: ['CHUNK 9 — ECONOMY & MARKET ARCHITECTURE', 'Core Currencies', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Core Currencies
- Anchor: core-currencies
- Depends on: ['9.1 ECONOMY DESIGN PHILOSOPHY']
- Feeds into: ['9.8 MATERIAL ECONOMY']
- Related: ['9.1 ECONOMY DESIGN PHILOSOPHY', '9.8 MATERIAL ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.8 MATERIAL ECONOMY
- Anchor: 9-8-material-economy
- Depends on: ['Core Currencies']
- Feeds into: ['9.9 CRAFTING ECONOMY']
- Related: ['Core Currencies', '9.9 CRAFTING ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.9 CRAFTING ECONOMY
- Anchor: 9-9-crafting-economy
- Depends on: ['9.8 MATERIAL ECONOMY']
- Feeds into: ['9.10 BLACK MARKET ECONOMY']
- Related: ['9.8 MATERIAL ECONOMY', '9.10 BLACK MARKET ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.10 BLACK MARKET ECONOMY
- Anchor: 9-10-black-market-economy
- Depends on: ['9.9 CRAFTING ECONOMY']
- Feeds into: ['9.11 NPC ECONOMIC BEHAVIOUR']
- Related: ['9.9 CRAFTING ECONOMY', '9.11 NPC ECONOMIC BEHAVIOUR', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.11 NPC ECONOMIC BEHAVIOUR
- Anchor: 9-11-npc-economic-behaviour
- Depends on: ['9.10 BLACK MARKET ECONOMY']
- Feeds into: ['9.12 LIVE OPS ECONOMY CONTROLS']
- Related: ['9.10 BLACK MARKET ECONOMY', '9.12 LIVE OPS ECONOMY CONTROLS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.12 LIVE OPS ECONOMY CONTROLS
- Anchor: 9-12-live-ops-economy-controls
- Depends on: ['9.11 NPC ECONOMIC BEHAVIOUR']
- Feeds into: ['9.13 ECONOMY AI — INFLATION & STABILITY ENGINE']
- Related: ['9.11 NPC ECONOMIC BEHAVIOUR', '9.13 ECONOMY AI — INFLATION & STABILITY ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9.13 ECONOMY AI — INFLATION & STABILITY ENGINE
- Anchor: 9-13-economy-ai-inflation-stability-engine
- Depends on: ['9.12 LIVE OPS ECONOMY CONTROLS']
- Feeds into: ['CHUNK 10 — PROPERTIES & HOUSING EXPANSION BOOK']
- Related: ['9.12 LIVE OPS ECONOMY CONTROLS', 'CHUNK 10 — PROPERTIES & HOUSING EXPANSION BOOK', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 10 — PROPERTIES & HOUSING EXPANSION BOOK
- Anchor: chunk-10-properties-housing-expansion-book
- Depends on: ['9.13 ECONOMY AI — INFLATION & STABILITY ENGINE']
- Feeds into: ['10.3 HOUSING BONUSES']
- Related: ['9.13 ECONOMY AI — INFLATION & STABILITY ENGINE', '10.3 HOUSING BONUSES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.3 HOUSING BONUSES
- Anchor: 10-3-housing-bonuses
- Depends on: ['CHUNK 10 — PROPERTIES & HOUSING EXPANSION BOOK']
- Feeds into: ['Core Upgrade Rooms']
- Related: ['CHUNK 10 — PROPERTIES & HOUSING EXPANSION BOOK', 'Core Upgrade Rooms', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Core Upgrade Rooms
- Anchor: core-upgrade-rooms
- Depends on: ['10.3 HOUSING BONUSES']
- Feeds into: ['NPC Burglary Attempts']
- Related: ['10.3 HOUSING BONUSES', 'NPC Burglary Attempts', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## NPC Burglary Attempts
- Anchor: npc-burglary-attempts
- Depends on: ['Core Upgrade Rooms']
- Feeds into: ['10.8 HOUSING MARKET SIMULATION']
- Related: ['Core Upgrade Rooms', '10.8 HOUSING MARKET SIMULATION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10.8 HOUSING MARKET SIMULATION
- Anchor: 10-8-housing-market-simulation
- Depends on: ['NPC Burglary Attempts']
- Feeds into: ['CHUNK 15 — AI SYSTEMS: AI DIRECTOR, NPC BEHAVIOUR & WORLD SIMULATION']
- Related: ['NPC Burglary Attempts', 'CHUNK 15 — AI SYSTEMS: AI DIRECTOR, NPC BEHAVIOUR & WORLD SIMULATION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 15 — AI SYSTEMS: AI DIRECTOR, NPC BEHAVIOUR & WORLD SIMULATION
- Anchor: chunk-15-ai-systems-ai-director-npc-behaviour-world-simulation
- Depends on: ['10.8 HOUSING MARKET SIMULATION']
- Feeds into: ['15.4 NPC BEHAVIOUR ENGINE']
- Related: ['10.8 HOUSING MARKET SIMULATION', '15.4 NPC BEHAVIOUR ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.4 NPC BEHAVIOUR ENGINE
- Anchor: 15-4-npc-behaviour-engine
- Depends on: ['CHUNK 15 — AI SYSTEMS: AI DIRECTOR, NPC BEHAVIOUR & WORLD SIMULATION']
- Feeds into: ['15.5 NPC GANG AI']
- Related: ['CHUNK 15 — AI SYSTEMS: AI DIRECTOR, NPC BEHAVIOUR & WORLD SIMULATION', '15.5 NPC GANG AI', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.5 NPC GANG AI
- Anchor: 15-5-npc-gang-ai
- Depends on: ['15.4 NPC BEHAVIOUR ENGINE']
- Feeds into: ['15.7 NPC BOSS AI']
- Related: ['15.4 NPC BEHAVIOUR ENGINE', '15.7 NPC BOSS AI', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.7 NPC BOSS AI
- Anchor: 15-7-npc-boss-ai
- Depends on: ['15.5 NPC GANG AI']
- Feeds into: ['15.10 ECONOMY INTERACTION WITH AI']
- Related: ['15.5 NPC GANG AI', '15.10 ECONOMY INTERACTION WITH AI', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.10 ECONOMY INTERACTION WITH AI
- Anchor: 15-10-economy-interaction-with-ai
- Depends on: ['15.7 NPC BOSS AI']
- Feeds into: ['15.11 AI HOOKS INTO COMBAT']
- Related: ['15.7 NPC BOSS AI', '15.11 AI HOOKS INTO COMBAT', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.11 AI HOOKS INTO COMBAT
- Anchor: 15-11-ai-hooks-into-combat
- Depends on: ['15.10 ECONOMY INTERACTION WITH AI']
- Feeds into: ['15.12 AI HOOKS INTO CRIMES']
- Related: ['15.10 ECONOMY INTERACTION WITH AI', '15.12 AI HOOKS INTO CRIMES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 15.12 AI HOOKS INTO CRIMES
- Anchor: 15-12-ai-hooks-into-crimes
- Depends on: ['15.11 AI HOOKS INTO COMBAT']
- Feeds into: ['CHUNK 16 — COMBAT SYSTEMS (PVE, PVP, WEAPONS, ARMOR, SKILLS)']
- Related: ['15.11 AI HOOKS INTO COMBAT', 'CHUNK 16 — COMBAT SYSTEMS (PVE, PVP, WEAPONS, ARMOR, SKILLS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 16 — COMBAT SYSTEMS (PVE, PVP, WEAPONS, ARMOR, SKILLS)
- Anchor: chunk-16-combat-systems-pve-pvp-weapons-armor-skills
- Depends on: ['15.12 AI HOOKS INTO CRIMES']
- Feeds into: ['16.1 COMBAT SYSTEM OVERVIEW']
- Related: ['15.12 AI HOOKS INTO CRIMES', '16.1 COMBAT SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.1 COMBAT SYSTEM OVERVIEW
- Anchor: 16-1-combat-system-overview
- Depends on: ['CHUNK 16 — COMBAT SYSTEMS (PVE, PVP, WEAPONS, ARMOR, SKILLS)']
- Feeds into: ['16.2 PRIMARY COMBAT STATS']
- Related: ['CHUNK 16 — COMBAT SYSTEMS (PVE, PVP, WEAPONS, ARMOR, SKILLS)', '16.2 PRIMARY COMBAT STATS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.2 PRIMARY COMBAT STATS
- Anchor: 16-2-primary-combat-stats
- Depends on: ['16.1 COMBAT SYSTEM OVERVIEW']
- Feeds into: ['16.7 COMBAT FORMULAS (SIMPLIFIED)']
- Related: ['16.1 COMBAT SYSTEM OVERVIEW', '16.7 COMBAT FORMULAS (SIMPLIFIED)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.7 COMBAT FORMULAS (SIMPLIFIED)
- Anchor: 16-7-combat-formulas-simplified
- Depends on: ['16.2 PRIMARY COMBAT STATS']
- Feeds into: ['16.8 PVP COMBAT MODES']
- Related: ['16.2 PRIMARY COMBAT STATS', '16.8 PVP COMBAT MODES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.8 PVP COMBAT MODES
- Anchor: 16-8-pvp-combat-modes
- Depends on: ['16.7 COMBAT FORMULAS (SIMPLIFIED)']
- Feeds into: ['16.9 PVE COMBAT']
- Related: ['16.7 COMBAT FORMULAS (SIMPLIFIED)', '16.9 PVE COMBAT', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.9 PVE COMBAT
- Anchor: 16-9-pve-combat
- Depends on: ['16.8 PVP COMBAT MODES']
- Feeds into: ['16.11 FACTION RAID COMBAT']
- Related: ['16.8 PVP COMBAT MODES', '16.11 FACTION RAID COMBAT', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.11 FACTION RAID COMBAT
- Anchor: 16-11-faction-raid-combat
- Depends on: ['16.9 PVE COMBAT']
- Feeds into: ['16.12 COMBAT LOGIC FLOW']
- Related: ['16.9 PVE COMBAT', '16.12 COMBAT LOGIC FLOW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 16.12 COMBAT LOGIC FLOW
- Anchor: 16-12-combat-logic-flow
- Depends on: ['16.11 FACTION RAID COMBAT']
- Feeds into: ['CHUNK 18 — CRIME SYSTEM ULTRA-DETAILED BOOK (20 PATHS)']
- Related: ['16.11 FACTION RAID COMBAT', 'CHUNK 18 — CRIME SYSTEM ULTRA-DETAILED BOOK (20 PATHS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 18 — CRIME SYSTEM ULTRA-DETAILED BOOK (20 PATHS)
- Anchor: chunk-18-crime-system-ultra-detailed-book-20-paths
- Depends on: ['16.12 COMBAT LOGIC FLOW']
- Feeds into: ['18.1 CRIME SYSTEM OVERVIEW']
- Related: ['16.12 COMBAT LOGIC FLOW', '18.1 CRIME SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 18.1 CRIME SYSTEM OVERVIEW
- Anchor: 18-1-crime-system-overview
- Depends on: ['CHUNK 18 — CRIME SYSTEM ULTRA-DETAILED BOOK (20 PATHS)']
- Feeds into: ['18.2 GLOBAL CRIME FORMULAS']
- Related: ['CHUNK 18 — CRIME SYSTEM ULTRA-DETAILED BOOK (20 PATHS)', '18.2 GLOBAL CRIME FORMULAS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 18.2 GLOBAL CRIME FORMULAS
- Anchor: 18-2-global-crime-formulas
- Depends on: ['18.1 CRIME SYSTEM OVERVIEW']
- Feeds into: ['18.3 CRIME PATH LIST (FULL)']
- Related: ['18.1 CRIME SYSTEM OVERVIEW', '18.3 CRIME PATH LIST (FULL)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 18.3 CRIME PATH LIST (FULL)
- Anchor: 18-3-crime-path-list-full
- Depends on: ['18.2 GLOBAL CRIME FORMULAS']
- Feeds into: ['18.4 FULL DETAILS FOR EACH CRIME PATH']
- Related: ['18.2 GLOBAL CRIME FORMULAS', '18.4 FULL DETAILS FOR EACH CRIME PATH', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 18.4 FULL DETAILS FOR EACH CRIME PATH
- Anchor: 18-4-full-details-for-each-crime-path
- Depends on: ['18.3 CRIME PATH LIST (FULL)']
- Feeds into: ['PATH 2 — SHOPLIFTING & RETAIL CRIME']
- Related: ['18.3 CRIME PATH LIST (FULL)', 'PATH 2 — SHOPLIFTING & RETAIL CRIME', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 2 — SHOPLIFTING & RETAIL CRIME
- Anchor: path-2-shoplifting-retail-crime
- Depends on: ['18.4 FULL DETAILS FOR EACH CRIME PATH']
- Feeds into: ['PATH 3 — FRAUD & IDENTITY CRIME']
- Related: ['18.4 FULL DETAILS FOR EACH CRIME PATH', 'PATH 3 — FRAUD & IDENTITY CRIME', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 3 — FRAUD & IDENTITY CRIME
- Anchor: path-3-fraud-identity-crime
- Depends on: ['PATH 2 — SHOPLIFTING & RETAIL CRIME']
- Feeds into: ['PATH 8 — CYBERCRIME & HACKING']
- Related: ['PATH 2 — SHOPLIFTING & RETAIL CRIME', 'PATH 8 — CYBERCRIME & HACKING', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 8 — CYBERCRIME & HACKING
- Anchor: path-8-cybercrime-hacking
- Depends on: ['PATH 3 — FRAUD & IDENTITY CRIME']
- Feeds into: ['PATH 19 — UNDERGROUND TRANSPORT (TUBE CRIME)']
- Related: ['PATH 3 — FRAUD & IDENTITY CRIME', 'PATH 19 — UNDERGROUND TRANSPORT (TUBE CRIME)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 19 — UNDERGROUND TRANSPORT (TUBE CRIME)
- Anchor: path-19-underground-transport-tube-crime
- Depends on: ['PATH 8 — CYBERCRIME & HACKING']
- Feeds into: ['PATH 20 — PRISON CRIME PATH']
- Related: ['PATH 8 — CYBERCRIME & HACKING', 'PATH 20 — PRISON CRIME PATH', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## PATH 20 — PRISON CRIME PATH
- Anchor: path-20-prison-crime-path
- Depends on: ['PATH 19 — UNDERGROUND TRANSPORT (TUBE CRIME)']
- Feeds into: ['**Crime Chains**']
- Related: ['PATH 19 — UNDERGROUND TRANSPORT (TUBE CRIME)', '**Crime Chains**', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Crime Chains**
- Anchor: crime-chains
- Depends on: ['PATH 20 — PRISON CRIME PATH']
- Feeds into: ['CHUNK 20 — MISSIONS SYSTEM EXPANSION (NARRATIVE, GENERATORS, NPC RELATIONSHIPS)']
- Related: ['PATH 20 — PRISON CRIME PATH', 'CHUNK 20 — MISSIONS SYSTEM EXPANSION (NARRATIVE, GENERATORS, NPC RELATIONSHIPS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 20 — MISSIONS SYSTEM EXPANSION (NARRATIVE, GENERATORS, NPC RELATIONSHIPS)
- Anchor: chunk-20-missions-system-expansion-narrative-generators-npc-relationships
- Depends on: ['**Crime Chains**']
- Feeds into: ['20.4 NPC RELATIONSHIP MATRIX']
- Related: ['**Crime Chains**', '20.4 NPC RELATIONSHIP MATRIX', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 20.4 NPC RELATIONSHIP MATRIX
- Anchor: 20-4-npc-relationship-matrix
- Depends on: ['CHUNK 20 — MISSIONS SYSTEM EXPANSION (NARRATIVE, GENERATORS, NPC RELATIONSHIPS)']
- Feeds into: ['21.10 CRIME MODIFIERS BY BOROUGH']
- Related: ['CHUNK 20 — MISSIONS SYSTEM EXPANSION (NARRATIVE, GENERATORS, NPC RELATIONSHIPS)', '21.10 CRIME MODIFIERS BY BOROUGH', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 21.10 CRIME MODIFIERS BY BOROUGH
- Anchor: 21-10-crime-modifiers-by-borough
- Depends on: ['20.4 NPC RELATIONSHIP MATRIX']
- Feeds into: ['CHUNK 23 — PROPERTIES & HOUSING SYSTEM (UPGRADES, ROOMS, SECURITY, STAFF)']
- Related: ['20.4 NPC RELATIONSHIP MATRIX', 'CHUNK 23 — PROPERTIES & HOUSING SYSTEM (UPGRADES, ROOMS, SECURITY, STAFF)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 23 — PROPERTIES & HOUSING SYSTEM (UPGRADES, ROOMS, SECURITY, STAFF)
- Anchor: chunk-23-properties-housing-system-upgrades-rooms-security-staff
- Depends on: ['21.10 CRIME MODIFIERS BY BOROUGH']
- Feeds into: ['23.6 NPC STAFF SYSTEM']
- Related: ['21.10 CRIME MODIFIERS BY BOROUGH', '23.6 NPC STAFF SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.6 NPC STAFF SYSTEM
- Anchor: 23-6-npc-staff-system
- Depends on: ['CHUNK 23 — PROPERTIES & HOUSING SYSTEM (UPGRADES, ROOMS, SECURITY, STAFF)']
- Feeds into: ['23.8 PROPERTY ECONOMY']
- Related: ['CHUNK 23 — PROPERTIES & HOUSING SYSTEM (UPGRADES, ROOMS, SECURITY, STAFF)', '23.8 PROPERTY ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 23.8 PROPERTY ECONOMY
- Anchor: 23-8-property-economy
- Depends on: ['23.6 NPC STAFF SYSTEM']
- Feeds into: ['CHUNK 24 — COMPANIES & JOBS SYSTEM (ECONOMY, RANKS, OWNERSHIP, NPC STAFF)']
- Related: ['23.6 NPC STAFF SYSTEM', 'CHUNK 24 — COMPANIES & JOBS SYSTEM (ECONOMY, RANKS, OWNERSHIP, NPC STAFF)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 24 — COMPANIES & JOBS SYSTEM (ECONOMY, RANKS, OWNERSHIP, NPC STAFF)
- Anchor: chunk-24-companies-jobs-system-economy-ranks-ownership-npc-staff
- Depends on: ['23.8 PROPERTY ECONOMY']
- Feeds into: ['24.5 EMPLOYEE SYSTEM (PLAYERS + NPCS)']
- Related: ['23.8 PROPERTY ECONOMY', '24.5 EMPLOYEE SYSTEM (PLAYERS + NPCS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 24.5 EMPLOYEE SYSTEM (PLAYERS + NPCS)
- Anchor: 24-5-employee-system-players-npcs
- Depends on: ['CHUNK 24 — COMPANIES & JOBS SYSTEM (ECONOMY, RANKS, OWNERSHIP, NPC STAFF)']
- Feeds into: ['NPC Employees:']
- Related: ['CHUNK 24 — COMPANIES & JOBS SYSTEM (ECONOMY, RANKS, OWNERSHIP, NPC STAFF)', 'NPC Employees:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## NPC Employees:
- Anchor: npc-employees
- Depends on: ['24.5 EMPLOYEE SYSTEM (PLAYERS + NPCS)']
- Feeds into: ['25.7 BLACK MARKET NPCS']
- Related: ['24.5 EMPLOYEE SYSTEM (PLAYERS + NPCS)', '25.7 BLACK MARKET NPCS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.7 BLACK MARKET NPCS
- Anchor: 25-7-black-market-npcs
- Depends on: ['NPC Employees:']
- Feeds into: ['CHUNK 27 — STOCK MARKET, POINTS MARKET & GLOBAL ECONOMY SYSTEM']
- Related: ['NPC Employees:', 'CHUNK 27 — STOCK MARKET, POINTS MARKET & GLOBAL ECONOMY SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 27 — STOCK MARKET, POINTS MARKET & GLOBAL ECONOMY SYSTEM
- Anchor: chunk-27-stock-market-points-market-global-economy-system
- Depends on: ['25.7 BLACK MARKET NPCS']
- Feeds into: ['27.1 GLOBAL ECONOMY OVERVIEW']
- Related: ['25.7 BLACK MARKET NPCS', '27.1 GLOBAL ECONOMY OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.1 GLOBAL ECONOMY OVERVIEW
- Anchor: 27-1-global-economy-overview
- Depends on: ['CHUNK 27 — STOCK MARKET, POINTS MARKET & GLOBAL ECONOMY SYSTEM']
- Feeds into: ['27.9 FUTURES, OPTIONS & BONDS (ENDGAME ECONOMY)']
- Related: ['CHUNK 27 — STOCK MARKET, POINTS MARKET & GLOBAL ECONOMY SYSTEM', '27.9 FUTURES, OPTIONS & BONDS (ENDGAME ECONOMY)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.9 FUTURES, OPTIONS & BONDS (ENDGAME ECONOMY)
- Anchor: 27-9-futures-options-bonds-endgame-economy
- Depends on: ['27.1 GLOBAL ECONOMY OVERVIEW']
- Feeds into: ['27.10 AI DIRECTOR ECONOMY CONTROL']
- Related: ['27.1 GLOBAL ECONOMY OVERVIEW', '27.10 AI DIRECTOR ECONOMY CONTROL', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.10 AI DIRECTOR ECONOMY CONTROL
- Anchor: 27-10-ai-director-economy-control
- Depends on: ['27.9 FUTURES, OPTIONS & BONDS (ENDGAME ECONOMY)']
- Feeds into: ['27.11 ECONOMY ANTI-EXPLOIT SYSTEM']
- Related: ['27.9 FUTURES, OPTIONS & BONDS (ENDGAME ECONOMY)', '27.11 ECONOMY ANTI-EXPLOIT SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 27.11 ECONOMY ANTI-EXPLOIT SYSTEM
- Anchor: 27-11-economy-anti-exploit-system
- Depends on: ['27.10 AI DIRECTOR ECONOMY CONTROL']
- Feeds into: ['CHUNK 29 — NPC SYSTEM (AI BEHAVIOUR, GANGS, BOSSES, ECONOMY ROLES)']
- Related: ['27.10 AI DIRECTOR ECONOMY CONTROL', 'CHUNK 29 — NPC SYSTEM (AI BEHAVIOUR, GANGS, BOSSES, ECONOMY ROLES)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 29 — NPC SYSTEM (AI BEHAVIOUR, GANGS, BOSSES, ECONOMY ROLES)
- Anchor: chunk-29-npc-system-ai-behaviour-gangs-bosses-economy-roles
- Depends on: ['27.11 ECONOMY ANTI-EXPLOIT SYSTEM']
- Feeds into: ['29.1 NPC SYSTEM OVERVIEW']
- Related: ['27.11 ECONOMY ANTI-EXPLOIT SYSTEM', '29.1 NPC SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.1 NPC SYSTEM OVERVIEW
- Anchor: 29-1-npc-system-overview
- Depends on: ['CHUNK 29 — NPC SYSTEM (AI BEHAVIOUR, GANGS, BOSSES, ECONOMY ROLES)']
- Feeds into: ['29.2 NPC TYPES (FULL LIST)']
- Related: ['CHUNK 29 — NPC SYSTEM (AI BEHAVIOUR, GANGS, BOSSES, ECONOMY ROLES)', '29.2 NPC TYPES (FULL LIST)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.2 NPC TYPES (FULL LIST)
- Anchor: 29-2-npc-types-full-list
- Depends on: ['29.1 NPC SYSTEM OVERVIEW']
- Feeds into: ['Civilian NPCs']
- Related: ['29.1 NPC SYSTEM OVERVIEW', 'Civilian NPCs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Civilian NPCs
- Anchor: civilian-npcs
- Depends on: ['29.2 NPC TYPES (FULL LIST)']
- Feeds into: ['Criminal NPCs']
- Related: ['29.2 NPC TYPES (FULL LIST)', 'Criminal NPCs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Criminal NPCs
- Anchor: criminal-npcs
- Depends on: ['Civilian NPCs']
- Feeds into: ['Gang NPCs']
- Related: ['Civilian NPCs', 'Gang NPCs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Gang NPCs
- Anchor: gang-npcs
- Depends on: ['Criminal NPCs']
- Feeds into: ['Law Enforcement NPCs']
- Related: ['Criminal NPCs', 'Law Enforcement NPCs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Law Enforcement NPCs
- Anchor: law-enforcement-npcs
- Depends on: ['Gang NPCs']
- Feeds into: ['Syndicate NPCs']
- Related: ['Gang NPCs', 'Syndicate NPCs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Syndicate NPCs
- Anchor: syndicate-npcs
- Depends on: ['Law Enforcement NPCs']
- Feeds into: ['Economy NPCs']
- Related: ['Law Enforcement NPCs', 'Economy NPCs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Economy NPCs
- Anchor: economy-npcs
- Depends on: ['Syndicate NPCs']
- Feeds into: ['29.3 NPC PERSONALITY & STATS']
- Related: ['Syndicate NPCs', '29.3 NPC PERSONALITY & STATS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.3 NPC PERSONALITY & STATS
- Anchor: 29-3-npc-personality-stats
- Depends on: ['Economy NPCs']
- Feeds into: ['29.4 NPC BEHAVIOUR SYSTEM']
- Related: ['Economy NPCs', '29.4 NPC BEHAVIOUR SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.4 NPC BEHAVIOUR SYSTEM
- Anchor: 29-4-npc-behaviour-system
- Depends on: ['29.3 NPC PERSONALITY & STATS']
- Feeds into: ['29.5 NPC SCHEDULE & PATHING SYSTEM']
- Related: ['29.3 NPC PERSONALITY & STATS', '29.5 NPC SCHEDULE & PATHING SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.5 NPC SCHEDULE & PATHING SYSTEM
- Anchor: 29-5-npc-schedule-pathing-system
- Depends on: ['29.4 NPC BEHAVIOUR SYSTEM']
- Feeds into: ['29.6 NPC RELATIONSHIP MATRIX']
- Related: ['29.4 NPC BEHAVIOUR SYSTEM', '29.6 NPC RELATIONSHIP MATRIX', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.6 NPC RELATIONSHIP MATRIX
- Anchor: 29-6-npc-relationship-matrix
- Depends on: ['29.5 NPC SCHEDULE & PATHING SYSTEM']
- Feeds into: ['29.7 NPC GANGS SYSTEM']
- Related: ['29.5 NPC SCHEDULE & PATHING SYSTEM', '29.7 NPC GANGS SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.7 NPC GANGS SYSTEM
- Anchor: 29-7-npc-gangs-system
- Depends on: ['29.6 NPC RELATIONSHIP MATRIX']
- Feeds into: ['29.8 NPC BOSSES (ELITE ENCOUNTERS)']
- Related: ['29.6 NPC RELATIONSHIP MATRIX', '29.8 NPC BOSSES (ELITE ENCOUNTERS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.8 NPC BOSSES (ELITE ENCOUNTERS)
- Anchor: 29-8-npc-bosses-elite-encounters
- Depends on: ['29.7 NPC GANGS SYSTEM']
- Feeds into: ['29.9 NPC ECONOMIC ROLES']
- Related: ['29.7 NPC GANGS SYSTEM', '29.9 NPC ECONOMIC ROLES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.9 NPC ECONOMIC ROLES
- Anchor: 29-9-npc-economic-roles
- Depends on: ['29.8 NPC BOSSES (ELITE ENCOUNTERS)']
- Feeds into: ['29.10 NPC WORLD SIMULATION']
- Related: ['29.8 NPC BOSSES (ELITE ENCOUNTERS)', '29.10 NPC WORLD SIMULATION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.10 NPC WORLD SIMULATION
- Anchor: 29-10-npc-world-simulation
- Depends on: ['29.9 NPC ECONOMIC ROLES']
- Feeds into: ['29.11 AI DIRECTOR NPC CONTROL']
- Related: ['29.9 NPC ECONOMIC ROLES', '29.11 AI DIRECTOR NPC CONTROL', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.11 AI DIRECTOR NPC CONTROL
- Anchor: 29-11-ai-director-npc-control
- Depends on: ['29.10 NPC WORLD SIMULATION']
- Feeds into: ['29.12 NPC ANTI-EXPLOIT SYSTEM']
- Related: ['29.10 NPC WORLD SIMULATION', '29.12 NPC ANTI-EXPLOIT SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.12 NPC ANTI-EXPLOIT SYSTEM
- Anchor: 29-12-npc-anti-exploit-system
- Depends on: ['29.11 AI DIRECTOR NPC CONTROL']
- Feeds into: ['30.6 CRIME ZONES & HOTSPOTS']
- Related: ['29.11 AI DIRECTOR NPC CONTROL', '30.6 CRIME ZONES & HOTSPOTS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 30.6 CRIME ZONES & HOTSPOTS
- Anchor: 30-6-crime-zones-hotspots
- Depends on: ['29.12 NPC ANTI-EXPLOIT SYSTEM']
- Feeds into: ['CHUNK 33 — COMBAT SYSTEM (PVE, PVP, BOSSES, STATUS EFFECTS, TURN ENGINE)']
- Related: ['29.12 NPC ANTI-EXPLOIT SYSTEM', 'CHUNK 33 — COMBAT SYSTEM (PVE, PVP, BOSSES, STATUS EFFECTS, TURN ENGINE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 33 — COMBAT SYSTEM (PVE, PVP, BOSSES, STATUS EFFECTS, TURN ENGINE)
- Anchor: chunk-33-combat-system-pve-pvp-bosses-status-effects-turn-engine
- Depends on: ['30.6 CRIME ZONES & HOTSPOTS']
- Feeds into: ['33.1 COMBAT SYSTEM OVERVIEW']
- Related: ['30.6 CRIME ZONES & HOTSPOTS', '33.1 COMBAT SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.1 COMBAT SYSTEM OVERVIEW
- Anchor: 33-1-combat-system-overview
- Depends on: ['CHUNK 33 — COMBAT SYSTEM (PVE, PVP, BOSSES, STATUS EFFECTS, TURN ENGINE)']
- Feeds into: ['33.2 COMBAT MODES']
- Related: ['CHUNK 33 — COMBAT SYSTEM (PVE, PVP, BOSSES, STATUS EFFECTS, TURN ENGINE)', '33.2 COMBAT MODES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.2 COMBAT MODES
- Anchor: 33-2-combat-modes
- Depends on: ['33.1 COMBAT SYSTEM OVERVIEW']
- Feeds into: ['**PvE Combat**']
- Related: ['33.1 COMBAT SYSTEM OVERVIEW', '**PvE Combat**', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **PvE Combat**
- Anchor: pve-combat
- Depends on: ['33.2 COMBAT MODES']
- Feeds into: ['**PvP Combat**']
- Related: ['33.2 COMBAT MODES', '**PvP Combat**', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **PvP Combat**
- Anchor: pvp-combat
- Depends on: ['**PvE Combat**']
- Feeds into: ['**Faction Combat**']
- Related: ['**PvE Combat**', '**Faction Combat**', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Faction Combat**
- Anchor: faction-combat
- Depends on: ['**PvP Combat**']
- Feeds into: ['**Boss Combat**']
- Related: ['**PvP Combat**', '**Boss Combat**', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## **Boss Combat**
- Anchor: boss-combat
- Depends on: ['**Faction Combat**']
- Feeds into: ['33.3 TURN ENGINE (CORE MECHANICS)']
- Related: ['**Faction Combat**', '33.3 TURN ENGINE (CORE MECHANICS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.3 TURN ENGINE (CORE MECHANICS)
- Anchor: 33-3-turn-engine-core-mechanics
- Depends on: ['**Boss Combat**']
- Feeds into: ['33.4 COMBAT STATS']
- Related: ['**Boss Combat**', '33.4 COMBAT STATS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.4 COMBAT STATS
- Anchor: 33-4-combat-stats
- Depends on: ['33.3 TURN ENGINE (CORE MECHANICS)']
- Feeds into: ['33.9 BOSS COMBAT FRAMEWORK']
- Related: ['33.3 TURN ENGINE (CORE MECHANICS)', '33.9 BOSS COMBAT FRAMEWORK', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.9 BOSS COMBAT FRAMEWORK
- Anchor: 33-9-boss-combat-framework
- Depends on: ['33.4 COMBAT STATS']
- Feeds into: ['33.10 AI COMBAT ENGINE']
- Related: ['33.4 COMBAT STATS', '33.10 AI COMBAT ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.10 AI COMBAT ENGINE
- Anchor: 33-10-ai-combat-engine
- Depends on: ['33.9 BOSS COMBAT FRAMEWORK']
- Feeds into: ['33.11 COMBAT REWARD SYSTEM']
- Related: ['33.9 BOSS COMBAT FRAMEWORK', '33.11 COMBAT REWARD SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.11 COMBAT REWARD SYSTEM
- Anchor: 33-11-combat-reward-system
- Depends on: ['33.10 AI COMBAT ENGINE']
- Feeds into: ['33.12 COMBAT ANTI-EXPLOIT LOGIC']
- Related: ['33.10 AI COMBAT ENGINE', '33.12 COMBAT ANTI-EXPLOIT LOGIC', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 33.12 COMBAT ANTI-EXPLOIT LOGIC
- Anchor: 33-12-combat-anti-exploit-logic
- Depends on: ['33.11 COMBAT REWARD SYSTEM']
- Feeds into: ['CHUNK 34 — CRIMES SYSTEM (20 CRIME PATHS + SUB-CRIMES + RISK + HEAT)']
- Related: ['33.11 COMBAT REWARD SYSTEM', 'CHUNK 34 — CRIMES SYSTEM (20 CRIME PATHS + SUB-CRIMES + RISK + HEAT)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 34 — CRIMES SYSTEM (20 CRIME PATHS + SUB-CRIMES + RISK + HEAT)
- Anchor: chunk-34-crimes-system-20-crime-paths-sub-crimes-risk-heat
- Depends on: ['33.12 COMBAT ANTI-EXPLOIT LOGIC']
- Feeds into: ['34.1 CRIME SYSTEM OVERVIEW']
- Related: ['33.12 COMBAT ANTI-EXPLOIT LOGIC', '34.1 CRIME SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.1 CRIME SYSTEM OVERVIEW
- Anchor: 34-1-crime-system-overview
- Depends on: ['CHUNK 34 — CRIMES SYSTEM (20 CRIME PATHS + SUB-CRIMES + RISK + HEAT)']
- Feeds into: ['34.2 THE 20 CRIME PATHS (FULL LIST)']
- Related: ['CHUNK 34 — CRIMES SYSTEM (20 CRIME PATHS + SUB-CRIMES + RISK + HEAT)', '34.2 THE 20 CRIME PATHS (FULL LIST)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.2 THE 20 CRIME PATHS (FULL LIST)
- Anchor: 34-2-the-20-crime-paths-full-list
- Depends on: ['34.1 CRIME SYSTEM OVERVIEW']
- Feeds into: ['34.3 CRIME PATH DETAILS & SUB-CRIMES']
- Related: ['34.1 CRIME SYSTEM OVERVIEW', '34.3 CRIME PATH DETAILS & SUB-CRIMES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.3 CRIME PATH DETAILS & SUB-CRIMES
- Anchor: 34-3-crime-path-details-sub-crimes
- Depends on: ['34.2 THE 20 CRIME PATHS (FULL LIST)']
- Feeds into: ['9. Fraud & Cybercrime']
- Related: ['34.2 THE 20 CRIME PATHS (FULL LIST)', '9. Fraud & Cybercrime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 9. Fraud & Cybercrime
- Anchor: 9-fraud-cybercrime
- Depends on: ['34.3 CRIME PATH DETAILS & SUB-CRIMES']
- Feeds into: ['11. Assault & Violent Crime']
- Related: ['34.3 CRIME PATH DETAILS & SUB-CRIMES', '11. Assault & Violent Crime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 11. Assault & Violent Crime
- Anchor: 11-assault-violent-crime
- Depends on: ['9. Fraud & Cybercrime']
- Feeds into: ['19. High-End Theft / Artifact Crime']
- Related: ['9. Fraud & Cybercrime', '19. High-End Theft / Artifact Crime', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19. High-End Theft / Artifact Crime
- Anchor: 19-high-end-theft-artifact-crime
- Depends on: ['11. Assault & Violent Crime']
- Feeds into: ['20. Elite Crime Ops (Endgame)']
- Related: ['11. Assault & Violent Crime', '20. Elite Crime Ops (Endgame)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 20. Elite Crime Ops (Endgame)
- Anchor: 20-elite-crime-ops-endgame
- Depends on: ['19. High-End Theft / Artifact Crime']
- Feeds into: ['34.4 CRIME SUCCESS CALCULATION']
- Related: ['19. High-End Theft / Artifact Crime', '34.4 CRIME SUCCESS CALCULATION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.4 CRIME SUCCESS CALCULATION
- Anchor: 34-4-crime-success-calculation
- Depends on: ['20. Elite Crime Ops (Endgame)']
- Feeds into: ['34.5 HEAT & WANTED SYSTEM FOR CRIMES']
- Related: ['20. Elite Crime Ops (Endgame)', '34.5 HEAT & WANTED SYSTEM FOR CRIMES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.5 HEAT & WANTED SYSTEM FOR CRIMES
- Anchor: 34-5-heat-wanted-system-for-crimes
- Depends on: ['34.4 CRIME SUCCESS CALCULATION']
- Feeds into: ['34.6 CRIME XP TREES & MASTERY']
- Related: ['34.4 CRIME SUCCESS CALCULATION', '34.6 CRIME XP TREES & MASTERY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.6 CRIME XP TREES & MASTERY
- Anchor: 34-6-crime-xp-trees-mastery
- Depends on: ['34.5 HEAT & WANTED SYSTEM FOR CRIMES']
- Feeds into: ['34.7 CRIME REWARDS']
- Related: ['34.5 HEAT & WANTED SYSTEM FOR CRIMES', '34.7 CRIME REWARDS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.7 CRIME REWARDS
- Anchor: 34-7-crime-rewards
- Depends on: ['34.6 CRIME XP TREES & MASTERY']
- Feeds into: ['34.8 AI DIRECTOR CRIME CONTROL']
- Related: ['34.6 CRIME XP TREES & MASTERY', '34.8 AI DIRECTOR CRIME CONTROL', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.8 AI DIRECTOR CRIME CONTROL
- Anchor: 34-8-ai-director-crime-control
- Depends on: ['34.7 CRIME REWARDS']
- Feeds into: ['34.9 CRIME ANTI-EXPLOIT SYSTEM']
- Related: ['34.7 CRIME REWARDS', '34.9 CRIME ANTI-EXPLOIT SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 34.9 CRIME ANTI-EXPLOIT SYSTEM
- Anchor: 34-9-crime-anti-exploit-system
- Depends on: ['34.8 AI DIRECTOR CRIME CONTROL']
- Feeds into: ['35.11 ITEM ECONOMY & MARKET INFLUENCE']
- Related: ['34.8 AI DIRECTOR CRIME CONTROL', '35.11 ITEM ECONOMY & MARKET INFLUENCE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 35.11 ITEM ECONOMY & MARKET INFLUENCE
- Anchor: 35-11-item-economy-market-influence
- Depends on: ['34.9 CRIME ANTI-EXPLOIT SYSTEM']
- Feeds into: ['36.10 COMBAT INTEGRATION (ADVANCED)']
- Related: ['34.9 CRIME ANTI-EXPLOIT SYSTEM', '36.10 COMBAT INTEGRATION (ADVANCED)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 36.10 COMBAT INTEGRATION (ADVANCED)
- Anchor: 36-10-combat-integration-advanced
- Depends on: ['35.11 ITEM ECONOMY & MARKET INFLUENCE']
- Feeds into: ['36.11 WEAPON & ARMOUR ECONOMY']
- Related: ['35.11 ITEM ECONOMY & MARKET INFLUENCE', '36.11 WEAPON & ARMOUR ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 36.11 WEAPON & ARMOUR ECONOMY
- Anchor: 36-11-weapon-armour-economy
- Depends on: ['36.10 COMBAT INTEGRATION (ADVANCED)']
- Feeds into: ['Player vs NPC Raids:']
- Related: ['36.10 COMBAT INTEGRATION (ADVANCED)', 'Player vs NPC Raids:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Player vs NPC Raids:
- Anchor: player-vs-npc-raids
- Depends on: ['36.11 WEAPON & ARMOUR ECONOMY']
- Feeds into: ['37.12 FACTION ECONOMY SYSTEM']
- Related: ['36.11 WEAPON & ARMOUR ECONOMY', '37.12 FACTION ECONOMY SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 37.12 FACTION ECONOMY SYSTEM
- Anchor: 37-12-faction-economy-system
- Depends on: ['Player vs NPC Raids:']
- Feeds into: ['38.3 PROPERTY CORE STATS']
- Related: ['Player vs NPC Raids:', '38.3 PROPERTY CORE STATS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.3 PROPERTY CORE STATS
- Anchor: 38-3-property-core-stats
- Depends on: ['37.12 FACTION ECONOMY SYSTEM']
- Feeds into: ['Combat/Defence Rooms']
- Related: ['37.12 FACTION ECONOMY SYSTEM', 'Combat/Defence Rooms', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Combat/Defence Rooms
- Anchor: combat-defence-rooms
- Depends on: ['38.3 PROPERTY CORE STATS']
- Feeds into: ['38.9 PROPERTY ECONOMY']
- Related: ['38.3 PROPERTY CORE STATS', '38.9 PROPERTY ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38.9 PROPERTY ECONOMY
- Anchor: 38-9-property-economy
- Depends on: ['Combat/Defence Rooms']
- Feeds into: ['CHUNK 39 — HOUSING INTERIORS, DECORATION & PRESTIGE SYSTEM']
- Related: ['Combat/Defence Rooms', 'CHUNK 39 — HOUSING INTERIORS, DECORATION & PRESTIGE SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 39 — HOUSING INTERIORS, DECORATION & PRESTIGE SYSTEM
- Anchor: chunk-39-housing-interiors-decoration-prestige-system
- Depends on: ['38.9 PROPERTY ECONOMY']
- Feeds into: ['39.9 INTERIOR ECONOMY']
- Related: ['38.9 PROPERTY ECONOMY', '39.9 INTERIOR ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 39.9 INTERIOR ECONOMY
- Anchor: 39-9-interior-economy
- Depends on: ['CHUNK 39 — HOUSING INTERIORS, DECORATION & PRESTIGE SYSTEM']
- Feeds into: ['Tactical Combat Drills']
- Related: ['CHUNK 39 — HOUSING INTERIORS, DECORATION & PRESTIGE SYSTEM', 'Tactical Combat Drills', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Tactical Combat Drills
- Anchor: tactical-combat-drills
- Depends on: ['39.9 INTERIOR ECONOMY']
- Feeds into: ['Temp Crime Jobs']
- Related: ['39.9 INTERIOR ECONOMY', 'Temp Crime Jobs', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Temp Crime Jobs
- Anchor: temp-crime-jobs
- Depends on: ['Tactical Combat Drills']
- Feeds into: ['Crime Achievements']
- Related: ['Tactical Combat Drills', 'Crime Achievements', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Crime Achievements
- Anchor: crime-achievements
- Depends on: ['Temp Crime Jobs']
- Feeds into: ['Combat Achievements']
- Related: ['Temp Crime Jobs', 'Combat Achievements', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Combat Achievements
- Anchor: combat-achievements
- Depends on: ['Crime Achievements']
- Feeds into: ['Core Dashboard Tools:']
- Related: ['Crime Achievements', 'Core Dashboard Tools:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Core Dashboard Tools:
- Anchor: core-dashboard-tools
- Depends on: ['Combat Achievements']
- Feeds into: ['Economy Tools:']
- Related: ['Combat Achievements', 'Economy Tools:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Economy Tools:
- Anchor: economy-tools
- Depends on: ['Core Dashboard Tools:']
- Feeds into: ['Economy Logs:']
- Related: ['Core Dashboard Tools:', 'Economy Logs:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Economy Logs:
- Anchor: economy-logs
- Depends on: ['Economy Tools:']
- Feeds into: ['Combat Validation:']
- Related: ['Economy Tools:', 'Combat Validation:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Combat Validation:
- Anchor: combat-validation
- Depends on: ['Economy Logs:']
- Feeds into: ['CHUNK 47 — NPC SYSTEM, CIVILIANS, GANGS, BOSSES, AI BEHAVIOURS & WORLD POPULATION']
- Related: ['Economy Logs:', 'CHUNK 47 — NPC SYSTEM, CIVILIANS, GANGS, BOSSES, AI BEHAVIOURS & WORLD POPULATION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## CHUNK 47 — NPC SYSTEM, CIVILIANS, GANGS, BOSSES, AI BEHAVIOURS & WORLD POPULATION
- Anchor: chunk-47-npc-system-civilians-gangs-bosses-ai-behaviours-world-population
- Depends on: ['Combat Validation:']
- Feeds into: ['47.1 NPC SYSTEM OVERVIEW']
- Related: ['Combat Validation:', '47.1 NPC SYSTEM OVERVIEW', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.1 NPC SYSTEM OVERVIEW
- Anchor: 47-1-npc-system-overview
- Depends on: ['CHUNK 47 — NPC SYSTEM, CIVILIANS, GANGS, BOSSES, AI BEHAVIOURS & WORLD POPULATION']
- Feeds into: ['47.2 CIVILIAN NPCS']
- Related: ['CHUNK 47 — NPC SYSTEM, CIVILIANS, GANGS, BOSSES, AI BEHAVIOURS & WORLD POPULATION', '47.2 CIVILIAN NPCS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.2 CIVILIAN NPCS
- Anchor: 47-2-civilian-npcs
- Depends on: ['47.1 NPC SYSTEM OVERVIEW']
- Feeds into: ['47.3 CRIMINAL NPCS']
- Related: ['47.1 NPC SYSTEM OVERVIEW', '47.3 CRIMINAL NPCS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.3 CRIMINAL NPCS
- Anchor: 47-3-criminal-npcs
- Depends on: ['47.2 CIVILIAN NPCS']
- Feeds into: ['47.4 POLICE NPCS']
- Related: ['47.2 CIVILIAN NPCS', '47.4 POLICE NPCS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.4 POLICE NPCS
- Anchor: 47-4-police-npcs
- Depends on: ['47.3 CRIMINAL NPCS']
- Feeds into: ['47.5 SPECIAL SYNDICATE NPCS']
- Related: ['47.3 CRIMINAL NPCS', '47.5 SPECIAL SYNDICATE NPCS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.5 SPECIAL SYNDICATE NPCS
- Anchor: 47-5-special-syndicate-npcs
- Depends on: ['47.4 POLICE NPCS']
- Feeds into: ['47.6 BOSS NPCS']
- Related: ['47.4 POLICE NPCS', '47.6 BOSS NPCS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.6 BOSS NPCS
- Anchor: 47-6-boss-npcs
- Depends on: ['47.5 SPECIAL SYNDICATE NPCS']
- Feeds into: ['47.7 NPC AI BEHAVIOURS']
- Related: ['47.5 SPECIAL SYNDICATE NPCS', '47.7 NPC AI BEHAVIOURS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.7 NPC AI BEHAVIOURS
- Anchor: 47-7-npc-ai-behaviours
- Depends on: ['47.6 BOSS NPCS']
- Feeds into: ['Core AI Systems:']
- Related: ['47.6 BOSS NPCS', 'Core AI Systems:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Core AI Systems:
- Anchor: core-ai-systems
- Depends on: ['47.7 NPC AI BEHAVIOURS']
- Feeds into: ['Combat AI:']
- Related: ['47.7 NPC AI BEHAVIOURS', 'Combat AI:', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Combat AI:
- Anchor: combat-ai
- Depends on: ['Core AI Systems:']
- Feeds into: ['47.8 NPC INTEGRATION INTO GAME SYSTEMS']
- Related: ['Core AI Systems:', '47.8 NPC INTEGRATION INTO GAME SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.8 NPC INTEGRATION INTO GAME SYSTEMS
- Anchor: 47-8-npc-integration-into-game-systems
- Depends on: ['Combat AI:']
- Feeds into: ['47.9 NPC SCALING']
- Related: ['Combat AI:', '47.9 NPC SCALING', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.9 NPC SCALING
- Anchor: 47-9-npc-scaling
- Depends on: ['47.8 NPC INTEGRATION INTO GAME SYSTEMS']
- Feeds into: ['47.10 NPC ANTI-EXPLOIT SYSTEM']
- Related: ['47.8 NPC INTEGRATION INTO GAME SYSTEMS', '47.10 NPC ANTI-EXPLOIT SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 47.10 NPC ANTI-EXPLOIT SYSTEM
- Anchor: 47-10-npc-anti-exploit-system
- Depends on: ['47.9 NPC SCALING']
- Feeds into: ['Architect Knowledge Base — Core Document']
- Related: ['47.9 NPC SCALING', 'Architect Knowledge Base — Core Document', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Architect Knowledge Base — Core Document
- Anchor: architect-knowledge-base-core-document
- Depends on: ['47.10 NPC ANTI-EXPLOIT SYSTEM']
- Feeds into: ['4. CRIME SYSTEM — FULL EXTENSION']
- Related: ['47.10 NPC ANTI-EXPLOIT SYSTEM', '4. CRIME SYSTEM — FULL EXTENSION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 4. CRIME SYSTEM — FULL EXTENSION
- Anchor: 4-crime-system-full-extension
- Depends on: ['Architect Knowledge Base — Core Document']
- Feeds into: ['4.1 CRIME MODULES EXTENDED']
- Related: ['Architect Knowledge Base — Core Document', '4.1 CRIME MODULES EXTENDED', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 4.1 CRIME MODULES EXTENDED
- Anchor: 4-1-crime-modules-extended
- Depends on: ['4. CRIME SYSTEM — FULL EXTENSION']
- Feeds into: ['4.2 CRIME OUTCOME MATRIX']
- Related: ['4. CRIME SYSTEM — FULL EXTENSION', '4.2 CRIME OUTCOME MATRIX', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 4.2 CRIME OUTCOME MATRIX
- Anchor: 4-2-crime-outcome-matrix
- Depends on: ['4.1 CRIME MODULES EXTENDED']
- Feeds into: ['5. COMBAT MEGA-EXPANSION']
- Related: ['4.1 CRIME MODULES EXTENDED', '5. COMBAT MEGA-EXPANSION', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 5. COMBAT MEGA-EXPANSION
- Anchor: 5-combat-mega-expansion
- Depends on: ['4.2 CRIME OUTCOME MATRIX']
- Feeds into: ['7.1 MACRO-ECONOMY']
- Related: ['4.2 CRIME OUTCOME MATRIX', '7.1 MACRO-ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.1 MACRO-ECONOMY
- Anchor: 7-1-macro-economy
- Depends on: ['5. COMBAT MEGA-EXPANSION']
- Feeds into: ['7.2 MICRO-ECONOMY']
- Related: ['5. COMBAT MEGA-EXPANSION', '7.2 MICRO-ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 7.2 MICRO-ECONOMY
- Anchor: 7-2-micro-economy
- Depends on: ['7.1 MACRO-ECONOMY']
- Feeds into: ['10. NPC WORLD EVOLUTION ENGINE']
- Related: ['7.1 MACRO-ECONOMY', '10. NPC WORLD EVOLUTION ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 10. NPC WORLD EVOLUTION ENGINE
- Anchor: 10-npc-world-evolution-engine
- Depends on: ['7.2 MICRO-ECONOMY']
- Feeds into: ['17. NPC SYNDICATE SIMULATION LAYER']
- Related: ['7.2 MICRO-ECONOMY', '17. NPC SYNDICATE SIMULATION LAYER', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 17. NPC SYNDICATE SIMULATION LAYER
- Anchor: 17-npc-syndicate-simulation-layer
- Depends on: ['10. NPC WORLD EVOLUTION ENGINE']
- Feeds into: ['19.2 LOYALTY SCORE']
- Related: ['10. NPC WORLD EVOLUTION ENGINE', '19.2 LOYALTY SCORE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 19.2 LOYALTY SCORE
- Anchor: 19-2-loyalty-score
- Depends on: ['17. NPC SYNDICATE SIMULATION LAYER']
- Feeds into: ['20. COMBAT WEATHER + TERRAIN SYSTEM']
- Related: ['17. NPC SYNDICATE SIMULATION LAYER', '20. COMBAT WEATHER + TERRAIN SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 20. COMBAT WEATHER + TERRAIN SYSTEM
- Anchor: 20-combat-weather-terrain-system
- Depends on: ['19.2 LOYALTY SCORE']
- Feeds into: ['24. NPC MEGA-SIMULATION ENGINE (NMSE)']
- Related: ['19.2 LOYALTY SCORE', '24. NPC MEGA-SIMULATION ENGINE (NMSE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 24. NPC MEGA-SIMULATION ENGINE (NMSE)
- Anchor: 24-npc-mega-simulation-engine-nmse
- Depends on: ['20. COMBAT WEATHER + TERRAIN SYSTEM']
- Feeds into: ['24.1 NPC PERSONALITY ARCHETYPES']
- Related: ['20. COMBAT WEATHER + TERRAIN SYSTEM', '24.1 NPC PERSONALITY ARCHETYPES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 24.1 NPC PERSONALITY ARCHETYPES
- Anchor: 24-1-npc-personality-archetypes
- Depends on: ['24. NPC MEGA-SIMULATION ENGINE (NMSE)']
- Feeds into: ['24.2 NPC MEMORY SYSTEM']
- Related: ['24. NPC MEGA-SIMULATION ENGINE (NMSE)', '24.2 NPC MEMORY SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 24.2 NPC MEMORY SYSTEM
- Anchor: 24-2-npc-memory-system
- Depends on: ['24.1 NPC PERSONALITY ARCHETYPES']
- Feeds into: ['25.3 NPC DRIVERS & TRAFFIC']
- Related: ['24.1 NPC PERSONALITY ARCHETYPES', '25.3 NPC DRIVERS & TRAFFIC', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 25.3 NPC DRIVERS & TRAFFIC
- Anchor: 25-3-npc-drivers-traffic
- Depends on: ['24.2 NPC MEMORY SYSTEM']
- Feeds into: ['29. COMBAT STAT SCALING FORMULAS (OVERVIEW)']
- Related: ['24.2 NPC MEMORY SYSTEM', '29. COMBAT STAT SCALING FORMULAS (OVERVIEW)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29. COMBAT STAT SCALING FORMULAS (OVERVIEW)
- Anchor: 29-combat-stat-scaling-formulas-overview
- Depends on: ['25.3 NPC DRIVERS & TRAFFIC']
- Feeds into: ['29.2 COMBAT CURVES']
- Related: ['25.3 NPC DRIVERS & TRAFFIC', '29.2 COMBAT CURVES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 29.2 COMBAT CURVES
- Anchor: 29-2-combat-curves
- Depends on: ['29. COMBAT STAT SCALING FORMULAS (OVERVIEW)']
- Feeds into: ['30. CRIME FORMULA SUPERSTRUCTURE']
- Related: ['29. COMBAT STAT SCALING FORMULAS (OVERVIEW)', '30. CRIME FORMULA SUPERSTRUCTURE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 30. CRIME FORMULA SUPERSTRUCTURE
- Anchor: 30-crime-formula-superstructure
- Depends on: ['29.2 COMBAT CURVES']
- Feeds into: ['31. NPC BOSS GENERATOR ENGINE (NBGE)']
- Related: ['29.2 COMBAT CURVES', '31. NPC BOSS GENERATOR ENGINE (NBGE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31. NPC BOSS GENERATOR ENGINE (NBGE)
- Anchor: 31-npc-boss-generator-engine-nbge
- Depends on: ['30. CRIME FORMULA SUPERSTRUCTURE']
- Feeds into: ['31.1 CORE PROFILE']
- Related: ['30. CRIME FORMULA SUPERSTRUCTURE', '31.1 CORE PROFILE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31.1 CORE PROFILE
- Anchor: 31-1-core-profile
- Depends on: ['31. NPC BOSS GENERATOR ENGINE (NBGE)']
- Feeds into: ['31.2 COMBAT SIGNATURE']
- Related: ['31. NPC BOSS GENERATOR ENGINE (NBGE)', '31.2 COMBAT SIGNATURE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 31.2 COMBAT SIGNATURE
- Anchor: 31-2-combat-signature
- Depends on: ['31.1 CORE PROFILE']
- Feeds into: ['38. COMBAT CALCULATION APPENDIX']
- Related: ['31.1 CORE PROFILE', '38. COMBAT CALCULATION APPENDIX', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 38. COMBAT CALCULATION APPENDIX
- Anchor: 38-combat-calculation-appendix
- Depends on: ['31.2 COMBAT SIGNATURE']
- Feeds into: ['Tier 2 — Public Combatants']
- Related: ['31.2 COMBAT SIGNATURE', 'Tier 2 — Public Combatants', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Tier 2 — Public Combatants
- Anchor: tier-2-public-combatants
- Depends on: ['38. COMBAT CALCULATION APPENDIX']
- Feeds into: ['Tier 3 — NPC Gang Forces']
- Related: ['38. COMBAT CALCULATION APPENDIX', 'Tier 3 — NPC Gang Forces', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## Tier 3 — NPC Gang Forces
- Anchor: tier-3-npc-gang-forces
- Depends on: ['Tier 2 — Public Combatants']
- Feeds into: ['55. CRIME MEGA-TREE: PRESTIGE & INTERNATIONAL']
- Related: ['Tier 2 — Public Combatants', '55. CRIME MEGA-TREE: PRESTIGE & INTERNATIONAL', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 55. CRIME MEGA-TREE: PRESTIGE & INTERNATIONAL
- Anchor: 55-crime-mega-tree-prestige-international
- Depends on: ['Tier 3 — NPC Gang Forces']
- Feeds into: ['55.1 PRESTIGE CRIME MECHANICS']
- Related: ['Tier 3 — NPC Gang Forces', '55.1 PRESTIGE CRIME MECHANICS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 55.1 PRESTIGE CRIME MECHANICS
- Anchor: 55-1-prestige-crime-mechanics
- Depends on: ['55. CRIME MEGA-TREE: PRESTIGE & INTERNATIONAL']
- Feeds into: ['55.2 INTERNATIONAL CRIMES']
- Related: ['55. CRIME MEGA-TREE: PRESTIGE & INTERNATIONAL', '55.2 INTERNATIONAL CRIMES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 55.2 INTERNATIONAL CRIMES
- Anchor: 55-2-international-crimes
- Depends on: ['55.1 PRESTIGE CRIME MECHANICS']
- Feeds into: ['58. NPC RELATIONSHIP ENGINE (NRE)']
- Related: ['55.1 PRESTIGE CRIME MECHANICS', '58. NPC RELATIONSHIP ENGINE (NRE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 58. NPC RELATIONSHIP ENGINE (NRE)
- Anchor: 58-npc-relationship-engine-nre
- Depends on: ['55.2 INTERNATIONAL CRIMES']
- Feeds into: ['58.1 NPC RELATIONSHIP TYPES']
- Related: ['55.2 INTERNATIONAL CRIMES', '58.1 NPC RELATIONSHIP TYPES', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 58.1 NPC RELATIONSHIP TYPES
- Anchor: 58-1-npc-relationship-types
- Depends on: ['58. NPC RELATIONSHIP ENGINE (NRE)']
- Feeds into: ['58.2 NPC EMOTIONAL DRIVERS']
- Related: ['58. NPC RELATIONSHIP ENGINE (NRE)', '58.2 NPC EMOTIONAL DRIVERS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 58.2 NPC EMOTIONAL DRIVERS
- Anchor: 58-2-npc-emotional-drivers
- Depends on: ['58.1 NPC RELATIONSHIP TYPES']
- Feeds into: ['76.1 PLAYER VISIBILITY SCORE (PVS)']
- Related: ['58.1 NPC RELATIONSHIP TYPES', '76.1 PLAYER VISIBILITY SCORE (PVS)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 76.1 PLAYER VISIBILITY SCORE (PVS)
- Anchor: 76-1-player-visibility-score-pvs
- Depends on: ['58.2 NPC EMOTIONAL DRIVERS']
- Feeds into: ['78. CYBERCRIME ENGINE']
- Related: ['58.2 NPC EMOTIONAL DRIVERS', '78. CYBERCRIME ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 78. CYBERCRIME ENGINE
- Anchor: 78-cybercrime-engine
- Depends on: ['76.1 PLAYER VISIBILITY SCORE (PVS)']
- Feeds into: ['78.2 CYBERCRIME TIERS']
- Related: ['76.1 PLAYER VISIBILITY SCORE (PVS)', '78.2 CYBERCRIME TIERS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 78.2 CYBERCRIME TIERS
- Anchor: 78-2-cybercrime-tiers
- Depends on: ['78. CYBERCRIME ENGINE']
- Feeds into: ['79. BANK & ATM CRIME SYSTEM']
- Related: ['78. CYBERCRIME ENGINE', '79. BANK & ATM CRIME SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 79. BANK & ATM CRIME SYSTEM
- Anchor: 79-bank-atm-crime-system
- Depends on: ['78.2 CYBERCRIME TIERS']
- Feeds into: ['80. NPC DIALOGUE ENGINE (NDE)']
- Related: ['78.2 CYBERCRIME TIERS', '80. NPC DIALOGUE ENGINE (NDE)', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 80. NPC DIALOGUE ENGINE (NDE)
- Anchor: 80-npc-dialogue-engine-nde
- Depends on: ['79. BANK & ATM CRIME SYSTEM']
- Feeds into: ['80.1 NPC PERSONALITY TAGS']
- Related: ['79. BANK & ATM CRIME SYSTEM', '80.1 NPC PERSONALITY TAGS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 80.1 NPC PERSONALITY TAGS
- Anchor: 80-1-npc-personality-tags
- Depends on: ['80. NPC DIALOGUE ENGINE (NDE)']
- Feeds into: ['106. NPC CAREER ENGINE']
- Related: ['80. NPC DIALOGUE ENGINE (NDE)', '106. NPC CAREER ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 106. NPC CAREER ENGINE
- Anchor: 106-npc-career-engine
- Depends on: ['80.1 NPC PERSONALITY TAGS']
- Feeds into: ['109. TACTICAL COMBAT ENGINE']
- Related: ['80.1 NPC PERSONALITY TAGS', '109. TACTICAL COMBAT ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 109. TACTICAL COMBAT ENGINE
- Anchor: 109-tactical-combat-engine
- Depends on: ['106. NPC CAREER ENGINE']
- Feeds into: ['112. ELITE CRIME PATHS']
- Related: ['106. NPC CAREER ENGINE', '112. ELITE CRIME PATHS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 112. ELITE CRIME PATHS
- Anchor: 112-elite-crime-paths
- Depends on: ['109. TACTICAL COMBAT ENGINE']
- Feeds into: ['132. HOUSING MARKET ENGINE']
- Related: ['109. TACTICAL COMBAT ENGINE', '132. HOUSING MARKET ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 132. HOUSING MARKET ENGINE
- Anchor: 132-housing-market-engine
- Depends on: ['112. ELITE CRIME PATHS']
- Feeds into: ['134. NPC ASCENSION ENGINE']
- Related: ['112. ELITE CRIME PATHS', '134. NPC ASCENSION ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 134. NPC ASCENSION ENGINE
- Anchor: 134-npc-ascension-engine
- Depends on: ['132. HOUSING MARKET ENGINE']
- Feeds into: ['140. NPC FAMILY ENGINE']
- Related: ['132. HOUSING MARKET ENGINE', '140. NPC FAMILY ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 140. NPC FAMILY ENGINE
- Anchor: 140-npc-family-engine
- Depends on: ['134. NPC ASCENSION ENGINE']
- Feeds into: ['144. MUTABLE CRIME ENGINE']
- Related: ['134. NPC ASCENSION ENGINE', '144. MUTABLE CRIME ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 144. MUTABLE CRIME ENGINE
- Anchor: 144-mutable-crime-engine
- Depends on: ['140. NPC FAMILY ENGINE']
- Feeds into: ['159. NPC AFTERLIFE SYSTEM']
- Related: ['140. NPC FAMILY ENGINE', '159. NPC AFTERLIFE SYSTEM', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 159. NPC AFTERLIFE SYSTEM
- Anchor: 159-npc-afterlife-system
- Depends on: ['144. MUTABLE CRIME ENGINE']
- Feeds into: ['164. APOCALYPSE ECONOMY']
- Related: ['144. MUTABLE CRIME ENGINE', '164. APOCALYPSE ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 164. APOCALYPSE ECONOMY
- Anchor: 164-apocalypse-economy
- Depends on: ['159. NPC AFTERLIFE SYSTEM']
- Feeds into: ['182. COSMIC CRIME ENGINE']
- Related: ['159. NPC AFTERLIFE SYSTEM', '182. COSMIC CRIME ENGINE', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 182. COSMIC CRIME ENGINE
- Anchor: 182-cosmic-crime-engine
- Depends on: ['164. APOCALYPSE ECONOMY']
- Feeds into: []
- Related: ['164. APOCALYPSE ECONOMY', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING', '165. THE FORGE OF ORIGINS']

# COSMIC SYSTEMS

## 165. THE FORGE OF ORIGINS
- Anchor: 165-the-forge-of-origins
- Depends on: []
- Feeds into: ['170. COSMIC ARTEFACT ENGINE']
- Related: ['170. COSMIC ARTEFACT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## 170. COSMIC ARTEFACT ENGINE
- Anchor: 170-cosmic-artefact-engine
- Depends on: ['165. THE FORGE OF ORIGINS']
- Feeds into: ['173. VOID INVASION ENGINE']
- Related: ['165. THE FORGE OF ORIGINS', '173. VOID INVASION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 173. VOID INVASION ENGINE
- Anchor: 173-void-invasion-engine
- Depends on: ['170. COSMIC ARTEFACT ENGINE']
- Feeds into: ['176. ANTI-GOD ENGAGEMENT']
- Related: ['170. COSMIC ARTEFACT ENGINE', '176. ANTI-GOD ENGAGEMENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 176. ANTI-GOD ENGAGEMENT
- Anchor: 176-anti-god-engagement
- Depends on: ['173. VOID INVASION ENGINE']
- Feeds into: ['186. ORIGIN REWRITE ENGINE']
- Related: ['173. VOID INVASION ENGINE', '186. ORIGIN REWRITE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 186. ORIGIN REWRITE ENGINE
- Anchor: 186-origin-rewrite-engine
- Depends on: ['176. ANTI-GOD ENGAGEMENT']
- Feeds into: ['189. ASCENSION TREE ENGINE']
- Related: ['176. ANTI-GOD ENGAGEMENT', '189. ASCENSION TREE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 189. ASCENSION TREE ENGINE
- Anchor: 189-ascension-tree-engine
- Depends on: ['186. ORIGIN REWRITE ENGINE']
- Feeds into: ['196. ASCENSION ENGINE']
- Related: ['186. ORIGIN REWRITE ENGINE', '196. ASCENSION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 196. ASCENSION ENGINE
- Anchor: 196-ascension-engine
- Depends on: ['189. ASCENSION TREE ENGINE']
- Feeds into: []
- Related: ['189. ASCENSION TREE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

# DIMENSIONAL SYSTEMS

## DRIFT KING
- Anchor: drift-king
- Depends on: []
- Feeds into: ['74. PARALLEL CITY ENGINE']
- Related: ['74. PARALLEL CITY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', '165. THE FORGE OF ORIGINS']

## 74. PARALLEL CITY ENGINE
- Anchor: 74-parallel-city-engine
- Depends on: ['DRIFT KING']
- Feeds into: ['110. MULTIVERSE CHAIN SYSTEM']
- Related: ['DRIFT KING', '110. MULTIVERSE CHAIN SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 110. MULTIVERSE CHAIN SYSTEM
- Anchor: 110-multiverse-chain-system
- Depends on: ['74. PARALLEL CITY ENGINE']
- Feeds into: ['123. DIMENSION RAID ENGINE']
- Related: ['74. PARALLEL CITY ENGINE', '123. DIMENSION RAID ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 123. DIMENSION RAID ENGINE
- Anchor: 123-dimension-raid-engine
- Depends on: ['110. MULTIVERSE CHAIN SYSTEM']
- Feeds into: ['138. MULTIVERSE WAR ENGINE (MWE)']
- Related: ['110. MULTIVERSE CHAIN SYSTEM', '138. MULTIVERSE WAR ENGINE (MWE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 138. MULTIVERSE WAR ENGINE (MWE)
- Anchor: 138-multiverse-war-engine-mwe
- Depends on: ['123. DIMENSION RAID ENGINE']
- Feeds into: ['152. DIMENSIONAL CITY ENGINE']
- Related: ['123. DIMENSION RAID ENGINE', '152. DIMENSIONAL CITY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 152. DIMENSIONAL CITY ENGINE
- Anchor: 152-dimensional-city-engine
- Depends on: ['138. MULTIVERSE WAR ENGINE (MWE)']
- Feeds into: ['157. LIVING TIMELINE ENGINE']
- Related: ['138. MULTIVERSE WAR ENGINE (MWE)', '157. LIVING TIMELINE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 157. LIVING TIMELINE ENGINE
- Anchor: 157-living-timeline-engine
- Depends on: ['152. DIMENSIONAL CITY ENGINE']
- Feeds into: ['171. TIMELINE CONFLUENCE ENGINE']
- Related: ['152. DIMENSIONAL CITY ENGINE', '171. TIMELINE CONFLUENCE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 171. TIMELINE CONFLUENCE ENGINE
- Anchor: 171-timeline-confluence-engine
- Depends on: ['157. LIVING TIMELINE ENGINE']
- Feeds into: ['180. GREAT RIFT ENGINE']
- Related: ['157. LIVING TIMELINE ENGINE', '180. GREAT RIFT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 180. GREAT RIFT ENGINE
- Anchor: 180-great-rift-engine
- Depends on: ['171. TIMELINE CONFLUENCE ENGINE']
- Feeds into: ['184. DIMENSIONAL BOSS FORGE']
- Related: ['171. TIMELINE CONFLUENCE ENGINE', '184. DIMENSIONAL BOSS FORGE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 184. DIMENSIONAL BOSS FORGE
- Anchor: 184-dimensional-boss-forge
- Depends on: ['180. GREAT RIFT ENGINE']
- Feeds into: ['193. RIFT NAVIGATION ENGINE']
- Related: ['180. GREAT RIFT ENGINE', '193. RIFT NAVIGATION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 193. RIFT NAVIGATION ENGINE
- Anchor: 193-rift-navigation-engine
- Depends on: ['184. DIMENSIONAL BOSS FORGE']
- Feeds into: []
- Related: ['184. DIMENSIONAL BOSS FORGE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', '165. THE FORGE OF ORIGINS']

# MYTHIC SYSTEMS

## Class E — Cultural & Historical Goods
- Anchor: class-e-cultural-historical-goods
- Depends on: []
- Feeds into: ['32.7 DIFFICULTY SCALING']
- Related: ['32.7 DIFFICULTY SCALING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING', '165. THE FORGE OF ORIGINS']

## 32.7 DIFFICULTY SCALING
- Anchor: 32-7-difficulty-scaling
- Depends on: ['Class E — Cultural & Historical Goods']
- Feeds into: ['Mythic (Endgame)']
- Related: ['Class E — Cultural & Historical Goods', 'Mythic (Endgame)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## Mythic (Endgame)
- Anchor: mythic-endgame
- Depends on: ['32.7 DIFFICULTY SCALING']
- Feeds into: ['37. MICRO-LORE: DISTRICT CULTURAL PERSONALITY']
- Related: ['32.7 DIFFICULTY SCALING', '37. MICRO-LORE: DISTRICT CULTURAL PERSONALITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 37. MICRO-LORE: DISTRICT CULTURAL PERSONALITY
- Anchor: 37-micro-lore-district-cultural-personality
- Depends on: ['Mythic (Endgame)']
- Feeds into: ['46. MYTHIC ITEM FRAMEWORK']
- Related: ['Mythic (Endgame)', '46. MYTHIC ITEM FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 46. MYTHIC ITEM FRAMEWORK
- Anchor: 46-mythic-item-framework
- Depends on: ['37. MICRO-LORE: DISTRICT CULTURAL PERSONALITY']
- Feeds into: ['46.1 MYTHIC WEAPON ARCHETYPES']
- Related: ['37. MICRO-LORE: DISTRICT CULTURAL PERSONALITY', '46.1 MYTHIC WEAPON ARCHETYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 46.1 MYTHIC WEAPON ARCHETYPES
- Anchor: 46-1-mythic-weapon-archetypes
- Depends on: ['46. MYTHIC ITEM FRAMEWORK']
- Feeds into: ['82. CULT & OCCULT SYSTEM']
- Related: ['46. MYTHIC ITEM FRAMEWORK', '82. CULT & OCCULT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 82. CULT & OCCULT SYSTEM
- Anchor: 82-cult-occult-system
- Depends on: ['46.1 MYTHIC WEAPON ARCHETYPES']
- Feeds into: ['82.1 CULT MECHANICS']
- Related: ['46.1 MYTHIC WEAPON ARCHETYPES', '82.1 CULT MECHANICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 82.1 CULT MECHANICS
- Anchor: 82-1-cult-mechanics
- Depends on: ['82. CULT & OCCULT SYSTEM']
- Feeds into: ['100. MYTHOS LAYER']
- Related: ['82. CULT & OCCULT SYSTEM', '100. MYTHOS LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 100. MYTHOS LAYER
- Anchor: 100-mythos-layer
- Depends on: ['82.1 CULT MECHANICS']
- Feeds into: ['125. CULT CREATION ENGINE']
- Related: ['82.1 CULT MECHANICS', '125. CULT CREATION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 125. CULT CREATION ENGINE
- Anchor: 125-cult-creation-engine
- Depends on: ['100. MYTHOS LAYER']
- Feeds into: ['135. DREAMWORLD ENGINE']
- Related: ['100. MYTHOS LAYER', '135. DREAMWORLD ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 135. DREAMWORLD ENGINE
- Anchor: 135-dreamworld-engine
- Depends on: ['125. CULT CREATION ENGINE']
- Feeds into: ['THE CULT OF THE BROKEN CROWN']
- Related: ['125. CULT CREATION ENGINE', 'THE CULT OF THE BROKEN CROWN', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## THE CULT OF THE BROKEN CROWN
- Anchor: the-cult-of-the-broken-crown
- Depends on: ['135. DREAMWORLD ENGINE']
- Feeds into: ['THE MYTHWEAVER']
- Related: ['135. DREAMWORLD ENGINE', 'THE MYTHWEAVER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## THE MYTHWEAVER
- Anchor: the-mythweaver
- Depends on: ['THE CULT OF THE BROKEN CROWN']
- Feeds into: ['149. CITY EVOLUTION v4 (MYTHIC)']
- Related: ['THE CULT OF THE BROKEN CROWN', '149. CITY EVOLUTION v4 (MYTHIC)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 149. CITY EVOLUTION v4 (MYTHIC)
- Anchor: 149-city-evolution-v4-mythic
- Depends on: ['THE MYTHWEAVER']
- Feeds into: ['150. ORIGIN MYTH ENGINE']
- Related: ['THE MYTHWEAVER', '150. ORIGIN MYTH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 150. ORIGIN MYTH ENGINE
- Anchor: 150-origin-myth-engine
- Depends on: ['149. CITY EVOLUTION v4 (MYTHIC)']
- Feeds into: ['153. MYTHIC PATHS']
- Related: ['149. CITY EVOLUTION v4 (MYTHIC)', '153. MYTHIC PATHS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 153. MYTHIC PATHS
- Anchor: 153-mythic-paths
- Depends on: ['150. ORIGIN MYTH ENGINE']
- Feeds into: ['156. MYTH-WEAVER LAW']
- Related: ['150. ORIGIN MYTH ENGINE', '156. MYTH-WEAVER LAW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 156. MYTH-WEAVER LAW
- Anchor: 156-myth-weaver-law
- Depends on: ['153. MYTHIC PATHS']
- Feeds into: ['167. PLAYER MYTHOLOGY ENGINE (PME)']
- Related: ['153. MYTHIC PATHS', '167. PLAYER MYTHOLOGY ENGINE (PME)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 167. PLAYER MYTHOLOGY ENGINE (PME)
- Anchor: 167-player-mythology-engine-pme
- Depends on: ['156. MYTH-WEAVER LAW']
- Feeds into: ['174. MYTHIC DIPLOMACY ENGINE']
- Related: ['156. MYTH-WEAVER LAW', '174. MYTHIC DIPLOMACY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 174. MYTHIC DIPLOMACY ENGINE
- Anchor: 174-mythic-diplomacy-engine
- Depends on: ['167. PLAYER MYTHOLOGY ENGINE (PME)']
- Feeds into: ['188. DREAMWAR ENGINE']
- Related: ['167. PLAYER MYTHOLOGY ENGINE (PME)', '188. DREAMWAR ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 188. DREAMWAR ENGINE
- Anchor: 188-dreamwar-engine
- Depends on: ['174. MYTHIC DIPLOMACY ENGINE']
- Feeds into: ['190. WORLD-MYTH ENGINE']
- Related: ['174. MYTHIC DIPLOMACY ENGINE', '190. WORLD-MYTH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 190. WORLD-MYTH ENGINE
- Anchor: 190-world-myth-engine
- Depends on: ['188. DREAMWAR ENGINE']
- Feeds into: ['192. VOIDFLESH ENGINE']
- Related: ['188. DREAMWAR ENGINE', '192. VOIDFLESH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING']

## 192. VOIDFLESH ENGINE
- Anchor: 192-voidflesh-engine
- Depends on: ['190. WORLD-MYTH ENGINE']
- Feeds into: []
- Related: ['190. WORLD-MYTH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'DRIFT KING', '165. THE FORGE OF ORIGINS']

# ULTRA SYSTEMS

## MASTER OF MASTER BIBLES — VERSION 7 (AUTO-DEPENDENCY ENGINE)
- Anchor: master-of-master-bibles-version-7-auto-dependency-engine
- Depends on: []
- Feeds into: ['MASTER OF MASTER BIBLES — VERSION 6 (AUTO-CLASSIFIED)']
- Related: ['MASTER OF MASTER BIBLES — VERSION 6 (AUTO-CLASSIFIED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

## MASTER OF MASTER BIBLES — VERSION 6 (AUTO-CLASSIFIED)
- Anchor: master-of-master-bibles-version-6-auto-classified
- Depends on: ['MASTER OF MASTER BIBLES — VERSION 7 (AUTO-DEPENDENCY ENGINE)']
- Feeds into: ['MASTER OF MASTER BIBLES — VERSION 5 (PROFESSIONAL DOC EDITION)']
- Related: ['MASTER OF MASTER BIBLES — VERSION 7 (AUTO-DEPENDENCY ENGINE)', 'MASTER OF MASTER BIBLES — VERSION 5 (PROFESSIONAL DOC EDITION)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTER OF MASTER BIBLES — VERSION 5 (PROFESSIONAL DOC EDITION)
- Anchor: master-of-master-bibles-version-5-professional-doc-edition
- Depends on: ['MASTER OF MASTER BIBLES — VERSION 6 (AUTO-CLASSIFIED)']
- Feeds into: ['MASTER OF MASTER BIBLES — VERSION 4  ']
- Related: ['MASTER OF MASTER BIBLES — VERSION 6 (AUTO-CLASSIFIED)', 'MASTER OF MASTER BIBLES — VERSION 4  ', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTER OF MASTER BIBLES — VERSION 4  
- Anchor: master-of-master-bibles-version-4
- Depends on: ['MASTER OF MASTER BIBLES — VERSION 5 (PROFESSIONAL DOC EDITION)']
- Feeds into: ['FULL ARCHITECTURAL REORGANISATION EDITION']
- Related: ['MASTER OF MASTER BIBLES — VERSION 5 (PROFESSIONAL DOC EDITION)', 'FULL ARCHITECTURAL REORGANISATION EDITION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## FULL ARCHITECTURAL REORGANISATION EDITION
- Anchor: full-architectural-reorganisation-edition
- Depends on: ['MASTER OF MASTER BIBLES — VERSION 4  ']
- Feeds into: ['MASTER STRUCTURE INDEX  ']
- Related: ['MASTER OF MASTER BIBLES — VERSION 4  ', 'MASTER STRUCTURE INDEX  ', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTER STRUCTURE INDEX  
- Anchor: master-structure-index
- Depends on: ['FULL ARCHITECTURAL REORGANISATION EDITION']
- Feeds into: ['MASTER OF MASTER BIBLES — VERSION 3 (STRUCTURED EDITION)']
- Related: ['FULL ARCHITECTURAL REORGANISATION EDITION', 'MASTER OF MASTER BIBLES — VERSION 3 (STRUCTURED EDITION)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTER OF MASTER BIBLES — VERSION 3 (STRUCTURED EDITION)
- Anchor: master-of-master-bibles-version-3-structured-edition
- Depends on: ['MASTER STRUCTURE INDEX  ']
- Feeds into: ['TABLE OF CONTENTS']
- Related: ['MASTER STRUCTURE INDEX  ', 'TABLE OF CONTENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE OF CONTENTS
- Anchor: table-of-contents
- Depends on: ['MASTER OF MASTER BIBLES — VERSION 3 (STRUCTURED EDITION)']
- Feeds into: ['MASTER OF MASTER BIBLES — VERSION 2 (HARMONISED EDITION)']
- Related: ['MASTER OF MASTER BIBLES — VERSION 3 (STRUCTURED EDITION)', 'MASTER OF MASTER BIBLES — VERSION 2 (HARMONISED EDITION)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTER OF MASTER BIBLES — VERSION 2 (HARMONISED EDITION)
- Anchor: master-of-master-bibles-version-2-harmonised-edition
- Depends on: ['TABLE OF CONTENTS']
- Feeds into: ['MASTER OF MASTER BIBLES']
- Related: ['TABLE OF CONTENTS', 'MASTER OF MASTER BIBLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTER OF MASTER BIBLES
- Anchor: master-of-master-bibles
- Depends on: ['MASTER OF MASTER BIBLES — VERSION 2 (HARMONISED EDITION)']
- Feeds into: ['TRENCH CITY — MASTER DESIGN BIBLE']
- Related: ['MASTER OF MASTER BIBLES — VERSION 2 (HARMONISED EDITION)', 'TRENCH CITY — MASTER DESIGN BIBLE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TRENCH CITY — MASTER DESIGN BIBLE
- Anchor: trench-city-master-design-bible
- Depends on: ['MASTER OF MASTER BIBLES']
- Feeds into: ['COMPLETE MODULE + FEATURE COMPENDIUM']
- Related: ['MASTER OF MASTER BIBLES', 'COMPLETE MODULE + FEATURE COMPENDIUM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## COMPLETE MODULE + FEATURE COMPENDIUM
- Anchor: complete-module-feature-compendium
- Depends on: ['TRENCH CITY — MASTER DESIGN BIBLE']
- Feeds into: ['(All 75+ Systems Unified Into One Document)']
- Related: ['TRENCH CITY — MASTER DESIGN BIBLE', '(All 75+ Systems Unified Into One Document)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## (All 75+ Systems Unified Into One Document)
- Anchor: all-75-systems-unified-into-one-document
- Depends on: ['COMPLETE MODULE + FEATURE COMPENDIUM']
- Feeds into: ['2. CITY SYSTEMS']
- Related: ['COMPLETE MODULE + FEATURE COMPENDIUM', '2. CITY SYSTEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. CITY SYSTEMS
- Anchor: 2-city-systems
- Depends on: ['(All 75+ Systems Unified Into One Document)']
- Feeds into: ['11. MINI-GAMES & SIDE SYSTEMS']
- Related: ['(All 75+ Systems Unified Into One Document)', '11. MINI-GAMES & SIDE SYSTEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11. MINI-GAMES & SIDE SYSTEMS
- Anchor: 11-mini-games-side-systems
- Depends on: ['2. CITY SYSTEMS']
- Feeds into: ['12. SOCIAL SYSTEMS']
- Related: ['2. CITY SYSTEMS', '12. SOCIAL SYSTEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12. SOCIAL SYSTEMS
- Anchor: 12-social-systems
- Depends on: ['11. MINI-GAMES & SIDE SYSTEMS']
- Feeds into: ['13. EVENTS & SEASONS']
- Related: ['11. MINI-GAMES & SIDE SYSTEMS', '13. EVENTS & SEASONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13. EVENTS & SEASONS
- Anchor: 13-events-seasons
- Depends on: ['12. SOCIAL SYSTEMS']
- Feeds into: ['14. STORE & MONETIZATION']
- Related: ['12. SOCIAL SYSTEMS', '14. STORE & MONETIZATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14. STORE & MONETIZATION
- Anchor: 14-store-monetization
- Depends on: ['13. EVENTS & SEASONS']
- Feeds into: ['15. ADMIN, SECURITY & BACKEND']
- Related: ['13. EVENTS & SEASONS', '15. ADMIN, SECURITY & BACKEND', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15. ADMIN, SECURITY & BACKEND
- Anchor: 15-admin-security-backend
- Depends on: ['14. STORE & MONETIZATION']
- Feeds into: ['16. COMPLETE SYSTEM COUNT SUMMARY']
- Related: ['14. STORE & MONETIZATION', '16. COMPLETE SYSTEM COUNT SUMMARY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16. COMPLETE SYSTEM COUNT SUMMARY
- Anchor: 16-complete-system-count-summary
- Depends on: ['15. ADMIN, SECURITY & BACKEND']
- Feeds into: ['END OF MASTER DOCUMENT']
- Related: ['15. ADMIN, SECURITY & BACKEND', 'END OF MASTER DOCUMENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## END OF MASTER DOCUMENT
- Anchor: end-of-master-document
- Depends on: ['16. COMPLETE SYSTEM COUNT SUMMARY']
- Feeds into: ['1.1 FULL GAME IDENTITY OVERVIEW']
- Related: ['16. COMPLETE SYSTEM COUNT SUMMARY', '1.1 FULL GAME IDENTITY OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1.1 FULL GAME IDENTITY OVERVIEW
- Anchor: 1-1-full-game-identity-overview
- Depends on: ['END OF MASTER DOCUMENT']
- Feeds into: ['1.2 GAMEPLAY PILLARS']
- Related: ['END OF MASTER DOCUMENT', '1.2 GAMEPLAY PILLARS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1.2 GAMEPLAY PILLARS
- Anchor: 1-2-gameplay-pillars
- Depends on: ['1.1 FULL GAME IDENTITY OVERVIEW']
- Feeds into: ['1.3 WORLD STRUCTURE']
- Related: ['1.1 FULL GAME IDENTITY OVERVIEW', '1.3 WORLD STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1.3 WORLD STRUCTURE
- Anchor: 1-3-world-structure
- Depends on: ['1.2 GAMEPLAY PILLARS']
- Feeds into: ['1.4 SYSTEM OVERVIEW INDEX']
- Related: ['1.2 GAMEPLAY PILLARS', '1.4 SYSTEM OVERVIEW INDEX', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1.4 SYSTEM OVERVIEW INDEX
- Anchor: 1-4-system-overview-index
- Depends on: ['1.3 WORLD STRUCTURE']
- Feeds into: ['1.5 DESIGN PHILOSOPHY']
- Related: ['1.3 WORLD STRUCTURE', '1.5 DESIGN PHILOSOPHY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1.5 DESIGN PHILOSOPHY
- Anchor: 1-5-design-philosophy
- Depends on: ['1.4 SYSTEM OVERVIEW INDEX']
- Feeds into: ['2.1 PLAYER STATS MODEL (FULL SPEC)']
- Related: ['1.4 SYSTEM OVERVIEW INDEX', '2.1 PLAYER STATS MODEL (FULL SPEC)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.1 PLAYER STATS MODEL (FULL SPEC)
- Anchor: 2-1-player-stats-model-full-spec
- Depends on: ['1.5 DESIGN PHILOSOPHY']
- Feeds into: ['2.2 EXPERIENCE & LEVELING']
- Related: ['1.5 DESIGN PHILOSOPHY', '2.2 EXPERIENCE & LEVELING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.2 EXPERIENCE & LEVELING
- Anchor: 2-2-experience-leveling
- Depends on: ['2.1 PLAYER STATS MODEL (FULL SPEC)']
- Feeds into: ['2.3 PASSIVE SKILLS SYSTEM']
- Related: ['2.1 PLAYER STATS MODEL (FULL SPEC)', '2.3 PASSIVE SKILLS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.3 PASSIVE SKILLS SYSTEM
- Anchor: 2-3-passive-skills-system
- Depends on: ['2.2 EXPERIENCE & LEVELING']
- Feeds into: ['2.4 PLAYER ALIGNMENT: KARMA & INFAMY']
- Related: ['2.2 EXPERIENCE & LEVELING', '2.4 PLAYER ALIGNMENT: KARMA & INFAMY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.4 PLAYER ALIGNMENT: KARMA & INFAMY
- Anchor: 2-4-player-alignment-karma-infamy
- Depends on: ['2.3 PASSIVE SKILLS SYSTEM']
- Feeds into: ['2.5 PLAYER ROLES & BUILDS']
- Related: ['2.3 PASSIVE SKILLS SYSTEM', '2.5 PLAYER ROLES & BUILDS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.5 PLAYER ROLES & BUILDS
- Anchor: 2-5-player-roles-builds
- Depends on: ['2.4 PLAYER ALIGNMENT: KARMA & INFAMY']
- Feeds into: ['2.6 DEATH, HOSPITAL, JAIL']
- Related: ['2.4 PLAYER ALIGNMENT: KARMA & INFAMY', '2.6 DEATH, HOSPITAL, JAIL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.6 DEATH, HOSPITAL, JAIL
- Anchor: 2-6-death-hospital-jail
- Depends on: ['2.5 PLAYER ROLES & BUILDS']
- Feeds into: ['2.7 PLAYER PROGRESSION STAGES']
- Related: ['2.5 PLAYER ROLES & BUILDS', '2.7 PLAYER PROGRESSION STAGES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.7 PLAYER PROGRESSION STAGES
- Anchor: 2-7-player-progression-stages
- Depends on: ['2.6 DEATH, HOSPITAL, JAIL']
- Feeds into: ['2.9 ANTI-ABUSE & FAIRNESS PROTECTIONS']
- Related: ['2.6 DEATH, HOSPITAL, JAIL', '2.9 ANTI-ABUSE & FAIRNESS PROTECTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.9 ANTI-ABUSE & FAIRNESS PROTECTIONS
- Anchor: 2-9-anti-abuse-fairness-protections
- Depends on: ['2.7 PLAYER PROGRESSION STAGES']
- Feeds into: ['3.1 USERS & ACCOUNT STRUCTURE']
- Related: ['2.7 PLAYER PROGRESSION STAGES', '3.1 USERS & ACCOUNT STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3.1 USERS & ACCOUNT STRUCTURE
- Anchor: 3-1-users-account-structure
- Depends on: ['2.9 ANTI-ABUSE & FAIRNESS PROTECTIONS']
- Feeds into: ['TABLE: users']
- Related: ['2.9 ANTI-ABUSE & FAIRNESS PROTECTIONS', 'TABLE: users', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: users
- Anchor: table-users
- Depends on: ['3.1 USERS & ACCOUNT STRUCTURE']
- Feeds into: ['TABLE: user_stats']
- Related: ['3.1 USERS & ACCOUNT STRUCTURE', 'TABLE: user_stats', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: user_stats
- Anchor: table-user-stats
- Depends on: ['TABLE: users']
- Feeds into: ['TABLE: user_bars']
- Related: ['TABLE: users', 'TABLE: user_bars', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: user_bars
- Anchor: table-user-bars
- Depends on: ['TABLE: user_stats']
- Feeds into: ['TABLE: user_progression']
- Related: ['TABLE: user_stats', 'TABLE: user_progression', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: user_progression
- Anchor: table-user-progression
- Depends on: ['TABLE: user_bars']
- Feeds into: ['TABLE: items']
- Related: ['TABLE: user_bars', 'TABLE: items', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: items
- Anchor: table-items
- Depends on: ['TABLE: user_progression']
- Feeds into: ['TABLE: user_equipment']
- Related: ['TABLE: user_progression', 'TABLE: user_equipment', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: user_equipment
- Anchor: table-user-equipment
- Depends on: ['TABLE: items']
- Feeds into: ['TABLE: properties']
- Related: ['TABLE: items', 'TABLE: properties', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: properties
- Anchor: table-properties
- Depends on: ['TABLE: user_equipment']
- Feeds into: ['TABLE: user_properties']
- Related: ['TABLE: user_equipment', 'TABLE: user_properties', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: user_properties
- Anchor: table-user-properties
- Depends on: ['TABLE: properties']
- Feeds into: ['TABLE: racing_tracks']
- Related: ['TABLE: properties', 'TABLE: racing_tracks', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: racing_tracks
- Anchor: table-racing-tracks
- Depends on: ['TABLE: user_properties']
- Feeds into: ['TABLE: racing_results']
- Related: ['TABLE: user_properties', 'TABLE: racing_results', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: racing_results
- Anchor: table-racing-results
- Depends on: ['TABLE: racing_tracks']
- Feeds into: ['TABLE: missions']
- Related: ['TABLE: racing_tracks', 'TABLE: missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: missions
- Anchor: table-missions
- Depends on: ['TABLE: racing_results']
- Feeds into: ['TABLE: mission_attempts']
- Related: ['TABLE: racing_results', 'TABLE: mission_attempts', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: mission_attempts
- Anchor: table-mission-attempts
- Depends on: ['TABLE: missions']
- Feeds into: ['TABLE: territories']
- Related: ['TABLE: missions', 'TABLE: territories', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: territories
- Anchor: table-territories
- Depends on: ['TABLE: mission_attempts']
- Feeds into: ['TABLE: auction_house']
- Related: ['TABLE: mission_attempts', 'TABLE: auction_house', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: auction_house
- Anchor: table-auction-house
- Depends on: ['TABLE: territories']
- Feeds into: ['TABLE: stocks']
- Related: ['TABLE: territories', 'TABLE: stocks', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: stocks
- Anchor: table-stocks
- Depends on: ['TABLE: auction_house']
- Feeds into: ['TABLE: user_stocks']
- Related: ['TABLE: auction_house', 'TABLE: user_stocks', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: user_stocks
- Anchor: table-user-stocks
- Depends on: ['TABLE: stocks']
- Feeds into: ['3.9 LOGGING, ANTI‑CHEAT & LIVE OPS']
- Related: ['TABLE: stocks', '3.9 LOGGING, ANTI‑CHEAT & LIVE OPS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3.9 LOGGING, ANTI‑CHEAT & LIVE OPS
- Anchor: 3-9-logging-anti-cheat-live-ops
- Depends on: ['TABLE: user_stocks']
- Feeds into: ['TABLE: logs']
- Related: ['TABLE: user_stocks', 'TABLE: logs', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: logs
- Anchor: table-logs
- Depends on: ['3.9 LOGGING, ANTI‑CHEAT & LIVE OPS']
- Feeds into: ['TABLE: live_ops_modifiers']
- Related: ['3.9 LOGGING, ANTI‑CHEAT & LIVE OPS', 'TABLE: live_ops_modifiers', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TABLE: live_ops_modifiers
- Anchor: table-live-ops-modifiers
- Depends on: ['TABLE: logs']
- Feeds into: ['CHUNK 4 — UI/UX FOUNDATION & DARK LUXURY DESIGN FRAMEWORK']
- Related: ['TABLE: logs', 'CHUNK 4 — UI/UX FOUNDATION & DARK LUXURY DESIGN FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 4 — UI/UX FOUNDATION & DARK LUXURY DESIGN FRAMEWORK
- Anchor: chunk-4-ui-ux-foundation-dark-luxury-design-framework
- Depends on: ['TABLE: live_ops_modifiers']
- Feeds into: ['4.1 DESIGN PHILOSOPHY']
- Related: ['TABLE: live_ops_modifiers', '4.1 DESIGN PHILOSOPHY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.1 DESIGN PHILOSOPHY
- Anchor: 4-1-design-philosophy
- Depends on: ['CHUNK 4 — UI/UX FOUNDATION & DARK LUXURY DESIGN FRAMEWORK']
- Feeds into: ['4.2 GLOBAL COLOR TOKENS']
- Related: ['CHUNK 4 — UI/UX FOUNDATION & DARK LUXURY DESIGN FRAMEWORK', '4.2 GLOBAL COLOR TOKENS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.2 GLOBAL COLOR TOKENS
- Anchor: 4-2-global-color-tokens
- Depends on: ['4.1 DESIGN PHILOSOPHY']
- Feeds into: ['4.3 TYPOGRAPHY SYSTEM']
- Related: ['4.1 DESIGN PHILOSOPHY', '4.3 TYPOGRAPHY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.3 TYPOGRAPHY SYSTEM
- Anchor: 4-3-typography-system
- Depends on: ['4.2 GLOBAL COLOR TOKENS']
- Feeds into: ['4.4 LAYOUT GRID SYSTEM']
- Related: ['4.2 GLOBAL COLOR TOKENS', '4.4 LAYOUT GRID SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.4 LAYOUT GRID SYSTEM
- Anchor: 4-4-layout-grid-system
- Depends on: ['4.3 TYPOGRAPHY SYSTEM']
- Feeds into: ['Cards']
- Related: ['4.3 TYPOGRAPHY SYSTEM', 'Cards', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Cards
- Anchor: cards
- Depends on: ['4.4 LAYOUT GRID SYSTEM']
- Feeds into: ['Buttons']
- Related: ['4.4 LAYOUT GRID SYSTEM', 'Buttons', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Buttons
- Anchor: buttons
- Depends on: ['Cards']
- Feeds into: ['Inputs']
- Related: ['Cards', 'Inputs', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Inputs
- Anchor: inputs
- Depends on: ['Buttons']
- Feeds into: ['Lists']
- Related: ['Buttons', 'Lists', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Lists
- Anchor: lists
- Depends on: ['Inputs']
- Feeds into: ['Modals']
- Related: ['Inputs', 'Modals', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Modals
- Anchor: modals
- Depends on: ['Lists']
- Feeds into: ['4.6 NAVIGATION ARCHITECTURE']
- Related: ['Lists', '4.6 NAVIGATION ARCHITECTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.6 NAVIGATION ARCHITECTURE
- Anchor: 4-6-navigation-architecture
- Depends on: ['Modals']
- Feeds into: ['Sidebar Structure']
- Related: ['Modals', 'Sidebar Structure', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Sidebar Structure
- Anchor: sidebar-structure
- Depends on: ['4.6 NAVIGATION ARCHITECTURE']
- Feeds into: ['Top Bar']
- Related: ['4.6 NAVIGATION ARCHITECTURE', 'Top Bar', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Top Bar
- Anchor: top-bar
- Depends on: ['Sidebar Structure']
- Feeds into: ['4.7 PAGE TEMPLATE RULES']
- Related: ['Sidebar Structure', '4.7 PAGE TEMPLATE RULES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.7 PAGE TEMPLATE RULES
- Anchor: 4-7-page-template-rules
- Depends on: ['Top Bar']
- Feeds into: ['Standard Module Page Template:']
- Related: ['Top Bar', 'Standard Module Page Template:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Standard Module Page Template:
- Anchor: standard-module-page-template
- Depends on: ['4.7 PAGE TEMPLATE RULES']
- Feeds into: ['Detail View Page Template:']
- Related: ['4.7 PAGE TEMPLATE RULES', 'Detail View Page Template:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Detail View Page Template:
- Anchor: detail-view-page-template
- Depends on: ['Standard Module Page Template:']
- Feeds into: ['List/Table Pages:']
- Related: ['Standard Module Page Template:', 'List/Table Pages:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## List/Table Pages:
- Anchor: list-table-pages
- Depends on: ['Detail View Page Template:']
- Feeds into: ['4.8 ANIMATION & FEEDBACK RULES']
- Related: ['Detail View Page Template:', '4.8 ANIMATION & FEEDBACK RULES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.8 ANIMATION & FEEDBACK RULES
- Anchor: 4-8-animation-feedback-rules
- Depends on: ['List/Table Pages:']
- Feeds into: ['4.9 ACCESSIBILITY']
- Related: ['List/Table Pages:', '4.9 ACCESSIBILITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.9 ACCESSIBILITY
- Anchor: 4-9-accessibility
- Depends on: ['4.8 ANIMATION & FEEDBACK RULES']
- Feeds into: ['4.10 DARK LUXURY UI — VISUAL IDENTITY CHECKPOINTS']
- Related: ['4.8 ANIMATION & FEEDBACK RULES', '4.10 DARK LUXURY UI — VISUAL IDENTITY CHECKPOINTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4.10 DARK LUXURY UI — VISUAL IDENTITY CHECKPOINTS
- Anchor: 4-10-dark-luxury-ui-visual-identity-checkpoints
- Depends on: ['4.9 ACCESSIBILITY']
- Feeds into: ['2. Urban Theft']
- Related: ['4.9 ACCESSIBILITY', '2. Urban Theft', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Urban Theft
- Anchor: 2-urban-theft
- Depends on: ['4.10 DARK LUXURY UI — VISUAL IDENTITY CHECKPOINTS']
- Feeds into: ['3. Burglary']
- Related: ['4.10 DARK LUXURY UI — VISUAL IDENTITY CHECKPOINTS', '3. Burglary', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Burglary
- Anchor: 3-burglary
- Depends on: ['2. Urban Theft']
- Feeds into: ['4. Mugging & Robbery']
- Related: ['2. Urban Theft', '4. Mugging & Robbery', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. Mugging & Robbery
- Anchor: 4-mugging-robbery
- Depends on: ['3. Burglary']
- Feeds into: ['5. Drug Operations']
- Related: ['3. Burglary', '5. Drug Operations', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. Drug Operations
- Anchor: 5-drug-operations
- Depends on: ['4. Mugging & Robbery']
- Feeds into: ['6. Fraud & Scams']
- Related: ['4. Mugging & Robbery', '6. Fraud & Scams', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6. Fraud & Scams
- Anchor: 6-fraud-scams
- Depends on: ['5. Drug Operations']
- Feeds into: ['8. Smuggling (Local)']
- Related: ['5. Drug Operations', '8. Smuggling (Local)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8. Smuggling (Local)
- Anchor: 8-smuggling-local
- Depends on: ['6. Fraud & Scams']
- Feeds into: ['9. Smuggling (International)']
- Related: ['6. Fraud & Scams', '9. Smuggling (International)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9. Smuggling (International)
- Anchor: 9-smuggling-international
- Depends on: ['8. Smuggling (Local)']
- Feeds into: ['10. Heists (Small)']
- Related: ['8. Smuggling (Local)', '10. Heists (Small)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10. Heists (Small)
- Anchor: 10-heists-small
- Depends on: ['9. Smuggling (International)']
- Feeds into: ['11. Heists (Major)']
- Related: ['9. Smuggling (International)', '11. Heists (Major)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11. Heists (Major)
- Anchor: 11-heists-major
- Depends on: ['10. Heists (Small)']
- Feeds into: ['12. Extortion']
- Related: ['10. Heists (Small)', '12. Extortion', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12. Extortion
- Anchor: 12-extortion
- Depends on: ['11. Heists (Major)']
- Feeds into: ['13. Blackmail']
- Related: ['11. Heists (Major)', '13. Blackmail', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13. Blackmail
- Anchor: 13-blackmail
- Depends on: ['12. Extortion']
- Feeds into: ['16. Kidnapping & Hostage Work']
- Related: ['12. Extortion', '16. Kidnapping & Hostage Work', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16. Kidnapping & Hostage Work
- Anchor: 16-kidnapping-hostage-work
- Depends on: ['13. Blackmail']
- Feeds into: ['17. Weapons Trafficking']
- Related: ['13. Blackmail', '17. Weapons Trafficking', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17. Weapons Trafficking
- Anchor: 17-weapons-trafficking
- Depends on: ['16. Kidnapping & Hostage Work']
- Feeds into: ['18. Human Trafficking (Toned-down MMO-safe version)']
- Related: ['16. Kidnapping & Hostage Work', '18. Human Trafficking (Toned-down MMO-safe version)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 18. Human Trafficking (Toned-down MMO-safe version)
- Anchor: 18-human-trafficking-toned-down-mmo-safe-version
- Depends on: ['17. Weapons Trafficking']
- Feeds into: ['19. Syndicate Operations']
- Related: ['17. Weapons Trafficking', '19. Syndicate Operations', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19. Syndicate Operations
- Anchor: 19-syndicate-operations
- Depends on: ['18. Human Trafficking (Toned-down MMO-safe version)']
- Feeds into: ['5.4 POLICE HEAT SYSTEM']
- Related: ['18. Human Trafficking (Toned-down MMO-safe version)', '5.4 POLICE HEAT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.4 POLICE HEAT SYSTEM
- Anchor: 5-4-police-heat-system
- Depends on: ['19. Syndicate Operations']
- Feeds into: ['5.5 POLICE RESPONSE AI']
- Related: ['19. Syndicate Operations', '5.5 POLICE RESPONSE AI', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.5 POLICE RESPONSE AI
- Anchor: 5-5-police-response-ai
- Depends on: ['5.4 POLICE HEAT SYSTEM']
- Feeds into: ['5.8 PROCEDURAL VARIANTS']
- Related: ['5.4 POLICE HEAT SYSTEM', '5.8 PROCEDURAL VARIANTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.8 PROCEDURAL VARIANTS
- Anchor: 5-8-procedural-variants
- Depends on: ['5.5 POLICE RESPONSE AI']
- Feeds into: ['5.10 LIVE OPS & ANALYTICS HOOKS']
- Related: ['5.5 POLICE RESPONSE AI', '5.10 LIVE OPS & ANALYTICS HOOKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.10 LIVE OPS & ANALYTICS HOOKS
- Anchor: 5-10-live-ops-analytics-hooks
- Depends on: ['5.8 PROCEDURAL VARIANTS']
- Feeds into: ['5.11 ANTI-EXPLOIT RULES']
- Related: ['5.8 PROCEDURAL VARIANTS', '5.11 ANTI-EXPLOIT RULES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.11 ANTI-EXPLOIT RULES
- Anchor: 5-11-anti-exploit-rules
- Depends on: ['5.10 LIVE OPS & ANALYTICS HOOKS']
- Feeds into: ['6.4 INITIATIVE FORMULA']
- Related: ['5.10 LIVE OPS & ANALYTICS HOOKS', '6.4 INITIATIVE FORMULA', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6.4 INITIATIVE FORMULA
- Anchor: 6-4-initiative-formula
- Depends on: ['5.11 ANTI-EXPLOIT RULES']
- Feeds into: ['6.5 ATTACK FORMULAS']
- Related: ['5.11 ANTI-EXPLOIT RULES', '6.5 ATTACK FORMULAS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6.5 ATTACK FORMULAS
- Anchor: 6-5-attack-formulas
- Depends on: ['6.4 INITIATIVE FORMULA']
- Feeds into: ['Accuracy']
- Related: ['6.4 INITIATIVE FORMULA', 'Accuracy', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Accuracy
- Anchor: accuracy
- Depends on: ['6.5 ATTACK FORMULAS']
- Feeds into: ['Hit Chance']
- Related: ['6.5 ATTACK FORMULAS', 'Hit Chance', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Hit Chance
- Anchor: hit-chance
- Depends on: ['Accuracy']
- Feeds into: ['Damage']
- Related: ['Accuracy', 'Damage', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Damage
- Anchor: damage
- Depends on: ['Hit Chance']
- Feeds into: ['6.6 DAMAGE TYPES']
- Related: ['Hit Chance', '6.6 DAMAGE TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6.6 DAMAGE TYPES
- Anchor: 6-6-damage-types
- Depends on: ['Damage']
- Feeds into: ['Aggressive']
- Related: ['Damage', 'Aggressive', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Aggressive
- Anchor: aggressive
- Depends on: ['6.6 DAMAGE TYPES']
- Feeds into: ['Defensive']
- Related: ['6.6 DAMAGE TYPES', 'Defensive', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Defensive
- Anchor: defensive
- Depends on: ['Aggressive']
- Feeds into: ['Tactical']
- Related: ['Aggressive', 'Tactical', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tactical
- Anchor: tactical
- Depends on: ['Defensive']
- Feeds into: ['Reckless (high‑risk variant)']
- Related: ['Defensive', 'Reckless (high‑risk variant)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Reckless (high‑risk variant)
- Anchor: reckless-high-risk-variant
- Depends on: ['Tactical']
- Feeds into: ['6.14 ANTI-EXPLOIT SAFETY']
- Related: ['Tactical', '6.14 ANTI-EXPLOIT SAFETY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6.14 ANTI-EXPLOIT SAFETY
- Anchor: 6-14-anti-exploit-safety
- Depends on: ['Reckless (high‑risk variant)']
- Feeds into: ['Requirements']
- Related: ['Reckless (high‑risk variant)', 'Requirements', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Requirements
- Anchor: requirements
- Depends on: ['6.14 ANTI-EXPLOIT SAFETY']
- Feeds into: ['Rank Examples']
- Related: ['6.14 ANTI-EXPLOIT SAFETY', 'Rank Examples', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rank Examples
- Anchor: rank-examples
- Depends on: ['Requirements']
- Feeds into: ['Mansion Rooms']
- Related: ['Requirements', 'Mansion Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mansion Rooms
- Anchor: mansion-rooms
- Depends on: ['Rank Examples']
- Feeds into: ['Operational Missions']
- Related: ['Rank Examples', 'Operational Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Operational Missions
- Anchor: operational-missions
- Depends on: ['Mansion Rooms']
- Feeds into: ['War Missions']
- Related: ['Mansion Rooms', 'War Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## War Missions
- Anchor: war-missions
- Depends on: ['Operational Missions']
- Feeds into: ['Sleeper Actions']
- Related: ['Operational Missions', 'Sleeper Actions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Sleeper Actions
- Anchor: sleeper-actions
- Depends on: ['War Missions']
- Feeds into: ['7.8 TERRITORY CONTROL SYSTEM']
- Related: ['War Missions', '7.8 TERRITORY CONTROL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7.8 TERRITORY CONTROL SYSTEM
- Anchor: 7-8-territory-control-system
- Depends on: ['Sleeper Actions']
- Feeds into: ['Territory Attributes']
- Related: ['Sleeper Actions', 'Territory Attributes', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Territory Attributes
- Anchor: territory-attributes
- Depends on: ['7.8 TERRITORY CONTROL SYSTEM']
- Feeds into: ['7.9 WAR SYSTEM (FULL MECHANICS)']
- Related: ['7.8 TERRITORY CONTROL SYSTEM', '7.9 WAR SYSTEM (FULL MECHANICS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7.9 WAR SYSTEM (FULL MECHANICS)
- Anchor: 7-9-war-system-full-mechanics
- Depends on: ['Territory Attributes']
- Feeds into: ['War Preparation']
- Related: ['Territory Attributes', 'War Preparation', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## War Preparation
- Anchor: war-preparation
- Depends on: ['7.9 WAR SYSTEM (FULL MECHANICS)']
- Feeds into: ['War Phases']
- Related: ['7.9 WAR SYSTEM (FULL MECHANICS)', 'War Phases', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## War Phases
- Anchor: war-phases
- Depends on: ['War Preparation']
- Feeds into: ['War Outcomes']
- Related: ['War Preparation', 'War Outcomes', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## War Outcomes
- Anchor: war-outcomes
- Depends on: ['War Phases']
- Feeds into: ['7.13 ANTI‑EXPLOIT & FAIRNESS RULES']
- Related: ['War Phases', '7.13 ANTI‑EXPLOIT & FAIRNESS RULES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7.13 ANTI‑EXPLOIT & FAIRNESS RULES
- Anchor: 7-13-anti-exploit-fairness-rules
- Depends on: ['War Outcomes']
- Feeds into: ['8.1 MISSION SYSTEM OVERVIEW']
- Related: ['War Outcomes', '8.1 MISSION SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.1 MISSION SYSTEM OVERVIEW
- Anchor: 8-1-mission-system-overview
- Depends on: ['7.13 ANTI‑EXPLOIT & FAIRNESS RULES']
- Feeds into: ['8.2 STORY MISSIONS (BRANCHING)']
- Related: ['7.13 ANTI‑EXPLOIT & FAIRNESS RULES', '8.2 STORY MISSIONS (BRANCHING)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.2 STORY MISSIONS (BRANCHING)
- Anchor: 8-2-story-missions-branching
- Depends on: ['8.1 MISSION SYSTEM OVERVIEW']
- Feeds into: ['8.3 PROCEDURAL MISSIONS']
- Related: ['8.1 MISSION SYSTEM OVERVIEW', '8.3 PROCEDURAL MISSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.3 PROCEDURAL MISSIONS
- Anchor: 8-3-procedural-missions
- Depends on: ['8.2 STORY MISSIONS (BRANCHING)']
- Feeds into: ['8.4 DAILY & WEEKLY MISSIONS']
- Related: ['8.2 STORY MISSIONS (BRANCHING)', '8.4 DAILY & WEEKLY MISSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.4 DAILY & WEEKLY MISSIONS
- Anchor: 8-4-daily-weekly-missions
- Depends on: ['8.3 PROCEDURAL MISSIONS']
- Feeds into: ['8.11 MISSION CHAINS']
- Related: ['8.3 PROCEDURAL MISSIONS', '8.11 MISSION CHAINS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.11 MISSION CHAINS
- Anchor: 8-11-mission-chains
- Depends on: ['8.4 DAILY & WEEKLY MISSIONS']
- Feeds into: ['8.12 SEASONAL MISSION ARCS']
- Related: ['8.4 DAILY & WEEKLY MISSIONS', '8.12 SEASONAL MISSION ARCS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.12 SEASONAL MISSION ARCS
- Anchor: 8-12-seasonal-mission-arcs
- Depends on: ['8.11 MISSION CHAINS']
- Feeds into: ['8.13 AI DIRECTOR → MISSION INTERACTION']
- Related: ['8.11 MISSION CHAINS', '8.13 AI DIRECTOR → MISSION INTERACTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.13 AI DIRECTOR → MISSION INTERACTION
- Anchor: 8-13-ai-director-mission-interaction
- Depends on: ['8.12 SEASONAL MISSION ARCS']
- Feeds into: ['8.14 ANTI-EXPLOIT RULES FOR MISSIONS']
- Related: ['8.12 SEASONAL MISSION ARCS', '8.14 ANTI-EXPLOIT RULES FOR MISSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8.14 ANTI-EXPLOIT RULES FOR MISSIONS
- Anchor: 8-14-anti-exploit-rules-for-missions
- Depends on: ['8.13 AI DIRECTOR → MISSION INTERACTION']
- Feeds into: ['9.2 CURRENCIES & VALUE TYPES']
- Related: ['8.13 AI DIRECTOR → MISSION INTERACTION', '9.2 CURRENCIES & VALUE TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.2 CURRENCIES & VALUE TYPES
- Anchor: 9-2-currencies-value-types
- Depends on: ['8.14 ANTI-EXPLOIT RULES FOR MISSIONS']
- Feeds into: ['Material Tiers']
- Related: ['8.14 ANTI-EXPLOIT RULES FOR MISSIONS', 'Material Tiers', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Material Tiers
- Anchor: material-tiers
- Depends on: ['9.2 CURRENCIES & VALUE TYPES']
- Feeds into: ['9.3 MONEY FAUCETS (WAYS MONEY ENTERS THE GAME)']
- Related: ['9.2 CURRENCIES & VALUE TYPES', '9.3 MONEY FAUCETS (WAYS MONEY ENTERS THE GAME)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.3 MONEY FAUCETS (WAYS MONEY ENTERS THE GAME)
- Anchor: 9-3-money-faucets-ways-money-enters-the-game
- Depends on: ['Material Tiers']
- Feeds into: ['9.4 MONEY SINKS (WAYS MONEY LEAVES THE GAME)']
- Related: ['Material Tiers', '9.4 MONEY SINKS (WAYS MONEY LEAVES THE GAME)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.4 MONEY SINKS (WAYS MONEY LEAVES THE GAME)
- Anchor: 9-4-money-sinks-ways-money-leaves-the-game
- Depends on: ['9.3 MONEY FAUCETS (WAYS MONEY ENTERS THE GAME)']
- Feeds into: ['9.6 AUCTION HOUSE']
- Related: ['9.3 MONEY FAUCETS (WAYS MONEY ENTERS THE GAME)', '9.6 AUCTION HOUSE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.6 AUCTION HOUSE
- Anchor: 9-6-auction-house
- Depends on: ['9.4 MONEY SINKS (WAYS MONEY LEAVES THE GAME)']
- Feeds into: ['9.14 ANTI-EXPLOIT MEASURES']
- Related: ['9.4 MONEY SINKS (WAYS MONEY LEAVES THE GAME)', '9.14 ANTI-EXPLOIT MEASURES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.14 ANTI-EXPLOIT MEASURES
- Anchor: 9-14-anti-exploit-measures
- Depends on: ['9.6 AUCTION HOUSE']
- Feeds into: ['9.15 MULTI-CURRENCY INTERACTIONS']
- Related: ['9.6 AUCTION HOUSE', '9.15 MULTI-CURRENCY INTERACTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.15 MULTI-CURRENCY INTERACTIONS
- Anchor: 9-15-multi-currency-interactions
- Depends on: ['9.14 ANTI-EXPLOIT MEASURES']
- Feeds into: ['10.6 STASH & STORAGE SYSTEM']
- Related: ['9.14 ANTI-EXPLOIT MEASURES', '10.6 STASH & STORAGE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10.6 STASH & STORAGE SYSTEM
- Anchor: 10-6-stash-storage-system
- Depends on: ['9.15 MULTI-CURRENCY INTERACTIONS']
- Feeds into: ['10.9 RENTAL SYSTEM']
- Related: ['9.15 MULTI-CURRENCY INTERACTIONS', '10.9 RENTAL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10.9 RENTAL SYSTEM
- Anchor: 10-9-rental-system
- Depends on: ['10.6 STASH & STORAGE SYSTEM']
- Feeds into: ['10.12 LAND OWNERSHIP (EXPANSION MODULE)']
- Related: ['10.6 STASH & STORAGE SYSTEM', '10.12 LAND OWNERSHIP (EXPANSION MODULE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10.12 LAND OWNERSHIP (EXPANSION MODULE)
- Anchor: 10-12-land-ownership-expansion-module
- Depends on: ['10.9 RENTAL SYSTEM']
- Feeds into: ['10.14 ANTI-EXPLOIT PROTECTIONS']
- Related: ['10.9 RENTAL SYSTEM', '10.14 ANTI-EXPLOIT PROTECTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10.14 ANTI-EXPLOIT PROTECTIONS
- Anchor: 10-14-anti-exploit-protections
- Depends on: ['10.12 LAND OWNERSHIP (EXPANSION MODULE)']
- Feeds into: ['SPEED']
- Related: ['10.12 LAND OWNERSHIP (EXPANSION MODULE)', 'SPEED', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SPEED
- Anchor: speed
- Depends on: ['10.14 ANTI-EXPLOIT PROTECTIONS']
- Feeds into: ['HANDLING']
- Related: ['10.14 ANTI-EXPLOIT PROTECTIONS', 'HANDLING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## HANDLING
- Anchor: handling
- Depends on: ['SPEED']
- Feeds into: ['STEALTH']
- Related: ['SPEED', 'STEALTH', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## STEALTH
- Anchor: stealth
- Depends on: ['HANDLING']
- Feeds into: ['CARGO']
- Related: ['HANDLING', 'CARGO', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CARGO
- Anchor: cargo
- Depends on: ['STEALTH']
- Feeds into: ['DURABILITY']
- Related: ['STEALTH', 'DURABILITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## DURABILITY
- Anchor: durability
- Depends on: ['CARGO']
- Feeds into: ['11.5 DURABILITY & DAMAGE SYSTEM']
- Related: ['CARGO', '11.5 DURABILITY & DAMAGE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.5 DURABILITY & DAMAGE SYSTEM
- Anchor: 11-5-durability-damage-system
- Depends on: ['DURABILITY']
- Feeds into: ['11.6 RACING SYSTEM OVERVIEW']
- Related: ['DURABILITY', '11.6 RACING SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.6 RACING SYSTEM OVERVIEW
- Anchor: 11-6-racing-system-overview
- Depends on: ['11.5 DURABILITY & DAMAGE SYSTEM']
- Feeds into: ['11.7 RACING TRACK TYPES']
- Related: ['11.5 DURABILITY & DAMAGE SYSTEM', '11.7 RACING TRACK TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.7 RACING TRACK TYPES
- Anchor: 11-7-racing-track-types
- Depends on: ['11.6 RACING SYSTEM OVERVIEW']
- Feeds into: ['11.8 RACING FORMULAS']
- Related: ['11.6 RACING SYSTEM OVERVIEW', '11.8 RACING FORMULAS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.8 RACING FORMULAS
- Anchor: 11-8-racing-formulas
- Depends on: ['11.7 RACING TRACK TYPES']
- Feeds into: ['11.9 SMUGGLING SYSTEM OVERVIEW']
- Related: ['11.7 RACING TRACK TYPES', '11.9 SMUGGLING SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.9 SMUGGLING SYSTEM OVERVIEW
- Anchor: 11-9-smuggling-system-overview
- Depends on: ['11.8 RACING FORMULAS']
- Feeds into: ['Local Smuggling']
- Related: ['11.8 RACING FORMULAS', 'Local Smuggling', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Local Smuggling
- Anchor: local-smuggling
- Depends on: ['11.9 SMUGGLING SYSTEM OVERVIEW']
- Feeds into: ['International Smuggling']
- Related: ['11.9 SMUGGLING SYSTEM OVERVIEW', 'International Smuggling', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## International Smuggling
- Anchor: international-smuggling
- Depends on: ['Local Smuggling']
- Feeds into: ['11.10 SMUGGLING ROUTES']
- Related: ['Local Smuggling', '11.10 SMUGGLING ROUTES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.10 SMUGGLING ROUTES
- Anchor: 11-10-smuggling-routes
- Depends on: ['International Smuggling']
- Feeds into: ['11.11 SMUGGLING SUCCESS FORMULA']
- Related: ['International Smuggling', '11.11 SMUGGLING SUCCESS FORMULA', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.11 SMUGGLING SUCCESS FORMULA
- Anchor: 11-11-smuggling-success-formula
- Depends on: ['11.10 SMUGGLING ROUTES']
- Feeds into: ['11.12 SMUGGLING FAILURE OUTCOMES']
- Related: ['11.10 SMUGGLING ROUTES', '11.12 SMUGGLING FAILURE OUTCOMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.12 SMUGGLING FAILURE OUTCOMES
- Anchor: 11-12-smuggling-failure-outcomes
- Depends on: ['11.11 SMUGGLING SUCCESS FORMULA']
- Feeds into: ['11.14 ANTI-EXPLOIT RULES']
- Related: ['11.11 SMUGGLING SUCCESS FORMULA', '11.14 ANTI-EXPLOIT RULES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11.14 ANTI-EXPLOIT RULES
- Anchor: 11-14-anti-exploit-rules
- Depends on: ['11.12 SMUGGLING FAILURE OUTCOMES']
- Feeds into: ['CHUNK 12 — SOCIAL SYSTEMS DEEP BOOK']
- Related: ['11.12 SMUGGLING FAILURE OUTCOMES', 'CHUNK 12 — SOCIAL SYSTEMS DEEP BOOK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 12 — SOCIAL SYSTEMS DEEP BOOK
- Anchor: chunk-12-social-systems-deep-book
- Depends on: ['11.14 ANTI-EXPLOIT RULES']
- Feeds into: ['12.1 SOCIAL SYSTEM OVERVIEW']
- Related: ['11.14 ANTI-EXPLOIT RULES', '12.1 SOCIAL SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.1 SOCIAL SYSTEM OVERVIEW
- Anchor: 12-1-social-system-overview
- Depends on: ['CHUNK 12 — SOCIAL SYSTEMS DEEP BOOK']
- Feeds into: ['12.2 MAIL SYSTEM']
- Related: ['CHUNK 12 — SOCIAL SYSTEMS DEEP BOOK', '12.2 MAIL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.2 MAIL SYSTEM
- Anchor: 12-2-mail-system
- Depends on: ['12.1 SOCIAL SYSTEM OVERVIEW']
- Feeds into: ['Mail Features:']
- Related: ['12.1 SOCIAL SYSTEM OVERVIEW', 'Mail Features:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mail Features:
- Anchor: mail-features
- Depends on: ['12.2 MAIL SYSTEM']
- Feeds into: ['Anti-Abuse:']
- Related: ['12.2 MAIL SYSTEM', 'Anti-Abuse:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Anti-Abuse:
- Anchor: anti-abuse
- Depends on: ['Mail Features:']
- Feeds into: ['12.3 MESSENGER / REAL-TIME CHAT']
- Related: ['Mail Features:', '12.3 MESSENGER / REAL-TIME CHAT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.3 MESSENGER / REAL-TIME CHAT
- Anchor: 12-3-messenger-real-time-chat
- Depends on: ['Anti-Abuse:']
- Feeds into: ['12.4 FORUM SYSTEM']
- Related: ['Anti-Abuse:', '12.4 FORUM SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.4 FORUM SYSTEM
- Anchor: 12-4-forum-system
- Depends on: ['12.3 MESSENGER / REAL-TIME CHAT']
- Feeds into: ['Categories:']
- Related: ['12.3 MESSENGER / REAL-TIME CHAT', 'Categories:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Categories:
- Anchor: categories
- Depends on: ['12.4 FORUM SYSTEM']
- Feeds into: ['Features:']
- Related: ['12.4 FORUM SYSTEM', 'Features:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Features:
- Anchor: features
- Depends on: ['Categories:']
- Feeds into: ['12.5 RELATIONSHIP SYSTEM (FRIENDS / RIVALS)']
- Related: ['Categories:', '12.5 RELATIONSHIP SYSTEM (FRIENDS / RIVALS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.5 RELATIONSHIP SYSTEM (FRIENDS / RIVALS)
- Anchor: 12-5-relationship-system-friends-rivals
- Depends on: ['Features:']
- Feeds into: ['12.6 REPUTATION SYSTEM']
- Related: ['Features:', '12.6 REPUTATION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.6 REPUTATION SYSTEM
- Anchor: 12-6-reputation-system
- Depends on: ['12.5 RELATIONSHIP SYSTEM (FRIENDS / RIVALS)']
- Feeds into: ['Karma increases from:']
- Related: ['12.5 RELATIONSHIP SYSTEM (FRIENDS / RIVALS)', 'Karma increases from:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Karma increases from:
- Anchor: karma-increases-from
- Depends on: ['12.6 REPUTATION SYSTEM']
- Feeds into: ['Infamy increases from:']
- Related: ['12.6 REPUTATION SYSTEM', 'Infamy increases from:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Infamy increases from:
- Anchor: infamy-increases-from
- Depends on: ['Karma increases from:']
- Feeds into: ['12.7 NEWSPAPER SYSTEM']
- Related: ['Karma increases from:', '12.7 NEWSPAPER SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.7 NEWSPAPER SYSTEM
- Anchor: 12-7-newspaper-system
- Depends on: ['Infamy increases from:']
- Feeds into: ['12.8 MODERATION TOOLS']
- Related: ['Infamy increases from:', '12.8 MODERATION TOOLS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.8 MODERATION TOOLS
- Anchor: 12-8-moderation-tools
- Depends on: ['12.7 NEWSPAPER SYSTEM']
- Feeds into: ['12.9 PLAYER SAFETY & REPORTING SYSTEM']
- Related: ['12.7 NEWSPAPER SYSTEM', '12.9 PLAYER SAFETY & REPORTING SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.9 PLAYER SAFETY & REPORTING SYSTEM
- Anchor: 12-9-player-safety-reporting-system
- Depends on: ['12.8 MODERATION TOOLS']
- Feeds into: ['12.10 SOCIAL ANALYTICS & AI']
- Related: ['12.8 MODERATION TOOLS', '12.10 SOCIAL ANALYTICS & AI', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.10 SOCIAL ANALYTICS & AI
- Anchor: 12-10-social-analytics-ai
- Depends on: ['12.9 PLAYER SAFETY & REPORTING SYSTEM']
- Feeds into: ['12.11 ANTI-EXPLOIT & SOCIAL SECURITY']
- Related: ['12.9 PLAYER SAFETY & REPORTING SYSTEM', '12.11 ANTI-EXPLOIT & SOCIAL SECURITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12.11 ANTI-EXPLOIT & SOCIAL SECURITY
- Anchor: 12-11-anti-exploit-social-security
- Depends on: ['12.10 SOCIAL ANALYTICS & AI']
- Feeds into: ['CHUNK 13 — EVENTS, SEASONS & LIVE OPS SYSTEM']
- Related: ['12.10 SOCIAL ANALYTICS & AI', 'CHUNK 13 — EVENTS, SEASONS & LIVE OPS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 13 — EVENTS, SEASONS & LIVE OPS SYSTEM
- Anchor: chunk-13-events-seasons-live-ops-system
- Depends on: ['12.11 ANTI-EXPLOIT & SOCIAL SECURITY']
- Feeds into: ['13.1 EVENT SYSTEM OVERVIEW']
- Related: ['12.11 ANTI-EXPLOIT & SOCIAL SECURITY', '13.1 EVENT SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.1 EVENT SYSTEM OVERVIEW
- Anchor: 13-1-event-system-overview
- Depends on: ['CHUNK 13 — EVENTS, SEASONS & LIVE OPS SYSTEM']
- Feeds into: ['13.2 EVENT TYPES']
- Related: ['CHUNK 13 — EVENTS, SEASONS & LIVE OPS SYSTEM', '13.2 EVENT TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.2 EVENT TYPES
- Anchor: 13-2-event-types
- Depends on: ['13.1 EVENT SYSTEM OVERVIEW']
- Feeds into: ['1. Static Scheduled Events']
- Related: ['13.1 EVENT SYSTEM OVERVIEW', '1. Static Scheduled Events', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Static Scheduled Events
- Anchor: 1-static-scheduled-events
- Depends on: ['13.2 EVENT TYPES']
- Feeds into: ['2. Dynamic AI Events']
- Related: ['13.2 EVENT TYPES', '2. Dynamic AI Events', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Dynamic AI Events
- Anchor: 2-dynamic-ai-events
- Depends on: ['1. Static Scheduled Events']
- Feeds into: ['3. Seasonal Events']
- Related: ['1. Static Scheduled Events', '3. Seasonal Events', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Seasonal Events
- Anchor: 3-seasonal-events
- Depends on: ['2. Dynamic AI Events']
- Feeds into: ['4. Micro Events']
- Related: ['2. Dynamic AI Events', '4. Micro Events', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. Micro Events
- Anchor: 4-micro-events
- Depends on: ['3. Seasonal Events']
- Feeds into: ['13.3 EVENT MODIFIER SYSTEM']
- Related: ['3. Seasonal Events', '13.3 EVENT MODIFIER SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.3 EVENT MODIFIER SYSTEM
- Anchor: 13-3-event-modifier-system
- Depends on: ['4. Micro Events']
- Feeds into: ['Modifier Examples:']
- Related: ['4. Micro Events', 'Modifier Examples:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Modifier Examples:
- Anchor: modifier-examples
- Depends on: ['13.3 EVENT MODIFIER SYSTEM']
- Feeds into: ['13.4 AI DIRECTOR — EVENT GENERATION ENGINE']
- Related: ['13.3 EVENT MODIFIER SYSTEM', '13.4 AI DIRECTOR — EVENT GENERATION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.4 AI DIRECTOR — EVENT GENERATION ENGINE
- Anchor: 13-4-ai-director-event-generation-engine
- Depends on: ['Modifier Examples:']
- Feeds into: ['13.5 EVENT FLOW STRUCTURE']
- Related: ['Modifier Examples:', '13.5 EVENT FLOW STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.5 EVENT FLOW STRUCTURE
- Anchor: 13-5-event-flow-structure
- Depends on: ['13.4 AI DIRECTOR — EVENT GENERATION ENGINE']
- Feeds into: ['13.6 EVENT CHALLENGES']
- Related: ['13.4 AI DIRECTOR — EVENT GENERATION ENGINE', '13.6 EVENT CHALLENGES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.6 EVENT CHALLENGES
- Anchor: 13-6-event-challenges
- Depends on: ['13.5 EVENT FLOW STRUCTURE']
- Feeds into: ['13.7 EVENT REWARD STRUCTURE']
- Related: ['13.5 EVENT FLOW STRUCTURE', '13.7 EVENT REWARD STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.7 EVENT REWARD STRUCTURE
- Anchor: 13-7-event-reward-structure
- Depends on: ['13.6 EVENT CHALLENGES']
- Feeds into: ['13.8 LEADERBOARD SYSTEM']
- Related: ['13.6 EVENT CHALLENGES', '13.8 LEADERBOARD SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.8 LEADERBOARD SYSTEM
- Anchor: 13-8-leaderboard-system
- Depends on: ['13.7 EVENT REWARD STRUCTURE']
- Feeds into: ['13.9 SEASON PASS (BATTLE PASS SYSTEM)']
- Related: ['13.7 EVENT REWARD STRUCTURE', '13.9 SEASON PASS (BATTLE PASS SYSTEM)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.9 SEASON PASS (BATTLE PASS SYSTEM)
- Anchor: 13-9-season-pass-battle-pass-system
- Depends on: ['13.8 LEADERBOARD SYSTEM']
- Feeds into: ['13.10 SEASONAL STORY ARCS']
- Related: ['13.8 LEADERBOARD SYSTEM', '13.10 SEASONAL STORY ARCS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.10 SEASONAL STORY ARCS
- Anchor: 13-10-seasonal-story-arcs
- Depends on: ['13.9 SEASON PASS (BATTLE PASS SYSTEM)']
- Feeds into: ['13.11 LIVE OPS DASHBOARD (ADMIN)']
- Related: ['13.9 SEASON PASS (BATTLE PASS SYSTEM)', '13.11 LIVE OPS DASHBOARD (ADMIN)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.11 LIVE OPS DASHBOARD (ADMIN)
- Anchor: 13-11-live-ops-dashboard-admin
- Depends on: ['13.10 SEASONAL STORY ARCS']
- Feeds into: ['13.12 LIVE OPS ANALYTICS']
- Related: ['13.10 SEASONAL STORY ARCS', '13.12 LIVE OPS ANALYTICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.12 LIVE OPS ANALYTICS
- Anchor: 13-12-live-ops-analytics
- Depends on: ['13.11 LIVE OPS DASHBOARD (ADMIN)']
- Feeds into: ['13.13 ANTI-EXPLOIT RULES']
- Related: ['13.11 LIVE OPS DASHBOARD (ADMIN)', '13.13 ANTI-EXPLOIT RULES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13.13 ANTI-EXPLOIT RULES
- Anchor: 13-13-anti-exploit-rules
- Depends on: ['13.12 LIVE OPS ANALYTICS']
- Feeds into: ['CHUNK 14 — STORE, COSMETICS & MONETISATION FRAMEWORK']
- Related: ['13.12 LIVE OPS ANALYTICS', 'CHUNK 14 — STORE, COSMETICS & MONETISATION FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 14 — STORE, COSMETICS & MONETISATION FRAMEWORK
- Anchor: chunk-14-store-cosmetics-monetisation-framework
- Depends on: ['13.13 ANTI-EXPLOIT RULES']
- Feeds into: ['14.1 MONETISATION PHILOSOPHY']
- Related: ['13.13 ANTI-EXPLOIT RULES', '14.1 MONETISATION PHILOSOPHY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.1 MONETISATION PHILOSOPHY
- Anchor: 14-1-monetisation-philosophy
- Depends on: ['CHUNK 14 — STORE, COSMETICS & MONETISATION FRAMEWORK']
- Feeds into: ['14.2 COSMETIC STORE OVERVIEW']
- Related: ['CHUNK 14 — STORE, COSMETICS & MONETISATION FRAMEWORK', '14.2 COSMETIC STORE OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.2 COSMETIC STORE OVERVIEW
- Anchor: 14-2-cosmetic-store-overview
- Depends on: ['14.1 MONETISATION PHILOSOPHY']
- Feeds into: ['14.3 MANSION COSMETICS']
- Related: ['14.1 MONETISATION PHILOSOPHY', '14.3 MANSION COSMETICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.3 MANSION COSMETICS
- Anchor: 14-3-mansion-cosmetics
- Depends on: ['14.2 COSMETIC STORE OVERVIEW']
- Feeds into: ['14.5 PROFILE COSMETICS']
- Related: ['14.2 COSMETIC STORE OVERVIEW', '14.5 PROFILE COSMETICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.5 PROFILE COSMETICS
- Anchor: 14-5-profile-cosmetics
- Depends on: ['14.3 MANSION COSMETICS']
- Feeds into: ['14.6 CHAT COSMETICS']
- Related: ['14.3 MANSION COSMETICS', '14.6 CHAT COSMETICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.6 CHAT COSMETICS
- Anchor: 14-6-chat-cosmetics
- Depends on: ['14.5 PROFILE COSMETICS']
- Feeds into: ['14.7 SEASON PASS MONETISATION']
- Related: ['14.5 PROFILE COSMETICS', '14.7 SEASON PASS MONETISATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.7 SEASON PASS MONETISATION
- Anchor: 14-7-season-pass-monetisation
- Depends on: ['14.6 CHAT COSMETICS']
- Feeds into: ['14.8 CURRENCY PACKS (SAFE MODEL)']
- Related: ['14.6 CHAT COSMETICS', '14.8 CURRENCY PACKS (SAFE MODEL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.8 CURRENCY PACKS (SAFE MODEL)
- Anchor: 14-8-currency-packs-safe-model
- Depends on: ['14.7 SEASON PASS MONETISATION']
- Feeds into: ['14.9 STORE EVENTS & SALES']
- Related: ['14.7 SEASON PASS MONETISATION', '14.9 STORE EVENTS & SALES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.9 STORE EVENTS & SALES
- Anchor: 14-9-store-events-sales
- Depends on: ['14.8 CURRENCY PACKS (SAFE MODEL)']
- Feeds into: ['14.10 BUNDLES']
- Related: ['14.8 CURRENCY PACKS (SAFE MODEL)', '14.10 BUNDLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.10 BUNDLES
- Anchor: 14-10-bundles
- Depends on: ['14.9 STORE EVENTS & SALES']
- Feeds into: ['14.11 LOOT CRATES (FAIR, NON-GAMBLING)']
- Related: ['14.9 STORE EVENTS & SALES', '14.11 LOOT CRATES (FAIR, NON-GAMBLING)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.11 LOOT CRATES (FAIR, NON-GAMBLING)
- Anchor: 14-11-loot-crates-fair-non-gambling
- Depends on: ['14.10 BUNDLES']
- Feeds into: ['14.12 ANTI-WHALE SAFEGUARDS']
- Related: ['14.10 BUNDLES', '14.12 ANTI-WHALE SAFEGUARDS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.12 ANTI-WHALE SAFEGUARDS
- Anchor: 14-12-anti-whale-safeguards
- Depends on: ['14.11 LOOT CRATES (FAIR, NON-GAMBLING)']
- Feeds into: ['14.13 FRAUD PREVENTION & CHARGEBACK PROTECTION']
- Related: ['14.11 LOOT CRATES (FAIR, NON-GAMBLING)', '14.13 FRAUD PREVENTION & CHARGEBACK PROTECTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.13 FRAUD PREVENTION & CHARGEBACK PROTECTION
- Anchor: 14-13-fraud-prevention-chargeback-protection
- Depends on: ['14.12 ANTI-WHALE SAFEGUARDS']
- Feeds into: ['14.14 STORE ANALYTICS']
- Related: ['14.12 ANTI-WHALE SAFEGUARDS', '14.14 STORE ANALYTICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14.14 STORE ANALYTICS
- Anchor: 14-14-store-analytics
- Depends on: ['14.13 FRAUD PREVENTION & CHARGEBACK PROTECTION']
- Feeds into: ['15.1 AI SYSTEMS OVERVIEW']
- Related: ['14.13 FRAUD PREVENTION & CHARGEBACK PROTECTION', '15.1 AI SYSTEMS OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.1 AI SYSTEMS OVERVIEW
- Anchor: 15-1-ai-systems-overview
- Depends on: ['14.14 STORE ANALYTICS']
- Feeds into: ['15.2 AI DIRECTOR — GLOBAL CONTROL SYSTEM']
- Related: ['14.14 STORE ANALYTICS', '15.2 AI DIRECTOR — GLOBAL CONTROL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.2 AI DIRECTOR — GLOBAL CONTROL SYSTEM
- Anchor: 15-2-ai-director-global-control-system
- Depends on: ['15.1 AI SYSTEMS OVERVIEW']
- Feeds into: ['AI Director Outputs:']
- Related: ['15.1 AI SYSTEMS OVERVIEW', 'AI Director Outputs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## AI Director Outputs:
- Anchor: ai-director-outputs
- Depends on: ['15.2 AI DIRECTOR — GLOBAL CONTROL SYSTEM']
- Feeds into: ['AI Director Tension Meter:']
- Related: ['15.2 AI DIRECTOR — GLOBAL CONTROL SYSTEM', 'AI Director Tension Meter:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## AI Director Tension Meter:
- Anchor: ai-director-tension-meter
- Depends on: ['AI Director Outputs:']
- Feeds into: ['15.3 DIRECTOR DECISION TREE']
- Related: ['AI Director Outputs:', '15.3 DIRECTOR DECISION TREE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.3 DIRECTOR DECISION TREE
- Anchor: 15-3-director-decision-tree
- Depends on: ['AI Director Tension Meter:']
- Feeds into: ['15.6 POLICE AI SYSTEM']
- Related: ['AI Director Tension Meter:', '15.6 POLICE AI SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.6 POLICE AI SYSTEM
- Anchor: 15-6-police-ai-system
- Depends on: ['15.3 DIRECTOR DECISION TREE']
- Feeds into: ['15.8 WORLD SIMULATION ENGINE']
- Related: ['15.3 DIRECTOR DECISION TREE', '15.8 WORLD SIMULATION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.8 WORLD SIMULATION ENGINE
- Anchor: 15-8-world-simulation-engine
- Depends on: ['15.6 POLICE AI SYSTEM']
- Feeds into: ['15.9 BOROUGH SIMULATION']
- Related: ['15.6 POLICE AI SYSTEM', '15.9 BOROUGH SIMULATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.9 BOROUGH SIMULATION
- Anchor: 15-9-borough-simulation
- Depends on: ['15.8 WORLD SIMULATION ENGINE']
- Feeds into: ['15.13 AI HOOKS INTO SMUGGLING']
- Related: ['15.8 WORLD SIMULATION ENGINE', '15.13 AI HOOKS INTO SMUGGLING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.13 AI HOOKS INTO SMUGGLING
- Anchor: 15-13-ai-hooks-into-smuggling
- Depends on: ['15.9 BOROUGH SIMULATION']
- Feeds into: ['15.15 ANTI-EXPLOIT AI SYSTEM']
- Related: ['15.9 BOROUGH SIMULATION', '15.15 ANTI-EXPLOIT AI SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.15 ANTI-EXPLOIT AI SYSTEM
- Anchor: 15-15-anti-exploit-ai-system
- Depends on: ['15.13 AI HOOKS INTO SMUGGLING']
- Feeds into: ['15.16 AI LOAD MANAGEMENT']
- Related: ['15.13 AI HOOKS INTO SMUGGLING', '15.16 AI LOAD MANAGEMENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15.16 AI LOAD MANAGEMENT
- Anchor: 15-16-ai-load-management
- Depends on: ['15.15 ANTI-EXPLOIT AI SYSTEM']
- Feeds into: ['Strength']
- Related: ['15.15 ANTI-EXPLOIT AI SYSTEM', 'Strength', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Strength
- Anchor: strength
- Depends on: ['15.16 AI LOAD MANAGEMENT']
- Feeds into: ['Defense']
- Related: ['15.16 AI LOAD MANAGEMENT', 'Defense', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Defense
- Anchor: defense
- Depends on: ['Strength']
- Feeds into: ['Speed']
- Related: ['Strength', 'Speed', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Speed
- Anchor: speed
- Depends on: ['Defense']
- Feeds into: ['Dexterity']
- Related: ['Defense', 'Dexterity', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Dexterity
- Anchor: dexterity
- Depends on: ['Speed']
- Feeds into: ['16.3 WEAPON CLASSES']
- Related: ['Speed', '16.3 WEAPON CLASSES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.3 WEAPON CLASSES
- Anchor: 16-3-weapon-classes
- Depends on: ['Dexterity']
- Feeds into: ['16.4 WEAPON ATTRIBUTES']
- Related: ['Dexterity', '16.4 WEAPON ATTRIBUTES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.4 WEAPON ATTRIBUTES
- Anchor: 16-4-weapon-attributes
- Depends on: ['16.3 WEAPON CLASSES']
- Feeds into: ['16.5 ARMOR SYSTEM']
- Related: ['16.3 WEAPON CLASSES', '16.5 ARMOR SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.5 ARMOR SYSTEM
- Anchor: 16-5-armor-system
- Depends on: ['16.4 WEAPON ATTRIBUTES']
- Feeds into: ['16.6 STATUS EFFECTS']
- Related: ['16.4 WEAPON ATTRIBUTES', '16.6 STATUS EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.6 STATUS EFFECTS
- Anchor: 16-6-status-effects
- Depends on: ['16.5 ARMOR SYSTEM']
- Feeds into: ['**Bleed**']
- Related: ['16.5 ARMOR SYSTEM', '**Bleed**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Bleed**
- Anchor: bleed
- Depends on: ['16.6 STATUS EFFECTS']
- Feeds into: ['**Stun**']
- Related: ['16.6 STATUS EFFECTS', '**Stun**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Stun**
- Anchor: stun
- Depends on: ['**Bleed**']
- Feeds into: ['**Suppression**']
- Related: ['**Bleed**', '**Suppression**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Suppression**
- Anchor: suppression
- Depends on: ['**Stun**']
- Feeds into: ['**Panic**']
- Related: ['**Stun**', '**Panic**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Panic**
- Anchor: panic
- Depends on: ['**Suppression**']
- Feeds into: ['**Fatigue**']
- Related: ['**Suppression**', '**Fatigue**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Fatigue**
- Anchor: fatigue
- Depends on: ['**Panic**']
- Feeds into: ['16.10 BOSS MECHANICS']
- Related: ['**Panic**', '16.10 BOSS MECHANICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.10 BOSS MECHANICS
- Anchor: 16-10-boss-mechanics
- Depends on: ['**Fatigue**']
- Feeds into: ['16.13 AI DIRECTOR HOOKS']
- Related: ['**Fatigue**', '16.13 AI DIRECTOR HOOKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.13 AI DIRECTOR HOOKS
- Anchor: 16-13-ai-director-hooks
- Depends on: ['16.10 BOSS MECHANICS']
- Feeds into: ['16.14 ANTI-EXPLOIT PROTECTIONS']
- Related: ['16.10 BOSS MECHANICS', '16.14 ANTI-EXPLOIT PROTECTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.14 ANTI-EXPLOIT PROTECTIONS
- Anchor: 16-14-anti-exploit-protections
- Depends on: ['16.13 AI DIRECTOR HOOKS']
- Feeds into: ['CHUNK 17 — ITEMS, CRAFTING, LOOT, MATERIAL TIERS & BLUEPRINTS']
- Related: ['16.13 AI DIRECTOR HOOKS', 'CHUNK 17 — ITEMS, CRAFTING, LOOT, MATERIAL TIERS & BLUEPRINTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 17 — ITEMS, CRAFTING, LOOT, MATERIAL TIERS & BLUEPRINTS
- Anchor: chunk-17-items-crafting-loot-material-tiers-blueprints
- Depends on: ['16.14 ANTI-EXPLOIT PROTECTIONS']
- Feeds into: ['17.1 ITEM SYSTEM OVERVIEW']
- Related: ['16.14 ANTI-EXPLOIT PROTECTIONS', '17.1 ITEM SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.1 ITEM SYSTEM OVERVIEW
- Anchor: 17-1-item-system-overview
- Depends on: ['CHUNK 17 — ITEMS, CRAFTING, LOOT, MATERIAL TIERS & BLUEPRINTS']
- Feeds into: ['17.2 MATERIAL TIER SYSTEM (T1 → T6)']
- Related: ['CHUNK 17 — ITEMS, CRAFTING, LOOT, MATERIAL TIERS & BLUEPRINTS', '17.2 MATERIAL TIER SYSTEM (T1 → T6)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.2 MATERIAL TIER SYSTEM (T1 → T6)
- Anchor: 17-2-material-tier-system-t1-t6
- Depends on: ['17.1 ITEM SYSTEM OVERVIEW']
- Feeds into: ['**Tier 1: Common**']
- Related: ['17.1 ITEM SYSTEM OVERVIEW', '**Tier 1: Common**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Tier 1: Common**
- Anchor: tier-1-common
- Depends on: ['17.2 MATERIAL TIER SYSTEM (T1 → T6)']
- Feeds into: ['**Tier 2: Uncommon**']
- Related: ['17.2 MATERIAL TIER SYSTEM (T1 → T6)', '**Tier 2: Uncommon**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Tier 2: Uncommon**
- Anchor: tier-2-uncommon
- Depends on: ['**Tier 1: Common**']
- Feeds into: ['**Tier 3: Rare**']
- Related: ['**Tier 1: Common**', '**Tier 3: Rare**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Tier 3: Rare**
- Anchor: tier-3-rare
- Depends on: ['**Tier 2: Uncommon**']
- Feeds into: ['**Tier 4: Epic**']
- Related: ['**Tier 2: Uncommon**', '**Tier 4: Epic**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Tier 4: Epic**
- Anchor: tier-4-epic
- Depends on: ['**Tier 3: Rare**']
- Feeds into: ['**Tier 5: Legendary**']
- Related: ['**Tier 3: Rare**', '**Tier 5: Legendary**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Tier 5: Legendary**
- Anchor: tier-5-legendary
- Depends on: ['**Tier 4: Epic**']
- Feeds into: ['17.3 BLUEPRINT SYSTEM']
- Related: ['**Tier 4: Epic**', '17.3 BLUEPRINT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.3 BLUEPRINT SYSTEM
- Anchor: 17-3-blueprint-system
- Depends on: ['**Tier 5: Legendary**']
- Feeds into: ['17.4 CRAFTING SYSTEM OVERVIEW']
- Related: ['**Tier 5: Legendary**', '17.4 CRAFTING SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.4 CRAFTING SYSTEM OVERVIEW
- Anchor: 17-4-crafting-system-overview
- Depends on: ['17.3 BLUEPRINT SYSTEM']
- Feeds into: ['17.5 WEAPON MOD CRAFTING']
- Related: ['17.3 BLUEPRINT SYSTEM', '17.5 WEAPON MOD CRAFTING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.5 WEAPON MOD CRAFTING
- Anchor: 17-5-weapon-mod-crafting
- Depends on: ['17.4 CRAFTING SYSTEM OVERVIEW']
- Feeds into: ['17.6 ARMOR UPGRADES']
- Related: ['17.4 CRAFTING SYSTEM OVERVIEW', '17.6 ARMOR UPGRADES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.6 ARMOR UPGRADES
- Anchor: 17-6-armor-upgrades
- Depends on: ['17.5 WEAPON MOD CRAFTING']
- Feeds into: ['17.7 CHEMICAL CRAFTING (CONSUMABLES)']
- Related: ['17.5 WEAPON MOD CRAFTING', '17.7 CHEMICAL CRAFTING (CONSUMABLES)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.7 CHEMICAL CRAFTING (CONSUMABLES)
- Anchor: 17-7-chemical-crafting-consumables
- Depends on: ['17.6 ARMOR UPGRADES']
- Feeds into: ['17.8 HACKING TOOL CRAFTING']
- Related: ['17.6 ARMOR UPGRADES', '17.8 HACKING TOOL CRAFTING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.8 HACKING TOOL CRAFTING
- Anchor: 17-8-hacking-tool-crafting
- Depends on: ['17.7 CHEMICAL CRAFTING (CONSUMABLES)']
- Feeds into: ['17.10 SMUGGLING CONTAINERS']
- Related: ['17.7 CHEMICAL CRAFTING (CONSUMABLES)', '17.10 SMUGGLING CONTAINERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.10 SMUGGLING CONTAINERS
- Anchor: 17-10-smuggling-containers
- Depends on: ['17.8 HACKING TOOL CRAFTING']
- Feeds into: ['17.12 LOOT SYSTEM OVERVIEW']
- Related: ['17.8 HACKING TOOL CRAFTING', '17.12 LOOT SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.12 LOOT SYSTEM OVERVIEW
- Anchor: 17-12-loot-system-overview
- Depends on: ['17.10 SMUGGLING CONTAINERS']
- Feeds into: ['17.13 LOOT TIERS']
- Related: ['17.10 SMUGGLING CONTAINERS', '17.13 LOOT TIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.13 LOOT TIERS
- Anchor: 17-13-loot-tiers
- Depends on: ['17.12 LOOT SYSTEM OVERVIEW']
- Feeds into: ['17.14 CONTRABAND SYSTEM']
- Related: ['17.12 LOOT SYSTEM OVERVIEW', '17.14 CONTRABAND SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.14 CONTRABAND SYSTEM
- Anchor: 17-14-contraband-system
- Depends on: ['17.13 LOOT TIERS']
- Feeds into: ['17.15 ITEM DURABILITY SYSTEM']
- Related: ['17.13 LOOT TIERS', '17.15 ITEM DURABILITY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.15 ITEM DURABILITY SYSTEM
- Anchor: 17-15-item-durability-system
- Depends on: ['17.14 CONTRABAND SYSTEM']
- Feeds into: ['17.16 ANTI-DUPLICATION & ITEM SECURITY']
- Related: ['17.14 CONTRABAND SYSTEM', '17.16 ANTI-DUPLICATION & ITEM SECURITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.16 ANTI-DUPLICATION & ITEM SECURITY
- Anchor: 17-16-anti-duplication-item-security
- Depends on: ['17.15 ITEM DURABILITY SYSTEM']
- Feeds into: ['Success Chance:']
- Related: ['17.15 ITEM DURABILITY SYSTEM', 'Success Chance:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Success Chance:
- Anchor: success-chance
- Depends on: ['17.16 ANTI-DUPLICATION & ITEM SECURITY']
- Feeds into: ['Heat Gain:']
- Related: ['17.16 ANTI-DUPLICATION & ITEM SECURITY', 'Heat Gain:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Heat Gain:
- Anchor: heat-gain
- Depends on: ['Success Chance:']
- Feeds into: ['Loot Quality:']
- Related: ['Success Chance:', 'Loot Quality:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Loot Quality:
- Anchor: loot-quality
- Depends on: ['Heat Gain:']
- Feeds into: ['PATH 1 — PICKPOCKETING & STREET THEFT']
- Related: ['Heat Gain:', 'PATH 1 — PICKPOCKETING & STREET THEFT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 1 — PICKPOCKETING & STREET THEFT
- Anchor: path-1-pickpocketing-street-theft
- Depends on: ['Loot Quality:']
- Feeds into: ['PATH 4 — BURGLARY & HOUSEBREAKING']
- Related: ['Loot Quality:', 'PATH 4 — BURGLARY & HOUSEBREAKING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 4 — BURGLARY & HOUSEBREAKING
- Anchor: path-4-burglary-housebreaking
- Depends on: ['PATH 1 — PICKPOCKETING & STREET THEFT']
- Feeds into: ['PATH 6 — ASSAULT & STREET VIOLENCE']
- Related: ['PATH 1 — PICKPOCKETING & STREET THEFT', 'PATH 6 — ASSAULT & STREET VIOLENCE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 6 — ASSAULT & STREET VIOLENCE
- Anchor: path-6-assault-street-violence
- Depends on: ['PATH 4 — BURGLARY & HOUSEBREAKING']
- Feeds into: ['PATH 7 — DRUG DEALING & DISTRIBUTION']
- Related: ['PATH 4 — BURGLARY & HOUSEBREAKING', 'PATH 7 — DRUG DEALING & DISTRIBUTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 7 — DRUG DEALING & DISTRIBUTION
- Anchor: path-7-drug-dealing-distribution
- Depends on: ['PATH 6 — ASSAULT & STREET VIOLENCE']
- Feeds into: ['PATH 9 — ROBBERY & ARMED HOLD-UPS']
- Related: ['PATH 6 — ASSAULT & STREET VIOLENCE', 'PATH 9 — ROBBERY & ARMED HOLD-UPS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 9 — ROBBERY & ARMED HOLD-UPS
- Anchor: path-9-robbery-armed-hold-ups
- Depends on: ['PATH 7 — DRUG DEALING & DISTRIBUTION']
- Feeds into: ['PATH 10 — SMUGGLING & IMPORT OPERATIONS']
- Related: ['PATH 7 — DRUG DEALING & DISTRIBUTION', 'PATH 10 — SMUGGLING & IMPORT OPERATIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 10 — SMUGGLING & IMPORT OPERATIONS
- Anchor: path-10-smuggling-import-operations
- Depends on: ['PATH 9 — ROBBERY & ARMED HOLD-UPS']
- Feeds into: ['PATH 11 — BLACKMAIL & EXTORTION']
- Related: ['PATH 9 — ROBBERY & ARMED HOLD-UPS', 'PATH 11 — BLACKMAIL & EXTORTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 11 — BLACKMAIL & EXTORTION
- Anchor: path-11-blackmail-extortion
- Depends on: ['PATH 10 — SMUGGLING & IMPORT OPERATIONS']
- Feeds into: ['PATH 12 — LOAN SHARKING & UNDERGROUND FINANCE']
- Related: ['PATH 10 — SMUGGLING & IMPORT OPERATIONS', 'PATH 12 — LOAN SHARKING & UNDERGROUND FINANCE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 12 — LOAN SHARKING & UNDERGROUND FINANCE
- Anchor: path-12-loan-sharking-underground-finance
- Depends on: ['PATH 11 — BLACKMAIL & EXTORTION']
- Feeds into: ['PATH 13 — ILLICIT GAMBLING OPERATIONS']
- Related: ['PATH 11 — BLACKMAIL & EXTORTION', 'PATH 13 — ILLICIT GAMBLING OPERATIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 13 — ILLICIT GAMBLING OPERATIONS
- Anchor: path-13-illicit-gambling-operations
- Depends on: ['PATH 12 — LOAN SHARKING & UNDERGROUND FINANCE']
- Feeds into: ['PATH 14 — WEAPON TRAFFICKING']
- Related: ['PATH 12 — LOAN SHARKING & UNDERGROUND FINANCE', 'PATH 14 — WEAPON TRAFFICKING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 14 — WEAPON TRAFFICKING
- Anchor: path-14-weapon-trafficking
- Depends on: ['PATH 13 — ILLICIT GAMBLING OPERATIONS']
- Feeds into: ['PATH 15 — ARTEFACT & MUSEUM THEFT']
- Related: ['PATH 13 — ILLICIT GAMBLING OPERATIONS', 'PATH 15 — ARTEFACT & MUSEUM THEFT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 15 — ARTEFACT & MUSEUM THEFT
- Anchor: path-15-artefact-museum-theft
- Depends on: ['PATH 14 — WEAPON TRAFFICKING']
- Feeds into: ['PATH 17 — KIDNAPPING & RANSOM']
- Related: ['PATH 14 — WEAPON TRAFFICKING', 'PATH 17 — KIDNAPPING & RANSOM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 17 — KIDNAPPING & RANSOM
- Anchor: path-17-kidnapping-ransom
- Depends on: ['PATH 15 — ARTEFACT & MUSEUM THEFT']
- Feeds into: ['PATH 18 — SYNDICATE HEISTS']
- Related: ['PATH 15 — ARTEFACT & MUSEUM THEFT', 'PATH 18 — SYNDICATE HEISTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATH 18 — SYNDICATE HEISTS
- Anchor: path-18-syndicate-heists
- Depends on: ['PATH 17 — KIDNAPPING & RANSOM']
- Feeds into: ['19.2 RANKED WAR SYSTEM (ELO-BASED)']
- Related: ['PATH 17 — KIDNAPPING & RANSOM', '19.2 RANKED WAR SYSTEM (ELO-BASED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.2 RANKED WAR SYSTEM (ELO-BASED)
- Anchor: 19-2-ranked-war-system-elo-based
- Depends on: ['PATH 18 — SYNDICATE HEISTS']
- Feeds into: ['ELO Rating Components:']
- Related: ['PATH 18 — SYNDICATE HEISTS', 'ELO Rating Components:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ELO Rating Components:
- Anchor: elo-rating-components
- Depends on: ['19.2 RANKED WAR SYSTEM (ELO-BASED)']
- Feeds into: ['War Matchmaking:']
- Related: ['19.2 RANKED WAR SYSTEM (ELO-BASED)', 'War Matchmaking:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## War Matchmaking:
- Anchor: war-matchmaking
- Depends on: ['ELO Rating Components:']
- Feeds into: ['War Tiers:']
- Related: ['ELO Rating Components:', 'War Tiers:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## War Tiers:
- Anchor: war-tiers
- Depends on: ['War Matchmaking:']
- Feeds into: ['19.3 WAR OBJECTIVES (MULTI-MODE)']
- Related: ['War Matchmaking:', '19.3 WAR OBJECTIVES (MULTI-MODE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.3 WAR OBJECTIVES (MULTI-MODE)
- Anchor: 19-3-war-objectives-multi-mode
- Depends on: ['War Tiers:']
- Feeds into: ['19.4 MORALE SYSTEM']
- Related: ['War Tiers:', '19.4 MORALE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.4 MORALE SYSTEM
- Anchor: 19-4-morale-system
- Depends on: ['19.3 WAR OBJECTIVES (MULTI-MODE)']
- Feeds into: ['19.5 LOGISTICS & SUPPLY LINES']
- Related: ['19.3 WAR OBJECTIVES (MULTI-MODE)', '19.5 LOGISTICS & SUPPLY LINES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.5 LOGISTICS & SUPPLY LINES
- Anchor: 19-5-logistics-supply-lines
- Depends on: ['19.4 MORALE SYSTEM']
- Feeds into: ['19.6 TERRITORY SYSTEM EXPANSION']
- Related: ['19.4 MORALE SYSTEM', '19.6 TERRITORY SYSTEM EXPANSION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.6 TERRITORY SYSTEM EXPANSION
- Anchor: 19-6-territory-system-expansion
- Depends on: ['19.5 LOGISTICS & SUPPLY LINES']
- Feeds into: ['Bonuses:']
- Related: ['19.5 LOGISTICS & SUPPLY LINES', 'Bonuses:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Bonuses:
- Anchor: bonuses
- Depends on: ['19.6 TERRITORY SYSTEM EXPANSION']
- Feeds into: ['19.7 TERRITORY WAR EVENTS']
- Related: ['19.6 TERRITORY SYSTEM EXPANSION', '19.7 TERRITORY WAR EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.7 TERRITORY WAR EVENTS
- Anchor: 19-7-territory-war-events
- Depends on: ['Bonuses:']
- Feeds into: ['19.8 RAID SYSTEM (PVE/PVP HYBRID)']
- Related: ['Bonuses:', '19.8 RAID SYSTEM (PVE/PVP HYBRID)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.8 RAID SYSTEM (PVE/PVP HYBRID)
- Anchor: 19-8-raid-system-pve-pvp-hybrid
- Depends on: ['19.7 TERRITORY WAR EVENTS']
- Feeds into: ['19.9 BLACK OPS SYSTEM (ELITE MISSIONS)']
- Related: ['19.7 TERRITORY WAR EVENTS', '19.9 BLACK OPS SYSTEM (ELITE MISSIONS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.9 BLACK OPS SYSTEM (ELITE MISSIONS)
- Anchor: 19-9-black-ops-system-elite-missions
- Depends on: ['19.8 RAID SYSTEM (PVE/PVP HYBRID)']
- Feeds into: ['**War Chains**']
- Related: ['19.8 RAID SYSTEM (PVE/PVP HYBRID)', '**War Chains**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **War Chains**
- Anchor: war-chains
- Depends on: ['19.9 BLACK OPS SYSTEM (ELITE MISSIONS)']
- Feeds into: ['19.13 SEASONAL WAR STRUCTURE']
- Related: ['19.9 BLACK OPS SYSTEM (ELITE MISSIONS)', '19.13 SEASONAL WAR STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.13 SEASONAL WAR STRUCTURE
- Anchor: 19-13-seasonal-war-structure
- Depends on: ['**War Chains**']
- Feeds into: ['19.14 AI DIRECTOR WARFARE INFLUENCE']
- Related: ['**War Chains**', '19.14 AI DIRECTOR WARFARE INFLUENCE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.14 AI DIRECTOR WARFARE INFLUENCE
- Anchor: 19-14-ai-director-warfare-influence
- Depends on: ['19.13 SEASONAL WAR STRUCTURE']
- Feeds into: ['19.15 ANTI-EXPLOIT WAR PROTECTIONS']
- Related: ['19.13 SEASONAL WAR STRUCTURE', '19.15 ANTI-EXPLOIT WAR PROTECTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.15 ANTI-EXPLOIT WAR PROTECTIONS
- Anchor: 19-15-anti-exploit-war-protections
- Depends on: ['19.14 AI DIRECTOR WARFARE INFLUENCE']
- Feeds into: ['20.1 MISSION SYSTEM EXPANSION OVERVIEW']
- Related: ['19.14 AI DIRECTOR WARFARE INFLUENCE', '20.1 MISSION SYSTEM EXPANSION OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.1 MISSION SYSTEM EXPANSION OVERVIEW
- Anchor: 20-1-mission-system-expansion-overview
- Depends on: ['19.15 ANTI-EXPLOIT WAR PROTECTIONS']
- Feeds into: ['20.2 MISSION TYPES (5-LAYER SYSTEM)']
- Related: ['19.15 ANTI-EXPLOIT WAR PROTECTIONS', '20.2 MISSION TYPES (5-LAYER SYSTEM)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.2 MISSION TYPES (5-LAYER SYSTEM)
- Anchor: 20-2-mission-types-5-layer-system
- Depends on: ['20.1 MISSION SYSTEM EXPANSION OVERVIEW']
- Feeds into: ['1. Story Missions (Handcrafted)']
- Related: ['20.1 MISSION SYSTEM EXPANSION OVERVIEW', '1. Story Missions (Handcrafted)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Story Missions (Handcrafted)
- Anchor: 1-story-missions-handcrafted
- Depends on: ['20.2 MISSION TYPES (5-LAYER SYSTEM)']
- Feeds into: ['2. Repeatable Missions']
- Related: ['20.2 MISSION TYPES (5-LAYER SYSTEM)', '2. Repeatable Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Repeatable Missions
- Anchor: 2-repeatable-missions
- Depends on: ['1. Story Missions (Handcrafted)']
- Feeds into: ['3. Procedural Missions']
- Related: ['1. Story Missions (Handcrafted)', '3. Procedural Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Procedural Missions
- Anchor: 3-procedural-missions
- Depends on: ['2. Repeatable Missions']
- Feeds into: ['5. Black Ops Missions']
- Related: ['2. Repeatable Missions', '5. Black Ops Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. Black Ops Missions
- Anchor: 5-black-ops-missions
- Depends on: ['3. Procedural Missions']
- Feeds into: ['20.3 MISSION GENERATOR FRAMEWORK']
- Related: ['3. Procedural Missions', '20.3 MISSION GENERATOR FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.3 MISSION GENERATOR FRAMEWORK
- Anchor: 20-3-mission-generator-framework
- Depends on: ['5. Black Ops Missions']
- Feeds into: ['Inputs:']
- Related: ['5. Black Ops Missions', 'Inputs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Inputs:
- Anchor: inputs
- Depends on: ['20.3 MISSION GENERATOR FRAMEWORK']
- Feeds into: ['Outputs:']
- Related: ['20.3 MISSION GENERATOR FRAMEWORK', 'Outputs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Outputs:
- Anchor: outputs
- Depends on: ['Inputs:']
- Feeds into: ['Generator Layers:']
- Related: ['Inputs:', 'Generator Layers:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Generator Layers:
- Anchor: generator-layers
- Depends on: ['Outputs:']
- Feeds into: ['Relationship Values:']
- Related: ['Outputs:', 'Relationship Values:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Relationship Values:
- Anchor: relationship-values
- Depends on: ['Generator Layers:']
- Feeds into: ['Relationship Inputs:']
- Related: ['Generator Layers:', 'Relationship Inputs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Relationship Inputs:
- Anchor: relationship-inputs
- Depends on: ['Relationship Values:']
- Feeds into: ['20.5 BRANCHING NARRATIVE FRAMEWORK']
- Related: ['Relationship Values:', '20.5 BRANCHING NARRATIVE FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.5 BRANCHING NARRATIVE FRAMEWORK
- Anchor: 20-5-branching-narrative-framework
- Depends on: ['Relationship Inputs:']
- Feeds into: ['Branch Types:']
- Related: ['Relationship Inputs:', 'Branch Types:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Branch Types:
- Anchor: branch-types
- Depends on: ['20.5 BRANCHING NARRATIVE FRAMEWORK']
- Feeds into: ['Choice Consequences:']
- Related: ['20.5 BRANCHING NARRATIVE FRAMEWORK', 'Choice Consequences:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Choice Consequences:
- Anchor: choice-consequences
- Depends on: ['Branch Types:']
- Feeds into: ['20.6 MISSION FLOW STRUCTURE']
- Related: ['Branch Types:', '20.6 MISSION FLOW STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.6 MISSION FLOW STRUCTURE
- Anchor: 20-6-mission-flow-structure
- Depends on: ['Choice Consequences:']
- Feeds into: ['20.7 MISSION OBJECTIVE TYPES']
- Related: ['Choice Consequences:', '20.7 MISSION OBJECTIVE TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.7 MISSION OBJECTIVE TYPES
- Anchor: 20-7-mission-objective-types
- Depends on: ['20.6 MISSION FLOW STRUCTURE']
- Feeds into: ['20.8 MISSION OBSTACLE SYSTEM']
- Related: ['20.6 MISSION FLOW STRUCTURE', '20.8 MISSION OBSTACLE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.8 MISSION OBSTACLE SYSTEM
- Anchor: 20-8-mission-obstacle-system
- Depends on: ['20.7 MISSION OBJECTIVE TYPES']
- Feeds into: ['20.9 AI DIRECTOR MISSION INFLUENCE']
- Related: ['20.7 MISSION OBJECTIVE TYPES', '20.9 AI DIRECTOR MISSION INFLUENCE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.9 AI DIRECTOR MISSION INFLUENCE
- Anchor: 20-9-ai-director-mission-influence
- Depends on: ['20.8 MISSION OBSTACLE SYSTEM']
- Feeds into: ['20.11 BLACK OPS MISSION SYSTEM']
- Related: ['20.8 MISSION OBSTACLE SYSTEM', '20.11 BLACK OPS MISSION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.11 BLACK OPS MISSION SYSTEM
- Anchor: 20-11-black-ops-mission-system
- Depends on: ['20.9 AI DIRECTOR MISSION INFLUENCE']
- Feeds into: ['20.12 MISSION LOOT & REWARD TABLES']
- Related: ['20.9 AI DIRECTOR MISSION INFLUENCE', '20.12 MISSION LOOT & REWARD TABLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.12 MISSION LOOT & REWARD TABLES
- Anchor: 20-12-mission-loot-reward-tables
- Depends on: ['20.11 BLACK OPS MISSION SYSTEM']
- Feeds into: ['20.13 MISSION ANTI-EXPLOIT SYSTEM']
- Related: ['20.11 BLACK OPS MISSION SYSTEM', '20.13 MISSION ANTI-EXPLOIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.13 MISSION ANTI-EXPLOIT SYSTEM
- Anchor: 20-13-mission-anti-exploit-system
- Depends on: ['20.12 MISSION LOOT & REWARD TABLES']
- Feeds into: ['CHUNK 21 — CITY SYSTEM & WORLD MAP (BOROUGHS, DISTRICTS, LANDMARKS)']
- Related: ['20.12 MISSION LOOT & REWARD TABLES', 'CHUNK 21 — CITY SYSTEM & WORLD MAP (BOROUGHS, DISTRICTS, LANDMARKS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 21 — CITY SYSTEM & WORLD MAP (BOROUGHS, DISTRICTS, LANDMARKS)
- Anchor: chunk-21-city-system-world-map-boroughs-districts-landmarks
- Depends on: ['20.13 MISSION ANTI-EXPLOIT SYSTEM']
- Feeds into: ['21.1 CITY SYSTEM OVERVIEW']
- Related: ['20.13 MISSION ANTI-EXPLOIT SYSTEM', '21.1 CITY SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.1 CITY SYSTEM OVERVIEW
- Anchor: 21-1-city-system-overview
- Depends on: ['CHUNK 21 — CITY SYSTEM & WORLD MAP (BOROUGHS, DISTRICTS, LANDMARKS)']
- Feeds into: ['21.2 BOROUGH LIST (LONDON-INSPIRED)']
- Related: ['CHUNK 21 — CITY SYSTEM & WORLD MAP (BOROUGHS, DISTRICTS, LANDMARKS)', '21.2 BOROUGH LIST (LONDON-INSPIRED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.2 BOROUGH LIST (LONDON-INSPIRED)
- Anchor: 21-2-borough-list-london-inspired
- Depends on: ['21.1 CITY SYSTEM OVERVIEW']
- Feeds into: ['1. Camden Borough']
- Related: ['21.1 CITY SYSTEM OVERVIEW', '1. Camden Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Camden Borough
- Anchor: 1-camden-borough
- Depends on: ['21.2 BOROUGH LIST (LONDON-INSPIRED)']
- Feeds into: ['2. Hackney Borough']
- Related: ['21.2 BOROUGH LIST (LONDON-INSPIRED)', '2. Hackney Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Hackney Borough
- Anchor: 2-hackney-borough
- Depends on: ['1. Camden Borough']
- Feeds into: ['3. Tower Borough (Tower Hamlets Inspired)']
- Related: ['1. Camden Borough', '3. Tower Borough (Tower Hamlets Inspired)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Tower Borough (Tower Hamlets Inspired)
- Anchor: 3-tower-borough-tower-hamlets-inspired
- Depends on: ['2. Hackney Borough']
- Feeds into: ['4. Southbank Borough']
- Related: ['2. Hackney Borough', '4. Southbank Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. Southbank Borough
- Anchor: 4-southbank-borough
- Depends on: ['3. Tower Borough (Tower Hamlets Inspired)']
- Feeds into: ['5. Westminster Borough']
- Related: ['3. Tower Borough (Tower Hamlets Inspired)', '5. Westminster Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. Westminster Borough
- Anchor: 5-westminster-borough
- Depends on: ['4. Southbank Borough']
- Feeds into: ['6. Brixton Borough']
- Related: ['4. Southbank Borough', '6. Brixton Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6. Brixton Borough
- Anchor: 6-brixton-borough
- Depends on: ['5. Westminster Borough']
- Feeds into: ['7. Peckham Borough']
- Related: ['5. Westminster Borough', '7. Peckham Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7. Peckham Borough
- Anchor: 7-peckham-borough
- Depends on: ['6. Brixton Borough']
- Feeds into: ['8. Stratford Borough']
- Related: ['6. Brixton Borough', '8. Stratford Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8. Stratford Borough
- Anchor: 8-stratford-borough
- Depends on: ['7. Peckham Borough']
- Feeds into: ['9. Heathrow Logistics Borough']
- Related: ['7. Peckham Borough', '9. Heathrow Logistics Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9. Heathrow Logistics Borough
- Anchor: 9-heathrow-logistics-borough
- Depends on: ['8. Stratford Borough']
- Feeds into: ['10. Blackwall Industrial Borough']
- Related: ['8. Stratford Borough', '10. Blackwall Industrial Borough', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10. Blackwall Industrial Borough
- Anchor: 10-blackwall-industrial-borough
- Depends on: ['9. Heathrow Logistics Borough']
- Feeds into: ['21.3 DISTRICT SYSTEM (MICRO-MAPS)']
- Related: ['9. Heathrow Logistics Borough', '21.3 DISTRICT SYSTEM (MICRO-MAPS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.3 DISTRICT SYSTEM (MICRO-MAPS)
- Anchor: 21-3-district-system-micro-maps
- Depends on: ['10. Blackwall Industrial Borough']
- Feeds into: ['21.4 LANDMARKS (UNIQUE GAMEPLAY NODES)']
- Related: ['10. Blackwall Industrial Borough', '21.4 LANDMARKS (UNIQUE GAMEPLAY NODES)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.4 LANDMARKS (UNIQUE GAMEPLAY NODES)
- Anchor: 21-4-landmarks-unique-gameplay-nodes
- Depends on: ['21.3 DISTRICT SYSTEM (MICRO-MAPS)']
- Feeds into: ['21.5 BOROUGH STATE SYSTEM']
- Related: ['21.3 DISTRICT SYSTEM (MICRO-MAPS)', '21.5 BOROUGH STATE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.5 BOROUGH STATE SYSTEM
- Anchor: 21-5-borough-state-system
- Depends on: ['21.4 LANDMARKS (UNIQUE GAMEPLAY NODES)']
- Feeds into: ['1. Heat Level']
- Related: ['21.4 LANDMARKS (UNIQUE GAMEPLAY NODES)', '1. Heat Level', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Heat Level
- Anchor: 1-heat-level
- Depends on: ['21.5 BOROUGH STATE SYSTEM']
- Feeds into: ['2. Gang Influence']
- Related: ['21.5 BOROUGH STATE SYSTEM', '2. Gang Influence', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Gang Influence
- Anchor: 2-gang-influence
- Depends on: ['1. Heat Level']
- Feeds into: ['4. Economic Stability']
- Related: ['1. Heat Level', '4. Economic Stability', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. Economic Stability
- Anchor: 4-economic-stability
- Depends on: ['2. Gang Influence']
- Feeds into: ['5. AI Director Tension']
- Related: ['2. Gang Influence', '5. AI Director Tension', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. AI Director Tension
- Anchor: 5-ai-director-tension
- Depends on: ['4. Economic Stability']
- Feeds into: ['21.6 CITY EVENT SYSTEM']
- Related: ['4. Economic Stability', '21.6 CITY EVENT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.6 CITY EVENT SYSTEM
- Anchor: 21-6-city-event-system
- Depends on: ['5. AI Director Tension']
- Feeds into: ['21.7 WORLD TRAVEL SYSTEM']
- Related: ['5. AI Director Tension', '21.7 WORLD TRAVEL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.7 WORLD TRAVEL SYSTEM
- Anchor: 21-7-world-travel-system
- Depends on: ['21.6 CITY EVENT SYSTEM']
- Feeds into: ['21.8 CITY UPGRADES & OWNERSHIP']
- Related: ['21.6 CITY EVENT SYSTEM', '21.8 CITY UPGRADES & OWNERSHIP', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.8 CITY UPGRADES & OWNERSHIP
- Anchor: 21-8-city-upgrades-ownership
- Depends on: ['21.7 WORLD TRAVEL SYSTEM']
- Feeds into: ['21.9 BOROUGH LOOT TABLES']
- Related: ['21.7 WORLD TRAVEL SYSTEM', '21.9 BOROUGH LOOT TABLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.9 BOROUGH LOOT TABLES
- Anchor: 21-9-borough-loot-tables
- Depends on: ['21.8 CITY UPGRADES & OWNERSHIP']
- Feeds into: ['21.11 CITY AI INTEGRATION']
- Related: ['21.8 CITY UPGRADES & OWNERSHIP', '21.11 CITY AI INTEGRATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.11 CITY AI INTEGRATION
- Anchor: 21-11-city-ai-integration
- Depends on: ['21.9 BOROUGH LOOT TABLES']
- Feeds into: ['21.12 ANTI-EXPLOIT CITY LOGIC']
- Related: ['21.9 BOROUGH LOOT TABLES', '21.12 ANTI-EXPLOIT CITY LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.12 ANTI-EXPLOIT CITY LOGIC
- Anchor: 21-12-anti-exploit-city-logic
- Depends on: ['21.11 CITY AI INTEGRATION']
- Feeds into: ['Street Class']
- Related: ['21.11 CITY AI INTEGRATION', 'Street Class', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Street Class
- Anchor: street-class
- Depends on: ['21.12 ANTI-EXPLOIT CITY LOGIC']
- Feeds into: ['Sport Class']
- Related: ['21.12 ANTI-EXPLOIT CITY LOGIC', 'Sport Class', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Sport Class
- Anchor: sport-class
- Depends on: ['Street Class']
- Feeds into: ['Luxury Class']
- Related: ['Street Class', 'Luxury Class', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Luxury Class
- Anchor: luxury-class
- Depends on: ['Sport Class']
- Feeds into: ['Off‑Road Class']
- Related: ['Sport Class', 'Off‑Road Class', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Off‑Road Class
- Anchor: off-road-class
- Depends on: ['Luxury Class']
- Feeds into: ['Utility / Vans']
- Related: ['Luxury Class', 'Utility / Vans', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Utility / Vans
- Anchor: utility-vans
- Depends on: ['Off‑Road Class']
- Feeds into: ['Engine Mods']
- Related: ['Off‑Road Class', 'Engine Mods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Engine Mods
- Anchor: engine-mods
- Depends on: ['Utility / Vans']
- Feeds into: ['Handling Mods']
- Related: ['Utility / Vans', 'Handling Mods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Handling Mods
- Anchor: handling-mods
- Depends on: ['Engine Mods']
- Feeds into: ['Stealth Mods']
- Related: ['Engine Mods', 'Stealth Mods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Stealth Mods
- Anchor: stealth-mods
- Depends on: ['Handling Mods']
- Feeds into: ['Armor Mods']
- Related: ['Handling Mods', 'Armor Mods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Armor Mods
- Anchor: armor-mods
- Depends on: ['Stealth Mods']
- Feeds into: ['Utility Mods']
- Related: ['Stealth Mods', 'Utility Mods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Utility Mods
- Anchor: utility-mods
- Depends on: ['Armor Mods']
- Feeds into: ['22.5 GARAGES & WORKSHOPS']
- Related: ['Armor Mods', '22.5 GARAGES & WORKSHOPS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 22.5 GARAGES & WORKSHOPS
- Anchor: 22-5-garages-workshops
- Depends on: ['Utility Mods']
- Feeds into: ['22.7 RACING SYSTEM (MULTIPLE FORMATS)']
- Related: ['Utility Mods', '22.7 RACING SYSTEM (MULTIPLE FORMATS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 22.7 RACING SYSTEM (MULTIPLE FORMATS)
- Anchor: 22-7-racing-system-multiple-formats
- Depends on: ['22.5 GARAGES & WORKSHOPS']
- Feeds into: ['1. Sprint Races']
- Related: ['22.5 GARAGES & WORKSHOPS', '1. Sprint Races', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Sprint Races
- Anchor: 1-sprint-races
- Depends on: ['22.7 RACING SYSTEM (MULTIPLE FORMATS)']
- Feeds into: ['2. Circuit Races']
- Related: ['22.7 RACING SYSTEM (MULTIPLE FORMATS)', '2. Circuit Races', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Circuit Races
- Anchor: 2-circuit-races
- Depends on: ['1. Sprint Races']
- Feeds into: ['3. Drag Races']
- Related: ['1. Sprint Races', '3. Drag Races', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Drag Races
- Anchor: 3-drag-races
- Depends on: ['2. Circuit Races']
- Feeds into: ['4. Outlaw Street Races']
- Related: ['2. Circuit Races', '4. Outlaw Street Races', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. Outlaw Street Races
- Anchor: 4-outlaw-street-races
- Depends on: ['3. Drag Races']
- Feeds into: ['6. Syndicate Invitational Cups']
- Related: ['3. Drag Races', '6. Syndicate Invitational Cups', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6. Syndicate Invitational Cups
- Anchor: 6-syndicate-invitational-cups
- Depends on: ['4. Outlaw Street Races']
- Feeds into: ['22.8 PURSUIT SYSTEM']
- Related: ['4. Outlaw Street Races', '22.8 PURSUIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 22.8 PURSUIT SYSTEM
- Anchor: 22-8-pursuit-system
- Depends on: ['6. Syndicate Invitational Cups']
- Feeds into: ['Storage Capacity']
- Related: ['6. Syndicate Invitational Cups', 'Storage Capacity', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Storage Capacity
- Anchor: storage-capacity
- Depends on: ['22.8 PURSUIT SYSTEM']
- Feeds into: ['Stealth Rating']
- Related: ['22.8 PURSUIT SYSTEM', 'Stealth Rating', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Stealth Rating
- Anchor: stealth-rating
- Depends on: ['Storage Capacity']
- Feeds into: ['Hidden Compartments']
- Related: ['Storage Capacity', 'Hidden Compartments', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Hidden Compartments
- Anchor: hidden-compartments
- Depends on: ['Stealth Rating']
- Feeds into: ['TIER 1 — Flats & Bedsits']
- Related: ['Stealth Rating', 'TIER 1 — Flats & Bedsits', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 1 — Flats & Bedsits
- Anchor: tier-1-flats-bedsits
- Depends on: ['Hidden Compartments']
- Feeds into: ['TIER 2 — Apartments']
- Related: ['Hidden Compartments', 'TIER 2 — Apartments', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 2 — Apartments
- Anchor: tier-2-apartments
- Depends on: ['TIER 1 — Flats & Bedsits']
- Feeds into: ['TIER 3 — Townhouses']
- Related: ['TIER 1 — Flats & Bedsits', 'TIER 3 — Townhouses', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 3 — Townhouses
- Anchor: tier-3-townhouses
- Depends on: ['TIER 2 — Apartments']
- Feeds into: ['TIER 4 — Luxury Penthouses']
- Related: ['TIER 2 — Apartments', 'TIER 4 — Luxury Penthouses', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 4 — Luxury Penthouses
- Anchor: tier-4-luxury-penthouses
- Depends on: ['TIER 3 — Townhouses']
- Feeds into: ['TIER 5 — Mansions']
- Related: ['TIER 3 — Townhouses', 'TIER 5 — Mansions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 5 — Mansions
- Anchor: tier-5-mansions
- Depends on: ['TIER 4 — Luxury Penthouses']
- Feeds into: ['TIER 6 — Syndicate Fortresses (ENDGAME)']
- Related: ['TIER 4 — Luxury Penthouses', 'TIER 6 — Syndicate Fortresses (ENDGAME)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 6 — Syndicate Fortresses (ENDGAME)
- Anchor: tier-6-syndicate-fortresses-endgame
- Depends on: ['TIER 5 — Mansions']
- Feeds into: ['23.3 ROOMS SYSTEM']
- Related: ['TIER 5 — Mansions', '23.3 ROOMS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 23.3 ROOMS SYSTEM
- Anchor: 23-3-rooms-system
- Depends on: ['TIER 6 — Syndicate Fortresses (ENDGAME)']
- Feeds into: ['Functional Rooms']
- Related: ['TIER 6 — Syndicate Fortresses (ENDGAME)', 'Functional Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Functional Rooms
- Anchor: functional-rooms
- Depends on: ['23.3 ROOMS SYSTEM']
- Feeds into: ['Luxury Rooms']
- Related: ['23.3 ROOMS SYSTEM', 'Luxury Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Luxury Rooms
- Anchor: luxury-rooms
- Depends on: ['Functional Rooms']
- Feeds into: ['Defense Rooms']
- Related: ['Functional Rooms', 'Defense Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Defense Rooms
- Anchor: defense-rooms
- Depends on: ['Luxury Rooms']
- Feeds into: ['Security Upgrades']
- Related: ['Luxury Rooms', 'Security Upgrades', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Security Upgrades
- Anchor: security-upgrades
- Depends on: ['Defense Rooms']
- Feeds into: ['Storage Upgrades']
- Related: ['Defense Rooms', 'Storage Upgrades', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Storage Upgrades
- Anchor: storage-upgrades
- Depends on: ['Security Upgrades']
- Feeds into: ['Smuggling Upgrades']
- Related: ['Security Upgrades', 'Smuggling Upgrades', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Smuggling Upgrades
- Anchor: smuggling-upgrades
- Depends on: ['Storage Upgrades']
- Feeds into: ['Comfort Upgrades']
- Related: ['Storage Upgrades', 'Comfort Upgrades', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Comfort Upgrades
- Anchor: comfort-upgrades
- Depends on: ['Smuggling Upgrades']
- Feeds into: ['Staff Types']
- Related: ['Smuggling Upgrades', 'Staff Types', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Staff Types
- Anchor: staff-types
- Depends on: ['Comfort Upgrades']
- Feeds into: ['23.7 STAFF MANAGEMENT']
- Related: ['Comfort Upgrades', '23.7 STAFF MANAGEMENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 23.7 STAFF MANAGEMENT
- Anchor: 23-7-staff-management
- Depends on: ['Staff Types']
- Feeds into: ['24.1 SYSTEM OVERVIEW']
- Related: ['Staff Types', '24.1 SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.1 SYSTEM OVERVIEW
- Anchor: 24-1-system-overview
- Depends on: ['23.7 STAFF MANAGEMENT']
- Feeds into: ['24.2 PLAYER JOBS SYSTEM']
- Related: ['23.7 STAFF MANAGEMENT', '24.2 PLAYER JOBS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.2 PLAYER JOBS SYSTEM
- Anchor: 24-2-player-jobs-system
- Depends on: ['24.1 SYSTEM OVERVIEW']
- Feeds into: ['Job Categories:']
- Related: ['24.1 SYSTEM OVERVIEW', 'Job Categories:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Job Categories:
- Anchor: job-categories
- Depends on: ['24.2 PLAYER JOBS SYSTEM']
- Feeds into: ['Example Progression:']
- Related: ['24.2 PLAYER JOBS SYSTEM', 'Example Progression:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Example Progression:
- Anchor: example-progression
- Depends on: ['Job Categories:']
- Feeds into: ['Job Tasks:']
- Related: ['Job Categories:', 'Job Tasks:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Job Tasks:
- Anchor: job-tasks
- Depends on: ['Example Progression:']
- Feeds into: ['Job Bonuses:']
- Related: ['Example Progression:', 'Job Bonuses:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Job Bonuses:
- Anchor: job-bonuses
- Depends on: ['Job Tasks:']
- Feeds into: ['24.3 PLAYER-OWNED COMPANIES']
- Related: ['Job Tasks:', '24.3 PLAYER-OWNED COMPANIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.3 PLAYER-OWNED COMPANIES
- Anchor: 24-3-player-owned-companies
- Depends on: ['Job Bonuses:']
- Feeds into: ['Requirements:']
- Related: ['Job Bonuses:', 'Requirements:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Requirements:
- Anchor: requirements
- Depends on: ['24.3 PLAYER-OWNED COMPANIES']
- Feeds into: ['Company Categories:']
- Related: ['24.3 PLAYER-OWNED COMPANIES', 'Company Categories:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Company Categories:
- Anchor: company-categories
- Depends on: ['Requirements:']
- Feeds into: ['24.4 COMPANY STATS']
- Related: ['Requirements:', '24.4 COMPANY STATS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.4 COMPANY STATS
- Anchor: 24-4-company-stats
- Depends on: ['Company Categories:']
- Feeds into: ['Player Employees:']
- Related: ['Company Categories:', 'Player Employees:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Player Employees:
- Anchor: player-employees
- Depends on: ['24.4 COMPANY STATS']
- Feeds into: ['24.6 COMPANY MANAGEMENT']
- Related: ['24.4 COMPANY STATS', '24.6 COMPANY MANAGEMENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.6 COMPANY MANAGEMENT
- Anchor: 24-6-company-management
- Depends on: ['Player Employees:']
- Feeds into: ['24.7 PRODUCTION & SUPPLY CHAIN SYSTEM']
- Related: ['Player Employees:', '24.7 PRODUCTION & SUPPLY CHAIN SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.7 PRODUCTION & SUPPLY CHAIN SYSTEM
- Anchor: 24-7-production-supply-chain-system
- Depends on: ['24.6 COMPANY MANAGEMENT']
- Feeds into: ['Example Chains:']
- Related: ['24.6 COMPANY MANAGEMENT', 'Example Chains:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Example Chains:
- Anchor: example-chains
- Depends on: ['24.7 PRODUCTION & SUPPLY CHAIN SYSTEM']
- Feeds into: ['24.10 COMPANY EVENTS']
- Related: ['24.7 PRODUCTION & SUPPLY CHAIN SYSTEM', '24.10 COMPANY EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.10 COMPANY EVENTS
- Anchor: 24-10-company-events
- Depends on: ['Example Chains:']
- Feeds into: ['24.11 COMPANY FINANCIAL SYSTEM']
- Related: ['Example Chains:', '24.11 COMPANY FINANCIAL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.11 COMPANY FINANCIAL SYSTEM
- Anchor: 24-11-company-financial-system
- Depends on: ['24.10 COMPANY EVENTS']
- Feeds into: ['24.12 ANTI-EXPLOIT COMPANY LOGIC']
- Related: ['24.10 COMPANY EVENTS', '24.12 ANTI-EXPLOIT COMPANY LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.12 ANTI-EXPLOIT COMPANY LOGIC
- Anchor: 24-12-anti-exploit-company-logic
- Depends on: ['24.11 COMPANY FINANCIAL SYSTEM']
- Feeds into: ['TIER 4 — Syndicate Exchange']
- Related: ['24.11 COMPANY FINANCIAL SYSTEM', 'TIER 4 — Syndicate Exchange', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 4 — Syndicate Exchange
- Anchor: tier-4-syndicate-exchange
- Depends on: ['24.12 ANTI-EXPLOIT COMPANY LOGIC']
- Feeds into: ['TIER 5 — International Underworld']
- Related: ['24.12 ANTI-EXPLOIT COMPANY LOGIC', 'TIER 5 — International Underworld', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 5 — International Underworld
- Anchor: tier-5-international-underworld
- Depends on: ['TIER 4 — Syndicate Exchange']
- Feeds into: ['TIER 6 — “The Deep Exchange” (Endgame)']
- Related: ['TIER 4 — Syndicate Exchange', 'TIER 6 — “The Deep Exchange” (Endgame)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TIER 6 — “The Deep Exchange” (Endgame)
- Anchor: tier-6-the-deep-exchange-endgame
- Depends on: ['TIER 5 — International Underworld']
- Feeds into: ['25.3 CONTRABAND CLASSES']
- Related: ['TIER 5 — International Underworld', '25.3 CONTRABAND CLASSES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.3 CONTRABAND CLASSES
- Anchor: 25-3-contraband-classes
- Depends on: ['TIER 6 — “The Deep Exchange” (Endgame)']
- Feeds into: ['Class A — Physical Goods']
- Related: ['TIER 6 — “The Deep Exchange” (Endgame)', 'Class A — Physical Goods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Class A — Physical Goods
- Anchor: class-a-physical-goods
- Depends on: ['25.3 CONTRABAND CLASSES']
- Feeds into: ['Class B — Chemical Goods']
- Related: ['25.3 CONTRABAND CLASSES', 'Class B — Chemical Goods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Class B — Chemical Goods
- Anchor: class-b-chemical-goods
- Depends on: ['Class A — Physical Goods']
- Feeds into: ['Class C — Digital Contraband']
- Related: ['Class A — Physical Goods', 'Class C — Digital Contraband', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Class C — Digital Contraband
- Anchor: class-c-digital-contraband
- Depends on: ['Class B — Chemical Goods']
- Feeds into: ['Class D — High-Risk Contraband']
- Related: ['Class B — Chemical Goods', 'Class D — High-Risk Contraband', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Class D — High-Risk Contraband
- Anchor: class-d-high-risk-contraband
- Depends on: ['Class C — Digital Contraband']
- Feeds into: ['25.4 SMUGGLING SYSTEM (FULL)']
- Related: ['Class C — Digital Contraband', '25.4 SMUGGLING SYSTEM (FULL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.4 SMUGGLING SYSTEM (FULL)
- Anchor: 25-4-smuggling-system-full
- Depends on: ['Class D — High-Risk Contraband']
- Feeds into: ['25.5 SMUGGLING RUN PHASES']
- Related: ['Class D — High-Risk Contraband', '25.5 SMUGGLING RUN PHASES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.5 SMUGGLING RUN PHASES
- Anchor: 25-5-smuggling-run-phases
- Depends on: ['25.4 SMUGGLING SYSTEM (FULL)']
- Feeds into: ['25.6 SMUGGLING RISK SYSTEM']
- Related: ['25.4 SMUGGLING SYSTEM (FULL)', '25.6 SMUGGLING RISK SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.6 SMUGGLING RISK SYSTEM
- Anchor: 25-6-smuggling-risk-system
- Depends on: ['25.5 SMUGGLING RUN PHASES']
- Feeds into: ['25.8 LAUNDERING SYSTEM']
- Related: ['25.5 SMUGGLING RUN PHASES', '25.8 LAUNDERING SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.8 LAUNDERING SYSTEM
- Anchor: 25-8-laundering-system
- Depends on: ['25.6 SMUGGLING RISK SYSTEM']
- Feeds into: ['25.9 FENCING STOLEN GOODS']
- Related: ['25.6 SMUGGLING RISK SYSTEM', '25.9 FENCING STOLEN GOODS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.9 FENCING STOLEN GOODS
- Anchor: 25-9-fencing-stolen-goods
- Depends on: ['25.8 LAUNDERING SYSTEM']
- Feeds into: ['25.10 SYNDICATE INFLUENCE SYSTEM']
- Related: ['25.8 LAUNDERING SYSTEM', '25.10 SYNDICATE INFLUENCE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.10 SYNDICATE INFLUENCE SYSTEM
- Anchor: 25-10-syndicate-influence-system
- Depends on: ['25.9 FENCING STOLEN GOODS']
- Feeds into: ['CHUNK 26 — CASINO, GAMBLING & RISK/REWARD SYSTEM']
- Related: ['25.9 FENCING STOLEN GOODS', 'CHUNK 26 — CASINO, GAMBLING & RISK/REWARD SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 26 — CASINO, GAMBLING & RISK/REWARD SYSTEM
- Anchor: chunk-26-casino-gambling-risk-reward-system
- Depends on: ['25.10 SYNDICATE INFLUENCE SYSTEM']
- Feeds into: ['26.1 CASINO SYSTEM OVERVIEW']
- Related: ['25.10 SYNDICATE INFLUENCE SYSTEM', '26.1 CASINO SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.1 CASINO SYSTEM OVERVIEW
- Anchor: 26-1-casino-system-overview
- Depends on: ['CHUNK 26 — CASINO, GAMBLING & RISK/REWARD SYSTEM']
- Feeds into: ['26.2 OFFICIAL CASINO GAMES']
- Related: ['CHUNK 26 — CASINO, GAMBLING & RISK/REWARD SYSTEM', '26.2 OFFICIAL CASINO GAMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.2 OFFICIAL CASINO GAMES
- Anchor: 26-2-official-casino-games
- Depends on: ['26.1 CASINO SYSTEM OVERVIEW']
- Feeds into: ['Blackjack']
- Related: ['26.1 CASINO SYSTEM OVERVIEW', 'Blackjack', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Blackjack
- Anchor: blackjack
- Depends on: ['26.2 OFFICIAL CASINO GAMES']
- Feeds into: ['Roulette']
- Related: ['26.2 OFFICIAL CASINO GAMES', 'Roulette', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Roulette
- Anchor: roulette
- Depends on: ['Blackjack']
- Feeds into: ['Slots']
- Related: ['Blackjack', 'Slots', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Slots
- Anchor: slots
- Depends on: ['Roulette']
- Feeds into: ['High-Low']
- Related: ['Roulette', 'High-Low', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## High-Low
- Anchor: high-low
- Depends on: ['Slots']
- Feeds into: ['Crash Game']
- Related: ['Slots', 'Crash Game', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Crash Game
- Anchor: crash-game
- Depends on: ['High-Low']
- Feeds into: ['Sports Betting (AI-Simulated)']
- Related: ['High-Low', 'Sports Betting (AI-Simulated)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Sports Betting (AI-Simulated)
- Anchor: sports-betting-ai-simulated
- Depends on: ['Crash Game']
- Feeds into: ['26.3 UNDERGROUND GAMBLING GAMES']
- Related: ['Crash Game', '26.3 UNDERGROUND GAMBLING GAMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.3 UNDERGROUND GAMBLING GAMES
- Anchor: 26-3-underground-gambling-games
- Depends on: ['Sports Betting (AI-Simulated)']
- Feeds into: ['Backroom Dice']
- Related: ['Sports Betting (AI-Simulated)', 'Backroom Dice', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Backroom Dice
- Anchor: backroom-dice
- Depends on: ['26.3 UNDERGROUND GAMBLING GAMES']
- Feeds into: ['Illegal Poker Rooms']
- Related: ['26.3 UNDERGROUND GAMBLING GAMES', 'Illegal Poker Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Illegal Poker Rooms
- Anchor: illegal-poker-rooms
- Depends on: ['Backroom Dice']
- Feeds into: ['Rigged Slot Machines']
- Related: ['Backroom Dice', 'Rigged Slot Machines', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rigged Slot Machines
- Anchor: rigged-slot-machines
- Depends on: ['Illegal Poker Rooms']
- Feeds into: ['High-Stakes Syndicate Games']
- Related: ['Illegal Poker Rooms', 'High-Stakes Syndicate Games', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## High-Stakes Syndicate Games
- Anchor: high-stakes-syndicate-games
- Depends on: ['Rigged Slot Machines']
- Feeds into: ['26.4 PVP GAMBLING MODES']
- Related: ['Rigged Slot Machines', '26.4 PVP GAMBLING MODES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.4 PVP GAMBLING MODES
- Anchor: 26-4-pvp-gambling-modes
- Depends on: ['High-Stakes Syndicate Games']
- Feeds into: ['Player Duels Betting']
- Related: ['High-Stakes Syndicate Games', 'Player Duels Betting', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Player Duels Betting
- Anchor: player-duels-betting
- Depends on: ['26.4 PVP GAMBLING MODES']
- Feeds into: ['26.5 HOUSE EDGE & FAIRNESS SYSTEM']
- Related: ['26.4 PVP GAMBLING MODES', '26.5 HOUSE EDGE & FAIRNESS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.5 HOUSE EDGE & FAIRNESS SYSTEM
- Anchor: 26-5-house-edge-fairness-system
- Depends on: ['Player Duels Betting']
- Feeds into: ['26.6 ADDICTION & COOL DOWN SYSTEM']
- Related: ['Player Duels Betting', '26.6 ADDICTION & COOL DOWN SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.6 ADDICTION & COOL DOWN SYSTEM
- Anchor: 26-6-addiction-cool-down-system
- Depends on: ['26.5 HOUSE EDGE & FAIRNESS SYSTEM']
- Feeds into: ['26.7 MONEY LAUNDERING HOOKS']
- Related: ['26.5 HOUSE EDGE & FAIRNESS SYSTEM', '26.7 MONEY LAUNDERING HOOKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.7 MONEY LAUNDERING HOOKS
- Anchor: 26-7-money-laundering-hooks
- Depends on: ['26.6 ADDICTION & COOL DOWN SYSTEM']
- Feeds into: ['26.8 CASINO EVENTS & JACKPOT SYSTEMS']
- Related: ['26.6 ADDICTION & COOL DOWN SYSTEM', '26.8 CASINO EVENTS & JACKPOT SYSTEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.8 CASINO EVENTS & JACKPOT SYSTEMS
- Anchor: 26-8-casino-events-jackpot-systems
- Depends on: ['26.7 MONEY LAUNDERING HOOKS']
- Feeds into: ['Seasonal Jackpot Pool']
- Related: ['26.7 MONEY LAUNDERING HOOKS', 'Seasonal Jackpot Pool', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Seasonal Jackpot Pool
- Anchor: seasonal-jackpot-pool
- Depends on: ['26.8 CASINO EVENTS & JACKPOT SYSTEMS']
- Feeds into: ['High-Roller Invitational']
- Related: ['26.8 CASINO EVENTS & JACKPOT SYSTEMS', 'High-Roller Invitational', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## High-Roller Invitational
- Anchor: high-roller-invitational
- Depends on: ['Seasonal Jackpot Pool']
- Feeds into: ['Lucky Night Events']
- Related: ['Seasonal Jackpot Pool', 'Lucky Night Events', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Lucky Night Events
- Anchor: lucky-night-events
- Depends on: ['High-Roller Invitational']
- Feeds into: ['26.9 ANTI-EXPLOIT CASINO LOGIC']
- Related: ['High-Roller Invitational', '26.9 ANTI-EXPLOIT CASINO LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.9 ANTI-EXPLOIT CASINO LOGIC
- Anchor: 26-9-anti-exploit-casino-logic
- Depends on: ['Lucky Night Events']
- Feeds into: ['Stock Variables:']
- Related: ['Lucky Night Events', 'Stock Variables:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Stock Variables:
- Anchor: stock-variables
- Depends on: ['26.9 ANTI-EXPLOIT CASINO LOGIC']
- Feeds into: ['Stock Actions:']
- Related: ['26.9 ANTI-EXPLOIT CASINO LOGIC', 'Stock Actions:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Stock Actions:
- Anchor: stock-actions
- Depends on: ['Stock Variables:']
- Feeds into: ['Dividends:']
- Related: ['Stock Variables:', 'Dividends:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Dividends:
- Anchor: dividends
- Depends on: ['Stock Actions:']
- Feeds into: ['27.3 COMPANY IPO SYSTEM']
- Related: ['Stock Actions:', '27.3 COMPANY IPO SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27.3 COMPANY IPO SYSTEM
- Anchor: 27-3-company-ipo-system
- Depends on: ['Dividends:']
- Feeds into: ['27.4 TAKEOVERS & HOSTILE ACQUISITIONS']
- Related: ['Dividends:', '27.4 TAKEOVERS & HOSTILE ACQUISITIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27.4 TAKEOVERS & HOSTILE ACQUISITIONS
- Anchor: 27-4-takeovers-hostile-acquisitions
- Depends on: ['27.3 COMPANY IPO SYSTEM']
- Feeds into: ['27.5 ECONOMIC EVENTS']
- Related: ['27.3 COMPANY IPO SYSTEM', '27.5 ECONOMIC EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27.5 ECONOMIC EVENTS
- Anchor: 27-5-economic-events
- Depends on: ['27.4 TAKEOVERS & HOSTILE ACQUISITIONS']
- Feeds into: ['27.7 GLOBAL PRICE INDEX (GPI)']
- Related: ['27.4 TAKEOVERS & HOSTILE ACQUISITIONS', '27.7 GLOBAL PRICE INDEX (GPI)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27.7 GLOBAL PRICE INDEX (GPI)
- Anchor: 27-7-global-price-index-gpi
- Depends on: ['27.5 ECONOMIC EVENTS']
- Feeds into: ['Futures Contracts']
- Related: ['27.5 ECONOMIC EVENTS', 'Futures Contracts', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Futures Contracts
- Anchor: futures-contracts
- Depends on: ['27.7 GLOBAL PRICE INDEX (GPI)']
- Feeds into: ['Options Trading']
- Related: ['27.7 GLOBAL PRICE INDEX (GPI)', 'Options Trading', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Options Trading
- Anchor: options-trading
- Depends on: ['Futures Contracts']
- Feeds into: ['Government Bonds']
- Related: ['Futures Contracts', 'Government Bonds', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Government Bonds
- Anchor: government-bonds
- Depends on: ['Options Trading']
- Feeds into: ['CHUNK 28 — SOCIAL SYSTEMS (MAIL, MESSENGER, FEEDS, PROFILES, GROUPS, SAFETY)']
- Related: ['Options Trading', 'CHUNK 28 — SOCIAL SYSTEMS (MAIL, MESSENGER, FEEDS, PROFILES, GROUPS, SAFETY)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 28 — SOCIAL SYSTEMS (MAIL, MESSENGER, FEEDS, PROFILES, GROUPS, SAFETY)
- Anchor: chunk-28-social-systems-mail-messenger-feeds-profiles-groups-safety
- Depends on: ['Government Bonds']
- Feeds into: ['28.1 SOCIAL SYSTEM OVERVIEW']
- Related: ['Government Bonds', '28.1 SOCIAL SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.1 SOCIAL SYSTEM OVERVIEW
- Anchor: 28-1-social-system-overview
- Depends on: ['CHUNK 28 — SOCIAL SYSTEMS (MAIL, MESSENGER, FEEDS, PROFILES, GROUPS, SAFETY)']
- Feeds into: ['28.2 MAIL SYSTEM (ASYNC MESSAGING)']
- Related: ['CHUNK 28 — SOCIAL SYSTEMS (MAIL, MESSENGER, FEEDS, PROFILES, GROUPS, SAFETY)', '28.2 MAIL SYSTEM (ASYNC MESSAGING)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.2 MAIL SYSTEM (ASYNC MESSAGING)
- Anchor: 28-2-mail-system-async-messaging
- Depends on: ['28.1 SOCIAL SYSTEM OVERVIEW']
- Feeds into: ['28.3 REAL-TIME MESSENGER (LIVE CHAT)']
- Related: ['28.1 SOCIAL SYSTEM OVERVIEW', '28.3 REAL-TIME MESSENGER (LIVE CHAT)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.3 REAL-TIME MESSENGER (LIVE CHAT)
- Anchor: 28-3-real-time-messenger-live-chat
- Depends on: ['28.2 MAIL SYSTEM (ASYNC MESSAGING)']
- Feeds into: ['28.4 PUBLIC FEEDS']
- Related: ['28.2 MAIL SYSTEM (ASYNC MESSAGING)', '28.4 PUBLIC FEEDS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.4 PUBLIC FEEDS
- Anchor: 28-4-public-feeds
- Depends on: ['28.3 REAL-TIME MESSENGER (LIVE CHAT)']
- Feeds into: ['**City Feed**']
- Related: ['28.3 REAL-TIME MESSENGER (LIVE CHAT)', '**City Feed**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **City Feed**
- Anchor: city-feed
- Depends on: ['28.4 PUBLIC FEEDS']
- Feeds into: ['**Event Feed**']
- Related: ['28.4 PUBLIC FEEDS', '**Event Feed**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Event Feed**
- Anchor: event-feed
- Depends on: ['**City Feed**']
- Feeds into: ['28.5 PLAYER PROFILES']
- Related: ['**City Feed**', '28.5 PLAYER PROFILES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.5 PLAYER PROFILES
- Anchor: 28-5-player-profiles
- Depends on: ['**Event Feed**']
- Feeds into: ['28.6 REPUTATION & SOCIAL MERITS']
- Related: ['**Event Feed**', '28.6 REPUTATION & SOCIAL MERITS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.6 REPUTATION & SOCIAL MERITS
- Anchor: 28-6-reputation-social-merits
- Depends on: ['28.5 PLAYER PROFILES']
- Feeds into: ['28.7 FRIENDS & GROUPS']
- Related: ['28.5 PLAYER PROFILES', '28.7 FRIENDS & GROUPS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.7 FRIENDS & GROUPS
- Anchor: 28-7-friends-groups
- Depends on: ['28.6 REPUTATION & SOCIAL MERITS']
- Feeds into: ['28.8 REPORTING & MODERATION PIPELINE']
- Related: ['28.6 REPUTATION & SOCIAL MERITS', '28.8 REPORTING & MODERATION PIPELINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.8 REPORTING & MODERATION PIPELINE
- Anchor: 28-8-reporting-moderation-pipeline
- Depends on: ['28.7 FRIENDS & GROUPS']
- Feeds into: ['28.9 SAFETY & ANTI-ABUSE SYSTEMS']
- Related: ['28.7 FRIENDS & GROUPS', '28.9 SAFETY & ANTI-ABUSE SYSTEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.9 SAFETY & ANTI-ABUSE SYSTEMS
- Anchor: 28-9-safety-anti-abuse-systems
- Depends on: ['28.8 REPORTING & MODERATION PIPELINE']
- Feeds into: ['Anti-Spam']
- Related: ['28.8 REPORTING & MODERATION PIPELINE', 'Anti-Spam', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Anti-Spam
- Anchor: anti-spam
- Depends on: ['28.9 SAFETY & ANTI-ABUSE SYSTEMS']
- Feeds into: ['Anti-Scam']
- Related: ['28.9 SAFETY & ANTI-ABUSE SYSTEMS', 'Anti-Scam', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Anti-Scam
- Anchor: anti-scam
- Depends on: ['Anti-Spam']
- Feeds into: ['Anti-Impersonation']
- Related: ['Anti-Spam', 'Anti-Impersonation', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Anti-Impersonation
- Anchor: anti-impersonation
- Depends on: ['Anti-Scam']
- Feeds into: ['Anti-Alt Network Abuse']
- Related: ['Anti-Scam', 'Anti-Alt Network Abuse', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Anti-Alt Network Abuse
- Anchor: anti-alt-network-abuse
- Depends on: ['Anti-Impersonation']
- Feeds into: ['28.10 SOCIAL EVENTS']
- Related: ['Anti-Impersonation', '28.10 SOCIAL EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.10 SOCIAL EVENTS
- Anchor: 28-10-social-events
- Depends on: ['Anti-Alt Network Abuse']
- Feeds into: ['CHUNK 30 — CITY SYSTEM (BOROUGHS, HEAT, WEATHER, TIME, SHOPS, EVENTS)']
- Related: ['Anti-Alt Network Abuse', 'CHUNK 30 — CITY SYSTEM (BOROUGHS, HEAT, WEATHER, TIME, SHOPS, EVENTS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 30 — CITY SYSTEM (BOROUGHS, HEAT, WEATHER, TIME, SHOPS, EVENTS)
- Anchor: chunk-30-city-system-boroughs-heat-weather-time-shops-events
- Depends on: ['28.10 SOCIAL EVENTS']
- Feeds into: ['30.1 CITY SYSTEM OVERVIEW']
- Related: ['28.10 SOCIAL EVENTS', '30.1 CITY SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.1 CITY SYSTEM OVERVIEW
- Anchor: 30-1-city-system-overview
- Depends on: ['CHUNK 30 — CITY SYSTEM (BOROUGHS, HEAT, WEATHER, TIME, SHOPS, EVENTS)']
- Feeds into: ['30.2 BOROUGH SYSTEM']
- Related: ['CHUNK 30 — CITY SYSTEM (BOROUGHS, HEAT, WEATHER, TIME, SHOPS, EVENTS)', '30.2 BOROUGH SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.2 BOROUGH SYSTEM
- Anchor: 30-2-borough-system
- Depends on: ['30.1 CITY SYSTEM OVERVIEW']
- Feeds into: ['Example Borough Types:']
- Related: ['30.1 CITY SYSTEM OVERVIEW', 'Example Borough Types:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Example Borough Types:
- Anchor: example-borough-types
- Depends on: ['30.2 BOROUGH SYSTEM']
- Feeds into: ['30.3 HEAT SYSTEM (CITY‑WIDE + BOROUGH‑LEVEL)']
- Related: ['30.2 BOROUGH SYSTEM', '30.3 HEAT SYSTEM (CITY‑WIDE + BOROUGH‑LEVEL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.3 HEAT SYSTEM (CITY‑WIDE + BOROUGH‑LEVEL)
- Anchor: 30-3-heat-system-city-wide-borough-level
- Depends on: ['Example Borough Types:']
- Feeds into: ['Heat Levels:']
- Related: ['Example Borough Types:', 'Heat Levels:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Heat Levels:
- Anchor: heat-levels
- Depends on: ['30.3 HEAT SYSTEM (CITY‑WIDE + BOROUGH‑LEVEL)']
- Feeds into: ['30.4 WEATHER SYSTEM']
- Related: ['30.3 HEAT SYSTEM (CITY‑WIDE + BOROUGH‑LEVEL)', '30.4 WEATHER SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.4 WEATHER SYSTEM
- Anchor: 30-4-weather-system
- Depends on: ['Heat Levels:']
- Feeds into: ['30.5 TIME‑OF‑DAY SYSTEM']
- Related: ['Heat Levels:', '30.5 TIME‑OF‑DAY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.5 TIME‑OF‑DAY SYSTEM
- Anchor: 30-5-time-of-day-system
- Depends on: ['30.4 WEATHER SYSTEM']
- Feeds into: ['Day Cycle:']
- Related: ['30.4 WEATHER SYSTEM', 'Day Cycle:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Day Cycle:
- Anchor: day-cycle
- Depends on: ['30.5 TIME‑OF‑DAY SYSTEM']
- Feeds into: ['30.7 SHOPS & SERVICES']
- Related: ['30.5 TIME‑OF‑DAY SYSTEM', '30.7 SHOPS & SERVICES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.7 SHOPS & SERVICES
- Anchor: 30-7-shops-services
- Depends on: ['Day Cycle:']
- Feeds into: ['Legal Shops:']
- Related: ['Day Cycle:', 'Legal Shops:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Legal Shops:
- Anchor: legal-shops
- Depends on: ['30.7 SHOPS & SERVICES']
- Feeds into: ['Illegal Shops:']
- Related: ['30.7 SHOPS & SERVICES', 'Illegal Shops:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Illegal Shops:
- Anchor: illegal-shops
- Depends on: ['Legal Shops:']
- Feeds into: ['30.8 CITY EVENTS (LOCAL + GLOBAL)']
- Related: ['Legal Shops:', '30.8 CITY EVENTS (LOCAL + GLOBAL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.8 CITY EVENTS (LOCAL + GLOBAL)
- Anchor: 30-8-city-events-local-global
- Depends on: ['Illegal Shops:']
- Feeds into: ['Local Borough Events:']
- Related: ['Illegal Shops:', 'Local Borough Events:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Local Borough Events:
- Anchor: local-borough-events
- Depends on: ['30.8 CITY EVENTS (LOCAL + GLOBAL)']
- Feeds into: ['City‑Wide Events:']
- Related: ['30.8 CITY EVENTS (LOCAL + GLOBAL)', 'City‑Wide Events:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## City‑Wide Events:
- Anchor: city-wide-events
- Depends on: ['Local Borough Events:']
- Feeds into: ['30.9 LANDMARKS & SPECIAL AREAS']
- Related: ['Local Borough Events:', '30.9 LANDMARKS & SPECIAL AREAS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.9 LANDMARKS & SPECIAL AREAS
- Anchor: 30-9-landmarks-special-areas
- Depends on: ['City‑Wide Events:']
- Feeds into: ['30.10 AI DIRECTOR CITY MANAGEMENT']
- Related: ['City‑Wide Events:', '30.10 AI DIRECTOR CITY MANAGEMENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.10 AI DIRECTOR CITY MANAGEMENT
- Anchor: 30-10-ai-director-city-management
- Depends on: ['30.9 LANDMARKS & SPECIAL AREAS']
- Feeds into: ['30.11 CITY ANTI‑EXPLOIT LOGIC']
- Related: ['30.9 LANDMARKS & SPECIAL AREAS', '30.11 CITY ANTI‑EXPLOIT LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.11 CITY ANTI‑EXPLOIT LOGIC
- Anchor: 30-11-city-anti-exploit-logic
- Depends on: ['30.10 AI DIRECTOR CITY MANAGEMENT']
- Feeds into: ['31.1 TRAVEL & TRANSPORT OVERVIEW']
- Related: ['30.10 AI DIRECTOR CITY MANAGEMENT', '31.1 TRAVEL & TRANSPORT OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.1 TRAVEL & TRANSPORT OVERVIEW
- Anchor: 31-1-travel-transport-overview
- Depends on: ['30.11 CITY ANTI‑EXPLOIT LOGIC']
- Feeds into: ['31.5 PUBLIC TRANSPORT SYSTEM']
- Related: ['30.11 CITY ANTI‑EXPLOIT LOGIC', '31.5 PUBLIC TRANSPORT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.5 PUBLIC TRANSPORT SYSTEM
- Anchor: 31-5-public-transport-system
- Depends on: ['31.1 TRAVEL & TRANSPORT OVERVIEW']
- Feeds into: ['Train Network']
- Related: ['31.1 TRAVEL & TRANSPORT OVERVIEW', 'Train Network', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Train Network
- Anchor: train-network
- Depends on: ['31.5 PUBLIC TRANSPORT SYSTEM']
- Feeds into: ['Tube System (Underground)']
- Related: ['31.5 PUBLIC TRANSPORT SYSTEM', 'Tube System (Underground)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tube System (Underground)
- Anchor: tube-system-underground
- Depends on: ['Train Network']
- Feeds into: ['Bus System']
- Related: ['Train Network', 'Bus System', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Bus System
- Anchor: bus-system
- Depends on: ['Tube System (Underground)']
- Feeds into: ['31.6 FAST TRAVEL NETWORK']
- Related: ['Tube System (Underground)', '31.6 FAST TRAVEL NETWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.6 FAST TRAVEL NETWORK
- Anchor: 31-6-fast-travel-network
- Depends on: ['Bus System']
- Feeds into: ['31.8 DELIVERY / ESCAPE / CHASE MISSIONS']
- Related: ['Bus System', '31.8 DELIVERY / ESCAPE / CHASE MISSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.8 DELIVERY / ESCAPE / CHASE MISSIONS
- Anchor: 31-8-delivery-escape-chase-missions
- Depends on: ['31.6 FAST TRAVEL NETWORK']
- Feeds into: ['Delivery Missions']
- Related: ['31.6 FAST TRAVEL NETWORK', 'Delivery Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Delivery Missions
- Anchor: delivery-missions
- Depends on: ['31.8 DELIVERY / ESCAPE / CHASE MISSIONS']
- Feeds into: ['Escape Missions']
- Related: ['31.8 DELIVERY / ESCAPE / CHASE MISSIONS', 'Escape Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Escape Missions
- Anchor: escape-missions
- Depends on: ['Delivery Missions']
- Feeds into: ['Chase Missions']
- Related: ['Delivery Missions', 'Chase Missions', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Chase Missions
- Anchor: chase-missions
- Depends on: ['Escape Missions']
- Feeds into: ['31.9 OUT-OF-CITY & INTERNATIONAL TRAVEL']
- Related: ['Escape Missions', '31.9 OUT-OF-CITY & INTERNATIONAL TRAVEL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.9 OUT-OF-CITY & INTERNATIONAL TRAVEL
- Anchor: 31-9-out-of-city-international-travel
- Depends on: ['Chase Missions']
- Feeds into: ['31.10 TRAVEL RISK SYSTEM']
- Related: ['Chase Missions', '31.10 TRAVEL RISK SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.10 TRAVEL RISK SYSTEM
- Anchor: 31-10-travel-risk-system
- Depends on: ['31.9 OUT-OF-CITY & INTERNATIONAL TRAVEL']
- Feeds into: ['31.11 TRAVEL EVENTS']
- Related: ['31.9 OUT-OF-CITY & INTERNATIONAL TRAVEL', '31.11 TRAVEL EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.11 TRAVEL EVENTS
- Anchor: 31-11-travel-events
- Depends on: ['31.10 TRAVEL RISK SYSTEM']
- Feeds into: ['31.12 AI DIRECTOR TRAVEL CONTROL']
- Related: ['31.10 TRAVEL RISK SYSTEM', '31.12 AI DIRECTOR TRAVEL CONTROL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.12 AI DIRECTOR TRAVEL CONTROL
- Anchor: 31-12-ai-director-travel-control
- Depends on: ['31.11 TRAVEL EVENTS']
- Feeds into: ['31.13 ANTI-EXPLOIT TRAVEL LOGIC']
- Related: ['31.11 TRAVEL EVENTS', '31.13 ANTI-EXPLOIT TRAVEL LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.13 ANTI-EXPLOIT TRAVEL LOGIC
- Anchor: 31-13-anti-exploit-travel-logic
- Depends on: ['31.12 AI DIRECTOR TRAVEL CONTROL']
- Feeds into: ['CHUNK 32 — MISSIONS, QUESTS, HEISTS & STORYLINE SYSTEM']
- Related: ['31.12 AI DIRECTOR TRAVEL CONTROL', 'CHUNK 32 — MISSIONS, QUESTS, HEISTS & STORYLINE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 32 — MISSIONS, QUESTS, HEISTS & STORYLINE SYSTEM
- Anchor: chunk-32-missions-quests-heists-storyline-system
- Depends on: ['31.13 ANTI-EXPLOIT TRAVEL LOGIC']
- Feeds into: ['32.1 MISSION SYSTEM OVERVIEW']
- Related: ['31.13 ANTI-EXPLOIT TRAVEL LOGIC', '32.1 MISSION SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.1 MISSION SYSTEM OVERVIEW
- Anchor: 32-1-mission-system-overview
- Depends on: ['CHUNK 32 — MISSIONS, QUESTS, HEISTS & STORYLINE SYSTEM']
- Feeds into: ['32.2 MISSION TYPES']
- Related: ['CHUNK 32 — MISSIONS, QUESTS, HEISTS & STORYLINE SYSTEM', '32.2 MISSION TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.2 MISSION TYPES
- Anchor: 32-2-mission-types
- Depends on: ['32.1 MISSION SYSTEM OVERVIEW']
- Feeds into: ['**Story Missions**']
- Related: ['32.1 MISSION SYSTEM OVERVIEW', '**Story Missions**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Story Missions**
- Anchor: story-missions
- Depends on: ['32.2 MISSION TYPES']
- Feeds into: ['**Daily Missions**']
- Related: ['32.2 MISSION TYPES', '**Daily Missions**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Daily Missions**
- Anchor: daily-missions
- Depends on: ['**Story Missions**']
- Feeds into: ['**Procedural Missions**']
- Related: ['**Story Missions**', '**Procedural Missions**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Procedural Missions**
- Anchor: procedural-missions
- Depends on: ['**Daily Missions**']
- Feeds into: ['**Syndicate Missions**']
- Related: ['**Daily Missions**', '**Syndicate Missions**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## **Syndicate Missions**
- Anchor: syndicate-missions
- Depends on: ['**Procedural Missions**']
- Feeds into: ['32.3 MISSION STRUCTURE']
- Related: ['**Procedural Missions**', '32.3 MISSION STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.3 MISSION STRUCTURE
- Anchor: 32-3-mission-structure
- Depends on: ['**Syndicate Missions**']
- Feeds into: ['32.4 HEIST SYSTEM (AAA MULTI-PHASE MISSIONS)']
- Related: ['**Syndicate Missions**', '32.4 HEIST SYSTEM (AAA MULTI-PHASE MISSIONS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.4 HEIST SYSTEM (AAA MULTI-PHASE MISSIONS)
- Anchor: 32-4-heist-system-aaa-multi-phase-missions
- Depends on: ['32.3 MISSION STRUCTURE']
- Feeds into: ['32.5 PROCEDURAL MISSION GENERATOR (PMG)']
- Related: ['32.3 MISSION STRUCTURE', '32.5 PROCEDURAL MISSION GENERATOR (PMG)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.5 PROCEDURAL MISSION GENERATOR (PMG)
- Anchor: 32-5-procedural-mission-generator-pmg
- Depends on: ['32.4 HEIST SYSTEM (AAA MULTI-PHASE MISSIONS)']
- Feeds into: ['32.6 DYNAMIC STORYLINES']
- Related: ['32.4 HEIST SYSTEM (AAA MULTI-PHASE MISSIONS)', '32.6 DYNAMIC STORYLINES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.6 DYNAMIC STORYLINES
- Anchor: 32-6-dynamic-storylines
- Depends on: ['32.5 PROCEDURAL MISSION GENERATOR (PMG)']
- Feeds into: ['32.8 MISSION REWARD SYSTEM']
- Related: ['32.5 PROCEDURAL MISSION GENERATOR (PMG)', '32.8 MISSION REWARD SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.8 MISSION REWARD SYSTEM
- Anchor: 32-8-mission-reward-system
- Depends on: ['32.6 DYNAMIC STORYLINES']
- Feeds into: ['32.9 AI DIRECTOR MISSION CONTROL']
- Related: ['32.6 DYNAMIC STORYLINES', '32.9 AI DIRECTOR MISSION CONTROL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.9 AI DIRECTOR MISSION CONTROL
- Anchor: 32-9-ai-director-mission-control
- Depends on: ['32.8 MISSION REWARD SYSTEM']
- Feeds into: ['32.10 MISSION ANTI-EXPLOIT LOGIC']
- Related: ['32.8 MISSION REWARD SYSTEM', '32.10 MISSION ANTI-EXPLOIT LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.10 MISSION ANTI-EXPLOIT LOGIC
- Anchor: 32-10-mission-anti-exploit-logic
- Depends on: ['32.9 AI DIRECTOR MISSION CONTROL']
- Feeds into: ['33.5 WEAPON CATEGORIES & MECHANICS']
- Related: ['32.9 AI DIRECTOR MISSION CONTROL', '33.5 WEAPON CATEGORIES & MECHANICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 33.5 WEAPON CATEGORIES & MECHANICS
- Anchor: 33-5-weapon-categories-mechanics
- Depends on: ['32.10 MISSION ANTI-EXPLOIT LOGIC']
- Feeds into: ['Weapon Categories:']
- Related: ['32.10 MISSION ANTI-EXPLOIT LOGIC', 'Weapon Categories:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Weapon Categories:
- Anchor: weapon-categories
- Depends on: ['33.5 WEAPON CATEGORIES & MECHANICS']
- Feeds into: ['33.6 ARMOUR SYSTEM']
- Related: ['33.5 WEAPON CATEGORIES & MECHANICS', '33.6 ARMOUR SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 33.6 ARMOUR SYSTEM
- Anchor: 33-6-armour-system
- Depends on: ['Weapon Categories:']
- Feeds into: ['33.7 STATUS EFFECTS (FULL LIST)']
- Related: ['Weapon Categories:', '33.7 STATUS EFFECTS (FULL LIST)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 33.7 STATUS EFFECTS (FULL LIST)
- Anchor: 33-7-status-effects-full-list
- Depends on: ['33.6 ARMOUR SYSTEM']
- Feeds into: ['Physical Effects:']
- Related: ['33.6 ARMOUR SYSTEM', 'Physical Effects:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Physical Effects:
- Anchor: physical-effects
- Depends on: ['33.7 STATUS EFFECTS (FULL LIST)']
- Feeds into: ['Tactical Effects:']
- Related: ['33.7 STATUS EFFECTS (FULL LIST)', 'Tactical Effects:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tactical Effects:
- Anchor: tactical-effects
- Depends on: ['Physical Effects:']
- Feeds into: ['Chemical Effects:']
- Related: ['Physical Effects:', 'Chemical Effects:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Chemical Effects:
- Anchor: chemical-effects
- Depends on: ['Tactical Effects:']
- Feeds into: ['33.8 ENVIRONMENTAL MODIFIERS']
- Related: ['Tactical Effects:', '33.8 ENVIRONMENTAL MODIFIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 33.8 ENVIRONMENTAL MODIFIERS
- Anchor: 33-8-environmental-modifiers
- Depends on: ['Chemical Effects:']
- Feeds into: ['1. Pickpocketing']
- Related: ['Chemical Effects:', '1. Pickpocketing', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Pickpocketing
- Anchor: 1-pickpocketing
- Depends on: ['33.8 ENVIRONMENTAL MODIFIERS']
- Feeds into: ['2. Shoplifting']
- Related: ['33.8 ENVIRONMENTAL MODIFIERS', '2. Shoplifting', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Shoplifting
- Anchor: 2-shoplifting
- Depends on: ['1. Pickpocketing']
- Feeds into: ['3. Street Robbery']
- Related: ['1. Pickpocketing', '3. Street Robbery', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Street Robbery
- Anchor: 3-street-robbery
- Depends on: ['2. Shoplifting']
- Feeds into: ['4. Residential Burglary']
- Related: ['2. Shoplifting', '4. Residential Burglary', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. Residential Burglary
- Anchor: 4-residential-burglary
- Depends on: ['3. Street Robbery']
- Feeds into: ['5. Commercial Burglary']
- Related: ['3. Street Robbery', '5. Commercial Burglary', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. Commercial Burglary
- Anchor: 5-commercial-burglary
- Depends on: ['4. Residential Burglary']
- Feeds into: ['6. Car Theft']
- Related: ['4. Residential Burglary', '6. Car Theft', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6. Car Theft
- Anchor: 6-car-theft
- Depends on: ['5. Commercial Burglary']
- Feeds into: ['7. Drug Dealing']
- Related: ['5. Commercial Burglary', '7. Drug Dealing', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7. Drug Dealing
- Anchor: 7-drug-dealing
- Depends on: ['6. Car Theft']
- Feeds into: ['8. Weapon Running']
- Related: ['6. Car Theft', '8. Weapon Running', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 8. Weapon Running
- Anchor: 8-weapon-running
- Depends on: ['7. Drug Dealing']
- Feeds into: ['10. Vandalism & Disorder']
- Related: ['7. Drug Dealing', '10. Vandalism & Disorder', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 10. Vandalism & Disorder
- Anchor: 10-vandalism-disorder
- Depends on: ['8. Weapon Running']
- Feeds into: ['12. Blackmail & Extortion']
- Related: ['8. Weapon Running', '12. Blackmail & Extortion', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12. Blackmail & Extortion
- Anchor: 12-blackmail-extortion
- Depends on: ['10. Vandalism & Disorder']
- Feeds into: ['13. Loan Sharking']
- Related: ['10. Vandalism & Disorder', '13. Loan Sharking', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13. Loan Sharking
- Anchor: 13-loan-sharking
- Depends on: ['12. Blackmail & Extortion']
- Feeds into: ['14. Counterfeiting']
- Related: ['12. Blackmail & Extortion', '14. Counterfeiting', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14. Counterfeiting
- Anchor: 14-counterfeiting
- Depends on: ['13. Loan Sharking']
- Feeds into: ['15. Smuggling (Local)']
- Related: ['13. Loan Sharking', '15. Smuggling (Local)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15. Smuggling (Local)
- Anchor: 15-smuggling-local
- Depends on: ['14. Counterfeiting']
- Feeds into: ['16. Smuggling (International)']
- Related: ['14. Counterfeiting', '16. Smuggling (International)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16. Smuggling (International)
- Anchor: 16-smuggling-international
- Depends on: ['15. Smuggling (Local)']
- Feeds into: ['17. Gang Contracts']
- Related: ['15. Smuggling (Local)', '17. Gang Contracts', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17. Gang Contracts
- Anchor: 17-gang-contracts
- Depends on: ['16. Smuggling (International)']
- Feeds into: ['18. Syndicate Operations']
- Related: ['16. Smuggling (International)', '18. Syndicate Operations', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 18. Syndicate Operations
- Anchor: 18-syndicate-operations
- Depends on: ['17. Gang Contracts']
- Feeds into: ['CHUNK 35 — ITEMS, BLUEPRINTS, CRAFTING & MATERIAL SYSTEM']
- Related: ['17. Gang Contracts', 'CHUNK 35 — ITEMS, BLUEPRINTS, CRAFTING & MATERIAL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 35 — ITEMS, BLUEPRINTS, CRAFTING & MATERIAL SYSTEM
- Anchor: chunk-35-items-blueprints-crafting-material-system
- Depends on: ['18. Syndicate Operations']
- Feeds into: ['35.1 ITEM SYSTEM OVERVIEW']
- Related: ['18. Syndicate Operations', '35.1 ITEM SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.1 ITEM SYSTEM OVERVIEW
- Anchor: 35-1-item-system-overview
- Depends on: ['CHUNK 35 — ITEMS, BLUEPRINTS, CRAFTING & MATERIAL SYSTEM']
- Feeds into: ['35.2 ITEM CATEGORIES']
- Related: ['CHUNK 35 — ITEMS, BLUEPRINTS, CRAFTING & MATERIAL SYSTEM', '35.2 ITEM CATEGORIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.2 ITEM CATEGORIES
- Anchor: 35-2-item-categories
- Depends on: ['35.1 ITEM SYSTEM OVERVIEW']
- Feeds into: ['Weapons']
- Related: ['35.1 ITEM SYSTEM OVERVIEW', 'Weapons', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Weapons
- Anchor: weapons
- Depends on: ['35.2 ITEM CATEGORIES']
- Feeds into: ['Armour']
- Related: ['35.2 ITEM CATEGORIES', 'Armour', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Armour
- Anchor: armour
- Depends on: ['Weapons']
- Feeds into: ['Tools']
- Related: ['Weapons', 'Tools', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tools
- Anchor: tools
- Depends on: ['Armour']
- Feeds into: ['Consumables']
- Related: ['Armour', 'Consumables', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Consumables
- Anchor: consumables
- Depends on: ['Tools']
- Feeds into: ['Contraband']
- Related: ['Tools', 'Contraband', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Contraband
- Anchor: contraband
- Depends on: ['Consumables']
- Feeds into: ['Crafting Materials']
- Related: ['Consumables', 'Crafting Materials', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Crafting Materials
- Anchor: crafting-materials
- Depends on: ['Contraband']
- Feeds into: ['35.3 RARITY TIERS']
- Related: ['Contraband', '35.3 RARITY TIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.3 RARITY TIERS
- Anchor: 35-3-rarity-tiers
- Depends on: ['Crafting Materials']
- Feeds into: ['35.4 BLUEPRINT SYSTEM']
- Related: ['Crafting Materials', '35.4 BLUEPRINT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.4 BLUEPRINT SYSTEM
- Anchor: 35-4-blueprint-system
- Depends on: ['35.3 RARITY TIERS']
- Feeds into: ['35.5 CRAFTING PROFESSIONS (FULL LIST)']
- Related: ['35.3 RARITY TIERS', '35.5 CRAFTING PROFESSIONS (FULL LIST)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.5 CRAFTING PROFESSIONS (FULL LIST)
- Anchor: 35-5-crafting-professions-full-list
- Depends on: ['35.4 BLUEPRINT SYSTEM']
- Feeds into: ['35.6 CRAFTING STATIONS']
- Related: ['35.4 BLUEPRINT SYSTEM', '35.6 CRAFTING STATIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.6 CRAFTING STATIONS
- Anchor: 35-6-crafting-stations
- Depends on: ['35.5 CRAFTING PROFESSIONS (FULL LIST)']
- Feeds into: ['Workshops']
- Related: ['35.5 CRAFTING PROFESSIONS (FULL LIST)', 'Workshops', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Workshops
- Anchor: workshops
- Depends on: ['35.6 CRAFTING STATIONS']
- Feeds into: ['Chemical Labs']
- Related: ['35.6 CRAFTING STATIONS', 'Chemical Labs', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Chemical Labs
- Anchor: chemical-labs
- Depends on: ['Workshops']
- Feeds into: ['Server Rooms']
- Related: ['Workshops', 'Server Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Server Rooms
- Anchor: server-rooms
- Depends on: ['Chemical Labs']
- Feeds into: ['Greenhouses']
- Related: ['Chemical Labs', 'Greenhouses', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Greenhouses
- Anchor: greenhouses
- Depends on: ['Server Rooms']
- Feeds into: ['Garages']
- Related: ['Server Rooms', 'Garages', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Garages
- Anchor: garages
- Depends on: ['Greenhouses']
- Feeds into: ['35.7 MATERIAL SOURCES']
- Related: ['Greenhouses', '35.7 MATERIAL SOURCES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.7 MATERIAL SOURCES
- Anchor: 35-7-material-sources
- Depends on: ['Garages']
- Feeds into: ['35.8 CRAFTING PROCESS']
- Related: ['Garages', '35.8 CRAFTING PROCESS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.8 CRAFTING PROCESS
- Anchor: 35-8-crafting-process
- Depends on: ['35.7 MATERIAL SOURCES']
- Feeds into: ['35.9 ITEM DURABILITY & REPAIR']
- Related: ['35.7 MATERIAL SOURCES', '35.9 ITEM DURABILITY & REPAIR', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.9 ITEM DURABILITY & REPAIR
- Anchor: 35-9-item-durability-repair
- Depends on: ['35.8 CRAFTING PROCESS']
- Feeds into: ['35.10 ITEM MODDING & UPGRADES']
- Related: ['35.8 CRAFTING PROCESS', '35.10 ITEM MODDING & UPGRADES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.10 ITEM MODDING & UPGRADES
- Anchor: 35-10-item-modding-upgrades
- Depends on: ['35.9 ITEM DURABILITY & REPAIR']
- Feeds into: ['35.12 ITEM ANTI-EXPLOIT LOGIC']
- Related: ['35.9 ITEM DURABILITY & REPAIR', '35.12 ITEM ANTI-EXPLOIT LOGIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.12 ITEM ANTI-EXPLOIT LOGIC
- Anchor: 35-12-item-anti-exploit-logic
- Depends on: ['35.10 ITEM MODDING & UPGRADES']
- Feeds into: ['36.2 WEAPON CLASSES & SUBTYPES']
- Related: ['35.10 ITEM MODDING & UPGRADES', '36.2 WEAPON CLASSES & SUBTYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.2 WEAPON CLASSES & SUBTYPES
- Anchor: 36-2-weapon-classes-subtypes
- Depends on: ['35.12 ITEM ANTI-EXPLOIT LOGIC']
- Feeds into: ['Pistols']
- Related: ['35.12 ITEM ANTI-EXPLOIT LOGIC', 'Pistols', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Pistols
- Anchor: pistols
- Depends on: ['36.2 WEAPON CLASSES & SUBTYPES']
- Feeds into: ['Revolvers']
- Related: ['36.2 WEAPON CLASSES & SUBTYPES', 'Revolvers', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Revolvers
- Anchor: revolvers
- Depends on: ['Pistols']
- Feeds into: ['SMGs']
- Related: ['Pistols', 'SMGs', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SMGs
- Anchor: smgs
- Depends on: ['Revolvers']
- Feeds into: ['Rifles']
- Related: ['Revolvers', 'Rifles', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rifles
- Anchor: rifles
- Depends on: ['SMGs']
- Feeds into: ['Shotguns']
- Related: ['SMGs', 'Shotguns', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Shotguns
- Anchor: shotguns
- Depends on: ['Rifles']
- Feeds into: ['Snipers']
- Related: ['Rifles', 'Snipers', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Snipers
- Anchor: snipers
- Depends on: ['Shotguns']
- Feeds into: ['Heavy Weapons']
- Related: ['Shotguns', 'Heavy Weapons', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Heavy Weapons
- Anchor: heavy-weapons
- Depends on: ['Snipers']
- Feeds into: ['Exotic / Prototype Weapons']
- Related: ['Snipers', 'Exotic / Prototype Weapons', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Exotic / Prototype Weapons
- Anchor: exotic-prototype-weapons
- Depends on: ['Heavy Weapons']
- Feeds into: ['36.3 WEAPON STAT SYSTEM']
- Related: ['Heavy Weapons', '36.3 WEAPON STAT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.3 WEAPON STAT SYSTEM
- Anchor: 36-3-weapon-stat-system
- Depends on: ['Exotic / Prototype Weapons']
- Feeds into: ['36.4 WEAPON DAMAGE CURVES']
- Related: ['Exotic / Prototype Weapons', '36.4 WEAPON DAMAGE CURVES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.4 WEAPON DAMAGE CURVES
- Anchor: 36-4-weapon-damage-curves
- Depends on: ['36.3 WEAPON STAT SYSTEM']
- Feeds into: ['36.5 AMMO TYPES (FULL LIST)']
- Related: ['36.3 WEAPON STAT SYSTEM', '36.5 AMMO TYPES (FULL LIST)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.5 AMMO TYPES (FULL LIST)
- Anchor: 36-5-ammo-types-full-list
- Depends on: ['36.4 WEAPON DAMAGE CURVES']
- Feeds into: ['Standard Ammo']
- Related: ['36.4 WEAPON DAMAGE CURVES', 'Standard Ammo', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Standard Ammo
- Anchor: standard-ammo
- Depends on: ['36.5 AMMO TYPES (FULL LIST)']
- Feeds into: ['Armour-Piercing Ammo']
- Related: ['36.5 AMMO TYPES (FULL LIST)', 'Armour-Piercing Ammo', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Armour-Piercing Ammo
- Anchor: armour-piercing-ammo
- Depends on: ['Standard Ammo']
- Feeds into: ['Special Ammo']
- Related: ['Standard Ammo', 'Special Ammo', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Special Ammo
- Anchor: special-ammo
- Depends on: ['Armour-Piercing Ammo']
- Feeds into: ['Prototype Ammo']
- Related: ['Armour-Piercing Ammo', 'Prototype Ammo', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Prototype Ammo
- Anchor: prototype-ammo
- Depends on: ['Special Ammo']
- Feeds into: ['Armour Layers']
- Related: ['Special Ammo', 'Armour Layers', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Armour Layers
- Anchor: armour-layers
- Depends on: ['Prototype Ammo']
- Feeds into: ['Armour Stats:']
- Related: ['Prototype Ammo', 'Armour Stats:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Armour Stats:
- Anchor: armour-stats
- Depends on: ['Armour Layers']
- Feeds into: ['Armour Types:']
- Related: ['Armour Layers', 'Armour Types:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Armour Types:
- Anchor: armour-types
- Depends on: ['Armour Stats:']
- Feeds into: ['36.7 DAMAGE TYPES & RESISTANCE SYSTEM']
- Related: ['Armour Stats:', '36.7 DAMAGE TYPES & RESISTANCE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.7 DAMAGE TYPES & RESISTANCE SYSTEM
- Anchor: 36-7-damage-types-resistance-system
- Depends on: ['Armour Types:']
- Feeds into: ['Physical']
- Related: ['Armour Types:', 'Physical', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Physical
- Anchor: physical
- Depends on: ['36.7 DAMAGE TYPES & RESISTANCE SYSTEM']
- Feeds into: ['Chemical']
- Related: ['36.7 DAMAGE TYPES & RESISTANCE SYSTEM', 'Chemical', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Chemical
- Anchor: chemical
- Depends on: ['Physical']
- Feeds into: ['Elemental']
- Related: ['Physical', 'Elemental', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Elemental
- Anchor: elemental
- Depends on: ['Chemical']
- Feeds into: ['Attachment Types']
- Related: ['Chemical', 'Attachment Types', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Attachment Types
- Anchor: attachment-types
- Depends on: ['Elemental']
- Feeds into: ['Exotic Mods']
- Related: ['Elemental', 'Exotic Mods', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Exotic Mods
- Anchor: exotic-mods
- Depends on: ['Attachment Types']
- Feeds into: ['Modding Rules:']
- Related: ['Attachment Types', 'Modding Rules:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Modding Rules:
- Anchor: modding-rules
- Depends on: ['Exotic Mods']
- Feeds into: ['36.9 ENVIRONMENTAL WEAPON INTERACTIONS']
- Related: ['Exotic Mods', '36.9 ENVIRONMENTAL WEAPON INTERACTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.9 ENVIRONMENTAL WEAPON INTERACTIONS
- Anchor: 36-9-environmental-weapon-interactions
- Depends on: ['Modding Rules:']
- Feeds into: ['36.12 ANTI-EXPLOIT MEASURES']
- Related: ['Modding Rules:', '36.12 ANTI-EXPLOIT MEASURES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.12 ANTI-EXPLOIT MEASURES
- Anchor: 36-12-anti-exploit-measures
- Depends on: ['36.9 ENVIRONMENTAL WEAPON INTERACTIONS']
- Feeds into: ['Creation Requirements:']
- Related: ['36.9 ENVIRONMENTAL WEAPON INTERACTIONS', 'Creation Requirements:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Creation Requirements:
- Anchor: creation-requirements
- Depends on: ['36.12 ANTI-EXPLOIT MEASURES']
- Feeds into: ['37.4 TERRITORY CONTROL SYSTEM']
- Related: ['36.12 ANTI-EXPLOIT MEASURES', '37.4 TERRITORY CONTROL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.4 TERRITORY CONTROL SYSTEM
- Anchor: 37-4-territory-control-system
- Depends on: ['Creation Requirements:']
- Feeds into: ['37.5 TERRITORY WARFARE']
- Related: ['Creation Requirements:', '37.5 TERRITORY WARFARE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.5 TERRITORY WARFARE
- Anchor: 37-5-territory-warfare
- Depends on: ['37.4 TERRITORY CONTROL SYSTEM']
- Feeds into: ['37.6 THE CHAIN SYSTEM']
- Related: ['37.4 TERRITORY CONTROL SYSTEM', '37.6 THE CHAIN SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.6 THE CHAIN SYSTEM
- Anchor: 37-6-the-chain-system
- Depends on: ['37.5 TERRITORY WARFARE']
- Feeds into: ['Player vs Player Raids:']
- Related: ['37.5 TERRITORY WARFARE', 'Player vs Player Raids:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Player vs Player Raids:
- Anchor: player-vs-player-raids
- Depends on: ['37.6 THE CHAIN SYSTEM']
- Feeds into: ['37.9 DIPLOMACY SYSTEM']
- Related: ['37.6 THE CHAIN SYSTEM', '37.9 DIPLOMACY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.9 DIPLOMACY SYSTEM
- Anchor: 37-9-diplomacy-system
- Depends on: ['Player vs Player Raids:']
- Feeds into: ['37.10 SYNDICATE INFLUENCE SYSTEM']
- Related: ['Player vs Player Raids:', '37.10 SYNDICATE INFLUENCE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.10 SYNDICATE INFLUENCE SYSTEM
- Anchor: 37-10-syndicate-influence-system
- Depends on: ['37.9 DIPLOMACY SYSTEM']
- Feeds into: ['CHUNK 38 — PROPERTIES, UPGRADES, FORTRESSES & DEFENCE SYSTEM']
- Related: ['37.9 DIPLOMACY SYSTEM', 'CHUNK 38 — PROPERTIES, UPGRADES, FORTRESSES & DEFENCE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 38 — PROPERTIES, UPGRADES, FORTRESSES & DEFENCE SYSTEM
- Anchor: chunk-38-properties-upgrades-fortresses-defence-system
- Depends on: ['37.10 SYNDICATE INFLUENCE SYSTEM']
- Feeds into: ['Tier 1 — Basic Living']
- Related: ['37.10 SYNDICATE INFLUENCE SYSTEM', 'Tier 1 — Basic Living', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tier 1 — Basic Living
- Anchor: tier-1-basic-living
- Depends on: ['CHUNK 38 — PROPERTIES, UPGRADES, FORTRESSES & DEFENCE SYSTEM']
- Feeds into: ['Tier 2 — Standard Properties']
- Related: ['CHUNK 38 — PROPERTIES, UPGRADES, FORTRESSES & DEFENCE SYSTEM', 'Tier 2 — Standard Properties', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tier 2 — Standard Properties
- Anchor: tier-2-standard-properties
- Depends on: ['Tier 1 — Basic Living']
- Feeds into: ['Tier 4 — High-End Properties']
- Related: ['Tier 1 — Basic Living', 'Tier 4 — High-End Properties', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tier 4 — High-End Properties
- Anchor: tier-4-high-end-properties
- Depends on: ['Tier 2 — Standard Properties']
- Feeds into: ['Tier 5 — Compounds & Complexes']
- Related: ['Tier 2 — Standard Properties', 'Tier 5 — Compounds & Complexes', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tier 5 — Compounds & Complexes
- Anchor: tier-5-compounds-complexes
- Depends on: ['Tier 4 — High-End Properties']
- Feeds into: ['Tier 6 — Endgame Fortresses']
- Related: ['Tier 4 — High-End Properties', 'Tier 6 — Endgame Fortresses', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tier 6 — Endgame Fortresses
- Anchor: tier-6-endgame-fortresses
- Depends on: ['Tier 5 — Compounds & Complexes']
- Feeds into: ['1. **Comfort**']
- Related: ['Tier 5 — Compounds & Complexes', '1. **Comfort**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. **Comfort**
- Anchor: 1-comfort
- Depends on: ['Tier 6 — Endgame Fortresses']
- Feeds into: ['2. **Security**']
- Related: ['Tier 6 — Endgame Fortresses', '2. **Security**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. **Security**
- Anchor: 2-security
- Depends on: ['1. **Comfort**']
- Feeds into: ['3. **Storage**']
- Related: ['1. **Comfort**', '3. **Storage**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. **Storage**
- Anchor: 3-storage
- Depends on: ['2. **Security**']
- Feeds into: ['4. **Defence Rating**']
- Related: ['2. **Security**', '4. **Defence Rating**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. **Defence Rating**
- Anchor: 4-defence-rating
- Depends on: ['3. **Storage**']
- Feeds into: ['5. **Prestige**']
- Related: ['3. **Storage**', '5. **Prestige**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. **Prestige**
- Anchor: 5-prestige
- Depends on: ['4. **Defence Rating**']
- Feeds into: ['Living Modules']
- Related: ['4. **Defence Rating**', 'Living Modules', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Living Modules
- Anchor: living-modules
- Depends on: ['5. **Prestige**']
- Feeds into: ['Utility Modules']
- Related: ['5. **Prestige**', 'Utility Modules', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Utility Modules
- Anchor: utility-modules
- Depends on: ['Living Modules']
- Feeds into: ['Crafting Rooms']
- Related: ['Living Modules', 'Crafting Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Crafting Rooms
- Anchor: crafting-rooms
- Depends on: ['Utility Modules']
- Feeds into: ['Economic Rooms']
- Related: ['Utility Modules', 'Economic Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Economic Rooms
- Anchor: economic-rooms
- Depends on: ['Crafting Rooms']
- Feeds into: ['Defensive Structures:']
- Related: ['Crafting Rooms', 'Defensive Structures:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Defensive Structures:
- Anchor: defensive-structures
- Depends on: ['Economic Rooms']
- Feeds into: ['Fortress Mechanics:']
- Related: ['Economic Rooms', 'Fortress Mechanics:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Fortress Mechanics:
- Anchor: fortress-mechanics
- Depends on: ['Defensive Structures:']
- Feeds into: ['Raid Types:']
- Related: ['Defensive Structures:', 'Raid Types:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Raid Types:
- Anchor: raid-types
- Depends on: ['Fortress Mechanics:']
- Feeds into: ['38.10 SMUGGLING ROOM SYSTEM']
- Related: ['Fortress Mechanics:', '38.10 SMUGGLING ROOM SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 38.10 SMUGGLING ROOM SYSTEM
- Anchor: 38-10-smuggling-room-system
- Depends on: ['Raid Types:']
- Feeds into: ['39.1 INTERIOR SYSTEM OVERVIEW']
- Related: ['Raid Types:', '39.1 INTERIOR SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.1 INTERIOR SYSTEM OVERVIEW
- Anchor: 39-1-interior-system-overview
- Depends on: ['38.10 SMUGGLING ROOM SYSTEM']
- Feeds into: ['39.2 INTERIOR THEMES (FULL LIST)']
- Related: ['38.10 SMUGGLING ROOM SYSTEM', '39.2 INTERIOR THEMES (FULL LIST)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.2 INTERIOR THEMES (FULL LIST)
- Anchor: 39-2-interior-themes-full-list
- Depends on: ['39.1 INTERIOR SYSTEM OVERVIEW']
- Feeds into: ['Modern Luxury']
- Related: ['39.1 INTERIOR SYSTEM OVERVIEW', 'Modern Luxury', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Modern Luxury
- Anchor: modern-luxury
- Depends on: ['39.2 INTERIOR THEMES (FULL LIST)']
- Feeds into: ['Industrial']
- Related: ['39.2 INTERIOR THEMES (FULL LIST)', 'Industrial', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Industrial
- Anchor: industrial
- Depends on: ['Modern Luxury']
- Feeds into: ['Dark Ops']
- Related: ['Modern Luxury', 'Dark Ops', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Dark Ops
- Anchor: dark-ops
- Depends on: ['Industrial']
- Feeds into: ['Neo-Syndicate']
- Related: ['Industrial', 'Neo-Syndicate', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Neo-Syndicate
- Anchor: neo-syndicate
- Depends on: ['Dark Ops']
- Feeds into: ['Street Aesthetic']
- Related: ['Dark Ops', 'Street Aesthetic', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Street Aesthetic
- Anchor: street-aesthetic
- Depends on: ['Neo-Syndicate']
- Feeds into: ['Underground Bunker']
- Related: ['Neo-Syndicate', 'Underground Bunker', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Underground Bunker
- Anchor: underground-bunker
- Depends on: ['Street Aesthetic']
- Feeds into: ['39.3 ROOM TYPES (FULL LIST)']
- Related: ['Street Aesthetic', '39.3 ROOM TYPES (FULL LIST)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.3 ROOM TYPES (FULL LIST)
- Anchor: 39-3-room-types-full-list
- Depends on: ['Underground Bunker']
- Feeds into: ['Living Spaces']
- Related: ['Underground Bunker', 'Living Spaces', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Living Spaces
- Anchor: living-spaces
- Depends on: ['39.3 ROOM TYPES (FULL LIST)']
- Feeds into: ['Functional Spaces']
- Related: ['39.3 ROOM TYPES (FULL LIST)', 'Functional Spaces', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Functional Spaces
- Anchor: functional-spaces
- Depends on: ['Living Spaces']
- Feeds into: ['Economic Spaces']
- Related: ['Living Spaces', 'Economic Spaces', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Economic Spaces
- Anchor: economic-spaces
- Depends on: ['Functional Spaces']
- Feeds into: ['Prestige Spaces']
- Related: ['Functional Spaces', 'Prestige Spaces', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Prestige Spaces
- Anchor: prestige-spaces
- Depends on: ['Economic Spaces']
- Feeds into: ['39.4 DECORATIVE ITEM CATEGORIES']
- Related: ['Economic Spaces', '39.4 DECORATIVE ITEM CATEGORIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.4 DECORATIVE ITEM CATEGORIES
- Anchor: 39-4-decorative-item-categories
- Depends on: ['Prestige Spaces']
- Feeds into: ['Furniture']
- Related: ['Prestige Spaces', 'Furniture', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Furniture
- Anchor: furniture
- Depends on: ['39.4 DECORATIVE ITEM CATEGORIES']
- Feeds into: ['Lighting']
- Related: ['39.4 DECORATIVE ITEM CATEGORIES', 'Lighting', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Lighting
- Anchor: lighting
- Depends on: ['Furniture']
- Feeds into: ['Wall Decor']
- Related: ['Furniture', 'Wall Decor', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Wall Decor
- Anchor: wall-decor
- Depends on: ['Lighting']
- Feeds into: ['Props']
- Related: ['Lighting', 'Props', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Props
- Anchor: props
- Depends on: ['Wall Decor']
- Feeds into: ['Prestige Items']
- Related: ['Wall Decor', 'Prestige Items', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Prestige Items
- Anchor: prestige-items
- Depends on: ['Props']
- Feeds into: ['39.5 INTERIOR STATS & BONUSES']
- Related: ['Props', '39.5 INTERIOR STATS & BONUSES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.5 INTERIOR STATS & BONUSES
- Anchor: 39-5-interior-stats-bonuses
- Depends on: ['Prestige Items']
- Feeds into: ['Comfort']
- Related: ['Prestige Items', 'Comfort', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Comfort
- Anchor: comfort
- Depends on: ['39.5 INTERIOR STATS & BONUSES']
- Feeds into: ['Prestige']
- Related: ['39.5 INTERIOR STATS & BONUSES', 'Prestige', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Prestige
- Anchor: prestige
- Depends on: ['Comfort']
- Feeds into: ['Functionality Bonuses:']
- Related: ['Comfort', 'Functionality Bonuses:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Functionality Bonuses:
- Anchor: functionality-bonuses
- Depends on: ['Prestige']
- Feeds into: ['39.6 INTERIOR EDITOR SYSTEM']
- Related: ['Prestige', '39.6 INTERIOR EDITOR SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.6 INTERIOR EDITOR SYSTEM
- Anchor: 39-6-interior-editor-system
- Depends on: ['Functionality Bonuses:']
- Feeds into: ['39.7 PRESTIGE GALLERY SYSTEM']
- Related: ['Functionality Bonuses:', '39.7 PRESTIGE GALLERY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.7 PRESTIGE GALLERY SYSTEM
- Anchor: 39-7-prestige-gallery-system
- Depends on: ['39.6 INTERIOR EDITOR SYSTEM']
- Feeds into: ['39.8 INTERACTIVE OBJECTS']
- Related: ['39.6 INTERIOR EDITOR SYSTEM', '39.8 INTERACTIVE OBJECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.8 INTERACTIVE OBJECTS
- Anchor: 39-8-interactive-objects
- Depends on: ['39.7 PRESTIGE GALLERY SYSTEM']
- Feeds into: ['39.10 SOCIAL INTEGRATION']
- Related: ['39.7 PRESTIGE GALLERY SYSTEM', '39.10 SOCIAL INTEGRATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.10 SOCIAL INTEGRATION
- Anchor: 39-10-social-integration
- Depends on: ['39.8 INTERACTIVE OBJECTS']
- Feeds into: ['39.11 INTERIOR ANTI-EXPLOIT MEASURES']
- Related: ['39.8 INTERACTIVE OBJECTS', '39.11 INTERIOR ANTI-EXPLOIT MEASURES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.11 INTERIOR ANTI-EXPLOIT MEASURES
- Anchor: 39-11-interior-anti-exploit-measures
- Depends on: ['39.10 SOCIAL INTEGRATION']
- Feeds into: ['CHUNK 40 — COUNTRY SYSTEM, INTERNATIONAL TRAVEL, GLOBAL SMUGGLING NETWORKS']
- Related: ['39.10 SOCIAL INTEGRATION', 'CHUNK 40 — COUNTRY SYSTEM, INTERNATIONAL TRAVEL, GLOBAL SMUGGLING NETWORKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 40 — COUNTRY SYSTEM, INTERNATIONAL TRAVEL, GLOBAL SMUGGLING NETWORKS
- Anchor: chunk-40-country-system-international-travel-global-smuggling-networks
- Depends on: ['39.11 INTERIOR ANTI-EXPLOIT MEASURES']
- Feeds into: ['40.1 COUNTRY SYSTEM OVERVIEW']
- Related: ['39.11 INTERIOR ANTI-EXPLOIT MEASURES', '40.1 COUNTRY SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.1 COUNTRY SYSTEM OVERVIEW
- Anchor: 40-1-country-system-overview
- Depends on: ['CHUNK 40 — COUNTRY SYSTEM, INTERNATIONAL TRAVEL, GLOBAL SMUGGLING NETWORKS']
- Feeds into: ['40.2 COUNTRY LIST (INITIAL)']
- Related: ['CHUNK 40 — COUNTRY SYSTEM, INTERNATIONAL TRAVEL, GLOBAL SMUGGLING NETWORKS', '40.2 COUNTRY LIST (INITIAL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.2 COUNTRY LIST (INITIAL)
- Anchor: 40-2-country-list-initial
- Depends on: ['40.1 COUNTRY SYSTEM OVERVIEW']
- Feeds into: ['United Kingdom (Base Region)']
- Related: ['40.1 COUNTRY SYSTEM OVERVIEW', 'United Kingdom (Base Region)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## United Kingdom (Base Region)
- Anchor: united-kingdom-base-region
- Depends on: ['40.2 COUNTRY LIST (INITIAL)']
- Feeds into: ['Netherlands']
- Related: ['40.2 COUNTRY LIST (INITIAL)', 'Netherlands', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Netherlands
- Anchor: netherlands
- Depends on: ['United Kingdom (Base Region)']
- Feeds into: ['Spain']
- Related: ['United Kingdom (Base Region)', 'Spain', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Spain
- Anchor: spain
- Depends on: ['Netherlands']
- Feeds into: ['Morocco']
- Related: ['Netherlands', 'Morocco', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Morocco
- Anchor: morocco
- Depends on: ['Spain']
- Feeds into: ['Turkey']
- Related: ['Spain', 'Turkey', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Turkey
- Anchor: turkey
- Depends on: ['Morocco']
- Feeds into: ['UAE']
- Related: ['Morocco', 'UAE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## UAE
- Anchor: uae
- Depends on: ['Turkey']
- Feeds into: ['India']
- Related: ['Turkey', 'India', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## India
- Anchor: india
- Depends on: ['UAE']
- Feeds into: ['Japan']
- Related: ['UAE', 'Japan', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Japan
- Anchor: japan
- Depends on: ['India']
- Feeds into: ['Colombia']
- Related: ['India', 'Colombia', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Colombia
- Anchor: colombia
- Depends on: ['Japan']
- Feeds into: ['40.3 INTERNATIONAL TRAVEL SYSTEM']
- Related: ['Japan', '40.3 INTERNATIONAL TRAVEL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.3 INTERNATIONAL TRAVEL SYSTEM
- Anchor: 40-3-international-travel-system
- Depends on: ['Colombia']
- Feeds into: ['40.4 GLOBAL SMUGGLING NETWORK']
- Related: ['Colombia', '40.4 GLOBAL SMUGGLING NETWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.4 GLOBAL SMUGGLING NETWORK
- Anchor: 40-4-global-smuggling-network
- Depends on: ['40.3 INTERNATIONAL TRAVEL SYSTEM']
- Feeds into: ['40.5 FOREIGN CITIES & UNIQUE CONTENT']
- Related: ['40.3 INTERNATIONAL TRAVEL SYSTEM', '40.5 FOREIGN CITIES & UNIQUE CONTENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.5 FOREIGN CITIES & UNIQUE CONTENT
- Anchor: 40-5-foreign-cities-unique-content
- Depends on: ['40.4 GLOBAL SMUGGLING NETWORK']
- Feeds into: ['Amsterdam']
- Related: ['40.4 GLOBAL SMUGGLING NETWORK', 'Amsterdam', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Amsterdam
- Anchor: amsterdam
- Depends on: ['40.5 FOREIGN CITIES & UNIQUE CONTENT']
- Feeds into: ['Istanbul']
- Related: ['40.5 FOREIGN CITIES & UNIQUE CONTENT', 'Istanbul', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Istanbul
- Anchor: istanbul
- Depends on: ['Amsterdam']
- Feeds into: ['Dubai']
- Related: ['Amsterdam', 'Dubai', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Dubai
- Anchor: dubai
- Depends on: ['Istanbul']
- Feeds into: ['40.6 INTERNATIONAL MISSIONS']
- Related: ['Istanbul', '40.6 INTERNATIONAL MISSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.6 INTERNATIONAL MISSIONS
- Anchor: 40-6-international-missions
- Depends on: ['Dubai']
- Feeds into: ['40.7 WORLD EVENTS & GEO-POLITICAL CHANGES']
- Related: ['Dubai', '40.7 WORLD EVENTS & GEO-POLITICAL CHANGES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.7 WORLD EVENTS & GEO-POLITICAL CHANGES
- Anchor: 40-7-world-events-geo-political-changes
- Depends on: ['40.6 INTERNATIONAL MISSIONS']
- Feeds into: ['40.9 GLOBAL HEAT & WANTED SYSTEM']
- Related: ['40.6 INTERNATIONAL MISSIONS', '40.9 GLOBAL HEAT & WANTED SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.9 GLOBAL HEAT & WANTED SYSTEM
- Anchor: 40-9-global-heat-wanted-system
- Depends on: ['40.7 WORLD EVENTS & GEO-POLITICAL CHANGES']
- Feeds into: ['40.10 INTERNATIONAL ANTI-EXPLOIT SYSTEM']
- Related: ['40.7 WORLD EVENTS & GEO-POLITICAL CHANGES', '40.10 INTERNATIONAL ANTI-EXPLOIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.10 INTERNATIONAL ANTI-EXPLOIT SYSTEM
- Anchor: 40-10-international-anti-exploit-system
- Depends on: ['40.9 GLOBAL HEAT & WANTED SYSTEM']
- Feeds into: ['CHUNK 41 — MINI-GAMES, SKILL GAMES, TRAINING & SIDE ACTIVITIES']
- Related: ['40.9 GLOBAL HEAT & WANTED SYSTEM', 'CHUNK 41 — MINI-GAMES, SKILL GAMES, TRAINING & SIDE ACTIVITIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 41 — MINI-GAMES, SKILL GAMES, TRAINING & SIDE ACTIVITIES
- Anchor: chunk-41-mini-games-skill-games-training-side-activities
- Depends on: ['40.10 INTERNATIONAL ANTI-EXPLOIT SYSTEM']
- Feeds into: ['41.1 MINI-GAME SYSTEM OVERVIEW']
- Related: ['40.10 INTERNATIONAL ANTI-EXPLOIT SYSTEM', '41.1 MINI-GAME SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.1 MINI-GAME SYSTEM OVERVIEW
- Anchor: 41-1-mini-game-system-overview
- Depends on: ['CHUNK 41 — MINI-GAMES, SKILL GAMES, TRAINING & SIDE ACTIVITIES']
- Feeds into: ['41.2 SKILL-BASED MINI-GAMES']
- Related: ['CHUNK 41 — MINI-GAMES, SKILL GAMES, TRAINING & SIDE ACTIVITIES', '41.2 SKILL-BASED MINI-GAMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.2 SKILL-BASED MINI-GAMES
- Anchor: 41-2-skill-based-mini-games
- Depends on: ['41.1 MINI-GAME SYSTEM OVERVIEW']
- Feeds into: ['Lockpicking Game']
- Related: ['41.1 MINI-GAME SYSTEM OVERVIEW', 'Lockpicking Game', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Lockpicking Game
- Anchor: lockpicking-game
- Depends on: ['41.2 SKILL-BASED MINI-GAMES']
- Feeds into: ['Safe Cracking']
- Related: ['41.2 SKILL-BASED MINI-GAMES', 'Safe Cracking', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Safe Cracking
- Anchor: safe-cracking
- Depends on: ['Lockpicking Game']
- Feeds into: ['Hacking Game']
- Related: ['Lockpicking Game', 'Hacking Game', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Hacking Game
- Anchor: hacking-game
- Depends on: ['Safe Cracking']
- Feeds into: ['Pickpocket Timing Game']
- Related: ['Safe Cracking', 'Pickpocket Timing Game', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Pickpocket Timing Game
- Anchor: pickpocket-timing-game
- Depends on: ['Hacking Game']
- Feeds into: ['Sharpshooting Range']
- Related: ['Hacking Game', 'Sharpshooting Range', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Sharpshooting Range
- Anchor: sharpshooting-range
- Depends on: ['Pickpocket Timing Game']
- Feeds into: ['Racing Time Trials']
- Related: ['Pickpocket Timing Game', 'Racing Time Trials', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Racing Time Trials
- Anchor: racing-time-trials
- Depends on: ['Sharpshooting Range']
- Feeds into: ['41.3 CHANCE / RISK MINI-GAMES']
- Related: ['Sharpshooting Range', '41.3 CHANCE / RISK MINI-GAMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.3 CHANCE / RISK MINI-GAMES
- Anchor: 41-3-chance-risk-mini-games
- Depends on: ['Racing Time Trials']
- Feeds into: ['Dice Games']
- Related: ['Racing Time Trials', 'Dice Games', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Dice Games
- Anchor: dice-games
- Depends on: ['41.3 CHANCE / RISK MINI-GAMES']
- Feeds into: ['Cards']
- Related: ['41.3 CHANCE / RISK MINI-GAMES', 'Cards', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Cards
- Anchor: cards
- Depends on: ['Dice Games']
- Feeds into: ['Shell Game']
- Related: ['Dice Games', 'Shell Game', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Shell Game
- Anchor: shell-game
- Depends on: ['Cards']
- Feeds into: ['Street Con Games']
- Related: ['Cards', 'Street Con Games', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Street Con Games
- Anchor: street-con-games
- Depends on: ['Shell Game']
- Feeds into: ['41.4 TRAINING MINI-GAMES']
- Related: ['Shell Game', '41.4 TRAINING MINI-GAMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.4 TRAINING MINI-GAMES
- Anchor: 41-4-training-mini-games
- Depends on: ['Street Con Games']
- Feeds into: ['Gym Rhythm Game']
- Related: ['Street Con Games', 'Gym Rhythm Game', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Gym Rhythm Game
- Anchor: gym-rhythm-game
- Depends on: ['41.4 TRAINING MINI-GAMES']
- Feeds into: ['Reflex Training']
- Related: ['41.4 TRAINING MINI-GAMES', 'Reflex Training', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Reflex Training
- Anchor: reflex-training
- Depends on: ['Gym Rhythm Game']
- Feeds into: ['Crafting Skill Tests']
- Related: ['Gym Rhythm Game', 'Crafting Skill Tests', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Crafting Skill Tests
- Anchor: crafting-skill-tests
- Depends on: ['Reflex Training']
- Feeds into: ['41.5 OCCUPATION MINI-GAMES (SIDE JOBS)']
- Related: ['Reflex Training', '41.5 OCCUPATION MINI-GAMES (SIDE JOBS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.5 OCCUPATION MINI-GAMES (SIDE JOBS)
- Anchor: 41-5-occupation-mini-games-side-jobs
- Depends on: ['Crafting Skill Tests']
- Feeds into: ['Courier Work']
- Related: ['Crafting Skill Tests', 'Courier Work', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Courier Work
- Anchor: courier-work
- Depends on: ['41.5 OCCUPATION MINI-GAMES (SIDE JOBS)']
- Feeds into: ['Bar Work']
- Related: ['41.5 OCCUPATION MINI-GAMES (SIDE JOBS)', 'Bar Work', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Bar Work
- Anchor: bar-work
- Depends on: ['Courier Work']
- Feeds into: ['Street Performance']
- Related: ['Courier Work', 'Street Performance', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Street Performance
- Anchor: street-performance
- Depends on: ['Bar Work']
- Feeds into: ['41.6 WORLD INTERACTIVE MINI-GAMES']
- Related: ['Bar Work', '41.6 WORLD INTERACTIVE MINI-GAMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.6 WORLD INTERACTIVE MINI-GAMES
- Anchor: 41-6-world-interactive-mini-games
- Depends on: ['Street Performance']
- Feeds into: ['Dumpster Diving']
- Related: ['Street Performance', 'Dumpster Diving', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Dumpster Diving
- Anchor: dumpster-diving
- Depends on: ['41.6 WORLD INTERACTIVE MINI-GAMES']
- Feeds into: ['Pawn Shop Negotiation']
- Related: ['41.6 WORLD INTERACTIVE MINI-GAMES', 'Pawn Shop Negotiation', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Pawn Shop Negotiation
- Anchor: pawn-shop-negotiation
- Depends on: ['Dumpster Diving']
- Feeds into: ['Underground Fight Pits']
- Related: ['Dumpster Diving', 'Underground Fight Pits', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Underground Fight Pits
- Anchor: underground-fight-pits
- Depends on: ['Pawn Shop Negotiation']
- Feeds into: ['41.7 MINI-GAME REWARD SYSTEM']
- Related: ['Pawn Shop Negotiation', '41.7 MINI-GAME REWARD SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.7 MINI-GAME REWARD SYSTEM
- Anchor: 41-7-mini-game-reward-system
- Depends on: ['Underground Fight Pits']
- Feeds into: ['41.8 MINI-GAME ANTI-EXPLOIT SYSTEM']
- Related: ['Underground Fight Pits', '41.8 MINI-GAME ANTI-EXPLOIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.8 MINI-GAME ANTI-EXPLOIT SYSTEM
- Anchor: 41-8-mini-game-anti-exploit-system
- Depends on: ['41.7 MINI-GAME REWARD SYSTEM']
- Feeds into: ['CHUNK 42 — ACHIEVEMENTS, AWARDS, MERITS, TITLES & MERIT SHOP']
- Related: ['41.7 MINI-GAME REWARD SYSTEM', 'CHUNK 42 — ACHIEVEMENTS, AWARDS, MERITS, TITLES & MERIT SHOP', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 42 — ACHIEVEMENTS, AWARDS, MERITS, TITLES & MERIT SHOP
- Anchor: chunk-42-achievements-awards-merits-titles-merit-shop
- Depends on: ['41.8 MINI-GAME ANTI-EXPLOIT SYSTEM']
- Feeds into: ['42.1 ACHIEVEMENT SYSTEM OVERVIEW']
- Related: ['41.8 MINI-GAME ANTI-EXPLOIT SYSTEM', '42.1 ACHIEVEMENT SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.1 ACHIEVEMENT SYSTEM OVERVIEW
- Anchor: 42-1-achievement-system-overview
- Depends on: ['CHUNK 42 — ACHIEVEMENTS, AWARDS, MERITS, TITLES & MERIT SHOP']
- Feeds into: ['42.2 ACHIEVEMENT CATEGORIES']
- Related: ['CHUNK 42 — ACHIEVEMENTS, AWARDS, MERITS, TITLES & MERIT SHOP', '42.2 ACHIEVEMENT CATEGORIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.2 ACHIEVEMENT CATEGORIES
- Anchor: 42-2-achievement-categories
- Depends on: ['42.1 ACHIEVEMENT SYSTEM OVERVIEW']
- Feeds into: ['Mission Achievements']
- Related: ['42.1 ACHIEVEMENT SYSTEM OVERVIEW', 'Mission Achievements', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mission Achievements
- Anchor: mission-achievements
- Depends on: ['42.2 ACHIEVEMENT CATEGORIES']
- Feeds into: ['Crafting Achievements']
- Related: ['42.2 ACHIEVEMENT CATEGORIES', 'Crafting Achievements', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Crafting Achievements
- Anchor: crafting-achievements
- Depends on: ['Mission Achievements']
- Feeds into: ['Social Achievements']
- Related: ['Mission Achievements', 'Social Achievements', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Social Achievements
- Anchor: social-achievements
- Depends on: ['Crafting Achievements']
- Feeds into: ['Travel Achievements']
- Related: ['Crafting Achievements', 'Travel Achievements', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Travel Achievements
- Anchor: travel-achievements
- Depends on: ['Social Achievements']
- Feeds into: ['Minigame Achievements']
- Related: ['Social Achievements', 'Minigame Achievements', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Minigame Achievements
- Anchor: minigame-achievements
- Depends on: ['Travel Achievements']
- Feeds into: ['42.3 ACHIEVEMENT TIERS']
- Related: ['Travel Achievements', '42.3 ACHIEVEMENT TIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.3 ACHIEVEMENT TIERS
- Anchor: 42-3-achievement-tiers
- Depends on: ['Minigame Achievements']
- Feeds into: ['Bronze (Easy)']
- Related: ['Minigame Achievements', 'Bronze (Easy)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Bronze (Easy)
- Anchor: bronze-easy
- Depends on: ['42.3 ACHIEVEMENT TIERS']
- Feeds into: ['Silver (Intermediate)']
- Related: ['42.3 ACHIEVEMENT TIERS', 'Silver (Intermediate)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Silver (Intermediate)
- Anchor: silver-intermediate
- Depends on: ['Bronze (Easy)']
- Feeds into: ['Platinum (Elite)']
- Related: ['Bronze (Easy)', 'Platinum (Elite)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Platinum (Elite)
- Anchor: platinum-elite
- Depends on: ['Silver (Intermediate)']
- Feeds into: ['42.4 MERIT / AWARD POINT SYSTEM']
- Related: ['Silver (Intermediate)', '42.4 MERIT / AWARD POINT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.4 MERIT / AWARD POINT SYSTEM
- Anchor: 42-4-merit-award-point-system
- Depends on: ['Platinum (Elite)']
- Feeds into: ['42.5 TITLES SYSTEM']
- Related: ['Platinum (Elite)', '42.5 TITLES SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.5 TITLES SYSTEM
- Anchor: 42-5-titles-system
- Depends on: ['42.4 MERIT / AWARD POINT SYSTEM']
- Feeds into: ['Title Categories:']
- Related: ['42.4 MERIT / AWARD POINT SYSTEM', 'Title Categories:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Title Categories:
- Anchor: title-categories
- Depends on: ['42.5 TITLES SYSTEM']
- Feeds into: ['42.6 MERIT SHOP SYSTEM']
- Related: ['42.5 TITLES SYSTEM', '42.6 MERIT SHOP SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.6 MERIT SHOP SYSTEM
- Anchor: 42-6-merit-shop-system
- Depends on: ['Title Categories:']
- Feeds into: ['42.7 ACHIEVEMENT GALLERY & PROFILE DISPLAY']
- Related: ['Title Categories:', '42.7 ACHIEVEMENT GALLERY & PROFILE DISPLAY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.7 ACHIEVEMENT GALLERY & PROFILE DISPLAY
- Anchor: 42-7-achievement-gallery-profile-display
- Depends on: ['42.6 MERIT SHOP SYSTEM']
- Feeds into: ['42.8 SEASONAL & LIVE EVENT ACHIEVEMENTS']
- Related: ['42.6 MERIT SHOP SYSTEM', '42.8 SEASONAL & LIVE EVENT ACHIEVEMENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.8 SEASONAL & LIVE EVENT ACHIEVEMENTS
- Anchor: 42-8-seasonal-live-event-achievements
- Depends on: ['42.7 ACHIEVEMENT GALLERY & PROFILE DISPLAY']
- Feeds into: ['42.9 ANTI-EXPLOIT & ACHIEVEMENT VALIDATION']
- Related: ['42.7 ACHIEVEMENT GALLERY & PROFILE DISPLAY', '42.9 ANTI-EXPLOIT & ACHIEVEMENT VALIDATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.9 ANTI-EXPLOIT & ACHIEVEMENT VALIDATION
- Anchor: 42-9-anti-exploit-achievement-validation
- Depends on: ['42.8 SEASONAL & LIVE EVENT ACHIEVEMENTS']
- Feeds into: ['CHUNK 43 — DONATOR, SUBSCRIPTIONS, COSMETICS, BATTLE PASS & MONETISATION SYSTEM']
- Related: ['42.8 SEASONAL & LIVE EVENT ACHIEVEMENTS', 'CHUNK 43 — DONATOR, SUBSCRIPTIONS, COSMETICS, BATTLE PASS & MONETISATION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 43 — DONATOR, SUBSCRIPTIONS, COSMETICS, BATTLE PASS & MONETISATION SYSTEM
- Anchor: chunk-43-donator-subscriptions-cosmetics-battle-pass-monetisation-system
- Depends on: ['42.9 ANTI-EXPLOIT & ACHIEVEMENT VALIDATION']
- Feeds into: ['43.1 MONETISATION OVERVIEW']
- Related: ['42.9 ANTI-EXPLOIT & ACHIEVEMENT VALIDATION', '43.1 MONETISATION OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.1 MONETISATION OVERVIEW
- Anchor: 43-1-monetisation-overview
- Depends on: ['CHUNK 43 — DONATOR, SUBSCRIPTIONS, COSMETICS, BATTLE PASS & MONETISATION SYSTEM']
- Feeds into: ['43.2 DONATOR PACKS (PERMANENT)']
- Related: ['CHUNK 43 — DONATOR, SUBSCRIPTIONS, COSMETICS, BATTLE PASS & MONETISATION SYSTEM', '43.2 DONATOR PACKS (PERMANENT)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.2 DONATOR PACKS (PERMANENT)
- Anchor: 43-2-donator-packs-permanent
- Depends on: ['43.1 MONETISATION OVERVIEW']
- Feeds into: ['Donator Benefits:']
- Related: ['43.1 MONETISATION OVERVIEW', 'Donator Benefits:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Donator Benefits:
- Anchor: donator-benefits
- Depends on: ['43.2 DONATOR PACKS (PERMANENT)']
- Feeds into: ['Donator-Only Features:']
- Related: ['43.2 DONATOR PACKS (PERMANENT)', 'Donator-Only Features:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Donator-Only Features:
- Anchor: donator-only-features
- Depends on: ['Donator Benefits:']
- Feeds into: ['43.3 MONTHLY SUBSCRIPTION (LOYALTY PASS)']
- Related: ['Donator Benefits:', '43.3 MONTHLY SUBSCRIPTION (LOYALTY PASS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.3 MONTHLY SUBSCRIPTION (LOYALTY PASS)
- Anchor: 43-3-monthly-subscription-loyalty-pass
- Depends on: ['Donator-Only Features:']
- Feeds into: ['Subscription Loyalty Track:']
- Related: ['Donator-Only Features:', 'Subscription Loyalty Track:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Subscription Loyalty Track:
- Anchor: subscription-loyalty-track
- Depends on: ['43.3 MONTHLY SUBSCRIPTION (LOYALTY PASS)']
- Feeds into: ['43.4 COSMETICS SYSTEM']
- Related: ['43.3 MONTHLY SUBSCRIPTION (LOYALTY PASS)', '43.4 COSMETICS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.4 COSMETICS SYSTEM
- Anchor: 43-4-cosmetics-system
- Depends on: ['Subscription Loyalty Track:']
- Feeds into: ['43.5 SEASONAL BATTLE PASS']
- Related: ['Subscription Loyalty Track:', '43.5 SEASONAL BATTLE PASS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.5 SEASONAL BATTLE PASS
- Anchor: 43-5-seasonal-battle-pass
- Depends on: ['43.4 COSMETICS SYSTEM']
- Feeds into: ['Rewards Include:']
- Related: ['43.4 COSMETICS SYSTEM', 'Rewards Include:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rewards Include:
- Anchor: rewards-include
- Depends on: ['43.5 SEASONAL BATTLE PASS']
- Feeds into: ['Progression:']
- Related: ['43.5 SEASONAL BATTLE PASS', 'Progression:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Progression:
- Anchor: progression
- Depends on: ['Rewards Include:']
- Feeds into: ['Season Duration:']
- Related: ['Rewards Include:', 'Season Duration:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Season Duration:
- Anchor: season-duration
- Depends on: ['Progression:']
- Feeds into: ['43.6 COSMETIC SHOP & ROTATING STORE']
- Related: ['Progression:', '43.6 COSMETIC SHOP & ROTATING STORE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.6 COSMETIC SHOP & ROTATING STORE
- Anchor: 43-6-cosmetic-shop-rotating-store
- Depends on: ['Season Duration:']
- Feeds into: ['43.7 PAYMENT INTEGRITY & SECURITY LAYER']
- Related: ['Season Duration:', '43.7 PAYMENT INTEGRITY & SECURITY LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.7 PAYMENT INTEGRITY & SECURITY LAYER
- Anchor: 43-7-payment-integrity-security-layer
- Depends on: ['43.6 COSMETIC SHOP & ROTATING STORE']
- Feeds into: ['43.8 FAIRNESS & ANTI-P2W SYSTEMS']
- Related: ['43.6 COSMETIC SHOP & ROTATING STORE', '43.8 FAIRNESS & ANTI-P2W SYSTEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.8 FAIRNESS & ANTI-P2W SYSTEMS
- Anchor: 43-8-fairness-anti-p2w-systems
- Depends on: ['43.7 PAYMENT INTEGRITY & SECURITY LAYER']
- Feeds into: ['43.9 FUTURE MONETISATION EXPANSIONS']
- Related: ['43.7 PAYMENT INTEGRITY & SECURITY LAYER', '43.9 FUTURE MONETISATION EXPANSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.9 FUTURE MONETISATION EXPANSIONS
- Anchor: 43-9-future-monetisation-expansions
- Depends on: ['43.8 FAIRNESS & ANTI-P2W SYSTEMS']
- Feeds into: ['CHUNK 44 — MESSAGING, MAIL, NOTIFICATIONS, SOCIAL SYSTEMS & CHAT']
- Related: ['43.8 FAIRNESS & ANTI-P2W SYSTEMS', 'CHUNK 44 — MESSAGING, MAIL, NOTIFICATIONS, SOCIAL SYSTEMS & CHAT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 44 — MESSAGING, MAIL, NOTIFICATIONS, SOCIAL SYSTEMS & CHAT
- Anchor: chunk-44-messaging-mail-notifications-social-systems-chat
- Depends on: ['43.9 FUTURE MONETISATION EXPANSIONS']
- Feeds into: ['44.1 SOCIAL & COMMUNICATION OVERVIEW']
- Related: ['43.9 FUTURE MONETISATION EXPANSIONS', '44.1 SOCIAL & COMMUNICATION OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.1 SOCIAL & COMMUNICATION OVERVIEW
- Anchor: 44-1-social-communication-overview
- Depends on: ['CHUNK 44 — MESSAGING, MAIL, NOTIFICATIONS, SOCIAL SYSTEMS & CHAT']
- Feeds into: ['44.2 IN‑GAME MAIL SYSTEM']
- Related: ['CHUNK 44 — MESSAGING, MAIL, NOTIFICATIONS, SOCIAL SYSTEMS & CHAT', '44.2 IN‑GAME MAIL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.2 IN‑GAME MAIL SYSTEM
- Anchor: 44-2-in-game-mail-system
- Depends on: ['44.1 SOCIAL & COMMUNICATION OVERVIEW']
- Feeds into: ['Mail Features:']
- Related: ['44.1 SOCIAL & COMMUNICATION OVERVIEW', 'Mail Features:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mail Features:
- Anchor: mail-features
- Depends on: ['44.2 IN‑GAME MAIL SYSTEM']
- Feeds into: ['Mail Categories:']
- Related: ['44.2 IN‑GAME MAIL SYSTEM', 'Mail Categories:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mail Categories:
- Anchor: mail-categories
- Depends on: ['Mail Features:']
- Feeds into: ['Attachment Rules:']
- Related: ['Mail Features:', 'Attachment Rules:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Attachment Rules:
- Anchor: attachment-rules
- Depends on: ['Mail Categories:']
- Feeds into: ['Mail Protections:']
- Related: ['Mail Categories:', 'Mail Protections:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mail Protections:
- Anchor: mail-protections
- Depends on: ['Attachment Rules:']
- Feeds into: ['44.3 REAL‑TIME CHAT SYSTEM']
- Related: ['Attachment Rules:', '44.3 REAL‑TIME CHAT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.3 REAL‑TIME CHAT SYSTEM
- Anchor: 44-3-real-time-chat-system
- Depends on: ['Mail Protections:']
- Feeds into: ['44.4 NOTIFICATION SYSTEM']
- Related: ['Mail Protections:', '44.4 NOTIFICATION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.4 NOTIFICATION SYSTEM
- Anchor: 44-4-notification-system
- Depends on: ['44.3 REAL‑TIME CHAT SYSTEM']
- Feeds into: ['44.5 SOCIAL PROFILES']
- Related: ['44.3 REAL‑TIME CHAT SYSTEM', '44.5 SOCIAL PROFILES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.5 SOCIAL PROFILES
- Anchor: 44-5-social-profiles
- Depends on: ['44.4 NOTIFICATION SYSTEM']
- Feeds into: ['44.6 FRIENDS & BLOCKING SYSTEM']
- Related: ['44.4 NOTIFICATION SYSTEM', '44.6 FRIENDS & BLOCKING SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.6 FRIENDS & BLOCKING SYSTEM
- Anchor: 44-6-friends-blocking-system
- Depends on: ['44.5 SOCIAL PROFILES']
- Feeds into: ['44.7 SOCIAL REPUTATION SYSTEM']
- Related: ['44.5 SOCIAL PROFILES', '44.7 SOCIAL REPUTATION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.7 SOCIAL REPUTATION SYSTEM
- Anchor: 44-7-social-reputation-system
- Depends on: ['44.6 FRIENDS & BLOCKING SYSTEM']
- Feeds into: ['44.8 COMMUNITY TOOLS']
- Related: ['44.6 FRIENDS & BLOCKING SYSTEM', '44.8 COMMUNITY TOOLS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.8 COMMUNITY TOOLS
- Anchor: 44-8-community-tools
- Depends on: ['44.7 SOCIAL REPUTATION SYSTEM']
- Feeds into: ['Leaderboards:']
- Related: ['44.7 SOCIAL REPUTATION SYSTEM', 'Leaderboards:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Leaderboards:
- Anchor: leaderboards
- Depends on: ['44.8 COMMUNITY TOOLS']
- Feeds into: ['Bulletin Boards:']
- Related: ['44.8 COMMUNITY TOOLS', 'Bulletin Boards:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Bulletin Boards:
- Anchor: bulletin-boards
- Depends on: ['Leaderboards:']
- Feeds into: ['Event Feed:']
- Related: ['Leaderboards:', 'Event Feed:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Event Feed:
- Anchor: event-feed
- Depends on: ['Bulletin Boards:']
- Feeds into: ['44.9 CHAT & MAIL ANTI‑EXPLOIT SYSTEM']
- Related: ['Bulletin Boards:', '44.9 CHAT & MAIL ANTI‑EXPLOIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.9 CHAT & MAIL ANTI‑EXPLOIT SYSTEM
- Anchor: 44-9-chat-mail-anti-exploit-system
- Depends on: ['Event Feed:']
- Feeds into: ['CHUNK 45 — ADMIN PANEL, STAFF TOOLS, MODERATION, ANTI-CHEAT & SECURITY FRAMEWORK']
- Related: ['Event Feed:', 'CHUNK 45 — ADMIN PANEL, STAFF TOOLS, MODERATION, ANTI-CHEAT & SECURITY FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 45 — ADMIN PANEL, STAFF TOOLS, MODERATION, ANTI-CHEAT & SECURITY FRAMEWORK
- Anchor: chunk-45-admin-panel-staff-tools-moderation-anti-cheat-security-framework
- Depends on: ['44.9 CHAT & MAIL ANTI‑EXPLOIT SYSTEM']
- Feeds into: ['45.1 ADMIN & STAFF SYSTEM OVERVIEW']
- Related: ['44.9 CHAT & MAIL ANTI‑EXPLOIT SYSTEM', '45.1 ADMIN & STAFF SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.1 ADMIN & STAFF SYSTEM OVERVIEW
- Anchor: 45-1-admin-staff-system-overview
- Depends on: ['CHUNK 45 — ADMIN PANEL, STAFF TOOLS, MODERATION, ANTI-CHEAT & SECURITY FRAMEWORK']
- Feeds into: ['45.2 ADMIN PANEL (FULL DASHBOARD)']
- Related: ['CHUNK 45 — ADMIN PANEL, STAFF TOOLS, MODERATION, ANTI-CHEAT & SECURITY FRAMEWORK', '45.2 ADMIN PANEL (FULL DASHBOARD)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.2 ADMIN PANEL (FULL DASHBOARD)
- Anchor: 45-2-admin-panel-full-dashboard
- Depends on: ['45.1 ADMIN & STAFF SYSTEM OVERVIEW']
- Feeds into: ['User Management:']
- Related: ['45.1 ADMIN & STAFF SYSTEM OVERVIEW', 'User Management:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## User Management:
- Anchor: user-management
- Depends on: ['45.2 ADMIN PANEL (FULL DASHBOARD)']
- Feeds into: ['Item Tools:']
- Related: ['45.2 ADMIN PANEL (FULL DASHBOARD)', 'Item Tools:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Item Tools:
- Anchor: item-tools
- Depends on: ['User Management:']
- Feeds into: ['45.3 MODERATOR TOOLS']
- Related: ['User Management:', '45.3 MODERATOR TOOLS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.3 MODERATOR TOOLS
- Anchor: 45-3-moderator-tools
- Depends on: ['Item Tools:']
- Feeds into: ['Chat Moderation:']
- Related: ['Item Tools:', 'Chat Moderation:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Chat Moderation:
- Anchor: chat-moderation
- Depends on: ['45.3 MODERATOR TOOLS']
- Feeds into: ['Player Reports:']
- Related: ['45.3 MODERATOR TOOLS', 'Player Reports:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Player Reports:
- Anchor: player-reports
- Depends on: ['Chat Moderation:']
- Feeds into: ['Player Notes:']
- Related: ['Chat Moderation:', 'Player Notes:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Player Notes:
- Anchor: player-notes
- Depends on: ['Player Reports:']
- Feeds into: ['Quick Tools:']
- Related: ['Player Reports:', 'Quick Tools:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Quick Tools:
- Anchor: quick-tools
- Depends on: ['Player Notes:']
- Feeds into: ['45.4 LOGGING SYSTEM (FULL COVERAGE)']
- Related: ['Player Notes:', '45.4 LOGGING SYSTEM (FULL COVERAGE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.4 LOGGING SYSTEM (FULL COVERAGE)
- Anchor: 45-4-logging-system-full-coverage
- Depends on: ['Quick Tools:']
- Feeds into: ['Player Logs:']
- Related: ['Quick Tools:', 'Player Logs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Player Logs:
- Anchor: player-logs
- Depends on: ['45.4 LOGGING SYSTEM (FULL COVERAGE)']
- Feeds into: ['Admin Logs:']
- Related: ['45.4 LOGGING SYSTEM (FULL COVERAGE)', 'Admin Logs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Admin Logs:
- Anchor: admin-logs
- Depends on: ['Player Logs:']
- Feeds into: ['Security Logs:']
- Related: ['Player Logs:', 'Security Logs:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Security Logs:
- Anchor: security-logs
- Depends on: ['Admin Logs:']
- Feeds into: ['45.5 ANTI-CHEAT ENGINE']
- Related: ['Admin Logs:', '45.5 ANTI-CHEAT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.5 ANTI-CHEAT ENGINE
- Anchor: 45-5-anti-cheat-engine
- Depends on: ['Security Logs:']
- Feeds into: ['Speedhack Detection:']
- Related: ['Security Logs:', 'Speedhack Detection:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Speedhack Detection:
- Anchor: speedhack-detection
- Depends on: ['45.5 ANTI-CHEAT ENGINE']
- Feeds into: ['Stat Manipulation Detection:']
- Related: ['45.5 ANTI-CHEAT ENGINE', 'Stat Manipulation Detection:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Stat Manipulation Detection:
- Anchor: stat-manipulation-detection
- Depends on: ['Speedhack Detection:']
- Feeds into: ['Macro Detection:']
- Related: ['Speedhack Detection:', 'Macro Detection:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Macro Detection:
- Anchor: macro-detection
- Depends on: ['Stat Manipulation Detection:']
- Feeds into: ['45.6 EXPLOIT DETECTION ENGINE']
- Related: ['Stat Manipulation Detection:', '45.6 EXPLOIT DETECTION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.6 EXPLOIT DETECTION ENGINE
- Anchor: 45-6-exploit-detection-engine
- Depends on: ['Macro Detection:']
- Feeds into: ['45.7 SECURITY FRAMEWORK']
- Related: ['Macro Detection:', '45.7 SECURITY FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.7 SECURITY FRAMEWORK
- Anchor: 45-7-security-framework
- Depends on: ['45.6 EXPLOIT DETECTION ENGINE']
- Feeds into: ['Account Protection:']
- Related: ['45.6 EXPLOIT DETECTION ENGINE', 'Account Protection:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Account Protection:
- Anchor: account-protection
- Depends on: ['45.7 SECURITY FRAMEWORK']
- Feeds into: ['Session Protections:']
- Related: ['45.7 SECURITY FRAMEWORK', 'Session Protections:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Session Protections:
- Anchor: session-protections
- Depends on: ['Account Protection:']
- Feeds into: ['Request Protections:']
- Related: ['Account Protection:', 'Request Protections:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Request Protections:
- Anchor: request-protections
- Depends on: ['Session Protections:']
- Feeds into: ['Trade Protections:']
- Related: ['Session Protections:', 'Trade Protections:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Trade Protections:
- Anchor: trade-protections
- Depends on: ['Request Protections:']
- Feeds into: ['45.8 STAFF AUDIT TRAIL & ACCOUNTABILITY']
- Related: ['Request Protections:', '45.8 STAFF AUDIT TRAIL & ACCOUNTABILITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.8 STAFF AUDIT TRAIL & ACCOUNTABILITY
- Anchor: 45-8-staff-audit-trail-accountability
- Depends on: ['Trade Protections:']
- Feeds into: ['45.9 GDPR / LEGAL / PRIVACY TOOLS']
- Related: ['Trade Protections:', '45.9 GDPR / LEGAL / PRIVACY TOOLS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.9 GDPR / LEGAL / PRIVACY TOOLS
- Anchor: 45-9-gdpr-legal-privacy-tools
- Depends on: ['45.8 STAFF AUDIT TRAIL & ACCOUNTABILITY']
- Feeds into: ['45.10 INCIDENT RESPONSE WORKFLOW']
- Related: ['45.8 STAFF AUDIT TRAIL & ACCOUNTABILITY', '45.10 INCIDENT RESPONSE WORKFLOW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.10 INCIDENT RESPONSE WORKFLOW
- Anchor: 45-10-incident-response-workflow
- Depends on: ['45.9 GDPR / LEGAL / PRIVACY TOOLS']
- Feeds into: ['CHUNK 46 — WORLD EVENTS, DYNAMIC AI DIRECTOR, SEASONAL SYSTEM & CRISIS ENGINE']
- Related: ['45.9 GDPR / LEGAL / PRIVACY TOOLS', 'CHUNK 46 — WORLD EVENTS, DYNAMIC AI DIRECTOR, SEASONAL SYSTEM & CRISIS ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 46 — WORLD EVENTS, DYNAMIC AI DIRECTOR, SEASONAL SYSTEM & CRISIS ENGINE
- Anchor: chunk-46-world-events-dynamic-ai-director-seasonal-system-crisis-engine
- Depends on: ['45.10 INCIDENT RESPONSE WORKFLOW']
- Feeds into: ['46.1 WORLD SYSTEM OVERVIEW']
- Related: ['45.10 INCIDENT RESPONSE WORKFLOW', '46.1 WORLD SYSTEM OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.1 WORLD SYSTEM OVERVIEW
- Anchor: 46-1-world-system-overview
- Depends on: ['CHUNK 46 — WORLD EVENTS, DYNAMIC AI DIRECTOR, SEASONAL SYSTEM & CRISIS ENGINE']
- Feeds into: ['46.2 AI DIRECTOR — DYNAMIC CITY CONTROLLER']
- Related: ['CHUNK 46 — WORLD EVENTS, DYNAMIC AI DIRECTOR, SEASONAL SYSTEM & CRISIS ENGINE', '46.2 AI DIRECTOR — DYNAMIC CITY CONTROLLER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.2 AI DIRECTOR — DYNAMIC CITY CONTROLLER
- Anchor: 46-2-ai-director-dynamic-city-controller
- Depends on: ['46.1 WORLD SYSTEM OVERVIEW']
- Feeds into: ['The AI Director monitors:']
- Related: ['46.1 WORLD SYSTEM OVERVIEW', 'The AI Director monitors:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The AI Director monitors:
- Anchor: the-ai-director-monitors
- Depends on: ['46.2 AI DIRECTOR — DYNAMIC CITY CONTROLLER']
- Feeds into: ['The AI Director can:']
- Related: ['46.2 AI DIRECTOR — DYNAMIC CITY CONTROLLER', 'The AI Director can:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The AI Director can:
- Anchor: the-ai-director-can
- Depends on: ['The AI Director monitors:']
- Feeds into: ['Director Behaviour States:']
- Related: ['The AI Director monitors:', 'Director Behaviour States:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Director Behaviour States:
- Anchor: director-behaviour-states
- Depends on: ['The AI Director can:']
- Feeds into: ['46.3 WORLD EVENT ENGINE']
- Related: ['The AI Director can:', '46.3 WORLD EVENT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.3 WORLD EVENT ENGINE
- Anchor: 46-3-world-event-engine
- Depends on: ['Director Behaviour States:']
- Feeds into: ['Event Types:']
- Related: ['Director Behaviour States:', 'Event Types:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Event Types:
- Anchor: event-types
- Depends on: ['46.3 WORLD EVENT ENGINE']
- Feeds into: ['Events Affect:']
- Related: ['46.3 WORLD EVENT ENGINE', 'Events Affect:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Events Affect:
- Anchor: events-affect
- Depends on: ['Event Types:']
- Feeds into: ['46.4 SEASONAL SYSTEM']
- Related: ['Event Types:', '46.4 SEASONAL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.4 SEASONAL SYSTEM
- Anchor: 46-4-seasonal-system
- Depends on: ['Events Affect:']
- Feeds into: ['Seasonal Themes Examples:']
- Related: ['Events Affect:', 'Seasonal Themes Examples:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Seasonal Themes Examples:
- Anchor: seasonal-themes-examples
- Depends on: ['46.4 SEASONAL SYSTEM']
- Feeds into: ['46.5 CRISIS ENGINE']
- Related: ['46.4 SEASONAL SYSTEM', '46.5 CRISIS ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.5 CRISIS ENGINE
- Anchor: 46-5-crisis-engine
- Depends on: ['Seasonal Themes Examples:']
- Feeds into: ['Crisis Types:']
- Related: ['Seasonal Themes Examples:', 'Crisis Types:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Crisis Types:
- Anchor: crisis-types
- Depends on: ['46.5 CRISIS ENGINE']
- Feeds into: ['1. **City Lockdown**']
- Related: ['46.5 CRISIS ENGINE', '1. **City Lockdown**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. **City Lockdown**
- Anchor: 1-city-lockdown
- Depends on: ['Crisis Types:']
- Feeds into: ['2. **Blackout**']
- Related: ['Crisis Types:', '2. **Blackout**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. **Blackout**
- Anchor: 2-blackout
- Depends on: ['1. **City Lockdown**']
- Feeds into: ['3. **Syndicate City Takeover**']
- Related: ['1. **City Lockdown**', '3. **Syndicate City Takeover**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. **Syndicate City Takeover**
- Anchor: 3-syndicate-city-takeover
- Depends on: ['2. **Blackout**']
- Feeds into: ['4. **Economic Collapse**']
- Related: ['2. **Blackout**', '4. **Economic Collapse**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4. **Economic Collapse**
- Anchor: 4-economic-collapse
- Depends on: ['3. **Syndicate City Takeover**']
- Feeds into: ['5. **Storm / Weather Crisis**']
- Related: ['3. **Syndicate City Takeover**', '5. **Storm / Weather Crisis**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5. **Storm / Weather Crisis**
- Anchor: 5-storm-weather-crisis
- Depends on: ['4. **Economic Collapse**']
- Feeds into: ['6. **Pandemic Event**']
- Related: ['4. **Economic Collapse**', '6. **Pandemic Event**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 6. **Pandemic Event**
- Anchor: 6-pandemic-event
- Depends on: ['5. **Storm / Weather Crisis**']
- Feeds into: ['Community Goals:']
- Related: ['5. **Storm / Weather Crisis**', 'Community Goals:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Community Goals:
- Anchor: community-goals
- Depends on: ['6. **Pandemic Event**']
- Feeds into: ['46.7 EVENT REWARD STRUCTURE']
- Related: ['6. **Pandemic Event**', '46.7 EVENT REWARD STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.7 EVENT REWARD STRUCTURE
- Anchor: 46-7-event-reward-structure
- Depends on: ['Community Goals:']
- Feeds into: ['46.8 EVENT SCHEDULING & RANDOMISATION']
- Related: ['Community Goals:', '46.8 EVENT SCHEDULING & RANDOMISATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.8 EVENT SCHEDULING & RANDOMISATION
- Anchor: 46-8-event-scheduling-randomisation
- Depends on: ['46.7 EVENT REWARD STRUCTURE']
- Feeds into: ['46.9 CRISIS ANTI-EXPLOIT SYSTEM']
- Related: ['46.7 EVENT REWARD STRUCTURE', '46.9 CRISIS ANTI-EXPLOIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.9 CRISIS ANTI-EXPLOIT SYSTEM
- Anchor: 46-9-crisis-anti-exploit-system
- Depends on: ['46.8 EVENT SCHEDULING & RANDOMISATION']
- Feeds into: ['Civilian AI:']
- Related: ['46.8 EVENT SCHEDULING & RANDOMISATION', 'Civilian AI:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Civilian AI:
- Anchor: civilian-ai
- Depends on: ['46.9 CRISIS ANTI-EXPLOIT SYSTEM']
- Feeds into: ['CHUNK 48 — ENDGAME SYSTEMS, LEGACY CONTENT, PLAYER RANKS, PRESTIGE LOOPS & FUTURE EXPANSIONS']
- Related: ['46.9 CRISIS ANTI-EXPLOIT SYSTEM', 'CHUNK 48 — ENDGAME SYSTEMS, LEGACY CONTENT, PLAYER RANKS, PRESTIGE LOOPS & FUTURE EXPANSIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CHUNK 48 — ENDGAME SYSTEMS, LEGACY CONTENT, PLAYER RANKS, PRESTIGE LOOPS & FUTURE EXPANSIONS
- Anchor: chunk-48-endgame-systems-legacy-content-player-ranks-prestige-loops-future-expansions
- Depends on: ['Civilian AI:']
- Feeds into: ['48.1 ENDGAME OVERVIEW']
- Related: ['Civilian AI:', '48.1 ENDGAME OVERVIEW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.1 ENDGAME OVERVIEW
- Anchor: 48-1-endgame-overview
- Depends on: ['CHUNK 48 — ENDGAME SYSTEMS, LEGACY CONTENT, PLAYER RANKS, PRESTIGE LOOPS & FUTURE EXPANSIONS']
- Feeds into: ['48.2 PLAYER RANK FRAMEWORK']
- Related: ['CHUNK 48 — ENDGAME SYSTEMS, LEGACY CONTENT, PLAYER RANKS, PRESTIGE LOOPS & FUTURE EXPANSIONS', '48.2 PLAYER RANK FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.2 PLAYER RANK FRAMEWORK
- Anchor: 48-2-player-rank-framework
- Depends on: ['48.1 ENDGAME OVERVIEW']
- Feeds into: ['Rank Tiers:']
- Related: ['48.1 ENDGAME OVERVIEW', 'Rank Tiers:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rank Tiers:
- Anchor: rank-tiers
- Depends on: ['48.2 PLAYER RANK FRAMEWORK']
- Feeds into: ['Rank Rewards:']
- Related: ['48.2 PLAYER RANK FRAMEWORK', 'Rank Rewards:', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rank Rewards:
- Anchor: rank-rewards
- Depends on: ['Rank Tiers:']
- Feeds into: ['48.3 PRESTIGE & REBIRTH LOOPS']
- Related: ['Rank Tiers:', '48.3 PRESTIGE & REBIRTH LOOPS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.3 PRESTIGE & REBIRTH LOOPS
- Anchor: 48-3-prestige-rebirth-loops
- Depends on: ['Rank Rewards:']
- Feeds into: ['48.4 MASTERY TREES (POST-PRESTIGE)']
- Related: ['Rank Rewards:', '48.4 MASTERY TREES (POST-PRESTIGE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.4 MASTERY TREES (POST-PRESTIGE)
- Anchor: 48-4-mastery-trees-post-prestige
- Depends on: ['48.3 PRESTIGE & REBIRTH LOOPS']
- Feeds into: ['48.6 ELITE CRAFTING & PROTOTYPE ITEMS']
- Related: ['48.3 PRESTIGE & REBIRTH LOOPS', '48.6 ELITE CRAFTING & PROTOTYPE ITEMS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.6 ELITE CRAFTING & PROTOTYPE ITEMS
- Anchor: 48-6-elite-crafting-prototype-items
- Depends on: ['48.4 MASTERY TREES (POST-PRESTIGE)']
- Feeds into: ['48.7 RAID FORTRESSES (ENDGAME GROUP CONTENT)']
- Related: ['48.4 MASTERY TREES (POST-PRESTIGE)', '48.7 RAID FORTRESSES (ENDGAME GROUP CONTENT)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.7 RAID FORTRESSES (ENDGAME GROUP CONTENT)
- Anchor: 48-7-raid-fortresses-endgame-group-content
- Depends on: ['48.6 ELITE CRAFTING & PROTOTYPE ITEMS']
- Feeds into: ['48.8 MEGA-HEISTS (ULTIMATE SOLO/GROUP MISSIONS)']
- Related: ['48.6 ELITE CRAFTING & PROTOTYPE ITEMS', '48.8 MEGA-HEISTS (ULTIMATE SOLO/GROUP MISSIONS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.8 MEGA-HEISTS (ULTIMATE SOLO/GROUP MISSIONS)
- Anchor: 48-8-mega-heists-ultimate-solo-group-missions
- Depends on: ['48.7 RAID FORTRESSES (ENDGAME GROUP CONTENT)']
- Feeds into: ['48.9 LEGACY CONTENT (LONG-TERM STORYLINES)']
- Related: ['48.7 RAID FORTRESSES (ENDGAME GROUP CONTENT)', '48.9 LEGACY CONTENT (LONG-TERM STORYLINES)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.9 LEGACY CONTENT (LONG-TERM STORYLINES)
- Anchor: 48-9-legacy-content-long-term-storylines
- Depends on: ['48.8 MEGA-HEISTS (ULTIMATE SOLO/GROUP MISSIONS)']
- Feeds into: ['48.10 FUTURE EXPANSIONS — OFFICIAL BLUEPRINT']
- Related: ['48.8 MEGA-HEISTS (ULTIMATE SOLO/GROUP MISSIONS)', '48.10 FUTURE EXPANSIONS — OFFICIAL BLUEPRINT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.10 FUTURE EXPANSIONS — OFFICIAL BLUEPRINT
- Anchor: 48-10-future-expansions-official-blueprint
- Depends on: ['48.9 LEGACY CONTENT (LONG-TERM STORYLINES)']
- Feeds into: ['Expansion 1: **Global Syndicate War**']
- Related: ['48.9 LEGACY CONTENT (LONG-TERM STORYLINES)', 'Expansion 1: **Global Syndicate War**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Expansion 1: **Global Syndicate War**
- Anchor: expansion-1-global-syndicate-war
- Depends on: ['48.10 FUTURE EXPANSIONS — OFFICIAL BLUEPRINT']
- Feeds into: ['Expansion 3: **Properties 2.0**']
- Related: ['48.10 FUTURE EXPANSIONS — OFFICIAL BLUEPRINT', 'Expansion 3: **Properties 2.0**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Expansion 3: **Properties 2.0**
- Anchor: expansion-3-properties-2-0
- Depends on: ['Expansion 1: **Global Syndicate War**']
- Feeds into: ['Expansion 4: **Smuggler Capital Update**']
- Related: ['Expansion 1: **Global Syndicate War**', 'Expansion 4: **Smuggler Capital Update**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Expansion 4: **Smuggler Capital Update**
- Anchor: expansion-4-smuggler-capital-update
- Depends on: ['Expansion 3: **Properties 2.0**']
- Feeds into: ['Expansion 5: **AI Director 2.0**']
- Related: ['Expansion 3: **Properties 2.0**', 'Expansion 5: **AI Director 2.0**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Expansion 5: **AI Director 2.0**
- Anchor: expansion-5-ai-director-2-0
- Depends on: ['Expansion 4: **Smuggler Capital Update**']
- Feeds into: ['Expansion 6: **New UK Regions**']
- Related: ['Expansion 4: **Smuggler Capital Update**', 'Expansion 6: **New UK Regions**', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Expansion 6: **New UK Regions**
- Anchor: expansion-6-new-uk-regions
- Depends on: ['Expansion 5: **AI Director 2.0**']
- Feeds into: ['48.11 ENDGAME ANTI-EXPLOIT SYSTEM']
- Related: ['Expansion 5: **AI Director 2.0**', '48.11 ENDGAME ANTI-EXPLOIT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.11 ENDGAME ANTI-EXPLOIT SYSTEM
- Anchor: 48-11-endgame-anti-exploit-system
- Depends on: ['Expansion 6: **New UK Regions**']
- Feeds into: ['MASTERBIBLE V3 — AAA STUDIO ULTRA EDITION']
- Related: ['Expansion 6: **New UK Regions**', 'MASTERBIBLE V3 — AAA STUDIO ULTRA EDITION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MASTERBIBLE V3 — AAA STUDIO ULTRA EDITION
- Anchor: masterbible-v3-aaa-studio-ultra-edition
- Depends on: ['48.11 ENDGAME ANTI-EXPLOIT SYSTEM']
- Feeds into: ['The Complete Canonical Law of Trench City']
- Related: ['48.11 ENDGAME ANTI-EXPLOIT SYSTEM', 'The Complete Canonical Law of Trench City', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Complete Canonical Law of Trench City
- Anchor: the-complete-canonical-law-of-trench-city
- Depends on: ['MASTERBIBLE V3 — AAA STUDIO ULTRA EDITION']
- Feeds into: ['1. HIGH-ORDER GAME PHILOSOPHY']
- Related: ['MASTERBIBLE V3 — AAA STUDIO ULTRA EDITION', '1. HIGH-ORDER GAME PHILOSOPHY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. HIGH-ORDER GAME PHILOSOPHY
- Anchor: 1-high-order-game-philosophy
- Depends on: ['The Complete Canonical Law of Trench City']
- Feeds into: ['2. WORLD META-ARCHITECTURE']
- Related: ['The Complete Canonical Law of Trench City', '2. WORLD META-ARCHITECTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. WORLD META-ARCHITECTURE
- Anchor: 2-world-meta-architecture
- Depends on: ['1. HIGH-ORDER GAME PHILOSOPHY']
- Feeds into: ['2.1 SYSTEM LAYER']
- Related: ['1. HIGH-ORDER GAME PHILOSOPHY', '2.1 SYSTEM LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.1 SYSTEM LAYER
- Anchor: 2-1-system-layer
- Depends on: ['2. WORLD META-ARCHITECTURE']
- Feeds into: ['2.2 CONTENT LAYER']
- Related: ['2. WORLD META-ARCHITECTURE', '2.2 CONTENT LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.2 CONTENT LAYER
- Anchor: 2-2-content-layer
- Depends on: ['2.1 SYSTEM LAYER']
- Feeds into: ['2.3 SIMULATION LAYER']
- Related: ['2.1 SYSTEM LAYER', '2.3 SIMULATION LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.3 SIMULATION LAYER
- Anchor: 2-3-simulation-layer
- Depends on: ['2.2 CONTENT LAYER']
- Feeds into: ['2.4 PLAYER-CREATED LAYER']
- Related: ['2.2 CONTENT LAYER', '2.4 PLAYER-CREATED LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2.4 PLAYER-CREATED LAYER
- Anchor: 2-4-player-created-layer
- Depends on: ['2.3 SIMULATION LAYER']
- Feeds into: ['3. PLAYER SYSTEM BLUEPRINT (EXTENDED)']
- Related: ['2.3 SIMULATION LAYER', '3. PLAYER SYSTEM BLUEPRINT (EXTENDED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. PLAYER SYSTEM BLUEPRINT (EXTENDED)
- Anchor: 3-player-system-blueprint-extended
- Depends on: ['2.4 PLAYER-CREATED LAYER']
- Feeds into: ['3.1 BUILD IDENTITIES']
- Related: ['2.4 PLAYER-CREATED LAYER', '3.1 BUILD IDENTITIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3.1 BUILD IDENTITIES
- Anchor: 3-1-build-identities
- Depends on: ['3. PLAYER SYSTEM BLUEPRINT (EXTENDED)']
- Feeds into: ['1 — **The Titan** (DEF-focused)']
- Related: ['3. PLAYER SYSTEM BLUEPRINT (EXTENDED)', '1 — **The Titan** (DEF-focused)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1 — **The Titan** (DEF-focused)
- Anchor: 1-the-titan-def-focused
- Depends on: ['3.1 BUILD IDENTITIES']
- Feeds into: ['2 — **The Executioner** (STR-focused)']
- Related: ['3.1 BUILD IDENTITIES', '2 — **The Executioner** (STR-focused)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2 — **The Executioner** (STR-focused)
- Anchor: 2-the-executioner-str-focused
- Depends on: ['1 — **The Titan** (DEF-focused)']
- Feeds into: ['3 — **The Shade** (SPD-focused)']
- Related: ['1 — **The Titan** (DEF-focused)', '3 — **The Shade** (SPD-focused)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3 — **The Shade** (SPD-focused)
- Anchor: 3-the-shade-spd-focused
- Depends on: ['2 — **The Executioner** (STR-focused)']
- Feeds into: ['4 — **The Surgeon** (DEX-focused)']
- Related: ['2 — **The Executioner** (STR-focused)', '4 — **The Surgeon** (DEX-focused)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 4 — **The Surgeon** (DEX-focused)
- Anchor: 4-the-surgeon-dex-focused
- Depends on: ['3 — **The Shade** (SPD-focused)']
- Feeds into: ['5 — **The Mastermind** (INT, CHA, AWR hybrid)']
- Related: ['3 — **The Shade** (SPD-focused)', '5 — **The Mastermind** (INT, CHA, AWR hybrid)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5 — **The Mastermind** (INT, CHA, AWR hybrid)
- Anchor: 5-the-mastermind-int-cha-awr-hybrid
- Depends on: ['4 — **The Surgeon** (DEX-focused)']
- Feeds into: ['3.2 FULL BARS REGEN SYSTEM']
- Related: ['4 — **The Surgeon** (DEX-focused)', '3.2 FULL BARS REGEN SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3.2 FULL BARS REGEN SYSTEM
- Anchor: 3-2-full-bars-regen-system
- Depends on: ['5 — **The Mastermind** (INT, CHA, AWR hybrid)']
- Feeds into: ['5.1 FULL DAMAGE PIPELINE']
- Related: ['5 — **The Mastermind** (INT, CHA, AWR hybrid)', '5.1 FULL DAMAGE PIPELINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.1 FULL DAMAGE PIPELINE
- Anchor: 5-1-full-damage-pipeline
- Depends on: ['3.2 FULL BARS REGEN SYSTEM']
- Feeds into: ['5.2 STATUS EFFECTS (EXTENDED)']
- Related: ['3.2 FULL BARS REGEN SYSTEM', '5.2 STATUS EFFECTS (EXTENDED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 5.2 STATUS EFFECTS (EXTENDED)
- Anchor: 5-2-status-effects-extended
- Depends on: ['5.1 FULL DAMAGE PIPELINE']
- Feeds into: ['7. ECONOMIC SUPERSTRUCTURE']
- Related: ['5.1 FULL DAMAGE PIPELINE', '7. ECONOMIC SUPERSTRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7. ECONOMIC SUPERSTRUCTURE
- Anchor: 7-economic-superstructure
- Depends on: ['5.2 STATUS EFFECTS (EXTENDED)']
- Feeds into: ['7.3 AI GOVERNOR']
- Related: ['5.2 STATUS EFFECTS (EXTENDED)', '7.3 AI GOVERNOR', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 7.3 AI GOVERNOR
- Anchor: 7-3-ai-governor
- Depends on: ['7. ECONOMIC SUPERSTRUCTURE']
- Feeds into: ['9.1 RISK ZONES']
- Related: ['7. ECONOMIC SUPERSTRUCTURE', '9.1 RISK ZONES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.1 RISK ZONES
- Anchor: 9-1-risk-zones
- Depends on: ['7.3 AI GOVERNOR']
- Feeds into: ['9.2 CONTRABAND EFFECTS']
- Related: ['7.3 AI GOVERNOR', '9.2 CONTRABAND EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 9.2 CONTRABAND EFFECTS
- Anchor: 9-2-contraband-effects
- Depends on: ['9.1 RISK ZONES']
- Feeds into: ['11. EVENTS & SEASONS — OMNISYSTEM']
- Related: ['9.1 RISK ZONES', '11. EVENTS & SEASONS — OMNISYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 11. EVENTS & SEASONS — OMNISYSTEM
- Anchor: 11-events-seasons-omnisystem
- Depends on: ['9.2 CONTRABAND EFFECTS']
- Feeds into: ['12. META-PSYCHOLOGY DESIGN']
- Related: ['9.2 CONTRABAND EFFECTS', '12. META-PSYCHOLOGY DESIGN', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 12. META-PSYCHOLOGY DESIGN
- Anchor: 12-meta-psychology-design
- Depends on: ['11. EVENTS & SEASONS — OMNISYSTEM']
- Feeds into: ['13. ANTI-CHEAT & SECURITY ULTRA-LAYER']
- Related: ['11. EVENTS & SEASONS — OMNISYSTEM', '13. ANTI-CHEAT & SECURITY ULTRA-LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 13. ANTI-CHEAT & SECURITY ULTRA-LAYER
- Anchor: 13-anti-cheat-security-ultra-layer
- Depends on: ['12. META-PSYCHOLOGY DESIGN']
- Feeds into: ['14. TECHNICAL CANON — ENGINE LAW']
- Related: ['12. META-PSYCHOLOGY DESIGN', '14. TECHNICAL CANON — ENGINE LAW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 14. TECHNICAL CANON — ENGINE LAW
- Anchor: 14-technical-canon-engine-law
- Depends on: ['13. ANTI-CHEAT & SECURITY ULTRA-LAYER']
- Feeds into: ['15. FUTURE EXPANSION LAW']
- Related: ['13. ANTI-CHEAT & SECURITY ULTRA-LAYER', '15. FUTURE EXPANSION LAW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 15. FUTURE EXPANSION LAW
- Anchor: 15-future-expansion-law
- Depends on: ['14. TECHNICAL CANON — ENGINE LAW']
- Feeds into: ['END OF MASTERBIBLE V3']
- Related: ['14. TECHNICAL CANON — ENGINE LAW', 'END OF MASTERBIBLE V3', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## END OF MASTERBIBLE V3
- Anchor: end-of-masterbible-v3
- Depends on: ['15. FUTURE EXPANSION LAW']
- Feeds into: ['16. THE WORLD-TENSION ENGINE (WTE)']
- Related: ['15. FUTURE EXPANSION LAW', '16. THE WORLD-TENSION ENGINE (WTE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16. THE WORLD-TENSION ENGINE (WTE)
- Anchor: 16-the-world-tension-engine-wte
- Depends on: ['END OF MASTERBIBLE V3']
- Feeds into: ['16.1 TENSION BRACKETS']
- Related: ['END OF MASTERBIBLE V3', '16.1 TENSION BRACKETS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 16.1 TENSION BRACKETS
- Anchor: 16-1-tension-brackets
- Depends on: ['16. THE WORLD-TENSION ENGINE (WTE)']
- Feeds into: ['Low Tension (0–120)']
- Related: ['16. THE WORLD-TENSION ENGINE (WTE)', 'Low Tension (0–120)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Low Tension (0–120)
- Anchor: low-tension-0-120
- Depends on: ['16.1 TENSION BRACKETS']
- Feeds into: ['Medium Tension (120–250)']
- Related: ['16.1 TENSION BRACKETS', 'Medium Tension (120–250)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Medium Tension (120–250)
- Anchor: medium-tension-120-250
- Depends on: ['Low Tension (0–120)']
- Feeds into: ['High Tension (250–400)']
- Related: ['Low Tension (0–120)', 'High Tension (250–400)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## High Tension (250–400)
- Anchor: high-tension-250-400
- Depends on: ['Medium Tension (120–250)']
- Feeds into: ['Critical Tension (400–500)']
- Related: ['Medium Tension (120–250)', 'Critical Tension (400–500)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Critical Tension (400–500)
- Anchor: critical-tension-400-500
- Depends on: ['High Tension (250–400)']
- Feeds into: ['17.1 SYNDICATE DECISION LOOP (Runs every hour)']
- Related: ['High Tension (250–400)', '17.1 SYNDICATE DECISION LOOP (Runs every hour)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 17.1 SYNDICATE DECISION LOOP (Runs every hour)
- Anchor: 17-1-syndicate-decision-loop-runs-every-hour
- Depends on: ['Critical Tension (400–500)']
- Feeds into: ['18.2 AI GOVERNOR INTERVENTIONS']
- Related: ['Critical Tension (400–500)', '18.2 AI GOVERNOR INTERVENTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 18.2 AI GOVERNOR INTERVENTIONS
- Anchor: 18-2-ai-governor-interventions
- Depends on: ['17.1 SYNDICATE DECISION LOOP (Runs every hour)']
- Feeds into: ['19.1 ROLES']
- Related: ['17.1 SYNDICATE DECISION LOOP (Runs every hour)', '19.1 ROLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.1 ROLES
- Anchor: 19-1-roles
- Depends on: ['18.2 AI GOVERNOR INTERVENTIONS']
- Feeds into: ['19.3 CIVIL WAR CONDITIONS']
- Related: ['18.2 AI GOVERNOR INTERVENTIONS', '19.3 CIVIL WAR CONDITIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 19.3 CIVIL WAR CONDITIONS
- Anchor: 19-3-civil-war-conditions
- Depends on: ['19.1 ROLES']
- Feeds into: ['20.1 WEATHER EFFECTS']
- Related: ['19.1 ROLES', '20.1 WEATHER EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.1 WEATHER EFFECTS
- Anchor: 20-1-weather-effects
- Depends on: ['19.3 CIVIL WAR CONDITIONS']
- Feeds into: ['20.2 TERRAIN EFFECTS']
- Related: ['19.3 CIVIL WAR CONDITIONS', '20.2 TERRAIN EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 20.2 TERRAIN EFFECTS
- Anchor: 20-2-terrain-effects
- Depends on: ['20.1 WEATHER EFFECTS']
- Feeds into: ['21. BRANCHING MISSION STRUCTURE']
- Related: ['20.1 WEATHER EFFECTS', '21. BRANCHING MISSION STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21. BRANCHING MISSION STRUCTURE
- Anchor: 21-branching-mission-structure
- Depends on: ['20.2 TERRAIN EFFECTS']
- Feeds into: ['21.1 HEIST FRAMEWORK']
- Related: ['20.2 TERRAIN EFFECTS', '21.1 HEIST FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 21.1 HEIST FRAMEWORK
- Anchor: 21-1-heist-framework
- Depends on: ['21. BRANCHING MISSION STRUCTURE']
- Feeds into: ['23. TECHNICAL STACK EXPANDED']
- Related: ['21. BRANCHING MISSION STRUCTURE', '23. TECHNICAL STACK EXPANDED', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 23. TECHNICAL STACK EXPANDED
- Anchor: 23-technical-stack-expanded
- Depends on: ['21.1 HEIST FRAMEWORK']
- Feeds into: ['23.1 CLUSTER ARCHITECTURE']
- Related: ['21.1 HEIST FRAMEWORK', '23.1 CLUSTER ARCHITECTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 23.1 CLUSTER ARCHITECTURE
- Anchor: 23-1-cluster-architecture
- Depends on: ['23. TECHNICAL STACK EXPANDED']
- Feeds into: ['23.2 ANTI-EXPLOIT MATRIX']
- Related: ['23. TECHNICAL STACK EXPANDED', '23.2 ANTI-EXPLOIT MATRIX', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 23.2 ANTI-EXPLOIT MATRIX
- Anchor: 23-2-anti-exploit-matrix
- Depends on: ['23.1 CLUSTER ARCHITECTURE']
- Feeds into: ['The Warlord']
- Related: ['23.1 CLUSTER ARCHITECTURE', 'The Warlord', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Warlord
- Anchor: the-warlord
- Depends on: ['23.2 ANTI-EXPLOIT MATRIX']
- Feeds into: ['The Broker']
- Related: ['23.2 ANTI-EXPLOIT MATRIX', 'The Broker', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Broker
- Anchor: the-broker
- Depends on: ['The Warlord']
- Feeds into: ['The Assassin']
- Related: ['The Warlord', 'The Assassin', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Assassin
- Anchor: the-assassin
- Depends on: ['The Broker']
- Feeds into: ['The Ghost']
- Related: ['The Broker', 'The Ghost', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Ghost
- Anchor: the-ghost
- Depends on: ['The Assassin']
- Feeds into: ['The Saboteur']
- Related: ['The Assassin', 'The Saboteur', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Saboteur
- Anchor: the-saboteur
- Depends on: ['The Ghost']
- Feeds into: ['24.3 TERRITORY ECOLOGY']
- Related: ['The Ghost', '24.3 TERRITORY ECOLOGY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.3 TERRITORY ECOLOGY
- Anchor: 24-3-territory-ecology
- Depends on: ['The Saboteur']
- Feeds into: ['1. Criminal Ecosystem']
- Related: ['The Saboteur', '1. Criminal Ecosystem', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 1. Criminal Ecosystem
- Anchor: 1-criminal-ecosystem
- Depends on: ['24.3 TERRITORY ECOLOGY']
- Feeds into: ['2. Economic Ecosystem']
- Related: ['24.3 TERRITORY ECOLOGY', '2. Economic Ecosystem', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 2. Economic Ecosystem
- Anchor: 2-economic-ecosystem
- Depends on: ['1. Criminal Ecosystem']
- Feeds into: ['3. Enforcement Ecosystem']
- Related: ['1. Criminal Ecosystem', '3. Enforcement Ecosystem', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 3. Enforcement Ecosystem
- Anchor: 3-enforcement-ecosystem
- Depends on: ['2. Economic Ecosystem']
- Feeds into: ['24.4 DYNAMIC TERRITORY EVENTS']
- Related: ['2. Economic Ecosystem', '24.4 DYNAMIC TERRITORY EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 24.4 DYNAMIC TERRITORY EVENTS
- Anchor: 24-4-dynamic-territory-events
- Depends on: ['3. Enforcement Ecosystem']
- Feeds into: ['25.2 RACING FORMATS']
- Related: ['3. Enforcement Ecosystem', '25.2 RACING FORMATS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 25.2 RACING FORMATS
- Anchor: 25-2-racing-formats
- Depends on: ['24.4 DYNAMIC TERRITORY EVENTS']
- Feeds into: ['26. PRESTIGE SYSTEM — ENDGAME RENEWAL LOOP']
- Related: ['24.4 DYNAMIC TERRITORY EVENTS', '26. PRESTIGE SYSTEM — ENDGAME RENEWAL LOOP', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26. PRESTIGE SYSTEM — ENDGAME RENEWAL LOOP
- Anchor: 26-prestige-system-endgame-renewal-loop
- Depends on: ['25.2 RACING FORMATS']
- Feeds into: ['26.1 PRESTIGE TIERS']
- Related: ['25.2 RACING FORMATS', '26.1 PRESTIGE TIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.1 PRESTIGE TIERS
- Anchor: 26-1-prestige-tiers
- Depends on: ['26. PRESTIGE SYSTEM — ENDGAME RENEWAL LOOP']
- Feeds into: ['26.2 PRESTIGE PERK TREES']
- Related: ['26. PRESTIGE SYSTEM — ENDGAME RENEWAL LOOP', '26.2 PRESTIGE PERK TREES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.2 PRESTIGE PERK TREES
- Anchor: 26-2-prestige-perk-trees
- Depends on: ['26.1 PRESTIGE TIERS']
- Feeds into: ['Legacy Tree']
- Related: ['26.1 PRESTIGE TIERS', 'Legacy Tree', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Legacy Tree
- Anchor: legacy-tree
- Depends on: ['26.2 PRESTIGE PERK TREES']
- Feeds into: ['Influence Tree']
- Related: ['26.2 PRESTIGE PERK TREES', 'Influence Tree', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Influence Tree
- Anchor: influence-tree
- Depends on: ['Legacy Tree']
- Feeds into: ['Shadow Tree']
- Related: ['Legacy Tree', 'Shadow Tree', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Shadow Tree
- Anchor: shadow-tree
- Depends on: ['Influence Tree']
- Feeds into: ['26.3 SEASONAL WORLD RESETS']
- Related: ['Influence Tree', '26.3 SEASONAL WORLD RESETS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 26.3 SEASONAL WORLD RESETS
- Anchor: 26-3-seasonal-world-resets
- Depends on: ['Shadow Tree']
- Feeds into: ['27. INTERNATIONAL EXPANSION LAW']
- Related: ['Shadow Tree', '27. INTERNATIONAL EXPANSION LAW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27. INTERNATIONAL EXPANSION LAW
- Anchor: 27-international-expansion-law
- Depends on: ['26.3 SEASONAL WORLD RESETS']
- Feeds into: ['27.1 INTERNATIONAL HUBS']
- Related: ['26.3 SEASONAL WORLD RESETS', '27.1 INTERNATIONAL HUBS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27.1 INTERNATIONAL HUBS
- Anchor: 27-1-international-hubs
- Depends on: ['27. INTERNATIONAL EXPANSION LAW']
- Feeds into: ['27.2 INTER-CITY TRAVEL MECHANICS']
- Related: ['27. INTERNATIONAL EXPANSION LAW', '27.2 INTER-CITY TRAVEL MECHANICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 27.2 INTER-CITY TRAVEL MECHANICS
- Anchor: 27-2-inter-city-travel-mechanics
- Depends on: ['27.1 INTERNATIONAL HUBS']
- Feeds into: ['28. POLITICAL HIERARCHY OF THE UNDERWORLD']
- Related: ['27.1 INTERNATIONAL HUBS', '28. POLITICAL HIERARCHY OF THE UNDERWORLD', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28. POLITICAL HIERARCHY OF THE UNDERWORLD
- Anchor: 28-political-hierarchy-of-the-underworld
- Depends on: ['27.2 INTER-CITY TRAVEL MECHANICS']
- Feeds into: ['28.1 FIVE POWER BLOCKS']
- Related: ['27.2 INTER-CITY TRAVEL MECHANICS', '28.1 FIVE POWER BLOCKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.1 FIVE POWER BLOCKS
- Anchor: 28-1-five-power-blocks
- Depends on: ['28. POLITICAL HIERARCHY OF THE UNDERWORLD']
- Feeds into: ['28.2 WORLD GOVERNANCE CYCLE']
- Related: ['28. POLITICAL HIERARCHY OF THE UNDERWORLD', '28.2 WORLD GOVERNANCE CYCLE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.2 WORLD GOVERNANCE CYCLE
- Anchor: 28-2-world-governance-cycle
- Depends on: ['28.1 FIVE POWER BLOCKS']
- Feeds into: ['28.3 PLAYER POLITICAL TITLES']
- Related: ['28.1 FIVE POWER BLOCKS', '28.3 PLAYER POLITICAL TITLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 28.3 PLAYER POLITICAL TITLES
- Anchor: 28-3-player-political-titles
- Depends on: ['28.2 WORLD GOVERNANCE CYCLE']
- Feeds into: ['29.1 DAMAGE ARCHETYPES']
- Related: ['28.2 WORLD GOVERNANCE CYCLE', '29.1 DAMAGE ARCHETYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 29.1 DAMAGE ARCHETYPES
- Anchor: 29-1-damage-archetypes
- Depends on: ['28.3 PLAYER POLITICAL TITLES']
- Feeds into: ['29.3 ARMOUR CLASSES']
- Related: ['28.3 PLAYER POLITICAL TITLES', '29.3 ARMOUR CLASSES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 29.3 ARMOUR CLASSES
- Anchor: 29-3-armour-classes
- Depends on: ['29.1 DAMAGE ARCHETYPES']
- Feeds into: ['29.4 WEAPON FAMILY MODIFIERS']
- Related: ['29.1 DAMAGE ARCHETYPES', '29.4 WEAPON FAMILY MODIFIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 29.4 WEAPON FAMILY MODIFIERS
- Anchor: 29-4-weapon-family-modifiers
- Depends on: ['29.3 ARMOUR CLASSES']
- Feeds into: ['30.1 SKILL CHECK FORMULA (FULL)']
- Related: ['29.3 ARMOUR CLASSES', '30.1 SKILL CHECK FORMULA (FULL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.1 SKILL CHECK FORMULA (FULL)
- Anchor: 30-1-skill-check-formula-full
- Depends on: ['29.4 WEAPON FAMILY MODIFIERS']
- Feeds into: ['30.2 PAYOUT FORMULA (FULL)']
- Related: ['29.4 WEAPON FAMILY MODIFIERS', '30.2 PAYOUT FORMULA (FULL)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.2 PAYOUT FORMULA (FULL)
- Anchor: 30-2-payout-formula-full
- Depends on: ['30.1 SKILL CHECK FORMULA (FULL)']
- Feeds into: ['30.3 ECONOMIC STABILITY CORRECTION']
- Related: ['30.1 SKILL CHECK FORMULA (FULL)', '30.3 ECONOMIC STABILITY CORRECTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.3 ECONOMIC STABILITY CORRECTION
- Anchor: 30-3-economic-stability-correction
- Depends on: ['30.2 PAYOUT FORMULA (FULL)']
- Feeds into: ['30.4 CATASTROPHIC FAIL SYSTEM']
- Related: ['30.2 PAYOUT FORMULA (FULL)', '30.4 CATASTROPHIC FAIL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 30.4 CATASTROPHIC FAIL SYSTEM
- Anchor: 30-4-catastrophic-fail-system
- Depends on: ['30.3 ECONOMIC STABILITY CORRECTION']
- Feeds into: ['31.3 ADAPTIVE AI SYSTEM']
- Related: ['30.3 ECONOMIC STABILITY CORRECTION', '31.3 ADAPTIVE AI SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.3 ADAPTIVE AI SYSTEM
- Anchor: 31-3-adaptive-ai-system
- Depends on: ['30.4 CATASTROPHIC FAIL SYSTEM']
- Feeds into: ['31.4 REWARD MATRIX']
- Related: ['30.4 CATASTROPHIC FAIL SYSTEM', '31.4 REWARD MATRIX', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 31.4 REWARD MATRIX
- Anchor: 31-4-reward-matrix
- Depends on: ['31.3 ADAPTIVE AI SYSTEM']
- Feeds into: ['32. CARTEL FORMATION ENGINE (CFE)']
- Related: ['31.3 ADAPTIVE AI SYSTEM', '32. CARTEL FORMATION ENGINE (CFE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32. CARTEL FORMATION ENGINE (CFE)
- Anchor: 32-cartel-formation-engine-cfe
- Depends on: ['31.4 REWARD MATRIX']
- Feeds into: ['32.1 CARTEL ATTRIBUTES']
- Related: ['31.4 REWARD MATRIX', '32.1 CARTEL ATTRIBUTES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.1 CARTEL ATTRIBUTES
- Anchor: 32-1-cartel-attributes
- Depends on: ['32. CARTEL FORMATION ENGINE (CFE)']
- Feeds into: ['32.2 CARTEL ACTIONS']
- Related: ['32. CARTEL FORMATION ENGINE (CFE)', '32.2 CARTEL ACTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.2 CARTEL ACTIONS
- Anchor: 32-2-cartel-actions
- Depends on: ['32.1 CARTEL ATTRIBUTES']
- Feeds into: ['32.3 CARTEL WARS']
- Related: ['32.1 CARTEL ATTRIBUTES', '32.3 CARTEL WARS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 32.3 CARTEL WARS
- Anchor: 32-3-cartel-wars
- Depends on: ['32.2 CARTEL ACTIONS']
- Feeds into: ['33.1 TERRITORY CONTROL ENGINE']
- Related: ['32.2 CARTEL ACTIONS', '33.1 TERRITORY CONTROL ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 33.1 TERRITORY CONTROL ENGINE
- Anchor: 33-1-territory-control-engine
- Depends on: ['32.3 CARTEL WARS']
- Feeds into: ['Macro Strategy']
- Related: ['32.3 CARTEL WARS', 'Macro Strategy', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Macro Strategy
- Anchor: macro-strategy
- Depends on: ['33.1 TERRITORY CONTROL ENGINE']
- Feeds into: ['Meso Strategy']
- Related: ['33.1 TERRITORY CONTROL ENGINE', 'Meso Strategy', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Meso Strategy
- Anchor: meso-strategy
- Depends on: ['Macro Strategy']
- Feeds into: ['Micro Strategy']
- Related: ['Macro Strategy', 'Micro Strategy', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Micro Strategy
- Anchor: micro-strategy
- Depends on: ['Meso Strategy']
- Feeds into: ['34. COMPANY MEGA-SIMULATION LAYER']
- Related: ['Meso Strategy', '34. COMPANY MEGA-SIMULATION LAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 34. COMPANY MEGA-SIMULATION LAYER
- Anchor: 34-company-mega-simulation-layer
- Depends on: ['Micro Strategy']
- Feeds into: ['34.1 DEPARTMENTS']
- Related: ['Micro Strategy', '34.1 DEPARTMENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 34.1 DEPARTMENTS
- Anchor: 34-1-departments
- Depends on: ['34. COMPANY MEGA-SIMULATION LAYER']
- Feeds into: ['34.2 INDUSTRY EVENTS']
- Related: ['34. COMPANY MEGA-SIMULATION LAYER', '34.2 INDUSTRY EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 34.2 INDUSTRY EVENTS
- Anchor: 34-2-industry-events
- Depends on: ['34.1 DEPARTMENTS']
- Feeds into: ['34.3 EMPLOYEE SIMULATION']
- Related: ['34.1 DEPARTMENTS', '34.3 EMPLOYEE SIMULATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 34.3 EMPLOYEE SIMULATION
- Anchor: 34-3-employee-simulation
- Depends on: ['34.2 INDUSTRY EVENTS']
- Feeds into: ['34.4 SHAREHOLDER SYSTEM']
- Related: ['34.2 INDUSTRY EVENTS', '34.4 SHAREHOLDER SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 34.4 SHAREHOLDER SYSTEM
- Anchor: 34-4-shareholder-system
- Depends on: ['34.3 EMPLOYEE SIMULATION']
- Feeds into: ['35. PLAYER PSYCHOLOGY ENGINE (PPE)']
- Related: ['34.3 EMPLOYEE SIMULATION', '35. PLAYER PSYCHOLOGY ENGINE (PPE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35. PLAYER PSYCHOLOGY ENGINE (PPE)
- Anchor: 35-player-psychology-engine-ppe
- Depends on: ['34.4 SHAREHOLDER SYSTEM']
- Feeds into: ['35.1 MOTIVATIONAL DRIVERS']
- Related: ['34.4 SHAREHOLDER SYSTEM', '35.1 MOTIVATIONAL DRIVERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.1 MOTIVATIONAL DRIVERS
- Anchor: 35-1-motivational-drivers
- Depends on: ['35. PLAYER PSYCHOLOGY ENGINE (PPE)']
- Feeds into: ['Short-Term']
- Related: ['35. PLAYER PSYCHOLOGY ENGINE (PPE)', 'Short-Term', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Short-Term
- Anchor: short-term
- Depends on: ['35.1 MOTIVATIONAL DRIVERS']
- Feeds into: ['Mid-Term']
- Related: ['35.1 MOTIVATIONAL DRIVERS', 'Mid-Term', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Mid-Term
- Anchor: mid-term
- Depends on: ['Short-Term']
- Feeds into: ['Long-Term']
- Related: ['Short-Term', 'Long-Term', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Long-Term
- Anchor: long-term
- Depends on: ['Mid-Term']
- Feeds into: ['35.2 PLAYER AGENCY PATHWAYS']
- Related: ['Mid-Term', '35.2 PLAYER AGENCY PATHWAYS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 35.2 PLAYER AGENCY PATHWAYS
- Anchor: 35-2-player-agency-pathways
- Depends on: ['Long-Term']
- Feeds into: ['36. MACRO-LORE: THE WORLD BEHIND TRENCH CITY']
- Related: ['Long-Term', '36. MACRO-LORE: THE WORLD BEHIND TRENCH CITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36. MACRO-LORE: THE WORLD BEHIND TRENCH CITY
- Anchor: 36-macro-lore-the-world-behind-trench-city
- Depends on: ['35.2 PLAYER AGENCY PATHWAYS']
- Feeds into: ['36.1 GLOBAL POWER STRUCTURES']
- Related: ['35.2 PLAYER AGENCY PATHWAYS', '36.1 GLOBAL POWER STRUCTURES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 36.1 GLOBAL POWER STRUCTURES
- Anchor: 36-1-global-power-structures
- Depends on: ['36. MACRO-LORE: THE WORLD BEHIND TRENCH CITY']
- Feeds into: ['The Five']
- Related: ['36. MACRO-LORE: THE WORLD BEHIND TRENCH CITY', 'The Five', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## The Five
- Anchor: the-five
- Depends on: ['36.1 GLOBAL POWER STRUCTURES']
- Feeds into: ['International Syndicates']
- Related: ['36.1 GLOBAL POWER STRUCTURES', 'International Syndicates', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## International Syndicates
- Anchor: international-syndicates
- Depends on: ['The Five']
- Feeds into: ['Corporate Paragovernments']
- Related: ['The Five', 'Corporate Paragovernments', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Corporate Paragovernments
- Anchor: corporate-paragovernments
- Depends on: ['International Syndicates']
- Feeds into: ['Rogue Nations']
- Related: ['International Syndicates', 'Rogue Nations', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Rogue Nations
- Anchor: rogue-nations
- Depends on: ['Corporate Paragovernments']
- Feeds into: ['37.1 UPTOWN HEIGHTS']
- Related: ['Corporate Paragovernments', '37.1 UPTOWN HEIGHTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.1 UPTOWN HEIGHTS
- Anchor: 37-1-uptown-heights
- Depends on: ['Rogue Nations']
- Feeds into: ['37.2 THE NARROWS']
- Related: ['Rogue Nations', '37.2 THE NARROWS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.2 THE NARROWS
- Anchor: 37-2-the-narrows
- Depends on: ['37.1 UPTOWN HEIGHTS']
- Feeds into: ['37.3 INDUSTRIAL BELT']
- Related: ['37.1 UPTOWN HEIGHTS', '37.3 INDUSTRIAL BELT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.3 INDUSTRIAL BELT
- Anchor: 37-3-industrial-belt
- Depends on: ['37.2 THE NARROWS']
- Feeds into: ['37.4 DROWNED QUARTER']
- Related: ['37.2 THE NARROWS', '37.4 DROWNED QUARTER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.4 DROWNED QUARTER
- Anchor: 37-4-drowned-quarter
- Depends on: ['37.3 INDUSTRIAL BELT']
- Feeds into: ['37.5 OLD MILE']
- Related: ['37.3 INDUSTRIAL BELT', '37.5 OLD MILE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 37.5 OLD MILE
- Anchor: 37-5-old-mile
- Depends on: ['37.4 DROWNED QUARTER']
- Feeds into: ['38.1 FINAL HIT CHANCE FORMULA']
- Related: ['37.4 DROWNED QUARTER', '38.1 FINAL HIT CHANCE FORMULA', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 38.1 FINAL HIT CHANCE FORMULA
- Anchor: 38-1-final-hit-chance-formula
- Depends on: ['37.5 OLD MILE']
- Feeds into: ['38.2 DAMAGE FORMULA — EXTENDED']
- Related: ['37.5 OLD MILE', '38.2 DAMAGE FORMULA — EXTENDED', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 38.2 DAMAGE FORMULA — EXTENDED
- Anchor: 38-2-damage-formula-extended
- Depends on: ['38.1 FINAL HIT CHANCE FORMULA']
- Feeds into: ['38.3 CRITICAL STRIKE FORMULA']
- Related: ['38.1 FINAL HIT CHANCE FORMULA', '38.3 CRITICAL STRIKE FORMULA', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 38.3 CRITICAL STRIKE FORMULA
- Anchor: 38-3-critical-strike-formula
- Depends on: ['38.2 DAMAGE FORMULA — EXTENDED']
- Feeds into: ['38.4 TURN ORDER FORMULA']
- Related: ['38.2 DAMAGE FORMULA — EXTENDED', '38.4 TURN ORDER FORMULA', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 38.4 TURN ORDER FORMULA
- Anchor: 38-4-turn-order-formula
- Depends on: ['38.3 CRITICAL STRIKE FORMULA']
- Feeds into: ['38.5 ARMOUR MITIGATION SCALE']
- Related: ['38.3 CRITICAL STRIKE FORMULA', '38.5 ARMOUR MITIGATION SCALE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 38.5 ARMOUR MITIGATION SCALE
- Anchor: 38-5-armour-mitigation-scale
- Depends on: ['38.4 TURN ORDER FORMULA']
- Feeds into: ['39. DISTRICT BIOME ENGINE']
- Related: ['38.4 TURN ORDER FORMULA', '39. DISTRICT BIOME ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39. DISTRICT BIOME ENGINE
- Anchor: 39-district-biome-engine
- Depends on: ['38.5 ARMOUR MITIGATION SCALE']
- Feeds into: ['39.1 BIOME-LEVEL VARIABLES']
- Related: ['38.5 ARMOUR MITIGATION SCALE', '39.1 BIOME-LEVEL VARIABLES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.1 BIOME-LEVEL VARIABLES
- Anchor: 39-1-biome-level-variables
- Depends on: ['39. DISTRICT BIOME ENGINE']
- Feeds into: ['39.2 DISTRICT UNIQUE HAZARDS']
- Related: ['39. DISTRICT BIOME ENGINE', '39.2 DISTRICT UNIQUE HAZARDS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 39.2 DISTRICT UNIQUE HAZARDS
- Anchor: 39-2-district-unique-hazards
- Depends on: ['39.1 BIOME-LEVEL VARIABLES']
- Feeds into: ['40. WORLD ENVIRONMENT SIMULATION ENGINE (WESE)']
- Related: ['39.1 BIOME-LEVEL VARIABLES', '40. WORLD ENVIRONMENT SIMULATION ENGINE (WESE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40. WORLD ENVIRONMENT SIMULATION ENGINE (WESE)
- Anchor: 40-world-environment-simulation-engine-wese
- Depends on: ['39.2 DISTRICT UNIQUE HAZARDS']
- Feeds into: ['40.1 WEATHER STATES']
- Related: ['39.2 DISTRICT UNIQUE HAZARDS', '40.1 WEATHER STATES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.1 WEATHER STATES
- Anchor: 40-1-weather-states
- Depends on: ['40. WORLD ENVIRONMENT SIMULATION ENGINE (WESE)']
- Feeds into: ['40.2 DAY/NIGHT CYCLE EFFECTS']
- Related: ['40. WORLD ENVIRONMENT SIMULATION ENGINE (WESE)', '40.2 DAY/NIGHT CYCLE EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.2 DAY/NIGHT CYCLE EFFECTS
- Anchor: 40-2-day-night-cycle-effects
- Depends on: ['40.1 WEATHER STATES']
- Feeds into: ['40.3 SEASONAL MODIFIERS']
- Related: ['40.1 WEATHER STATES', '40.3 SEASONAL MODIFIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 40.3 SEASONAL MODIFIERS
- Anchor: 40-3-seasonal-modifiers
- Depends on: ['40.2 DAY/NIGHT CYCLE EFFECTS']
- Feeds into: ['41. SOCIAL IDENTITY SUPER-SYSTEM']
- Related: ['40.2 DAY/NIGHT CYCLE EFFECTS', '41. SOCIAL IDENTITY SUPER-SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41. SOCIAL IDENTITY SUPER-SYSTEM
- Anchor: 41-social-identity-super-system
- Depends on: ['40.3 SEASONAL MODIFIERS']
- Feeds into: ['41.1 REPUTATION (RESPECT-BASED)']
- Related: ['40.3 SEASONAL MODIFIERS', '41.1 REPUTATION (RESPECT-BASED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.1 REPUTATION (RESPECT-BASED)
- Anchor: 41-1-reputation-respect-based
- Depends on: ['41. SOCIAL IDENTITY SUPER-SYSTEM']
- Feeds into: ['41.2 FAME (PUBLIC VISIBILITY)']
- Related: ['41. SOCIAL IDENTITY SUPER-SYSTEM', '41.2 FAME (PUBLIC VISIBILITY)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.2 FAME (PUBLIC VISIBILITY)
- Anchor: 41-2-fame-public-visibility
- Depends on: ['41.1 REPUTATION (RESPECT-BASED)']
- Feeds into: ['41.3 NOTORIETY (FEAR-BASED)']
- Related: ['41.1 REPUTATION (RESPECT-BASED)', '41.3 NOTORIETY (FEAR-BASED)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 41.3 NOTORIETY (FEAR-BASED)
- Anchor: 41-3-notoriety-fear-based
- Depends on: ['41.2 FAME (PUBLIC VISIBILITY)']
- Feeds into: ['42. MISSION SCRIPTING ENGINE (MSE)']
- Related: ['41.2 FAME (PUBLIC VISIBILITY)', '42. MISSION SCRIPTING ENGINE (MSE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42. MISSION SCRIPTING ENGINE (MSE)
- Anchor: 42-mission-scripting-engine-mse
- Depends on: ['41.3 NOTORIETY (FEAR-BASED)']
- Feeds into: ['42.1 MISSION PHASES']
- Related: ['41.3 NOTORIETY (FEAR-BASED)', '42.1 MISSION PHASES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 42.1 MISSION PHASES
- Anchor: 42-1-mission-phases
- Depends on: ['42. MISSION SCRIPTING ENGINE (MSE)']
- Feeds into: ['43. CITY INFRASTRUCTURE SYSTEM']
- Related: ['42. MISSION SCRIPTING ENGINE (MSE)', '43. CITY INFRASTRUCTURE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43. CITY INFRASTRUCTURE SYSTEM
- Anchor: 43-city-infrastructure-system
- Depends on: ['42.1 MISSION PHASES']
- Feeds into: ['43.1 INFRASTRUCTURE FAIL EVENTS']
- Related: ['42.1 MISSION PHASES', '43.1 INFRASTRUCTURE FAIL EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 43.1 INFRASTRUCTURE FAIL EVENTS
- Anchor: 43-1-infrastructure-fail-events
- Depends on: ['43. CITY INFRASTRUCTURE SYSTEM']
- Feeds into: ['44. MEGA EVENT ENGINE (MEE)']
- Related: ['43. CITY INFRASTRUCTURE SYSTEM', '44. MEGA EVENT ENGINE (MEE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44. MEGA EVENT ENGINE (MEE)
- Anchor: 44-mega-event-engine-mee
- Depends on: ['43.1 INFRASTRUCTURE FAIL EVENTS']
- Feeds into: ['44.1 EVENT TIERS']
- Related: ['43.1 INFRASTRUCTURE FAIL EVENTS', '44.1 EVENT TIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.1 EVENT TIERS
- Anchor: 44-1-event-tiers
- Depends on: ['44. MEGA EVENT ENGINE (MEE)']
- Feeds into: ['44.2 EXAMPLE MEGA EVENTS']
- Related: ['44. MEGA EVENT ENGINE (MEE)', '44.2 EXAMPLE MEGA EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.2 EXAMPLE MEGA EVENTS
- Anchor: 44-2-example-mega-events
- Depends on: ['44.1 EVENT TIERS']
- Feeds into: ['THE BLACKOUT']
- Related: ['44.1 EVENT TIERS', 'THE BLACKOUT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE BLACKOUT
- Anchor: the-blackout
- Depends on: ['44.2 EXAMPLE MEGA EVENTS']
- Feeds into: ['THE CARTEL WAR']
- Related: ['44.2 EXAMPLE MEGA EVENTS', 'THE CARTEL WAR', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE CARTEL WAR
- Anchor: the-cartel-war
- Depends on: ['THE BLACKOUT']
- Feeds into: ['THE UNDERWORLD SUMMIT']
- Related: ['THE BLACKOUT', 'THE UNDERWORLD SUMMIT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE UNDERWORLD SUMMIT
- Anchor: the-underworld-summit
- Depends on: ['THE CARTEL WAR']
- Feeds into: ['THE FLOOD']
- Related: ['THE CARTEL WAR', 'THE FLOOD', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE FLOOD
- Anchor: the-flood
- Depends on: ['THE UNDERWORLD SUMMIT']
- Feeds into: ['THE FUGITIVE PROTOCOL']
- Related: ['THE UNDERWORLD SUMMIT', 'THE FUGITIVE PROTOCOL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE FUGITIVE PROTOCOL
- Anchor: the-fugitive-protocol
- Depends on: ['THE FLOOD']
- Feeds into: ['44.3 CRISIS ARC STRUCTURE']
- Related: ['THE FLOOD', '44.3 CRISIS ARC STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 44.3 CRISIS ARC STRUCTURE
- Anchor: 44-3-crisis-arc-structure
- Depends on: ['THE FUGITIVE PROTOCOL']
- Feeds into: ['45. AI DIRECTOR — META-CONTROL SYSTEM']
- Related: ['THE FUGITIVE PROTOCOL', '45. AI DIRECTOR — META-CONTROL SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45. AI DIRECTOR — META-CONTROL SYSTEM
- Anchor: 45-ai-director-meta-control-system
- Depends on: ['44.3 CRISIS ARC STRUCTURE']
- Feeds into: ['45.1 DIRECTOR INPUT FEEDS']
- Related: ['44.3 CRISIS ARC STRUCTURE', '45.1 DIRECTOR INPUT FEEDS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.1 DIRECTOR INPUT FEEDS
- Anchor: 45-1-director-input-feeds
- Depends on: ['45. AI DIRECTOR — META-CONTROL SYSTEM']
- Feeds into: ['45.2 DIRECTOR OUTPUT ACTIONS']
- Related: ['45. AI DIRECTOR — META-CONTROL SYSTEM', '45.2 DIRECTOR OUTPUT ACTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.2 DIRECTOR OUTPUT ACTIONS
- Anchor: 45-2-director-output-actions
- Depends on: ['45.1 DIRECTOR INPUT FEEDS']
- Feeds into: ['45.3 DIRECTOR PERSONALITY MODES']
- Related: ['45.1 DIRECTOR INPUT FEEDS', '45.3 DIRECTOR PERSONALITY MODES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 45.3 DIRECTOR PERSONALITY MODES
- Anchor: 45-3-director-personality-modes
- Depends on: ['45.2 DIRECTOR OUTPUT ACTIONS']
- Feeds into: ['LENIENT MODE']
- Related: ['45.2 DIRECTOR OUTPUT ACTIONS', 'LENIENT MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## LENIENT MODE
- Anchor: lenient-mode
- Depends on: ['45.3 DIRECTOR PERSONALITY MODES']
- Feeds into: ['NEUTRAL MODE']
- Related: ['45.3 DIRECTOR PERSONALITY MODES', 'NEUTRAL MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## NEUTRAL MODE
- Anchor: neutral-mode
- Depends on: ['LENIENT MODE']
- Feeds into: ['HOSTILE MODE']
- Related: ['LENIENT MODE', 'HOSTILE MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## HOSTILE MODE
- Anchor: hostile-mode
- Depends on: ['NEUTRAL MODE']
- Feeds into: ['VENGEFUL MODE']
- Related: ['NEUTRAL MODE', 'VENGEFUL MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## VENGEFUL MODE
- Anchor: vengeful-mode
- Depends on: ['HOSTILE MODE']
- Feeds into: ['THE KINGMAKER']
- Related: ['HOSTILE MODE', 'THE KINGMAKER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE KINGMAKER
- Anchor: the-kingmaker
- Depends on: ['VENGEFUL MODE']
- Feeds into: ['VEILRENDER']
- Related: ['VENGEFUL MODE', 'VEILRENDER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## VEILRENDER
- Anchor: veilrender
- Depends on: ['THE KINGMAKER']
- Feeds into: ['HEARTSTOPPER']
- Related: ['THE KINGMAKER', 'HEARTSTOPPER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## HEARTSTOPPER
- Anchor: heartstopper
- Depends on: ['VEILRENDER']
- Feeds into: ['BLOODTIDE']
- Related: ['VEILRENDER', 'BLOODTIDE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## BLOODTIDE
- Anchor: bloodtide
- Depends on: ['HEARTSTOPPER']
- Feeds into: ['46.2 ARTEFACT ARMOUR SETS']
- Related: ['HEARTSTOPPER', '46.2 ARTEFACT ARMOUR SETS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.2 ARTEFACT ARMOUR SETS
- Anchor: 46-2-artefact-armour-sets
- Depends on: ['BLOODTIDE']
- Feeds into: ['EXOSUIT: TITAN PROTOCOL']
- Related: ['BLOODTIDE', 'EXOSUIT: TITAN PROTOCOL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## EXOSUIT: TITAN PROTOCOL
- Anchor: exosuit-titan-protocol
- Depends on: ['46.2 ARTEFACT ARMOUR SETS']
- Feeds into: ['WRAITHWEAVE']
- Related: ['46.2 ARTEFACT ARMOUR SETS', 'WRAITHWEAVE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## WRAITHWEAVE
- Anchor: wraithweave
- Depends on: ['EXOSUIT: TITAN PROTOCOL']
- Feeds into: ['IRON HALO']
- Related: ['EXOSUIT: TITAN PROTOCOL', 'IRON HALO', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## IRON HALO
- Anchor: iron-halo
- Depends on: ['WRAITHWEAVE']
- Feeds into: ['46.3 REALITY-BENDING ARTEFACTS']
- Related: ['WRAITHWEAVE', '46.3 REALITY-BENDING ARTEFACTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 46.3 REALITY-BENDING ARTEFACTS
- Anchor: 46-3-reality-bending-artefacts
- Depends on: ['IRON HALO']
- Feeds into: ['HOURGLASS OF ASHEN TIME']
- Related: ['IRON HALO', 'HOURGLASS OF ASHEN TIME', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## HOURGLASS OF ASHEN TIME
- Anchor: hourglass-of-ashen-time
- Depends on: ['46.3 REALITY-BENDING ARTEFACTS']
- Feeds into: ['CROWN OF THE UNDERWORLD']
- Related: ['46.3 REALITY-BENDING ARTEFACTS', 'CROWN OF THE UNDERWORLD', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CROWN OF THE UNDERWORLD
- Anchor: crown-of-the-underworld
- Depends on: ['HOURGLASS OF ASHEN TIME']
- Feeds into: ['BLOOD CONTRACT']
- Related: ['HOURGLASS OF ASHEN TIME', 'BLOOD CONTRACT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## BLOOD CONTRACT
- Anchor: blood-contract
- Depends on: ['CROWN OF THE UNDERWORLD']
- Feeds into: ['47. TERRITORY POLITICAL ENGINE (TPE)']
- Related: ['CROWN OF THE UNDERWORLD', '47. TERRITORY POLITICAL ENGINE (TPE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 47. TERRITORY POLITICAL ENGINE (TPE)
- Anchor: 47-territory-political-engine-tpe
- Depends on: ['BLOOD CONTRACT']
- Feeds into: ['47.1 TERRITORY STATES']
- Related: ['BLOOD CONTRACT', '47.1 TERRITORY STATES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 47.1 TERRITORY STATES
- Anchor: 47-1-territory-states
- Depends on: ['47. TERRITORY POLITICAL ENGINE (TPE)']
- Feeds into: ['NEUTRAL']
- Related: ['47. TERRITORY POLITICAL ENGINE (TPE)', 'NEUTRAL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## NEUTRAL
- Anchor: neutral
- Depends on: ['47.1 TERRITORY STATES']
- Feeds into: ['CONTENTIOUS']
- Related: ['47.1 TERRITORY STATES', 'CONTENTIOUS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CONTENTIOUS
- Anchor: contentious
- Depends on: ['NEUTRAL']
- Feeds into: ['OCCUPIED']
- Related: ['NEUTRAL', 'OCCUPIED', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## OCCUPIED
- Anchor: occupied
- Depends on: ['CONTENTIOUS']
- Feeds into: ['REBELLIOUS']
- Related: ['CONTENTIOUS', 'REBELLIOUS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## REBELLIOUS
- Anchor: rebellious
- Depends on: ['OCCUPIED']
- Feeds into: ['FROZEN']
- Related: ['OCCUPIED', 'FROZEN', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## FROZEN
- Anchor: frozen
- Depends on: ['REBELLIOUS']
- Feeds into: ['47.2 TERRITORY ACTIONS']
- Related: ['REBELLIOUS', '47.2 TERRITORY ACTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 47.2 TERRITORY ACTIONS
- Anchor: 47-2-territory-actions
- Depends on: ['FROZEN']
- Feeds into: ['48. FINANCIAL WARFARE SYSTEM (FWS)']
- Related: ['FROZEN', '48. FINANCIAL WARFARE SYSTEM (FWS)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48. FINANCIAL WARFARE SYSTEM (FWS)
- Anchor: 48-financial-warfare-system-fws
- Depends on: ['47.2 TERRITORY ACTIONS']
- Feeds into: ['48.1 ECONOMIC WEAPONS']
- Related: ['47.2 TERRITORY ACTIONS', '48.1 ECONOMIC WEAPONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.1 ECONOMIC WEAPONS
- Anchor: 48-1-economic-weapons
- Depends on: ['48. FINANCIAL WARFARE SYSTEM (FWS)']
- Feeds into: ['PRICE STRANGLE']
- Related: ['48. FINANCIAL WARFARE SYSTEM (FWS)', 'PRICE STRANGLE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PRICE STRANGLE
- Anchor: price-strangle
- Depends on: ['48.1 ECONOMIC WEAPONS']
- Feeds into: ['SCARCITY BOMB']
- Related: ['48.1 ECONOMIC WEAPONS', 'SCARCITY BOMB', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SCARCITY BOMB
- Anchor: scarcity-bomb
- Depends on: ['PRICE STRANGLE']
- Feeds into: ['FALSE FLAG TRADE']
- Related: ['PRICE STRANGLE', 'FALSE FLAG TRADE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## FALSE FLAG TRADE
- Anchor: false-flag-trade
- Depends on: ['SCARCITY BOMB']
- Feeds into: ['CARTEL TAXATION']
- Related: ['SCARCITY BOMB', 'CARTEL TAXATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CARTEL TAXATION
- Anchor: cartel-taxation
- Depends on: ['FALSE FLAG TRADE']
- Feeds into: ['CORPORATE HOSTILE TAKEOVER']
- Related: ['FALSE FLAG TRADE', 'CORPORATE HOSTILE TAKEOVER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CORPORATE HOSTILE TAKEOVER
- Anchor: corporate-hostile-takeover
- Depends on: ['CARTEL TAXATION']
- Feeds into: ['48.2 ECONOMIC WARFARE OUTCOMES']
- Related: ['CARTEL TAXATION', '48.2 ECONOMIC WARFARE OUTCOMES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 48.2 ECONOMIC WARFARE OUTCOMES
- Anchor: 48-2-economic-warfare-outcomes
- Depends on: ['CORPORATE HOSTILE TAKEOVER']
- Feeds into: ['49. LEGACY SYSTEM']
- Related: ['CORPORATE HOSTILE TAKEOVER', '49. LEGACY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 49. LEGACY SYSTEM
- Anchor: 49-legacy-system
- Depends on: ['48.2 ECONOMIC WARFARE OUTCOMES']
- Feeds into: ['49.1 BLOODLINE TRAITS']
- Related: ['48.2 ECONOMIC WARFARE OUTCOMES', '49.1 BLOODLINE TRAITS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 49.1 BLOODLINE TRAITS
- Anchor: 49-1-bloodline-traits
- Depends on: ['49. LEGACY SYSTEM']
- Feeds into: ['50. INTERNATIONAL RELATIONS ENGINE (IRE)']
- Related: ['49. LEGACY SYSTEM', '50. INTERNATIONAL RELATIONS ENGINE (IRE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 50. INTERNATIONAL RELATIONS ENGINE (IRE)
- Anchor: 50-international-relations-engine-ire
- Depends on: ['49.1 BLOODLINE TRAITS']
- Feeds into: ['50.2 GLOBAL EVENTS']
- Related: ['49.1 BLOODLINE TRAITS', '50.2 GLOBAL EVENTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 50.2 GLOBAL EVENTS
- Anchor: 50-2-global-events
- Depends on: ['50. INTERNATIONAL RELATIONS ENGINE (IRE)']
- Feeds into: ['51. WORLD BOSS RAID FRAMEWORK']
- Related: ['50. INTERNATIONAL RELATIONS ENGINE (IRE)', '51. WORLD BOSS RAID FRAMEWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 51. WORLD BOSS RAID FRAMEWORK
- Anchor: 51-world-boss-raid-framework
- Depends on: ['50.2 GLOBAL EVENTS']
- Feeds into: ['51.1 WORLD BOSS TRAITS']
- Related: ['50.2 GLOBAL EVENTS', '51.1 WORLD BOSS TRAITS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 51.1 WORLD BOSS TRAITS
- Anchor: 51-1-world-boss-traits
- Depends on: ['51. WORLD BOSS RAID FRAMEWORK']
- Feeds into: ['51.2 RAID PARTICIPANT TIERS']
- Related: ['51. WORLD BOSS RAID FRAMEWORK', '51.2 RAID PARTICIPANT TIERS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 51.2 RAID PARTICIPANT TIERS
- Anchor: 51-2-raid-participant-tiers
- Depends on: ['51.1 WORLD BOSS TRAITS']
- Feeds into: ['Tier 4 — Police/Military Forces']
- Related: ['51.1 WORLD BOSS TRAITS', 'Tier 4 — Police/Military Forces', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Tier 4 — Police/Military Forces
- Anchor: tier-4-police-military-forces
- Depends on: ['51.2 RAID PARTICIPANT TIERS']
- Feeds into: ['51.3 RAID PHASE STRUCTURE']
- Related: ['51.2 RAID PARTICIPANT TIERS', '51.3 RAID PHASE STRUCTURE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 51.3 RAID PHASE STRUCTURE
- Anchor: 51-3-raid-phase-structure
- Depends on: ['Tier 4 — Police/Military Forces']
- Feeds into: ['51.4 BOSS REWARD SYSTEM']
- Related: ['Tier 4 — Police/Military Forces', '51.4 BOSS REWARD SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 51.4 BOSS REWARD SYSTEM
- Anchor: 51-4-boss-reward-system
- Depends on: ['51.3 RAID PHASE STRUCTURE']
- Feeds into: ['52.1 HQ UPGRADES']
- Related: ['51.3 RAID PHASE STRUCTURE', '52.1 HQ UPGRADES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 52.1 HQ UPGRADES
- Anchor: 52-1-hq-upgrades
- Depends on: ['51.4 BOSS REWARD SYSTEM']
- Feeds into: ['DEFENSIVE']
- Related: ['51.4 BOSS REWARD SYSTEM', 'DEFENSIVE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## DEFENSIVE
- Anchor: defensive
- Depends on: ['52.1 HQ UPGRADES']
- Feeds into: ['ECONOMIC']
- Related: ['52.1 HQ UPGRADES', 'ECONOMIC', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ECONOMIC
- Anchor: economic
- Depends on: ['DEFENSIVE']
- Feeds into: ['MILITARY']
- Related: ['DEFENSIVE', 'MILITARY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MILITARY
- Anchor: military
- Depends on: ['ECONOMIC']
- Feeds into: ['INTELLIGENCE']
- Related: ['ECONOMIC', 'INTELLIGENCE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## INTELLIGENCE
- Anchor: intelligence
- Depends on: ['MILITARY']
- Feeds into: ['53.1 ROOM TYPES']
- Related: ['MILITARY', '53.1 ROOM TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 53.1 ROOM TYPES
- Anchor: 53-1-room-types
- Depends on: ['INTELLIGENCE']
- Feeds into: ['Basic Rooms']
- Related: ['INTELLIGENCE', 'Basic Rooms', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## Basic Rooms
- Anchor: basic-rooms
- Depends on: ['53.1 ROOM TYPES']
- Feeds into: ['53.2 TENANT SIMULATION']
- Related: ['53.1 ROOM TYPES', '53.2 TENANT SIMULATION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 53.2 TENANT SIMULATION
- Anchor: 53-2-tenant-simulation
- Depends on: ['Basic Rooms']
- Feeds into: ['54. SEASON SYSTEM — DEEP OPERATIONAL DESIGN']
- Related: ['Basic Rooms', '54. SEASON SYSTEM — DEEP OPERATIONAL DESIGN', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 54. SEASON SYSTEM — DEEP OPERATIONAL DESIGN
- Anchor: 54-season-system-deep-operational-design
- Depends on: ['53.2 TENANT SIMULATION']
- Feeds into: ['54.1 SEASON PHASES']
- Related: ['53.2 TENANT SIMULATION', '54.1 SEASON PHASES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 54.1 SEASON PHASES
- Anchor: 54-1-season-phases
- Depends on: ['54. SEASON SYSTEM — DEEP OPERATIONAL DESIGN']
- Feeds into: ['54.2 SEASONAL RESETS']
- Related: ['54. SEASON SYSTEM — DEEP OPERATIONAL DESIGN', '54.2 SEASONAL RESETS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 54.2 SEASONAL RESETS
- Anchor: 54-2-seasonal-resets
- Depends on: ['54.1 SEASON PHASES']
- Feeds into: ['54.3 WORLD EVOLUTION']
- Related: ['54.1 SEASON PHASES', '54.3 WORLD EVOLUTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 54.3 WORLD EVOLUTION
- Anchor: 54-3-world-evolution
- Depends on: ['54.2 SEASONAL RESETS']
- Feeds into: ['56. TOTAL SYSTEMS BLUEPRINT']
- Related: ['54.2 SEASONAL RESETS', '56. TOTAL SYSTEMS BLUEPRINT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 56. TOTAL SYSTEMS BLUEPRINT
- Anchor: 56-total-systems-blueprint
- Depends on: ['54.3 WORLD EVOLUTION']
- Feeds into: ['57.1 CONTRABAND TYPES']
- Related: ['54.3 WORLD EVOLUTION', '57.1 CONTRABAND TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 57.1 CONTRABAND TYPES
- Anchor: 57-1-contraband-types
- Depends on: ['56. TOTAL SYSTEMS BLUEPRINT']
- Feeds into: ['57.2 TRADE ROUTING ENGINE']
- Related: ['56. TOTAL SYSTEMS BLUEPRINT', '57.2 TRADE ROUTING ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 57.2 TRADE ROUTING ENGINE
- Anchor: 57-2-trade-routing-engine
- Depends on: ['57.1 CONTRABAND TYPES']
- Feeds into: ['57.3 PLAYER SMUGGLER RANKS']
- Related: ['57.1 CONTRABAND TYPES', '57.3 PLAYER SMUGGLER RANKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 57.3 PLAYER SMUGGLER RANKS
- Anchor: 57-3-player-smuggler-ranks
- Depends on: ['57.2 TRADE ROUTING ENGINE']
- Feeds into: ['ALLY']
- Related: ['57.2 TRADE ROUTING ENGINE', 'ALLY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ALLY
- Anchor: ally
- Depends on: ['57.3 PLAYER SMUGGLER RANKS']
- Feeds into: ['RIVAL']
- Related: ['57.3 PLAYER SMUGGLER RANKS', 'RIVAL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## RIVAL
- Anchor: rival
- Depends on: ['ALLY']
- Feeds into: ['INFORMANT']
- Related: ['ALLY', 'INFORMANT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## INFORMANT
- Anchor: informant
- Depends on: ['RIVAL']
- Feeds into: ['ENFORCER']
- Related: ['RIVAL', 'ENFORCER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ENFORCER
- Anchor: enforcer
- Depends on: ['INFORMANT']
- Feeds into: ['LOVER']
- Related: ['INFORMANT', 'LOVER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## LOVER
- Anchor: lover
- Depends on: ['ENFORCER']
- Feeds into: ['BETRAYER']
- Related: ['ENFORCER', 'BETRAYER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## BETRAYER
- Anchor: betrayer
- Depends on: ['LOVER']
- Feeds into: ['59. SOUND & STEALTH ENGINE']
- Related: ['LOVER', '59. SOUND & STEALTH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 59. SOUND & STEALTH ENGINE
- Anchor: 59-sound-stealth-engine
- Depends on: ['BETRAYER']
- Feeds into: ['59.1 NOISE SIGNATURE SYSTEM']
- Related: ['BETRAYER', '59.1 NOISE SIGNATURE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 59.1 NOISE SIGNATURE SYSTEM
- Anchor: 59-1-noise-signature-system
- Depends on: ['59. SOUND & STEALTH ENGINE']
- Feeds into: ['59.2 SOUND-BASED STEALTH CHECKS']
- Related: ['59. SOUND & STEALTH ENGINE', '59.2 SOUND-BASED STEALTH CHECKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 59.2 SOUND-BASED STEALTH CHECKS
- Anchor: 59-2-sound-based-stealth-checks
- Depends on: ['59.1 NOISE SIGNATURE SYSTEM']
- Feeds into: ['60. VICE & NIGHTLIFE ENGINE']
- Related: ['59.1 NOISE SIGNATURE SYSTEM', '60. VICE & NIGHTLIFE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 60. VICE & NIGHTLIFE ENGINE
- Anchor: 60-vice-nightlife-engine
- Depends on: ['59.2 SOUND-BASED STEALTH CHECKS']
- Feeds into: ['60.1 ADDICTION SYSTEM']
- Related: ['59.2 SOUND-BASED STEALTH CHECKS', '60.1 ADDICTION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 60.1 ADDICTION SYSTEM
- Anchor: 60-1-addiction-system
- Depends on: ['60. VICE & NIGHTLIFE ENGINE']
- Feeds into: ['60.2 NIGHTLIFE POWER NETWORKS']
- Related: ['60. VICE & NIGHTLIFE ENGINE', '60.2 NIGHTLIFE POWER NETWORKS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 60.2 NIGHTLIFE POWER NETWORKS
- Anchor: 60-2-nightlife-power-networks
- Depends on: ['60.1 ADDICTION SYSTEM']
- Feeds into: ['61. CITY TRAFFIC & CROWD ENGINE']
- Related: ['60.1 ADDICTION SYSTEM', '61. CITY TRAFFIC & CROWD ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 61. CITY TRAFFIC & CROWD ENGINE
- Anchor: 61-city-traffic-crowd-engine
- Depends on: ['60.2 NIGHTLIFE POWER NETWORKS']
- Feeds into: ['61.1 TRAFFIC DENSITY ZONES']
- Related: ['60.2 NIGHTLIFE POWER NETWORKS', '61.1 TRAFFIC DENSITY ZONES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 61.1 TRAFFIC DENSITY ZONES
- Anchor: 61-1-traffic-density-zones
- Depends on: ['61. CITY TRAFFIC & CROWD ENGINE']
- Feeds into: ['62. CORPORATE CAREER SYSTEM']
- Related: ['61. CITY TRAFFIC & CROWD ENGINE', '62. CORPORATE CAREER SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 62. CORPORATE CAREER SYSTEM
- Anchor: 62-corporate-career-system
- Depends on: ['61.1 TRAFFIC DENSITY ZONES']
- Feeds into: ['62.1 OFFICE POLITICS ENGINE']
- Related: ['61.1 TRAFFIC DENSITY ZONES', '62.1 OFFICE POLITICS ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 62.1 OFFICE POLITICS ENGINE
- Anchor: 62-1-office-politics-engine
- Depends on: ['62. CORPORATE CAREER SYSTEM']
- Feeds into: ['63. FIGHT RING ENGINE']
- Related: ['62. CORPORATE CAREER SYSTEM', '63. FIGHT RING ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 63. FIGHT RING ENGINE
- Anchor: 63-fight-ring-engine
- Depends on: ['62.1 OFFICE POLITICS ENGINE']
- Feeds into: ['64. LIVE OPS SYSTEM']
- Related: ['62.1 OFFICE POLITICS ENGINE', '64. LIVE OPS SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 64. LIVE OPS SYSTEM
- Anchor: 64-live-ops-system
- Depends on: ['63. FIGHT RING ENGINE']
- Feeds into: ['65. MONETISATION LAW']
- Related: ['63. FIGHT RING ENGINE', '65. MONETISATION LAW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 65. MONETISATION LAW
- Anchor: 65-monetisation-law
- Depends on: ['64. LIVE OPS SYSTEM']
- Feeds into: ['66. DARK LUXURY CODEX']
- Related: ['64. LIVE OPS SYSTEM', '66. DARK LUXURY CODEX', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 66. DARK LUXURY CODEX
- Anchor: 66-dark-luxury-codex
- Depends on: ['65. MONETISATION LAW']
- Feeds into: ['67. WEATHER DISASTER ENGINE (WDE)']
- Related: ['65. MONETISATION LAW', '67. WEATHER DISASTER ENGINE (WDE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 67. WEATHER DISASTER ENGINE (WDE)
- Anchor: 67-weather-disaster-engine-wde
- Depends on: ['66. DARK LUXURY CODEX']
- Feeds into: ['67.1 DISASTER TYPES']
- Related: ['66. DARK LUXURY CODEX', '67.1 DISASTER TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 67.1 DISASTER TYPES
- Anchor: 67-1-disaster-types
- Depends on: ['67. WEATHER DISASTER ENGINE (WDE)']
- Feeds into: ['FLOODWAVE']
- Related: ['67. WEATHER DISASTER ENGINE (WDE)', 'FLOODWAVE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## FLOODWAVE
- Anchor: floodwave
- Depends on: ['67.1 DISASTER TYPES']
- Feeds into: ['SUPERCELL']
- Related: ['67.1 DISASTER TYPES', 'SUPERCELL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SUPERCELL
- Anchor: supercell
- Depends on: ['FLOODWAVE']
- Feeds into: ['HEAT DOOM']
- Related: ['FLOODWAVE', 'HEAT DOOM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## HEAT DOOM
- Anchor: heat-doom
- Depends on: ['SUPERCELL']
- Feeds into: ['SNOWLOCK']
- Related: ['SUPERCELL', 'SNOWLOCK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SNOWLOCK
- Anchor: snowlock
- Depends on: ['HEAT DOOM']
- Feeds into: ['67.2 DISASTER PHASES']
- Related: ['HEAT DOOM', '67.2 DISASTER PHASES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 67.2 DISASTER PHASES
- Anchor: 67-2-disaster-phases
- Depends on: ['SNOWLOCK']
- Feeds into: ['68.1 PART CATEGORIES']
- Related: ['SNOWLOCK', '68.1 PART CATEGORIES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 68.1 PART CATEGORIES
- Anchor: 68-1-part-categories
- Depends on: ['67.2 DISASTER PHASES']
- Feeds into: ['68.2 BUILD SPECIALISATIONS']
- Related: ['67.2 DISASTER PHASES', '68.2 BUILD SPECIALISATIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 68.2 BUILD SPECIALISATIONS
- Anchor: 68-2-build-specialisations
- Depends on: ['68.1 PART CATEGORIES']
- Feeds into: ['DRAGOON']
- Related: ['68.1 PART CATEGORIES', 'DRAGOON', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## DRAGOON
- Anchor: dragoon
- Depends on: ['68.2 BUILD SPECIALISATIONS']
- Feeds into: ['GHOSTRUNNER']
- Related: ['68.2 BUILD SPECIALISATIONS', 'GHOSTRUNNER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## GHOSTRUNNER
- Anchor: ghostrunner
- Depends on: ['DRAGOON']
- Feeds into: ['TANKLINE']
- Related: ['DRAGOON', 'TANKLINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TANKLINE
- Anchor: tankline
- Depends on: ['GHOSTRUNNER']
- Feeds into: ['TECHBREAKER']
- Related: ['GHOSTRUNNER', 'TECHBREAKER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## TECHBREAKER
- Anchor: techbreaker
- Depends on: ['TANKLINE']
- Feeds into: ['68.3 RACING AFFINITY SYSTEM']
- Related: ['TANKLINE', '68.3 RACING AFFINITY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 68.3 RACING AFFINITY SYSTEM
- Anchor: 68-3-racing-affinity-system
- Depends on: ['TECHBREAKER']
- Feeds into: ['69.1 TRAUMA TYPES']
- Related: ['TECHBREAKER', '69.1 TRAUMA TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 69.1 TRAUMA TYPES
- Anchor: 69-1-trauma-types
- Depends on: ['68.3 RACING AFFINITY SYSTEM']
- Feeds into: ['LIGHT']
- Related: ['68.3 RACING AFFINITY SYSTEM', 'LIGHT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## LIGHT
- Anchor: light
- Depends on: ['69.1 TRAUMA TYPES']
- Feeds into: ['MODERATE']
- Related: ['69.1 TRAUMA TYPES', 'MODERATE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## MODERATE
- Anchor: moderate
- Depends on: ['LIGHT']
- Feeds into: ['SEVERE']
- Related: ['LIGHT', 'SEVERE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SEVERE
- Anchor: severe
- Depends on: ['MODERATE']
- Feeds into: ['69.3 SCAR SYSTEM']
- Related: ['MODERATE', '69.3 SCAR SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 69.3 SCAR SYSTEM
- Anchor: 69-3-scar-system
- Depends on: ['SEVERE']
- Feeds into: ['70. HUMAN CONDITION ENGINE']
- Related: ['SEVERE', '70. HUMAN CONDITION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 70. HUMAN CONDITION ENGINE
- Anchor: 70-human-condition-engine
- Depends on: ['69.3 SCAR SYSTEM']
- Feeds into: ['70.1 MOOD TYPES']
- Related: ['69.3 SCAR SYSTEM', '70.1 MOOD TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 70.1 MOOD TYPES
- Anchor: 70-1-mood-types
- Depends on: ['70. HUMAN CONDITION ENGINE']
- Feeds into: ['70.2 FOOD & DRINK EFFECTS']
- Related: ['70. HUMAN CONDITION ENGINE', '70.2 FOOD & DRINK EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 70.2 FOOD & DRINK EFFECTS
- Anchor: 70-2-food-drink-effects
- Depends on: ['70.1 MOOD TYPES']
- Feeds into: ['71.2 SPY DETECTION SYSTEM']
- Related: ['70.1 MOOD TYPES', '71.2 SPY DETECTION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 71.2 SPY DETECTION SYSTEM
- Anchor: 71-2-spy-detection-system
- Depends on: ['70.2 FOOD & DRINK EFFECTS']
- Feeds into: ['72. ECONOMIC COLLAPSE ENGINE']
- Related: ['70.2 FOOD & DRINK EFFECTS', '72. ECONOMIC COLLAPSE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 72. ECONOMIC COLLAPSE ENGINE
- Anchor: 72-economic-collapse-engine
- Depends on: ['71.2 SPY DETECTION SYSTEM']
- Feeds into: ['72.1 COLLAPSE EFFECTS']
- Related: ['71.2 SPY DETECTION SYSTEM', '72.1 COLLAPSE EFFECTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 72.1 COLLAPSE EFFECTS
- Anchor: 72-1-collapse-effects
- Depends on: ['72. ECONOMIC COLLAPSE ENGINE']
- Feeds into: ['72.2 RECOVERY PHASES']
- Related: ['72. ECONOMIC COLLAPSE ENGINE', '72.2 RECOVERY PHASES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 72.2 RECOVERY PHASES
- Anchor: 72-2-recovery-phases
- Depends on: ['72.1 COLLAPSE EFFECTS']
- Feeds into: ['73. PRISON WORLD ENGINE']
- Related: ['72.1 COLLAPSE EFFECTS', '73. PRISON WORLD ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 73. PRISON WORLD ENGINE
- Anchor: 73-prison-world-engine
- Depends on: ['72.2 RECOVERY PHASES']
- Feeds into: ['73.2 PRISON GAMEPLAY']
- Related: ['72.2 RECOVERY PHASES', '73.2 PRISON GAMEPLAY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 73.2 PRISON GAMEPLAY
- Anchor: 73-2-prison-gameplay
- Depends on: ['73. PRISON WORLD ENGINE']
- Feeds into: ['SHADOW TRENCH']
- Related: ['73. PRISON WORLD ENGINE', 'SHADOW TRENCH', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## SHADOW TRENCH
- Anchor: shadow-trench
- Depends on: ['73.2 PRISON GAMEPLAY']
- Feeds into: ['GOLDEN PARAGON CITY']
- Related: ['73.2 PRISON GAMEPLAY', 'GOLDEN PARAGON CITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## GOLDEN PARAGON CITY
- Anchor: golden-paragon-city
- Depends on: ['SHADOW TRENCH']
- Feeds into: ['FRACTURED TRENCH']
- Related: ['SHADOW TRENCH', 'FRACTURED TRENCH', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## FRACTURED TRENCH
- Anchor: fractured-trench
- Depends on: ['GOLDEN PARAGON CITY']
- Feeds into: ['76. PUBLIC PERCEPTION ENGINE']
- Related: ['GOLDEN PARAGON CITY', '76. PUBLIC PERCEPTION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 76. PUBLIC PERCEPTION ENGINE
- Anchor: 76-public-perception-engine
- Depends on: ['FRACTURED TRENCH']
- Feeds into: ['76.2 PUBLIC CONTROVERSY SYSTEM']
- Related: ['FRACTURED TRENCH', '76.2 PUBLIC CONTROVERSY SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 76.2 PUBLIC CONTROVERSY SYSTEM
- Anchor: 76-2-public-controversy-system
- Depends on: ['76. PUBLIC PERCEPTION ENGINE']
- Feeds into: ['77. LAW ENFORCEMENT SIMULATION ENGINE (LESE)']
- Related: ['76. PUBLIC PERCEPTION ENGINE', '77. LAW ENFORCEMENT SIMULATION ENGINE (LESE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 77. LAW ENFORCEMENT SIMULATION ENGINE (LESE)
- Anchor: 77-law-enforcement-simulation-engine-lese
- Depends on: ['76.2 PUBLIC CONTROVERSY SYSTEM']
- Feeds into: ['77.1 POLICE AI STATES']
- Related: ['76.2 PUBLIC CONTROVERSY SYSTEM', '77.1 POLICE AI STATES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 77.1 POLICE AI STATES
- Anchor: 77-1-police-ai-states
- Depends on: ['77. LAW ENFORCEMENT SIMULATION ENGINE (LESE)']
- Feeds into: ['PATROL MODE']
- Related: ['77. LAW ENFORCEMENT SIMULATION ENGINE (LESE)', 'PATROL MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PATROL MODE
- Anchor: patrol-mode
- Depends on: ['77.1 POLICE AI STATES']
- Feeds into: ['ALERT MODE']
- Related: ['77.1 POLICE AI STATES', 'ALERT MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ALERT MODE
- Anchor: alert-mode
- Depends on: ['PATROL MODE']
- Feeds into: ['LOCKDOWN MODE']
- Related: ['PATROL MODE', 'LOCKDOWN MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## LOCKDOWN MODE
- Anchor: lockdown-mode
- Depends on: ['ALERT MODE']
- Feeds into: ['PURSUIT MODE']
- Related: ['ALERT MODE', 'PURSUIT MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## PURSUIT MODE
- Anchor: pursuit-mode
- Depends on: ['LOCKDOWN MODE']
- Feeds into: ['CORRUPTION MODE']
- Related: ['LOCKDOWN MODE', 'CORRUPTION MODE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## CORRUPTION MODE
- Anchor: corruption-mode
- Depends on: ['PURSUIT MODE']
- Feeds into: ['77.2 CORRUPTION SYSTEM']
- Related: ['PURSUIT MODE', '77.2 CORRUPTION SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 77.2 CORRUPTION SYSTEM
- Anchor: 77-2-corruption-system
- Depends on: ['CORRUPTION MODE']
- Feeds into: ['78.1 HACKING MECHANICS']
- Related: ['CORRUPTION MODE', '78.1 HACKING MECHANICS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 78.1 HACKING MECHANICS
- Anchor: 78-1-hacking-mechanics
- Depends on: ['77.2 CORRUPTION SYSTEM']
- Feeds into: ['78.3 DIGITAL CONSEQUENCES']
- Related: ['77.2 CORRUPTION SYSTEM', '78.3 DIGITAL CONSEQUENCES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 78.3 DIGITAL CONSEQUENCES
- Anchor: 78-3-digital-consequences
- Depends on: ['78.1 HACKING MECHANICS']
- Feeds into: ['79.1 ATM BOMBING']
- Related: ['78.1 HACKING MECHANICS', '79.1 ATM BOMBING', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 79.1 ATM BOMBING
- Anchor: 79-1-atm-bombing
- Depends on: ['78.3 DIGITAL CONSEQUENCES']
- Feeds into: ['79.2 BANK HEISTS']
- Related: ['78.3 DIGITAL CONSEQUENCES', '79.2 BANK HEISTS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 79.2 BANK HEISTS
- Anchor: 79-2-bank-heists
- Depends on: ['79.1 ATM BOMBING']
- Feeds into: ['81. AUGMENTATION ENGINE']
- Related: ['79.1 ATM BOMBING', '81. AUGMENTATION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 81. AUGMENTATION ENGINE
- Anchor: 81-augmentation-engine
- Depends on: ['79.2 BANK HEISTS']
- Feeds into: ['81.1 AUGMENT TYPES']
- Related: ['79.2 BANK HEISTS', '81.1 AUGMENT TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 81.1 AUGMENT TYPES
- Anchor: 81-1-augment-types
- Depends on: ['81. AUGMENTATION ENGINE']
- Feeds into: ['83. WEATHER AI 2.0']
- Related: ['81. AUGMENTATION ENGINE', '83. WEATHER AI 2.0', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 83. WEATHER AI 2.0
- Anchor: 83-weather-ai-2-0
- Depends on: ['81.1 AUGMENT TYPES']
- Feeds into: ['84. GLOBAL DIPLOMACY MATRIX']
- Related: ['81.1 AUGMENT TYPES', '84. GLOBAL DIPLOMACY MATRIX', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 84. GLOBAL DIPLOMACY MATRIX
- Anchor: 84-global-diplomacy-matrix
- Depends on: ['83. WEATHER AI 2.0']
- Feeds into: ['85. ECHO BATTLE SYSTEM']
- Related: ['83. WEATHER AI 2.0', '85. ECHO BATTLE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 85. ECHO BATTLE SYSTEM
- Anchor: 85-echo-battle-system
- Depends on: ['84. GLOBAL DIPLOMACY MATRIX']
- Feeds into: ['86. INFRASTRUCTURE TAKEOVER']
- Related: ['84. GLOBAL DIPLOMACY MATRIX', '86. INFRASTRUCTURE TAKEOVER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 86. INFRASTRUCTURE TAKEOVER
- Anchor: 86-infrastructure-takeover
- Depends on: ['85. ECHO BATTLE SYSTEM']
- Feeds into: ['87. MUSIC AI ENGINE']
- Related: ['85. ECHO BATTLE SYSTEM', '87. MUSIC AI ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 87. MUSIC AI ENGINE
- Anchor: 87-music-ai-engine
- Depends on: ['86. INFRASTRUCTURE TAKEOVER']
- Feeds into: ['88. STREAM MODE & PUBLIC ARENAS']
- Related: ['86. INFRASTRUCTURE TAKEOVER', '88. STREAM MODE & PUBLIC ARENAS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 88. STREAM MODE & PUBLIC ARENAS
- Anchor: 88-stream-mode-public-arenas
- Depends on: ['87. MUSIC AI ENGINE']
- Feeds into: ['89. PLAYER GOVERNMENT SYSTEM']
- Related: ['87. MUSIC AI ENGINE', '89. PLAYER GOVERNMENT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 89. PLAYER GOVERNMENT SYSTEM
- Anchor: 89-player-government-system
- Depends on: ['88. STREAM MODE & PUBLIC ARENAS']
- Feeds into: ['90. CRISIS DIPLOMACY ENGINE']
- Related: ['88. STREAM MODE & PUBLIC ARENAS', '90. CRISIS DIPLOMACY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 90. CRISIS DIPLOMACY ENGINE
- Anchor: 90-crisis-diplomacy-engine
- Depends on: ['89. PLAYER GOVERNMENT SYSTEM']
- Feeds into: ['91. BLOCK SYSTEM']
- Related: ['89. PLAYER GOVERNMENT SYSTEM', '91. BLOCK SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 91. BLOCK SYSTEM
- Anchor: 91-block-system
- Depends on: ['90. CRISIS DIPLOMACY ENGINE']
- Feeds into: ['92. CIVILIAN SIM ENGINE']
- Related: ['90. CRISIS DIPLOMACY ENGINE', '92. CIVILIAN SIM ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 92. CIVILIAN SIM ENGINE
- Anchor: 92-civilian-sim-engine
- Depends on: ['91. BLOCK SYSTEM']
- Feeds into: ['93. COURT SYSTEM']
- Related: ['91. BLOCK SYSTEM', '93. COURT SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 93. COURT SYSTEM
- Anchor: 93-court-system
- Depends on: ['92. CIVILIAN SIM ENGINE']
- Feeds into: ['94. PANIC PROPAGATION ENGINE']
- Related: ['92. CIVILIAN SIM ENGINE', '94. PANIC PROPAGATION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 94. PANIC PROPAGATION ENGINE
- Anchor: 94-panic-propagation-engine
- Depends on: ['93. COURT SYSTEM']
- Feeds into: ['96. WORLD STATE ENDINGS']
- Related: ['93. COURT SYSTEM', '96. WORLD STATE ENDINGS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 96. WORLD STATE ENDINGS
- Anchor: 96-world-state-endings
- Depends on: ['94. PANIC PROPAGATION ENGINE']
- Feeds into: ['THE GOLDEN AGE']
- Related: ['94. PANIC PROPAGATION ENGINE', 'THE GOLDEN AGE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE GOLDEN AGE
- Anchor: the-golden-age
- Depends on: ['96. WORLD STATE ENDINGS']
- Feeds into: ['THE DARK ASCENT']
- Related: ['96. WORLD STATE ENDINGS', 'THE DARK ASCENT', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE DARK ASCENT
- Anchor: the-dark-ascent
- Depends on: ['THE GOLDEN AGE']
- Feeds into: ['THE IRON LOCKDOWN']
- Related: ['THE GOLDEN AGE', 'THE IRON LOCKDOWN', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE IRON LOCKDOWN
- Anchor: the-iron-lockdown
- Depends on: ['THE DARK ASCENT']
- Feeds into: ['THE CRIMSON KINGDOM']
- Related: ['THE DARK ASCENT', 'THE CRIMSON KINGDOM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE CRIMSON KINGDOM
- Anchor: the-crimson-kingdom
- Depends on: ['THE IRON LOCKDOWN']
- Feeds into: ['97. PREDICTION AI ENGINE (PAE)']
- Related: ['THE IRON LOCKDOWN', '97. PREDICTION AI ENGINE (PAE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 97. PREDICTION AI ENGINE (PAE)
- Anchor: 97-prediction-ai-engine-pae
- Depends on: ['THE CRIMSON KINGDOM']
- Feeds into: ['98. SECRET SOCIETY NETWORK (SSN)']
- Related: ['THE CRIMSON KINGDOM', '98. SECRET SOCIETY NETWORK (SSN)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 98. SECRET SOCIETY NETWORK (SSN)
- Anchor: 98-secret-society-network-ssn
- Depends on: ['97. PREDICTION AI ENGINE (PAE)']
- Feeds into: ['99. BIOHACK ENGINE']
- Related: ['97. PREDICTION AI ENGINE (PAE)', '99. BIOHACK ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 99. BIOHACK ENGINE
- Anchor: 99-biohack-engine
- Depends on: ['98. SECRET SOCIETY NETWORK (SSN)']
- Feeds into: ['101. ECONOMIC SINGULARITY ENGINE']
- Related: ['98. SECRET SOCIETY NETWORK (SSN)', '101. ECONOMIC SINGULARITY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 101. ECONOMIC SINGULARITY ENGINE
- Anchor: 101-economic-singularity-engine
- Depends on: ['99. BIOHACK ENGINE']
- Feeds into: ['102. MEMORY IMPRINT ENGINE']
- Related: ['99. BIOHACK ENGINE', '102. MEMORY IMPRINT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 102. MEMORY IMPRINT ENGINE
- Anchor: 102-memory-imprint-engine
- Depends on: ['101. ECONOMIC SINGULARITY ENGINE']
- Feeds into: ['103. PLAYER LIFE SYSTEM']
- Related: ['101. ECONOMIC SINGULARITY ENGINE', '103. PLAYER LIFE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 103. PLAYER LIFE SYSTEM
- Anchor: 103-player-life-system
- Depends on: ['102. MEMORY IMPRINT ENGINE']
- Feeds into: ['104. NATIONAL POLITICS SIM']
- Related: ['102. MEMORY IMPRINT ENGINE', '104. NATIONAL POLITICS SIM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 104. NATIONAL POLITICS SIM
- Anchor: 104-national-politics-sim
- Depends on: ['103. PLAYER LIFE SYSTEM']
- Feeds into: ['105. CITY EVOLUTION ENGINE v3']
- Related: ['103. PLAYER LIFE SYSTEM', '105. CITY EVOLUTION ENGINE v3', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 105. CITY EVOLUTION ENGINE v3
- Anchor: 105-city-evolution-engine-v3
- Depends on: ['104. NATIONAL POLITICS SIM']
- Feeds into: ['107. REPUTATION GRAPH ENGINE']
- Related: ['104. NATIONAL POLITICS SIM', '107. REPUTATION GRAPH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 107. REPUTATION GRAPH ENGINE
- Anchor: 107-reputation-graph-engine
- Depends on: ['105. CITY EVOLUTION ENGINE v3']
- Feeds into: ['108. LOOT AI SYSTEM']
- Related: ['105. CITY EVOLUTION ENGINE v3', '108. LOOT AI SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 108. LOOT AI SYSTEM
- Anchor: 108-loot-ai-system
- Depends on: ['107. REPUTATION GRAPH ENGINE']
- Feeds into: ['111. MEGASTRUCTURE SYSTEM']
- Related: ['107. REPUTATION GRAPH ENGINE', '111. MEGASTRUCTURE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 111. MEGASTRUCTURE SYSTEM
- Anchor: 111-megastructure-system
- Depends on: ['108. LOOT AI SYSTEM']
- Feeds into: ['113. APOCALYPTIC BOSS ENGINE']
- Related: ['108. LOOT AI SYSTEM', '113. APOCALYPTIC BOSS ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 113. APOCALYPTIC BOSS ENGINE
- Anchor: 113-apocalyptic-boss-engine
- Depends on: ['111. MEGASTRUCTURE SYSTEM']
- Feeds into: ['114. HISTORY BRANCH SYSTEM']
- Related: ['111. MEGASTRUCTURE SYSTEM', '114. HISTORY BRANCH SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 114. HISTORY BRANCH SYSTEM
- Anchor: 114-history-branch-system
- Depends on: ['113. APOCALYPTIC BOSS ENGINE']
- Feeds into: ['115. GRAND STRATEGY MODULE']
- Related: ['113. APOCALYPTIC BOSS ENGINE', '115. GRAND STRATEGY MODULE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 115. GRAND STRATEGY MODULE
- Anchor: 115-grand-strategy-module
- Depends on: ['114. HISTORY BRANCH SYSTEM']
- Feeds into: ['116. THE SUPREME LAW OF TRENCH CITY']
- Related: ['114. HISTORY BRANCH SYSTEM', '116. THE SUPREME LAW OF TRENCH CITY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 116. THE SUPREME LAW OF TRENCH CITY
- Anchor: 116-the-supreme-law-of-trench-city
- Depends on: ['115. GRAND STRATEGY MODULE']
- Feeds into: ['117. AI PERSONALITY EVOLUTION (APE)']
- Related: ['115. GRAND STRATEGY MODULE', '117. AI PERSONALITY EVOLUTION (APE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 117. AI PERSONALITY EVOLUTION (APE)
- Anchor: 117-ai-personality-evolution-ape
- Depends on: ['116. THE SUPREME LAW OF TRENCH CITY']
- Feeds into: ['117.1 PERSONALITY GROWTH TRAITS']
- Related: ['116. THE SUPREME LAW OF TRENCH CITY', '117.1 PERSONALITY GROWTH TRAITS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 117.1 PERSONALITY GROWTH TRAITS
- Anchor: 117-1-personality-growth-traits
- Depends on: ['117. AI PERSONALITY EVOLUTION (APE)']
- Feeds into: ['117.2 MEMORY-DRIVEN EVOLUTION']
- Related: ['117. AI PERSONALITY EVOLUTION (APE)', '117.2 MEMORY-DRIVEN EVOLUTION', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 117.2 MEMORY-DRIVEN EVOLUTION
- Anchor: 117-2-memory-driven-evolution
- Depends on: ['117.1 PERSONALITY GROWTH TRAITS']
- Feeds into: ['118. MULTISPECIES FRAMEWORK (OPTIONAL MODE)']
- Related: ['117.1 PERSONALITY GROWTH TRAITS', '118. MULTISPECIES FRAMEWORK (OPTIONAL MODE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 118. MULTISPECIES FRAMEWORK (OPTIONAL MODE)
- Anchor: 118-multispecies-framework-optional-mode
- Depends on: ['117.2 MEMORY-DRIVEN EVOLUTION']
- Feeds into: ['119. SHADOW STOCK EXCHANGE (SSE)']
- Related: ['117.2 MEMORY-DRIVEN EVOLUTION', '119. SHADOW STOCK EXCHANGE (SSE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 119. SHADOW STOCK EXCHANGE (SSE)
- Anchor: 119-shadow-stock-exchange-sse
- Depends on: ['118. MULTISPECIES FRAMEWORK (OPTIONAL MODE)']
- Feeds into: ['120. CYBERWAR ENGINE']
- Related: ['118. MULTISPECIES FRAMEWORK (OPTIONAL MODE)', '120. CYBERWAR ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 120. CYBERWAR ENGINE
- Anchor: 120-cyberwar-engine
- Depends on: ['119. SHADOW STOCK EXCHANGE (SSE)']
- Feeds into: ['121. DYNASTY ENGINE']
- Related: ['119. SHADOW STOCK EXCHANGE (SSE)', '121. DYNASTY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 121. DYNASTY ENGINE
- Anchor: 121-dynasty-engine
- Depends on: ['120. CYBERWAR ENGINE']
- Feeds into: ['122. TERRAFORM ENGINE']
- Related: ['120. CYBERWAR ENGINE', '122. TERRAFORM ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 122. TERRAFORM ENGINE
- Anchor: 122-terraform-engine
- Depends on: ['121. DYNASTY ENGINE']
- Feeds into: ['124. IDEOLOGY ENGINE']
- Related: ['121. DYNASTY ENGINE', '124. IDEOLOGY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 124. IDEOLOGY ENGINE
- Anchor: 124-ideology-engine
- Depends on: ['122. TERRAFORM ENGINE']
- Feeds into: ['126. PSYWAR ENGINE']
- Related: ['122. TERRAFORM ENGINE', '126. PSYWAR ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 126. PSYWAR ENGINE
- Anchor: 126-psywar-engine
- Depends on: ['124. IDEOLOGY ENGINE']
- Feeds into: ['127. TIME LOOP ENGINE']
- Related: ['124. IDEOLOGY ENGINE', '127. TIME LOOP ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 127. TIME LOOP ENGINE
- Anchor: 127-time-loop-engine
- Depends on: ['126. PSYWAR ENGINE']
- Feeds into: ['128. WORLD MEMORY ENGINE']
- Related: ['126. PSYWAR ENGINE', '128. WORLD MEMORY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 128. WORLD MEMORY ENGINE
- Anchor: 128-world-memory-engine
- Depends on: ['127. TIME LOOP ENGINE']
- Feeds into: ['129. SOCIETAL SIM ENGINE']
- Related: ['127. TIME LOOP ENGINE', '129. SOCIETAL SIM ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 129. SOCIETAL SIM ENGINE
- Anchor: 129-societal-sim-engine
- Depends on: ['128. WORLD MEMORY ENGINE']
- Feeds into: ['130. MEDIA CONTROL ENGINE']
- Related: ['128. WORLD MEMORY ENGINE', '130. MEDIA CONTROL ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 130. MEDIA CONTROL ENGINE
- Anchor: 130-media-control-engine
- Depends on: ['129. SOCIETAL SIM ENGINE']
- Feeds into: ['133. CORPORATE WAR ENGINE']
- Related: ['129. SOCIETAL SIM ENGINE', '133. CORPORATE WAR ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 133. CORPORATE WAR ENGINE
- Anchor: 133-corporate-war-engine
- Depends on: ['130. MEDIA CONTROL ENGINE']
- Feeds into: ['136. HYPERSTRUCTURE LAW']
- Related: ['130. MEDIA CONTROL ENGINE', '136. HYPERSTRUCTURE LAW', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 136. HYPERSTRUCTURE LAW
- Anchor: 136-hyperstructure-law
- Depends on: ['133. CORPORATE WAR ENGINE']
- Feeds into: ['137. RELIGION FRAMEWORK ENGINE (RFE)']
- Related: ['133. CORPORATE WAR ENGINE', '137. RELIGION FRAMEWORK ENGINE (RFE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 137. RELIGION FRAMEWORK ENGINE (RFE)
- Anchor: 137-religion-framework-engine-rfe
- Depends on: ['136. HYPERSTRUCTURE LAW']
- Feeds into: ['137.1 RELIGION TYPES']
- Related: ['136. HYPERSTRUCTURE LAW', '137.1 RELIGION TYPES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 137.1 RELIGION TYPES
- Anchor: 137-1-religion-types
- Depends on: ['137. RELIGION FRAMEWORK ENGINE (RFE)']
- Feeds into: ['THE PATH OF THE GOLDEN VEIL']
- Related: ['137. RELIGION FRAMEWORK ENGINE (RFE)', 'THE PATH OF THE GOLDEN VEIL', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE PATH OF THE GOLDEN VEIL
- Anchor: the-path-of-the-golden-veil
- Depends on: ['137.1 RELIGION TYPES']
- Feeds into: ['THE ORDER OF IRON']
- Related: ['137.1 RELIGION TYPES', 'THE ORDER OF IRON', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE ORDER OF IRON
- Anchor: the-order-of-iron
- Depends on: ['THE PATH OF THE GOLDEN VEIL']
- Feeds into: ['THE SHADOW CHOIR']
- Related: ['THE PATH OF THE GOLDEN VEIL', 'THE SHADOW CHOIR', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE SHADOW CHOIR
- Anchor: the-shadow-choir
- Depends on: ['THE ORDER OF IRON']
- Feeds into: ['137.2 RELIGIOUS POWER ACTIONS']
- Related: ['THE ORDER OF IRON', '137.2 RELIGIOUS POWER ACTIONS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 137.2 RELIGIOUS POWER ACTIONS
- Anchor: 137-2-religious-power-actions
- Depends on: ['THE SHADOW CHOIR']
- Feeds into: ['141. CONSPIRACY WEB ENGINE']
- Related: ['THE SHADOW CHOIR', '141. CONSPIRACY WEB ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 141. CONSPIRACY WEB ENGINE
- Anchor: 141-conspiracy-web-engine
- Depends on: ['137.2 RELIGIOUS POWER ACTIONS']
- Feeds into: ['142. CASINO EMPIRE ENGINE']
- Related: ['137.2 RELIGIOUS POWER ACTIONS', '142. CASINO EMPIRE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 142. CASINO EMPIRE ENGINE
- Anchor: 142-casino-empire-engine
- Depends on: ['141. CONSPIRACY WEB ENGINE']
- Feeds into: ['143. BLACK HOLE EVENT ENGINE']
- Related: ['141. CONSPIRACY WEB ENGINE', '143. BLACK HOLE EVENT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 143. BLACK HOLE EVENT ENGINE
- Anchor: 143-black-hole-event-engine
- Depends on: ['142. CASINO EMPIRE ENGINE']
- Feeds into: ['145. WEAPON ECOSYSTEM 4.0']
- Related: ['142. CASINO EMPIRE ENGINE', '145. WEAPON ECOSYSTEM 4.0', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 145. WEAPON ECOSYSTEM 4.0
- Anchor: 145-weapon-ecosystem-4-0
- Depends on: ['143. BLACK HOLE EVENT ENGINE']
- Feeds into: ['146. LEGENDARY CLASSES']
- Related: ['143. BLACK HOLE EVENT ENGINE', '146. LEGENDARY CLASSES', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 146. LEGENDARY CLASSES
- Anchor: 146-legendary-classes
- Depends on: ['145. WEAPON ECOSYSTEM 4.0']
- Feeds into: ['THE WRAITH']
- Related: ['145. WEAPON ECOSYSTEM 4.0', 'THE WRAITH', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE WRAITH
- Anchor: the-wraith
- Depends on: ['146. LEGENDARY CLASSES']
- Feeds into: ['THE COLOSSUS']
- Related: ['146. LEGENDARY CLASSES', 'THE COLOSSUS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE COLOSSUS
- Anchor: the-colossus
- Depends on: ['THE WRAITH']
- Feeds into: ['THE ORACLE']
- Related: ['THE WRAITH', 'THE ORACLE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE ORACLE
- Anchor: the-oracle
- Depends on: ['THE COLOSSUS']
- Feeds into: ['THE EXECUTIONER']
- Related: ['THE COLOSSUS', 'THE EXECUTIONER', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## THE EXECUTIONER
- Anchor: the-executioner
- Depends on: ['THE ORACLE']
- Feeds into: ['147. SQUAD AI ENGINE']
- Related: ['THE ORACLE', '147. SQUAD AI ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 147. SQUAD AI ENGINE
- Anchor: 147-squad-ai-engine
- Depends on: ['THE EXECUTIONER']
- Feeds into: ['148. SENTIENT WEATHER ENGINE']
- Related: ['THE EXECUTIONER', '148. SENTIENT WEATHER ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 148. SENTIENT WEATHER ENGINE
- Anchor: 148-sentient-weather-engine
- Depends on: ['147. SQUAD AI ENGINE']
- Feeds into: ['151. WORLD DOOM CHAINS']
- Related: ['147. SQUAD AI ENGINE', '151. WORLD DOOM CHAINS', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 151. WORLD DOOM CHAINS
- Anchor: 151-world-doom-chains
- Depends on: ['148. SENTIENT WEATHER ENGINE']
- Feeds into: ['154. REALITY ANCHOR SYSTEM']
- Related: ['148. SENTIENT WEATHER ENGINE', '154. REALITY ANCHOR SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 154. REALITY ANCHOR SYSTEM
- Anchor: 154-reality-anchor-system
- Depends on: ['151. WORLD DOOM CHAINS']
- Feeds into: ['155. CONFESSION ENGINE']
- Related: ['151. WORLD DOOM CHAINS', '155. CONFESSION ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 155. CONFESSION ENGINE
- Anchor: 155-confession-engine
- Depends on: ['154. REALITY ANCHOR SYSTEM']
- Feeds into: ['158. ARCHETYPE ASCENDANCY']
- Related: ['154. REALITY ANCHOR SYSTEM', '158. ARCHETYPE ASCENDANCY', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 158. ARCHETYPE ASCENDANCY
- Anchor: 158-archetype-ascendancy
- Depends on: ['155. CONFESSION ENGINE']
- Feeds into: ['161. REALITY FRACTURE NETWORK']
- Related: ['155. CONFESSION ENGINE', '161. REALITY FRACTURE NETWORK', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 161. REALITY FRACTURE NETWORK
- Anchor: 161-reality-fracture-network
- Depends on: ['158. ARCHETYPE ASCENDANCY']
- Feeds into: ['162. PLAYER CHRONICLE SYSTEM']
- Related: ['158. ARCHETYPE ASCENDANCY', '162. PLAYER CHRONICLE SYSTEM', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 162. PLAYER CHRONICLE SYSTEM
- Anchor: 162-player-chronicle-system
- Depends on: ['161. REALITY FRACTURE NETWORK']
- Feeds into: ['166. THE GRAND PARADOX LAW (System #150)']
- Related: ['161. REALITY FRACTURE NETWORK', '166. THE GRAND PARADOX LAW (System #150)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 166. THE GRAND PARADOX LAW (System #150)
- Anchor: 166-the-grand-paradox-law-system-150
- Depends on: ['162. PLAYER CHRONICLE SYSTEM']
- Feeds into: ['168. FUSION PATH ENGINE']
- Related: ['162. PLAYER CHRONICLE SYSTEM', '168. FUSION PATH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 168. FUSION PATH ENGINE
- Anchor: 168-fusion-path-engine
- Depends on: ['166. THE GRAND PARADOX LAW (System #150)']
- Feeds into: ['169. CROSS-REALITY GOVERNANCE ENGINE']
- Related: ['166. THE GRAND PARADOX LAW (System #150)', '169. CROSS-REALITY GOVERNANCE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 169. CROSS-REALITY GOVERNANCE ENGINE
- Anchor: 169-cross-reality-governance-engine
- Depends on: ['168. FUSION PATH ENGINE']
- Feeds into: ['172. SENTIENT CITY ENGINE (SCE)']
- Related: ['168. FUSION PATH ENGINE', '172. SENTIENT CITY ENGINE (SCE)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 172. SENTIENT CITY ENGINE (SCE)
- Anchor: 172-sentient-city-engine-sce
- Depends on: ['169. CROSS-REALITY GOVERNANCE ENGINE']
- Feeds into: ['177. SANCTUM ENGINE']
- Related: ['169. CROSS-REALITY GOVERNANCE ENGINE', '177. SANCTUM ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 177. SANCTUM ENGINE
- Anchor: 177-sanctum-engine
- Depends on: ['172. SENTIENT CITY ENGINE (SCE)']
- Feeds into: ['178. CHIMERA ENGINE']
- Related: ['172. SENTIENT CITY ENGINE (SCE)', '178. CHIMERA ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 178. CHIMERA ENGINE
- Anchor: 178-chimera-engine
- Depends on: ['177. SANCTUM ENGINE']
- Feeds into: ['179. GHOST NETWORK ENGINE']
- Related: ['177. SANCTUM ENGINE', '179. GHOST NETWORK ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 179. GHOST NETWORK ENGINE
- Anchor: 179-ghost-network-engine
- Depends on: ['178. CHIMERA ENGINE']
- Feeds into: ['181. REALITY PHYSICS ENGINE']
- Related: ['178. CHIMERA ENGINE', '181. REALITY PHYSICS ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 181. REALITY PHYSICS ENGINE
- Anchor: 181-reality-physics-engine
- Depends on: ['179. GHOST NETWORK ENGINE']
- Feeds into: ['183. PARTY ENGINE']
- Related: ['179. GHOST NETWORK ENGINE', '183. PARTY ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 183. PARTY ENGINE
- Anchor: 183-party-engine
- Depends on: ['181. REALITY PHYSICS ENGINE']
- Feeds into: ['185. REALITY FORTRESS ENGINE']
- Related: ['181. REALITY PHYSICS ENGINE', '185. REALITY FORTRESS ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 185. REALITY FORTRESS ENGINE
- Anchor: 185-reality-fortress-engine
- Depends on: ['183. PARTY ENGINE']
- Feeds into: ['187. CITY VOICE ENGINE']
- Related: ['183. PARTY ENGINE', '187. CITY VOICE ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 187. CITY VOICE ENGINE
- Anchor: 187-city-voice-engine
- Depends on: ['185. REALITY FORTRESS ENGINE']
- Feeds into: ['191. EPOCH ENGINE']
- Related: ['185. REALITY FORTRESS ENGINE', '191. EPOCH ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 191. EPOCH ENGINE
- Anchor: 191-epoch-engine
- Depends on: ['187. CITY VOICE ENGINE']
- Feeds into: ['195. LIVING ARTEFACT ENGINE']
- Related: ['187. CITY VOICE ENGINE', '195. LIVING ARTEFACT ENGINE', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## 195. LIVING ARTEFACT ENGINE
- Anchor: 195-living-artefact-engine
- Depends on: ['191. EPOCH ENGINE']
- Feeds into: ['END OF VERSION 4']
- Related: ['191. EPOCH ENGINE', 'END OF VERSION 4', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## END OF VERSION 4
- Anchor: end-of-version-4
- Depends on: ['195. LIVING ARTEFACT ENGINE']
- Feeds into: ['ARCHITECTGPT SYSTEM INDEX (AUTO-GENERATED PLACEHOLDER)']
- Related: ['195. LIVING ARTEFACT ENGINE', 'ARCHITECTGPT SYSTEM INDEX (AUTO-GENERATED PLACEHOLDER)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ARCHITECTGPT SYSTEM INDEX (AUTO-GENERATED PLACEHOLDER)
- Anchor: architectgpt-system-index-auto-generated-placeholder
- Depends on: ['END OF VERSION 4']
- Feeds into: ['ARCHITECTGPT MASTER INDEX (V6 BUILD)']
- Related: ['END OF VERSION 4', 'ARCHITECTGPT MASTER INDEX (V6 BUILD)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ARCHITECTGPT MASTER INDEX (V6 BUILD)
- Anchor: architectgpt-master-index-v6-build
- Depends on: ['ARCHITECTGPT SYSTEM INDEX (AUTO-GENERATED PLACEHOLDER)']
- Feeds into: ['ARCHITECTGPT INDEX (V7)']
- Related: ['ARCHITECTGPT SYSTEM INDEX (AUTO-GENERATED PLACEHOLDER)', 'ARCHITECTGPT INDEX (V7)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods']

## ARCHITECTGPT INDEX (V7)
- Anchor: architectgpt-index-v7
- Depends on: ['ARCHITECTGPT MASTER INDEX (V6 BUILD)']
- Feeds into: []
- Related: ['ARCHITECTGPT MASTER INDEX (V6 BUILD)', 'CORE SYSTEMS', '5. FACTIONS & TERRITORIES', 'Class E — Cultural & Historical Goods', 'DRIFT KING']

