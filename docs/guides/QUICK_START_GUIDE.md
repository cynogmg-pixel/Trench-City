# 🚀 TRENCH CITY V2 - QUICK START GUIDE

**Version:** Alpha 1.0.0
**Status:** ✅ READY TO PLAY

---

## ⚡ 5-MINUTE SETUP

### Step 1: Install Database (2 minutes)

```bash
# Windows
install_alpha_systems.bat

# Linux/Mac
chmod +x install_alpha_systems.sh
./install_alpha_systems.sh
```

### Step 2: Configure .env (1 minute)

```env
DB_HOST=localhost
DB_NAME=trench_city
DB_USER=root
DB_PASS=your_password
APP_ENV=development
```

### Step 3: Start Server (1 minute)

```bash
cd public
php -S localhost:8000
```

### Step 4: Play! (1 minute)

```
http://localhost:8000
```

Register → Train → Crime → Fight → Win!

---

## 🎮 WHAT YOU CAN DO

### ⚡ Quick Actions
- 🏠 **Dashboard** - Overview of your character
- 💪 **Gym** - Train your stats (Strength, Speed, Defense, Dexterity)
- 🎭 **Crimes** - Commit crimes to earn cash
- ⚔️ **Combat** - Attack other players

### 💰 Economy
- 🏦 **Bank** - Deposit, withdraw, transfer money
- 🏪 **Market** - (Coming in Phase 2)
- 💼 **Jobs** - (Coming in Phase 2)

### 👥 Social
- 👤 **Profile** - View your stats and achievements
- 🌐 **Players** - Browse all players
- 📧 **Mail** - Send messages to other players
- 🏆 **Leaderboards** - See who's on top

---

## 📊 STARTING STATS

When you register, you get:

```
Level:     1
XP:        0
Cash:      £5,000
Bank:      £0

Stats:
- Strength:   10
- Speed:      10
- Defense:    10
- Dexterity:  10

Bars:
- Energy:  100/100
- Nerve:   15/15
- Happy:   100/100
- Life:    100/100
```

---

## 🎯 FIRST STEPS

### 1. Train Your Stats (1 minute)
- Go to **Gym**
- Click "Train Strength" (costs 5 Energy)
- Earn XP and increase Strength

### 2. Commit a Crime (1 minute)
- Go to **Crimes**
- Try "Pickpocket" (costs 1 Nerve)
- Earn £50-150 if successful

### 3. Save Your Money (30 seconds)
- Go to **Bank**
- Deposit £1,000
- Your money is now safe from attacks

### 4. Attack Someone (1 minute)
- Go to **Combat**
- Find a target near your level
- Click "Attack" (costs 10 Energy)
- Steal cash if you win!

### 5. Send a Message (30 seconds)
- Go to **Mail**
- Click "Compose"
- Send mail to another player

---

## 💡 PRO TIPS

### Efficient Progression
1. **Train when Energy is full** (100+)
2. **Crime when Nerve is full** (15+)
3. **Deposit cash regularly** (avoid losing it in fights)
4. **Attack when you have high stats** (better win rate)

### Resource Management
- Energy regenerates: 5 per 5 minutes
- Nerve regenerates: 1 per 5 minutes
- Happy degrades slowly
- Life only drops from combat

### Money Strategy
- Keep most cash in bank
- Only carry what you need for purchases
- Transfer fees are 1% (minimum £100)

### Combat Strategy
- Attack players with similar or lower stats
- Higher stats = better hit chance
- Energy cost: 10 per attack
- Steal 1-5% of target's cash on win

---

## 🗺️ NAVIGATION MAP

```
Dashboard (Home)
│
├── Quick Actions
│   ├── Gym (Train stats)
│   ├── Crimes (Earn cash)
│   └── Combat (Attack players)
│
├── Economy
│   ├── Bank (Manage money)
│   ├── Market (Coming soon)
│   └── Jobs (Coming soon)
│
├── Social
│   ├── Profile (Your stats)
│   ├── Players (Browse)
│   ├── Mail (Messages)
│   └── Leaderboards (Rankings)
│
└── System
    ├── Settings (Coming soon)
    └── Logout
```

---

## 📈 PROGRESSION PATH

