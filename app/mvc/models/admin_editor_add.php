<?php
// CHARGEMENT DES DONNEES PAYS
	$query = $pdo->prepare("select * from pays");
	$query->execute();
	$pays = $query->fetchAll(PDO::FETCH_ASSOC);
	$pays_list=[];
	foreach ($pays as $p) {
		array_push($pays_list,array($p['alpha2'],$p['nom_fr']));
	}

// CHARGEMENT DES NOMS EDITEURS EXISTANTES
	$query = $pdo->prepare("select edinom from editeurs");
	$query->execute();
	$resultset = $query->fetchAll(PDO::FETCH_ASSOC);
	$editor_list =[];
	foreach ($resultset as $set) {
		array_push($editor_list,array("edinom"=>$set['edinom']));
	}
?>
