<?php
 if(!empty($_FILES["archivo"]["name"]))
 {
      $connect = mysqli_connect("localhost", "root", "", "bd_svet_nueva");

      $output = '';
      $allowed_ext = array("csv");
      $extension = end(explode(".", $_FILES["archivo"]["name"]));
      if(in_array($extension, $allowed_ext))
      {
           $file_data = fopen($_FILES["archivo"]["tmp_name"], 'r');
           fgetcsv($file_data);
           while($row = fgetcsv($file_data))
           {
                set_time_limit(0);//limite de tiempo cero para poder recorrer todo el archivo.txt
                $user_vid = mysqli_real_escape_string($connect, $row[0]);
                $user_horario = mysqli_real_escape_string($connect, $row[2]);

                $query1 = "
                DELETE FROM vp_user_horario WHERE user_id_huella=$user_vid AND horario =$user_horario
                ";
                mysqli_query($connect, $query1);

                $query = "
                INSERT IGNORE INTO vp_user_horario(user_id_huella, horario)
                VALUES ('$user_vid', '$user_horario')
                ";
                mysqli_query($connect, $query);

           }



      }
      else
      {
           echo 'Error1';
      }
 }
 else
 {
      echo "Error2";
 }
 ?>
