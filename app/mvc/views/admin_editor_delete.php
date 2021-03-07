<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Suppression d\'un éditeur'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="ediid">Choix de l'éditeur</label>
		<select name="ediid" id="ediid">
			<?php
			foreach ($editor_list as $key) { ?>
				<option value="<?php  echo $key['ediid'] ?>"
					<?php if(isset($_POST['action']) && $_POST['action']=='editor_delete' && $key['ediid']==$_POST['ediid'] ){ echo " selected ";} ?>><?php  echo $key['edinom']?></option>
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
