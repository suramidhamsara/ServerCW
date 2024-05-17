<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">

</head>

<body>
	<?php $this->load->view('header'); ?>
	<div class="container" style="padding-top: 8%;">
		<div class="row justify-content-center">
			<div class="col-md-6">

				<?php if (isset($error)): ?>
					<div class="alert alert-danger">
						<?= $error ?>
					</div>
				<?php endif; ?>
				<form action="<?= site_url('login') ?>" method="post">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<div class="form-group" style="padding-top: 40px">
						<button type="submit" class="btn btn-primary" style="height: 40px; width: 100px; margin: 0 auto 2rem; display: block;">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>