<?php
/**
 * Logout
 * BariPasta Manager
 */

require_once '../includes/auth.php';

// Esegue il logout
logout();

// Reindirizza al login
header("Location: login.php");
exit();
?>