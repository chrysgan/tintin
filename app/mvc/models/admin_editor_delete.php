<?php
	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("select ediid, edinom, edipays, edidesc, ediimg from editeurs order by edinom");
	$query -> execute();
	$editor_list = $query->fetchAll(PDO::FETCH_ASSOC);
?>
