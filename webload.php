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
	// $dotenv->overload();

	$env = new ZenEnv(__DIR__.'./.env');	
		
	// try {		
   
 //        $db_host = getenv('DB_HOST');   
	// 	$db_name = getenv('DB_DATABASE');
	// 	$db_url = "sqlsrv:Server=".$db_host.";Database=".$db_name;   

 //        $db_user = getenv('DB_USERNAME');         
 //        $db_password = getenv('DB_PASSWORD');   

 //        $db = new PDO($db_url, $db_user, $db_password); 
	// } catch (PDOException $e) {
	// 	echo "Failed to get DB handle: " . $e->getMessage() . "\n";
	// 	exit;
	// }

	// $dao = new SqlsrvDao($db);
	
	$lastDate = getenv('Last_Date');
	$ch = getenv('CHANNEL');

	$ch_title = getenv('CH_TITLE');
	$init_dt = '';
	
	// $s_time=$s_time[$ch];	
	
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
		$contracts = LogFile::getInstance()->toArray(iconv('UTF-8','GB2312',$filename));	

		// dd($contracts);
		//从数据库中获取合同的信息	
		// $contracts=collect($dao->getADInfoByItemIDs($strItemIDs));		

		$filename=getenv('OUTPUT_PATH').$nextDate->format('Ymd').$ch.'.txt';
		$str='';
		
		$contracts->each(function ($contract) use (&$str, $nextDate, $ch_title) {
			//计算播出时间
			if ($contract['desc'] && $contract['b_time']) {
				$bs=(int)floor((intval(substr($contract['b_time'],-3))+200)/1000);
			
				$bn=(intval(substr($contract['b_time'],-3))+200)%1000;
				$bns=substr(str_pad($bn,3,'0',STR_PAD_LEFT),0,2);
				
				$snd=$nextDate->format('Y-m-d').substr($contract['b_time'],0,8);
				//dd($snd);
				$nd=Carbon::createFromFormat('Y-m-d H:i:s', $snd)->addSeconds($bs);

				//计算广告长度
				$slen='';

				if (!$contract['e_time']) {
					$len = intval($contract['len']);
					$ilen = (int)floor($len/25);

					$h=(int)floor($ilen/3600);
					$m=(int)floor(($ilen%3600)/60);
					$s=$ilen-$h*3600-$m*60;		
					$f=(int)($len%25);

					$slen=str_pad($h,2,'0',STR_PAD_LEFT).str_pad($m,2,'0',STR_PAD_LEFT).str_pad($s,2,'0',STR_PAD_LEFT).str_pad($f,2,'0',STR_PAD_LEFT);
				} else {
					$b_times=explode(':', $contract['b_time']);
					$e_times=explode(':', $contract['e_time']);
					$plen=($e_times[0]*3600*1000+$e_times[1]*60*1000+$e_times[2]*1000+$e_times[3])-($b_times[0]*3600*1000+$b_times[1]*60*1000+$b_times[2]*1000+$b_times[3]);
					$ilen = (int)floor($plen/1000);
					$h=(int)floor($ilen/3600);
					$m=(int)floor(($ilen%3600)/60);
					$s=$ilen-$h*3600-$m*60;
					$f=(int)(floor(($plen%1000)/40));

					$slen=str_pad($h,2,'0',STR_PAD_LEFT).str_pad($m,2,'0',STR_PAD_LEFT).str_pad($s,2,'0',STR_PAD_LEFT).str_pad($f,2,'0',STR_PAD_LEFT);
				}


				//根据播出时间，计算得出时间段
				// $temp=explode(':',substr($contract['b_time'],0,8));
				
				// $s='';			
				
				// foreach ($s_time as $key=>$val) {					
				// 	if ((($contract['b_time'])>=$val[0]) && (($contract['b_time'])<$val[1])) {
				// 		if (($temp[1]>=0) && ($temp[1]<15)) {
				// 			$ps= $temp[0].'00';
				// 		} else if (($temp[1]>=15) && ($temp[1]<30)) {
				// 			$ps= $temp[0].'15';
				// 		} else if (($temp[1]>=30) && ($temp[1]<45)) {
				// 			$ps= $temp[0].'30';
				// 		} else if (($temp[1]>=45) && ($temp[1]<60)) {
				// 			$ps= $temp[0].'45';
				// 		} 						
				// 		$s=$ps.$key;						
				// 		break;
				// 	}
				// }

				// $line=$nd->format('YmdHis').$bns.$slen.str_pad($ch_title, 16, " ").str_pad($s, 20, " ").$contract['desc']."\r\n";
				//dd($contract['desc']);
				$htdata=$nd->format('YmdHis').$bns.$slen;
				$line=iconv('utf-8', 'gb2312',$htdata).str_pad(iconv('utf-8', 'gb2312',$ch_title), 16, " ").str_pad(iconv('utf-8', 'gb2312', $contract['s_time']), 16, " ").iconv('utf-8', 'gb2312', $contract['desc'])."\r\n";
				$str=$str.$line;				
			}
		});
			
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



