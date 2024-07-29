<?php

$css_loading = "<link href=\"".DIR_CSS.$controller.".css\" rel=\"stylesheet\">";

ob_start();
?>

<div class="myRow flex-center">
	<h1 class="page_title flex-center"><?php echo $$page_title; ?></h1>
</div>

<div class="about">
    <div class="myRow about-body">
        <div class="about-bloc5">
            <div class="about-bloc4">
                <div class="about-bloc3">
                    <div class="about-bloc2">
                        <div class="about-bloc1">
                            <div class="about-bloc ">
                                <h1>Parlons un peu de ce site...</h1>
																<p>Je commencerait par vous dire que ce site est la mise à jour de chrysgan.free.fr</p>
																<p>Ce site dispose de fonctionnalités que l'ancien n'avait pas, sous réserve, pour certaines de créer un compte.</p>
																<ul>
																	<li>Le site permet d'afficher les objets par types d'objets, par séries, par éditeurs ou encore par personnages.</li>
																</ul>
																<p class="underlined">Un site participatif (sous réserve d'avoir un compte)</p>
																<ul>
																	<li>Vous pourrez maintenant facilement proposer des objets à mettre dans la galerie via un formulaire</li>
																	<li>Vous pourrez proposer la modification des objets</li>
																</ul>
                                <p class="underlined">Un site évolutif</p>
																<ul>
																	<li>Je vous propose ici d'implémenter de nouvelles fonctions</li>
																	<li>Proposez, je verrais la faisabilité et si j'en suis capable. La fonction sera intégrée au site</li>
																</ul>
                                <p class="underlined">Remerciements</p>
																<ul>
																	<p>L'ancien site avait été réalisé avec Open Element.<br>
																		Celui-ci est entièrement codé, et il m'a fallu quelques mois d'apprentissage.<br>
																		Voici donc ceux qui m'ont permis de réaliser ce site.</p>

																		<li><a href="https://www.grafikart.fr/" target="_blank">Grafikart</a></li>
																		<li><a href="https://www.pierre-giraud.com/" target="_blank">Pierre Giraud</a></li>
																		<li><a href="https://openclassrooms.com/fr//" target="_blank">OpenClassRooms</a></li>
																		<li><a href="https://codeconcept.teachable.com/" target="_blank">Code Concept</a></li>
																</ul>
																<p><a class="underlined flex-center" href="mailto:contact@lesfigurinesdetintin.planethoster.world">contact@lesfigurinesdetintin.planethoster.world</a></p>
	                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once DIR_TEMPLATES.$tmpl_main;
?>
