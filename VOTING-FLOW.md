# 🎮 Voting Flow Guide

## User Journey

### Step 1: Browse Pets 🐾
- User lands on the page and sees the pet gallery
- They can scroll through all pets and click to view details in modal
- **No voting panel visible yet** - just pure browsing experience

### Step 2: Start Voting 🗳️
- User clicks the **"Start Voting"** button in the header
- Voting panel slides in from the top with animation
- Notification appears: "Click on 3 pet cards to build your voting hand! 🎲"
- Start Voting button disappears

### Step 3: Select Pets (Build Your Hand) 🎴
User clicks on pet cards to select them:

**1st Click**: Pet goes to **1st Place Slot** (🥇 3 Points)
- Card gets a gold badge overlay
- Pet image appears in the 1st place slot

**2nd Click**: Next pet goes to **2nd Place Slot** (🥈 2 Points)
- Card gets a silver badge overlay
- Pet image appears in the 2nd place slot

**3rd Click**: Final pet goes to **3rd Place Slot** (🥉 3rd Place)
- Card gets a bronze badge overlay
- Pet image appears in the 3rd place slot
- Email field slides in with animation

### Step 4: Enter Email 📧
- Email input field appears after 3 selections
- User enters their company email
- Placeholder shows: "name@osbornetech.co.uk"
- Submit button becomes enabled

### Step 5: Submit Vote ⚡
- User clicks **"Submit Your Votes"**
- Backend validates:
  - ✅ Valid email format
  - ✅ Correct company domain
  - ✅ Email hasn't voted before
  - ✅ All 3 pets are different
- Success: Confetti animation! 🎉
- Success message: "Your vote has been recorded! Thank you for participating! 🎉"

### Step 6: View Results 🏆
- Click **"View Leaderboard"** at any time
- See rankings with:
  - Current position (🥇🥈🥉)
  - Pet images
  - Total points
  - Vote breakdown (1st/2nd/3rd counts)

## Key Interactions

### Card Click Behavior

**Before Voting Starts:**
- Click card → Opens modal to view pet details
- Modal message: "What an adorable contestant! Click 'Start Voting' to begin selecting your favorites!"

**During Voting:**
- Click unselected card → Adds to next available slot
- Click selected card → Opens modal showing current placement
- Modal message: "{Pet Name} is already in your {placement}!"

### Remove/Change Selections
- Each filled slot has an **× button** in the top-right corner
- Click × to remove that pet from the slot
- Badge disappears from the card
- Can then select a different pet

### Clear All
- Click **"Clear Selections"** button at bottom of voting panel
- Removes all 3 selections at once
- Resets the voting panel to empty state

## Visual Feedback

### Cards
- **Default**: Subtle glow, tilt on hover
- **Selected**: Pink border glow, badge overlay (🥇/🥈/🥉)
- **Hover**: 3D tilt effect, shine animation

### Voting Slots
- **Empty**: Dashed border, placeholder text
- **Filled**: Solid border, pet image, name, points
- **Animation**: Card flip effect when filled

### Notifications
- **Success** (Green): ✅ Vote submitted, pet added
- **Error** (Red): ❌ Duplicate vote, invalid email
- **Warning** (Yellow): ⚠️ Already selected 3 pets
- **Info** (Blue): ℹ️ Instructions, pet removed

## Technical Notes

### State Management
- `votingActive` = false → Browse mode (cards open modal)
- `votingActive` = true → Selection mode (cards add to slots)

### Animation Sequence
1. **Panel appears**: fadeInScale (0.6s)
2. **Scroll**: Smooth scroll to panel
3. **Card selection**: badgePop animation
4. **Slot fill**: slotFill with card flip (0.4s)
5. **Email reveal**: fadeInUp (0.5s)
6. **Success**: Confetti explosion!

### Responsive Design
- **Desktop**: 3 slots in a row
- **Tablet**: 3 slots in a row (smaller)
- **Mobile**: Stacked vertically (1 column)

## Error Handling

### User Tries To:
- **Select 4th pet**: Notification warns to clear selections
- **Submit without email**: Error notification
- **Submit invalid email**: Error notification
- **Submit wrong domain**: "Only osbornetech.co.uk emails allowed"
- **Vote twice**: "This email has already voted"
- **Select same pet twice**: Prevented by backend validation

## Tips for Users

💡 **Browse first**: Look at all pets before starting to vote
💡 **Order matters**: Choose carefully - 1st place is worth 3 points!
💡 **Remove mistakes**: Click the × on any slot to change your mind
💡 **One vote only**: Make it count - you can't change after submitting!
💡 **Share results**: Check the leaderboard to see who's winning!

## Admin Features

### Leaderboard
- Auto-calculates from database view
- Sorts by total points DESC
- Ties broken by 1st place count
- Real-time updates (refresh page)

### Database Tracking
- Stores all votes with timestamp
- Logs IP and user agent
- Email uniqueness enforced
- Full vote breakdown available
