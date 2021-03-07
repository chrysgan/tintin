var description;
// Get the modal information
var modal = document.getElementById("ModalObjectInformation");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("modal_close_object_information")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }


// Listener pour les informations objets
document.querySelectorAll('.display-info')
 .forEach( link => link.addEventListener('click', e=>
   {
     description=""
     e.preventDefault()
     var objid = e.currentTarget.parentElement.parentElement.parentElement.getAttribute('id')
     var modalContent = document.getElementById("modal-text-content")
     var httpRequest = new XMLHttpRequest();
     var ajaxUrl = '/ajax/get_object_desc/'+ objid;
		 if (!httpRequest) {
   				alert('Abandon :( Impossible de créer une instance de XMLHTTP');
   				return false;
		}
 		httpRequest.open('GET', ajaxUrl);
 		httpRequest.send();
    httpRequest.onreadystatechange =  function(){
      if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
          //Récupére le json retourné par ajax et le parser
          // compter le nb de ligne retourner
          var nbPers = JSON.parse(httpRequest.responseText).length;
          description = JSON.parse(httpRequest.responseText)[0]["objdesc"];

          description = description.replace(/\r\n/g, '<br>');
          modalContent.innerHTML = description;
        }
        else {
          alert('Il y a eu un problème avec la requête.');
        }
      }
    }
    modal.style.display = "block";
   }))
