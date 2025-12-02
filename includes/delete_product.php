<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php';
$pdo = Database::getInstance()->getConnection();

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit;
}

$id = intval($_GET['id']);

// fetch product to remove image file
$stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if ($row) {
    // delete DB row
    $del = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $del->execute([$id]);

    // delete image file if exists
    if (!empty($row['image']) && file_exists(__DIR__ . '/uploads/' . $row['image'])) {
        @unlink(__DIR__ . '/uploads/' . $row['image']);
    }
}

// optional message via GET (avoid session for simplicity)
header("Location: manage_products.php");
exit;
