<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
      backdrop-filter: contrast(1);
    }
    #page-title{
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
    .g-recaptcha {
      margin-bottom: 15px;
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-navy my-2">
    <div class="card-body">
      <p class="login-box-msg">Please enter your credentials</p>
      <form id="login-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" autofocus placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="g-recaptcha" data-sitekey="6LehJi8rAAAAANIErYDJqUslXnDj5nCBj4nKHzDv"></div>
        <div class="row">
          <div class="col-8">
            <!-- <a href="< ?php echo base_url ?>">Go to Website</a> -->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url ?>dist/js/adminlte.min.js"></script>
<!-- reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
  $(document).ready(function(){
    end_loader();
    
    $('#login-frm').submit(function(e){
      e.preventDefault();
      start_loader();
      
      // Check if reCAPTCHA is completed
      var recaptchaResponse = grecaptcha.getResponse();
      if(recaptchaResponse.length === 0) {
        alert_toast("Please complete the reCAPTCHA verification", "error");
        end_loader();
        return false;
      }
      
      $.ajax({
        url: _base_url_ + "classes/Login.php?f=login",
        data: $(this).serialize() + "&recaptcha_response=" + recaptchaResponse,
        method: "POST",
        dataType: "json",
        error: err => {
          console.error(err);
          alert_toast("An error occurred", "error");
          end_loader();
        },
        success: function(resp) {
          if(resp.status == 'success') {
            location.href = _base_url_ + resp.redirect;
          } else if(!!resp.msg) {
            alert_toast(resp.msg, "error");
          } else {
            alert_toast("An error occurred", "error");
          }
          end_loader();
        }
      });
    });
  });
</script>
</body>
</html>