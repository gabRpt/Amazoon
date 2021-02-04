<?php
  session_start(); //Démarre une session et on regarde si on est admin

  if ($_SESSION['admin']){
    echo "<head>
            <meta charset=utf-8>
            <title>Page d'administration</title>
          </head>
            <h1>Bienvenue dans la page d'administration</h1>
            <body>
              <div id=navbar></div>
              <br><br>
              <h2>Ajout de CD</h2>

              Vous allez ajouter un nouvel album dans la base de données. <br>
              Veuillez ne laisser aucune ligne vide, et veuillez indiquer le lien de la photo que vous voulez utiliser <br>";

              //Creation du formulaire
              echo "<FORM ENCTYPE=multipart/form-data ACTION=ajout.php METHOD=POST>";

              //Lignes demandant du texte
              echo"<p>Genre : <input type=text name=genre required/></p>
              <p>Auteur : <input type=text name=auteur required/></p>
              <p>Titre de l'album : <input type=text name=titre required/></p>
              <p>Prix : <input type=number name=prix step=0.01 required/></p>";

              //Ligne pour insérer la photo
              echo"<input type=file name=photo> <br> <br>";

              //Bouton pour valider l'insertion
              echo"<input type=submit value=Ajouter le CD>
              </FORM>
              <body>";

      //Ici on Afficher un champ de dans lequel on peut saisir un titre de cd, a chaque lettre saisie appelle la fonction
      //afficherCD avec comme paramètre le contenu du champ
      echo"   <br><h2>Suppression de CD</h2>
              <form action=''>
                Titre: <input type=text id=titre onkeyup=afficherCD(this.value)></input>
              </form>
              <p>
                Cliquez pour supprimer :<br>
                <span id=listeTitres></span>
              </p>
              </body>
              <script>
                function navbar(){
                  var xmlhttp = new XMLHttpRequest();
                  var navbar = document.getElementById('navbar');

                  xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      navbar.innerHTML=this.responseText;
                    }
                  };
                  xmlhttp.open('GET','../accueil/navbar.php',true);
                  xmlhttp.send();
                }
                navbar();";

      //A chaque lettre saisie, on va récupérer dans la base de donnée tous les album via getTitres.php avec
      //comme paramètre ce que contient le champ, on affiche ensuite des lien vers la page de suppresion avec comme
      //paramètre le titre et auteur de l'album (voir suppression.php)
      echo"       function afficherCD(str){
                  if (str.length == 0) {
                    document.getElementById('listeTitres').innerHTML = '';
                    return;
                  } else {
                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('listeTitres').innerHTML = this.responseText;
                      }
                    };
                    xmlhttp.open('GET', 'getTitres.php?titre='+str, true);
                    xmlhttp.send();
                  }
                }
              </script>";
  }
  else {
    header('location: ../login/login.php'); //si on est pas admin on est redirigé vers la page de login
  }
?>
