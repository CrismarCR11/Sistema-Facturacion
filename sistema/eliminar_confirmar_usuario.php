<?php
    //esto es para que solo el que tenga el rol de admi pueda configurar
    session_start();
    if($_SESSION['rol']!=1)
    {
        header("location: ./");
    }
    include "../conexion.php";

    if(!empty($_POST)){
        if($_POST['idusuario']==1){
            header('location: lista_usuario.php');
            //mysqli_close($conexion);
            exit;
        }
        $idusuario = $_POST['idusuario'];
        //consulta para eliminar el registro 
        //$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
        $query_delete=mysqli_query($conexion, "UPDATE usuario SET estatus = 0 WHERE idusuario=$idusuario");
        if($query_delete){
            header('location: lista_usuario.php');
        }else{
            echo "Error Al Eliminar";
        }

    }
    //request= es similar a post o get
    //
    if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1)
    {
        header('location: lista_usuario.php');
        //mysqli_close($conexion);
    }else{
        
        $idusuario = $_REQUEST['id'];
        
        //traer los datos del usuario
        $query=mysqli_query($conexion,"SELECT u.nombre, u.usuario, r.rol
                                        FROM usuario u 
                                        INNER JOIN
                                        rol r
                                        ON u.rol=r.idrol
                                        WHERE u.idusuario=$idusuario");
        //nos envia datos en filas
        //mysqli_close($conexion);
        $result=mysqli_num_rows($query);
        if($result > 0){
            while($data=mysqli_fetch_array($query)){
                $nombre = $data['nombre'];
                $usuario = $data['usuario'];
                $rol = $data['rol'];
            }
        }else{
            header("location: lista_usuario.php");
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
            <h2>¿Esta seguro de eliminar el siguiente registro?</h2>
            <p>Nombre: <span> <?php echo $nombre;?> </span> </p>
            <p>Usuario: <span> <?php echo $usuario;?> </span> </p>
            <p>Rol: <span> <?php echo $rol;?> </span> </p>
           
            <form action="" method="post">

                <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
                <a href="lista_usuario.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" Class="btn_ok">
            </form>
        </div>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>