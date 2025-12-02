<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
if(!isset($_GET['id'])) { echo "No product specified"; exit; }
$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if(!$product){ echo "Product not found"; exit; }
?>

<section>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <img src="uploads/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p>Quantity: <?= $product['quantity'] ?></p>
    <p>Price: $<?= $product['price'] ?></p>
</section>

<?php include 'includes/footer.php'; ?>
