 function validarDesayunos(numero){
    if (!/^([0-9]).*$/.test(numero) )  {
      alert("El valor " + numero + " no es un numero");
  }
         if(numero > 63 ){
           
           alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
          
       } 
   if(numero === "" ){
           
           alert("la casilla esta vacia debe colocar un O 贸 el valor su factura");
          
       }
      
  }
  
   function validarAlmuerzo(numero2){
    if (!/^([0-9]).*$/.test(numero2) )  {
      alert("El valor " + numero2 + " no es un n鷐ero");
  }
         if(numero2 > 84 ){
           
           alert("El valor " + numero2 + " sobrepasa el valor maximo permitido en Almuersos que es de Q 84.00");
          
       } 
   if(numero2 === "" ){
           
           alert("la casilla esta vacia debe colocar un O 贸 el valor su factura");
          
       }
      
  }

  
  
  function validarCenas(numero1){
    if (!/^([0-9]).*$/.test(numero1) )  {
      alert("El valor " + numero1 + " no es un n鷐ero");
  }
         if(numero1 > 63 ){
           
           alert("El valor " + numero1 + " sobrepasa el valor maximo permitido en Cenas que es de Q 63.00");
          
       } 
   if(numero1 === "" ){
           
           alert("la casilla esta vacia debe colocar un O 贸 el valor su factura");
          
       }
      
  }

function validarHospedajes(numero22){
    if (!/^([0-9]).*$/.test(numero22) )  {
      alert("El valor " + numero22 + " no es un n鷐ero");
  }
         if(numero22 > 210 ){
           
           alert("El valor  Q" + numero22 + " sobrepasa el valor maximo permitido en Hospedaje que es de Q 210.00");
          
       } 
   if(numero22 === "" ){
           
           alert("la casilla esta vacia debe colocar un O 贸 el valor su factura");
          
       }
      
  }
  
  function countChars(obj){
    var maxLength = 20;
    var strLength = obj.value.length;
    var charRemain = (maxLength - strLength);
    
    if(charRemain < 0){
        document.getElementById("objetivo").innerHTML = '<span style="color: red;">Has superado el l韒ite de '+maxLength+' caracteres</span>';
    }else{
        document.getElementById("objetivo").innerHTML = charRemain+' caracteres restantes';
    }
}
  
 