<?php

use App\Message as Message;

require_once DIR_MODELS.$controller.'.php';
$affichage = 1;
$class="";
$msg_button =' Supprimer le personnage';
if(empty($_POST)==true ){
	$action = 'pers_delete';
}
if(
		isset($_POST['persid']) 		&& empty($_POST['persid'])==false
		&& isset($_POST['action'])		&& $_POST['action']=='pers_delete'
	){
	$action = 'validation';
	$msg_button = "Validation de la suppression";
	$class = "warning";
}
if(
		isset($_POST['persid']) 		&& empty($_POST['persid'])==false
		&& isset($_POST['action']) 		&& $_POST['action']=='validation'
	){

	// Recuperation du chemin du fichier à Supprimer
	$param = $_POST['persid'];
	$query = $pdo->prepare("select persimg, persid from personnages where persid = $param;");
	$query->execute();
	$img_to_delete = $query->fetchAll(PDO::FETCH_ASSOC);
	// Controle qu'il n'y a pas d'objets avec cet editeur
	$query = $pdo->prepare("select distinct 1 from objets_persos where persid = $param;");
	$query->execute();
	$rep_persid = $query->fetch();
	// Suppression de l'image
	if(!$rep_persid){
		if(empty($img_to_delete[0]['persimg'])==false && file_exists(DIR_PERS_IMAGES_ROOT.$img_to_delete[0]['persimg'])){
			unlink(DIR_PERS_IMAGES_ROOT.$img_to_delete[0]['persimg']);
		}
		// Supprimer l'enregistrement
		$query = $pdo->prepare("delete from personnages where persid = $param;");
		$query->execute();
		Message::addMsg("Le personnage a été supprimé.");
		$affichage = 2;
	}
	else{
		Message::addMsg("Le personnage ne peux être supprimé car il est utilisé.");
		$affichage=2;
	}
}

require_once DIR_VIEWS.$controller.'.php';
?>
