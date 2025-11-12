<?php
include 'includes/db.php';
include 'includes/crud.php';
include 'includes/header.php';

$db = (new Database())->connect();
$crud = new Crud($db);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $message = $crud->createUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm']);
}
?>

<div class="container">
  <h2 class="mb-4">Register Admin</h2>
  <?php if ($message): ?><div class="alert alert-info"><?php echo $message; ?></div><?php endif; ?>

  <form method="POST" class="col-md-6 mx-auto">
    <input type="text" name="name" placeholder="Name" class="form-control mb-2" required>
    <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
    <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
    <input type="password" name="confirm" placeholder="Confirm Password" class="form-control mb-3" required>
    <button class="btn btn-primary w-100">Register</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
