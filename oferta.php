<?php
require 'config/config.php';
require 'config/database.php';
$db=new Database();
$con=$db->conectar();

$sql =$con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1 AND descuento >0");
$sql->execute();
$resultado=$sql->fetchALL(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Cali Tech</title>
    
    <meta name="autor" content="Aleexa">
    <link rel="stylesheet" href="css/estilo_index.css">
 

</head>
<body style="background-color:gainsboro">
<!--Menu-->
<?php include 'menu.php' ?>   



    <div class="novedades">
        <h2>Ofertas</h2>
    </div>

    <!--TELEFONOS-->
    <?php foreach($resultado as $row){?>
    <div class="columna">
        
        <div class="galeria">
            <a href="detalle.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1',$row['id'], KEY_TOKEN); ?>">
                <?php
                $id=$row['id'];
                $imagen="img/". $id ."/principal.png";
                if(!file_exists($imagen)){
                    $imagen="img/no-photo.jpg";
                }
                ?>
                <img src="<?php echo $imagen; ?>">
            </a>
            <div class="Descripcion">
                <h3><?php echo $row['nombre']; ?></h3>
                <p id="precio">$<?php echo number_format( $row['precio'],2,'.',','); ?></p>
            </div>
        </div>
    </div>

    
    <?php } ?>


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