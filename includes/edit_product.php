<?php
session_start();
require '../db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

// Handle Delete
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$id]);
    header('Location: manage_users.php');
    exit;
}

// Fetch all users
$stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

include 'header.php';
?>

<div class="container">
    <h1>User Management</h1>
    <a class="btn" href="add_user.php" style="margin-bottom:15px;">Add New User</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td><?= $u['created_at'] ?></td>
                    <td>
                        <a class="btn" href="edit_user.php?id=<?= $u['id'] ?>">Edit</a>
                        <a class="btn muted" href="manage_users.php?delete=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
