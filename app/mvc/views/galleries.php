<?php

$css_loading = "
<link href=\"".DIR_CSS.$controller.".css\" rel=\"stylesheet\">
<link href=\"".DIR_CSS."card.css\" rel=\"stylesheet\">
<link href=\"".DIR_CSS."lightbox.css\" rel=\"stylesheet\">
";

ob_start();
?>


<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $urls; ?></h1>
</div>
<div class="galleries">
	<!-- entete cards -->
	<?php if(isset($area_1)){?>
	<div class="myRow info-editor">
		<div class="myCol-40">
			<img src="<?php echo $area_img; ?>" alt="">
		</div>
		<div class="myCol-40">
			<p><?php echo $area_1; ?></p>
			<?php if(isset($area_2)){echo "<p>".$area_2."</p>"; }?>
		</div>
	</div>
	<?php } ?>
	<!-- gallerie des cards -->
	<div class="gallery-group">
		<?php  foreach ($requete as $value) { echo $value;	};	?>
	</div>
</div>
<script src="<?php echo DIR_JS; ?>lightbox.js" type="module" defer></script>
<script src="<?php echo DIR_JS; ?>add_information.js" type="module" defer></script>
<?php
$content = ob_get_clean();

require_once DIR_TEMPLATES.$tmpl_main; ?>
