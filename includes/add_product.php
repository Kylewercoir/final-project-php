<?php
include 'db.php';
include 'auth-check.php';
check_admin();

$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $image = $_FILES['image']['name'];

    if($_FILES['image']['tmp_name']){
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
    }

    $stmt = $pdo->prepare("INSERT INTO products (name,description,quantity,price,image) VALUES (?,?,?,?,?)");
    if($stmt->execute([$name,$description,$quantity,$price,$image])){
        $message = "Product added successfully!";
    } else {
        $message = "Failed to add product.";
    }
}
?>

<?php include 'header.php'; ?>

<h1>Add Product</h1>
<?php if($message) echo "<p>$message</p>"; ?>
<form action="" method="POST" enctype="multipart/form-data">
    <label>Name</label>
    <input type="text" name="name" required>
    <label>Description</label>
    <textarea name="description" required></textarea>
    <label>Quantity</label>
    <input type="number" name="quantity" required>
    <label>Price</label>
    <input type="text" name="price" required>
    <label>Image</label>
    <input type="file" name="image" required>
    <button type="submit">Add Product</button>
</form>

<?php include 'footer.php'; ?>
