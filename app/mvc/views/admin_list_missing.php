<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $$page_title; ?></h1>
</div>

<div class="myRow flex-center">
	<table class="myTableTemplate admin_table">
		<tr>
			<?php
			foreach ($owned_list as $key) { ?>
				<tr>
					<td><?php echo $key['objid'] ?></td>
					<td><?php echo $key['typecode'] ?></td>
					<td><?php echo $key['edinom'] ?></td>
					<td><?php echo $key['sernom'] ?></td>
					<td><?php echo $key['objnom'] ?></td>
				</tr>
			<?php }	?>
		</tr>
    </table>
</div>

<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main;
?>
