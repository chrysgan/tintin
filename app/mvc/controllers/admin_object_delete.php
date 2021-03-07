<?php

use App\Message as Message;

require_once DIR_MODELS.$controller.'.php';
$affichage = 1;
$class="";
$msg_button =' Supprimer l\'objet';
if(empty($_POST)==true ){
	$action = 'object_delete';
}
if(
		isset($_POST)
		&& isset($_POST['objid'])
		&& empty($_POST['objid'])==false
		&& isset($_POST['action'])
		&& $_POST['action']=='object_delete'
	){
	$action = 'validation';
	$msg_button = "Validation de la suppression";
	$class = "warning";
}
if(
		isset($_POST)
		&& isset($_POST['objid'])
		&& empty($_POST['objid'])==false
		&& isset($_POST['action'])
		&& $_POST['action']=='validation'
	){
	// Recuperation des chemins images
	$param = intval($_POST['objid']);
	$query = $pdo->prepare("select imgfile from objets_images where objid = {$param};");
	$query->execute();
	$resultset = $query->fetchAll(PDO::FETCH_ASSOC);

	// // Suppression des images sur le disque
	foreach ($resultset as $set) {
		if(!empty($set['imgfile']) && file_exists(DIR_OBJECTS_IMAGES_ROOT.$set['imgfile'])){
			unlink(DIR_OBJECTS_IMAGES_ROOT.$set['imgfile']);
		}
	}
	// suppressions des images en bdd
	$query = $pdo->prepare("delete from objets_images where objid = {$param};");
	$query->execute();

	// suppression des associations en bdd
	$query = $pdo->prepare("delete from objets_persos where objid = {$param};");
	$query->execute();

	// suppression de l'objet en bdd
	$query = $pdo->prepare("delete from objets where objid = {$param};");
	$query->execute();

	Message::addMsg("L'objet a été supprimé.");
	$affichage = 2;
}

require_once DIR_VIEWS.$controller.'.php';
?>
