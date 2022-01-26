<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 
include_once("menu.php");
$erreur = "";
$ok = "";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>statistique du vente</title>
</head>
<body>


<div>
	<h4>statistique du vente</h4>
  <div id="piechart"></div>

    
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
 if(isset($_POST['parMarque']))
 {
?>

  <script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['produit', 'vente par produit'],

<?php
  if(!empty($_POST['marque']))
  {
    
      $marque=$_POST['marque'];
      
      $sql="select sum(v.quantitevendu) as 'vTotal',p.libelle
      from vente v, produit p where p.idpro = v.idpro and p.marque='$marque' group by p.idpro";
      $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
      
    
  }else
  {
    $sql="select sum(v.quantitevendu) as 'vTotal',p.libelle 
    from vente v, produit p where p.idpro = v.idpro  group by p.idpro";
    $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
  }
        
  while($ligne = mysqli_fetch_assoc($res) )
  {
    echo "['".$ligne['libelle']."', ".$ligne['vTotal']."],";
  }
?>

]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Ventes', 'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

  
<?php
 }
?>
<form  method="POST" action="statistiques.php">
<div>
	
  
	<select  class="form-control" name="marque" >
    <option value="">Touts les marques</option>
		<?php
		
		$sql="select distinct (marque) from produit ";
		$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		// mysqli_num_rows : permet de compter le nombre de ligne dans la requetes select
		if(mysqli_num_rows($res)>0)
		{
			// mysqli_fetch_assoc : permet de lire les resultats de select ligne par ligne est le met dans un tableau ($ligne)
			
			while($ligne = mysqli_fetch_assoc($res))
			{
			echo '<option value="'.$ligne['marque'].'">'.$ligne['marque'].' </option>';
			}
		}
		
		
		?>
	</select></br>

  <button type="submit" class="btn btn-primary" name="parMarque">Afficher</button>
</form>


</div>

</body>