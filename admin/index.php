<?php  
$page = "Admin Login";

require_once '../config/db.php';
$error = false;
$email = $email_err = $password = $password_err = "";

if(isset($_POST['login'])){
	// sanitize the post array
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	// store POST vars in regular variables
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	// validate email
	if (empty($email)) {
		$error = true;
		$email_err = "Please enter email";
	}else{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = true;
			$email_err = "Please enter email";
		}
	}

	// validate password
	if(empty($password)){
		$error = true;
		$password_err = "Please enter a password";
	}

	// if not error
	if (!$error) {
		// prepare an sql statement
		$sql = "SELECT * FROM admin WHERE email=:email";
		// prepare statement
		if ($stmt = $pdo->prepare($sql)) {
			// bind param
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);

			// attempt to execute
			if ($stmt->execute()) {
				// check if email exist
				if ($stmt->rowCount() === 1) {
					if ($row = $stmt->fetch()) {
						$hashed_password = $row['password'];
						if (password_verify($password, $hashed_password)) {
							// sucessfull login
							session_start();
							$_SESSION['admin'] = $row['id'];
							$_SESSION['email'] = $email;
							$_SESSION['name'] = $row['name'];
							header("Location: dashboard.php");
						}else{
							// display wrong password
							$password_err = "Invalid password";
						}
					}
				}else{
					// user does not exist
					$email_err = "No account found for that email";
				}
			}else{
				// query fail to execute
				die("Somthing went wrong");
			}
		}
	} else{
		die('Error exist');
	}
}

require_once 'includes/head.php';
?>

		<div class="container">
			<div class="row">
				<div class="col-md-4 mx-auto">
					<div class="card card-body bg-light mt-4">
						<div class="text-center mb-2">
							<span class="fa-stack fa-5x text-cyan">
		            <i class="fa fa-circle fa-stack-2x"></i>
		            <i class="fa fa-user fa-stack-1x fa-inverse"></i>
		        	</span>
							<h5>Admin Login</h5>
						</div>
						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							<div class="form-group">
								<label for="email">Email:</label>
								<input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : '' ?>" name="email" id="email" value="<?php echo $email; ?>" placeholder="you@yourmail.com">
								<span class="invalid-feedback"><?php echo $email_err; ?></span>
							</div>
							<div class="form-group">
								<label for="password">Password:</label>
								<input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : '' ?>" name="password" value="<?php echo $password ?>" id="password" placeholder="Enter your password">
								<span class="invalid-feedback"><?php echo $password_err; ?></span>
							</div>
							<input type="submit" name="login" class="btn bg-cyan btn-lg btn-block" value="Login">
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>