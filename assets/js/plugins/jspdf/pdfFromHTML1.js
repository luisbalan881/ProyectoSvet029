function HTMLtoPDF1(solicitud){
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
	   doc.addImage(logo, 'png', 20, 15, 60, 15);  //  20, 15, ancho, 

            
            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
           // doc.writeText(0, 30 ,'NIT: '+data.nit,{align:'right' ,width:190});
		   			doc.writeText(0, 30 ,'DPI: '+data.cui,{align:'right' ,width:190});

		 doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);

	   //doc.text(33, 50, 'BOLETA DE SOLICITUD Y AUTORIZACIÓN DE VEH�?CULO PARA COMISIONES');
                  //   doc.writeText(0, 30 ,'NIT'+data.nit,{align:'right',width:190});
                    doc.writeText(0, 50 ,''+data.correlativo,{align:'right',width:190});
                 //doc.setFontType("bold");
		 //doc.text(94, 59, data.fecha); //append email id in pdf
                 doc.writeText(0, 55 ,'Guatemala, '+data.fecha1,{align:'right',width:190});


		 doc.setFontSize(12);
		 doc.writeText(0, 65 ,'REQUERIMIENTO DE TRASLADO POR MOTIVO DE LOS SERVICIOS',{align:'center',width:211});
		 doc.setFontSize("12");
                 doc.text(25, 72, 'Señor (a):');
		 //doc.text(25, 98, 'Solicitante :');
                 
                  doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
		// doc.text(55, 80,  data.correlativo);
		// doc.text(55, 86, data.autorizado);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 75);

		// doc.text(55, 72, p_lineas1);
                
                  doc.text(45, 78, data.autorizado2);
                  // doc.text(62, 78, data.nombre2);
		 //doc.text(79, 78, data.apellido1);
                 //doc.text(93, 78, data.apellido2);

		 doc.setFontSize("12");
                 
                 
		// doc.text(25, 84, 'De manera atenta me dirijo a usted para hacerle de su conocimiento que se le nombra, para');
		 doc.text(25, 84, 'Reciba un cordial saludo, por este medio se le informa que de acuerdo con las actividades');
		// doc.text(25, 88, 'que, en representación de la Secretaría contra la Violencia Sexual, Explotación y Trata de');
		 doc.text(25, 88, 'que realiza en la Secretaría contra la Violencia Sexual, Explotación y Trata de Personas -SVET-.');
                // doc.text(25, 92, 'Pesonas -SVET- realice la actividad que se describe a continuación:                    ');
                  doc.text(25, 92, 'Se le solicíta realizar la siguiente actividad:                    ');
                 //doc.text(25, 103, data.obj);
                 var p_lineas1 = doc.splitTextToSize(data.obj, 170);

				doc.text(25, 103, p_lineas1);
				
				
				var p_lineas3 = doc.splitTextToSize(data.lugar1, 153);

				doc.text(46, 122, p_lineas3);

                 doc.text(25, 122, 'Municipio,');
                // doc.text(54, 122, data.lugar1);
                 doc.text(25, 131, 'El cual inicia el:');
                 doc.text(55, 131, data.fecha);
                 doc.text(80, 131, 'y finaliza el:');
                 doc.text(103, 131, data.fecha2);
                 doc.text(25, 139, 'Así mismo, se le instruye que deberá cumplir con la ruta establecida y la misma no podrá');
		 doc.text(25, 143, 'ser modificada sin autorización previa de su autoridad superior inmediata.');
                 //doc.text(25, 141, 'transporte estara a cargo del piloto y vehiculo asignado por la Dirección Administrativa.');
                  doc.text(25, 147, 'Sin otro particular, me suscribo.');
                   doc.writeText(0, 172 ,'Atentamente,',{align:'center',width:190});

		 

		// doc.setFontType("normal");
		// doc.setTextColor(68, 68, 68);
		// doc.text(55, 80,  data.correlativo);
		// doc.text(55, 86, data.autorizado);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 115);

		// doc.text(55, 92, p_lineas1);
		 //doc.text(55, 98, data.solicitante);

		 doc.setFontSize("8");


		// doc.writeText(0, 10 ,'Fecha y hora en la que se creó la solicitud: '+data.fecha_creacion,{align:'right',width:190});


		 

		 doc.setDrawColor(98, 98,98);

		 doc.setFontType("normal");
		 var p1=140;
		 var titulo= "";


     doc.setTextColor(68, 68, 68);
     doc.setFontSize("10");
     doc.setFontType("bold");

    // doc.text(25, 130, 'Justificación de la Solicitud: ');
		 doc.setFontSize(10);
     doc.setFontType("normal");
		 var p_lineas = doc.splitTextToSize(titulo, 155);
     doc.setTextColor(68, 68, 68);




     var string = titulo.replace(/f7/g,'\n\n');

     var lMargin=25; //left margin in mm
    var rMargin=25; //right margin in mm
    var pdfInMM=210;  // width of A4 in mm
		 var lines =doc.splitTextToSize(string, (pdfInMM-lMargin-rMargin));
     doc.text(lMargin,p1,lines);




		 doc.setFontSize(10);











		 

		 
		 doc.setFontSize("10");
		 doc.setFontType("normal");
		 doc.writeText(10, 235, '4ta calle 5-51 Zona 1, Guatemala' ,{align:'center',width:190});
		 doc.writeText(10, 240, 'Telefonos:(502)2504-8888' ,{align:'center',width:190});



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




