<?php  
session_start();
$page = "Change Password";
/*
protect route
check if user is not authenticated
to redirect the user to login page
*/
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
}

require_once 'config/db.php';
require_once 'includes/head.php';
require_once 'includes/nav.php';

$user_id = $_SESSION['user_id'];
$error = false;
$new_pass = $current_pass = $confirm_pass = "";
$new_pass_err = $current_pass_err = $confirm_pass_err = "";

if($_SERVER['REQUEST_METHOD'] === "POST"){
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	$current_pass = trim($_POST['current_pass']);
	$new_pass = trim($_POST['new_pass']);
	$confirm_pass = trim($_POST['confirm_pass']);

	// validate input
	if (empty($current_pass)) {
		$error = true;
		$current_pass_err = "Current password is empty";
	}

	if (empty($new_pass)) {
		$error = true;
		$new_pass_err = "New password is empty";
	}else{
		if(strlen($new_pass) < 6){
			$error = true;
			$new_pass_err = "Password must be at least 6 characters";
		}
	}

	if (empty($confirm_pass)) {
		$error = true;
		$confirm_pass_err = "Confirm password is empty";
	}else{
		if($new_pass !== $confirm_pass){
			$error = true;
			$confirm_pass_err = "Passwords do not match";
		}
	}

	// if there is no error
	if (!$error) {
		$email = $_SESSION['email'];

		// prepare an sql query
		$sql = "SELECT * FROM users WHERE email= :email";
		// prepare statement
		if ($stmt = $pdo->prepare($sql)) {
			// bind param
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);

			// attempt to execute
			if ($stmt->execute()) {
				// check if email exist
				if ($row = $stmt->fetch()) {
					$hashed_password = $row['password'];
					if (password_verify($current_pass, $hashed_password)) {
						// hash password
						$new_password = password_hash($new_pass, PASSWORD_DEFAULT);
						// sucessfull match
						$sql = "UPDATE users SET password=:password WHERE id=:user_id";
						if ($query = $pdo->prepare($sql)) {
							// bind param
							$query->bindParam(":password", $new_password, PDO::PARAM_STR);
							$query->bindParam(":user_id", $user_id, PDO::PARAM_INT);

							// attempt to execute
							if ($query->execute()) {
								// password changed sucessfully
								$_SESSION['success-msg'] = "Password changed sucessfully";
								header("Location: myshares.php");
							}else{
								die("Error changing password");
							}
						}
					}else{
						// display wrong password
						$current_pass_err = "Current password is invalid";
					}
				}
				
			}else{
				// query fail to execute
				die("Somthing went wrong");
			}

		}
		unset($stmt);
	}

}


?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 mt-4">
			<?php require_once 'includes/sidebar.php'; ?>
		</div>
		<div class="col-md-9 mt-4">
			<h3>Change Password</h3>
			<hr>
			<div class="row">
		<div class="col-md-5">
			<p>Fill in your creadentials</p>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-group">
					<label for="current_pass">Current Password:</label>
					<input type="password" class="form-control <?php echo (!empty($current_pass_err)) ? 'is-invalid' : '' ?>" name="current_pass" value="<?php echo $current_pass; ?>" id="current_pass" placeholder="Enter your current password">
					<span class="invalid-feedback"><?php echo $current_pass_err; ?></span>
				</div>
				<div class="form-group">
					<label for="new_pass">New Password:</label>
					<input type="password" data-toggle="tooltip" title="minimum of six character" class="form-control <?php echo (!empty($new_pass_err)) ? 'is-invalid' : '' ?>" name="new_pass" value="<?php echo $new_pass; ?>" id="new_pass" placeholder="Enter your new password">
					<span class="invalid-feedback"><?php echo $new_pass_err; ?></span>
				</div>
				<div class="form-group">
					<label for="confirm_pass">Confirm Password:</label>
					<input type="password" class="form-control <?php echo (!empty($confirm_pass_err)) ? 'is-invalid' : '' ?>" name="confirm_pass" value="<?php echo $confirm_pass; ?>" id="confirm_pass" placeholder="Confirm your new password">
					<span class="invalid-feedback"><?php echo $confirm_pass_err; ?></span>
				</div>
				<input type="submit" class="btn btn-block bg-cyan" value="Change Password">
			</form>
		</div>
	</div>
		</div>
	</div>
</div>

<!-- end main content -->
<?php require_once 'includes/foot.php'; ?>