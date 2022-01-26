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
			(?,?,?,?,?) ";
			$query = $conn->prepare($sql);
			$query->bindParam(1, $libelle, PDO::PARAM_STR, 25);
			$query->bindParam(2, $prix, PDO::PARAM_STR, 25);
			$query->bindParam(3, $qtestock, PDO::PARAM_INT);
			$query->bindParam(4, $marque, PDO::PARAM_STR, 25);
			$query->bindParam(5, $chemin, PDO::PARAM_STR, 25);

			$resultat = $query->execute();
			if($query->rowCount() > 0)
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>