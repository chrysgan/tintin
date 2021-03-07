<?php
namespace App;

class Auth {

	// 0 = not connected
	// 1 = la tentative de connexion a echouée (user ou mdp inconnu)
	// 2 = la session en cours n'est pas valide (session user ou mdp inconnu)
	// 3 = la session est valide

	private static $_instance;
	private static $_status;

	public static function Init(){
		self::$_instance = new Auth();
	}

	private function __construct(){
		self::status();
	}

	public static function getStatus(){
		return self::$_status;
	}

	public static function status(){
		if(self::control_session()){
			if(self::is_exist($_SESSION['auth']['login'],$_SESSION['auth']['pwd'])){
				self::$_status = 3;}
			else{
				unset($_SESSION);
				self::$_status = 2;
			}
		}
		elseif(self::control_post()){
			 if(self::is_exist($_POST['login'],sha1($_POST['pwd']))){
			 		Message::addMsg('Vous êtes connecté.');
			 		self::$_status = 3;
			 }
			 else{
			 		Message::addMsg('Identifiant ou mot de passe inconnu');
			 		self::$_status = 1;
			 }

		}
		else{
			self::$_status = 0;
		}
	}

	// Controle validité du POST
	private static function control_post(){
		// Controle POST non vide
		if(isset($_POST['login']) && isset($_POST['pwd']) && !empty($_POST['login']) && !empty($_POST['pwd'])){
			// Controle intégrité des valeurs du POST et renvoie de message
			if(!controlUsername($_POST['login']) or !controlPass($_POST['pwd'])){
				Message::addMsg('Des caractères non autorisés ont été saisis dans le login ou mot de passe');
				return false;
			}
			else{
				return true;
			}
		}
		//  Retour message si login vide
		if(isset($_POST['login']) && empty($_POST['login'])){
			Message::addMsg('Login non renseigné');
		}
		//  Retour message si pwq vide
		if(isset($_POST['pwd']) && empty($_POST['login'])){
			Message::addMsg('Mot de passe non renseigné');
		}
		// Renvoie faux si pas de POST
		return false;
	}

	// Controle de validité de la session
	private static function control_session(){
		if(isset($_SESSION['auth']['login']) && isset($_SESSION['auth']['pwd']) && !empty($_SESSION['auth']['login'])  && !empty($_SESSION['auth']['pwd'])){
			return true;
		}
		else{

			return false;
		}
	}

	// Controle existence dans la DB
	private static function is_exist($username,$userpass){
		global $pdo;
		$query = $pdo->prepare("select MBUSERNAME, MBUSERPASS, MBTYPE, MBID from membres where MBUSERNAME='$username' and MBUSERPASS='$userpass' and validation_received is not null");
		$query->execute();
		$requete = $query->fetchAll(\PDO::FETCH_ASSOC);
		if (count($requete) == 1){
			$_SESSION['auth']['login']=$requete[0]['MBUSERNAME'];
			$_SESSION['auth']['pwd']=$requete[0]['MBUSERPASS'];
			$_SESSION['auth']['type']=sha1($requete[0]['MBTYPE']);
			$_SESSION['auth']['mbid']=$requete[0]['MBID'];
			return true;
		}
		else {
			return false;
		}

	}

}
?>
