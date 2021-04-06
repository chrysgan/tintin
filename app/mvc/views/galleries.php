<?php

$css_loading = "
<link href=\"".DIR_CSS.$controller.".css\" rel=\"stylesheet\">
<link href=\"".DIR_CSS."object.css\" rel=\"stylesheet\">
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
	<div class="myRow flex-center">
		<div class="gallery-group">
			<?php  foreach ($requete as $value) { echo $value;	};	?>
		</div>
	</div>
	<!-- zone d'insertion de la modal des informations de l'objet -->
	<div id="ModalObjectInformation" class="ModalObjectInformation">
		<div class="modal-content">
			<span class="modal_close_object_information">&times;</span>
			<p id="modal-text-content"></p>
		</div>
	</div>
</div>
<script src="<?php echo DIR_JS; ?>lightbox.js" type="module" defer></script>
<script src="<?php echo DIR_JS; ?>object_information.js" type="module" defer></script>
<script src="<?php echo DIR_JS; ?>stars.js" type="module" defer></script>
<?php
$content = ob_get_clean();

require_once DIR_TEMPLATES.$tmpl_main; ?>
