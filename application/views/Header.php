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
				<a style="font-size: 40px" class="navbar-brand" href="<?php echo site_url('home'); ?>">Tec Tech</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarColor01">
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<h4 style="margin-left: 10px; color: white; padding-top: 20px;"><?= $title ?></h4>
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
					<?php if (isset($user_id) && $user_id): ?>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('user/profile'); ?>">Welcome, <?= $username ?></a>
							</li>
							<?php if ($title == 'Profile'): ?>
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
								<form action="<?php echo site_url('user/login'); ?>">
									<button class="btn btn-primary">Login</button>
								</form>
							</li>
							<li class="nav-item">
								<!-- <a class="nav-link" href="<?php echo site_url('user/register'); ?>">Sign Up</a> -->
								<form action="<?php echo site_url('user/register'); ?>">
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

		<!-- <div class="container">
			<div class="d-flex justify-content-between align-items-baseline mt-5">
				<div class="d-flex align-items-baseline">
					<h1><a href="<?php echo site_url('home'); ?>" style="text-decoration: none; color: inherit;">Tec Tech</a></h1>
					<h2 style="margin-left: 10px;"><?= $title ?></h2>
				</div>

				<div>
					<?php if (isset($user_id) && $user_id): ?>
						<div class="d-flex ">
							<h3>Welcome, <a href="<?php echo site_url('user/profile'); ?>"><?= $username ?></a></h3>
							<?php if ($title == 'Profile'): ?>
								<div class="ml-3">
									<form action="<?php echo site_url('user/logout'); ?>" method="post">
										<button type="submit" class="btn btn-danger">Logout</button>
									</form>
								</div>
							<?php endif; ?>
						</div>
					<?php else: ?>
						<a href="<?php echo site_url('user/login'); ?>">
							<button class="btn btn-primary">Login</button>
						</a>
						<a href="<?php echo site_url('user/register'); ?>">
							<button class="btn btn-secondary">Sign Up</button>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div> -->
	</body>	
</html>
