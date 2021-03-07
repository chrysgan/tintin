<?php
// Verifier que l'objet existe
if(!is_numeric($parameters[1])){ $parameters[1] = 0; }
$query = $pdo->prepare("
    select obj.objid, obj.objnom objnom , objtaille, objdesc, objprix, objref, imgfile, edi.edinom edinom, ser.sernom sernom
    from objets obj
    inner join editeurs edi on edi.ediid = obj.ediid
    left join series ser on ser.serid = obj.serid
    inner join objets_images objimg on objimg.objid = obj.objid
    where 1=1
    and obj.objid = {$parameters[1]}
    and imgorder=1
    ;");

$query->execute();
if(intval($query->rowcount())>0){
    $object = $query->fetchAll(PDO::FETCH_ASSOC);

    if(empty($object[0]['objref'])){
        $objref = "nc";
    }
    else {
        $objref = $object[0]['objref'];
    }
    if($object[0]['objprix']==0){
        $objprix = "Offert";
    }
    else if($object[0]['objprix']==-1){
        $objprix="Inconnu";
    }
    else if($object[0]['objprix']==-2){
        $objprix="Ni vendu ni offert";
    }
    else {
        $objprix = $object[0]['objprix']." €";
    }

    $objid = $object[0]['objid'];
    $objnom = $object[0]['objnom'];
    $objtaille = $object[0]['objtaille'];
    $objdesc = $object[0]['objdesc'];
    $edinom = $object[0]['edinom'];
    $sernom = $object[0]['sernom'];
    $objimg = DIR_OBJECTS_IMAGES.$object[0]['imgfile'];
}

// Redirection si l'objet demandé n'existe pas
else {
    $redirection = "location:".WEBROOT.$page_404;
    header($redirection);
}
?>
