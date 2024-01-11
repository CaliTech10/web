<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/adminFunciones.php';

$db=new Database();
$con=$db->conectar();

/*$password=password_hash('admin',PASSWORD_DEFAULT);
$sql = "INSERT INTO admin (usuario, password, nombre, email, activo, fecha_alta)
VALUES ('admin','$password','administrador','admin@calitech.com','1',NOW ())";
$con->query($sql);*/

$errors=[];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.2/zephyr/bootstrap.min.css" integrity="sha512-tVaFJG+ePp27IMFymeEddl8DmqmDjlc2eInwfQ83Bddk8TC0lXUZ9kPy0VKGyQr52CY4THcBRBvCEZnsh63WmA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Cali Tech</title>
    
    <meta name="autor" content="Aleexa">
    <link rel="stylesheet" href="css/estilo_index.css">
    <link rel="stylesheet" href="css/estilos_inicioses.css">
 

</head>
<body style="background-color:gainsboro">
    <!--MENU-->


    

    

   <!--formulario inicio de sesion-->
   <div class="contenedor__login">
     <div class="Form_Sesion">
        <form action="productos.php" method="post"  style="background-color: black;">
            <h2 style="color: #47fdee;">Inicia Sesión</h2>
            <br>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario" required><br><br>
            <input type="password" name="password" id="password" placeholder="Contraseña" required><br><br>
            <?php mostrarMensajes($errors) ?>
            <button type="submit" class="btn btn-primary">Ingresar</button>

        </form>
    </div>
</div>


</html>