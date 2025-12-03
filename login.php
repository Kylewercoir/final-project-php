<?php
session_start();
require 'db.php';

$pdo = Database::getInstance()->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "All fields are required!";
    } else {

        //  prepare + execute
        $stmt = $pdo->prepare(query: "SELECT * FROM users WHERE username=? OR email=?");
        $stmt->execute(params: [$username, $username]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            // Set sessions
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            //  header syntax
            if ($user['role'] === 'admin') {
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

<section class="container">
    <h1>Login</h1>

    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" class="form">
        <label>Username or Email</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn">Login</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
