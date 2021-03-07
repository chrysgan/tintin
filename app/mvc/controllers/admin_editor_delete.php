<?php

use App\Message as Message;

require_once DIR_MODELS.$controller.'.php';
$affichage = 1;
$class="";
$msg_button =' Supprimer l\'éditeur';
if(empty($_POST)==true ){
	$action = 'editor_delete';
}
if(
		isset($_POST)
		&& isset($_POST['ediid'])
		&& empty($_POST['ediid'])==false
		&& isset($_POST['action'])
		&& $_POST['action']=='editor_delete'
	){
	$action = 'validation';
	$msg_button = "Validation de la suppression";
	$class = "warning";
}
if(
		isset($_POST)
		&& isset($_POST['ediid'])
		&& empty($_POST['ediid'])==false
		&& isset($_POST['action'])
		&& $_POST['action']=='validation'
	){
	// Recuperation du chemin du fichier à Supprimer
	$param = $_POST['ediid'];
	$query = $pdo->prepare("select ediimg, ediid from editeurs where ediid = $param;");
	$query->execute();
	$result_path_image = $query->fetchAll(PDO::FETCH_ASSOC);
	// Controle qu'il n'y a pas d'objets avec cet editeur
	$query = $pdo->prepare("select distinct 1 from objets where ediid = $param;");
	$query->execute();
	$resultset = $query->fetch();
	// Suppression de l'image
	if(!$resultset){
		if(empty($result_path_image[0]['ediimg'])==false && file_exists(DIR_EDITORS_IMAGES_ROOT.$result_path_image[0]['ediimg'])){
			unlink(DIR_EDITORS_IMAGES_ROOT.$result_path_image[0]['ediimg']);
		}
		// Supprimer l'enregistrement
		$query = $pdo->prepare("delete from editeurs where ediid = $param;");
		$query->execute();
		Message::addMsg("L'éditeur a été supprimé.");
		$affichage = 2;
	}
	else{
		Message::addMsg("L'éditeur ne peux être supprimé car il est utilisé.");
		$affichage=2;
	}
}

require_once DIR_VIEWS.$controller.'.php';
?>
