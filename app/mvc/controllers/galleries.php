<?php
	require_once DIR_MODELS.$controller.'.php';

	$url1 = null ; $url2 = null ; $url3 = null ;

	if(isset($parameters[1])){ $parameters[1]= mb_strtolower($parameters[1]);}

	// Création de la liste de niveau 1 si pas de valeurs cohérentes
	if(	!isset($parameters[1])
		|| (	isset($parameters[1]) && !in_array($parameters[1], $searchCategory ))
	){
		$requete = array(
			"<a class=\"gallery-item\" href=\"".WEBROOT.$controller."/series"."\">SERIES</a>",
			"<a	class=\"gallery-item\" href=\"".WEBROOT.$controller."/editeurs"."\">EDITEURS</a>",
			"<a	class=\"gallery-item\" href=\"".WEBROOT.$controller."/types"."\">TYPES OBJETS</a>",
			"<a	class=\"gallery-item\" href=\"".WEBROOT.$controller."/personnages"."\">PERSONNAGES</a>"
		);
		$url1 = $$page_title;
	}

	// Creation de la liste de niveau 2 à partir du paramètres 2
	if( isset($parameters[1]) && in_array($parameters[1],$searchCategory) ){
		$url1= "<a class=\"myNavLink\" href=\"".WEBROOT.$page_galleries."\">Galeries</a>";
		// $searchCategory = series
		if($parameters[1]=='series'){
			$requete = array();
			foreach ($serie_list as $serie) {
				$value = "<a	class=\"gallery-item\"
								href=\"".WEBROOT.$controller."/series/".$serie['serid']."\"
							>
							<img class=\"gallery-item-image\" src=\"".DIR_EDITORS_IMAGES.$serie['ediimg']."\" alt=\"".DIR_EDITORS_IMAGES.$serie['ediimg']."\">
							".$serie['sernom']."
						</a>";
				array_push($requete,$value);
			}
		}
		// $searchCategory = editeurs
		if($parameters[1]=='editeurs'){
			$requete = array();
			foreach ($editeur_list as $editeur) {
				if(empty($editeur['ediimg'])==true){
					$value = "<a	class=\"gallery-item\"
								href=\"".WEBROOT.$controller."/editeurs/".$editeur['ediid']."\"
							>
							".$editeur['edinom']."
						</a>";
				}
				if(empty($editeur['ediimg'])==false) {
					$value = "<a	class=\"gallery-item\"
									href=\"".WEBROOT.$controller."/editeurs/".$editeur['ediid']."\"
								>
								<img class=\"gallery-item-editeur\" src=\"".DIR_EDITORS_IMAGES.$editeur['ediimg']."\" alt=\"".DIR_EDITORS_IMAGES.$editeur['ediimg']."\">

							</a>";
					}
				array_push($requete,$value);
			}
		}
		// $searchCategory = types
		if($parameters[1]=='types' && empty($parameters[2])==true){
			$requete = array();
			foreach ($type_list as $type) {
				$value = "<a
							class=\"gallery-item\"
							href=\"".WEBROOT.$controller."/types/".$type['typeid']."\"
							style=\"background-image: url(".DIR_TYPES_IMAGES.$type['typeimg'].");\"
						>".
						$type['typelib'].
						"</a>";
				array_push($requete,$value);
			}
		}

		// $searchCategory = personnages
		if($parameters[1]=='personnages'){
			$requete = array();
			foreach ($personnage_list as $personnage) {
				$personnage['persalias']=strtoupper($personnage['persalias']);
				$personnage['persalias']=str_replace("DOCTEUR","DR",$personnage['persalias']);
				$personnage['persalias']=str_replace("MADAME","MME",$personnage['persalias']);
				$personnage['persalias']=str_replace("MONSIEUR","MR",$personnage['persalias']);
				$personnage['persalias']=str_replace("COLONEL","COL.",$personnage['persalias']);
				$personnage['persalias']=str_replace("PROFESSEUR","PR.",$personnage['persalias']);


				if(empty($personnage['persimg'])==true){
					$value = "<a	class=\"gallery-item smallsize\"
									href=\"".WEBROOT.$controller."/personnages/".$personnage['persid']."\"

								>
								".$personnage['persalias']."
							</a>";
					array_push($requete,$value);
				}
				if(empty($personnage['persimg'])==false){
					$value = "<a	class=\"gallery-item smallsize\"
									href=\"".WEBROOT.$controller."/personnages/".$personnage['persid']."\"
								>
								<img style=\"z-index:10;\" class=\"gallery-item-personnage\" src=\"".DIR_PERS_IMAGES.$personnage['persimg']."\" alt=\"".DIR_EDITORS_IMAGES.$personnage['persimg']."\">
								<p style=\"z-index:100; display:block;\"><br><br><br><br>".$personnage['persalias']."</p>


							</a>";
					array_push($requete,$value);
				}
			}
		}
	}

	// Affichage de la liste des cards (niveau 3)

	if(	isset($parameters[1])
		&& in_array($parameters[1],$searchCategory)
		&& isset($parameters[2])
	){
		/* gestion des where possibles */
		$left=null;$select=null;
		if($parameters[1]=='series'){$where = "and obj.serid = ".intval($parameters[2]);}
		if($parameters[1]=='editeurs'){$where = "and obj.ediid = ".intval($parameters[2]);}
		if($parameters[1]=='personnages'){$where = "and p.persid = ".intval($parameters[2]);$left="left join personnages p on p.persid = op.persid";$select = ", p.persalias,p.persimg,p.persdesc";}
		if($parameters[1]=='types'){$where = "and obj.typeid = ".intval($parameters[2]);}
		/* requete sql */
		$query = $pdo->prepare("
				SELECT distinct ser.*, obj.*, img.imgfile, oi2.nbimg, edi.edidesc, edi.ediimg, oi3.new, oi4.note_moyenne, edi.edinom {$select}
				FROM objets obj
				left join series ser on ser.serid = obj.serid
				inner join editeurs edi on edi.ediid = obj.ediid
				left join objets_images img on img.objid = obj.objid
				left join (
									select oi.objid objid, count(oi.imgfile) nbimg
									from objets_images oi
									group by oi.objid ) oi2 on oi2.objid = obj.objid
				left join (
					SELECT
					obj.objid , 1 new
					FROM objets obj
					order by objdatecreation desc
					limit 10
					) oi3 on oi3.objid = obj.objid
				left join (
					select com.objid , avg(com.comnote) note_moyenne
					from commentaires com
					group by objid
					) oi4 on oi4.objid = obj.objid
				left join  objets_persos  op on obj.objid = op.objid
				{$left}
				where 1=1
				{$where}
				and (imgorder = 1 or imgorder is null)
				and obj.objactif = 1
				order by obj.objnom"
		);
		$query->execute();
		$response = $query->fetchAll(PDO::FETCH_ASSOC);
		$requete=[];
		foreach($response as $value){
			if($parameters[1]=='personnages'){
				$value['objnom']=$value['sernom']??$value['edinom'];
			}
			require DIR_TEMPLATES.'card.php';
			array_push($requete, $var);
		}
		/* mise en forme entete */
		if($parameters[1]=='series'){
			$area_img =DIR_EDITORS_IMAGES.$value['ediimg'];
			$area_1 = $value['edidesc'];
			$area_2 = $value['serdesc'];
		}
		if($parameters[1]=='editeurs'){
			$area_img =DIR_EDITORS_IMAGES.$value['ediimg'];
			$area_1 = $value['edidesc'];
		}
		if($parameters[1]=='personnages'){
			$area_img =DIR_PERS_IMAGES.$value['persimg'];
			$area_1 = $value['persalias'];
			$area_2 = $value['persdesc'];
		}

		$url2= "<a class=\"myNavLink\" href=\"".WEBROOT.$page_galleries."/".$parameters[1]."\">". ucfirst($parameters[1])." </a>";

	}
	$urls = $url1 . $url2 . $url3;
	require_once DIR_VIEWS.$controller.'.php';
?>
