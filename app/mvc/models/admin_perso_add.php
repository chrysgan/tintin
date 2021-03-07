<?php

// CHARGEMENT DES NOMS ET CODES DES TYPES EXISTANTS
	$query = $pdo->prepare("select * from personnages");
	$query->execute();
	$resultset = $query->fetchAll(PDO::FETCH_ASSOC);

	$persalias_list =[];
	foreach ($resultset as $set) {
		array_push($persalias_list,$set['persalias']);
	}
?>
