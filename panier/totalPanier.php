<?php
  session_start();
  if(isset($_SESSION['panier'])){
    $total=0; //On initialise le prix total à 0
    //Pour tous les articles dans le paneir on ajoute son prix*quantite au prix total
    for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
    {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
    }
    echo $total; //on renvoie le total
  }
  else {
    header('location: ../accueil/index.php');
  }
?>
