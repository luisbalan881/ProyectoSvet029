<?php
require_once '../../inc/Database.php';
$tipo = $_FILES['archivo']['type'];
$tamanio = $_FILES['archivo']['size'];
$archivotmp = $_FILES['archivo']['tmp_name'];

//cargamos el archivo
$lineas = file($archivotmp);

//inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
$i=0;

//Recorremos el bucle para leer línea por línea
foreach ($lineas as $linea_num => $linea)
{
  set_time_limit(0);//limite de tiempo cero para poder recorrer todo el archivo.txt
   //abrimos bucle
   /*si es diferente a 0 significa que no se encuentra en la primera línea
   (con los títulos de las columnas) y por lo tanto puede leerla*/
   if($i != 0)
   {
       //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
       /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá
       leyendo hasta que encuentre un ; */
       $datos = explode(",",$linea);

       //Almacenamos los datos que vamos leyendo en una variable
       //usamos la función utf8_encode para leer correctamente los caracteres especiales
       $user_vid = $datos[0];
       $user_horario = $datos[2];

       $pdo = Database::connect();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       //guardamos en base de datos la línea leida
       $sql = "INSERT IGNORE INTO vp_user_horario(user_id_huella, horario) VALUES (?,?)";
       $q = $pdo->prepare($sql);
       $q->execute(array($user_vid, $user_horario));

       Database::disconnect();


       //cerramos condición
   }

   /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya
   entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
   $i++;

    echo 'succefull';
   //cerramos bucle



}

 ?>
