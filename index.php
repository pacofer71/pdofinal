<?php
    session_start();
    function generarToken(){
        return bin2hex(random_bytes(32/2));
    }
?>
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
      $_SESSION['token']= generarToken();
      if(isset($_SESSION['perfil'])){
        require 'class/Usuarios.php';
        $usuario=new Usuarios($_SESSION['nombre'], $_SESSION['perfil'], $_SESSION['email']);
          $usuario->pintarCabecera();
      }
       ?>
      <h3 class="text-center mt-3">Videos Juegos S.A.</h3>
      <div class="container mt-4 text-center">
          <a href="login.php" class="btn btn-info">Login</a>&nbsp;
          <a href="#" class="btn btn-info">Ver Juegos</a>&nbsp;
          <?php
            if(isset($_SESSION['perfil'])){
                echo "<a href='plataformas.php' class='btn btn-info'>Ver Plataformas</a>&nbsp;";
                if($_SESSION['perfil']=='Admin'){
                    echo "<a href='#' class='btn btn-info'>Gestionar Usuarios</a>";
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