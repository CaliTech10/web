<?php
require 'config/config.php';
require 'config/database.php';

$db=new Database();
$con=$db->conectar();

$productos = isset( $_SESSION['carrito']['productos'])? $_SESSION['carrito']['productos'] : null;

//print_r($_SESSION);

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql =$con->prepare("SELECT id, nombre, precio,descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[]=$sql->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/css/bootstrap.css">
    
    <meta name="autor" content="Aleexa">
    <link rel="stylesheet" href="css/estilo_index.css">
 

</head>
<body style="background-color:gainsboro">
    <!--Menu-->
<?php include 'menu.php' ?>

    <div class="container" style="margin-bottom:30px;">
        <div class="table-responsive" style="margin-top:50px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($lista_carrito==null){
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                        }else{
                            $total=0;
                            foreach($lista_carrito as $producto){
                                $_id= $producto['id'];
                                $nombre= $producto['nombre'];
                                $precio= $producto['precio'];
                                $descuento= $producto['descuento'];
                                $cantidad= $producto['cantidad'];
                                $precio_desc= $precio-(($precio *  $descuento)/100);
                                $subtotal= $cantidad * $precio_desc;
                                $total += $subtotal;
                                ?>
                    <tr>
                        <td><?php echo $nombre; ?></td>
                        <td>$<?php echo number_format($precio_desc,2,'.',','); ?></td>
                        <td><input type="number" min="1" mas="10" step="1" value="<?php echo $cantidad; ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value,<?php echo $_id; ?>)" ></td>
                        <td><div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',','); ?></div></td>
                        <td>
                        <button type="button" id="eliminar" data-bs-id="<?php echo $_id; ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eliminaModal">
  eliminar
</button></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">
                            <p class="h3" id="total"><?php echo MONEDA . number_format($total,2,'.',','); ?></p>
                        </td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>

            

        </div>

        

        <div class="row">
            <div class="col-md-5 offset-md-7 d-grid gap-2">
                <a href="compra.html"><button class="btn btn-primary btn-lg" >Comprar</button></a>
            </div>
        </div>


       <!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar el producto del pago?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="btn-elimina" class="btn btn-danger" onclick="eliminar()" >Eliminar</button>
      </div>
    </div>
  </div>
</div>



<script src="bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/css/bootstrap.min.css"></script>
<script src="bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>



    <script>

    let eliminaModal=document.getElementById('eliminaModal')
    eliminaModal.addEventListener('show.bs.modal', function(event){
    let button=event.relatedTarget
    let id=button.getAttribute('data-bs-id')
    let buttonElimina=eliminaModal.querySelector('.modal-footer #btn-elimina')
    buttonElimina.value=id
})

        function actualizaCantidad(cantidad,id){

        
            let url='clases/actualizar_carrito.php'
            let formData=new FormData()
            formData.append('action','agregar')
            formData.append('id',id)
            formData.append('cantidad',cantidad)

            fetch(url, {
                method:'POST',
                body:formData,
                mode:'cors'
            }).then(response=>response.json())
            .then(data => {
                if(data.ok){

                    let divsubtotal = document.getElementById('subtotal_'+ id)
                    divsubtotal.innerHTML=data.sub

                    let total=0.00
                    let list =document.getElementsByName('subtotal[]')

                    for(let i  =0; i < list.length; i++){
                        total += parseFloat(list[i].innerHTML.replace(/[$,]/g,''))
                    }

                    total=new Intl.NumberFormat('en-US',{
                        minimumFractionDigits: 2
                    }).format(total)
                    document.getElementById('total').innerHTML='<?php echo MONEDA; ?>'+ total
                    
                }
            })
        }

        function eliminar(){

            let botonElimina=document.getElementById('btn-elimina')
            let id=botonElimina.value
let url='clases/actualizar_carrito.php'
let formData=new FormData()
formData.append('action','eliminar')
formData.append('id',id)

fetch(url, {
    method:'POST',
    body:formData,
    mode:'cors'
}).then(response=>response.json())
.then(data => {
    if(data.ok){
        location.reload()
    }
})
}
    </script>





    
</body>






</html>

