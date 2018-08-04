<?php
    session_start();

    if ((!isset($_SESSION['userinfo']))){
        header('Location: index.php');
    }

    require __DIR__.'/bootstrap/autoload.php';
    
    use ZenEnv\ZenEnv;

    $env = new ZenEnv(__DIR__.'./.env');

    $envs= $env->get();

   
?>

<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>XBLog</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">    
    <link href="css/main.css" rel="stylesheet"> 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>

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

                <div class="navbar-right">
                    <ul class="nav navbar-nav ">
                        <li>
                            <a href="#">
                                <i class="fa fa-user"></i> <?php echo $_SESSION['userinfo']['name'] ?>
                            </a>
                        </li>
                        <li>
                            <a class="button" href="logout.php" onclick=" return confirm('你确定要退出吗?')">
                                <i class="fa fa-sign-out"></i> 注销
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">配置信息</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal">
                <div class="row">
                    <div class="form-group">
                        <label for="DB_HOST" class="col-md-2 control-label">
                            数据库服务器
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="DB_HOST" value="<?php echo trim($envs['DB_HOST']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="DB_DATABASE" class="col-md-2 control-label">
                            数据库
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="DB_DATABASE" value="<?php echo trim($envs['DB_DATABASE']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="DB_USERNAME" class="col-md-2 control-label">
                            数据库用户名
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="DB_USERNAME" value="<?php echo trim($envs['DB_USERNAME']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LOG_PATH" class="col-md-2 control-label">
                            密码
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="LOG_PATH" value="<?php echo trim($envs['LOG_PATH']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="OUTPUT_PATH" class="col-md-2 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="OUTPUT_PATH" value="<?php echo trim($envs['OUTPUT_PATH']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Last_Date" class="col-md-2 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="Last_Date" value="<?php echo trim($envs['Last_Date']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="CHANNEL" class="col-md-2 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="CHANNEL" value="<?php echo trim($envs['CHANNEL']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="CH_TITLE" class="col-md-2 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="CH_TITLE" value="<?php echo trim($envs['CH_TITLE']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="USER" class="col-md-2 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="USER" value="<?php echo trim($envs['USER']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="PASSWORD" class="col-md-2 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="PASSWORD" value="<?php echo trim($envs['PASSWORD']) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button type="button" class="btn btn-primary">保存</button>
                            <button type="button" class="btn btn-success">立刻执行</button>
                            <button type="button" class="btn btn-warning">取消</button>
                        </div>
                    </div>
                </div>    
            </form>    
          </div>
        </div>   
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>        
    </body>
</html>