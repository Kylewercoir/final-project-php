<?php
require 'db.php';
session_start();
include 'includes/header.php';

$pdo = Database::getInstance()->getConnection();
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<div class="container">
    <h1>All Products</h1>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a class="btn" href="includes/add_product.php">Add Product</a>
    <?php endif; ?>

    <div class="products-grid">
        <?php foreach($products as $product): ?>
            <div class="product-card">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <?php if($product['image'] && file_exists('uploads/'.$product['image'])): ?>
                    <img src="uploads/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-img">
                <?php endif; ?>
                <p>Quantity: <?= $product['quantity'] ?></p>
                <p>Price: $<?= $product['price'] ?></p>

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a class="btn" href="includes/edit_product.php?id=<?= $product['id'] ?>">Edit</a>
                    <a class="btn muted" href="includes/manage_products.php?delete=<?= $product['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
