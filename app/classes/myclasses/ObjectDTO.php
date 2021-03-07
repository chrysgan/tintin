<?php
namespace App;

use App\Message as Message;
use Intervention\Image\ImageManager;


class ObjectDTO {

    /* attributs propres de l'objet */
    private $id;
    private $actif;
    private $nom;
    private $taille;
    private $poids;
    private $prix;
    private $reference;
    private $editeur_id;
    private $serie_id;
    private $annee;
    private $mois;
    private $type_id;
    private $description;
    private $possede;
    private $rangement;
    private $mt_achat;
    private $detail_possede;
    private $personnages;
    private $images;
    /* attributs liés à la manipulation de l'objet */
    private $imagesToUpload;
    private $imgId; // id de l'image cliqué dans le front
    private $pdo;


    public function __construct($ARRAY,$FILES){
        //Connexion bdd
        $this->pdo=$GLOBALS['pdo'];

        /* attributs TEMPORAIRES propres de l'objet */
        $id = $ARRAY['objid']?? null;
        $actif = $ARRAY['objactif'] ?? null;
        $nom = $ARRAY['objnom']?? null;
        $taille = $ARRAY['objtaille']?? null;
        $poids = $ARRAY['objpoids']?? null;
        $prix = $ARRAY['objprix']?? null;
        $reference = $ARRAY['objref']?? null;
        $editeur_id = $ARRAY['objediid']?? null;
        $serie_id = $ARRAY['objserid']?? null;
        $annee = $ARRAY['objannee']?? null;
        $mois = $ARRAY['objmois']?? null;
        $type_id = $ARRAY['objtypeid']?? null;
        $description = $ARRAY['objdesc']?? null;
        $possede = $ARRAY['objpossede']?? null;
        $rangement = $ARRAY['objrangement']?? null;
        $mt_achat = $ARRAY['objmt_achat']?? null;
        $detail_possede = $ARRAY['objdetailpossede']?? null;
        $personnages = $ARRAY['personnages']?? null;
        $images = null;


        /* attributs liés TEMPORAIRES à la manipulation de l'objet */
        $imagesToUpload = $FILES ?? null;
        $imgId = $ARRAY['delete_image']?? $ARRAY['move_up_image']  ?? $ARRAY['move_down_image'] ??  null;  // id de l'image cliqué dans le front

        /* variables techniques */
        $nbImg = null;

        // Verifier que les variables sont du bon type et affecter
        if(is_numeric($id) && $id !=null ){settype($id,"int");$this->id = $id;}else{ $this->id=$this->generateId();}
        if(is_numeric($actif) && $actif!=null){
            settype($actif,"int");
            if($actif==1){$this->actif = "checked";}
        }
        if(settype($nom,"string") && $nom !=null){$this->nom = cleanStr($nom);}
        if(is_numeric($taille) && $taille != null){settype($taille,"float");$this->taille = $taille;}
        if(is_numeric($poids) && $poids!=null){settype($poids,"int");$this->poids = $poids;}
        if(is_numeric($prix) && $prix!=null){settype($prix,"float");$this->prix = $prix;}
        if(settype($reference,"string") && $reference!=null){$this->reference = cleanStr($reference);}
        if(is_numeric($editeur_id) && $editeur_id!=null){settype($editeur_id,"int");$this->editeur_id = $editeur_id;}
        if(is_numeric($serie_id) && $serie_id!=null){settype($serie_id,"int"); $this->serie_id = $serie_id; }
        if(is_numeric($annee) && $annee!=null){settype($annee,"int");$this->annee = $annee;}
        if(is_numeric($mois) && $mois!=null){settype($mois,"int");$this->mois = $mois;}
        if(is_numeric($type_id) && $type_id!=null){settype($type_id,"int");$this->type_id = $type_id;}
        if(settype($description,"string") && $description!=null){$this->description = cleanStr($description);}
        if(is_numeric($possede) && $possede!=null){
            settype($possede,"int");
            if($possede==1){$this->possede = "checked";}
        }
        if(settype($rangement,"string") && $rangement!=null){$this->rangement = cleanStr($rangement);}
        if(is_numeric($mt_achat) && $mt_achat!=null){settype($mt_achat,"float");$this->mt_achat = $mt_achat;}
        if(settype($detail_possede,"string") && $detail_possede!=null){$this->detail_possede = cleanStr($detail_possede);}
        if(settype($personnages,"array") && $personnages !=null){
            foreach ($personnages as $key => $value) {
                if(is_numeric($value) && $value!=null){settype($value,"int");$this->personnages[$key]=$value;}
            }
        }
        if(settype($imagesToUpload,"array") && $imagesToUpload !=null){
            $this->imagesToUpload = array();
            if(isset($imagesToUpload['fileImg']['name'])){
                $nbImg = count($imagesToUpload['fileImg']['name']);
            }
            for ($i=0; $i < $nbImg; $i++) {
                array_push( $this->imagesToUpload,
                    array(
                        $imagesToUpload['fileImg']['name'][$i],
                        $imagesToUpload['fileImg']['type'][$i],
                        $imagesToUpload['fileImg']['tmp_name'][$i],
                        $imagesToUpload['fileImg']['error'][$i],
                        $imagesToUpload['fileImg']['size'][$i]
                    )
                );
            }
        }
        if(is_numeric($imgId) && $imgId!=null){settype($imgId,"int");$this->imgId = $imgId;}
    }
    /* Test tous les attributs de l'objet pour savoir s'ils sont dans les critères attendus */
    public function isValid(){
        $errors = 0;
        //Controle actif
        if(!in_array($this->actif,array(1,0))){
            $errors++;
            message::addMsg("L'objet a un statut inconnu");
        }
        //Controle Nom : Longueur
        if(!(mb_strlen($this->nom)>=OBJECT_NAME_MIN_SIZE && mb_strlen($this->nom)<=OBJECT_NAME_MAX_SIZE)){
            $errors++;
            message::addMsg("La taille du nom doit être entre ".OBJECT_NAME_MIN_SIZE." et ".OBJECT_NAME_MAX_SIZE." caractères.");
        }
        //Controle Nom : Doublon dans une serie
        if($this->serie_id!=0 && !empty($this->serie_id)){
            $query=$this->pdo->prepare("select objnom objnom from objets where serid = {$this->serie_id} and objid <> {$this->id};");
            $query->execute();
            $resultset = $query->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($resultset as $set) {
                if(strtoupper($this->nom)==strtoupper($set['objnom'])){
                    $errors++;
                    message::addMsg("Le nom de l'objet est déjà utilisé dans cette série");
                }
            }
        }
        // Controle Taille de l'objet
        if(!($this->taille>=OBJECT_MIN_HEIGHT && $this->taille<=OBJECT_MAX_HEIGHT)){
            $errors++;
            message::addMsg("Taille de l'objet doit être compris entre ".OBJECT_MIN_HEIGHT." et ".OBJECT_MAX_HEIGHT." cm");
        }
        // Controle Poids de l'objet
        if(!($this->poids>=OBJECT_MIN_WEIGHT && $this->poids<=OBJECT_MAX_WEIGHT)){
            $errors++;
            message::addMsg("Le poids de l'objet doit être compris entre ".OBJECT_MIN_WEIGHT." et ".OBJECT_MAX_WEIGHT." grammes");
        }
        // Controle le prix de l'objet
        if( !(($this->prix>=0 && $this->prix<=OBJECT_MAX_PRICE) ||  $this->prix==-1 ||  $this->prix==-2)){
            $errors++;
            message::addMsg("Prix non conforme");
        }
        // Controle la reference de l'objet
        if(mb_strlen($this->reference)>OBJECT_REF_MAX_SIZE){
            $errors++;
            message::addMsg("La référence de l'objet doit être inférrieur à ".OBJECT_REF_MAX_SIZE." caractères.");
        }
        // Controle de l'editeur de l'objet
        if(!in_array($this->editeur_id,$GLOBALS['editeur_List_Id'])){
            $errors++;
            message::addMsg("Editeur non conforme");
        }
        // Controle de la serie de l'objet
        if(!(in_array($this->serie_id,$GLOBALS['serie_List_Id']) || $this->serie_id==0)){
            $errors++;
            message::addMsg("Série non conforme");
        }
        // Controle de l'année de l'objet
        if(($this->annee<OBJECT_MIN_YEAR || $this->annee>intval(date('Y'))) && $this->annee<>0){
            $errors++;
            message::addMsg("L'année de l'objet doit être entre ".OBJECT_MIN_YEAR." et aujourd'hui.");
        }
        // Controle de du mois de l'objet
        if($this->mois<0 || $this->mois>12){
            $errors++;
            message::addMsg("Le mois de lobjet doit être compris entre 0 et 12. 0 étant mois non connu");
        }
        //Controle que le type existe
        if(!in_array($this->type_id,$GLOBALS['type_List_Id'])){
            $errors++;
            message::addMsg("Type non conforme");
        }
        // Controle la taille de la description
        if(mb_strlen($this->description)>TEXTAREA_MAX_LENGTH){
            $errors++;
            message::addMsg("La taille de la description doit être inférrieur à ".TEXTAREA_MAX_LENGTH." caractères.");
        }
        //Controle possede
        if(!in_array($this->possede,array(1,0))){
            $errors++;
            message::addMsg("L'objet a une possession inconnu");
        }
        // Controle la taille de Rangement
        if(mb_strlen($this->rangement)>OBJECT_RANGEMENT_MAX_SIZE){
            $errors++;
            message::addMsg("La longueur du Rangement est de ".OBJECT_RANGEMENT_MAX_SIZE." caractères maximum.");
        }
        // Controle du montant achat de l'objet
        if($this->mt_achat>OBJECT_MAX_PRICE || $this->mt_achat<0){
            $errors++;
            message::addMsg("Montant d'achat doit être inférieur à ".OBJECT_MAX_PRICE);
        }
        // Controle la taille de detail sur l'objet possédé
        if(mb_strlen($this->description)>TEXTAREA_MAX_LENGTH){
            $errors++;
            message::addMsg("La taille de la description doit être inférrieur à ".TEXTAREA_MAX_LENGTH." caractères.");
        }
        //Controle que les personnages existent
        $temp_list=array();
        foreach ($GLOBALS['pers_ArrayList_IdAlias'] as $value) {
            settype($value['persid'],"int");
            array_push($temp_list,$value['persid']);
        }
        if($this->personnages!=null) {
            foreach ($this->personnages as $pers) {
                if(!in_array($pers,$temp_list)){
                    $errors++;
                    message::addMsg("Erreur dans la liste des personnages");
                }
            }
        }
        if($errors>0){
            return false;
        }
        else {
            return true;
        }
    }
    /* Pour exporter l'objet en array */
    public function toArray(){
        $toArray = array(
            "objid" => $this->id,
            "objactif" => $this->actif,
            "objnom" => $this->nom,
            "objtaille" => $this->taille,
            "objpoids" => $this->poids,
            "objprix" => $this->prix,
            "objref" => $this->reference,
            "objediid" => $this->editeur_id,
            "objserid" => $this->serie_id,
            "objannee" => $this->annee,
            "objmois" => $this->mois,
            "objtypeid" => $this->type_id,
            "objdesc" => $this->description,
            "objpossede" => $this->possede,
            "objrangement" => $this->rangement,
            "objmt_achat" => $this->mt_achat,
            "objdetailpossede" => $this->detail_possede,
            "objpersonnages" => $this->personnages,
            "objimages" => $this->images
        );
        return $toArray;
    }
    /* Sauvegarde de l'objet en base de données */
    public function save(){

        /* Sauvegarde principale */
        $query = $this->pdo->prepare(
            "INSERT into objets
            (objid,objactif,objnom,objtaille,objpoids,objprix,objref,ediid,serid,objannee,objmois,typeid,objdesc,possede,rangement,mt_achat,detail_sur_possession)
            values
            (:id,:actif,:nom,:taille,:poids,:prix,:reference,:editeur_id,:serie_id,:annee,:mois,:type_id,:description,:possede,:rangement,:mt_achat,:detail_possede);"
        );
        $query->bindParam(":id",$this->id,\PDO::PARAM_INT);
        if($this->actif=='checked'){$actif_insert=1;}else{$actif_insert=0;}
        $query->bindParam(":actif",$actif_insert,\PDO::PARAM_INT);
        $query->bindParam(":nom",$this->nom,\PDO::PARAM_STR);
        $query->bindParam(":taille",$this->taille);/**/
        $query->bindParam(":poids",$this->poids,\PDO::PARAM_INT);/**/
        $query->bindParam(":prix",$this->prix);/**/
        $query->bindParam(":reference",$this->reference,\PDO::PARAM_STR);
        $query->bindParam(":editeur_id",$this->editeur_id,\PDO::PARAM_INT);
        if($this->serie_id == null){$serie_id_insert= null;} else {$serie_id_insert = $this->serie_id;}
        $query->bindParam(":serie_id",$serie_id_insert,\PDO::PARAM_INT);
        $query->bindParam(":annee",$this->annee,\PDO::PARAM_INT);
        $query->bindParam(":mois",$this->mois,\PDO::PARAM_INT);
        $query->bindParam(":type_id",$this->type_id,\PDO::PARAM_INT);
        $query->bindParam(":description",$this->description,\PDO::PARAM_STR);
        if($this->possede=='checked'){$possede_insert=1;}else{$possede_insert=0;}
        $query->bindParam(":possede",$possede_insert,\PDO::PARAM_INT);
        $query->bindParam(":rangement",$this->rangement,\PDO::PARAM_STR);
        $query->bindParam(":mt_achat",$this->mt_achat);/**/
        $query->bindParam(":detail_possede",$this->detail_possede,\PDO::PARAM_STR);
		$query->execute();

        //Sauvegarde des personnages associés
        /* Suppression de l'antériorité des associations */
        $query = $this->pdo->prepare("delete from objets_persos where objid = {$this->id};");
        $query->execute();
        /* creation des nouvelles associations */
        if($this->personnages!=null){
            foreach ($this->personnages as $pers) {
        		$query = $this->pdo->prepare("insert into objets_persos (objid , persid) values ({$this->id},{$pers});");
        		$query->execute();
            }
        }

        Message::addMsg('Objet créé avec succès');
        unset($_POST);
    }

