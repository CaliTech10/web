<?php 

require 'config/config.php';

$db=new Database();
$con=$db->conectar();



$urlImagen=$_POST['urlImagen'] ?? '';

if($urlImagen !== '' && file_exists($urlImagen)){
    unlink($urlImagen);

}
