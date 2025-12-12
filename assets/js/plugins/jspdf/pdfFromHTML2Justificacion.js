                  function HTMLtoPDFVjustificacion(solicitud){
	$.ajax({
    type: "POST",
    url: "viaticos/php/hoja_solicitud2.php",
    data: {solicitud:solicitud}, //f de fecha y u de estado.
  dataType:'json',


    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){


	var doc = new jsPDF();
	   doc.addImage(logo, 'jpeg', 20, 15, 60, 35);

		 doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);

	   //doc.text(33, 50, 'BOLETA DE SOLICITUD Y AUTORIZACIÓN DE VEH�?CULO PARA COMISIONES');

		 doc.setFontSize(12.5);
		 doc.writeText(0, 55 ,'Ampliación de Nombramiento',{align:'center',width:211});
		 doc.setFontSize("10");
          doc.setFontType("normal");
		 doc.setFontSize("11");
		 doc.text(25, 61, 'Señor (a):');
		 doc.text(50, 64, data.autorizado2);
		 doc.text(25, 71, 'De manera atenta me dirijo a usted para, hacer de su conocimiento la ampliación ',{align:'justified',width:211});
		 doc.text(25, 75, 'del nombramiento ');
		 doc.text(113, 75, 'de fecha:');
		// doc.text(25, 86, 'Autorizado :');

		// doc.text(25, 92, 'Dep.(s) :');
		 
               //   doc.text(25, 104, 'Lugar(s) :');

		 doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
		 doc.text(59 , 75,  data.correlativo); 
         doc.text(130 , 75,  data.fecha1); 		 
                // doc.text(95, 80,  data.descripcion2);
		// doc.text(55, 86, data.autorizado);
                 //doc.text(100, 86, data.autorizado2);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 115);

		// doc.text(55, 92, p_lineas1);
		 
              //   doc.text(55, 104, data.lugar1);
                  // doc.text(95, 98, data.descripcion);

		 doc.setFontSize("8");


	//	doc.writeText(70, 80 ,'Fecha y hora en la que se creó la solicitud: '+data.fecha_creacion,{align:'right',width:211});


	//	 doc.setDrawColor(0, 136, 176);
		// doc.setFillColor(0, 136, 176);
		// doc.roundedRect(25, 105, 165, 8, 1, 1,'FD');
		 /*doc.roundedRect(25, 115, 165, 15, 1, 1,'FD');
		 doc.roundedRect(25, 132, 165, 15, 1, 1,'FD');*/
		// doc.setTextColor(255, 255, 255);
		// doc.setFontType("normal");
		// doc.setFontSize("10");


		// doc.text(30, 110, 'Fecha Inicio :');
		// doc.text(72, 110, 'Fecha Fin :');
		// doc.text(119, 110, 'No. Dias :');
		// doc.text(159, 110, 'Monto :');



		 doc.setFontType("normal");
		// doc.text(51, 110, data.fecha); //append email id in pdf
		// doc.text(90, 110, data.fecha2);
		// doc.text(136, 110, data.Total2);
		// doc.text(174, 110, data.Total);
                

		//doc.setDrawColor(98, 98,98);
		 doc.setTextColor(68, 68, 68);
		doc.setFontSize("11");
		doc.setFontType("normal");
		


    // doc.setTextColor(68, 68, 68);
     
    // doc.text(178, 115, data.personas);
	// doc.setFontType("bold");
	 doc.text(25, 85, 'Objetivo de la comisión : ');
	 doc.text(25, 110, 'Por motivo de: ');
   //  doc.text(25, 118, 'Objetivo de la comisión : ');
	 doc.text(25, 132, 'Descripción de lo solicitado: ');
	// doc.setTextColor(68, 68, 68);
     
      //doc.text(25, 127, data.obj);
      
       var p1=140;
		 var titulo= data.destino2;  // detalle de lo solicitado
      ///
     // var p_lineas2 = doc.splitTextToSize(data.obj, 170);

		// doc.text(25, 124, p_lineas2); 
      
      ///
      
		 doc.setFontSize(6);
     doc.setFontType("normal");
		 var p_lineas = doc.splitTextToSize(titulo, 155);
    // doc.setTextColor(68, 68, 68);



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

		 doc.setFontSize(11);










		 doc.setTextColor(68, 68, 68);	
		// doc.setTextColor(255, 255, 255);
		 doc.setFontType("normal");
		 var p_lineas2 = doc.splitTextToSize(data.obj, 167);
		 doc.text(25, 90, p_lineas2);

		 
		var p_lineas2 = doc.splitTextToSize(data.just, 167);
		 doc.text(25, 115, p_lineas2);

		  doc.setFontType("normal");

		// doc.line(36, 210, 100, 210);
		// doc.text(44, 214, 'Nombre y Firma del Solicitante');


		 //doc.line(112, 210, 180, 210);
		 //doc.text(126, 214, 'Jefe del Departamento');

		 doc.setFontSize("8");
		 doc.setFontType("bold");
		// doc.text(25, 230, 'Observaciones:');

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
		  doc.writeText(25, 248 ,'Adjunto',{align:'left',width:215});
		 doc.text(25 , 252,  data.correlativo); 
		 doc.writeText(0, 258 ,'Reporte Generado por Sistema Control Administrativo SVET - Módulo control de viaticos',{align:'center',width:215});
		 //doc.addImage(footer, 'png', 0, 260, 216, 15);
	   doc.save('Solicitud - '+ data.correlativo +'.pdf'); // Save the PDF with name "katara"...

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
