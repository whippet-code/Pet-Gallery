# 🚀 Quick Start Guide

## Get Your Pet Gallery Running in 3 Steps!

### Step 1: Add Your Pet Images
```bash
# Put your pet images in the pets/ folder
# Name them like: Barney.jpg, Fluffy.png, etc.
# The filename becomes the pet's display name!
```

**Remove demo images first:**
```bash
rm pets/*.jpg
```

Then add your real pet photos to the `pets/` folder.

### Step 2: Update the Voting URL
Open `index.php` and change line 4:
```php
$votingUrl = 'https://your-actual-voting-page.com';
```

### Step 3: Launch the Gallery

**For local testing:**
```bash
php -S localhost:8000
```
Then open: http://localhost:8000

**For production server:**
Just upload all files to your web server via FTP/SFTP.

---

## 🎯 That's It!

Your gallery is now live! 

### What You Get:
- ✨ Automatic gallery generation from your `pets/` folder
- 🎴 Pokemon-style cards with holographic effects
- 📱 Mobile responsive design
- ⚡ Smooth animations and transitions
- 🎊 Built-in confetti easter egg (try: ↑↑↓↓←→←→BA)

### Need Help?
Check the full `README.md` for customization options and troubleshooting.

---

## 📝 Quick Customization

### Change Colors
Edit `styles.css` lines 1-14 to modify the color scheme.

### Change Title
Edit `index.php` line 54 to change "PET BATTLE" text.

### Change Stats
Edit `index.php` lines 118-132 to customize the stats shown in the modal (Cuteness, Charm, Floof).

---

## ⚠️ Before Going Live

1. **Remove demo images**: `rm pets/*.jpg`
2. **Add real pet photos** to `pets/` folder
3. **Update voting URL** in `index.php`
4. **Test on your phone** to ensure mobile responsiveness
5. **Share and enjoy!** 🎉

---

Made with 💖 for charity | Co-Authored-By: Oz <oz-agent@warp.dev>
