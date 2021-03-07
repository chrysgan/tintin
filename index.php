<?php
session_start();

// ROOT défini le chemin quand l'appel est dans le code
define('ROOT',str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
// WEBRROOT défini le domaine
define('WEBROOT',str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
// Appel du fichier de configuration
require_once ROOT.'app/core/config.php';

// Recuperation des donnees générées par la redirection
$parameters =explode('/',$_GET['p']);

// Retourne la variable controller à partir du param[0]
if(empty($parameters[0])){ $controller = $page_home;}
else { $controller = $parameters[0];}

// Si le fichier controller n'existe pas renvoie sur le controller 404
if (!is_file(DIR_CONTROLLERS.$controller.'.php')){
 $redirection = "location:".WEBROOT.$page_404;
 header($redirection);
}


// appel du controlleur
$page_title = 'page_'.$controller.'_title';
require_once DIR_CONTROLLERS.$controller.'.php';
?>
