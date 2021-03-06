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
            $this->email = func_get_arg(2);
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
        echo "<form name='cerrar' action='cerrarSesion.php' method='POST' style='display:inline;'>\n";
        echo "<b>Usuario:</b> " . $this->nombre . "&nbsp|&nbsp;\n";
        echo "<b>Perfil:</b> " . $this->perfil . "&nbsp|&nbsp;\n";
        echo "<b>Email:</b> " . $this->email . "&nbsp;";
        echo "<input type='hidden' name='token' value='{$_SESSION['token']}' />\n";
        echo "<input type='submit' class='btn btn-danger' value='Cerrar Session'>\n";
        echo "</form>&nbsp;";
        echo "<form name='mp' action='mperfil.php' method='POST' style='white-space:nowrap; display:inline'>";
        echo "<input type='hidden' name='token' value='{$_SESSION['token']}' />\n";
        echo "<input type='hidden' name='nombre' value='{$this->nombre}' />\n";
        echo "<input type='submit' value='Perfil' class='btn btn-warning' />\n";
        echo "</form>";
        echo "</div>";
    }

    //-----------------------------------------------------------
    public function mostrar($nom)
    {
        $consulta = "select nombre, perfil, email from usuarios where nombre=:n";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute(
                [
                ':n' => $nom
                ]);
        } catch (PDOException $ex) {
            die("Error al recuperar usuario: " . $ex->getMessage());
        }
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
        return $fila;
    }
    //------------------------------------------------------------------------------
    public function read(){
        $cons="select * from usuarios";
        $stmt=$this->conexion->prepare($cons);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar los usuarios!!!! ".$ex->getMessage());
        }
        $datos=$stmt->fetchAll(PDO::FETCH_OBJ);
        return $datos;

    }
    //
    public function isOK($nomV, $nombreF,  $emailF){
        $con="select * from usuarios where nombre!='$nomV' and (nombre='$nombreF' or email='$emailF')";
        $dato=$this->conexion->query($con);
        $total=$dato->rowCount();
        if($total==0) return true;
        return false; 
    }
    //--------------------------------------------------
    public function update($nv, $n, $e, $p){
        $cons="update usuarios set nombre=:n, email=:e, perfil=:p where nombre=:nv";
        $stmt=$this->conexion->prepare($cons);
        try{
            $stmt->execute([
                ':n'=>$n,
                ':e'=>$e,
                ':p'=>$p,
                ':nv'=>$nv
            ]);
        }catch(PDOException $ex){
            die("Error al actualizar el usuario!!!! ".$ex->getMessage());
        }
    }
    public function update1($nv, $n, $e, $p, $pass){
        $cons="update usuarios set nombre=:n, email=:e, perfil=:p, pass=:pass where nombre=:nv";
        $stmt=$this->conexion->prepare($cons);
        $passBuena=hash('sha224', $pass);
        //die($passBuena);
        try{
            $stmt->execute([
                ':n'=>$n,
                ':e'=>$e,
                ':p'=>$p,
                ':pass'=>$passBuena,
                ':nv'=>$nv
            ]);
        }catch(PDOException $ex){
            die("Error al actualizar el usuario!!!! ".$ex->getMessage());
        }
    }
}
