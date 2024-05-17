<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<html>
	<head>
		<title>Tec Tech</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">
		<script src="http://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
			<div class="container-fluid">
				<a style="font-size: 40px" class="navbar-brand" href="<?php echo site_url('mainPage'); ?>">Tec Tech</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarColor01">
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<h4 style="margin-left: 10px; color: white; padding-top: 20px;"><?= isset($title) ? $title : '' ?></h4>
						</li>
						<li class="nav-item">
							<form style="padding-top: 10px;" action="<?php echo site_url('home/hide_ask_que_btn'); ?>">
								<button class="btn btn-secondary" style="margin-left: 20px;">View Questions</button>
							</form>
						</li>
						<!-- <li class="nav-item">
							<a class="nav-link" href="#">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Blog</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Categories</a>
						</li> -->
					</ul>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item mx-auto">
							<form class="form-inline" action="<?php echo site_url('home/search'); ?>" method="get">
								<div class="input-group w-100">
									<input class="form-control mr-sm-2" style="width: 600px" type="search" placeholder="Search Questions..."
										aria-label="Search" name="search"
										value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
									<div class="input-group-append">
										<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
									</div>
								</div>
							</form>
						</li>
					</ul>
					<?php if (isset($user_id) && $user_id): ?>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('user/profile'); ?>">Welcome, <?= $username ?></a>
							</li>
							<?php if (isset($title) && $title == 'Profile'): ?>
								<li class="nav-item">
									<form action="<?php echo site_url('user/logout'); ?>" method="post">
										<button type="submit" class="btn btn-danger">Logout</button>
									</form>
								</li>
							<?php endif; ?>
						</ul>
					<?php else: ?>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item" style="padding-right: 10px;">
								<!-- <a class="nav-link" href="<?php echo site_url('user/login'); ?>">Login</a> -->
								<form action="<?php echo site_url('login'); ?>">
									<button class="btn btn-primary">Login</button>
								</form>
							</li>
							<li class="nav-item">
								<!-- <a class="nav-link" href="<?php echo site_url('user/register'); ?>">Sign Up</a> -->
								<form action="<?php echo site_url('register'); ?>">
									<button class="btn btn-secondary">Sign Up</button>
								</form>
							</li>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</nav>
		<script>
            CKEDITOR.replace( 'editor1' );
        </script>
	</body>	
</html>
