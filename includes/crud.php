<?php
class Crud {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE ADMIN
    public function createAdmin($name, $email, $password, $confirm) {
        if ($password !== $confirm) {
            return "Passwords do not match!";
        }

        // Check duplicate email
        $check = $this->conn->prepare("SELECT * FROM admins WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            return "Email already registered!";
        }

        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);
        return "Admin registered successfully!";
    }

    // CREATE PRODUCT
    public function createProduct($name, $desc, $price, $inv, $imagePath) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, inventory, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price, $inv, $imagePath]);
        return "Product added!";
    }

    // READ ALL PRODUCTS
    public function getAllProducts() {
        $stmt = $this->conn->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ SINGLE PRODUCT
    public function getProduct($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE PRODUCT
    public function updateProduct($id, $name, $desc, $price, $inv, $image = null) {
        if ($image) {
            $sql = "UPDATE products SET name=?, description=?, price=?, inventory=?, image=? WHERE id=?";
            $params = [$name, $desc, $price, $inv, $image, $id];
        } else {
            $sql = "UPDATE products SET name=?, description=?, price=?, inventory=? WHERE id=?";
            $params = [$name, $desc, $price, $inv, $id];
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return "Product updated!";
    }

    // DELETE PRODUCT
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->execute([$id]);
        return "Product deleted!";
    }
}