// pdf para nombramiento y pase de salida  21 de julio 2023

function HTMLtoPDF2(solicitud){
	$.ajax({
    type: "POST",
    url: "viaticos/php/hoja_solicitud_pase.php",
    data: {solicitud:solicitud}, //f de fecha y u de estado.
  dataType:'json',


    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){


	var doc = new jsPDF();
	   doc.addImage(logo, 'png', 20, 15, 60, 15);  //  20, 15, ancho, 

            
            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
            doc.writeText(0, 30 ,'NIT: '+data.nit,{align:'right' ,width:190});

		 doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);

	   //doc.text(33, 50, 'BOLETA DE SOLICITUD Y AUTORIZACIÓN DE VEH�?CULO PARA COMISIONES');
                  //   doc.writeText(0, 30 ,'NIT'+data.nit,{align:'right',width:190});
                    doc.writeText(0, 50 ,''+data.correlativo,{align:'right',width:190});
                 //doc.setFontType("bold");
		 //doc.text(94, 59, data.fecha); //append email id in pdf
                 doc.writeText(0, 55 ,'Guatemala, '+data.fecha1,{align:'right',width:190});


		 doc.setFontSize(12.5);
		 doc.writeText(0, 65 ,'Asignación de Actividades',{align:'center',width:211});
		 doc.setFontSize("12");
                 doc.text(25, 72, 'Señor (a):');
		 //doc.text(25, 98, 'Solicitante :');
                 
                  doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
		// doc.text(55, 80,  data.correlativo);
		// doc.text(55, 86, data.autorizado);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 75);

		// doc.text(55, 72, p_lineas1);
                
                  doc.text(45, 78, data.autorizado2);
                  // doc.text(62, 78, data.nombre2);
		 //doc.text(79, 78, data.apellido1);
                 //doc.text(93, 78, data.apellido2);

		 doc.setFontSize("12");
                 
                 
		 doc.text(25, 84, 'De manera atenta me dirijo a usted para hacerle de su conocimiento que se le nombra, para');
		 doc.text(25, 88, 'que, en representación de la Secretaría contra la Violencia Sexual, Explotación y Trata de');
                 doc.text(25, 92, 'Personas -SVET- realice la actividad que se describe a continuación:                    ');
                 //doc.text(25, 103, data.obj);
                 var p_lineas1 = doc.splitTextToSize(data.obj, 170);

				doc.text(25, 103, p_lineas1);
                 doc.text(25, 122, 'Municipio,');
                 doc.text(54, 122, data.lugar1);
                 doc.text(25, 129, 'El cual inicia el:');
                 doc.text(55, 129, data.fecha);
				 

				 
                 doc.text(80, 129, 'y finaliza el:');
                 doc.text(103, 129, data.fecha2);
				
				  doc.text(25, 133, 'De:');
                 doc.text(35, 133, data.h1);
				 
				  doc.text(60, 133, 'A:');
                 doc.text(70, 133, data.h2);
				
				 
                 doc.text(25, 141, 'Así mismo, se le instruye que deberá cumplir con la ruta establecida y la misma no podrá');
		 doc.text(25, 144, 'ser modificada sin autorización previa de su autoridad superior inmediata.');
                 //doc.text(25, 141, 'transporte estara a cargo del piloto y vehiculo asignado por la Dirección Administrativa.');
                  doc.text(25, 148, 'Sin otro particular, me suscribo.');
                   doc.writeText(0, 168 ,'Atentamente,',{align:'center',width:190});

		 

		// doc.setFontType("normal");
		// doc.setTextColor(68, 68, 68);
		// doc.text(55, 80,  data.correlativo);
		// doc.text(55, 86, data.autorizado);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 115);

		// doc.text(55, 92, p_lineas1);
		 //doc.text(55, 98, data.solicitante);

		 doc.setFontSize("8");


		// doc.writeText(0, 10 ,'Fecha y hora en la que se creó la solicitud: '+data.fecha_creacion,{align:'right',width:190});


		 

		 doc.setDrawColor(98, 98,98);

		 doc.setFontType("normal");
		 var p1=140;
		 var titulo= "";


     doc.setTextColor(68, 68, 68);
     doc.setFontSize("10");
     doc.setFontType("bold");

    // doc.text(25, 130, 'Justificación de la Solicitud: ');
		 doc.setFontSize(10);
     doc.setFontType("normal");
		 var p_lineas = doc.splitTextToSize(titulo, 155);
     doc.setTextColor(68, 68, 68);




     var string = titulo.replace(/f7/g,'\n\n');

     var lMargin=25; //left margin in mm
    var rMargin=25; //right margin in mm
    var pdfInMM=210;  // width of A4 in mm
		 var lines =doc.splitTextToSize(string, (pdfInMM-lMargin-rMargin));
     doc.text(lMargin,p1,lines);

		 doc.setFontSize(10);
	 
		 doc.setFontSize("10");
		 doc.setFontType("normal");
		 doc.writeText(10, 235, '4ta calle 5-51 Zona 1, Guatemala' ,{align:'center',width:190});
		 doc.writeText(10, 240, 'Telefonos:(502)2504-8888' ,{align:'center',width:190});



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


