<?php
session_start();
require '../db.php';

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $image = '';

    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = '../uploads/' . $filename;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            $image = $filename;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, description, quantity, price, image) VALUES (?,?,?,?,?)");
    $stmt->execute([$name,$description,$quantity,$price,$image]);
    $message = 'Product added successfully!';
}

include 'header.php';
?>

<div class="container">
    <h1>Add Product</h1>
    <?php if($message) echo "<p class='success'>$message</p>"; ?>
    <form method="POST" enctype="multipart/form-data" class="form">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Quantity</label>
        <input type="number" name="quantity" required min="0">

        <label>Price</label>
        <input type="number" step="0.01" name="price" required min="0">

        <label>Image</label>
        <input type="file" name="image" accept="image/*">

        <button class="btn" type="submit">Add Product</button>
    </form>
    <a class="btn muted" href="../products.php">Back to Products</a>
</div>

<?php include 'footer.php'; ?>
