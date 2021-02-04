<?php
    session_start();
    if (!isset($_SESSION['admin'])){
      if (isset($_POST['login']) && isset($_POST['pwd'])){
          $login = $_POST['login']; //on récupère les variable du formulaire
          $pwd = $_POST['pwd'];
          $login_admin = "admin"; //identifiants administrateur
          $pwd_admin = "admin";

          //On regarde si les valeurs du formulaire correspondent aux logins de l'administration
          if ($login == $login_admin && $pwd == $pwd_admin){

            $_SESSION['admin'] = true;

            header('location: ../admin/admin.php');    //Renvoie vers la page d'administration
          }
          else {
            echo '<body onLoad="alert(\'Membre non reconnu...\')">';
            // puis on le redirige vers la page d'accueil
            echo '<meta http-equiv="refresh" content="0;URL=login.php">';
          }
      } else {
        echo 'Les variables du formulaire ne sont pas déclarées.';
      }
    }
    else {
      header('location: login.php');
    }
?>
