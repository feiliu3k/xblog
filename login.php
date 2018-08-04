<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/lst.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
 
    <style type="text/css" rel="stylesheet">
        .login-box {
          width: 100%;
          max-width:500px;
          height: 400px;
          position: absolute;
          top: 50%;
          margin-top: -200px;
          /*设置负值，为要定位子盒子的一半高度*/
          
        }

        @media screen and (min-width:500px){
          .login-box {
            left: 50%;
            /*设置负值，为要定位子盒子的一半宽度*/
            margin-left: -250px;
          }
        } 

        .form {
          width: 100%;
          max-width:500px;
          height: 275px;
          margin: 25px auto 0px auto;
          padding-top: 25px;
        } 
        .login-content {
          height: 300px;
          width: 100%;
          max-width:500px;
          background-color: rgba(255, 250, 2550, .6);
          float: left;
        }
        .input-group {
          margin: 0px 0px 30px 0px !important;
        }
        .form-control,.input-group {
          height: 40px;
        }
        .form-group {
          margin-bottom: 0px !important;
        }
        .login-title {
          padding: 20px 10px;
          background-color: rgba(0, 0, 0, .6);
        }
        .login-title h1 {
          margin-top: 10px !important;
        }
        .login-title small {
          color: #fff;
        }

        .link p {
          line-height: 20px;
          margin-top: 30px;
        }
        .btn-sm {
          padding: 8px 24px !important;
          font-size: 16px !important;
        }
        .alert {
          box-shadow: 4px 4px 5px 0 rgba(50,50,50,.19);
        }
        .alert-success {
          color: red;
          background-color: #dff0d8;
          border-color: #d6e9c6;
        } 
    </style>
  </head>
  <body id="body">
    <div id="wrap" >
        <div  class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                   <a href="/" class="navbar-brand"><b>XBLog</b></a>
                </div>
                <div id="top-navbar-collapse" class="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="#">首页</a></li>        
                        <li class=""><a href="#">关于</a></li>        
                    </ul>
                   
                </div>
            </div>
        </div> 
        <?php 
             if (isset($_SESSION['msg'])){

               echo '<div class="container">
                      <div class="box text-center alert alert-success">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?php echo $_SESSION["msg"];?>
                      </div>
                   </div>';
               
             }
           ?>
        
       
        <div class="login_box">
          <div class="login-box">
              <div class="login-title text-center">
                  <h1><small>登录</small></h1>
              </div>
              <div class="login-content ">
              <div class="form">
              <form action="src/validateUser.php" method="post">
                  <div class="form-group">
                      <div class="col-xs-12  ">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <input type="text" id="username" name="username" class="form-control" placeholder="用户名">
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12  ">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                              <input type="password" id="password" name="password" class="form-control" placeholder="密码">
                          </div>
                      </div>
                  </div>
                  <div class="form-group form-actions">
                      <div class="col-xs-4 col-xs-offset-4 ">
                          <button type="submit" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-off"></span> 登录</button>
                      </div>
                  </div>
                  
              </form>
              </div>
            </div>
          </div>
        </div>     
    </div>

    
</body>
</html>