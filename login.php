<?php
session_start();
// prevent logged in user from acessing this page
if (isset($_SESSION['user_id'])) {
	header('Location: index.php');
}

$page = "Login";

require_once 'config/db.php';

$error = false;
$email = $password = "";
$email_err = $password_err = "";

// chech to see if form is submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	// sanitize the post array
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	// store POST vars in regular variables
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	// validate email
	if (empty($email)) {
		$error = true;
		$email_err = "Please enter email";
	}

	// validate password
	if(empty($password)){
		$error = true;
		$password_err = "Please enter a password";
	}
	

	// check to see if no error
	if (!$error) {
		// prepare sql query
		$sql = "SELECT * FROM users WHERE email= :email";
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
							$_SESSION['user_id'] = $row['id'];
							$_SESSION['email'] = $email;
							$_SESSION['name'] = $row['name'];
							header("Location: index.php");
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
		unset($stmt);
	}
	unset($pdo);
}

require_once 'includes/head.php';
require_once 'includes/nav.php';
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
				</div>
				<p>Fill in your credentials to login</p>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : '' ?>" name="email" id="email" value="<?php echo $email; ?>" placeholder="you@yourmail.com">
						<span class="invalid-feedback"><?php echo $email_err; ?></span>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : '' ?>" name="password" value="<?php echo $password ?>" id="password" placeholder="Enter your password">
						<span class="invalid-feedback"><?php echo $password_err; ?></span>
					</div>
					<input type="submit" class="btn bg-cyan btn-lg btn-block" value="Login">
					<a href="register.php" class="btn btn-link text-cyan btn-block">Don't have an account? register</a>
				</form>
			</div>
		</div>
	</div>
</div>


<?php require_once 'includes/foot.php'; ?>