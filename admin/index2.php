<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/adminFunciones.php';

$db=new Database();
$con=$db->conectar();


 
$sql="SELECT id,nombre,descripcion,precio,descuento,id_categoria FROM productos
 where activo=1"; 

$resultado=$con->query($sql);
$productos=$resultado->fetchAll(PDO::FETCH_ASSOC);


?>

<?php include 'header.php'?>



                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-3">Productos</h2>

                        <a href="nuevo.php" class="btn btn-primary">Agregar</a>


                        <table class="table table-hover my-4">
                            <thead>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Descuento</th>

                            </thead>
                            <tbody>
                                <?php foreach($productos as $producto){ ?>

                                    <tr>
                                        <td>
                                           
                                            <?php echo $producto['nombre']; ?>
                                        </td>
                                        <td>
                                            <?php echo $producto['precio']; ?>
                                        </td>
                                        <td>

                                            <?php echo $producto['descuento']; ?>
                                        </td>
                                        <td>
                                        <a href="edita.php?id=<?php echo $producto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                        <td>
                                            <a href="editaelimina.php" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                    </main>

                    <!-- Modal -->
 <div class="modal fade" id="eliminaModal" tabindex="-1" data-bs-backdrop="static"
 data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar el producto?
      </div>
      <div class="modal-footer">
        <form action="elimina.php" method="post">
            <input type="hidden" name="id">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger" >Eliminar</button>
        </form>
    </div>
    </div>
  </div>
</div>

                <script>

let eliminaModal=document.getElementById('eliminaModal')
eliminaModal.addEventListener('show.bs.modal',function(event){

    let button=event.relatedTarget
    let id=button.getAttribute('data-bs-id')

    let modalInputId=eliminaModal.querySelector('.modal-footer input')
    modalInputId.value=id
})

</script>
                    <?php include 'footer.php' ?>
                


                  
               