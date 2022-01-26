<?php  session_start();
include_once("config.php");  //ajouter une ficher de configuration 
if(isset($_GET['logout']))
{
	//vider la session
	session_destroy();
	header('location:connexion.php');
	$_SESSION['iduser']="";
}

if(!empty($_SESSION['iduser']))
	{
		header('location:ListeProduits.php');
	}
$erreur = "";
$ok = "";
if(isset($_POST['connexion']))
{
	if( !empty($_POST['login']) and !empty($_POST['password']) )
	{
	
		$login = $_POST['login'] ;
		$password = $_POST['password'] ;
	
	
	try{
		$sql="select * from utilisateur where login=? and password=?" ;
		$query = $conn->prepare($sql);
		$query->bindParam(1, $login, PDO::PARAM_STR, 25);
		$query->bindParam(2, $password, PDO::PARAM_STR, 25);
		$resultat = $query->execute();
		if($query->rowCount() >0)
		{
			$client = $query->fetch();
			/*ondoit sauvegarder la session de l'utilisateur
			dans php existe un tabeau de session $_SESSION[''] en peut stocker tous ce qu'on veut
			a condition d'ajouter au debut de chaque page : session_start()	*/
			$_SESSION['iduser']=$client['iduser'];
			$_SESSION['nom']=$client['nom'];
			$_SESSION['prenom']=$client['prenom'];
			$_SESSION['profile']=$client['profile'];
			$_SESSION['image']=$client['image'];
			//pour faire une redirection avec PHP en utilise :
			header('location:ListeProduits.php');
		}
		else
		{
			$erreur="erreur de connexion login ou password incorrectes";
		}
	}
	catch(PDOException $e)
	{
		$e->getMessage().' '.$e->getCode();
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
<title>connexion</title>


</head>
<body>
<?php 
include_once("menu.php");
?>

<div>
	<h4>Connexion</h4>
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
<form method="POST" action="connexion.php">
<div>
    
	<div class="form-group col-md-6">
      <input type="text" class="form-control"  name="login" placeholder="login" required>
    </div>
	<div class="form-group col-md-6">
      <input type="password" class="form-control"  name="password" placeholder="password" required>
    </div>
    
  </div>
  
  <button type="submit" class="btn btn-primary" name="connexion">Ajouter</button>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
