                  function HTMLtoPDFV4(solicitud){
	$.ajax({
    type: "POST",
    url: "viaticos/php/hoja_solicitud4.php",
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
//lugar1
		 doc.setFontSize(12.5);
		// doc.writeText(0, 65 ,' ',{align:'center',width:211});
		 doc.setFontSize("10");
                     doc.text(175, 34, data.id1);
                    doc.text(175, 40, data.Total);
                    // doc.text(195, 40, data.Total2);
		// doc.text(25, 80, 'Nombramiento :');
		// doc.text(25, 86, 'Autorizado :');

		// doc.text(25, 92, 'Dep.(s) :');
		// doc.text(25, 98, 'Solicitante :');

		 doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
		 doc.text(82, 114,  data.correlativo);
                 doc.text(175, 114,  data.fecha1);
                 
                 doc.text(97, 81, data.lugar1);
                 doc.text(170, 81, data.Total2);
                // doc.text(95, 80,  data.descripcion2);
		 doc.text(35, 191, data.autorizado);
                 doc.text(35, 155, data.puesto);
                 doc.text(35, 202, data.puesto2);
                 //doc.text(100, 86, data.autorizado2);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 115);

		 //doc.text(55, 92, p_lineas1);
		 doc.text(35, 144, data.autorizado2);
                  // doc.text(95, 98, data.descripcion);

		 doc.setFontSize("10");


		 doc.writeText(0, 220 ,'Guatemala, '+data.fecha1,{align:'center',width:190});


		 //doc.setDrawColor(0, 136, 176);
		 //doc.setFillColor(0, 136, 176);
		 //doc.roundedRect(25, 105, 165, 8, 1, 1,'FD');
		 /*doc.roundedRect(25, 115, 165, 15, 1, 1,'FD');
		 doc.roundedRect(25, 132, 165, 15, 1, 1,'FD');*/
		 //doc.setTextColor(255, 255, 255);
		 //doc.setFontType("normal");
		 //doc.setFontSize("10");


		 //doc.text(30, 110, 'Fecha Inicio :');
		// doc.text(72, 110, 'Fecha Fin :');
		// doc.text(109, 110, 'Lugar :');
		// doc.text(165, 110, 'Monto :');



		 doc.setFontType("bold");
		// doc.text(51, 110, data.fecha); //append email id in pdf
		// doc.text(90, 110, data.fecha2);
		 //doc.text(136, 110, data.duracion);
                // doc.text(120, 110, data.lugar1);
		 //doc.text(178, 110, data.Total);
                

		 doc.setDrawColor(98, 98,98);

		 doc.setFontType("normal");
		 var p1=140;
		 var titulo='';


     doc.setTextColor(68, 68, 68);
     
    // doc.text(178, 115, data.personas);
    // doc.text(25, 123, 'Objetivo de la comisión : ');
      doc.setFontSize("8");
     doc.setFontType("normal");
      //doc.text(25, 127, data.obj);
      
      
      ///
      var p_lineas2 = doc.splitTextToSize(data.obj, 74);

		 doc.text(18, 81, p_lineas2); 
      
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
		 var p_lineas2 = doc.splitTextToSize(data.destino, 145);
		 doc.text(45, 119, p_lineas2);

		 var p_lineas3 = doc.splitTextToSize(data.motivo, 145);
		 doc.text(45, 137, p_lineas3);
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
		

	   doc.setTextColor(255, 0, 0); //set font color to red
	 
		 doc.setFontSize(8);
		 doc.setTextColor(5, 83, 142);
		// doc.writeText(0, 258 ,'Reporte Generado svetsis - Módulo control de viaticos',{align:'center',width:215});
		 //doc.addImage(footer, 'png', 0, 260, 216, 15);
	   doc.save('Solicitud - '+ data.correlativo +'.pdf'); // Save the PDF with name "katara"...

	 }


}).done( function(data) {
}).fail( function( jqXHR, textSttus, errorThrown){

alert(errorThrown);

});
}


