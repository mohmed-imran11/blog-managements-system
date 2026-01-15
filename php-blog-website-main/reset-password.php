<?php
date_default_timezone_set('Africa/Mogadishu');
require "db_conn.php";

if (!isset($_GET['token']) || empty($_GET['token'])) {
    die("Invalid token");
}

$token = trim($_GET['token']);

$stmt = $conn->prepare(
    "SELECT id 
     FROM users 
     WHERE reset_token = ? 
       AND token_expire IS NOT NULL
       AND token_expire > NOW()
     LIMIT 1"
);
$stmt->execute([$token]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Token expired or invalid");
}

$msg = "";

if (isset($_POST['reset'])) {
    $pass  = $_POST['password'];
    $cpass = $_POST['confirm'];

    if ($pass !== $cpass) {
        $msg = "Passwords do not match!";
    } elseif (strlen($pass) < 4) {
        $msg = "Password must be at least 4 characters!";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $update = $conn->prepare(
            "UPDATE users 
             SET password = ?, reset_token = NULL, token_expire = NULL 
             WHERE id = ?"
        );
        $update->execute([$hash, $user['id']]);

        header("Location: login.php?success=Password updated");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-card h4 {
            color: #220091;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-control {
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .btn-success {
            background-color: #220091;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-success:hover {
            background-color: #3a0fcf;
        }

        .alert {
            font-size: 0.9rem;
            text-align: left;
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
        <h4>Create New Password</h4>

        <?php if ($msg): ?>
            <div class="alert alert-danger"><?= $msg ?></div>
        <?php endif; ?>

        <input type="password" name="password" class="form-control" placeholder="New Password" required>
        <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required>

        <button name="reset" class="btn btn-success w-100">Save Password</button>
    </form>

</body>

</html>