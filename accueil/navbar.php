<?php
  //Barre de navigation
  //Nous l'avons mise à part puis appelé dans chaque page
  //Cette disposition permet de pouvoir modifier le menu dans chaque page
  //juste en modifiant ce fichier

  //Dans toutes les pages nous voulon afficher au moins l'accueil et le panier
  $navbar = "<button onclick=location.href='../accueil/index.php'>Accueil</button>
             <button onclick=location.href='../panier/panier.php'>Panier</button>";

  //On démarre la session afin et on vérifie si on est administrateur
  session_start();
  if (isset($_SESSION['admin'])){
    //Si on est admin on a pas besoin de se connecter donc on afficher la page permettant d'accéder
    //à l'interface d'administration ainsi qu'un bouton de deconnexion
    $navbar=$navbar." <button onclick=location.href='../admin/admin.php'>Administration</button>
                    <button onclick=location.href='../login/logout.php'>Déconnexion</button>";

  }
  else {
    //sinon on affiche juste un bouton de connexion
    $navbar=$navbar." <button onclick=location.href='../login/login.php'>Connexion</button>";
  }

  //On retourne la navbar que l'on souhaite afficher
  echo $navbar;
?>
