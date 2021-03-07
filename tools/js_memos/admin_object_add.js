<script>
	var httpRequest;

	document.getElementById("ediid").onchange = updateSerid;

	function updateSerid() {
		httpRequest = new XMLHttpRequest();
    var url = '/ajax/series_of_editor/'+ this.value;
			if (!httpRequest) {
				alert('Abandon :( Impossible de créer une instance de XMLHTTP');
				return false;
			}
		httpRequest.onreadystatechange = hydrateSerid;
		httpRequest.open('GET', url);
		httpRequest.send();
	}

	function hydrateSerid(){
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status === 200) {
				//Récupére le json retourné par ajax et le parse en objet
				var j = JSON.parse(httpRequest.responseText);
				var sel = document.getElementById("serid");
				var lg = sel.length;
				for (var i = 1; i < lg; i++) {
					sel.remove(1);
				}
				for (var i = 0; i<j.length; i++) {
					sel.options[sel.options.length] = new Option (j[i]["sernom"], j[i]["serid"]);
				}
			}
			else {
				alert('Il y a eu un problème avec la requête.');
			}
		}
	}

	











</script>
