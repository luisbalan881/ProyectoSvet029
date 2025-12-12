function generar_horario(id,mes,year){

  if(mes<10){
    mes='0'+mes;
  }

  $.ajax({
    type: "POST",
    url: "usuarios/php/hoja_horario_user.php",
    data: {id:id,mes:mes,year:year}, //f de fecha y u de estado.
  dataType:'json',


    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){

            var doc = new jsPDF('p','mm');


            p1 = 100;

            doc.setFontType("bold");
            doc.setFontSize(14);
            doc.setTextColor(68, 68, 68);



            doc.setTextColor(68, 68, 68);
            doc.setFontType("normal");
            doc.setTextColor(68, 68, 68);
            doc.setFontSize(10);
            var empleado;
            var departamento;
            var titulo;
            var total;

            for(var i = 0; i < data.data.length; i++) {

              doc.setFontSize(8);
              empleado = data.data[i].emp;
              departamento = data.data[i].departamento;
              titulo =  data.data[i].titulo;


              doc.text(27, p1, data.data[i].fecha_laboral);
              doc.text(48, p1, data.data[i].dia);
              doc.writeText(67, p1 ,data.data[i].tipo_dia,{align:'center',width:70});
              doc.text(146, p1, data.data[i].hora_en);
              doc.text(164, p1, data.data[i].hora_sal);


              doc.writeText(175, p1 ,data.data[i].horas,{align:'center',width:20});


              if(data.data[i].dia=='Viernes')
              {
                p1 +=12;
              }else {
                p1 +=3.5;
              }

              total=data.data[i].total;


            }

            doc.writeText(27, p1+10 ,'Horas trabajadas en el mes '+ total,{align:'right',width:163});

            doc.setDrawColor(0, 136, 176);
        		doc.setFillColor(255, 255, 255);
            doc.line(45, 83, 45, p1);
            doc.line(62, 83, 62, p1);
            doc.line(142, 83, 142, p1);
            doc.line(161, 83, 161, p1);
            doc.line(178, 83, 178, p1);
            p1-=82;

            doc.setFontType("bold");
            doc.setFontSize(13.5);
            doc.writeText(0, 65 ,'Reporte de Horas trabajadas correspondientes al mes de '+ titulo,{align:'center',width:215});
            doc.setFontSize(10);
            doc.setFontType("normal");
            doc.text(30, 75, "Empleado: ");
            doc.text(50, 75, empleado);

            doc.text(130, 75, "Departamento: ");
            doc.text(160, 75, departamento);


            //rectángulo general
            doc.setFontSize(12);
            doc.setTextColor(255, 255, 255);
            doc.setDrawColor(0, 136, 176);
        		doc.setFillColor(0, 136, 176);
        		doc.roundedRect(24, 83, 168, 12, 1, 1, 'FD');
            doc.text(27, 89, '  Fecha       Dia                                                                           Entrada     Salida');



        		doc.roundedRect(24, 83, 168, p1, 1, 1);





            //titulo kardex
            doc.addImage(logo, 'png', 20, 15, 60, 35);

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
