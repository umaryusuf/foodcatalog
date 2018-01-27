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
$share_id = $_GET['share_id'];
$user_id = $_SESSION['user_id'];

// prepare an sql delete query
$sql = "DELETE FROM foods WHERE id=:share_id AND user_id=:user_id";

if ($stmt = $pdo->prepare($sql)) {
	// bind param
	$stmt->bindParam(':share_id', $share_id, PDO::PARAM_INT);
	$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	// attempt to execute
	if($stmt->execute()){
    $_SESSION['success-msg'] = "Share deleted sucessfully";
		// redirect to my shares
		header("Location: myshares.php");
	}else{
		$_SESSION['danger-msg'] = "Error: deleting share";
		header("Location: myshares.php");
	}
}

?>