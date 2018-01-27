<?php 
require_once 'DB.php';

$db = new DB("127.0.0.1", "foodcatalogue", "root", "");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
	$db->query("SELECT * FROM users");

}elseif ($_SERVER['REQUEST_METHOD'] === "POST") {

	if($_GET['url'] === "likes"){
		
		$postId = $_GET['share_id'];
		if(!$db->query("SELECT id FROM likes WHERE share_id=:share_id AND user_id=:user_id", array(":share_id" => $postId, ":user_id" => $_GET['user_id']))){
			$db->query("UPDATE foods SET likes=likes+1 WHERE id=:id", array(":id" => $postId));
			$db->query("INSERT INTO likes VALUES('', :share_id, :user_id)", array(":share_id" => $postId, ":user_id" => $_GET['user_id']));
		}else{
			$db->query("UPDATE foods SET likes=likes-1 WHERE id=:id", array(":id" => $postId));
			$db->query("DELETE FROM likes WHERE share_id=:share_id AND user_id=:user_id", array(":share_id" => $postId, ":user_id" => $_GET['user_id']));
		}
			
	}
}else{
	http_response_code(405);
}
?>