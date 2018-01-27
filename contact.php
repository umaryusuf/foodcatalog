<?php 
session_start();
$page = "Contact";

require_once 'includes/head.php';
require_once 'includes/nav.php';
?>
<!-- start main content -->
<div class="container">
	<div class="row">
		<div class="col-md-6 ">
			<div class="card card-body bg-light mt-2">
				<h3>Contact Us</h3>
				<p>Send your message, questions or recommendations</p>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<div class="form-group">
						<label for="name">Full Name:</label>
						<input type="text" class="form-control " name="name" id="name" value="" placeholder="your full name">
						<span class="invalid-feedback"></span>
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control " name="email" id="email" value="" placeholder="you@yourmail.com">
						<span class="invalid-feedback"></span>
					</div>
					<div class="form-group">
						<label for="phone">Phone:</label>
						<input type="tel" class="form-control " name="phone" id="phone" value="" placeholder="Phone number">
						<span class="invalid-feedback"></span>
					</div>
					<div class="form-group">
						<label for="message">Message:</label>
						<textarea name="message" id="message" class="form-control" rows="5"></textarea>
					</div>
					<input type="submit" class="btn btn-success btn-block" value="Send Message">
				</form>
			</div>
		</div>
		<div class="col-md-5 offset-1">
			<div class="mt-3">
				<h3>Address</h3>
				<p>You can also contact us on the adress below to get to know more about us and get your waina as soon as posible.</p>
				<br>
				<address>
					<p><span class="fa fa-envelope"></span> E-mail: info@site.com</p>
					<p><span class="fa fa-phone"></span> Phone: +234 806 **** ***</p>
					<p><span class="fa fa-map-marker"></span> NO. 22 - 26, food catalogue road</p>
					<p>Kaduna Nigeria.</p>
				</address>
			</div>
		</div>
	</div>
</div>

<!-- end main content -->
<?php
require_once 'includes/footer.php';
require_once 'includes/foot.php'; 
?>