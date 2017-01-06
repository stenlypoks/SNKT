<?php
class User{
	private $connection;
	//k�ivitataks siis kui on = new User(see j�uab siia)

	function __construct($mysqli){
		//this viitab sellele klassile ja selle klassi muutujale
		$this->connection=$mysqli;
	}
	/*K�IK FUNKTSIOONID */

	function login($email, $password) {
		$notice="";
		$stmt = $this->connection->prepare("SELECT id, email, password FROM users WHERE email = ?");
		echo $this->connection->error;
		//asendan k�sim�rgi
		$stmt->bind_param("s", $email);

		//rea kohta tulba v��rtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();

		//ainult select puhul
		if($stmt->fetch()){
			//oli olemas,rida k�es
			$hash=hash("sha512", $password);
			if($hash==$passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				header("Location: data.php");
				exit();
			} else {
				$notice = "Parool vale";
			}
		} else {
			//ei olnud �htegi rida
			$notice = "Sellise emailiga $email kasutajat ei ole olemas";
		}

		$stmt->close();


		return $notice;
	}

	function signup($email, $password) {

		$stmt = $this->connection->prepare("INSERT INTO users (email, password) VALUE (?,?)");
		echo $this->connection->error;

		$stmt->bind_param("ss",$email, $password);
		if ($stmt->execute() ) {
			echo "�nnestus";
		}	else { "ERROR".$stmt->error;
		}
	}


}
?>
