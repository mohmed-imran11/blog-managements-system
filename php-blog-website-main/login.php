<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			height: 100vh;
			font-family: 'Segoe UI', sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.login-card {
			max-width: 400px;
			width: 100%;
			background: #fff;
			padding: 30px;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
			text-align: center;
		}

		.login-card h4 {
			font-size: 1.8rem;
			margin-bottom: 25px;
			color: #220091;
			font-weight: 700;
		}

		.form-control {
			font-size: 0.95rem;
			padding: 10px;
			border-radius: 8px;
		}

		.btn-primary {
			font-size: 1rem;
			padding: 10px;
			border-radius: 8px;
			background-color: #220091;
			border: none;
			transition: 0.3s;
		}

		.btn-primary:hover {
			background-color: #3a0fcf;
		}

		.links a {
			font-size: 0.85rem;
			margin-right: 15px;
			color: #220091;
			text-decoration: none;
			transition: 0.2s;
		}

		.links a:hover {
			text-decoration: underline;
			color: #3a0fcf;
		}

		.alert {
			font-size: 0.85rem;
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
	<form class="login-card" action="php/login.php" method="post">

		<h4>Login</h4>

		<?php if (isset($_GET['error'])) { ?>
			<div class="alert alert-danger" role="alert">
				<?= htmlspecialchars($_GET['error']); ?>
			</div>
		<?php } ?>

		<div class="mb-3 text-start">
			<label class="form-label">Username</label>
			<input type="text" name="uname" class="form-control"
				value="<?= isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : '' ?>" required>
		</div>

		<div class="mb-3 text-start">
			<label class="form-label">Password</label>
			<input type="password" name="pass" class="form-control" required>
		</div>

		<div class="mb-3 text-start">
			<label>
				<input type="checkbox" name="remember">
				Remember Me
			</label>
		</div>

		<button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

		<div class="d-flex justify-content-between links">
			<a href="admin-login.php">Admin Login</a>
			<a href="forgot-password.php">Forgot Password?</a>
		</div>

		<div class="d-flex justify-content-between links mt-2">
			<a href="blog.php">Blog</a>
			<a href="signup.php">Sign Up</a>
		</div>

	</form>
</body>

</html>