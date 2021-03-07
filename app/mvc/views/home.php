<?php

$css_loading = "<link href=\"".DIR_CSS.$controller.".css\" rel=\"stylesheet\">";

ob_start();
?>
<div class="home">
    <div class="myRow home-body">
        <div class="home-bloc5">
            <div class="home-bloc4">
                <div class="home-bloc3">
                    <div class="home-bloc2">
                        <div class="home-bloc1">
                            <div class="home-bloc ">
                                <h1 alt="">Je ne sais plus où j'en suis...</h1>
                                <p>Dans la jungle des objets dérivés Tintin, il est difficile de s'y retrouver.</p>
                                <p>Qui a fait quoi ? quand ? Combien existe-t-il de figurines dans cette  série ?</p>
                                <p >Voilà les questions que je me posais quand j'ai commencé à collectionner les objets de Tintin.
                                <p >Ici je fais l'inventaire des figurines de petites tailles en plastique ou résine.</p>
                                <p >Mon idée est de fournir une synthèse des informations que j'ai collectées ici et là, avec de belles photographies.</p>
                                <p >J'espère que le but sera atteint.</p>
                                <a class="flex-center link_button" href="<?php echo WEBROOT.$page_galleries; ?>">Début de la visite</a>
                                <p class="flex-center">dernier objet créé ou modifié&nbsp:&nbsp
                                    <a class="strong_link" href="<?=$url?>"> <?=$libelle_objet?></a>
                                </p>
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
