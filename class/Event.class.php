<?php
class Event {

    private $connection;

	function __construct($mysqli){
		$this->connection = $mysqli;
	}


	function saveEvent($name, $song) {

		$stmt = $this->connection->prepare("INSERT INTO performances (name, song) VALUE (?, ?)");
		echo $this->connection->error;

		$stmt->bind_param("is", $name, $song);

		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

	}

	function getAllPeople($q, $sort, $order) {

		$allowedSort = ["id", "name", "song"];

		// sort ei kuulu lubatud tulpade sisse
		if(!in_array($sort, $allowedSort)){
			$sort = "id";
		}

		$orderBy = "ASC";

		if($order == "DESC") {
			$orderBy = "DESC";
		}

		//echo "Sorteerin: ".$sort." ".$orderBy." ";


		if ($q != "") {
			//otsin
			echo "otsin: ".$q;

			$stmt = $this->connection->prepare("
				SELECT id, name, song
				FROM performances
				WHERE deleted IS NULL
				AND ( name LIKE ? OR song LIKE ? )
				ORDER BY $sort $orderBy
			");

			$searchWord = "%".$q."%";

			$stmt->bind_param("ss", $searchWord, $searchWord);

		} else {
			// ei otsi
			$stmt = $this->connection->prepare("
				SELECT id, name, song
				FROM performances
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
		}

	  $stmt->bind_result($id, $name, $song);
		$stmt->execute();
		$results=array();

		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while($stmt->fetch()) {
			$human=new StdClass();
			$human->id=$id;
			$human->name=$name;
			$human->song=$song;
			//echo $song."<br>";
			array_push($results, $human);
		}
		return $results;

	}


	function getSinglePerosonData($edit_id){


		$stmt = $this->connection->prepare("SELECT name, song FROM performances WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($name, $song);
		$stmt->execute();

		//tekitan objekti
		$p = new Stdclass();

		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->name = $name;
			$p->song = $song;


		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}

		$stmt->close();

		return $p;

	}

	function updatePerson($id, $name, $song){

		$stmt = $this->connection->prepare("UPDATE performances SET name=?, song=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("isi",$name, $song, $id);

		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}

		$stmt->close();

	}

	function deletePerson($id){

        $database = "if16_stenly";

		$stmt = $this->connection->prepare("
		UPDATE performances SET deleted=NOW()
		WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);

		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}

		$stmt->close();

	}


}
?>
