function solicitar_cupones(year,mes,solicitud_id,dep_id){

  $.ajax({
    type: "POST",
    url: "combustible/php/hoja_solicitud_cupones.php",
    data: {year:year,mes:mes,solicitud_id:solicitud_id,dep_id},
    dataType:'json', //f de fecha y u de estado.




    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){
            //alert(data);
            var documento;
            var hojas = data.data.length;
            var doc = new jsPDF('p','mm');




            doc.setFontType("bold");
            doc.setTextColor(68, 68, 68);
            doc.setFontSize(12);
             doc.writeText(30, 118 ,'DATOS DEL VEHICULO:' ,{align:'left',width:190});

            doc.setFontType("bold");
            doc.addImage(logo, 'png', 20, 15, 60, 35);
            doc.setTextColor(68, 68, 68);




            doc.setDrawColor(225,225,225);
            doc.setFillColor(255, 255, 255);
            doc.roundedRect(25, 120, 165, 10, 1, 1);
            doc.setFontSize(10);
            doc.setFontType("bold");
            doc.text(27, 126, 'Placa ');
            doc.text(47, 126, 'Marca ');
            doc.text(67, 126, 'Línea ');
            doc.text(82, 126, 'Rendimiento/galon');
            doc.text(115, 126, 'Combustible ');
            doc.text(140, 126, 'Responsable ');
            doc.text(176, 126, 'Monto ');


            p1 = 140;
            rect = 135;
            var total=0;
            var solicitante;
            var titulo;
            var f_d_solicitud;
            for(var i = 0; i < data.data.length; i++) {

              doc.setFontType("bold");
              doc.setFontSize(14);
              doc.setTextColor(68, 68, 68);
              /*if(data.data[i].comision_status == 1)
              {
                doc.writeText(0, 73 ,'SOLICITUD DE CUPONES DE COMBUSTIBLE',{align:'center',width:215});
                doc.writeText(0, 80 ,'PARA COMISION VICEPRESIDENCIAL',{align:'center',width:215});
              }
              else
              {*/
                //doc.writeText(0, 80 ,'SOLICITUD DE CUPONES DE COMBUSTIBLE',{align:'center',width:215});
              //}

              doc.setFontType("bold");
              doc.setTextColor(68, 68, 68);
              doc.setFontSize(12);
              doc.roundedRect(25, 59, 165, 39, 1, 1);
              //doc.writeText(0, 48 ,'Departamento Solicitante: '+ data.data[i].departamento,{align:'right',width:190});
              doc.writeText(0, 45 ,'INFORME DE CALCULO DE COMBUSTIBLE',{align:'right',width:190});
              doc.writeText(0, 53 ,data.data[i].solicitud,{align:'right',width:190});
              
              doc.setFontType("bold");
              doc.setTextColor(68, 68, 68);
              doc.setFontSize(10);
               doc.writeText(30, 58 ,'DATOS TOMADOS EN CUENTA PARA CALCULO DE COMBUSTIBLE:' ,{align:'left',width:190});
              doc.writeText(30, 63 , 'Distancia en Km a lugar de destino:'+ data.data[i].dis,{align:'left',width:190});
               doc.writeText(30, 68 , 'Distancia Guatemala destino y viceversa:'+ data.data[i].dis,{align:'left',width:190});
               doc.writeText(30, 73 , 'Dias aproximados de recorrido:'+ data.data[i].dias,{align:'left',width:190});
                doc.writeText(30, 78 , 'Recorrido interno perimetro del destino:'+ data.data[i].km_interno,{align:'left',width:190});
                 doc.writeText(30, 83 , 'Precio por galon:'+ data.data[i].p_galon,{align:'left',width:190});
                 doc.writeText(30, 88 , 'Rendimiento del Vehiculo:'+ data.data[i].rendimiento,{align:'left',width:190});
                 doc.writeText(30, 93 , 'Total en quetzales: Q'+ data.data[i].res_calculo,{align:'left',width:190});
                  doc.writeText(0, 93 , '__Redondeado a : Q'+ data.data[i].monto,{align:'center',width:190});
              documento = data.data[i].solicitud;

              f_d_solicitud = data.data[i].fecha_solicitud;

              doc.setFontSize(9);

              doc.setTextColor(255, 255, 255);
              doc.setDrawColor(0, 136, 176);
            	doc.setFillColor(0, 136, 176);
              doc.roundedRect(25, rect, 165, 8, 1, 1, 'FD');
              doc.setFontType("normal");

              doc.text(28, p1, data.data[i].placa);
              doc.writeText(28, p1 ,data.data[i].vehiculo,{align:'center',width:55});
              doc.writeText(42, p1 ,data.data[i].linea,{align:'center',width:60});

               doc.writeText(88, p1 ,data.data[i].rendimiento,{align:'center',width:10});
              doc.writeText(112, p1 ,data.data[i].combustible,{align:'center',width:10});
              doc.writeText(132, p1 ,data.data[i].entregado_a,{align:'center',width:30});
              doc.text(174, p1, 'Q');
              doc.writeText(187, p1 ,data.data[i].monto,{align:'right',width:0});

              total +=parseFloat(data.data[i].monto);

              p1 +=10;
              rect +=10;
              solicitante=data.data[i].solicitante;
              titulo=data.data[i].desc;
            }


            doc.text(147, p1, 'Total Solcitado  :  Q ');
            doc.writeText(5, p1,total+'.00',{align:'right',width:181});
            p1+=20;


            var string = titulo.replace(/f7/g,'\n\n');
            doc.setTextColor(68, 68, 68);

            var lMargin=25; //left margin in mm
           var rMargin=25; //right margin in mm
           var pdfInMM=210;  // width of A4 in mm
       		 var lines =doc.splitTextToSize(string, (pdfInMM-lMargin-rMargin));
            doc.text(lMargin,p1,lines);


            /*var p_lineas = doc.splitTextToSize(titulo, 165);
            //doc.text(25, p1, p_lineas);

            $.each( p_lineas, function( key, value ) {
              arregloDeSubCadenas = value.split('/');
              //alert(key);
              doc.text(25, p1, arregloDeSubCadenas);
              if(key==1 || key==3 || key==5){
                p1+=10
              }
              else{
                p1+=5;
              }


            });*/





            //doc.setDrawColor(215,215,215);
            //doc.line(30, 240, 100, 240);
          //  doc.writeText(30, 244,solicitante,{align:'center',width:75});


            doc.setFontSize(8);
            doc.setTextColor(5, 83, 142);
            doc.writeText(0, 258 ,'Reporte Generado vicesis - Módulo control de cupones',{align:'center',width:215});
            doc.addImage(footer, 'png', 0, 260, 216, 15);
            doc.setFontSize("8");
            doc.setTextColor(68, 68, 68);
            doc.writeText(0, 10 ,'Fecha y hora en la que se creó la solicitud: '+f_d_solicitud,{align:'right',width:190});


            doc.autoPrint()
            doc.save('Solicitud - '+ documento +'.pdf');
          }


  }).done( function(data) {
  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}
