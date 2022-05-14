<?php 

include("../conexion.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/tabla.css">

	<title>Lista de Usuarios</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
		<h1>Lista de Usuarios</h1>
        <a href="registro.php" class="btn_new">Crear Usuario</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo | creacion</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php 
            

                $query=mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM 
                                        usuario u INNER JOIN rol r ON u.rol=r.idrol WHERE estatus=1;");

                $result = mysqli_num_rows($query);
                // si nos devuelve mayor a 0 significa que tenemos registros
                if($result>0){
                    while($data = mysqli_fetch_array($query)){?>

                        <tr>
                            <td><?php echo $data["idusuario"]; ?></td>
                            <td><?php echo $data["nombre"]; ?></td>
                            <td><?php echo $data["correo"]; ?> </td>
                            <td><?php echo $data["rol"]; ?></td>
                            <td>
                                <a class="link_edit" href="edit_usuario.php?id=<?php echo $data["idusuario"]; ?>" >Editar</a>
                                <?php
                                    if($data['rol'] != "Administrador" ) {?>
                                        <a href="eliminar_confirmar_usuario.php?id=<?php echo $data["idusuario"]; ?>" class="link_delete">Eliminar</a>
                                   <?php }?>
                                
                                
                            </td>
                        </tr>
                <?php
                    }
                }?>
                
            
            
        </table>
    
    </section>

	<?php include "includes/footer.php" ?>
</body>
</html>