    public function update(){

        /* Mise à jour principale */
        $query = $this->pdo->prepare("
            update objets set
            objactif = :actif,
            objnom = :nom,
            objtaille = :taille,
            objpoids = :poids,
            objprix = :prix,
            objref = :reference,
            ediid = :editeur_id,
            serid = :serie_id,
            objannee = :annee,
            objmois = :mois,
            typeid = :type_id,
            objdesc = :description,
            possede = :possede,
            rangement = :rangement,
            mt_achat = :mt_achat,
            detail_sur_possession = :detail_possede
            where objid = :id;
            "
        );
        if($this->actif=='checked'){$actif_insert=1;}else{$actif_insert=0;}
        $query->bindParam(":actif",$actif_insert,\PDO::PARAM_INT);
        $query->bindParam(":nom",$this->nom,\PDO::PARAM_STR);
        $query->bindParam(":taille",$this->taille);/**/
        $query->bindParam(":poids",$this->poids,\PDO::PARAM_INT);/**/
        $query->bindParam(":prix",$this->prix);/**/
        $query->bindParam(":reference",$this->reference,\PDO::PARAM_STR);
        $query->bindParam(":editeur_id",$this->editeur_id,\PDO::PARAM_INT);
        if($this->serie_id == null){$serie_id_insert= null;} else {$serie_id_insert = $this->serie_id;}
        $query->bindParam(":serie_id",$serie_id_insert,\PDO::PARAM_INT);
        $query->bindParam(":annee",$this->annee,\PDO::PARAM_INT);
        $query->bindParam(":mois",$this->mois,\PDO::PARAM_INT);
        $query->bindParam(":type_id",$this->type_id,\PDO::PARAM_INT);
        $query->bindParam(":description",$this->description,\PDO::PARAM_STR);
        if($this->possede=='checked'){$possede_insert=1;}else{$possede_insert=0;}
        $query->bindParam(":possede",$possede_insert,\PDO::PARAM_INT);
        $query->bindParam(":rangement",$this->rangement,\PDO::PARAM_STR);
        $query->bindParam(":mt_achat",$this->mt_achat);/**/
        $query->bindParam(":detail_possede",$this->detail_possede,\PDO::PARAM_STR);
        $query->bindParam(":id",$this->id,\PDO::PARAM_INT);
		$query->execute();

        //Sauvegarde des personnages associés
        /* Suppression de l'antériorité des associations */
        $query = $this->pdo->prepare("delete from objets_persos where objid = {$this->id};");
        $query->execute();
        /* creation des nouvelles associations */
        if($this->personnages!=null){
            foreach ($this->personnages as $pers) {
        		$query = $this->pdo->prepare("insert into objets_persos (objid , persid) values ({$this->id},{$pers});");
        		$query->execute();
            }
        }

        Message::addMsg('Objet modifié avec succès');
        unset($_POST);
    }

