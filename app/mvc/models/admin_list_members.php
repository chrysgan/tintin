<?php
    // CHARGEMENT DES MEMBRES

    $query = $pdo->prepare("select mbid, mbusername , mbmail, mbtype, mbnews from membres");
    $query->execute();
    $resultset = $query->fetchAll(PDO::FETCH_ASSOC);
    $members_list=[];
    foreach ($resultset as $mem) {
        array_push(
            $members_list,
            array(
                'mbid'=>$mem['mbid'],
                'mbusername'=>$mem['mbusername'],
                'mbtype'=>$mem['mbtype'],
                'mbmail'=>$mem['mbmail'],
                'mbnews'=>$mem['mbnews']
            )
        );
    }
