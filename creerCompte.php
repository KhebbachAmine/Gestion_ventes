<?php
include_once("config.php");  //ajouter une ficher de configuration 
include_once("menu.php");

$erreur = "";
$ok = "";
if (isset($_POST['creerCompte'])) {
	if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['login'])
		and !empty($_POST['password']) and !empty($_POST['profile'])) {
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$email = $_POST['email'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$profile = $_POST['profile'];

		$chemin = "pictures/" . $_FILES['image']['name'];
		if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin)) {
			$sql = "insert into utilisateur(nom,prenom,email,login,password,profile,image) values ('$nom','$prenom','$email','$login','$password','$profile','$chemin') ";
			$res = mysqli_query($conn, $sql)	or die(mysqli_error($conn));
			if ($res > 0) {
				$ok = "l'utilisateur " . $nom . " est bien ajouté";
			} else {
				$erreur = "l'utilisateur " . $nom . " n'est pas ajouté";
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
	<title>Créer un compte</title>


</head>

<body>

	<div>
		<h4>Créer compte</h4>
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
		<form method="POST" action="creerCompte.php" enctype="multipart/form-data">
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
				<div class="form-group col-md-6">
					<input type="text" class="form-control" name="login" placeholder="login" required>
				</div>
				<div class="form-group col-md-6">
					<input type="password" class="form-control" name="password" placeholder="password" required>
				</div>
				<div class="form-group col-md-4">
					<select class="form-control" name="profile">
						<option value="Admin">Admin</option>
						<option value="User">User</option>
					</select>
				</div>

				<div>
					<input type="file" name="image" placeholder="image" required>
				</div>

			</div>

			<button type="submit" class="btn btn-primary" name="creerCompte">Créer compte</button>
		</form>
	</div>

</body>