                  function HTMLtoPDFV13(solicitud){
	$.ajax({
    type: "POST",
    url: "viaticos/php/hoja_liquidacion.php",
    data: {solicitud:solicitud}, //f de fecha y u de estado.
  dataType:'json',

//destino
   beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){


	var doc = new jsPDF();
        
        var logo1 = new Image();
        logo1.src = 'assets/img/liquidacion.jpeg';
	   doc.addImage(logo1, 'jpeg', 9, 6, 200, 260);

		 doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);

	   //doc.text(33, 50, 'BOLETA DE SOLICITUD Y AUTORIZACIÓN DE VEH�?CULO PARA COMISIONES');

		 doc.setFontSize(12.5);
		// doc.writeText(0, 65 ,'SOLICITUD DE VIATICOS 6',{align:'center',width:211});
		 doc.setFontSize("8");
                  doc.text(180, 36, data.id1);
                  doc.writeText(174, 36 ,'No.');
                    doc.text(175, 44, data.Total);
                    
                    
                     doc.writeText(49, 58 ,'SECRETARIA CONTRA LA VIOLENCIA SEXUAL, EXPLOTACION Y TRATA DE PERSONAS.');
            var p_lineas2 = doc.splitTextToSize(data.obj, 60);

		 doc.text(15, 94, p_lineas2); 
		// doc.text(25, 80, 'Nombramiento :');
		 //doc.text(25, 86, 'Autorizado :');
                 
                  //doc.text(69, 79, data.lugar1);
                   var p_lineas5 = doc.splitTextToSize(data.lugar1, 38);

		 doc.text(76, 94, p_lineas5); 
                  
                  
                  
                  
                  
                   doc.text(119, 94, data.Total2);

		// doc.text(25, 92, 'Dep.(s) :');
		// doc.text(25, 98, 'Solicitante :');

		 doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
		 //doc.text(55, 80,  data.correlativo);  
                // doc.text(95, 80,  data.descripcion2);
		// doc.text(35, 36, data.autorizado);
                 //doc.text(100, 86, data.autorizado2);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 115);
               // doc.text(80, 215,  data.correlativo);
               // doc.text(173, 79,  data.desa);
                //doc.text(173, 85,  data.almu);
               
                //doc.text(173, 91,  data.cena);
                //doc.text(173, 97,  data.hosp);//tgas
                 //doc.text(173, 106,  data.tgas);
                  doc.writeText(145, 94 ,'420.00');
                 doc.text(173, 94,  data.Total);  //tgas
                  doc.text(173, 140, '00.00');  //total
                   doc.text(173, 148,'00.00'); //modificado doc.text(173, 149,  data.reitegro); //modificado
                     doc.writeText(173, 155 ,data.tgas);//tgas
                   doc.text(173, 162, data.tgas);  //destino2
                  //doc.text(193, 146, data.resu);
                  //resu
                  //
                   var a= data.Total;
                  var b=a.toString(10);
                  var res= NumeroALetras(b);
                  
                  doc.text(67, 67,res );
                  
                 // var n1= data.tgas;
             //   var n = doc.write(data.Total);
               //    var n2 = doc.write(data.tgas);
                 //  var r = n-n2;
		// doc.text(55, 92, p_lineas1);
                
                //doc.text(173, 150, r);
		 doc.text(31, 185, data.autorizado2);
                 doc.text(31, 216, data.puesto);
				  //doc.writeText(161, 220 ,'NIT:');
                   doc.text(171, 216, data.nit);
                  
                  
                   doc.text(140, 232, data.autorizado);
                    doc.text(140, 238, data.puesto2);
                     doc.writeText(0, 170 ,'Guatemala,'+data.fechaf,{align:'center',width:190});
                // doc.text(35, 155, data.puesto);

		 doc.setFontSize("8");


		// doc.writeText(0, 10 ,'Fecha y hora en la que se creó la solicitud: '+data.fecha_creacion,{align:'right',width:190});


		// doc.setDrawColor(0, 136, 176);
		// doc.setFillColor(0, 136, 176);
		// doc.roundedRect(25, 105, 165, 8, 1, 1,'FD');
		 /*doc.roundedRect(25, 115, 165, 15, 1, 1,'FD');
		 doc.roundedRect(25, 132, 165, 15, 1, 1,'FD');*/
		 doc.setTextColor(255, 255, 255);
		 doc.setFontType("normal");
		 doc.setFontSize("10");


		// doc.text(30, 110, 'Fecha Inicio :');
		// doc.text(72, 110, 'Fecha Fin :');
		// doc.text(109, 110, 'Lugar :');
		// doc.text(165, 110, 'Monto :');



		 doc.setFontType("bold");
		// doc.text(51, 110, data.fecha); //append email id in pdf
		 //doc.text(90, 110, data.fecha2);
		 //doc.text(136, 110, data.duracion);
                 //doc.text(120, 110, data.lugar1);
		 //doc.text(178, 110, data.Total);
                

		 doc.setDrawColor(98, 98,98);

		 doc.setFontType("normal");
		 var p1=140;
		 var titulo= "";


     doc.setTextColor(68, 68, 68);
     doc.setFontSize("9");
     doc.setFontType("bold");
    // doc.text(178, 115, data.personas);
    // doc.text(25, 123, 'Objetivo de la comisión : ');
      doc.setFontSize("7");
     doc.setFontType("normal");
      //doc.text(25, 127, data.obj);
      
      
      ///
    //  var p_lineas2 = doc.splitTextToSize(data.obj, 170);

		// doc.text(25, 127, p_lineas2); 
      
      ///
      
		 doc.setFontSize(8);
     doc.setFontType("normal");
		 var p_lineas = doc.splitTextToSize(titulo, 155);
     doc.setTextColor(68, 68, 68);



//destino
     var string = titulo.replace(/f7/g,'\n\n');

     var lMargin=25; //left margin in mm
    var rMargin=25; //right margin in mm
    var pdfInMM=210;  // width of A4 in mm
		 var lines =doc.splitTextToSize(string, (pdfInMM-lMargin-rMargin));
     doc.text(lMargin,p1,lines);




		 //doc.line(36, 77, 203, 77);
		 //doc.line(34, 52, 203, 52);


		 //doc.text(120, 60, 'Fecha de la comisión');

		 doc.setFontSize(8);











		 doc.setTextColor(255, 255, 255);
		 doc.setFontType("bold");
		// var p_lineas2 = doc.splitTextToSize(data.destino, 145);
		// doc.text(45, 119, p_lineas2);

		// var p_lineas3 = doc.splitTextToSize(data.motivo, 145);
		// doc.text(45, 137, p_lineas3);
		 doc.setTextColor(68, 68, 68);



		  doc.setFontType("normal");

		// doc.line(36, 210, 100, 210);
		// doc.text(44, 214, 'Nombre y Firma del Solicitante');


		 //doc.line(112, 210, 180, 210);
		 //doc.text(126, 214, 'Jefe del Departamento');

		 doc.setFontSize("8");
		 doc.setFontType("bold");
		 //doc.text(25, 230, 'Observaciones:');

		 doc.setFontSize("7");
		 doc.setFontType("normal");
		// doc.text(25, 235, '1. Deberá presentar esta boleta a la Unidad de Transportes con un mínimo de 2 horas de anticipación:');
		// doc.text(25, 240, '2. En caso se cancele la comisión, deberá hacerlo de conocimiento de la Unidad de Transportes inmediatamente');



		doc.setFontSize("10");

		 doc.setFontType("bold");
		 //doc.line(25, 193, 190, 193);




	   /*doc.text(25, 205, 'PARA USO EXCLUSIVO DE TRANSPORTES');
		 doc.setFontType("normal");


		 doc.text(25, 215, 'Piloto Asignado :');
		 doc.text(25, 220, 'Vehículo Asignado :');

		 doc.text(83, 245, 'f) Unidad de Transportes');




		 doc.setFontSize("10");
		 doc.text(80, 215, data.piloto);
		 doc.text(80, 220, data.vehiculo);




		 //doc.line(52, 211, 190, 211);
		 //doc.line(58, 221, 190, 221);

		  doc.line(70, 240, 140, 240);*/





	   doc.setTextColor(255, 0, 0); //set font color to red
	   //doc.text(60, 20, document.getElementById("fname").value); //append first name in pdf
	   //doc.text(100, 20, document.getElementById("lname").value); //append last name in pdf
	   //doc.addPage(); // add new page in pdf
	   //doc.setTextColor(165, 0, 0);
	   //doc.text(10, 20, 'extra page to write');
		 doc.setFontSize(8);
		 doc.setTextColor(5, 83, 142);
		 //doc.writeText(0, 258 ,'Reporte Generado svetsis - Módulo control de viaticos',{align:'center',width:215});
		 //doc.addImage(footer, 'png', 0, 260, 216, 15);
	   doc.save('Solicitud - '+ data.correlativo +'.pdf'); // Save the PDF with name "katara"...

function Unidades(num){
 
  switch(num)
  {
    case 1: return "UN";
    case 2: return "DOS";
    case 3: return "TRES";
    case 4: return "CUATRO";
    case 5: return "CINCO";
    case 6: return "SEIS";
    case 7: return "SIETE";
    case 8: return "OCHO";
    case 9: return "NUEVE";
  }
 
  return "";
}
 
function Decenas(num){
 
  decena = Math.floor(num/10);
  unidad = num - (decena * 10);
 
  switch(decena)
  {
    case 1:
      switch(unidad)
      {
        case 0: return "DIEZ";
        case 1: return "ONCE";
        case 2: return "DOCE";
        case 3: return "TRECE";
        case 4: return "CATORCE";
        case 5: return "QUINCE";
        default: return "DIECI" + Unidades(unidad);
      }
    case 2:
      switch(unidad)
      {
        case 0: return "VEINTE";
        default: return "VEINTI" + Unidades(unidad);
      }
    case 3: return DecenasY("TREINTA", unidad);
    case 4: return DecenasY("CUARENTA", unidad);
    case 5: return DecenasY("CINCUENTA", unidad);
    case 6: return DecenasY("SESENTA", unidad);
    case 7: return DecenasY("SETENTA", unidad);
    case 8: return DecenasY("OCHENTA", unidad);
    case 9: return DecenasY("NOVENTA", unidad);
    case 0: return Unidades(unidad);
  }
}//Unidades()
 
function DecenasY(strSin, numUnidades){
  if (numUnidades > 0)
    return strSin + " Y " + Unidades(numUnidades)
 
  return strSin;
}//DecenasY()
 
function Centenas(num){
 
  centenas = Math.floor(num / 100);
  decenas = num - (centenas * 100);
 
  switch(centenas)
  {
    case 1:
      if (decenas > 0)
        return "CIENTO " + Decenas(decenas);
      return "CIEN";
    case 2: return "DOSCIENTOS " + Decenas(decenas);
    case 3: return "TRESCIENTOS " + Decenas(decenas);
    case 4: return "CUATROCIENTOS " + Decenas(decenas);
    case 5: return "QUINIENTOS " + Decenas(decenas);
    case 6: return "SEISCIENTOS " + Decenas(decenas);
    case 7: return "SETECIENTOS " + Decenas(decenas);
    case 8: return "OCHOCIENTOS " + Decenas(decenas);
    case 9: return "NOVECIENTOS " + Decenas(decenas);
  }
 
  return Decenas(decenas);
}//Centenas()
 
function Seccion(num, divisor, strSingular, strPlural){
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)
 
  letras = "";
 
  if (cientos > 0)
    if (cientos > 1)
      letras = Centenas(cientos) + " " + strPlural;
    else
      letras = strSingular;
 
  if (resto > 0)
    letras += "";
 
  return letras;
}//Seccion()
 
function Miles(num){
  divisor = 1000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)
 
  strMiles = Seccion(num, divisor, "MIL", "MIL");
  strCentenas = Centenas(resto);
 
  if(strMiles == "")
    return strCentenas;
 
  return strMiles + " " + strCentenas;
 
  //return Seccion(num, divisor, "UN MIL", "MIL") + " " + Centenas(resto);
}//Miles()
 
