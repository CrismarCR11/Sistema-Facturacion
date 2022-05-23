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

	<title>Lista de Usuarios</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        <?php
            //request= recibe datos ya sea get o post
            $busqueda = strtolower($_REQUEST['busqueda']);
            if(empty($busqueda)){
                header("location: lista_usuario.php");
                //mysqli_close($conexion);
            }
        ?>
		<h1>Lista de Usuarios</h1>
        <a href="registro.php" class="btn_new">Crear Usuario</a>

        <form action="buscar_usuario.php" method="get" class="form_search" >
            <input type="text" name="busqueda" class="text_buscar" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda ?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo | creacion</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php 
                //paginador
                //esto es para buscar el rol
                $rol = '';
                if($busqueda ==' administrador')
                {
                    $rol = " OR rol LIKE '%1%' ";
                }else if($busqueda == 'supervisor'){
                    $rol = " OR rol LIKE '%2%' ";
                }else if($busqueda == 'vendedor'){
                    $rol = " OR rol LIKE '%3%' ";
                }
                $sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
                                                    FROM usuario 
                                                    WHERE 
                                                    (
                                                        idusuario LIKE '%$busqueda%' OR
                                                        nombre LIKE '%$busqueda%' OR
                                                        correo LIKE '%$busqueda%' OR
                                                        usuario LIKE '%$busqueda%'
                                                        $rol 
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
                $query=mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM 
                                        usuario u INNER JOIN rol r ON u.rol=r.idrol 
                                        WHERE 
                                        (
                                                        u.idusuario LIKE '%$busqueda%' OR
                                                        u.nombre LIKE '%$busqueda%' OR
                                                        u.correo LIKE '%$busqueda%' OR
                                                        u.usuario LIKE '%$busqueda%' OR
                                                        r.rol LIKE '%$busqueda%'
                                                    )
                                        AND
                                        estatus=1 
                                        ORDER BY idusuario ASC
                                        LIMIT $desde,$por_pagina");

                //mysqli_close($conexion);
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