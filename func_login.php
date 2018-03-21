<?php

include('db_conf.php');
  
  if(isset($_POST['username'],$_POST['password'])){

   print_r( LoginAdministactor($_POST['username'],$_POST['password']));ß
  }
?>