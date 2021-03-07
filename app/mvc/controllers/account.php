<?php
use App\Message as Message;
use App\Auth as Auth;
use App\MyMail as MyMail;

require_once DIR_MODELS.$controller.'.php';

$mbid = null;
$pseudo = null;
$mail= null;
$mdp1 = null;
$mdp2 = null;
$news= null;
$required = 'required';
$updateaccount = 'Créer le compte';
if(Auth::getStatus()==3 ){$required=''; $updateaccount='Modifier le compte';}
$errors = 0;
$affichage=1;
$page_account_title = 'Création de compte';

// Creation de compte quand pas connecté

// Verifier que les chaines n'ont pas de caractères interdits
if(Auth::getStatus()==3 && empty($_POST)) // si connecté affichage du profil
{
  $query = $pdo->prepare("select * from membres where mbusername = '{$_SESSION['auth']['login']}';");
  $query->execute();
  $result=$query->fetchAll(PDO::FETCH_ASSOC);
  $mbid = $result[0]['mbid'];
  $pseudo = $result[0]['mbusername'];
  $mail = $result[0]['mbmail'];
  if($result[0]['mbnews']=='O'){$news='checked';}
  $affichage = 1  ;
  $page_account_title = 'Votre compte';
}
else if(!empty($_POST) && !isset($parameters[1]) )
{
  $affichage = 1;
  $mbid = intval($_POST['mbid']);
  $pseudo = cleanStr($_POST['pseudo']);
  $mail = cleanStr($_POST['mail']);
  $mdp1 = cleanStr($_POST['mdp1']);
  $mdp2 = cleanStr($_POST['mdp2']);
  if(isset($_POST['news'])){$news='O';}else{$news='N';}

	// Controle que le pseudo est valide et n'existe pas
	if(!empty($pseudo)){
		if(controlUsername($pseudo)){
      $query = $pdo->prepare("select distinct 1 nb from membres where upper(mbusername)=upper('{$pseudo}' and mbid<>'{$mbid}');");
      $query->execute();
      $result=$query->fetch(PDO::FETCH_ASSOC);
      if(intval($result['nb'])>0){
        $errors++;
				message::addMsg('Pseudo déjà utilisé');
			}
		}
		else{
      $errors++;
			message::addMsg('Pseudo non valide (contient des caractères spéciaux).');
		}
	}
	else{
		$errors++;
    message::addMsg('Pseudo obligatoire.');
	}
	// Controle que le mail est intègre et n'existe pas
	if(!empty($mail)){
		if(controlMail($mail)){
      $query = $pdo->prepare("select distinct 1 nb from membres where mbmail='{$mail}' and mbid<>'{$mbid}';");
      $query->execute();
      $result=$query->fetch(PDO::FETCH_ASSOC);
      if(intval($result['nb'])>0){
        $errors++;
				message::addMsg('Mail déjà utilisé.');
      }
		}
    if(controlYopMail($mail)){
      $errors++;
      message::addMsg('Yopmail non accepté.');
    }
		if(!controlMail($mail)){
      $errors++;
			message::addMsg('Mail non valide.');
		}
	}
	else{
    $errors++;
		message::addMsg('Mail obligatoire.');
	}
	// Controle que mdp1 = mdp2
	if(!empty($mdp1) && !empty($mdp2)){
		if(controlPass($mdp1)){
			if($mdp1!=$mdp2){
        $errors++;
				message::addMsg('Les mots de passe ne sont pas identiques.');
			}
		}
		else{
      $errors++;
			message::addMsg('Les mots de passe contient des caractères non autorisés.');
		}
	}
	else if (empty($mdp1) && empty($mdp2) && Auth::getStatus()!=3 ){
		$errors++;
    message::addMsg('Les mots de passe sont vides.');
	}
	// Si ok envoi du mail de validation
	if($errors == 0){
    // sur nouveau compte
    if(Auth::getStatus()!=3){
      // génération du code de validation
  		$string = rand_string(20);

  		// génération d$page_account_title = 'Création de compte';e l'url
  		$url='http://'.$_SERVER['HTTP_HOST'].'/account/'.sha1($string);
      // envoi du mail
      // envoi du mail
      $myMail = new MyMail();
      $myMail->setfrom($mailFrom,'Les Figurines de Tintin');
      $myMail->addaddress($mail);
      $myMail->subject("Validation Inscription Les Figurines de Tintin");
      $message = 	"
    		 Bonjour $pseudo

    		 Votre inscription sur Les Figurines de Tintin sera prise en compte quand vous aurez cliqué sur le lien ci-dessous

    		 $url

    		 Les figurines de Tintin vous remercie pour votre inscription";

      $myMail->body($message);
      $myMail->send();

      $mdp=sha1($mdp1);
  		//stockage dans la db du profil
            $query = $pdo->prepare("insert into membres (mbusername,mbmail,mbuserpass,mbdate,validation_sent,mbtype,mbnews) values ('{$pseudo}','{$mail}','{$mdp}', current_date ,'{$string}','USER','{$news}')");
      $query->execute();
      message::addMsg('Votre inscription a été prise en compte, un mail de validation vous a été envoyé.');
    }
    // sur modif compte
    if(Auth::getStatus()==3){
      $mdp=sha1($mdp1);
      $query = $pdo->prepare("update membres set mbusername= '{$pseudo}', mbmail= '{$mail}', mbnews= '{$news}' where mbid={$mbid};");
      $query->execute();
      if(!empty($mdp1)){
        $query = $pdo->prepare("update membres set mbuserpass= '{$mdp}' where mbid={$mbid};");
        $query->execute();
      }
      message::addMsg('Compte modifié.');
      $query = $pdo->prepare("select * from membres where mbid= {$mbid};");
      $query->execute();
      $result=$query->fetchAll(PDO::FETCH_ASSOC);
      $_SESSION['auth']['login']=$result[0]['mbusername'];
      $_SESSION['auth']['pwd']=$result[0]['mbuserpass'];
      $_SESSION['auth']['type']=sha1($result[0]['mbtype']);
      App\Auth::status();
    }

		unset($_POST);
    $affichage = 4;
	}
}
else if(Auth::getStatus()!=3 && isset($parameters[1])&& strtoupper($parameters[1])!='LOSTPASSWORD') // validation de compte - affichage 4
{
  $code = cleanStr($parameters[1]);
  $query = $pdo->prepare("select * from membres where sha1(validation_sent) = '{$code}';");
  $query->execute();
  $result=$query->fetchAll(PDO::FETCH_ASSOC);
  if($query->rowCount()==1){
    $query = $pdo->prepare("update membres set validation_received = validation_sent , validation_sent = '' where sha1(validation_sent) = '{$code}';");
    $query->execute();
    $_SESSION['auth']['login']=$result[0]['mbusername'];
    $_SESSION['auth']['pwd']=$result[0]['mbuserpass'];
    $_SESSION['auth']['type']=sha1($result[0]['mbtype']);
    App\Auth::status();
    message::addMsg('Vous êtes connecté');
    $page_account_title = 'Inscription validée.';
  }
  $affichage = 4;

}
else if(Auth::getStatus()!=3 && isset($parameters[1]) && strtoupper($parameters[1])=='LOSTPASSWORD' ) // Mot de passe oublié
{
  $page_account_title = 'Mot de passe oublié';
  if(isset($_POST['mail']) && !empty($_POST['mail'])){
    // Controler que le mail existe
    $query = $pdo->prepare("select distinct 1 from membres where upper(mbmail) = upper('{$_POST['mail']}');");
    $query->execute();
    // si mail existe
    if($query->rowCount()==1){
      // génération du code de validation
      $mail = $_POST['mail'];
  		$string = rand_string(20);

  		// génération d$page_account_title = 'Création de compte';e l'url
  		$url='http://'.$_SERVER['HTTP_HOST'].'/account/'.sha1($string);
      // envoi du mail
      $myMail = new MyMail();
      $myMail->setfrom($mailFrom,'Les Figurines de Tintin');
      $myMail->addaddress($mail);
      $myMail->subject("Les figurines de Tintin : Mot de passe oublié");
      $message =
      "
       Bonjour $pseudo

       Vous allez être connecté au site pour pouvoir modifier votre mot de passe.
     Rendez-vous sur votre profil pour le modifier.

       $url

       ";

       $myMail->body($message);
       $myMail->send();
      	//stockage dans la db du profil
  		$mdp=sha1($mdp1);
        $query = $pdo->prepare("update membres set validation_sent = '{$string}', validation_received = null where upper(mbmail)=upper('{$_POST['mail']}');");
        $query->execute();

  		// Redirection vers index en changeant le controler
  		message::addMsg('Un mail pour vous connecter a été envoyé.');
  		unset($_POST);
      $affichage = 4;
    }
    // si mail existe pas
    else{
      $affichage = 3;
      message::addMsg("Le mail < {$_POST['mail']} > n'existe pas dans notre base utilisateur");
    }
  }
  else {
    $affichage = 3;
  }



}


require_once DIR_VIEWS.$controller.'.php';
?>
