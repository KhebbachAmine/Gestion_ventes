<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";

if(!empty($_GET['supprimerProduit']))
{
	$idproduitSupprimer=$_GET['supprimerProduit'];
	$profile = $_SESSION['profile'];
	$sql="delete from produit where idpro ='$idproduitSupprimer' and '$profile'='Admin'";
	$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	//mysql_affected_rows : retourne le nombre de ligne :supprimés ou modifiés
	if(mysqli_affected_rows($conn)>0)
	{
		$ok="le produit dans idpro=".$idproduitSupprimer." est supprimé";
	}
	else
	{
		$erreur="le produit dans idpro=".$idproduitSupprimer." n'est pas supprimé";
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

<div class="container">
	<h4 class="p-3">Liste des Produits</h4>

	<?php
	
		$sql="select * from produit";
		$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($res)>0)
		{
			while($produit=mysqli_fetch_assoc($res))
			{
	?>
	<div class="card-group p-2" style="display:inline-block;width:17em;" >
		<div class="card">
			<img src="<?php echo $produit['image'];?>" class="card-img-top" alt="<?php echo $produit['libelle'];?>"  style="width:100%;">
			<div class="card-body">
			<h5 class="card-title"><?php echo $produit['libelle'].'  '.$produit['prix'];?> $</h5> 
			  <h5 class="card-title"><?php echo $produit['qtestock']?> unites</h5> 
			  <p class="card-text"><small class="text-muted"><?php echo $produit['marque'];?></small></p>
			  
			  <a class="btn btn-outline-danger" href="ListeProduits.php?supprimerProduit=<?php echo $produit['idpro'];?>" role="button">Supprimer</a>
			  <a class="btn btn-outline-secondary" href="modifierClients.php?idProduit=<?php echo $produit['idpro'];?>" role="button">Modifier</a>
			</div>
		</div>
  
	</div>
	
	<?php
			}
		}
	?>
</div>

</body>
