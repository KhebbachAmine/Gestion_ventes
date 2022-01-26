<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <a class="navbar-brand" href="#">Gestion vente</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Produit
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="AjouterProduit.php">Ajouter</a>
          <a class="dropdown-item" href="ListeProduits.php">Afficher</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clients
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="AjouterClient.php">Ajouter</a>
          <a class="dropdown-item" href="ListeClients.php">Afficher</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ventes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="vendre.php">Vendre</a>
          <a class="dropdown-item" href="statistiques.php">statistiques</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav" style="float:right;">
      <?php
      if (empty($_SESSION['iduser'])) {

      ?>
        <li class="nav-item active">
          <a class="nav-link" href="connexion.php">Connexion </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="creerCompte.php">Créer compte </a>
        </li>
      <?php
      } else {
      ?>
        <li class="nav-item active">
          <a class="nav-link" href="#"><img src="<?php echo $_SESSION['image'] ?>" style="width:30px;"><?php echo $_SESSION['nom'] . ' ' . $_SESSION['prenom'] ?></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="connexion.php?logout">Deconnexion </a>
        </li>
      <?php
      }
      ?>
    </ul>

  </div>
</nav>

<?php
?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
