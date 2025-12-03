<?php
include 'includes/header.php';
?>
<div class="container">
    <h1>Welcome to KyleWerCoir Gaming Inventory</h1>
    <p>Browse our products below:</p>
    <a class="btn" href="products.php">View All Products</a>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <p><a class="btn" href="includes/admin_dashboard.php">Go to Admin Dashboard</a></p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>