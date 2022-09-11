<?php

$css_loading = "<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $$page_title; ?></h1>
</div>

<div class="myRow flex-center">
    <table class="myTableTemplate admin_table">
			<?php
				foreach ($members_list as $key) {
					echo
						'<tr>
						<td>'.$key['mbid'].'</td>
						<td>'.$key['mbusername'].'</td>
						<td>'.$key['mbmail'].'</td>
						<td>'.$key['mbtype'].'</td>
						<td>'.$key['mbnews'].'</td>
						</tr>'
						;
				}
			?>
	</table>
</div>

<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main;
?>
