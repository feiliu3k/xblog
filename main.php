
<?php
    session_start();

    if ((!isset($_SESSION['userinfo']))){
        header('Location: index.php');
    }

    require __DIR__.'/bootstrap/autoload.php';

    use ZenEnv\ZenEnv;

    $env = new ZenEnv(__DIR__.'./.env');   
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $DB_HOST=trim($_POST["DB_HOST"]);
        $DB_DATABASE=trim($_POST["DB_DATABASE"]);
        $DB_USERNAME=trim($_POST["DB_USERNAME"]);
        $DB_PASSWORD=trim($_POST["DB_PASSWORD"]);
        
        $LOG_PATH=trim($_POST["LOG_PATH"]);
        $OUTPUT_PATH=trim($_POST["OUTPUT_PATH"]);
        $Last_Date=trim($_POST["Last_Date"]);
        $CHANNEL=trim($_POST["CHANNEL"]);
        $CH_TITLE=trim($_POST["CH_TITLE"]);
        
        $USER=trim($_POST["USER"]);
        $PASSWORD=trim($_POST["PASSWORD"]);

        $env->set([
            'DB_HOST' => $DB_HOST,
            'DB_DATABASE' => $DB_DATABASE,
            'DB_USERNAME' => $DB_USERNAME,
            'DB_PASSWORD' => $DB_PASSWORD,            
            'LOG_PATH' => $LOG_PATH,
            'OUTPUT_PATH' => $OUTPUT_PATH,
            'Last_Date' => $Last_Date,
            'CHANNEL' => $CHANNEL,
            'CH_TITLE' => $CH_TITLE,
            'USER' => $USER,
            'PASSWORD' => base64_encode($PASSWORD)
        ]); 

    }
  

    $envs= $env->get();  

   
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>首页 - 汕头市广播电视台</title>

    <!-- Styles -->
    <link href="./public/css/app.css" rel="stylesheet">
</head>

<body>
    <div id="app" class="root-page">

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="#">
                        XBLog
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        
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
        </nav>
        

        <div class="container">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">配置信息</h3>
              </div>
              <div class="panel-body">
                <form class="form-horizontal" method="post" >
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
                                数据库名
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
                            <label for="DB_PASSWORD" class="col-md-2 control-label">
                                数据库密码
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="DB_PASSWORD" value="<?php echo trim($envs['DB_PASSWORD']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="LOG_PATH" class="col-md-2 control-label">
                                播出日志文件路径
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="LOG_PATH" value="<?php echo trim($envs['LOG_PATH']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="OUTPUT_PATH" class="col-md-2 control-label">
                               生成目标文件路径
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="OUTPUT_PATH" value="<?php echo trim($envs['OUTPUT_PATH']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Last_Date" class="col-md-2 control-label">
                                最近导入日期
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
                                频道名称
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="CH_TITLE" value="<?php echo trim($envs['CH_TITLE']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="USER" class="col-md-2 control-label">
                                用户名
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="USER" value="<?php echo trim($envs['USER']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PASSWORD" class="col-md-2 control-label">
                                密码
                            </label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="PASSWORD" value="<?php echo base64_decode(trim($envs['PASSWORD'])) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <button type="submit" class="btn btn-primary" value="submit">保存</button>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#load-log" >立刻执行</button>
                                <button class="btn btn-warning" type="reset" value="reset">取消</button>
                            </div>
                        </div>
                    </div>    
                </form>    
              </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">
                    北京中科大洋科技发展股份有限公司插播系统&nbsp;播后数据生成平台  
                </p>

                <p class="pull-right"><a href="mailto:name@email.com">联系我们</a></p>
            </div>
        </footer> 
    </div>


    <div class="modal fade" id="load-log">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="./webload.php" class="form-horizontal">                   

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title"立刻执行</h4>
                    </div>
                    <div class="modal-body">                        
                        <p class="lead">
                            <i class="fa fa-question-circle fa-lg"></i>
                            是否立刻执行生成播后文件？
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            取消
                        </button>
                        <button type="submit" class="btn btn-primary">
                            确认
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="./public/js/app.js"></script>
    <script>
        (function() {
            $('#load-log').on('show.bs.modal', function (event) {
                
            });           
        }
    </script>
</body>
</html>