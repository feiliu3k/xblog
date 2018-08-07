﻿<?php

	session_start();

    if ((!isset($_SESSION['userinfo']))){
        header('Location: index.php');
    }

	require __DIR__.'/bootstrap/autoload.php';
	require __DIR__.'./SqlsrvDao.php';
	require __DIR__.'./LogFile.php';
	require __DIR__.'./s_time.php';
	
	use Carbon\Carbon;
	use ZenEnv\ZenEnv;
	
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();
	//$dotenv->overload();

	$env = new ZenEnv(__DIR__.'./.env');	
		
	try {		
   
        $db_host = getenv('DB_HOST');   
		$db_name = getenv('DB_DATABASE');
		$db_url = "sqlsrv:Server=".$db_host.";Database=".$db_name;   

        $db_user = getenv('DB_USERNAME');         
        $db_password = getenv('DB_PASSWORD');   

        $db = new PDO($db_url, $db_user, $db_password); 
	} catch (PDOException $e) {
		echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		exit;
	}

	$dao = new SqlsrvDao($db);
	
	$lastDate = getenv('Last_Date');
	$ch = getenv('CHANNEL');

	$ch_title = getenv('CH_TITLE');
	$init_dt = '';
	
	$s_time=$s_time[$ch];	
	
	if (!$lastDate) {
		$init_dt='2018-05-01 00:00:00';
	}else
	{
		$init_dt=$lastDate.' 00:00:00';
	}

	$nextDate =  Carbon::createFromFormat('Y-m-d H:i:s', $init_dt)->addDay();
	$toDay= Carbon::now()->toDateString();

	while ($nextDate<$toDay) {		
		$filename = getenv('LOG_PATH').'XBlog['.$ch.'--主机]'.$nextDate->format('Ymd').'.txt';
		
		//返回插播的素材，播出时间，素材长度列表
		$clipFiles = LogFile::getInstance()->toArray(iconv('UTF-8','GB2312',$filename));

		
		//从数据库中获取合同的信息	
		$contracts=collect($dao->getADInfoByClipFiles($clipFiles));

		$filename=getenv('OUTPUT_PATH').$nextDate->format('Ymd').$ch.'.txt';
		$str='';
		
		$contracts->each(function ($contract) use (&$str, $nextDate, $ch_title, $s_time) {
			//计算播出时间
			$bs=(int)floor((intval(substr($contract['b_time'],-3))+200)/1000);
		
			$bn=(intval(substr($contract['b_time'],-3))+200)%1000;
			$bns=substr(str_pad($bn,3,'0',STR_PAD_LEFT),0,2);
			
			$snd=$nextDate->format('Y-m-d').substr($contract['b_time'],0,8);

			$nd=Carbon::createFromFormat('Y-m-d H:i:s', $snd)->addSeconds($bs);



			//计算广告长度
			$len = intval($contract['len']);
			$ilen = (int)floor($len/25);

			$h=(int)floor($ilen/3600);
			$m=(int)floor(($ilen%3600)/60);
			$s=$ilen-$h*3600-$m*60;		
			$f=(int)($len%25);

			$slen=str_pad($h,2,'0',STR_PAD_LEFT).str_pad($m,2,'0',STR_PAD_LEFT).str_pad($s,2,'0',STR_PAD_LEFT).str_pad($f,2,'0',STR_PAD_LEFT);
			
			//根据播出时间，计算得出时间段
			$temp=substr($contract['b_time'],0,6);
			$s='';			
			foreach ($s_time as $key=>$val) {
				if (($temp>=$val[0]) && ($temp>=$val[1])) {
					$psi=(int)substr($temp,2,2);
					if (($psi>=0) && ($psi<15)) {
						$ps= substr($temp,0,2).'00';
					} else if (($psi>=15) && ($psi<30)) {
						$ps= substr($temp,0,2).'15';
					} else if (($psi>=30) && ($psi<45)) {
						$ps= substr($temp,0,2).'30';
					} else if (($psi>=45) && ($psi<60)) {
						$ps= substr($temp,0,2).'45';
					} 
					$s=$ps.$key;
					break;
				}
			}

			$line=$nd->format('YmdHis').$bns.$slen.str_pad($ch_title, 16, " ").str_pad($s, 20, " ").$contract['strdescription']."\r\n";
			$str=$str.$line;
		});
		//dd($contracts);
		if ($str) {
			file_put_contents($filename, $str, LOCK_EX);	
			$env->set([
				'Last_Date'=>$nextDate->format('Y-m-d')
			]);		
		}
		
		//fclose($file);
		$nextDate = $nextDate->addDay();
    }
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

        	<div class="jumbotron">
			    <h3>XBlog</h3>
			    <p class="lead">
			      播后数据执行成功。
			    </p>			   
			    <p>
			      <a class="btn btn-lg btn-success" href="./main.php" role="button">返回</a>
			    </p>
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



