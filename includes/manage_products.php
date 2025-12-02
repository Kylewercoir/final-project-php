<?php
session_start();
require 'db.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Delete product
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$delete_id]);

    $message = "Product deleted successfully.";
}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <h1>Manage Products</h1>

    <?php if (isset($message)): ?>
        <p class="success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <p><a href="add_product.php">Add New Product</a></p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td>$<?= $product['price'] ?></td>
                        <td>
                            <?php if ($product['image'] && file_exists('uploads/'.$product['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="80">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a> |
                            <a href="manage_products.php?delete_id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="index.php">Back to Home</a></p>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
