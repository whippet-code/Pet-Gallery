-- Pet Gallery Voting Database Schema (SQLite)
-- This creates the necessary tables for the voting system

-- Votes table: stores individual votes with email validation
CREATE TABLE IF NOT EXISTS votes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE,
    first_choice TEXT NOT NULL,
    second_choice TEXT NOT NULL,
    third_choice TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_address TEXT,
    user_agent TEXT
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_email ON votes(email);
CREATE INDEX IF NOT EXISTS idx_created_at ON votes(created_at);

-- Leaderboard view: calculates total points for each pet
-- Points: 3 for 1st place, 2 for 2nd place, 1 for 3rd place
CREATE VIEW IF NOT EXISTS leaderboard AS
SELECT 
    pet_name,
    SUM(points) as total_points,
    SUM(CASE WHEN place = 1 THEN 1 ELSE 0 END) as first_place_votes,
    SUM(CASE WHEN place = 2 THEN 1 ELSE 0 END) as second_place_votes,
    SUM(CASE WHEN place = 3 THEN 1 ELSE 0 END) as third_place_votes,
    COUNT(*) as total_votes
FROM (
    SELECT first_choice as pet_name, 3 as points, 1 as place FROM votes
    UNION ALL
    SELECT second_choice as pet_name, 2 as points, 2 as place FROM votes
    UNION ALL
    SELECT third_choice as pet_name, 1 as points, 3 as place FROM votes
) as all_votes
GROUP BY pet_name
ORDER BY total_points DESC, first_place_votes DESC;
