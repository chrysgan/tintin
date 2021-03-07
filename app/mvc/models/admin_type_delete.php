<?php
	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("select typeid, typelib, typecode, typeimg from types order by typelib");
	$query -> execute();
	$editor_list = $query->fetchAll(PDO::FETCH_ASSOC);
?>
