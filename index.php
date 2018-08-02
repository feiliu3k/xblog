<?php

	require __DIR__.'/bootstrap/autoload.php';
	require __DIR__.'./SqlsrvDao.php';
	require __DIR__.'./LogFile.php';
	require __DIR__.'./s_time.php';
	
	use Carbon\Carbon;

	header("Content-type: text/html; charset=utf-8"); 
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();

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
	
	if (!$lastDate) {
		$init_dt='2018-05-01 00:00:00';
	}else
	{
		$init_dt=$lastDate.' 00:00:00';
	}

	$nextDate =  Carbon::createFromFormat('Y-m-d H:i:s', $init_dt)->addDay();
	$toDay= Carbon::now()->toDateString();

	// echo $nextDate;
	// exit;
	// dd($nextDate->format('Y-m-d'));
	// dd($dao->exist($nextDate->format('Y-m-d'), '01'))
	// exit;
	
	while ($nextDate<$toDay) {		
		$filename = getenv('LOG_PATH').'XBlog['.$ch.'--主机]'.$nextDate->format('Ymd').'.txt';
		//返回插播的素材，播出时间，结束时间
		$bc_log = LogFile::getInstance()->toArray($filename);		
		//从数据库中获取合同的信息		
		$clipFile=$bc_log->first()['clipFile'];
		//生成文件；
		//$file=fopen(getenv('OUTPUT_PATH')."welcome.txt","w");
		$contract=$dao->getADInfoByClipFile($clipFile);

		$str = var_export($contract,TRUE);
		//dd($str);
		file_put_contents(getenv('OUTPUT_PATH')."welcome.txt", $str, FILE_APPEND | LOCK_EX);
		//fclose($file);
		$nextDate = $nextDate->addDay();
    }

	echo 'success';
