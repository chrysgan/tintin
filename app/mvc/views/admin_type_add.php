<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Ajout d\'un type d\'objet'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
		<label for="typelib">Nom du type</label>
		<input type="text" id="typelib" name="typelib" value="<?php  echo $typelib; ?>">
		<label for="typecode">Type Code</label>
		<input type="typecode" id="typecode" name="typecode" value="<?php  echo $typecode; ?>">
		<label for="fileImg">Image du type d'objet</label>
		<input type="file" id="fileImg" name="fileImg" accept=".png, .jpg, .jpeg, .gif">
		<div id="preview" class="imgPreview"></div>
		<button type="submit" name="post">Créer le type</button>
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
