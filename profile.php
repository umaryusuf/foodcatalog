<?php  
	session_start();
	$page = "My Profile";
	/*
protect route
check if user is not authenticated
to redirect the user to login page
*/
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
}
// db connection
require_once 'config/db.php';

// global vars
$error = false;
$photo = $photo_err = "";
$user_id = $_SESSION['user_id'];

// update profile picture
if (isset($_POST['change_picture'])) {
	$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

	$photo = $_FILES['picture']["name"];
	$photo_temp = $_FILES['picture']['tmp_name'];
	$target_dir = "assets/images/users/";

	if (empty($photo)) {
		$photo = "user.jpg";
	}else{
  	// check for valid image extension
  	switch($_FILES['picture']['type']){
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


    if (!$error) {
    	// rename image before inserting to database
    	$photo = "oaccfl_user_".time().".".$ext;
    	// prepare an sql statement
    	$sql = "UPDATE users SET picture=:picture WHERE id=:user_id";

    	$stmt = $pdo->prepare($sql);
    	// bind param
    	$stmt->bindParam(':picture', $photo, PDO::PARAM_STR);
    	$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    	// only upload image if user select a new image
      if(!empty($_FILES['picture']['name'])){
        move_uploaded_file($photo_temp, $target_dir.$photo);
      }
      // prepare to execute 
  		if($stmt->execute()){
        $_SESSION['success-msg'] = "Picture updated sucessfully";
  		}else{
  			$_SESSION['danger-msg'] = "Error changing profile photo";
  		}
  		unset($stmt);
  		unset($pdo);
    }

  }
}

$name = $name_err = $phone = $photo_err = "";
// update profile info
if (isset($_POST['update_info'])) {
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	$name = ucwords(test_input($_POST['name']));
	$phone = test_input($_POST['phone']);

	// validate name
	if(empty($name)){
		$error = true;
		$name_err = "Please enter a name";
	}

	// validate phone
	if(empty($phone)){
		$error = true;
		$phone_err = "Please enter a phone";
	}

	// if no error
	if (!$error) {
		// prepare an sql statement
		$sql = "UPDATE users SET name=:name, phone=:phone WHERE id=:user_id";
		$stmt = $pdo->prepare($sql);
		// bind params
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
		$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

		 // prepare to execute 
		if($stmt->execute()){
			$_SESSION['name'] = $name;
      $_SESSION['success-msg'] = "profile info updated sucessfully";
		}else{
			$_SESSION['danger-msg'] = "error updating profile info";
		}
		unset($stmt);

	}


}

require_once 'includes/head.php';
require_once 'includes/nav.php';


	// fetch user data
	$sql = "SELECT * FROM users WHERE id=:user_id";
	if($stmt = $pdo->prepare($sql)){
		// bind param
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

		// attempt to excute
		if($stmt->execute()){
			// store data in a varible
			$data = $stmt->fetch();
		}
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 mt-4">
			<?php require_once 'includes/sidebar.php'; ?>
		</div>
		<div class="col-md-9 mt-4">
			<h3>My Profile</h3>
			<hr>
			<?php if (isset($_SESSION['success-msg']) || isset($_SESSION['danger-msg'])): ?>
				<?php if ($_SESSION['success-msg']): ?>
					<div class="alert alert-success alert-dismissable fade show">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Success! </strong><?php echo $_SESSION['success-msg']; ?>
					</div>
				<?php else: ?>
					<div class="alert alert-warning alert-dismissable fade show">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning! </strong><?php echo $_SESSION['danger-msg']; ?>
					</div>
			<?php endif; 
				unset($_SESSION['success-msg']);
				unset($_SESSION['danger-msg']);
			endif 
			?>
			<div class="row">
				<div class="col-md-4">
					<img src="assets/images/users/<?php echo $data['picture']; ?>" alt="<?php echo $data['name']; ?>" class="img-fluid profile-img">
				</div>
				<div class="col-md-8">
					<button type="button" class="btn btn-link text-cyan" id="changePic">Change profile picture</button>
					<br>
					<button type="button" class="btn btn-link text-cyan" id="editInfo">Edit profile info</button>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="changePicForm" class="hide">
						<div class="form-group">
							<label for="picture">Upload</label>
							<input type="file" name="picture" id="picture" class="<?php echo !empty($photo_err) ? 'is-invalid' : '' ?> form-control-file">
							<span class="invalid-feedback"><?php echo $photo_err; ?></span>
							<input type="submit" value="Upload" name="change_picture" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
			<table class="table " id="profileInfo">
				<thead>
					<tr>
						<th>Info</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Full Name</td>
						<td><?php echo $data["name"]; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $data["email"]; ?></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><?php echo $data["phone"]; ?></td>
					</tr>
				</tbody>
			</table>
			<div class="row " style="display: none" class="hide" id="editProfile">
				<div class="col-md-6" >
					<h5 class="mt-2">Edit Profile Info</h5>
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
						<div class="form-group">
							<label for="name">Full Name:</label>
							<input type="text" name="name" id="name" class="form-control <?php echo !empty($name_err) ? 'is-invalid' : '' ?>" value="<?php echo $data['name'] ?>">
							<span class="invalid-feedback"><?php echo $name_err ?></span>
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" name="email" disabled id="email" class="form-control" value="<?php echo $data['email'] ?>">
						</div>
						<div class="form-group">
							<label for="phone">Phone:</label>
							<input type="text" name="phone" id="phone" class="form-control <?php echo !empty($photo_err) ? 'is-invalid' : '' ?>" value="<?php echo $data['phone'] ?>">
							<span class="invalid-feedback"><?php echo $phone_err; ?></span>
						</div>
						<button type="submit" name="update_info" class="btn btn-success">Update profile info</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end main content -->
<?php require_once 'includes/foot.php';?>