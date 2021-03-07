<?php

	// CHARGEMENT DES DONNEES SERIES EXISTANTES
	$query = $pdo->prepare("
					select serid, sernom, serannee, serdesc, sermois , commentaires
					from series
					order by sernom");
	$query -> execute();
	$serie_list = $query->fetchAll(PDO::FETCH_ASSOC);

?>
