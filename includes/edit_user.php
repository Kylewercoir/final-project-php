<?php
session_start();
require '../db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();
$id = intval($_GET['id'] ?? 0);
$message = '';

$stmt = $pdo->prepare(query: "SELECT * FROM users WHERE id=?");
$stmt->execute(params: [$id]);
$user = $stmt->fetch();

if(!$user){
    echo "<h1>User not found</h1>";
    include 'footer.php';
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $email = trim(string: $_POST['email']);
    $role = $_POST['role'];
    $password = trim(string: $_POST['password']);

    if(empty($username) || empty($email)){
        $message = 'Username and Email are required!';
    } else {
        if($password){
            $hashed_password = password_hash(password: $password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(query: "UPDATE users SET username=?, email=?, role=?, password=? WHERE id=?");
            $stmt->execute(params: [$username,$email,$role,$hashed_password,$id]);
        } else {
            $stmt = $pdo->prepare(query: "UPDATE users SET username=?, email=?, role=? WHERE id=?");
            $stmt->execute(params: [$username,$email,$role,$id]);
        }
        $message = 'User updated successfully!';
    }

    $stmt = $pdo->prepare(query: "SELECT * FROM users WHERE id=?");
    $stmt->execute(params: [$id]);
    $user = $stmt->fetch();
}

include 'header.php';
?>

<div class="container">
    <h1>Edit User</h1>
    <?php if($message) echo "<p class='success'>$message</p>"; ?>

    <form method="POST" class="form">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Password (leave blank to keep current)</label>
        <input type="password" name="password">

        <label>Role</label>
        <select name="role" required>
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <button class="btn" type="submit">Update User</button>
    </form>
    <a class="btn muted" href="manage_users.php">Back to Users</a>
</div>

<?php include 'footer.php'; ?>
