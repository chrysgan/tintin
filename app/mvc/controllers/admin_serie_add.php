<?php
	require_once DIR_MODELS.$controller.'.php';

	use App\Message as Message;

	$sernom= null;
	$serannee = null;
	$sermois = null;
	$serdesc= null;
	$sercommentaires = null;

	$errors = 0;
	$affichage = 1;


	// Si un post existe
	if(isset($_POST) && count($_POST)>0){

		// supprimer les caractères  speciaux  de nom et desc
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
			 if($serie['sernom']==$sernom){
	 			$errors++;
	 			Message::addMsg("Le nom de la série existe déjà.");
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

		if($errors == 0){

			$sernom = str_replace("'","''",$sernom);
			$serdesc = str_replace("'","''",$serdesc);
			$sercommentaires = str_replace("'","''",$sercommentaires);

			$query = $pdo->prepare("insert into series (sernom,serannee, sermois, serdesc, commentaires) values ('$sernom','$serannee','$sermois','$serdesc','{$sercommentaires}');" );
			$query->execute();
			Message::addMsg('Série créée avec succès');
			$affichage = 2;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
