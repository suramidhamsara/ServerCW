<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Tec Teach - find solution</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css">
	<!-- Backbone.js + jquery + underscore.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
	<style>
		.question-list {
			height: 550px;
			overflow-y: auto;
		}

		.question-card {
			transition: transform .5s;
			color: black;
		}

		.question-card:hover {
			color: grey;
		}

		.question-card:active {
			transform: scale(0.99);
			color: grey;
		}
		h2 {
			text-align: center;
			padding-top: 30px;
			padding-bottom: 30px;
		}
	</style>
</head>

<body>
	<?php $this->load->view('Header'); ?>
	<div class="container">
		<?php if (!$isAskQueBtn): ?>
			<?php if (!$showForm): ?>
				<div class="row mt-3 mb-3">
					<form action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
						<button type="submit" name="askButton" class="btn btn-success">Ask Question</button>
					</form>
				</div>
			<?php else: ?>
				<hr>
				<h2>Ask a Question</h2>
				<div id="askForm" style="padding-top:20px">
					<?php echo validation_errors(); ?>
					<div class="form-group w-100">
						<form action="<?php echo site_url('home/ask_question'); ?>" method="post">
							<input type="text" class="form-control mb-3" name="title" placeholder="Question Title" style="height: 50px; margin-bottom: 3rem !important;">
							<textarea type="text" class="form-control mb-3" name="description"
								placeholder="Question Description" rows="10" style="margin-bottom: 2rem !important;"></textarea>
							<!-- <button type="submit" class="btn btn-primary" style="height: 40px; width: 100px; margin-bottom: 2rem !important;">Submit</button> -->
							<button type="submit" class="btn btn-primary" style="height: 40px; width: 100px; margin: 0 auto 2rem; display: block;">Submit</button>
						</form>
					</div>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div style="padding-bottom: 20px"></div>
			<h2>List of Questions</h2>
			<div class="row mt-3 mb-3">
					<form action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
						<button type="submit" name="askButton" class="btn btn-success">Ask Question</button>
					</form>
				</div>
		<?php endif; ?>

		<div class="question-list">
			<?php if (empty($questions)) : ?>
				<div class="alert alert-info mt-3" role="alert">
					No questions found.
				</div>
			<?php endif; ?>
			<div id="questions"></div>
		</div>
		<?php echo '<script>';
		echo 'var questionsData = ' . json_encode($questions) . ';';
		echo '</script>'; ?>
		<script>
			var Question = Backbone.Model.extend({
				defaults: {
					id: "",
					title: "",
					description: "",
					user_id: "",
					username: "",
					date_asked: "",
					is_solved: "",
					answer_count: "",
					time_span: ""
				}
			});
			var question = new Question();
			var QuestionView = Backbone.View.extend({
				model: Question,
				initialize: function() {
					this.render();
				},
				template: _.template(`
		<a href="<?php echo site_url('question/view/<%= id %>'); ?>" class="text-decoration-none text-black">
			<div class="question-card card mb-3 ">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-between">
						<h5 class="font-weight-bold card-title">
							<%= title %>
							<% if (is_solved == 1) { %>
							<span class="badge badge-success">Solved</span>
						<% } %>
						</h5>
						<p class=" text-right" style="font-size:14px;">by <%= username %>
						<span class=" text-secondary"><%= time_span %> ago</span>
						</p>
						</div>
						<hr>
						<p>
						<%= description %>
					</p>
					<p style="font-size:14px;">Answers: <%= answer_count %>
					</p>
				</div>
			</div>
		</a>`),
				render: function() {
					this.$el.html(this.template(this.model.attributes));
					return this;
				}
			});
			var Questions = Backbone.Collection.extend({
				model: Question
			});
			var QuestionsView = Backbone.View.extend({
				initialize: function() {
					this.render();
				},
				collection: Questions,
				iteratingFunction: function(question) {
					var questionView = new QuestionView({
						model: question
					});
					this.$el.append(questionView.el);
				},
				render: function() {
					this.collection.forEach(this.iteratingFunction, this);
				}
			});
			var question_collection = new Questions();
			question_collection.reset(questionsData)
			var questionsView = new QuestionsView({
				collection: question_collection,
			});
			$('#questions').append(questionsView.el);
		</script>
	</div>
	<!-- <?php $this->load->view('Footer'); ?> -->

	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

</body>

</html>