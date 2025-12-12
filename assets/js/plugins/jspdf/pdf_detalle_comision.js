function HTMLtoPDF_detalle(solicitud){
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
	   doc.addImage(logo, 'png', 15, 15, 60, 15);  //  15, 15, ancho, 

            
            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
           // doc.writeText(0, 30 ,'NIT: '+data.nit,{align:'right' ,width:190});

		 doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);

	   //doc.text(33, 50, 'BOLETA DE SOLICITUD Y AUTORIZACIÓN DE VEH�?CULO PARA COMISIONES');
                  //   doc.writeText(0, 30 ,'NIT'+data.nit,{align:'right',width:190});
                   
                 //doc.setFontType("bold");
		 //doc.text(94, 59, data.fecha); //append email id in pdf
                 doc.writeText(0, 40 ,'Guatemala, '+data.fecha_liq,{align:'right',width:195});


		 doc.setFontSize(11);
		 doc.writeText(0, 35 ,'INFORME',{align:'center',width:195});
                 
                   doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
                                 
                  doc.setFontSize("10");
		 
                  doc.text(15, 48, 'Dirigido a :');
                   doc.text(34, 48, data.autorizado);//56
                    doc.text(15, 52, data.departamentos);  //56
                      doc.text(15, 56, 'Secretaria  contra la Violencia Sexual, Explotación y Trata de Personas');  //60
                 
                 
		 doc.setFontSize("10");
                 //doc.text(15, 72, 'Señor (a):');
		 //doc.text(15, 98, 'Solicitante :');
                 
                  doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
		// doc.text(55, 80,  data.correlativo);
		// doc.text(55, 86, data.autorizado);
		 //doc.text(55, 87, data.departamentos); //append email id in pdf
		// var p_lineas1 = doc.splitTextToSize(data.departamentos, 75);

		// doc.text(55, 72, p_lineas1);
               
                  // doc.text(62, 78, data.nombre2);
		 //doc.text(79, 78, data.apellido1);
                 //doc.text(93, 78, data.apellido2);
                  doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);

		 doc.setFontSize("10");
                 
                 
		 doc.text(15, 66, 'Por este medio hago de su conocimiento que según requerimiento');
                  doc.writeText(121, 66 ,''+data.correlativo);
		 doc.text(15, 70, 'de fecha ');
                  doc.text(30, 70, data.fecha1);
                 doc.text(50, 70, 'fui designado (a) para realizar la siguiente comisión:                    ');
                 //doc.text(15, 103, data.obj);
                 var p_lineas1 = doc.splitTextToSize(data.obj, 185);

		 doc.text(15, 74, p_lineas1);
                 
                  doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);
                 
                doc.text(15, 90, 'Objetivos:');
                //doc.text(54, 114, data.obj2);
                 doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
                  var p_lineas6 = doc.splitTextToSize(data.obj2, 185);

		 doc.text(15, 94, p_lineas6);
                 
                 
                  doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);
                 
                  doc.text(15, 120, 'Actividades Realizadas:');
                //doc.text(54, 114, data.obj2);
                doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
                 
                 
                  var p_lineas7 = doc.splitTextToSize(data.act, 185);

		 doc.text(15, 124, p_lineas7);
                 
                   doc.setFontType("bold");
		 doc.setTextColor(68, 68, 68);
                 
                doc.text(15, 190, 'Logros Alcanzados:');
                //doc.text(54, 114, data.obj2);
                 doc.setFontType("normal");
		 doc.setTextColor(68, 68, 68);
                  var p_lineas8 = doc.splitTextToSize(data.log, 185);

		 doc.text(15, 194, p_lineas8);
                 
                 
                 
                 
                
                 //doc.text(20, 121, 'El cual Inicia el:');
                 //doc.text(55, 121, data.fecha1);
                 //doc.text(80, 121, 'y finaliza el:');
                 //doc.text(103, 121, data.fecha2);
                 //doc.text(20, 127, 'Así mismo, se le instruye que debera cumplir con la ruta establecida y la misma no podrá');
		 //doc.text(20, 131, 'ser modificada sin autorización previa de su autoridad superior inmediata, el traslado y el');
                // doc.text(20, 135, 'trasporte estara a cargo del piloto y veniculo asignado por la Drirección Administrativa.');
                //  doc.text(20, 147, 'Sin otro particular, me suscribo.');
                //   doc.writeText(20, 240 ,'Atentamente,',{align:'left',width:190});

		 
                      doc.setFontType("normal");
                  doc.setFontSize("8");
		 doc.setTextColor(68, 68, 68);
                  doc.text(15, 264, 'F.___________________________                                                                    Vo Bo.___________________________');
                  doc.text(15, 268, data.autorizado2);
                  
                  doc.text(15, 272, data.puesto);
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

    // doc.text(15, 130, 'Justificación de la Solicitud: ');
		 doc.setFontSize(10);
     doc.setFontType("normal");
		 var p_lineas = doc.splitTextToSize(titulo, 155);
     doc.setTextColor(68, 68, 68);




     var string = titulo.replace(/f7/g,'\n\n');

     var lMargin=15; //left margin in mm
    var rMargin=15; //right margin in mm
    var pdfInMM=210;  // width of A4 in mm
		 var lines =doc.splitTextToSize(string, (pdfInMM-lMargin-rMargin));
     doc.text(lMargin,p1,lines);




		 doc.setFontSize(10);











		 

		/* 
		 doc.setFontSize("10");
		 doc.setFontType("normal");
		 doc.writeText(10, 235, '4ta calle 5-51 Zona 1, Guatemala' ,{align:'center',width:190});
		 doc.writeText(10, 240, 'Telefonos:(502)2004-8888' ,{align:'center',width:190});
*/


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

