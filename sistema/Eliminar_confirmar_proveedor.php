<?php
    //esto es para que solo el que tenga el rol de admi pueda configurar
    session_start();
    if($_SESSION['rol'] !=1 and $_SESSION['rol'] !=2)
    {
        header("location: ./");
    }
    include "../conexion.php";

    if(!empty($_POST)){
        if($_POST['idproveedor']){
            header('location: lista_proveedor.php');
            //mysqli_close($conexion);
            
        }
        $idproveedor = $_POST['idproveedor'];
        //consulta para eliminar el registro o actualizar
        //$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idcliente=$idcliente");
        $query_delete=mysqli_query($conexion, "UPDATE proveedor SET estatus = 0 WHERE codproveedor=$idproveedor");
        //si el queary nos devolvio algun valor verdadero
        if($query_delete){
            header('location: lista_proveedor.php');
        }else{
            echo "Error Al Eliminar";
        }

    }
    //request= es similar a post o get
    //validacion si el id existe 
    if(empty($_REQUEST['id']))
        {
        header('location: lista_proveedor.php');
        //mysqli_close($conexion);
    }else{
        
        $idproveedor = $_REQUEST['id'];
        
        //traer los datos del proveedor
        $query=mysqli_query($conexion,"SELECT * FROM proveedor
                                        WHERE codproveedor=$idproveedor");
        //nos envia datos en filas
        //mysqli_close($conexion);
        $result=mysqli_num_rows($query);
        //cuantas filas nos devolvio
        if($result > 0){
            while($data=mysqli_fetch_array($query)){
                $proveedor = $data['proveedor'];
            }
        }else{
            header("location: lista_proveedor.php");
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
	<title>Eliminar Proveedor</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
            <h2>¿Esta seguro de eliminar el siguiente registro?</h2>
            <p>Nombre del proveedor: <span> <?php echo $proveedor;?> </span> </p>
           
            <form action="" method="post">

                <input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
                <a href="lista_proveedor.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Eliminar" Class="btn_ok">
            </form>
        </div>
	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>