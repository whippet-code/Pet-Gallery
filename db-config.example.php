<?php
// Database configuration template
// Copy this file to db-config.php and update with your actual credentials

define('DB_HOST', 'localhost');
define('DB_NAME', 'pet_gallery');
define('DB_USER', 'your_database_username');
define('DB_PASS', 'your_database_password');

// Email domain validation (restrict to company emails)
// Multiple domains supported - add domains to the array
define('ALLOWED_EMAIL_DOMAINS', [
    'yourcompany.com',
    'yourcompany.co.uk'
]);

// Database connection function
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed");
    }
}
