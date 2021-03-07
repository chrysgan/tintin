<?php

	require_once DIR_MODELS.$controller.'.php';

	use App\Message as Message;
	use Intervention\Image\ImageManager;
	use App\ObjectDTO as ObjectDTO;

	$button_name = "Créer l'objet";

	/* gestion de la creation en clonant */
	if(	isset($parameters[2]) && intval($parameters[2])>0 && isset($_POST) 	&& count($_POST)== 0){
		$object = new ObjectDTO($objet,$_FILES);
	}
	else {
		$object = new ObjectDTO($_POST,$_FILES);
	}


	/* Si pas de POST */
	if(isset($_POST) && count($_POST)==0){
		extract($object->toArray());
		$affichage = 1;
	}
	/* Si un POST non vide existe */
	if(isset($_POST) && count($_POST)>0){
		/* si un post est fait avec le bouton 'créér ou modifier objet */
		if( isset($_POST['action']) && $_POST['action']== 'add_update_object'){
			if($object->isValid()){
				$object->save();
				$affichage = 2;
			}
			else{
				extract($object->toArray());
				$affichage = 1;
			}
		}
		/* si un post est fait avec le bouton ajouter une image */
		if( isset($_POST['action']) && $_POST['action']== 'add_images'){
			$object->saveImages();
			extract($object->toArray());
			$affichage = 1;
		}
		/* si un post est fait avec le bouton delete_image */
		if( isset($_POST['delete_image']) && !empty($_POST['delete_image'])){
			$object->deleteImage();
			extract($object->toArray());
			$affichage = 1;
		}
		/* si un post est fait avec le bouton move_up image */
		if( isset($_POST['move_up_image']) && !empty($_POST['move_up_image'])){
			$object->moveUpImage();
			extract($object->toArray());
			$affichage = 1;
		}
		/* si un post est fait avec le bouton move_donw image */
		if( isset($_POST['move_down_image']) && !empty($_POST['move_down_image'])){
			$object->moveDownImage();
			extract($object->toArray());
			$affichage = 1;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';

 ?>
