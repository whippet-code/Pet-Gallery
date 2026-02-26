# 🗳️ Pet Gallery Voting System Setup Guide

This guide will help you set up the voting system for your Pet Gallery competition.

## 📋 Prerequisites

- PHP 8.0+ with PDO SQLite extension (included by default)
- Web server (Apache, Nginx, or PHP's built-in server for testing)
- SQLite 3 (for command-line inspection, optional)

## 🚀 Quick Setup

### 1. Create Database

Run the SQLite schema to create the database:

```bash
sqlite3 pet_gallery.db < database-setup-sqlite.sql
```

This creates a `pet_gallery.db` file with all necessary tables and views.

### 2. Set Permissions

Make sure the database file is writable by the web server:

```bash
chmod 664 pet_gallery.db
chmod 775 .  # Directory must be writable for SQLite lock files
```

### 3. Configure Email Domains (Optional)

Edit `db-config.php` to update allowed email domains:

```php
define('ALLOWED_EMAIL_DOMAINS', [
    'osbornetech.co.uk',
    'osbornetechnologies.co.uk'
]);
```

### 4. Test the Setup

Start the PHP development server:

```bash
php -S localhost:8000
```

Visit `http://localhost:8000` and you should see the voting interface!

## 🎮 How It Works

### User Flow

1. **Browse Pets**: Users scroll through the pet gallery
2. **Select Top 3**: Click on pet cards to add them to voting slots (1st, 2nd, 3rd place)
3. **Enter Email**: After selecting 3 pets, an email field appears
4. **Submit Vote**: Submit with a company email address
5. **Confirmation**: Get a success message with confetti! 🎉

### Voting System

- **Points**: 3 points for 1st place, 2 points for 2nd place, 1 point for 3rd place
- **One Vote Per Email**: Each email address can only vote once
- **Company Domain**: Only emails from your specified domain are accepted
- **Duplicate Prevention**: Database ensures unique email addresses

### View Results

Visit `/leaderboard.php` to see:
- Current rankings sorted by total points
- Vote breakdown (1st, 2nd, 3rd place votes)
- Total number of votes cast

## 🗂️ File Structure

```
Pet-Gallery/
├── index.php              # Main gallery with voting interface
├── script.js              # Voting logic and UI interactions
├── styles.css             # All styling including voting panel
├── vote-submit.php        # Backend vote processing
├── leaderboard.php        # Results display page
├── db-config.php          # Database configuration
├── database-setup.sql     # Database schema
├── pets/                  # Pet images folder
└── VOTING-SETUP.md        # This file
```

## 🔧 Configuration Options

### Email Domain Validation

To change the allowed email domain, edit `db-config.php`:

```php
define('ALLOWED_EMAIL_DOMAIN', 'yourcompany.com');
```

### Points System

To modify the points system, edit:
1. `database-setup.sql` - Update the view query
2. `vote-submit.php` - Update validation messages if needed
3. Vote slot UI in `index.php` - Update displayed point values

## 🎨 Customization

### Voting Panel Styling

The voting panel is styled in `styles.css` starting at line 597. Key classes:
- `.voting-panel` - Main container (sticky positioning)
- `.voting-slots` - Grid layout for vote slots
- `.slot-content` - Individual slot styling
- `.vote-submit-btn` - Submit button

### Notifications

Customize notification appearance in `styles.css` starting at line 903. Four types:
- `notification-success` (green)
- `notification-error` (red)
- `notification-warning` (yellow)
- `notification-info` (blue)

## 🐛 Troubleshooting

### Votes Not Submitting

1. **Check Database File**: Verify `pet_gallery.db` exists and is writable
2. **Check Permissions**: Run `ls -l pet_gallery.db` to verify permissions (should be 664)
3. **Check Browser Console**: Open DevTools and look for JavaScript errors
4. **Check PHP Errors**: Look in your PHP error log
5. **Test Connection**: Run `php -r "require 'db-config.php'; getDbConnection();"`

### Leaderboard Not Showing Results

1. **Verify Database View**: Run `sqlite3 pet_gallery.db ".schema leaderboard"`
2. **Check Votes**: Run `sqlite3 pet_gallery.db "SELECT COUNT(*) FROM votes;"`
3. **Test View**: Run `sqlite3 pet_gallery.db "SELECT * FROM leaderboard;"`

### Email Domain Rejection

1. **Check Domain Setting**: Verify `ALLOWED_EMAIL_DOMAINS` array in `db-config.php`
2. **Case Sensitivity**: Domain comparison is case-insensitive
3. **Subdomains**: Currently exact match only (e.g., `mail.company.com` ≠ `company.com`)

### Database File Permissions

1. **File Not Writable**: Run `chmod 664 pet_gallery.db`
2. **Directory Not Writable**: Run `chmod 775 .` (SQLite needs to create lock files)
3. **Web Server User**: Ensure web server user (www-data, apache, nginx) can write to file

### CSS/JS Not Loading

1. **Check File Paths**: Ensure `styles.css` and `script.js` are in the same directory as `index.php`
2. **Clear Browser Cache**: Force refresh with Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)
3. **Check File Permissions**: Ensure web server can read the files

