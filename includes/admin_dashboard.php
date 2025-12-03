<?php
session_start();
require '../db.php';

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../index.php');
    exit;
}

include 'header.php';
?>

<div class="container dashboard">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>! Use the links below to manage your inventory and users.</p>

    <div class="dashboard-cards">

        <div class="card">
            <h2>Products</h2>
            <p>View, add, edit, or delete products</p>
            <a class="btn" href="manage_products.php">Manage Products</a>
        </div>

        <div class="card">
            <h2>Users</h2>
            <p>View, add, edit, or delete users</p>
            <a class="btn" href="manage_users.php">Manage Users</a>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>
