<?php

class Plataformas {

    private $conexion;
    private $id;
    private $nombre;
    private $imagen;

    public function __construct() {
        $numeroArg = func_num_args();
        if ($numeroArg == 1) {
            $this->setConexion(func_get_arg(0));
        }
    }

    public function setConexion($con) {
        $this->conexion = $con;
    }

    // Crud --------------------------------
    //create-------------
    public function create($n, $i) {
        $insertar = "insert into plataformas(nombre,imagen) values(:nom, :ima)";
        $stmt = $this->conexion->prepare($insertar);
        try {
            $stmt->execute([
                ':nom' => $n,
                ':ima' => $i
            ]);
        } catch (PDOException $ex) {
            die("Error al guardar en platformas!!! " . $ex->getMessage());
        }
    }

    //------------
    public function getTotalRegistros() {
        $consulta = "select * from plataformas";
        try {
            //guardo las plataformas en un array y las devuelvo
            $plataformas = $this->conexion->query($consulta);
        } catch (PDOException $ex) {
            die("Error al recuperar las plataformas!!!" . $ex->getMessage());
        }

        return $plataformas->rowCount();
    }

    //read
    public function read($inf, $pag) {
        //mostraremos todas las plataformas;
        $consulta = "select * from plataformas limit $inf,$pag";
        try {
            //guardo las plataformas en un array y las devuelvo
            $plataformas = $this->conexion->query($consulta);
        } catch (PDOException $ex) {
            die("Error al recuperar las plataformas!!!" . $ex->getMessage());
        }

        return $plataformas;
    }

    //update----------------------------------------------------------------------------------
    public function update() {
        if(func_num_args()==3){
            $id=func_get_arg(0);
            $nombre=func_get_arg(1);
            $imagen=func_get_arg(2);
            //die("id=$id, nombre=$nombre, imagen=$imagen");
            $update="update plataformas set nombre=:nom, imagen=:imagen where id=:cod";
            $ima=true;
        }
        else{
            $id=func_get_arg(0);
            $nombre=func_get_arg(1);
            $update="update plataformas set nombre=:nom where id=:cod";
            $ima=false;
        }
        $stmt=$this->conexion->prepare($update);
        try{
            if($ima){
                $stmt->execute([
                    ':nom'=>$nombre,
                    ':imagen'=>$imagen,
                    ':cod'=>$id
                ]);
            }
            else{
                $stmt->execute([
                    ':nom'=>$nombre,
                    ':cod'=>$id
                ]);
            }
        }catch(PDOException $ex){
            die("Error al actualizar: ".$ex->getMessage());
        }
    }

    //delete------------------------------------------------------------------------
    public function delete($id) {
        $del = "delete from plataformas where id=:cod";
        $stmt = $this->conexion->prepare($del);
        try {
            $stmt->execute([
                ':cod' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar Plataforma!! " . $ex->getMessage());
        }
    }

    //-----------------------------
    public function borrarArchivoImagen($id) {
        $consulta = "select imagen from plataformas where id=:cod";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([
                ':cod' => $id
            ]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
        $miImagen=$fila->imagen;
       
       
        if(basename($miImagen)!='default.jpg'){
            return $miImagen;
        }
        return 1;
    }

//-------------------------
public function verPlataforma($id){
    $consulta="select nombre, imagen from plataformas where id=:cod";
    $stmt=$this->conexion->prepare($consulta);
    try{
        $stmt->execute([
            ':cod'=>$id
        ]);
    }catch(PDOException $ex){
        die("Error al recuperar una plataforma!!! ".$ex->getMessage());
    }
    $fila=$stmt->fetch(PDO::FETCH_OBJ);
    return $fila;

}
//----------------------------------------------------------------------


}
