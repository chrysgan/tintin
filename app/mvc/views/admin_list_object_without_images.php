<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>

<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $page_admin_title.' - Liste des objets sans images'; ?></h1>
</div>

<?php

if ($affichage == 1) { require_once DIR_TEMPLATES.$tmpl_object_edition;}
if ($affichage == 2) { require_once DIR_TEMPLATES.$tmpl_return_admin;}
if ($affichage == 3) { require_once DIR_TEMPLATES.$tmpl_object_list;}
?>

<script type="text/javascript" src="<?php echo DIR_JS.'image_preview.js'?>"></script>

<?php
	$content = ob_get_clean();
	require_once DIR_TEMPLATES.$tmpl_main;
?>
