<?php

session_start();

require __DIR__.'./../bootstrap/autoload.php';

use ZenEnv\ZenEnv;

$env = new ZenEnv(__DIR__.'./../.env'); 
$envs = $env->get();

$username=trim($_POST["username"]);
$userpass=base64_encode(trim($_POST["password"]));

if ($username==trim($envs['USER'])) {
  if ($userpass==trim($envs['PASSWORD'])) {
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

       
       


    

  
 

