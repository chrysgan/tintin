<?php

	if(!empty($_POST['persalias'])){
		$persalias = strtoupper(cleanStr($_POST['persalias']));
	}

	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("
					select persid, persalias, persnom, persprenom, persimg,persdesc
					from personnages
					order by persalias");
	$query -> execute();
	$pers_list = $query->fetchAll(PDO::FETCH_ASSOC);

?>
