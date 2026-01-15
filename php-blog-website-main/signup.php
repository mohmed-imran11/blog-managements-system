<?php
require_once __DIR__ . "/db_conn.php";

$edit = false;
$user = null;


if (isset($_GET['id'])) {
	$edit = true;
	$id = $_GET['id'];

	$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->execute([$id]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$user) {
		die("User not found");
	}
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$fname   = $_POST['fname'];
	$lname   = $_POST['lname'];
	$username = $_POST['username'];
	$email   = $_POST['email'];
	$phone   = $_POST['phone'];
	$sex     = $_POST['sex'];
	$role    = strtolower($_POST['user_type']);
	$status  = $_POST['user_status'];

	$profile_picture = $edit ? $user['profile_picture'] : null;

	if (!empty($_FILES['profile_picture']['name'])) {

		$ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'webp'];

		if (!in_array($ext, $allowed)) {
			die("Invalid image type");
		}

		$profile_picture = uniqid("img_") . "." . $ext;

		move_uploaded_file(
			$_FILES['profile_picture']['tmp_name'],
			__DIR__ . "/uploads/" . $profile_picture
		);
	}


	if (!empty($_POST['password'])) {
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	}


	if ($edit) {

		$sql = "UPDATE users SET
                fname=?, lname=?, username=?, email=?, phone=?, sex=?,
                role=?, user_status=?, profile_picture=?";

		$params = [
			$fname,
			$lname,
			$username,
			$email,
			$phone,
			$sex,
			$role,
			$status,
			$profile_picture
		];

		if (!empty($_POST['password'])) {
			$sql .= ", password=?";
			$params[] = $password;
		}

		$sql .= " WHERE id=?";
		$params[] = $id;

		$stmt = $conn->prepare($sql);
		$stmt->execute($params);

		header("Location: admin/Users.php?success=User updated");
		exit;
	} else {

		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$stmt = $conn->prepare("
            INSERT INTO users
            (fname,lname,username,email,phone,sex,password,role,user_status,profile_picture)
            VALUES (?,?,?,?,?,?,?,?,?,?)
        ");

		$stmt->execute([
			$fname,
			$lname,
			$username,
			$email,
			$phone,
			$sex,
			$password,
			$role,
			$status,
			$profile_picture
		]);

		header("Location: admin/Users.php?success=User added successfully");
		exit;
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?= $edit ? 'Edit User' : 'Create Account' ?></title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<style>
		body {
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			background: #f2f2f2;
			font-family: 'Segoe UI', sans-serif;
		}

		form {
			width: 420px;
			background: #fff;
			padding: 30px;
			border-radius: 15px;
			box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
		}

		h3 {
			text-align: center;
			color: #220091;
			margin-bottom: 25px;
			font-weight: 700;
		}

		.form-control {
			margin-bottom: 12px;
			border-radius: 8px;
		}

		.btn-primary {
			background: #220091;
			border: none;
		}

		.btn-primary:hover {
			background: #3a0fcf;
		}
	</style>
</head>

<body>

	<form method="post" enctype="multipart/form-data">

		<h3><?= $edit ? 'Edit User' : 'Create Account' ?></h3>

		<?php if ($edit && !empty($user['profile_picture'])) { ?>
			<div class="text-center mb-3">
				<img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>"
					width="90" height="90"
					style="border-radius:50%;object-fit:cover;">
			</div>
		<?php } ?>

		<input class="form-control" name="fname" placeholder="First Name"
			value="<?= $edit ? htmlspecialchars($user['fname']) : '' ?>" required>

		<input class="form-control" name="lname" placeholder="Last Name"
			value="<?= $edit ? htmlspecialchars($user['lname']) : '' ?>" required>

		<select class="form-control" name="sex" required>
			<option value="">Select Sex</option>
			<option value="Male" <?= ($edit && $user['sex'] == 'Male') ? 'selected' : '' ?>>Male</option>
			<option value="Female" <?= ($edit && $user['sex'] == 'Female') ? 'selected' : '' ?>>Female</option>
		</select>

		<input class="form-control" name="username" placeholder="Username"
			value="<?= $edit ? htmlspecialchars($user['username']) : '' ?>" required>

		<input type="password" class="form-control" name="password"
			placeholder="<?= $edit ? 'New Password (optional)' : 'Password' ?>"
			<?= $edit ? '' : 'required' ?>>

		<input class="form-control" name="phone" placeholder="Phone"
			value="<?= $edit ? htmlspecialchars($user['phone']) : '' ?>" required>

		<input type="email" class="form-control" name="email" placeholder="Email"
			value="<?= $edit ? htmlspecialchars($user['email']) : '' ?>" required>

		<select class="form-control" name="user_type">
			<option value="user" <?= ($edit && $user['role'] == 'user') ? 'selected' : '' ?>>User</option>
			<option value="admin" <?= ($edit && $user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
		</select>

		<select class="form-control" name="user_status">
			<option value="Active" <?= ($edit && $user['user_status'] == 'Active') ? 'selected' : '' ?>>Active</option>
			<option value="Not Active" <?= ($edit && $user['user_status'] == 'Not Active') ? 'selected' : '' ?>>Not Active</option>
		</select>

		<input type="file" class="form-control" name="profile_picture" accept="image/*">

		<button class="btn btn-primary w-100 mt-2">
			<?= $edit ? 'Update User' : 'Sign Up' ?>
		</button>

	</form>

</body>

</html>