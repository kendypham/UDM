<?php
   $option = isset($_POST['taskOption']) ? $_POST['taskOption'] : false;
   if ($option) {
      echo htmlentities($_POST['taskOption'], ENT_QUOTES, "UTF-8");
   } else {
     echo "task option is required";
     exit; 
   }