 function validarDesayunos(numero){
    if (!/^([0-9]).*$/.test(numero) )  {
      alert("El valor " + numero + " no es un numero");
  }
         if(numero > 63 ){
           
           alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
          
       } 
   if(numero === "" ){
           
           alert("la casilla esta vacia debe colocar un O Ã³ el valor su factura");
          
       }
      
  }
  
  function validarpordia1(numero){
     
	 let numero1 = parseFloat(document.getElementById('des').value);
     let numero2 = parseFloat(document.getElementById('alm').value);
	 let numero3 = parseFloat(document.getElementById('cen').value);
	
	
    // Verificamos que los valores sean números
    if (isNaN(numero1) || isNaN(numero2) || isNaN(numero3) ) {
      swal("error ", "ingresar solo valores numericos, o ingresar un 0 porque el campo no  puede estar vacio" , "error");
	 //  alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
        return;
    }

    // Realizamos la suma
    let resultado1 = numero1 + numero2 + numero3;
	//let resultado2 = numero4 + numero5 + numero6;
	//console.log(resultado2);
	  
	  
		//º  let salida = parseFloat(document.getElementById('total').value);
	//	var total_solicitado= total1+total2+total3+total4;
		//console.log(salida);
		
		let t1 = 210;
		
		
		 if(resultado1 > t1 ){
            // swal("error ", " los valores sobrepasan al monto de meriendas  " + t1 , "error");
			 // alert("La suma de los valores ingresados en desayuno1, almuerzo y cena1 " + resultado1 + " sobrepasa el valor maximo permitido que es de Q 210");
			 swal("error ", "La suma de los valores ingresados en desayuno 1, almuerzo 1 y cena 1 sobrepasa al monto autorizado que es de Q210 verificar la sumatoria de:Q" + resultado1  , "error");
      boton_s_t.disabled = true;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
		} else{  
		boton_s_t.disabled = false;
		      }
		
		//		else if(resultado2 <= t1 ){
        //      alert("La suma de los valores ingresados enwww desayuno1, almuerzo y cena1 " + resultado2 + " sobrepasa el valor maximo permitido que es de Q 210");
      // boton_s_t.disabled = false;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
	//	} 
		
		
      
  }
  
  
  
  
  function validarpordia2(numero){
     
	
	 
	 // siguinete columna dia 2
	 
	 let numero4 = parseFloat(document.getElementById('des2').value);
     let numero5 = parseFloat(document.getElementById('alm2').value);
	 let numero6 = parseFloat(document.getElementById('cen2').value);
	 
	 
    // Verificamos que los valores sean números
    if (isNaN(numero4) || isNaN(numero5) || isNaN(numero6) ) {
      //swal("error ", "ingresar solo valores numericos, o ingresar un 0 porque el campo no  puede estar vacio" , "error");
	  swal("error ", "La suma de los valores ingresados en desayuno 2, almuerzo 2 y cena 2 sobrepasa al monto autorizado que es de Q210 verificar la sumatoria de:Q" + resultado1  , "error");
	 //  alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
        return;
    }

	let resultado2 = numero4 + numero5 + numero6;
	
		let t1 = 210;
		
		
		 if(resultado2 > t1 ){
            // swal("error ", " los valores sobrepasan al monto de meriendas  " + t1 , "error");
			  alert("La suma de los valores ingresados en desayuno 2, almuerzo 2 y cena 2 " + resultado2 + " sobrepasa el valor maximo permitido que es de Q 210");
      boton_s_t.disabled = true;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
				} else{  
		boton_s_t.disabled = false;
		      }
		
		
		
		//		else if(resultado2 <= t1 ){
        //      alert("La suma de los valores ingresados enwww desayuno1, almuerzo y cena1 " + resultado2 + " sobrepasa el valor maximo permitido que es de Q 210");
      // boton_s_t.disabled = false;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
	//	} 
		
		
      
  }
  
  
  function validarpordia3(numero){
     
	
	 
	 // siguinete columna dia 2
	 
	 let numero7 = parseFloat(document.getElementById('des3').value);
     let numero8 = parseFloat(document.getElementById('alm3').value);
	 let numero9 = parseFloat(document.getElementById('cen3').value);
	 
	 
    // Verificamos que los valores sean números
    if (isNaN(numero7) || isNaN(numero8) || isNaN(numero9) ) {
    //  swal("error ", "ingresar solo valores numericos, o ingresar un 0 porque el campo no  puede estar vacio" , "error");
	 swal("error ", "La suma de los valores ingresados en desayuno 3, almuerzo 3 y cena 3 sobrepasa al monto autorizado que es de Q210 verificar la sumatoria de:Q" + resultado1  , "error");
	 //  alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
        return;
    }

	let resultado3 = numero7 + numero8 + numero9;
	
		let t1 = 210;
		
		
		 if(resultado3 > t1 ){
            // swal("error ", " los valores sobrepasan al monto de meriendas  " + t1 , "error");
			  alert("La suma de los valores ingresados en desayuno 3, almuerzo 3 y cena 3 " + resultado3 + " sobrepasa el valor maximo permitido que es de Q 210");
       boton_s_t.disabled = true;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
				} else{  
		boton_s_t.disabled = false;
		      }
		
		//		else if(resultado2 <= t1 ){
        //      alert("La suma de los valores ingresados enwww desayuno1, almuerzo y cena1 " + resultado2 + " sobrepasa el valor maximo permitido que es de Q 210");
      // boton_s_t.disabled = false;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
	//	} 
		
		
      
  }
  
  
    function validarpordia4(numero){
     
	
	 
	 // siguinete columna dia 4
	 
	 let numero10 = parseFloat(document.getElementById('des4').value);
     let numero11 = parseFloat(document.getElementById('alm4').value);
	 let numero12 = parseFloat(document.getElementById('cen4').value);
	 
	 
    // Verificamos que los valores sean números
    if (isNaN(numero10) || isNaN(numero11) || isNaN(numero12) ) {
    //  swal("error ", "ingresar solo valores numericos, o ingresar un 0 porque el campo no  puede estar vacio" , "error");
	 swal("error ", "La suma de los valores ingresados en desayuno 4, almuerzo 4 y cena 4 sobrepasa al monto autorizado que es de Q210 verificar la sumatoria de:Q" + resultado1  , "error");
	 //  alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
        return;
    }

	let resultado4 = numero10 + numero11 + numero12;
	
		let t1 = 210;
		
		
		 if(resultado4 > t1 ){
            // swal("error ", " los valores sobrepasan al monto de meriendas  " + t1 , "error");
			  alert("La suma de los valores ingresados en desayuno 4, almuerzo 4 y cena 4 " + resultado4 + " sobrepasa el valor maximo permitido que es de Q 210");
       boton_s_t.disabled = true;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
				} else{  
		boton_s_t.disabled = false;
		      }
		
		//		else if(resultado2 <= t1 ){
        //      alert("La suma de los valores ingresados enwww desayuno1, almuerzo y cena1 " + resultado2 + " sobrepasa el valor maximo permitido que es de Q 210");
      // boton_s_t.disabled = false;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
	//	} 
		
		
      
  }
  
  
   function validarpordia5(numero){
     
	
	 
	 // siguinete columna dia 2
	 
	 let numero13 = parseFloat(document.getElementById('des5').value);
     let numero14 = parseFloat(document.getElementById('alm5').value);
	 let numero15 = parseFloat(document.getElementById('cen5').value);
	 
	 
	     // Verificamos que los valores sean números
    if (isNaN(numero13) || isNaN(numero14) || isNaN(numero15) ) {
      swal("error ", "ingresar solo valores numericos, o ingresar un 0 porque el campo no  puede estar vacio" , "error");
	 //  alert("El valor " + numero + " sobrepasa el valor maximo permitido en desayunos y Cenas que es de Q 63.00");
        return;
    }

	let resultado5 = numero13 + numero14 + numero15;
	
		let t1 = 210;
		
		
		 if(resultado5 > t1 ){
            // swal("error ", " los valores sobrepasan al monto de meriendas  " + t1 , "error");
			  //alert("La suma de los valores ingresados en desayuno 5, almuerzo 5 y cena 5 " + resultado5 + " sobrepasa el valor maximo permitido que es de Q 210");
			   swal("error ", "La suma de los valores ingresados en desayuno 5, almuerzo 5 y cena 5 sobrepasa al monto autorizado que es de Q210 verificar la sumatoria de:Q" + resultado1  , "error");
       boton_s_t.disabled = true;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
				} else{  
		boton_s_t.disabled = false;
		      }
		
		//		else if(resultado2 <= t1 ){
        //      alert("La suma de los valores ingresados enwww desayuno1, almuerzo y cena1 " + resultado2 + " sobrepasa el valor maximo permitido que es de Q 210");
      // boton_s_t.disabled = false;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
	//	} 
		
		
      
  }
  
  
  
  
   function validarAlmuerzo(numero2){
    if (!/^([0-9]).*$/.test(numero2) )  {
      alert("El valor " + numero2 + " no es un número");
  }
         if(numero2 > 84 ){
           
           alert("El valor " + numero2 + " sobrepasa el valor maximo permitido en Almuersos que es de Q 84.00");
          
       } 
   if(numero2 === "" ){
           
           alert("la casilla esta vacia debe colocar un O Ã³ el valor su factura");
          
       }
      
  }

  
  
  function validarCenas(numero1){
    if (!/^([0-9]).*$/.test(numero1) )  {
      alert("El valor " + numero1 + " no es un número");
  }
         if(numero1 > 63 ){
           
           alert("El valor " + numero1 + " sobrepasa el valor maximo permitido en Cenas que es de Q 63.00");
          
       } 
   if(numero1 === "" ){
           
           alert("la casilla esta vacia debe colocar un O Ã³ el valor su factura");
          
       }
      
  }

