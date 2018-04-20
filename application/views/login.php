<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/bootstrap.min.css">
  <title>TOKO SATURNUS</title>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">TOKO SATURNUS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

</nav>
<center>
<form class="form-signin" action='<?php echo base_url(); ?>index.php/ctrl_transaksi' method='post'>
<div class="container">

<?php
if($this->session->has_userdata('salah_login')){?>

<div class="alert alert-danger" role="alert">
<?php echo $this->session->userdata('salah_login');?>
</div>

<?php
}
?>
<h3>Please Login</h3>
<img src="">
  <div class="form-group">
    <label class="sr-only">Username</label>
    <input name="username" type="username" class="form-control" placeholder="Username">
  </div>
  <div class="form-group">
    <label class="sr-only">Password</label>
    <input name="password" type="password" class="form-control" placeholder="Password">
  </div>
</center>
  <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
</body>
</html>