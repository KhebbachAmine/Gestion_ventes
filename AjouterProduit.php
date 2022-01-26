<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";

if(isset($_POST['ajouterProduit']))
{
	if(!empty($_POST['libelle']) and !empty($_POST['qtestock']) and !empty($_POST['prix']) 
		and !empty($_POST['marque']))
	{
		$libelle = $_POST['libelle'];
		$qtestock = $_POST['qtestock'];
		$prix = $_POST['prix'];
		$marque = $_POST['marque'];
		//l'image sera stockée dans le dossier image , et dans la colone image on va sauvegarder le chemin
		$chemin = "images/".$_FILES['image']['name'];
		//sauvegarder l'image dans le serveur
		if(move_uploaded_file($_FILES['image']['tmp_name'],$chemin))
		{
			$sql = " insert into produit(libelle,prix,qtestock,marque,image ) values
			('$libelle','$prix','$qtestock','$marque','$chemin') ";
			//executer la requete
			$res = mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if($res > 0)
			{
				$ok = " le produit ".$libelle." est bien ajouté";	
			}
			else
			{
				$erreur = "le produit n'est pas ajouté";
			}
		}
		else
		{
			$erreur = "erreur de sauvegrder l'image";
		}
	}
	else
	{
		$erreur = "tout les champes sont obligatoires";
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>Ajouter un produit</title>


</head>
<body>

<?php 
include_once("menu.php");
?>

<div>
	<h4>Ajouter Produit</h4>
<?php
	if(!empty($_SESSION['iduser']) and !empty($_SESSION['profile']=='Admin'))
	{
	if($erreur != "")
	{
?>
		<div class="alert alert-danger" role="alert">
		<?php echo $erreur ; ?>
		</div>
<?php
	}
?>
<?php
	if($ok != "")
	{
?>
<div class="alert alert-success" role="alert">
<?php echo $ok ; ?>
</div>
<?php
	}
?>
	
<form enctype="multipart/form-data" method="POST" action="AjouterProduit.php">
<div>
    <div class="form-group col-md-6">
      <input type="text" class="form-control"  name="libelle" placeholder="libelle" required >
    </div>
	<div class="form-group col-md-6">  
      <input type="number" class="form-control"  name="prix" placeholder="prix" required>
    </div>
	<div class="form-group col-md-6">
      <input type="number" class="form-control"  name="qtestock" placeholder="qtestock" required>
    </div>
    <div class="form-group col-md-4">
      <select  class="form-control" name="marque">
        <option value="hp">hp</option>
		<option value="del">del</option>
        <option value="samsung">samsung</option>
      </select>
    </div>
	
	<div>
	<input type="file" name="image" placeholder="image">
	</div>
    
  </div>
  
  <button type="submit" class="btn btn-primary" name="ajouterProduit">Ajouter</button>
</form>
	<?php 
	}
	else 	if(!empty($_SESSION['iduser']) and !empty($_SESSION['profile']!='Admin'))
	{
?>
	<div class="alert alert-success" role="alert">
	vous n'avez pas le droit d'ajouter un produit
</div>
	<?php
	}
	else
	{
	?>
	<div class="alert alert-success" role="alert">
	Il faut <a href="connexion.php"> se connecter </a> pour ajouter un produit
</div>
<?php	

	}
?>

</div>


</body>