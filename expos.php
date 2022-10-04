<?php include("./template/cabecera.php"); ?>

    <?php
        include("administrador/config/bd.php");

        $sentenciaSQL= $conexion->prepare("select * from expos");
        $sentenciaSQL->execute();
        $listaexpos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <?php foreach($listaexpos as $expo) { ?>
    <div class="row-md-4">
    <div class="card">
        <img class="card-img-top" src="./img/<?php echo $expo['imagen']; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"> <?php echo $expo['nombre']; ?> </h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button">Ver mas</a>
        </div>
    </div>
    </div>
    <?php } ?>


<?php include("./template/pie.php"); ?>