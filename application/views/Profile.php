<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Profile</title>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
	<?php $this->load->view('header'); ?>
	<div class="container mt-3">
		<div class="row justify-content-center">
			<div class="col-md-4">
				<!-- User details -->
				<div class="card mb-3">
					<img src="" class="card-img-top" alt="User Avatar">
					<div class="card-body">
						<p class="card-text">Email: <?= $email ?></p>
						<p class="card-text">Questions: <?= $num_questions ?></p>
						<p class="card-text">Correct answers: <?= $num_correct_answers ?></p>
						<p class="card-text">Votes Recieved: <?= $total_votes ?></p>
					</div>
				</div>
				<!-- Image upload form -->
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="avatar">Change Avatar</label>
						<input type="file" class="form-control-file" id="avatar" name="avatar">
					</div>
					<button type="submit" class="btn btn-primary">Upload</button>
				</form>
			</div>

			<div class="col-md-8">
				<div class="mb-3">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="questions-tab" data-toggle="tab" href="#questions"
								role="tab">Questions Asked</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="answers-tab" data-toggle="tab" href="#answers" role="tab">Answers
								Given</a>
						</li>
					</ul>
				</div>


				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="questions" role="tabpanel">
						<?php foreach ($questions as $question): ?>
							<div class="card mb-3">
								<div class="card-body">
									<div class="d-flex justify-content-between align-items-center">
										<h5 class="card-title"><?= $question['title'] ?></h5>
										<p class="card-text text-right" style="font-size:small">
											<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?>
											ago
										</p>
									</div>
									<p class="card-text"><?= $question['description'] ?></p>
									<p class="card-text">Answers:
										<?= $this->Question_model->get_answer_count($question['id']) ?>
									</p>
								</div>
							</div>
						<?php endforeach; ?>

					</div>
					<div class="tab-pane fade" id="answers" role="tabpanel">

						<?php foreach ($answers as $answer): ?>
							<div class="card mb-3">
								<div class="card-body">
									<h5 class="card-title"><?= $answer['question_title'] ?></h5>
									<p class="card-text"><?= $answer['answer'] ?></p>
								</div>
							</div>

						<?php endforeach; ?>

					</div>
				</div>
			</div>

		</div>
	</div>
	<script>
		$(function () {
			$('.nav-tabs a').click(function (e) {
				e.preventDefault();
				$(this).tab('show');
			});
		});
	</script>
</body>

</html>
