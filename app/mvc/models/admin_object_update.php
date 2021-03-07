<?php

	use App\Serie as Serie;
	use App\Editeur as Editeur;
	use App\TypeObjet as TypeObjet;
	use App\Personnage as Personnage;

	// CHARGEMENT DES SERIES
		$serie = new Serie($pdo);
		$GLOBALS['serie_ArrayList_IdNom'] = $serie->getArrayList_IdNom();
		$GLOBALS['serie_List_Id'] = $serie->getListId();

	// CHARGEMENT DES EDITEURS
		$editeur = new Editeur($pdo);
		$GLOBALS['editeur_ArrayList_IdNom'] = $editeur->getArrayList_IdNom();
		$GLOBALS['editeur_List_Id'] = $editeur->getListId();

	// CHARGEMENT DES TYPES
		$type = new TypeObjet($pdo);
		$GLOBALS['type_ArrayList_IdLibt'] = $type->getArrayList_IdLib();
		$GLOBALS['type_List_Id'] = $type->getListId();


	// CHARGEMENT DES PERSONNAGES
		$pers = new Personnage($pdo);
		$GLOBALS['pers_ArrayList_IdAlias'] = $pers->getArrayList_IdAlias();

	// CHARGEMENT ASSOCIATION OBJET - PERSONNAGES
		$query = $pdo->prepare("select objid, persid from objets_persos;");
		$query->execute();
		$obj_pers = $query->fetchAll(PDO::FETCH_ASSOC);
		
	// CHARGEMENT DES OBJETS POUR LA LISTE(OBJECT_CHOICE) ET POUR L'OBJET A UPDATER (OBJECT_LIST)
		$query = $pdo->prepare("
			select
			obj.objid, edi.edinom , ser.sernom, obj.objnom, obj.objtaille, obj.objprix,
			obj.objref, obj.ediid, obj.serid, typ.typeid, obj.objdesc, obj.objactif,
			obj.rangement, obj.mt_achat, obj.possede, obj.detail_sur_possession,objpoids,
			obj.objannee, obj.objmois, typ.typecode ,
			case when oi2.nbimg is null then 0 else oi2.nbimg end nbimg,
			case when oi4.nbpers is null then 0 else oi4.nbpers end nbpers
			from objets obj
			inner join editeurs edi on obj.ediid=edi.ediid
			left join series ser on obj.serid = ser.serid
			inner join types typ on typ.typeid = obj.typeid
			left join (
				select oi.objid, count(oi.imgid) nbimg
			    from objets_images oi
			    group by oi.objid
			) oi2 on oi2.objid = obj.objid
			left join (
				select oi3.objid, count(oi3.persid) nbpers
			    from objets_persos oi3
			    group by oi3.objid
			) oi4 on oi4.objid = obj.objid
			order by edinom, sernom , objnom
		");
		$query->execute();
		$resultset = $query->fetchAll(PDO::FETCH_ASSOC);
		$object_list=[];
		$object_choice=[];
		foreach ($resultset as $obj) {
			$objnom = $obj['edinom'].' - '.$obj['sernom'].' - '. $obj['objnom'];
			array_push($object_choice,array(
				'objid'=>$obj['objid'],
				'objnom'=>$objnom,
				'actif'=>$obj['objactif'],
				'owned'=>$obj['possede'],
				'typecode'=>$obj['typecode'],
				'nbimg'=>$obj['nbimg'],
				'nbpers'=>$obj['nbpers'],
				'objprix'=>$obj['objprix'],
				'objref'=>$obj['objref'],
				'objpoids'=>$obj['objpoids'],
				'objannee'=>$obj['objannee'],
				'objmois'=>$obj['objmois'],
				'objrangement'=>$obj['rangement'],
				'objtaille'=>$obj['objtaille'],
				'objmt_achat'=>$obj['mt_achat']
				)
			);
			array_push($object_list,array(
				'objid'=>$obj['objid'],
				'objnom'=>$obj['objnom'],
				'objtaille'=>$obj['objtaille'],
				'objprix'=>$obj['objprix'],
				'objref'=>$obj['objref'],
				'objediid'=>$obj['ediid'],
				'objserid'=>$obj['serid'],
				'objtypeid'=>$obj['typeid'],
				'objdesc'=>$obj['objdesc'],
				'objactif'=>$obj['objactif'],
				'objrangement'=>$obj['rangement'],
				'objmt_achat'=>$obj['mt_achat'],
				'objpossede'=>$obj['possede'],
				'objdetailpossede'=>$obj['detail_sur_possession'],
				'objpoids'=>$obj['objpoids'],
				'objannee'=>$obj['objannee'],
				'objmois'=>$obj['objmois']
				)
			);
		}

?>
