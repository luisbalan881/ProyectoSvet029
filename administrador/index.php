<?php
$ref = null;
if ( !empty($_GET['ref'])) {
    $ref = $_REQUEST['ref'];
    if(!empty($_GET['id'])){
        $id = $_REQUEST['id'];
        header('Location: ../inicio.php?ref='.$ref.'&id='.$id );
    }else{
        header('Location: ../inicio.php?ref='.$ref);
    }
}else{
    header('Location: ../index.php');
}
