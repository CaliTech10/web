<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/adminFunciones.php';

$db=new Database();
$con=$db->conectar();


$id=$_POST['id'];

$activo=$_POST['activo'];


$sql="UPDATE productos SET activo=? WHERE id=?";


$stm=$con->prepare($sql);
if($stm->execute([$activo,$id])){




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