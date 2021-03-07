<?php

	use App\Message as Message;
	use Intervention\Image\ImageManager;

	// SI PAS DE POST
	$affichage = 1;

	$typelib = null;
	$typecode = null;
	$typeimg = null;
	$errors = 0;

	require_once DIR_MODELS.$controller.'.php';

	// SI POST CHOIX EDITEUR FAIT
	if(isset($_POST['action']) && $_POST['action']== 'choose_type'){
		$affichage = 2;

		// CHARGEMENT DES DONNEES DE l'EDITEUR
		foreach ($type_list as $type) {
			if($type['typeid']==$_POST['typeid']){
				$typeid = $type['typeid'];
				$typelib = $type['typelib'];
				$typecode = $type['typecode'];
				$typeimg = $type['typeimg'];
				break;
			}
		}
	}
	// SI POST UPDATE EDITOR FAIT
	if(isset($_POST['action']) && $_POST['action']== 'update_type'){
		// cleanString et attribution des valeurs
		$typeid = cleanStr($_POST['typeid']);
		$typelib = cleanStr($_POST['typelib']);
		$typeimg = $_POST['typeimg'];
		$typecode = strtoupper(cleanStr($_POST['typecode']));

		// controler que le nom n'existe pas
		foreach ($type_list as $type) {
			 if($type['typelib']==$typelib && $type['typeid']!=$typeid){
				 $errors++;
				 message::addMsg("Le type existe déjà.");
			 }
		}
		// controler la longueur du nom
		if(!(mb_strlen($typelib)!=0 && mb_strlen($typelib)<=50)){
			$errors++;
			Message::addMsg("La longueur du nom est de maximum 25 caractères et ne peut être vide.");
		}

		// controler que le code n'existe pas
		foreach ($type_list as $type) {
			 if($type['typecode']==$typecode && $type['typeid']!=$typeid){
				 $errors++;
				 message::addMsg("Le code type existe déjà.");
			 }
		}

		// controler la longueur du code
		if(!(mb_strlen($typecode)!=0 && mb_strlen($typecode)<=5)){
			$errors++;
			Message::addMsg("La longueur du code est de maximum 5 caractères et ne peut être vide.");
		}

		// Gestion des images

		if(!empty($_FILES['fileImg']['name']) && in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
				// controle fichier precedent existant
				foreach ($type_list as $type) {
					// fichier precedent existe => suppression
					if($type['typeid']==$typeid && !empty($type['typeimg'])){
						unlink(DIR_TYPES_IMAGES_ROOT.$type['typeimg']);
					}
				}
				// Creation de l'image
				$manager = new ImageManager();
				$img =  $manager->make($_FILES['fileImg']['tmp_name']);
				// redimensionnement de l'image
				$img->resize(null, $type_image_height, function ($constraint) {
						$constraint->aspectRatio();
				});
				$typeimg = strtoupper($typecode.'.png');
				$img->save(DIR_TYPES_IMAGES_ROOT.$typeimg,90);
		}
		else if(empty($_FILES['fileImg']['name'])){
			foreach ($type_list as $type) {
				// fichier precedent existe => renommage
				if($type['typeid']==$typeid && !empty($type['typeimg'])){
					$typeimg = strtoupper($typecode.'.png');
					rename(DIR_TYPES_IMAGES_ROOT.$type['typeimg'],DIR_TYPES_IMAGES_ROOT.$typeimg);
				}
			}
		}
		else if(!empty($_FILES['fileImg']['name']) && !in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
			$errors++;
			message::addMsg("La pièce jointe n'a pas été ajouté car elle n'est pas de type image attendue (JPEG PNG GIF).");
		}
		if($errors==0){
			// sauvegarde des données dans la base
			$typelib = str_replace("'","''",$typelib);
			$typecode = str_replace("'","''",$typecode);
			$query = $pdo->prepare("update types set typelib ='$typelib', typeimg='$typeimg', typecode='$typecode' , typeimg='$typeimg' where typeid = $typeid;");
			$query->execute();
			Message::addMsg('Type modifié avec succès');
			$affichage = 3;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
