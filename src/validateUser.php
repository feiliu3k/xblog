<?php

session_start();

$username=trim($_POST["username"]);
$userpass=trim($_POST["password"]);
if ($username=='admin') {
  if ($userpass=='admin'){
      $userinfo['id'] = 1;
      $userinfo['name'] ='admin';     
      $_SESSION["userinfo"]=$userinfo;          
      header('Location: ../main.php');
  }
  else{
      $_SESSION['msg']='密码错误!';           
      echo '密码错误';           
  }
}
else{     
  $_SESSION['msg']='用户不存在!';
  echo '用户不存在';     
}

       
       


    

  
 

