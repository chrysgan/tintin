<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Modification d\'une série'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="serid">Choix de la série à modifier</label>
		<select name="serid" id="serid">
			<?php
			foreach ($serie_list as $key) { ?>
				<option value="<?php  echo $key['serid'] ?>"><?php echo $key['sernom']?></option>
			<?php }?>
		</select>
		<button type="submit" name="action" value="choose_serie">Modifier</button>
	</form>
</div>

<?php } if($affichage==2)  {  ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<input type="hidden" id="serid" name="serid" value="<?php  echo $serid; ?>">
		<label for="sernom">Nom de la série</label>
		<input type="text" id="sernom" name="sernom" maxlength="50" value="<?php  echo $sernom; ?>">
		<label for="serannee">Année de parution</label>
		<input type="number" id="serannee" name="serannee" max="<?php echo date('Y'); ?>" value="<?php  echo $serannee; ?>">
		<label for="sermois">Mois de parution</label>
		<input type="number" id="sermois" name="sermois" min="0" max="12" value="<?php  echo $sermois; ?>">
		<label for="serdesc">Description de la série</label>
		<textarea name="serdesc" id="serdesc" cols="40" rows="7"><?php  echo $serdesc; ?></textarea>
		<label for="sercommentaires">Commentaires (pas d'affichage sur la fiche)</label>
		<textarea name="sercommentaires" id="sercommentaires" cols="50" rows="7"><?php  echo $sercommentaires; ?></textarea>
		<button type="submit" name="action" value="update_serie">Modifier la série</button>
	</form>
</div>

<?php } if($affichage==3)  {  ?>

<div class="myRow flex-center">
	<a class="link_back_home" href="<?php echo WEBROOT.$page_admin;?>">RETOUR A LA GESTION DU SITE</a>
</div>

<?php }  ?>

<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main; ;
?>
