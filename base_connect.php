<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is logged in, retrieve the plain email from session
if (isset($_SESSION["username"])) {
    // The username is stored as plain text (not base64) by login.php
    $loginuser = $_SESSION["username"];
    $user      = $_SESSION["username"];
} else {
    // No active session – clear any residual data
    $_SESSION = array();
    session_destroy();
}
?>