<?php
require_once DIR_MODELS.$controller.'.php';


if($objet['serid']==null){
    $urlending="/".$objet['typecode']."/".$objet['ediid'];
}
else{
    $urlending = "/series/".$objet['serid'];
}
$url =WEBROOT.$page_galleries.$urlending;
$libelle_objet=$objet['objnom'];

require_once DIR_VIEWS.$controller.'.php';
?>