function validarHospedajes(numero22){
    if (!/^([0-9]).*$/.test(numero22) )  {
      alert("El valor " + numero22 + " no es un número");
  }
         if(numero22 > 210 ){
           
           alert("El valor  Q" + numero22 + " sobrepasa el valor maximo permitido en Hospedaje que es de Q 210.00");

          
       } 
   if(numero22 === "" ){
           
           alert("la casilla esta vacia debe colocar un O Ã³ el valor su factura");//
          
       }
      
  }
  
  /*
function validarTotales(numero222){
	 
		 
	 var salida=$('#total').val();
	 
	 console.log(salida);
    if (!/^([0-9]).*$/.test(numero222) )  {
      alert("El valor " + numero222 + " no es un número");
  }
         if(numero222 > salida ){
           
           alert("El valor  Q" + numero222 + " sobrepasa el valor maximo solicitado:");
          
       } 
   if(numero222 === "" ){
           
           alert("la casilla esta vacia debe colocar un O Ã³ el valor su factura");//
          
       }
      
  }*/
  
   function validarTotales(numero222){
      
	  
	  
	 let numero1 = parseFloat(document.getElementById('dest').value);
     let numero2 = parseFloat(document.getElementById('almt').value);
	 let numero3 = parseFloat(document.getElementById('cent').value);
	 let numero4 = parseFloat(document.getElementById('host').value);
    
    // Verificamos que los valores sean números
    if (isNaN(numero1) || isNaN(numero2) || isNaN(numero3) || isNaN(numero4)) {
      swal("error ", "ingresar solo valores numericos, o ingresar un 0 porque el campo no  puede estar vacio" , "error");
        return;
    }

    // Realizamos la suma
    let resultado = numero1 + numero2 + numero3 + numero4;
	  
	  
		  let salida = parseFloat(document.getElementById('total').value);
		  document.getElementById('totalgt').value = resultado;
		  
		   let salida2 = parseFloat(document.getElementById('totalgt').value);
	//	var total_solicitado= total1+total2+total3+total4;
		//console.log(salida);
		
		/*
		 if(salida2 > salida ){
             swal("error ", " los valores sobrepasan al monto solicitud de viaticos  " + salida , "error");
       boton_s_t.disabled = true;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
		} 
		
				 if(salida2 <= salida ){
             swal("info", " los valores ingresados NO sobrepasan el total solicitado: " + salida + " puede continuar puede continuar liquidando", "info");
       boton_s_t.disabled = false;
       
		// alert("los valores sobrepasan al monto solicitud de viaticos:"+ salida);
		} */
		
		// script.js
		
		
		 
/*
// Declaramos una variable en JavaScript
let miVariable = "Hola, esto es un valor desde JavaScript";

// Esperamos a que el DOM se cargue completamente
window.onload = function() {
    // Seleccionamos el elemento HTML por su ID
    let variableElement = document.getElementById('variable');
    
    // Asignamos el valor de la variable al elemento HTML
    variableElement.textContent = miVariable;
};*/
		
   }
  
     function validar(){
		 
		 $(document).ready(function() {
            $('#btn-Delete').click(function() {
                $('#SolicitudForm').val('');
            });
        }); 
		
        }
 