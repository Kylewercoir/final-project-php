<?php
session_start();
require 'db.php';

$pdo = Database::getInstance()->getConnection();
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)){
        $message = "All fields are required!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])){
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // important!

            // Redirect based on role
            if($user['role'] === 'admin'){
                header(header: "Location: includes/admin_dashboard.php");
            } else {
                header(header: "Location: index.php");
            }
            exit;
        } else {
            $message = "Invalid username/email or password!";
        }
    }
}

include 'includes/header.php';
?>

<section class="container">
    <h1>Login</h1>
    <?php if($message) echo "<p class='error'>$message</p>"; ?>
    <form method="POST" class="form">
        <label>Username or Email</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn">Login</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
