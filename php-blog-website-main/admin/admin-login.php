<?php


session_start();

if (isset($_POST['uname']) && isset($_POST['pass'])) {

   include "../db_conn.php";

   $uname = $_POST['uname'];
   $pass = $_POST['pass'];

   if (empty($uname)) {
      header("Location: ../admin-login.php?error=User name is required");
      exit;
   } else if (empty($pass)) {
      header("Location: ../admin-login.php?error=Password is required");
      exit;
   } else {
      $sql = "SELECT * FROM users WHERE username=? AND user_status='Active'";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$uname]);

      if ($stmt->rowCount() == 1) {
         $user = $stmt->fetch();

         if (password_verify($pass, $user['password'])) {

            if ($user['role'] == 'admin') {
               $_SESSION['admin_id'] = $user['id'];
               $_SESSION['username'] = $user['username'];
               $_SESSION['role'] = $user['role'];
               header("Location: post.php");
               exit;
            } else {
               $_SESSION['user_id'] = $user['id'];
               $_SESSION['username'] = $user['username'];
               $_SESSION['role'] = $user['role'];
               header("Location: ../index.php");
               exit;
            }
         } else {
            header("Location: ../admin-login.php?error=Incorect User name or password");
            exit;
         }
      } else {
         header("Location: ../admin-login.php?error=Incorect User name or password");
         exit;
      }
   }
} else {
   header("Location: ../admin-login.php");
   exit;
}
