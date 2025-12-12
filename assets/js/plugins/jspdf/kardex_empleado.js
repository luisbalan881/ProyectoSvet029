$(function(){
   $("input[name='foto']").on("change", function(){
       var formData = new FormData($("#em_form")[0]);
       var ruta = "usuarios/php/subir_foto.php";
       $.ajax({
           url: ruta,
           type: "POST",
           data: formData,
           contentType: false,
           processData: false,
           success: function(datos)
           {
               $("#fotografia").html(datos);
               $(".img-contenedor_profile").html( $('<img/>', {
        src: 'usuarios/fotos/'+datos,
        alt: ''
    }));
           }
       });
   });
});


function HTMLtoPDF(){
  mm = $('#fotografia').text();
  if((mm == 'Error, el archivo no es una imagen')||
     (mm == 'Error, el tamaño máximo permitido es un 4MB')||
     (mm == 'Error la anchura y la altura maxima permitida es 500px') ||
     (mm == 'Error la anchura y la altura mínima permitida es 200px'))
  {
  alert('Necesita subir una imagen válida');

}
else {
  if(mm == 'No posee Fotografía')
  {
    mm= 'user.png';
    convertir_imagen(mm);
  }
  else {
  convertir_imagen(mm);
  }

}



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

function convertir_imagen(foto)
{

  var imageUrl = 'usuarios/fotos/'+foto;
  var convertType = 'Canvas';
  var convertFunction = convertType === 'FileReader' ?
    convertFileToDataURLviaFileReader :
    convertImgToDataURLviaCanvas;
    var x;
  convertFunction(imageUrl, function(base64Img) {

     //x = $('.output').find('.link').attr('href', base64Img).text(base64Img).end().show();
     //return base64Img;
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
		//seccion datos personales
		doc.text(112, 58, document.getElementById("user_nm11").value);
		doc.text(112, 63, document.getElementById("user_nm22").value);
		doc.text(112, 68, document.getElementById("user_ap11").value);
		doc.text(112, 73, document.getElementById("user_ap22").value);

		doc.text(112, 83, document.getElementById("fecha_nac").value);
		doc.text(112, 88, document.getElementById("user_lugar_nac").value);
		doc.text(112, 93, $('#user_civil option:selected').text());
		doc.text(112, 98, $('#nacionalidad option:selected').text());

		doc.text(112, 103, $('#user_genre option:selected').text());
		doc.text(112, 108, document.getElementById("user_direccion").value);
		doc.text(112, 113, document.getElementById("user_cui").value);
		doc.text(112, 118, document.getElementById("user_movil").value);

		var p_d = document.getElementById("user_prof").value;
		var p_lineas = doc.splitTextToSize(p_d, 100);
		doc.text(112, 123, p_lineas);

		//sección datos laborales

		doc.text(112, 148, document.getElementById("user_acuerdo").value);
		doc.text(112, 153, document.getElementById("fecha_acuerdo").value);
		doc.text(112, 158, document.getElementById("user_partida").value);
		doc.text(112, 163, $('#dep_id option:selected').text());
		doc.text(112, 168, document.getElementById("user_cargo").value);
		doc.text(112, 173, document.getElementById("user_puesto").value);
		doc.text(112, 178, document.getElementById("user_igss").value);
		doc.text(112, 183, document.getElementById("user_nit").value);

		doc.text(112, 188, document.getElementById("fecha_posesion").value);
		doc.text(112, 193, document.getElementById("fecha_inicio").value);
		doc.text(112, 198, document.getElementById("fecha_fin").value);

		var r_d = $('#renglon option:selected').text();
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
    if(r_d == '029 - Otras remuneraciones de personal temporal'){
      doc.text(72, 228, '      Honorarios:');
      doc.writeText(0, 228 ,$("#sb").val(),{align:'right',width:180});
    }
    else{
      doc.text(72, 228, '200   Bono 66-200:');
  		doc.text(72, 233, '853   Bono Vicepresidencial:');
  		doc.text(72, 238, '---      Complemento Personal:');
  		doc.text(72, 243, '553   Bono por Antigüedad:');
  		doc.text(72, 248, '---      Bono Profesional:');
      doc.text(72, 253, '---      Gastos de Representación:');

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

      doc.writeText(0, 228 ,$("#b66").val(),{align:'right',width:180});
      doc.writeText(0, 233 ,$("#bv").val(),{align:'right',width:180});
      doc.writeText(0, 238 ,$("#cp").val(),{align:'right',width:180});
      doc.writeText(0, 243 ,$("#ba").val(),{align:'right',width:180});
      doc.writeText(0, 248 ,$("#bp").val(),{align:'right',width:180});
      doc.writeText(0, 253 ,$("#gr").val(),{align:'right',width:180});

      /*doc.writeText(0, 253 ,$("#ig").val(),{align:'right',width:204});
      doc.writeText(0, 258 ,$("#mo").val(),{align:'right',width:204});
      doc.writeText(0, 263 ,$("#d81").val(),{align:'right',width:204});*/


      doc.setDrawColor(137, 137, 137);
  		doc.line(150, 271, 208, 271);

      doc.writeText(0, 268 ,$("#sb").val(),{align:'right',width:180});
      //doc.writeText(0, 276 ,$("#sg").val(),{align:'right',width:204});

      doc.writeText(0, 276 ,$("#to").val(),{align:'right',width:180});
      //doc.writeText(0, 281 ,$("#li").val(),{align:'right',width:180});
    }


    // FINAL DE LA PÁGINA
     doc.addImage(base64Img, 'png', 10, 43, 50, 60);
     doc.setFontSize(8);
		 doc.setTextColor(5, 83, 142);
     doc.writeText(7, 308 ,'Reporte Generado vicesis - Módulo control Empleados',{align:'center',width:215});
     doc.addImage(footer, 'png', 9, 310, 209, 15);
     //doc.writeText(0, 300 ,'-- Formato interno --',{align:'center',width:210});
     doc.save('Kardex - '+ $('#user_nm11').val() +' '+ $('#user_nm22').val() +' '+ $('#user_ap11').val() +' '+ $('#user_ap22').val() + '.pdf');
  });



  //event.preventDefault();
};
