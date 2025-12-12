<?php
require_once '../../inc/Database.php';

$user_id = $_POST['id'];
$password=$_POST['pw'];
$error_msg = '';
//$pwc=$_POST['pwc'];

/*$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
// Crea una contraseña con sal.
$password = hash('sha512', $password . $random_salt);
// Crear usuario con contraseña definida.
actualizarPassword($password, $random_salt, $user_id);

function actualizarPassword($password, $random_salt,$user_id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE vp_user SET user_pass = ?, user_salt = ?, user_mod = ?, user_rev = user_rev + 1 WHERE user_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($password, $random_salt,$user_id,$user_id));
    Database::disconnect();
}
*/
if (strlen($password) != 128) {
    // La contraseña con hash deberá ser de 128 caracteres.
    $error_msg = 'Contraseña no cumple los requisitos';
    echo $error_msg;
}
if (empty($error_msg)) {

$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
// Crea una contraseña con sal.
$password = hash('sha512', $password . $random_salt);


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user SET user_pass = ?, user_salt = ?, user_mod = ?, user_rev = user_rev + 1 WHERE user_id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($password, $random_salt,$user_id,$user_id));
Database::disconnect();
echo 'Password cambiado exitosamente';

}

 ?>
