<?php
include "includes/header.php";
include_once "includes/Inventory.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$inventory = new Inventory(require "includes/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity'],
        'image' => $_POST['image'] // optional: image upload logic
    ];
    $inventory->addProduct($data);
    header("Location: products.php");
    exit;
}
?>

<div class="text">
    <h1>Add Product</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" name="price" placeholder="Price" step="0.01" required><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br>
        <input type="text" name="image" placeholder="Image URL"><br>
        <button type="submit" class="btn">Add Product</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
