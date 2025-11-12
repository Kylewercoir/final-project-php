<?php
require_once   '/includes/config.php';
require_once   '/includes/Database.php';
require_once  '/includes/Inventory.php';
$config = require  '/includes/config.php';
$inventory = new Inventory($config);
include  '/includes/header.php';
?>
<section class="py-4">
  <div class="row align-items-center">
    <div class="col-md-7">
      <h2>Welcome to Kyles Final PHP Project Inventory Management System</h2>
      <p>View products, create an account, or sign in to manage inventory.</p>
      <a href="/products.php" class="btn btn-primary">Browse Products</a>
    </div>
    <div class="col-md-5">
      <img src="/hero.png" class="img-fluid" alt="Inventory illustration">
    </div>
  </div>
</section>

<?php include  '/includes/footer.php'; ?>
