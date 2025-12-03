<?php
session_start();
require '../db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if(empty($username) || empty($email) || empty($password)){
        $message = 'All fields are required!';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->execute([$username,$email]);
        if($stmt->fetch()){
            $message = 'Username or email already exists!';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username,email,password,role) VALUES (?,?,?,?)");
            $stmt->execute([$username,$email,$hashed_password,$role]);
            $message = 'User added successfully!';
        }
    }
}

include 'header.php';
?>

<div class="container">
    <h1>Add User</h1>
    <?php if($message) echo "<p class='success'>$message</p>"; ?>

    <form method="POST" class="form">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button class="btn" type="submit">Add User</button>
    </form>
    <a class="btn muted" href="manage_users.php">Back to Users</a>
</div>

<?php include 'footer.php'; ?>
