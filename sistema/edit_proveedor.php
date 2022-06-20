<?php
    //esto es para que solo el que tenga el rol de admi pueda configurar
    session_start();
    
    include "../conexion.php";
    if(!empty($_POST))
    {
        $alert='';
        //si son vacion mandara un mensaje si no pasara al else
        if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            $codproveedor=$_POST['id'];
            $proveedor= $_POST['proveedor'];
            $contacto= $_POST['contacto'];
            $telefono= $_POST['telefono'];
            $direccion= $_POST['direccion'];
            
            
                        $sql_update = mysqli_query($conexion, "UPDATE proveedor
                                                            SET proveedor='$proveedor', contacto='$contacto', telefono='$telefono', direccion='$direccion'
                                                            WHERE codproveedor=$codproveedor");
                
                if($sql_update)
                {
                    $alert='<p class="msg_error">Proveedor actualizado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el Proveedor</p>';
                }
            }
        
        
    }
    // mostrar datos en el formulario
    if(empty($_REQUEST['id']))
    {
        header('Location: lista_proveedor.php');
        //mysqli_close($conexion);
    }
    $codproveedor = $_REQUEST['id'];
    //agarrar los datos de la base de datos
    $sql= mysqli_query($conexion,"SELECT * FROM proveedor
    WHERE codproveedor=$codproveedor");
    //mysqli_close($conexion);
    $result_sql = mysqli_num_rows($sql);
    if($result_sql==0)
    {
        header('Location: lista_proveedor.php');
    }else{
        
        //recuperar datos dentro del data
        while ($data=mysqli_fetch_array($sql)){
            $codproveedor= $data['codproveedor'];
            $proveedor= $data['proveedor'];
            $contacto= $data['contacto'];
            $telefono= $data['telefono'];
            $direccion= $data['direccion'];
            
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
	<title>Acutalizar Proveedor</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        
        <form action="" class="Formu" method="post">
        <div class="alert"> <?php echo isset($alert)? $alert:''; ?> </div>
            <h1 class="titulo">Actualizar</h1>
            <input type="hidden" name="id" value="<?php echo $codproveedor; ?>">
            <input class="texto" name="proveedor" id="proveedor" type="text" placeholder="Proveedor" value="<?php echo $proveedor; ?>">
            <input class="texto" name="contacto" id="contacto"type="text" placeholder="Contacto" value="<?php echo $contacto; ?>">
            <input class="texto" name="telefono" type="number" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
            <input class="texto" name="direccion" id="direccion" type="text" placeholder="Direccion completa" value="<?php echo $direccion; ?>">

            
            <input type="submit" value="Actualizar Proveedor" class="boton">
        </form>



	</section>



	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>