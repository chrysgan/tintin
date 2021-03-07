<?php
    // CHARGEMENT DES MEMBRES

    $query = $pdo->prepare("
        SELECT objid, edinom , sernom, typecode, objnom,rangement
        FROM objets obj
        inner join editeurs edi on edi.ediid=obj.ediid
        left join series ser on ser.serid=obj.serid
        inner join types typ on typ.typeid = obj.typeid
        where possede<>1
        order by edinom, sernom, objnom
    ");
    $query->execute();
    $resultset = $query->fetchAll(PDO::FETCH_ASSOC);
    $owned_list=[];
    foreach ($resultset as $mem) {
        array_push(
            $owned_list,
            array(
                'objid'=>$mem['objid'],
                'edinom'=>$mem['edinom'],
                'sernom'=>$mem['sernom'],
                'typecode'=>$mem['typecode'],
                'objnom'=>$mem['objnom'],
                'rangement'=>$mem['rangement']
            )
        );
    }
