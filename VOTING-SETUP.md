# 🗳️ Pet Gallery Voting System Setup Guide

This guide will help you set up the voting system for your Pet Gallery competition.

## 📋 Prerequisites

- PHP 8.0+ with PDO MySQL extension
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache, Nginx, or PHP's built-in server for testing)

## 🚀 Quick Setup

### 1. Database Configuration

First, create a MySQL database for the project:

```sql
CREATE DATABASE pet_gallery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Configure Database Connection

Edit `db-config.php` and update these values:

```php
define('DB_HOST', 'localhost');          // Your database host
define('DB_NAME', 'pet_gallery');        // Your database name
define('DB_USER', 'your_username');      // Your database username
define('DB_PASS', 'your_password');      // Your database password

// Set your company email domain
define('ALLOWED_EMAIL_DOMAIN', 'osbornetech.co.uk');
```

### 3. Import Database Schema

Run the SQL schema to create tables and views:

```bash
mysql -u your_username -p pet_gallery < database-setup.sql
```

Or manually execute the SQL in `database-setup.sql` through phpMyAdmin or MySQL Workbench.

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

1. **Check Database Connection**: Verify credentials in `db-config.php`
2. **Check Browser Console**: Open DevTools and look for JavaScript errors
3. **Check PHP Errors**: Look in your PHP error log
4. **Test vote-submit.php**: Navigate directly to see any PHP errors

### Leaderboard Not Showing Results

1. **Verify Database View**: Check that the `leaderboard` view was created
2. **Check Permissions**: Ensure database user has SELECT permissions
3. **Test Query**: Run the view query directly in MySQL

### Email Domain Rejection

1. **Check Domain Setting**: Verify `ALLOWED_EMAIL_DOMAIN` in `db-config.php`
2. **Case Sensitivity**: Domain comparison is case-insensitive
3. **Subdomains**: Currently exact match only (e.g., `mail.company.com` ≠ `company.com`)

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
