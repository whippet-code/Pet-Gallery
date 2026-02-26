<?php
// Configuration
$imagesFolder = __DIR__ . '/pets';
$votingUrl = 'https://your-voting-page.com';

// Pull in the pets
function getPetImages($folder) {
    $images = [];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
        return $images;
    }
    
    $files = scandir($folder);
    foreach ($files as $file) {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($extension, $allowedExtensions)) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $images[] = [
                'filename' => $file,
                'name' => $name,
                'path' => 'pets/' . $file
            ];
        }
    }
    
    // Shuffle for variety on each load
    shuffle($images);
    return $images;
}

$pets = getPetImages($imagesFolder);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐾 Ultimate Osborne Pet Battle!</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="noise-overlay"></div>
    
    <header class="header">
        <div class="container">
            <h1 class="title">
                <span class="title-emoji">🐾</span>
                <span class="title-text">PET BATTLE</span>
                <span class="title-emoji">⚡</span>
            </h1>
            <p class="subtitle">Vote for your favorite furry friend • All in the name of charity 💖</p>
            <div class="stats">
                <div class="stat-badge">
                    <span class="stat-number"><?php echo count($pets); ?></span>
                    <span class="stat-label">Contestants</span>
                </div>
            </div>
        </div>
    </header>

    <main class="gallery-container">
        <div class="gallery" id="gallery">
            <?php foreach ($pets as $index => $pet): ?>
            <div class="pet-card" 
                 data-pet-name="<?php echo htmlspecialchars($pet['name']); ?>"
                 data-pet-image="<?php echo htmlspecialchars($pet['path']); ?>"
                 data-index="<?php echo $index; ?>"
                 style="--delay: <?php echo $index * 0.05; ?>s">
                <div class="card-inner">
                    <div class="card-shine"></div>
                    <div class="card-image-wrapper">
                        <img src="<?php echo htmlspecialchars($pet['path']); ?>" 
                             alt="<?php echo htmlspecialchars($pet['name']); ?>"
                             class="card-image"
                             loading="lazy">
                    </div>
                    <div class="card-footer">
                        <h3 class="pet-name"><?php echo htmlspecialchars($pet['name']); ?></h3>
                        <div class="card-rarity">★★★★★</div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <button class="modal-close" id="modalClose">
                <span class="close-icon">✕</span>
            </button>
            
            <div class="battle-card">
                <div class="card-holographic"></div>
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-type">LEGENDARY PET</span>
                        <div class="card-stars">★★★★★</div>
                    </div>
                </div>
                
                <div class="card-image-container">
                    <img src="" alt="" id="modalImage" class="modal-image">
                    <div class="card-frame"></div>
                </div>
                
                <div class="card-info">
                    <h2 class="modal-pet-name" id="modalName"></h2>
                    <div class="card-stats">
                        <div class="stat">
                            <span class="stat-icon">💖</span>
                            <span class="stat-text">Cuteness</span>
                            <span class="stat-bar"><span class="stat-fill" style="--value: 99%"></span></span>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">⚡</span>
                            <span class="stat-text">Charm</span>
                            <span class="stat-bar"><span class="stat-fill" style="--value: 95%"></span></span>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">✨</span>
                            <span class="stat-text">Floof</span>
                            <span class="stat-bar"><span class="stat-fill" style="--value: 100%"></span></span>
                        </div>
                    </div>
                </div>
                
                <div class="card-actions">
                    <a href="<?php echo htmlspecialchars($votingUrl); ?>" 
                       class="vote-button" 
                       id="voteButton"
                       target="_blank">
                        <span class="button-bg"></span>
                        <span class="button-text">
                            <span class="button-icon">⚡</span>
                            VOTE NOW (it's free)
                            <span class="button-icon">⚡</span>
                        </span>
                    </a>
                    <p class="vote-subtitle">Help us raise money for Barnsley Hospice! 🎉</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>Made with 💖 for our furry friends • Osborne Tech</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
