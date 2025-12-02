<?php include 'includes/header.php'; ?>
<section>
    <h1>Welcome to KyleWerCoirGaming Inventory</h1>
    <p>Browse our products and see what we have in stock!</p>
</section>

<section>
    <h2>Featured Products</h2>
    <div class="products-grid">
        <?php
        include '../includes/db.php';
        $stmt = $pdo->query("SELECT * FROM products LIMIT 4");
        while($product = $stmt->fetch()):
        ?>
        <div class="product-card">
            <a href="product.php?id=<?= $product['id'] ?>">
                <img src="/assets/images/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p>Quantity: <?= $product['quantity'] ?></p>
                <p>Price: $<?= $product['price'] ?></p>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</section>
<?php include '../includes/footer.php'; ?>
