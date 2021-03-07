<?php

use App\Message as Message;

require_once DIR_MODELS.$controller.'.php';
$affichage = 1;
$class="";
$msg_button =' Supprimer le type d\'objet';
if(empty($_POST)==true ){
	$action = 'type_delete';
}
if(
		isset($_POST['typeid']) 		&& empty($_POST['typeid'])==false
		&& isset($_POST['action'])		&& $_POST['action']=='type_delete'
	){
	$action = 'validation';
	$msg_button = "Validation de la suppression";
	$class = "warning";
}
if(
		isset($_POST['typeid']) 		&& empty($_POST['typeid'])==false
		&& isset($_POST['action']) 		&& $_POST['action']=='validation'
	){

	// Recuperation du chemin du fichier à Supprimer
	$param = $_POST['typeid'];
	$query = $pdo->prepare("select typeimg, typeid from types where typeid = $param;");
	$query->execute();
	$rep_image = $query->fetchAll(PDO::FETCH_ASSOC);
	// Controle qu'il n'y a pas d'objets avec cet editeur
	$query = $pdo->prepare("select distinct 1 from objets where typeid = $param;");
	$query->execute();
	$rep_typeid = $query->fetch();
	// Suppression de l'image
	if(!$rep_typeid){
		if(empty($rep_image[0]['typeimg'])==false && file_exists(DIR_TYPES_IMAGES_ROOT.$rep_image[0]['typeimg'])){
			unlink(DIR_TYPES_IMAGES_ROOT.$rep_image[0]['typeimg']);
		}
		// Supprimer l'enregistrement
		$query = $pdo->prepare("delete from types where typeid = $param;");
		$query->execute();
		Message::addMsg("Le type a été supprimé.");
		$affichage = 2;
	}
	else{
		Message::addMsg("Le type ne peux être supprimé car il est utilisé.");
		$affichage=2;
	}
}

require_once DIR_VIEWS.$controller.'.php';
?>
