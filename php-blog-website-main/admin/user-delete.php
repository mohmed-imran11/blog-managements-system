<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
  header("Location: ../admin-login.php");
  exit;
}

if (!isset($_GET['id'])) {
  header("Location: users.php?error=User ID missing");
  exit;
}

$user_id = $_GET['id'];

require_once "../db_conn.php";
include_once("data/User.php"); // Make sure deleteById($conn, $user_id) exists

$res = deleteById($conn, $user_id);

if ($res) {
  $sm = "User deleted successfully!";
  header("Location: users.php?success=$sm");
  exit;
} else {
  $em = "Unknown error occurred!";
  header("Location: users.php?error=$em");
  exit;
}
