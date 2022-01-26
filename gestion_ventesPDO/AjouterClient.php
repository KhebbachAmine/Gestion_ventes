<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
$erreur = "";
$ok = "";
if(isset($_POST['ajouterClient']))
{
	if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['ville']))
	{
	$nom = $_POST['nom'] ;
	$prenom = $_POST['prenom'] ;
	$email = $_POST['email'] ;
	$ville = $_POST['ville'] ;
	
	$chemin = "pictures/".$_FILES['image']['name'];
	if(move_uploaded_file($_FILES['image']['tmp_name'],$chemin))
	{

	try{
		$sql="insert into client(nom,prenom,email,ville,image) values (?,?,?,?,?) " ;

		$query = $conn->prepare($sql);
		$query->bindParam(1, $nom, PDO::PARAM_STR, 25);
		$query->bindParam(2, $prenom, PDO::PARAM_STR, 25);
		$query->bindParam(3, $email, PDO::PARAM_STR, 25);
		$query->bindParam(4, $ville, PDO::PARAM_STR, 25);
		$query->bindParam(5, $chemin, PDO::PARAM_STR, 25);
		
		 $query->execute();
		if($query->rowCount() > 0) 
		{
			$ok="le client ".$nom." est bien ajouté";
		}
		else
		{
			$erreur="le client ".$nom." n'est pas ajouté";
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
	<h4>Ajouter un client</h4>
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
	
<form enctype="multipart/form-data" method="POST" action="AjouterClient.php">
<div>
    <div class="form-group col-md-6">
      <input type="text" class="form-control"  name="nom" placeholder="nom" required >
    </div>
	<div class="form-group col-md-6">  
      <input type="text" class="form-control"  name="prenom" placeholder="prenom" required>
    </div>
	<div class="form-group col-md-6">
      <input type="email" class="form-control"  name="email" placeholder="email" required>
    </div>
    <div class="form-group col-md-4">
      <select  class="form-control" name="ville">
        <option value="Temmara">Temmara</option>
		<option value="Tanger">Tanger</option>
        <option value="Kinetra">Kinetra</option>
      </select>
    </div>
	
	<div>
	<input type="file" name="image" placeholder="image" required>
	</div>
    
  </div>
  
  <button type="submit" class="btn btn-primary" name="ajouterClient">Ajouter</button>
</form>
<?php 
	}
	else 	if(!empty($_SESSION['iduser']) and !empty($_SESSION['profile']!='Admin'))
	{
?>
	<div class="alert alert-success" role="alert">
	vous n'avez pas le droit d'ajouter un client
</div>
	<?php
	}
	else
	{
	?>
	<div class="alert alert-success" role="alert">
	Il faut <a href="connexion.php"> se connecter </a> pour ajouter un client
</div>
<?php	

	}
?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
