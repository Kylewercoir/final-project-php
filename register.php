<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';



// Get PDO connection from singleton
$pdo = Database::getInstance()->getConnection();

// Now $pdo->prepare() will work

// Enable errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($email) || empty($password)){
        $message = "All fields are required!";
    } else {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->execute([$username, $email]);

        if($stmt->rowCount() > 0){
            $message = "Username or email already exists!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
            if($stmt->execute([$username,$email,$hashed_password])){
                $message = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $message = "Error registering user.";
            }
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
