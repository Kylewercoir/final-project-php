<?php
include 'db.php';
include 'auth.php';
check_admin();
?>

<?php include 'header.php'; ?>

<h1>Manage Products</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php
    $stmt = $pdo->query("SELECT * FROM products");
    while($product = $stmt->fetch()):
    ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= $product['quantity'] ?></td>
        <td>$<?= $product['price'] ?></td>
        <td>
            <a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a> |
            <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'footer.php'; ?>