    /* Génération automatique d'un id unique */
    public function generateId(){
        /* recherche d'id créé par erreur pour les images */
        $query = $this->pdo->prepare("select oi.objid,oi.imgfile from objets_images oi left join objets o on o.objid=oi.objid where o.objnom is null;");
        $query->execute();
        $resultSet = $query->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($resultSet as $set) {
            /* suppression physique des images */
            if(!empty($set['imgfile']) && file_exists(DIR_OBJECTS_IMAGES_ROOT.$set['imgfile'])){
    			unlink(DIR_OBJECTS_IMAGES_ROOT.$set['imgfile']);
    		}
            /* suppression des enreg en bdd */
            $query = $this->pdo->prepare("delete from objets_images where objid = {$set['objid']};");
            $query->execute();
        }
        /* generation de l'id */
        $query = $this->pdo->prepare("SELECT max(objid)+1 NEWID FROM objets;");
        $query->execute();
        $new_id = $query->fetch(\PDO::FETCH_ASSOC);
        settype($new_id['NEWID'],"int");
        return $new_id['NEWID'];
    }
    /* Sauvegarde des images */
    public function saveImages(){
        foreach ($this->imagesToUpload as $image) {
            // création de l'image
            $manager = new ImageManager();
            $img =  $manager->make($image[2]);
            // redimensionnement de l'image
            $imgSize=getimagesize($image[2]);
            if($imgSize[1]>=OBJECT_IMAGE_HEIGHT){
                $img->resize(null, OBJECT_IMAGE_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            // attribution d'un numero et sauvegarde de l'image
            $query = $this->pdo->prepare("select substr(max(imgfile),1,6) numero from objets_images");
            $query->execute();
            $result  = $query->fetch(\PDO::FETCH_ASSOC);
            $number = intval($result['numero'],10)+1;
            $objimg = substr('000000'.$number,-6).'.JPG';
            $img->save(DIR_OBJECTS_IMAGES_ROOT.$objimg);
            // attribution d'un numero d'ordre
            $query = $this->pdo->prepare("select max(imgorder) nb from objets_images where objid = {$this->id}");
            $query->execute();
            $result  = $query->fetch(\PDO::FETCH_ASSOC);
            $nb=intval($result['nb'])+1;
            //Sauvegarde dans la table objets_images
            $query = $this->pdo->prepare("insert into objets_images (objid , imgfile, imgorder) values ({$this->id},'{$objimg}',{$nb});");
            $query->execute();
        }
        // rechargement des associations d'images
        $this->loadImages();

    }

    public function loadImages(){
        $query = $this->pdo->prepare("select objid, imgid, imgfile, imgorder from objets_images  where objid = {$this->id} order by objid, imgorder");
        $query->execute();
        $resultset = $query->fetchAll(\PDO::FETCH_ASSOC);
        $this->images= array();
        foreach ($resultset as $img) {
            array_push($this->images,array('objid'=>$img['objid'],'imgid'=>$img['imgid'],'imgfile'=>$img['imgfile'],'imgorder'=>$img['imgorder']));
        }
    }

    public function deleteImage(){
        /* Suppression physique de l'image */
        $query = $this->pdo->prepare("select imgfile,imgorder from objets_images where imgid = {$this->imgId};");
        $query->execute();
        $img = $query->fetchAll(\PDO::FETCH_ASSOC);
        $order = $img[0]['imgorder'];
        unlink(DIR_OBJECTS_IMAGES_ROOT.$img[0]['imgfile']);
        // Suppression de l'image en base de données
        $query = $this->pdo->prepare("delete from objets_images where imgid = {$this->imgId};");
        $query->execute();
        // ordonnancement des autres images suite à la suppression
        $query = $this->pdo->prepare("select imgid,imgorder from objets_images where objid = {$this->id} order by imgorder;");
        $query->execute();
        $img_list = $query->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($img_list as $img) {
            if(intval($img['imgorder'])>intval($order)){
                $tmpImgid = intval($img['imgid']);
                $query = $this->pdo->prepare("update objets_images set imgorder = imgorder-1 where imgid = {$tmpImgid};");
                $query->execute();
                // mise à jour date objets
                $query = $this->pdo->prepare("update objets set objdateupdate = current_timestamp() where objid = {$this->id};");
                $query->execute();
            }
        }
        // rechargement des associations d'images
        $this->loadImages();
    }

    // changement de l'ordonnancement sur monter l'element
    public function moveUpImage(){
        $query = $this->pdo->prepare("select objid, imgid, imgorder from objets_images where objid = {$this->id} order by imgorder;");
        $query->execute();
        $img_list = $query->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($img_list as $img) {
            settype($img['imgorder'],"int");
            settype($img['imgid'],"int");
            if($img['imgorder']>1){
                if($img['imgid'] == $this->imgId){
                    // changement de l'ordre de l'image précédente ds la bdd
                    $query = $this->pdo->prepare("update objets_images set imgorder = imgorder +1 where objid = {$this->id} and imgorder = ({$img['imgorder']}-1);");
                    $query->execute();
                    // changement de l'ordre de l'image en cours ds la bdd
                    $query = $this->pdo->prepare("update objets_images set imgorder = imgorder -1 where imgid = {$this->imgId};");
                    $query->execute();
                    // mise à jour date objets
                    $query = $this->pdo->prepare("update objets set objdateupdate = current_timestamp() where objid = {$this->id};");
                    $query->execute();
                }
            }
        }
        // rechargement des associations d'images
        $this->loadImages();
    }

    // changement de l'ordonnancement sur descendre l'element
    public function moveDownImage(){
        $query = $this->pdo->prepare("select objid, imgid, imgorder from objets_images where objid = {$this->id} order by imgorder;");
        $query->execute();
        $img_list = $query->fetchAll(\PDO::FETCH_ASSOC);
        $query = $this->pdo->prepare("select max(imgorder) ordre from objets_images where objid = {$this->id};");
        $query->execute();
        $max = $query->fetchAll(\PDO::FETCH_ASSOC);
        settype($max[0]['ordre'],"int");
        foreach ($img_list as $img) {
            settype($img['imgorder'],"int");
            settype($img['imgid'],"int");
            if($img['imgorder']<$max[0]['ordre']){
                if($img['imgid'] == $this->imgId){
                    // changement de l'ordre de l'image suivante ds la bdd
                    $query = $this->pdo->prepare("update objets_images set imgorder = imgorder -1 where objid = {$this->id} and imgorder = ({$img['imgorder']}+1);");
                    $query->execute();
                    // changement de l'ordre de l'image en cours ds la bdd
                    $query = $this->pdo->prepare("update objets_images set imgorder = imgorder +1 where imgid = {$this->imgId};");
                    $query->execute();
                    // mise à jour date objets
                    $query = $this->pdo->prepare("update objets set objdateupdate = current_timestamp() where objid = {$this->id};");
                    $query->execute();
                }
            }
        }
        // rechargement des associations d'images
        $this->loadImages();
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}
