class LightboxImage {

    constructor(url){
     this.url = url
     this.objid = parseInt(this.url.parentElement.parentElement.getAttribute('id'))
     this.order = parseInt("1")
     this.last = parseInt(this.url.getAttribute('data-badge'))
     this.element = this.buildDOM(url)
     this.loadImage(url)
     document.body.appendChild(this.element)
     if(this.last ==1){document.querySelector('.lightbox_next').setAttribute('hidden','')}

    }

    loadImage(url){
     const image = new Image();
     const container = this.element.querySelector('.lightbox_container')
     image.onload = function(){
       container.appendChild(image)
     }
     image.src = url

    }

    buildDOM(url){
     const dom = document.createElement('div')
     dom.classList.add('lightbox')
     dom.innerHTML=`
            <button class="lightbox_next" >Suivant</button>
            <button class="lightbox_prev" hidden>Précédent</button>
            <button class="lightbox_close">Fermer</button>
            <div class="lightbox_container">
            </div>`
    dom.querySelector('.lightbox_close').addEventListener('click',this.close.bind(this))
    dom.querySelector('.lightbox_next' ).addEventListener('click',this.next.bind(this))
    dom.querySelector('.lightbox_prev' ).addEventListener('click',this.prev.bind(this))
    return dom
    }

    close(e){
     e.preventDefault()
     this.element.classList.add('fadeOut')
     window.setTimeout(()=>{
       this.element.parentElement.removeChild(this.element)
     },500)
    }

    next(e){
        e.preventDefault()
        var img = this.element.querySelector('.lightbox_container>img')
                document.querySelector('.lightbox_prev').removeAttribute('hidden')
        var httpRequest = new XMLHttpRequest();
        this.order = this.order + 1
        var ajaxUrl = '/ajax/get_object_image/'+ this.objid + '/'+ this.order;
        if (!httpRequest) {
            alert('Abandon :( Impossible de créer une instance de XMLHTTP');
            return false;
        }
        httpRequest.open('GET', ajaxUrl);
        httpRequest.send();
        httpRequest.onreadystatechange =  function(){
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                    img.src = "/public/images/objects/" + JSON.parse(httpRequest.responseText)[0]["imgfile"]
                }
                else {
                    alert('Il y a eu un problème avec la requête.');
                }
            }
        }
        if(this.last == this.order ){document.querySelector('.lightbox_next').setAttribute('hidden','')}
    }

    prev(e){
        e.preventDefault()
        var img = this.element.querySelector('.lightbox_container>img')
        document.querySelector('.lightbox_next').removeAttribute('hidden')
        var httpRequest = new XMLHttpRequest();
        this.order = this.order - 1
        var ajaxUrl = '/ajax/get_object_image/'+ this.objid + '/'+ this.order;
        if (!httpRequest) {
            alert('Abandon :( Impossible de créer une instance de XMLHTTP');
            return false;
        }
        httpRequest.open('GET', ajaxUrl);
        httpRequest.send();
        httpRequest.onreadystatechange =  function(){
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                    img.src = "/public/images/objects/" + JSON.parse(httpRequest.responseText)[0]["imgfile"]
                }
                else {
                    alert('Il y a eu un problème avec la requête.');
                }
            }
        }
        if(this.order == 1 ){document.querySelector('.lightbox_prev').setAttribute('hidden','')}
    }



    }





// Listener pour lightbox image
document.querySelectorAll('a[href$=".JPG"]','a[href$=".PNG"]')
  .forEach( link => link.addEventListener('click', e=>
  {
  e.preventDefault()
  new LightboxImage(e.currentTarget)
}))
