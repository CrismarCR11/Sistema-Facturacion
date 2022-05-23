<?php
    //esto es para que solo el que tenga el rol de admi pueda configurar
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
            $idcliente=$_POST['id'];
            $nit= $_POST['nit'];
            $nombre= $_POST['nombre'];
            $telefono= $_POST['telefono'];
            $direccion= $_POST['direccion'];
            
            //devolver un resultado 
            $result=0;
            if(is_numeric($nit) and $nit !=0)
            {
                $query = mysqli_query($conexion,"SELECT * FROM cliente
                WHERE (nit = '$nit' AND idcliente != $idcliente)");
                $result = mysqli_fetch_array($query);
            }
           

            if($result>0){
                $alert='<p class="msg_error">El nit ya existen, ingrese otro</p>';
            }else{
                if($nit == '')
                {
                    $nit=0;
                }

                    $sql_update = mysqli_query($conexion, "UPDATE cliente
                                                            SET nit=$nit, nombre='$nombre', telefono='$telefono', direccion='$direccion'
                                                            WHERE idcliente=$idcliente");
                
                if($sql_update)
                {
                    $alert='<p class="msg_error">Cliente actualizado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el Cliente</p>';
                }
            }
        }
        
    }
    // mostrar datos en el formulario
    if(empty($_REQUEST['id']))
    {
        header('Location: lista_clientes.php');
        //mysqli_close($conexion);
    }
    $idcliente = $_REQUEST['id'];
    //agarrar los datos de la base de datos
    $sql= mysqli_query($conexion,"SELECT * FROM cliente
    WHERE idcliente=$idcliente");
    //mysqli_close($conexion);
    $result_sql = mysqli_num_rows($sql);
    if($result_sql==0)
    {
        header('Location: lista_clientes.php');
    }else{
        
        //recuperar datos dentro del data
        while ($data=mysqli_fetch_array($sql)){
            $idcliente= $data['idcliente'];
            $nit= $data['nit'];
            $nombre= $data['nombre'];
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
	<title>Acutalizar Cliente</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        
        <form action="" class="Formu" method="post">
        <div class="alert"> <?php echo isset($alert)? $alert:''; ?> </div>
            <h1 class="titulo">Actualizar</h1>
            <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
            <input class="texto" name="nit" id="nit" type="number" placeholder="numero de NIT" value="<?php echo $nit; ?>">
            <input class="texto" name="nombre" id="nombre"type="text" placeholder="Nombre" value="<?php echo $nombre; ?>">
            <input class="texto" name="telefono" type="number" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
            <input class="texto" name="direccion" id="direccion" type="text" placeholder="Direccion completa" value="<?php echo $direccion; ?>">

            
            <input type="submit" value="Actualizar Cliente" class="boton">
        </form>



	</section>



	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>