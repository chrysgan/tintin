<?php
	require_once DIR_MODELS.$controller.'.php';

	use App\Message as Message;
	use Intervention\Image\ImageManager;

	$edinom= null;
	$edidesc= null;
	$edipays= null;
	$edicreateyear = null;
	$edicloseyear = null;
	$ediimg = null;
	$edicommentaires = null;
	$errors = 0;
	$affichage = 1;

	// SI POST -> ANALYSE
	if(isset($_POST) && count($_POST)>0){

			// supprimer les caractères  speciaux  de nom et desc et affectation des valeurs
			$edinom = strtoupper(cleanStr($_POST['edinom']));
			$edidesc = cleanStr($_POST['edidesc']);
			$edipays = strtoupper(cleanStr($_POST['edipays']));
			$edicreateyear = intval($_POST['edicreateyear']);
			$edicloseyear = intval($_POST['edicloseyear']);
			$edicommentaires = cleanStr($_POST['edicommentaires']);


			// controle la longueur du nom
			if(mb_strlen($edinom)<1 || mb_strlen($edinom)>50){
				$errors++;
				message::addMsg("Le nom doit comprendre entre 1 et 50 caractères.");
			}
			foreach ($editor_list as $editor) {
				// controle que le nom n'existe pas
				if( $edinom == $editor['edinom']){
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

			// controle que le fichier est une image
			if(!empty($_FILES['fileImg']['name']) && in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG']) && $errors == 0){
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
			else if(!empty($_FILES['fileImg']['name']) && !in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
				$errors++;
				message::addMsg("La pièce jointe n'a pas été ajouté car elle n'est pas de type image attendue (JPEG PNG GIF).");
			}
			if($errors==0){
				// sauvegarde des données dans la base
				$edinom = str_replace("'","''",$edinom);
				$edidesc = str_replace("'","''",$edidesc);
				$edicommentaires = str_replace("'","''",$edicommentaires);
				$query = $pdo->prepare("
					insert into editeurs (edinom,edipays,edidesc,edicreateyear,edicloseyear,ediimg,commentaires)
					values ('{$edinom}','{$edipays}','{$edidesc}',{$edicreateyear},{$edicloseyear},'{$ediimg}','{$edicommentaires}');" );
				$query->execute();
				Message::addMsg('Editeur créé avec succès');
				$affichage = 2;
			}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
