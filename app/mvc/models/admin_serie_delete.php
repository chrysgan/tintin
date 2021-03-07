<?php
	// CHARGEMENT DES DONNEES EDITEURS EXISTANTES
	$query = $pdo->prepare("select serid, sernom from series order by sernom");
	$query -> execute();
	$serie_list = $query->fetchAll(PDO::FETCH_ASSOC);
?>
