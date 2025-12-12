function HTMLtoPDF(emp,correlativo){

  $.ajax({
    type: "POST",
    url: "usuarios/php/get_fotografia.php",
    data: {emp:emp,correlativo:correlativo}, //f de fecha y u de estado.
    dataType: 'json',

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){

          convertir_imagen(data.foto,emp,correlativo);
          }
        });


}





function convertImgToDataURLviaCanvas(url, callback, outputFormat) {
var img = new Image();
img.crossOrigin = 'Anonymous';
img.onload = function() {
var canvas = document.createElement('CANVAS');
var ctx = canvas.getContext('2d');
var dataURL;
canvas.height = this.height;
canvas.width = this.width;
ctx.drawImage(this, 0, 0);
dataURL = canvas.toDataURL(outputFormat);
callback(dataURL);
canvas = null;
};
img.src = url;
}

function convertImgToDataURLviaCanvas(url, callback, outputFormat) {
var img = new Image();
img.crossOrigin = 'Anonymous';
img.onload = function() {
var canvas = document.createElement('CANVAS');
var ctx = canvas.getContext('2d');
var dataURL;
canvas.height = this.height;
canvas.width = this.width;
ctx.drawImage(this, 0, 0);
dataURL = canvas.toDataURL(outputFormat);
callback(dataURL);
canvas = null;
};
img.src = url;
}

