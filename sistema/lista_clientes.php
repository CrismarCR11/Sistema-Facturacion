<?php 
//esto es para que solo el que tenga el rol de admi pueda configurar
session_start();
if($_SESSION['rol']!=1)
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

	<title>Lista de Clientes</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
		<h1>Lista de Clientes</h1>
        <a href="registro_cliente.php" class="btn_new">Crear Cliente</a>

        <form action="buscar_usuario.php" method="get" class="form_search" >
            <input type="text" name="busqueda" class="text_buscar" id="busqueda" placeholder="Buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>NIT</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Creador</th>
                <th>Acciones</th>
            </tr>
            <?php 
                //paginador
                $sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM cliente WHERE estatus=1");
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
                $query=mysqli_query($conexion,"SELECT c.idcliente, c.nit, c.nombre as cliente, c.telefono, c.direccion, u.nombre as usuario FROM 
                                        cliente c INNER JOIN usuario u ON c.usuario_id=u.idusuario WHERE c.estatus=1 
                                        ORDER BY idcliente ASC
                                        LIMIT $desde,$por_pagina");
                //mysqli_close($conexion);
                $result = mysqli_num_rows($query);
                //$ree=mysqli_fetch_array($query);
                //print_r ($ree);
                // si nos devuelve mayor a 0 significa que tenemos registros
                if($result>0){
                    while($data = mysqli_fetch_array($query)){
                            if($data["nit"]==0)
                            {
                                $nit = 'C/F';
                            }else{
                                $nit =$data["nit"];
                            }
                    ?>
                        <tr>
                            <td><?php echo $data["idcliente"]; ?></td>
                            <td><?php echo $nit ?></td>
                            <td><?php echo $data["cliente"]; ?></td>
                            <td><?php echo $data["telefono"]; ?> </td>
                            <td><?php echo $data["direccion"]; ?></td>
                            <td><?php echo $data["usuario"]; ?></td>
                            <td>
                                <a class="link_edit" href="edit_cliente.php?id=<?php echo $data["idcliente"]; ?>" >Editar</a>
                                
                                        <a href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>" class="link_delete">Eliminar</a>
                                   
                                
                                
                            </td>
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