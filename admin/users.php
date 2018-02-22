<?php
session_start();
if (!isset($_SESSION['admin'])) {
	header("location: index.php");
}

$page = "Users";
require_once '../config/db.php';

// prepare and sql select query
$sql = "SELECT * FROM users ORDER BY id DESC";

if($stmt = $pdo->prepare($sql)) {
	if ($stmt->execute()) {
		if ($stmt->rowCount() > 0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$message = "There is no registered user at the moment";
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
      <li class="breadcrumb-item active">Users Page</li>
    </ol>
		<div class="row">
			<?php foreach ($result as $data): ?>
				<div class="col-md-3 mb-2">
				<div class="card">
					<img src="../assets/images/users/<?php echo $data['picture'] ?>" style="height: 200px" alt="<?php echo $data['name'] ?>" style="height: 250px" class="food-img card-img-top">
					<div class="card-body">
						<h4 class="card-title"><?php echo $data['name']; ?></h4>
						<p class="card-text"><?php echo $data['email']."<br>".$data['phone']; ?></p>
					</div>
				</div>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
<?php require_once 'includes/foot.php'; ?>