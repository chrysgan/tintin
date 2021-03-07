<?php
// A reactiver si le dump ne se deroule pas bien afin de trouver les anomalies
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dir = dirname(__FILE__) . '/dump'.date('-Y-m-d_H-i-s', time()).'.sql';

echo "Backing up database to {$dir} \r\n";


exec("mysqldump --opt --skip-lock-tables --user='lesfupev_chrysgan' --password='Gregdumon3573' --host='localhost' 'lesfupev_tintin' --result-file={$dir} 2>&1", $output);

var_dump($output);

// ajouter un tache cron là :
// https://world-387.fr.planethoster.net:2083/cpsess2270603981/frontend/paper_lantern/cron/index.html
// /usr/local/bin/php /home/lesfupev/public_html/app/dump/dump.php

// Pour récupérer les données (dump et nouvelles images) faire une synchro ftp avec freefilesync
// parametres ftp dans le fichier habituel
