<?php
// Preventing unauthorized access to admin pages
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: /login.php");
    exit;
}
?>
