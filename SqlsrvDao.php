<?php

class SqlsrvDao{

    protected $dbh = NULL; 

    public function __construct($dbh) {
       $this->dbh=$dbh;      
    }

    public function getADInfoBygetADInfoByItemID($strItemID)
    {        
        $sql='select top 1 STRITEMID, STRDESCRIPTION, LDURATION, STRSCEDULEPLAYTIME, STRPARENTITEMID, STRCHID from TMP_PLAYINGLIST where STRITEMID=?';     
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $strItemID, PDO::PARAM_STR);
        $stmt->execute();       
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;             
    }

    public function getADInfoByItemIDs($strItemIDs)
    {        
        try { 
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//异常模式  
            $this->dbh->beginTransaction();//开启事物  
            $sql = "select top 1 STRITEMID, STRDESCRIPTION, LDURATION, STRSCEDULEPLAYTIME, STRPARENTITEMID, STRCHID from TMP_PLAYINGLIST where STRITEMID=?";

            // $clipFiles->map(function($item, $key) use ($sql) {
            //     $stmt = $this->dbh->prepare($sql);
            //     $stmt->bindValue(1, $item->clipFile, PDO::PARAM_STR);
            //     $stmt->execute();       
            //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //     $item->put('strdescription', $result['strdescription']);
            //     return $item;     
            // }

            foreach ($strItemIDs as $strItemID) {                               
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindValue(1, $strItemID['strItemID'], PDO::PARAM_STR);
                $stmt->execute();       
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                //$clipFile=array_merge($clipFile, $result) ;
                $strItemID->put('strdescription', $result['STRDESCRIPTION']);
                $strItemID->put('lduration', $result['LDURATION']);  
            }

            $this->dbh->commit();//执行事物的提交操作*/  
            return $strItemIDs;
        }catch (PDOException $e){  
            die("Error!: ".$e->getMessage().'<br>');  
            $this->dbh->rollBack();//执行事物的回滚操作  
        }  
        return false;            
    }
}