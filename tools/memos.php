<script>
//
// JAVASCRIPT
//


// BOUCLE POUR VISUALISER LE CONTENU D'UNE VARIABLE TABLEAU
    var monTab = "un tableau";
    var monArraySeria = '';
		for (var i in monTab)
		{
		    monArraySeria += 'Key: ' + i + '; Valeur: ' + monTab[i] + "\r\n";
		}
		alert(monArraySeria);

// Fonctions anonymes : Mettre une fonction dans une variables
    var carre = function(x){ return x*x;  }
    // les parentheses à la suite de la variable permettent de déclencher l'execution de la fonction.
    carre()
    // si on execute plusieurs fois une fonction stockée dans une variable, s'il y a des variables dans la fonction elles sont gardées
    //  c'est comme si on avait une instance de la fonction
// Fonctions auto-invoquées
    // on encadre la fonction avec des parentheses puis on les fait suivre d'autre parentheses
    (function(x){ code...})();

// AJAX
  // pour le parsing cf admin_object_add.js
    var httpRequest;
    document.getElementById("ediid").onchange = makeRequest;
    function makeRequest() {
      httpRequest = new XMLHttpRequest();
      var url = '/ajax/series_of_editor/'+ this.value;
      if (!httpRequest) {
        alert('Abandon :( Impossible de créer une instance de XMLHTTP');
        return false;
      }
      httpRequest.onreadystatechange = alertContents;
      httpRequest.open('GET', url);
      httpRequest.send();
    }
    function alertContents() {
      if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
          alert(httpRequest.responseText);
        } else {
          alert('Il y a eu un problème avec la requête.');
        }
      }
    }





</script>

<?php

//
//
// PHP
//
//

// Recharger une image si elle a est differente de celle du disque (qui aurait été modifié)
?>  Solution, la fonction filectime() en suffixe:
  <IMG src='<? echo $picture."?".filectime($picture); ?>'>
  La fonction filectime retourne la date de la dernière création du fichier.
  Donc tant que l'image ne change pas, le nom identique à celui en cache dans IE, et l'image s'affichera immédiatement.
  Quand l'image est mise à jour, la date de création change, donc le nom comparé au cache est différent, et uniquement cette image sera rechargée!
<?php


// AFFICHER LE CONTENU D'UNE VARIABLE TABLEAU OU QUE CE SOIT
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";

// TOUTES LES VARIABLES
		$arr = get_defined_vars();
		echo '<pre>';
		print_r($arr);
		echo '</pre>';

		echo '<pre>';
		print_r(array_keys(get_defined_vars()));
		echo '</pre>';

		var_dump($GLOBALS);

// SQL
	// Renvoie les erreurs de la requete
		print_r($req->errorInfo());

		'Utiliser les : pour fermer et ouvrir les conditions';

// REQUETE ET CHARGEMENT DANS DES OBJETS
while($data=$req->fetch(PDO::FETCH_OBJ)){
	$objets[$i]=$data;
	$i++;
}

// PARCOURS D OBJET DANS UN TBALEAU
foreach ($objets as $key => $value) {
	echo $key." : ";
	echo $value->fignom.'<br>';
}

// AUTOLOADER

spl_autoload_register('fonction');

// Cette fonction charge automatiquement une classe en appelant une fonction
// En revanche cette fonction ne doit pas être dans une classe
// Pour charger une fonction qui est dans une classe le paramètre fonction doit être remplacé par un tableau dont la première valeur est la classe à charger et la seconde la méthode (fonction) de la classe à executer

spl_autoload_register(array(__CLASS__,'autoload'));

// VARIABLES
$GLOBALS; // toutes les variables globales (y compris $_SESSION quand elle existe)


// SESSIONS
session_save_path(); // Lieu de sauvegarde des fichiers sur le serveur, en général : /var/lib/php/sessions


//
//
// BOOTSTRAP
//
//

xs < 576 phones
sm >= 576 tablets
md >= 768 desktop
lg >= 992 large desktop
xl >= 1200 extra large desktop
