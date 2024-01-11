
<?php 

require 'config/config.php';
require 'config/database.php';
require 'clases/adminFunciones.php';

$db=new Database();
$con=$db->conectar();



$id = $_GET['id'];

$sql=$con->prepare("SELECT id,nombre,descripcion,precio,descuento,id_categoria,activo FROM productos
 where id=? AND activo=1"); 

 $sql->execute([$id]);
$producto=$sql->fetch(PDO::FETCH_ASSOC);

$rutaImagenes='../img/'.$id.'/';
$imagenPrincipal=$rutaImagenes.'principal.png';


 ?>


<?php include 'header.php'?>



                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-3">Elimina Producto</h1>


                        <form action="actualiza.php" enctype="multipart/form-data" method="post">

                        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">


                            <div class="mb-3">
                              <label for="nombre" class="form-label">Nombre</label>
                              <input type="number" class="form-control" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" require autofocus>
                            </div>

                            <div class="mb-3">
                              <label for="descripcion" class="form-label">Descripción</label>
                              <textarea class="form-control" name="descripcion" id="descripcion" 
                               required ><?php echo $producto['descripcion']; ?></textarea>
                            </div>


                            <div class="row mb-2">
                                <div class="col">
                                      <label for="imagen_principal" class="form-label">Imagen principal</label>
                                      <input type="file" class="form-control" name="imagen_principal" id="imagen_principal" accept="image/jpeg"   >
                                </div>
                            </div>

                            <div class="row mb-2">
                            <div class="col">
                                <?php if(file_exists($imagenPrincipal)){ ?>
                                    
                                    <img src=" <?php echo $imagenPrincipal ?>" class="img-thumnail my-3"><br>
                                    

                                    <?php } ?>
                            </div>

                            </div>
                           
                            
                            <div class="row">
                            <div class="col mb-3">
                              <label for="precio" class="form-label">Precio</label>
                              <input type="number" class="form-control" name="precio" id="precio" value="<?php echo $producto['precio']; ?>" require >
                             </div>

                              <div class="col mb-3">
                              <label for="descuento" class="form-label">Descuento</label>
                              <input type="number"
                                class="form-control" name="descuento" id="descuento" value="<?php echo $producto['descuento']; ?>" require >
                              </div>
                            </div>

                            <div class="row">
                              <div class="col mb-3">
                              <label for="id_categoria" class="form-label">Categoria</label>
                              <input type="number"
                                class="form-control" name="id_categoria" id="id_categoria" value="<?php echo $producto['id_categoria']; ?>" require >
                              </div>
                            </div>

                            <div class="row">
                              <div class="col mb-3">
                              <label for="activo" class="form-label">Activo</label>
                              <input type="number"
                                class="form-control" name="activo" id="activo" value="<?php echo $producto['activo']; ?>" require >
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                        

                    </div>
                </main>

               
                <script>

                    ClassicEditor
                    .create(document.querySelector('#editor'))
                    .catch(error => {
                        console.error(error);
                    });


                    function eliminaImagen(urlImagen){
                        let url ='eliminar_imagen.php'
                        let formData = new FormData()
                        formData.append('urlImagen',urlImagen)


                        fetch(url,{
                            method: 'POST',
                            body: formData
                        }).then(response)=>{
                            if(response.ok){
                                location.reload()
                            }
                        }
                    }
                </script>


 


                <?php include 'footer.php' ?>


                
                
           