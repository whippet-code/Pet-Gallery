# 🐾 Pet Gallery - Ultimate Pet Battle for Charity

A modern pet portrait gallery with Pokemon-style battle cards, smooth animations, and a slick SPA-like feel. Built for a Osborne Tech / Barnsley Hospice charity pet competition.

## ✨ Features

- **🎨 Modern Mobile Game Aesthetic** - Bold typography, vibrant gradients, and playful design
- **🎴 Trading Card Design** - Pokemon/card battler inspired modal cards with holographic effects
- **⚡ Smooth Animations** - Beautiful micro-interactions, view transitions, and tilt effects
- **📱 Fully Responsive** - Works beautifully on all devices
- **🔄 Auto-Updating Gallery** - Dynamically generates gallery from image folder
- **🎯 SPA Feel** - Smooth, app-like experience without page reloads
- **♿ Accessible** - Keyboard navigation (ESC to close modal)
- **🎊 Easter Egg** - Konami code for confetti effect! (↑↑↓↓←→←→BA)

## 🚀 Quick Start

### Requirements
- PHP 8.3+ (for local testing, any web server will work)
- Modern web browser

### Installation

1. **Clone or download** this project to your web server directory

2. **Add pet images** to the `pets/` folder:
   ```bash
   # Images should be named with the pet's name
   # Example: Barney.jpg, Fluffy.png, Max.jpg
   ```
   
   Supported formats: `.jpg`, `.jpeg`, `.png`, `.gif`, `.webp`

3. **Update voting URL** in `index.php` (line 4):
   ```php
   $votingUrl = 'https://your-actual-voting-page.com';
   ```

4. **Start a local server** (if testing locally):
   ```bash
   php -S localhost:8000
   ```

5. **Open in browser**: `http://localhost:8000`

## 📁 Project Structure

```
Pet-Gallery/
├── index.php       # Main gallery page with PHP logic
├── styles.css      # All styling, animations, and effects
├── script.js       # Interactive features and animations
├── pets/           # Place all pet images here
│   ├── Barney.jpg
│   ├── Fluffy.png
│   └── ...
└── README.md       # This file
```

## 🎨 Customisation

### Colors & Gradients
Edit CSS variables in `styles.css` (lines 1-14):
```css
:root {
    --primary: #ff6b6b;
    --secondary: #4ecdc4;
    --accent: #ffe66d;
    /* ... more colors */
}
```

### Typography
The project uses Google Fonts:
- **Poppins** (body text)
- **Space Grotesk** (headings)

Change fonts in `index.php` (line 45) and update CSS accordingly.

### Page Title & Text
Edit `index.php`:
- Line 41: Page title
- Lines 52-57: Main heading
- Line 57: Subtitle
- Line 155: Footer text

### Stats Display
Modify the stats shown in the modal card (`index.php`, lines 118-132):
- Change icons (💖, ⚡, ✨)
- Change stat names (Cuteness, Charm, Floof)
- Stats are randomised (80-100%) on each card open

## 🎯 How It Works

1. **PHP scans** the `pets/` folder for images
2. **Extracts pet names** from filenames (e.g., "Barney.jpg" → "Barney")
3. **Generates gallery** with all found images
4. **JavaScript handles** interactions:
   - Card hover effects with 3D tilt
   - Modal open/close animations
   - Stat bar animations
   - Confetti easter egg

## 🎭 Effects & Interactions

### Card Effects
- **Hover**: 3D tilt effect that follows mouse
- **Shine**: Holographic shine on hover
- **Scale**: Smooth zoom animation
- **Stagger**: Cards fade in with staggered timing

### Modal Effects
- **Card Flip**: Battle card flips in on open
- **Holographic**: Continuous holographic shimmer
- **Stats**: Animated progress bars with gradient
- **Vote Button**: Pulsing animation with hover scale

### Performance
- Lazy loading for images
- Intersection Observer for scroll animations
- CSS transforms for smooth 60fps animations
- Optimised hover effects

## 🌐 Deployment

### To Your Server
1. Upload all files via FTP/SFTP
2. Ensure `pets/` folder has write permissions (755)
3. Upload pet images to `pets/` folder
4. Navigate to your domain

### Nginx Configuration (Optional)
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### Apache Configuration
No special configuration needed - standard PHP setup works!

## 🎁 Pro Tips

- **Image Sizes**: Recommended 800x1000px or similar portrait ratio
- **File Naming**: Use descriptive names (they become the pet name displayed)
- **Performance**: For 50+ images, consider implementing pagination
- **Sound Effects**: Uncomment lines in `script.js` to add audio (you'll need to add sound files)

## 🐛 Troubleshooting

**Gallery not showing images:**
- Check `pets/` folder exists and has images
- Verify image file extensions are supported
- Check PHP has read permissions

**Animations not working:**
- Ensure JavaScript is enabled
- Check browser console for errors
- Try clearing browser cache

**Modal not opening:**
- Check browser console for JavaScript errors
- Verify all files are loaded correctly

## 📝 License

Free to use for charity projects! 💖

## 🙏 Credits

Built with love for our furry friends and charity!

Co-Authored-By: Oz <oz-agent@warp.dev>
