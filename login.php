<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "includes/header.php";
include_once "includes/User.php";

$user = new User(require "includes/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loggedInUser = $user->login($_POST['email'], $_POST['password']);
    if ($loggedInUser) {
        session_start();
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['username'] = $loggedInUser['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<div class="text">
    <h1>Login</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" class="btn">Login</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
