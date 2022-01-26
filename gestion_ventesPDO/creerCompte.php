<?php 
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";
if(isset($_POST['creerCompte']))
{
	if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['login'])
		and !empty($_POST['password']) and !empty($_POST['profile']))
	{
	$nom = $_POST['nom'] ;
	$prenom = $_POST['prenom'] ;
	$email = $_POST['email'] ;
	$login = $_POST['login'] ;
	$password = $_POST['password'] ;
	$profile = $_POST['profile'] ;
	
	$chemin = "pictures/".$_FILES['image']['name'];
		if(move_uploaded_file($_FILES['image']['tmp_name'],$chemin))
		{

			try
			{	
				$sql="insert into utilisateur(nom,prenom,email,login,password,profile,image) values (?,?,?,?,?,?,?) " ;
				$query = $conn->prepare($sql);
				$query->bindParam(1,$nom, PDO::PARAM_STR, 50 );
				$query->bindParam(2,$prenom, PDO::PARAM_STR, 50 );
				$query->bindParam(3,$email, PDO::PARAM_STR, 50 );
				$query->bindParam(4,$login, PDO::PARAM_STR, 50 );
				$query->bindParam(5,$password, PDO::PARAM_STR, 50 );
				$query->bindParam(6,$profile, PDO::PARAM_STR, 50 );
				$query->bindParam(7,$chemin, PDO::PARAM_STR, 50 );
				$query->execute();
				if($query->rowCount() >0)
				{
					$ok="l'utilisateur ".$nom." est bien ajouté";
				}
				else
				{
					$erreur="l'utilisateur ".$nom." n'est pas ajouté";
				}
			}catch(PDOException $e)
			{
				echo $e->grtMessage().' '.$e->getCode();
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
<title>Créer un compte</title>


</head>
<body>
<?php 
include_once("menu.php");
?>

<div>
	<h4>Créer un compte</h4>
<?php
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
<form enctype="multipart/form-data" method="POST" action="creerCompte.php">
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
	<div class="form-group col-md-6">
      <input type="text" class="form-control"  name="login" placeholder="login" required>
    </div>
	<div class="form-group col-md-6">
      <input type="password" class="form-control"  name="password" placeholder="password" required>
    </div>
    <div class="form-group col-md-4">
      <select  class="form-control" name="profile">
        <option value="Admin">Admin</option>
		<option value="User">User</option>
      </select>
    </div>
	
	<div>
	<input type="file" name="image" placeholder="image" required>
	</div>
    
  </div>
  
  <button type="submit" class="btn btn-primary" name="creerCompte">Ajouter</button>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
