<?php
if($_POST){
    session_start();

    if ($_POST){
        if (($_POST['usuario']=="TallerSO") && ($_POST['contrasenia']=='12345')) {
            
            $_SESSION['usuario']="ok";
            $_SESSION['nombreUsuario']="TallerSO";
            header('Location:inicio.php');

        } else {
            if (($_POST['usuario']=="anonymus") && ($_POST['contrasenia']=='contraseña')) {
            
                $_SESSION['usuario']="ok";
                $_SESSION['nombreUsuario']="anonymus";
                header('Location:inicio.php');
    
            }else {
                if (($_POST['usuario']=="reprobado") && ($_POST['contrasenia']=='12345')) {
            
                    $_SESSION['usuario']="ok";
                    $_SESSION['nombreUsuario']="reprobado";
                    header('Location:../index.php');
        
                }else {
                    $mensaje="Error contraseña o usuario invalidos";
                }
            }
        }

        
    }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
        <div class="row">

            <div class="col-md-4">
                
            </div>

            <div class="col-md-4" style="margin-top: 175px;">
                
                <div class="card">

                    <div class="card-header">
                        <h1 style="text-align: center;">Login</h1>
                    </div>
                    
                    <div class="card-body">
                        
                    <?php if(isset($mensaje)) {?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                    <?php } ?>
                        
                        <form method="POST">

                            <div class = "form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Ingresa tu usuario">
                            </div>

                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Ingresa tu contraseña">
                            </div>

                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                        
                        

                    </div>
                
                </div>

            </div>
            
        </div>
    </div>

  </body>
</html>