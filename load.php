<?php

	require __DIR__.'/bootstrap/autoload.php';
	require __DIR__.'./SqlsrvDao.php';
	require __DIR__.'./LogFile.php';
	require __DIR__.'./s_time.php';
	
	use Carbon\Carbon;
	use ZenEnv\ZenEnv;

	header("Content-type: text/html; charset=utf-8"); 
	
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
		$clipFiles = LogFile::getInstance()->toArray($filename);

		//从数据库中获取合同的信息	
		$contracts=collect($dao->getADInfoByClipFiles($clipFiles));

		$filename=getenv('OUTPUT_PATH').$nextDate->format('Ymd').$ch.'.txt';
		$str='';
		
		$contracts->each(function ($contract) use (&$str, $nextDate, $ch_title, $s_time) {
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
					$s=$key;
					break;
				}
			}

			$line=$nextDate->format('Ymd').substr($contract['b_time'],0,8).$slen.str_pad($ch_title, 16, " ").str_pad($s, 16, " ").$contract['strdescription']."\r\n";
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

	echo 'success';
