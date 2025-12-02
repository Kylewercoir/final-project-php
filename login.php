<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';
require 'includes/auth-check.php';

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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if($user['role'] === 'admin'){
                header("Location: includes/admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $message = "Invalid username/email or password!";
        }
    }
}

include 'includes/header.php';
?>

<section>
    <h1>Login</h1>
    <?php if($message) echo "<p>$message</p>"; ?>
    <form method="POST">
        <label>Username or Email</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
