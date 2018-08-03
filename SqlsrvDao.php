<?php

class SqlsrvDao{

    protected $dbh = NULL; 

    public function __construct($dbh) {
       $this->dbh=$dbh;      
    }

    public function getADInfoByClipFile($clipFile)
    {        
        $sql='select top 1 stritemid, strclipfile, strdescription, lduration, strparentitemid from BMI_ADLISTITEM where strclipfile=?';     
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $clipFile, PDO::PARAM_STR);
        $stmt->execute();       
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;             
    }

    public function getADInfoByClipFiles($clipFiles)
    {        
        try { 
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//异常模式  
            $this->dbh->beginTransaction();//开启事物  
            $sql = "select top 1 strdescription, lduration from BMI_ADLISTITEM where strclipfile=?";

            // $clipFiles->map(function($item, $key) use ($sql) {
            //     $stmt = $this->dbh->prepare($sql);
            //     $stmt->bindValue(1, $item->clipFile, PDO::PARAM_STR);
            //     $stmt->execute();       
            //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //     $item->put('strdescription', $result['strdescription']);
            //     return $item;     
            // }

            foreach ($clipFiles as $clipFile) {                               
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindValue(1, $clipFile['clipFile'], PDO::PARAM_STR);
                $stmt->execute();       
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                //$clipFile=array_merge($clipFile, $result) ;
                $clipFile->put('strdescription', $result['strdescription']);
                $clipFile->put('lduration', $result['lduration']);  
            }

            $this->dbh->commit();//执行事物的提交操作*/  
            return $clipFiles;
        }catch (PDOException $e){  
            die("Error!: ".$e->getMessage().'<br>');  
            $this->dbh->rollBack();//执行事物的回滚操作  
        }  
        return false;            
    }
}