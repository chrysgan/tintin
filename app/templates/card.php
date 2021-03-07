<?php
use App\Auth;

$objid = $value['objid'];

if(empty($value['imgfile']) || !file_exists(DIR_OBJECTS_IMAGES_ROOT.$value['imgfile'])){
    $objimg =  DIR_OBJECTS_IMAGES."000000.PNG";
}
else {
    $objimg = DIR_OBJECTS_IMAGES.$value['imgfile'];
}
$nbimg = intval($value['nbimg']);
if($nbimg>1){$badge = 'badge';}else $badge ='no-badge';


if(mb_strlen($value['objnom'])>34){
    $objnom = mb_substr($value['objnom'],0,34).'...';
    $objtitle = $value['objnom'];
}
else {
    $objnom = $value['objnom'];
    $objtitle = '';
}

$note=0;
foreach($com_list as $com) {
    if($com['objid']==$objid){
        $note = $com['comnote'];
    }
}

if(empty($value['objref'])){
    $objref = "-";
}
else {
    $objref = $value['objref'];
}
if($value['objprix']==0 && empty($value['objprix']==false)){
    $objprix = "Offert";
}
else if($value['objprix']==-1){
    $objprix="Inconnu";
}
else if($value['objprix']==-2){
    $objprix="Ni vendu ni offert";
}
else {
    $objprix = $value['objprix']." €";
}
$objdesc = $value['objdesc'];
$new = $value['new'];
$note_gen = round($value['note_moyenne'],1);
if($note_gen>0) {
    $hideimg = "";
    $hidespan="style=\"display:block;\"";
}
else {
    $hideimg ="hidden";
    $hidespan="style=\"display:none;\"";
}
if(intval($value['objpoids']>0)){
    $objpoids = $value['objpoids'].' grs';
}
else {
    $objpoids = '-';
}
if(intval($value['objtaille'])>0){
    $objtaille = $value['objtaille'].' cm';
}
else {
    $objtaille = 'nc';
}
$serie_link='';
if(intval($value['serid'])>0){
    $serie_link = WEBROOT.$page_galleries.'/series/'.$value['serid'];
}

switch($value['objmois']){
    case 1:
        $objmois = 'Jan. ';
        break;
    case 2:
        $objmois = 'Fev. ';
        break;
    case 3:
        $objmois = 'Mar. ';
        break;
    case 4:
        $objmois = 'Avr. ';
        break;
    case 5:
        $objmois = 'Mai ';
        break;
    case 6:
        $objmois = 'Juin ';
        break;
    case 7:
        $objmois = 'Jui. ';
        break;
    case 8:
        $objmois = 'Aou. ';
        break;
    case 9:
        $objmois = 'Sep. ';
        break;
    case 10:
        $objmois = 'Oct. ';
        break;
    case 11:
        $objmois = 'Nov. ';
        break;
    case 12:
        $objmois = 'Dec. ';
        break;
    default:
        $objmois ='';
        break;

}

if(intval($value['objannee']>0)){
    $objannee = $value['objannee'];
}
else {
    $objannee = '';
}

$objpossede = $value['possede'];
$objrangement = $value['rangement'];

$sernom = $value['sernom'];
$edinom = $value['edinom'];
ob_start();
?>
<div class="obj-item" id="<?php echo $objid; ?>">
    <div class="topcard">
        <a class="<?php echo $badge; ?>" data-badge="<?php echo $nbimg; ?>" href="<?php echo $objimg; ?>">
            <img class="myImg" src="<?php echo $objimg; ?>" alt="<?php echo $edinom.'-'.$sernom.'-'.$objnom; ?>">
            <img class="ban_star" src="/public/images/elements/BIG-STAR.PNG" <?php echo $hideimg; ?>>
            <p class="ban_star_nb" <?php echo $hidespan; ?>><?php echo $note_gen; ?></p>
            <?php if($new=='1') { ?>
                <img class="ban_nouveau" src="/public/images/elements/banniere.png" alt="new_image">
            <?php } ?>
        </a>
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
                 <span class="span-right"><?php echo $objrangement.'-'.$objpossede; ?></span>
            <?php } ?>
        </p>

        <p>
            <span>Ref : <?php echo $objref; ?></span>
            <span class="span-right">Parution : <?php echo $objmois.$objannee; ?></span>
            <hr>
        <p>
            <?php if (Auth::getStatus()== 3) {

                for ($i=1; $i <= 5 ; $i++) {
                    if(intval($i)<=intval($note)){
                        echo "<a class=\"stars rated \" href=\"\" data-star=\"{$i}\"></a>";
                    }
                    else {
                        echo "<a class=\"stars\" href=\"\" data-star=\"{$i}\"></a>";
                    }
                }
            }
            ?>
            <?php if (Auth::getStatus()== 3) { ?>
                <a title="Ajouter des informations à cet objet" class="info-obj" href="<?php echo WEBROOT.'add_information/'.$objid; ?>"><span><i class="material-icons">add_circle</i></span></a>
            <?php  }?>
            <?php if(!empty($objdesc)){ ?>
                <a title="Voir les informations complémentaires" class="info-obj display-info" href=""><span><i class="material-icons">info</i></span></a>
            <?php } ?>
            <?php if(!empty($serie_link) && isset($parameters[1]) && $parameters[1]<>'S'){ ?>
                <a title="Voir la série complète" class="info-obj" href="<?php echo $serie_link; ?>"><span><i class="material-icons">unarchive</i></span></a>
            <?php } ?>
            <?php if (Auth::getStatus()== 3 && $_SESSION['auth']['type']==sha1('ADMIN')) { ?>

                    <a title="Editer l'objet" class="info-obj" href="<?php echo WEBROOT.'admin/object_update/'.$objid; ?>"><span><i class="material-icons">pending</i></span></button></a>

            <?php  }?>
        </p>
    </div>
</div>

<?php $var = ob_get_clean(); ?>
