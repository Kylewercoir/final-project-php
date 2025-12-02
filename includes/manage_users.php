<?php
include 'db.php';
include 'auth.php';
check_admin();
?>

<?php include 'header.php'; ?>

<h1>Manage Users</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php
    $stmt = $pdo->query("SELECT * FROM users");
    while($user = $stmt->fetch()):
    ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['role'] ?></td>
        <td>
            <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'footer.php'; ?>
