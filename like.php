<?php
session_start();
$page = "Likes";
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
}

require_once 'config/db.php';

if (isset($_GET['share_id'])) {
	if(!query($pdo, "SELECT id FROM likes WHERE share_id=:share_id AND user_id=:user_id", array(":share_id" => $_GET["share_id"], ":user_id" => $_SESSION['user_id']))){
		query($pdo, "UPDATE foods SET likes=likes+1 WHERE id=:id", array(":id" => $_GET["share_id"]));
		query($pdo, "INSERT INTO likes VALUES('', :share_id, :user_id)", array(":share_id" => $_GET['share_id'], ":user_id" => $_SESSION['user_id']));
	}else{
		query($pdo, "UPDATE foods SET likes=likes-1 WHERE id=:id", array(":id" => $_GET["share_id"]));
		query($pdo, "DELETE FROM likes WHERE share_id=:share_id AND user_id=:user_id", array(":share_id" => $_GET['share_id'], ":user_id" => $_SESSION['user_id']));
	}
	
}

?>