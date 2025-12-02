<?php
if (session_status() === PHP_SESSION_NONE) session_start();


include "includes/header.php";
include_once "includes/inventory.php";

$inventory = new Inventory(require "includes/config.php");
$products = $inventory->getAllProducts();
?>

<link rel="stylesheet" href="css/styles.css">


<div class="text">
    <h1>All Products</h1>
    <div class="products">
        <?php foreach($products as $p): ?>
            <div class="product">
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                <p>Quantity: <?php echo $p['quantity']; ?></p>
                <a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary">View</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
