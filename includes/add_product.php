<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php';
$pdo = Database::getInstance()->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    // Image Upload
    $imageFile = "";
    if (!empty($_FILES['image']['name'])) {
        $imageFile = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageFile);
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, description, quantity, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $quantity, $price, $imageFile]);

    header("Location: manage_products.php");
    exit;
}

include 'includes/header.php';
?>

<h1>Add Product</h1>

<form method="POST" enctype="multipart/form-data">
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <label>Quantity</label>
    <input type="number" name="quantity" required>

    <label>Price</label>
    <input type="number" step="0.01" name="price" required>

    <label>Image</label>
    <input type="file" name="image">

    <button type="submit">Add Product</button>
</form>

<?php include 'includes/footer.php'; ?>
