<?php  
session_start();
$page = "Comments";
// require db connection
require_once 'config/db.php';

$message = $no_comment = $msg_comment = $comment_err = "";
$share_id = $_GET['share_id'];
$user_id = null;

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
}

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

if (isset($_POST['add_comment'])) {
	$error = false;
	// sanitize post array
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	// put POST var into regular variables
	$msg = test_input($_POST['message']);

	// validate input
	if(empty($msg)){
		$comment_err = "Comment field is empty";
	}else{
		// an sql statement that insert users comments
		$sql = "INSERT INTO comments(share_id, user_id, message) VALUES(:share_id, :user_id, :message)";
		if ($stmt = $pdo->prepare($sql)) {
			// bind param
			$stmt->bindParam(":share_id", $share_id, PDO::PARAM_INT);
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->bindParam(":message", $msg, PDO::PARAM_STR);

			// attempt to execute
			if($stmt->execute()){
				$message = "Comment added sucessfully";
			}else{
				$message = "Error post comment";
			}

		}
		unset($stmt);
	}

}

if (isset($_POST['update_comment'])) {
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	// put POST vars into regular variables
	$comment_id = $_POST['comment_id'];
	$msg = test_input($_POST['message']);

	if (empty($msg)) {
		$comment_err = "Comment field is empty";
	}else{
		// an sql statement that update users comments
		$update_sql = "UPDATE comments SET message=:message WHERE id=:id AND user_id=:user_id";

		if ($query = $pdo->prepare($update_sql)) {
			// bind params
			$query->bindParam(":message", $msg, PDO::PARAM_STR);
			$query->bindParam(":id", $comment_id, PDO::PARAM_INT);
			$query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			
			// attempt to execute
			if ($query->execute()) {
				// sucessfully updated
				$message = "Comment updated sucessfully";
			}else{
				// failed to execute
				$message = "Error updating comments";
			}
		}		
		unset($query);
	}

}
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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center mt-3"><?php echo $data['food_name']; ?></h3>
			<hr>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<img src="assets/images/<?php echo $data['photo'] ?>" alt="Card Image" style="height: 250px" class="food-img card-img-top">
					<div class="card-body">
						<h4 class="card-title"><?php echo $data['food_name']; ?></h4>
						<p class="card-text"><?php echo $data['description']; ?></p>
						<hr>
						<p>Posted on: <?php echo $data['date_created']; ?></p>
					</div>
					<div class="card-footer" style="padding: 0;">
						<form action="like.php?share_id=<?php echo $data['id']; ?>" method="POST">
							<div class="btn-group" style="width: 100%">
							  <a href="#" id="likeBtn" class="btn btn-primary" data-id="<?php echo $data['id'] ?>" data-toggle="tooltip" title="likes">
									<i class="fa fa-thumbs-up"></i> <span class="text"> <span class="badge badge-dark">11</span></span>
							  </a>
							  <a href="comments.php?share_id=<?php echo $share_id; ?>" class="btn btn-primary" data-toggle="tooltip" title="comments">
							  	<i class="fa fa-comments-o"></i> 
							  	<span class="text"> 
							  		<span class="badge badge-dark">
							  			<?php  
								  				$sql = "SELECT COUNT(id) FROM comments WHERE share_id=:share_id";
								  				if($stmt = $pdo->prepare($sql)){
								  					$stmt->bindParam(":share_id", $data["id"], PDO::PARAM_INT);

								  					if($stmt->execute()){
								  						if($stmt->rowCount() > 0) {
								  							$num = $stmt->fetch();
								  							echo $num[0];
								  						}else{
								  							echo "0";
								  						}
								  					}
								  				}
								  				unset($stmt);
								  				unset($pdo);
								  			?>
							  		</span>
							  	</span>
							  </a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6 offset-2">
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
				<!-- only show comment box if the user is logged in 
					or ask the user to please login to add comment-->
				<?php if (isset($_SESSION['user_id'])): ?>
					<h3>Add comment</h3>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?share_id='.$share_id; ?>" method="post">
						<div class="form-group">	
							<label for="message">Your comment:</label>
							<textarea name="message" id="message" rows="3" class="form-control <?php echo ($comment_err !== '') ? 'is-invalid' : '' ?>"></textarea>
							<span class="invalid-feedback"><?php echo $comment_err; ?></span>
						</div>
						<button type="submit" name="add_comment" class="btn btn-primary">Add Comment <i class="fa fa-comment-o"></i></button>
					</form>
					<hr>
				<?php else: ?>
					<div class="alert alert-info alert-dismissable fade show">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>info! </strong>please <a href="login.php">login</a> to add comment
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
										<img src="assets/images/users/<?php echo $val['picture']; ?>" alt="<?php echo $val['name'] ?>" class="img-comment img-fluid rounded-circle">
									</div>
									<div class="col-md-9">
										<h5 class="card-title mt-2 mb-0"><?php echo $val['name']; ?></h5>
										<p class="text"><?php echo $val["email"]; ?></p>
									</div>
								</div>
								
								<hr>
								<p class="font-italic">"<?php echo html_entity_decode($val['message']); ?>"</p>
								<!-- check if the user post the comment and the show edit and delete options
										or hide the the user didn't post the comment -->
								<?php if ($val["id"] === $user_id): ?>
									<hr>
									<p>
										<button type="button" class="btn btn-link" id="editBtn">Edit Comment</button> 
										 &nbsp; - &nbsp;&nbsp; 
										<a href="delete_comment.php?oaccfl=<?php echo $val['com_id'].'&share_id='.$share_id; ?>" id="deleteBtn" class="text-danger">Delete Comment</a>
									</p>
									<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?share_id='.$share_id; ?>" method="post" class="hide" id="updateForm">
										<div class="form-group">	
											<label for="message">Your comment:</label>
											<textarea name="message" id="message" rows="3" class="form-control <?php echo ($comment_err !== '') ? 'is-invalid' : '' ?>"><?php echo html_entity_decode($val["message"]); ?></textarea>
											<span class="invalid-feedback"><?php echo $comment_err; ?></span>
										</div>
										<input type="hidden" name="comment_id" value="<?php echo $val['com_id']; ?>">
										<button type="submit" name="update_comment" class="btn btn-primary">Update Comment <i class="fa fa-comment-o"></i></button>
									</form>
								<?php endif ?>
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