# Pet Gallery Sound Effects

This directory contains configuration and resources for sound effects in the Pet Gallery voting system.

## Current Sound Effects

The application includes two sound effects:

### 1. **Card Selection Sound** (`cardSelect`)
- **When it plays**: When a user selects a pet card to add to their voting hand
- **Default behavior**: A pleasant two-note chime (C#5 → A4) generated using Web Audio API
- **Duration**: ~300ms
- **Volume**: 30%

### 2. **Submission Sound** (`submit`)
- **When it plays**: When a user successfully submits their complete voting deck
- **Default behavior**: A triumphant ascending chord (C5 → E5 → G5) generated using Web Audio API
- **Duration**: ~300ms per note (total ~500ms)
- **Volume**: 25%

## Using Custom Audio Files

The system is designed to work with custom MP3, WAV, or OGG audio files. To use your own sounds:

1. **Place your audio files** in this directory with these filenames:
   - `card-select.mp3` (or `.wav`, `.ogg`)
   - `submit.mp3` (or `.wav`, `.ogg`)

2. **The system will automatically**:
   - Try to play your custom audio file first
   - Fall back to generated Web Audio API sounds if files aren't found

## Example: Finding/Creating Sound Effects

Here are some suggestions for finding appropriate sounds:

### Free Sound Resources:
- **Freesound.org** - Creative Commons licensed sounds
  - Search: "card select" or "button click" for selection sounds
  - Search: "success" or "victory" for submission sounds
- **Zapsplat.com** - Free sound effects
- **Open Game Art** - Free game audio
- **Mixkit** - Free audio elements

### Recommended Sound Characteristics:

#### Card Selection Sound:
- Short, playful chime or beep
- 200-400ms duration
- Uplifting tone (not warning/error sound)
- Examples: coin pickup, positive notification, card flip

#### Submission Sound:
- Triumphant or celebratory
- 300-800ms duration  
- Ascending progression (suggests completion/success)
- Examples: victory fanfare, level complete, success chime

## Technical Details

### How It Works:

1. **JavaScript Sound System** (in `script.js`):
   ```javascript
   playSound(type)           // Main method to play sounds
   initAudioContext()        // Initialize Web Audio API context
   playSynthSound(type)      // Generate sounds using Web Audio API
   playCardSelectSound()     // Implementation for card selection
   playSubmissionSound()     // Implementation for submission
   ```

2. **Audio Playback Priority**:
   - First: Try to load and play `sounds/{type}.mp3`
   - Fallback: Use Web Audio API to generate synth sounds
   - Error handling: Gracefully fails if audio context isn't available

3. **Browser Support**:
   - Modern browsers: Chrome, Firefox, Safari, Edge
   - Uses Web Audio API (widely supported)
   - Fallback for older browsers included

## Implementation Details

### Sound Effects Are Triggered In:

1. **`addPetToVote()` function**:
   - Called when user clicks a pet card to select it
   - Plays the `cardSelect` sound

2. **`submitVotes()` function**:
   - Called when user submits their complete deck
   - Plays the `submit` sound on successful submission

### Audio Context Management:
- Audio context is created lazily (on first sound play)
- Shared across the application (single context instance)
- Automatically resumes if suspended by browser

## Testing Sounds

You can test the generated sounds using the included test page:

1. Open `sounds/card-select.html` in a web browser
2. Click the buttons to hear the sounds

## Customization Guide

### Modifying Generated Sounds:

Edit `script.js` in the `playCardSelectSound()` and `playSubmissionSound()` methods:

```javascript
// Example: Change card select frequency
osc1.frequency.value = 554; // Change from 554 Hz
```

### Frequency Values (Musical Notes):
- C4: 261.63 Hz
- A4: 440 Hz
- C5: 523.25 Hz
- E5: 659.25 Hz
- G5: 783.99 Hz

## Volume Control

Current default volumes:
- Card Select: 0.3 (30%)
- Submission: 0.25 (25%)

To adjust volume globally, modify the gain values in the `playSound()` or synthesis methods.

## Browser Notes

- **Audio Context**: Requires user interaction to start (first click enables audio)
- **Mobile**: Some mobile browsers require HTTPS and user gesture
- **Audio Files**: Web Audio API context may require CORS headers if hosting externally

## Future Enhancements

Potential improvements:
- Add user preference for sound on/off
- Add volume slider control
- Include more sound effects (hover, error states)
- Add background music option
- Support for different sound themes

## Support

If sounds aren't playing:
1. Check browser console for errors
2. Verify audio files are in the correct location
3. Ensure browser hasn't muted audio
4. Try the test page (`card-select.html`) to verify Web Audio API works
