<?php
session_start();

// Check if user is logged in
$logged = false;
$user_id = null;

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	$logged = true;
	$user_id = $_SESSION['user_id'];
}

$notFound = 0;

// Include necessary files
require_once "db_conn.php";
include_once "admin/data/Post.php";
include_once "admin/data/Comment.php";

// Fetch posts
if (isset($_GET['search'])) {
	$key = $_GET['search'];
	$posts = serach($conn, $key);
	$notFound = ($posts == 0) ? 1 : 0;
} else {
	$posts = getAll($conn);
}

// Fetch categories
$categories = get5Categoies($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($_GET['search']) ? "Search '" . htmlspecialchars($_GET['search']) . "'" : "Blog Page" ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
		body {
			background: #f4f6f9;
			font-family: 'Segoe UI', sans-serif;
		}

		.main-blog-card {
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
		}

		.main-blog-card img {
			object-fit: cover;
			height: 200px;
		}

		.main-blog-card h5 {
			font-size: 1.2rem;
			font-weight: 600;
		}

		.main-blog-card p {
			font-size: 0.95rem;
			color: #555;
		}

		.react-btns i {
			cursor: pointer;
			margin-right: 5px;
		}

		.react-btns i.liked {
			color: #0d6efd;
		}

		aside.aside-main {
			width: 250px;
			margin-left: 20px;
		}

		.category-aside .list-group-item.active {
			background-color: #0d6efd;
			border-color: #0d6efd;
			color: #fff;
			font-weight: 600;
		}

		.container section {
			display: flex;
			flex-wrap: wrap;
		}

		main.main-blog {
			flex: 1 1 70%;
		}

		@media(max-width: 768px) {

			main.main-blog,
			aside.aside-main {
				flex: 1 1 100%;
				margin-left: 0;
				margin-top: 15px;
			}
		}
	</style>
</head>

<body>

	<?php include 'inc/NavBar.php'; ?>

	<div class="container mt-5">
		<section>
			<!-- Main Blog Posts -->
			<main class="main-blog">
				<?php if ($posts != 0) : ?>
					<?php if (isset($_GET['search'])) : ?>
						<h2 class="mb-4">Search results for "<b><?= htmlspecialchars($_GET['search']) ?></b>"</h2>
					<?php endif; ?>

					<?php foreach ($posts as $post) : ?>
						<div class="card main-blog-card mb-4">
							<img src="upload/blog/<?= $post['cover_url'] ?>" alt="<?= $post['post_title'] ?>" class="card-img-top">
							<div class="card-body">
								<h5 class="card-title"><?= $post['post_title'] ?></h5>
								<p class="card-text"><?= substr(strip_tags($post['post_text']), 0, 200) ?>...</p>
								<a href="blog-view.php?post_id=<?= $post['post_id'] ?>" class="btn btn-primary btn-sm">Read More</a>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<div class="react-btns">
										<?php if ($logged) :
											$liked = isLikedByUserID($conn, $post['post_id'], $user_id); ?>
											<i class="fa fa-thumbs-up <?= $liked ? 'liked' : '' ?> like-btn"
												post-id="<?= $post['post_id'] ?>"
												liked="<?= $liked ? 1 : 0 ?>"></i>
										<?php else : ?>
											<i class="fa fa-thumbs-up"></i>
										<?php endif; ?>
										Likes (<span><?= likeCountByPostID($conn, $post['post_id']) ?></span>)
										<a href="blog-view.php?post_id=<?= $post['post_id'] ?>#comments" class="ms-3">
											<i class="fa fa-comment"></i> Comments (<?= CountByPostID($conn, $post['post_id']) ?>)
										</a>
									</div>
									<small class="text-muted"><?= $post['crated_at'] ?></small>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

				<?php else : ?>
					<div class="alert alert-warning">
						<?= $notFound ? "No results found for '<b>" . htmlspecialchars($_GET['search']) . "</b>'" : "No posts available yet." ?>
					</div>
				<?php endif; ?>
			</main>

			<!-- Sidebar Categories -->
			<aside class="aside-main">
				<div class="list-group category-aside">
					<a href="#" class="list-group-item list-group-item-action active">Categories</a>
					<?php foreach ($categories as $cat) : ?>
						<a href="category.php?category_id=<?= $cat['id'] ?>" class="list-group-item list-group-item-action">
							<?= $cat['category'] ?>
						</a>
					<?php endforeach; ?>
				</div>
			</aside>
		</section>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".like-btn").click(function() {
				var post_id = $(this).attr('post-id');
				var liked = $(this).attr('liked');

				if (liked == 1) {
					$(this).attr('liked', '0');
					$(this).removeClass('liked');
				} else {
					$(this).attr('liked', '1');
					$(this).addClass('liked');
				}

				$(this).next().load("ajax/like-unlike.php", {
					post_id: post_id
				});
			});
		});
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>