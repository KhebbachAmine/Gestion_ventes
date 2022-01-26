<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
$erreur = "";
$ok = "";
if(isset($_POST['modifierProduit']))
{
	if(!empty($_POST['libelle'])  and !empty($_POST['prix']) and !empty($_POST['qtestock']) and !empty($_POST['marque']))
	{
	$libelle = $_POST['libelle'] ;
	$prix = $_POST['prix'] ;
    $qtestock = $_POST['qtestock'] ;
	$marque = $_POST['marque'] ;
	$idpro = $_POST['idpro'] ;
	
	if(!empty($_FILES['image']['name']))
	{
	$chemin = "images/".$_FILES['image']['name'];
	if(move_uploaded_file($_FILES['image']['tmp_name'],$chemin))
	{

	try{
		$sql="update produit set libelle=?,prix=?,qtestock=?,marque=?,image=? where idpro=?";

		$query = $conn->prepare($sql);
		$query->bindParam(1, $libelle, PDO::PARAM_STR, 25);
		$query->bindParam(2, $prix, PDO::PARAM_STR, 25);
		$query->bindParam(3, $qtestock, PDO::PARAM_STR, 25);
		$query->bindParam(4, $marque, PDO::PARAM_STR, 25);
		$query->bindParam(5, $chemin, PDO::PARAM_STR, 25);
		$query->bindParam(6, $idpro, PDO::PARAM_INT);
		
		 $query->execute();
		if($query->rowCount() > 0) 
		{
			$ok="le produit ".$libelle." est bien modifier";
		}
		else
		{
			$erreur="le produit ".$libelle." n'est pas modifier";
		}
	}
	catch(PDOException $e)
	{
		$e->getMessage().' '.$e->getCode();
	}
	}
	else
	{
		$erreur = "l'image n'est pas téléchargé";
	}
}
else
{ 
	try{
		$sql="update produit set libelle=?,prix=?,qtestock=?,marque=? where idpro=?";

		$query = $conn->prepare($sql);
		$query->bindParam(1, $libelle, PDO::PARAM_STR, 25);
		$query->bindParam(2, $prix, PDO::PARAM_STR, 25);
		$query->bindParam(3, $qtestock, PDO::PARAM_STR, 25);
		$query->bindParam(4, $marque, PDO::PARAM_STR, 25);
		$query->bindParam(5, $idpro, PDO::PARAM_INT);
		
		 $query->execute();
		if($query->rowCount() > 0) 
		{
			$ok="le produit ".$libelle." est bien modifier";
		}
		else
		{
			$erreur="le produit ".$libelle." n'est pas modifier";
		}
	}
	catch(PDOException $e)
	{
		$e->getMessage().' '.$e->getCode();
	}
}
}
else
{
	$erreur = "tout les champs ce sont obligatoires";	
}
header("location:ListeProduits.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>Modifier un client</title>


</head>
<body>
<?php 
include_once("menu.php");
?>

<div>
	<h4>Modifier un client</h4>
<?php
if(!empty($_GET['idProduit']))
{
    $idProduit = $_GET['idProduit']; 
	try{

	$sql="select * from produit where idpro=?";
	$query = $conn->prepare($sql);
	$query->bindParam(1, $idProduit, PDO::PARAM_INT);
	$query->execute();	
	if($query->rowCount()>0)
	{
			$produit=$query->fetch();
			?>
	
<form enctype="multipart/form-data" method="POST" action="modifierProduits.php">
<div>
<div class="form-group col-md-6">
      <input type="number" class="form-control"  name="idpro" value="<?php echo $produit['idpro'] ;?>"  style="display:none" >
    </div>
    <div class="form-group col-md-6">
      <input type="text" class="form-control"  name="libelle" value="<?php echo $produit['libelle'] ;?>" placeholder="libelle" required >
    </div>
	<div class="form-group col-md-6">  
      <input type="text" class="form-control"  name="prix" value="<?php echo $produit['prix'] ;?>" placeholder="prix" required>
    </div>
	<div class="form-group col-md-6">
      <input type="number" class="form-control"  name="qtestock" value="<?php echo $produit['qtestock'] ;?>" placeholder="qtestock" required>
    </div>
    <div class="form-group col-md-4">
      <select  class="form-control" name="marque">
        <option value="hp" <?php if($produit['marque']=="hp"){echo "selected";}?>>HP</option>
		<option value="del" <?php if($produit['marque']=="del"){echo "selected";}?>>DEL</option>
        <option value="samsung" <?php if($produit['marque']=="samsung"){echo "selected";}?>>SAMSUNG</option>
      </select>
    </div>
	
	<div>
	<input type="file" name="image" placeholder="image" >
	<img src="<?php echo $produit['image'] ;?>" style="max-width:100px;"/>
	</div>
    
  </div>
  
  <button type="submit" class="btn btn-primary" name="modifierProduit">Modifier</button>
</form>
	<?php
		}
		else
		{
			echo "N'existe aucun produit de id=".$idProduit;
		}
	}
	catch(PDOException $e)
	{
		$e->getMessage().' '.$e->getCode();
	}

	}	


	?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

