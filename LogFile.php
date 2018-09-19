<?php
use tightenco\collect;
//单例
class LogFile{
    //创建静态私有的变量保存该类对象
    static private $instance;
    
    //防止直接创建对象
    private function __construct() {
        
    }
        //防止克隆对象
    private function __clone() {

    }

    static public function getInstance() {
        //判断$instance是否是Uni的对象
        //没有则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;        
    }

    public function toArray($filename) {

		$logs=collect([]);
		
		if (file_exists($filename)) {
			
			$file = fopen($filename, "r");
			
			while(!feof($file)) {
				
				$line= fgets($file);
				if (!trim($line)) continue;
				if (strpos(trim($line),'VS.Cue')===false) continue;						 
				
				$cue_line = $line;
				$play_line = '';								
				$stop_line = '';

				while(!feof($file)) {
					$line= fgets($file);
					if (!trim($line)) continue;
					
					if (strpos(trim($line),'VS.Cue')) {
						//处理
						if (($cue_line) && ($play_line)) {
							$row=$this->cue_decode($cue_line);
							$start_time = $this->time_decode($play_line);
							$stop_time = $this->time_decode($stop_line);
							$row->put('b_time', $start_time);
							$row->put('e_time', $stop_time);
							$logs->push($row);
						}
						$cue_line = '';
						$play_line = '';
						$stop_line = '';
						$cue_line=$line;						
					}

					if (strpos(trim($line),'VS.Play')) {
						$play_line=$line;						
					}

					if (strpos(trim($line),'VS.Stop')) {
						$stop_line=$line;						
					}

					continue;
					
				}
				
				
			}
			
			fclose($file);
									
		}
		return $logs;
    }

    public function getLastDate($filename) {
    	$fp = file($filename);
		return $fp[count($fp)-1];
    }

    public function cue_decode($line) {
		$temp=explode(',', substr($line, 42, -4));
		$clipFile=collect([]);
		$clipFile->put('desc', iconv('GB2312','UTF-8',substr($temp[5],6)));
		$clipFile->put('s_time', iconv('GB2312','UTF-8',substr($temp[7],10)));
		$clipFile->put('len', $temp[3]);
		return $clipFile;
    }
        
    public function time_decode($line) {  
    	if (trim($line)) {
	    	$temp=explode(' ', $line);
	    	return $temp[1];
    	}
    	return false;
    }
}