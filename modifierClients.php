<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
$erreur = "";
$ok = "";

if (isset($_POST['modifierClient'])) {
	if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['ville'])) {
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$email = $_POST['email'];
		$ville = $_POST['ville'];
		$idcli = $_POST['idcli'];

		if (!empty($_FILES['image']['name'])) {
			$chemin = "pictures/" . $_FILES['image']['name'];
			if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin)) {
				$sql = "update client set nom='$nom' , prenom='$prenom' , email='$email' , ville='$ville' , image='$chemin' where idcli='$idcli'";
				$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
				//mysql_affected_rows : retourne le nombre de ligne :supprimés ou modifiés
				if (mysqli_affected_rows($conn) > 0) {
					$ok = "le client est bien modifier";
				} else {
					$erreur = "erreur de modification";
				}
			} else {
				$erreur =  "l'image n'est pas téléchargé";
			}
		} else {
			$sql = "update client set nom='$nom' , prenom='$prenom' , email='$email' , ville='$ville' where idcli='$idcli'";
			$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			//mysql_affected_rows : retourne le nombre de ligne :supprimés ou modifiés
			if (mysqli_affected_rows($conn) > 0) {
				$ok = "le client est bien modifier";
			} else {
				$erreur = "erreur de modification";
			}
		}
	} else {
		$erreur = "tout les champs est obligatoires";
	}
	header("location:ListeClients.php");
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
		<h4>modifier un client</h4>
		<?php
		if (isset($_GET['idClient'])) {

			$idClient = $_GET['idClient'];
			$sql = "select * from client where idcli='$idClient'";
			$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			if (mysqli_num_rows($res) > 0) {
				$client = mysqli_fetch_assoc($res);
		?>
		<form method="POST" action="modifierClients.php" enctype="multipart/form-data">
			<div>
				<div class="form-group col-md-6">
					<input type="text" class="form-control" name="idcli" value="<?php echo $client['idcli']; ?>" placeholder="idcli" readonly>
				</div>
				<div class="form-group col-md-6">
					<input type="text" class="form-control" name="nom" value="<?php echo $client['nom']; ?>" placeholder="nom" required>
				</div>
				<div class="form-group col-md-6">
					<input type="text" class="form-control" name="prenom" value="<?php echo $client['prenom']; ?>" placeholder="prenom" required>
				</div>
				<div class="form-group col-md-6">
					<input type="email" class="form-control" name="email" value="<?php echo $client['email']; ?>" placeholder="email" required>
				</div>
				<div class="form-group col-md-4">
					<select class="form-control" name="ville">
						<option value="Temmara" <?php if ($client['ville'] == "temara") { echo " selected";} ?> >Temmara</option>
						<option value="Tanger" <?php if ($client['ville'] == "tanger") { echo " selected";} ?> >Tanger</option>
						<option value="kenitra" <?php if ($client['ville'] == "kenitra") { echo " selected";} ?> >Kénitra</option>
					</select>
				</div>

				<div>
					<input type="file" name="image" placeholder="image">
					<img src="<?php echo $client['image'] ?>" style="width:100px; border=1px white solid;" />
				</div>

			</div>

			<button type="submit" class="btn btn-primary" name="modifierClient">Modifier</button>
		</form>
		<?php

			}
		}
		?>
	</div>

</body>