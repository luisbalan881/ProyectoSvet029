function load_solicitud_by_id(id)
{
var $modal = $('#modal-remoto');
$modal.load('transporte/ver_solicitud.php', {'id':id},
function(){
  $modal.modal('show');
});
}
