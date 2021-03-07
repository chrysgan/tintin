<?php
	require_once DIR_MODELS.$controller.'.php';

	use App\Message as Message;
	use Intervention\Image\ImageManager as ImageManager;

	$typeid= null;
	$typecode= null;
	$typelib= null;
	$typeimg = null;
	$errors = 0;
	$affichage = 1;


	// Si un post existe
	if(isset($_POST) && count($_POST)>0){

		// supprimer les caractères  speciaux  de nom et desc
		$typecode = strtoupper(cleanStr($_POST['typecode']));
		$typelib = cleanStr($_POST['typelib']);

		// controler la longueur du nom
		if(!(mb_strlen($typelib)!=0 && mb_strlen($typelib)<=50)){
			$errors++;
			Message::addMsg("La longueur du nom est de maximum 25 caractères et ne peut être vide.");
		}

		// controler que le nom n'existe pas
		if(in_array($typelib, $typelib_list, false)){
			$errors++;
			Message::addMsg("Le nom du type existe déjà.");
		}
		// controler la longueur du code
		if(!(mb_strlen($typecode)!=0 && mb_strlen($typecode)<=5)){
			$errors++;
			Message::addMsg("La longueur du code est de maximum 5 caractères et ne peut être vide.");
		}
		// controler le code n'existe pas
		if(in_array($typecode, $typecode_list, false)){
			$errors++;
			Message::addMsg("Le code du type existe déjà.");
		}

		// Creation de l'image si pas d'erreur
		if(!empty($_FILES['fileImg']['tmp_name']) && in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG']) && $errors == 0){
			$manager = new ImageManager();
			$img =  $manager->make($_FILES['fileImg']['tmp_name']);
			// redimensionnement de l'image
			$img->resize(null, $type_image_height, function ($constraint) {
					$constraint->aspectRatio();
			});
			$typeimg = strtoupper($typecode.'.jpg');
			$img->save(DIR_TYPES_IMAGES_ROOT.$typeimg);
		}
		else if(!empty($_FILES['fileImg']['tmp_name']) && !in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
			$errors++;
			message::addMsg("La pièce jointe n'a pas été ajouté car elle n'est pas de type image attendue (JPEG PNG GIF).");
		}
		if($errors == 0){

			$typelib = str_replace("'","''",$typelib);
			$typecode = str_replace("'","''",$typecode);

			$query = $pdo->prepare("insert into types (typelib,typecode,typeimg) values ('$typelib','$typecode','$typeimg');" );
			$query->execute();
			Message::addMsg('Type créé avec succès');
			$affichage = 2;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