function convertir_imagen(foto,emp, correlativo)
{
  var f=foto;
  if(foto=='')
  {
    f='user.png';
  }

  var imageUrl = 'usuarios/fotos/'+f;
  var convertType = 'Canvas';
  var convertFunction = convertType === 'FileReader' ?
    convertFileToDataURLviaFileReader :
    convertImgToDataURLviaCanvas;
    var x;
  convertFunction(imageUrl, function(base64Img) {

     //x = $('.output').find('.link').attr('href', base64Img).text(base64Img).end().show();
     //return base64Img;

     $.ajax({
       type: "POST",
       url: "usuarios/php/hoja_otros.php",
       data: {emp:emp,correlativo:correlativo}, //f de fecha y u de estado.
       dataType: 'json',

       beforeSend:function(){
                     //$('#response').html('<span class="text-info">Loading response...</span>');


             },
             success:function(data){
               //alert(data);
               var doc = new jsPDF('p','mm',[216,334]);
               doc.setFontType("normal");


          		 //rectángulo general

          		 //titulo kardex
               doc.addImage(logo, 'png', 10, 5, 50, 30);

          				 //doc.setFont('courier');

          				 doc.setFontSize(13);
          				 doc.setTextColor(56, 63, 71);
                   doc.setTextColor(108, 117, 125);
               		doc.setFontType("bold");
                   doc.writeText(0, 20 ,'VICEPRESIDENCIA DE LA REPÚBLICA',{align:'center',width:210});
                   doc.writeText(0, 25 ,'TARJETA KARDEX',{align:'center',width:210});

          		doc.setDrawColor(137, 137, 137);
          		//doc.line(10, 39, 208, 39);
          		//doc.roundedRect(10, 30, 63, 80, 3, 3);
          		//fin titulo

          		//vertical lines

          		doc.setFontSize(12);
          		doc.setDrawColor(0, 171, 255);
          		doc.setFillColor(0, 171, 255);
              doc.setDrawColor(0, 136, 176);
              doc.setFillColor(0, 136, 176);
          		doc.roundedRect(68, 43, 140, 8, 1, 1, 'FD');
          		doc.setTextColor(255, 255, 255);
          		doc.setFontType("bold");
          		doc.text(72, 48, 'Datos Personales');

          		doc.setFillColor(0, 171, 255);
              doc.setDrawColor(0, 136, 176);
              doc.setFillColor(0, 136, 176);
          		doc.roundedRect(68, 133, 140, 8, 1, 1, 'FD');
          		doc.text(72, 138, 'Datos Laborales');
          		//titulos en azul
          		doc.setTextColor(6, 90, 155);
          		doc.setFontSize(8);
          		doc.setFontType("normal");
          		doc.text(72, 58, '1er. Nombre:');
          		doc.text(72, 63, '2do. Nombre:');
          		doc.text(72, 68, '1er. Apellido:');
          		doc.text(72, 73, '2do. Apellido:');
          		doc.text(72, 78, 'Apellido Casada:');

          		doc.text(72, 83, 'Fecha de Nacimiento:');
          		doc.text(72, 88, 'Lugar de Nacimiento:');
          		doc.text(72, 93, 'Estado Civil:');
          		doc.text(72, 98, 'Nacionalidad:');

          		doc.text(72, 103, 'Género:');
          		doc.text(72, 108, 'Dirección:');
          		doc.text(72, 113, 'CUI:');
          		doc.text(72, 118, 'Móvil:');
          		doc.text(72, 123, 'Profesión U Oficio:');





          		doc.setTextColor(56, 63, 71);
          		//seccion datos personales
              doc.text(112, 58, data.nom_1);
          		doc.text(112, 63, data.nom_2);
          		doc.text(112, 68, data.ape_1);
          		doc.text(112, 73, data.ape_2);

              doc.text(112, 83, data.fecha_nac);
          		doc.text(112, 88, data.lugar_nac);
              doc.text(112, 93, data.e_civil);
          		doc.text(112, 98, data.e_nac);

              doc.text(112, 103, data.e_genero);
              doc.text(112, 108, data.e_direccion);
          		doc.text(112, 113, data.e_cui);
          		doc.text(112, 118, data.e_movil);

          		var p_d = data.e_prof;
          		var p_lineas = doc.splitTextToSize(p_d, 100);
          		doc.text(112, 123, p_lineas);

          		//sección datos laborales
              if(data.renglon =='029')
              {
                doc.setTextColor(6, 90, 155);
            		doc.setFontSize(8);
            		doc.setFontType("normal");
                doc.text(72, 148, 'Acuerdo:');
            		doc.text(72, 153, 'Fecha:');
            		doc.text(72, 158, 'Partida:');
            		doc.text(72, 163, 'Contrato No.:');

            		doc.text(72, 168, 'Fecha:');
            		doc.text(72, 173, 'Fianza:');

            		doc.text(72, 178, 'Inicio:');
            		doc.text(72, 183, 'Fin:');

            		doc.text(72, 188, 'Dependencia:');
            		doc.text(72, 193, 'Cargo:');
            		doc.text(72, 198, 'Puesto Funcional:');

            		doc.text(72, 203, 'IGSS:');
                doc.text(72, 208, 'NIT:');

            		doc.text(72, 213, 'Fecha Posesión:');
            		doc.text(72, 218, 'Fecha Inicio:');
            		doc.text(72, 223, 'Fecha Destitución:');

            		doc.text(72, 228, 'Renglón:');

                doc.setTextColor(56, 63, 71);
                doc.text(112, 148, data.e_acuerdo);
            		doc.text(112, 153, data.e_acuerdo_fecha);
            		doc.text(112, 158, data.e_partida);
            		doc.text(112, 163, data.e_contrato);
            		doc.text(112, 168, data.contrato_fecha);
            		doc.text(112, 173, data.fianza);
            		doc.text(112, 178, data.c_ini);
            		doc.text(112, 183, data.c_fin);

            		doc.text(112, 188, data.dep);
            		doc.text(112, 193, data.cargo);
            		doc.text(112, 198, data.puesto);
            		doc.text(112, 203, data.igss);
            		doc.text(112, 208, data.nit);

            		doc.text(112, 213, data.f_posesion);
            		doc.text(112, 218, data.f_inicio);
            		doc.text(112, 223, data.f_destitucion);
            		var r_d = data.renglon_nm;
            		var r_lineas = doc.splitTextToSize(r_d, 100);
            		doc.text(112, 228, r_lineas);



                doc.setDrawColor(0, 171, 255);
            		doc.setFillColor(0, 171, 255);
                doc.setDrawColor(0, 136, 176);
                doc.setFillColor(0, 136, 176);
            		doc.roundedRect(68, 238, 140, 8, 1, 1, 'FD');
            		doc.setTextColor(255, 255, 255);
            		doc.setFontType("bold");
                doc.setFontSize(12);
                doc.text(72, 243, 'Nombre');
            		doc.text(160, 243, 'Ingresos');
                //doc.text(190, 218, 'Gastos');


                doc.setTextColor(6, 90, 155);
                doc.setFontSize(8);
                doc.setFontType("normal");

                doc.text(72, 253, 'Honorarios:');
                doc.setTextColor(56, 63, 71);
                doc.writeText(0, 253 ,data.s_base,{align:'right',width:177});

                if(data.f_destitucion!=''){
                  doc.setDrawColor(0, 171, 255);
                  doc.setFillColor(0, 171, 255);
                  doc.setDrawColor(0, 136, 176);
                  doc.setFillColor(0, 136, 176);
                  doc.roundedRect(68, 263, 140, 8, 1, 1, 'FD');
                  doc.setTextColor(255, 255, 255);
                  doc.setFontType("bold");
                  doc.setFontSize(12);
                  doc.text(72, 268, 'Finalización del Contrato');

                  //doc.text(190, 218, 'Gastos');


                  doc.setTextColor(6, 90, 155);
                  doc.setFontSize(8);
                  doc.setFontType("normal");

                  doc.text(72, 278, 'Resolución No.:');
                  doc.text(72, 283, 'Resolución Fecha:');
                  doc.text(72, 288, 'Fecha destitución:');
                  doc.text(72, 293, 'Motivo :');

                  doc.text(112, 278, data.resolucion);
                  doc.text(112, 283, data.resolucion_fecha);
                  doc.text(112, 288, data.f_destitucion);

                  var r_d11 = data.literal;
              		var r_lineas11 = doc.splitTextToSize(r_d11, 100);
              		doc.text(112, 293, r_lineas11);
                }


              }
              else {
                doc.setTextColor(6, 90, 155);
            		doc.setFontSize(8);
            		doc.setFontType("normal");
                //datos Laborales
            		doc.text(72, 148, 'Acuerdo:');
            		doc.text(72, 153, 'Fecha:');
            		doc.text(72, 158, 'Partida:');
            		doc.text(72, 163, 'Dependencia:');

            		doc.text(72, 168, 'Cargo:');
            		doc.text(72, 173, 'Puesto Funcional:');

            		doc.text(72, 178, 'IGSS:');
            		doc.text(72, 183, 'NIT:');

            		doc.text(72, 188, 'Fecha Posesión:');
            		doc.text(72, 193, 'Fecha Inicio:');
            		doc.text(72, 198, 'Fecha Destitución:');

            		doc.text(72, 203, 'Renglón:');

                doc.setTextColor(56, 63, 71);
                doc.text(112, 148, data.e_acuerdo);
            		doc.text(112, 153, data.e_acuerdo_fecha);
            		doc.text(112, 158, data.e_partida);
            		doc.text(112, 163, data.dep);
            		doc.text(112, 168, data.cargo);
            		doc.text(112, 173, data.puesto);
            		doc.text(112, 178, data.igss);
            		doc.text(112, 183, data.nit);

            		doc.text(112, 188, data.f_posesion);
            		doc.text(112, 193, data.f_inicio);
            		doc.text(112, 198, data.f_destitucion);

            		var r_d = data.renglon_nm;
            		var r_lineas = doc.splitTextToSize(r_d, 100);
            		doc.text(112, 203, r_lineas);

                doc.setDrawColor(0, 171, 255);
            		doc.setFillColor(0, 171, 255);
                doc.setDrawColor(0, 136, 176);
                doc.setFillColor(0, 136, 176);
            		doc.roundedRect(68, 213, 140, 8, 1, 1, 'FD');
            		doc.setTextColor(255, 255, 255);
            		doc.setFontType("bold");
                doc.setFontSize(12);
                doc.text(72, 218, 'Nombre');
            		doc.text(160, 218, 'Ingresos');
                //doc.text(190, 218, 'Gastos');


                doc.setTextColor(6, 90, 155);
            		doc.setFontSize(8);
            		doc.setFontType("normal");

                doc.text(72, 228, '200   Bono 66-200:');
                doc.text(72, 233, '853   Bono Vicepresidencial:');
                doc.text(72, 238, '---      Complemento Personal:');
                doc.text(72, 243, '553   Bono por Antigüedad:');
                doc.text(72, 248, '---      Bono Profesional:');
                doc.text(72, 253, '---      Gastos de Representación:');
                  //GASTOS

                  //GASTOS
              		/*doc.text(72, 253, '317   I.G.S.S.:');
              		doc.text(72, 258, '318   Montepio:');
              		doc.text(72, 263, '321   Decreto 81-70:');*/
              		doc.text(72, 268, '---   Sueldo Base:');

              		doc.text(125, 276, 'Total:');
              		//doc.text(125, 281, 'Líquido:');
              		//doc.text(72, 270, 'CUI:');
              		//doc.text(72, 275, 'Móvil:');
                  doc.setTextColor(56, 63, 71);
              		//seccion datos personales

                  doc.writeText(0, 228 ,data.b_66,{align:'right',width:177});
                  doc.writeText(0, 233 ,data.b_v,{align:'right',width:177});
                  doc.writeText(0, 238 ,data.c_p,{align:'right',width:177});
                  doc.writeText(0, 243 ,data.b_a,{align:'right',width:177});
                  doc.writeText(0, 248 ,data.b_p,{align:'right',width:177});
                  doc.writeText(0, 253 ,data.g_r,{align:'right',width:177});

                  /*doc.writeText(0, 253 ,$("#ig").val(),{align:'right',width:204});
                  doc.writeText(0, 258 ,$("#mo").val(),{align:'right',width:204});
                  doc.writeText(0, 263 ,$("#d81").val(),{align:'right',width:204});*/


                  doc.setDrawColor(137, 137, 137);
              		doc.line(150, 271, 208, 271);

                  doc.writeText(0, 268 ,data.s_base,{align:'right',width:177});
                  //doc.writeText(0, 276 ,$("#sg").val(),{align:'right',width:204});

                  doc.writeText(0, 276 ,data.total,{align:'right',width:177});

              }








              // FINAL DE LA PÁGINA
               doc.addImage(base64Img, 'png', 10, 43, 50, 60);
               doc.setFontSize(8);
          		 doc.setTextColor(5, 83, 142);
               doc.writeText(7, 308 ,'Reporte Generado vicesis - Módulo control Empleados',{align:'center',width:215});
               doc.addImage(footer, 'png', 9, 310, 209, 15);
               //doc.writeText(0, 300 ,'-- Formato interno --',{align:'center',width:210});
               doc.save('Kardex '+data.nom_1+' '+ data.nom_2+' '+ data.ape_1+' '+ data.ape_2+'.pdf');

             }


     }).done( function() {










     }).fail( function( jqXHR, textSttus, errorThrown){

       console.log(errorThrown);
       console.log(textSttus);
       console.log(errorThrown);

     });



  });



  //event.preventDefault();
};
