<?php

if(in_array($parameters[1],$base_list,false)){
  $query = $pdo->prepare("select * from {$parameters[1]}");
  $query->execute();
  $send = $query->fetchAll(PDO::FETCH_ASSOC);
}
else if ($parameters[1]=='series_of_editor'){
    $query = $pdo->prepare("
      select distinct ser.*
      from series ser
      inner join objets obj on obj.serid = ser.serid
      where obj.ediid = {$parameters[2]}
      ");
    $query->execute();
    $send = $query->fetchAll(PDO::FETCH_ASSOC);
}
// select obj.objdesc
// from objets obj
// inner join objets_persos obj_pers on obj.objid = obj_pers.objid
else if ($parameters[1]=='get_object_desc'){
    $query = $pdo->prepare("
      select obj.objdesc , concat('{DIR_TYPES_IMAGES}',pers.persimg) persimg, persalias
      from objets obj
      left join objets_persos obj_pers on obj.objid = obj_pers.objid
      left join personnages pers on obj_pers.persid = pers.persid
      where obj.objid = {$parameters[2]}
      ");
    $query->execute();
    $send = $query->fetchAll(PDO::FETCH_ASSOC);
}
else if ($parameters[1]=='get_object_image' && isset($parameters[2]) && is_numeric($parameters[2]) && isset($parameters[3]) && is_numeric($parameters[3])){
    $query = $pdo->prepare("
        select imgfile
        from objets_images
        where objid = {$parameters[2]} and imgorder = {$parameters[3]}
      ");
    $query->execute();
    $send = $query->fetchAll(PDO::FETCH_ASSOC);
}
else if ($parameters[1]=='setRateId' && isset($parameters[2]) && is_numeric($parameters[2])&& isset($parameters[3]) && is_numeric($parameters[3])){
    // tester que objid et mdid existent dans le même enreg
    $objid = intval($parameters[2]);
    $note = intval($parameters[3]);
    $mbid = intval($_SESSION['auth']['mbid']);
    $query = $pdo->prepare("
        select 1
        from commentaires
        where objid = {$objid} and mbid = {$mbid}
      ");
    $query->execute();
    // si oui update
    if($query->rowCount()==1){
        $query = $pdo->prepare(" update commentaires set comnote = {$note}   where objid = {$objid} and mbid = {$mbid};");
        $query->execute();
    }
    // si non insert
    else{
        $query = $pdo->prepare(" insert into commentaires ( objid , mbid , comnote ) values ( {$objid} , {$mbid}, {$note} );");
        $query->execute();
    }
    $query = $pdo->prepare("
        select avg(com.comnote) note_moyenne
        from commentaires com
        where objid = {$objid}
        group by objid;");
    $query->execute();
    $send = $query->fetchAll(PDO::FETCH_ASSOC);
}
else {
  $send = null;
}


?>
