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
      
      <h3 class="text-center mt-3">Login</h3>
      <?php
      $_SESSION['token']=generarToken();
      
       if(isset($_SESSION['msg'])){
           echo "<p class='container text-danger'>";
                   echo $_SESSION['msg'];
           echo "</p>";
           unset($_SESSION['msg']);
       }
      ?>
      <div class="container mt-3" style="border: white 8px groove; padding: 6px">
            <form name='login' action='plogin.php' method='POST' > 
             <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" /> 
                
                <div class="form-group">
                    <label for="nom">Nombre</label>
                    <input type="txt" class="form-control" required id="nom" placeholder="Nombre" name='nombre' />
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" required id="pass" placeholder="Password" name='pass' />
                </div>

                <button type="submit" class="btn btn-primary" name='btn'>Login</button>&nbsp;
                <input type='reset' value='Limpiar' class='btn btn-warning' />&nbsp;
                <a href="index.php" class="btn btn-success">Entrar Como Invitado</a>
               
            </form>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>