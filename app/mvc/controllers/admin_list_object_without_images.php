<?php
	use App\Message as Message;
	use Intervention\Image\ImageManager;
	use App\ObjectDTO as ObjectDTO;

	// Variables pour les boutons et menus
	$button_name = "Modifier l'objet";

	// Chargement des données
	require_once DIR_MODELS.$controller.'.php';

	// S'il n'y a pas de param[2] affichage de la liste
	if(!isset($parameters[2]) || (isset($parameters[2]) && intval($parameters[2])<1)){
		$affichage = 3;
	}

	// S'il y a un  param[2] mais pas de post
	if(	isset($parameters[2])
		&& intval($parameters[2])>0
		&& isset($_POST)
		&& count($_POST)== 0
	){
	/* verifier que l'id existe */

	/* remplissage d'un array pour alimenter le param 1 du constructeur */
		foreach ($object_list as $objet) {
			if(intval($parameters[2]) == intval($objet['objid']) ){
				// ajouter à l'objet le tableau des personnages
				$personnages = array();
				foreach ($obj_pers as $objpers) {
					if(intval($objpers['objid'])==intval($objet['objid'])){
						settype($objpers['persid'],"int");
						array_push($personnages,$objpers['persid']);
					}
				}
				$objet['personnages'] = $personnages;
				$object = new ObjectDTO($objet,null);
			}
		}
		$object->loadImages();
		extract($object->toArray());
		$affichage = 1;
	}
	// S'il y a un  param[2] et un post





	if(isset($_POST) && count($_POST)>0){
		$object = new ObjectDTO($_POST,$_FILES);
		/* si un post est fait avec le bouton 'créér ou modifier objet */
		if( isset($_POST['action']) && $_POST['action']== 'add_update_object'){
			if($object->isValid()){
				$object->update();
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
