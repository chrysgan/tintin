<?php
use App\Auth;

/* id */
$objid = $value['objid'];

/* banniere nouveau*/
$new = $value['new'];

/* image */
if(empty($value['imgfile']) || !file_exists(DIR_OBJECTS_IMAGES_ROOT.$value['imgfile'])){
    $objimg =  DIR_OBJECTS_IMAGES."000000.PNG";
}
else { $objimg = DIR_OBJECTS_IMAGES.$value['imgfile'];}

/* nombre d'image */
$nbimg = intval($value['nbimg']);

/* description objet */
if(!empty($value['objdesc'])){ $objdesc = "<span class=\"obj-description\">".str_replace(chr(10),"<br>",$value['objdesc'])."</span>";}
else{ $objdesc="";}

/* titre card - nom objet et info-bulle */
/* passage du nom de la serie en nom de l'objet quand recherche pesonnage */
if($parameters[1]=='personnages'){$objnom = ucwords(mb_strtolower($value['edinom']));} else {$objnom=$value['objnom'];}
if(mb_strlen($objnom)>34){
    $objtitle = $objnom;
    $objnom = ucwords(mb_strtolower(mb_substr($objnom,0,34).'...'));
}
else { $objtitle = '';}

/* taille */
if(intval($value['objtaille'])>0){ $objtaille = $value['objtaille'].' cm';} else { $objtaille = 'nc';}

/* poids */
if(intval($value['objpoids']>0)){ $objpoids = $value['objpoids'].' grs';} else { $objpoids = '-';}

/* prix */
if($value['objprix']==0 && empty($value['objprix']==false)){ $objprix = "Offert";}
    else if($value['objprix']==-1){ $objprix="Inconnu";}
    else if($value['objprix']==-2){ $objprix="Ni vendu ni offert";}
    else { $objprix = $value['objprix']." €";}

/* rangement objet */
$objrangement = $value['rangement'];

/* possession objet */
$objpossede = $value['possede'];

/* reference */
if(empty($value['objref'])){ $objref = "-";} else { $objref = $value['objref'];}

/* annee parution */
if(intval($value['objannee']>0)){ $objannee = $value['objannee'];} else { $objannee = '';}

/* mois parution */
switch($value['objmois']){
    case 1: $objmois = 'Jan.'; break;     case 2: $objmois = 'Fev.'; break;
    case 3: $objmois = 'Mar.'; break;    case 4: $objmois = 'Avr.'; break;
    case 5: $objmois = 'Mai'; break;    case 6: $objmois = 'Juin'; break;
    case 7: $objmois = 'Jui.'; break;    case 8: $objmois = 'Aou.'; break;
    case 9: $objmois = 'Sep.'; break;    case 10: $objmois = 'Oct.'; break;
    case 11: $objmois = 'Nov.'; break;    case 12: $objmois = 'Dec.'; break;
    default: $objmois =''; break;
}

/* nom de la serie et titre*/

if(mb_strlen($value['sernom'])>25) {
    $titlesernom= "Nom de la série : ".$value['sernom'];
    $sernom = ucwords(mb_strtolower(mb_substr($value['sernom'],0,24)."..."));
}
else { $sernom = ucwords(mb_strtolower($value['sernom'])); $titlesernom= "Nom de la série";}

/* lien serie complete*/
$serie_link='';
if(intval($value['serid'])>0){
    $serie_link = WEBROOT.$page_galleries.'/series/'.$value['serid'];
}







/* nom de l'editeur */
$edinom = $value['edinom'];

ob_start();
?>
<div class="card" id="<?php echo $objid; ?>">

    <div class="topcard">
        <?php if($new=='1') { ?>
            <img class="ban_nouveau" src="/public/images/elements/banniere.png" alt="new_image">
        <?php } ?>
        <?php if($parameters[1]=='types') { ?>
            <span class="ban_editeur"><?php echo $edinom; ?></span>
        <?php } ?>
        <a class="img-container" data-badge="<?php echo $nbimg; ?>" href="<?php echo $objimg; ?>">
            <?php if($objdesc!="") { ?>
                <i class="material-icons-two-tone badge-description">info</i>
            <?php } ?>
                <img class="myImg" src="<?php echo $objimg; ?>" alt="<?php echo $edinom.'-'.$sernom.'-'.$objnom; ?>">
            <?php if($nbimg>1) { ?>
                <span class="badge-number"><?php echo $nbimg; ?></span>
            <?php } ?>
        </a>
        <?php echo $objdesc ?>
    </div>

    <div class="bodycard">
        <hr>
        <h2 title ="<?php echo $objtitle; ?>">
            <?php echo $objnom; if (Auth::getStatus()== 3 && $_SESSION['auth']['type']==sha1('ADMIN')) { echo ' ('.$objid.')'; }?>
        </h2>
        <hr>
        <p>
            <span>Taille : <?php echo $objtaille; ?></span>
            <span class="span-right">Poids : <?php echo $objpoids; ?></span>
        </p>
        <p>
            <span>Prix : <?php echo $objprix; ?></span>
            <?php if (Auth::getStatus()== 3 && $_SESSION['auth']['type']==sha1('ADMIN')) { ?>
                 <span class="span-right bgc-possession"><?php echo $objrangement; ?></span>
            <?php } ?>
        </p>
        <p>
            <span>Ref : <?php echo $objref; ?></span>
            <span class="span-right">Parution : <?php echo $objmois.' '.$objannee; ?></span>
        </p>
        <hr>
        <div class="bandeau-bas">
            <div class="myCol-70">
                <div class="myRow">
                    <?php if(!empty($serie_link) && isset($parameters[1]) && $parameters[1]<>'series'){ ?>
                        <span title="<?php echo $titlesernom; ?>" class="bandeau-bas-texte"><?php echo $sernom; ?></span>
                    <?php  }?>
                </div>
            </div>
            <div class="myCol-30">
                <div class="myRow bandeau-bas-icons">
                    <?php if (Auth::getStatus()== 3 && $_SESSION['auth']['type']==sha1('ADMIN')) { ?>
                        <a title="Editer l'objet" class="info-obj" href="<?php echo WEBROOT.'admin/object_update/'.$objid; ?>"><span><i class="material-icons">pending</i></span></button></a>
                    <?php  }?>
                    <?php if (Auth::getStatus()== 3) { ?>
                        <a title="Ajouter des informations à cet objet" class="info-obj" href="<?php echo WEBROOT.'add_information/'.$objid; ?>"><span><i class="material-icons">add_circle</i></span></a>
                    <?php  } else {?>
                        <a title="Ajouter des informations à cet objet" class="info-obj obj" href="#"><span><i class="material-icons">add_circle</i></span></a>
                    <?php  }?>
                    <?php if(!empty($serie_link) && isset($parameters[1]) && $parameters[1]<>'series'){ ?>
                        <a title="Voir la série complète" class="info-obj" href="<?php echo $serie_link; ?>"><span><i class="material-icons">collections</i></span></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $var = ob_get_clean(); ?>
