<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";


ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Modification d\'un personnage'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="persid">Choix du personnage à modifier</label>
		<select name="persid" id="persid">
			<?php
			foreach ($pers_list as $key) { ?>
				<option value="<?php  echo $key['persid'] ?>"><?php echo $key['persalias']?></option>
			<?php }?>
		</select>
		<button type="submit" name="action" value="choose_pers">Modifier</button>
	</form>
</div>

<?php } if($affichage==2)  {  ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
		<input type="hidden" id="persid" name="persid" value="<?php  echo $persid; ?>">
		<label for="persalias">Alias du personnage</label>
		<input type="text" id="persalias" name="persalias" value="<?php  echo $persalias; ?>">
		<label for="persnom">Nom du personnage</label>
		<input type="text" id="persnom" name="persnom" value="<?php  echo $persnom; ?>">
		<label for="persprenom">Prenom du personnage</label>
		<input type="text" id="persprenom" name="persprenom" value="<?php  echo $persprenom; ?>">
		<label for="persdesc">Description du personnage</label>
		<textarea name="persdesc" id="persdesc" cols="40" rows="7"><?php  echo $persdesc; ?></textarea>
		<label for="fileImg">Image du personnage</label>
		<input type="hidden" id="persimg" name="persimg" value="<?php  echo $persimg; ?>">
		<input type="file" id="fileImg" name="fileImg" accept=".png, .jpg, .jpeg, .gif">
		<div id="preview" class="imgPreview">
			<?php
				if(!empty($persimg)){
						echo "<img src=\"".DIR_PERS_IMAGES.$persimg."\" alt=\"\" class=\"imgPreview\">";
				}
			?>
		</div>
		<button type="submit" name="action" value="update_pers">Modifier le personnage</button>
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
