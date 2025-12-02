<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KyleWerCoirGaming Inventory</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <nav>
        <a href="index.php"><img src="uploads/logo.png" alt="KyleWerCoirGaming" class="logo"></a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <?php if(!isset($_SESSION['user_id'])): ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <?php if($_SESSION['role']=='admin'): ?>
                    <li><a href="includes/admin_dashboard.php">Dashboard</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