### Level 1-5: Beginner
- Train at **Street Gym** (free)
- Commit **Petty Crimes** (Pickpocket, Shoplifting)
- Avoid combat (too weak)
- Save £5,000 for next gym

### Level 5-10: Intermediate
- Unlock **Underground Boxing Club** (£5,000)
- Commit **Theft Crimes** (Burglary, Car Theft)
- Start attacking similar-level players
- Save £25,000 for next gym

### Level 10-20: Advanced
- Unlock **Elite Fitness Center** (£25,000)
- Commit **Violence Crimes** (Armed Robbery, Assault)
- Attack weaker players for easy cash
- Save £150,000 for best gym

### Level 20+: Expert
- Unlock **Private Training Facility** (£150,000)
- Commit **Organized & Elite Crimes**
- Dominate leaderboards
- Send threatening mail to rivals

---

## ⚠️ IMPORTANT WARNINGS

### You Can Lose:
- ❌ **Cash on hand** (stolen in combat)
- ❌ **Energy** (used for training/combat)
- ❌ **Nerve** (used for crimes)

### You CANNOT Lose:
- ✅ **Bank balance** (safe from combat)
- ✅ **Stats** (permanent gains)
- ✅ **XP/Level** (permanent)
- ✅ **Items** (when system is added)

### Consequences:
- **Hospital:** 15-60 minutes (from losing combat)
- **Jail:** 30-60 minutes (from failed crimes)
- **Energy/Nerve:** Regenerates over time

---

## 🔧 TROUBLESHOOTING

### "Can't login"
- Check username/password
- Clear browser cookies
- Check database connection in .env

### "Page not loading"
- Make sure PHP server is running: `php -S localhost:8000`
- Check you're in /public directory
- Verify .env has correct database credentials

### "Database error"
- Run installation scripts
- Check MySQL is running: `mysql -u root -p`
- Verify database exists: `SHOW DATABASES;`

### "CSRF token invalid"
- Clear cookies and login again
- Check session.save_path is writable

---

## 📞 HELP & DOCUMENTATION

- **Full README:** See `ALPHA_RELEASE_README.md`
- **Implementation Details:** See `IMPLEMENTATION_REPORT.md`
- **Database Schema:** See `core/*.sql` files
- **Code Reference:** See `core/helpers.php` for functions

---

## 🎯 DAILY GAMEPLAY LOOP

```
1. Login
2. Check Mail (any messages?)
3. Train Stats (spend Energy)
4. Commit Crimes (spend Nerve)
5. Attack Rivals (spend Energy)
6. Deposit Cash (protect earnings)
7. Check Leaderboards (how's your rank?)
8. Send Mail (trash talk or diplomacy)
9. Logout
```

**Time Required:** 10-15 minutes per session

---

## 🏆 ACHIEVEMENT IDEAS (Unofficial)

Track your progress:
- [ ] Reach Level 10
- [ ] Earn £100,000
- [ ] Win 10 fights
- [ ] Unlock all 4 gyms
- [ ] Reach Top 10 on any leaderboard
- [ ] Send 50 mail messages
- [ ] Commit 100 successful crimes
- [ ] Steal £10,000 from combat
- [ ] Train 500 gym sessions
- [ ] Reach 1,000 total stats

---

## 💬 COMMUNITY TIPS

### Make Friends
- Send mail to top players
- Form alliances
- Share resources (transfers)
- Plan coordinated attacks

### Make Enemies
- Attack top leaderboard players
- Send taunting mail
- Steal from rich players
- Dominate your level bracket

### Get Rich
- Crime > Train > Bank > Repeat
- Attack players with high cash
- Keep bank balance high for leaderboards
- Unlock all gyms early

### Get Strong
- Train consistently every day
- Unlock better gyms ASAP
- Focus on one stat first (Strength recommended)
- Use Happy bonuses when training

---

## 🚀 READY TO PLAY!

**Everything you need is installed and ready.**

```
cd public
php -S localhost:8000
```

Then visit: **http://localhost:8000**

**Welcome to Trench City. Build your empire. Dominate the streets. Rise to the top.**

---

**Version:** Alpha 1.0.0
**Status:** ✅ PLAYABLE NOW
**Last Updated:** December 17, 2025

🎮 **ENJOY THE GAME!** 🎮
