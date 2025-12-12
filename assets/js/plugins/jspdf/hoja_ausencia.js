function menu(tipodia, emp, resolucion,autorizacion)
{
  if(tipodia==6){
    if(autorizacion==0)
    {
      alert('La resolución no ha sido autorizada');
    }
    else {
      datos_hoja_vacaciones(emp, resolucion);
    }

  }
  else
  if (tipodia==2){
    permiso();
  }
  else {
    alert('no existe');
  }
}



function permiso(){
  alert('hoja de permiso');
}




function datos_hoja_vacaciones(emp, resolucion){
  $.ajax({
    type: "POST",
    url: "usuarios/php/hoja_vacaciones.php",
    data: {emp:emp, resolucion:resolucion}, //f de fecha y u de estado.
  dataType:'json',


    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){

            var doc = new jsPDF('p','mm');

            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
            doc.setFontSize(10);
            doc.writeText(0, 70 ,data.fecha,{align:'right',width:190});

            doc.setFontType("bold");




            if(data.genre == 1){
              doc.text(25, 100, 'Señor');
            }
            else if(data.genre == 2){
              doc.text(25, 100, 'Señora');
            }
            doc.text(25, 105, data.emp);
            doc.text(25, 110, data.cargo);
            doc.text(25, 115, 'Presente');

            //rectángulo general


            //titulo kardex
            doc.addImage(logo, 'png', 20, 15, 60, 35);

            doc.setFontType("bold");


            doc.setFontSize(14);
            doc.writeText(0, 85 ,'NOTIFICACION DE VACACIONES',{align:'center',width:215});


            doc.setFontType("normal");
            doc.setTextColor(0, 0, 0);
            doc.setFontSize(10);
            var p_lineas = doc.splitTextToSize('                   Se le informa que de conformidad con su solicitud y de acuerdo con el artículo 61 inciso 2do. De la Ley de Servicio Civil, se le autoriza gozar vacaciones de la manera siguiente:', 165);
            doc.text(25, 130, p_lineas);

            doc.setDrawColor(0, 136, 176);
        		doc.setFillColor(0, 136, 176);
        		doc.roundedRect(25, 150, 165, 8, 1, 1, 'FD');
            doc.roundedRect(25, 160, 165, 8, 1, 1, 'FD');
            doc.roundedRect(25, 170, 165, 8, 1, 1, 'FD');

            doc.setTextColor(255, 255, 255);
        		doc.setFontType("normal");
        		doc.text(30, 155, 'Período Correspondiente:                                Del:                                      Al:');
            doc.text(30, 165, 'Inicio y Final de Vacaciones:                           Del:                                      Al:');
            doc.text(30, 175, 'Deberá presentarse el:');

            doc.setFontType("bold");
            doc.text(110, 155, data.periodo_i);
            doc.text(152, 155, data.periodo_f);

            doc.text(110, 165, data.fecha_i);
            doc.text(152, 165, data.fecha_f);
            doc.writeText(110, 175 ,data.fecha_r,{align:'center',width:50});


            doc.setDrawColor(98, 98, 98);
            doc.line(30, 210, 100, 210);
            doc.line(138, 231, 190, 231);
            doc.setTextColor(68, 68, 68);
       		  doc.text(105, 230, 'Recibí conforme: F');

            doc.setFontSize(8);
            doc.setTextColor(5, 83, 142);
            doc.writeText(0, 258 ,'Reporte Generado vicesis - Módulo empleados',{align:'center',width:215});
            doc.addImage(footer, 'png', 0, 260, 216, 15);

            doc.addPage();

            doc.addImage(logo, 'png', 20, 15, 60, 35);

            doc.setDrawColor(0, 136, 176);
        		doc.setFillColor(0, 136, 176);
        		doc.roundedRect(25, 115, 165, 15, 1, 1, 'FD');
            doc.setTextColor(255, 255, 255);
            var p_lineas = doc.splitTextToSize('               De conformidad con el artículo 61, inciso 2do De la Ley de Servicio Civil, atentamente solicito se me autorice el uso de vacaciones a que tengo derecho, en los términos expresados a continuación:', 160);

            doc.text(28, 120, p_lineas);


            doc.setDrawColor(225,225,225);
        		doc.setFillColor(255, 255, 255);
        		doc.roundedRect(25, 60, 165, 50, 1, 1);


            doc.setTextColor(68, 68, 68);
            doc.setFontType("normal");
            doc.text(60, 70, 'A:');
            doc.text(60, 90, 'De:');
            doc.text(60, 97, 'Puesto que ocupa:');
            doc.text(60, 104, 'Fecha:');

            doc.text(110, 70, 'Licda. '+data.autorizado);
            doc.text(110, 75, data.puesto);
            doc.text(110, 90, data.emp);
            doc.text(110, 97, data.cargo);
            //doc.text(110, 104, data.date);
            doc.text(110, 104, data.fecha_n);

            doc.setDrawColor(225,225,225);
        		doc.setFillColor(255, 255, 255);
        		doc.roundedRect(25, 135, 165, 50, 1, 1);

            doc.text(60, 145, 'Período Correspondiente:');
            doc.text(120, 145, 'Del:');
            doc.text(120, 150, 'Al:');
            doc.text(135, 145, data.periodo_i);
            doc.text(135, 150, data.periodo_f);

            doc.text(60, 160, 'Inicio y Final de Vacaciones:');
            doc.text(120, 160, 'Del:');
            doc.text(120, 165, 'Al:');
            doc.text(135, 160, data.fecha_i);
            doc.text(135, 165, data.fecha_f);


            doc.text(60, 175, 'Reanudación de labores:');
            doc.writeText(110, 175 ,data.fecha_r,{align:'center',width:50});
            //doc.text(60, 104, 'FECHA:');


            doc.setDrawColor(0, 136, 176);
        		doc.setFillColor(0, 136, 176);
        		doc.roundedRect(25, 190, 165, 15, 1, 1, 'FD');
            doc.setTextColor(255, 255, 255);

            doc.setTextColor(255, 255, 255);
        		doc.setFontType("normal");
        		doc.text(30, 196, 'No. Días Solicitados:');
            doc.text(82, 196, 'No. Días gozados anteriormente');
            doc.text(152, 196, 'No. Días pendientes');

            doc.setFontType("bold");
            doc.writeText(30, 201 ,data.dias_s,{align:'center',width:30});
            doc.writeText(82, 201 ,data.dias_g,{align:'center',width:50});
            doc.writeText(152, 201 ,data.dias_p,{align:'center',width:30});

            doc.setTextColor(68, 68, 68);
            doc.setDrawColor(98, 98, 98);
            doc.line(30, 235, 95, 235);
            doc.text(50, 240, 'SOLICITANTE');
            doc.line(125, 235, 190, 235);

       		  doc.text(112, 235, 'Vo.Bo.');
            doc.setFontSize(8);
            doc.setTextColor(5, 83, 142);
            doc.writeText(0, 258 ,'Reporte Generado vicesis - Módulo empleados',{align:'center',width:215});
            doc.addImage(footer, 'png', 0, 260, 216, 15);
            doc.autoPrint()
            doc.save('vacaciones - '+data.emp+' - '+data.date +'.pdf');

          }


  }).done( function(data) {
  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}
