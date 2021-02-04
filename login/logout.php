<?php
  //On démarre la session
  session_start();
  //On détruit toutes les variables de session
  session_unset();
  //On détruit la session
  session_destroy();
  //On renvoie vers la page d'accueil
  header('location: ../accueil/index.php');
?>
