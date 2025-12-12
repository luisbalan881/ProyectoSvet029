function datos_hoja_cupones(year,mes,solicitud_id,dep_id){

  $.ajax({
    type: "POST",
    url: "combustible/php/hoja_autorizada_cupones.php",
    data: {year:year,mes:mes,solicitud_id:solicitud_id,dep_id},
    dataType:'json', //f de fecha y u de estado.




    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){
            //alert(data);
            console.log(data);
            var documento;
            var hojas = data.data.length;
            var doc = new jsPDF('p','mm');
            for(var i = 0; i < data.data.length; i++) {



            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
            doc.setFontSize(10);
            doc.writeText(0, 60 ,data.data[i].solicitud,{align:'right',width:190});
            documento = data.data[i].solicitud;

            doc.setFontType("bold");
            doc.addImage(logo, 'png', 20, 15, 60, 35);

            doc.setFontType("bold");


            doc.setFontSize(14);
            doc.writeText(0, 80 ,'AUTORIZACION DE ENTREGA DE COMBUSTIBLES',{align:'center',width:215});


            doc.setDrawColor(225,225,225);
        		doc.setFillColor(255, 255, 255);
        		doc.roundedRect(25, 90, 165, 60, 1, 1);
            doc.line(120, 94, 120, 145);
            doc.setFontSize(10);
            doc.setFontType("bold");
            doc.text(30, 99, 'Placa ');
            doc.text(30, 104, 'Vehículo');
            doc.text(30, 109, 'Combustible ');
            doc.text(30, 114, 'Línea');
            doc.text(30, 119, 'Modelo');
            doc.text(30, 124, 'Color ');
            doc.text(30, 129, 'Cilindraje');
            doc.text(30, 134, 'Cilindros');
            doc.text(30, 139, 'Entregados a');
            doc.text(30, 144, 'Responsable');

            doc.setFontType("normal");
            doc.text(60, 99, data.data[i].placa);
            doc.text(60, 104, data.data[i].vehiculo);
            doc.text(60, 109, data.data[i].combustible);
            doc.text(60, 114, data.data[i].linea);
            doc.text(60, 119, data.data[i].modelo);
            doc.text(60, 124, data.data[i].color);
            doc.text(60, 129, data.data[i].cilindraje);
            doc.text(60, 134, data.data[i].cilindros);
            doc.text(60, 139, data.data[i].entregado_a);
            doc.text(60, 144, data.data[i].responsable);


            /*DATOS DEL CARRO*/
           /* doc.setFontType("bold");
            doc.text(125, 99, 'Fecha Autorizado');

            doc.text(125, 114, 'Fecha Entregado');
            doc.text(125, 119, 'Kilómetro inicial');
            doc.text(125, 124, 'Kilómetro final');

            doc.setFontType("normal");

            doc.text(165, 99, data.data[i].fecha_autorizado);*/

              /*DATOS DEL CARRO*/
            doc.setFontType("bold");
            doc.text(125, 99, 'Fecha Autorizado');
            doc.text(125, 114, 'Km Inicial');
            doc.text(125, 119, 'Km final');
            doc.text(125, 124, 'Galones');

            
            doc.setFontType("normal");

            doc.text(165, 99, data.data[i].fecha_autorizado);
            doc.text(165, 114, data.data[i].km_ini);
            doc.text(165, 119, data.data[i].km_fin);
            doc.text(165, 124, data.data[i].galones_consumidos);
            
            

            /**/


            /**/

            var cupones = data.data[i].cupones;
            var cp = cupones.split(',');
            var montos = data.data[i].montos;
            var mt = montos.split(',');
            var total=0;

			
            p1 = 145;
            p2 = 145;
            rect = 150;


            doc.setTextColor();
            
               doc.setDrawColor(225,225,225);
        		doc.setFillColor(255, 255, 255);
        		doc.roundedRect(25, 90, 165, 60, 1, 1);
            doc.line(120, 94, 120, 145);
            doc.setFontSize(10);
            doc.setFillColor(255, 255, 255);
            //doc.setTextColor(5, 83, 142);
            doc.writeText(0, 185 ,'_________________________',{align:'center',width:215});
            doc.writeText(0, 190 ,'vo. Bo Director Administrativo ',{align:'center',width:215});
            doc.writeText(0, 215 ,'_________________________',{align:'center',width:215});
            doc.writeText(0, 220 ,'Elaborado Por ',{align:'center',width:215});
            doc.writeText(0, 245 ,'_________________________',{align:'center',width:215});
            doc.writeText(0, 250 ,'Nombre y firma de quien recibe los cupones ',{align:'center',width:215});
           // doc.writeText(30, 246 ,'Elaborado por ____________________________ Nombre y firma de quien recibe los cupones_________________________ ',{align:'center',width:215});
            //doc.writeText(0, 259 ,'Reporte Generado svetsis - Módulo control de cupones',{align:'center',width:215});
            

            cp.forEach( function(valor, indice, array) {
				if(indice==0 || indice==35 || indice==60 || indice==85 || indice==105 || indice==130 || indice==155)
			  {
				  p1 = 15;
            p2 = 15;
			rect = 0;
				  doc.addPage();
                                  
			  }
            // doc.setDrawColor(0, 136, 176);
          		//doc.setFillColor(0, 136, 176);
              //doc.roundedRect(25, rect, 165, 8, 1, 1, 'FD');
              doc.setFontType("normal");
              doc.text(40, p1, 'Cupon Número :');
              doc.setFontType("bold");
              doc.text(80, p1, valor);
              p1 +=5;
              rect +=5;
              
              //
              //
            /*  mt.forEach( function(valor, indice, array) {
              doc.setFontType("normal");
              doc.text(136, p2, 'Monto :');
              doc.setFontType("bold");
              doc.text(165, p2, 'Q');
              doc.writeText(0, p2,valor,{align:'right',width:180});
              total +=parseFloat(valor);
              p2 +=10;

            });*/
              //
              //
            /*   doc.text(136, p2, 'Monto :');
                doc.setFontType("bold");
              doc.text(165, p2, 'Q');
              doc.writeText(0, p2,valor,{align:'right',width:180});
              p2 +=10;
              p1 +=10;
              rect +=10;*/
		//	  alert(indice);
			  
            });

          mt.forEach( function(valor, indice, array) {
				if(indice=0 || indice==35 || indice==60 || indice==85 || indice==105 || indice==130 || indice==155)
			  {
				  p1 = 15;
            p2 = 15;
			//rect = 20;
                        //
                        
			//	  doc.addPage();	  
			  }

              //doc.setFontType("normal");
              
              
              doc.text(136, p2, 'Monto :');
                     
                              doc.setFontType("bold");
              doc.text(165, p2, 'Q');
              doc.writeText(0, p2,valor,{align:'right',width:180});
              total +=parseFloat(valor);
              p2 +=5;
              rect +=5;

            });

            doc.setTextColor(68, 68, 68);
            doc.setFontType("bold");
            doc.writeText(0, p2,'Total autorizado : Q   '+total+'.00',{align:'right',width:180});

           // doc.setDrawColor(215,215,215);
            //doc.line(30, 240, 100, 240);
            //doc.text(55, 244, 'Autorización');
            
            
            
           // doc.setFontSize(8);
            //doc.setTextColor(5, 83, 142);
            //doc.writeText(0, 258 ,'Reporte Generado svetsis - Módulo control de cupones',{align:'center',width:215});
           // doc.addImage(footer, 'png', 0, 260, 216, 15);





            hojas--;
            //if(hojas!=0)
            //if (doc.writeText0, 257)
          /* if (doc.writeText0, p2>270)
            
            {
              doc.addPage();
              // doc.addImage(logo, 'png', 0, 260, 216, 15);
              
              doc.setFontSize(8);
            doc.setFillColor(255, 255, 255);
            //doc.setTextColor(5, 83, 142);
            doc.writeText(0, 260 ,' vo. Bo Director Admiistrativo _________________________       ',{align:'center',width:215});
            doc.writeText(0, 276 ,'Elaborado por ____________________________ Nombre y firma de quien recibe los cupones_________________________ ',{align:'center',width:215});
            //doc.writeText(0, 259 ,'Reporte Generado svetsis - Módulo control de cupones',{align:'center',width:215});
            
            }

                else 
                    {
                        // doc.addImage(footer, 'png', 0, 260, 216, 15);
                        doc.setFontSize(8);
            doc.setFillColor(255, 255, 255);
            //doc.setTextColor(5, 83, 142);
            doc.writeText(0, 260 ,' vo. Bo Director Admiistrativo _________________________       ',{align:'center',width:215});
            doc.writeText(0, 276 ,'Elaborado por ____________________________ Nombre y firma de quien recibe los cupones_________________________ ',{align:'center',width:215});
            //doc.writeText(0, 259 ,'Reporte Generado svetsis - Módulo control de cupones',{align:'center',width:215});
            
                        
                        } */

          }
          doc.autoPrint()
          doc.save('Cupones - '+ documento +'.pdf');
          }


  }).done( function(data) {
  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}
