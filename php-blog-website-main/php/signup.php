<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$fname  = $_POST['fname'];
	$lname  = $_POST['lname'];
	$uname  = $_POST['uname'];
	$sex    = $_POST['sex'];
	$phone  = $_POST['phone'];
	$email  = $_POST['email'];
	$role   = $_POST['user_type'];
	$status = $_POST['user_status'];

	// ========= EDIT USER =========
	if (isset($_POST['id'])) {
		$id = $_POST['id'];

		// fetch old data
		$old = $conn->prepare("SELECT password, profile_picture FROM users WHERE id=?");
		$old->execute([$id]);
		$oldUser = $old->fetch(PDO::FETCH_ASSOC);

		$password = $oldUser['password'];
		$profile  = $oldUser['profile_picture'];

		// password update
		if (!empty($_POST['pass'])) {
			$password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
		}

		// profile picture update
		if (!empty($_FILES['profile_picture']['name'])) {
			$profile = $_FILES['profile_picture']['name'];
			move_uploaded_file(
				$_FILES['profile_picture']['tmp_name'],
				__DIR__ . "/../uploads/" . $profile
			);
		}

		$sql = "UPDATE users SET
                fname=?, lname=?, username=?, password=?,
                sex=?, phone=?, email=?, profile_picture=?,
                role=?, user_status=?
                WHERE id=?";

		$stmt = $conn->prepare($sql);
		$stmt->execute([
			$fname,
			$lname,
			$uname,
			$password,
			$sex,
			$phone,
			$email,
			$profile,
			$role,
			$status,
			$id
		]);

		header("Location: ../admin/users.php?success=User updated");
		exit;
	}

	// ========= ADD USER =========
	$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
	$image = $_FILES['profile_picture']['name'];

	if (!empty($image)) {
		move_uploaded_file(
			$_FILES['profile_picture']['tmp_name'],
			__DIR__ . "/../uploads/" . $image
		);
	}

	$sql = "INSERT INTO users
    (fname,lname,username,password,sex,phone,email,profile_picture,role,user_status)
    VALUES (?,?,?,?,?,?,?,?,?,?)";

	$stmt = $conn->prepare($sql);
	$stmt->execute([
		$fname,
		$lname,
		$uname,
		$pass,
		$sex,
		$phone,
		$email,
		$image,
		$role,
		$status
	]);

	header("Location: ../signup.php?success=Account created");
	exit;
}
