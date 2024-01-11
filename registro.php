<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';




$db=new Database();
$con=$db->conectar();

$errors=[];

if(!empty($_POST)){
    $nombres= trim($_POST['nombres']);
    $apellidos= trim($_POST['apellidos']);
    $email= trim($_POST['email']);
    $telefono= trim($_POST['telefono']);
    $usuario= trim($_POST['usuario']);
    $password= trim($_POST['password']);
    $repassword= trim($_POST['repassword']);

    if(esNulo([$nombres, $apellidos,$email ,$telefono ,$usuario ,$password ,$repassword])){
        $errors[]= "debe llenar todos los campos";
    }

    if(!esEmail($email)){
        $errors[]="la direccion de correo no es valida";
    }

    if(!validaPassword($password,$repassword)){
        $errors[]="las contraseñas no coinciden";
    }

    if(usuarioExiste($usuario,$con)){
        $errors[]="El nombre de usuario ya existe";
    }

    if(emailExiste($email,$con)){
        $errors[]="El correo $email ya existe";
    }

    if(count($errors)==0){

    $id =registraCliente([$nombres,$apellidos,$email,$telefono], $con);

    if($id>0){
        $pass_hash= password_hash($password, PASSWORD_DEFAULT);
        $token = generarToken();
        if(!registraUsuario([$usuario,$pass_hash,$token,$id], $con)){
            $errors[]="error al registrar usuario";
        }
    }else{
        $errors[]="error al registrar cliente";
    }

}

}



//session_destroy();


//print_r($_SESSION);
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
    <link rel="stylesheet" href="css/estilo_registro.css">
 

</head>
<body style="background-color:gainsboro">
    <!--MENU-->
    <header class="encabezado">
        <img src="img/logo.png" alt="logo">
        
        <div><a href="checkout.php"><img src="img/carrito-c.png" alt="" style="margin-left: 1873%; height: 50px; width: 50px;"></a> </div> <div><a href="checkout.php" style="float:right; height: 50px; width: 50px;"><span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span> </a></div>
        <h1>Cali Tech</h1>
        
        <nav>
            
            <a href="index.php" ><img src="img/pagina-principal.png" alt="" style="width: 33px; height: 33px;" >&nbsp Inicio</a>
            <a href="categorias.php"><img src="img/menu.png" alt="" style="width: 33px; height: 33px;" > Categorias</a>
            <a href="celulares.php"><img src="img/movil.png" alt="" style="width: 33px; height: 33px;" > celulares</a>
            <a href="oferta.php"><img src="img/rebaja.png" alt="" style="width: 33px; height: 33px;" >  Ofertas</a>
            
            <a href="iniciarsesion.html" style="float: right;">Iniciar sesion</a>
        </nav>
    </header>

    

    <div class="novedades">
        <h2>Registrarse</h2>
        
    </div>

    <?php  mostrarMensajes($errors); ?>

    <div class="contenedor__register">
      <div class="fo_pro">      
          <form action="registro.php" method="post" class="formulario_register" style="background-color:black;">
              <!-- cliente -->
              <h2 style="margin-top: 0.5%; color:#47fdee;" >Datos de cliente</h2> <br>
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="nombre" style="color: #47bbfd;"><span class="text-danger">*</span> Nombres:</label>
              <input type="text" name="nombres" id="nombres" class="form-control" pattern="[Aa-Zz]+" title="Solo se permiten Letras" required  >
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="apellidos" style="color: #47bbfd;"><span class="text-danger">*</span> Apellidos:</label>
              <input type="text" name="apellidos" id="apellidos" class="form-control" >
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="email" style="color: #47bbfd;"><span class="text-danger">*</span> Correo Electronico:</label>
              <input type="email" name="email" id="email" class="form-control" >
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="telefono" style="color: #47bbfd;"><span class="text-danger">*</span> Telefono:</label>
              <input type="tel" name="telefono" id="telefono" class="form-control" pattern="[0-9]+" title="Solo se permiten números" required >
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="usuario" style="color: #47bbfd;"><span class="text-danger">*</span> Usuario:</label>
              <input type="text" name="usuario" id="usuario" class="form-control" >
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="password" style="color: #47bbfd;"><span class="text-danger">*</span> Contraseña:</label>
              <input type="password" name="password" id="password" class="form-control" >
              <br>
              <i class="fa-solid fa-user"></i></i> <label for="repassword" style="color: #47bbfd;"><span class="text-danger">*</span> Repetir Contraseña:</label>
              <input type="password" name="repassword" id="repassword" class="form-control" >
              <br>
              <button style=" text-decoration: underline;" type="submit" class="btn btn-primary" >Registrar</button>
              <br>
              <input style="color:#47fdee; text-decoration: underline;" id="bot_ca" type="reset">
          </form>
    </div>
    </div>

   


    <footer class="footer">
        <table>
            <tr>
                <td>
                    CaliTech <br>
                    Av. Adolfo Lopez Mateos #133 Primer piso, Nezahualcoyotl <br>
                    Teléfono 5547629483
                </td>
                <td> &#169; TeCa</td>
            </tr>
        </table>
    </footer>

</body>

<script src="js/script.js"></script>

</html>