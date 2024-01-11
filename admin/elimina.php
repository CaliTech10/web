<?php 

require 'config/config.php';
require 'config/database.php';

$db=new Database();
$con=$db->conectar();



$id = $_POST['id'];

$sql=$con->prepare("UPDATE productos SET activo=0 
 where id=?"); 

 $sql->execute([$id]);

 header('Location:index2.php');


 ?>