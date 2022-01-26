<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
$erreur = "";
$ok = "";
if(isset($_POST['modifierClient']))
{
	if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['ville']))
	{
	$nom = $_POST['nom'] ;
	$prenom = $_POST['prenom'] ;
	$email = $_POST['email'] ;
	$ville = $_POST['ville'] ;
	$idcli = $_POST['idcli'] ;
	
	if(!empty($_FILES['image']['name']))
	{
	$chemin = "pictures/".$_FILES['image']['name'];
	if(move_uploaded_file($_FILES['image']['tmp_name'],$chemin))
	{

	try{
		$sql="update client set nom=?,prenom=?,email=?,ville=?,image=? where idcli=?";

		$query = $conn->prepare($sql);
		$query->bindParam(1, $nom, PDO::PARAM_STR, 25);
		$query->bindParam(2, $prenom, PDO::PARAM_STR, 25);
		$query->bindParam(3, $email, PDO::PARAM_STR, 25);
		$query->bindParam(4, $ville, PDO::PARAM_STR, 25);
		$query->bindParam(5, $chemin, PDO::PARAM_STR, 25);
		$query->bindParam(6, $idcli, PDO::PARAM_INT);
		
		 $query->execute();
		if($query->rowCount() > 0) 
		{
			$ok="le client ".$nom." est bien modifier";
		}
		else
		{
			$erreur="le client ".$nom." n'est pas modifier";
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
		$sql="update client set nom=?,prenom=?,email=?,ville=? where idcli=?" ;

		$query = $conn->prepare($sql);
		$query->bindParam(1, $nom, PDO::PARAM_STR, 25);
		$query->bindParam(2, $prenom, PDO::PARAM_STR, 25);
		$query->bindParam(3, $email, PDO::PARAM_STR, 25);
		$query->bindParam(4, $ville, PDO::PARAM_STR, 25);
		$query->bindParam(5, $idcli, PDO::PARAM_INT);

		
		 $query->execute();
		if($query->rowCount() > 0) 
		{
			$ok="le client ".$nom." est bien modifier";
		}
		else
		{
			$erreur="le client ".$nom." n'est pas modifier";
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
if(!empty($_GET['idClient']))
{
	try{

	$idClient = $_GET['idClient'];
	$sql="select * from client where idcli=?";
	$query = $conn->prepare($sql);
	$query->bindParam(1, $idClient, PDO::PARAM_INT);
	$query->execute();	
	if($query->rowCount()>0)
	{
			$client=$query->fetch();
			?>
	
<form enctype="multipart/form-data" method="POST" action="modifierClients.php">
<div>
<div class="form-group col-md-6">
      <input type="number" class="form-control"  name="idcli" value="<?php echo $client['idcli'] ;?>"  style="display:none" >
    </div>
    <div class="form-group col-md-6">
      <input type="text" class="form-control"  name="nom" value="<?php echo $client['nom'] ;?>" placeholder="nom" required >
    </div>
	<div class="form-group col-md-6">  
      <input type="text" class="form-control"  name="prenom" value="<?php echo $client['prenom'] ;?>" placeholder="prenom" required>
    </div>
	<div class="form-group col-md-6">
      <input type="email" class="form-control"  name="email" value="<?php echo $client['email'] ;?>" placeholder="email" required>
    </div>
    <div class="form-group col-md-4">
      <select  class="form-control" name="ville">
        <option value="temara" <?php if($client['ville']=="temara"){echo "selected";}?>>Temmara</option>
		<option value="tanger" <?php if($client['ville']=="tanger"){echo "selected";}?>>Tanger</option>
        <option value="Kinetra" <?php if($client['ville']=="Kinetra"){echo "selected";}?>>Kinetra</option>
      </select>
    </div>
	
	<div>
	<input type="file" name="image" placeholder="image" >
	<img src="<?php echo $client['image'] ;?>" style="max-width:100px;"/>
	</div>
    
  </div>
  
  <button type="submit" class="btn btn-primary" name="modifierClient">Modifier</button>
</form>
	<?php
		}
		else
		{
			echo "N'existe aucun client de id=".$idClient;
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

