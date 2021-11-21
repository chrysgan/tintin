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
                                <p>Qui a fait quoi ? quand ? Combien existe-t-il d'objets dans cette série ?</p>
                                <p>Vous trouverez ici des réponses à vos questions.</p>
                                <p>Et pour étoffer le site vous pourrez participer à son évolution pour la communauté tintinophile.</p>
                                <p>En créant un compte vous pourrez proposer la modification ou la création de nouveaux objets,</p>
                                <p>soit par des participations photographiques ou des compléments/corrections d'informations.</p>
                                <p>Venez participer nombreux à ce projet !</p>
                                <a class="flex-center link_button" href="<?php echo WEBROOT.$page_galleries; ?>">Début de la visite</a>
                                <p class="flex-center">dernier objet créé ou modifié le <?php echo date_format(new DateTime($dateCRUD),'d M Y');?>&nbsp:&nbsp
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
