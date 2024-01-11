<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/adminFunciones.php';

$db=new Database();
$con=$db->conectar();


 


$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$precio=$_POST['precio'];
$descuento=$_POST['descuento'];
$categoria=$_POST['id_categoria'];
$activo=$_POST['activo'];


$sql="INSERT INTO productos (nombre,descripcion,precio,descuento,id_categoria,activo) 
VALUES (?,?,?,?,?,?)";
$stm=$con->prepare($sql);

if($stm->execute([$nombre,$descripcion,$precio,$descuento,$categoria,$activo])){

    $descripcion=$con->lastInsertId();
    $id = $con->lastInsertId();


    if($_FILES['imagen_principal']['error'] == UPLOAD_ERR_OK){
        $dir= '../img/' . $id . '/';
        $permitidos =['png'];

        $arregloImagen = explode('.', $_FILES['imagen_principal']['name']);
        $extencion= strtolower(end($arregloImagen));


        if(in_array($extencion, $permitidos)){
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }



            $ruta_img =$dir.'principal.' . $extencion;
            if(move_uploaded_file($_FILES['imagen_principal']['tmp_name'], $ruta_img)){
                echo "el archivo se cargo correctamente.";
            }else{
                echo "Error al cargar archivo.";
            }
        }else{
            echo "Archivo no permitido.";
        }
    }else{
        echo "No enviaste archivo.";
    }

}





?>