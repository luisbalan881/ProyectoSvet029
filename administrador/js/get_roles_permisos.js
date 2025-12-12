$(document).ready(function(){

            get_roles();
            get_permisos();
});


function get_roles(){

  $.post("../herramientas/administrador/scripts_php/get_roles.php",
   function(data){
  $("#roles").html(data);

  });



}

function get_permisos(){
  $.post("../herramientas/administrador/scripts_php/get_permisos.php",
   function(data){
  $("#permisoss").html(data);

  });
}


function add_role() {
  jQuery('.js-validation-role').validate({
      ignore: [],
      errorClass: 'help-block animated fadeInDown',
      errorElement: 'div',
      errorPlacement: function(error, e) {
          jQuery(e).parents('.form-group > div').append(error);
      },
      highlight: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error').addClass('has-error');
          elem.closest('.help-block').remove();
          $("#add_roler").removeClass('vibrar').addClass('vibrar');
      },
      success: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error');
          elem.closest('.help-block').remove();
          $("#add_roler").removeClass('vibrar');


      },
      submitHandler: function(form){

          var role= $("#role").val();


          $.ajax({

            type: "POST",
            url: "../herramientas/administrador/scripts_php/add_roles.php",
            data: {role:role}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    $("#loginFormR")[0].reset();
                    setTimeout(function(){
                                    $('#loading1').fadeOut("slow");
                               }, 500);
                     $('#message').fadeIn().html(data);
                     $("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    $('#message').fadeOut("slow");
                                    $('#loading1').fadeOut("slow");
                                    $('#modal-remoto').modal('hide');
                                      get_horarios_usuario();
                               }, 500);
                  }


          }).done( function() {

            get_roles();








          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });


      }


  });

}


function add_perm() {
  jQuery('.js-validation-perm').validate({
      ignore: [],
      errorClass: 'help-block animated fadeInDown',
      errorElement: 'div',
      errorPlacement: function(error, e) {
          jQuery(e).parents('.form-group > div').append(error);
      },
      highlight: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error').addClass('has-error');
          elem.closest('.help-block').remove();
          $("#add_permiso").removeClass('vibrar').addClass('vibrar');
      },
      success: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error');
          elem.closest('.help-block').remove();
          $("#add_permiso").removeClass('vibrar');


      },
      submitHandler: function(form){


        var perm= $("#perm").val();


        $.ajax({

          type: "POST",
          url: "../herramientas/administrador/scripts_php/add_permisos.php",
          data: {perm:perm}, //f de fecha y u de estado.

          beforeSend:function(){
                        //$('#response').html('<span class="text-info">Loading response...</span>');

                        $('#loading2').fadeIn("slow");
                },
                success:function(data){
                  //alert(data);
                  $("#loginFormP")[0].reset();
                  setTimeout(function(){
                                  $('#loading2').fadeOut("slow");
                             }, 500);
                   $('#message').fadeIn().html(data);
                   $("#message").addClass('alert alert-success');
                   setTimeout(function(){
                                  $('#message').fadeOut("slow");
                                  $('#loading').fadeOut("slow");
                                  $('#modal-remoto').modal('hide');
                                    get_horarios_usuario();
                             }, 500);

                }


        }).done( function() {
          get_permisos();





        }).fail( function( jqXHR, textSttus, errorThrown){

          alert(errorThrown);

        });



      }


  });

}
