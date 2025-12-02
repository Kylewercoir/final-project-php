<?php
include "includes/header.php";
include_once "includes/inventory.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$inventory = new Inventory(require "includes/config.php");
$inventory->deleteProduct($_GET['id']);

header("Location: products.php");
exit;
