<?php
	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("select persid, persalias, persimg from personnages order by persalias");
	$query -> execute();
	$pers_list = $query->fetchAll(PDO::FETCH_ASSOC);
?>
