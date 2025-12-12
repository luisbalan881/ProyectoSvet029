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
            alert(data);
            console.log(data);
            var documento;
            var hojas = data.data.length;
            var doc = new jsPDF('p','mm');
            for(var i = 0; i < data.data.length; i++) {



            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
            doc.setFontSize(10);
            doc.writeText(0, 50 ,data.data[i].solicitud,{align:'right',width:190});
            documento = data.data[i].solicitud;

            doc.setFontType("bold");
            doc.addImage(logo, 'png', 20, 15, 60, 35);

            doc.setFontType("bold");


            doc.setFontSize(14);
            doc.writeText(0, 58 ,'AUTORIZACION DE ENTREGA DE COMBUSTIBLES',{align:'center',width:215});


            doc.setDrawColor(225,225,225);
        		doc.setFillColor(255, 255, 255);
        		doc.roundedRect(25, 60, 165, 60, 1, 1);
            doc.line(120, 60, 120, 121);
            doc.setFontSize(10);
            doc.setFontType("bold");
            doc.text(30, 69, 'Placa ');
            doc.text(30, 74, 'Vehiculo');
            doc.text(30, 79, 'Combustible ');
            doc.text(30, 84, 'Linea');
            doc.text(30, 89, 'Modelo');
            doc.text(30, 94, 'Color ');
            doc.text(30, 99, 'Cilindraje');
            doc.text(30, 104, 'Cilindros');
            doc.text(30, 109, 'Entregados a');
            doc.text(30, 114, 'Responsable');
            doc.text(30, 119, 'Destino');
            

            doc.setFontType("normal");
            doc.text(60, 69, data.data[i].placa);
            doc.text(60, 74, data.data[i].vehiculo);
            doc.text(60, 79, data.data[i].combustible);
            doc.text(60, 84, data.data[i].linea);
            doc.text(60, 89, data.data[i].modelo);
            doc.text(60, 94, data.data[i].color);
            doc.text(60, 99, data.data[i].cilindraje);
            doc.text(60, 104, data.data[i].cilindros);
            doc.text(60, 109, data.data[i].entregado_a);
            doc.text(60, 114, data.data[i].responsable);
            doc.text(60, 119, data.data[i].destino);
           
            /*DATOS DEL CARRO*/
            doc.setFontType("bold");
            doc.text(125, 69, 'Fecha Autorizado');
            doc.text(125, 74, 'Km Inicial');
            doc.text(125, 79, 'Km final');
            doc.text(125, 84, 'Galones');
            doc.text(125, 89, 'Km Recorridos');

            
            doc.setFontType("normal");

            doc.text(165, 69, data.data[i].fecha_autorizado);
            doc.text(165, 74, data.data[i].km_ini);
            doc.text(165, 79, data.data[i].km_fin);
            doc.text(165, 84, data.data[i].galones_consumidos);
            doc.text(165, 89, data.data[i].km_re);
            
            

            /*Cupon Numero*/

            var cupones = data.data[i].cupones;
            var cp = cupones.split(',');
            var montos = data.data[i].montos;
            var mt = montos.split(',');
            var total=0;

            p1 = 126;
            p2 = 126;
            rect = 121;


            doc.setTextColor();



            cp.forEach( function(valor, indice, array) {
                if(indice==12 || indice==35 || indice==60 || indice==85 || indice==105 || indice==130 || indice==155)
			  {
				  p1 = 15;
            p2 = 15;
			rect = 10;
				 
                    // mt.forEach();
                    doc.addPage();
                                 
                
                          }
              doc.setDrawColor(9, 28, 23);
          		doc.setFillColor(255, 255, 255);
              doc.roundedRect(25, rect, 165, 8, 1, 1, 'FD');
              doc.setFontType("normal");
              doc.text(40, p1, 'Cupon Numeros :');
              doc.setFontType("bold");
              doc.text(80, p1, valor);
              p1 +=8;
              rect +=8;
            });

            mt.forEach( function(valor, indice, array) {
              
                
              doc.setFontType("normal");
              doc.text(136, p2, 'Monto :');
              doc.setFontType("bold");
              doc.text(165, p2, 'Q');
              doc.writeText(0, p2,valor,{align:'right',width:180});
              total +=parseFloat(valor);
              p2 +=8;

            });

            doc.setTextColor(68, 68, 68);
            doc.setFontType("bold");
            doc.writeText(0, p2,'Total autorizado : Q   '+total+'.00',{align:'right',width:180});

            //doc.setDrawColor(215,215,215);
            //doc.line(30, 250, 190, 250); 
            //doc.line(120, 250, 120, 280);
            //doc.text(55, 244, 'Autorización----------------------------');
          //  doc.setDrawColor(225,225,225);
         //	doc.setFillColor(255, 255, 255);
         	//doc.roundedRect(25, 245, 165, 30, 1, 1);
          //  doc.line(115, 245, 115, 277);
            
            //doc.writeText(0, 255 ,'Administrativo________________',{align:'center',width:215});
          //  doc.writeText(0, 255 ,'_________________________',{align:'center',width:215});
           // doc.writeText(0, 250 ,'Elaborado Por _________________________ vo. Bo Director Admon_________________________',{align:'center',width:215});
            //doc.writeText(0, 265 ,'_________________________',{align:'center',width:215});
           // doc.writeText(0, 270 ,'Elaborado Por______________ ',{align:'center',width:215});
           // doc.writeText(0, 275 ,'_________________________',{align:'center',width:215});
           // doc.writeText(0, 265 ,'Nombre y firma de quien recibe los cupones  ___________________________________________',{align:'center',width:215});
           // doc.writeText(0, 265 ,'Autorizado po________________',{align:'center',width:215});
           // doc.writeText(0, 220 ,'Entregado a________________',{align:'center',width:215});

            doc.setFontSize(8);
            doc.setTextColor(5, 83, 142);
            //doc.writeText(0, 258 ,'Reporte Generado vicesis - Módulo control de cupones',{align:'center',width:215});
            //doc.addImage(footer, 'png', 0, 260, 216, 15);

            hojas--;
            if(hojas!=0)
            {
              doc.addPage();
            }





          }
          doc.autoPrint()
          doc.save('Cupones - '+ documento +'.pdf');
          }


  }).done( function(data) {
  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}
