<?php
  //On démarre la session et on regarde si on a pas déjà créer un panier
  session_start();
  if(!isset($_SESSION['panier'])){
    $_SESSION['panier']=array();//On créer un tableau "panier"
    $_SESSION['panier']['libelleProduit'] = array();//Dans ce tableau pannier on créer un nouveau tableau libelleproduit
    $_SESSION['panier']['qteProduit'] = array(); //Dans ce tableau pannier on créer un nouveau tableau qteProduit
    $_SESSION['panier']['prixProduit'] = array(); //Dans ce tableau pannier on créer un nouveau tableau prixProduit
  }

  //On récupère tous les paramètres du l'url
    $libelle=$_REQUEST['titre'];
    $prix=$_REQUEST['prix'];
    $nbProd=$_REQUEST['nbProd'];

  //On recherche dans le tableau le libelle du produit
  $positionProduit = array_search($libelle,  $_SESSION['panier']['libelleProduit']);
  //Si il existe déjà on additionne le nombre de produit à celui déjà existant
  if ($positionProduit !== false)
  {
     $_SESSION['panier']['qteProduit'][$positionProduit] += $nbProd ;
  }
  else
  {
     //Sinon on ajoute le produit
     array_push( $_SESSION['panier']['libelleProduit'],"$libelle");
     array_push( $_SESSION['panier']['qteProduit'],$nbProd);
     array_push( $_SESSION['panier']['prixProduit'],$prix);
  }
  echo "Ajouté"; //On renvoie 'ajouté' à la fonction
?>
