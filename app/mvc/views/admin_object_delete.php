<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Suppression d\'un objet'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="objid">Choix de l'objet</label>
		<select name="objid" id="objid">
			<?php
			foreach ($object_choice as $key) { ?>
				<option value="<?php  echo $key['objid'] ?>"
					<?php if(isset($_POST['action']) && $_POST['action']=='object_delete' && $key['objid']==$_POST['objid'] ){ echo " selected ";} ?>><?php  echo $key['objnom']?></option>
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
