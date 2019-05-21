<?php
    session_start();
    
    spl_autoload_register(function($nombre){
        require './class/'.$nombre.'.php';
        
    });
    function fmensaje($texto){
        $_SESSION['msg']=$texto;
        header('Location:login.php');
        die();
    }
    //atques csrf
    if (!(isset($_SESSION['token']) && isset($_POST['token'])) || $_SESSION['token'] != $_POST['token']) {
        fmensaje("Error de Token !! Ataque CSRF detectado!!!");
    }
    //Recogemos todo del formulario
    $nombre=trim($_POST['nombre']);
    $pass=trim($_POST['pass']);
    if(strlen($nombre)==0 || strlen($pass)==0){
        fmensaje("El nombre y la contraseña NO pueden ser solo espacios en blanco!!!");
    }
    $conexion=new Conexion();
    $llave=$conexion->getLlave();
    $usuario =new Usuarios($llave);
    $resultado=$usuario->validar($nombre, $pass);
    if(is_numeric($resultado)){
        fmensaje("Error de validacion, revise credenciales!!!");
        $llave=null;
    }
    else{
        $_SESSION['perfil']=$resultado[1];
        $_SESSION['email']=$resultado[0];
        $_SESSION['nombre']=$nombre;
        $llave=null;
        header('Location:index.php');
    }    