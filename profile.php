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

$user_id = $_SESSION['user_id'];

require_once 'config/db.php';
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
<div class="container">
	<div class="row">
		<div class="col-md-3 mt-4">
			<?php require_once 'includes/sidebar.php'; ?>
		</div>
		<div class="col-md-9 mt-4">
			<h3>My Profile</h3>
			<hr>
			<div class="row">
				<div class="col-md-4">
					<img src="assets/images/users/<?php echo $data['picture']; ?>" alt="<?php echo $data['name']; ?>" class="img-fluid profile-img">
				</div>
				<div class="col-md-8">
					<button type="button" class="btn btn-link " id="changePic">Change profile picture</button>
					<br>
					<button type="button" class="btn btn-link" id="editInfo">Edit profile info</button>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="hide">
						<div class="form-group">
							<label for="picture">Upload</label>
							<input type="file" name="picture" id="picture" class="form-control-file">
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
			<div class="row " id="editProfile">
				<div class="col-md-6">
					<h5>Edit Profile Info</h5>
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="">
						<div class="form-group">
							<label for="name">Full Name:</label>
							<input type="text" name="name" id="name" class="form-control">
							<span class="invalid-feedback"></span>
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="text" name="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label for="phone">Phone:</label>
							<input type="text" name="phone" id="phone" class="form-control">
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