<?php
header('Content-Type: application/json');
require_once 'db-config.php';

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Response helper function
function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    sendResponse(false, 'Invalid JSON data');
}

// Validate required fields
$email = filter_var(trim($input['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$firstChoice = trim($input['firstChoice'] ?? '');
$secondChoice = trim($input['secondChoice'] ?? '');
$thirdChoice = trim($input['thirdChoice'] ?? '');

if (!$email) {
    sendResponse(false, 'Please provide a valid email address');
}

if (empty($firstChoice) || empty($secondChoice) || empty($thirdChoice)) {
    sendResponse(false, 'Please select all three pet choices');
}

// Check all choices are different
if ($firstChoice === $secondChoice || $firstChoice === $thirdChoice || $secondChoice === $thirdChoice) {
    sendResponse(false, 'You must select three different pets');
}

// Validate email domain (company emails only)
$emailParts = explode('@', $email);
if (count($emailParts) !== 2) {
    sendResponse(false, 'Invalid email format');
}

$domain = strtolower($emailParts[1]);
$allowedDomains = array_map('strtolower', ALLOWED_EMAIL_DOMAINS);

if (!in_array($domain, $allowedDomains)) {
    $domainList = implode(' or ', ALLOWED_EMAIL_DOMAINS);
    sendResponse(false, "Only $domainList email addresses are allowed");
}

// Get client info for security tracking
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

try {
    $pdo = getDbConnection();
    
    // Check if email has already voted
    $stmt = $pdo->prepare("SELECT id FROM votes WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        sendResponse(false, 'This email address has already voted. Each person can only vote once!');
    }
    
    // Insert the vote
    $stmt = $pdo->prepare("
        INSERT INTO votes (email, first_choice, second_choice, third_choice, ip_address, user_agent)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $email,
        $firstChoice,
        $secondChoice,
        $thirdChoice,
        $ipAddress,
        $userAgent
    ]);
    
    // Get total vote count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM votes");
    $result = $stmt->fetch();
    $totalVotes = $result['total'];
    
    sendResponse(true, 'Your vote has been recorded! Thank you for participating! 🎉', [
        'totalVotes' => $totalVotes
    ]);
    
} catch (PDOException $e) {
    error_log("Vote submission error: " . $e->getMessage());
    sendResponse(false, 'An error occurred while processing your vote. Please try again.');
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    sendResponse(false, 'An error occurred. Please try again.');
}
