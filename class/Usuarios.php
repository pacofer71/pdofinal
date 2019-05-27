<?php

class Usuarios
{

    private $conexion;
    private $nombre;
    private $perfil;
    private $pass;
    private $email;

    public function __construct()
    {
        //Miramos el numero de argumentos
        $numParam = func_num_args();
        if ($numParam == 1) {
            //solo hemos recibido un parametro
            $this->ponerConexion(func_get_arg(0));
        }
        if ($numParam == 3) {
            $this->nombre = func_get_arg(0);
            $this->perfil = func_get_arg(1);
            $this->mail = func_get_arg(2);
        }
    }

    public function ponerConexion($con)
    {
        $this->conexion = $con;
    }

    //-------------------------------------------------
    public function validar($nom, $pass)
    {
        //paso el $pass a sha224
        $passCifrada = openssl_digest($pass, "sha224", false);
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
        if ($stmt->rowCount() == 0) {
            //si no encuentro nada devuelvo 0 
            return 0;
        } else {
            //si encuentro al usu y su pass de devuelvo el mail
            //para mostrarlo y el prefil para gestionar donde podra o no
            //ingresar
            $datos = $stmt->fetch(PDO::FETCH_OBJ);
            $devolver = [$datos->email, $datos->perfil];
            $stmt = null;

            return $devolver;
            //cierro todo

        }
    }
    //-----------------------------------------------------------------------------
    public function pintarCabecera()
    {
        echo "<div class='text-right' style='border: white 4px groove;'>";
        echo "<form name='cerrar' action='cerrarSesion.php' method='POST' style='display:inline;'>";
        echo "<b>Usuario:</b> " . $this->nombre . "&nbsp|&nbsp;";
        echo "<b>Perfil:</b> " . $this->perfil . "&nbsp|&nbsp;";
        echo "<b>Email:</b> " . $this->email . "&nbsp;";
        echo "<input type='hidden' name='token' value='{$_SESSION['token']}' />";
        echo "<input type='submit' class='btn btn-danger' value='Cerrar Session'>";
        echo "</form>&nbsp;";
        echo "<form name='mp' action='mperfil.php' method='POST' style='white-space:nowrap; display:inline'>";
        echo "<input type='hidden' name='token' value='{$_SESSION['token']}' />\n";
        echo "<input type='hidden' name='nombre' value='{$this->nombre}' />\n";
        echo "<input type='submit' value='Perfil' class='btn btn-success' />";
        echo "</form>";
        echo "</div>";
    }

    //-----------------------------------------------------------
    public function mostrar($nom)
    {
        $consulta = "select nombre, perfil, email from usuarios where nombre:n";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute(
                [
                ':n' => $nom
                ]);
        } catch (PDOException $ex) {
            die("Error al recuperar usaurio: " . $ex->getMessage());
        }
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
    }
}
