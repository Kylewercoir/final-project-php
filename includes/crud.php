<?php
class Crud {
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  // Create admin (register)
  public function createAdmin($name, $email, $password, $confirm) {
    if ($password !== $confirm) {
      return "Passwords do not match.";
    }

    $check = $this->conn->prepare("SELECT * FROM admins WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
      return "Email already exists.";
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hash]);
    return "Admin account created successfully!";
  }

  // Login
  public function login($email, $password) {
    $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
      return $user;
    }
    return false;
  }

  // Create product
  public function createProduct($name, $desc, $qty, $price, $image) {
    $stmt = $this->conn->prepare("INSERT INTO products (name, description, quantity, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $desc, $qty, $price, $image]);
    return "Product added successfully!";
  }

  // Read all products
  public function getProducts() {
    $stmt = $this->conn->query("SELECT * FROM products ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get single product
  public function getProductById($id): mixed {
    $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Update product
  public function updateProduct($id, $name, $desc, $qty, $price, $image): string {
    $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, quantity=?, price=?, image=? WHERE id=?");
    $stmt->execute([$name, $desc, $qty, $price, $image, $id]);
    return "Product updated!";
  }

  // Delete product
  public function deleteProduct($id): string {
    $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    return "Product deleted!";
  }
}
?>
