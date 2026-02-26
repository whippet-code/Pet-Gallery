# 🚀 Quick Start Guide

## Get Your Pet Gallery Running in 4 Steps!

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

### Step 2: Set Up Voting Database

Create the SQLite database:
```bash
sqlite3 pet_gallery.db < database-setup-sqlite.sql
chmod 664 pet_gallery.db
```

Optionally, update email domains in `db-config.php`:
```php
define('ALLOWED_EMAIL_DOMAINS', [
    'yourcompany.com',
    'yourcompany.co.uk'
]);
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
- 🗳️ **Full Voting System** - Ranked voting with email validation
- 🎮 **Compact Voting Panel** - Fixed side panel that doesn't block gallery
- 🏆 **Live Leaderboard** - See results in real-time at `/leaderboard.php`
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
3. **Set up database**: Run the SQLite setup commands above
4. **Update email domains** in `db-config.php` to match your company
5. **Test voting flow**: Click "Start Voting", select 3 pets, submit
6. **Test on your phone** to ensure mobile responsiveness
7. **Check leaderboard**: Visit `/leaderboard.php` to see results
8. **Share and enjoy!** 🎉

## 🔍 Inspecting Votes

View who has voted:
```bash
sqlite3 pet_gallery.db "SELECT email, first_choice, second_choice, third_choice, created_at FROM votes;"
```

View leaderboard:
```bash
sqlite3 pet_gallery.db "SELECT * FROM leaderboard;"
```

Or download `pet_gallery.db` and open with [DB Browser for SQLite](https://sqlitebrowser.org/)

---

Made with 💖 for charity | Co-Authored-By: Oz <oz-agent@warp.dev>
