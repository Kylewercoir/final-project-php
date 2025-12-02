<?php
if (session_status() === PHP_SESSION_NONE) session_start();
class Inventory {
    private $pdo;

    public function __construct($config) {
        $this->pdo = new PDO($config['dsn'], $config['user'], $config['pass']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // List all products
    public function getAllProducts() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single product
    public function getProduct($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add, Update, Delete (for logged-in users)
    public function addProduct($data) { /* ... */ }
    public function updateProduct($id, $data) { /* ... */ }
    public function deleteProduct($id) { /* ... */ }
}
