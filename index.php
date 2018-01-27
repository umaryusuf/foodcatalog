<?php
session_start();
require_once 'config/db.php';
$page = "Home";
$message = "";

// prepare and sql select query
$sql = "SELECT * FROM foods ORDER BY id DESC";

if($stmt = $pdo->prepare($sql)) {
	if ($stmt->execute()) {
		if ($stmt->rowCount() > 0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$message = "There is no share at the moment, please share or check back later";
		}
	}else{
		$message = "Error executing code";
	}
}

require_once 'includes/head.php';
require_once 'includes/nav.php';
?>
<!-- start main content -->
		<div id="particles-js" class="text-center mb-2">
			<div id="content">
				<h1>Online Africa Cuisine Catalogue for Food Lovers</h1>
				<p class="lead">Online Africa Cuisine Catalogue for Food Lovers is a platform that allows food lovers to share on African food, like on African food and comment on African food.</p>
				<?php if (isset($_SESSION['user_id'])): ?>
					<h3>Welcome <?php echo $_SESSION['name']; ?> - <?php echo $_SESSION['email']; ?></h3>	
					<a class="btn btn-primary" href="myshares.php" role="button"><i class="fa fa-share-square"></i> My Shares &raquo;</a>
					<a class="btn btn-primary" href="share_food.php" role="button"><i class="fa fa-share-alt"></i> Share Food &raquo;</a>
					<br>
					<i id="animate" class="icon fa fa-angle-double-down fa-5x animated bounce"></i>
					<h3 class="nice-font">See what others share</h3>
				<?php else:?>
				<a class="btn btn-lg btn-primary" href="register.php" role="button">Get Started &raquo;</a>
					<br>
					<i id="animate" class="icon fa fa-angle-double-down fa-5x animated bounce"></i>
					<h3 class="nice-font">See what others share</h3>
				<?php endif ?>
			</div>
		</div>
		<div class="container-fluid">
			<?php if (!empty($message)): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card bg-info">
							<div class="card-body">
								<br>
								<h3 class="mt-4 mx-auto mb-4"><?php echo $message ?></h3>
								<br>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="row">		
				<?php foreach ($result as $data): ?>
					<div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 mb-2">
						<div class="card">
							<img src="assets/images/<?php echo $data['photo'] ?>" alt="Card Image" class="food-img card-img-top">
							<div class="card-body">
								<h4 class="card-title"><?php echo $data['food_name']; ?></h4>
								<p class="card-text"><?php echo $data['description']; ?></p>
								<hr>
								<p>Posted on: <?php echo $data['date_created']; ?></p>
							</div>
							<?php if (isset($_SESSION['user_id'])): ?>
								<div class="card-footer" style="padding: 0;">
									<form action="like.php?share_id=<?php echo $data['id']; ?>" method="POST">
										<div class="btn-group" style="width: 100%">
											<?php if (!query($pdo, "SELECT id FROM likes WHERE share_id=:share_id AND user_id=:user_id", array(":share_id" => $data["id"], ":user_id" => $_SESSION['user_id']))): ?>
													<button type="button" id="likeBtn" class="btn btn-primary" data-id="<?php echo $data['id']; ?>" data-user-id="<?php echo  $_SESSION['user_id']; ?>" data-toggle="tooltip" title="likes">
													<i class="fa fa-heart-o"></i> like  
											  	<span class="badge badge-dark"><?php echo $data['likes']; ?> likes</span>
											  </button>
											<?php else: ?>
										  <button type="submit" id="likeBtn" class="btn btn-primary" data-id="<?php echo $data['id']; ?>" data-user-id="<?php echo  $_SESSION['user_id']; ?>" data-toggle="tooltip" title="likes">
												<i class="fa fa-heart"></i> Unlike 
										  	<span class="badge badge-dark"><?php echo $data['likes']; ?> likes</span>
										  </button> &nbsp;
										<?php endif ?>
										  <a href="comments.php?share_id=<?php echo $data['id']; ?>" class="btn btn-primary" data-toggle="tooltip" title="comments">
										  	<i class="fa fa-comments-o"></i> 
										  	 
										  		<span class="badge badge-dark">
										  			<?php  
											  				$sql = "SELECT COUNT(id) FROM comments WHERE share_id=:share_id";
											  				if($stmt = $pdo->prepare($sql)){
											  					$stmt->bindParam(":share_id", $data["id"], PDO::PARAM_INT);

											  					if($stmt->execute()){
											  						if($stmt->rowCount() > 0) {
											  							$num = $stmt->fetch();
											  							echo '<span class="badge badge-dark">'.$num[0].' comments</span>';
											  						}else{
											  							echo '<span class="badge badge-dark">0 comment</span>';
											  						}
											  					}
											  				}
											  			?>
										  		</span>
										  	</span>
										  </a>
										</div>
									</form>
								</div>
							<?php else: ?>
								<div class="card-footer">
									<div class="row">
										<div class="col">
											<span class="badge badge-dark"><i class="fa fa-heart"></i> <?php echo $data['likes']; ?> likes</span>
										</div>
										<div class="col">
											<span class="badge badge-dark">
							  			<?php  
								  				$sql = "SELECT COUNT(id) FROM comments WHERE share_id=:share_id";
								  				if($stmt = $pdo->prepare($sql)){
								  					$stmt->bindParam(":share_id", $data["id"], PDO::PARAM_INT);

								  					if($stmt->execute()){
								  						if($stmt->rowCount() > 0) {
								  							$num = $stmt->fetch();
								  							echo '<span class="badge badge-dark"> <i class="fa fa-comments-o"></i> '.$num[0].' comments</span>';
								  						}else{
								  							echo '<span class="badge badge-dark"><i class="fa fa-comments-o"></i> 0 comment</span>';
								  						}
								  					}
								  				}
								  			?>
							  			</span>
										</div>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
				<?php endforeach ?>
			<?php 
					unset($stmt);
					unset($pdo);
				endif 
			?>

			</div> <!-- end row -->
		</div>

<!-- end main content -->
<?php
require_once 'includes/footer.php';
?>
<script src="assets/js/particles.min.js"></script>
<script>
	particlesJS.load('particles-js', 'particles.json', function(){
		console.log("particles-js loaded");
	});
</script>
<?php
require_once 'includes/foot.php'; 
?>