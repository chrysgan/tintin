<?php

	if(!empty($_POST['typelib'])){
		$typelib = strtoupper(cleanStr($_POST['typelib']));
	}

	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("
					select typeid, typelib, typecode, typeimg
					from types
					order by typelib");
	$query -> execute();
	$type_list = $query->fetchAll(PDO::FETCH_ASSOC);

?>
