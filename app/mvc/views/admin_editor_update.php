<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Modification d\'un éditeur'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="ediid">Choix de l'éditeur à modifier</label>
		<select name="ediid" id="ediid">
			<?php
			foreach ($editor_list as $key) { ?>
				<option value="<?php  echo $key['ediid'] ?>"><?php echo $key['edinom']?></option>
			<?php }?>
		</select>
		<button type="submit" name="action" value="choose_editor">Modifier</button>
	</form>
</div>

<?php } if($affichage==2)  {  ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
		<input type="hidden" id="ediid" name="ediid" value="<?php  echo $ediid; ?>">
		<label for="edinom">Nom de l'éditeur</label>
		<input type="text" id="edinom" name="edinom" maxlength="50" title="50 caractères maximum" value="<?php  echo $edinom; ?>">
		<label for="edicreateyear">Année de création</label>
		<input type="number" id="edicreateyear" name="edicreateyear" max="<?php echo date('Y'); ?>" value="<?php  echo $edicreateyear; ?>">
		<label for="edicloseyear">Année de fermeture</label>
		<input type="number" id="edicloseyear" name="edicloseyear" max="<?php echo date('Y'); ?>" value="<?php  echo $edicloseyear; ?>">
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
		<input type="hidden" id="ediimg" name="ediimg" value="<?php  echo $ediimg; ?>">
		<input type="file" id="fileImg" name="fileImg" accept=".png, .jpg, .jpeg, .gif">
		<div id="preview" class="imgPreview">
			<?php
				if(!empty($ediimg)){
						echo "<img src=\"".DIR_EDITORS_IMAGES.$ediimg."\" alt=\"\" class=\"imgPreview\">";
				}
			?>
		</div>
		<button type="submit" name="action" value="update_editor">Modifier l'éditeur</button>
	</form>
</div>

<?php } if($affichage==3)  {  ?>

<div class="myRow flex-center">
	<a class="link_back_home" href="<?php echo WEBROOT.$page_admin;?>">RETOUR A LA GESTION DU SITE</a>
</div>

<?php }  ?>
<script type="text/javascript" src="<?php echo DIR_JS.'image_preview.js'?>"></script>
<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main; ;
?>
