<?php
/**
 * Demo Image Generator
 * 
 * This script creates placeholder images for testing the gallery.
 * Run this once to populate the gallery with demo images.
 * 
 * Usage: php add-demo-images.php
 * 
 * Note: Requires GD library. Remove demo images before deploying to production!
 */

$petsFolder = __DIR__ . '/pets';
$demoNames = [
    'Barney', 'Fluffy', 'Max', 'Luna', 'Charlie',
    'Bella', 'Rocky', 'Daisy', 'Cooper', 'Molly',
    'Buddy', 'Sadie', 'Tucker', 'Chloe', 'Bear'
];

$colors = [
    ['r' => 255, 'g' => 107, 'b' => 107], // Pink
    ['r' => 78, 'g' => 205, 'b' => 196],  // Teal
    ['r' => 255, 'g' => 230, 'b' => 109], // Yellow
    ['r' => 102, 'g' => 126, 'b' => 234], // Purple
    ['r' => 240, 'g' => 147, 'b' => 251], // Light purple
];

// Check if GD is available
if (!extension_loaded('gd')) {
    die("Error: GD library is not installed. Please install it to generate demo images.\n");
}

// Create pets folder if it doesn't exist
if (!is_dir($petsFolder)) {
    mkdir($petsFolder, 0755, true);
    echo "✓ Created pets folder\n";
}

echo "🎨 Generating demo images...\n\n";

foreach ($demoNames as $index => $name) {
    $filename = $petsFolder . '/' . $name . '.jpg';
    
    // Skip if file already exists
    if (file_exists($filename)) {
        echo "⊘ Skipped: $name.jpg (already exists)\n";
        continue;
    }
    
    // Create image (portrait ratio: 600x800)
    $width = 600;
    $height = 800;
    $image = imagecreatetruecolor($width, $height);
    
    // Select color
    $color = $colors[$index % count($colors)];
    
    // Create gradient background
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)($color['r'] * (1 - $ratio * 0.3));
        $g = (int)($color['g'] * (1 - $ratio * 0.3));
        $b = (int)($color['b'] * (1 - $ratio * 0.3));
        $lineColor = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width, $y, $lineColor);
    }
    
    // Add text
    $white = imagecolorallocate($image, 255, 255, 255);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    
    // Pet name (large)
    $fontSize = 60;
    $textBox = imagettfbbox($fontSize, 0, __DIR__ . '/arial.ttf', $name);
    
    // Use imagestring instead if font file not available
    $centerX = ($width - (strlen($name) * 20)) / 2;
    $centerY = ($height / 2) - 30;
    imagestring($image, 5, $centerX, $centerY, $name, $white);
    
    // Add "DEMO" text
    $demoX = ($width - (strlen('DEMO PET') * 15)) / 2;
    imagestring($image, 4, $demoX, $centerY + 40, 'DEMO PET', $white);
    
    // Add cute emoji placeholder
    $emojiX = ($width - 40) / 2;
    imagestring($image, 5, $emojiX, $centerY - 60, ':)', $white);
    
    // Add decorative elements (circles)
    $circleColor = imagecolorallocatealpha($image, 255, 255, 255, 80);
    imagefilledellipse($image, 100, 100, 80, 80, $circleColor);
    imagefilledellipse($image, $width - 100, $height - 100, 120, 120, $circleColor);
    
    // Save image
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
    
    echo "✓ Created: $name.jpg\n";
}

echo "\n✨ Done! Generated " . count($demoNames) . " demo images.\n";
echo "🌐 Run 'php -S localhost:8000' to start the gallery!\n";
echo "\n⚠️  Remember to replace these demo images with real pet photos!\n";
?>
