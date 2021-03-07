const allStars = document.querySelectorAll(".stars");

init();

function init() {
    allStars.forEach(star=>{
        star.addEventListener("click", setRated);
        star.addEventListener("mouseover", addCSS);
        star.addEventListener("mouseleave", removeCSS);

    })
}


function setRated(e){
    e.preventDefault();
    // console.log(e.target);
    // console.dir(e.target.nodeName);
    const overedStars = e.target;
    overedStars.classList.add("rated");
    const previousSiblings = getPreviousSiblings(overedStars);
    previousSiblings.forEach(elem => elem.classList.add("rated"));
    const nextSiblings = getNextSiblings(overedStars);
    nextSiblings.forEach(elem => elem.classList.remove("rated"));
    var note = e.target.dataset.star;
    var objid = e.target.parentNode.parentNode.parentNode.id;
    var httpRequest = new XMLHttpRequest();
    var ajaxUrl = '/ajax/setRateId/'+ objid +'/'+ note;
    if (!httpRequest) {
        alert('Abandon :( Impossible de créer une instance de XMLHTTP');
        return false;
    }
    httpRequest.open('GET', ajaxUrl);
    httpRequest.send();
    httpRequest.onreadystatechange =  function(){
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                var nb = parseInt(JSON.parse(httpRequest.responseText)[0]['note_moyenne']);
                if(nb>0){
                    e.target.parentNode.parentNode.parentNode.firstElementChild.firstElementChild.childNodes[3].removeAttribute("hidden");
                    e.target.parentNode.parentNode.parentNode.firstElementChild.firstElementChild.childNodes[5].innerHTML = nb;
                    e.target.parentNode.parentNode.parentNode.firstElementChild.firstElementChild.childNodes[5].style.display = "block";
                }

            }
        }
    }
}

function addCSS(e, css="checked"){
    const overedStars = e.target;
    overedStars.classList.add(css);
    const previousSiblings = getPreviousSiblings(overedStars);
    previousSiblings.forEach(elem => elem.classList.add(css));

}

function removeCSS(e){
    const overedStars = e.target;
    overedStars.classList.remove("checked");
    const previousSiblings = getPreviousSiblings(overedStars);
    previousSiblings.forEach(elem => elem.classList.remove("checked"));
    // console.log("remove",previousSiblings);
}

function getPreviousSiblings(elem){
    let siblings = [];
    const aNodeType = 1;
    while (elem = elem.previousSibling) {
        if(elem.nodeType === aNodeType){
            siblings = [elem, ...siblings];
        }
    }
    return siblings;
}
function getNextSiblings(elem){
    let siblings = [];
    const aNodeType = 1;
    while (elem = elem.nextSibling) {
        if(elem.nodeType === aNodeType){
            siblings = [elem, ...siblings];
        }
    }
    return siblings;
}
