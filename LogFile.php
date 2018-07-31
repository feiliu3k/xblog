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

		if (file_exists($filename)) {

			$file = fopen($filename, "r");
			$logs=collect([]);
			
			while(!feof($file)) {
				
				$line= fgets($file);//fgets()函数从文件指针中读取一行
				if (!trim($line)) break;
				if (strpos(trim($line),'VS.Cue')===false) continue;				 
				$row=$this->cue_decode($line);
				
				dd($row);
				
				while(!feof($file)) {
					$line= fgets($file);
					if (!trim($line)) break;
					if (strpos(trim($line),'SWT.SwitchPGM')===false) {						
						continue;
					} else {
						$row->put('strSwitchPGM', $line);
						break;
					}
				}
				$logs->push($row);				
			}
			
			fclose($file);
									
			return $logs;
		}

		return false;
    }

    public function getLastDate($filename) {
    	$fp = file($filename);
		return $fp[count($fp)-1];
    }

    public function cue_decode($line) {
    	$row=collect([]);
		$infos = explode(' ', $line);
		// dd($infos);
		$row->put('b_time', str_replace(':', '', $infos[1]));
		$clipFile = substr(explode('VS.Cue', $infos[2])[1],1,-1);
		$row->put('len', substr($infos[4], 0, -1));		
		$row->put('clip_file', $clipFile);
		return $row;
    }
    
}