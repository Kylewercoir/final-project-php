<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php';
$pdo = Database::getInstance()->getConnection();

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit;
}

$product_id = intval($_GET['id']);
$message = '';

// fetch product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: manage_products.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $imageName = $product['image']; // default keep existing

    // basic validation
    if ($name === '' || $description === '') {
        $message = "Name and description are required.";
    } elseif ($quantity < 0 || $price < 0) {
        $message = "Quantity and price must be >= 0.";
    } else {
        // Image upload handling
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg','jpeg','png','gif','webp'];
            $origName = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $message = "Only images (jpg, jpeg, png, gif, webp) are allowed.";
            } else {
                // generate unique name
                $newName = uniqid('prod_', true) . '.' . $ext;
                $target = __DIR__ . '/uploads/' . $newName;

                if (!is_dir(__DIR__ . '/uploads')) {
                    mkdir(__DIR__ . '/uploads', 0755, true);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    // delete old image file if exists and different
                    if (!empty($product['image']) && file_exists(__DIR__ . '/uploads/' . $product['image'])) {
                        @unlink(__DIR__ . '/uploads/' . $product['image']);
                    }
                    $imageName = $newName;
                } else {
                    $message = "Failed to move uploaded file.";
                }
            }
        }

        // If no error so far, update DB
        if ($message === '') {
            $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, quantity=?, price=?, image=? WHERE id=?");
            $stmt->execute([$name, $description, $quantity, $price, $imageName, $product_id]);
            $message = "Product updated successfully.";
            // refresh product
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
        }
    }
}

include 'includes/header.php';
?>
<main class="container">
    <h1>Edit Product</h1>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="form">
        <label for="name">Name</label>
        <input id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

        <label for="quantity">Quantity</label>
        <input id="quantity" name="quantity" type="number" min="0" value="<?= intval($product['quantity']) ?>" required>

        <label for="price">Price</label>
        <input id="price" name="price" type="number" step="0.01" min="0" value="<?= htmlspecialchars($product['price']) ?>" required>

        <label for="image">Image (leave blank to keep current)</label>
        <input id="image" name="image" type="file" accept="image/*">
        <?php if (!empty($product['image']) && file_exists(__DIR__ . '/uploads/' . $product['image'])): ?>
            <p>Current image:</p>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="" style="max-width:150px;">
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit">Update Product</button>
            <a class="btn muted" href="manage_products.php">Back</a>
        </div>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
