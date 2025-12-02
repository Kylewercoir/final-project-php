<?php
// Start session for login tracking
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyle's Inventory Management</title>
    <!-- CSS is linked in the page itself like your pizza project -->
</head>
<body>
    <header>
        <h1>Kyle Inventory Management</h1>
        <!-- Optional: simple nav -->
        <nav>
            <a href="index.php">Home</a> |
            <a href="products.php">Products</a>
            <?php
            if (!isset($_SESSION['user_id'])) {
                echo ' | <a href="register.php">Register</a>';
                echo ' | <a href="login.php">Login</a>';
            } else {
                echo ' | Welcome, ' . htmlspecialchars($_SESSION['username']);
                echo ' | <a href="logout.php">Logout</a>';
            }
            ?>
        </nav>
        <hr>
    </header>
