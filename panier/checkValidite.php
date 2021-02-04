<?php
  //On démarre la session et on regarde si on a  un panier
  session_start();
  if(isset($_SESSION['panier'])){
    //On récupère tous les paramètres de l'url
    $date = $_REQUEST['date'];
    $numeros = $_REQUEST['numeros'];
    $cvc = $_REQUEST['cvc'];

    if(strlen($numeros) == 16){ // Check s'il y a 16 chiffres saisis
      if($numeros[0] == $numeros[15]){  //Check si le Premier et dernier chiffre sont les mêmes
        if(strlen($cvc) == 3){  //Check s'il y a 3 chiffres dans le cvc

          $currentDate = date_create(date('Y-m'));  //Récupération de la date du jour
          $dateFormate = date_create($date);  //Conversion de la date en string vers un format Date
          $difference = $currentDate->diff($dateFormate); //Récupération de la différence entre les deux dates
          $diff = $difference->format('%m');  //On formate le résultat en fonction du nombre de mois de différence

          if (intval($diff)<3){ //Check si la carte est valide de + de 3 mois
            echo 'La date de validité de la carte doit être supérieure à la date du jour de plus de 3 mois.';
          }
          else {
            //Ici, toutes les vérification on été bonnes
            //Nous pouvons donc reset le panier et afficher un message de retour
            $_SESSION['panier']=array();
            $_SESSION['panier']['libelleProduit'] = array();
            $_SESSION['panier']['qteProduit'] = array();
            $_SESSION['panier']['prixProduit'] = array();
            echo 'Commande prise en compte, vous allez être redirigé !';
          }
        }
        else {
          echo 'Le cvc doit être de 3 chiffres !';
        }
      }
      else {
        echo 'Le premier et dernier numéro de votre carte ne sont pas les mêmes !';
      }
    }
    else {
      echo "Il doit y avoir 16 chiffres dans votre numéro de carte ! ";
    }
  }
  else {
    header('location: ../accueil/index.php');
  }
?>
