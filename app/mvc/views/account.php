<?php

ob_start();

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";
// affichage :
// 1 : formulaire création de compte
// 2 : formulaire compte modification de compte
// 3 :
// 4 : affichage modification ou validation prise en compte

?>
<?php if ($affichage == 1) { ?>


	<div class="myRow flex-center">
  	<h1 class="page_title flex-center"><?php echo $$page_title; ?></h1>
  </div>
	<div class="myRow flex-center">
		  <div class="myCol">
        <form class="form-group-vertical adminForm" action="" method="post">
					<input type="hidden" name="mbid" value="<?php echo $mbid;?>">
	        <label for="pseudo">Pseudo</label>
          <input type="text"  id="pseudo" name="pseudo"  value="<?php echo $pseudo;?>" required>
          <label for="InputEmail">Adresse Mail</label>
          <input type="email"  id="InputEmail" aria-describedby="emailHelp" name="mail" value="<?php echo $mail; ?>" required>
          <small id="emailHelp" class="form-text text-muted">Votre adresse mail ne sera communiquée à personne.</small>
          <label for="Password1">Mot de passe</label>
          <input type="password"  id="Password1" name="mdp1" <?php echo $required ?>>
          <label for="Password2">Confirmation du mot de passe</label>
          <input type="password"  id="Password2" name="mdp2" <?php echo $required ?> >
          <br>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" name="news" value="O" <?php echo $news;?>>
            <label class="form-check-label" for="gridCheck">
              Etre informé par mail des mises à jour
            </label>
          </div>
          <button type="submit" name="action" value="validation"><?php echo $updateaccount; ?></button>
      </form>
		</div>
	</div>

<?php } if($affichage==2)  {  ?>




<?php } if($affichage==3)  {  ?>

	<div class="myRow flex-center">
		<h1 class="page_title flex-center"><?php echo $page_account_title; ?></h1>
	</div>
	<div class="myRow flex-center">
			<div class="myCol">
				<form class="form-group-vertical adminForm" action="" method="post">
					<label for="InputEmail">Adresse Mail</label>
					<input type="email"  id="InputEmail" aria-describedby="emailHelp" name="mail" value="<?php echo $mail; ?>" required>
					<button type="submit" name="action" value="validation">Me renvoyer un mail pour se connecter</button>
			</form>
		</div>
	</div>



<?php } if($affichage==4)  {  ?>

	<div class="myRow flex-center">
		<a class="link_back_home" href="<?php echo WEBROOT.$page_home;?>">Retour à la page d'accueil</a>
	</div>


<?php }  ?>



<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main;
?>
