<?php
   session_start();
    include "../conexion.php";
    if(!empty($_POST))
    {
        $alert='';
        //si son vacion mandara un mensaje si no pasara al else
        if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            $nit = $_POST['nit'];
            $nombre= $_POST['nombre'];
            date_default_timezone_set('America/Argentina/Buenos_Aires');    
            $DateAndTime = date('m-d-Y h:i:s a', time());
            //por si queremos poner fecha es esto
            //$email= $_POST['correo']." | ".$DateAndTime;
            $telefono= $_POST['telefono'];
            $direccion= $_POST['direccion'];
            $usuario_id = $_SESSION['idUser'];

            $result=0;
            if(is_numeric($nit) and $nit !=0)
            {
                $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE nit = '$nit' ");
                $result=mysqli_fetch_array($query);

            }
            if($result>0)
            {
                $alert='<p class="msg_error">El número de NIT ya existe</p>';
            }
            else{
                $query_insert = mysqli_query($conexion,"INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id) 
                                                                    VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')");
                if($query_insert)
                {
                    $alert='<p class="msg_error">Cliente creado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el Cliente</p>';
                }
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
	<title>Registro Cliente</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        
        <form action="" class="Formu" method="post">
        <div class="alert"> <?php echo isset($alert)? $alert:''; ?> </div>
            <h1 class="titulo">Registro</h1>
            <input class="texto" name="nit" id="nit" type="number" placeholder="numero de NIT">
            <input class="texto" name="nombre" id="nombre"type="text" placeholder="Nombre">
            <input class="texto" name="telefono" type="number" id="telefono" placeholder="Teléfono">
            <input class="texto" name="direccion" id="direccion" type="text" placeholder="Direccion completa">

            
            <input type="submit" value="Crear Cliente" class="boton">
        </form>



	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>