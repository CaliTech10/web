
<?php 

require 'config/config.php';
require 'config/database.php';
require 'clases/adminFunciones.php';

$db=new Database();
$con=$db->conectar();





 ?>


<?php include 'header.php'?>



                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-3">Nuevo Producto</h1>


                        <form action="guarda.php" enctype="multipart/form-data" method="post">
                            <div class="mb-3">
                              <label for="nombre" class="form-label">Nombre</label>
                              <input type="text"
                                class="form-control" name="nombre" id="nombre" require autofocus>
                            </div>

                            <div class="mb-3">
                              <label for="descripcion" class="form-label">Descripción</label>
                              <textarea class="form-control" name="descripcion" id="descripcion" required ></textarea>
                            </div>

                            <div class="row mb-2">
                                <div class="col">
                                      <label for="imagen_principal" class="form-label">Imagen principal</label>
                                      <input type="file" class="form-control" name="imagen_principal" id="imagen_principal" accept="image/jpeg" required >
                                </div>
                            </div>
                           
                            
                            <div class="row">
                            <div class="col mb-3">
                              <label for="precio" class="form-label">Precio</label>
                              <input type="number" class="form-control" name="precio" id="precio" require >
                             </div>

                              <div class="col mb-3">
                              <label for="descuento" class="form-label">Descuento</label>
                              <input type="number"
                                class="form-control" name="descuento" id="descuento" require >
                              </div>
                            </div>

                            <div class="row">
                              <div class="col mb-3">
                              <label for="id_categoria" class="form-label">Categoria</label>
                              <input type="number"
                                class="form-control" name="id_categoria" id="id_categoria" require >
                              </div>
                            </div>
                            <div class="row">
                              <div class="col mb-3">
                              <label for="id_categoria" class="form-label">Activo</label>
                              <input type="number"
                                class="form-control" name="activo" id="activo" require >
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                        

                    </div>
                </main>


                <?php include 'footer.php' ?>
                
           