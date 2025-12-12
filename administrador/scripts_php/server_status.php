

<?php
//require_once '../../inc/Database.php';
if (!isset($_SERVER['HTTP_REFERER'])){

echo "<script type='text/javascript'> window.location='index.php'; </script>";
exit();


}

else {
  $enlace = new mysqli("localhost", "viceadmi", "3&9Ve8*59qi", "vicepresidencia");

  /* comprobar la conexión */
  if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}

echo "Estado del sistema: <br>". mysqli_stat($enlace);

mysqli_close($enlace);

}


 ?>
