<?php
require_once '../../inc/Database.php';
$empleado = $_POST['empleado'];
if (isset($_FILES["foto"]))
{
    $file = $_FILES["foto"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    $carpeta = "../fotos/";

    if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif')
    {
      echo "<label class='label label-danger'>Error, el archivo no es una imagen</label>";
    }
    else if ($size > 4096*4096)
    {
      echo "<span class='label label-danger'>Error, el tamaño máximo permitido es un 4MB</span>";
    }
    else if ($width > 1000 || $height > 1000)
    {
        echo "<span class='label label-danger'>Error la anchura y la altura maxima permitida es 1000px</span>";
    }
    /*else if ($width > 600 || $height > 600)
    {
        echo "<span class='label label-danger'>Error la anchura y la altura maxima permitida es 500px</span>";
    }*/
    else if($width < 200 || $height < 200)
    {
        echo "<span class='label label-danger'>Error la anchura y la altura mínima permitida es 200px</span>";
    }
    else
    {
        $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
        //echo "<img src='$src'>";

        echo $nombre;
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql2 = "UPDATE vp_user_datos_laborales SET fotografia=?WHERE user_id=?";
        $q2 = $pdo->prepare($sql2);
        $q2->execute(array($nombre,$empleado));

        $sql3 = "UPDATE vp_user_011_029_historial SET fotografia=?WHERE user_id=?";
        $q3 = $pdo->prepare($sql3);
        $q3->execute(array($nombre,$empleado));

        Database::disconnect();
    }
}
?>
