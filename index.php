<?php
session_start(); 
include('config/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= APP_NAME; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <center>
      <img src="<?= APP_URL ?>public/img/logeo.png" width="300px" alt="">
    </center>
    <div class="login-logo">
      <h3><b><?= APP_NAME ?></b></h3>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Digite sus credenciales</p>

        <form action="controler_login.php" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
          </div>
        </form>

        <!-- Mostrar alerta si hay mensaje -->
        <?php if (isset($_SESSION['mensaje'])): ?>
          <script>
            Swal.fire({
              position: "center",
              icon: "error",
              title: "<?= $_SESSION['mensaje']; ?>",
              showConfirmButton: false,
              timer: 4000
            });
          </script>
          <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        
      </div>
    </div>
  </div>

  <script src="<?= APP_URL; ?>/public/plugins/jquery/jquery.min.js"></script>
  <script src="<?= APP_URL; ?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= APP_URL; ?>/public/dist/js/adminlte.min.js"></script>

</body>
</html>
