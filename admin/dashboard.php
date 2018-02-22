<?php
session_start();
$page = "Dashboard";
if (!isset($_SESSION['admin'])) {
	header("location: index.php");
}
require_once '../config/db.php';

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
        <li class="breadcrumb-item active">Welcome Admin | <?php echo $_SESSION['email']; ?></li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-4 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-share-alt"></i>
              </div>
              <div class="mr-5">
							<?php  
				  				$sql = "SELECT COUNT(id) FROM foods";
				  				if($stmt = $pdo->prepare($sql)){

				  					if($stmt->execute()){
				  						if($stmt->rowCount() > 0) {
				  							$num = $stmt->fetch();
				  							echo "<span class='badge badge-success'>".$num[0]."</span>";
				  						}else{
				  							echo "<span class='badge badge-primary'>0</span>";
				  						}
				  					}
				  				}
				  				unset($stmt);
				  			?>
               Shared Food</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="shares.php">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5">73 Tasks!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-users"></i>
              </div>
              <div class="mr-5">
							<?php  
				  				$sql = "SELECT COUNT(id) FROM users";
				  				if($stmt = $pdo->prepare($sql)){

				  					if($stmt->execute()){
				  						if($stmt->rowCount() > 0) {
				  							$num = $stmt->fetch();
				  							echo "<span class='badge badge-primary'>".$num[0]."</span>";
				  						}else{
				  							echo "<span class='badge badge-primary'>0</span>";
				  						}
				  					}
				  				}
				  				unset($stmt);
				  			?>
               registered users</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="users.php">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Bar Chart</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-8 my-auto">
   								<img src="includes/barchart.png" class="img-fluid" alt="pie chart">
                </div>
                <div class="col-sm-4 text-center my-auto">
                  <div class="h4 mb-0 text-primary">
                  	<?php  
						  				$sql = "SELECT COUNT(id) FROM foods";
						  				if($stmt = $pdo->prepare($sql)){

						  					if($stmt->execute()){
						  						if($stmt->rowCount() > 0) {
						  							$num = $stmt->fetch();
						  							echo $num[0];
						  						}else{
						  							echo '0';
						  						}
						  					}
						  				}
						  				unset($stmt);
						  			?>
                  </div>
                  <div class="small text-muted">Shares</div>
                  <hr>
                  <div class="h4 mb-0 text-warning">73</div>
                  <div class="small text-muted">Task</div>
                  <hr>
                  <div class="h4 mb-0 text-success">
										<?php  
						  				$sql = "SELECT COUNT(id) FROM users";
						  				if($stmt = $pdo->prepare($sql)){

						  					if($stmt->execute()){
						  						if($stmt->rowCount() > 0) {
						  							$num = $stmt->fetch();
						  							echo $num[0];
						  						}else{
						  							echo '0';
						  						}
						  					}
						  				}
						  				unset($stmt);
						  			?>
                  </div>
                  <div class="small text-muted">Users</div>
                </div>
              </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
        </div>
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> Pie Chart</div>
            <div class="card-body">
              <img src="includes/piechart.png" class="img-fluid" alt="pie chard">
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->

<?php require_once 'includes/foot.php'; ?>