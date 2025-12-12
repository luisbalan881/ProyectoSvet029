
function load_solicitud(id)
{
    var $modal = $('#modal-remoto-lgg1');
    $modal.load('../herramientas/transporte/solicitar_transporte.php', {id:id},
    function(){
      $modal.modal('show');

  });

}
