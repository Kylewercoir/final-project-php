<?php
include 'includes/db.php';
include 'includes/crud.php';
include 'includes/header.php';

$db = (new Database())->connect();
$crud = new Crud($db);
$products = $crud->getAllProducts();
?>

<div class="container">
  <h2 class="mb-4 text-center">All Products</h2>
  <div class="row">
    <?php foreach ($products as $p): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="images/<?php echo htmlspecialchars($p['image']); ?>" class="card-img-top" alt="Product">
          <div class="card-body">
            <h5><?php echo htmlspecialchars(string: $p['name']); ?></h5>
            <p><?php echo htmlspecialchars(string: $p['description']); ?></p>
            <p><strong>In Stock:</strong> <?php echo $p['quantity']; ?></p>
            <a href="single_product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">View</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
