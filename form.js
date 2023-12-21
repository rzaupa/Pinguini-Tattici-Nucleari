function createErrorFunction (regex, msg){
  return function () {
  const classname = "errorSuggestion";
    const padre = this.parentNode;
    Object.values(padre.children)
      .filter( (e) => e.classList.contains(classname))
      .forEach( (e) => padre.removeChild(e));

    if(this.value.search(regex) != 0){
      showError(this,msg);
      this.focus();
      this.select();
      return false;
    }
    return true;
  }
}

function caricamento(){
  document.getElementById("titolo").onblur = createErrorFunction(/^.{3}$/,"Almeno 3 caratteri");
  document.getElementById("durata").onblur = createErrorFunction(/^0\d:[0-5]\d$/,"Il formato deve essere 分分:秒秒");
  document.getElementById("dataRadio").onblur =  createErrorFunction(/^\d{4}-\d{2}-\d{2}$/,"Il formato deve essere AAAA-MM-DD");
  document.getElementById("urlVideo").onblur =  function () {
    try{
      new URL(this.value);
      return true;
    }catch (err){
      showError(this,"Url Invalido");
      this.focus();
      this.select();
      return false;
    }
  }

}

function validateForm(){
//  return [
//    document.getElementByI("titolo"),
//    document.getElementByI("durata"),
//    document.getElementByI("dataRadio"),
//    document.getElementByI("urlVideo"),
//  ].map(
//      funciton (elem){
//        return elem.onblur();
//      }
//    ).reduce(
//      ((a,b) => a && b),
//      document.getElementByI("rYes").checked || document.getElementByI("rNo").checked
//    );
}

function showError(elem, msg){
  const classname = "errorSuggestion";
  const padre = elem.parentNode;

  const errore = document.createElement("strong");
  errore.classList.add(classname);
  errore.innerHTML = msg;
  padre.appendChild(errore);
}
