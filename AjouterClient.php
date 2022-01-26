<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
$erreur = "";
$ok = "";
if (isset($_POST['ajouterClient'])) {
	if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['ville'])) {
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$email = $_POST['email'];
		$ville = $_POST['ville'];

		$chemin = "pictures/" . $_FILES['image']['name'];
		if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin)) {
			$sql = "insert into client(nom,prenom,email,ville,image) values ('$nom','$prenom','$email','$ville','$chemin') ";
			$res = mysqli_query($conn, $sql)	or die(mysqli_error($conn));
			if ($res > 0) {
				$ok = "le client " . $nom . " est bien ajouté";
			} else {
				$erreur = "le client " . $nom . " n'est pas ajouté";
			}
		} else {
			$erreur = "l'image n'est pas téléchargé";
		}
	} else {
		$erreur = "tout les champs ce sont obligatoires";
	}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Ajouter un client</title>
</head>

<body>
	<?php
	include_once("menu.php");
	?>

	<div>
		<h4>Ajouter client</h4>
		<?php
		if (!empty($_SESSION['iduser']) and !empty($_SESSION['profile'] == 'Admin')) {

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

			<form method="POST" action="AjouterClient.php" enctype="multipart/form-data">
				<div>
					<div class="form-group col-md-6">
						<input type="text" class="form-control" name="nom" placeholder="nom" required>
					</div>
					<div class="form-group col-md-6">
						<input type="text" class="form-control" name="prenom" placeholder="prenom" required>
					</div>
					<div class="form-group col-md-6">
						<input type="email" class="form-control" name="email" placeholder="email" required>
					</div>
					<div class="form-group col-md-4">
						<select class="form-control" name="ville">
							<option value="Temmara">Temmara</option>
							<option value="Tanger">Tanger</option>
							<option value="Kinetra">Kénitra</option>
						</select>
					</div>

					<div>
						<input type="file" name="image" placeholder="image" required>
					</div>

				</div>

				<button type="submit" class="btn btn-primary" name="ajouterClient">Ajouter client</button>
			</form>
		<?php
		} else 	if (!empty($_SESSION['iduser']) and !empty($_SESSION['profile'] == 'User')) {
		?>
			<div class="alert alert-success" role="alert">
				vous n'avez pas le droit d'ajouter un client
			</div>
		<?php
		} else {
		?>
			<div class="alert alert-success" role="alert">
				Il faut <a href="connexion.php"> se connecter </a> pour ajouter un client
			</div>
		<?php

		}
		?>
	</div>

</body>