<?php
include 'db.php';
include 'auth.php'; // Make sure this file has check_admin() function
check_admin();
?>

<?php include 'header.php'; ?>

<h1>Admin Dashboard</h1>

<section>
    <h2>Manage Products</h2>
    <a href="add_product.php" class="btn">Add New Product</a>
    <a href="manage_products.php" class="btn">View/Edit Products</a>
</section>

<section>
    <h2>Manage Users</h2>
    <a href="manage_users.php" class="btn">View/Edit Users</a>
</section>

<?php include 'footer.php'; ?>
