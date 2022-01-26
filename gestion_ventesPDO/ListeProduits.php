<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";

if(!empty($_GET['supprimerProduit']))
{
	$idproduitSupprimer=$_GET['supprimerProduit'];
	$profile=$_SESSION['profile'];
	try{
	$sql="delete from produit where idpro =? and profile='Admin' ";
	$query = $conn->prepare($sql);
	$query->bindParam(1, $idproduitSupprimer, PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() > 0)
	{

		$ok="le produit dans idpro=".$idproduitSupprimer." est supprimé";
	}
	else
	{
		$erreur="le produit dans idpro=".$idproduitSupprimer." n'est pas supprimé";
	}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage().' '.$e->getCode();
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>Liste des Produits</title>
</head>
<body>
<?php 
include_once("menu.php");
?>

<div>
	<h4>Liste des Produits</h4>

	<?php
	
		$sql="select * from produit";
		$res=$conn->query($sql);
		if($res->rowCount() > 0)
		{
			while($produit=$res->fetch())
			{
	?>
	<div class="card-group" style="display:inline-block;width:24%;" >
		<div class="card">
			<img src="<?php echo $produit['image'];?>" class="card-img-top" alt="<?php echo $produit['libelle'];?>"  style="width:100%;">
			<div class="card-body">
			<h5 class="card-title"><?php echo $produit['libelle'].'  '.$produit['prix'];?> $</h5> 
			  <h5 class="card-title"><?php echo $produit['qtestock']?> unites</h5> 
			  <p class="card-text"><small class="text-muted"><?php echo $produit['marque'];?></small></p>
			  
			  <a class="btn btn-outline-danger" href="ListeProduits.php?supprimerProduit=<?php echo $produit['idpro'];?>" role="button">Supprimer</a>
			  <a class="btn btn-outline-secondary" href="modifierProduits.php?idProduit=<?php echo $produit['idpro'];?>" role="button">Modifier</a>
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
