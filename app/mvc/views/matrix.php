<?php

$css_loading = "<link href=\"".DIR_CSS.$controller.".css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $$page_title; ?></h1>
</div>

<div class="myRow flex-center">

</div>

<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main;
?>
