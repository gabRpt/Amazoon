<?php

//Cette page correspond l'ajout dans la BD du CD qui a été entré dans le formulaire de "AjoutCD.php"
//On va donc récuperer ces valeurs et s'en servir pour alimenter la table
//On va aussi placer le fichier transmit dans le formulaire dans le repertoire ./Images/
	session_start();
	if ($_SESSION['admin']){
		//On attribue aux variables les informations nécéssaires à la connexion à la BD
		$PARAM_hote='lakartxela.iutbayonne.univ-pau.fr';
		$PARAM_bdd='tjbaptiste_pro';
	  $PARAM_user='tjbaptiste_pro';
	  $PARAM_pw='tjbaptiste_pro';

		//On attribue aux variables les résultats du formulaire
		$auteur = $_POST['auteur'];
		$genre = $_POST['genre'];
		$prix = $_POST['prix'];
		$titre = $_POST['titre'];
		$nomPhoto = $_FILES["photo"]["name"];

		//Verification que tous les champs ont été remplis
		if ($auteur != '' && $genre != '' && $prix != ''  && $titre != '' && $nomPhoto != '')
		{
	//	if (isset($auteur,$genre,$prix,$titre,$nomPhoto) == false && isset($genre) && isset($prix) && isset($titre) && isset($nomPhoto))


			//Définition du repertoire d'upload
			$uploads_dir = '../accueil/Images/';

			//Récupération du nom de l'image
			$nomPhoto = $_FILES["photo"]["name"];

			//Récupération du nom temporaire de l'image
			$tmp_nom = $_FILES["photo"]["tmp_name"];

			//Nom de la photo + du répertoire où l'on veut la déposer
			$nomPhotoDir = "$uploads_dir".$nomPhoto;
			//Deplacement
			move_uploaded_file($tmp_nom, $nomPhotoDir);

			try{
					//Connexion à la base de données
					$connexion   =   new   PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_bdd,   $PARAM_user,$PARAM_pw);

					//Insertion du CD dans la BD
					$sql = "INSERT INTO CD VALUES (?,?,?,?,?)"; //chaque ? est un paramètre lors de l'execute
					$stmt= $connexion->prepare($sql);
					$stmt->execute([$auteur, $titre, $prix, $nomPhotoDir, $genre]);

					echo '<body onLoad="alert(\'Album bien ajouté !...\')">';
	       //puis on le redirige vers la page d'accueil
	        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';


			}
			catch(Exception $er){
				// Si il y a une erreur liée à la base de données, alors on affiche l'erreur
				echo 'Erreur : '.$er->getMessage().'<br />';
			}

		}

		else {

			//L'un des champs n'a pas été remplis, on préviens donc l'utilisateur, et on le fait revenir en arriere
			echo '<body onLoad="alert(\'L\\\'un des champs du formulaire est manquant...\')">';
			// puis on le redirige vers la page d'accueil
			echo '<meta http-equiv="refresh" content="0;URL=admin.php">';

		}
	}
	else {
		header('location: ../login/login.php');
	}
?>
