<?php

// CHARGEMENT DES OBJETS POUR LA LISTE
	$query = $pdo->prepare("
		select objid, edinom , sernom, objnom,objtaille,objprix,objref,obj.ediid,obj.serid,typeid,objdesc
		from objets obj
		inner join editeurs edi on obj.ediid=edi.ediid
		left join series ser on obj.serid = ser.serid
		order by edinom, sernom , objnom
	");
	$query->execute();
	$resultset = $query->fetchAll(PDO::FETCH_ASSOC);
	$object_list=[];
	$object_choice=[];
	foreach ($resultset as $obj) {
		$objnom = $obj['edinom'].' - '.$obj['sernom'].' - '. $obj['objnom'];
		array_push($object_choice,array('objid'=>$obj['objid'],'objnom'=>$objnom));
		array_push($object_list,array(
			'objid'=>$obj['objid'],
			'objnom'=>$obj['objnom'],
			'objtaille'=>$obj['objtaille'],
			'objprix'=>$obj['objprix'],
			'objref'=>$obj['objref'],
			'ediid'=>$obj['ediid'],
			'serid'=>$obj['serid'],
			'typeid'=>$obj['typeid'],
			'objdesc'=>$obj['objdesc']
			)
		);
	}


?>
