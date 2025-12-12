function load_solicitud_id(year,mes,solicitud,dep_id)
{
  $('#cerrar_this').fadeIn(1000);
  $.post("combustible/php/get_listado_vehiculos_solicitud_id.php",
  { year:year,mes:mes,solicitud:solicitud,dep_id:dep_id},
   function(data){
  $("#lista").fadeOut(0).html(data).fadeIn(600);

  });
}

function get_solicitud_vehiculo_by_id(year,mes,solicitud_id,vehiculo_id,dep_id)
{
  $('#cerrar_this').hide();
    //alert("seleccionaste : "+ id + " " + vid);
    $.post("combustible/php/asignar_cupones_vehiculo_solicitud_id.php",
    { year:year,mes:mes,solicitud_id:solicitud_id,vehiculo_id:vehiculo_id,dep_id:dep_id},
     function(data){
    $("#lista").fadeOut(0).html(data).fadeIn(600);

    });


}

function get_kilometraje_vehiculo_by_id(year,mes,solicitud_id,vehiculo_id,dep_id)
{
  //$('#cerrar_this').hide();
    //alert("seleccionaste : "+ id + " " + vid);
    $.post("combustible/php/asignar_kilometros_cupon_vehiculo.php",
    { year:year,mes:mes,solicitud_id:solicitud_id,vehiculo_id:vehiculo_id,dep_id:dep_id},
     function(data){
    $("#kilometrajes").fadeOut(0).html(data).fadeIn(600);

    });


}

function load_devolver_vehiculo(year,mes,solicitud_id,vehiculo_id,dep_id)
{
  $('#cerrar_this').hide();
    //alert("seleccionaste : "+ id + " " + vid);
    $.post("combustible/php/devolver_cupones_vehiculo_solicitud_id.php",
    { year:year,mes:mes,solicitud_id:solicitud_id,vehiculo_id:vehiculo_id,dep_id:dep_id},
     function(data){
    $("#lista").fadeOut(0).html(data).fadeIn(600);

    });


}