function Millones(num){
  divisor = 1000000;
  cientos = Math.floor(num / divisor)
  resto = num - (cientos * divisor)
 
  strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
  strMiles = Miles(resto);
 
  if(strMillones == "")
    return strMiles;
 
  return strMillones + " " + strMiles;
 
  //return Seccion(num, divisor, "UN MILLON", "MILLONES") + " " + Miles(resto);
}//Millones()
 
function NumeroALetras(num,centavos){
  var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    letrasCentavos: "",
  };
  if(centavos == undefined || centavos==false) {
    data.letrasMonedaPlural="";
    data.letrasMonedaSingular="";
  }else{
    data.letrasMonedaPlural="CENTIMOS";
    data.letrasMonedaSingular="CENTIMO";
  }
 
  if (data.centavos > 0)
    data.letrasCentavos = "CON " + NumeroALetras(data.centavos,true);
 
  if(data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
  if (data.enteros == 1)
    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
  else
    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
}//NumeroALetras()




	 }


}).done( function(data) {
}).fail( function( jqXHR, textSttus, errorThrown){

alert(errorThrown);

});
}


/*

function HTMLtoPDF(){
var pdf = new jsPDF('p', 'pt', 'letter');
source = $('#HTMLtoPDF')[0];
specialElementHandlers = {
	'#bypassme': function(element, renderer){
		return true
	}
}
margins = {
    top: 50,
    left: 60,
    width: 545
  };
pdf.fromHTML(
  	source // HTML string or DOM elem ref.
  	, margins.left // x coord
  	, margins.top // y coord
  	, {
  		'width': margins.width // max width of content on PDF
  		, 'elementHandlers': specialElementHandlers
  	},
  	function (dispose) {
  	  // dispose: object with X, Y of the last line add to the PDF
  	  //          this allow the insertion of new lines after html
        pdf.save('html2pdf.pdf');
      }
  )
}
*/
