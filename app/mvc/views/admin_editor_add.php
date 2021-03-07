<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Ajout d\'un éditeur'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
		<label for="edinom">Nom de l'éditeur</label>
		<input type="text" id="edinom" name="edinom" maxlength="50" title="50 caractères maximum" value="<?php  echo $edinom; ?>">
		<label for="edicreateyear">Année de création</label>
		<input type="number" id="edicreateyear"  max="<?php echo date('Y'); ?>" name="edicreateyear" value="<?php  echo $edicreateyear; ?>">
		<label for="edicloseyear">Année de fermeture</label>
		<input type="number" id="edicloseyear"   max="<?php echo date('Y'); ?>"name="edicloseyear" value="<?php  echo $edicloseyear; ?>">
		<label for="edipays">Pays</label>
		<select name="edipays" id="edipays">
			<?php
			$default=false;
			foreach ($pays_list as $key) {
				if($key[0]==$edipays){$selected = "selected"; $default=true;}
				elseif($key[0]=='FR' && $default==false){ $selected = "selected";}
				else {$selected = '';}
				echo "<option value=\"$key[0]\" $selected >$key[1]</option>";
			}
			?>
		</select>
		<label for="edidesc">Description Editeur</label>
		<textarea name="edidesc" id="edidesc" cols="50" rows="7"><?php  echo $edidesc; ?></textarea>
		<label for="edicommentaires">Commentaires (pas d'affichage sur la fiche)</label>
		<textarea name="edicommentaires" id="edicommentaires" cols="50" rows="7"><?php  echo $edicommentaires; ?></textarea>
		<label for="fileImg">Logo de l'éditeur</label>
		<input type="file" id="fileImg" name="fileImg"  type="file" accept=".png, .jpg, .jpeg, .gif">
		<div id="preview" class="imgPreview"></div>
		<button type="submit" name="post">Créer l'éditeur</button>
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
