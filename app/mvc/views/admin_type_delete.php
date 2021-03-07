<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Suppression d\'un type d\'objet'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="typelib">Choix du type à supprimer</label>
		<select name="typeid" id="typeid">
			<?php
			foreach ($editor_list as $key) { ?>
				<option value="<?php  echo $key['typeid'] ?>"
					<?php if(isset($_POST['action']) && $_POST['action']=='type_delete' && $key['typeid']==$_POST['typeid'] ){ echo " selected ";} ?>><?php  echo $key['typelib']?></option>
			<?php }?>
		</select>
		<button class="<?php echo $class; ?> "type="submit" name="action" value="<?php echo $action; ?>"><?php echo $msg_button; ?></button>
	</form>
</div>

<?php } if($affichage==2)  {  ?>

<div class="myRow flex-center">
	<a class="link_back_home" href="<?php echo WEBROOT.$page_admin;?>">RETOUR A LA GESTION DU SITE</a>
</div>

<?php }  ?>

<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main; ;
?>
