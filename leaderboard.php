<?php
require_once 'db-config.php';

// Fetch leaderboard data
try {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM leaderboard");
    $results = $stmt->fetchAll();
    
    // Get total vote count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM votes");
    $voteData = $stmt->fetch();
    $totalVotes = $voteData['total'];
} catch (Exception $e) {
    error_log("Leaderboard error: " . $e->getMessage());
    $results = [];
    $totalVotes = 0;
}

$imagesFolder = __DIR__ . '/pets';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏆 Pet Battle Leaderboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .leaderboard-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .leaderboard-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .leaderboard-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #ffe66d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }
        
        .total-votes {
            font-size: 1.2rem;
            opacity: 0.8;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            padding: 0.8rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 100px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        .leaderboard-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .leaderboard-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 1.5rem;
            display: grid;
            grid-template-columns: 60px 100px 1fr auto;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out forwards;
            animation-delay: calc(var(--index) * 0.1s);
            opacity: 0;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .leaderboard-item:hover {
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateX(10px);
        }
        
        .rank {
            font-size: 2rem;
            font-weight: 900;
            font-family: 'Space Grotesk', sans-serif;
            text-align: center;
        }
        
        .rank-1 { color: #ffd700; }
        .rank-2 { color: #c0c0c0; }
        .rank-3 { color: #cd7f32; }
        
        .pet-image {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }
        
        .pet-info {
            flex: 1;
        }
        
        .pet-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .vote-breakdown {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            opacity: 0.7;
        }
        
        .points {
            text-align: right;
        }
        
        .points-value {
            font-size: 2.5rem;
            font-weight: 900;
            font-family: 'Space Grotesk', sans-serif;
            background: var(--gradient-4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .points-label {
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        @media (max-width: 768px) {
            .leaderboard-item {
                grid-template-columns: 40px 80px 1fr;
                gap: 1rem;
                padding: 1rem;
            }
            
            .pet-image {
                width: 80px;
                height: 80px;
            }
            
            .points {
                grid-column: 3;
                text-align: left;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="noise-overlay"></div>
    
    <div class="leaderboard-container" style="position: relative; z-index: 2;">
        <a href="index.php" class="back-link">← Back to Gallery</a>
        
        <div class="leaderboard-header">
            <h1 class="leaderboard-title">🏆 Leaderboard 🏆</h1>
            <p class="total-votes">Total Votes: <?php echo $totalVotes; ?></p>
        </div>
        
        <div class="leaderboard-list">
            <?php if (empty($results)): ?>
                <div style="text-align: center; padding: 3rem; opacity: 0.7;">
                    <p style="font-size: 1.5rem;">No votes yet! Be the first to vote! 🗳️</p>
                </div>
            <?php else: ?>
                <?php foreach ($results as $index => $pet): 
                    $rank = $index + 1;
                    $rankClass = $rank <= 3 ? "rank-$rank" : "";
                    
                    // Try to find the pet image
                    $petImage = null;
                    $files = scandir($imagesFolder);
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_FILENAME) === $pet['pet_name']) {
                            $petImage = 'pets/' . $file;
                            break;
                        }
                    }
                ?>
                <div class="leaderboard-item" style="--index: <?php echo $index; ?>;">
                    <div class="rank <?php echo $rankClass; ?>">
                        <?php 
                            if ($rank === 1) echo '🥇';
                            elseif ($rank === 2) echo '🥈';
                            elseif ($rank === 3) echo '🥉';
                            else echo "#$rank";
                        ?>
                    </div>
                    
                    <?php if ($petImage): ?>
                        <img src="<?php echo htmlspecialchars($petImage); ?>" 
                             alt="<?php echo htmlspecialchars($pet['pet_name']); ?>"
                             class="pet-image">
                    <?php else: ?>
                        <div class="pet-image" style="background: rgba(255,255,255,0.1);"></div>
                    <?php endif; ?>
                    
                    <div class="pet-info">
                        <div class="pet-name"><?php echo htmlspecialchars($pet['pet_name']); ?></div>
                        <div class="vote-breakdown">
                            <span>🥇 <?php echo $pet['first_place_votes']; ?></span>
                            <span>🥈 <?php echo $pet['second_place_votes']; ?></span>
                            <span>🥉 <?php echo $pet['third_place_votes']; ?></span>
                        </div>
                    </div>
                    
                    <div class="points">
                        <div class="points-value"><?php echo $pet['total_points']; ?></div>
                        <div class="points-label">points</div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
