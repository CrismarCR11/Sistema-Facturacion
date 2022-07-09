<?php 
//esto es para que solo el que tenga el rol de admi pueda configurar
session_start();
if($_SESSION['rol'] !=1 and $_SESSION['rol'] !=2)
    {
        header("location: ./");
    }
include("../conexion.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/tabla.css">

	<title>Lista de Proveedores</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        <?php
            //request= recibe datos ya sea get o post
            $busqueda = strtolower($_REQUEST['busqueda']);
            if(empty($busqueda)){
                header("location: lista_proveedor.php");
                //mysqli_close($conexion);
            }
        ?>
		<h1>Lista de Proveedor</h1>
        <a href="registro_proveedor.php" class="btn_new">Crear Proveedor</a>

        <form action="buscar_proveedor.php" method="get" class="form_search" >
            <input type="text" name="busqueda" class="text_buscar" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda ?>">
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
                
                $sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
                                                    FROM proveedor 
                                                    WHERE 
                                                    (
                                                        codproveedor LIKE '%$busqueda%' OR
                                                        proveedor LIKE '%$busqueda%' OR
                                                        contacto LIKE '%$busqueda%' OR
                                                        telefono LIKE '%$busqueda%'  
                                                    )
                                                    AND
                                                    estatus=1");
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
                proveedor p INNER JOIN usuario u ON p.usuario_id=u.idusuario
                                        WHERE (p.estatus =1) and
                                        (
                                                        codproveedor LIKE '%$busqueda%' OR
                                                        proveedor LIKE '%$busqueda%' OR
                                                        contacto LIKE '%$busqueda%' OR
                                                        telefono LIKE '%$busqueda%'OR
                                                        nombre LIKE '%$busqueda%'
                                                    )
                                       
                                        ORDER BY codproveedor ASC
                                        LIMIT $desde,$por_pagina");

                //mysqli_close($conexion);
                $result = mysqli_num_rows($query);
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
                
        <?php
            //verificar si no se encuentra un usuario en la busqueda no hacer nada
            if($total_registro!=0)
            {
        ?>

        <div class="paginador">
            <ul>
                <?php
                    if($pagina != 1)
                    {
                
                ?>
                <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<<</a></li>
                <li><a href="?pagina= <?php $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<<</a></li>
                <?php
                    }
                    //contador para el paginador
                    for($i=1; $i <= $total_paginas; $i++){
                        if($i == $pagina)
                        {
                            echo '<li  class="pageSelected">'.$i.'</li>';
                        }else{
                            echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                        }
                        
                    }
                    
                    if($pagina != $total_paginas)
                    {
                ?>
                
                
                <li><a href="?pagina= <?php $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>>></a></li>
                <li><a href="?pagina= <?php $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>>|<</a></li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>


    </section>

	<?php include "includes/footer.php" ?>
</body>
</html>