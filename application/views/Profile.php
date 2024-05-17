<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Profile</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		.question-list {
			height: 400px;
			overflow-y: auto;
		}

		.question-card {
			transition: transform .5s;
		}

		.question-card:hover {
			color: grey;
		}

		.question-card:active {
			transform: scale(0.99);
			color: grey;
		}
	</style>
</head>

<body>
	<?php $this->load->view('header'); ?>
	<div class="container mt-3">
		<div class="row justify-content-center">
			<div class="col-md-4">
				<!-- User details -->
				<div class="card mb-3">
					<div class="card-body">
						<p class="card-text">Email: <?= $email ?></p>
						<p class="card-text">Questions: <?= $num_questions ?></p>
						<p class="card-text">Correct answers: <?= $num_correct_answers ?></p>
						<p class="card-text">Votes Recieved: <?= $total_votes ?></p>
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class="mb-3">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="questions-tab" data-toggle="tab" href="#questions"
								role="tab">Questions Asked</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="answers-tab" data-toggle="tab" href="#answers" role="tab">Answers Given</a>
						</li>
					</ul>
				</div>


				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="questions" role="tabpanel">
						<div class="question-list">
							<?php if (empty($questions)): ?>
								<div class="alert alert-info" role="alert">
									No questions found.
								</div>
							<?php endif; ?>
							<?php foreach ($questions as $question): ?>
								<a href="<?php echo site_url('question/view/' . $question['id']); ?>"
									class="text-decoration-none" style="color:black; ">
									<div class="card mb-3 question-card">
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
								</a>

							<?php endforeach; ?>
						</div>

					</div>
					<div class="tab-pane fade" id="answers" role="tabpanel">
						<div class="question-list">
							<?php if (empty($answers)): ?>
								<div class="alert alert-info" role="alert">
									No Answers found.
								</div>
							<?php endif; ?>

							<?php foreach ($answers as $answer): ?>
								<a href="<?php echo site_url('question/view/' . $answer['question_id']); ?>"
									class="text-decoration-none" style="color:black; ">
									<div class="card mb-3 question-card">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center">

												<h5 class="card-title"><?= $answer['question_title'] ?></h5>
												<p class="card-text text-right" style="font-size:small">
													<?= strtolower(timespan(strtotime($answer['date_answered']), time(), 2)); ?>
													ago
												</p>
											</div>
											<p class="card-text"><?= $answer['answer'] ?></p>
										</div>
									</div>
								</a>

							<?php endforeach; ?>
						</div>

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