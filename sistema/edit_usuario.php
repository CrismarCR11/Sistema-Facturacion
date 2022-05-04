<?php
    include "../conexion.php";
    if(!empty($_POST))
    {
        $alert='';
        //si son vacion mandara un mensaje si no pasara al else
        if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])
        || empty($_POST['clave']) || empty($_POST['rol']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            
            $nombre= $_POST['nombre'];
            $email= $_POST['correo'];
            $user= $_POST['usuario'];
            $clave= $_POST['clave'];
            $rol= $_POST['rol'];

            $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
            $result = mysqli_fetch_array($query);

            if($result>0){
                $alert='<p class="msg_error">El correo o el usuario ya existen</p>';
            }else{
                $query_insert = mysqli_query($conexion,"INSERT INTO usuario(nombre,correo,usuario,clave,rol) 
                                                                    VALUES('$nombre','$email','$user','$clave','$rol')");
                if($query_insert)
                {
                    $alert='<p class="msg_error">Usuario creado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el usuario</p>';
                }
            }
        }
    }
    // mostrar datos
    if(empty($_GET['id']))
    {
        header('Location: lista_usuario.php');
    }
    $iduser = $_GET['id'];
    
    $sql= mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) AS idrol, (r.rol) as rol 
    FROM usuario u 
    INNER JOIN rol r ON u.rol = r.idrol 
    WHERE idusuario=$iduser");

    $result_sql = mysqli_num_rows($sql);
    if($result_sql==0)
    {
        header('Location: lista_usuario.php');
    }else{
        $option= '';
        while ($data=mysqli_fetch_array($sql)){
            $iduser= $data['idusuario'];
            $nombre= $data['nombre'];
            $correo= $data['correo'];
            $usuario= $data['usuario'];
            $idrol= $data['idrol'];
            $rol= $data['rol'];
            
            if($idrol == 1){
                $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
            }else if($idrol == 2){
                $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
            }else if($idrol == 3){
                $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scrips.php" ?>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
	<title>Acutalizar Usuarios</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>
	<section id="container">
        
        <form action="" class="Formu" method="post">
        <div class="alert"> <?php echo isset($alert)? $alert:''; ?> </div>
            <h1 class="titulo">Actualizar</h1>
            <input class="texto" name="nombre" type="text" placeholder="Nombre" value="<?php echo $nombre;  ?>">
            <input class="texto" name="correo" type="email" placeholder="Correo Electronico" value="<?php echo $correo;  ?>">
            <input class="texto" name="usuario" type="text" placeholder="Usuario" value="<?php echo $usuario;  ?>">
            <input class="texto" name="clave" type="password" placeholder="Password">
            <?php 
                $query_rol = mysqli_query($conexion,"SELECT * FROM rol");
                $result_rol = mysqli_num_rows($query_rol);
            ?>
            
            <select class="texto noting" name="rol" id="rol">
                <?php 
                    echo $option;
                    if($result_rol>0)
                    {
                        while($rol = mysqli_fetch_array($query_rol))
                        {
                            ?>
                            <option value="<?php echo $rol["idrol"];?> "><?php echo $rol["rol"] ?></option>
                        <?php
                        }
                    }
                ?>
                
                
            </select>
            
            <input type="submit" value="Actualizar Usuario" class="boton">
        </form>



	</section>

	<?php include "includes/footer.php" ?>
</body>
</html>