<?php

@include 'config.php';

session_start();

// Optional: store the username if needed before destroying session
$_SESSION['logout_message'] = "You have been logged out successfully.";

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login_page.php");
exit;

?>