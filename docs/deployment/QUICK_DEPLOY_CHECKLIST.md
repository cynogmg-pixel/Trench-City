# ⚡ QUICK DEPLOY CHECKLIST

## 🎯 3-Minute Deployment

### Step 1: Upload Files (30 seconds)
```bash
# CSS file
/var/www/trench_city/assets/css/landing-cinematic.css

# New landing page
/var/www/trench_city/public/index_cinematic.php
```

### Step 2: Test New Page (1 minute)
```
Visit: https://www.trenchmade.co.uk/index_cinematic.php
```

**Check:**
- [ ] Page loads without errors
- [ ] Navigation shows (logo + 2 buttons)
- [ ] Hero text is readable
- [ ] CTA buttons are gold
- [ ] Stat cards appear in grid
- [ ] Feature cards load
- [ ] Live world panel displays
- [ ] Footer shows

### Step 3: Deploy to Production (30 seconds)
```bash
# Backup old version
mv /var/www/trench_city/public/index.php /var/www/trench_city/public/index_old.php

# Activate new version
mv /var/www/trench_city/public/index_cinematic.php /var/www/trench_city/public/index.php
```

### Step 4: Add Background Image (1 minute)
```bash
# Upload London skyline image
/var/www/trench_city/assets/imgs/london-skyline.jpg

# Image should be:
# - 1920x1080px or larger
# - Dark/night scene
# - JPG format, <500KB
# - Big Ben or Westminster visible
```

**Done!** ✅

---

## 🔥 OPTIONAL ENHANCEMENTS

### A. Minify CSS (Performance)
```bash
# Install cssnano (if not installed)
npm install -g cssnano-cli

# Minify
cssnano /var/www/trench_city/assets/css/landing-cinematic.css > /var/www/trench_city/assets/css/landing-cinematic.min.css

# Update HTML <link> to use .min.css
```

**Benefit:** ~40% smaller file size

---

### B. Add Real Player Count (Dynamic)
In `index.php`, replace static numbers:

```php
<?php
// At top of file
$db = getDB();
$playerCount = $db->query("SELECT COUNT(*) FROM users WHERE status='active'")->fetchColumn();
$familyCount = $db->query("SELECT COUNT(DISTINCT family_id) FROM users WHERE family_id IS NOT NULL")->fetchColumn();
?>

<!-- In HTML -->
<div class="landing-stat-value"><?= number_format($playerCount) ?></div>
<div class="landing-stat-value"><?= number_format($familyCount) ?></div>
```

**Benefit:** Real-time accuracy

---

### C. WebP Background Image (Performance)
```bash
# Convert to WebP (better compression)
cwebp -q 85 london-skyline.jpg -o london-skyline.webp

# Update CSS with fallback:
.landing-hero {
    background:
        linear-gradient(...),
        url('/assets/imgs/london-skyline.webp') center/cover;
}

/* Fallback for old browsers */
.no-webp .landing-hero {
    background-image: url('/assets/imgs/london-skyline.jpg');
}
```

**Benefit:** 30-50% smaller image

---

### D. Add Favicon
```bash
# Generate favicons (use https://realfavicongenerator.net/)
# Upload to /assets/imgs/
favicon.ico
favicon-16x16.png
favicon-32x32.png
apple-touch-icon.png
```

Add to `<head>`:
```html
<link rel="icon" type="image/x-icon" href="/assets/imgs/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/imgs/favicon-32x32.png">
<link rel="apple-touch-icon" href="/assets/imgs/apple-touch-icon.png">
```

---

## 🧪 TESTING CHECKLIST

### Browser Testing
- [ ] Chrome (desktop)
- [ ] Firefox (desktop)
- [ ] Safari (macOS)
- [ ] Safari (iOS)
- [ ] Chrome (Android)

### Responsive Testing
- [ ] Desktop (1920px)
- [ ] Laptop (1366px)
- [ ] Tablet (768px)
- [ ] Mobile (375px)

### Feature Testing
- [ ] Navigation links work
- [ ] Login button → `/login.php`
- [ ] Register button → `/register.php`
- [ ] Scroll is smooth
- [ ] Animations play on load
- [ ] Cards glow on hover
- [ ] Buttons lift on hover
- [ ] Mobile menu works

### Performance Testing
```bash
# Google PageSpeed Insights
https://pagespeed.web.dev/
# Enter: https://www.trenchmade.co.uk/

# Target Scores:
# Desktop: 90+
# Mobile: 80+
```

---

## 🐛 COMMON ISSUES

### Issue: Background image doesn't show
**Solution:** Check file path
```css
/* Make sure path is correct */
url('/assets/imgs/london-skyline.jpg')

/* Not relative path */
url('../imgs/london-skyline.jpg')  ❌
```

### Issue: Glassmorphism not working (no blur)
**Solution:** Check browser support
```css
/* Add -webkit- prefix for Safari */
backdrop-filter: blur(20px);
-webkit-backdrop-filter: blur(20px);
```

### Issue: Animations don't play
**Solution:** Hard refresh browser
```
Ctrl+Shift+R (Windows)
Cmd+Shift+R (Mac)
```

### Issue: Gold color looks different
**Solution:** Check color profile
```css
/* Ensure exact hex values */
#D4AF37  /* Rich gold */
#F5C451  /* Bright gold */
#C5A028  /* Dark gold */
```

### Issue: Mobile buttons stacked weird
**Solution:** Already handled in CSS
```css
@media (max-width: 768px) {
    .landing-cta-group { flex-direction: column; }
}
```

---

## 📊 SUCCESS METRICS

### Before Launch
```
Bounce Rate:     65% (expected for plain page)
Avg Session:     30s
Registrations:   Low conversion
```

### After Launch (Target)
```
Bounce Rate:     <45% (engaged visitors)
Avg Session:     2+ minutes (exploring features)
Registrations:   +40% conversion improvement
```

### Track with Google Analytics
```html
<!-- Add to <head> -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-XXXXXXXXXX');
</script>
```

---

## 🎉 DEPLOYMENT DONE!

### Verify Live
1. Visit: `https://www.trenchmade.co.uk/`
2. Should see cinematic hero with "Build Your Criminal Empire"
3. Gold buttons should glow on hover
4. Stat cards should show 4-column grid
5. Footer should show links

### Rollback (If Needed)
```bash
# Restore old version
mv /var/www/trench_city/public/index.php /var/www/trench_city/public/index_new.php
mv /var/www/trench_city/public/index_old.php /var/www/trench_city/public/index.php
```

---

## 📞 NEXT STEPS

### Immediate (Week 1)
- [ ] Add London skyline background
- [ ] Test on all devices
- [ ] Share with beta testers
- [ ] Monitor analytics

### Short-term (Week 2-4)
- [ ] Implement real player stats
- [ ] Add favicon set
- [ ] Optimize images (WebP)
- [ ] Setup Google Analytics
- [ ] A/B test CTA copy

### Long-term (Month 2+)
- [ ] Add gameplay trailer video
- [ ] Create animated logo
- [ ] Implement lazy loading
- [ ] Add Discord widget
- [ ] Setup service worker (PWA)

---

**🚀 Your dark luxury crime MMO landing page is LIVE!**

**The streets of Trench City are now open for business.** 🏴‍☠️

