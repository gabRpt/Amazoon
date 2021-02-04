<?php
session_start();
  if(isset($_SESSION['panier'])){
    //On affiche les champs de saisie de la carte
    //Quand on rentre un numéro dans le champs des numéros on appelle la fonction checkTaille
    // avec comme paramètre l'idenfiant du champ ainsi que le nombre maximum permis
    //Pareil pour le cvc
    //Pour la date d'expiration le minimum commence à la date d'aujourdui qui est calculé
    //lorsqu'on ouvre la page.
    //la balise div avec comment identifiant retour, contiendra le message de retour une fois le bouton cliqué
    echo "<head>
            <meta charset=utf-8>
            <title>Paiement</title>
          </head>
          <h1>Paiement</h1>
          <div id=navbar></div>
          <br>
            Numéro: <input id=16chiffres type=number onkeyup=checkTaille('16chiffres',9999999999999999) required></input><br>
            Cvc: <input id=cvc type=number onkeyup=checkTaille('cvc',999) required></input><br>
            Date d'expiration: <input id=date type=month min= required></input><br>
            <button onclick=paiement()>Payer</button>
          <div id=retour></div>";

    //css permettant d'enlever les flèches de l'input type=number
    //Le deuxième est pour firefox
    //le premier est pour les autres navigateurs
    echo" <style>
          input::-webkit-outer-spin-button,
          input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
          }
          input[type=number] {
            -moz-appearance: textfield;
          }
          </style>";

      //Affichage de la barre de navigation comme d'habitude
      echo" <script>
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
      //On récupère de la date d'aujourd'hui 'moi et année'
      //On met cette date commme attribut min du champ de sélection de date
      //On met cette date comme date par défaut du champ
      echo"   function dateMin(){
                var date = new Date();
                var mois = date.getMonth()+1;
                var annee = date.getFullYear();
                dateMin = annee + '-' + mois;
                document.getElementById('date').setAttribute('min', dateMin);
                document.getElementById('date').value = dateMin;
              }
            dateMin();";//On éxecute la fonction

      //On vérifie la taille du champe en fonction du paramètre maxLenght
      //id contient l'identifiant du champ dans lequel on veut récupérer la valeur
      //pour la comparer avec maxlenght
      echo"   function checkTaille(id,maxLenght){
              taille=document.getElementById(id).value;

              if (taille > maxLenght){
                var str = taille;
                str = str.slice(0,-1);
                document.getElementById(id).value=str;
              }

            }";
      //fonction permettant de faire passer du temps
      echo"   function sleep(ms) {
              return new Promise(resolve => setTimeout(resolve, ms));
            }";

    //Cette fonction permet d'appeler checkValidite.php avec comme paramètre le contenu des champs
    //Cette fonction retourne un message indiquant si les valeurs saisies sont valides
    //si ce message est le message de confirmation de la commande, nous redirigeons vers la page d'accueil après 2000ms d'attente
    echo"     async function paiement(){
              var xmlhttp = new XMLHttpRequest();
              var retour = document.getElementById('retour');
              var date = document.getElementById('date').value;
              var numeros = document.getElementById('16chiffres').value;
              var cvc = document.getElementById('cvc').value;

              xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  retour.innerHTML=this.responseText;
                }
              };
              xmlhttp.open('GET','checkValidite.php?date='+date+'&numeros='+numeros+'&cvc='+cvc,true);
              xmlhttp.send();

              await sleep(2000);
              if(retour.innerHTML == 'Commande prise en compte, vous allez être redirigé !'){
                window.location.href = '../accueil/index.php';
              }
            }

          </script>";
  }
  else {
    header('location: ../accueil/index.php');
  }
?>
