<?php
include 'includes/db.php';
session_start();
$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if($user['role']=='admin'){
            header("Location: /includes/admin_dashboard.php");
        } else {
            header("Location: /pages/index.php");
        }
        exit;
    } else {
        $message = "Invalid login!";
    }
}
?>
<?php include 'includes/header.php'; ?>
<section>
    <h1>Login</h1>
    <?php if($message) echo "<p>$message</p>"; ?>
    <form action="" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</section>
<?php include 'includes/footer.php'; ?>
