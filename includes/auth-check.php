<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../db.php';
$pdo = Database::getInstance()->getConnection();

include __DIR__ . '/header.php';

// quick stats
$stmt = $pdo->query(query: "SELECT COUNT(*) AS cnt FROM products");
$productsCount = $stmt->fetchColumn();

$stmt = $pdo->query(query: "SELECT COUNT(*) AS cnt FROM users");
$usersCount = $stmt->fetchColumn();

$stmt = $pdo->query(query: "SELECT SUM(quantity) AS total_stock FROM products");
$totalStock = $stmt->fetchColumn();
?>
<main class="container">
    <h1>Admin Dashboard</h1>

    <div class="stats-grid">
        <div class="stat">
            <h2><?= intval(value: $productsCount) ?></h2>
            <p>Products</p>
        </div>
        <div class="stat">
            <h2><?= intval(value: $usersCount) ?></h2>
            <p>Users</p>
        </div>
        <div class="stat">
            <h2><?= intval(value: $totalStock) ?></h2>
            <p>Total Stock</p>
        </div>
    </div>

    <div class="admin-actions">
        <a class="btn" href="/manage_products.php">Manage Products</a>
        <a class="btn" href="/add_product.php">Add Product</a>
        <a class="btn" href="/users.php">Manage Users</a>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>
