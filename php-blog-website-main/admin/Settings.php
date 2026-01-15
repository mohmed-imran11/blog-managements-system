<?php
session_start();
require_once("../db_conn.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin-login.php");
    exit;
}

// Fetch current admin info
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$_SESSION['admin_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle POST update
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET fname=?, lname=?, email=?, phone=?, password=? WHERE id=?");
        $stmt->execute([$fname, $lname, $email, $phone, $password, $user['id']]);
    } else {
        $stmt = $conn->prepare("UPDATE users SET fname=?, lname=?, email=?, phone=? WHERE id=?");
        $stmt->execute([$fname, $lname, $email, $phone, $user['id']]);
    }

    $msg = "Settings updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .settings-card {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .settings-card h3 {
            color: #220091;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-control {
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #220091;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #3a0fcf;
        }

        .alert {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="settings-card">
        <h3>Admin Settings</h3>

        <?php if ($msg): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?= $user['fname'] ?>" required>
            <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?= $user['lname'] ?>" required>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $user['email'] ?>" required>
            <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= $user['phone'] ?>">
            <input type="password" name="password" class="form-control" placeholder="New Password (optional)">
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
    </div>

</body>

</html>