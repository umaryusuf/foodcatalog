<?php
session_start();
$page = "My Shares";

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
$message = "";
// prepare a select query
$sql = "SELECT * FROM foods WHERE user_id=:user_id ORDER BY id DESC";

if ($stmt = $pdo->prepare($sql)) {
	// bind param
	$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

	// attempt to execute
	if($stmt->execute()){
		// check if has any shares
		if($stmt->rowCount() > 0){
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$message = "You have no shares yet";
		}
	}else{
		$message = "Error fetching shares";
	}

	// close connection
	unset($stmt);
}


?>
<!-- start main content -->

<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 mt-4 ">
			<?php require_once 'includes/sidebar.php'; ?>
		</div>
		<div class="col-md-9 mt-4">
			<h3>My Shares</h3>
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
			<?php if (!empty($message)): ?>
				<div class="col-md-10">
					<div class="card bg-info">
						<div class="card-body">
							<br>
							<h3><?php echo $message; ?></h3>
							<br>
						</div>
					</div>
				</div>
			<?php else: 
				foreach ($result as $data): ?>

				<div class="col-sm-4 mb-2">
					<div class="card">
						<img src="assets/images/<?php echo $data['photo'] ?>" alt="Card Image" class="food-img card-img-top">
						<div class="card-body">
							<h4 class="card-title"><?php echo $data['food_name']; ?></h4>
							<p class="card-text"><?php echo $data['description']; ?></p>
							<hr>
							<p>Posted on: <?php echo $data['date_created']; ?></p>
							<div class="btn-group">
									<a href="edit_share.php?share_id=<?php echo $data['id']; ?>" class="btn btn-warning" style="color:#fff">&nbsp; Edit &nbsp;</a>
									<a href="delete_share.php?share_id=<?php echo $data['id']; ?>" id="deleteBtn" class="btn btn-danger btn-block">Delete</a>
									<a href="comments.php?share_id=<?php echo $data['id'] ?>" class="btn bg-cyan">comments</a>
							</div>
						</div>
						<div class="card-footer" style="font-size: 14px">
						<div class="row">
							<div class="col">
								<span class=""><i class="fa fa-heart"></i> <?php echo $data['likes']; ?> likes</span>
							</div>
							<div class="col">
								<span class="">
				  			<?php  
					  				$sql = "SELECT COUNT(id) FROM comments WHERE share_id=:share_id";
					  				if($stmt = $pdo->prepare($sql)){
					  					$stmt->bindParam(":share_id", $data["id"], PDO::PARAM_INT);

					  					if($stmt->execute()){
					  						if($stmt->rowCount() > 0) {
					  							$num = $stmt->fetch();
					  							echo '<i class="fa fa-comments-o"></i> '.$num[0].' comments';
					  						}else{
					  							echo '<i class="fa fa-comments-o"></i> 0 comment';
					  						}
					  					}
					  				}
					  			?>
				  			</span>
							</div>
						</div>
					</div>
					</div>
				</div>
				
			<?php endforeach;
				unset($stmt);
				unset($pdo);
				endif;
			 ?>

			</div> <!-- end row -->
		</div>
	</div>
</div>

<!-- end main content -->
<?php
require_once 'includes/footer.php';
require_once 'includes/foot.php'; 
?>