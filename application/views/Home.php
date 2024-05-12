<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Tec Tech - Qs for Techies</title>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">
	<style>
		.questions {
			height: 400px;
			overflow-y: auto;
		}
	</style>
</head>

<body>
	<?php $this->load->view('Header'); ?>
	<div class="container">

		<div class=" mt-3 mb-3">
			<input type="text" class="form-control" placeholder="Search questions...">
		</div>
		<!-- Ask Question button -->
		<div class="mb-3">
			<form action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
				<button type="submit" name="askButton" class="btn btn-success mb-3">Ask Question</button>
			</form>
		</div>

		<?php if ($isShowForm): ?>
			<div id="askForm">
				<?php echo validation_errors(); ?>
				<form action="<?php echo site_url('home/ask_question'); ?>" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="title" placeholder="Question Title">
					</div>
					<div class="form-group">
						<textarea id="editor1" type="text" class="form-control" name="description" placeholder="Question Description" rows="4" cols="50"></textarea>
					</div>
					<button type="submit" class="btn btn-primary mb-5">Submit</button>
				</form>
			</div>
		<?php endif; ?>


		<!-- List of questions -->
		<div class="questions">

			<?php foreach ($questions as $question): ?>
				<div class="card mb-3">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<h5 class="card-title"><?= $question['title'] ?></h5>
							<p class="card-text text-right" style="font-size:small">by <span
									class="font-weight-bold"><?= ucfirst(strtolower($question['username'])) ?></span>
								<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago
							</p>
						</div>


						<p class="card-text"><?= $question['description'] ?></p>
						<p class="card-text">Answers: <?= $this->Question_model->get_answer_count($question['id']) ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

</body>

</html>
