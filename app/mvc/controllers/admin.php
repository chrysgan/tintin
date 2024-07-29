<?php
$actions = [
	'editor_add','editor_update','editor_delete',
	'object_add','object_update','object_delete',
	'perso_add','perso_update','perso_delete',
	'serie_add','serie_update','serie_delete',
	'type_add','type_update','type_delete',
	'list_members','list_object_without_images'
];

// CONTROLE QUE LE USER EST BIEN ADMIN
if(!isset($_SESSION['auth']) || ( isset($_SESSION['auth']) && $_SESSION['auth']['type']!=sha1('ADMIN'))){
	$controller = 'home';
	require_once DIR_CONTROLLERS.$controller.'.php';
	exit();
}
// ADMIN MENU PRINCIPAL
if( !isset($parameters[1]) ||
		(isset($parameters[1]) && !in_array($parameters[1],$actions,false))
		){
		if(isset($parameters[1])){unset($parameters);}
		require_once DIR_MODELS.$controller.'.php';
		require_once DIR_VIEWS.$controller.'.php';
		exit;
}
// ADMIN MENUS COMPLEMENTAIRES
if( isset($parameters[1]) && in_array($parameters[1],$actions,false)){
	$controller .= '_'.$parameters[1];
	require_once DIR_CONTROLLERS.$controller.'.php';
	exit;
}
?>
