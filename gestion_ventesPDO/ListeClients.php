<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";

		if(!empty($_GET['supprimerClient']))
		{
			$idclientSupprimer=$_GET['supprimerClient'];
			$profile=$_SESSION['profile'];
		try
		{
		
		$sql="delete from client where idcli=? and profile='Admin'";
		$query = $conn->prepare($sql);
		$query->bindParam(1, $idclientSupprimer, PDO::PARAM_INT);
		$resultat = $query->execute();
		if($query->rowCount() > 0)
		{
		$ok="le client dans idcli=".$idclientSupprimer." est supprimé";
	}
	else
	{
		$erreur="le client dans idcli=".$idclientSupprimer." n'est pas supprimé";
	}
	}
	catch(PDOException $e)
	{
		$e->getMessage().' '.$e->getCode();
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

<div>
	<h4>Liste des client</h4>

	<?php
		$sql="select * from client";
		$res=$conn->query($sql);
		if($res->rowCount() > 0)
		{
			while($client=$res->fetch())
			{
	?>
	<div class="card-group" style="display:inline-block;width:25%;" >
		<div class="card">
			<img src="<?php echo $client['image'];?>" class="card-img-top" alt="<?php echo $client['nom'];?>"  style="width:100%;">
			<div class="card-body">
			  <h5 class="card-title"><?php echo $client['nom'].' '.$client['prenom'];?></h5> from 
			  <h5 class="card-title"><?php echo $client['ville']?></h5> 
			  <p class="card-text"><small class="text-muted"><?php echo $client['email'];?></small></p>
			  <a class="btn btn-outline-danger" href="ListeClients.php?supprimerClient=<?php echo $client['idcli'];?>" role="button">Supprimer</a>
			  <a class="btn btn-outline-secondary" href="modifierClients.php?idClient=<?php echo $client['idcli'];?>" role="button">Modifier</a>
			</div>
		</div>
  
	</div>
	
	<?php
			}
		}
	?>

</div>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
