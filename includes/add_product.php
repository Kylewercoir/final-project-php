<?php
session_start();
require 'db.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $imagePath = null;

    // Validate inputs
    if (empty($name) || empty($description) || $quantity < 0 || $price < 0) {
        $message = "Please fill in all required fields with valid values.";
    } else {
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newImage = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.$newImage);
            $imagePath = $newImage;
        }

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO products (name, description, quantity, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $quantity, $price, $imagePath]);

        $message = "Product added successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <h1>Add New Product</h1>

    <?php if ($message): ?>
        <p class="success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="0" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>

        <label for="image">Product Image:</label>
        <input type="file" name="image" id="image">

        <button type="submit">Add Product</button>
    </form>

    <p><a href="manage_products.php">Back to Manage Products</a></p>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
