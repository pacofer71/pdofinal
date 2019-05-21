<?php
session_start();

function generarToken() {
    return bin2hex(random_bytes(32 / 2));
}

if (!isset($_SESSION['perfil'])) {
    header('Location:index.php');
    die();
}
spl_autoload_register(function($nombre){
    require './class/'.$nombre.'.php';
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
        if (isset($_SESSION['perfil'])) {
            echo "<div class='text-right' style='border: white 4px groove;'>";
            echo "<form name='cerrar' action='cerrarSesion.php' method='POST'>";
            echo "<b>Usuario:</b> " . $_SESSION['nombre'] . "&nbsp|&nbsp;";
            echo "<b>Perfil:</b> " . $_SESSION['perfil'] . "&nbsp|&nbsp;";
            echo "<b>Email:</b> " . $_SESSION['email'] . "&nbsp;";
            echo "<input type='hidden' name='token' value='{$_SESSION['token']}' />";
            echo "<input type='submit' class='btn btn-danger' value='Cerrar Session'>";
            echo "</form>";
            echo "</div>";
        }
        ?>
        <h3 class="text text-center mt-3">Plataformas Disponibles</h3>
        <?php
            if($_SESSION['perfil']=='Admin'){
                echo "<div class='container mt-2'>";
                echo "<a href='cplataforma.php' class='btn btn-info'>Crear Plataforma</a>";
                echo "</div>";
            }
         ?>
        </div>
        <div class="container mt-3">
             <?php
            if(isset($_SESSION['mensaje'])){
                echo "<div class='container text-danger'>";
                echo $_SESSION['mensaje'];
                $_SESSION['mensaje']=null;
                echo "</div>";
            }
        ?>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Imagen</th>
                        <?php
                        if($_SESSION['perfil']=='Admin'){
                        echo "<th scope='col'>Acciones</th>";
                        }
                                ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $miConexion=new Conexion();
                        $llave=$miConexion->getLlave();
                        $lasPlataformas=new Plataformas($llave);
                       
                        //-------------
                        $paginacion=4; //cantidad de registros por pagina
                        $total=$lasPlataformas->getTotalRegistros(); //total registros
                        $npaginas=ceil($total/$paginacion);//total de paginas
                        if(isset($_GET['pag'])){
                            $inf=($_GET['pag']-1)*$paginacion;
                            $plataformas=$lasPlataformas->read($inf,$paginacion); 
                        }
                        else{
                           $plataformas=$lasPlataformas->read(0, $paginacion); 
                        }
                         
                        
                        foreach($plataformas as $item){
                            echo "<tr>";
                            echo "<td>{$item[0]}</td>";
                            echo "<td>{$item[1]}</td>";
                            echo "<td><img src='{$item[2]}' width='80px' /></td>";
                            if($_SESSION['perfil']=='Admin'){
                            echo "<td>";
                            echo "<form name='br' action='delete.php' method='POST' >";
                            echo "<input type='hidden' value='{$_SESSION['token']}' name='token' />";
                            echo "<input type='hidden' name='id' value='{$item[0]}' />";
                            echo "<input type='submit' value='Borrar' class='btn btn-danger' />";
                            echo "</form>";
                            echo "</td>";
                            }
                            echo "</tr>";
                            
                        }
                        $llave=null;
                        
                    ?>
                   
                </tbody>
            </table>
            <?php
                
                for($i=1; $i<=$npaginas; $i++){
                    if($i!=$npaginas){
                        echo "<a href=plataformas.php?pag=$i style='text-decoration:none'>|&nbsp;$i&nbsp;</a>";
                    }
                    else{
                        echo "<a href=plataformas.php?pag=$i style='text-decoration:none'>|&nbsp;$i&nbsp;|</a>";
                    }
                }
            ?>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>