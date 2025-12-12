

function cargar_panel(id){



  $.ajax({
      type: "POST",
      url:'usuarios/empleado_modificar_datos.php',
      data:{id:id},
      beforeSend:function(){
            $("#template").fadeOut(0).html('<div class="loaderr"></div><br>').fadeIn(100);
            },
      success: function(data){

        $("#template").fadeOut(0).html(data).fadeIn(300);
        /*setTimeout(function(){
          $("#template").animate({
         height: 647
      }, 600);
                       $("#template").html(data);
                  }, 300);*/

      }
  });
}

function cargar_panel_ascensos(id){


$('#xyx').removeClass('contorno2');
  $.ajax({
      type: "POST",
      url:'usuarios/php/get_user_ascencos_contratos_listado.php',
      data:{id:id},
      beforeSend:function(){
            $("#template").fadeOut(0).html('<div class="loaderr"></div><br>').fadeIn(100);
            },
      success: function(data){

        $("#template").fadeOut(0).html(data).fadeIn(300);
        /*setTimeout(function(){
          $("#template").animate({
         height: 647
      }, 600);
                       $("#template").html(data);
                  }, 300);*/
      }
  });
}


function nueva_partida(id,renglon){
  var url;
  var altura;
  if(renglon=='011' || renglon=='022'){
    url = 'usuarios/php/011_nuevo_ascenso_user.php';
    altura=495;
  }else if(renglon='029') {
    url = 'usuarios/php/029_nuevo_contrato_user.php';
    altura=495;
  }
  $.ajax({
      type: "POST",
      url:url,
      data:{id:id},
      beforeSend:function(){
            $("#template").fadeOut(0).html('<div class="loaderr"></div><br>').fadeIn(100);
            },
      success: function(data){

        $("#template").fadeOut(0).html(data).fadeIn(300);
        /*setTimeout(function(){
          $("#template").animate({
         height: 647
      }, 600);
                       $("#template").html(data);
                  }, 300);*/
      }
  });
}

function editar_partida(id,correlativo,renglon){
  var url;
  var altura;
  if(renglon=='011'){
    url = 'usuarios/php/011_ascenso_user.php';
    altura=495;
  }else if(renglon='029') {
    url = 'usuarios/php/029_contrato_user.php';
    altura=495;
  }
  $.ajax({
      type: "POST",
      url:url,
      data:{id:id,correlativo:correlativo},
      beforeSend:function(){
            $("#template").fadeOut(0).html('<div class="loaderr"></div><br>').fadeIn(100);
            },
      success: function(data){

        $("#template").fadeOut(0).html(data).fadeIn(300);
        /*setTimeout(function(){
          $("#template").animate({
         height: 647
      }, 600);
                       $("#template").html(data);
                  }, 300);*/
      }
  });
}


function finalizar_partida(id,correlativo,renglon){
  var url;
  var altura;
  url = 'usuarios/php/destitucion.php';
  altura=225;
  $.ajax({
      type: "POST",
      url:url,
      data:{id:id,correlativo:correlativo},
      beforeSend:function(){
            $("#template").fadeOut(0).html('<div class="loaderr"></div><br>').fadeIn(100);
            },
      success: function(data){

        $("#template").fadeOut(0).html(data).fadeIn(300);
        /*setTimeout(function(){
          $("#template").animate({
         height: 647
      }, 600);
                       $("#template").html(data);
                  }, 300);*/

      }
  });
}
