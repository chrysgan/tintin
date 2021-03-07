<?php

	use App\Message as Message;
	use Intervention\Image\ImageManager;

	// SI PAS DE POST
	$serid= null;
	$sernom = null;
	$serannee = null;
	$sermois = null;;
	$serdesc = null;
	$sercommentaires=null;

	$errors = 0;
	$affichage = 1;

	require_once DIR_MODELS.$controller.'.php';

	// SI POST CHOIX EDITEUR FAIT
	if(isset($_POST['action']) && $_POST['action']== 'choose_serie'){
		$affichage = 2;

		// CHARGEMENT DES DONNEES DE A SERIE
		foreach ($serie_list as $serie) {
			if($serie['serid']==$_POST['serid']){
				$serid = $serie['serid'];
				$sernom = $serie['sernom'];
				$serannee = intval($serie['serannee']);
				$sermois = intval($serie['sermois']);
				$serdesc = $serie['serdesc'];
				$sercommentaires = $serie['commentaires'];
				break;
			}
		}
	}
	// SI POST UPDATE serie FAIT
	if(isset($_POST['action']) && $_POST['action']== 'update_serie'){
		// Affichage du formaulaire prérempli au cas ou des valeurs seraient fausses
		$affichage =2;
		// cleanString et attribution des valeurs
		$serid = cleanStr($_POST['serid']);
		$sernom = cleanStr($_POST['sernom']);
		$serannee = intval($_POST['serannee']);
		$sermois = intval($_POST['sermois']);
		$serdesc = cleanStr($_POST['serdesc']);
		$sercommentaires = cleanStr($_POST['sercommentaires']);

		// Controle de la longueur du nom
		if(!(mb_strlen($sernom)>0 && mb_strlen($sernom)<=50)){
			$errors++;
			message::addMsg("Le nom de la série doit comprendre entre 1 et 50 caractères.");
		}

		// controler que le nom n'existe pas
		foreach ($serie_list as $serie) {
			 if($serie['sernom']==$sernom && $serie['serid']!=$serid){
				 $errors++;
				 message::addMsg("Le nom de la série existe déjà.");
			 }
		}

		// Controle de l'année de la série
		if($serannee<1926 || $serannee>intval(date('Y'))){
			$errors++;
			message::addMsg("L'année de la série doit être entre 1926 et aujourd'hui.");
		}
		// Controle de du mois de la série
		if($sermois<0 || $sermois>12){
			$errors++;
			message::addMsg("Le mois de la série doit être compris entre 0 et 12. 0 étant mois non connu");
		}
		if($errors==0){
			// sauvegarde des données dans la base

			$sernom = str_replace("'","''",$sernom);
			$serdesc = str_replace("'","''",$serdesc);
			$sercommentaires = str_replace("'","''",$sercommentaires);

			$query = $pdo->prepare("update series set sernom ='{$sernom}', serdesc='{$serdesc}' , serannee={$serannee}, sermois={$sermois} , commentaires='{$sercommentaires}' where serid = {$serid};");
			$query->execute();
			Message::addMsg('Série modifié avec succès');
			// Affichage du retour à la page admin
			$affichage = 3;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
