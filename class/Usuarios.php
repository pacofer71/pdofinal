<?php

class Usuarios {

    private $conexion;
    private $nombre;
    private $perfil;
    private $pass;
    private $email;

    public function __construct() {
        //Miramos el numero de argumentos
        $numParam = func_num_args();
        if ($numParam == 1) {
            //solo hemos recibido un parametro
            $this->ponerConexion(func_get_arg(0));
        }
    }

    public function ponerConexion($con) {
        $this->conexion = $con;
    }

    //-------------------------------------------------
    public function validar($nom, $pass) {
        //paso el $pass a sha224
        $passCifrada=openssl_digest($pass, "sha224", false);
        //die($passCifrada);
        $consulta = "select * from usuarios where nombre=:nom and pass=:pass";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([
                        ':nom' => $nom,
                        ':pass' => $passCifrada
                    ]);
            
        } catch (PDOException $ex) {
            die("Error en validar usuarios, mensaje=" . $ex->getMessage());
        }
        if($stmt->rowCount()==0){
            //si no encuentro nada devuelvo 0 
            return 0;
        }
        else{
            //si encuentro al usu y su pass de devuelvo el mail
            //para mostrarlo y el prefil para gestionar donde podra o no
            //ingresar
            $datos=$stmt->fetch(PDO::FETCH_OBJ);
            $devolver=[$datos->email, $datos->perfil];
            $stmt=null;
            
            return $devolver;
            //cierro todo
            
        }
    }

    //-----------------------------------------------------------
}
