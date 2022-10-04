<?php include("../template/cabecera.php"); ?>

<?php

    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
    $txtImagen=(isset($_FILES['txtImagen']))?$_FILES['txtImagen']['name']:"";
    $diapositiva=(isset($_FILES['$diapositiva']))?$_FILES['$diapositiva']['name']:"";
    $accion=(isset($_POST['accion']))?$_POST['accion']:"";

    include("../config/bd.php");

/*
        echo $txtID."<br>";
        echo $txtNombre."<br>";
        echo $txtImagen."<br>";
        echo $diapositiva."<br>";
        echo $accion."<br>";  */    
/*
        
*/
        switch($accion){

            case "Agregar":

                $sentenciaSQL= $conexion->prepare("INSERT INTO expos(nombre,imagen) VALUES (:nombre, :imagen);");
                $sentenciaSQL->bindParam(':nombre', $txtNombre);

                $fecha= new DateTime();
                $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpeg";

                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

                if ($tmpImagen!="") {
                    move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
                }

                $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                $sentenciaSQL->execute();
                //echo "Presionado boton agregar";
                break;

            case "Modificar":
                
                $sentenciaSQL= $conexion->prepare("update expos set nombre=:nombre where id=:id");
                $sentenciaSQL->bindParam(':nombre',$txtNombre);
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();

                if ($txtImagen!="") {

                    $fecha= new DateTime();
                    $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpeg";
                    $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                    
                    move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                    $sentenciaSQL= $conexion->prepare("select imagen from expos where id=:id");
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute();
                    $expo=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                
                    if (isset($expo["imagen"]) && ($expo["imagen"])!="imagen.jpeg") {
                    
                        if(file_exists("../../img/".$expo["imagen"])){
                            unlink("../../img/".$expo["imagen"]);
                        }

                    }

                    $sentenciaSQL= $conexion->prepare("update expos set imagen=:imagen where id=:id");
                    $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute();
                }
                header("Location:expos.php");
                //echo "Presionado boton modificar";
                break;

            case "Cancelar":
                //echo "Presionado boton cancelar";
                header("Location:expos.php");
                break;

            case "Seleccionar":
                $sentenciaSQL= $conexion->prepare("select * from expos where id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $listaexpos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                $txtNombre=$listaexpos['nombre'];
                $txtImagen=$listaexpos['imagen'];

                //echo "Presionado boton Seleccionar";
                break;

            case "Borrar":
                //echo "Presionado boton Borrar";

                $sentenciaSQL= $conexion->prepare("select imagen from expos where id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $expo=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                
                if (isset($expo["imagen"]) && ($expo["imagen"])!="imagen.jpeg") {
                    
                    if(file_exists("../../img/".$expo["imagen"])){
                        unlink("../../img/".$expo["imagen"]);
                    }

                }
                
                $sentenciaSQL= $conexion->prepare("Delete from expos where id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                header("Location:expos.php");
                break;

        }

        $sentenciaSQL= $conexion->prepare("select * from expos");
        $sentenciaSQL->execute();
        $listaexpos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

    <div class="col-md-5">

        <div class="card">

            <div class="card-header">
                Datos de la exposición
            </div>
            
            <div class="card-body">
                
            <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
                <label for="txtID">ID</label>
                <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
            </div>
            <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre de la expo">
            </div>
            <div class = "form-group">
                <label for="txtImagen">Portada: </label>

                <?php echo $txtImagen; ?>
                
                <?php
                    if($txtImagen!=""){
                ?>
                   <br> <img class="img-tumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="195" alt="">
                <?php
                    }
                ?>

                <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Portada">
            </div>
    <!--        <div class = "form-group">
                <label for="diapositiva">diapositiva</label>
                <input type="file" class="form-control" name="diapositiva" id="diapositiva" accept=".pptx" placeholder="Presentación">
            </div> -->
            
            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>

        </form>

            </div>

        </div>        
        

    </div>

    <div class="col-md-7" style="margin-top: 35px;">
        
        <table class="table" table-bordered>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($listaexpos as $expo) { ?>
                <tr>
                    <td><?php echo $expo['id']; ?></td>
                    <td><?php echo $expo['nombre']; ?></td>
                    <td>

                        <img src="../../img/<?php echo $expo['imagen']; ?>" width="125" alt="">
                        

                    </td>
                    
                    <td>
                    
                    <form method="POST">

                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $expo['id']; ?>" />

                        <input type="submit" name="accion" value="Seleccionar" class="btn-primary" />
                        <input type="submit" name="accion" value="Borrar" class="btn-danger" />

                    </form>
                
                    </td>
                
            </tr>
            <?php }?>
                
            </tbody>
        </table>

    </div>

<?php include("../template/pie.php"); ?>