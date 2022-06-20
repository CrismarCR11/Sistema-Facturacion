<?php
   session_start();
   if($_SESSION['rol']!=1 and $_SESSION['rol'] !=2)
   {
       header("location: ./");
   }

    include "../conexion.php";
    if(!empty($_POST))
    {
        $alert='';
        //si son vacion mandara un mensaje si no pasara al else
        if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            $proveedor = $_POST['proveedor'];
            $contacto= $_POST['contacto'];
            date_default_timezone_set('America/Argentina/Buenos_Aires');    
            $DateAndTime = date('m-d-Y h:i:s a', time());
            //por si queremos poner fecha es esto
            //$email= $_POST['correo']." | ".$DateAndTime;
            $telefono= $_POST['telefono'];
            $direccion= $_POST['direccion'];
            $usuario_id = $_SESSION['idUser'];

            
            $query_insert = mysqli_query($conexion,"INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id) 
                                                                    VALUES('$proveedor','$contacto','$telefono','$direccion','$usuario_id')");
                if($query_insert)
                {
                    $alert='<p class="msg_error">Proveedor creado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el Proveedor</p>';
                }
        }
            
            
        
        //mysqli_close($conexion);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
	<title>Registro Proveedor</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        
        <form action="" class="Formu" method="post">
        <div class="alert"> <?php echo isset($alert)? $alert:''; ?> </div>
            <h1 class="titulo">Registro</h1>
            <input class="texto" name="proveedor" id="proveedor" type="text" placeholder="Nombre del Proveedor">
            <input class="texto" name="contacto" id="contacto"type="text" placeholder="Nombre Completo del Contacto">
            <input class="texto" name="telefono" type="number" id="telefono" placeholder="Teléfono">
            <input class="texto" name="direccion" id="direccion" type="text" placeholder="Direccion completa">

            
            <input type="submit" value="Crear Proveedor" class="boton">
        </form>



	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>