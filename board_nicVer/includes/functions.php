<?php
// includes/functions.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../config/db.php';

/**
 * Basic sanitizer for text inputs
 */
function sanitize(string $s): string {
    return htmlspecialchars(trim($s), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Require login - redirect to login if not logged in
 */
function checkLogin(): void {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /CorkBoard/auth/login.php');
        exit;
    }
}

/**
 * Current user id helper
 */
function current_user_id(): ?int {
    return $_SESSION['user_id'] ?? null;
}

/**
 * JSON helper
 */
function json_response($data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}
