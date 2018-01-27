<?php  
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "foodcatalogue");
define("BASE_URL", "http://localhost/foodcatalogue/");

try{
	$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	$pdo->exec("set names utf-8");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
}catch(PDOException $e){
	die('Connection failed '. $e->getMessage());
}

function query($pdo, $query, $param = array()){

	$stmt = $pdo->prepare($query);
	$stmt->execute($param);

	if(explode(' ', $query)[0] === "SELECT"){
		$data = $stmt->fetchAll();
		return $data;
	}
	
}

// a function that sanitize user input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>