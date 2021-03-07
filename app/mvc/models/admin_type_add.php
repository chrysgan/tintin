<?php

// CHARGEMENT DES NOMS ET CODES DES TYPES EXISTANTS
	$query = $pdo->prepare("select * from types");
	$query->execute();
	$rep = $query->fetchAll(PDO::FETCH_ASSOC);

	$typelib_list =[];
	foreach ($rep as $r) {
		array_push($typelib_list,$r['typelib']);
	}
	$typecode_list =[];
	foreach ($rep as $r) {
		array_push($typecode_list,$r['typecode']);
	}
?>
