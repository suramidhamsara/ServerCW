<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?= $question['title'] ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
	<?php $this->load->view('Header'); ?>

	<div class="container mt-5">
		<h2><?= $question['title'] ?></h2>
		<p><?= $question['description'] ?></p>
		<p class="card-text text-right" style="font-size:small">asked by <span
				class="font-weight-bold"><?= ucfirst(strtolower($question['username'])) ?></span>
			<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago
		</p>

		<?php if ($question['is_solved']): ?>
			<p class="text-success">This question has been solved</p>

		<?php endif; ?>

		<hr>

		<div class="row mb-3">
			<div class="col-md-6">
				<h4>Answers</h4>
			</div>



			<div class="col-md-6 text-right">
				<form action="<?php echo site_url('question/view/' . $question['id'] . '/show_answer_form') ?>"
					method="post">
					<button type="submit" name="answerButton" class="btn btn-success">Add Answer</button>
				</form>
			</div>
		</div>



		<?php if ($showForm): ?>
			<div id="askForm">
				<?php echo validation_errors(); ?>
				<div class="form-group">

					<form action="<?php echo site_url('question/view/' . $question['id'] . '/answer/submit'); ?>"
						method="post">
						<div class="form-group">
							<textarea type="text" class="form-control" name="answer" placeholder="Enter Answer" rows="7"></textarea>
						</div>

						<button type="submit" class="btn btn-primary" style="height: 40px; width: 100px; margin: 0 auto 2rem; display: block;">Submit</button>
					</form>
				</div>
			</div>
		<?php endif; ?>

		<?php if (empty($question['answers'])): ?>
			<p>No answers yet.</p>
		<?php else: ?>


			<?php foreach ($question['answers'] as $answer): ?>
				<div class="card mb-3">
					<div class="card-body d-flex align-items-start">
						<div class="mr-3">
							<a
								href="<?php echo site_url('question/' . $question['id'] . '/answer/' . $answer['id'] . '/vote/up'); ?>">
								<span>&#x2191;</span>
							</a>

							<div><?= $answer['vote_count'] ?></div>

							<a
								href="<?php echo site_url('question/' . $question['id'] . '/answer/' . $answer['id'] . '/vote/down'); ?>">
								<span>&#x2193;</span>
							</a>
						</div>
						<div class="w-100">
							<p class="card-text"><?= $answer['answer'] ?></p>
							<?php if ($this->session->userdata('user_id') == $question['user_id'] && !($answer['is_correct'])): ?>
								<div class="row">
									<div class="col-auto">
										<form action="<?php echo site_url('answer/mark_as_correct') ?>" method="post">
											<input type="hidden" name="answer_id" value="<?= $answer['id'] ?>">
											<input type="hidden" name="question_id" value="<?= $question['id'] ?>">
											<button type="submit" class="btn btn-success">Mark as Correct</button>
										</form>
									</div>
									<div class="col-auto">
										<form action="<?php echo site_url('answer/delete_answer') ?>" method="post">
											<input type="hidden" name="answer_id" value="<?= $answer['id'] ?>">
											<input type="hidden" name="question_id" value="<?= $question['id'] ?>">
											<button type="submit" class="btn btn-danger">Delete</button>
										</form>
									</div>
								</div>
								
							<?php endif; ?>
							<?php if ($answer['is_correct']): ?>
								<i class="fas fa-check text-success fa-2x"></i>
							<?php endif; ?>
							<p class="card-text text-right" style="font-size:small">answered by <span
									class="font-weight-bold"><?= ucfirst(strtolower($answer['username'])) ?></span>
								<?= strtolower(timespan(strtotime($answer['date_answered']), time(), 2)); ?> ago
							</p>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		<?php endif; ?>

	</div>



</body>

</html>