<?php

$css_loading = "
<link href=\"".DIR_CSS."add_information.css\" rel=\"stylesheet\">
<link href=\"".DIR_CSS."admin.css\" rel=\"stylesheet\">
";

ob_start();
?>

<?php if ($affichage == 1) { ?>

<div class="myRow flex-center" >
	<h1 class="page_title flex-center"><?php echo $$page_title ?></h1>
</div>
<div class="myRow flex-center" id="insert">
    <div class="myCol-40 myCol  actual_object">
        <img class="myThumb" src="<?php echo $objimg; ?>" alt="">
        <p>Nom de la figurine: <?php echo $objnom; ?></p>
        <p>Editeur : <?php echo $edinom; ?></p>
        <p>Série : <?php echo $sernom; ?></p>
        <p>Taille : <?php echo $objtaille; ?> cm</p>
        <p>Prix : <?php echo $objprix; ?></p>
        <p>Ref : <?php echo $objref; ?></p>
        <p>Description : <br> <?php echo $objdesc; ?></p>

    </div>

        <form class="myCol-40 myCol form-group-vertical adminForm" action="" enctype="multipart/form-data" method="post">
            <h4>
            - Ecrivez les modifications que vous souhaitez apporter à cette fiche.<br>
            - Vous pouvez aussi joindre des documents.
            </h4>
            <label for="message">Message :</label>
            <textarea name="message" rows="8" cols="" required></textarea>
            <label for="files">Ajouter des documents</label>
            <input type="file" name="files[]" value="" multiple>
            <button type="submit" name="action" value="send_message" id="submit" >Poster mes propositions</button>
        </form>

</div>
<script type="text/javascript">
    var btn = document.getElementById('submit');
    btn.addEventListener('click',function(e){
		var insert = document.getElementById('insert');
        var div = document.createElement("div");
		var p1 = document.createElement("p");
		var p2 = document.createElement("p");
		p1.innerHTML = "Veuillez patienter pendant le chargement des fichiers";
        div.classList.add("waiting");
		var img = document.createElement('img');
		img.src = "/public/images/elements/LOADER.GIF";
		p2.appendChild(img);
		div.appendChild(p1);
		div.appendChild(p2);
        insert.appendChild(div);
        }
    )
</script>

<?php } if($affichage==2)  {  ?>

    <div class="myRow flex-center">
    	<a class="link_back_home" href="<?php echo WEBROOT.$page_home;?>">RETOUR A L'ACCUEIL</a>
    </div>

<?php }  ?>

<?php
$content = ob_get_clean();

require_once DIR_TEMPLATES.$tmpl_main;

?>
