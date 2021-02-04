<?php

  try{
    $titre = $_REQUEST['titre'];  //Récupération des variables passées dans l'URL
    $auteur = $_REQUEST['auteur'];

    $PARAM_hote='lakartxela.iutbayonne.univ-pau.fr';
    $PARAM_bdd='tjbaptiste_pro';
    $PARAM_user='tjbaptiste_pro';
    $PARAM_pw='tjbaptiste_pro';
    // $connexion nous permet de se connecter à la base de données
    $connexion   =   new   PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_bdd,   $PARAM_user,$PARAM_pw);

    // On sélectionne les tuples respectant le titre et auteur donné en url
    $resultats=$connexion->query("SELECT * FROM CD WHERE titre like \"$titre\" AND auteur LIKE \"$auteur\"");
    $resultats->setFetchMode(PDO::FETCH_OBJ);
    $val=$resultats->fetch();

    //On affiche l'image en grand format (400*400 pour garder une lisibilité)
    //Ainsi que tous les détails
    echo "<img src=$val->image width=400 height=400></img>
          <p>
            Titre: $val->titre<br>
            Auteur: $val->auteur<br>
            Genre: $val->genre<br>
            Prix: $val->prix €
          </p>";

    $resultats->closeCursor();  //on ferme de curseur
  }
  catch(Exception $er){
      // Si une erreur liée à la base de données -> on affiche l'erreur
      echo 'Erreur : '.$er->getMessage().'<br />';
  }
?>
