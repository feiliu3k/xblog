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
}