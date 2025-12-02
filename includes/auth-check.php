<?php
session_start();

/**
 * Check if a user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if a user is an admin
 */
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Redirect non-logged-in users to login page
 */
function check_login() {
    if (!is_logged_in()) {
        header("Location: ../login.php");
        exit;
    }
}

/**
 * Redirect non-admin users to home page
 */
function check_admin() {
    if (!is_logged_in() || !is_admin()) {
        header("Location: ../index.php");
        exit;
    }
}
