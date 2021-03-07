<?php

// CHARGEMENT DES NOMS ET CODES DES TYPES EXISTANTS
	$query = $pdo->prepare("select * from series");
	$query->execute();
	$resultset = $query->fetchAll(PDO::FETCH_ASSOC);

	$serie_list =[];
	foreach ($resultset as $set) {
		array_push($serie_list,array('sernom'=>$set['sernom']));
	}

?>
