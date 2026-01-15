<?php
session_start();
require "db_conn.php";

if (isset($_SESSION['user_id'])) {
    $conn->prepare("UPDATE users SET remember_token=NULL, remember_expire=NULL WHERE id=?")
        ->execute([$_SESSION['user_id']]);
}

session_destroy();
setcookie("remember_token", "", time() - 3600, "/");
header("Location: login.php");
exit;
