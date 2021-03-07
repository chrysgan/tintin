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


	// Chargement des données en cas de clonage (chargement initial uniquement)
	// S'il y a un  param[2] mais pas de post
	if(	isset($parameters[2]) && intval($parameters[2])>0 && isset($_POST) 	&& count($_POST)== 0){

		// CHARGEMENT ASSOCIATION OBJET - PERSONNAGES
		$query = $pdo->prepare("select objid, persid from objets_persos where objid = {$parameters[2]};");
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
			where obj.objid = {$parameters[2]}
			order by edinom, sernom , objnom
		");
		$query->execute();
		$resultset = $query->fetchAll(PDO::FETCH_ASSOC);

		/* remplissage d'un array pour alimenter le param 1 du constructeur */
		$personnages = array();
		foreach ($obj_pers as $objpers) {
			settype($objpers['persid'],"int");
			array_push($personnages,$objpers['persid']);
		}

		$objet = array(
			'objnom'=>$resultset[0]['objnom'],
			'objtaille'=>$resultset[0]['objtaille'],
			'objprix'=>$resultset[0]['objprix'],
			'objref'=>$resultset[0]['objref'],
			'objediid'=>$resultset[0]['ediid'],
			'objserid'=>$resultset[0]['serid'],
			'objtypeid'=>$resultset[0]['typeid'],
			'objdesc'=>$resultset[0]['objdesc'],
			'objactif'=>$resultset[0]['objactif'],
			'objrangement'=>$resultset[0]['rangement'],
			'objmt_achat'=>$resultset[0]['mt_achat'],
			'objpossede'=>$resultset[0]['possede'],
			'objdetailpossede'=>$resultset[0]['detail_sur_possession'],
			'objpoids'=>$resultset[0]['objpoids'],
			'objannee'=>$resultset[0]['objannee'],
			'objmois'=>$resultset[0]['objmois']
		);

		$objet['personnages'] = $personnages;
	}

























?>
