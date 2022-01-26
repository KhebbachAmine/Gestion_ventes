<?php session_start();
include_once("config.php");  //ajouter une ficher de configuration 

$erreur = "";
$ok = "";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>Statistique</title>


</head>
<body>

<?php 
include_once("menu.php");
?>

<div>
	<h4 style="text-align:center">produit par marque</h4>
    <?php
         if(isset($_POST['parMarque']))
         {
    ?>
    <div id="piechart"></div>

    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['produit', 'vente par produit'],

<?php
   try{
        if(!empty($_POST['marque'])  )
        {   
            
            $marque=$_POST['marque'];
   
        
            $sql="select sum(v.quantitevendu) as 'vTotal',p.libelle
            from vente v, produit p where p.idpro = v.idpro and p.marque=? group by p.idpro";
            $query=$conn->prepare($sql);
            $query->bindParam(1, $marque, PDO::PARAM_STR, 50);

        }
        else
        {   
            $sql="select sum(v.quantitevendu) as 'vTotal',p.libelle
            from vente v, produit p where p.idpro = v.idpro  group by p.idpro";
            $query=$conn->prepare($sql);
        }
          
            $query->execute();
            while($ligne=$query->fetch() )
            {
               echo "['".$ligne['libelle']."', ".$ligne['vTotal']."],";
            }
        
          
        }
        catch(PDOException $e)
        {
            echo $e->getMessage().' '.$e->getCode();
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
        <option value="">Toutes les marques </option>
		<?php
		
		try{
			$sql="select distinct (marque) from produit ";
			$query=$conn->prepare($sql);
			$query->execute(); 
		
			if($query->rowCount() >0)
			{
				while($ligne = $query->fetch())
				{
					echo '<option value="'.$ligne['marque'].'">'.$ligne['marque'].'</option>';
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage().' '.$e->getCode();
		}	
		
		?>
	</select></br>
	
  
	
	
  
  <button type="submit" class="btn btn-primary" name="parMarque">Afficher</button>
</form>
	
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>