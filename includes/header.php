<?php {
    session_start();
}
?>
<header>
    <nav>
        <!-- Logo -->
        <a href="index.php"><img src="uploads/logo.png" alt="KyleWerCoirGaming" class="logo"></a>

        <!-- Navigation menu -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Guest links -->
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <!-- Admin links -->
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="add_product.php">Add Product</a></li>
                    <li><a href="users.php">Manage Users</a></li>
                    <li><a href="add_user.php">Add User</a></li>
                    <li><a href="includes/admin_dashboard.php">Dashboard</a></li>
                <?php endif; ?>
                <!-- Logout with username -->
                <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<style>
/* Header styling */
header { background: #333; color: #fff; padding: 15px 30px; }
header .logo { height: 50px; }
nav ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
nav ul li a { color: #fff; text-decoration: none; }
nav ul li a:hover { text-decoration: underline; }
</style>
