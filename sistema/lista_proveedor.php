<?php 
//esto es para que solo el que tenga el rol de admi pueda configurar
session_start();

include("../conexion.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/tabla.css">

	<title>Lista de Proveedor</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
		<h1>Lista de Proveedor</h1>
        <a href="registro_proveedor.php" class="btn_new">Crear Proveedor</a>

        <form action="buscar_cliente.php" method="get" class="form_search" >
            <input type="text" name="busqueda" class="text_buscar" id="busqueda" placeholder="Buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Contacto</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Creador</th>
                <th>Acciones</th>
                <th>Fecha</th>
            </tr>
            <?php 
                //paginador
                $sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM proveedor WHERE estatus=1");
                $result_register=mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['total_registro'];
                $por_pagina=5;
                if(empty($_GET['pagina'])){
                    $pagina=1;
                }else{
                    $pagina=$_GET['pagina'];
                }
                $desde=($pagina-1)*$por_pagina;
                $total_paginas=ceil($total_registro / $por_pagina);
                echo $total_registro;
                echo $total_paginas;

                //traer de la base de datos los registros
                $query=mysqli_query($conexion,"SELECT p.codproveedor, p.proveedor, p.contacto, p.telefono, p.direccion, u.nombre as usuario, p.date_add FROM 
                                        proveedor p INNER JOIN usuario u ON p.usuario_id=u.idusuario WHERE p.estatus=1 
                                        ORDER BY codproveedor ASC
                                        LIMIT $desde,$por_pagina");
                //mysqli_close($conexion);
                $result = mysqli_num_rows($query);
                //$ree=mysqli_fetch_array($query);
                //print_r ($ree);
                // si nos devuelve mayor a 0 significa que tenemos registros
                if($result>0){
                    while($data = mysqli_fetch_array($query)){
                        //formato de fecha
                        $formato = 'Y-m-d H:i:s';
                        $fecha= DateTime::createFromFormat($formato,$data["date_add"]);
                            
                    ?>
                        <tr>
                            <td><?php echo $data["codproveedor"]; ?></td>
                            <td><?php echo $data["proveedor"]; ?></td>
                            <td><?php echo $data["contacto"]; ?></td>
                            <td><?php echo $data["telefono"]; ?> </td>
                            <td><?php echo $data["direccion"]; ?></td>
                            <td><?php echo $data["usuario"]; ?></td>
                            <td>
                                <a class="link_edit" href="edit_proveedor.php?id=<?php echo $data["codproveedor"]; ?>" >Editar</a>
                                
                        
                                <a href="eliminar_confirmar_proveedor.php?id=<?php echo $data["codproveedor"]; ?>" class="link_delete">Eliminar</a>
                                   
                                        
                                   
                                
                                
                            </td>
                            <td><?php echo $fecha->format('d-m-Y'); ?></td>
                        </tr>
                <?php
                    }
                    
                }?>
                
            
            
        </table>

        <div class="paginador">
            <ul>
                <?php
                    if($pagina != 1)
                    {
                
                ?>
                <li><a href="?pagina=<?php echo 1; ?>">|<<</a></li>
                <li><a href="?pagina= <?php $pagina-1; ?>"><<<</a></li>
                <?php
                    }
                    //contador para el paginador
                    for($i=1; $i <= $total_paginas; $i++){
                        if($i == $pagina)
                        {
                            echo '<li  class="pageSelected">'.$i.'</li>';
                        }else{
                            echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                        }
                        
                    }
                    
                    if($pagina != $total_paginas)
                    {
                ?>
                
                
                <li><a href="?pagina= <?php $pagina+1; ?>">>>></a></li>
                <li><a href="?pagina= <?php $total_paginas; ?>">>>|<</a></li>
                <?php } ?>
            </ul>
        </div>
    
    </section>

	<?php include "includes/footer.php" ?>
</body>
</html>