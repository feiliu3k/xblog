<?php

class SqlsrvDao{

    protected $dbh = NULL; 

    public function __construct($dbh) {
       $this->dbh=$dbh;      
    }

    public function getLastDate($mark)
    {        
        $sql='select top 1 * from bcwj where mark=? order by filename desc';     
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $mark, PDO::PARAM_INT);
        $stmt->execute();       
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;             
    }

    public function exist($filename, $mark)
    {        
        $sql='select top 1 * from bcwj where filename=? and mark=? order by filename desc';     
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $filename, PDO::PARAM_STR);
        $stmt->bindValue(2, $mark, PDO::PARAM_INT);
        $stmt->execute();       
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !!$result;             
    }

    public function insertLogwj($filename, $mark)
    {     
        
        $sql = "insert into bcwj(filename,mark) values('";
        $sql .= $filename."',";
        $sql .= "'".$mark."'";       
        $sql .= ")";                
        
        return $this->dbh->exec($sql);
    }

    public function insertLog($logs) 
    {
       try { 
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//异常模式  
            $this->dbh->beginTransaction();//开启事物  
            $sql = "insert into sjbc(d_date,b_time,len,fre,s_time,number,g_num,content,belt,cx,rev_cx) values('";

            foreach ($logs as $log) {                
                $strSql = $sql.$log['d_date']."',";
                $strSql .= "'".$log['b_time']."',";
                $strSql .= "'".$log['len']."',";
                $strSql .= "'".$log['fre']."',";
                $strSql .= "'".$log['s_time']."',";
                $strSql .= "'".$log['number']."',";
                $strSql .= "'".$log['g_num']."',";
                $strSql .= "'".$log['content']."',";
                $strSql .= "'".$log['belt']."',";
                $strSql .= $log['cx'].",";
                $strSql .= $log['rev_cx'];
                $strSql .= ")";                
                $this->dbh->exec($strSql);
            }

            $this->dbh->commit();//执行事物的提交操作*/  
            return true;
        }catch (PDOException $e){  
            die("Error!: ".$e->getMessage().'<br>');  
            $this->dbh->rollBack();//执行事物的回滚操作  
        }  
        return false;
    }
}