<?php

session_start();

function errorP($texto) {
    $_SESSION['errorp'] = $texto;
    header('Location:cplataforma.php');
    die();
}

//si no soy admin no puedo entrar
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'Admin') {
    //die("No estoy validado!!!");
    header('Location:index.php');
    die();
}
//Protegemos el formulario de ataques csrf
if (!(isset($_SESSION['token']) && isset($_POST['token'])) || $_SESSION['token'] != $_POST['token']) {
    header('Location:index.php');
    die();
}
//Autoload de las clases
spl_autoload_register(function($nombre) {
    require './class/' . $nombre . '.php';
});
//cogemos los datos del formulario, comprobamos que el nombre no este vacio
$nombre = trim($_POST['nombre']);
if (strlen($nombre) == 0) {
    errorP("El campo nombre no pueder ser vacio o nulo!!!!!!");
}
//Si no hemos elegido ninguna imagen pondemos la default
//en otro caso la guardaremos
if (empty($_FILES['imagen']['tmp_name'])) {
    $nombreImagen = "img/plataformas/default.jpg";
} 
else {
    //verificamos que el archivo sea una imagen con el tipo mime
    $permitidos = ['image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/tiff'];
    if (!in_array($_FILES['imagen']['type'], $permitidos)) {
        errorP("El archivo de imagen debe ser una IMAGEN!!!!!");
    }
    //si todo esta bien lo guado fisicamente con un nombre unico
    //y lo insertamoes en la bbdd
    $id = time();
    $nombreImagen = "img/plataformas/" . $id . '_' . $_FILES['imagen']['name'];
    //  die($nombreImagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreImagen);
}

$conexion=new Conexion();
$llave=$conexion->getLlave();
$plataforma=new Plataformas($llave);
$plataforma->create($nombre, $nombreImagen);
$llave=null;
$_SESSION['mensaje']="Plataforma creada correctamente.";
header('Location:plataformas.php');

    