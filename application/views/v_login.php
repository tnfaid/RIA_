<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/login.css">
  <title>Mirai Store</title>
</head>
<body>
      

      <!-- Form Mixin-->
      <!-- Input Mixin-->
      <!-- Button Mixin-->
      <!-- Pen Title-->
      <div class="pen-title" style="padding-top: 100px">
      </div>
      <!-- Form Module-->
      <form action='<?php echo base_url(); ?>index.php/transaksi' method='post'>
      <div class="module form-module" >
        <?php
        if($this->session->has_userdata('salah_login')){?>

        <div class="alert alert-danger" role="alert">
        <?php echo $this->session->userdata('salah_login');?>
        </div>

        <?php
        }
        ?>
        <div class="container">
        <div id="login" class="signin-card">
          <div class="logo-image center">
              <img src="http://www.officialpsds.com/images/thumbs/Spiderman-Logo-psd59240.png" alt="Logo" title="Logo" width="138">
          </div>
          <h1 class="display1 center" style="center">Mirai Store</h1>
          <form action="" method="" class="" role="form">
            <div id="form-login-username" class="form-group">
              <input id="username" class="form-control" name="username" type="text" size="18" alt="login" required />
              <span class="form-highlight"></span>
              <span class="form-bar"></span>
              <label for="username" class="float-label">login</label>
            </div>
            <div id="form-login-password" class="form-group">
              <input id="passwd" class="form-control" name="password" type="password" size="18" alt="password" required>
              <span class="form-highlight"></span>
              <span class="form-bar"></span>
              <label for="password" class="float-label">password</label>
            </div>
            <div>
              <button class="btn btn-block btn-info ripple-effect" type="submit" name="Submit" alt="sign in">Sign in</button>  
            </div>

            </div>
          </form>
        </div>
        </div>
    </form>

</body>
</html>