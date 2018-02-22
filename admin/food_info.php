<?php  
session_start();
if (!isset($_SESSION['admin'])) {
	header("location: index.php");
}

$page = "Comments";
require_once '../config/db.php';

$share_id = $_GET['share_id'];


// an sql statement that select shared food
$sql = "SELECT * FROM foods WHERE id=:share_id";
if ($stmt = $pdo->prepare($sql)) {
	// bind param
	$stmt->bindParam(":share_id", $share_id, PDO::PARAM_INT);

	// attempt to execute
	if ($stmt->execute()) {
		if ($stmt->rowCount() === 1) {
			$data  = $stmt->fetch();
		}else{
			die("Shared food does not exist");
		}
	}else{
		die("Error executing code");
	}

}
unset($stmt);



// an sql select statement that selects data from users and comments table
$sql = "SELECT users.id, users.name, users.email, users.picture, comments.id AS com_id, comments.message FROM comments INNER JOIN users ON users.id=comments.user_id AND comments.share_id=:share_id ORDER BY comments.id DESC";
if ($stmt = $pdo->prepare($sql)) {
	// bind param
	$stmt->bindParam(":share_id", $share_id, PDO::PARAM_INT);

	// attempt to execute
	if ($stmt->execute()) {
		if ($stmt->rowCount() > 0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{
			// there is no comment yet
			$no_comment = "There is no comment yet";
		}
	}else{
		// error executing data
	}
}

unset($stmt);
require_once 'includes/head.php';
require_once 'includes/nav.php';
?>
<div class="content-wrapper">
	<div class="container">
		<!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="shares.php">Shares</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $data['food_name']; ?></li>
    </ol>			
		<div class="row">
			<div class="col-md-4 offset-1 mb-2">
				<div class="card">
					<img src="../assets/images/<?php echo $data['photo'] ?>" alt="<?php echo $data['food_name'] ?>" style="height: 210px" class="food-img card-img-top">
					<div class="card-body">
						<h4 class="card-title"><?php echo $data['food_name']; ?></h4>
						<p class="card-text"><?php echo $data['description']; ?></p>
						<hr>
						<p>Posted on: <?php echo $data['date_created']; ?></p>
					</div>
					<div class="card-footer" style="font-size: 16px">
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
			<div class="col-md-5 offset-1">
				<!-- show success or error messages if they exist -->
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
					endif ?>
				<?php if (!empty($message)): ?>
					<div class="alert alert-success alert-dismissable fade show">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Success! </strong><?php echo $message; ?>
					</div>
				<?php endif ?>
				<!-- tell the user if there is no comment
						or display all comment if there is -->
				<?php if (!empty($no_comment)): ?>
					<div class="card card-body bg-info"><?php echo $no_comment; ?></div>
				<?php else: ?>
					<!-- loop through all comments and display them -->
					<?php foreach ($result as $val): ?>
						<div class="card mb-2 ">
							<div class="card-body pb-2">
								<div class="row">
									<div class="col-md-3">
										<img src="../assets/images/users/<?php echo $val['picture']; ?>" alt="<?php echo $val['name'] ?>" class="img-comment img-fluid rounded-circle">
									</div>
									<div class="col-md-9">
										<h5 class="card-title mt-2 mb-0"><?php echo $val['name']; ?></h5>
										<p class="text"><?php echo $val["email"]; ?></p>
									</div>
								</div>
								
								<hr>
								<p class="font-italic">"<?php echo html_entity_decode($val['message']); ?>"</p>
							</div>	
						</div>
					<?php endforeach ?>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<?php  
require_once 'includes/foot.php';
?>