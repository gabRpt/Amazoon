<?php
  //on regarde si est pas déjà connecté
  session_start();
  if (isset($_SESSION['admin'])){
    header('location: ../accueil/index.php');
  }

  //Affichage d'un simple formulaire
  //Le bouton renvoie vers login_check.php
  echo "<!DOCTYPE html>
        <html lang=fr dir=ltr>
        <head>
          <meta charset=utf-8>
          <title>Page login</title>
        </head>
        <h1>Page de login</h1>
        <div id=navbar></div>
        <br><br>
        <body>
          <form action=login_check.php method=post>
            login<input type=text name=login required><br>
            password<input type=password name=pwd required><br>
            <input type=submit value=Connexion>
          </form>
        </body>
        </html>
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
          navbar();
        </script>";
?>
