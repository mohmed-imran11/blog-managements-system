<?php
date_default_timezone_set('Africa/Mogadishu');
require "db_conn.php";

$msg = "";

if (isset($_POST['send'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token  = bin2hex(random_bytes(32));
        $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $conn->prepare(
            "UPDATE users 
             SET reset_token = ?, token_expire = ? 
             WHERE id = ?"
        )->execute([$token, $expire, $user['id']]);

        $link = "http://localhost/php-blog-website-main/php-blog-website-main/reset-password.php?token=$token";

        $msg = "Reset Link: <a href='$link'>$link</a>";
    } else {
        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .login-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            width: 650px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-card h4 {
            font-weight: 700;
            color: #220091;
        }

        .login-card .btn-primary {
            background-color: #220091;
            border: none;
        }

        .login-card .btn-primary:hover {
            background-color: #3a0fcf;
        }

        .login-card a {
            color: #220091;
            text-decoration: none;
        }

        .login-card a:hover {
            color: #3a0fcf;
        }

        .alert a {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <form method="post" class="login-card">
        <h4 class="mb-3">Forgot Password</h4>

        <?php if ($msg): ?>
            <div class="alert alert-info text-start"><?= $msg ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button name="send" class="btn btn-primary w-100">Send Reset Link</button>

        <div class="mt-3 text-center">
            <a href="login.php">Back to Login</a>
        </div>
    </form>

</body>

</html>