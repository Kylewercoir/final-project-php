
<?php
ini_set('display_errors,1');
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) session_start();
include '/includes/header.php';
// Include header and necessary files
include "includes/header.php";
include_once "includes/inventory.php";

// Load config and initialize inventory
$config = require "includes/config.php";
$inventory = new Inventory($config);
?>

<!-- Link CSS -->
<link rel="stylesheet" href="styles.css">

<div class="text">
  <h1>Welcome to Kyle's Final PHP Project Inventory Management System</h1>
  <p>View products, create an account, or sign in to manage inventory.</p>
  <a href="products.php" class="btn btn-lg btn-primary">Browse Products</a>
</div>

<?php include "includes/footer.php"; ?>
