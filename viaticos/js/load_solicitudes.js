
function load_solicitud(id)
{
    var $modal = $('#modal-remoto-lgg');
    $modal.load('../herramientas/transporte/solicitar_transporte.php', {id:id},
    function(){
      $modal.modal('show');

  });

}
