<?php

require_once ROOT.'app/core/paths.php';
require_once ROOT.'app/core/variables.php';
require_once ROOT.'app/core/functions.php';

// Chargement de l'autoloader de classes
// spl_autoload_register('load_class');

require_once DIR_CLASSES.'vendor/autoload.php';

// // Initialisation Authentification

App\Auth::Init();


?>
