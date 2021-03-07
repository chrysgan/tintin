<?php

	use App\Message as Message;
	use Intervention\Image\ImageManager;

	// SI PAS DE POST
	$affichage = 1;

	$persid = null;
	$persalias = null;
	$persnom = null;
	$persprenom = null;
	$persimg = null;
	$persdesc = null;
	$errors = 0;

	require_once DIR_MODELS.$controller.'.php';

	// SI POST CHOIX PERS FAIT
	if(isset($_POST['action']) && $_POST['action']== 'choose_pers'){
		$affichage = 2;

		// CHARGEMENT DES DONNEES DE l'EDITEUR
		foreach ($pers_list as $pers) {
			if($pers['persid']==$_POST['persid']){
				$persid = $pers['persid'];
				$persalias = $pers['persalias'];
				$persnom = $pers['persnom'];
				$persprenom = $pers['persprenom'];
				$persdesc = $pers['persdesc'];
				$persimg = $pers['persimg'];
				break;
			}
		}
	}
	// SI POST UPDATE EDITOR FAIT
	if(isset($_POST['action']) && $_POST['action']== 'update_pers'){
		$affichage=2;
		// cleanString et attribution des valeurs
		$persid = cleanStr($_POST['persid']);
		$persalias = cleanStr($_POST['persalias']);
		$persnom = cleanStr($_POST['persnom']);
		$persprenom = cleanStr($_POST['persprenom']);
		$persdesc = cleanStr($_POST['persdesc']);
		$persimg = cleanStr($_POST['persimg']);

		// controler que l'alias n'existe pas
		foreach ($pers_list as $pers) {
			 if($pers['persalias']==$persalias && $pers['persid']!=$persid){
				 $errors++;
				 message::addMsg("Le personnage existe déjà.");
			 }
		}
		// controler longueur de l'alias
		if(!(mb_strlen($persalias)>0 && mb_strlen($persalias)<=50)){
			$errors++;
			Message::addMsg("La longueur de l'alias est incorrecte");
		}
		// controler longueur du nom
		if(!(mb_strlen($persnom)<=50)){
			$errors++;
			Message::addMsg("La longueur du nom est incorrecte");
		}
		// controler longueur du prenom
		if(!(mb_strlen($persprenom)<=50)){
			$errors++;
			Message::addMsg("La longueur du prenom est incorrecte");
		}
		// controle de l'image
		if(!empty($_FILES['fileImg']['name']) && in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG']) && $errors == 0){
				// controle fichier precedent existant
				foreach ($pers_list as $pers) {
					// fichier precedent existe => suppression
					if($pers['persid']==$persid && !empty($pers['persimg'])){
						unlink(DIR_PERS_IMAGES_ROOT.$pers['persimg']);
					}
				}
				// Creation de l'image
				$manager = new ImageManager();
				$img =  $manager->make($_FILES['fileImg']['tmp_name']);
				// redimensionnement de l'image
				$img->resize(null, $pers_image_height, function ($constraint) {
						$constraint->aspectRatio();
				});
				$persimg = strtoupper($persalias.'.png');
				$img->save(DIR_PERS_IMAGES_ROOT.$persimg);
		}
		else if(empty($_FILES['fileImg']['name']) && $errors == 0){
			foreach ($pers_list as $pers) {
				// fichier precedent existe => renommage
				if($pers['persid']==$persid && !empty($pers['persimg'])){
					$persimg = strtoupper($persalias.'.png');
					rename(DIR_PERS_IMAGES_ROOT.$pers['persimg'],DIR_PERS_IMAGES_ROOT.$persimg);
				}
			}
		}
		else if(!empty($_FILES['fileImg']['name']) && !in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
			$errors++;
			message::addMsg("La pièce jointe n'a pas été ajouté car elle n'est pas de pers image attendue (JPEG PNG GIF).");
		}
		if($errors==0){
			// sauvegarde des données dans la base

			$persalias = str_replace("'","''",$persalias);
			$persnom = str_replace("'","''",$persnom);
			$persprenom = str_replace("'","''",$persprenom);
			$persdesc = str_replace("'","''",$persdesc);

			$query = $pdo->prepare("update personnages set persalias ='$persalias', persprenom='$persprenom', persnom='$persnom' , persimg='$persimg', persdesc = '$persdesc' where persid = $persid;");
			$query->execute();
			Message::addMsg('Personnage modifié avec succès');
			$affichage = 3;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
