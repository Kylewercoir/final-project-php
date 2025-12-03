<?php
session_start();
require '../db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

// Delete product
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    header('Location: manage_products.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();

include 'header.php';
?>

<div class="container">
    <h1>Manage Products</h1>
    <p><a class="btn" href="add_product.php">Add New Product</a></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= intval($p['quantity']) ?></td>
            <td>$<?= htmlspecialchars($p['price']) ?></td>
            <td>
                <?php if (!empty($p['image']) && file_exists("../uploads/".$p['image'])): ?>
                    <img src="../uploads/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:50px;">
                <?php endif; ?>
            </td>
            <td>
                <a class="btn" href="edit_product.php?id=<?= $p['id'] ?>">Edit</a>
                <a class="btn muted" href="manage_products.php?delete=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>
