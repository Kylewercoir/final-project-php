<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "includes/header.php";
include_once "includes/inventory.php";

$inventory = new Inventory(require "includes/config.php");
$product = $inventory->getProduct($_GET['id']);
?>

<div class="text">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <p>Price: $<?php echo $product['price']; ?></p>
    <p>Quantity: <?php echo $product['quantity']; ?></p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="update_product.php?id=<?php echo $product['id']; ?>" class="btn">Update</a>
        <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn">Delete</a>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>
