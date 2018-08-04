<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>登陆 - 汕头市广播电视台</title>

    <!-- Styles -->
    <link href="./public/css/app.css" rel="stylesheet">
</head>

<body>
    <div id="app" class="login-page">
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
                        <li><a href="./login.php">登录</a></li>
                     </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">登录</div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="./src/validateUser.php">
                                    
                                    <div class="form-group">
                                        <label for="username" class="col-md-4 control-label">用户名</label>

                                        <div class="col-md-6">
                                            <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-4 control-label">密码</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>

                                    

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                登录
                                            </button>                                          
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">
                    由 XMAN 设计和编码
                </p>

                <p class="pull-right"><a href="mailto:name@email.com">联系我们</a></p>
            </div>
        </footer>  
    </div>

    <!-- Scripts -->
    <script src="./public/js/app.js"></script>
</body>
</html>