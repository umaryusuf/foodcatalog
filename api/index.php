<?php 
require_once 'DB.php';

$db = new DB("127.0.0.1", "foodcatalogue", "root", "");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
	if ($_GET['url'] === "shares") {
		$shares = $db->query("SELECT * FROM foods");
		$response = "[";

		foreach ($shares as $share) {
			$response .= "{";
				$response .= '"id": "' . $share['id'] . '",';
				$response .= '"FoodName": "' . $share['food_name'] . '",';
				$response .= '"Description": "' . $share['description'] . '",';
				$response .= '"DateCreated": "' . $share['date_created'] . '",';
				$response .= '"Picture": "' . $share['photo'] . '",';
				$response .= '"Likes": "' . $share['likes'] . '"';
			$response .= "},";
		}

		$response = substr($response, 0, strlen($response) -1);
		$response .= "]";
		echo $response;
	}

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
		echo "{";
		echo '"Likes": ';
		echo $db->query("SELECT likes FROM foods WHERE id=:share_id", array(":share_id" => $postId))[0]['likes'];
		echo "}";
	}
}else{
	http_response_code(405);
}
?>