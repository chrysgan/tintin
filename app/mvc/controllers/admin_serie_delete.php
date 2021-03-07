<?php

use App\Message as Message;

require_once DIR_MODELS.$controller.'.php';
$affichage = 1;
$class="";
$msg_button =' Supprimer la série';
if(empty($_POST)==true ){
	$action = 'serie_delete';
}
if(
		isset($_POST)
		&& isset($_POST['serid'])
		&& empty($_POST['serid'])==false
		&& isset($_POST['action'])
		&& $_POST['action']=='serie_delete'
	){
	$action = 'validation';
	$msg_button = "Validation de la suppression";
	$class = "warning";
}
if(
		isset($_POST)
		&& isset($_POST['serid'])
		&& empty($_POST['serid'])==false
		&& isset($_POST['action'])
		&& $_POST['action']=='validation'
	){
		$param = $_POST['serid'];
		// Controle qu'il n'y a pas d'objets avec ce type
		$query = $pdo->prepare("select distinct 1 from objets where serid = $param;");
		$query->execute();
		$result = $query->fetch();

	if(!$result){
		$query = $pdo->prepare("delete from series where serid = $param;");
		$query->execute();
		Message::addMsg("La série a été supprimé.");
		$affichage = 2;
	}
	else{
		Message::addMsg("L'éditeur ne peux être supprimé car il est utilisé.");
		$affichage=1;
	}
}

require_once DIR_VIEWS.$controller.'.php';
?>
