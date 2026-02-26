<?php
// Database configuration template - SQLite
// Copy this file to db-config.php and update if needed

// Database file path (relative to this file)
// The database file will be created automatically when you run the setup
define('DB_PATH', __DIR__ . '/pet_gallery.db');

// Email domain validation (restrict to company emails)
// Multiple domains supported - add domains to the array
define('ALLOWED_EMAIL_DOMAINS', [
    'yourcompany.com',
    'yourcompany.co.uk'
]);

// Database connection function
function getDbConnection() {
    try {
        $dsn = "sqlite:" . DB_PATH;
        $pdo = new PDO($dsn, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        
        // Enable foreign keys for SQLite
        $pdo->exec('PRAGMA foreign_keys = ON;');
        
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed");
    }
}
