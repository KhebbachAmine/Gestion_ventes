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
		$datevente=date('c');
		
		$sql="insert into vente(idpro,idcli,quantitevendu,datevente) values ('$produit','$client','$quantite','$datevente')";
		$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if($res>0)
		{
			$ok="la vente de client est bien ajouté";
		}
		else
		{
			$error="la vente n'est pas ajouté";
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
		
		$sql="select idcli,nom,prenom from client ";
		$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		// mysqli_num_rows : permet de compter le nombre de ligne dans la requetes select
		if(mysqli_num_rows($res)>0)
		{
			// mysqli_fetch_assoc : permet de lire les resultats de select ligne par ligne est le met dans un tableau ($ligne)
			
			while($ligne = mysqli_fetch_assoc($res))
			{
			echo '<option value="'.$ligne['idcli'].'">'.$ligne['nom'].' '.$ligne['prenom'].'</option>';
			}
		}
		
		
		?>
	</select></br>
	
	<select  class="form-control" name="produit" required>
		<?php
		
		$sql="select idpro,libelle from produit ";
		$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		// mysqli_num_rows : permet de compter le nombre de ligne dans la requetes select
		if(mysqli_num_rows($res)>0)
		{
			// mysqli_fetch_assoc : permet de lire les resultats de select ligne par ligne est le met dans un tableau ($ligne)
			
			while($ligne = mysqli_fetch_assoc($res))
			{
			echo '<option value="'.$ligne['idpro'].'">'.$ligne['libelle'].'</option>';
			}
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

</body>