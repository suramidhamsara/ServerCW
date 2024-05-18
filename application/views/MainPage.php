<!DOCTYPE html>
<html>
<head>
    <title>MainPage</title>
    <style>
        .centered-content {
            text-align: center;
            margin: auto;
            width: 70%;
            padding: 40px;
        }
        h1 {
            padding-bottom: 20px;
            padding-top: 20px
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php $this->load->view('Header'); ?>
    <div class="centered-content">
        <img src="../imgs/image1.jpg" alt="Your Image" style="display: block; margin: auto; width: 450px;">
        <h1>Welcome to Tec Teach Website</h1>
        <p>Welcome to Tec Teach, your ultimate destination for our website's purpose and services. Whether you're seeking specific offerings and solutions your website provides or looking to another benefit or feature, you've come to the right place. Our mission, providing you with unique selling points or advantages. Explore our diverse range of designed to we needs/solve your problems/help you achieve your goals. join our community of community members and embark on a journey of outcome users can expect. Start exploring now and discover the possibilities that await you!!!</p>
    </div>
    <?php if (!$showForm): ?>
        <div class="row"  style="margin-top: -40px;">
            <form class="mx-auto" action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
                <button type="submit" name="askButton" class="btn btn-success">Ask Question</button>
            </form>
        </div>
    <?php else: ?>
        <hr>
        <h5>Ask a Question</h5>
        <div id="askForm">
            <?php echo validation_errors(); ?>
            <div class="form-group w-100">
                <form action="<?php echo site_url('home/ask_question'); ?>" method="post">
                    <input type="text" class="form-control mb-3" name="title" placeholder="Question Title">
                    <textarea type="text" class="form-control mb-3" name="description"
                        placeholder="Question Description" rows="5"></textarea>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
    
</body>
</html>