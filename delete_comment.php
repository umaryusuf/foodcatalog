<?php  
session_start();

	/*
protect route
check if user is not authenticated
to redirect the user to login page
*/
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
}

require_once 'config/db.php';
$com_id = $_GET['oaccfl'];
$user_id = $_SESSION['user_id'];
$share_id = $_GET['share_id'];

// prepare an sql delete query
$sql = "DELETE FROM comments WHERE id=:com_id AND user_id=:user_id";

if ($stmt = $pdo->prepare($sql)) {
	// bind param
	$stmt->bindParam(':com_id', $com_id, PDO::PARAM_INT);
	$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	// attempt to execute
	if($stmt->execute()){
    $_SESSION['success-msg'] = "Comment deleted sucessfully";
		// redirect to my shares
		header("Location: comments.php?share_id=$share_id");
	}else{
		$_SESSION['danger-msg'] = "Error: deleting share";
		header("Location: myshares.php");
	}
}

?>