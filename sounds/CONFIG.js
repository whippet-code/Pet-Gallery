// Sound Effect Configuration Guide for Pet Gallery
// ================================================

// QUICK START:
// ============
// 
// 1. Add your audio files to the /sounds directory:
//    - Rename to: card-select.mp3 (for pet card selection)
//    - Rename to: submit.mp3 (for deck submission)
//
// 2. The system will automatically use your files!
//    No code changes needed.
//
// 3. If files aren't found, the system falls back to
//    synthetic beeps generated with Web Audio API.

// SUPPORTED FORMATS:
// =================
// - MP3 (best browser compatibility)
// - WAV (high quality)
// - OGG (smaller file size)
// - WebM (modern browsers)

// FILE RECOMMENDATIONS:
// ====================

// Card Select Sound:
// - File: card-select.mp3
// - Duration: 200-400ms (short and snappy)
// - Type: Positive, playful chime or notification sound
// - Frequency: No specific requirement
// - Examples: 
//   * Card flip sound
//   * Coin pickup
//   * UI confirmation beep
//   * Positive notification chime

// Submission Sound:
// - File: submit.mp3
// - Duration: 300-800ms (celebratory length)
// - Type: Triumphant, celebratory, success fanfare
// - Examples:
//   * Victory fanfare
//   * Level complete jingle
//   * Success chime
//   * Triumphant trumpet sound

// FINDING SOUNDS:
// ==============
// 
// Free Resources:
// - freesound.org (Creative Commons)
// - zapsplat.com (free sound effects)
// - opengameart.com (game audio)
// - mixkit.co (free audio elements)
// 
// Search terms:
// - "card select" / "button click"
// - "success" / "victory" / "fanfare"
// - "positive" / "celebration" / "achievement"

// ADVANCED CUSTOMIZATION:
// =======================
// 
// If you want to modify the generated sounds, edit script.js:
//
// In the playCardSelectSound() method:
//   osc1.frequency.value = 554;  // Try: 440, 512, 659
//   osc1.type = 'sine';          // Try: 'sine', 'square', 'sawtooth'
//
// In the playSubmissionSound() method:
//   const notes = [523.25, 659.25, 783.99];  // Musical notes in Hz
//   // C5:523.25  D5:587.33  E5:659.25
//   // F5:698.46  G5:783.99  A5:880
//   // B5:987.77  C6:1046.50

// VOLUME LEVELS:
// ==============
//
// Current defaults:
// - Card Select: 0.3 (30%)  // Quiet so it doesn't startle
// - Submission: 0.25 (25%)  // Slightly quieter
//
// To modify, edit the playSound() method:
//   audio.volume = 0.3;  // Change to 0.1 (quiet) to 1.0 (loud)

// TESTING YOUR SOUNDS:
// ===================
// 
// 1. Open /sounds/card-select.html in browser
// 2. Click "Play Submission Sound" to test
// 3. Or simply use the Pet Gallery:
//    - Click a pet card to hear selection sound
//    - Submit votes to hear submission sound

// HOW IT WORKS UNDER THE HOOD:
// ============================
//
// 1. playSound('cardSelect') is called when:
//    - User clicks a pet card to add to their voting hand
//    - Located in: addPetToVote() function
//
// 2. playSound('submit') is called when:
//    - User successfully submits their complete 3-pet deck
//    - Located in: submitVotes() function
//
// 3. Playback Priority:
//    a) System tries to load 'sounds/cardSelect.mp3'
//    b) If file not found, falls back to Web Audio API synth
//    c) If Web Audio fails, silently continues (no error)

// TROUBLESHOOTING:
// ================
//
// Sounds not playing?
// 1. Check browser console (F12) for errors
// 2. Verify file names: card-select.mp3, submit.mp3
// 3. Verify files are in /sounds directory
// 4. Try the test page: /sounds/card-select.html
// 5. Ensure audio isn't muted in browser
// 6. Check CORS headers if hosting externally
// 7. Some mobile browsers need HTTPS
//
// Web Audio API not working?
// 1. Browser may need a click first to enable audio
// 2. Try opening settings (F12) → Check for audio errors
// 3. Some browsers limit audio context creation

// FUTURE ENHANCEMENTS:
// ===================
// 
// Potential additions to consider:
// - User settings to mute/unmute sounds
// - Volume slider control
// - Different sound themes/styles
// - Background music option
// - Hover sound effects (optional)
// - Payment/coin sounds
// - Celebration sound effects after voting
