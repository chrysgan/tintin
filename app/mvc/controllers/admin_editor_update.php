<?php

	use App\Message as Message;
	use Intervention\Image\ImageManager;

	// SI PAS DE POST
	$affichage = 1;

	$edinom = null;
	$edidesc = null;
	$edipays = null;
	$edicreateyear = null;
	$edicloseyear = null;
	$edicommentaires = null;
	$errors = 0;

	require_once DIR_MODELS.$controller.'.php';

	// SI POST CHOIX EDITEUR FAIT
	if(isset($_POST['action']) && $_POST['action']== 'choose_editor'){
		$affichage = 2;

		// CHARGEMENT DES DONNEES DE l'EDITEUR
		foreach ($editor_list as $editor) {
			if($editor['ediid']==$_POST['ediid']){
				$ediid = $editor['ediid'];
				$edinom = $editor['edinom'];
				$edipays = $editor['edipays'];
				$edidesc = $editor['edidesc'];
				$edicreateyear = intval($editor['edicreateyear']);
				$edicloseyear = intval($editor['edicloseyear']);
				$ediimg = $editor['ediimg'];
				$edicommentaires = $editor['commentaires'];
				break;
			}
		}
	}
	// SI POST UPDATE EDITOR FAIT
	if(isset($_POST['action']) && $_POST['action']== 'update_editor'){
		$affichage = 2;
		// cleanString et attribution des valeurs
		$ediid = cleanStr($_POST['ediid']);
		$edinom = strtoupper(cleanStr($_POST['edinom']));
		$edidesc = cleanStr($_POST['edidesc']);
		$edipays = $_POST['edipays'];
		$edicreateyear = intval($_POST['edicreateyear']);
		$edicloseyear = intval($_POST['edicloseyear']);
		$ediimg = $_POST['ediimg'];
		$edicommentaires = cleanStr($_POST['edicommentaires']);

		// controle la longueur du nom
		if(mb_strlen($edinom)<1){
			$errors++;
			message::addMsg("Le nom de l'éditeur est vide.");
		}
		foreach ($editor_list as $editor) {
			// controle que le nom n'existe pas
			if($editor['edinom']==$edinom && $editor['ediid']!=$ediid){
				$errors++;
				message::addMsg("Le nom de l'éditeur existe déjà.");
			}
		}
		// controle de l'année de création
		if(!(($edicreateyear>EDITOR_MIN_CREATE_YEAR && $edicreateyear<date('Y')) || $edicreateyear==0)){
			$errors++;
			message::addMsg("L'année de création n'est pas dans la plage de date.");
		}
		// controle de l'année de fermeture
		if(!(($edicloseyear>EDITOR_MIN_CREATE_YEAR && $edicloseyear<date('Y')) || $edicloseyear==0)){
			$errors++;
			message::addMsg("L'année de fermeture n'est pas dans la plage de date.");
		}

		// controle de l'image

		if(!empty($_FILES['fileImg']['name']) && in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG']) && $errors == 0){
				// controle fichier precedent existant
				foreach ($editor_list as $editor) {
					// fichier precedent existe => suppression
					if($editor['ediid']==$ediid && !empty($editor['ediimg'])){
						unlink(DIR_EDITORS_IMAGES_ROOT.$editor['ediimg']);
					}
				}
				// Creation de l'image
				$manager = new ImageManager();
				$img =  $manager->make($_FILES['fileImg']['tmp_name']);
				// redimensionnement de l'image
				$img->resize(null, $editor_image_height, function ($constraint) {
						$constraint->aspectRatio();
				});
				$ediimg = strtoupper($edinom.'.PNG');
				$img->save(DIR_EDITORS_IMAGES_ROOT.$ediimg,90);
		}
		else if(empty($_FILES['fileImg']['name']) && $errors == 0){
			foreach ($editor_list as $editor) {
				// fichier precedent existe => renommage
				if($editor['ediid']==$ediid && !empty($editor['ediimg'])){
					$ediimg = $edinom.'.PNG';
					rename(DIR_EDITORS_IMAGES_ROOT.$editor['ediimg'],DIR_EDITORS_IMAGES_ROOT.$ediimg);
				}
			}
		}
		else if(!empty($_FILES['fileImg']['name']) && !in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
			$errors++;
			message::addMsg("La pièce jointe n'a pas été ajouté car elle n'est pas de type image attendue (JPEG PNG GIF).");
		}
		if($errors==0){
			// sauvegarde des données dans la base
			$edinom = str_replace("'","''",$edinom);
			$edidesc = str_replace("'","''",$edidesc);
			$edicommentaires = cleanStr($_POST['edicommentaires']);
			$query = $pdo->prepare("
			update editeurs set edinom ='$edinom', edipays='$edipays', edidesc='$edidesc' , edicreateyear='$edicreateyear', edicloseyear='$edicloseyear', ediimg='$ediimg' , commentaires='{$edicommentaires}' where ediid = $ediid;");
			$query->execute();
			Message::addMsg('Editeur modifié avec succès');
			$affichage = 3;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
