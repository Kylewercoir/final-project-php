<?php

require 'db.php';

$pdo = Database::getInstance()->getConnection();
include 'includes/header.php';
?>

<h1>All Products</h1>

<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
$counter = 1;

while($product = $stmt->fetch()):
    // Dynamic image
    $imagePath = 'uploads/kylewercoir-hat.png';
    if(!empty($product['image']) && file_exists('uploads/'.$product['image'])){
        $imagePath = 'uploads/'.$product['image'];
    }


    $counter++;
?>
    <div>
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:150px;">
        <p>Quantity: <?= $product['quantity'] ?></p>
        <p>Price: $<?= $product['price'] ?></p>
    </div>
<?php endwhile; ?>

<?php include 'includes/footer.php'; ?>