## 🔒 Security Notes

- Email addresses are stored but kept secure
- IP addresses and user agents are logged for fraud prevention
- SQL injection protection via prepared statements
- XSS protection via `htmlspecialchars()`
- Input validation on both client and server side

## 🔍 Inspecting the Database

### Command Line

View all votes:
```bash
sqlite3 pet_gallery.db "SELECT * FROM votes;"
```

View leaderboard:
```bash
sqlite3 pet_gallery.db "SELECT * FROM leaderboard;"
```

Count total votes:
```bash
sqlite3 pet_gallery.db "SELECT COUNT(*) FROM votes;"
```

Interactive mode:
```bash
sqlite3 pet_gallery.db
# Then use SQL commands:
# .tables - list tables
# .schema votes - show table structure
# SELECT * FROM votes; - view data
# .quit - exit
```

### GUI Tools

Download the `pet_gallery.db` file and open with:

1. **[DB Browser for SQLite](https://sqlitebrowser.org/)** (Free, recommended)
   - Drag and drop the .db file
   - Browse data, run queries, export to CSV

2. **[TablePlus](https://tableplus.com/)** (Beautiful UI)
   - File → Open → Select pet_gallery.db
   - Great for quick inspection

3. **[SQLiteStudio](https://sqlitestudio.pl/)** (Free, cross-platform)
   - Full-featured database manager

4. **Online Viewers**
   - [sqliteviewer.app](https://sqliteviewer.app/) - Upload and view in browser

### Export Votes

Export to CSV:
```bash
sqlite3 pet_gallery.db <<EOF
.headers on
.mode csv
.output votes_export.csv
SELECT * FROM votes;
.quit
EOF
```

Export to JSON:
```bash
sqlite3 pet_gallery.db <<EOF
.mode json
.output votes_export.json
SELECT * FROM votes;
.quit
EOF
```

## 📊 Database Schema

### `votes` Table

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key |
| email | VARCHAR(255) | Unique voter email |
| first_choice | VARCHAR(255) | 1st place pet name |
| second_choice | VARCHAR(255) | 2nd place pet name |
| third_choice | VARCHAR(255) | 3rd place pet name |
| created_at | TIMESTAMP | Vote timestamp |
| ip_address | VARCHAR(45) | Voter IP (optional) |
| user_agent | TEXT | Browser info (optional) |

### `leaderboard` View

Automatically calculates:
- `pet_name` - Pet's name
- `total_points` - Sum of all points
- `first_place_votes` - Count of 1st place votes
- `second_place_votes` - Count of 2nd place votes
- `third_place_votes` - Count of 3rd place votes
- `total_votes` - Total number of votes received

## 🎯 Testing Checklist

- [ ] Database connection works
- [ ] Can browse pet gallery
- [ ] Can select 3 different pets
- [ ] Email field appears after 3 selections
- [ ] Invalid email shows error
- [ ] Wrong domain shows error
- [ ] Successful vote shows confirmation
- [ ] Cannot vote twice with same email
- [ ] Leaderboard displays correctly
- [ ] Mobile responsive design works

## 💡 Tips

1. **Test with Multiple Browsers**: Check Firefox, Chrome, Safari, and mobile browsers
2. **Use Real Email Addresses**: During testing, use actual company emails to verify domain validation
3. **Monitor Database**: Watch the votes table to ensure data is being stored correctly
4. **Backup Before Launch**: Export your database before going live
5. **Set Up Error Logging**: Configure PHP error logging to catch issues in production

## 📞 Support

If you encounter issues:
1. Check the browser console for JavaScript errors
2. Check PHP error logs for server-side issues
3. Verify database connection and permissions
4. Test with a simple vote to isolate the problem

## 🎉 Launch!

Once everything is tested and working:
1. Update `ALLOWED_EMAIL_DOMAIN` with your actual domain
2. Deploy to your production server
3. Share the link with your team
4. Monitor the leaderboard for results!

Good luck with your pet competition! 🐾
