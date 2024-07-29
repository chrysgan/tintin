<?php

// Variables des index de pages
$page_home = 'home';
$page_galleries = 'galleries';
$page_404 = '404';
$page_admin = 'admin';
$page_account = 'account';
$page_logout = 'logout';
$page_about = 'about';
$page_phpinfos = 'Infos Php';
$page_matrix = 'matrix';

// Variables des templates
$tmpl_main = 'main_template.php';
$tmpl_return_admin = 'return_admin.php';
$tmpl_object_edition = 'object_edition.php';
$tmpl_object_list = 'object_list.php';
$metadescription='';

//Variables affichage des pages
$website_title = 'Les Figurines de Tintin';
$title_addin = '';
$page_galleries_title = 'Galeries';
$page_account_title = 'Mon compte';
$page_admin_title = 'Gestion du site';
$page_account_title ='A faire en fonction du contexte';
$page_add_information_title = 'Ajouter des informations';
$page_about_title = 'A propos';
$page_phpinfos_title = 'Infos Php';
$page_matrix_title = 'matrix';

//Variables à initialiser pour éviter les erreurs
$content ='';
$messages =[];

//Variables des images
$editor_image_height = 150;
define("OBJECT_IMAGE_HEIGHT", 1000);
$object_image_thumb_height = 200;
$type_image_height = 200;
$pers_image_height = 200;

//Constantes
// OBJECT
define("OBJECT_NAME_MIN_SIZE", 4);
define("OBJECT_NAME_MAX_SIZE", 100);
define("OBJECT_MIN_HEIGHT", 0);
define("OBJECT_MAX_HEIGHT", 190);
define("OBJECT_MIN_WEIGHT", 0);
define("OBJECT_MAX_WEIGHT", 20000);
define("OBJECT_MIN_PRICE",-2);
define("OBJECT_MAX_PRICE",2000);
define("OBJECT_REF_MAX_SIZE", 50);
define("OBJECT_MIN_YEAR", 1929);
define("TEXTAREA_MAX_LENGTH",3000);
define("OBJECT_RANGEMENT_MAX_SIZE",45);
// Editeur
define("EDITOR_MIN_CREATE_YEAR",1800);
// Serie
define("SERIE_YEAR",1926);



//Chargement des variables contextuelles
if($_SERVER['HTTP_HOST']=='tintin'){
	require_once ROOT.'app/core/variables_work.php';
}
else if($_SERVER['HTTP_HOST']=='dev.tintin'){
	require_once ROOT.'app/core/variables_local.php';
}
else if($_SERVER['HTTP_HOST']=='lesfigurinesdetintin.planethoster.world'){
	require_once ROOT.'app/core/variables_distant.php';
}

$database_parameters = [$host,$user,$pwd,$db];

// Initialiser la connexion à la base de données
	try{

		$pdo = new \PDO("mysql:host=$database_parameters[0];dbname=$database_parameters[3]","$database_parameters[1]","$database_parameters[2]");
		$pdo->exec("SET NAMES 'UTF8'");
		// DBD: affichage des erreurs de bdd
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}
	catch (Exception $e){
		// DBD: affichage des erreurs de connection
		exit('Erreur : ' . $e->getMessage());
	}

?>
