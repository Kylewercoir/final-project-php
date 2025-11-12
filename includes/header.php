<?php
session_start();
?>
<header class="p-3 bg-dark text-white">
  <div class="container d-flex justify-content-between align-items-center">
    <h2><a href="index.php" class="text-white text-decoration-none">Kyle Final Project Inventory System</a></h2>
    <nav>
      <a href="index.php" class="text-white me-3">Home</a>
      <a href="products.php" class="text-white me-3">Products</a>
      <a href="register.php" class="text-white me-3">Register</a>
      <?php if (!isset($_SESSION['user'])): ?>
        <form class="d-inline" method="POST" action="login.php">
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <button class="btn btn-sm btn-light">Login</button>
        </form>
      <?php else: ?>
        <span class="me-3">Hi, <?php echo $_SESSION['user']['name']; ?></span>
        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
