<?php

$css_loading = "<link href=\"".DIR_CSS.$controller.".css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $$page_title ?></h1>
</div>
<div class="myRow flex-center">
	<table class="myTableTemplate admin_table">
	    <tbody>
	        <tr>
	        	<td>Editeurs</td>
	            <td><a href="<?php echo WEBROOT.$controller.'/editor_add'; ?>"><i class="material-icons">add_circle_outline</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/editor_update'; ?>"><i class="material-icons">create</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/editor_delete'; ?>"><i class="material-icons">remove_circle_outline</i></a></td>
	        </tr>
	        <tr>
	        	<td>Objets</td>
	            <td><a href="<?php echo WEBROOT.$controller.'/object_add'; ?>"><i class="material-icons">add_circle_outline</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/object_update'; ?>"><i class="material-icons">create</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/object_delete'; ?>"><i class="material-icons">remove_circle_outline</i></a></td>
	        </tr>
	        <tr>
	        	<td>Personnages</td>
	            <td><a href="<?php echo WEBROOT.$controller.'/perso_add'; ?>"><i class="material-icons">add_circle_outline</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/perso_update'; ?>"><i class="material-icons">create</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/perso_delete'; ?>"><i class="material-icons">remove_circle_outline</i></a></td>
	        </tr>
	        <tr>
	        	<td>Series</td>
	            <td><a href="<?php echo WEBROOT.$controller.'/serie_add'; ?>"><i class="material-icons">add_circle_outline</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/serie_update'; ?>"><i class="material-icons">create</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/serie_delete'; ?>"><i class="material-icons">remove_circle_outline</i></a></td>
	        </tr>
	        <tr>
	        	<td>Types</td>
	            <td><a href="<?php echo WEBROOT.$controller.'/type_add'; ?>"><i class="material-icons">add_circle_outline</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/type_update'; ?>"><i class="material-icons">create</i></a></td>
	            <td><a href="<?php echo WEBROOT.$controller.'/type_delete'; ?>"><i class="material-icons">remove_circle_outline</i></a></td>
	        </tr>
			<tr>
				<td>Liste</td>
				<td colspan="3"><a href="<?php echo WEBROOT.$controller.'/list_members'; ?>">Membres</a></td>
			</tr>
			<tr>
				<td>Liste</td>
				<td colspan="3"><a href="<?php echo WEBROOT.$controller.'/list_object_without_images'; ?>">Objets sans images</a></td>
			</tr>
			<tr>
				<td>Systeme</td>
				<td colspan="3"><a href="<?php echo WEBROOT.'phpinfos'; ?>">Php Infos</a></td>
			</tr>
	    </tbody>
		</table>
</div>
<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main;
?>
