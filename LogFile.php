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
				
				$cue_line=$line;
				$play_line='';								
				
				while(!feof($file)) {
					$line= fgets($file);
					if (!trim($line)) continue;
					
					if (strpos(trim($line),'VS.Cue')) {
						$cue_line=$line;
						continue;
					}

					if (strpos(trim($line),'VS.Play')===false) {						
						continue;
					} else {
						$play_line=$line;
						break;
					}
				}
				
				if ($cue_line && $play_line) {
					$row=$this->cue_decode($cue_line);
					$start_time=$this->play_decode($play_line);
					$row->put('b_time', $start_time);
					$logs->push($row);				
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
		$clipFile->put('clipFile', substr($temp[1],7));
		$clipFile->put('len', $temp[3]);
		return $clipFile;
    }
    
    public function play_decode($line) {    	
    	return substr($line, 28, 12);		
    }
}