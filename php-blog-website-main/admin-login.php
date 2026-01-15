<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<style>
		body {
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: 'Segoe UI', Tahoma, sans-serif;
		}

		form {
			background-color: #fff;
			border-radius: 15px;
			padding: 30px;
			width: 400px;
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
			text-align: center;
		}

		form h4 {
			font-weight: 700;
			color: #220091;
		}

		form p {
			color: #555;
			margin-bottom: 25px;
		}

		.form-control:focus {
			border-color: #220091;
			box-shadow: 0 0 5px rgba(34, 0, 145, 0.5);
		}

		.btn-primary {
			background-color: #220091;
			border: none;
			width: 100%;
			margin-top: 10px;
		}

		.btn-primary:hover {
			background-color: #3a0fcf;
		}

		.links {
			margin-top: 15px;
			display: flex;
			justify-content: space-between;
		}

		.links a {
			text-decoration: none;
			color: #220091;
			font-weight: 500;
		}

		.links a:hover {
			color: #3a0fcf;
		}

		.alert {
			text-align: left;
		}

		@media (max-width: 480px) {
			form {
				width: 90%;
				padding: 20px;
			}
		}
	</style>
</head>

<body>
	<form action="admin/admin-login.php" method="post">
		<h4>ADMIN LOGIN</h4>
		<p>Only for Administrator</p>

		<?php if (isset($_GET['error'])) { ?>
			<div class="alert alert-danger" role="alert">
				<?php echo htmlspecialchars($_GET['error']); ?>
			</div>
		<?php } ?>

		<div class="mb-3">
			<label class="form-label">User name</label>
			<input type="text" class="form-control" name="uname"
				value="<?php echo (isset($_GET['uname'])) ? htmlspecialchars($_GET['uname']) : "" ?>">
		</div>

		<div class="mb-3">
			<label class="form-label">Password</label>
			<input type="password" class="form-control" name="pass">
		</div>

		<button type="submit" class="btn btn-primary">Login</button>

		<div class="links">
			<a href="login.php">User Login</a>
			<a href="forgot-password.php">Forgot Password?</a>
		</div>
	</form>
</body>

</html>