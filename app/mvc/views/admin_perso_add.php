<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Ajout d\'un personnage'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
		<label for="persalias">Alias du personnage</label>
		<input type="text" id="persalias" name="persalias" maxlength="50"  title="Doit comprendre entre 1 et 50 caractères" value="<?php  echo $persalias; ?>">
		<label for="persnom">Nom du personnage</label>
		<input type="text" id="persnom" name="persnom" value="<?php  echo $persnom; ?>">
		<label for="persprenom">Prenom du personnage</label>
		<input type="text" id="persprenom" name="persprenom" value="<?php  echo $persprenom; ?>">
		<label for="persdesc">Description du personnage</label>
		<textarea name="persdesc" id="persdesc" cols="40" rows="7"><?php  echo $persdesc; ?></textarea>
		<label for="fileImg">Image du personnage</label>
		<input type="file" id="fileImg" name="fileImg" accept=".png, .jpg, .jpeg, .gif">
		<div id="preview" class="imgPreview"></div>
		<button type="submit" name="post">Créer le personnage</button>
	</form>
</div>

<?php } if($affichage==2)  {  ?>

<div class="myRow flex-center">
	<a class="link_back_home" href="<?php echo WEBROOT.$page_admin;?>">RETOUR A LA GESTION DU SITE</a>
</div>

<?php }  ?>
<script type="text/javascript" src="<?php echo DIR_JS.'image_preview.js'?>"></script>
<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main; ;
?>
