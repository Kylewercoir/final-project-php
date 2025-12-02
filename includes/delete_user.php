<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php';
$pdo = Database::getInstance()->getConnection();

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$delete_id = intval($_GET['id']);

// prevent deleting self
if ($delete_id === intval($_SESSION['user_id'])) {
    // redirect back or show message
    header("Location: users.php");
    exit;
}

// delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$delete_id]);

header("Location: users.php");
exit;
