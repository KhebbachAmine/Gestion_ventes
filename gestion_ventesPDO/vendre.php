<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";
if(isset($_POST['vendre']))
{
	if(!empty($_POST['client']) and !empty($_POST['produit']) and !empty($_POST['quantite']) )
	{
		$client=$_POST['client'];
		$produit=$_POST['produit'];
		$quantite=$_POST['quantite'];
		$datevente=date('d-m-y');
		
	try{
		$sql="insert into vente(idpro,idcli,quantitevendu,datevente) values (?,?,?,?)";
		$query=$conn->prepare($sql);
		$query->bindParam(1, $produit, PDO::PARAM_INT);
		$query->bindParam(2, $client, PDO::PARAM_INT);
		$query->bindParam(3, $quantite, PDO::PARAM_INT);
		$query->bindParam(4, $datevente, PDO::PARAM_STR, 50);
		$query->execute();
		if($query->rowCount() >0)
		{
			$ok="la vente de client est bien ajouté";
		}
		else
		{
			$erreur="la vente n'est pas ajouté";
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage().' '.$e->getCode();
	}
	}

	else
	{
		$erreur="tous les champs sont obligatoires";
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>vendre un produit</title>


</head>
<body>

<?php 
include_once("menu.php");
?>

<div>
	<h4>vendre un Produit</h4>
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
	
<form  method="POST" action="vendre.php">
<div>
	
  
	<select  class="form-control" name="client" required>
		<?php

		try{
			$sql="select idcli,nom,prenom from client ";
			$query=$conn->query($sql);
	
			if($query->rowCount() >0)
			{
				while($ligne = $query->fetch())
				{
					echo '<option value="'.$ligne['idcli'].'">'.$ligne['nom'].' '.$ligne['prenom'].'</option>';
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage().' '.$e->getConde();
		}
		
		
		?>
	</select></br>
	
	<select  class="form-control" name="produit" required>
		<?php
		
		try{
			$sql="select idpro,libelle from produit ";
			$query=$conn->prepare($sql);
			$query->execute(); 
		
			if($query->rowCount() >0)
			{
				while($ligne = $query->fetch())
				{
					echo '<option value="'.$ligne['idpro'].'">'.$ligne['libelle'].'</option>';
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage().' '.$e->getConde();
		}	
		
		?>
	</select></br>
	
    <div class="form-group col-md-6">
      <input type="text" class="form-control"  name="quantite" placeholder="quantite" required >
    </div>
	
	
	
  
  <button type="submit" class="btn btn-primary" name="vendre">Vendre</button>
</form>
		<?php 
	}
	else 	if(!empty($_SESSION['iduser']) and !empty($_SESSION['profile']!='Admin'))
	{
?>
	<div class="alert alert-success" role="alert">
	vous n'avez pas le droit de vendu
</div>
	<?php
	}
	else
	{
	?>
	<div class="alert alert-success" role="alert">
	Il faut <a href="connexion.php"> se connecter </a> pour vendu
</div>
<?php	

	}
?>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>