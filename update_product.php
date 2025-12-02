<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require "includes/header.php";
include_once "includes/inventory.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$inventory = new Inventory(require "includes/config.php");
$product = $inventory->getProduct($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity'],
        'image' => $_POST['image']
    ];
    $inventory->updateProduct($_GET['id'], $data);
    header("Location: product.php?id=" . $_GET['id']);
    exit;
}
?>

<div class="text">
    <h1>Update Product</h1>
    <form method="post">
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required><br>
        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required><br>
        <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>"><br>
        <button type="submit" class="btn">Update Product</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
