<?php
  //Démarre une session et on regarde si on est admin
  session_start();
  if ($_SESSION['admin']){

    try{

      $PARAM_hote='lakartxela.iutbayonne.univ-pau.fr';
      $PARAM_bdd='tjbaptiste_pro';
      $PARAM_user='tjbaptiste_pro';
      $PARAM_pw='tjbaptiste_pro';
      // $connexion nous permet de se connecter à la base de données
      $connexion   =   new   PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_bdd,   $PARAM_user,$PARAM_pw);

      $titre = $_REQUEST['titre']; //On récupère les paramètres du lien
      $auteur = $_REQUEST['auteur'];

      //on essaie de supprimer le tuple correspondant à l'auteur et titre (ce sont des clés primaires dans la BD)
      $resultats = $connexion->exec("DELETE FROM CD WHERE auteur LIKE \"$auteur\" AND titre LIKE \"$titre\"");

      if ($resultats > 0){
        //on affiche une alerte
        echo '<body onLoad="alert(\'Le CD à bien été supprimé...\')">';
       //puis on le redirige vers la page d'administration
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
      }
      else {
        //on affiche une alerte
        echo '<body onLoad="alert(\'Il y a eu un petit soucis...\')">';
       //puis on le redirige vers la page d'administration
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
      }

    }
    catch(Exception $er){
        // Si une erreur liée à la base de données -> on affiche l'erreur
        echo 'Erreur : '.$er->getMessage().'<br />';
    }
  }
  else {
    header('location: ../login/login.php');
  }
?>
