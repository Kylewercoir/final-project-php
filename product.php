<?php
session_start();
include 'includes/header.php';
require 'db.php';

$id = intval($_GET['id'] ?? 0);
$pdo = Database::getInstance()->getConnection();
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if(!$product){
    echo "<h1>Product not found</h1>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="card single-product">
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p>Quantity: <?= intval($product['quantity']) ?></p>
    <p>Price: $<?= htmlspecialchars($product['price']) ?></p>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a class="btn" href="includes/edit_product.php?id=<?= $product['id'] ?>">Edit</a>
        <a class="btn muted" href="includes/manage_products.php?delete=<?= $product['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
