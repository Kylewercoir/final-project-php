<?php
session_start();
require 'db.php';

$pdo = Database::getInstance()->getConnection();
include 'includes/header.php';
?>

<section>
    <h1>Welcome to KyleWerCoirGaming Inventory</h1>
    <p>Browse our products and see what we have in stock!</p>
</section>

<section>
    <h2>Featured Products</h2>
    <div class="products-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
        $counter = 1;

        while($product = $stmt->fetch()):
            // Use specific images for first two products
            if($counter === 1) {
                $imagePath = 'uploads/kylewercoir-hat.png';
            } elseif($counter === 2) {
                $imagePath = 'uploads/kylewercoir-t-shirt.png';
            } elseif(!empty($product['image']) && file_exists('uploads/'.$product['image'])) {
                $imagePath = 'uploads/'.$product['image'];
            } else {
                $imagePath = 'uploads/default.png';
            }

            $counter++;
        ?>
        <div class="product-card">
            <a href="product.php?id=<?= $product['id'] ?>">
                <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p>Quantity: <?= $product['quantity'] ?></p>
                <p>Price: $<?= $product['price'] ?></p>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<div class="container">
    <h1>Welcome to KyleWerCoir Gaming Inventory</h1>
    <p>Browse our products below:</p>
    <a class="btn" href="products.php">View All Products</a>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <p><a class="btn" href="includes/admin_dashboard.php">Go to Admin Dashboard</a></p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>