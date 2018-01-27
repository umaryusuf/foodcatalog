<?php  
class DB {
	private $pdo;

	public function __construct($dbhost, $dbname, $username, $password){
		try{
			$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		}catch(PDOExeception $e) {
			die('Connection failed '. $e->getMessage());
		}
	}

	public function query($query, $params = array()){

		$stmt = $this->pdo->prepare($query);
		$stmt->execute($params);

		if(explode(' ', $query)[0] == "SELECT"){
			$data = $stmt->fetchAll();
			return $data;
		}
		
	}

}
?>