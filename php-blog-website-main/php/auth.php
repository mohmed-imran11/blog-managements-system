<?php
// auth.php
session_start();
require "../db_conn.php";

// If session exists, do nothing
if (isset($_SESSION['user_id'])) return;

// If remember_me cookie exists
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $conn->prepare(
        "SELECT id, username FROM users 
         WHERE remember_token=? AND remember_expire > NOW() LIMIT 1"
    );
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    } else {
        setcookie("remember_token", "", time() - 3600, "/");
    }
}
