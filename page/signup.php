<?php

	require("../functions.php");

    require("../class/Helper.class.php");
	$Helper = new Helper();

	require("../class/User.class.php");
	$User = new User($mysqli);

	//kui on sisse loginud siis suunan data lehele
	/*if(isset($_SESSION["userId"])){
		header("Location: data.php");
		exit();
	}*/

	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);

	// MUUTUJAD
	$signupEmailError= "*";
	$signupEmail = "";
	$signupUsername = "" ;


	if(isset ($_POST["signupEmail"])) {
		if(empty ($_POST["signupEmail"])){
			$signupEmailError = "* V�li on kohustuslik!";
		} else{
		$signupEmail = $_POST["signupEmail"];
		}
	}

	$signupPasswordError= "*";
	if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
			$signupPasswordError = "* V�li on kohustuslik!";
		} else {
			if(strlen($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "* Parool peab olema v�hemalt 8 t�hem�rki pikk!";
			}
		}
	}


	if ( $signupEmailError == "*" AND
		$signupPasswordError == "*" &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"])
	){
		//vigu ei olnud, k�ik on olemas
		echo "Salvestan...<br>";
		echo "email ".$signupEmail. "<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
			$password = hash("sha512", $_POST["signupPassword"]);
		echo $password."<br>";
		 $User->signup($signupEmail, $password);
	}



?>


<?php require("../signupheader.php");?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-2 col-md-3 col-md-offset-3">
		<h1>Loo kasutaja</h1>

		<form method="POST">
		<br><br>
		<input name="signupEmail" placeholder="Email" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError;?>
		<br><br>
		<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError;?>
		<br><br>
		<input type="submit" value="Loo kasutaja">
		<br><br>
		<a class="link" href="http://localhost:5555/~stenpoks/SNKT/page/login.php">Kasutaja olemas? Logi sisse</a>
		</form>
		</div>
	</div>
</div>
<?php require("../signupfooter.php");?>
