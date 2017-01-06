<?php
	//ühendan sessionniga
	require("../functions.php");

	require("../class/Helper.class.php");
	$Helper= new Helper();

	require("../class/Event.class.php");
	$Event= new Event($mysqli);

	//kui ei ole sisse loginud, suunan login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}

	//kas aadressireal on logout
	if(isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}


	if(isset($_GET["q"])){
		$q=$_GET["q"];
	}else{
		//ei otsi
		$q="";
	}

	//vaikimisi, kui keegi mingit linki ei vajuta
	$sort = "id";
	$order = "ASC";

	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}



///////////////MILLEKS SEE ON?
$people=$Event->getAllPeople($q, $sort, $order);

	//echo"<pre>";
	//var_dump($people[1]);
	//echo"</pre>";

	if ( isset($_POST["name"]) &&
		 isset($_POST["song"]) &&
		 !empty($_POST["name"]) &&
		 !empty($_POST["song"])
	) {


		$song = cleanInput($_POST["song"]);

		saveEvent(cleanInput($_POST["name"]), $song);
	}

	$people=$Event->getAllPeople($q, $sort, $order);

	//echo "<pre>";
	//var_dump($people);
	//echo "</pre>";


?>


<?php require("../dataheader.php");?>

<h1>Su nägu kõlab tuttavalt</h1>


<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="row">

<h2>Esitatud laulud</h2>


<?php
	$html="<table class='table table-bordered table-condensed'>";
		$html .="<tr>";
			$ordername="ASC";
			$arr="&darr;";
			if(isset($_GET["order"])&&
				$_GET["order"]=="ASC"&&
				$_GET["sort"]=="name"){
				$ordername="DESC";
				$arr="&uarr;";
			}
			$html .= "<th>
						<a href='?q=".$q."&sort=name&order=".$ordername."'>
							Esitaja nimi
						</a>
					 </th>";


			$ordersong="ASC";
			$arr="&darr;";
			if(isset($_GET["order"])&&
				$_GET["order"]=="ASC"&&
				$_GET["sort"]=="song"){
				$ordersong="DESC";
				$arr="&uarr;";
			}
			$html .="<th>
						<a href='?q=".$q."&sort=song&order=".$ordersong."'>
							Loo nimi
						</a>
					</th>";

	$html .="</tr>";
	//iga liikmekohta masssiiivis
	foreach($people as $p){
		$html .="<tr>";
			$html .="<td>".$p->name."</td>";
			$html .="<td>".$p->song."</td>";
			$html .="</tr>";
	}
	$html .="</table>";
	echo $html;
?>

<br><br>

<h2>
	Lisa uus esitus
</h2>

<br><br>

<form method="POST" >

	<label>Esitaja nimi</label><br>
	<input name="text" type="text">

	<br><br>
	<label>Loo nimi</label><br>
	<input name="text" type="text">

	<br<br>

	<input type="submit" value="Salvesta">

</form>



			</div>

			<div class="row">









		</div>
	</div>
</div>
