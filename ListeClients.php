<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";

if (!empty($_GET['supprimerClient'])) {
	$idclientSupprimer = $_GET['supprimerClient'];
	$profile = $_SESSION['profile'];
	$sql = "delete from client where idcli='$idclientSupprimer' and '$profile'='Admin'";
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	//mysql_affected_rows : retourne le nombre de ligne :supprimés ou modifiés
	if (mysqli_affected_rows($conn) > 0) {
		$ok = "le client dans id=" . $idclientSupprimer . " est supprimé";
	} else {
		$erreur = "le client dans id=" . $idclientSupprimer . " n'est pas supprimé";
	}
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Liste des clients</title>
</head>

<body>
	<?php
	include_once("menu.php");
	?>

	<div class="container">
		<h4 class="p-3">Liste des client</h4>

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

		<?php
		$sql = "select * from client";
		$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		if (mysqli_num_rows($res) > 0) {
			while ($client = mysqli_fetch_assoc($res)) {
		?>
			<div class="card-group p-2" style="display:inline-block;width:17em">
				<div class="card">
					<img src="<?php echo $client['image']; ?>" class="card-img-top" alt="<?php echo $client['nom']; ?>" style="width:100%;">
					<div class="card-body">
						<h5 class="card-title"><?php echo $client['nom'] . ' ' . $client['prenom']; ?></h5> from
						<h5 class="card-title"><?php echo $client['ville'] ?></h5>
						<p class="card-text"><small class="text-muted"><?php echo $client['email']; ?></small></p>
						<a class="btn btn-outline-danger" href="ListeClients.php?supprimerClient=<?php echo $client['idcli']; ?>" role="button">Supprimer</a>
						<a class="btn btn-outline-secondary" href="modifierClients.php?idClient=<?php echo $client['idcli']; ?>" role="button">Modifier</a>
					</div>
				</div>

			</div>

		<?php
			}
		}
		?>

	</div>

</body>