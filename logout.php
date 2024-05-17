<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to home page 
header("Location: index.php");
exit; 
?>