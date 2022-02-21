<?php
session_start();
if (isset($_SESSION['user_authorized'])) {
    session_destroy();
}
?>
<?php
if (isset($_POST['login'])) {
    include('../clases/auth.php');
    $user = new auth();//Se instancia el objeto de la clase auth
    $resp= $user->login($_POST['email'],$_POST['password']); //Se accede al metodo login
 
    if ($resp[0]['code_response']=='00') {
        $_SESSION['user_authorized']=true;
        $_SESSION['nombre']=$resp[0]['name'];
        $_SESSION['apellido']=$resp[0]['last_name'];

        header("Location: r_viewAll.php");
    } else {
       if($resp[0]['code_response']=='01'){
         echo 'Usuario o contraseña incorrecto';
       }
       else{
          echo $resp[0]['code_response'];
       } 
    }
    
}
?>   
<!DOCTYPE html>
<html lang="en">
  <?php
    require_once '../src/head.php';
  ?>
  <body>
    <div id="layoutAuthentication">
      <div id="layoutAuthentication_content">
        <main>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <br/>
                <br/>
                <img src="../images/logo.png" style="display:block;margin:auto;">
                <div class="card shadow-lg border-0 rounded-lg mt-3">
                  <div class="card-body" id="estProf">
                    <form id="loginForm2" name="loginForm2" method="POST">
                      <div class="form-group">
                        <label class="small mb-1" for="inputEmailAddress">Correo</label>
                        <input class="form-control py-4"  id="email" name="email" type="email" placeholder="Digite Correo" />
                      </div>
                      <div class="form-group">
                        <label class="small mb-1" for="inputPassword">Contraseña</label>
                        <input class="form-control py-4"  id="password" name="password" type="password" placeholder="Digite Contraseña" />
                      </div>
                      <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button type="submit" class="btn btn-warning" id="login" name="login">Iniciar sesión</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
      <div id="layoutAuthentication_footer">
        <?php
          require_once '../src/footer.php';
        ?>
    </div>
  </div>
  <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>-->
  </body>
</html>
