<div class="myRow flex-center">
	<table class="myRow flex-center myTableTemplate">
		<tr>
			<td class="inactif">&nbsp&nbsp</td><td>Objet inactif</td>
			<td class="pas_range">&nbsp&nbsp</td><td>Objet pas rangé</td>
			<td class="not_owned">&nbsp&nbsp</td><td>Objet non possédé</td>
			<td class="attente">&nbsp&nbsp</td><td>Objet en attente de rangement</td>
		</tr>
	</table>
	<table class="myTableTemplate">
		<thead>
        <tr>
			<th scope="col" >Type</th>
			<th scope="col" >Id</th>
			<th scope="col" >Libellé de l'objet</th>
			<th scope="col" >Dupliquer</th>
			<th scope="col" >Images</th>
			<th scope="col" >Persos<br>associés</th>
			<th scope="col" >Poids</th>
			<th scope="col" >Taille</th>
			<th scope="col" >Prix</th>
			<th scope="col" >Reference</th>
			<th scope="col" >Parution</th>
			<th scope="col" >Rangement</th>
        </tr>
    </thead>
		<!-- Lignes du tableau -->
		<tbody>
		<?php
			foreach ($object_choice as $key) {
				$owned = '';
				if(intval($key['actif'])==0){$flg_actif = "inactif";} else {$flg_actif="";}
				if(intval($key['owned'])==0){$owned = "not_owned";}
				if($key['objmois']==0)
					{$parution=$key['objannee'];}
				else
					{$parution=$key['objmois'].'-'.$key['objannee'];}
				if($key['objprix']==-2){$prix='Ni vendu ni offert';}
				else if($key['objprix']==-1){$prix='Inconnu';}
				else if($key['objprix']==0){$prix='Offert';}
				else $prix=$key['objprix'];
				if(strlen($key['objrangement'])==0 && $key['owned']==1){$rangement = 'pas_range';}
				else if (strpos($key['objrangement'],'attente')!==false ) {$rangement='attente';}
				else {$rangement='';}
				?>

				<tr>
					<td class="<?php  echo $flg_actif; ?> center"><?php echo $key['typecode']?></td>
					<td class="<?php  echo $owned; ?> center"><?php echo $key['objid']   ?></td>
					<td class=""><a href="/admin/object_update/<?php echo $key['objid']   ?>"><?php echo $key['objnom']?></a></td>
					<td class="center"><a href="<?php echo WEBROOT.'admin/object_add/'.$key['objid']?>"><i class="material-icons">content_copy</i></a></td>
					<td class="center"><?php echo $key['nbimg'] ?></td>
					<td class="center"><?php echo $key['nbpers'] ?></td>
					<td class="center"><?php echo $key['objpoids'] ?></td>
					<td class="center"><?php echo $key['objtaille']   ?></td>
					<td class="center"><?php echo $prix ?></td>
					<td class="center"><?php echo $key['objref'] ?></td>
					<td class="center"><?php echo $parution ?></td>
					<td class="<?php  echo $rangement; ?>"><?php echo $key['objrangement'] ?></td>
				</tr>
			<?php }?>
			<!-- Fin des lignes du tableau -->
			</tbody>
	</table>
</div>
