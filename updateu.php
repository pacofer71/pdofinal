<?php

session_start();
function errorP($texto) {
    $_SESSION['errorp'] = $texto;
    header("Location:mperfil.php?nombre={$_POST['nombreV']}");
    die();
}

function mensaje($texto, $id) {
    $_SESSION['mensaje'] = $texto;
    header('Location:usuarios.php');
    die();
}

//si no soy admin no puedo entrar
if (!isset($_SESSION['perfil'])) {
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
//recogemos todo
$nombreV=$_POST['nombreV'];
$nombreF=trim($_POST['nombre']);
$email=trim($_POST['email']);
//die($nombreF.", ".$email);
if(strlen($nombreF)==0 || strlen($email)==0){
    errorP("El nombre o el email no puden ser solo espacios en blanco !!!!!");
}
$conexion=new Conexion();
$llave=$conexion->getLlave();
$usuario=new Usuarios($llave);
$dato=$usuario->isOk($nombreV, $nombreF, $email);
if(!$dato){
    errorP("Error el usuario o el mail YA están registrados!!!!!!!!");
}
die("Guardando todo");