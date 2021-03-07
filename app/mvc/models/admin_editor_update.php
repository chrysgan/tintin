<?php
// CHARGEMENT DES DONNEES PAYS
	$query = $pdo->prepare("select * from pays");
	$query->execute();
	$pays = $query->fetchAll(PDO::FETCH_ASSOC);
	$pays_list=[];
	foreach ($pays as $p) {
		array_push($pays_list,array($p['alpha2'],$p['nom_fr']));
	}

	if(!empty($_POST['edinom'])){
		$edinom = strtoupper(cleanStr($_POST['edinom']));
	}
	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("
					select ediid, edinom, edipays, edidesc, ediimg , edicreateyear, edicloseyear,commentaires
					from editeurs
					order by edinom");
	$query -> execute();
	$editor_list = $query->fetchAll(PDO::FETCH_ASSOC);

?>
