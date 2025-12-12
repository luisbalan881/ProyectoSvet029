  function validarKilometrosFinales(numero){
   //  var kilo = "<?php echo $kilo;?>";
   //var n =$(this).find("motivo").text();
   var btnEnviar = document.getElementById('boton_s_t');
   var kmInicial = $('#km_inicial').val();
  // document.getElementById('boton_s_t').disabled=true;
    if (!/^([0-9]).*$/.test(numero) )  {
      alert("El valor " + numero + " no es un numero");
      //
      
      //
  }
         if(numero < kmInicial ){
           
           alert("El kilometraje " + numero + " es menor a kilometraje inical:" + " " +kmInicial+ " " + "Verificar valor no se procesara ingreso");
       
       } 
   if(numero === "" ){
           
           alert("la casilla esta vacia debe colocar un O ó el valor su factura");
          
       }
       
       
        if(numero > kmInicial ){
               alert("datos validos");
          
        btnEnviar.disabled = false;
        }
      
       if(numero < kmInicial ){
               alert("datos no validos");
          
        btnEnviar.disabled = true;
        }
  }
