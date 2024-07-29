var list = document.getElementsByClassName("obj");

function add_information() {
    window.alert("Vous devez être connecté pour utiliser cette fonction.");
}

var i=0;
var len = list.length;

for (i = 0, len ; i < len; i++){
    list[i].prevent
    list[i].onclick = add_information;
}
