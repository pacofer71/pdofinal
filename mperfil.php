<?php
session_start();
//si no soy admin NO puedo entrar
if (!isset($_SESSION['perfil'])) {
    header('Location:index.php');
    die();
}
if(!isset($_REQUEST['nombre'])){
    header('Location:index.php');
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
    $usuario = new Usuarios($_SESSION['nombre'], $_SESSION['perfil'], $_SESSION['email']);
    $usuario->pintarCabecera();

    ?>
    <h3 class='text-center mt-3'>Modificar Usuario</h3>
    <?php
    if (isset($_SESSION['errorp'])) {
        echo "<div class='container text-danger'>";
        echo $_SESSION['errorp'];
        $_SESSION['errorp'] = null;
        echo "</div>";
    }
    $nombre=$_REQUEST['nombre'];
   // die($nombre);
    $conexion=new Conexion();
    $llave=$conexion->getLlave();
    $esteUsuario = new Usuarios($llave);
    $datos=$esteUsuario->mostrar($nombre);
    ?>
    <div class="container mt-4">
    <form name='df' action='updateu.php' method='POST' >
        <input type='hidden' name='token' value='<?php echo $_SESSION['token'] ?>'' />
        <div class="form-group row">
    <label for="em" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="em" value="<?php echo $datos->email ?>" name='email'>
    </div>
  </div>
  <div class="form-group row">
    <label for="nom" class="col-sm-2 col-form-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nom" value='<?php echo $datos->nombre ?>' name='nombre'>
    </div>
  </div>
  <div class="form-group row">
    <label for="pass" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="pass" name='password' value='****'>
    </div>
  </div>
  <?php 
    if($_SESSION['perfil']!='Admin'){
            # code...
    ?>
  <div class="form-group row">
    <label for="p" class="col-sm-2 col-form-label">Perfil</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control" id="p" value='<?php echo $datos->perfil ?>' name='perfil'>
    </div>
  </div>
  <?php 
    }
    if($_SESSION['perfil']=='Admin'){
        $otroUsuario=new Usuarios($llave);
        $datos=$otroUsuario->read();
        echo "<label for='p' class='col-sm-2 col-form-label'>Perfil</label>";
        echo "<select name='perfil' class='form-control'>";
        foreach($datos as $item){
            echo "<option value='{$item->perfil}'>{$item->perfil}</option>";
        }
        echo "</select>";
    }
    ?>
    </form>
    </div>
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>