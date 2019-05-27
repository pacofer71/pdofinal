<?php
session_start();
//si no soy admin NO puedo entrar
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'Admin') {
    header('Location:index.php');
    die();
}

function generarToken()
{
    return bin2hex(random_bytes(32 / 2));
}
spl_autoload_register(function ($nombre) {
    require './class/' . $nombre . '.php';
});
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Video Juegos</title>
</head>

<body style="background-color: sandybrown">
    <?php
    $_SESSION['token'] = generarToken();

    echo "<div class='text-right' style='border: white 4px groove;'>";
    echo "<form name='cerrar' action='cerrarSesion.php' method='POST'>\n";
    echo "<b>Usuario:</b> " . $_SESSION['nombre'] . "&nbsp;|&nbsp;\n";
    echo "<b>Perfil:</b> " . $_SESSION['perfil'] . "&nbsp;|&nbsp;\n";
    echo "<b>Email:</b> " . $_SESSION['email'] . "&nbsp;\n";
    echo "<input type='hidden' name='token' value='{$_SESSION['token']}' />\n";
    echo "<input type='submit' class='btn btn-danger' value='Cerrar Session'>";
    echo "</form>\n";
    echo "</div>";
    ?>
    <h3 class='text-center mt-3'>Modificar Plataforma</h3>
    <?php
    if (isset($_SESSION['errorp'])) {
        echo "<div class='container text-danger'>";
        echo $_SESSION['errorp'];
        $_SESSION['errorp'] = null;
        echo "</div>";
    }
    // recupero todos los datos de l a  plataforma (nombre e imagen)
    $conexion = new Conexion();
    $llave = $conexion->getLlave();
    $plataforma = new Plataformas($llave);
    $id=$_GET['id'];
    $fila = $plataforma->verPlataforma($id);
    $nombre = $fila->nombre;
    $imagen = $fila->imagen;
    //die($nombre. ", ".$imagen);
    ?>
    <div class="container mt-4" style='border: white 4px groove; padding: 8px'>
        <form name='uno' method='POST' enctype="multipart/form-data" action='updatep.php'>
            <input type='hidden' name='token' value='<?php echo $_SESSION['token']; ?>' />
            <input type='hidden' name='id' value='<?php echo $id ?>' />
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" value='<?php echo $nombre ?>' name='nombre' required />
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col">
                    <img src='<?php echo $imagen; ?>' width='100px' />
                    &nbsp;&nbsp;
<a href='mplataforma.php?id=<?php echo $id; ?>&ima=1' class='btn btn-success'>Cambiar</a>
                </div>
                
            </div>
            <?php if (isset($_GET['ima'])) { ?>
                <div class="from-row mt-4">
                    <div class="col">
                        <label for="im"><b>Imagen:&nbsp;</b></label>
                        <input type="file" name='imagen' id='im' />
                    </div>
                </div>
            <?php } ?>

            <div class="form-row mt-4">
                <div class="col">
                    <input type='submit' value='Modificar' class='btn btn-success' />&nbsp;
                    <a href='plataformas.php' class='btn btn-info'>Volver</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>