<html>
  <head></head>
  <body style="width: 100%; height: 100%;">

  <div style="top: 15%; left: 35%; position: absolute;">


<?php


	require("../functions.php");

    require("../class/Helper.class.php");
	$Helper = new Helper();

	require("../class/User.class.php");
	$User = new User($mysqli);

	//kui on sisse loginud siis suunan data lehele
/*	if(isset($_SESSION["userId"])){
		header("Location: data.php");
		exit();
	}*/

	//kui tahab kasutajat luua siis suuna signup lehele
	/*if(isset(                            )){
		header("Location: signup.php");
		exit();
	}
	*/


	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);

	// MUUTUJAD
	$loginEmail = "";


	$notice ="";
	//kas kasutaja tahab sisse logida
	if( isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	){
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
	}


?>




<?php require("../loginheader.php");?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3">
		<h1>   Logi sisse</h1>
		<p style="color:black;"><?=$notice;?></p>
		<form method="POST" >
			<label>E-post</label><br>
			<div class="form-group">
					<input class="form-control" name="loginEmail" type="email" value="<?php if(isset($_POST['loginEmail'])) { echo $_POST['loginEmail']; } ?>" class="textbox required email">
			</div>
			<label>Parool</label><br>
			<div class="form-group">
			<input class="form-control" name="loginPassword" type="password">
			</div>
			<br><br>
			<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Logi sisse">
			<input class="btn btn-success btn-sm btn-block visible-xs-block" type="submit" value="Logi sisse2">
			<br><br>
			<a class="link" href="http://localhost:5555/~stenpoks/SNKT/page/signup.php">Loo kasutaja</a>
		</form>
		</div>
	</div>
</div>
<?php require("../loginfooter.php");?>

</div>
</body>
</html>
