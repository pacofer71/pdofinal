<?php

session_start();
function errorP($texto) {
    $_SESSION['errorp'] = $texto;
    header("Location:mplataforma.php?id=");
    die();
}

function mensaje($texto, $id) {
    $_SESSION['mensaje'] = $texto;
    header('Location:plataformas.php?id=$id');
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
//recupero el ide de la plataforma
$id=$_POST['id'];
//cogemos los datos del formulario, comprobamos que el nombre no este vacio
$nombre = trim($_POST['nombre']);
if (strlen($nombre) == 0) {
    errorP("El campo nombre no pueder ser vacio o nulo!!!!!!", $id);
}
//Si no hemos elegido ninguna imagen dejamos la que tiene
//en otro caso la guardaremos
$conexion=new Conexion();
$llave = $conexion->getLlave();
$plataforma= new Plataformas($llave);
$datos=$plataforma->borrarArchivoImagen($id);
if (empty($_FILES['imagen']['tmp_name'])) {
    $imagen=false;
}
else{
    $permitidos = ['image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/tiff'];
    if (!in_array($_FILES['imagen']['type'], $permitidos)) {
        errorP("El archivo de imagen debe ser una IMAGEN!!!!!", $id);
    }
    //si todo esta bien lo guado fisicamente con un nombre unico
    //y lo insertamoes en la bbdd
    $idm = time();
    $nombreImagen = "img/plataformas/" . $idm . '_' . $_FILES['imagen']['name'];
    //  die($nombreImagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreImagen);
    //debemos borrar la imagen antigua recuperamos el nombre de la imagen y la borramos si no es la default
    if(!is_numeric($datos)){
        unlink($datos);
    }
    $imagen=true;
} 
//ahora hacemos el update propiamente dicho
if($imagen){
    $plataforma->update($id, $nombre, $nombreImagen);
}
else{
    $plataforma->update($id, $nombre);
}
$llave=null;
mensaje("Plataforma actualizada con exito.");

