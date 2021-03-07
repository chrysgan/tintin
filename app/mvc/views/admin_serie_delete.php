<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Suppression d\'une série'; ?></h1>
</div>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center">
	<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
		<label for="serid">Choix de la série à supprimer</label>
		<select name="serid" id="serid">
			<?php
			foreach ($serie_list as $key) { ?>
				<option value="<?php  echo $key['serid'] ?>"
					<?php if(isset($_POST['action']) && $_POST['action']=='serie_delete' && $key['serid']==$_POST['serid'] ){ echo " selected ";} ?>><?php  echo $key['sernom']?></option>
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
