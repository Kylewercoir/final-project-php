<?php
session_start();

require 'db.php';
$pdo = Database::getInstance()->getConnection();

include 'includes/header.php';

// Show errors temporarily for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<h1>All Products</h1>

<div class="products-grid">

<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");

while ($product = $stmt->fetch()):
    
    // Default image
    $imagePath = 'uploads/kylewercoir-hat.png';

    // Use product image if exists
    if (!empty($product['image']) && file_exists('uploads/' . $product['image'])) {
        $imagePath = 'uplaods/kylewercoir-t-shirt.png' . $product['image'];
    }

?>
    <div class="product-card">
        <h2><?= htmlspecialchars($product['name']) ?></h2>

        <img src="<?= htmlspecialchars($imagePath) ?>" 
             alt="<?= htmlspecialchars($product['name']) ?>" 
             style="width:150px;">

        <p>Quantity: <?= $product['quantity'] ?></p>
        <p>Price: $<?= $product['price'] ?></p>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <p><a href="includes/edit_product.php?id=<?= $product['id'] ?>">Edit</a></p>
            <p><a href="includes/delete_product.php?id=<?= $product['id'] ?>">Delete</a></p>
        <?php endif; ?>

    </div>
<?php endwhile; ?>

</div>

<?php include 'includes/footer.php'; ?>
