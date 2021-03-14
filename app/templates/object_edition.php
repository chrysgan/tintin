<form class="form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post" name="myForm">
        <div class="myRow flex-center">
            <div class="myCol-30">
                <input
                    id="objid"
                    name="objid"
                    type="hidden"
                    value="<?=$objid; ?>"
                >
                <div class="">
                    <input
                        id="objactif"
                        name="objactif"
                        type="checkbox"
                        title="Coché l'objet s'affichera sur le site"
                        value="1"
                        <?=$objactif; ?>
                    > <!-- echo $objactiftag = selected -->
                    <label for="objactif">Objet actif</label>
                </div>
                <label for="objnom">Nom de l'objet</label>
                <input
                    id="objnom"
                    name="objnom"
                    type="text"
                    title="<?=OBJECT_NAME_MAX_SIZE;?> caractères max"
                    value="<?=$objnom; ?>"
                    minlength="<?=OBJECT_NAME_MIN_SIZE ?>"
                    maxlength="<?=OBJECT_NAME_MAX_SIZE ?>"
                >
                <label for="objtaille">Hauteur en centimètres</label>
                <input
                    id="objtaille"
                    name="objtaille"
                    type="number"
                    title="doit être compris entre <?=OBJECT_MIN_HEIGHT;?> et <?=OBJECT_MAX_HEIGHT;?>"
                    value="<?=$objtaille; ?>"
                    step="any"
                    min="<?=OBJECT_MIN_HEIGHT;?>"
                    max="<?=OBJECT_MAX_HEIGHT;?>"
                >
                <label for="objpoids">Poids en grammes</label>
                <input
                    id="objpoids"
                    name="objpoids"
                    type="number"
                    title="doit être compris entre <?=OBJECT_MIN_WEIGHT;?> et <?=OBJECT_MAX_WEIGHT;?>"
                    value="<?=$objpoids; ?>"
                    step="any"
                    min="<?=OBJECT_MIN_WEIGHT;?>"
                    max="<?=OBJECT_MAX_WEIGHT;?>"
                >
                <label for="objprix">Prix d'achat (€) <br>
                    -2 : Ni vendu ni offert &nbsp&nbsp&nbsp&nbsp
                    -1 : Inconnu &nbsp&nbsp&nbsp&nbsp
                    0 :	Offert </label>
                <input
                    id="objprix"
                    name="objprix"
                    type="number"
                    title="Le prix ne peut exceder <?=OBJECT_MAX_PRICE;?> €"
                    value="<?=$objprix; ?>"
                    step="any"
                    min="<?=OBJECT_MIN_PRICE;?>"
                    max="<?=OBJECT_MAX_PRICE;?>"
                >
                <label for="objref">Référence de l'objet</label>
                <input
                    id="objref"
                    name="objref"
                    type="text"
                    title="<?=OBJECT_REF_MAX_SIZE;?> caractères max"
                    value="<?=$objref; ?>"
                    maxlength="<?=OBJECT_REF_MAX_SIZE;?>"
                >
                    <label for="objediid">Editeur</label>
                <select name="objediid" id="objediid">
                    <?php
                        $default=false;
                        foreach ($GLOBALS['editeur_ArrayList_IdNom'] as $key) {
                        if($key[0]==$objediid || (mb_strlen($objediid)==0 && intval($key[0])==4))
                        {$selected = "selected"; $default=true;}
                        else
                        {$selected = '';}
                        echo "<option value=\"{$key[0]}\" $selected >{$key[1]}</option>";
                        }
                    ?>
                </select>
                <label for="objserid">Série</label>
                <select name="objserid" id="objserid">
                        <option value="0" >-</option>
                        <?php
                            $default=false;
                            foreach ($GLOBALS['serie_ArrayList_IdNom'] as $key) {
                                if($key[0]==$objserid){$selected = "selected"; $default=true;}
                                else {$selected = '';}
                                echo "<option value=\"{$key[0]}\" $selected >{$key[1]}</option>";
                            }
                        ?>
                </select>
                <fieldset>
                    <legend>Parution</legend>
                    <label for="objannee">Année</label>
                    <input
                        id="objannee"
                        name="objannee"
                        type="number"
                        title="L'année doit être comprise entre <?=OBJECT_MIN_YEAR; ?> et <?=date('Y'); ?>"
                        value="<?=$objannee; ?>"
                        min="<?=OBJECT_MIN_YEAR; ?>"
                        max="<?=date('Y'); ?>"
                    >
                    <label for="objmois">Mois</label>
                    <input
                        id="objmois"
                        name="objmois"
                        type="number"
                        title="Nombre compris entre 0 et 12"
                        value="<?=$objmois; ?>"
                        min="0"
                        max="12"
                    >
                </fieldset>

                <label for="objtypeid">Type</label>
                <select name="objtypeid" id="objtypeid">
                        <?php
                            $default=false;
                                var_dump($objtypeid);
                                foreach ($GLOBALS['type_ArrayList_IdLibt'] as $key) {
                                if($key[0]==$objtypeid){$selected = "selected"; $default=true;} else {$selected = '';}
                                echo "<option value=\"{$key[0]}\" $selected >{$key[1]}</option>";
                            }
                        ?>
                </select>

                <label for="objdesc">Description de l'objet</label>
                <textarea name="objdesc" id="objdesc" cols="40" rows="7"><?=$objdesc; ?></textarea>

                <div class="">
                    <input
                        id="objpossede"
                        name="objpossede"
                        type="checkbox"
                        value="1"
                        <?=$objpossede; ?>
                        /><!-- echo $objpossedetag = selected -->
                    <label for="objpossede">Possédé</label>
                </div>

                <label for="objrangement">Rangement de de l'objet</label>
                <input
                    id="objrangement"
                    type="text"
                    name="objrangement"
                    title="50 caractères max"
                    value="<?=$objrangement; ?>"
                    maxlength="<?=OBJECT_RANGEMENT_MAX_SIZE; ?>"
                >

                <label for="objmt_achat">Montant achat</label>
                <input
                    id="objmt_achat"
                    type="number"
                    name="objmt_achat"
                    title="Le montant ne peut exceder <?=OBJECT_MAX_PRICE?> €"
                    value="<?=$objmt_achat; ?>"
                    step="any"
                    min="0"
                    max="<?=OBJECT_MAX_PRICE;?>"
                >

                <label for="objdetailpossede">Detail sur l'objet possédé</label>
                <textarea name="objdetailpossede" id="objdetailpossede" cols="40" rows="7"><?=$objdetailpossede; ?></textarea>

                <label for="fileImg">Ajout d'images</label>
                <input type="file" id="fileImg" name="fileImg[]"  multiple accept=".png, .jpg, .jpeg, .gif">
                <div id="preview"></div>
                <button type="submit" name="action" value="add_images">Ajouter image(s)</button>

                <!-- <?php if(isset($objimages)){ ?> -->
                <label for="tableUpdateObjectImage">Images existantes</label>
                <table id="tableUpdateObjectImage" class="tableUpdateObjectImage">
                    <div>
                    <?php
                    foreach ($objimages as $img) {
                        if($img['objid']==$objid){
                            echo "<tr>";
                            echo "<td><img class=\"imgPreview\" src=\"".DIR_OBJECTS_IMAGES.$img['imgfile']."\" alt=\"\"></td>";
                            echo "<td><button type=\"button\" name=\"delete_image\" value=\"".$img['imgid']."\">Supprimer</button></td>";
                            echo "<td><button type=\"button\" name=\"move_up_image\" value=\"".$img['imgid']."\">Up</button>";
                            echo "<button type=\"button\" name=\"move_down_image\" value=\"".$img['imgid']."\">Down</button></td>";
                            echo"</tr>";
                        }
                    }
                    ?>
                    </div>
                </table>
                <!-- <?php }?> -->

            </div>
            <div class="myCol-40">
                <fieldset>
                    <legend>Personnages associés</legend>
                <table class="">
                    <tbody>
                        <?php
                        $ligne=1;
                        foreach ($GLOBALS['pers_ArrayList_IdAlias'] as $pers) {
                            $checked="";
                            if(isset($pers['persid']) && isset($objpersonnages) && in_array($pers['persid'],$objpersonnages)){$checked='checked';}
                            if ($ligne%2 == 1){echo "<tr>";}
                            echo "<td><div>";
                            echo "<input type=\"checkbox\" id=\"persos_{$pers['persid']}\" name=\"personnages[]\" value=\"{$pers['persid']}\" ".$checked." >";
                            echo "<label for=\"persos_{$pers['persid']}\">{$pers['persalias']}</label>";
                            echo "</div></td>";
                            if ($ligne%2 == 0){echo "</tr>";}
                            $ligne++;

                        }
                        ?>
                    </tbody>
                </table>
            </fieldset>
            </div>
        </div> <!-- fermeture div ligne -->
        <button role="button" type="submit" name="action" value="add_update_object"><?=$button_name ?></button>
</form>
