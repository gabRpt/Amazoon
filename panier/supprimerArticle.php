<?php
  session_start();
  if(isset($_SESSION['panier'])){
    //On créer un panier temporaire
    $tmp=array();
    $tmp['libelleProduit'] = array();
    $tmp['qteProduit'] = array();
    $tmp['prixProduit'] = array();

    //On récupère le libelle du produit à supprimer
    $prodASuppr=$_POST["libelle"];

    if ($prodASuppr != 'all'){
      //Pour chaque produit contenu dans le panier
      for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
      {
        //si le libelle du produit courant nest pas égal au produita supprimer
        //on l'ajoute au panier temporaire
       if ($_SESSION['panier']['libelleProduit'][$i] !== $prodASuppr)
       {
          array_push( $tmp['libelleProduit'],$_SESSION['panier']['libelleProduit'][$i]);
          array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
          array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
       }
      }
    }
    //On remplace le panier précédent par le panier temporaire
    $_SESSION['panier'] =  $tmp;
    //On efface le panier temporaire
    unset($tmp);
  }
  //On renvoie vers le paneir
  header('location: panier.php');
?>
