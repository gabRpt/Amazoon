<?php
  //On récupère tous les paramètres du l'url
  $lib = $_REQUEST['lib'];
  $nbProd = $_REQUEST['nbProd'];

  //On démarre la session et on regarde si on a  un panier
  session_start();
  if(isset($_SESSION['panier'])){

    //On recherche dans le tableau le libelle du produit
    $positionProduit = array_search($lib,  $_SESSION['panier']['libelleProduit']);

    //On check si le produit est existant dans le panier
    if ($positionProduit !== true)
    {
      //On check si le nombre de produit passé en paramètre est bien un nombre
      if (is_numeric($nbProd)){
        //On update la quantité actuelle du produit
       $_SESSION['panier']['qteProduit'][$positionProduit] = $nbProd;
       //On Récupère le prix du produit
       $prixProd=$_SESSION['panier']['prixProduit'][$positionProduit];
       //On calcul le prix total du produit par rapport à la quantité
       $prixTotal=$nbProd*$prixProd;
       echo $prixTotal; //On retourne le prix total
     }
     else {
       echo 'Veuillez entrer une valeur numérique';
     }
    }
    else {
      echo 'Erreur produit';
    }
  }
  else {
    echo 'Erreur panier';
  }

?>
