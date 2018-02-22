<?php
session_start();
if (!isset($_SESSION['admin'])) {
	header("location: index.php");
}

$page = "Shares";
require_once '../config/db.php';

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
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="dashboard.php">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Shares Page</li>
    </ol>
		<div class="row">
			<?php foreach ($result as $data): ?>
			<div class="col-md-4 mb-2">
				<div class="card">
					<a href="food_info.php?share_id=<?php echo $data['id']; ?>">
						<img src="../assets/images/<?php echo $data['photo'] ?>" style="height: 200px" alt="<?php echo $data['food_name'] ?>" style="height: 250px" class="food-img card-img-top">
					</a>
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
			<?php 
				endforeach; 
				unset($stmt);
				unset($pdo);
			?>
		</div>
	</div>
</div>
<?php require_once 'includes/foot.php'; ?>