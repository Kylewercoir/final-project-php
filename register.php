<?php
require 'db.php';
$pdo = Database::getInstance()->getConnection();
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
        $message = 'All fields are required!';
    } elseif($password !== $confirm_password){
        $message = 'Passwords do not match!';
    } else {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->execute([$username,$email]);
        if($stmt->fetch()){
            $message = 'Username or email already exists!';
        } else {
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username,email,password,role) VALUES (?,?,?,?)");
            $stmt->execute([$username,$email,$hashed_password,'user']);
            $message = 'Registration successful! You can now login.';
        }
    }
}

include 'includes/header.php';
?>

<div class="container">
    <h1>Register</h1>

    <?php if($message): ?>
        <p class="success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" class="form">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button class="btn" type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php" class="link">Login here</a></p>
</div>

<?php include 'includes/footer.php'; ?>
