<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
include_once("menu.php"); 

if (isset($_GET['logout'])) {
	//vider la session
	session_destroy();
	header('location:connexion.php');
	$_SESSION['iduser'] = "";
}

if (!empty($_SESSION['iduser'])) {
	header('location:ListeProduits.php');
}

$erreur = "";
$ok = "";

if (isset($_POST['connexion'])) {

	if (!empty($_POST['login']) and !empty($_POST['password'])) {

		$login = $_POST['login'];
		$password = $_POST['password'];

		$sql = "select * from utilisateur where login='$login' and password='$password'";
		$res = mysqli_query($conn, $sql)	or die(mysqli_error($conn));
		
		if (mysqli_num_rows($res) > 0) {
			/* on doit sauvegarder la session de l'utilisateur
			dans php existe un tableau de session $_SESSION[''] en peut stocker tous ce qu'on veut
			a condition d'ajouter au debut de chaque page : session_start()	*/
			$client = mysqli_fetch_assoc($res);
			$_SESSION['iduser'] = $client['iduser'];
			$_SESSION['nom'] = $client['nom'];
			$_SESSION['prenom'] = $client['prenom'];
			$_SESSION['profile'] = $client['profile'];
			$_SESSION['image'] = $client['image'];
			//pour faire une redirection avec PHP en utilise :
			header('location:ListeProduits.php');
		} else {
			$erreur = "erreur de connexion login/password incorrectes";
		}
	} else {
		$erreur = "tout les champs ce sont obligatoires";
	}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>connexion</title>
</head>

<body class="bg-light">

	<div class="container p-5">
		<h4>Connexion</h4>

		<?php  
		if ($erreur != "") {  
		?>

			<div class="alert alert-danger" role="alert">
				<?php echo $erreur; ?>
			</div>

		<?php
		}
		?>

		<?php
		if ($ok != "") {
		?>
			<div class="alert alert-success" role="alert">
				<?php echo $ok; ?>
			</div>
		<?php
		}
		?>
		<form method="POST" action="connexion.php">

				<div class="form-group col-md-6">
					<input type="text" class="form-control" name="login" placeholder="login" required>
				</div>
				<div class="form-group col-md-6">
					<input type="password" class="form-control" name="password" placeholder="password" required>
				</div>


			<button type="submit" class="btn btn-primary" name="connexion">Se connecter</button>
		</form>
	</div>

</body>