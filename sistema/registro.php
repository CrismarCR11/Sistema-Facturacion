<?php
    include "../conexion.php";
    if(!empty($_POST))
    {
        $alert='';
        //si son vacion mandara un mensaje si no pasara al else
        if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])
        || empty($_POST['clave']) || empty($_POST['rol']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            
            $nombre= $_POST['nombre'];
            date_default_timezone_set('America/Argentina/Buenos_Aires');    
            $DateAndTime = date('m-d-Y h:i:s a', time());
            $email= $_POST['correo']." | ".$DateAndTime;
            $user= $_POST['usuario'];
            $clave= $_POST['clave'];
            $rol= $_POST['rol'];

            $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
            $result = mysqli_fetch_array($query);

            if($result>0){
                $alert='<p class="msg_error">El correo o el usuario ya existen</p>';
            }else{
                $query_insert = mysqli_query($conexion,"INSERT INTO usuario(nombre,correo,usuario,clave,rol) 
                                                                    VALUES('$nombre','$email','$user','$clave','$rol')");
                if($query_insert)
                {
                    $alert='<p class="msg_error">Usuario creado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el usuario</p>';
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
	<title>Registro Usuarios</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        
        <form action="" class="Formu" method="post">
        <div class="alert"> <?php echo isset($alert)? $alert:''; ?> </div>
            <h1 class="titulo">Registro</h1>
            <input class="texto" name="nombre" type="text" placeholder="Nombre">
            <input class="texto" name="correo" type="email" placeholder="Correo Electronico">
            <input class="texto" name="usuario" type="text" placeholder="Usuario">
            <input class="texto" name="clave" type="password" placeholder="Password">
            <select class="texto" name="rol" id="rol">
                <option value="1">Administrador</option>
                <option value="2">Supervisor</option>
                <option value="3">Vendedor</option>
            </select>
            
            <input type="submit" value="Crear Usuario" class="boton">
        </form>



	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>