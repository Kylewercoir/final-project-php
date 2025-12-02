<?php
session_start();

function check_login() {
    if(!isset($_SESSION['user_id'])) {
        header("Location: /login.php");
        exit;
    }
}

function check_admin() {
    check_login();
    if($_SESSION['role'] != 'admin') {
        header("Location: /pages/index.php");
        exit;
    }
}
?>
