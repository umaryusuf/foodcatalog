		<?php
		if(isset($_SESSION['user_id'])){
			$req = $pdo->prepare("SELECT picture FROM users WHERE id=:user_id");
			$req->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
			$req->execute();
			$pic = $req->fetch();
		}
		?>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-cyan">
			<a class="navbar-brand" href="index.php">OACCFL</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item <?php echo ($page === 'Home') ? 'active' : ''; ?>">
						<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item <?php echo ($page === 'About') ? 'active' : ''; ?>">
						<a class="nav-link" href="about.php">About</a>
					</li>
					<li class="nav-item <?php echo ($page === 'Contact') ? 'active' : ''; ?>">
						<a class="nav-link" href="contact.php">Contact</a>
					</li>
				</ul>
				<ul class="navbar-nav ">
					<?php if (isset($_SESSION['user_id'])): ?>
					<li class="nav-item dropdown active">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        <img src="assets/images/users/<?php echo $pic['picture']; ?>" class="nav-item rounded-circle img-fluid"  style="width: 30px; height: 30px;" alt=""> <?php echo $_SESSION['name']; ?>
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="myshares.php"><i class="fa fa-share-square fa-fw"></i> My Shares</a>
			        <a class="dropdown-item" href="share_food.php"><i class="fa fa-share-alt"></i> Share Food</a>
			        <a class="dropdown-item" href="profile.php"><i class="fa fa-user-o fa-fw"></i> My Profile</a>
			        <a class="dropdown-item text-danger  btop" href="logout.php"><i class="fa fa-sign-out fa-fw"></i> logout </a>
			      </div>
			    </li>
					<?php else: ?>
					<li class="nav-item <?php echo ($page === 'Register') ? 'active' : ''; ?>">
						<a class="nav-link" href="register.php">Register</a>
					</li>
					<li class="nav-item <?php echo ($page === 'Login') ? 'active' : ''; ?>">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					<?php endif ?>
				</ul>
			</div>
		</nav>