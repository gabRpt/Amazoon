<?php

  //Démarre une session et on regarde si on est admin
  session_start();
  if ($_SESSION['admin']){
    $titre = $_REQUEST['titre'];
    try{
      $PARAM_hote='lakartxela.iutbayonne.univ-pau.fr';
      $PARAM_bdd='tjbaptiste_pro';
      $PARAM_user='tjbaptiste_pro';
      $PARAM_pw='tjbaptiste_pro';
      // $connexion nous permet de se connecter à la base de données
      $connexion   =   new   PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_bdd,   $PARAM_user,$PARAM_pw);

      // On séléction tous les albums contenant ce que contient la variable titre
      $resultats=$connexion->query("SELECT * FROM CD WHERE titre like '%$titre%'");
      $resultats->setFetchMode(PDO::FETCH_OBJ);
      $retour="";

      //Pour tous tuples que l'on a récupéré
      while ($val=$resultats->fetch()){
        $titre=$val->titre;
        $auteur=$val->auteur;
        //on concatène le message de retour avec un lien vers la page suppression.php avec comme
        //paramètre d'url le titre et l'auteur concerné. On met dedans aussi le titre et l'auteur comme "nom du lien"
        $retour = $retour."<br><a href=\"suppression.php?titre=$titre&auteur=$auteur\"> Titre: $titre  |  Auteur/groupe: $auteur</a>";
      }
      echo $retour;
    }
    catch(Exception $er){
        // Si une erreur liée à la base de données -> on affiche l'erreur
        echo 'Erreur : '.$er->getMessage().'<br />';
    }

  }
?>
