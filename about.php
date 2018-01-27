<?php
session_start();
$page = "About";

require_once 'includes/head.php';
require_once 'includes/nav.php';
?>
<!-- start main content -->
		<div id="particles-js" class="text-center mb-2">
			<div id="content">
				<h1 class="mt-5">About Us</h1>
				<p class="lead">Online Africa Cuisine Catalogue for Food Lovers is a platform that allows food lovers to share on African food, like on African food and comment on African food.</p>
			</div>
		</div>
		<br>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h4>About</h4>
				</div>
				<div class="col-md-8">
					<h5>We allows food lovers to share, like, and comment on African food.</h5>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem id corporis laboriosam iure nemo aliquid hic, dolor fuga commodi quasi labore consectetur asperiores possimus magnam ipsa! Illum, saepe reprehenderit totam eius inventore quo consequatur cum dicta repellendus asperiores unde nulla, tempora molestias repudiandae, ipsa nihil recusandae debitis accusantium tempore vero.
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<h4>What we do</h4>

				</div>
				<div class="col-md-8">
					<h5>We share, like, and comment on African food.</h5>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem id corporis laboriosam iure nemo aliquid hic, dolor fuga commodi quasi labore consectetur asperiores possimus magnam ipsa! Illum, saepe reprehenderit totam eius inventore quo consequatur cum dicta repellendus asperiores unde nulla, tempora molestias repudiandae, ipsa nihil recusandae debitis accusantium tempore vero.
				</div>
			</div>
		</div>

<!-- end main content -->
<?php require_once 'includes/footer.php'; ?>
<script src="assets/js/particles.min.js"></script>
<script>
	particlesJS.load('particles-js', 'particles.json', function(){
		console.log("particles-js loaded");
	});
</script>
<?php require_once 'includes/foot.php'; ?>