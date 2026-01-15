<?php
session_start();
require_once "../db_conn.php";
// Handle login form submission
if (isset($_POST['uname']) && isset($_POST['pass'])) {
   $uname = trim($_POST['uname']);
   $pass  = trim($_POST['pass']);
   $remember = isset($_POST['remember']);
   $data = "uname=" . urlencode($uname);

   if (empty($uname)) {
      header("Location: ../login.php?error=Username required&$data");
      exit;
   }

   if (empty($pass)) {
      header("Location: ../login.php?error=Password required&$data");
      exit;
   }

   $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
   $stmt->execute([$uname]);

   if ($stmt->rowCount() !== 1) {
      header("Location: ../login.php?error=Incorrect username or password&$data");
      exit;
   }

   $user = $stmt->fetch();

   if (!password_verify($pass, $user['password'])) {
      header("Location: ../login.php?error=Incorrect username or password&$data");
      exit;
   }

   if ($user['user_status'] !== 'Active') {
      header("Location: ../login.php?error=Your account is not active");
      exit;
   }

   // ✅ login success
   $_SESSION['user_id'] = $user['id'];
   $_SESSION['username'] = $user['username'];
   $_SESSION['last_activity'] = time();

   if ($remember) {
      $token = bin2hex(random_bytes(32));
      $stmt = $conn->prepare("UPDATE users SET remember_token=? WHERE id=?");
      $stmt->execute([$token, $user['id']]);
      setcookie("remember_token", $token, time() + (7 * 24 * 60 * 60), "/"); // 7 days
   }

   header("Location: ../blog.php");
   exit;
} else {
   header("Location: ../login.php?error=Invalid request");
   exit;
}
