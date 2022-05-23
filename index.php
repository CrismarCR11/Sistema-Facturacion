<?php



$alert='';
//validando si exite una sesion y redireccionar
session_start();
if(!empty($_SESSION['active']))
{
    header('location: sistema/');
}else{
    //recibir lo enviado del formulario
    if(!empty($_POST))
    {
        /* empty = vacio 
        si esta vacio la variable usuario o clave*/
        if(empty($_POST['usuario']) || empty($_POST['clave']))
        {
        
            $alert='Ingrese su usuario y su clave';

        }else{
            //requiere_once= para traer un archivo extra
            require_once "conexion.php";

            //agarrar usuario y clave
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $pass = mysqli_real_escape_string($conexion, $_POST['clave']);

            echo $user."</br>";
            echo $pass;
            /* query= seleccionar toda la fila donde el usuario sea igual a user y clace igual a pass */
            $query= mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario='$user' AND clave='$pass' ");
            //mysqli_close($conexion);
            $result=mysqli_num_rows($query);

            if($result>0)
            {
                $data=mysqli_fetch_array($query);
                //print_r($data);
                //sesion iniciada y guardado de datos
                
                $_SESSION['active']=true;
                $_SESSION['idUser']= $data['idusuario'];
                $_SESSION['nombre']= $data['nombre'];
                $_SESSION['email']= $data['correo'];
                $_SESSION['user']= $data['usuario'];
                $_SESSION['rol']= $data['rol'];

                header('location: sistema/');
            }else{
                $alert='El usuario o la clave son incorrectos';
                session_destroy();
            }

        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Login | Sistema Facturacion</title>
</head>
<body>


<section id="container">

    <form action="index.php" method="post">

        <h3>Iniciar Sesion</h3>
        <input class="text"  type="text" name="usuario" placeholder="Usuario">
        <input class="password"  type="password" name="clave" placeholder="Contraseña">
        <div class="alert">
            <!-- isset= impirmir si se tiene algo si no nada -->
            <?php echo(isset($alert)) ? $alert : ''; ?>
        </div>
        </br>
        <input class="button"  type="submit" value="Iniciar Sesion"> <br>
        <br>
        <label class="label" for=""><a href="">Crear Cuenta</a></label>

    </form>

</section>
    
</body>
</html>