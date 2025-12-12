function cargar(dir){
    var url=dir
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        success: function(datos){
            $('#tabla').slideToggle("slow").slideToggle("slow");
            $('#h').slideToggle("slow",function(){
              $('#back').css({"opacity":"0"}).show().animate({opacity:1});
            });

            $('#back').fadeOut(600,function(){
              $('back').hide();



            });
            $('#tabla2').fadeOut(0).html(datos).fadeIn(900);
        }
    });
}


$(document).ready(function(){
  var $modal = $('#modal-remoto-lgg2');
  $('#permisos').on('click', function(){
    $modal.load('administrador/permisos_roles.php',
    function(){
      $modal.modal('show');
    });
  });
});



function cargar2(dir){
    var url=dir
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        success: function(datos){

            $('#tabla2').html(datos);
        }
    });
}
