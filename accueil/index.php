<?php
	//Entete de la page
	echo "<BODY>
				<HEAD>
					<TITLE> Amazoon - Revendeur de CD </TITLE>
				</HEAD>
					<h1 align=center>Amazoon</h1>
					<h2 align=center>Amazoon est un site indépendant créé en 2013 par Gabin RAAPOTO et Theo JEAN-BAPTISTE.</h2>
					<div id=navbar></div>";
					// ^^cette division sera complétée par la fonction navbar() affichant une barre de menu
	echo "<h3>Voici les CDs disponibles : </h3></br>
				</BODY>";


		//les column reprènent des principes des sizer avec wxwidgets
		// Permet de créer des zones dans la page
		echo"<style>
				*{
				  box-sizing: border-box;
				}
				.columnh {
				  float: left;
				  width: 100%;
				  height: 200px;
				}
				.columnv {
				  float: left;
				  width: 50%;
				  height: 200px;
				}
				.columnvf {
				  float: left;
				  width: 100%;
				  height: 200px;
				}
				.left {
				  width: 20%;
				}
				.right {
				  width: 80%;
				}
				.nbProd {
					width: 40px;
					height: 25px;
				}";

		//Ici on défini toutes les fonctions utilisées par les éléments de la page
		//Cette fonction permet d'affichers tous les détails quand on clique sur le bouton détails
		//On récupère le titre et auteur de l'album sur lequelle on a voulu afficher les Détails
		//Et on les envoie paramètre d'url en appelant détails.php qui
		//On affiche le résultat envoyé par détails.php dans la division ayant pour identifiant imgDetails
		echo"</style>
				<script>
					function afficherDetails(titre,auteur){
						var xmlhttp = new XMLHttpRequest();
		        var details = document.getElementById('imgDetails');

		        xmlhttp.onreadystatechange = function() {
		          if (this.readyState == 4 && this.status == 200) {
		            details.innerHTML=this.responseText;
		          }
		        };
		        xmlhttp.open('GET','details.php?titre='+titre+'&auteur='+auteur,true);
		        xmlhttp.send();
					}";
		//Cette fonction reprend le même principe que la précédente
		echo"		function ajoutPanier(titre,prix,idProd){
						var xmlhttp = new XMLHttpRequest();
		        var span = document.getElementById('s'+idProd);
						var nbProd = document.getElementById(idProd).value;

		        xmlhttp.onreadystatechange = function() {
		          if (this.readyState == 4 && this.status == 200) {
		            span.innerHTML=this.responseText;
		          }
		        };
		        xmlhttp.open('GET','../panier/ajoutPanier.php?titre='+titre+'&prix='+prix+'&nbProd='+nbProd,true);
		        xmlhttp.send();
					}";
		//Cette fonction affiche la barre de navigation dans la division vue au tout début
		//Cette barre est récupérée dans navbar.php
		echo"		function navbar(){
		        var xmlhttp = new XMLHttpRequest();
		        var navbar = document.getElementById('navbar');

		        xmlhttp.onreadystatechange = function() {
		          if (this.readyState == 4 && this.status == 200) {
		            navbar.innerHTML=this.responseText;
		          }
		        };
		        xmlhttp.open('GET','navbar.php',true);
		        xmlhttp.send();
		      }
		      navbar();
				</script>
				<div class='columnv'>";

try {
		//Paramètres d'accès à la base de données

		$PARAM_hote='lakartxela.iutbayonne.univ-pau.fr';
		$PARAM_bdd='tjbaptiste_pro';
		$PARAM_user='tjbaptiste_pro';
		$PARAM_pw='tjbaptiste_pro';
        // $connexion nous permet de se connecter à la base de données
        $connexion   =   new   PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_bdd,   $PARAM_user,$PARAM_pw);

        // On sélectionne les 5 premiers cd de la base de données
        $resultats=$connexion->query("SELECT * FROM CD");
        $resultats->setFetchMode(PDO::FETCH_OBJ);
				$idProd=0;	//Idproduit permettant d'identifier les produits dans les fonctions
				$details="</div><div class=columnv>"; //Premier sizer vertical divisant la page en deux
		while($val= $resultats->fetch()) {

			$idProd++;

			//Création de l'image redimensionnée
			//Hauteur et largeur de l'image que l'on souhaite
			$hauteur = 100;
			$largeur = 100;

			//Creation de l'image vide de taille $hauteur et $largeur
			$image = imagecreate($hauteur,$largeur);

			//Recuperation du lien de l'image
			$filename = $val->image;

			//Recuperation de la taille l'image
			$tabTaille = getimagesize($filename);

			//Recopie de l'image dans $filename
			$image_r = imagecreatefromjpeg($filename);


			//Copie de $image_r vers $image avec la taille de $image
			imagecopyresampled($image,$image_r, 0,0,0,0, $hauteur, $largeur, $tabTaille[0], $tabTaille[1]);

			//Sauvegarde de la nouvelle image dans le dossier ./Images/
			ImageJpeg($image,$val->image ."_redim.jpg");

			//Affichage de l'image redimensionnéede l'album
			$source=$val->image.'_redim.jpg';
			echo "		<div class=columnh>
									<div class='columnv left'>
										<img src=$source><br><br>
										<div>";

			//Affichage du champ permettant de choisir la quantite voulu ainsi que le boutton
			//permettant d'ajouter au panier qui appelle la fonction ajouter au panier avec comme Paramètres
			//le titre de l'album, son prix et son idProd
			//idProd permet de récupérer la quantite
			//sidProd affichera "Ajouté" si le produit est ajouté
			echo"							<input id=$idProd onkeydown=\"return false;\" class=nbProd type=number min=1 value=1>
												<button onclick='ajoutPanier(\"$val->titre\",\"$val->prix\",\"$idProd\")'>Ajouter</button>
												<span id=s$idProd></span>
										</div>";

			//Affichage de quelques détails sur l'album ainsi que le bouton permettant d'afficher les détails
			//afficherDétails a comme paramètres le titre et auteur de l'album dont on souhaite afficher les détails
			echo"				</div>
									<div class='columnv right'>
										Titre: $val->titre<br>
										Auteur: $val->auteur<br><br>
										<button onclick='afficherDetails(\"$val->titre\",\"$val->auteur\")'>Détails</button>
									</div>
								</div>";


			//Destruction de l'image créée
			ImageDestroy($image);

		}
		echo "</div><div id=imgDetails class=columnv></div>";
	}
    catch(Exception $er){
        // Si une erreur liée à la base de données -> on affiche l'erreur
        echo 'Erreur : '.$er->getMessage().'<br />';
    }
?>
