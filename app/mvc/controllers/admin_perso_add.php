<?php
	require_once DIR_MODELS.$controller.'.php';

	use App\Message as Message;
	use Intervention\Image\ImageManager as ImageManager;

	$persid= null;
	$persnom= null;
	$persprenom = null;
	$persalias= null;
	$persdesc= null;
	$persimg = null;
	$errors = 0;
	$affichage = 1;


	// Si un post existe
	if(isset($_POST) && count($_POST)>0){

		// supprimer les caractères  speciaux  de nom et desc
		$persnom = cleanStr($_POST['persnom']);
		$persprenom = cleanStr($_POST['persprenom']);
		$persalias = strtoupper(cleanStr($_POST['persalias']));
		$persdesc = cleanStr($_POST['persdesc']);


		// controler que le nom n'existe pas
		if(in_array($persalias, $persalias_list, false)){
			$errors++;
			Message::addMsg("Le nom du personnage existe déjà.");
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

		// Creation de l'image si pas d'erreur
		if(!empty($_FILES['fileImg']['tmp_name']) && in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG']) && $errors == 0){
			$manager = new ImageManager();
			$img =  $manager->make($_FILES['fileImg']['tmp_name']);
			// redimensionnement de l'image
			$img->resize(null, $pers_image_height, function ($constraint) {
					$constraint->aspectRatio();
			});
			$persimg = strtoupper($persalias.'.png');
			$img->save(DIR_PERS_IMAGES_ROOT.$persimg);
		}
		else if(!empty($_FILES['fileImg']['tmp_name']) && !in_array(strtoupper(substr(mime_content_type($_FILES['fileImg']['tmp_name']),6)),['JPEG','GIF','PNG'])){
			$errors++;
			message::addMsg("La pièce jointe n'a pas été ajouté car elle n'est pas de type image attendue (JPEG PNG GIF).");
		}
		if($errors ==0 ){

			$persalias = str_replace("'","''",$persalias);
			$persnom = str_replace("'","''",$persnom);
			$persprenom = str_replace("'","''",$persprenom);
			$persdesc = str_replace("'","''",$persdesc);

			$query = $pdo->prepare("insert into personnages (persalias,persnom,persprenom,persimg,persdesc) values ('$persalias','$persnom','$persprenom','$persimg','$persdesc');" );
			$query->execute();
			Message::addMsg('Personnage créé avec succès');
			$affichage = 2;
		}
	}
	require_once DIR_VIEWS.$controller.'.php';
 ?>
