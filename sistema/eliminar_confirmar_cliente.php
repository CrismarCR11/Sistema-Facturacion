<?php
    //esto es para que solo el que tenga el rol de admi pueda configurar
    session_start();
    if($_SESSION['rol'] !=1 and $_SESSION['rol'] !=2)
    {
        header("location: ./");
    }
    include "../conexion.php";

    if(!empty($_POST)){
        if($_POST['idcliente']){
            header('location: lista_clientes.php');
            //mysqli_close($conexion);
            
        }
        $idcliente = $_POST['idcliente'];
        //consulta para eliminar el registro 
        //$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idcliente=$idcliente");
        $query_delete=mysqli_query($conexion, "UPDATE cliente SET estatus = 0 WHERE idcliente=$idcliente");
        if($query_delete){
            header('location: lista_clientes.php');
        }else{
            echo "Error Al Eliminar";
        }

    }
    //request= es similar a post o get
    //
    if(empty($_REQUEST['id']))
        {
        header('location: lista_clientes.php');
        //mysqli_close($conexion);
    }else{
        
        $idcliente = $_REQUEST['id'];
        
        //traer los datos del usuario
        $query=mysqli_query($conexion,"SELECT * FROM cliente
                                        WHERE idcliente=$idcliente");
        //nos envia datos en filas
        //mysqli_close($conexion);
        $result=mysqli_num_rows($query);
        if($result > 0){
            while($data=mysqli_fetch_array($query)){
                $nit = $data['nit'];
                $nombre = $data['nombre'];
            }
        }else{
            header("location: lista_clientes.php");
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
            <h2>¿Esta seguro de eliminar el siguiente registro?</h2>
            <p>NIT: <span> <?php echo $nit;?> </span> </p>
            <p>Nombre del cliente: <span> <?php echo $nombre;?> </span> </p>
           
            <form action="" method="post">

                <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
                <a href="lista_clientes.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Eliminar" Class="btn_ok">
            </form>
        </div>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>