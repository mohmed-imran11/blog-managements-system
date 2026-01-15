<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Halkan ka sii wad koodkaaga
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	$logged = true;
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
	<div class="container-fluid">
		<a class="navbar-brand fw-bold" href="blog.php">
			My<span class="text-primary">Blog</span>
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
			aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : '' ?>" href="blog.php">Blog</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'category.php' ? 'active' : '' ?>" href="category.php">Category</a>
				</li>

				<?php if ($logged): ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-user me-1"></i>@<?= htmlspecialchars($_SESSION['username']) ?>
						</a>
						<ul class="dropdown-menu" aria-labelledby="userDropdown">
							<li><a class="dropdown-item" href="profile.php">Profile</a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
						</ul>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a class="nav-link btn btn-outline-primary ms-2" href="login.php">Login / Signup</a>
					</li>
				<?php endif; ?>
			</ul>

			<form class="d-flex" role="search" method="GET" action="blog.php">
				<input class="form-control me-2" type="search" name="search" placeholder="Search..." aria-label="Search">
				<button class="btn btn-outline-success" type="submit">Search</button>
			</form>
		</div>
	</div>
</nav>

<!-- Optional: add custom CSS -->
<style>
	.navbar-nav .nav-link.active {
		font-weight: 600;
		color: #0d6efd !important;
	}

	.navbar-nav .btn-outline-primary {
		padding: 0.35rem 0.75rem;
	}
</style>