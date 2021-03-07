<?php
use App\Auth;
use App\Message;
 ?>

<!DOCTYPE html>
<html>
    <head>
    	<title><?php echo $website_title.$title_addin; ?> </title>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto&400display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sigmar+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"> -->
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Two+Tone" rel="stylesheet"> -->
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"> -->
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"> -->
        <link href="<?php echo DIR_CSS; ?>colors.css" rel="stylesheet">
        <link href="<?php echo DIR_CSS; ?>main.css" rel="stylesheet">
        <link href="<?php echo DIR_CSS; ?>forms.css" rel="stylesheet">
        <?php echo $css_loading; ?>
    </head>
    <body>
        <nav class="myRow">
            <a class="brand text-secondary" href="<?php echo WEBROOT; ?>"><?php echo $website_title;?></a>
            <!-- Links -->
            <ul>
                <li><a class="menu" href="<?php echo WEBROOT.$page_galleries; ?>"><?php echo $page_galleries_title; ?></a></li>
                <li><a class="menu" href="<?php echo WEBROOT.$page_about; ?>"><?php echo $page_about_title; ?></a></li>
                <?php if(isset($_SESSION['auth']['type']) && $_SESSION['auth']['type']==sha1('ADMIN')) : ?>
                    <li><a class="menu" href="<?php echo WEBROOT.$page_admin; ?>">Admin</a></li>
                <?php endif ; ?>
            </ul>
            <!-- Formulaire -->
            <?php if (Auth::getStatus() != 3) : ?>
            <form class="form-group" action="" method="POST">
                <input class="form-item" type="text" placeholder="pseudo"   name="login">
                <input class="form-item" type="password" placeholder="mot de passe"  name="pwd" >
                <button class ="log-item" title="Se connecter" type="submit" name="sign" value = "in"><span><i class="material-icons md-light">library_add_check</i></span></button>
                <a class="log-item" title="Créer un compte" href="<?php echo WEBROOT.$page_account; ?>"><span ><i class="material-icons md-light">add_circle_outline</i></span></a>
                <a class="log-item" title="Mot de passe oublié" href="<?php echo WEBROOT.$page_account.'/lostpassword'; ?>"><span ><i class="material-icons md-light">lock_open</i></span></a>
            </form>
            <?php else :  ?>
            <div>
                <a class="" href="<?php echo WEBROOT.$page_account; ?>"><span ><i class="material-icons md-light">face</i></span></a>
                <a class="" href="<?php echo WEBROOT.$page_logout; ?>"><span><i class="material-icons md-light">exit_to_app</i></span></a>
            </div>
            <?php endif ; ?>
            <!-- Fin formulaire -->
        </nav>
        <!-- Barre message -->
        <?php  if(Message::nbMsg()!=0) : ?>
        <div id="message" class="myRow flex-center message" >
            <?php Message::displayMsg(); ?>
        </div>
        <?php endif ; ?>
        <!-- fin barre message -->
        <!-- Corps de la page -->
            <?php echo $content; ?>
        <!-- Fin du corps de la page -->
        <script type="text/javascript">
            function fadeOutEffect() {
                var fadeTarget = document.getElementById("message");
                if(fadeTarget!=null){
                    var diviseur = (fadeTarget.offsetHeight / 10) + 20 ;
                    var newh ;
                    var fadeEffect = setInterval(function () {
                        if (!fadeTarget.style.opacity) {
                            fadeTarget.style.opacity = 1;
                        }
                        if (fadeTarget.style.opacity > 0) {
                            hauteur = Math.round(fadeTarget.offsetHeight - diviseur );
                            fadeTarget.style.height = hauteur+"px";
                            fadeTarget.style.opacity -= 0.1;
                        } else {
                            fadeTarget.style.padding="0";
                            clearInterval(fadeEffect);
                        }
                    }, 20);
                    }
                }
            setTimeout(fadeOutEffect, 4000);
        </script>
  </body>
</html>
