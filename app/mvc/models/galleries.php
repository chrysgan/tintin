<?php

	use App\Auth;

	$searchCategory = array('series','editeurs','personnages','types','albums');

	/* Liste des séries */
	$query = $pdo->prepare("
		select distinct e.edinom, s.serid , s.sernom,e.ediimg
		from objets o1
		inner join series s on o1.serid =s.serid
		inner join editeurs e on o1.ediid = e.ediid
		where o1.objactif = 1
		order by 1,3
	");
	$query->execute();
	$resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
	$serie_list = array();
	foreach ($resultSet as $set) {
		array_push($serie_list,	array('sernom' => $set['sernom'],'serid' => $set['serid'],'edinom' => $set['edinom'],'ediimg' => $set['ediimg']));
	}

	/* Liste des editeurs */
	$query = $pdo->prepare("
		select distinct e.ediid, e.edinom, e.ediimg
		from objets o1
		inner join editeurs e on o1.ediid = e.ediid
		order by 2
	");
	$query->execute();
	$resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
	$editeur_list = array();
	foreach ($resultSet as $set) {
		array_push($editeur_list,array('ediid' => $set['ediid'],'edinom' => $set['edinom'],'ediimg' => $set['ediimg']));
	}

	/* Liste des types */
	$query = $pdo->prepare("
		select distinct t.typelib,t.typeid,t.typeimg,t.typecode
		from objets o1
		inner join types t on o1.typeid = t.typeid
		where o1.objactif=1
		order by 4
	");
	$query->execute();
	$resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
	$type_list = array();
	foreach ($resultSet as $set) {
		array_push($type_list,array('typeid' => $set['typeid'],'typecode' => $set['typecode'],'typeimg' => $set['typeimg'],'typelib' => $set['typelib']));
	}

	/* Liste des personnage */
	$query = $pdo->prepare("
		select distinct p.persid, p.persalias,p.persimg
		from objets_persos op
		inner join personnages p on op.persid =p.persid
		where persalias not in ('Aucun','Décor')
		order by 2
	");
	$query->execute();
	$resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
	$personnage_list = array();
	foreach ($resultSet as $set) {
		array_push($personnage_list,array('persid' => $set['persid'],'persalias' => $set['persalias'],'persimg' => $set['persimg']));
	}

	// Récupération des données commentaires liées à l'utilisateur
	$com_list=[];
	if (Auth::getStatus()== 3) {
		$query = $pdo->prepare("
			select com.*
			from membres mb
			inner join commentaires com on com.mbid = mb.mbid
			where com.mbid={$_SESSION['auth']['mbid']}
		");
		$query->execute();
		$com_list = $query->fetchAll(PDO::FETCH_ASSOC);

	}

?>
