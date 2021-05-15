<?php
require_once DIR_MODELS.$controller.'.php';


$urlending="/editeurs/".$objet['ediid']."#".$objet['objid'];

$url =WEBROOT.$page_galleries.$urlending;
$libelle_objet=$objet['objnom'];

require_once DIR_VIEWS.$controller.'.php';
?>
