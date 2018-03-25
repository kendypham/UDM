<?php

include('db_conf.php');
  if(isset($_POST['username'],$_POST['password'])){

  $result=LoginAdministactor($_POST['username'],$_POST['password']);
  $result=trim($result);
  if(!strcmp($result, "success")){
  	  $_SESSION['username'] = $_POST['username'];
  	  $_SESSION['admin'] = true;
  	  print_r("success");
  }
   else {
   print_r("login failed");
   }
  }
?>