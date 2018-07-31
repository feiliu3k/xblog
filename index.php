<?php
	use Carbon\Carbon;

	require __DIR__.'/bootstrap/autoload.php';
	require __DIR__.'./SqlsrvDao.php';
	require __DIR__.'./LogFile.php';

	header("Content-type: text/html; charset=utf-8"); 
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();

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
		$filename = getenv('LOG_PATH').'XBlog[CH05--主机]'.$nextDate->format('Ymd').'.txt';
		//返回插播的素材，播出时间，结束时间
		$bc_log = LogFile::getInstance()->toArray($filename);

		//从数据库中获取合同的信息

		dd($bc_log);
		
		$nextDate = $nextDate->addDay();
    }

	echo 'success';
