<?php

    echo "<head>
        <meta charset=utf-8>
        <title>Panier</title>
      </head>
        <h1>Votre panier</h1>
        <div id=navbar></div>
        <style>
          .nbProd {
            width: 40px;
            height: 25px;
          }
        </style>
        <script>";
      //fonction permettant de mettre à jour le sousTotal de l'article dont la quantité
      //a été modifier, on appelle calculPrix.php avec comme paramètre le libéllé du produit
      //concerné ainsi que la quantité actuelle du produit
      //on met à jour le sous-total puis on appelle la fonction pour mettre à jour le prix total
      echo"  function updatePrix(idProd) {
              var xmlhttp = new XMLHttpRequest();
              var sousTotal = document.getElementById('sousTotal'+idProd);

              xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  sousTotal.innerHTML=this.responseText;
                }
              };
              var libelle = document.getElementById('lib'+idProd).innerHTML;
              var nbProd = document.getElementById('nb'+idProd).value;

              xmlhttp.open('GET','calculPrix.php?lib='+libelle+'&nbProd='+nbProd,true);
              xmlhttp.send();
              updateTotal();
          }";
      //fonction permettant de faire passer le temps
    echo "function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
          }";
      //fonction permettant de mettre à jour le prix total, en appellant totalPanier.php
      //la valeur retournée sera affichée. On attend 100ms le temps que le sous-total soit actualisé
    echo"   async function updateTotal(){
            await sleep(100);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById('total').innerHTML=this.responseText;
              }
            };
            xmlhttp.open('GET','totalPanier.php',true);
            xmlhttp.send();
          }";

    //On affiche la barre de navigation
    echo"   function navbar(){
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
        </script>
        <body>";

    session_start();
    //si on a un panier on peut afficher les articles contenus
    if(isset($_SESSION['panier'])){
      $nbArticles=count($_SESSION['panier']['libelleProduit']);//On compte le nombre d'articles

        if ($nbArticles <= 0)//si on a aucun article
          echo "<br><br>Votre panier est vide !";
        else
        {
            $total=0; //Cout total du panier
            $idProd=0;//idProduit incrémentale
            for ($i=0 ;$i < $nbArticles ; $i++)
            {
                $idProd++;//on incrémente
                //On récupère les informations du produit à la position $i
                $produit=$_SESSION['panier']["libelleProduit"][$i];
                $prix=$_SESSION['panier']['prixProduit'][$i];
                $qte=$_SESSION['panier']['qteProduit'][$i];
                $sousTotal=$qte * $prix; //On calcul de sousTotal du produit
                $total += $sousTotal;//On additionne le total avec le soustotal
                //On affiche le titre du produit
                echo "<br><br><div id=lib$idProd>$produit</div>";
                //On créer un champs n'acceptant que des modifications par les flèches
                //ce qui enlève beaucoup de cas d'erreurs, à chaque flèche activé on
                //execute la fonction updatePrix avec comme paramètre l'identifiant du produit
                echo "Qte: <input onkeydown=\"return false;\" id=nb$idProd oninput=updatePrix($idProd) class=nbProd type=number min=1 size=1 value=".$_SESSION['panier']['qteProduit'][$i].">";
                //On affiche le sousTotal
                echo "<div>
                        <span>Sous total: </span>
                        <span id=sousTotal$idProd>$sousTotal</span>
                        <span> €</span>
                      </div>";
                //On créer un formulaire appelant supprimerArticle.php quand on clique sur le bouton
                //ce formulaire contient une valeur cachée de l'utrilisateur contenant le titre du produit
                //que l'on souhaite supprimer.
                echo "<form action=supprimerArticle.php method=POST>
                        <input type=hidden name=libelle value=\"$produit\">
                        <button type=submit name=btn>Supprimer</button>
                      </form>";

            }
            //On affiche le grand total du panier avec comme id=total afin de pouvoir le modier plus tard
            echo "<br><br><div>
                            <span>Total: </span>
                            <span id=total>$total</span>
                            <span> €</span>
                          </div>";
          //On créer un formulaire appelant supprimerArticle.php quand on clique sur le bouton
          //ce formulaire contient une valeur cachée de l'utrilisateur contenant 'All'
          //permettant de supprimer tous les produits du panier
          //On créer aussi un bouton hors formulaire permettant d'accéder à la page de paiement
            echo "<form action=supprimerArticle.php method=POST>
                    <input type=hidden name=libelle value=all>
                    <button type=submit name=btn>Vider le panier</button>
                  </form>
                  <a href=paiement.php><button>Procéder au paiement</button></a>";
        }
    }
    else {
      echo "<br><br>Votre panier est vide !";
    }
?>
