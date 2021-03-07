function createThumbnail(sFile,sId) {
  var oReader = new FileReader();
  oReader.addEventListener('load', function() {
    var oImgElement = document.createElement('img');
    oImgElement.classList.add('imgPreview')
    oImgElement.src = this.result;
    document.getElementById('preview').appendChild(oImgElement);
  }, false);

  oReader.readAsDataURL(sFile);

}//function
function changeInputFil(oEvent){
  var oInputFile = oEvent.currentTarget,
      sName = oInputFile.name,
      aFiles = oInputFile.files,
      aAllowedTypes = ['png', 'jpg', 'jpeg', 'gif'],
      imgType;
  document.getElementById('preview').innerHTML ='';
  for (var i = 0 ; i < aFiles.length ; i++) {
    imgType = aFiles[i].name.split('.');
    imgType = imgType[imgType.length - 1];
    if(aAllowedTypes.indexOf(imgType) != -1) {
      createThumbnail(aFiles[i],sName);
    }//if
  }//for
}//function

document.addEventListener('DOMContentLoaded',function(){
 var aFileInput = document.forms['myForm'].querySelectorAll('[type=file]');
  for(var k = 0; k < aFileInput.length;k++){
    aFileInput[k].addEventListener('change', changeInputFil, false);
  }//for
});
