<?php
use App\Message as Message;
use App\Auth as Auth;
use App\MyMail as MyMail;


// Redirection 404 si pas connecté
if(Auth::getStatus()!=3) {
    $controller = $page_404;
    unset($_POST);
}

$affichage = 1;
// echo $_FILES['files']['name'][0];
// echo $_FILES['files']['tmp_name'][0];
require_once DIR_MODELS.$controller.'.php';

if(!empty($_POST)){

    $message = cleanStr($_POST['message']);

    // envoi du mail
    $myMail = new MyMail();
    $myMail->setfrom($mailFrom,'Les Figurines de Tintin');
    $myMail->addaddress($mailContact);
    $myMail->subject("Modification d'objet {$objid} par {$_SESSION['auth']['login']} ({$_SESSION['auth']['mbid']}) : {$edinom} - {$sernom} - {$objnom} ");
    $myMail->body($message);
    foreach ($_FILES['files']['name'] as $key => $value) {
        if($_FILES['files']['size'][$key]<5000000){
            $myMail->addattachment($_FILES['files']['tmp_name'][$key],$value);
        }
    }
    $myMail->send();
    Message::addMsg('Message posté avec succès.');
    $affichage = 2;
}



require_once DIR_VIEWS.$controller.'.php';


?>
