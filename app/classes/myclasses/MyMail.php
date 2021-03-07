<?php
namespace App;

use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\SMTP as SMTP;

class MyMail {

    private $envMail;

    public function __construct(){

        $this->envMail = new PHPMailer();

        //Gestion des varaiables en fonction des mails utilisés
        if($_SERVER['HTTP_HOST']=='tintin' || $_SERVER['HTTP_HOST']=='dev.tintin'){
            $this->envMail->IsSMTP(); // active SMTP
            $this->envMail->SMTPDebug = 0;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
            $this->envMail->SMTPAuth = true;  // Authentification SMTP active
            $this->envMail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
            $this->envMail->Host = $GLOBALS['mailHost'];
            $this->envMail->Port = $GLOBALS['mailPort'];
            $this->envMail->Username = $GLOBALS['mailFrom'];
            $this->envMail->Password = $GLOBALS['mailPwd'];
            $this->envMail->CharSet = $GLOBALS['charset'];
        }
        else if($_SERVER['HTTP_HOST']=='lesfigurinesdetintin.planethoster.world'){
            $this->envMail->Host = $GLOBALS['mailHost'];
            $this->envMail->Port = $GLOBALS['mailPort'];
            $this->envMail->CharSet = $GLOBALS['charset'];
        }
    }

    public function setfrom($mailfrom, $mailfromname){
        $this->envMail->SetFrom($mailfrom, $mailfromname);
    }
    public function subject($subject_str){
        $this->envMail->Subject = $subject_str;
    }

    public function addaddress($address_str){
        $this->envMail->AddAddress($address_str);
    }

    public function body($body_str){
        $this->envMail->Body = $body_str;
    }

    public function addattachment($file_attachment,$filename){
        $this->envMail->addAttachment($file_attachment,$filename);
    }

    public function send(){
        $this->envMail->Send();
        // $this->envMail->ErrorInfo;
    }

}

?>
