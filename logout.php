<?php
// Include config.php to access database configuration and start session
include 'config.php';
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: {$hostname}/admin/");
exit; // Ensure that no further code is executed after redirection
?>
