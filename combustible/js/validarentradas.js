  function validarKilometrosFinales(numero){
   //  var kilo = "<?php echo $kilo;?>";
   //var n =$(this).find("motivo").text();
   
  // alert(numero);
  
   var btnEnviar = document.getElementById('boton_s_t');
   var kmInicial = $('#km_inicial').val();
  // document.getElementById('boton_s_t').disabled=true;
  
     /*
    if (!/^([0-9]).*$/.test(numero) )  {
      alert("El valor " + numero + " no es un numero");
      //
       btnEnviar.disabled = false;
      //
  }
         else if(numero < kmInicial ){
           
           alert("El kilometraje " + numero + " es menor a kilometraje inical:" + " " +kmInicial+ " " + "Verificar valor no se procesara ingreso");
        btnEnviar.disabled = false
       } 
         else if(numero > kmInicial ){
           
           alert("El kilometraje " + numero + " es mayor a kilometraje inical:" + " " +kmInicial+ " " + "Validos");
        btnEnviar.disabled = true;
       } 
   else if(numero === "" ){
           
           alert("la casilla esta vacia debe colocar un O ó el valor su factura");
           btnEnviar.disabled = false;
       }
       
       */
      
      
       
        if(parseInt(numero) < parseInt(kmInicial)){
           
           alert("El kilometraje " + numero + " es menor a kilometraje inical:" + " " +kmInicial+ " " + "Verificar valor no se procesara ingreso");
        btnEnviar.disabled = true;
        
        
       } 
       
       
      else if(numero == null ){
           
           alert("El kilometraje " + numero + " so procesan valores vacio:" + " " +kmInicial+ " " + "no se procesara");
        btnEnviar.disabled = true;
        
        
       } 
      else if (parseInt(numero) > parseInt(kmInicial) )
        btnEnviar.disabled = false;
        alert("validos");
       
  }
