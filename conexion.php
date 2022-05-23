<?php
//conexion con la base de datos
    $servidor='localhost';
    $user='root';
    $contraseña='';
    $db='factura';
    $conexion= @mysqli_connect($servidor,$user,$contraseña,$db);
    
    //conectando a la base de datos

    if(!$conexion){
        echo "Error en la conexion";
         
    }
    


?>