<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
	header("Location: ../admin-login.php");
	exit;
}

require_once __DIR__ . "/../db_conn.php"; // sax path

// DELETE USER (role ka ma eegin)
if (isset($_GET['delete_id'])) {
	$delete_id = $_GET['delete_id'];

	$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
	$stmt->execute([$delete_id]);

	header("Location: Users.php?success=User deleted successfully");
	exit;
}

// Fetch all users & admins
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
	<title>Dashboard Users</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container mt-5">
		<h3>All Users
			<a href="../signup.php" class="btn btn-success btn-sm">Add New</a>
		</h3>

		<?php if (isset($_GET['success'])): ?>
			<div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
		<?php endif; ?>
		<?php if (isset($_GET['error'])): ?>
			<div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
		<?php endif; ?>

		<?php if (!empty($users)) { ?>
			<table class="table table-bordered table-striped mt-3">
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Sex</th>
					<th>Type</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>

				<?php foreach ($users as $u) { ?>
					<tr>
						<td><?= $u['id'] ?></td>
						<td><?= $u['fname'] . " " . $u['lname'] ?></td>
						<td><?= $u['username'] ?></td>
						<td><?= $u['email'] ?></td>
						<td><?= $u['phone'] ?></td>
						<td><?= $u['sex'] ?></td>
						<td><?= $u['role'] ?></td>
						<td><?= $u['user_status'] ?></td>
						<td>
							<a class="btn btn-primary btn-sm" href="../signup.php?id=<?= $u['id'] ?>">Edit</a>
							<a class="btn btn-danger btn-sm" href="?delete_id=<?= $u['id'] ?>"
								onclick="return confirm('Are you sure you want to delete this user?');">
								Delete
							</a>
						</td>
					</tr>
				<?php } ?>
			</table>
		<?php } else { ?>
			<p>No users found.</p>
		<?php } ?>
	</div>
</body>

</html>