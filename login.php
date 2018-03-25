<?php
session_start(); 
if (isset($_SESSION['username'])){
    echo ("<script>location.href='manage.php'</script>");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

  <title>Manager</title>
</head>
<body>
  <div class="container ">
    <div class="row">
        <div class="col-md-9 m-auto">
            <h2 class="text-center text-white mb-4">Bootstrap 4 Login Form</h2>
            <div class="row">
                <div class="col-md-9 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">Login</h3>
                        </div>
                        <div class="card-body">
                            <form class="form" role="form" id="formLogin" method="POST">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username" required="">
                                    <div class="invalid-feedback">Oops, you missed this one.</div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password" required="" autocomplete="new-password">
                                    <div class="invalid-feedback">Enter your password too!</div>
                                </div>
                                <div>
                                    <label class="custom-control custom-checkbox">
                                      <input type="checkbox" >
                                     
                                      <span class="custom-control-description small text-dark">Remember me on this computer</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin">Login</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>

            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>


 <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
 <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
 <script type="text/javascript" src="assets/js/login.js"></script>
</body>
</html>