<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Modification d\'un type d\'objet'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="typeid">Choix du type à modifier</label>
		<select name="typeid" id="typeid">
			<?php
			foreach ($type_list as $key) { ?>
				<option value="<?php  echo $key['typeid'] ?>"><?php echo $key['typelib']?></option>
			<?php }?>
		</select>
		<button type="submit" name="action" value="choose_type">Modifier</button>
	</form>
</div>

<?php } if($affichage==2)  {  ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
		<input type="hidden" id="typeid" name="typeid" value="<?php  echo $typeid; ?>">
		<label for="typelib">Libellé du type</label>
		<input type="text" id="typelib" name="typelib" value="<?php  echo $typelib; ?>">
		<label for="typecode">Code du type</label>
		<input type="text" id="typecode" name="typecode" value="<?php  echo $typecode; ?>">
		<label for="fileImg">Image du type</label>
		<input type="hidden" id="typeimg" name="typeimg" value="<?php  echo $typeimg; ?>">
		<input type="file" id="fileImg" name="fileImg" accept=".png, .jpg, .jpeg, .gif">
		<div id="preview" class="imgPreview">
			<?php
				if(!empty($typeimg)){
						echo "<img src=\"".DIR_TYPES_IMAGES.$typeimg."\" alt=\"\" class=\"imgPreview\">";
				}
			?>
		</div>
		<button type="submit" name="action" value="update_type">Modifier le type</button>
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
