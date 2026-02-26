# 🔄 Migration Notes - MySQL to SQLite

## Summary

Successfully migrated the Pet Gallery voting system from MySQL to SQLite, and redesigned the voting panel UI for better usability.

## Changes Made

### Database Migration (MySQL → SQLite)

**Removed:**
- `database-setup.sql` (MySQL schema)
- MySQL service dependency
- MySQL configuration requirements

**Added:**
- `database-setup-sqlite.sql` (SQLite schema)
- `pet_gallery.db` (SQLite database file)

**Updated:**
- `db-config.php` - Changed from MySQL PDO to SQLite PDO
- `db-config.example.php` - Updated template for SQLite
- `.gitignore` - Added SQLite database files

### Why SQLite?

✅ **Zero Configuration** - No database server needed
✅ **Single File** - Easy to backup and inspect
✅ **Portable** - Move between environments easily
✅ **Built-in PHP Support** - PDO SQLite included by default
✅ **Perfect Scale** - Handles hundreds of concurrent reads easily
✅ **Easy Inspection** - Download .db file and open with GUI tools

### UI Redesign - Compact Voting Panel

**Problem:** Original voting panel was full-width and obscured the pet gallery, making it impossible to select pets.

**Solution:** Redesigned as a compact, fixed-position side panel.

#### Desktop View
- **Position:** Fixed to right side (380px wide)
- **Layout:** Horizontal slots (badge + thumbnail + name + points)
- **Visibility:** Doesn't block pet gallery
- **Scrollable:** Custom scrollbar if content overflows

#### Mobile View
- **Position:** Fixed to top, full width
- **Compact:** Smaller fonts, tighter spacing (40px thumbnails)
- **Still accessible:** Doesn't take over entire screen

#### Slot Layout Changes
**Before:** Vertical cards with large images (3/4 aspect ratio)
**After:** Horizontal rows with small thumbnails (50px × 50px)

**Layout:** `🥇 Badge → 🖼️ Thumbnail → Pet Name → 3 Points`

### Multiple Email Domain Support

**Added support for multiple company domains:**
```php
define('ALLOWED_EMAIL_DOMAINS', [
    'osbornetech.co.uk',
    'osbornetechnologies.co.uk'
]);
```

### Auto-Close Voting Panel

**After successful vote submission:**
1. Success message + confetti 🎉
2. Wait 2 seconds
3. Voting panel fades out
4. "Start Voting" button reappears
5. Smooth scroll to top

## Database Schema Differences

### MySQL vs SQLite Syntax

**Auto-increment:**
- MySQL: `AUTO_INCREMENT`
- SQLite: `AUTOINCREMENT`

**Data Types:**
- MySQL: `VARCHAR(255)`, `TIMESTAMP`
- SQLite: `TEXT`, `DATETIME`

**View Creation:**
- MySQL: `CREATE OR REPLACE VIEW`
- SQLite: `CREATE VIEW IF NOT EXISTS`

## Files Structure

### Current Files
```
Pet-Gallery/
├── database-setup-sqlite.sql  # SQLite schema
├── pet_gallery.db             # SQLite database file
├── db-config.php              # SQLite configuration
├── db-config.example.php      # SQLite template
├── vote-submit.php            # Backend (no changes needed)
├── leaderboard.php            # Results page (no changes needed)
├── index.php                  # Main page with compact panel
├── script.js                  # Updated voting logic
├── styles.css                 # Redesigned panel styles
└── pets/                      # Pet images
```

### Removed Files
- `database-setup.sql` (old MySQL schema)

## Deployment Changes

### Before (MySQL)
1. Upload files
2. Create MySQL database on server
3. Import schema via phpMyAdmin
4. Configure database credentials
5. Ensure MySQL service running

### After (SQLite)
1. Upload files (including pet_gallery.db)
2. Set file permissions: `chmod 664 pet_gallery.db`
3. Ensure directory is writable: `chmod 775 .`
4. Done! ✅

## Inspecting Data

### Command Line
```bash
# View all votes
sqlite3 pet_gallery.db "SELECT * FROM votes;"

# View leaderboard
sqlite3 pet_gallery.db "SELECT * FROM leaderboard;"

# Count votes
sqlite3 pet_gallery.db "SELECT COUNT(*) FROM votes;"

# Export to CSV
sqlite3 pet_gallery.db <<EOF
.headers on
.mode csv
.output votes.csv
SELECT * FROM votes;
.quit
EOF
```

### GUI Tools
- **[DB Browser for SQLite](https://sqlitebrowser.org/)** (Free, recommended)
- **[TablePlus](https://tableplus.com/)** (Beautiful UI)
- **[SQLiteStudio](https://sqlitestudio.pl/)** (Free, cross-platform)

## Testing Checklist

- [x] Database created successfully
- [x] Voting panel displays correctly
- [x] Pets are not obscured by panel
- [x] Can select 3 pets
- [x] Email validation works
- [x] Multiple domains accepted
- [x] Votes stored in SQLite
- [x] Leaderboard displays correctly
- [x] Panel auto-closes after submission
- [x] Mobile responsive
- [x] Can inspect database

## Performance Notes

### SQLite Performance
- **Read Performance:** Excellent (1000s of reads/sec)
- **Write Performance:** Good for this use case (sequential writes)
- **Concurrency:** Perfect for < 500 simultaneous voters
- **Database Size:** Minimal (~100KB for 500 votes)

### When to Consider MySQL
- 1000+ simultaneous write operations
- Complex multi-table joins and transactions
- Need for replication/clustering
- Enterprise-level requirements

For this charity pet competition, SQLite is perfect! 🎯

## Backup Strategy

### Simple Backup
```bash
# Copy database file
cp pet_gallery.db pet_gallery_backup_$(date +%Y%m%d).db
```

### Automated Backup (Cron)
```bash
# Add to crontab: backup daily at 2am
0 2 * * * cp /path/to/pet_gallery.db /path/to/backups/pet_gallery_$(date +\%Y\%m\%d).db
```

## Rollback Plan

If needed, can always migrate back to MySQL:
1. Export SQLite data to CSV
2. Create MySQL database
3. Import CSV into MySQL
4. Revert `db-config.php` changes
5. Use old MySQL schema

But you won't need to - SQLite works great! 🚀

---

**Migration Date:** 2026-02-26
**Version:** SQLite + Compact UI v1.0
**Status:** ✅ Complete and Tested
