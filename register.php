<?php
$page = "Register";

require_once 'config/db.php';

$error = false;
$name = $email = $phone = $password = $confirm_password = "";
$name_err = $email_err = $phone_err = $password_err = $confirm_password_err = "";

// chech to see if form is submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	// sanitize the post array
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	// store POST vars in regular variables
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);


	// validate name
	if(empty($name)){
		$error = true;
		$name_err = "Please enter a name";
	}

	// validate email
	if (empty($email)) {
		$error = true;
		$email_err = "Please enter email";
	}else{
		// prepare a select statement
		$sql = "SELECT id FROM users WHERE email= :email";

		if ($stmt = $pdo->prepare($sql)) {
			// bind variable
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);

			// attempt to execute
			if($stmt->execute()){
				// check if email exist
				if ($stmt->rowCount() === 1) {
					$error = true;
					$email_err = "Email is already taken";
				}
			}else{
				die('Something went wrong');
			}
		}
		unset($stmt);
	}

	// validate phone
	if(empty($phone)){
		$error = true;
		$phone_err = "Please enter a phone";
	}

	// validate password
	if(empty($password)){
		$error = true;
		$password_err = "Please enter a password";
	}elseif (strlen($password) < 6) {
		$error = true;
		$password_err = "Password must be at least 6 character";
	}

	// validate confirm_password
	if(empty($confirm_password)){
		$error = true;
		$confirm_password_err = "Please re-enter password";
	}else{
		if($password !== $confirm_password) {
			$error = true;
			$confirm_password_err = "Passwords don't match";
		}
	}

	// check to see if not error
	if(!$error){
		// hash password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// prepare sql insert query
		$sql = "INSERT INTO users(name, email, phone, password) VALUES(:name, :email, :phone, :password)";

		//  bind params
		if ($stmt = $pdo->prepare($sql)) {
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);

			// attempt to execute
			if ($stmt->execute()) {
				header("Location: login.php");
			}else{
				die("Something went wrong.");
			}
		}
		unset($stmt);

	}
	// close connection

}

require_once 'includes/head.php';
require_once 'includes/nav.php';
?>
<!-- begin main content -->
<div class="container">
	<div class="row">
		<div class="col-md-4 mx-auto">
			<div class="card card-body bg-light mt-2">
				<div class="text-center mb-2">
					<span class="fa-stack fa-5x text-primary">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-user fa-stack-1x fa-inverse"></i>
        	</span>
				</div>
				<p>Fill in this form to create your account</p>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control  <?php echo (!empty($name_err)) ? 'is-invalid' : '' ?>" name="name" id="name" value="<?php echo $name; ?>" placeholder="your full name">
						<span class="invalid-feedback"><?php echo $name_err; ?></span>
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control  <?php echo (!empty($email_err)) ? 'is-invalid' : '' ?>" name="email" id="email" value="<?php echo $email; ?>" placeholder="you@yourmail.com">
						<span class="invalid-feedback"><?php echo $email_err; ?></span>
					</div>
					<div class="form-group">
						<label for="phone">Phone:</label>
						<input type="tel" class="form-control  <?php echo (!empty($phone_err)) ? 'is-invalid' : '' ?>" name="phone" id="phone" value="<?php echo $phone; ?>" placeholder="Phone number">
						<span class="invalid-feedback"><?php echo $phone_err; ?></span>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" data-toggle="tooltip" title="minimum of six character" class="form-control  <?php echo (!empty($password_err)) ? 'is-invalid' : '' ?>" name="password" id="password" value="<?php echo $password; ?>" placeholder="Enter password">
						<span class="invalid-feedback"><?php echo $password_err; ?></span>
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm Password:</label>
						<input type="password" class="form-control  <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : '' ?>" name="confirm_password" id="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="confirm password">
						<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
					</div>
					<div class="form-row">
						<div class="col">
							<input type="submit" class="btn btn-success btn-block btn-lg" value="Register">
						</div>
						<div class="col">
							<a href="login.php" class="btn btn-light btn-block">Have an account? login</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end main content -->
<?php
require_once 'includes/footer.php';
require_once 'includes/foot.php'; 
?>