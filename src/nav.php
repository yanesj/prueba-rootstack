<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand" href="dashboardAdmin.php">Reportes Uniminuto</a>
  <input type="hidden" id="host" name="host" value="<?php echo $host ?>">
  <ul class="navbar-nav d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        &nbsp;&nbsp;&nbsp;Bienvenido(a) <br/>&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'] ?>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="closeAdmin.php">Salir</a>
      </div>
    </li>
  </ul>
</nav>
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <?php include('../include/sideMenu.php'); ?>
      </div>
      <div class="sb-sidenav-footer">
        <div class="small">Usuario Logeado:</div>
          <?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'] ?>
      </div>
    </nav>
  </div>