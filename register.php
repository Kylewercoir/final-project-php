<?php
include '../includes/db.php';
$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if($stmt->rowCount() > 0){
        $message = "Username or email already exists!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if($stmt->execute([$username, $email, $password])){
            $message = "Registration successful! <a href='/login.php'>Login here</a>";
        } else {
            $message = "Something went wrong.";
        }
    }
}
?>
<?php include 'includes/header.php'; ?>
<section>
    <h1>Register</h1>
    <?php if($message) echo "<p>$message</p>"; ?>
    <form action="" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Register</button>
    </form>
</section>
<?php include 'includes/footer.php'; ?>
