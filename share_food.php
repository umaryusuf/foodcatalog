<?php
session_start();
$page = "Share Food";
// require database connection file
require_once 'config/db.php';
/*
protect route
check if user is not authenticated
to redirect the user to login page
*/
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
}

$error = false;
$food_name_err = $photo_err = $description_err = "";
$photo = $food_name = $description = "";

if($_SERVER['REQUEST_METHOD'] === "POST") {
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	// put POSTS vars into regular variable
	$photo = $_FILES["photo"]["name"];
	$photo_temp = $_FILES["photo"]["tmp_name"];
	$food_name = trim($_POST["food_name"]);
	$description = trim($_POST["description"]);

	$target_dir = "assets/images/";

	if (empty($photo)) {
		$error = true;
		$photo_err = "Please select a photo";
	}
	
	// check for valid image extension
	switch($_FILES['photo']['type']){
    case 'image/jpeg':
    case 'image/jpg':
    	$ext = 'jpg'; 
    	break;
    case 'image/gif': 
    	$ext = 'gif'; 
    	break;
    case 'image/png': 
    	$ext = 'png'; 
    	break;
    case 'image/tiff': 
    	$ext = 'tif'; 
    	break;
    case 'image/webp': 
    	$ext = 'webp'; 
    	break;
    default: 
    	$ext = ''; 
    	break;
  }

  // validate extension
  if(!$ext){
    $error = true;
  	$photo_err = "Sorry, only JPG, JPEG, PNG, webp & GIF files are allowed.";
  }

  if(empty($food_name)){
  	$error = true;
  	$food_name_err = "Please enter food name";
  }

  if(empty($description)){
  	$error = true;
  	$description_err = "Please enter food description";
  }

  // if there is no error
  if(!$error && $ext){

  	// rename image before inserting to database
  	$photo = "oaccfl_".date('h_i_s').time().".".$ext;
  	$user_id = $_SESSION['user_id'];
  	$date_created = date("dS M, Y h:i:a");

  	// preapare an sql insert query
  	$sql = "INSERT INTO foods(food_name, description, photo, user_id, date_created) VALUES(:food_name, :description, :photo, :user_id, :date_created)";

  	// bind params
  	if($stmt = $pdo->prepare($sql)){
  		$stmt->bindParam(":food_name", $food_name, PDO::PARAM_STR);
  		$stmt->bindParam(":description", $description, PDO::PARAM_STR);
  		$stmt->bindParam(":photo", $photo, PDO::PARAM_STR);
  		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
  		$stmt->bindParam(":date_created", $date_created, PDO::PARAM_STR);

  		// prepare to execute and upload image
  		if($stmt->execute() && move_uploaded_file($photo_temp, $target_dir.$photo)){
  			// set a success message
  			$_SESSION['success-msg'] = "Food shared sucessfully";
  			// redirect to my shares
  			header("Location: myshares.php");
  		}else{
  			die("Error: executing code");
  		}
  	}
  	// close connection
  	unset($stmt);
  }


}

require_once 'includes/head.php';
require_once 'includes/nav.php';
?>
<!-- start main content -->

<div class="container">
	<div class="row">
		<div class="col-md-3 mt-4">
			<?php require_once 'includes/sidebar.php'; ?>
		</div>
		<div class="col-md-9 mt-4">
			<h3>Share Food</h3>
			<p>Fill in the form to share food</p>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="photo">Photo:</label>
							<input type="file" name="photo" class="form-control <?php echo (!empty($photo_err)) ? 'is-invalid' : ''; ?>" id="photo" >
							<span class="invalid-feedback"><?php echo $photo_err ?></span>
						</div>
						<div class="form-group">
							<label for="food_name">Food Name:</label>
							<input type="text" name="food_name" class="form-control <?php echo (!empty($food_name_err)) ? 'is-invalid' : ''; ?>" id="food_name" placeholder="Food Name" value="<?php echo $food_name; ?>">
							<span class="invalid-feedback"><?php echo $food_name_err ?></span>
						</div>
						<div class="form-group">
							<label for="description">Description:</label>
							<textarea name="description" id="description" data-toggle="tooltip" title="maximum of 150 characters" maxlength="150" rows="4" class="form-control  <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" placeholder="Food description"><?php echo $description; ?></textarea>
							<span class="invalid-feedback"><?php echo $description_err; ?></span>
						</div>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
					<br><br>	
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end main content -->
<?php
require_once 'includes/footer.php';
require_once 'includes/foot.php'; 
?>